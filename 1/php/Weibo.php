<?php
    include_once("preconfig.php");
?>
<html>
	<head><title>微博分享</title>
        <link rel="stylesheet" href="../css/layout.css" type="text/css">
        <link rel="stylesheet" href="../css/link.css" type="text/css">
        <link rel="stylesheet" href="../css/font.css" type="text/css">
        <link rel="stylesheet" href="../css/style.css" type="text/css"> 
	</head>
    <body>
        <div id="container">
            <div id="headwrap">
                <div class="head">
                    <a href="../index.php" class="logo">
                        <img src="../image/logo.jpg" title="I Need U">
                    </a>
                    <div class="head-nav">
                        <ul class="head-nav-menu">
                            <li><a href="../index.php">首页</a></li>
                            <li><a href="./Search.php">搜索</a></li>
                            <li><a href="../index.php?update=1">更新</a><li>
                            <li><a href="./insert.php">发布愿望</a></li>		
		                    <li><a href="./friends.php">关注的人</a></li>
		                    <li><a href="./MyWish.php">我的愿望</a></li>
                            <li><a href="./IPayed.php">我支付的</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="content">
                <?php
	                if(isset($_GET['comment']))
	                {
		                echo "<p>分享成功</p>";
		                echo '<a href="../index.php"><button type="button type="button">返回首页</button></a>';
		                $c->update("想知道我的心愿吗？快来看看吧！http://apps.weibo.com/kingguko?uuID=".$_SESSION['oauth2']['user_id']);
	                }
	                if( isset($_REQUEST['text']) )
	                {
		                $c->update( $_REQUEST['text'] );
		                // 发送微博
		                echo "<p>发送完成</p>";
		                echo '<a href="../index.php"><button type="button type="button">返回首页</button></a>';
	                }
                ?>
            </div>
        </div>
	</body>
</html>
 

