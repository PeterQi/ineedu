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




