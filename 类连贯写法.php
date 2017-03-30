<?php

	header("content-type:text/html;charset=utf-8");
	/**
	*  指甲测试函数类
	*  测试　数组之　连惯操作
	*/
	class ligen 
	{
		
		public $name;
		public $type;
		function __construct($argument)
		{
			$artument = explode(',', $argument);
			//print_r($artument);
			$this->name = $artument[0];
			$this->type = $artument[1];	
		}

		public function _name()
		{

			echo $this->name;
			return $this;
		}

		public function _type()
		{
			echo $this->type;
			return $this;
		}

		public function _zhijia($n,$v)
		{
			$this->$n = $v;
			return $this;
		}

		public function ok()
		{

			echo '完毕了，就是return $this';
			return $this;
		}

		public function ok2()
		{

			echo '<br /> __________^ _ ^  ___________';
			return $this;
		}
		
		static function _meiyouguanxi()
		{
			echo '<br /><br />没有关于我们只是朋友。';
			
		}


		static function img($url)
		{
			set_time_limit(0);//禁卡超时
			echo str_repeat ( " " , 1024 ) ;
			ob_flush();
			flush();
			
			ob_start();
			@readfile($url);
			$f = ob_get_contents();
			if(false==$f){echo '采集错误.';return;}
			ob_end_clean();

			preg_match_all('/(\.gif|jpg|bmp)/', $url,$pr);//后缀
		
			$pr = '.'.$pr[1][0];
			//$fp = fopen('1.gif', 'w');
			$fp = fopen('zjimgs/'.date('Y-m-d').time().$pr, 'w');
			$fw = fwrite($fp, $f);
			fclose($fp);
			if(true == $fw)
			{

				echo "采集成功<br />";
			}else{
				echo "采集失败<br />";
			}

		}
	}


	$lg = new ligen('李根,男');
	$lg->_zhijia('name','周雷')->_zhijia('type',' 女')->_name()->_type()->ok2()->ok();
	ligen::_meiyouguanxi();
	$a = array('a','b','c',array(1,2,3,array(1,2,3)),4,5,6);
	echo implode('-',$a); //这时候以+ 组合了。
?>