<?php
	header("content-type:text/html;charset=utf-8");

	class Downimg{



		static function down($url)
		{
			set_time_limit(0);//禁超时
			//及时输出
			echo str_repeat ( " " , 1024 ) ;
			ob_flush();
			flush();



			//读取文件
			ob_start();
			@readfile($url);
			$f = ob_get_contents();			
			if(false==$f){echo '采集错误.';return;}
			ob_end_clean();






			preg_match_all('/(\.gif|jpg|bmp|js)/', $url,$pr);//图片后缀		
			if(!$pr[1][0]){echo '后缀错误！';return false;}
			$pr = '.'.$pr[1][0];

			if(!file_exists('zjimgs'))
			{
				mkdir('zjimgs');
			}

			//写入文件
			$fp = fopen('zjimgs/'.date('Y-m-d').time().$pr, 'w');
			$fw = fwrite($fp, $f);
			fclose($fp);
			if (true == $fw){
				echo "<font color=green>下载成功</font><br />"; 
				return true;
				}else{
				echo "<font color=red>下载失败</font><br />";
				return true;
			}

		}//end func


	}

	//下载图片

	$lg = new Downimg();
	$lg->down('http://img02.taobaocdn.com/bao/uploaded/i1/17200027153270636/T1jAqmFndfXXXXXXXX_!!0-item_pic.jpg_250x250.jpg');
	$lg->down('http://pic.desk.chinaz.com/file/201211/5/shierybizi7.jpg');
	//下载js
	$lg->down('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
	//错误下载，会提示哦 没有后缀的
	$lg->down('http://pic.desk.chinaz.com/file/201211/5/shierybizi7');

?>