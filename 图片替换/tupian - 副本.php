
<?php
/*
----------------------------------------------------------------------
函数:调整图片尺寸或生成缩略图
修改:2009-8-8
返回:True/False
参数:
   $Image   需要调整的图片(含路径)
   $Dw=450   调整时最大宽度;缩略图时的绝对宽度
   $Dh=450   调整时最大高度;缩略图时的绝对高度
   $Type=1   1,调整尺寸; 2,生成缩略图
作者:Seven(QQ:9256114)WWW.7DI.NET*/
$path='img/';//路径
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
<html><body>
<form  method="post" enctype="multipart/form-data" name="form1">
  <table>
    <tr><td>上传图片</td></tr>
    <tr><td><input type="file" name="photo" size="20" /></td></tr>
  <tr><td><input type="submit" value="上传"/></td></tr>
  </table>
  允许上传的文件类型为:<?=implode(', ',$phtypes)?></form>
<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
    if (!is_uploaded_file($_FILES["photo"][tmp_name])){
      echo "图片不存在";
      exit();
    }
    if(!is_dir('img')){//路径若不存在则创建
     mkdir('img');
    }
    $upfile=$_FILES["photo"]; 
    $pinfo=pathinfo($upfile["name"]);
    $name=$pinfo['basename'];//文件名
    $tmp_name=$upfile["tmp_name"];
    $file_type=$pinfo['extension'];//获得文件类型
    $showphpath=$path.$name;
   
    if(in_array($upfile["type"],$phtypes)){
      echo "文件类型不符！";
      exit();
     }
   if(move_uploaded_file($tmp_name,$path.$name)){
    echo "成功！";
 Img($showphpath,110,110,1);
   }
   echo "<img src=\"".$showphpath."\"  />";
 }
?>
</body>
</html>