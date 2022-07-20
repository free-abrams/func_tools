<?php


namespace FreeAbrams\FuncTools\Handlers\File;

/**
 * Created By FreeAbrams
 * Date: 2022/7/20
 */
class FileHeadCode
{
	const map8Bytes = [
		'FFD8FF' => '',
		'89504E47' => '',
	];
	
	const map4Bytes = [
		'FFD8' => 'jpg',
	];
	
	static public function getValue($key , $len = 4)
	{
		$map = [];
		switch($len)
		{
			case 4;
				$map = self::map4Bytes;
				break;
				
			case 8;
				$map = self::map8Bytes;
				break;
				
			default;
				$map = self::map4Bytes;
				break;
		}
		return $map[strtoupper($key)]??'';
	}
}