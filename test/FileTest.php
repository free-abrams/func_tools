<?php


namespace FreeAbrams\Test;

use FreeAbrams\FuncTools\Handlers\File;
use PHPUnit\Framework\TestCase;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class FileTest extends TestCase
{
	public function testSaveAs()
	{
		$__file = $_FILES;
		$file = new File($__file);
		$path = '/upload/'.
			date('Y', time()).'/'.
			date('m', time()).'/'.
			date('d', time()).'/'.md5(time());
		$file->saveAs($path);
	}
}