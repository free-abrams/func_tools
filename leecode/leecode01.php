<?php
//1. 两数之和
//输入：nums = [2,7,11,15], target = 9
//输出：[0,1]
//解释：因为 nums[0] + nums[1] == 9 ，返回 [0, 1] 。
//链接：https://leetcode-cn.com/problems/two-sum
function two_sum($arr, $target)
{
	$hash = function ($arr) {
		$res = [];
		foreach ($arr as $k => $v) {
			$res[$v] = $k;
		}
		return $res;
	};

	foreach ($arr as $k => $v) {
		$temp = $target - $v;
		if (isset($hash[$temp])) {
			return [$hash[$temp], $k];
		}
	}
	return false;
}
//2. 两数相加
//输入：l1 = [2,4,3], l2 = [5,6,4]
//输出：[7,0,8]
//解释：342 + 465 = 807.
function add_two_numbers($l1 = [2,4,3], $l2 = [5,6,4])
{
	$a = '';$b = '';
	foreach($l1 as $v) {
		$a = $v . $a;
	}
	foreach($l2 as $v) {
		$b = $v . $b;
	}
	$c = $a + $b;
	$d = [];
	for($i = strlen($c); $i > 0; $i-- ) {
		$d[] = $c[$i];
	}

	return $d;
}
//3. 无重复字符的最长子串
//输入: s = "abcabcbb"
//输出: 3
//解释: 因为无重复字符的最长子串是 "abc"，所以其长度为 3。
function longest_substring_without_repeating_characters($s = 'abcabcbb')
{
	$hash = [];
	$i = 0;$j = 0;
	$res = 0;
	while($i < strlen($s) && $j < strlen($s)) {
		if (!in_array($hash, $s[$i])) {
			$hash[] = $s[$j++];
			$res = count($hash)>j - i?count($hash):j -i;
		} else {
			unset($hash[$i++]);
		}
	}

	return $res;
}
//4. 寻找两个正序数组的中位数
//输入：nums1 = [1,2], nums2 = [3,4]
//输出：2.50000
//解释：合并数组 = [1,2,3,4] ，中位数 (2 + 3) / 2 = 2.5
function median_of_two_sorted_arrays($nums1 = [1,2], $nums2 = [3,4])
{
	$merger = array_merge($nums1, $nums2);
	$merger = fast_sort($merger);

	if (count($merger) % 2 > 0) {
		$l = floor(count($merger) / 2);
		$r = ceil(count($merger) / 2);
		$res = ($l + $r) / 2;
	} else {
		$res = $merger[count($merger) / 2];
	}
}
//5. 最长回文子串
//输入：s = "babad"
//输出："bab"
//解释："aba" 同样是符合题意的答案。
function longest_palindromic_substring()
{

}
//6. Z 字形变换
//将一个给定字符串 s 根据给定的行数 numRows ，以从上往下、从左到右进行 Z 字形排列。
//
//比如输入字符串为 "PAYPALISHIRING" 行数为 3 时，排列如下：
//
//P   A   H   N
//A P L S I I G
//Y   I   R
//之后，你的输出需要从左往右逐行读取，产生出一个新的字符串，比如："PAHNAPLSIIGYIR"。
//
//请你实现这个将字符串进行指定行数变换的函数：
//
//string convert(string s, int numRows);
function zigzag_conversion($s = 'PAYPALISHIRING', $numRows = 3)
{

}

//7. 整数反转
//给你一个 32 位的有符号整数 x ，返回将 x 中的数字部分反转后的结果。
//如果反转后整数超过 32 位的有符号整数的范围[−231, 231− 1] ，就返回 0。
//假设环境不允许存储 64 位整数（有符号或无符号）。
function reverse_integer()
{

}
//8. 字符串转换整数 (atoi)
//函数myAtoi(string s) 的算法如下：
//
//读入字符串并丢弃无用的前导空格
//检查下一个字符（假设还未到字符末尾）为正还是负号，读取该字符（如果有）。 确定最终结果是负数还是正数。 如果两者都不存在，则假定结果为正。
//读入下一个字符，直到到达下一个非数字字符或到达输入的结尾。字符串的其余部分将被忽略。
//将前面步骤读入的这些数字转换为整数（即，"123" -> 123， "0032" -> 32）。如果没有读入数字，则整数为 0 。必要时更改符号（从步骤 2 开始）。
//如果整数数超过 32 位有符号整数范围 [−231, 231− 1] ，需要截断这个整数，使其保持在这个范围内。具体来说，小于 −231 的整数应该被固定为 −231 ，大于 231 − 1 的整数应该被固定为 231 − 1 。
//返回整数作为最终结果。
//注意：
//
//本题中的空白字符只包括空格字符 ' ' 。
//除前导空格或数字后的其余字符串外，请勿忽略 任何其他字符。
function string_to_integer_atoi()
{

}
//9. 回文数
//给你一个整数 x ，如果 x 是一个回文整数，返回 true ；否则，返回 false 。
//回文数是指正序（从左向右）和倒序（从右向左）读都是一样的整数。
//例如，121 是回文，而 123 不是。
function palindrome_number()
{

}
//10. 正则表达式匹配
//给你一个字符串s和一个字符规律p，请你来实现一个支持 '.'和'*'的正则表达式匹配。
//
//'.' 匹配任意单个字符
//'*' 匹配零个或多个前面的那一个元素
//所谓匹配，是要涵盖整个字符串s的，而不是部分字符串。

function regular_expression_matching()
{

}