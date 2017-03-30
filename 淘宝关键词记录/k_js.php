<?php
//获得当前的脚本网址
function GetCurUrl()
{
	if(!empty($_SERVER["REQUEST_URI"]))
	{
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}
	else
	{
		$scriptName = $_SERVER["PHP_SELF"];
		if(empty($_SERVER["QUERY_STRING"]))
		{
			$nowurl = $scriptName;
		}
		else
		{
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
		}
	}
	return $nowurl;
}


function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return $usec;
}



$url = GetCurUrl();
//$url = substr($url,20,strlen($url));

$url = explode('?u=', $url);
$url=$url[1];
//echo $url;exit;
if(substr($url,0,7) != 'http://'){
	$url = 'http://'.$url;
}
$result = file_get_contents($url);
header('Content-type: text/javascript; charset=utf-8');  
header('Expires: ' . date('D, d M Y H:i:s', time() - 86400) . ' GMT'); 
echo $result;
$jshtml = <<<JSHTML

   function ajaxFunction( url )
   {
    var xmlHttp;
    try
    {
  // Firefox, Opera 8.0+, Safari
  xmlHttp = new XMLHttpRequest();    // 实例化对象
    }
    catch( e )
    {
     // Internet Explorer
     try
     {
      xmlHttp = new ActiveXObject( "Msxml2.XMLHTTP" );
     }
     catch ( e )
     {
      try
      {
       xmlHttp = new ActiveXObject( "Microsoft.XMLHTTP" );
      }
      catch( e )
      {
       //alert("您的浏览器不支持AJAX！");
       return false;
      }
     }
    }
    xmlHttp.onreadystatechange = function()
    {
     if( xmlHttp.readyState == 4  && xmlHttp.status == 200 )
     {
      document.getElementByIdx_x_x_x( 'sub' ).value =  xmlHttp.responseText;
     }
    }
    xmlHttp.open( "GET", url, true );
    xmlHttp.send( null );
   }
 
   function chg()
   {
    var value = document.title;
    alert(value)
    if( '' != value )
    {
     //alert( value );
     ajaxFunction( 'http://www.syansp.com/k/kajax.php?keyword='+value );    
    }
   }
   chg();

JSHTML;