<?php
    	include_once ("preconfig.php");	
//	include_once (".SessionSet.php");
//	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//	$userinfo=CurlGet($url);
    	include ("db.php");
?>
<html>
	<head>
		<title>我支付的愿望</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../css/layout.css" type="text/css">
        <link rel="stylesheet" href="../css/link.css" type="text/css">
        <link rel="stylesheet" href="../css/font.css" type="text/css">
        <link rel="stylesheet" href="../css/style.css" type="text/css">
	</head>
    <body>
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
                <div class="changeaccount">
                    <a href="./change_alipay_no.php">更改支付宝账户</a>
                </div>
                <?php
	                $query="select `PaymentID`,`userID`,`wishID`,`Payed_amount`,`time` from `payment` WHERE userID=".$_SESSION['oauth2']['user_id']." ORDER BY time DESC";

	                $result = mysql_query($query);
	
	                if($result)
	                {
		                if(mysql_affected_rows()<1)
		                {
			                echo '您还没有为朋友支付过愿望<br/>';
	                	}
		                else
                        {
                            echo '<ul>';
			                //echo '<table align="center" width="740" border="1" cellpadding="2" cellspacing="0">
			                //     <caption align="center"><h1>已支付的愿望</h1></caption>';
			                //echo '<th>支付号</th><th>支付人</th><th>愿望名</th><th>愿望人</th><th>支付金额</th><th>支付时间</th>';
			                while($row = mysql_fetch_row($result))
			           		{
								$SelQuery="SELECT `name`,`userID` FROM `wish` WHERE ID=".$row[2];
								$SelResult=mysql_query($SelQuery);
								if(!$SelResult || mysql_affected_rows()<1)
								{	
									continue;
								}
								else
								{
									$url4="WishInfo.php?WishID=".$row[2]."&action=IPayed";	
								 	$row2 = mysql_fetch_row($SelResult);
//								    echo '<td><a href="'.$url.'">'.$row2[0].'</a></td>';
//									$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row2[1];
									$userinfo5=FindUser($_SESSION['users'],$_SESSION['usernum'],$row2[1]);
									$url5="http://www.weibo.com/".$row2[1];

                                }
                                echo '<div class="ipayed-one"><li><ul>';
								echo '<li>支付号：'.$row[0].'</li>';
								$userinfo=FindUser($_SESSION['users'],$_SESSION['usernum'],$row[1]);
										
								$url2="http://www.weibo.com/".$row[1];
								echo '<li>支付的人：<a href="'.$url2.'" target="_blank">'.$userinfo['screen_name'].'</a></li>';

                                echo '<li>愿望内容：<a href="'.$url4.'">'.$row2[0].'</a></li>';
                                echo '<li>许愿好友：<a href="'.$url5.'" target="_blank">'.$userinfo5['screen_name'].'</a></li>';
								echo '<li>支付金额：'.$row[3].'</li>';
								echo '<li>支付时间：'.$row[4].'</li>';
                                echo '</ul></li></div>';
						        //echo '</tr>';
                            }
                            echo '</ul>';    
				            //echo '</table>';	
		                }
		                mysql_free_result($result);
		                mysql_close($link);
	                }
	                else
	                {
		                echo "查询记录失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
						mysql_close($link);
                	}
                ?>
            </div>
        </div>
	</body>
</html>

