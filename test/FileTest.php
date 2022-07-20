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
	public function testCreateFromStreamData()
	{
		$res = dirname(dirname(__FILE__)).'/uploads/';
		$stream = file_get_contents('https://wx2.sinaimg.cn/bmiddle/005YCRu1gy1h4c5082r93j30k00k07cg.jpg');
		$handle = new File();
		$handle->createFromStreamData($stream);
		return $handle->saveAs($res, '北安普顿');
	}
}