<?php
	include_once ("preconfig.php");	
//	include_once ("SessionSet.php");
//	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//	$userinfo=CurlGet($url);
	include ("db.php");    
?> 
<html>
    <head>
		<title>我的愿望清单</title>
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
	                $query="select `ID`,`name`,`price`,`deadline`,`reason`,`describe`,`time` from `wish` WHERE userID=".$_SESSION['oauth2']['user_id']." ORDER BY deadline ASC";

	                $result = mysql_query($query);
	
	                if($result)
                	{
		                if(mysql_affected_rows()<1)
		                {
		                	echo '您还没有告诉我们您的愿望<br/>';
		                }
		                else
                        {
                            echo    '<div class="mywish-lish"><ul>';
		                    //echo	'<table align="center" width="600" border="1" cellpadding="2" cellspacing="0">';
                            //echo    '<th>愿望名</th><th>价格</th><th>截止日期</th><th>理由</th><th>描述</th><th>发布时间</th>';
        
                            while($row = mysql_fetch_assoc($result))
                            {
                                echo '<div class="mywish-one"><li><ul>';
				                //echo '<tr>';
		 			            foreach($row as $key => $data)
					            {
									if($key=='ID')
									{
										$url="WishInfo.php?WishID=".$data."&action=MyWish";
									}
									else
									{
										if($key=='name')
											echo '<li>愿望名称：<a href="'.$url.'">'.$data.'</a></li>';
										else if($key=='price')	
                                            echo '<li>大约金额：'.$data.'</li>';
                                        else if($key=='deadline')	
                                            echo '<li>截止日期：'.$data.'</li>';    
                                        else if($key=='reason')	
                                            echo '<li>许愿原因：'.$data.'</li>';
                                        else if($key=='describe')	
                                            echo '<li>愿望描述：'.$data.'</li>';
                                        else
							         	    echo '<li>许愿日期：'.$data.'</li>';
									}
                                }
                                echo '</ul></li></div>';
				                //echo '</tr>';
			                }	
                            //echo '</table>';
                            echo '</ul></div>';		
	                	}
						echo '<a href="Weibo.php?comment=1">分享</a>';
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




