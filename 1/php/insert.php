<!DOCTYPE html>
<?php
	include 'alipay_no.php';
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
    <body onload= 'setdefaulttime("year","month","day","hour","minute","deadline")'>
        <div id="container">
            <div id="headwrap">
                <div class="head">
                    <a href="../index.php" class="logo">
                        <img src="../image/logo.jpg" title="I Need U">
                    </a>
                    <div class="head-nav">
                        <ul class="head-nav-menu">
                            <li><a href="../index.php">首页</a></li>
                            <li><a href="./Search.php">搜索</a></li>
                            <li><a href="../index.php?update=1">更新</a><li>
                            <li><a href="./insert.php">发布愿望</a></li>		
		                    <li><a href="./friends.php">关注的人</a></li>
		                    <li><a href="./MyWish.php">我的愿望</a></li>
                            <li><a href="./IPayed.php">我支付的</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="content">  
                <div id="w_notice1"><p id="x2"></p></div> 
                <div id="w_notice2"><p id="y2"></p></div>
                <div id="w_content">    
                    <form action="DBinsert.php" method="post"  onsubmit="return checkform()">
                        <div class="wish_pag w_name">
                            <span>愿望名称:</span>
                            <input id="name" class="w_input" type="text" size=20 name="WishName" onblur= 'checkname("name","x2","不能为空")' />
                        </div>
                        <div class="wish_pag w_price">
                            <span>大约价格:</span>
                            <input id="price" class="w_input" type="text" name="WishPrice" onblur= 'checkprice("price","y2","不能为字符或空")' />
                            <div class="w_notice"><p id="y2"></p></div>
                        </div>
                        <div class="wish_pag w_time">
                            <span>截止时间:</span>
                            <div class="timeoption">
                            年:<select id="year" onchange= 'timecombine("year","month","day","hour","minute","deadline")'>
  								<option>2013</option><option>2014</option><option>2015</option><option>2016</option>
							</select>
							月:<select id="month" onchange= 'timecombine("year","month","day","hour","minute","deadline")'>
								<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
								<option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
                                <option>11</option><option>12</option>
							<select/>
							日:<select id="day" onfocus='checkday("year","month","day")' onchange= 'timecombine("year","month","day","hour","minute","deadline")'>
								<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
								<option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
								<option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
								<option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>
								<option>21</option><option>22</option><option>23</option><option>24</option><option>25</option>
								<option>26</option><option>27</option><option>28</option><option>29</option><option>30</option>
								<option>31</option>
							<select/>
							时:<select id="hour" onchange= 'timecombine("year","month","day","hour","minute","deadline")'>
							    <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
								<option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
								<option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
                                <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
								<option>20</option><option>21</option><option>22</option><option>23</option>
							</select>
							分:<select id="minute" onchange= 'timecombine("year","month","day","hour","minute","deadline")'>
								<option>00</option><option>01</option><option>02</option><option>03</option>
								<option>04</option><option>05</option><option>06</option><option>07</option>
								<option>08</option><option>09</option><option>10</option><option>11</option>
		                        <option>12</option><option>13</option><option>14</option><option>15</option>
								<option>16</option><option>17</option><option>18</option><option>19</option>
								<option>20</option><option>21</option><option>22</option><option>23</option>
						        <option>24</option><option>25</option><option>26</option><option>27</option>
								<option>28</option><option>29</option><option>30</option><option>31</option>
								<option>32</option><option>33</option><option>34</option><option>35</option>
				                <option>36</option><option>37</option><option>38</option><option>39</option>
								<option>40</option><option>41</option><option>42</option><option>43</option>
								<option>44</option><option>45</option><option>46</option><option>47</option>
								<option>48</option><option>49</option><option>50</option><option>51</option>
								<option>52</option><option>53</option><option>54</option><option>55</option>
								<option>56</option><option>57</option><option>58</option><option>59</option>	
                            </select>
                            </div>
				            <input class="w_input" type="hidden" name="WishDeadline" id="deadline">
                        </div>
                        <div class="w_reason">
                            <div class="smallbox"><span>许愿原因:</span></div>
                            <textarea rows="10" cols="30" name="WishReason"></textarea>
				            <!--<input class="rea_input" type="textarea" name="WishReason"/>-->
                        </div>
                        <div class="w_describe">
                            <div class="smallbox"><span>礼物描述:</span></div>
                            <textarea rows="10" cols="30" name="WishDescribe"></textarea>
                            <!--<input class="des_input" type="textarea" name="WishDescribe"/>-->
                        </div>
                        <div class="w_reprice">
                            <div class="smallbox"><span>推荐金额:</span></div>
                            <input class="re_input" type="text" name="Recommend"/><br/>
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
		if(checkname("name","x2","不可为空")&&checkprice("price","y2","不可为空和字符")&&checktime("year","month","day","hour","minute"))
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
