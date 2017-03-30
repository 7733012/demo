<?php
header("Content-type:text/html;charset=utf-8");
/**
* 数据类型
	标量数据 （字符串，整型，浮点型，布尔值） isset() 检测变量是否存在。
	复合类型 （数组(array)，对象(object)）
	特殊类型  资源，null
	常量 类型只能是标量  define("NAME","李根！");   echo defined("NAME");
	
*/




	//var_dump(); 可以输出类型和值。
	//getType();  可以查看是什么类型。
	
	//系统提供的常量 如__FILE__(当前的地址)
	//当前的行号 __LINE__;
	//PHP_VERSION 
	//PHP_OS
	
	echo 'PHP版本号：'.PHP_VERSION; 
	echo '<br />';	
	echo '当前在第'.__LINE__.'行';
	echo '<br />';
	echo '当前操作系统'.PHP_OS;
	echo '<br />';
	echo '当前的地址'.__FILE__;
	
	echo '<br />';
	echo '__FILE__ 的类型是'.getType(__FILE__);
	
	/*
		php执行方式 是，从上到下，遇到变量存到内存，一行一行执行的。 
	*/
	echo '<br />';
	$zhijia = array(1,2,5,10,'这是一个字符串');
	var_dump($zhijia);
	echo '<br />';
	define('OL','这是常量OL,常量只能用量类型！');
	if(defined('OL'))
	{
		echo '存在常量OL 他的值是：'.OL;
	}
	//常量，是不能取消，和重新定义的，但它的作用范围是全局的。
	echo '<br />--------------------------';
	function zhi()
	{
	
		echo OL;
	}
	zhi(); //常量使用范围是全局的。
?>