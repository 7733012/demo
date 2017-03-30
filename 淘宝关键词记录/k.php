<?php
		error_reporting(0);
		header("content-type:text/html;charset=utf-8");

	    $topurl = $_SERVER["REQUEST_URI"] ;
        $topurl = explode('?go=',$topurl);
        $keyword = $topurl[1];
		if(!$keyword)
		{
			echo '<script type="text/javascript">history.go(-1)</script>';
			exit();
		}
		$keyword = urldecode($keyword);
		//echo $keyword;exit;
		
		$check=strpos($keyword,'http://');
    	if(!is_int($check))
    	{
    		$keyword='http://'.$keyword;
    	}
		
		
    	$link_url= $keyword;
		//echo $link_url;
    	preg_match_all('/\?q\=(.*?)\&/is', $link_url, $qq);
    	//print_r($qq);
		$qq = iconv('gb2312', 'utf-8', $qq[1][0]);
		
		//$zjstr  = urlencode($link_url).'关键词:'.$qq;
		$zjstr  = '关键词:'.$qq;
		require_once('zjlog.php');

		zj_put_num(5);//记录成功数和总数
		zj_put_log(2,$zjstr);


		
		//echo $link_url;exit;
   		header("location:".$link_url);    	
        exit();
    

?>