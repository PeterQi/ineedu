<?php
	include_once ("preconfig.php");	
    include ("db.php");
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
if(isset($_GET['WishID']))
{
	$query="select `userID` from `wish` WHERE ID=".$_GET['WishID'];
	$result = mysql_query($query);
	$IsMe=0;
	if($result)
	{
		if(mysql_affected_rows()<1)
		{
			echo '此愿望已被删除！<br/>';
			die();
		}
		else
		{
			while($row = mysql_fetch_row($result))
			{
				if($row[0]==$_SESSION['oauth2']['user_id'])
					$IsMe=1;
			}
		}
	}
	if($IsMe==1)
	{
		if(isset($_POST["payed"]))
		{
			if($_POST["payed"]=="Yes")
			{
				$yesUp=mysql_query("UPDATE `payment` SET `centain`='1' WHERE `PaymentID`=".$_GET["PaymentID"]);
				if($yesUp&&mysql_affected_rows()>0)
				{
					echo '确认成功！<a href="javascript:history.go(-2);" title="返回上一页"><button type="button type="button">返回</button></a>';
				}	
				else
				{
					echo '确认失败！'.mysql_errno().':'.mysql_error().'<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
				}
			}
			else
				echo '<a href="javascript:history.go(-2);" title="返回上一页"><button type="button type="button">返回</button></a>';
			exit;
		}
		$userinfo=FindUser($_SESSION['users'],$_SESSION['usernum'],$_GET["hisID"]);
		$alipay_no=mysql_query("select `alipay_no` from `user_alipay_no` where userID=".$_GET["hisID"]);
		if($alipay_no&&mysql_affected_rows()>0)
		{
			$row=mysql_fetch_row($alipay_no);
			echo $userinfo['screen_name']."的支付宝是".$row[0]."<br>";
			echo '他确实给您的支付宝付款了'.$_GET["Payed_amount"].'元。<form action="" method="post">是的：
			<input type = "radio" checked="checked" name="payed" value="Yes"/>	<br/>
			<input type="submit" value="提交"><br/>
			</form>';
			echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
			
		}
		else
		{
			echo '他还没有告诉我们他的支付宝。';
		}
	}
}
?>
        </div>
    </div>
</html>
