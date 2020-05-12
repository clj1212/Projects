<?php    
header("Content-type: text/html; charset=utf-8");        
$username =$_POST['user'];
$password =$_POST['pass'];
$mailadd=$_POST["mailadd"];
$repassword = $_POST['pw2'];
$question=$_POST['question'];
$answer=$_POST['answer'];        
if ($username == ''){            
echo '<script>alert("请输入用户名！");history.go(-1);</script>';            
exit(0);        
}        
if ($password == ''){            
echo '<script>alert("请输入密码");history.go(-1);</script>';            
exit(0);        
} 
if ($answer == ''){            
echo '<script>alert("请输入密保答案");history.go(-1);</script>';            
exit(0);        
} 

       
if ($password != $repassword){            
echo '<script>alert("密码与确认密码应该一致");history.go(-1);</script>';            
exit(0);        
}        
if($password == $repassword){            
$conn =mysqli_connect("127.0.0.1","root","masae980824","prp");             
if (!$conn){                
echo '数据库连接失败！';                
exit(0);            
}
else {                
$sql = "select user from register where user = '$username'";                
$result = $conn->query($sql);             
$number = mysqli_num_rows($result);                
if ($number) {                   
echo '<script>alert("用户名已经存在");history.go(-1);</script>';                
} 
else {                    
$sql_insert = "insert into register (user,mailadd,pass,$question,status) values ('$username','$mailadd','$password','$answer',0)";                    
$res_insert = $conn->query($sql_insert);                    
if ($res_insert) {
echo "<script>alert('注册成功~欢迎加入~');</script>"; 	
echo '<script>window.location="login.html";</script>';                    
} 
else 
{                        
//echo "<script>alert('系统繁忙，请稍候！');history.go(-1);</script>";
	printf("Error: %s\n", mysqli_error($conn));                    
}                
}            
}        
}
else{            
echo "<script>alert('提交未成功！'); history.go(-1);</script>";        
}
$conn->close();
mysqli_free_result($result);
mysqli_free_result($res_insert);
mysqli_close($conn);