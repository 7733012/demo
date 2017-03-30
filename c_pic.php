<?php
class Collection{
	protected $url;				//采集地址php100.com
	protected $prefix;			//重命名文件前缀
	protected $style;			//需要采集的图片格式，传入一个数组
	const prel = '/(?:http?|https?):\/\/(?:[^\.\/\(\)\?]+)\.(?:[^\.\/]+)\.(?:com|cn|net|org)\/(?:[^\.:\"\'\(\)\?]+)\.(jpg|png|gif)/i';			//采集规则
	//构造函数
	function __construct($url,$prefix,$style){
		switch($this->checkdata($url,$prefix,$style)){
			case 1:
				echo '<script>alert("采集地址不能为空！")</script>';
				exit;
				break;
			case 2:
				echo '<script>alert("需要采集的图片格式，应该为数组！")</script>';
				exit;
				break;
			case 3:
				echo '<script>alert("需要采集的图片格式，不能为空！")</script>';
				exit;
				break;
			case 4:
				echo '<script>alert("文件名不能含有. / |或用空格开头！")</script>';
				exit;
		}
		$this->url = $url;
		$this->prefix = $prefix;
		$this->style = $style;
	}
	//开始采集数据
	public function action(){
		$url = $this->checkurl();
		$imgurl = $this->collecturl($url);
		$this->savafile($imgurl);
	}
	//url处理
	protected function checkurl(){
		$munprel = '/\([0-9]+,[0-9]+\)/i';
		$myurl;
		if(preg_match($munprel,$this->url,$arr)){
			$temp = substr($arr[0],1,strlen($arr[0])-2);
			$mymunber = explode(',',$temp);
			$temparr = explode($arr[0],$this->url);
			for($i=$mymunber[0];$i<=$mymunber[1];$i++){
				$myurl[] = $temparr[0].$i.$temparr[1];
			}
		}else{
			$myurl = $this->url;
		}
		return $myurl;
	}
	//文件保存
	protected function savafile($imgurl){
		if(!empty($imgurl)){
			foreach($imgurl[0] as $key=>$value){
				$filename = '';
				if(in_array($imgurl[1][$key],$this->style)){
				    $size = @getimagesize($value);
					if($size === false){
						continue;
					}
					list($w,$h,$t,$a) = $size;
					if($w<200 || $h<200){
						continue;
					} 
					ob_start();
					readfile($value);
					$obj = ob_get_contents();
					ob_end_clean();
					$dir = 'F:/php/';
					if(!is_dir($dir)){
						mkdir($dir,0777);
					}
					if(!empty($this->prefix)){
						$filename = $dir.$this->prefix.date('Ymd').rand(10000,99999).'.'.$imgurl[1][$key];
					}else{
						$filename = $dir.date('Ymd').rand(10000,99999).'.'.$imgurl[1][$key];
					}
					$fo = @fopen($filename,'wb');
					if($fo === false){
						echo '<script>alert("创建文件失败，文件目录不可写！")</script>';
						exit;
					}
					$fw = fwrite($fo,$obj);
					echo '<div style="width:350px;background:#ddd;">'.$filename.'采集成功</div>';
				}
			}
		}
	}
	
	//地址采集函数,包括图片后缀名
	protected function collecturl($url){
		set_time_limit(0);
		if(is_array($url)){
			$arr = array();
			$imgkey = array();
			foreach($url as $value){
				$code = file_get_contents($value);
				preg_match_all(self::prel,$code,$arrimg);
				$arr = array_merge($arr,$arrimg[0]);
				$imgkey = array_merge($imgkey,$arrimg[1]);
			}
			return array($arr,$imgkey);
		}else{
			$code = file_get_contents($url);
			preg_match_all(self::prel,$code,$arrimg);
			return $arrimg;
		}
	}
	//检验数据
	private function checkdata($url,$prefix,$style){
		if(empty($url)){
			return 1;
		}elseif(!is_array($style)){
			return 2;
		}elseif(count($style)==0){
			return 3;
		}elseif(stripos($prefix,'.') !== false || stripos($prefix,'/') !== false || stripos($prefix,'|') !== false){
			return 4;
		}
	}
}


?>