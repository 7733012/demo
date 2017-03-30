<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php


require('common.inc.php');
$dblink=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
mysql_select_db($cfg_dbname ,$dblink);
mysql_query('set names gbk');
$count ="select COUNT(id) from dede_archives";
$count = mysql_query($count);
$count =mysql_fetch_assoc($count);
print_r($count);

//要操作的数据表
$db_table = 'dede_archives';



echo $lg_img = "select * from $db_table where litpic !=''";
$arr = mysql_query($lg_img);
while($zhijia = mysql_fetch_array($arr))
{

	$litpic = $zhijia[litpic];
	if(empty($litpic))
	{
		continue;//如果为空就跳过
	}
	//echo '-------------------------------------------id  ';
	$t_id = $zhijia[id].'<br />';
	
	//查找.jp
	if(preg_match('/(.*?)\.jpgg$/i',$litpic))
	{
		$litpic = preg_replace('/(.*?)\.jpgg$/is','\\1.jpg',$litpic);	
		if($litpic)
		{
		//	echo '成功'.$litpic.'<br >';

		
	
	
	
			//$litpic = addslashes($litpic);
			$u_sql = "update $db_table set `litpic` = '$litpic' where id = '$t_id'";
			$ok = mysql_query($u_sql);
			
			echo $u_sql;
			if($ok==true)
			{
				echo '  替换成功！<br />';
			}else{
				echo '  替换失败！<br />';
			}
		
	
	}
	
		
	
	
	}//正则完成
}
 
 
?>

</body>
</html>
