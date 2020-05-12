<?php    
header("Content-type: text/html; charset=utf-8");        
$user =$_POST['user'];
$pass =$_POST['pass'];
$conn =mysqli_connect("127.0.0.1","root","masae980824","prp");   
if (!$conn){                
echo "<script>alert('数据库连接失败，请稍候！');</script>";               
exit(0);            
}
$sql="select pass from register where user='$user'"; 
$result = $conn->query($sql);  
if (!$result) {
	printf("Error: %s\n", mysqli_error($conn));
    exit();}          
$number = mysqli_num_rows($result);  
$row =$result->fetch_assoc();              
if ($number){
	if ($row['pass']==$pass){
		session_start();
		$_SESSION['user']= $user;
		echo "<script>alert('登录成功，点击返回个人主页');</script>"; 
		echo '<script>window.location="certdisplay.php";</script>';  	                
	} 
	else echo "<script>alert('密码错误');</script>"; 
}
else echo "<script>alert('用户名不存在');</script>";

mysqli_free_result($result);
mysqli_close($conn);