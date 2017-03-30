<?php
		
		$qq = $_GET['keyword'];
		
		//$qq = iconv('gb2312', 'utf-8', $qq[1][0]);
		
		
		$qq = str_replace('_淘宝搜索', '', $qq);
		$zjstr  = '关键词:'.$qq;
		require_once('zjlog.php');

		zj_put_num(5);//记录成功数和总数
		zj_put_log(2,$zjstr);


    

?>