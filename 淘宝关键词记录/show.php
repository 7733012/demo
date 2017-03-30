<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	header("content-type:text/html;charset=utf-8");
	ini_set('memory_limit','-1');
	//检测权限
	function check_admin()
	{
		
		if (!session_id()){session_start();}
		$u_session = $_SESSION['zj_user_login_show_admin'];
		if($u_session == '21232f297a57a5a743894a0e4a801fc3')
		{
			return true;
		}else if($_POST['login'])
		{
			$user_name = $_POST['user_name'];
			$user_pass = $_POST['user_pass'];
			if(md5($user_pass) !== '8bc9b67d65ffa684482a3ddcf79c1fed' && md5(user_name) !== '21232f297a57a5a743894a0e4a801fc3')
			{
				echo '^_^，没有权限 请绕路而行..';
			    exit;//如果没有这个cookie值就退出
			}else{
				if (!session_id()){ session_start();}
				$_SESSION['zj_user_login_show_admin']='21232f297a57a5a743894a0e4a801fc3';
			}	
		}else{
			echo '^_^，没有权限 请绕路而行..';
			exit;//如果没有这个cookie值就退出
		}

	}

	check_admin();

	
	date_default_timezone_set('Asia/Shanghai');

	$d=isset($_GET['date']) ? $_GET['date'] :date('Y-m-d');	
	$zjArr  = explode('-', $d);
	$zjdir = dirname(__FILE__).DIRECTORY_SEPARATOR.'zjlogs'.DIRECTORY_SEPARATOR.$zjArr[0].DIRECTORY_SEPARATOR.$zjArr[1].DIRECTORY_SEPARATOR.$zjArr[2];
	
	$zjdirlog =$zjdir.DIRECTORY_SEPARATOR.'allLog'.DIRECTORY_SEPARATOR;//所有日志
	$zj_hour =$zjdir.DIRECTORY_SEPARATOR.'zjhour'.DIRECTORY_SEPARATOR;//24小时 数据

	$allLog_file = $zjdirlog.'allLog.php';//所有日志
	$successLog_file = $zjdirlog.'successLog.php';//成功日志
	$failLog_file = $zjdirlog.'failLog.php';//失败日志
	$allNum_file = $zjdir.DIRECTORY_SEPARATOR.'allNum.php';//总数	
	$successNum_file = $zjdir.DIRECTORY_SEPARATOR.'successNum.php';//成功
	$failNum_file = $zjdir.DIRECTORY_SEPARATOR.'failNum.php ';//失败
	//数组方式 1所有日志，2成功日志,3失败日志,4总数,5成功数,6失败数
	$file_arr = array(1 => $allLog_file,2 => $successLog_file, 3 =>$failLog_file,4 => $allNum_file,5 => $successNum_file,6 => $failNum_file);


	function zj_read($zj_num,$show_info=0)
	{
		set_time_limit(0);
		global $file_arr;
		if(!defined('ZJ_TAOBAO'))
		{
			define('ZJ_TAOBAO','lg998');//没有这句权限 取不到值
		}
		$fname = $file_arr[$zj_num];
		$zj = @file_get_contents($fname);

		//如果是下载日志
		if($show_info==1)
		{
			$zj = preg_replace('/<\?php\n.*\n\?>/','',$zj);
			return $zj;
			exit;			
		}
		
		$arr = array(
			array('/\r/','/\d{2}:\d{2}:\d{2}/','/<\?php\n.*\n\?>/','/库中存在成功/','/入库跳转成功/','/没有淘点金链接跳过/','/\s\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s/','/商品入库失败/','/没有url参数访问/'),
			array('<br />','<span class="a_date">\\0</span>','','<span class="on_db">\\0</span>','<span class="in_db">\\0</span>','<span class="api_no">\\0</span>','<span class="api_ip">\\0</span>','<span class="db_no">\\0</span>','<span class="no_url">\\0</span>'),
		);		
		if(isset($_GET['show_t']))
		{
			echo '<span style="color:#6F0">^_^ 超级管理员：admin  <a href="'.$_SERVER["REQUEST_URI"].'&save=yes">下载</a></span></span><br />';
			echo '<style type="text/css">';
			echo '*{margin:0;padding:0;}';
			echo '.a_date{color:green;text-decoration:underline;}';
			echo '.on_db{color:#F60}';
			echo '.in_db{color:#0C0}';
			echo '.api_no{color:#F00}';
			echo '.api_ip{color:#00A2A2}';
			echo '.db_no{color:#FF0080}';
			echo '.no_url{color:#03F}';
			echo 'body{line-height:200%;font-size:14px;background:#000;color:#eee;padding-left:20px;}';
			echo 'a{color:#0CC;text-decoration:underline;}';
			echo '</style>';			
		}
		
		

		$zj = preg_replace($arr[0],$arr[1],$zj);
		//$zj = iconv('gbk', 'utf-8', $zj);
		
		echo $zj;			
		
	
	}


	//$name 4,5,6 代表全部成功失败 $h 0-23代表小时
	function zj_r_h($name)
	{
		global $zj_hour;
				
		$zj_h_arr = array(4=>'a_',5=>'b_',6=>'c_');			
		
		$zj_name = $zj_h_arr[$name];
		$zj='';
		$p_reg= '/<\?php\n.*\n\?>/';
		for ($i=0; $i < 24; $i++) { 
			$zj_f_name =$zj_name .$i;
			$zj_h_file = $zj_hour.$zj_f_name.'.php';
			//$zj_h_file = str_replace('\\', '/', $zj_h_file);
			if(file_exists($zj_h_file))
			{
				$zj.= file_get_contents($zj_h_file);
				if(!$zj)
				{
					$zj.='0,';
				}else{
					$zj.=',';
				}
			}else{
				$zj.= '0,';
			}		

		}
		$zj=preg_replace($p_reg, '', $zj);
		return rtrim($zj,',');

	}


	//退出
	if(isset($_GET['exit']))
	{

		echo '<style type="text/css">';
		echo '*{margin:0;padding:0;}';
		echo 'body{line-height:200%;font-size:14px;background:#000;color:#0C0;padding-left:20px;}';
		echo 'a{color:#0CC;text-decoration:underline;text-align:center;}';
		echo '.alert{}';
		echo '</style>';			
		if(session_destroy())
		{
			echo '<div class="alert">退出成功 ^_^ </div>';
		}else{
			echo '<div class="alert">退出失败 - - </div>';
		}
		exit;
	}

	//下载日志
	if(isset($_GET['save']))
	{	
		$urls = $_SERVER["REQUEST_URI"];
		if(strpos($urls,'alllog'))
		{
			$logid = 1;//全部日志
		}elseif(strpos($urls,'successlog'))
		{
			$logid = 2;//成功日志
		}elseif(strpos($urls,'errorlog')){
			$logid = 3;//失败日志	
		}
		$tit_arr=array(1=>"全部日志",2=>"成功日志",3=>"失败日志");
		$downstr = zj_read($logid,1);;//内容
		
		$filename = $tit_arr[$logid].$d;//文档名字
		header("content-type:text/html;charset=utf-8");
		header("Content-type: text/plain");
		header("Accept-Ranges: bytes");
		header("Content-Disposition: attachment; filename=".$filename);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header("Pragma: no-cache" );
		header("Expires: 0" );
		exit($downstr);
		
	}
	//查看失败的日志的 
	if(isset($_GET['errorlog']))
	{
		header("Content-type:text/html;charset=utf-8");
		zj_read(3);
		exit;
	}

	//查看成功的日志
	if(isset($_GET['successlog']))
	{
		header("content-type:text/html;charset=utf-8");		
		zj_read(2);
		exit;
	}
	//查看所有的日志
	if(isset($_GET['alllog']))
	{
		header("content-type:text/html;charset=utf-8");		
		zj_read(1);
		exit;
	}
	//检测环境
	if(isset($_GET['zjcheck']))
	{
		
$zjstr=<<<EOD
		<style type="text/css">
		*{margin:0;padding:0;}
		body{line-height:200%;font-size:14px;background:#000;color:red;padding-left:20px;}
		a{color:#6F0;text-decoration:none;}
		.zhijiabox{background:#000;padding:15px 10px;line-height:24px;}
		.ok_yes{color:#6F0;}
		.ok_no{color:red;}
		</style>
EOD;

		echo $zjstr;
		echo '<div class="zhijiabox">';		
		include 'zjlog.php';
		if(!zj_mkdir($zjdirlog))
		{
			//自动创建目录，当存在时不理会，返回真
			echo  '<span class="ok_no">zjlogs 创建目录及子目录失败！ㄨ<br /></span>';
		}else{
			echo  '<span class="ok_yes">zjlogs 可以创建目录及子目录√<br /></span>';
		}
		if(!zj_mkdir($zj_hour))
		{
			//自动创建目录，当存在时不理会，返回真
			echo  '<span class="ok_no">zj_hour 创建目录及子目录失败！ㄨ<br /></span>';
		}else{
			echo  '<span class="ok_yes">zj_hour 可以创建目录及子目录√<br /></span>';
		}
		
		//echo is_writable($zjdirlog) ? '<span class="ok_yes">zjlogs可写√</span><br />' : "<span class='ok_no'>zjlogs不可写入ㄨ</span><br />";
		//echo is_writable($zj_hour) ? '<span class="ok_yes">zj_hour可写√</span><br />' : "<span class='ok_no'>zj_hour不可写入ㄨ</span><br />";
		$keyurl = str_replace('\\','/',dirname(__FILE__)).'/key/key.txt';
		$keypurl = str_replace('\\','/',dirname(__FILE__)).'/key/key.txt';
		echo is_writable($keypurl) ? '<span class="ok_yes">key/key.php可写√</span><br />' : "<span class='ok_no'>key/key.php不可写入ㄨ</span><br />";
		echo is_writable($keyurl) ? '<span class="ok_yes">key/key.txt可写√</span><br />' : "<span class='ok_no'>key/key.txt不可写入ㄨ</span><br />";
		echo session_id() ? '<span class="ok_yes">session可用，用于后台登陆状态√</span><br />' : "<span class='ok_no'>session不可用，用于后台登陆状态√ㄨ</span><br />";
		@include 'mysql_class.php';	
		if($mysql)
		{
			echo  '<span class="ok_yes">可以连接到数据库√<br /></span>';
		}else{
			echo  '<span class="ok_no">不能连接数据库<br /></span>';
		}
		echo '</div>';
		exit;

	}

	//曲线报表　
	if(isset($_GET['get_hours']))
	{
		$surl='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$surl = dirname($surl).'/97date/';
		$surl2 = dirname($surl).'/97date/'.'highcharts/';
		
		echo '<script type="text/javascript" src="'.$surl.'jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.$surl2.'highcharts.js"></script>';
		echo '<script type="text/javascript" src="'.$surl2.'modules/exporting.js"></script>';

		
		$all_list= zj_r_h(4);
		$success_list= zj_r_h(5);
		$fail_list= zj_r_h(6);
		$all_num = array_sum(explode(',', $all_list));
		$success_num = array_sum(explode(',', $success_list));
		$fail_num = array_sum(explode(',', $fail_list));
		
$zjstr=<<<EOD
		<style type="text/css">
		*{margin:0;padding:0;}
		body{font-size:14px;color: #000;background:#FFF;}
		</style>
		<script type="text/javascript">
		
        $(function () {
         $('#tu_container').highcharts({
            chart: {
                type: 'spline',
                 inverted: false
            },
            title: {
                text: '日期{$d} 　全部{$all_num}次 　成功{$success_num}次　 失败{$fail_num}次'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
            	categories: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11','12','13','14','15','16','17','18','19','20','21','22','23']
            	
            },
            yAxis: {
                title: {
                    text: ''
                },
                min:0                
            },

            tooltip:  {
                valueSuffix: '次',
                 crosshairs: true,
                shared: true
            },
            legend: {
                layout: 'horizontal',              
                    backgroundColor: '#FFFFFF',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    align: 'center',
                    verticalAlign: 'top',
                    enabled:true,
                    //x: 100,
                    y: 50,
                    //floating: true,
                    shadow: true
            },
            series: [

            {
                name: '总数',               
				data:[{$all_list}]
				

			}, {
            	name: '失败',               
				data:[{$fail_list}]
			},{
           		name: '成功',               
				data:[{$success_list}]
			}]
        });
		
		
 
     });



</script>

<div id="tu_container" style="min-width: 400px;height: 400px; margin: 0 auto;"></div>
EOD;
		echo $zjstr;
		exit;



	}


		


	//获取key值
	if(isset($_GET['get_key']))
	{
		$key_path = str_replace('\\','/',dirname(__FILE__)).'/key/key.php';
		$key_config = @file_get_contents($key_path);
		$key_reg = "/array\(\"(.*?)\",\"(.*?)\",\"(.*?)\",\),\/\/(.*?)\n/is";
		preg_match_all($key_reg, $key_config, $see_config);
		//print_r ($see_config[1]);
		$surl='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$surl = dirname($surl).'/97date/';
		$surl2 = dirname($surl).'/97date/'.'lhgdialog/';
		echo '<script type="text/javascript" src="'.$surl.'jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.$surl.'zjui.js"></script>';
		echo '<div class="zhijiabox">';
		echo '当前共有账号'.count($see_config[0]).'个！平均分配模式<font color=green>(如: 有2个账号就是每个50%,1个账号100%)</font>';
		echo '&nbsp;<input type="button" class="bt" id="new_form" value="增加" /><br />';
		
		foreach ($see_config[1] as $key => $val) {
			
			echo '<form class="zj_key_from">';
			foreach ($see_config as $k => $v) {
				if($k==0){continue;}
				if($k==1)
				{	
					echo "<span class='in_tit'>appkey:</span><input type='text' class='in_txt' value='".$v[$key]."'><br />";
				}else if($k==2)
				{
					echo "<span class='in_tit'>App Secret:</span><input type='text' class='in_txt' value='".$v[$key]."'><br />";
				}elseif($k==3)
				{
					echo "<span class='in_tit'>pid淘客计费id:</span><input type='text' class='in_txt' value='".$v[$key]."'><br />";
				}elseif($k==4)
				{
					echo "<span class='in_tit'>备注:</span><input type='text' class='in_txt' value='".$v[$key]."'><br />";
				}
			}
			echo '<input type="button" class="del_from" class="bt"  value="删除" /><br />';
			echo '</form>';				
			
		}
		
		echo '<br /><input type="reset" class="bt"  value="重置" />&nbsp;<input type="submit" class="bt" id="zj_form_save" value="保存" />';			
		echo '</div>';
		
$zjstr=<<<EOD
		<style type="text/css">
		*{margin:0;padding:0;}
		form{margin-top:20px;padding-bottom:20px;border-bottom:1px solid #555;}
		body{font-size:14px;color: #000;background:#FFF;}
		.bt{width:60px;height:24px;line-height:24px;}
		.zhijiabox{padding:15px 10px;line-height:24px;background:#FFF;}
		.in_txt{height:22px;background:#FFF;line-height:22px;margin:0;padding:0;width:300px;overflow:hidden;border:none;border-bottom:1px solid #555;}
		.in_tit{height:22px;line-height:22px;vertical-align:middel;width:150px;overflow:hidden;font-weight:bold;display:inline-block;}
		</style>
EOD;

		echo $zjstr;
		exit;
	}

	//设置key值
	if(isset($_GET['set_key']))
	{
		global $surl,$surl2,$surl3;
		$all_html = str_replace('\\','',$_POST['all_html']);//得到提交的数据，替换下\这个符号为空

		$key_path = str_replace('\\','/',dirname(__FILE__)).'/key/key.php';

		$key_config = @file_get_contents($key_path);
		$key_config_reg = '/(<.*?return array\()(.*?)(\);)/is';
		preg_match_all($key_config_reg, $key_config, $key_config); //这是原先的数据
		//print_r($key_config);exit;
		//总体匹配
		//$all_form_reg = '/(<form.*?<\/form>)/is';
		//preg_match_all($all_form_reg, $all_html, $all_form_arr);
		//分多段匹配
		$appkey_reg  = '/appkey:.*?value="(.*?)"/is';
		$app2_reg 	 = '/App Secret:.*?value="(.*?)"/is';
		$pid_reg     = '/pid淘客计费id:.*?value="(.*?)"/is';
		$bei_reg     = '/备注:.*?value="(.*?)"/is';
		
		preg_match_all($appkey_reg, $all_html, $appkey_arr);
		preg_match_all($app2_reg, $all_html, $app2_arr);
		preg_match_all($pid_reg, $all_html, $pid_arr);
		preg_match_all($bei_reg, $all_html, $bei_arr);
		$new_config = array($appkey_arr[1],$app2_arr[1],$pid_arr[1],$bei_arr[1]);
		
		//循环出来新的数据
		$zjstr="\n";
		foreach ($appkey_arr[1] as $key => $val) {
			//array('21372184','56c94e49581ca1634f2ff97b9cbac52e','14553253'),//多多购网
			$zjstr.="array(";
			foreach ($new_config as $k => $v) {				
				if($k==3)
				{
					$zjstr .='),//'.$v[$key]."\n";
					continue 2;
				}else{
					$zjstr .='"'.$v[$key].'",';
				}
			}
			$zjstr.="),\n";
		}
		//print_r($zjstr);
		//组合新的源代码
		$key_config[2][0]=$zjstr;
		$zjstr=$key_config[1][0].$key_config[2][0].$key_config[3][0];
		//echo $zjstr;exit;
		$is_ok =file_put_contents($key_path, $zjstr,LOCK_EX );
		if($is_ok)
		{
			echo '^_^ 修改成功';
		}else{
			echo '^_^ 修改失败';
		}

		exit;
	}


	//script url
	$surl='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	$surl3= dirname($surl).'/';
	$surl = $surl3.'97date/';
	$surl2 = dirname($surl).'/97date/'.'lhgdialog/';
	/*
	风格可以随机改变
	$zj_skins_arr = array('qq2011','mac','jtop','idialog','discuz','default','chrome','blue');
	$zj_skins_key = count($zj_skins_arr)-1;
	$zj_skins_key =rand(0,$zj_skins_key);
	*/
$zjstr=<<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<title>日志后台管理</title>
</head>
<body>
	<script type="text/javascript" src="{$surl}jquery.min.js"></script>
	<script type="text/javascript" src="{$surl2}lhgcore.lhgdialog.min.js"></script>
	<script type="text/javascript" src="{$surl2}lhgdialog.js"></script>
	<link style='text/css' rel="stylesheet" href="{$surl2}skins/qq2011.css" />
	<script type="text/javascript">
	$(function(){

		$('#get_key').dialog({		
	    width: '600px',
	    height: 500,
	    content: 'url:{$surl3}show.php?get_key=1',
	    title:"(^_^)api账号设置"
		});

		$('#zjcheck').dialog({		
	    width: '280px',
	    height: '180px',
	    content: 'url:{$surl3}show.php?zjcheck=1',
	    title:"(^_^)环境检测"
		});
		
		//所有日志
		$('#alllog').dialog({		
	    width: '900px',
	    height: 500,
	    content: 'url:{$surl3}show.php?alllog=1&date={$d}&show_t=1',
	    title:"(^_^)所有日志"
		});

		//成功日志
		$('#successlog').dialog({		
	    width: '900px',
	    height: 500,
	    content: 'url:{$surl3}show.php?successlog=1&date={$d}&show_t=1',
	    title:"(^_^)成功日志"
		});

		//失败日志
		$('#errorlog').dialog({
		width: '900px',
	    height: 500,
	    content: 'url:{$surl3}show.php?errorlog=1&date={$d}&show_t=1',
	    title:"(^_^)失败日志"
		});

		//退出登陆
		$('#zj_exit').dialog({
		width: '350px',
	    height: 220,
	    content: 'url:{$surl3}show.php?exit=1',
	    title:"(^_^)退出系统"
		});

		//曲线报表		
		$('#get_hours').dialog({
		width: '960px',
	    height: 400,
	    content: 'url:{$surl3}show.php?get_hours=1&date={$d}',
	    title:"(^_^)曲线报表"
		});
	

		
	})


	
	</script>
EOD;
	//按时间计算
	$all_list= zj_r_h(4);
	$success_list= zj_r_h(5);
	$fail_list= zj_r_h(6);
	$all_num = array_sum(explode(',', $all_list));//总数
	$success_num = array_sum(explode(',', $success_list));//成功数
	$fail_num = array_sum(explode(',', $fail_list));//失败数

	$all_num = ($all_num>=0) ? $all_num:zj_read(4);//以前有总数计算所以加了这句取总的
	$success_num = ($success_num>=0) ? $success_num:zj_read(5);
	$fail_num = ($fail_num>=0) ? $fail_num:zj_read(6);
	if($all_num>0 && $fail_num>0)
	{
		$fail_bi = $fail_num / $all_num * 100;	
		$fail_bi = round($fail_bi ,2).'%'; //失败比例
	}else{
		$fail_bi=0;
	}
	echo $zjstr;

	//echo '<font color=red align=center>提示：日志已经加密 ，如果你看到此信息，说明您已经登陆！</font>';
	echo '<script language="javascript" type="text/javascript" src="'.$surl.'/WdatePicker.js"></script>';	
	echo "<div class='zhijiabox'>";
	echo '<span style="color:red;width:800px;display:block;padding:0 5px;background:#eee;margin-bottom:30px;">';
	echo '<span style="display:inline-block;font-weight:bold;">日期:</span>';
	echo '&nbsp;<input class="Wdate" type="text" id="day_put" value="'.$d.'" onClick="WdatePicker()"> <input type="button" value="确定" class="yesday" onclick="select_day()"/>';
	echo '<span style="display:inline-block;margin-left:50px;"><font color="green"><i>(日志加密，未登陆拒绝查看,爬虫也不行！)</i></font> (^_^) 超级管理员：admin   <a href="javascript:void(0)" id="zj_exit">退出</a></span></span>';	
	
	echo '访问总数:<span class="nums">'.$all_num;echo "<a href='javascript:location.reload(true)' class='bt_a' style='margin:0;margin-left:50px;'>刷新信息</a>  失败比例：" .$fail_bi.'</span><br />';
	echo '访问下载:<span class="nums">'.$success_num;echo '</span><br />';
	echo '访问失败:<span class="nums">'.$fail_num;
	echo '</span><br /><br />';
	echo "<a href='javascript:void(0)' id='alllog' class='bt_a'>所有日志</a>";
	echo "&nbsp;&nbsp;<a href='javascript:void(0);'  id = 'successlog' class='bt_a'>成功日志</a>";
	echo "&nbsp;&nbsp;<a href='javascript:void(0);' id='errorlog' class='bt_a'>失败日志</a>";
	echo "&nbsp;&nbsp;<a href='javascript:void(0);'  class='bt_a' id='get_hours'>曲线报表</a>";
	//echo "&nbsp;&nbsp;<a href='javascript:void(0);' id ='zjcheck'  class='bt_a'>环境检测</a>";
	//echo "&nbsp;&nbsp;<a href='javascript:void(0);'  class='bt_a' id='get_key'>api账号</a>";
	

	echo '</div>';
?>

<style type="text/css">
	*{margin:0;padding:0;}
	body{font-size:14px;color: #000;background:#9bad9d;}
	a{text-decoration: none;color:#1e00ff;}
	a.bt_a{background:url(<?php echo $surl.'btn1.png';?>) no-repeat;width:69px;font-size:12px;height:24px;color:#fff;text-align:center;line-height:24px;display:inline-block;}
	.zhijiabox{display:block;background:#fff;width:800px;margin:150px auto;padding:15px 10px;line-height:24px;border:5px outset #ccc;background:#f5f5f5;}
	.nums{color:#f00;}
	.Wdate{width:100px;padding-left:8px;}
	.yesday{width:50px;height:20px;}
	.ok_yes{color: green;font-size:18px;}
	.ok_no{color:red;font-size:18px;}
</style>
<script type="text/javascript">
	function select_day()
	{
		
		var zjday = document.getElementById('day_put').value;
		//alert(zjday);
		location.href='show.php?date='+zjday;
	}
	$('a.bt_a').hover(function(){$(this).css('opacity','0.5')},function(){$(this).css('opacity','1')})
	$('.zhijiaboxs').fadeIn("slow");
</script>
</body>
</html>