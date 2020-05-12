
<!DOCTYPE HTML>
<html>
<head>
<title>Blockchain Picture Copyright | Login :: w3layouts</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' media="all" />
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Google Fonts -->
<link href='http://fonts.useso.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/sticky-navigation.css" />
<link href="css/demo.css" rel="stylesheet" type="text/css" />
<script>
$(function() {

	// grab the initial top offset of the navigation 
	var sticky_navigation_offset_top = $('#sticky_navigation').offset().top;
	
	// our function that decides weather the navigation bar should have "fixed" css position or not.
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		
		// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
		if (scroll_top > sticky_navigation_offset_top) { 
			$('#sticky_navigation').css({ 'position': 'fixed', 'top':0, 'left':0 });
		} else {
			$('#sticky_navigation').css({ 'position': 'relative' }); 
		}   
	};
	
	// run our function on load
	sticky_navigation();
	
	// and run it again every time you scroll
	$(window).scroll(function() {
		 sticky_navigation();
	});
	
	// NOT required:
	// for this demo disable all links that point to "#"
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); 
	});
	
});
</script>
</head>
<body>
	<!-- Header Part Starts Here -->
<div class="header">
	<div class="container">
	<div id="demo_top_wrapper">
	<div id="sticky_navigation_wrapper">
		<div id="sticky_navigation">
			<div class="demo_container navigation-bar">
				<div class="navigation">
					<div class="logo">个人中心</a></div>
					<div class="navig">
						<ul>
							<li><a href="certdisplay.php">已认证作品</a></li>
							<li><a href="tradable.php">可交易作品</a></li>
							<li><a href="certification.html">认证新作品</a></li>
							<li><a href="market.php">交易商城</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="navigation-right">
					<ul class="user">
						<li>
							<span></span><a href="reset_regist.php">退出登录</a>
						</li>
						<li>
							<span class="bascket"></span><a href="basket.php">购物车</a>
						</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>	
</div>
</div>
</div>

<div class="container">
<section id="main">
	<div class="content">
		<div class="pag-nav">
			<ul class="p-list">
				<li><a href="personal.php">个人中心</a></li> &nbsp;&nbsp;/&nbsp;
				<li class="act">&nbsp;交易商城</li>
			</ul>
		</div>
		
<?php    
header("Content-type: text/html; charset=utf-8"); 

session_start();

$user = $_SESSION['user'];
$style=$_GET['style'];
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
$sql="select * from tradable where user!='$user' and ";

	if ($style=="s1"){
		$sql=$sql."s1=1";
		echo "
			<div class='coats'>
				<h3 class='c-head'>风景</h3>
			<div class='coat-row'>";}
	elseif ($style=="s2"){
			$sql=$sql."s2=1";
			echo "
				<div class='coats'>
					<h3 class='c-head'>人物</h3>
				<div class='coat-row'>";}
	elseif ($style=="s3"){
				$sql=$sql."s3=1";
				echo "
					<div class='coats'>
						<h3 class='c-head'>动漫</h3>
					<div class='coat-row'>";}
	elseif ($style=="s4"){
					$sql=$sql."s4=1";
					echo "
						<div class='coats'>
							<h3 class='c-head'>设计</h3>
						<div class='coat-row'>";}
	elseif ($style=="s5"){
						$sql=$sql."s5=1";
						echo "
							<div class='coats'>
								<h3 class='c-head'>其它</h3>
							<div class='coat-row'>";}

mysqli_set_charset( $conn,"utf8" );//使数据库中的数据以utf8格式显示在网页上
$result=mysqli_query($conn,$sql); 
if (!$result) {
	printf("Error: %s\n", mysqli_error($conn));
	exit();}
else {
	$count=0;
	while($row = mysqli_fetch_assoc($result)){
	$count=$count+1;
	$filepath = $row['filepath'];
	$picname=$row['picname'];
	$date=$row['tradabledate'];
	$pichash=$row['pichash'];
	$price=$row['price'];
	$user1=$row['user'];
	if ($count%4==0){
		echo "&emsp;";
		echo "<div class='clearfix'></div>";}
	echo "
		<div class='coat-column'>
			<a href='$filepath'>
					<img src='$filepath' class='img-responsive' alt=''>
				<div class='prod-desc'><h4>$picname</h4><small>&yen $price</small></br>
				<small>来自：用户$user1</small></br>
				<small>上传时间：$date</small></div>
			</a>
				<div class='mask'>
					<div class='info'><a href='product.php?pichash=$pichash'>View</a></div>
				</div>
					<div class='reg'>
						<a href='addbasket.php?pichash=$pichash'>
							加入购物车
						</a>
					</div>
		</div>";
		
	}
}
	
?>
					<div class='clearfix'></div>
			</div>
		</div>

	</div>
</section>
</body>
</html>