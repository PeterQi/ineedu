<?php
	include_once ("preconfig.php");	

	include ("db.php");
if($_GET['WishID']!=null)
{
	$query="select `userID`,`name`,`price`,`deadline`,`reason`,`describe`,`time`,`recommend` from `wish` WHERE ID=".$_GET['WishID'];

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
			while($row = mysql_fetch_row($result))
			{
				$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row[0];
				$userinfo=CurlGet($url2);
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
			$query="select `userID`,`Payed_amount`,`time` from `payment` WHERE wishID=".$_GET['WishID']." ORDER BY time DESC";
			$result = mysql_query($query);
			if($IsMe==1)
			{
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
					echo '<th>交付人</th><th>交付金额</th><th>交付时间</th>';
					while($row = mysql_fetch_row($result))
					{
						echo '<tr>';
						$payed+=$row[1];
						$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row[0];
						$userinfo=CurlGet($url2);
						$url="http://www.weibo.com/".$row[0];
			 			foreach($row as $key => $data)
						{
							if($key==0)
							{
								echo '<td><a href="'.$url.'" target="_blank">'.$_SESSION['username'].'</a></td>';	
							}
							else
								echo '<td>'.$data.'</td>';	
						}
						echo '</tr>';
					}
					echo '</table>';
					echo '剩余金额：'.($totalprice-$payed).'<br/>';
				}
				$deleteurl="DeleteWish.php?wishID=".$_GET['WishID'];
				echo '<a href="'.$deleteurl.'">删除愿望</a><br/>';
			}
			else
			{
				$payed=0;
				if(mysql_affected_rows()>=1)
				{
					while($row = mysql_fetch_row($result))
					{
						$payed+=$row[1];
					}
				}
				echo '剩余金额：'.($totalprice-$payed).'<br/>';
			}

			
		}
//			$url=$_GET["action"].".php";
		$url="payment.php?WishID=".$_GET['WishID'];
		$time=date("Y-m-d H:i:s",time());
		if($time>$deadline)
			echo'此愿望已不能支付<br/>'; 
		else
			echo '<a href="'.$url.'">帮他支付</a><br/>';
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
