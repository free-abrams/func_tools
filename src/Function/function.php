<?php

use App\Models\Config;
use Illuminate\Support\Facades\DB;

/**
 * 获取配置
 * @return string
 */
function get_config($name)
{
    return Config::where('name', $name)->value('value');
}

/**
 * 获取当前host域名
 * @return string
 */
function get_host()
{
    $scheme = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $url = $scheme . $_SERVER['HTTP_HOST'];
    return $url;
}

/**
 *  随机生成代码
 * @param array $data 返回数据
 */
function get_string($length, $type = 1)
{
    switch ($type) {
        case 1:
            $chars = '0123456789';
            break;
        case 2:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            break;
        case 3:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqistuvwxyz0123456789';
            break;
        case 4:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqistuvwxyz0123456789+-=[]{}|\/<> !@#$%^&*:?.,';
            break;
    }
    $return = '';
    for ($i = 0; $i < $length; $i++) {
        $return .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $return;
}

/**
 * [unique_arr 去除二维数组重复值]
 * @return [type] [返回值是二维数组]
 */
function unique_arr($array2D, $stkeep = false, $ndformat = true)
{

    // 判断是否保留一级数组键 (一级数组键可以为非数字)
    if ($stkeep) $stArr = array_keys($array2D);    //返回数据的下标

    // 判断是否保留二级数组键 (所有二级数组键必须相同)
    if ($ndformat) $ndArr = array_keys(end($array2D));    //返回二维数组的最后一个下标

    //降维,也可以用implode,将一维数组转换为用逗号连接的字符串,结果是索引一维数组
    foreach ($array2D as &$v) {
        if (isset($v['pivot'])) {
            unset($v['pivot']);
        }
        $v = implode(",", $v);
        $temp[] = $v;
    }

    //去掉重复的字符串,也就是重复的一维数组
    $temp = array_unique($temp);

    //再将拆开的数组重新组装
    foreach ($temp as $k => $v) {
        if ($stkeep) $k = $stArr[$k];
        if ($ndformat) {
            $tempArr = explode(",", $v);
            foreach ($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
        } else $output[$k] = explode(",", $v);
    }

    return $output;
}


/**
 *  获取用户支付宝userid
 * @param array $data 返回数据
 */
function GetUserid($id)
{
    $userid = Db::table('member')->where('id', $id)->value('userid');
    return $userid;
}

/**
 *  获取用户详情
 * @param array $data 返回数据
 */
function GetUserinfo($id)
{
    $userid = Db::table('member')->where('id', $id)->first();
    return $userid;
}

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
function showMsg($status, $message = '', $data = array())
{
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
    exit(json_encode($result));
}

/**
 *  curl get的形式访问。
 * @param array $data 返回数据
 */
function httpGet($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

/**
 *  curl post的形式访问。
 * @param array $data 返回数据
 */
function httpPost($url, $array)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 500);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function httpPostJson($url, $data_string)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)

    ));
    $res = curl_exec($ch);

    if (curl_errno($ch)) {

    }
    curl_close($ch);
    return $res;
}
/**
 *  第三方短信接口
 * @param array $data 返回数据
 */
function sendMsg($mobile, $code)
{
    $url = 'http://120.78.138.165:9008';//系统接口地址
    $msg = "【群智网络】验证码：" . $code . "，请在10分钟内使用，过时失效。";
    $content = urlencode(iconv('utf-8', 'GBK', $msg));
    $url = $url . "/servlet/UserServiceAPI?method=sendSMS&extenno=&isLongSms=0&username=veth&password=" . base64_encode(123456) . "&smstype=0&mobile=" . $mobile . "&content=" . $content;
    return file_get_contents($url);
}

/**
 * 判断是否为合法的身份证号码
 * @param $mobile
 * @return int
 */
function isCreditNo($vStr)
{
    $vCity = array(
        '11', '12', '13', '14', '15', '21', '22',
        '23', '31', '32', '33', '34', '35', '36',
        '37', '41', '42', '43', '44', '45', '46',
        '50', '51', '52', '53', '54', '61', '62',
        '63', '64', '65', '71', '81', '82', '91'
    );
    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
    if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);
    if ($vLength == 18) {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18) {
        $vSum = 0;
        for ($i = 17; $i >= 0; $i--) {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
        }
        if ($vSum % 11 != 1) return false;
    }
    return true;
}

