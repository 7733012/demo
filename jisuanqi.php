<?php
if($_POST['sub']){
	$a=$_POST['age'];
	$b=$_POST['hi'];
	$m=$_POST['m'];
	$c="+";
	$f="-";
	$e="*";
	$j="/";
	switch ($m){
		case $c:$d=$a+$b;
				   break;
		case $f:$d=$a-$b;
				   break;
		case $e:$d=$a*$b;
				   break;
		case $j:$d=$a/$b;
				   break;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd ">
<html xmlns="http://www.w3.org/1999/xhtml ">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="gb2312" />
<title>php计算器</title>
</head>
<body>
<div style="width: 350px;height: 170px;margin: 80px auto;line-height: 40px;font-size: 14px;background: #F1F1F1;padding: 40px;border: 1px solid #DDD;">
<form action="" method="POST" >
	<input type="text" name="age"><br/>
	<input type="text" name="hi"><br/>
	<input type="radio" name="m" value="+">+
	<input type="radio" name="m" value="-">-
	<input type="radio" name="m" value="*">*
	<input type="radio" name="m" value="/">/
	<br/>
	<input type="submit" value="计算" name="sub"/>
</form>
<?php
echo "结果为：".$d;
echo "<br/>作者： <a href='http://www.daomei.net.cn' target='_blank'>倒霉网</a>";
?>
</div>
</body>
</html>