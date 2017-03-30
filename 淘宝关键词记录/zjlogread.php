<?php
	/*
		2013-06-16日 晚所写 by云淡风轻
		自动分目录记录，读到日志，为php文件 
	*/
	error_reporting(E_ALL & ~ E_NOTICE); //错误处理
	/*验证cookie
	if($_COOKIE['zhijia_read_names']!='aslkdjlja_dsjfwwej_lsjdfhuiwheusdhaohuwueu')
	{
		echo '^_^，没有权限 请绕路而行..';
		exit;//如果没有这个cookie值就退出		
	}
		*/

	date_default_timezone_set('Asia/Shanghai');
	$zjYear = isset($_GET['date']) ? $_GET['date'] :date('Y-m-d');//可带date参数	
	$zjArr  = explode('-', $zjYear);
	//print_r($zjArr);

	$zjdir = dirname(__FILE__).DIRECTORY_SEPARATOR.'zjlogs'.DIRECTORY_SEPARATOR.$zjArr[0].DIRECTORY_SEPARATOR.$zjArr[1].DIRECTORY_SEPARATOR.$zjArr[2].DIRECTORY_SEPARATOR;
	
	$zjdirlog =$zjdir.DIRECTORY_SEPARATOR.'allLog'.DIRECTORY_SEPARATOR;//所有日志

	$allLog_file = $zjdirlog.'allLog.php';//所有日志
	$successLog_file = $zjdirlog.'successLog.php';//成功日志
	$failLog_file = $zjdirlog.'failLog.php';//失败日志
	$allNum_file = $zjdir.DIRECTORY_SEPARATOR.'allNum.php';//总数	
	$successNum_file = $zjdir.DIRECTORY_SEPARATOR.'successNum.php';//成功
	$failNum_file = $zjdir.DIRECTORY_SEPARATOR.'failNum.php ';//失败
	//数组方式 1所有日志，2成功日志,3失败日志,4总数,5成功数,6失败数
	$file_arr = array(1 => $allLog_file,2 => $successLog_file, 3 =>$failLog_file,4 => $allNum_file,5 => $successNum_file,6 => $failNum_file);


	function zj_read($zj_num)
	{
		define('ZJ_TAOBAO','lg998');//没有这句权限 取不到值
		global $file_arr;
		$fname = $file_arr[$zj_num];
		$zj = @file_get_contents($fname);
		$arr = array(
			array('/\r/','/[\x{4e00}-\x{9fa5}]/u','/\d{2}:\d{2}:\d{2}/','/<\?php\n.*\n.>/is'),
			array('<br />','<font color=red>\\0</font>','<font style="color:green;text-decoration:underline;">\\0</font>',''),
		);
		echo  preg_replace($arr[0],$arr[1],$zj);		
		
	}
	/*
	echo '总数：'; zj_read(4); //总数：
	echo '成功数：'; zj_read(5); //读取成功数
	echo '失败数：'; zj_read(6); //失败数
	echo '全部日志：'; zj_read(1); //全部日志
	echo '成功日志：'; zj_read(2); //成功日志
	echo '失败日志：'; zj_read(3); //失败日志
	*/

	

	$url_pass = isset($_POST['url_pass']) ? $_POST['url_pass'] : '^_^，没有权限 请绕路而行..';
	
	//url_pass 可以批量取，可以单取，批量取用- 分开如取成功，失败 总数 php?url_pass=4-5-6
	if(strpos($url_pass,'-'))
	{
		$uarr = explode('-',$url_pass);		
		foreach ($uarr as $key => $value)
		{
			zj_read($value);
			echo "|";

		}

	}else{
		//通过url参数显示数据
		zj_read($url_pass);
	}
	
?>