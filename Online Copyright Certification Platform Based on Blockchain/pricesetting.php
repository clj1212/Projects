<?php
header("Content-type: text/html;charset=utf-8");
session_start();

$user = $_SESSION['user'];
$pichash=$_SESSION['pichash'];

$proname=$_POST['proname'];
$price=$_POST['price'];
$clause=$_POST['clause'];
$style=$_POST['style'];
$error = error_get_last();	
	if ($error['message']=='Undefined index: user') {
		echo "<script>alert('请重新登陆，页面正在跳转...');</script>"; 	
		echo '<script>window.location="login.html";</script>';   
	}
	$conn =mysqli_connect("127.0.0.1","root","masae980824","prp");   
	if (!$conn){                
		echo "<script>alert('数据库连接失败，请稍候！');</script>";               
		exit(0);            
	}
	else{
		mysqli_set_charset( $conn,"utf8" );//使数据库中的数据以utf8格式显示在网页上

		$sql1="select * from certification where pichash='$pichash'";
		$result=mysqli_query($conn,$sql1); 
		if (!$result) {
			printf("Error: %s\n", mysqli_error($conn));
			exit();}
		else {
			while($row = mysqli_fetch_assoc($result)){
			$filepath = $row['filepath'];
			$picname=$row['picname'];
			$certdate=$row['date'];
			$pichash=$row['pichash'];  
			date_default_timezone_set('PRC'); 
			$tradabledate = date('Y-m-d H:i:s'); //上传日期
			$s1=$row['s1']; 
			$s2=$row['s2']; 
			$s3=$row['s3']; 
			$s4=$row['s4']; 
			$s5=$row['s5']; }
		}
			
		$sql2 = "insert into tradable (user,picname,proname,pichash,price,certdate,tradabledate,filepath,clause,$style) 
		values ('$user','$picname','$proname','$pichash','$price','$certdate','$tradabledate','$filepath','$clause',1)";                
		$result2 = $conn->query($sql2);                               
		if ($result2) {   
			$sql3="update certification set status=1 where pichash='$pichash'";
			$result3=$conn->query($sql3);
			if ($result3){
				echo "<script>alert('作品已提交到商城~即将返回个人中心');</script>"; 	
				echo '<script>window.location="personal.php";</script>'; 
			} 
		else 
		{                        
			//echo "<script>alert('系统繁忙，请稍候！');history.go(-1);</script>";
			printf("Error: %s\n", mysqli_error($conn));   
		
}                
}
	$conn->close();
mysqli_free_result($result);
mysqli_free_result($result2);
mysqli_close($conn);
	
	
	}
	

