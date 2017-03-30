<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php

error_reporting(1);
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
echo '<br />';
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
	$path_img = './uploads/allimg/';
	if(preg_match('/.*?([^\.jpg|\.gif])$/is',$litpic))
	{
		//echo '成功'.$litpic.'<br >';
		$dirarr = explode('/', $litpic);
		$c_f = count($dirarr);
		//文件名字
		$f_name = $dirarr[$c_f-1];
		//目录名字
		$p_name = $dirarr[$c_f-2];
		
		//print_r($p_name).'<br >';
		$dir_list = @scandir($path_img.$p_name.'/');
		if(!$dir_list)
		{
			//echo '不存在这个目录，跳过！<br />';
			continue;
		}
		
		
		$t_key = zj_find('/'.$f_name.'.*/is',$dir_list);
		echo 't_key:  '.$t_key.'                  <br />';
		$new_litpic = 'http://img.szqcgw.com/uploads/allimg/'.$p_name.'/'.$t_key;
		echo 'url_path: '.$new_litpic;
		
		echo '成功'.$litpic.'<br >';
		//print_r($dir_list);
		echo '<br /><br /><br /><br /><br /><br />';
		

	
		
			$u_sql = "update $db_table set `litpic` = '$new_litpic' where id = '$t_id'";
			$ok = mysql_query($u_sql);
			
			echo $u_sql;
			if($ok==true)
			{
				echo '  替换成功！<br />';
			}else{
				echo '  替换失败！<br />';
			}
		

	
	
		
	
	
	}//正则完成
	
	
	
}
 
 function zj_find($reg,$arr){
	
		foreach($arr as $key=>$val)
		{
			if(preg_match($reg,$val))
			{	
				
				return $val;
			}
		}
	}
?>

</body>
</html>
