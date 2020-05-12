
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
							<span class="bascket"></span><a>购物车</a>
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
				<li><a href="market_login.php">购物商城</a></li> &nbsp;&nbsp;/&nbsp;
				<li class="act">&nbsp;购物车</li>
			</ul>
		</div>
		
		
<?php
header("Content-type: text/html;charset=utf-8");
session_start();
$user=$_SESSION['user'];
if (!isset($_SESSION['basket'])){
	$number=0;
	echo "
	<div class='coats sing-c'>
	<h3 class='c-head'>我的购物车($number)</h3>
	<p>购物车空空如也~去<a href='market.php'>here</a>逛逛吧~</p>
			</div>
";
}
else{
	$basket=$_SESSION['basket'];
	$number=count($basket);
if ($number==0){
	echo "
		<div class='coats sing-c'>
	<h3 class='c-head'>我的购物车($number)</h3>
	<p>购物车空空如也~去<a href='market.php'>交易商城</a>逛逛吧~</p>
			</div>
";}
else {
	echo "
		<div class='coats sing-c'>
	<h3 class='c-head'>我的购物车($number)</h3></br></br></br>
	</div>
	        <div id='section'>
            <br>
            <table width='2000px' cellspacing='0' cellpadding='5'>
	      <tr bgcolor='#ddd'>
          <th></th>
          <th >作品名称</th>
          <th >作品简述</th>
          <th >作者</th>
          <th >认证日期</th>
          <th align='left'>作品价格</th>
          <th></th>
        </tr>
    ";
/*<div class='cloudMtxTable_body'>
      <table class='cloudTable'  style='table-layout:fixed'  border='1' cellspacing='0'>
        <colgroup >
          <col width='1000px'>
          <col width='1000px'>
          <col width='1000px'>
          <col width='1000px'>
          <col width='1000px'>
          <col width='1000px'>
          <col width='1000px'>
        </colgroup>
        <tbody class='cloudTable_body'>
					  "; */
				$p=0;
	for($x=0;$x<$number;$x++) {
		$pichash=$basket[$x];
	$conn =mysqli_connect("127.0.0.1","root","masae980824","prp");             
	if (!$conn){                
	echo '数据库连接失败！';                
	exit(0);            
	}
	else { 
		mysqli_set_charset( $conn,"utf8" );//使数据库中的数据以utf8格式显示在网页上
		$sql="select * from tradable where pichash='$pichash'";
		$result=mysqli_query($conn,$sql); 
		if (!$result) {
			printf("Error: %s\n", mysqli_error($conn));
			exit();}
		else {
			while($row = mysqli_fetch_assoc($result)){
				$picname=$row['picname'];
				$proname=$row['proname'];
				$picpath=$row['filepath'];
				$clause=substr($row['clause'],0,100);
				$user1=$row['user'];
				$date=$row['certdate'];
				$price=$row['price'];
				
				echo "
                    <tr >
                        	<td><img src='$picpath' height='200' width='200' /></td> 
                        	<td><a href='product.php?pichash=$pichash'>$picname  $proname</td> 
                            <td align='center'>$clause</td>
                            <td align='right'>$user1</td> 
                            <td align='right'>$date</td>
							<td align='right'>$price</td>
                            <td align='center'> <a href='remove.php?pichash=$pichash'><img src='images/remove_x.gif'/><br />移出购物车</a> </td>
						</tr>
						</br>
					";
				$price=floatval($price);
				$p=$price+$p;
			}
		}
	}
	}
	echo 
	//</tbody>

      //</table>
    "
  </div>
	</br>
	</br>
	<tr>
	<td></td><td></td><td></td><td></td><td></td>
	<td align='right' style='background:#ddd; font-weight:bold'> 总计 </td>
		<td align='middle' style='background:#ddd; font-weight:bold'>$p</td>
	</tr>
	<td style='background:#ddd; font-weight:bold'> </td>
	</table>
	<div class='reg'>
		<a href='market.php'>
			继续购物
		</a>
	</div>
	<div class='reg'>
		<a href='3.2_pay.php'>
			立即购买
		</a>
	</div>
	";
	
}
}



	
	




?>

		
		
		
		
		
	</div>
</section>
</body>
</html>