<?php
header("Content-type: text/html;charset=utf-8");
session_start();

$user = $_SESSION['user'];
$error = error_get_last();	
    if ($error['message']=='Undefined index: user') {
		echo "<script>alert('请重新登陆，页面正在跳转...');</script>"; 	
		echo '<script>window.location="login.html";</script>';   
    }
    

$style=$_POST['style'];
$description = $_POST['description'];
$picname = $_POST['picname'];
$filename = $_FILES['file0']['name'];
$filesize = $_FILES['file0']['size'];
$filetype = $_FILES['file0']['type'];
$tmpfile = $_FILES['file0']['tmp_name'];
date_default_timezone_set('PRC'); 
$date  = date('Y-m-d H:i:s'); //上传日期
$filepath="image/".$user.strtotime($date).$filename; 

//图片保存到服务器
if(move_uploaded_file($tmpfile,$filepath))
{
	echo "<center>已存入文件夹</center>";
}else{
    echo "<center>存入文件夹失败</center>";
}

$conn =mysqli_connect("127.0.0.1","root","masae980824","prp"); 
//将图片转化为bs64码后，加上时间，用户，用哈希函数进行加密，得到数据库中该图片的key
//https://blog.csdn.net/baidu_28393027/article/details/80540132   上链后的密码可以参考加盐
$piccode=base64_encode(file_get_contents($filepath));
$piccode=$date.$piccode;
$pichash=hash("sha256",$piccode);
  
if (!$conn){                
	echo "<script>alert('数据库连接失败，请稍候！');</script>";               
	exit(0);            
}
else{
	$conn->query("set names 'utf8'");
	$sql="insert into certification (user,picname,date,filepath,description,filesize,filetype,pichash,$style,status)
	values ('$user','$picname','$date','$filepath','$description','$filesize','$filetype','$pichash',1,0)"; 
	$result = $conn->query($sql);  
if (!$result) {
	printf("Error: %s\n", mysqli_error($conn));
    exit();}
else {
	echo "<script>alert('上传成功！');</script>"; 	
	echo '<script>window.location="certification.html";</script>'; 
}
}

// else{
// 	echo "<script>alert('作品上传失败，请重试！');</script>";               
// 	exit(0); 
// }


mysqli_free_result($result);
mysqli_close($conn);
