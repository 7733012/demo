<?php
header("Content-type:text/html;charset=utf-8");


//外部变量。
	//例如从一个表单，提交到php，
	
	/*
		$_GET
		$_POST 
		$_REQUEST  //包含了post,和get
		直接使用变量名，如 name='abc'   直接可以使用$abc   php5中提供了直接使用变量名就OK。
	*/
	
/*	print_r($_GET);
	
	print_r($_POST);
	
	print_r($_REQUEST);
	
	
	echo $_GET['aaa'];
	echo $_POST['bbb'];
	
	echo $_REQUEST['ddd'];
	
	echo $ddd;*/


/*
	服务器环境变量。
	phpinfo();
	echo $_SERVER;  
	echo $_ENV
*/	

	echo $zhijia;  //当url?zhijia=李根 或post提交过来的，都可以直接用变量名获取。
	print_r($_ENV);
?>