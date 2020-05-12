<?php
header("Content-type: text/html;charset=utf-8");
session_start();
$user=$_SESSION['user'];
$pichash=$_GET['pichash'];

$error = error_get_last();	
if ($error['message']=='Undefined index: user') {
	echo "<script>alert('请重新登陆，页面正在跳转...');</script>"; 	
	echo '<script>window.location="login.html";</script>';   
}
if (!isset($_SESSION['basket'])){
	$basket=array();
	$basket[]=$pichash;
	echo "<script>alert('加入购物车成功！');</script>"; 
}
else{
	$basket=$_SESSION['basket'];
	if (in_array($pichash,$basket)){
		echo "<script>alert('该商品已加入购物车~');</script>"; 	
	}
	else {
		$basket[]=$pichash;
		echo "<script>alert('加入购物车成功！');</script>"; 
		}
}

$_SESSION['basket']=$basket;
echo "<script> history.go(-1);</script>";
?>	