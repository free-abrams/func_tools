<?php


namespace FreeAbrams\FuncTools\Handlers\File;

/**
 * Created By FreeAbrams
 * Date: 2022/7/19
 */
class FileReader extends BaseFile
{
	public function __construct()
	{
	}
	
	public function createFromFgetcsv(string $path)
	{
		$st = fopen($path, 'r');
		while (!feof($st)) {
			yield fgetcsv($st);
		}
		fclose($st);
	}
	
	public function createFromFgets(string $path)
	{
		$st = fopen($path, 'r');
		while (!feof($st)) {
			yield fgets($st);
		}
		fclose($st);
	}
	
	public function createFromFgetss(string $path)
	{
		$st = fopen($path, 'r');
		while (!feof($st)) {
			yield fgetss($st);
		}
		fclose($st);
	}
	
	public function createFromArray(array $data)
	{
		yield from $data;
	}
}