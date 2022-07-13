<?php


namespace FreeAbrams\FuncTools\Handlers;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class Mime
{
	// 表明文件是普通文本，理论上是人类可读
	private $text = [
		['mime' => 'text/plain', 'extension' => ['txt'], 'desc' => '普通文本格式'],
		['mime' => 'text/javascript', 'extension' => ['js'], 'desc' => '表示 Javascript 脚本文件'],
		['mime' => 'text/css', 'extension' => ['css'], 'desc' => '表示 CSS 样式表'],
		['mime' => 'text/html', 'extension' => ['htm', 'html', 'shtml'], 'desc' => 'HTML 文件格式'],
		['mime' => 'application/xhtml+xml', 'extension' => ['xht', 'xhtml'], 'desc' => 'XHTML 文件格式'],
		['mime' => 'text/xml', 'extension' => ['xml'], 'desc' => 'XML 文件格式'],
		['mime' => 'text/x-vcard', 'extension' => ['vcf'], 'desc' => 'VCF 文件格式'],
	];
	// 表明是某种图像。不包括视频，但是动态图（比如动态gif）也使用image类型
	private $image = [
		['mime' => 'image/gif', 'extension' => ['gif'], 'desc' => 'GIF 图像格式'],
		['mime' => 'image/jpeg', 'extension' => ['jpg', 'jpeg'], 'desc' => 'JPG(JPEG) 图像格式'],
		['mime' => 'image/jp2', 'extension' => ['jpg2'], 'desc' => 'JPG2 图像格式'],
		['mime' => 'image/png', 'extension' => ['png'], 'desc' => 'PNG 图像格式'],
		['mime' => 'image/tiff', 'extension' => ['tif', 'tiff'], 'desc' => 'TIF(TIFF) 图像格式'],
		['mime' => 'image/bmp', 'extension' => ['bmp'], 'desc' => 'BMP 图像格式（位图格式）'],
		['mime' => 'image/svg+xml', 'extension' => ['svg', 'svgz'], 'desc' => 'SVG 图像格式'],
		['mime' => 'image/webp', 'extension' => ['webp'], 'desc' => 'WebP 图像格式'],
		['mime' => 'image/x-icon', 'extension' => ['ico'], 'desc' => 'ico 图像格式，通常用于浏览器 Favicon 图标'],
	];
	// 表明是某种音频文件
	private $audio = [
		['mime' => 'audio/mpeg', 'extension' => ['mp3'], 'desc' => 'mpeg 音频格式'],
		['mime' => 'audio/midi', 'extension' => ['mid'], 'desc' => 'mid 音频格式'],
		['mime' => 'audio/x-wav', 'extension' => ['wav'], 'desc' => 'wav 音频格式'],
		['mime' => 'audio/x-mpegurl', 'extension' => ['m3u'], 'desc' => 'm3u 音频格式'],
		['mime' => 'audio/x-m4a', 'extension' => ['m4a'], 'desc' => 'm4a 音频格式'],
		['mime' => 'audio/ogg', 'extension' => ['ogg'], 'desc' => 'ogg 音频格式'],
		['mime' => 'audio/x-realaudio', 'extension' => ['ra'], 'desc' => 'Real Audio 音频格式'],
	];
	// 表明是某种视频文件
	private $video = [
		['mime' => 'video/mp4', 'extension' => ['mp4'], 'desc' => 'mp4 视频格式'],
		['mime' => 'video/mpeg', 'extension' => ['mpg', 'mpe', 'mpeg'], 'desc' => 'mpeg 视频格式'],
		['mime' => 'video/quicktime', 'extension' => ['qt', 'mov'], 'desc' => 'QuickTime 视频格式'],
		['mime' => 'video/x-m4v', 'extension' => ['m4v'], 'desc' => 'm4v 视频格式'],
		['mime' => 'video/x-ms-wmv', 'extension' => ['wmv'], 'desc' => 'wmv 视频格式（Windows 操作系统上的一种视频格式）'],
		['mime' => 'video/x-msvideo', 'extension' => ['avi'], 'desc' => 'avi 视频格式'],
		['mime' => 'video/webm', 'extension' => ['webm'], 'desc' => 'webm 视频格式'],
		['mime' => 'video/x-flv', 'extension' => ['flv'], 'desc' => 'flv 一种基于 flash 技术的视频格式'],
	];
	// 表明是某种二进制数据
	private $application = [
		['mime' => 'application/msword	', 'extension' => ['doc'], 'desc' => '微软 Office Word 格式（Microsoft Word 97 - 2004 document）'],
		['mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'extension' => ['docx'], 'desc' => '微软 Office Word 文档格式'],
		['mime' => 'application/vnd.ms-excel', 'extension' => ['xls'], 'desc' => '微软 Office Excel 格式（Microsoft Excel 97 - 2004 Workbook'],
		['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'extension' => ['xlsx'], 'desc' => '微软 Office Excel 文档格式'],
		['mime' => 'application/vnd.ms-powerpoint', 'extension' => ['ppt'], 'desc' => '微软 Office PowerPoint 格式（Microsoft PowerPoint 97 - 2003 演示文稿）'],
		['mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'extension' => ['pptx'], 'desc' => '微软 Office PowerPoint 文稿格式'],
		['mime' => 'application/x-gzip', 'extension' => ['gz', 'gzip'], 'desc' => 'GZ 压缩文件格式'],
		['mime' => 'application/zip', 'extension' => ['zip', '7zip'], 'desc' => 'ZIP 压缩文件格式'],
		['mime' => 'application/rar', 'extension' => ['rar'], 'desc' => 'RAR 压缩文件格式'],
		['mime' => 'application/x-tar', 'extension' => ['tar', 'tgz'], 'desc' => 'TAR 压缩文件格式'],
		['mime' => 'application/pdf', 'extension' => ['pdf'], 'desc' => 'PDF 是 Portable Document Format 的简称，即便携式文档格式'],
		['mime' => 'application/rtf', 'extension' => ['rtf'], 'desc' => 'RTF 是指 Rich Text Format，即通常所说的富文本格式'],
		['mime' => 'application/x-javascript', 'extension' => ['js'], 'desc' => 'Javascript 文件类型'],
		['mime' => 'application/xhtml+xml', 'extension' => ['xht', 'xhtml'], 'desc' => 'XHTML 文件格式'],
		['mime' => 'application/kswps', 'extension' => ['wps'], 'desc' => '金山 Office 文字排版文件格式'],
		['mime' => 'application/kset', 'extension' => ['et'], 'desc' => '金山 Office 表格文件格式'],
		['mime' => 'application/ksdps', 'extension' => ['dps'], 'desc' => '金山 Office 演示文稿格式'],
		['mime' => 'application/x-photoshop', 'extension' => ['psd'], 'desc' => 'Photoshop 源文件格式'],
		['mime' => 'application/x-coreldraw', 'extension' => ['cdr'], 'desc' => 'Coreldraw 源文件格式'],
		['mime' => 'application/x-shockwave-flash', 'extension' => ['swf'], 'desc' => 'Adobe Flash 源文件格式'],
		['mime' => 'application/x-httpd-php', 'extension' => ['php', 'php3', 'php4', 'phtml'], 'desc' => 'PHP 文件格式'],
		['mime' => 'application/java-archive', 'extension' => ['jar'], 'desc' => 'Java 归档文件格式'],
		['mime' => 'application/vnd.android.package-archive', 'extension' => ['apk'], 'desc' => 'Android 平台包文件格式'],
		['mime' => 'application/octet-stream', 'extension' => ['exe'], 'desc' => 'Windows 系统可执行文件格式'],
		['mime' => 'application/x-x509-user-cert', 'extension' => ['crt', 'pem'], 'desc' => 'PEM 文件格式'],
	];
	
	// 合并后的mime数组
	private $mime = [];
	
	public function __construct()
	{
		$arr = array_merge($this->application, $this->text, $this->video, $this->audio, $this->image);
		foreach ($arr as $k => $v) {
			$arr[$v['mime']] = $v;
		}
		
		$this->mime = $arr;
		unset($arr);
	}
	
	/**
	 * 返回文件真实后缀
	 * @param string $mime
	 * @return false|mixed
	 */
	public function extension(string $mime = '')
	{
		if ($mime && array_key_exists($mime, $this->mime)) {
			return $this->mime[$mime]['extension'];
		}
		return false;
	}
	
	/**
	 * 返回文件真实后缀的数组
	 * @param string $mime
	 * @return false|mixed
	 */
	public function extensionArray(string $mime = '')
	{
		if ($mime && array_key_exists($mime, $this->mime)) {
			return $this->mime[$mime]['extension'];
		}
		return false;
	}
	
	/**
	 * 返回文件真实mime
	 * @param string $mime
	 * @return false|mixed
	 */
	public function mime(string $mime = '')
	{
		if ($mime && array_key_exists($mime, $this->mime)) {
			return $this->mime[$mime];
		}
		return false;
	}
}