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
                    echo '<ul><li>';
					//echo '<table align="center" width="726" border="1" cellpadding="2" cellspacing="0">
			        //          <caption align="center"><h1>好友的愿望</h1></caption>';
      				//echo '<th>我关注的人</th>';
					for($i=0;$i<$page;$i++)
					foreach($UserFriendsIDs[$i]["users"] as $data)
                    {
                        echo '<div class="myfrds-one"><ul><li class="myfrds-img"><a href="Wishes.php?username='.$data["screen_name"].'">
                              <img src="'.$data["profile_image_url"].'"></a></li>';
                        echo '<li class="myfrds-name"><a href="Wishes.php?username='.$data["screen_name"].'">'.$data["screen_name"].'</a></li></ul></div>';
						//echo '<tr><td><a href="Wishes.php?username='.$data["screen_name"].'">'.$data["screen_name"].'</a></td></tr>';
                    }    
                    //echo '</table>';
                    echo '</li></ul>';
	                mysql_close($link);
            ?>
            </div>
        </div>
	</body>
</html>

