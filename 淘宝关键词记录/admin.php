<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>APIϵͳ-��½</title>
<style type='text/css'>

*{margin:0;padding:0;}
body{background:#000;}
.login_box{width:600px;overflow:hidden;border:5px outset #555;padding:20px;margin:150px auto;background:#fff;}
.login_box .input{width:50%;height:26px;line-height:26px;font-size:14px;color:#333;font-weight:800px;font-family:'΢���ź�','����','����';vertical-align:middle;margin-bottom:10px;padding:0 6px;}
.btn{width:60px!important;height:24px!important;line-height:24px!important;}
fieldset{padding:20px;}
legend{margin-bottom:20px;}
</style>
</head>
<body>

<?php

	//��֤cookie
	if(isset($_COOKIE['logined']) && strstr($_COOKIE['logined'],md5('zhijiaonline')))
	{
		echo '<script type="text/javascript">location.href="admin.php";</script>';
		
	}
?>
<div class='login_box'>

<form name='zhijia' action='show.php' method='post'>
<fieldset>
<legend>����Ա��½</legend>
����Ա��<input name='user_name' value='' type='input'class='input'/><br />
��&nbsp;&nbsp;�룺<input name='user_pass' value=''type='password' class='input'/><br />
<input type='submit' value='��½' name='login' class='btn' />&nbsp;
<input type='button' value='�ر�' onclick="javascript:window.close()" class='btn' />
</fieldset>
</form>
</div>




</body>
</html>
