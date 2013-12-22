<?php
	include_once ("preconfig.php");	
    include ("db.php");
?>
<html>
    <head>
        <title>愿望信息</title>
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
if($_GET['WishID']!=null)
{
	if(isset($_POST["comment"])	)
	{
		$insertCom=mysql_query('INSERT INTO `comment`(`wishID`,`userID`,`content`) VALUES ("'.$_GET['WishID'].'","'.$_SESSION['oauth2']['user_id'].'","'.$_POST["comment"].'")');
		if(!($insertCom&&mysql_affected_rows()>0))
		{
			echo "评论失败！".mysql_error()."<br/>";
		}
	}
	$query="select `userID`,`name`,`price`,`deadline`,`reason`,`describe`,`time`,`recommend`,`trade` from `wish` WHERE ID=".$_GET['WishID'];
	
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
			echo '<table align="center" width="500" border="1" cellpadding="2" cellspacing="0">
			<caption align="center"><h1>愿望</h1></caption>';
		//	$tradenum="";
			$unfinish=0;
			while($row = mysql_fetch_row($result))
			{
				$tradenum=$row[8];
//				$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row[0];
				$userinfo=FindUser($_SESSION['users'],$_SESSION['usernum'],$row[0]);
				if($row[0]==$_SESSION['oauth2']['user_id'])
					$IsMe=1;
				$url="http://www.weibo.com/".$row[0];
				echo '<td>用户：<a href="'.$url.'" target="_blank">'.$userinfo['screen_name'].'</a></td>';	
//				echo '<tr><td>用户：'.$row[0].'</td></tr>';
				echo '<tr><td>愿望名：'.$row[1].'</td></tr>';
				echo '<tr><td>价格：'.$row[2].'</td></tr>';
				echo '<tr><td>截止日期：'.$row[3].'</td></tr>';
				echo '<tr><td>理由：'.$row[4].'</td></tr>';
				echo '<tr><td>描述：'.$row[5].'</td></tr>';
				echo '<tr><td>发布愿望时间：'.$row[6].'</td></tr>';
				echo '<tr><td>推荐支付金额：';
				if($row[7]!=null&&$row[7]>0)echo $row[7].'</td></tr>';
				else echo '无</td></tr>';
				$totalprice=$row[2];
				$deadline=$row[3];
			}	
			echo '</table>';
			$query="select `userID`,`Payed_amount`,`time`,`PaymentID`,`centain` from `payment` WHERE wishID=".$_GET['WishID']." ORDER BY time DESC";
			$result = mysql_query($query);
			$payed=0;
				if(mysql_affected_rows()<1)
				{
					echo '此愿望仍没有人为之交付<br/>';
					echo '剩余金额：'.$totalprice.'<br/>';

				}
				else
				{
					echo '<table align="center" width="500" border="1" cellpadding="1" cellspacing="4">
					<caption align="center"><h1>交付记录</h1></caption>';
					$payed=0;
					echo '<th>交付人</th><th>交付金额</th><th>交付时间</th><th>已确认</th>';
					while($row = mysql_fetch_row($result))
					{
						echo '<tr>';
						$payed+=$row[1];
					//	$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row[0];
						$userinfo=FindUser($_SESSION['users'],$_SESSION['usernum'],$row[0]);
						$url="http://www.weibo.com/".$row[0];
						$tmprow0=$row[0];
						$paymentID=$row[3];
						$payed_amount=$row[1];
			 			foreach($row as $key => $data)
						{
							if($key==0)
							{
								echo '<td><a href="'.$url.'" target="_blank">'.$userinfo['screen_name'].'</a></td>';	
							}
							else if($key==4)
							{
								echo '<td>';
								if($data==0)
								{
									if($IsMe==1)
									{
										echo '<a href="centainThat.php?hisID='.$tmprow0.'&WishID='.$_GET["WishID"].'&PaymentID='.$paymentID.'&Payed_amount='.$payed_amount.'">';
										echo '否</a>';
										$unfinish=1;
									}
									else
										echo '否';
								}
								else
									echo '是';
								echo '</td>';
							}
							else if($key!=3)
								echo '<td>'.$data.'</td>';	
						}
						echo '</tr>';
					}
					echo '</table>';
					echo '剩余金额：'.($totalprice-$payed).'<br/>';
				}
			if(isset($_GET["ShowComment"])&&$_GET["ShowComment"]==1)
			{
				echo '<a href="WishInfo.php?ShowComment=0&WishID='.$_GET["WishID"].'">查看评论</a>';
				$comments=mysql_query('SELECT `userID`,`content`,`time` FROM `comment` WHERE wishID='.$_GET['WishID']);
				if($comments&&mysql_affected_rows()>0)
				{
					echo '<table align="center" width="500" border="1" cellpadding="1" cellspacing="4">
					<caption align="center"><h1>评论</h1></caption>';
					echo '<th>评论人</th><th>评论</th><th>评论时间</th>';
					while($c_row = mysql_fetch_row($comments))
					{
						echo '<tr>';
						$userinfo=FindUser($_SESSION['users'],$_SESSION['usernum'],$c_row[0]);
						$url="http://www.weibo.com/".$c_row[0];
//						$tmprow0=$row[0];
//						$paymentID=$row[3];
//						$payed_amount=$row[1];
			 			foreach($c_row as $key => $data)
						{
							if($key==0)
							{
								echo '<td><a href="'.$url.'" target="_blank">'.$userinfo['screen_name'].'</a></td>';	
							}
							else
							{
								echo '<td>'.$data.'</td>';
							}
						}
						echo '</tr>';
					}
					echo '</table>';
				}
				else
				{
					echo '<br/>此愿望仍没有评论<br/>';

				}
			}
			else
			{
				echo '<a href="WishInfo.php?ShowComment=1&WishID='.$_GET["WishID"].'">查看评论</a>';
			}
			echo '<form action="WishInfo.php?ShowComment=1&WishID='.$_GET["WishID"].'" method="post">
			<input type="text" name="comment"/>
			<input type="submit" value="评论"/></form>';
			if($IsMe == 1)
			{
				if($tradenum=="")
				{
					$deleteurl="DeleteWish.php?wishID=".$_GET['WishID'];
					$_SESSION["wishIDtrade"]=$_GET['WishID'];
					if($totalprice==$payed&&$unfinish==0)
					{
						echo '<a href="http://www.taobao.com" target="_blank">去淘宝下订单！</a><br/>';
						echo '请提供订单号：
<form action="testTaobao.php" method="get">
<input type="text" name="tradeID"/>
<input type="submit" value="确定"/>
</form><br/>';
					}
					echo '<a href="'.$deleteurl.'">删除愿望</a><br/>';
				}
				else
				{
					$selRes=mysql_query('SELECT * FROM `trade` WHERE `tid`='.$tradenum);
					if($selRes&&mysql_affected_rows()>0)
					{
						$trade=mysql_fetch_assoc($selRes);
						echo "订单号：".$trade['tid']."<br>";
						echo "商品号：".$trade['num_iid']."<br>";
						echo "创建时间：".$trade['created']."<br>";
						echo "交易标题：".$trade['title']."<br>";
						echo "商品价格：".$trade['price']."<br>";
						echo "商品金额：".$trade['total_fee']."<br>";
						echo "付款时间：".$trade['pay_time']."<br>";
						echo "交易结束时间：".$trade['end_time']."<br>";
						echo "买家的支付宝id号：".$trade['alipay_id']."<br>";
						echo "支付宝交易号：".$trade['alipay_no']."<br>";
						echo "买家昵称：".$trade['buyer_nick']."<br>";
						echo "卖家昵称：".$trade['seller_nick']."<br>";
						echo "图片链接：".$trade['pic_path']."<br>";
						echo "买家支付宝帐号：".$trade['buyer_alipay_no']."<br>";
						echo "收货人姓名：".$trade['receiver_name']."<br>";
						echo "收货人所在省份：".$trade['receiver_state']."<br>";
						echo "卖家发货时间：".$trade['consign_time']."<br>";
						echo "卖家姓名：".$trade['seller_name']."<br>";
//	echo $resp->tid."<br>";
    //}
					}
					//else
					//{
					//	echo mysql_errno().":".mysql_error();
					//}
				}
			}
			else
			{
				$url="payment.php?WishID=".$_GET['WishID'];
				$time=date("Y-m-d H:i:s",time());
				$selRes=mysql_query('SELECT * FROM `trade` WHERE `tid`='.$tradenum);
					if($selRes&&mysql_affected_rows()>0)
					{
						$trade=mysql_fetch_assoc($selRes);
						echo "订单号：".$trade['tid']."<br>";
						echo "商品号：".$trade['num_iid']."<br>";
						echo "创建时间：".$trade['created']."<br>";
						echo "交易标题：".$trade['title']."<br>";
						echo "商品价格：".$trade['price']."<br>";
						echo "商品金额：".$trade['total_fee']."<br>";
						echo "付款时间：".$trade['pay_time']."<br>";
						echo "交易结束时间：".$trade['end_time']."<br>";
						echo "买家的支付宝id号：".$trade['alipay_id']."<br>";
						echo "支付宝交易号：".$trade['alipay_no']."<br>";
						echo "买家昵称：".$trade['buyer_nick']."<br>";
						echo "卖家昵称：".$trade['seller_nick']."<br>";
						echo "图片链接：".$trade['pic_path']."<br>";
						echo "买家支付宝帐号：".$trade['buyer_alipay_no']."<br>";
						echo "收货人姓名：".$trade['receiver_name']."<br>";
						echo "收货人所在省份：".$trade['receiver_state']."<br>";
						echo "卖家发货时间：".$trade['consign_time']."<br>";
						echo "卖家姓名：".$trade['seller_name']."<br>";
//	echo $resp->tid."<br>";
    //}
					}
				if($time>$deadline||$totalprice==$payed)
					echo'此愿望已不能支付<br/>'; 
				else
					echo '<a href="'.$url.'">帮他支付</a><br/>';
				/*$payed=0;
				if(mysql_affected_rows()>=1)
				{
					while($row = mysql_fetch_row($result))
					{
						$payed+=$row[1];
					}
				}
				echo '剩余金额：'.($totalprice-$payed).'<br/>';*/
			}
		/*	if(isset($_SESSION["trade"])
			{
				
			}*/

			
		}
//			$url=$_GET["action"].".php";
		
		echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
//		echo '<a href="'.$url.'"><button type="button">返回</button></a>';
		mysql_free_result($result);
		mysql_close($link);
		

	}
	else
	{
		echo "查询记录失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
	}
}
?>
            </div>
        </div>
    </body>
</html>
