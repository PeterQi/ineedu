<?php
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
include ("db.php");
session_start();
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
		include "auth.php";
		exit;
} else {
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
}
$CreTbl="CREATE TABLE `ms".$_SESSION['oauth2']['user_id'].'`(id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,wishID INT(7) UNSIGNED NOT NULL,WishTime TIMESTAMP NOT NULL)';
$tmp=mysql_query($CreTbl);
//var_dump($tmp);
if($tmp)
{
	$SName="ms".$_SESSION['oauth2']['user_id'];
	InsertSem($SName);
	UpdateMyFriendsWish();
}
function SemWait($SemName)
{

	while(1)
	{
		$Sem_wait=mysql_query('SELECT `value` FROM sem WHERE name="'.$SemName.'"');
		if($Sem_wait && mysql_affected_rows())
		{
			$semrow=mysql_fetch_row($Sem_wait);
			if($semrow[0]==1)
			{
				$UpQuery=mysql_query('Update `sem` SET `value`=0 WHERE `name`="'.$SemName.'"');
				break;
			}
		}
	}
}
function SemPost($SemName)
{
	mysql_query('Update `sem` SET `value`=1 WHERE `name`="'.$SemName.'"');
}
function InsertSem($SemName)
{
	$query='INSERT INTO sem (`name`) VALUES ("'.$SemName.'")';
	return mysql_query($query);
}
function UpdateMyFriendsWish()
{
	$cu=0;
	$nxtCu=1;
	$page=0;
	while($nxtCu!=0)
	{
		$url="https://api.weibo.com/2/friendships/friends/ids.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$_SESSION['oauth2']['user_id']."&cursor=$cu";
		$UserFriendsIDs[$page]=CurlGet($url);
		$nxtCu=$UserFriendsIDs[$page]["next_cursor"];
		$cu=$nxtCu;
		$page++;
	}
	$recordNum=0;
	$UserFriendsIDs[$page-1]["ids"][count($UserFriendsIDs[$page-1]["ids"])]=$_SESSION['oauth2']['user_id'];
	for($i=0;$i<$page;$i++)
		foreach($UserFriendsIDs[$i]["ids"] as $data)
		{
			
			$query="SELECT  `ID` ,  `time`   FROM  `wish` WHERE  `deadline` > CURRENT_TIMESTAMP and userID = $data";
			$result=mysql_query($query);
			if($result && mysql_affected_rows()>0)
			{
//				echo "1";
				while($row=mysql_fetch_assoc($result))
				{
					$record[$recordNum]=$row;
					$recordNum++;
				}
				
       		}
		} 
//	var_dump($record);
//	$ar=array(5,2,7,4,1,3,2,3,6,10,9,8);
//	qs($ar,0,11);
//	var_dump($ar);
	qsForTime($record,0,$recordNum-1);
	if($recordNum>100)
		$insertNum=100;
	else
		$insertNum=$recordNum;
	for($i=0;$i<$insertNum;$i++)
	{
		$SelQuery="SELECT * FROM ms".$_SESSION['oauth2']['user_id']." where id=".($i+1);
		$SelResult=mysql_query($SelQuery);
		if($SelResult && mysql_affected_rows()<1)
		{
			$InsQuery="INSERT INTO ms".$_SESSION['oauth2']['user_id']."(`id`,`wishID`,`WishTime`) VALUES (".($i+1).",".$record[$i]['ID'].',"'.$record[$i]["time"].'")';
			$InsResult=mysql_query($InsQuery);
		}
		else
		{
			$UpdateQuery="UPDATE `ms".$_SESSION['oauth2']['user_id']."` set `id`=".($i+1).",`wishID`=".$record[$i]['ID'].',`WishTime`="'.$record[$i]["time"].'" where `id`='.($i+1);
			$UpdResult=mysql_query($UpdateQuery);
		}
	}


}
function qsForTime(&$array,$left,$right)
{
	if($left>=$right) return;
	$i=$left;
	$j=$right;
	$key=$left;
	while($i<$j)
	{
		while($i<$j && $array[$j]["time"]<$array[$key]["time"]) $j--;
		if($i<$j)
		{
			$tmp=$array[$key];
			$array[$key]=$array[$j];
			$array[$j]=$tmp;
			$key=$j;
		}
		while($i<$j && $array[$i]["time"]>=$array[$key]['time']) $i++;
		if($i<$j)
		{
			$tmp=$array[$key];
			$array[$key]=$array[$i];
			$array[$i]=$tmp;
			$key=$i;

		}
	}
	qsForTime($array,$left,$key-1);
	qsForTime($array,$key+1,$right);
	return ;
}
function qs(&$array,$left,$right)
{
	if($left>=$right) return;
	$i=$left;
	$j=$right;
	$key=$left;
	while($i<$j)
	{
		while($i<$j && $array[$j]<$array[$key]) $j--;
		if($i<$j)
		{
			$tmp=$array[$key];
			$array[$key]=$array[$j];
			$array[$j]=$tmp;
			$key=$j;
		}
		while($i<$j && $array[$i]>=$array[$key]) $i++;
		if($i<$j)
		{
			$tmp=$array[$key];
			$array[$key]=$array[$i];
			$array[$i]=$tmp;
			$key=$i;

		}
	}
	qs($array,$left,$key-1);
	qs($array,$key+1,$right);
	return ;
}
//else
//	echo mysql_errno().":".mysql_error();
function CurlGet($url)
{
    $curl = curl_init();
	curl_setopt($curl,CURLOPT_URL, $url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$info=curl_exec($curl);
	if(curl_errno($curl))
	{
		echo 'Errno'.curl_error($curl);
	}
	curl_close($curl);
	$info=json_decode($info,true);
    return $info;
}
function userinfos($userID)
{
	$url="https://api.weibo.com/2/users/show.json?access_token=".$_SESSION['oauth2']['oauth_token']."&uid=".$userID;
	$userinfo=CurlGet($url);
	return $userinfo;
}
?>