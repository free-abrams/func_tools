<?php


namespace FreeAbrams\FuncTools\Handlers;

/**
 * Created By FreeAbrams
 * Date: 2022/7/18
 */
class SignIn
{
	private $conBomDay;
	private $conBomSec;
	public function __construct(int $conBomDay = 0)
	{
		if ($conBomDay < 0) {
			throw new \Exception('value must great than zero');
		}
		$this->conBomDay = $conBomDay;
		$this->conBomSec = $conBomDay * 24 * 3600;
	}
	
	public function maxConBomDay(array $data = [], $conBomDay = 0)
	{
		if (!$data || $conBomDay < 0) {
			return 0;
		}
		$conBom = 0;
		if ($conBomDay > 0) {
			$this->conBomDay = $conBomDay;
			$this->conBomSec = $conBomDay * 24 * 3600;
		}
		$data = array_values($data);
		foreach ($data as $k => $v) {
			if (strtotime($data[$k+1]) - strtotime($data[$k]) > $this->conBomSec) {
				return $conBom;
			}
			$conBom++;
		}
		return $conBom;
	}
	
	public function unConBomDays(array $data = [], $conBomDay = 0)
	{
		if (!$data || $conBomDay < 0) {
			return 0;
		}
		$conBom = 0;
		$res = [];
		if ($conBomDay > 0) {
			$this->conBomDay = $conBomDay;
			$this->conBomSec = $conBomDay * 24 * 3600;
		}
		$data = array_values($data);
		foreach ($data as $k => $v) {
			if (strtotime($data[$k+1]) - strtotime($data[$k]) > $this->conBomSec) {
				$sec = strtotime($data[$k+1]) - strtotime($data[$k]);
				$day = ceil($sec / 3600 / 24);
				for ($i = $day - 1;$i > 0;$i--) {
					$res[] = $data[$k+1] - (3600 * 24);
				}
				$res[] = $data[$k];
			}
			$conBom++;
		}
		return $conBom;
	}
}