/**
 * @return mixed
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 给浏览器静态资源加版本号,强制刷新缓存
 * @param string $source 资源路径
 * @return string         资源路径加上版本号
 */
function loadEdition($source)
{
    $version = '1.00';

    return $source . '?v=' . $version;
}

/**
 * 返回错误信息页面提示
 * @param null $message
 * @param null $url
 * @param null $view
 * @param string $type
 * @param int $wait
 * @return \Illuminate\Http\Response
 */
function viewError($message = null, $url = null, $type = 'error', $view = null, $wait = 3)
{
    $view = $view ? $view : 'admin.commons.' . $type;

    return response()->view($view, [
        'url' => $url ? route($url) : '/',
        'message' => $message ? $message : '发生错误,请重试!',
        'wait' => $wait,
    ]);
}


/**
 * [对象转换数组]
 * 过滤无关字段，空值
 * @return [type] [返回值是一维数组]
 */
function get_integral_pay($data, $day)
{
    $update = array();
//    $integral = ['3','7','30','90','180','365'];
    $integral = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'];
    foreach ($integral as $k1 => $v1) {
        if ($v1 >= $day) {
            if ($v1 == '1') {
                $str[] = 'integral_pay' . $v1;
            } else {
                $str[] = 'integral_pay' . $v1;
            }
        }
    }
    foreach ($data as $k => $array) {
        foreach ($str as $key => $value) {
            $update[] = $array->$value;
        }
    }
    return $update;
}

/**
 * [对象转换数组]
 * 起租价格
 * @return [type] [返回值是一维数组]
 */
function get_integral_price($array)
{
    $integral = ['1', '7', '30', '90', '180', '365'];
    $update = array();
    foreach ($integral as $key => $value) {
        if ($value > $array->integralMinday) {
            $update[] = $value;
        }
    }
    $update[] = $array->integralMinday;
    return $update;
}


function get_integral_day($data)
{
    if ($data >= 12) {
        return $data / 12 * 365 + $data % 12 * 30;
    }
    return $data * 30;
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 */
function time_format($time = NULL, $format = 'Y-m-d H:i')
{
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 随机生成订单号
 * @return [type] [返回值是一维数组]
 */
function get_number_chang($model, $key, $length = 6,$prefix = '',$time = true)
{
    $string = get_string($length);
    if($time){
        $orderid = $prefix.time_format(time(), 'Ymd') . $string;
    }else{
        $orderid = $prefix.$string;
    }
    $where[] = [$key, '=', $orderid];
    $thunk = Db::table($model)->where($where)->value($key);
    if ($thunk) {
        return get_number_chang($model, $key, $length, $prefix);
    } else {
        return $orderid;
    }
}

function get_order_id($model)
{
    //$thunk = Db::table($model)->where($where)->value($key);
    $thunk = DB::table('orders')->orderByDesc('id')->first('id');

    return $thunk->id;
}

/*快递鸟接口*/
/**
 * Json方式 查询订单物流轨迹
 */
function getOrderTracesByJson($LogisticCode, $ShipperCode)
{
    $requestData = "{'OrderCode':'','ShipperCode':'" . $ShipperCode . "','LogisticCode':'" . $LogisticCode . "'}";
    $ReqURL = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
    $EBusinessID = '1463603';
    $Appkey = '802251d9-a328-4d38-bb02-177aaea37c50';
    $datas = array(
        'EBusinessID' => $EBusinessID,
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData),
        'DataType' => '2',
    );
    $datas['DataSign'] = Cencrypt($requestData, $Appkey);
    $result = sendPost($ReqURL, $datas);
    return $result;
}

/**
 * Json方式 面单
 */
function submitEOrder($config, $requestData)
{
    $datas = array(
        'EBusinessID' => $config['EBusinessID'],
        'RequestType' => '1007',
        'RequestData' => urlencode($requestData),
        'DataType' => '2',
    );
    $datas['DataSign'] = Cencrypt($requestData, $config['AppKey']);
    $result = sendPost($config['ReqURL_Add'], $datas);
    return $result;
}

/**
 *  post提交数据
 * @param string $url 请求Url
 * @param array $datas 提交的数据
 * @return url响应返回的html
 */
function sendPost($url, $datas)
{
    $temps = array();
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);
    }
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
    if (empty($url_info['port'])) {
        $url_info['port'] = 80;
    }
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader .= "Host:" . $url_info['host'] . "\r\n";
    $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader .= "Connection:close\r\n\r\n";
    $httpheader .= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
    $headerFlag = true;
    while (!feof($fd)) {
        if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
            break;
        }
    }
    while (!feof($fd)) {
        $gets .= fread($fd, 128);
    }
    fclose($fd);

    return $gets;
}

