<?php
    	include_once ("preconfig.php");	
	    	include ("db.php");
				

?>
<html>
	<head>
		<title>我关注的人的愿望</title>
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
                <div id="banner"><h2>关注的人</h2></div>
                <div id="hi">
                    <?php
//						$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//						$userinfo=CurlGet($url);
					//	var_dump($userinfo);
			           // echo '您好：<a href="../index.php">'.$_SESSION["username"].'</a>';
	            	?>
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
					$cu=0;
					$nxtCu=1;
					$page=0;
					while($nxtCu!=0)
					{
						$url="https://api.weibo.com/2/friendships/friends.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']                        ['user_id']."&cursor=$cu";
						$UserFriendsIDs[$page]=CurlGet($url);
						$nxtCu=$UserFriendsIDs[$page]["next_cursor"];
						$cu=$nxtCu;
						$page++;
					}
					echo '<table align="center" width="726" border="1" cellpadding="2" cellspacing="0">
			                      <caption align="center"><h1>好友的愿望</h1></caption>';
      				echo '<th>我关注的人</th>';
					for($i=0;$i<$page;$i++)
					foreach($UserFriendsIDs[$i]["users"] as $data)
					{
						echo '<tr><td><a href="Wishes.php?username='.$data["screen_name"].'">'.$data["screen_name"].'</a></td></tr>';
					}    
	                mysql_close($link);
            ?>
            </div>
        </div>
	</body>
</html>

