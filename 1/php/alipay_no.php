<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title>获取支付宝账户</title>
        <link rel="stylesheet" href="../css/link.css" type="text/css">
        <link rel="stylesheet" href="../css/layout.css" type="text/css">
        <link rel="stylesheet" href="../css/font.css" type="text/css">
        <link rel="stylesheet" href="../css/style.css" type="text/css">
    </head>
    <body>
    <div id="container">
            <div id="headwrap">
                <div class="head">
                    <a href="./index.php" class="logo">
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
	include "preconfig.php";
	include "db.php";
	$select="SELECT * FROM `user_alipay_no` where `userID`=".$_SESSION['oauth2']['user_id'];
	$selectRes=mysql_query($select);
	if($selectRes)
	{
		if(mysql_affected_rows()<1)
		{
			if(isset($_POST['alipay_no']))
			{
				$insert="INSERT INTO `user_alipay_no` VALUES (".$_SESSION['oauth2']['user_id'].',"'.$_POST['alipay_no'].'")';
		
				$insertRes=mysql_query($insert);
				if($insertRes&&mysql_affected_rows()>0)
				{
					echo '输入成功！';
					echo '<a href="javascript:history.go(-2);" title="返回上一页"><button type="button type="button">返回</button></a>';
					exit;
				}
				else
				{
					echo "输入失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br/>";
				}
			}
            echo '<div class="ali-account">
                    <form action="" method="post">
                        <label>请输入您的支付宝账号：</label>
                        <div class="input"><input type="text" name="alipay_no" class="input-t"></div>
                        <div class="input"><input type="submit" value="提交" class="input-s"></div>
                        <label>*填写支付宝帐号必须是自己的!</label>
                    </form><br>
                  </div>';
			exit;
		}
	}
	else
	{
		echo "查询失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br/>";
		exit;
	}
?>
            </div>
        </div>
    </body>
</html>
