<?php


namespace FreeAbrams\FuncTools\Handlers;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
// 秒杀类
use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * Created By FreeAbrams
 * Date: 2022/6/22
 */
class KillService
{
	public function redisLockInit($goods_id, $value)
	{
		$key = 'redis_goods_lock_id_'.$goods_id;
		$user_to_goods_key = 'user_to_goods_id_'.$goods_id;
		Redis::command('del', [$key, 'success', $user_to_goods_key]);
		return Redis::set($key, $value);
	}
	
	public function redisLock($user_id, $goods_id, $stock)
	{
		$key = 'redis_goods_lock_id_'.$goods_id;
        //监听对应的key,事务提交之前，如果key被修改，则事务被打断
        Redis::watch($key);
		$lock = Redis::get($key);
		if ($lock) {
			$sortKey = 'user_to_goods_id_'.$goods_id;
			$member = Redis::sismember($sortKey, $user_id);
			if ($member) {
				return 1;
			}
			
			$res = Redis::transaction(function($redis) use($key, $stock, $user_id, $sortKey){
				$redis->decrby($key, $stock);
				$redis->sadd($sortKey, $user_id);
			});
			if ($res) {
				$lvalue = [];
				for ($i = 0; $i < $stock; $i++) {
					$lvalue[] = '用户: '.$user_id.' 抢到商品: '.$goods_id.' 第 '.$lock--.' 个';
				}
				Redis::lpush('success', $lvalue);
				$res = Goods::query()->where('id', $goods_id)->decrement('stock', $stock, ['sell' => DB::raw('`sell`+'.(int)$stock)]);
				if (!$res) {
					Redis::incrby($key, $stock);
					Redis::srem($sortKey, $user_id);
				}
				return true;
			} else {
				return false;
			}
			
		} else {
			return 0;
		}
	}
	
	public function redisQueueInit($goods_id, $stock)
	{
		$goods_key = 'kill_goods_id_'.$goods_id;
		$user_to_goods_key = 'user_to_goods_id_'.$goods_id;
		if (Redis::llen($goods_key) == $stock) {
			return false;
		}
		Redis::command('del', [$goods_key, $user_to_goods_key, 'success']);
		
		for ($i = 1; $i <= $stock; $i++) {
			Redis::lpush($goods_key, $i);
		}
		
		return Redis::llen($goods_key);
	}
	
	public function redisQueue($user_id, $goods_id, $stock)
	{
		$goods_key = 'kill_goods_id_'.$goods_id;
		$user_to_goods_key = 'user_to_goods_id_'.$goods_id;
		
		if (Redis::sismember($user_to_goods_key, $user_id)) {
			return false;
		}
		
		$count = Redis::lpop($goods_key);
		if (!$count) {
			return false;
		}
		
		Redis::sadd($user_to_goods_key, $user_id);
		$lvalue = '用户: '.$user_id.' 抢到商品: '.$goods_id.' 第 '.$count.' 个';
		Redis::lpush('success', $lvalue);
		
		$res = Goods::query()->where('id', $goods_id)->decrement('stock', $stock, ['sell' => DB::raw('`sell`+'.(int)$stock)]);
		if (!$res) {
			Redis::lpush($goods_key, $count);
			Redis::srem($user_to_goods_key, $user_id);
		}
		
		return true;
	}
}