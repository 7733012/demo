<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php

$n = !empty($_GET['n'])?$_GET['n']:exit('没有取到指针的值');
$pagen=10;//每次处理几张图片 


require('common.inc.php');
$dblink=mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
mysql_select_db($cfg_dbname ,$dblink);
mysql_query('set names gbk');
//$count ="select COUNT(id) from dede_archives";
//$count = mysql_query($count);
//$count =mysql_fetch_assoc($count);
//print_r($count);


echo $lg_img = "select id,litpic from dede_archives where id>$n order by id asc limit $pagen";
$lg_img = mysql_query($lg_img);
if(empty($lg_img))
{
	exit('处理完成');	
}



	//缓冲输出开启 
		ob_start(); //打开输出缓冲区 
		ob_end_flush(); 
		ob_implicit_flush(1); //立即输出 
		//echo str_repeat(" ",4096); //确保足够的字符，立即输出，Linux服务器可以去掉这个语句
		
		
while($imgarr = mysql_fetch_assoc($lg_img))
{
	
	echo 'ID:';
	echo $litpic_id= $imgarr['id'];//id 下次处理从此处开始

	$litpic_url= 'http://img.aimein.com'.$imgarr['litpic'];//图片地址
	
	
	echo '缩略图地址：'.$litpic_url."<a href=$litpic_url target=_blank>打开</a>";
	//更新图片地址
	echo $up_sql = "update dede_archives set litpic=\"$litpic_url\" where id=\"$litpic_id\"";
	$thok = mysql_query($up_sql);
	
	

	 if($thok)
	 {
		 
		//echo '图片比例转换成功 <img src="'.$litpic_url.'" /><br />';
		echo "图片地址转换成功$litpic_url<br />";
	  }else{
		//echo '图片比例转换失败 <img src="'.$litpic_url.'" /><br />';  
		echo "<font color='red'>图片地址转换失败$litpic_url</font><br />";
		//exit();
	  }
	  
}


 echo $nexturl = 'tupian2.php?n='.$litpic_id;
//当处理完成后，跳转到下一个页面 处理下一段数据 
sleep(1);
 echo '<script type="text/javascript"> window.location.href="'.$nexturl.'";</script>';//跳转下个页面




 
 
?>

</body>
</html>
