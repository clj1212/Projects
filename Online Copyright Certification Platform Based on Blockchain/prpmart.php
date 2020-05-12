<?php    
    session_start();
    $user = $_SESSION['user'];

    $error = error_get_last();  
    if ($error['message']=='Undefined index: user') {
        echo "请重新登陆，页面正在跳转...";
        echo "<meta http-equiv='Refresh' content='4;URL=2_login.html'>";
    };
    $con=mysqli_connect("127.0.0.1","root","masae980824","test");
    mysqli_set_charset( $con,"utf8" );//使数据库中的数据以utf8格式显示在网页上
    if (!$con) {
        die("数据库连接失败: " . mysqli_error($con));
    }
    $sql="select description,filename,date,filepath,price from image";
    $result=mysqli_query($con,$sql); 

    echo '
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="mystyle.css" rel="stylesheet" type="text/css" />        
        <title>Upload Page</title>
    </head>
    <body>
        <h1>
            <div id="nav">
                <form action="2_upload.html" method="get">
                    <input type="submit" name="uploadsubmit" id="btnupload" value="上传新作品" class="clickButton"/>
                </form>
            </div>
            <div id="nav">
                <form action="2.2_overview.php" method="get">
                    <input type="submit" name="overviewsubmit" id="btnoverview" value="已提交作品" class="noButton"/>
                </form>
            </div>
            <div id="nav">
                <form action="3_shop.html" method="get">
                    <input type="submit" name="shopsubmit" id="btnshop" value="交易商城" class="clickButton"/>
                </form>
            </div>
            <div id="nav">
                <form action="4_personal.html" method="get">
                     <input type="submit" name="personalsubmit" id="btnpersonal" value="个人中心" class="clickButton"/>
                </form>
            </div>
        </h1>
        <br>
        <h2>
            <div id="section">
            <br>
            <br>
            <table border="1" style="text-align:center;font-size:16px; border: 1px solid grey;border-collapse:collapse" width="900" >
            <tr style = "background-color:#d0d0d0;color:white"> 
            <td> 作品名称 </td>
            <td> 作品描述 </td>  
            <td> 上传日期 </td>  
            <td> 图片预览 </td>
            </tr>
            ';        
    while($row = mysqli_fetch_assoc($result)){    
        echo "<tr> ";    
        $filepath = $row['filepath'];
        echo "<td><a href='$filepath'>".$row["filename"]."</a></td>";
        echo "<td width='500'>" . $row['description'] . "</td>";
        echo "<td width='170'>" . $row['price'] . "</td>";
		echo "<td width='170'>" . $row['date'] . "</td>";
        $filepath = $row['filepath'];
        echo "<td width='75'><img src='$filepath' height='50' width='75' > 
        <a href='$filepath' style='font-size:6px;color:#BEBEBE' >点击查看大图</a>
        </td>";
        echo "</tr>";
		echo "<div>
                <form action='3.2_pay.php' method='get>
                    <input type='submit' value='购买 class='noButton'/>
                </form>
            </div>";
    };
    echo '
            </div>
        </h2>
        <br>

    </body>
</html>
';

?>