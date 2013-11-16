<?php
	include_once ("preconfig.php");
	include_once ("db.php");
	$SelQuery="SELECT `userID` FROM `wish` WHERE `ID`=".$_GET["wishID"];
//	var_dump($_GET["wishID"]);
	$SelResult=mysql_query($SelQuery);
//	var_dump($SelResult);
	if($SelResult && mysql_affected_rows()>0)
	{
		$row=mysql_fetch_assoc($SelResult);
		
//			var_dump($row);
//			var_dump($_SESSION['oauth2']['user_id']);
			if($row['userID']!=$_SESSION['oauth2']['user_id'])
			{
				echo "删除失败！<br/>";
				echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
				die();
			}
		
	}
	else
	{
		echo "愿望不存在！<br/>";
		echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
		die();
	}
	$DelQuery="DELETE FROM wish WHERE ID=".$_GET["wishID"];
	$DelResult=mysql_query($DelQuery);
	if($DelResult && mysql_affected_rows()>0)
	{
		echo "删除成功!<br/>";	
		echo '<a href="../index.php"><button type="button type="button">返回首页</button></a>';
	}
	else
	{
//		echo mysql_errno().":".mysql_error()."<br/>";
		echo "删除失败！<br/>";	
		echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
	}
	mysql_close($link);
?>
