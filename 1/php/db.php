<?php
$link = mysql_connect('w.rdc.sae.sina.com.cn:3307',SAE_MYSQL_USER,SAE_MYSQL_PASS);

	if(!$link)
	{
		die('链接失败：'.mysql_error());
	}
	mysql_select_db('app_ineedu',$link)or die('不能选定数据库 app_ineedu : '.mysql_error());
	mysql_query("set names 'utf8'");
?>
