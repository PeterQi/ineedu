<?php
	include ("db.php");
	include_once ("preconfig.php");
//	include "SessionSet.php";
	if($_GET['WishID']!=null)
	{
		$query="select `price`,`deadline` from `wish` WHERE `ID`=".$_GET['WishID'];

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
               	            echo "交付成功！";//：".mysql_insert_id()."<br>";
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


