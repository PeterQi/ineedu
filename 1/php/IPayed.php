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
        <div id="container">
            <div id="header">
                <div id="logo">I Need you</div>
                <div id="banner"><h2>插入愿望</h2></div>
                <div id="hi">
                </div>
            </div>
            <div class="gap"></div>
            <div id="navfirst">
                <ul id="menu">
                    <li><a href="../php/insert.php">发布愿望</a></li>		
		            <li><a href="../php/friends.php">关注的人</a></li>
		            <li><a href="../php/MyWish.php">我的愿望</a></li>
		            <li><a href="../php/IPayed.php">我支付的</a></li>
                    <li><a href="../php/insert.php">关于我们</a></li>
                </ul>
            </div>
            <div id="content">
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
			                echo '<table align="center" width="740" border="1" cellpadding="2" cellspacing="0">
			                      <caption align="center"><h1>已支付的愿望</h1></caption>';
			                echo '<th>支付号</th><th>支付人</th><th>愿望名</th><th>愿望人</th><th>支付金额</th><th>支付时间</th>';
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
									$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$row2[1];
									$userinfo5=CurlGet($url2);
									$url5="http://www.weibo.com/".$row2[1];

								}
				        		echo '<tr>';
			 			    	foreach($row as $key=>$data)
					    		{
							    	if($key==2)
							    	{
										echo '<td><a href="'.$url4.'">'.$row2[0].'</a></td>';	    					
										echo '<td><a href="'.$url5.'" target="_blank">'.$userinfo5['screen_name'].'</a></td>';
					    			}
								    else if($key==1)
									{
										$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$data;
										$userinfo=CurlGet($url2);
										$url2="http://www.weibo.com/".$data;
										echo '<td><a href="'.$url2.'" target="_blank">'.$userinfo['screen_name'].'</a></td>';
									}
									else
							    		echo '<td>'.$data.'</td>';	

					    		}
						        echo '</tr>';
				            }	
				            echo '</table>';	
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

