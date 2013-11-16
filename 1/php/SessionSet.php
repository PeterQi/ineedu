<?php
	session_start();
	if(!isset($_SESSION["isLogin"]) || $_SESSION['isLogin']!='1')
	{
        //header("Location:./php/login.php");
        $url = "./php/login.php";
			echo "<script language='javascript' type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>";
        exit;
	}
?>
