<?php
	//error_reporting(0);//屏蔽错误
	date_default_timezone_set('Asia/Shanghai'); //设置时间为上海时间
	$zjYear = date('Y-m-d');
	$zjArr  = explode('-', $zjYear);
	$zjdir = dirname(__FILE__).DIRECTORY_SEPARATOR.'zjlogs'.DIRECTORY_SEPARATOR.$zjArr[0].DIRECTORY_SEPARATOR.$zjArr[1].DIRECTORY_SEPARATOR.$zjArr[2];
	
	$zjdirlog =$zjdir.DIRECTORY_SEPARATOR.'allLog'.DIRECTORY_SEPARATOR;//所有日志
	$zj_hour =$zjdir.DIRECTORY_SEPARATOR.'zjhour'.DIRECTORY_SEPARATOR;//24小时 数据	
	
	
	//自动建立所需要的目录
	if(!zj_mkdir($zjdirlog) || !zj_mkdir($zj_hour))
	{
		die('zjlogs 权限需要0777');
	}
	
	$allLog_file = $zjdirlog.'allLog.php';//所有日志
	$successLog_file = $zjdirlog.'successLog.php';//成功日志
	$failLog_file = $zjdirlog.'failLog.php';//失败日志
	$allNum_file = $zjdir.DIRECTORY_SEPARATOR.'allNum.php';//总数	
	$successNum_file = $zjdir.DIRECTORY_SEPARATOR.'successNum.php';//成功
	$failNum_file = $zjdir.DIRECTORY_SEPARATOR.'failNum.php ';//失败
	
	$file_arr = array(1 => $allLog_file,2 => $successLog_file, 3 =>$failLog_file,4 => $allNum_file,5 => $successNum_file,6 => $failNum_file);
	

	
	function zj_mkdir($zj_path) 
	{ 
		if(!is_dir($zj_path))
		{  
			if(!zj_mkdir(dirname($zj_path)))
			{
			  return false;  
			} 
			if(!mkdir($zj_path,0777))
			{ 
			  return false;
			}  
		} 
		 return true;  
	}  


	/* int file_num 5-6 可选 ,5是成功数，6是失败数，总数自动写入*/
	function zj_put_num($file_num)
	{
		global $file_arr,$zj_hour;		
		
		$zj_h = preg_replace('/^0{1}/', '', date('H'));//防止00,01...等的出现   当前小时		
		$zj_h_arr = array(4=>'a_',5=>'b_',6=>'c_');
		$zj_f_name =$zj_h_arr[$file_num].$zj_h;
		$zj_fa_name =$zj_h_arr[4].$zj_h;
		$zj_h_file = $zj_hour.$zj_f_name.'.php';//当前小时的文件名 a_0 a_2 b_2 c_2这样 a 是全部　b是成功　c是失败 后面是小时数字
		$zj_ha_file = $zj_hour.$zj_fa_name.'.php';
		
		if(file_exists($zj_h_file)){
		
			put_jia($zj_h_file);//24小时数据　每小时插入 当前编号(成功||失败) +1

			put_jia($zj_ha_file);//24小时数据 总数			
		}else{
			//如果不存在当前小时的文件自动建立
			$zj_str = "<?php\n";
			$zj_str .= "defined('ZJ_TAOBAO')=='lg998' or die('^_^，没有权限 请绕路而行..');\n";
			$zj_str .= "?>\n";
			$zj_str .= "1";	
			file_put_contents($zj_h_file,$zj_str,LOCK_EX);
			if(!file_exists($zj_ha_file))
			{
				file_put_contents($zj_ha_file,$zj_str,LOCK_EX);
			}else{
				put_jia($zj_ha_file);//24小时数据 总数
			}
		}//24小时数据
		
	}//end func
	

	//经过测试　高并发　操作不会覆盖
	function put_jia($filePath)
	{
			
	    $fp = fopen($filePath, 'r+');				
		do{  
	        $canWrite = flock($fp, LOCK_EX);		        
	        if (!$canWrite)  
	        {   
	        	usleep(100);//延迟0.1ms 
	        } 
	    }while(!$canWrite);
	    if($canWrite)
	    {			    
		    $zjdata =fread($fp,filesize($filePath)+1);		    
		    $reg= '/(.*?\>\n)(\d+)/s';
		    preg_match_all($reg, $zjdata, $zj_arr);			   
		    $zjnum = $zj_arr[2][0]+1;			   
		    $zjstr = $zj_arr[1][0].$zjnum;
		    //sleep(5);//测试延时５秒
		    fseek($fp,0);//倒回到文件开头
			fwrite($fp, $zjstr);
		    flock($fp,LOCK_UN);//释放锁定  
		   	fclose($fp);
		}
	}//end func

	//在原日志上增加一条 并发防出错
	function put_jia_log($filePath,$str)
	{

		$fp = fopen($filePath, 'a');				
		do{  
	        $canWrite = flock($fp, LOCK_EX);		        
	        if (!$canWrite)  
	        {   
	        	usleep(100);//延迟0.1ms 
	        } 
	    }while(!$canWrite);
	    if($canWrite)
	    {			    
		    $zjdata =fread($fp,filesize($filePath)+1);
			fwrite($fp, $str);
		    flock($fp,LOCK_UN);//释放锁定  
		   	fclose($fp);
		}
	}


	/* int file_num 2-3 可选 ,2是成功日志，3是失败日志，总日志自动写入*/
	/*geturl 传入的地址 beizu错误的信息*/
	function zj_put_log($file_num,$geturl='',$beizu='')
	{
			global $file_arr;;
			$fname = $file_arr[$file_num]; //根据参数选择成功失败的文件名
			$fname_a = $file_arr[1];//总日志 自动写入
			$zjtime = date('Y-m-d H:i:s');	
			if($_SERVER['HTTP_CLIENT_IP']){
				$zjip=$_SERVER['HTTP_CLIENT_IP'];
			}elseif($_SERVER['HTTP_X_FORWARDED_FOR']){
				 $zjip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				 $zjip=$_SERVER['REMOTE_ADDR'];
			}			
			//$zjagent = $_SERVER['HTTP_USER_AGENT'];
			$zjstring = $zjtime."\t".$zjip."\t".$geturl."\t".$beizu."\r\n";			
			if(file_exists($fname) ||file_exists($fname_a)){
				put_jia_log($fname,$zjstring);//当前日志
				put_jia_log($fname_a,$zjstring);//总日志 
			}else{
				$zj_str = "<?php\n";
				$zj_str .= "defined('ZJ_TAOBAO')=='lg998' or die('^_^，没有权限 请绕路而行..');\n";
				$zj_str .= "?>\n";
				$zj_str .= $zjstring;
				$zhijia = file_put_contents($fname,$zj_str,LOCK_EX);
				if(!file_exists($fname_a))
				{
					$zhijia = file_put_contents($fname_a,$zj_str,LOCK_EX);
				}else{
					put_jia_log($fname_a,$zjstring);//总日志 
				} 		
			}
			
	}//end

?>