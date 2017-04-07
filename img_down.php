<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title>指甲_css文件背景图片下载 for_php版</title>

<style type="text/css">
*{margin:0;padding:0;}
a:link,a:visited{color:#000;font-size:14px;text-decoration:none;}
a:hover,a:active{color:#f00;text-decoration:underline;}
body{font-size:14px;margin:20px 40px;}
font{font-size:12px;}
.zj_prompt{
	border:1px solid #ccc;padding:6px;
	margin-bottom:12px;
	line-height:22px;
}
.zj_tit{
	background:#f5f5f5;border:1px solid #ccc;height:24px;line-height:24px;font-size:14px;font-weight:bold;margin-bottom:20px;padding:6px;;
}
.zj_ts{
	border:1px solid #ddd;
	width:500px;
	padding:6px;
	margin-top:8px;
	display:block;
	background:#eee;
}

table{ border-collapse:collapse;width:80%}
td{ border:#ccc solid 1px; padding:4px; }
</style>
</head>
<body>

<?php
/*
 * 此文档由一个叫： 、残缺.諾言 所写。
 */



if($_POST['submit'])
{
ignore_user_abort(); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
set_time_limit(0);	//执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去

//引入css文件
if(empty($_FILES['css_file']['name']))
{
$css_file = $_POST['css_file'];
}else{
$css_file = $_FILES['css_file']['tmp_name'];
$css_name = $_FILES['css_file']['name'];
if(is_file($css_file)){echo $css_name."<font color=green>文件存在，正在读取...</font><br />";}else{echo "指定的文件无法读取...停止执行(<font color=red>小提示：可能php没有启用上传功功能请开户后重试，你可以直接使用远程地址(输入本地路径也可以)...)<a href='javascript:history.go(-1)'>返回首页</a>";exit();}
}

$css_name=!empty($css_name)?$css_name:$css_file;	//判断css名字

if(empty($css_file)){echo "<font color=red>由于没有指定css文件...</font>所以图片下载终止!<br /><font color=green>(如果是本地浏览选择css文件，请放在虚拟目录中...，绝对地址指定,请确认css存在)</font><a href='javascript:history.go(-1)'>返回首页</a>";exit();}

$url_path= $_POST['url_path'] or '';	//如果css里面的背景图片路径是相对的，请填写图片文件夹的网址路径
$down_dir= $_POST['down_dir'];	//下载目录




//路径正则
function img_path($img){
	global $url_path;
	if(preg_match("/.*background:url\s?\(\'?\"?.*\.(gif|jpg|png)/Ui",$img)){
	$img=preg_replace("/.*url\s?\(\'?\"?/i","",$img);
	$img=preg_replace("/\'?\"?\).*/","",$img);
	$img=str_replace("\n","",$img);
	return $url_path.$img;
	}

}


//图片名称的正则
function img_name($img){

	$img=preg_replace("/.*\//","",$img);
	return $img;

}


$img_file=@file($css_file);	//读取css文件
if(is_array($img_file) && !empty($img_file)){echo $css_name."<font color=green>文件分析成功,进行下一步操作...</font><br /><br />";}else{echo "<font color=red>文件分析失败,停止下步操作...</font><a href='javascript:history.go(-1)'>返回首页</a>";exit();}

//sort($img_names);//排序数组

$url_img=array();	//建立一个要下载图片的数组

foreach ($img_file as $line=>$img)
{
	if(img_path($img)){
	$url_img[]=img_path($img);
	$img_names[]=img_name(img_path($img));	//取图片名称，下载用
	}

}

//print_r($url_img);	//正则从css里面取的图片地址

//print_r($img_names);	//取出来的图片名字


echo "<div class='zj_prompt'>";
echo "你选择的css文件是：<font color=green>".$css_name."</font>";
echo "<br>";

if(empty($url_path)){
echo "background:url(绝对路径)：<font color=green>空(没有选择)</font>";
}else{
echo "background:url(绝对路径)：<font color=green>".$url_path."</font>";
}
echo "<br>";


if(empty($down_dir)){

$down_dir=str_replace('\\','/',dirname(__FILE__).'/');
echo "下载目录(根目录):<a href=?scan_dir=".$down_dir." target='_blank'><span style='color:#369;text-decoration:underline'>".$down_dir."</span></a>";

}else{
$down_dir=str_replace('\\','/',dirname(__FILE__).'/'.$down_dir.'/');
if(!is_dir($down_dir)){$dir_ok=@mkdir($down_dir);if(!$dir_ok){echo "下载目录指定成功,建立失败...(<font color=red>请确认目录有写入权限。</font>)<a href='javascript:history.go(-1)'>返回首页</a></div>";exit();}
}

echo "下载目录:<a href=?scan_dir=".$down_dir." target='_blank'><span style='color:#369;text-decoration:underline'>".$down_dir."</span></a>";
}
echo "</div>";


$len=count($url_img);	//取有多少张图片
echo "<div class='zj_tit'><font color=red>".$css_name."</font>，共有背景图片<font color=green>$len</font>张</div>";

//判断是否选择为自动
if($_POST['img_auto']!='img_auto'){
foreach($url_img as $k=>$v){
echo ($k+1)."、<a href='".$v."'target='_blank'>".$v."</a>(<font color=green>读取成功</font>)<br />";
}
echo "<br /><div class='zj_prompt' style='text-align:center'><font color='#336699'>- - - - - - - - - - - - - - - - - - -文件分析完毕- - - - - - - - - - - - - - - - - - -</font><br /><a href='javascript:location.reload()' style='text-decoration:underline'>刷新该页</a>&nbsp;&nbsp;<a href='javascript:history.go(-1)' style='text-decoration:underline'>返回首页</a></div>";
exit();
}


$down_img=array();	//建立一个img数组

for($i=0;$i<$len;$i++)
{

if($down_img[$i]=@file("$url_img[$i]")){

echo ($i+1)."、<a href='".$url_img[$i]."'target='_blank'>".$url_img[$i]."</a>(<font color=green>读取成功</font>)";
}else{

echo ($i+1)."、<a href='".$url_img[$i]."'target='_blank'>".$url_img[$i]."</a>(<font color=red>读取失败</font>)";

}

$downs_img=null;	//初始化图片
for ($n=0;$n<count($down_img[$i]);$n++)
{
	$downs_img.=$down_img[$i][$n];

}

	if(file_exists($down_dir.$img_names[$i])){echo "(<font color='#336699'>图片重复...</font>)<br><br>";continue;}//判断图片是否存在
	$file_link=@fopen($down_dir.$img_names[$i],"xb");	//如果不存在，新建一个图片
	/*
	
	'r' - 只读打开，指针指向文件开始； 

	'r+' - 为读写打开，指针指向文件开始； 

	'w' - 只写打开，指针指向文件开始，文件大小清零。如果文件不存在，则新建； 

	'w+' - 为读写打开，指针指向文件开始，文件大小清零。如果文件不存在，则新建； 

	'a' - 为追加打开，指针指向文件结尾。如果文件不存在，尝试新建； 

	'a+' - 为读写打开，指针指向文件结尾。如果文件不存在，尝试新建。 

	注意: mode 可以包含字母 'b'。这仅仅在在系统区分二进制和文本文件才有用。 (i.e. Windows. 它在Unix中是无用的)。如果不需要，它将被忽略。 

	如果你想在include_path中搜索文件，你可以使用可选的第三个参数并把它设置为"1"。
	
	*/

	@flock($file_link,LOCK_EX);	//锁定链接
	/*
	LOCK_SH：表示共享锁定，PHP4.0.1前为1；
	LOCK_EX：表示独占锁定，PHP4.0.1前为2；
	LOCK_UN：释放锁定，无论是共享还是独占，PHP4.0.1前为3；
	LOCK_NB：不希望在锁定时出现堵塞时设置该参数PHP4.0.1前为4；
	*/
	$down_ok=@fwrite($file_link,$downs_img);	//写入图片了
	if($down_ok){
		echo "(<font color=green>下载成功</font>)<br><br>";
	}
	else
	{
		echo "(<font color=red>下载失败</font>)<br><br>";
	}
	@flock($file_link,LOCK_UN);//解除锁定
	@fclose($file_link);	//关闭这个图片




}//最大的for结束喽



if($i>=$len){echo "<br /><div class='zj_prompt' style='text-align:center'><font color='#336699'>- - - - - - - - - - - - - - - - - - -程序运行完毕- - - - - - - - - - - - - - - - - - -</font><br /><a href='javascript:location.reload()' style='text-decoration:underline'>刷新该页</a>&nbsp;&nbsp;<a href='javascript:history.go(-1)' style='text-decoration:underline'>返回首页</a></div>";exit();}

}//提交按钮

if($_GET['scan_dir']){
	// 使用表格浏览目录的结构
    print("<TABLE>");
    // 创建表格的头
    print("<TR>");
    print("<TH><font color='red'>文件名</font></TH>");
    print("<TH><font color='red'>文件的大小</font></TH>");
    print("</TR>");
$dir_link=@opendir($_GET['scan_dir']);

while($entryName=@readdir($dir_link))
	{
	print("<TR>");
        print("<TD>$entryName</TD>");
        print("<TD ALIGN=\"right\">");
   $size=@filesize($_GET['scan_dir'].$entryName);
   
   if($size <1024)                     
          {$FileSize = (string)$size."字节";}
        elseif($size <(1024 * 1024))
          {
            $FileSize = number_format((double)($size / 1024), 2)."KB";
          }
        else
           {
              $FileSize = number_format((double)($size/(1024*1024)),2)."MB";
           }
        print($FileSize);
        print("</TD>");
        print("</TR>");

	}
	@closedir($dir_link);  // 关闭目录
    print("</TABLE>");

	exit();
}//打开目录

?>





<form name="zj_form" enctype="multipart/form-data" method="post" action="">
  <label><font color=red>请选择css文件：</font></label>
    本地选择:<input type="file" name="css_file" id="css_file" /> 或者远程 <input type="text" name="css_file" id="css_file" />(<font color=green>例http://www.qq.com</font>)
    <br />
    <label class='zj_ts'><font color=red>路径提示:</font><br>打开css文件,找到background:url(“这里的代码->是否为绝对路径”)<br><font color=green>绝对路径</font>如:http://www.xx.com/img/zj.png<br><font color=green>相对路径</font>如:img/zj.png(<font color=red>需要填写http://www.xx.com/</font>)<br />
	绝对路径:&nbsp;<input type="text" name="url_path" id="css_file" />(<font color=green>默认为空，绝对路径不必理会</font>)<br />
	</label><br />
	下载目录:&nbsp;&nbsp;<input type="text" name="down_dir" /><font color=green>(留空，默认为当前目录)<font><br />
	<input type="radio" name='img_auto'  value='img_auto'  id='img_auto' checked/>自动<label for='img_auto'>(<font color=green>程序自动下载图片</font>)</label><br />	
	<input type="radio" name='img_auto' value='false'  id='img_noauto'/>手动<label for='img_noauto'>(<font color=green>只分析文件，显示结果</font>)</label>
  <br /><br />

    <input type="submit" name="submit" value="开始执行" />
	<input type="reset" name="reset" value="重新设定" />
	<input type="button" onclick="location.reload(true)" value="页面刷新" />
</form>

</body>
</html>