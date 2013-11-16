<?php
	include ("db.php");
	include_once ("preconfig.php");
//	include "SessionSet.php";
	$insert="INSERT INTO `wish` (`userID`,`name`,`price`,`deadline`,`reason`,`describe`,`recommend`) VALUES('".$_SESSION['oauth2']['user_id']."','".$_POST["WishName"]."','".$_POST["WishPrice"]."','".$_POST["WishDeadline"]."','".$_POST["WishReason"]."','".$_POST["WishDescribe"]."','".$_POST["Recommend"]."')";

	$result = mysql_query($insert);
	if($result && mysql_affected_rows()>0)
	{
		$wishID=mysql_insert_id();
		$cu=0;
		$nxtCu=1;
		$page=0;
		while($nxtCu!=0)
		{
			$url="https://api.weibo.com/2/friendships/followers/ids.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id']."&cursor=$cu";
			$UserFollowersIDs[$page]=CurlGet($url);
			$nxtCu=$UserFollowersIDs[$page]["next_cursor"];
			$cu=$nxtCu;
			$page++;
		}
		$recordNum=0;
		$UserFollowersIDs[$page-1]["ids"][count($UserFollowersIDs[$page-1]["ids"])]=$_SESSION['oauth2']['user_id'];
//		var_dump($UserFollowersIDs[$page-1]["ids"]);
		for($i=0;$i<$page;$i++)
			foreach($UserFollowersIDs[$i]["ids"] as $data)
			{
				$SelResult=mysql_query("select `id`,`wishID`,`WishTime` from ms".$data." ORDER BY WishTime DESC");
				if($SelResult)
				{
		//			echo $data."<br/>";
					$flag=mysql_affected_rows();
					SemWait("ms".$data);	
		//			if(mysql_query("LOCK TABLE ms".$data." write"))
					{
						$num=1;
						if($flag>0)
						{
							while($row=mysql_fetch_assoc($SelResult))
							{
								$time=date("Y-m-d H:i:s",time());
								if($row['WishTime']<$time)
								{
									$num=$row['id'];
		//							echo $num."<br/>";
									break;
								}
							}
						}
						mysql_query("BEGIN");
						for($j=$flag;$j>=$num;$j--)
						{
							if($j>=100)
								continue;
							$Select1=mysql_query("select `id`,`wishID`,`WishTime` from ms".$data." WHERE `id`=".$j);
							$SelRow=mysql_fetch_assoc($Select1);
							$InsQuery1=mysql_query("INSERT INTO `ms".$data."` VALUES(".($j+1).",".$SelRow['wishID'].',"'.$SelRow['WishTime'].'")');
							$UpQuery=true;
							if(!$InsQuery)
							{
			//					echo mysql_errno().":::".mysql_error()."<br/>";
								$UpQuery=mysql_query("UPDATE `ms".$data."` SET `wishID`=".$SelRow['wishID'].',`WishTime`="'.$SelRow['WishTime']. '" WHERE `id`='.($j+1));
			//					echo mysql_errno()."::".mysql_error()."<br/>";
							}
							if(!$UpQuery) 
							{
								mysql_query("ROLLBACK");
	//							mysql_query("UNLOCK TABLE");
								SemPost("ms".$data);
			//					echo mysql_errno().":".mysql_error()."<br/>";
								echo "发送愿望失败<br/>";
								die();
								break;
							}
							
						}
						$InsQuery=mysql_query("INSERT INTO `ms".$data."` VALUES($num,$wishID,CURRENT_TIMESTAMP)");
						$UpQuery2=true;
						if(!$InsQuery)
							$UpQuery2=mysql_query("UPDATE `ms".$data."` SET `id`=$num,`wishID`=$wishID,`WishTime`=CURRENT_TIMESTAMP WHERE `id`=$num");
						if(!$UpQuery2)
						{
							mysql_query("ROLLBACK");
//							mysql_query("UNLOCK TABLE");
							SemPost("ms".$data);
							echo "发送愿望失败<br/>";
							die();
						}
						mysql_query("COMMIT");
						SemPost("ms".$data);
//						mysql_query("UNLOCK TABLE");
					}
/*					else
					{
						echo mysql_errno().':'.mysql_error()."<br/>";
					}*/
				
				}
			}
        echo "愿望插入成功！<br>";
		
	}
	else
	{
		echo "愿望插入失败！<br>";//错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
	}
	echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
	mysql_free_result($result);
	mysql_close($link);
?>

<h2>发送微博</h2>
<form action="Weibo.php" method="post">
<input type="text" name="text" value="我有一个愿望 “<?php echo $_POST["WishName"]."”，快来看看吧！http://apps.weibo.com/kingguko"; ?>" style=" width:300px" />
&nbsp;<input type="submit" />
</form>
