<?php

namespace FreeAbrams\FuncTools\Handlers;

use voku\helper\ASCII;

class Str
{
	/**
	 * 判断指定字符串是否以另一指定字符串开头
	 * @param string $search
	 * @param string $subject
	 * @return false|int
	 */
	static public function startWith($search = '', $subject = '')
	{
		$regex = "/^($search)/";
		$match = [];
		return preg_match($regex, $subject, $match)?true:false;
	}
	
	/**
	 * 判断指定字符串是否以另一指定字符串结尾
	 * @param string $search
	 * @param string $subject
	 * @return false|int
	 */
	static public function endWith($search = '', $subject = '')
	{
		$regex = "/($search)$/";
		$match = [];
		return preg_match($regex, $subject, $match)?true:false;
	}
	
	/**
	 * @param string $search
	 * @param string $replace
	 * @param string $subject
	 * @return string|string[]|null
	 */
	static public function replace($search = '', $replace = '', $subject = '', $words = 0)
	{
		$regex = "/($search)/";
		return preg_replace($regex, $replace, $subject);
	}
	
	/**
	 * @param string $search
	 * @param string $subject
	 * @return false|int
	 */
	static public function search($search = '', $subject = '')
	{
		$regex = "/$search/";
		$match = [];
		return preg_match($regex, $subject, $match);
	}
	
	/**
	 * 将返回字符串中指定值后的所有内容，没有则返回false
	 * @param string $subject
	 * @param string $string
	 * @return false|string
	 */
	static public function after(string $subject, string $string)
	{
		$regx = "/(?<=\b($string)\b).*/";
		preg_match($regx, $subject, $match);
		return $match[0]??false;
	}
	
	/**
	 * 返回字符串中指定值最后一次出现后的所有内容，没有则返回false
	 * @param string $subject
	 * @param string $string
	 * @return false|string
	 */
	static public function afterLast(string $subject, string $string)
	{
		$regx = "/(?<!=\b($string)\b)[^($string)]*$/";
		preg_match($regx, $subject, $match);
		return $match[0]??false;
	}
	
	/**
	 * 返回字符串中指定值之前的所有内容，没有则返回null
	 * @param string $subject
	 * @param string $string
	 * @return false|string
	 */
	static public function before(string $subject, string $string)
	{
		$regx = "/^.*(?=$string)/";
		preg_match($regx, $subject, $match);
		return $match[0]??false;
	}
	
	/**
	 * 返回字符串中指定值最后一次出现前的所有内容
	 * @param string $subject
	 * @param string $string
	 * @return false|string
	 */
	static public function beforeLast(string $subject, string $string)
	{
		$regx = "/^.*(?=($string))/";
		preg_match($regx, $subject, $match);
		return $match[0]??false;
	}
	
	/**
	 * 返回两个值之间的字符串部分
	 * @param string $subject
	 * @param string $before
	 * @param string $after
	 * @return mixed
	 */
	static public function between(string $subject, string $before, string $after)
	{
		$regx = "/(?<=$before).*(?=$after)/";
		preg_match($regx, $subject, $match);
		return $match[1]??$match[0];
	}
	
	/**
	 * 判断指定字符串中是否包含另一指定字符串（区分大小写）
	 * @param string $subject
	 * @param $value
	 * @return false|int
	 */
	static public function contains(string $subject, $value)
	{
		if (is_array($value)) {
			$value = '('.implode(')|(', $value).')';
		} else {
			$value = "($value)";
		}
		$regx = "/$value/";
		return preg_match_all($regx, $subject);
	}
	/**
	 * 判断指定字符串是否包含指定数组中的所有值
	 * @param string $subject
	 * @param $value
	 * @return false|int
	 */
	static public function containsAll(string $subject, $value)
	{
		if (is_string($value)) {
			$data = [];
			$data[] = $value;
		} else {
			$data = &$value;
		}
		$regx = '/(?=.*'.implode(')(?=.*', $data).')^.*/';
		preg_match($regx, $subject, $match);
		return isset($match[0])?true:false;
	}
	
	/**
	 * 回指定字符串的父级目录部分
	 * @param string $path
	 * @param int $value
	 * @return string
	 */
	static public function dirname(string $path, $value = 1)
	{
		return dirname($path, $value);
	}
	
	/**
	 * 用于判断字符串是否是 7 位 ASCII
	 * @param string $subject
	 * @return bool
	 */
	static public function isAscii(string $subject)
	{
		return ASCII::is_ascii($subject);
	}
	
	/**
	 * 字符串转换成 ASCII
	 * @param string $subject
	 * @param string $language
	 * @return string
	 */
	static public function toAscii(string $subject, $language = 'en')
	{
		return ASCII::to_ascii($subject, $language);
	}
	
	/**
	 * 去除html脚本特殊符号，防止xss
	 * @param string $subject
	 * @return string
	 */
	static public function trimHtmlSpecialChars(string $subject)
	{
		return htmlspecialchars($subject);
	}
}