
<?php
/*
----------------------------------------------------------------------
����:����ͼƬ�ߴ����������ͼ
�޸�:2009-8-8
����:True/False
����:
   $Image   ��Ҫ������ͼƬ(��·��)
   $Dw=450   ����ʱ�����;����ͼʱ�ľ��Կ��
   $Dh=450   ����ʱ���߶�;����ͼʱ�ľ��Ը߶�
   $Type=1   1,�����ߴ�; 2,��������ͼ
����:Seven(QQ:9256114)WWW.7DI.NET*/
$path='img/';//·��
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
   #�����Ҫ��������ͼ,��ԭͼ����һ�����¸�$Image��ֵ
   IF($Type!=1){
    Copy($Image,Str_Replace(".","_x.",$Image));
    $Image=Str_Replace(".","_x.",$Image);
   }
   #ȡ���ļ�������,���ݲ�ͬ�����ͽ�����ͬ�Ķ���
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
   #�������û�д����ɹ�,��˵����ͼƬ�ļ�
   IF(Empty($Img)){
    #�������������ͼ��ʱ�����,����Ҫɾ���Ѿ����Ƶ��ļ�
    IF($Type!=1){Unlink($Image);}
    Return False;
   }
   #�����ִ�е����ߴ������
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
    $nImg = ImageCreateTrueColor($width,$height);     #�½�һ�����ɫ����
    ImageCopyReSampled($nImg,$Img,0,0,0,0,$width,$height,$w,$h);#�ز�����������ͼ�񲢵�����С
    ImageJpeg ($nImg,$Image);          #��JPEG��ʽ��ͼ���������������ļ�
    Return True;
   #�����ִ����������ͼ������
   }Else{
    $w=ImagesX($Img);
    $h=ImagesY($Img);
    $width = $w;
    $height = $h;
    $nImg = ImageCreateTrueColor($Dw,$Dh);
    IF($h/$w>$Dh/$Dw){ #�߱Ƚϴ�
     $width=$Dw;
     $height=$h*$Dw/$w;
     $IntNH=$height-$Dh;
     ImageCopyReSampled($nImg, $Img, 0, -$IntNH/1.8, 0, 0, $Dw, $height, $w, $h);
    }Else{     #��Ƚϴ�
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
    <tr><td>�ϴ�ͼƬ</td></tr>
    <tr><td><input type="file" name="photo" size="20" /></td></tr>
  <tr><td><input type="submit" value="�ϴ�"/></td></tr>
  </table>
  �����ϴ����ļ�����Ϊ:<?=implode(', ',$phtypes)?></form>
<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
    if (!is_uploaded_file($_FILES["photo"][tmp_name])){
      echo "ͼƬ������";
      exit();
    }
    if(!is_dir('img')){//·�����������򴴽�
     mkdir('img');
    }
    $upfile=$_FILES["photo"]; 
    $pinfo=pathinfo($upfile["name"]);
    $name=$pinfo['basename'];//�ļ���
    $tmp_name=$upfile["tmp_name"];
    $file_type=$pinfo['extension'];//����ļ�����
    $showphpath=$path.$name;
   
    if(in_array($upfile["type"],$phtypes)){
      echo "�ļ����Ͳ�����";
      exit();
     }
   if(move_uploaded_file($tmp_name,$path.$name)){
    echo "�ɹ���";
 Img($showphpath,110,110,1);
   }
   echo "<img src=\"".$showphpath."\"  />";
 }
?>
</body>
</html>