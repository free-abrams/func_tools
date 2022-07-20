<?php


namespace FreeAbrams\FuncTools\Handlers\File;

use FreeAbrams\FuncTools\Error\FileUploadError;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class BaseFile
{
	public function saveAs()
    {

    }
    
    public function checkDir($path)
    {
		// 检查路径
		if (!is_dir($path)) {
            if (false === @mkdir($path, 0777, true) && !is_dir($path)) {
                throw new FileUploadError(sprintf('Unable to create the "%s" directory.', $path));
            }
		}  elseif (!is_writable($path)) {
            throw new FileUploadError(sprintf('Unable to write in the "%s" directory.', $path));
        }
    }
}