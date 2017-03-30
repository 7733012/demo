<?php

//转义html
function html($html)
{
	return htmlspecialchars($html);
}


//echo md5('李根中华人民共和国');

//md5_file();

/*数字格式化，按千分位，分格
echo number_format('9999999',0,',',':');
*/

/*

//preg_match();  //只匹配一次

$reg = '/http:\/\/www\.[^\/]*.com/';

$url = 'http://www.baidu.asdfadsf.adsfad.com';
if(preg_match($reg,$url,$urls))
{
	echo '匹配成功。';
	print_r($urls);
}else{

	echo '匹配失败。';
}*/

/*
$zj = ' 1234578   中国   我爱你abcd    ';//处理两端的空白
echo trim($zj,'0..9 A..z a..z \0');
echo strlen($zj);//输出有多少个字符串。
*/


/*

strip_tags($tag); //去除标签，比如font ,div i b class等	
*/

/*
str_replace($arr1,$arr2,$html); //替换字符串函数。
*/

/*
printf();//格式化输出
sprintf();//返回一个格式化的字符串
*/


/*
$a = 'zhijia,1,2,3,4,中华人';
$a = explode(',',$a);//分割函数
print_r($a); //以逗号分割，分出一个数组
*/

/*
implode(); join()2函数相同join别名;//连接肿的元素 组合成为字符串 
$a = array('a','b','c');
echo implode('-',$a); //这时候以+ 组合了。
*/


/*
$i= strpos("abcdabcd","bc"); //找到第一次出现的字符串位置 返回真假
var_dump($i);

strrpos();//最后一次出现字符串的位置

strrchr 查找最后一次出现字符串 的字符，可以截取字符

$str = strrchr('abcdabcedef','d');
var_dump($str);


strstr();//查找第一次出现字符串 的字符，可以截取字符

substr('helloworld',5);//截取字符串从第5个字符后面所以，从后面就-2;
substr('zhijiaonline','-1,3');
*/

/*

*/




 ?>