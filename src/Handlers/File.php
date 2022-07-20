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
	
	/**
	 * 保存表单上传文件
	 * @param $type
	 * @param $name
	 * @param $tmp_name
	 * @param $size
	 * @param $error
	 * @return FileFromPost
	 */
	public function createFromPostData($type, $name, $tmp_name, $size, $error)
	{
		return $this->handler = new FileFromPost($type, $name, $tmp_name, $size, $error);
	}
	
	/**
	 * 保存字节流文件
	 * @param $stream
	 * @return FileFromBitString
	 */
	public function createFromStreamData($stream)
	{
		return $this->handler = new FileFromBitString($stream);
	}
	
	/**
	 * 读取磁盘上的文件
	 * @param string $realPath
	 * @return \Generator
	 */
	public function createFromPathFile(string $realPath)
	{
		return $this->handler = (new FileReader())->createFromFgetcsv($realPath);
	}
	
	public function saveAs($path = '', $name = '')
	{
		return $this->handler->saveAs($path, $name);
	}
}