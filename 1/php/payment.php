<?php
	include_once ("preconfig.php");
	include ("db.php");	
//	include_once ("SessionSet.php");
//	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id'];
//	$userinfo=CurlGet($url);
?>
<html>
	<head>
		<title>支付</title>
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
            <div id="banner"><h2>支付</h2></div>
            
            <div id="hi">
                <?php
			        echo '您好：<a href="../index.php">'.$_SESSION["username"].'</a>';
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
            <div id="frm_pay">
                <h2>支&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付</h2>
            <div class="user_pay">
<?php
/*             <div class="frm_cont payWish">
                        <label for="wishID">愿望编号</label>
                        <input type="text" name="WishID" id="payWish" />
                    </div> */
		$query="select `deadline`,`recommend` from `wish` WHERE `ID`=".$_GET['WishID'];
		$result = mysql_query($query);	
		if($result)
		{
			if(mysql_affected_rows()<1)
			{
				echo '没有此愿望<br/>';
				die();
			}
			else
			{
				$row = mysql_fetch_row($result);
				$deadline=$row[0];
				$recPrice=$row[1];
				$time=date("Y-m-d H:i:s",time());
				if($time>$deadline)
				{
					echo'此愿望已不能支付<br/>'; 
					echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';
					die();
				}
			}
		}
		else
		{
			echo "查询失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
		}
?>
	    	    <form action="DBpayment.php?WishID=<?php echo $_GET["WishID"]?>" method="post">
                    <div class="frm_cont payMuch">
                        <label for="Payed_amount">付款金额</label>
                        <input type="text" name="Payed_amount" id="payMuch" />
                    </div>
                    <div class="btns">
                        <button type="submit" class="btn_pay">
                            <span>提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交</span>
                        </button>
                        <button type="reset" class="btn_pay">
                            <span>重&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;置</span>
                        </button> 
                    </div>
                </form>
		<?php
				 echo "推荐支付金额：";
			    if($recPrice!=null&&$recPrice>0) echo $recPrice."<br/>";
                else echo "无<br/>";
				echo '<a href="javascript:history.go(-1);" title="返回上一页"><button type="button type="button">返回</button></a>';		
			mysql_close($link);
		?>
                </div>
            </div>
        </div>
	</body>
</html>
