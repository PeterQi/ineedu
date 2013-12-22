<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21706974"></script>
<?php
include_once ("preconfig.php");
include "TopSdk.php";
include "db.php";
//$urlhaha="https://api.weibo.com/2/suggestions/users/not_interested.json";
//$post_datahaha=array("uid"=>2514878273,"access_token"=>$_SESSION['oauth2']['oauth_token']);
//CurlPost($urlhaha,$post_datahaha);
if(isset($_GET["tradeID"]))
{
	$_SESSION["tradeID"]=$_GET["tradeID"];
}
if(!isset($_SESSION["infos"]["access_token"]))
{
	if(isset($_GET["code"]))
	{
		$_SESSION["code"]=$_GET["code"];
	}
	if(!isset($_SESSION["code"]))
    {
        $url="./tbtmp.php?id=1";
		//$url= "https://oauth.tbsandbox.com/authorize?response_type=code&client_id=1021706974&redirect_uri=1.ineedu.sinaapp.com/php/testTaobao.php";
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL= '.$url.'"/>'; //header("Location: ".$url);
		exit;
	}
	$url = "https://oauth.tbsandbox.com/token";
	$post_data = array("client_id"=>"1021706974","client_secret"=>"sandboxd7dd088a6535e66b5a24aada0","redirect_uri"=>"http://1.ineedu.sinaapp.com/php/testTaobao.php","grant_type"=>"authorization_code","code"=>$_SESSION["code"]);
	$_SESSION["infos"]=CurlPost($url,$post_data);
	var_dump($_SESSION["infos"]);
}
?>
<?php
$c = new TopClient;
$c->appkey = "1021706974";
$c->secretKey = "sandboxd7dd088a6535e66b5a24aada0";
$c->sessionkey=$_SESSION["infos"]["access_token"];
$req = new TradeGetRequest;
if(isset($_SESSION["tradeID"])&&isset($_SESSION["infos"]))
{
	$req->setTid($_SESSION["tradeID"]);
	$req->setFields("tid,num_iid,created,title,price,total_fee,pay_time,end_time,alipay_id,alipay_no,seller_nick,pic_path,buyer_alipay_no,receiver_name,receiver_state,consign_time,seller_name,buyer_nick");
//	$req->setFields("tid,num_iid,created,title,price,total_fee,pay_time,end_time,alipay_id,alipay_no,seller_nick,pic_path,receiver_state,consign_time,seller_name,buyer_nick");

	$resp = $c->execute($req,$c->sessionkey);
	var_dump($resp);
	$_SESSION["trade"] = $resp->trade;
	
/*	if(!isset($_GET["output"]))
	{
//		header("Location: http://apps.weibo.com/kingguko?taobao=1");
		$url="./tbtmp.php?id=2";
		//$url= "https://oauth.tbsandbox.com/authorize?response_type=code&client_id=1021706974&redirect_uri=1.ineedu.sinaapp.com/php/testTaobao.php";
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL= '.$url.'"/>'; //header("Location: ".$url);

	}
	else
	{*/
		$trade=$_SESSION["trade"];
		$inserttrade=mysql_query('INSERT INTO `trade` VALUES ("'.$trade->tid.'","'.$trade->num_iid.'","'.$trade->created.'","'.$trade->title.'","'.$trade->price.'","'.$trade->total_fee.'","'.$trade->pay_time.'","'.$trade->end_time.'","'.$trade->alipay_id.'","'.$trade->alipay_no.'","'.$trade->buyer_nick.'","'.$trade->seller_nick.'","'.$trade->pic_path.'","'.$trade->buyer_alipay_no.'","'.$trade->receiver_name.'","'.$trade->receiver_state.'","'.$trade->consign_time.'","'.$trade->seller_name.'")');

		if($inserttrade&&mysql_affected_rows()>0)
		{
			$uptrade=mysql_query('Update `wish` SET `trade`="'.$_SESSION["tradeID"].'" WHERE `ID`='.$_SESSION['wishIDtrade']);
			if($uptrade&&mysql_affected_rows()>0)
				echo "插入交易成功！<br>";
			else
				echo "更新失败！<br>";
		}
		else
		{
			echo "该交易不可用<br>";
			echo mysql_errno().':'.mysql_error();
			exit;
		}
		echo "订单号：".$trade->tid."<br>";
		echo "商品号：".$trade->num_iid."<br>";
		echo "创建时间：".$trade->created."<br>";
		echo "交易标题：".$trade->title."<br>";
		echo "商品价格：".$trade->price."<br>";
		echo "商品金额：".$trade->total_fee."<br>";
		echo "付款时间：".$trade->pay_time."<br>";
		echo "交易结束时间：".$trade->end_time."<br>";
		echo "买家的支付宝id号：".$trade->alipay_id."<br>";
		echo "支付宝交易号：".$trade->alipay_no."<br>";
		echo "买家昵称：".$trade->buyer_nick."<br>";
		echo "卖家昵称：".$trade->seller_nick."<br>";
		echo "图片链接：".$trade->pic_path."<br>";
		echo "买家支付宝帐号：".$trade->buyer_alipay_no."<br>";
		echo "收货人姓名：".$trade->receiver_name."<br>";
		echo "收货人所在省份：".$trade->receiver_state."<br>";
		echo "卖家发货时间：".$trade->consign_time."<br>";
		echo "卖家姓名：".$trade->seller_name."<br>";
				
//	echo $resp->tid."<br>";
    //}
		session_destroy();
		echo '<a href="../index.php/" title="返回首页"><button type="button type="button">返回</button></a>';

}
?>
</head>
</html>
<?php
mysql_close($link);
/*
<html>
<head>
<title>test淘宝</title>
</head>
<body>
	<form name = "input" action="" method="get">
	淘宝订单号：
	<input type="text" name="tradeID"/>
	<input type="submit" value="Submit"/>
	</form>
</body>
</html>*/?>
