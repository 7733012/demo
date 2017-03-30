<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php

set_time_limit(0);
require('common.inc.php');
$dblink=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
mysql_select_db($cfg_dbname ,$dblink);
mysql_query('set names gbk');


//要操作的数据表
$db_table = 'dede_archives';



echo $lg_img = "select * from $db_table where litpic !=''";
$arr = mysql_query($lg_img);
while($zhijia = mysql_fetch_array($arr))
{


		
	
	//echo '-------------------------------------------id  ';
			$t_id = $zhijia[id].'<br />';
			$litpic = 'http://www.bofangke.net'.$zhijia[litpic];
			
			$ch = curl_init(); 
			$timeout = 10; 
			curl_setopt ($ch, CURLOPT_URL, $litpic); 
			curl_setopt($ch, CURLOPT_HEADER, 1); 
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 

			$contents = curl_exec($ch);
			//echo $contents;
			if (preg_match("/404/", $contents)){
				echo '文件不存在';
				echo 'pic'.$litpic.'<br />';
			
	
				//$litpic = addslashes($litpic);
				$u_sql = "delete from $db_table  where id = '$t_id'";
				$ok = mysql_query($u_sql);
				
				echo $u_sql;
				if($ok==true)
				{
					echo '  删除成功！<br />';
				}else{
					echo '  删除失败！<br />';
				}
			}else{
			continue;
			}
}
 
 
?>

</body>
</html>
