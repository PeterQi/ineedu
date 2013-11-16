<!DOCTYPE html>
<?php
	include_once ("preconfig.php");
//	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//	$userinfo=CurlGet($url);
//	include "SessionSet.php";
?>
<html>
	<head>
		<script type="text/javascript" language="javascript" src="../js/check.js"></script>
		<title>插入愿望</title>
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
                <div id="hi"></div>
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
                <div id="w_notice1"><p id="x2"></p></div> 
                <div id="w_notice2"><p id="y2"></p></div>
                <div id="w_content">    
		            <form action="DBinsert.php" method="post" onsubmit="return checkform()">
                        <div class="wish_pag w_name">
                            <span>愿望名称:</span>
                            <input id="name" class="w_input" type="text" name="WishName" onblur=checkname("name","x2","不能为空") />
                        </div>
                        <div class="wish_pag w_price">
                            <span>大约价格:</span>
                            <input id="price" class="w_input" type="text" name="WishPrice" onblur=checkprice("price","y2","不能为字符或空") />
                            <div class="w_notice"><p id="y2"></p></div>
                        </div>
                        <div class="wish_pag w_time">
                            <span>截止时间:</span>
				            <input class="w_input" type="text" name="WishDeadline"/>
                        </div>
                        <div class="w_reason">
                            <span>许愿原因:</span>
				            <input class="rea_input" type="text" name="WishReason"/>
                        </div>
                        <div class="w_describe">
                            <span>礼物描述:</span>
                            <input class="des_input" type="text" name="WishDescribe"/>
                        </div>
                        <div class="w_reprice">
                            <span>推荐金额:</span>
                            <input class="re_input" type="text" name="WishReprice"/><br/>
                            <!--0或不输入表示无推荐金额-->
                        </div>
				        <div class="w_button">
                            <button class="btn_wish" type="submit" name="submit">
                                <span>提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交</span>
                            </button>
                            <button class="btn_wish" type="reset" name="reset">
                                <span>重&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;置</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	<script>
	function checkform()
	{
		if(checkname("name","x2","不可为空")&&checkprice("price","y2","不可为空和字符"))
		{
			return true;	
		}	
		else
		{
			return false;
		}
	}
	</script>
	</body>
</html>
