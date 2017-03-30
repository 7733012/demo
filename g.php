<?php
	header("Content-type:text/html;charset=gb2312");
	//取网页源码
	$url_file = file_get_contents('http://www.szqcgw.com/');
	//echo $url_file;
	if(!$url_file)
	{
		//如果取源码失败，则跳转
		header('location:http://www.szqcgw.com/');
	}
	
	//打列表的链接 
	//正则表达式	
	$list_reg = '/<DIV class=inav>(.*?)<DIV class=links>/is'; //列表
	preg_match_all($list_reg,$url_file,$list);
	//print_r($list[1][0]);
	
	
	
	//找是a标签的 url
	$list_reg_a = '/href=\"(.*?)\"/is';
	preg_match_all($list_reg_a,$list[1][0],$lista);
	//print_r($lista[1]);exit;
	
	
	//把数组放进去 并取 .html结尾的
	$a = array();
	foreach($lista[1] as $key=>$val)
	{
		if(strpos($val,'.html'))
		{
		$a[] = 'http://www.szqcgw.com'.$val;
		}
	}
	
	//print_r($a);
	
	
	//随机从数组中，取一条链接
	$k =  array_rand($a,1);
	$ok_url = $a[$k];
	
	//跳转到这个页面
	header('location:'.$ok_url);
?>