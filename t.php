<?php

	set_time_limit(0); //����ʱ
	
	include("data/common.inc.php");
	//Ŀ���ǰ�a��ǩ ���滻Ϊ�գ��ɼ���ʱ��û�����á�

	$reg = array('/<a.*?>/is','/<\/a>/is');
	$reg2= array('','');
	

	$link=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	mysql_select_db($cfg_dbname,$link);
	mysql_query('set names gbk');
	//��ѯ���滻
	
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
			echo $aid.'�滻�ɹ� ';
		}else{
			echo '�滻ʧ�ܣ�';
		}
		
	}






?>