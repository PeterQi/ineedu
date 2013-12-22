function checkname(nameid,namehintid,namehint)
{
	var x=document.getElementById(nameid).value;
	var x3=document.getElementById(namehintid);
	if(x=="")
	{
		x3.innerHTML=namehint;
		x3.style.color="red";
		return false;	
	}
	else
	{
		x3.innerHTML="√";
		x3.style.color="green";
		return true;	
	}	
}

function checkprice(priceid,pricehintid,pricehint)
{
	var y=document.getElementById(priceid).value;
	var y3=document.getElementById(pricehintid);	
	if((y=="")||(isNaN(y)))
	{
		y3.innerHTML=pricehint;
		y3.style.color="red";
		return false;	
	}
	else
	{
		y3.innerHTML="√";
		y3.style.color="green";
		return true;	
	}
}

function checkday(yearid,monthid,dayid)
{
	var x=document.createElement('option');
	var y=document.createElement('option');
	var z=document.createElement('option');
	x.text='29';
	y.text='30';
	z.text='31';
	var myyear=document.getElementById(yearid);
	var yeartext=myyear.options[myyear.selectedIndex].text;
	var mymonth=document.getElementById(monthid);
	var monthtext=mymonth.options[mymonth.selectedIndex].text;
	var yearvalue=parseInt(yeartext,0);
	var monthvalue=parseInt(monthtext,0);
	var myday=document.getElementById(dayid);
	if(yearvalue%400==0||(yearvalue%4==0&&yearvalue%100!=0))
	{
		if(monthvalue==2)
		{
			myday.length=28;
			myday.add(x,null);
		}	
		else if(monthvalue==2||monthvalue==4||monthvalue==6||monthvalue==9||monthvalue==11)
		{
			myday.length=28;	
			myday.add(x,null);	
			myday.add(y,null);
		}
		else
		{
			myday.length=28;
			myday.add(x,null);	
			myday.add(y,null);
			myday.add(z,null);
		}
	}	
	else
	{
		if(monthvalue==2)
		{
			myday.length=28;
		}	
		else if(monthvalue==2||monthvalue==4||monthvalue==6||monthvalue==9||monthvalue==11)
		{
			myday.length=28;	
			myday.add(x,null);	
			myday.add(y,null);
		}
		else
		{
			myday.length=28;
			myday.add(x,null);	
			myday.add(y,null);
			myday.add(z,null);
		}	
	}
}

function timecombine(yearid,monthid,dayid,hourid,minuteid,timeid)
{
	var myyear=document.getElementById(yearid);
	var mymonth=document.getElementById(monthid);
	var myday=document.getElementById(dayid);
	var myhour=document.getElementById(hourid);
	var myminute=document.getElementById(minuteid);	
	var yeartext=myyear.options[myyear.selectedIndex].text;
	var monthtext=mymonth.options[mymonth.selectedIndex].text;
	var daytext=myday.options[myday.selectedIndex].text;
	var hourtext=myhour.options[myhour.selectedIndex].text;
	var minutetext=myminute.options[myminute.selectedIndex].text;
	var mytime=document.getElementById(timeid);
	mytime.value=yeartext+"-"+monthtext+"-"+daytext+" "+hourtext+":"+minutetext+":"+"00";
}

function checktime(yearid,monthid,dayid,hourid,minuteid)
{
	var myyear=document.getElementById(yearid);
	var mymonth=document.getElementById(monthid);
	var myday=document.getElementById(dayid);
	var myhour=document.getElementById(hourid);
	var myminute=document.getElementById(minuteid);	
	
	var yeartext=myyear.options[myyear.selectedIndex].text;
	var monthtext=mymonth.options[mymonth.selectedIndex].text;
	var daytext=myday.options[myday.selectedIndex].text;
	var hourtext=myhour.options[myhour.selectedIndex].text;
	var minutetext=myminute.options[myminute.selectedIndex].text;
	
	var yearvalue=parseInt(yeartext,0);
	var monthvalue=parseInt(monthtext,0);
	var dayvalue=parseInt(daytext,0);
	var hourvalue=parseInt(hourtext,0);
	var minutevalue=parseInt(minutetext,0);
	
	var datenow=new Date();
	var currenthour=datenow.getHours();
	var currentminute=datenow.getMinutes();
	var dateset=new Date();
	dateset.setFullYear(yearvalue,monthvalue-1,dayvalue);
	if(dateset>datenow)
		return true;	
	else if(dateset<datenow)
		return false;
	else
	{
		if(hourvalue>currenthour)
			return true;
		else if(hourvalue<currenthour)
			return false;
		else
			{
				if(minutevalue>currentminute)
					return true;
				else
					return false;	
			}	
	}	
}

function addDate(dy,dmomth,dd,dh,dm,dadd)
{
	var a = new Date(dy,dmomth,dd,dh,dm);
	a = a.valueOf();
	a = a + dadd * 1 * 60 * 60 * 1000;
	a = new Date(a);
	return a;
}

function setdefaulttime(yearid,monthid,dayid,hourid,minuteid,timeid)
{
	var myyear=document.getElementById(yearid);
	var mymonth=document.getElementById(monthid);
	var myday=document.getElementById(dayid);
	var myhour=document.getElementById(hourid);
	var myminute=document.getElementById(minuteid);
	var mytime=document.getElementById(timeid);
	
	var mydate=new Date();
	var currentyear=mydate.getFullYear();
	var currentmonth=mydate.getMonth();
	var currentday=mydate.getDate();
	var currenthour=mydate.getHours();
	var currentminute=mydate.getMinutes();
	var setdate=addDate(currentyear,currentmonth,currentday,currenthour,currentyear,currentminute,30)
	
	var setdate=new Date();
	setdate.setDate(mydate.getDate()+30);
	
	var yearset=setdate.getFullYear();
	var monthset=setdate.getMonth();
	var dayset=setdate.getDate();
	var hourset=setdate.getHours();
	var minuteset=setdate.getMinutes();
	
	myyear.options[yearset-2013].selected=true;
	mymonth.options[monthset-0].selected=true;
	myday.options[dayset-1].selected=true;
	myhour.options[hourset-0].selected=true;
	myminute.options[minuteset-0].selected=true;
	
	monthset=monthset+1;
	mytime.value=yearset+"-"+monthset+"-"+dayset+" "+hourset+":"+minuteset+":"+"00";
}