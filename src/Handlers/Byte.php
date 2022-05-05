<?php


namespace FreeAbrams\FuncTools\Handlers;

/**
 * Created By FreeAbrams
 * Date: 2022/4/1
 */
class Byte
{
	private $int = 1024;
	private $kb = 1024;
	private $mb = 1024^2;
	private $gb = 1024^3;
	private $tb = 1024^4;
	
	private $unit = ['B', 'KB', 'MB', 'GB', 'TB'];
	
	public function __construct($int)
	{
		$this->int = (int)$int;
	}
	
	public function diffToHuman()
	{
		$int = $this->int;
		for ($i = 0; $int > 1024 && $i < count($this->unit); $i++) {
			$int /= 1024;
		}
		return $int.$this->unit[$i];
	}
	
	public function unitTo($values, $tagUnit = 'MB')
	{
		
	}
}