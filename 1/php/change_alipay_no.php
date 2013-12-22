<?php
	include "preconfig.php";
    include "db.php";
?>
<html>
	<head>
        <script type="text/javascript" language="javascript" src="../js/check.js"></script>
		<title>插入愿望</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	if(isset($_POST["alipay_no"]))
	{
		$changeAli=mysql_query('UPDATE `user_alipay_no` SET `alipay_no`="'.$_POST["alipay_no"].'" WHERE `userID`='.$_SESSION["oauth2"]['user_id']);	
		if($changeAli&&mysql_affected_rows()>0)
		{
			echo "修改成功！<br>";
			echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';		
			exit;
		}
		else
		{
			echo "修改失败！<br>".mysql_error();
			exit;
		}
	}
?>
    <form action="" method="post">
        新的支付宝账号：<input type="text" name="alipay_no"/>
    <input type="submit"/>
    </form>
        </div>
    </div>
</html>
