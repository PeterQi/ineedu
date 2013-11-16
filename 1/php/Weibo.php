<?php
	include_once("preconfig.php");
	if( isset($_REQUEST['text']) )
	{
		$c->update( $_REQUEST['text'] );
		// 发送微博
		echo "<p>发送完成</p>";
		echo '<a href="../index.php"><button type="button type="button">返回首页</button></a>';
	}
?>
