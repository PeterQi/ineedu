<?php
	include "SessionSet.php";
?>
<html>
	<head>
		<title>注册</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<table align="center" width="500" border="0" cellpadding="2" cellspacing="0">
		<caption align="center"><h2>注册</h2></caption>

		<form action="register.php" method="post">
			<tr>
				<th>用户名:</th>
				<td><input type="text" name="UserName"   size="20"></td>
			</tr>
		
			<tr>
				<th>密码:</th>
				<td><input type="password" name="password"   size="20"></td>
			</tr>
			<tr>
				<th>再输一次密码:</th>
				<td><input type="password" name="password2"   size="20"></td>
			</tr>

			

			<tr>
				<td colspan="2" align="center">
					<input type="submit" name="submit" value="提交">
					<input type="reset" name="reset" value="重置">
				</td>
			</tr>
		</form>
	</body>
</html>
<?php
	include ("db.php");
	if($_POST['UserName']!=null && $_POST['password']!=null && $_POST['password2']!=null)
	{
		if($_POST['password']!=$_POST['password2'])
		{
			echo "两次密码输入不一致，插入失败<br>";
		}
		else
		{
			$query="select `name` from `user` WHERE `name`='".$_POST['UserName']."'";

			$result = mysql_query($query);
	
			if($result)
			{
				if(mysql_affected_rows()>0)
				{
					echo '用户名已被使用，请重新输入<br>';
				}
				else
				{
					$query="INSERT INTO `user` (`password`,`name`) VALUES('".$_POST['password']."','".$_POST['UserName']."')";
					$result = mysql_query($query);
					if($result && mysql_affected_rows()<1)
					{
						echo "注册失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
					}
					else
					{
						echo "这册成功，最后一条插入的数据记录ID为：".mysql_insert_id()."<br>";
					}
	
				}
			}
			else
				echo "注册失败，错误号：".mysql_errno()."，错误原因：".mysql_error()."<br>";
		}
	}
	else
	{
		echo "请输入完整信息<br>";
	}
		
	mysql_free_result($result);
	mysql_close($link);


?>
