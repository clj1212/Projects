<?php
$a = "world";
$aa='bbbbb';
echo "<a href='try.php?m=$a&j=$aa'>删除</a>";    

?>
<a href="try.php?m=<?php echo $a;?>">点我跳到try.php</a>