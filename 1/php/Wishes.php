<?php
	include_once ("preconfig.php");	
//	include_once ("SessionSet.php");
//	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//	$userinfo=CurlGet($url);
	include ("db.php");    
?> 
<html>
    <head>
		<title>愿望清单</title>
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
                <div id="banner"><h2>愿望清单</h2></div>
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
		//			var_dump($_GET["username"]);
					$url2="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&screen_name=".$_GET["username"];
					$userinfo=CurlGet($url2);
//					var_dump($userinfo);
					if(isset($userinfo["error_code"])) die("用户不存在！");
					$_userid=$userinfo["id"];
//					var_dump($userinfo);
	                $query="select `ID`,`name`,`price`,`deadline`,`reason`,`describe`,`time` from `wish` WHERE userID=".$_userid." ORDER BY deadline ASC";
					$url="http://www.weibo.com/".$_userid;
	                $result = mysql_query($query);
	
	                if($result)
                	{
		                if(mysql_affected_rows()<1)
		                {
		                	echo 'Ta还没有告诉我们Ta的愿望<br/>';
							echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
		                }
		                else
                        {
		                    echo	'<table align="center" width="600" border="1" cellpadding="2" cellspacing="0">';
                            echo    '<th>愿望人</th><th>愿望名</th><th>价格</th><th>截止日期</th><th>理由</th><th>描述</th><th>发布时间</th>';
        
                            while($row = mysql_fetch_assoc($result))
			                {
				                echo '<tr>';
		 			            foreach($row as $key => $data)
					            {
									if($key=='ID')
									{
										echo '<td><a href="'.$url.'" target="_blank">'.$userinfo['screen_name'].'</a></td>';	
										$url3="WishInfo.php?WishID=".$data."&action=Wishes";
									}
									else
									{
										if($key=='name')
											echo '<td><a href="'.$url3.'">'.$data.'</a></td>';
										else	
							         	    echo '<td>'.$data.'</td>';	
									}
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
	                }
			mysql_close($link);
                ?>
            </div>
        </div>
    </body>
</html>




