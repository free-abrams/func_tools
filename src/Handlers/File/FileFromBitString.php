<?php


namespace FreeAbrams\FuncTools\Handlers\File;

use Symfony\Component\Mime\MimeTypes;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class FileFromBitString extends BaseFile
{

	private $stream;

	public function __construct($stream)
	{
		$this->stream = $stream;
	}
	
	/**
	 * 保存文件流
	 * @param string $path
	 * @param string $name
	 * @return false|int|void
	 */
	public function saveAs(string $path = '', string $name = '')
	{
		$path = rtrim($path, '\//');
		self::checkDir($path);
		$head = substr($this->stream, 0, 2);
		$res = unpack('H4', $head);
		$ext = self::gaussByteExstension(array_pop($res));
		// 如果有后缀就替换，没有就加上
		$match = [];
		preg_match('/(?<=\.)[^\.]*$/', $name, $match);
		if ($match) {
			$name = preg_replace('/(?<=\.)[^\.]*$/', $ext, $name);
		} else {
			$name.= '.'.$ext;
		}
		return file_put_contents($path.'/'.$name, $this->stream);
	}
	
	/**
	 * 猜测文件流后缀
	 * @param $first4Bytes
	 * @return string
	 */
	private function gaussByteExstension($first4Bytes)
	{
		return FileHeadCode::getValue($first4Bytes, 4);
	}
}