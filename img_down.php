<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title>ָ��_css�ļ�����ͼƬ���� for_php��</title>

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
 * ���ĵ���һ���У� ����ȱ.�Z�� ��д��
 */



if($_POST['submit'])
{
ignore_user_abort(); //��ʹClient�Ͽ�(��ص������)��PHP�ű�Ҳ���Լ���ִ��.
set_time_limit(0);	//ִ��ʱ��Ϊ�����ƣ�phpĬ�ϵ�ִ��ʱ����30�룬ͨ��set_time_limit(0)�����ó��������Ƶ�ִ����ȥ

//����css�ļ�
if(empty($_FILES['css_file']['name']))
{
$css_file = $_POST['css_file'];
}else{
$css_file = $_FILES['css_file']['tmp_name'];
$css_name = $_FILES['css_file']['name'];
if(is_file($css_file)){echo $css_name."<font color=green>�ļ����ڣ����ڶ�ȡ...</font><br />";}else{echo "ָ�����ļ��޷���ȡ...ִֹͣ��(<font color=red>С��ʾ������phpû�������ϴ��������뿪�������ԣ������ֱ��ʹ��Զ�̵�ַ(���뱾��·��Ҳ����)...)<a href='javascript:history.go(-1)'>������ҳ</a>";exit();}
}

$css_name=!empty($css_name)?$css_name:$css_file;	//�ж�css����

if(empty($css_file)){echo "<font color=red>����û��ָ��css�ļ�...</font>����ͼƬ������ֹ!<br /><font color=green>(����Ǳ������ѡ��css�ļ������������Ŀ¼��...�����Ե�ַָ��,��ȷ��css����)</font><a href='javascript:history.go(-1)'>������ҳ</a>";exit();}

$url_path= $_POST['url_path'] or '';	//���css����ı���ͼƬ·������Եģ�����дͼƬ�ļ��е���ַ·��
$down_dir= $_POST['down_dir'];	//����Ŀ¼




//·������
function img_path($img){
	global $url_path;
	if(preg_match("/.*background:url\s?\(\'?\"?.*\.(gif|jpg|png)/Ui",$img)){
	$img=preg_replace("/.*url\s?\(\'?\"?/i","",$img);
	$img=preg_replace("/\'?\"?\).*/","",$img);
	$img=str_replace("\n","",$img);
	return $url_path.$img;
	}

}


//ͼƬ���Ƶ�����
function img_name($img){

	$img=preg_replace("/.*\//","",$img);
	return $img;

}


$img_file=@file($css_file);	//��ȡcss�ļ�
if(is_array($img_file) && !empty($img_file)){echo $css_name."<font color=green>�ļ������ɹ�,������һ������...</font><br /><br />";}else{echo "<font color=red>�ļ�����ʧ��,ֹͣ�²�����...</font><a href='javascript:history.go(-1)'>������ҳ</a>";exit();}

//sort($img_names);//��������

$url_img=array();	//����һ��Ҫ����ͼƬ������

foreach ($img_file as $line=>$img)
{
	if(img_path($img)){
	$url_img[]=img_path($img);
	$img_names[]=img_name(img_path($img));	//ȡͼƬ���ƣ�������
	}

}

//print_r($url_img);	//�����css����ȡ��ͼƬ��ַ

//print_r($img_names);	//ȡ������ͼƬ����


echo "<div class='zj_prompt'>";
echo "��ѡ���css�ļ��ǣ�<font color=green>".$css_name."</font>";
echo "<br>";

if(empty($url_path)){
echo "background:url(����·��)��<font color=green>��(û��ѡ��)</font>";
}else{
echo "background:url(����·��)��<font color=green>".$url_path."</font>";
}
echo "<br>";


if(empty($down_dir)){

$down_dir=str_replace('\\','/',dirname(__FILE__).'/');
echo "����Ŀ¼(��Ŀ¼):<a href=?scan_dir=".$down_dir." target='_blank'><span style='color:#369;text-decoration:underline'>".$down_dir."</span></a>";

}else{
$down_dir=str_replace('\\','/',dirname(__FILE__).'/'.$down_dir.'/');
if(!is_dir($down_dir)){$dir_ok=@mkdir($down_dir);if(!$dir_ok){echo "����Ŀ¼ָ���ɹ�,����ʧ��...(<font color=red>��ȷ��Ŀ¼��д��Ȩ�ޡ�</font>)<a href='javascript:history.go(-1)'>������ҳ</a></div>";exit();}
}

echo "����Ŀ¼:<a href=?scan_dir=".$down_dir." target='_blank'><span style='color:#369;text-decoration:underline'>".$down_dir."</span></a>";
}
echo "</div>";


$len=count($url_img);	//ȡ�ж�����ͼƬ
echo "<div class='zj_tit'><font color=red>".$css_name."</font>�����б���ͼƬ<font color=green>$len</font>��</div>";

//�ж��Ƿ�ѡ��Ϊ�Զ�
if($_POST['img_auto']!='img_auto'){
foreach($url_img as $k=>$v){
echo ($k+1)."��<a href='".$v."'target='_blank'>".$v."</a>(<font color=green>��ȡ�ɹ�</font>)<br />";
}
echo "<br /><div class='zj_prompt' style='text-align:center'><font color='#336699'>- - - - - - - - - - - - - - - - - - -�ļ��������- - - - - - - - - - - - - - - - - - -</font><br /><a href='javascript:location.reload()' style='text-decoration:underline'>ˢ�¸�ҳ</a>&nbsp;&nbsp;<a href='javascript:history.go(-1)' style='text-decoration:underline'>������ҳ</a></div>";
exit();
}


$down_img=array();	//����һ��img����

for($i=0;$i<$len;$i++)
{

if($down_img[$i]=@file("$url_img[$i]")){

echo ($i+1)."��<a href='".$url_img[$i]."'target='_blank'>".$url_img[$i]."</a>(<font color=green>��ȡ�ɹ�</font>)";
}else{

echo ($i+1)."��<a href='".$url_img[$i]."'target='_blank'>".$url_img[$i]."</a>(<font color=red>��ȡʧ��</font>)";

}

$downs_img=null;	//��ʼ��ͼƬ
for ($n=0;$n<count($down_img[$i]);$n++)
{
	$downs_img.=$down_img[$i][$n];

}

	if(file_exists($down_dir.$img_names[$i])){echo "(<font color='#336699'>ͼƬ�ظ�...</font>)<br><br>";continue;}//�ж�ͼƬ�Ƿ����
	$file_link=@fopen($down_dir.$img_names[$i],"xb");	//��������ڣ��½�һ��ͼƬ
	/*
	
	'r' - ֻ���򿪣�ָ��ָ���ļ���ʼ�� 

	'r+' - Ϊ��д�򿪣�ָ��ָ���ļ���ʼ�� 

	'w' - ֻд�򿪣�ָ��ָ���ļ���ʼ���ļ���С���㡣����ļ������ڣ����½��� 

	'w+' - Ϊ��д�򿪣�ָ��ָ���ļ���ʼ���ļ���С���㡣����ļ������ڣ����½��� 

	'a' - Ϊ׷�Ӵ򿪣�ָ��ָ���ļ���β������ļ������ڣ������½��� 

	'a+' - Ϊ��д�򿪣�ָ��ָ���ļ���β������ļ������ڣ������½��� 

	ע��: mode ���԰�����ĸ 'b'�����������ϵͳ���ֶ����ƺ��ı��ļ������á� (i.e. Windows. ����Unix�������õ�)���������Ҫ�����������ԡ� 

	���������include_path�������ļ��������ʹ�ÿ�ѡ�ĵ�������������������Ϊ"1"��
	
	*/

	@flock($file_link,LOCK_EX);	//��������
	/*
	LOCK_SH����ʾ����������PHP4.0.1ǰΪ1��
	LOCK_EX����ʾ��ռ������PHP4.0.1ǰΪ2��
	LOCK_UN���ͷ������������ǹ����Ƕ�ռ��PHP4.0.1ǰΪ3��
	LOCK_NB����ϣ��������ʱ���ֶ���ʱ���øò���PHP4.0.1ǰΪ4��
	*/
	$down_ok=@fwrite($file_link,$downs_img);	//д��ͼƬ��
	if($down_ok){
		echo "(<font color=green>���سɹ�</font>)<br><br>";
	}
	else
	{
		echo "(<font color=red>����ʧ��</font>)<br><br>";
	}
	@flock($file_link,LOCK_UN);//�������
	@fclose($file_link);	//�ر����ͼƬ




}//����for�����



if($i>=$len){echo "<br /><div class='zj_prompt' style='text-align:center'><font color='#336699'>- - - - - - - - - - - - - - - - - - -�����������- - - - - - - - - - - - - - - - - - -</font><br /><a href='javascript:location.reload()' style='text-decoration:underline'>ˢ�¸�ҳ</a>&nbsp;&nbsp;<a href='javascript:history.go(-1)' style='text-decoration:underline'>������ҳ</a></div>";exit();}

}//�ύ��ť

