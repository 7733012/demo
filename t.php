<?php

	set_time_limit(0); //不超时
	
	include("data/common.inc.php");
	//目标是把a标签 给替换为空，采集的时候没有设置。

	$reg = array('/<a.*?>/is','/<\/a>/is');
	$reg2= array('','');
	

	$link=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	mysql_select_db($cfg_dbname,$link);
	mysql_query('set names gbk');
	//查询表替换
	
	$sql = 'select aid,body from dede_addonarticle where body REGEXP "<a"';
	$arr = mysql_query($sql);
	while($rs=mysql_fetch_array($arr))
	{
		$body = preg_replace($reg,$reg2,$rs['body']);
		//echo $body;
		$aid= $rs['aid'];
		$up = mysql_query("update dede_addonarticle set body='$body' where aid='$aid'");
		if($up)
        {
			echo $aid.'替换成功 ';
		}else{
			echo '替换失败！';
		}
		
	}






?>