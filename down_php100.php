
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����php100 ��Ƶ version1.0- by qq7730312 Ư����ָ��</title>
<style type='text/css'>
*{margin:0;padding:0;}
.this_list{margin:0 auto;margin-top:10px;width:80%;color:#f00;font-size:18px;font-weight:bold;}
.info{text-align:left;font-weight:none;border:1px solid #ccc;background:#eee;margin-top:4px;width:80%;overflow:hidden;;margin-left:auto;margin-right:auto;padding:4px 10px;line-height:180%;font-size:12px;}
ul li{ list-style-type:decimal; }
</style>
</head>


<?php
	error_reporting(0);//E_ALL��ʾ������Ϣ ȫ��
	set_time_limit(0); //����ʱ
	//ini_set('memory_limit','1G'); //����ڴ�������1G
	header("Content-type: text/html; charset=gb2312");
	
	
	//ƥ���б�ҳ
	$pre_url='http://www.php100.com/html/shipinjiaocheng/PHP100shipinjiaocheng/';
	$url_arr = 'index,2,3,4,5,6'; 
	$url_arr = explode(',',$url_arr);
	foreach($url_arr as $key=>$val)
	{
		$url_arr[$key] =$pre_url.$val.'.html'; //ȡ���б�ĵ�ַ;
	}
	//print_r($url_arr);
	
    krsort($url_arr); //����
	
	
	//������ʽ
	$list_reg = '/<div id=\"left\">(.*?)<div class=\"page\">/is'; //�б� 
	$list_rega = '/<a href=\"([^\#]*)?\"/isU'; //a������
	
	$show_title = '/<h2>(.*?)<\/h2>/'; //��������
	$show_size_reg = '/�����С��<\/small><span>(.*?)<\/span>/is'; //�����С����
	$show_date_reg = '/����ʱ�䣺<\/small><span>(.*?)<\/span>/is'; //��������
	$show_downurl= '/<ul class=\"downurllist\">(.*?)<\/ul>/is';//���ص�ַ���� ul li;
	
	
	
	//��ȡ��ҳԴ��
	function html($url)
	{
		return file_get_contents($url); //���ض�����urlԴ��  param string
	}

	
	/* 
		������ 
		param $reg ���� ereg
		param $data Դ���� string
		param ȡ�÷��ص����鼸���� $html[1];
	*/
	function zz($reg,$data,$n='')
	{
		if(preg_match($reg,$data,$html))
		{
		
		if($n=='')
			{
				return $html;
			}else{
				return $html[$n];
			}
		}else{
			return '������ʽ:'.$reg.'<br /><font color=red>û��ƥ�䵽����</font><br />�������ǣ�'.__LINE__;
		}
	
	}
	/* 
		������ȫ��ƥ�� 
		param $reg ���� ereg
		param $data Դ���� string
		param ȡ�÷��ص����鼸���� $html[1];
	*/
	function zz_all($reg,$data,$n='')
	{
	
		if(preg_match_all($reg,$data,$html))
		{
			
			if($n=='')
			{
				return $html;
			}else{
				return $html[$n];
			}
		}else{
			return '������ʽ:'.$reg.'<br /><font color=red>ȫ������û��ƥ�䵽����</font><br />�������ǣ�'.__LINE__;
		}
	}
	
	
	
	
	//���������̿�����
	foreach($url_arr as $val)
	{
		//����������� 
		ob_start(); //����������� 
		ob_end_flush(); 
		ob_implicit_flush(1); //������� 
		//echo str_repeat(" ",4096); //ȷ���㹻���ַ������������Linux����������ȥ��������
			
		echo '<div class="this_list">��ǰ�ɼ��б����ַ��<a target="_blank" href="'.$val.'">'.$val.'</a></div>';
		$rs = html($val); //ȡ���б��Դ��
		//��ȡ�б��ul a
		$list = zz($list_reg,$rs,1); //�б�
		$lista = zz_all($list_rega,$list,1); //ȡ�б�����
		//print_r($lista);
		if(!is_array($lista))
		{
			exit('�б������δȡ�ɹ��� �޷������������ļ�');
		}
		
		krsort($lista);
		//ȡ����ҳ
		foreach($lista as $k=>$v)
		{
			$show_datas = html($v);
			
			//ȡ����
			$title = zz($show_title,$show_datas,1);	
			
			//ȡ�����С
			$size = zz($show_size_reg,$show_datas,1);
			
			//ȡ��������
			$pubdate = zz($show_date_reg,$show_datas,1);
			
			//ȡ���ص�ַ
			$downurl = zz($show_downurl,$show_datas,1);
			$downurl = str_replace('/index.php?','http://www.php100.com/index.php?',$downurl);
			//print_r($downurl);
			//exit;
			
			

			echo '<div class="info">';
			echo '��ǰ�ɼ���ַ��'.$v . '&nbsp;&nbsp;<a href="'.$v.'" target="_blank">�� ��</a><br />';
			echo $title.'<br />';
			echo '��Ƶ��С��'.$size.'<br />';
			echo '���ڣ�'.$pubdate.'<br />';
			echo '���ص�ַ��<ul>'.$downurl.'</ul><br />';
			echo "</div>";
			echo '<script> window.scrollTo(0,document.body.scrollHeight)</script>';
			
			ob_flush();
			flush();

		}
	
	
	
	}
	
	echo '����ִ����ɣ� ';
?>

