
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>下载php100 视频 version1.0- by qq7730312 漂亮灰指甲</title>
<style type='text/css'>
*{margin:0;padding:0;}
.this_list{margin:0 auto;margin-top:10px;width:80%;color:#f00;font-size:18px;font-weight:bold;}
.info{text-align:left;font-weight:none;border:1px solid #ccc;background:#eee;margin-top:4px;width:80%;overflow:hidden;;margin-left:auto;margin-right:auto;padding:4px 10px;line-height:180%;font-size:12px;}
ul li{ list-style-type:decimal; }
</style>
</head>


<?php
	error_reporting(0);//E_ALL显示错误信息 全部
	set_time_limit(0); //不超时
	//ini_set('memory_limit','1G'); //最大内存限制在1G
	header("Content-type: text/html; charset=gb2312");
	
	
	//匹配列表页
	$pre_url='http://www.php100.com/html/shipinjiaocheng/PHP100shipinjiaocheng/';
	$url_arr = 'index,2,3,4,5,6'; 
	$url_arr = explode(',',$url_arr);
	foreach($url_arr as $key=>$val)
	{
		$url_arr[$key] =$pre_url.$val.'.html'; //取到列表的地址;
	}
	//print_r($url_arr);
	
    krsort($url_arr); //倒序
	
	
	//正则表达式
	$list_reg = '/<div id=\"left\">(.*?)<div class=\"page\">/is'; //列表 
	$list_rega = '/<a href=\"([^\#]*)?\"/isU'; //a的正则
	
	$show_title = '/<h2>(.*?)<\/h2>/'; //标题正则
	$show_size_reg = '/软件大小：<\/small><span>(.*?)<\/span>/is'; //软件大小正则
	$show_date_reg = '/发布时间：<\/small><span>(.*?)<\/span>/is'; //发布日期
	$show_downurl= '/<ul class=\"downurllist\">(.*?)<\/ul>/is';//下载地址正则 ul li;
	
	
	
	//读取网页源码
	function html($url)
	{
		return file_get_contents($url); //返回读到的url源码  param string
	}

	
	/* 
		正则函数 
		param $reg 正则 ereg
		param $data 源代码 string
		param 取得返回的数组几比如 $html[1];
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
			return '正则表达式:'.$reg.'<br /><font color=red>没有匹配到内容</font><br />错误行是：'.__LINE__;
		}
	
	}
	/* 
		正则函数全局匹配 
		param $reg 正则 ereg
		param $data 源代码 string
		param 取得返回的数组几比如 $html[1];
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
			return '正则表达式:'.$reg.'<br /><font color=red>全局正则，没有匹配到内容</font><br />错误行是：'.__LINE__;
		}
	}
	
	
	
	
	//这里是流程控制了
	foreach($url_arr as $val)
	{
		//缓冲输出开启 
		ob_start(); //打开输出缓冲区 
		ob_end_flush(); 
		ob_implicit_flush(1); //立即输出 
		//echo str_repeat(" ",4096); //确保足够的字符，立即输出，Linux服务器可以去掉这个语句
			
		echo '<div class="this_list">当前采集列表的网址是<a target="_blank" href="'.$val.'">'.$val.'</a></div>';
		$rs = html($val); //取得列表的源码
		//读取列表的ul a
		$list = zz($list_reg,$rs,1); //列表
		$lista = zz_all($list_rega,$list,1); //取列表链接
		//print_r($lista);
		if(!is_array($lista))
		{
			exit('列表的链接未取成功， 无法继续！请检查文件');
		}
		
		krsort($lista);
		//取内容页
		foreach($lista as $k=>$v)
		{
			$show_datas = html($v);
			
			//取标题
			$title = zz($show_title,$show_datas,1);	
			
			//取软件大小
			$size = zz($show_size_reg,$show_datas,1);
			
			//取发布日期
			$pubdate = zz($show_date_reg,$show_datas,1);
			
			//取下载地址
			$downurl = zz($show_downurl,$show_datas,1);
			$downurl = str_replace('/index.php?','http://www.php100.com/index.php?',$downurl);
			//print_r($downurl);
			//exit;
			
			

			echo '<div class="info">';
			echo '当前采集地址是'.$v . '&nbsp;&nbsp;<a href="'.$v.'" target="_blank">√ 打开</a><br />';
			echo $title.'<br />';
			echo '视频大小：'.$size.'<br />';
			echo '日期：'.$pubdate.'<br />';
			echo '下载地址：<ul>'.$downurl.'</ul><br />';
			echo "</div>";
			echo '<script> window.scrollTo(0,document.body.scrollHeight)</script>';
			
			ob_flush();
			flush();

		}
	
	
	
	}
	
	echo '命令执行完成！ ';
?>

