<?php

	$zj = rand(0,1);
	if($zj==0)
	{
		$zj_str='<script type="text/javascript">';
		$zj_str.='var sogou_ad_id=208180;';
		$zj_str.='var sogou_ad_height=90;';
		$zj_str.='var sogou_ad_width=728;';
		$zj_str.='</script>';
		$zj_str.="<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>";
			
	}else{
	
		$zj_str='<script type="text/javascript">var afc_placementid=232245;var afc_width=728;var afc_height=90;</script><script type="text/javascript" src="http://rh.qq.com/sa.js"></script>';
	
	}
	echo $zj_str;
?>