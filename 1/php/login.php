<!DOCTYPE html>
<?php
	session_start();
	include "db.php";
	

	function clearSessions()
	{
		$_SESSION=array();
		/*if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(),'',time()-42000,'/');
		}*/
	}
	if($_GET["action"]=="login")
	{
        clearSessions();
		$query="select `userID`,`name` from `user` WHERE `name`='".$_POST['username']."' and `password`='".$_POST['password']."'";
		$result = mysql_query($query);
		if($result && mysql_affected_rows()>0)
		{
			
			$_SESSION["username"]=$_POST['username'];
			while($row = mysql_fetch_row($result))
			{
				$_SESSION["userID"]=$row[0];
			}	
			$_SESSION["isLogin"]='1';
			//echo session_id();
//			header("Location:index.php");
			//if(isset($_SESSION["isLogin"]))
			//	echo $_SESSION["isLogin"];
            //
            // var_dump($_SESSION);
             $url = "../index.php?".SID;
            echo "<script language='javascript' type='text/javascript'>";
			echo "window.location.href='$url'";
            echo "</script>";
            //echo '<a href="../index.php?'.SID.'">通过URL传递Session ID</a>';
            //$_SESSION["username"]="admin22";
            //echo "Session ID:".session_id()."<br>";
            //var_dump($_SESSION);
	
		}
		else
		{
		//	echo "注册失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
			die("用户名或密码错误！");		
	
		}

		/*if($_POST["username"]=="admin" && $_POST["password"]=="123456")
		{
			setCookie('username',$_POST["username"],time()+60*60*24*7);
			setCookie('isLogin','1',time()+60*60*24*7);
			header("Location:index.php");
		}
		else
		{
			die("用户名或密码错误！");
		}
*/
	}
	else if($_GET["action"]=="logout")
	{
		clearSessions();
	}
?>
<html>
    <head>
        <title>用户登陆</title>
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
                <div id="banner"></div>
            </div>
            <div class="gap"></div>
            <div id="content">
                <div id="frm_login">
                    <h2>用户登陆</h2>
                    <div class="user_login">
	    	            <form action="login.php?action=login" method="post">
                            <div class="frm_cont userName">
                                <label for="userName">用户名</label>
                                <input type="text" name="username" id="userName" />
                            </div>
                            <div class="frm_cont userPsw">
                                <label for="userPsw">密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
                                <input type="password" name="password" id="userPsw" />
                            </div>
                            <div class="btns">
                                <button type="submit" class="btn_login">
                                    <span>登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>
