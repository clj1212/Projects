<!--下面html里面要加入single.php的上传作品信息,交易也要设置区块链相关的密钥!-->

<!DOCTYPE HTML>
<html>
<head>
<title>Blockchain Picture Copyright | Register :: w3layouts</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' media="all" />
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
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
					<div class="logo"><a href="personal.php">个人中心</a></div>
					<span class="menu"></span>
					<script>
						$( "span.menu" ).click(function() {
						  $( ".navig" ).slideToggle( "slow", function() {
						    // Animation complete.
						  });
						});
					</script>
					<div class="navig">
						<ul>
							<li><a href="certdisplay.php">已认证作品</li>
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
				<li><a href="personal.php">个人中心</a></li> &nbsp;&nbsp;/&nbsp;
				<li class="act">&nbsp;新交易作品设置</li>
			</ul>
		</div>
		<div class="coats">
			<h3 class="c-head">作品信息</h3>
			<p>！！！！！！！！！！！！！！！下面这些模块要填充作品相关信息的内容嗷~~~~提交的手续也要增多一点点</p>
			<?php
				header("Content-type: text/html;charset=utf-8");
				session_start();

				$user = $_SESSION['user'];
				$pichash=$_GET['pichash'];
				$_SESSION['pichash']=$pichash;
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
				$sql="select * from certification where pichash='$pichash'";
				$result=mysqli_query($conn,$sql); 
				if (!$result) {
					printf("Error: %s\n", mysqli_error($conn));
					exit();}
				else {
					while($row = mysqli_fetch_assoc($result)){
					$filepath = $row['filepath'];
					$picname=$row['picname'];
					$date=$row['date'];
					$pichash=$row['pichash'];
					$description=$row['description'];
					echo "
						<div>
							<img src='$filepath' class='img-responsive' alt=''>
							<div class='prod-desc'><h4>$picname</h4>
							<small>上传时间：.$date</small></div>
							<small>简介：.$description</small></div>							
						</div>";
					}
				}
					}
					?>

<div class="register">
		<form action="pricesetting.php" method="post" onsubmit="return check();" enctype="multipart/form-data">
			<div>
				<small>商品标题</small>
				<div class="text">
					<input type="text" name="proname" id="pw1" maxlength="40" placeholder="40字以内" onkeyup="vali()"/><span id="tis"></span>
				</div>
				<small>主题</small>
				<div class="text">
					<Select name="style" id="style">
						<option value=""> </option>
						<option value="s1">风景</option>
						<option value="s2">人物</option>
						<option value="s3">动漫</option>
						<option value="s4">设计</option>
						<option value="s5">其他</option>
					</Select> 
				</div>
			</div>
				<small>商品价格</small>
				<div class="text">
					<input type="number" name="price" id="price" min="0.00" step="0.01" placeholder="单位：人民币；格式：xx.xx"/><span id="tis"></span>
				</div>
				<script>
			 	function vali() {
				var pw1 = document.getElementById("pw1").value;
				if(pw1.length>0){
				if(pw1.length<41) {
				document.getElementById("tis").innerHTML="<font color='green'>名称合格</font>";
				}
				else {
				document.getElementById("tis").innerHTML="<font color='red'>请输入40字以内</font>";
				}
				}
				else{
				document.getElementById("tis").innerHTML="<font color='red'>请输入商品标题</font>";
				}
				}
				</script>
			</div>
			<div class="clearfix"></div>
			<div class="form">
					<small>版权条款简介</small>
				<div class="text">
					<textarea name="clause" id="clause" class="easyui-validatebox" 
					onKeyUp="if(this.value.length>2000) this.value=this.value.substr(0,1000)" 
					maxlength="1000"></textarea>
					<font color="#C0C0C0">限输入1000个汉字包括标点</font>
				</div>
			</div>
<!--			<div class="form">
				<small>上传版权条款细则</small>
				<div class="text">
					<input type="file" name="file0" id="file0" multiple="multiple"  /><br>  		
				</div>
			</div>
			<div class="text">
				<input type="submit" value="send"/>
			</div>
		</form>
!-->
		<script type="text/javascript">
            function check() {
                if(document.getElementById("pw1").value==""){
                    alert("请输入图片名称");
                    return false;
                }
				if(document.getElementById("price").value==""){
                    alert("请输入价格");
                    return false;
                }
				if(document.getElementById("clause").value==""){
                    alert("简要介绍一下授权范围可以减少纠纷嗷");
                    return false;
                }
								if(document.getElementById("style").value==""){
                    alert("请选择图片分类");
                    return false;
                }
                return true;
            }
        </script>
		
		<div class="register-but">
			   <form>
					<div class="text">
						<input type="submit" value="确认" />
					</div>
			   </form>
		</div>

	</form>
	</div>
			</div>
</section>
</body>
</html>