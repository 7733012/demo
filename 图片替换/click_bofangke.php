<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php

$n = !empty($_GET['n'])?$_GET['n']:exit('没有取到指针的值');
$pagen=200;//每次处理几张图片 


require('common.inc.php');
$dblink=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
mysql_select_db($cfg_dbname ,$dblink);
mysql_query('set names '.$cfg_db_language);
//$count ="select COUNT(id) from dede_archives";
//$count = mysql_query($count);
//$count =mysql_fetch_assoc($count);
//print_r($count);


echo $lg_img = "select id,click from dede_archives where id>$n order by id asc limit $pagen";
echo '<br />';
$lg_img = mysql_query($lg_img);
if(empty($lg_img))
{
	exit('查询数据为空，或许 处理完成了！');	
}



	//缓冲输出开启 
		ob_start(); //打开输出缓冲区 
		ob_end_flush(); 
		ob_implicit_flush(1); //立即输出 
		//echo str_repeat(" ",4096); //确保足够的字符，立即输出，Linux服务器可以去掉这个语句
		
		
while($imgarr = mysql_fetch_assoc($lg_img))
{
	

	$zjclick= (int)$imgarr['click'];//点击数

	if($zjclick<200)
	{
		$click=rand(200,10000);//200至10000的随机数
	}
	$t_id = $imgarr['id'];
	echo $up_ok = "update dede_archives set click='$click' where id='$t_id'";
	$up_ok = mysql_query($up_ok);
	if($up_ok)
	{
		echo '点击数为： '.$click.' id为：'.$t_id.'修改成功！<br />';
	}
	
	

	  
}


 echo $nexturl = 'click_bofangke.php?n='.$t_id;
//当处理完成后，跳转到下一个页面 处理下一段数据 
sleep(1);
 echo '<script type="text/javascript"> window.location.href="'.$nexturl.'";</script>';//跳转下个页面



 
?>

</body>
</html>