/**
 * 电商Sign签名生成
 * @param data 内容
 * @param appkey Appkey
 * @return DataSign签名
 */
function Cencrypt($data, $appkey)
{
    return urlencode(base64_encode(md5($data . $appkey)));
}


/**
 * 判断二维码是否存在
 * @return 图片
 */
function getCodePng($info = array())
{
    if (empty($info)) {
        $img_path = 'qrcode' . get_string(3, 2) . '.png';
        if (!file_exists(public_path("img/$img_path"))) {
            return $img_path;
        } else {
            getCodePng();
        }
    }
}

/**
 * UTF-8编码转GBK编码
 * @return string
 */
function reCode($string)
{
    if (mb_detect_encoding($string, array('UTF-8', 'GBK')) == "UTF-8") {
        $Newstring = iconv("UTF-8", "gbk//TRANSLIT", $string);
    } else {
        $Newstring = $string;
    }
    return $Newstring;
}

/**
 * 价格区间筛选
 * @return array
 */
function priceSection($array, $start, $end)
{
    if ($start == 0 && $end == 0) {
        return $array;
    }
    $data = [];
    foreach ($array as $key => $value) {
        if ($value->integral_pay >= $start) {
            if ($end == 0) {
                $data[] = $value;
            } else {
                if ($value->integral_pay <= $end) {
                    $data[] = $value;
                }
            }
        }
    }
    return $data;

}

/**
 * 按价格排序
 * @return string
 */
function priceDesc($array, $desc)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    $temp = $array[0];
    $b = $array;
    if ($desc == 'desc') {
        for ($k = 1; $k < $len; $k++) {
            for ($j = 0; $j < $len - $k; $j++) {
                if ($b[$j]->integral_pay < $b[$j + 1]->integral_pay) {
                    $temp = $b[$j + 1];
                    $b[$j + 1] = $b[$j];
                    $b[$j] = $temp;
                }
            }
        }
    } else {
        for ($k = 1; $k < $len; $k++) {
            for ($j = 0; $j < $len - $k; $j++) {
                if ($b[$j]->integral_pay > $b[$j + 1]->integral_pay) {
                    $temp = $b[$j + 1];
                    $b[$j + 1] = $b[$j];
                    $b[$j] = $temp;
                }
            }
        }
    }
    return $b;

}

/**
 * 数组重组
 * @return string
 */
function reParam($data, $goods)
{
    if (!count($data) || !isset($goods)) {
        return [];
    }
    $array = [];
    $goodsArr = explode(',', $goods);
    foreach ($goodsArr as $key => $value) {
        $array[] = Db::table('goods_format')->where('status', 1)->where('pid', $value)->pluck('title')->toArray();
    }
    foreach ($array as $key => $value) {
        if (empty($value)) {
            unset($array[$key]);
        }
    }
    $return = main($array);
    foreach ($return as $key => $value) {
        foreach ($value as $k1 => $v2) {
            $return[$key]['type' . ($k1 + 1)] = $v2;
            unset($return[$key][$k1]);
        }

        $return[$key]['inventory'] = 0;
        $format = implode('@', $value);
        foreach ($data as $k => $v) {
            if ($format == $v->format1) {
                $return[$key]['inventory'] = $v->inventory;
            }
        }

    }

    return $return;
}


