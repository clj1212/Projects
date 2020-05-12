<?php
header("Content-type: text/html;charset=utf-8");
session_start();
// 将全局SESSION变量数组设置空.
//$_SESSION = array();
unset($_SESSION['user']);
// 如果SESSION数据存储在COOKIE中则删除COOKIE.
// Note: 将注销整个SESSION对象, 而不仅仅是SESSION数据!
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();                    //注销 session 会话
	echo "<script>alert('注销登录');</script>"; 	
	echo '<script>window.location="login.html";</script>'; 
?>