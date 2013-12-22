<?php
	include_once ("preconfig.php");
    include_once ("db.php");
?>
<html>
	<head>
        <script type="text/javascript" language="javascript" src="../js/check.js"></script>
		<title>删除愿望</title>
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
        </div>
    </div>
</html>
