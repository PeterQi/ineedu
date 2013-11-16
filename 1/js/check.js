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