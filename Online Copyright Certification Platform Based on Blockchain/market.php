<?php
header("Content-type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user'])) {
	echo '<script>window.location="market_login.php";</script>';   
    }
else{
	echo '<script>window.location="market_unlog.php";</script>';   
	}
?>