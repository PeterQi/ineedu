<html>
    <head><title>测试</title></head>
    <body>
	<?php
		if($_GET['id']==1)
		{
    		echo  '<iframe src=https://oauth.tbsandbox.com/authorize?response_type=code&client_id=1021706974&redirect_uri=http://1.ineedu.sinaapp.com/php/testTaobao.php height="300px" width="600" style="margin-top:15px;" target="_self"></iframe>';
		}
		else if($_GET['id']==2)
		{
			echo  '<iframe src=http://apps.weibo.com/kingguko?taobao=1 height="300px" width="600" style="margin-top:15px;" target="_self"></iframe>';
		}
	?>
    </body>
</html>