if($_GET['scan_dir']){
	// ʹ�ñ�����Ŀ¼�Ľṹ
    print("<TABLE>");
    // ��������ͷ
    print("<TR>");
    print("<TH><font color='red'>�ļ���</font></TH>");
    print("<TH><font color='red'>�ļ��Ĵ�С</font></TH>");
    print("</TR>");
$dir_link=@opendir($_GET['scan_dir']);

while($entryName=@readdir($dir_link))
	{
	print("<TR>");
        print("<TD>$entryName</TD>");
        print("<TD ALIGN=\"right\">");
   $size=@filesize($_GET['scan_dir'].$entryName);
   
   if($size <1024)                     
          {$FileSize = (string)$size."�ֽ�";}
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
	@closedir($dir_link);  // �ر�Ŀ¼
    print("</TABLE>");

	exit();
}//��Ŀ¼

?>





<form name="zj_form" enctype="multipart/form-data" method="post" action="">
  <label><font color=red>��ѡ��css�ļ���</font></label>
    ����ѡ��:<input type="file" name="css_file" id="css_file" /> ����Զ�� <input type="text" name="css_file" id="css_file" />(<font color=green>��http://www.qq.com</font>)
    <br />
    <label class='zj_ts'><font color=red>·����ʾ:</font><br>��css�ļ�,�ҵ�background:url(������Ĵ���->�Ƿ�Ϊ����·����)<br><font color=green>����·��</font>��:http://www.xx.com/img/zj.png<br><font color=green>���·��</font>��:img/zj.png(<font color=red>��Ҫ��дhttp://www.xx.com/</font>)<br />
	����·��:&nbsp;<input type="text" name="url_path" id="css_file" />(<font color=green>Ĭ��Ϊ�գ�����·���������</font>)<br />
	</label><br />
	����Ŀ¼:&nbsp;&nbsp;<input type="text" name="down_dir" /><font color=green>(���գ�Ĭ��Ϊ��ǰĿ¼)<font><br />
	<input type="radio" name='img_auto'  value='img_auto'  id='img_auto' checked/>�Զ�<label for='img_auto'>(<font color=green>�����Զ�����ͼƬ</font>)</label><br />	
	<input type="radio" name='img_auto' value='false'  id='img_noauto'/>�ֶ�<label for='img_noauto'>(<font color=green>ֻ�����ļ�����ʾ���</font>)</label>
  <br /><br />

    <input type="submit" name="submit" value="��ʼִ��" />
	<input type="reset" name="reset" value="�����趨" />
	<input type="button" onclick="location.reload(true)" value="ҳ��ˢ��" />
</form>

</body>
</html>