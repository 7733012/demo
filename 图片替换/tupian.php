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


require('data/common.inc.php');
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

	$litpic_url= $imgarr['litpic'];//图片地址
	
	
	echo '缩略图地址：'.$litpic_url."<a href=$litpic_url target=_blank>打开</a>";
	
	
	
	$litpic_url=ltrim($litpic_url,'/');
	//echo $img_url;
	 if(Img($litpic_url,110,110,1))
	 {
		 
		//echo '图片比例转换成功 <img src="'.$litpic_url.'" /><br />';
		echo "图片比例转换成功$litpic_url<br />";
	  }else{
		//echo '图片比例转换失败 <img src="'.$litpic_url.'" /><br />';  
		echo "<font color='red'>图片比例转换失败$litpic_url</font><br />";
		//exit();
	  }
	  
}


 echo $nexturl = 'tupian.php?n='.$litpic_id;
//当处理完成后，跳转到下一个页面 处理下一段数据 
sleep(1);
 echo '<script type="text/javascript"> window.location.href="'.$nexturl.'";</script>';//跳转下个页面


$phtypes=array(
   'img/gif',
   'img/jpg',
   'img/jpeg',
   'img/bmp',
   'img/pjpeg',
   'img/x-png'
);
Function Img($Image,$Dw=450,$Dh=450,$Type=1){
   IF(!File_Exists($Image)){
    Return False;
   }
   #如果需要生成缩略图,则将原图拷贝一下重新给$Image赋值
   IF($Type!=1){
    Copy($Image,Str_Replace(".","_x.",$Image));
    $Image=Str_Replace(".","_x.",$Image);
   }
   #取得文件的类型,根据不同的类型建立不同的对象
   $ImgInfo=GetImageSize($Image);
   Switch($ImgInfo[2]){
   Case 1:
    $Img = @ImageCreateFromGIF($Image);
   Break;
   Case 2:
    $Img = @ImageCreateFromJPEG($Image);
   Break;
   Case 3:
    $Img = @ImageCreateFromPNG($Image);
   Break;
   }
   #如果对象没有创建成功,则说明非图片文件
   IF(Empty($Img)){
    #如果是生成缩略图的时候出错,则需要删掉已经复制的文件
    IF($Type!=1){Unlink($Image);}
    Return False;
   }
   #如果是执行调整尺寸操作则
   IF($Type==1){
    $w=ImagesX($Img);
    $h=ImagesY($Img);
    $width = $w;
    $height = $h;
    IF($width>$Dw){
     $Par=$Dw/$width;
     $width=$Dw;
     $height=$height*$Par;
     IF($height>$Dh){
      $Par=$Dh/$height;
      $height=$Dh;
      $width=$width*$Par;
     }
    }ElseIF($height>$Dh){
     $Par=$Dh/$height;
     $height=$Dh;
     $width=$width*$Par;
     IF($width>$Dw){
      $Par=$Dw/$width;
      $width=$Dw;
      $height=$height*$Par;
     }
    }Else{
     $width=$width;
     $height=$height;
    }
    $nImg = ImageCreateTrueColor($width,$height);     #新建一个真彩色画布
    ImageCopyReSampled($nImg,$Img,0,0,0,0,$width,$height,$w,$h);#重采样拷贝部分图像并调整大小
    ImageJpeg ($nImg,$Image);          #以JPEG格式将图像输出到浏览器或文件
    Return True;
   #如果是执行生成缩略图操作则
   }Else{
    $w=ImagesX($Img);
    $h=ImagesY($Img);
    $width = $w;
    $height = $h;
    $nImg = ImageCreateTrueColor($Dw,$Dh);
    IF($h/$w>$Dh/$Dw){ #高比较大
     $width=$Dw;
     $height=$h*$Dw/$w;
     $IntNH=$height-$Dh;
     ImageCopyReSampled($nImg, $Img, 0, -$IntNH/1.8, 0, 0, $Dw, $height, $w, $h);
    }Else{     #宽比较大
     $height=$Dh;
     $width=$w*$Dh/$h;
     $IntNW=$width-$Dw;
     ImageCopyReSampled($nImg, $Img, -$IntNW/1.8, 0, 0, 0, $width, $Dh, $w, $h);
    }
    ImageJpeg ($nImg,$Image);
    Return True;
   }
}


 
 
?>

</body>
</html>
