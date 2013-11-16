﻿<?php
	session_start();
	include_once ("./php/preconfig.php");//haha	
	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
	$userinfo=CurlGet($url);
	$_SESSION["username"]=$userinfo["screen_name"];
?>

<html>
    <head>
        <title>网站主页面</title>
        <link rel="stylesheet" href="./css/link.css" type="text/css">
        <link rel="stylesheet" href="./css/layout.css" type="text/css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="logo">I Need you</div>
                <div id="banner"></div>
                <div id="hi">
                    <a href=index.php?update=1>更新</a>
                </div>
            </div>
            <div class="gap"></div>
            <div id="navfirst">
            <ul id="menu">
                <li><a href="./php/insert.php">发布愿望</a></li>		
		        <li><a href="./php/friends.php">关注的人</a></li>
		        <li><a href="./php/MyWish.php">我的愿望</a></li>
		        <li><a href="./php/IPayed.php">我支付的</a></li>
                <li><a href="./php/Search.php">搜索</a></li>
            </ul>
            </div>
		<?php/*	<form action="./php/Wishes.php" method="post">
                <input type="text" name="username" value="用户昵称"/>
				<input type="submit" name="button" value="搜索"/>
                <button type="submit">
            	搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索
                </button>
                           
            </form>*/?>
			<?php
				if($_GET["update"]==1)
					UpdateMyFriendsWish();
			?>
            <div id="content">
            <?php ShowMs(); ?>    
            </div>
        </div>
	</body>
</html>
<?php

function ShowMs()
{
	$SelQuery="SELECT `id`,`wishID`,`WishTime` FROM ms".$_SESSION['oauth2']['user_id']." ORDER BY WishTime DESC";
	$SelResult=mysql_query($SelQuery);
	if($SelResult && mysql_affected_rows()>0)
	{
		$Yes=false;
		while($SelRow=mysql_fetch_assoc($SelResult))
		{
			$Wish="select `userID`,`name`,`price`,`deadline`,`reason`,`describe`,`time` from `wish` WHERE ID=".$SelRow['wishID'];
			$WishResult=mysql_query($Wish);
			if((!$Yes) && $WishResult && mysql_affected_rows()>0)
			{
			
				echo	'<table align="center" width="600" border="1" cellpadding="2" cellspacing="0">';
        	    echo    '<th>愿望人</th><th>愿望名</th><th>价格</th><th>截止日期</th><th>理由</th><th>描述</th><th>发布时间</th>';
				$Yes=true;
			}
			if($WishResult && mysql_affected_rows()>0)
			{
            	while($row = mysql_fetch_assoc($WishResult))
			    {
					echo '<tr>';
		 			foreach($row as $key => $data)
					{
						if($key=='userID')
						{
//							$uinfo=userinfos($data);
							echo '<td><a href="http://www.weibo.com/'.$data.'" target="_blank">'.$data.'</a></td>';//$uinfo['screen_name'].'</a></td>';	
							$url3="./php/WishInfo.php?WishID=".$SelRow['wishID'];
						}
						else if($key=='name')
							echo '<td><a href="'.$url3.'">'.$data.'</a></td>';
						else	
			         	    echo '<td>'.$data.'</td>';	
		            }
				    echo '</tr>';
	            }
				
	        }
		}
		if($Yes) echo '</table>';
	}
	else
	{
		echo "没有最新动态<br/>";
	}
}

/*?>
<?php
/*session_start();

include_once( './php/preconfig.php' );
//include_once( './php/SessionSet.php' );

//从POST过来的signed_request中提取oauth2信息
if(!empty($_REQUEST["signed_request"])){
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
	$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
	if($data=='-2'){
		 die('签名错误!');
	}else{
		$_SESSION['oauth2']=$data;
	}
}
//判断用户是否授权
if (empty($_SESSION['oauth2']["user_id"])) {
    include "./php/auth.php";
		exit;
} else {
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>授权后的页面</title>
</head>

<body>

<?php
$ms  = $c->home_timeline(); // done

?>
<h2>发送新微博</h2>
<form action="" >
<input type="text" name="text" style="width:300px" />
&nbsp;<input type="submit" />
</form>
<?php

if( isset($_REQUEST['text']) )
{
$c->update( $_REQUEST['text'] );
// 发送微博
echo "<p>发送完成</p>";

}

?>

<?php if( is_array( $ms['statuses'] ) ): ?>
<?php foreach( $ms['statuses'] as $item ): ?>
<div style="padding:10px;margin:5px;border:1px solid #ccc">
<?=$item['text'];?>
</div>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>*/?>