function main($arr)
{
    $max = count($arr);
    if ($max > 1) {
        for ($i = 0; $i <= $max - 2; $i++) {
            $arr[$i + 1] = _inner($arr[$i], $arr[$i + 1]);
        }
        return $arr[$max - 1];
    } else {
        foreach ($arr as $k => $v) {
            for ($i = 1; $i <= count($v); $i++) {
                $rst[][] = $v[$i - 1];
            }
        }
        return $rst;
    }
}

function _inner($arr1, $arr2)
{
    foreach ($arr1 as $k => $v) {
        foreach ($arr2 as $key => $val) {
            if (is_array($v)) {
                $temp = $v;
                array_push($temp, $val);
                $rst[] = $temp;
                unset($temp);
            } else {
                $rst[] = [$v, $val];
            }
        }
    }
    return $rst;
}


/**
 * 合并数组
 * @return string
 */
function inArray($arr1, $arr2)
{
    $return = array();
    if (empty($arr1) || empty($arr2)) {
        empty($arr1) ? $return = $arr2 : $return = $arr1;
    } else {
        $return = array_merge($arr1, $arr2);
    }

    // $re1['inventory'] = $arr3;
    // $return[] = $array;
    // $return[] = $arr3;
    // var_dump($arr3);
    //ksort($return);
    return $return;
}

/**
 * 验证数据格式
 * @return string
 */
function check($array, $key)
{
    $messages = config('message');
    $validator = \Validator::make($array, $key, $messages);

    if ($validator->fails()) {
        $return = ['code' => 600, 'data' => [], 'msg' => $validator->errors()->first()];
        return response()->json($return);
    }
    return false;
}

/**
 * 材料库存最大计算
 * @return string
 */
function minimun_stock(array $stock, array $need)
{
    $minimun = [];
    if (is_array($stock) && is_array($need)) {
        foreach ($stock as $key => $value) {
            $minimun[] = intval($value / $need[$key]);
        }
    }
    if (count($minimun) > 0) {
        return min($minimun);
    }
    return false;
}

/**
 * 库存扣减算法
 * @return string
 */
function deduction_stock(array $stock, int $need)
{
    $minimun = [];
    if (is_array($stock) && is_int($need)) {
        foreach ($stock as $key => $value) {
            $minimun[$key] = $value;
            if ($value['status'] == 1) {
                if ((int)$value['stock'] >= (int)$need) {
                    $minimun[$key]['stock'] = (int)$value['stock'] - (int)$need;
                    $minimun[$key]['sell'] = (int)$value['sell'] + (int)$need;
                    if ((int)$value['stock'] == (int)$need) {
                        $minimun[$key]['status'] = 2;
                    }
                    break;
                } else {
                    $minimun[$key]['stock'] = 0;
                    $minimun[$key]['sell'] = (int)$value['sell'] + (int)$value['stock'];
                    $minimun[$key]['status'] = 2;
                    $need = (int)$need - (int)$value['stock'];
                    continue;
                }
            }
        }
    }
    return $minimun;
}

/*批量修改*/
function updateBatch($multipleData = [], $table, $mode = 1)
{

    try {
        if (empty($multipleData)) {
            throw new Exception("数据不存在");
        }
        $tableName = $table; // 表名
        $firstRow = current($multipleData);
        $updateColumn = array_keys($firstRow);
        // 默认以id为条件更新，如果没有ID则以第一个字段为条件
        $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
        unset($updateColumn[0]);
        // 拼接sql语句
        $updateSql = "UPDATE " . $tableName . " SET ";
        $sets = [];
        $bindings = [];
        foreach ($updateColumn as $uColumn) {
            $setSql = "`" . $uColumn . "` = CASE ";
            foreach ($multipleData as $data) {
                switch ($mode){
                    case 1:
                        $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                        break;
                    case 2:
                        $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN `" . $uColumn . "`+ ? ";
                        break;
                    case 3:
                        $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN `" . $uColumn . "`- ? ";
                        break;
                }
                $bindings[] = $data[$referenceColumn];
                $bindings[] = $data[$uColumn];
            }
            $setSql .= "ELSE `" . $uColumn . "` END ";
            $sets[] = $setSql;
        }
        $updateSql .= implode(', ', $sets);
        $whereIn = collect($multipleData)->pluck($referenceColumn)->values()->all();
        $bindings = array_merge($bindings, $whereIn);
        $whereIn = rtrim(str_repeat('?,', count($whereIn)), ',');
        $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
        // 传入预处理sql语句和对应绑定数据
        return  DB::update($updateSql,$bindings);
    } catch (\Exception $e) {
        return false;
    }
}

