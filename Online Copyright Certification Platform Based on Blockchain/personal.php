<?
//这里暂时复制了certdisplay.php,要改成个人基本信息
?>

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
							<li><a href="men.html">交易商城</a></li>
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
							<span class="bascket"></span><a href="bascket.html">购物车</a>
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
				<li><a href="index.html">Home</a></li> &nbsp;&nbsp;/&nbsp;
				<li class="act">&nbsp;已认证的作品</li>
			</ul>
		</div>
		<div class="coats">
			<h3 class="c-head">已认证作品</h3>
			<div class="coat-row">
				<?php
					header("Content-type: text/html;charset=utf-8");
					session_start();

					$user = $_SESSION['user'];
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
						$sql="select picname,date,filepath from certification where user='$user'";
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
							$date=$row['date'];
							if ($count%4==0){
								echo "&emsp;";
								echo "<div class='clearfix'></div>";}
							echo "
								<div class='coat-column'>
									<a href='$filepath'>
											<img src='$filepath' class='img-responsive' alt=''>
										<div class='prod-desc'><h4>$picname</h4>
										<small>上传时间：.$date</small></div>
									</a>
									<div class='mask'>
													<div class='info'><a href='$filepath'>View</a></div>
									 </div>
								</div>";
								
							}
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