<?php
header("Content-type: text/html;charset=utf-8");
session_start();
$user=$_SESSION['user'];
$pichash=$_GET['pichash'];
$basket=$_SESSION['basket'];
$error = error_get_last();	
if ($error['message']=='Undefined index: user') {
	echo "<script>alert('请重新登陆，页面正在跳转...');</script>"; 	
	echo '<script>window.location="login.html";</script>';   
}
else{
	$basket=array_diff($basket,[$pichash]);
	echo "<script>alert('成功移出购物车！');</script>"; 
	$_SESSION['basket']=$basket;
	echo '<script>window.location="basket.php";</script>';
	}
?>