function getBirthdayFromIdCard($id_card)
{
	if (is_string($id_card)) {
		return substr($id_card, 5, 8);
	}
}
if (!function_exists('dd')) {
    function dd(...$vars)
    {
        $cloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
        $dumper->setDisplayOptions(['maxDepth'=>5]);
        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::setHandler(
                function ($var) use ($cloner, $dumper) {
                    $dumper->dump($cloner->cloneVar($var));
                }
            );
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        exit(1);
    }
}
if (!function_exists('d')) {
    function d(...$vars)
    {
        $cloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
        $dumper->setDisplayOptions(['maxDepth'=>5]);
        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::setHandler(
                function ($var) use ($cloner, $dumper) {
                    $dumper->dump($cloner->cloneVar($var));
                }
            );
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        exit(1);
    }
}

/**
 * 冒泡排序
 */
if (!function_exists('pop_sort')) {
	function pop_sort($arr = [], $sort = 'desc')
	{
		for ($i = 0; $i < count($arr); $i++) {
			for ($j = 0; $j < count($arr); $j++) {
				if ($arr[$j] < $arr[$j + 1] && $sort == 'desc') {
					$temp = $arr[$j + 1];
					$arr[$j] = $arr[$j + 1];
					$arr[$j + 1] = $temp;
				} else {
					$temp = $arr[$j + 1];
					$arr[$j + 1] = $arr[$j];
					$arr[$j] = $temp;
				}
			}
		}
	}
}

if (!function_exists('fast_sort')) {
	function fast_sort($arr)
	{
		inner_fast_sort($arr, 0, count($arr) -1);
		return $arr;
	}
}


if (!function_exists('inner_fast_sort')) {
	function inner_fast_sort(&$arr, $start, $end)
	{
		if ($start >= $end) {
			return $arr;
		} else {
			$partition = partition($arr, $start, $end);
			echo $partition.PHP_EOL;
			inner_fast_sort($arr, 0, $partition - 1);
			inner_fast_sort($arr, $partition + 1, $end);
		}
	}
}

if (!function_exists('partition')) {
	function partition(&$arr, $start, $end)
	{
		$pivot = $arr[$start];
		$i = $start; $j = $end;
		while ($i < $j) {
			while ($i < $j && $arr[$j] >= $pivot )$j--;
			$arr[$i] = $arr[$j];
			while ($i < $j && $arr[$i] <= $pivot )$i++;
			$arr[$j] = $arr[$i];
		}
		
		$arr[$i] = $pivot;
		return $i;
	}
}

/**

    * 将字符串转换成二进制

    * @param type $str

    * @return type

    */
if (!function_exists('StrToBin')) {
    function StrToBin($str){

        //1.列出每个字符

        $arr = preg_split('/(?<!^)(?!$)/u', $str);

        //2.unpack字符

        foreach($arr as &$v){

            $temp = unpack('H*', $v);

            $v = base_convert($temp[1], 16, 2);

            unset($temp);

        }

        return join(' ',$arr);

    }
}



    /**

    * 将二进制转换成字符串

    * @param type $str

    * @return type

    */
if (!function_exists('BinToStr')) {
    function BinToStr($str){

        $arr = explode(' ', $str);

        foreach($arr as &$v){

            $v = pack("H".strlen(base_convert($v, 2, 16)), base_convert($v, 2, 16));

        }

        return join('', $arr);

    }
}

