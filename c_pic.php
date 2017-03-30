<?php
class Collection{
	protected $url;				//�ɼ���ַphp100.com
	protected $prefix;			//�������ļ�ǰ׺
	protected $style;			//��Ҫ�ɼ���ͼƬ��ʽ������һ������
	const prel = '/(?:http?|https?):\/\/(?:[^\.\/\(\)\?]+)\.(?:[^\.\/]+)\.(?:com|cn|net|org)\/(?:[^\.:\"\'\(\)\?]+)\.(jpg|png|gif)/i';			//�ɼ�����
	//���캯��
	function __construct($url,$prefix,$style){
		switch($this->checkdata($url,$prefix,$style)){
			case 1:
				echo '<script>alert("�ɼ���ַ����Ϊ�գ�")</script>';
				exit;
				break;
			case 2:
				echo '<script>alert("��Ҫ�ɼ���ͼƬ��ʽ��Ӧ��Ϊ���飡")</script>';
				exit;
				break;
			case 3:
				echo '<script>alert("��Ҫ�ɼ���ͼƬ��ʽ������Ϊ�գ�")</script>';
				exit;
				break;
			case 4:
				echo '<script>alert("�ļ������ܺ���. / |���ÿո�ͷ��")</script>';
				exit;
		}
		$this->url = $url;
		$this->prefix = $prefix;
		$this->style = $style;
	}
	//��ʼ�ɼ�����
	public function action(){
		$url = $this->checkurl();
		$imgurl = $this->collecturl($url);
		$this->savafile($imgurl);
	}
	//url����
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
	//�ļ�����
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
						echo '<script>alert("�����ļ�ʧ�ܣ��ļ�Ŀ¼����д��")</script>';
						exit;
					}
					$fw = fwrite($fo,$obj);
					echo '<div style="width:350px;background:#ddd;">'.$filename.'�ɼ��ɹ�</div>';
				}
			}
		}
	}
	
	//��ַ�ɼ�����,����ͼƬ��׺��
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
	//��������
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