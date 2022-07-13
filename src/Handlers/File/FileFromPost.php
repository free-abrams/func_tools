<?php


namespace FreeAbrams\FuncTools\Handlers\File;

use FreeAbrams\FuncTools\Error\FileUploadError;
use Symfony\Component\Mime\MimeTypes;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class FileFromPost extends BaseFile
{
	private $mimeType = '';

	private $filename = '';

	private $tempFileName = '';

	private $size = '';

	private $error = '';
	
	// 没有错误发生，文件上传成功。
	protected $UPLOAD_ERR_OK = 0;
	// 上传的文件超过了 php.ini 中 upload_max_filesize选项限制的值。
	protected $UPLOAD_ERR_INI_SIZE = 1;
	// 上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。
	protected $UPLOAD_ERR_FORM_SIZE = 2;
	// 文件只有部分被上传。
	protected $UPLOAD_ERR_PARTIAL = 3;
	// 没有文件被上传。
	protected $UPLOAD_ERR_NO_FILE = 4;
	// 找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。
	protected $UPLOAD_ERR_NO_TMP_DIR = 6;
	// 文件写入失败。PHP 5.1.0 引进。
	protected $UPLOAD_ERR_CANT_WRITE = 7;
	
	public function __construct($type , $name, $tmp_name, $size, $error)
	{
		$this->mimeType     = $type??'application/octet-stream';
		$this->filename     = $name;
		$this->tempFileName = $tmp_name;
		$this->size         = $size;
		$this->error        = $error;
	}
	
	/**
	 * 保存
	 * @param string $path
	 * @param string $name without extension
	 * @return string|void
	 * @throws FileUploadError
	 */
	public function saveAs(string $path = '', string $name = '')
	{
		$target = $this->getFile($path, $name);
		set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
		try {
			$move = move_uploaded_file($this->tempFileName, $target);
		} finally {
			restore_error_handler();
		}
		if (!$move) {
			throw new FileUploadError(sprintf('Could not move the file "%s" to "%s" (%s).', $this->tempFileName, $target, strip_tags($error)));
		}
		return $target;
	}
	
	private function getFile($path = '', $name = '')
	{
		// 检查路径
		if (!is_dir($path)) {
            if (false === @mkdir($path, 0777, true) && !is_dir($path)) {
                throw new FileUploadError(sprintf('Unable to create the "%s" directory.', $path));
            }
		}  elseif (!is_writable($path)) {
            throw new FileUploadError(sprintf('Unable to write in the "%s" directory.', $path));
        }
				// 检查是否能够上传
		if (!$this->canSave()) {
			return false;
		}
		
		// 检查后缀
		$exstension = '';
		if ($this->getClientExtension()) {
			$exstension.= '.'.$this->getClientExtension();
		}
		
		return rtrim($path, '\//').'/'.$name.$exstension;
	}
	
	private function guessFileExtension()
	{
		$mime = new MimeTypes();
		return $this->exstension = $mime->getExtensions($this->mimeType);
	}
	
	public function getClientExtension()
	{
		$match = [];
		preg_match('/(?<=\.)[^\.]*$/', $this->filename, $match);
		return array_pop($match);
	}
	
	/**
	 * 检查是否能保存
	 * @return bool
	 * @throws FileUploadError
	 */
	private function canSave()
	{
		switch ($this->error) {
			case $this->UPLOAD_ERR_OK:
				return true;
				break;
			case $this->UPLOAD_ERR_INI_SIZE:
				throw new FileUploadError('The file is too large (server).');
				break;
			case $this->UPLOAD_ERR_FORM_SIZE:
				throw new FileUploadError('The file is too large (form).');
				break;
			case $this->UPLOAD_ERR_PARTIAL:
				throw new FileUploadError('The file was only partially uploaded.');
				break;
			case $this->UPLOAD_ERR_NO_FILE:
				throw new FileUploadError('No file was uploaded.');
				break;
			case $this->UPLOAD_ERR_NO_TMP_DIR:
				throw new FileUploadError('The servers temporary folder is missing.');
				break;
			case $this->UPLOAD_ERR_CANT_WRITE:
				throw new FileUploadError('Failed to write to the temporary folder.');
				break;
		}
		return false;
	}
}