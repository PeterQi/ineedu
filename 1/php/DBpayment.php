<?php
	include ("db.php");
    include_once ("preconfig.php");
?>
<html>
	<head>
        <script type="text/javascript" language="javascript" src="../js/check.js"></script>
		<title>支付愿望</title>
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
//	include "SessionSet.php";
	if($_GET['WishID']!=null)
	{
		$query="select `price`,`deadline`,`userID`,`name` from `wish` WHERE `ID`=".$_GET['WishID'];

		$result = mysql_query($query);
	
		if($result)
		{
			if(mysql_affected_rows()<1)
			{
				echo '没有此愿望<br/>';
			}
			else
			{
				$row = mysql_fetch_row($result);
				$pr=$row[0];
				$deadline=$row[1];
				$time=date("Y-m-d H:i:s",time());
				$userID=$row[2];
				$tmpUserInfo=FindUser($_SESSION["users"],$_SESSION["usernum"],$userID);
				$tmpScreenName=$tmpUserInfo["screen_name"];
				$wishName=$row[3];
				if($time>$deadline)
				{
					echo'此愿望已不能支付<br/>'; 
				}
				//echo $pr;
				else
				{
					$query="select `userID`,`Payed_amount` from `payment` WHERE wishID=".$_GET['WishID'];
					$result = mysql_query($query);
					$payed=0;
					if($result && mysql_affected_rows()>0)
					{
						while($row = mysql_fetch_row($result))
						{
				
							$payed+=$row[1];
		 		
					
						}
					}
					$tmp=$pr-$payed;
					if($payed+$_POST['Payed_amount']>$pr)
					{
						echo '您给的太多啦！<br/>';
						echo '剩余金额：'.$tmp.'<br/>';
//						echo '<button type="button" >返回</button>';
					}
					else
					{
						$insert="INSERT INTO `payment` (`userID`,`wishID`,`Payed_amount`) VALUES('".$_SESSION['oauth2']['user_id']."','".$_GET["WishID"]."','".$_POST["Payed_amount"]."')";
						$result = mysql_query($insert);
						if($result && mysql_affected_rows()>0)
						{
               	         				echo "交付成功！赶快告诉大家吧！";//：".mysql_insert_id()."<br>";
							echo '<h2>发送微博</h2>
<form action="Weibo.php" method="post">
<input type="text" name="text" value="@'.$tmpScreenName.'  我给你的愿望&quot;'.$wishName.'&quot;筹了资金，快来看看吧！http://apps.weibo.com/kingguko?wishID='.$_GET['WishID'].'" style=" width:600px" />
&nbsp;<input type="submit" />
</form>';
						}
						else
						{
							echo "交付失败！";//：".mysql_errno()."，错误原因：".mysql_error()."<br>";
						}
					}
				
				}
			}
		}
		else
		{
			echo "查询失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
		}

	}
	echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
	mysql_free_result($result);
	mysql_close($link);


?>
        </div>
    </div>
</html>
