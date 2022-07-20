<?php


namespace FreeAbrams\FuncTools\Handlers;

use FreeAbrams\FuncTools\Handlers\File\FileFromBitString;
use FreeAbrams\FuncTools\Handlers\File\FileFromPost;
use FreeAbrams\FuncTools\Handlers\File\FileReader;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class File
{
	private $handler;
	
	public function createFromPostData($type, $name, $tmp_name, $size, $error)
	{
		return $this->handler = new FileFromPost($type, $name, $tmp_name, $size, $error);
	}
	
	public function createFromStreamData($stream)
	{
		return $this->handler = new FileFromBitString($stream);
	}
	
	public function createFromPathFile(string $realPath)
	{
		return $this->handler = (new FileReader())->createFromFgetcsv($realPath);
	}
	
	public function saveAs($path = '', $name = '')
	{
		return $this->handler->saveAs($path, $name);
	}
}