<?php 
include("../inc/global_admin.php");
$sql="select trackno from `orders` where orderno='".$_GET['orderid']."'";
$res=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_assoc($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Ziggis Coffee - Tracking Information</title>
<script>
function EnterTracking(val1)
{ 
	xmlHttp=GetXmlHttpObject1();
	if (xmlHttp==null)
	{
	alert ("Browser does not support HTTP Request");
	return;
	}

	var url="shop_trackingsave.php";
	url=url+"?id="+(document.frmTrack.orderid.value)+"&track="+(document.frmTrack.trackno.value);
	xmlHttp.onreadystatechange=stateChanged1;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	tb_remove();
}

function stateChanged1() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	//document.getElementById("errdiv").innerHTML=xmlHttp.responseText;
 } 
}
function GetXmlHttpObject1()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
</script>
</head>
<body style="font-family:Arial;font-size:11px; margin:0px; padding:0px; background-color:#f3e7d2;">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="100%" colspan="3" align="center"><form name="frmTrack" method="post" action="">
        <table width="300" cellspacing="0" cellpadding="2" border="0" style="font-size:11px; color:#780000;">
          
          <tr>
            <td colspan="3" bgcolor="#D0C0A3"><strong>Please enter Tracking Info for order # <?php echo $_GET['orderid'];?></strong></td>
          </tr>
          <tr>
            <td colspan="3" style="color:#ff0000; font-weight:bold;"><div id="errdiv"></div></td>
          </tr>
          <tr>
            <td width="133">Tracking #</td>
            <td width="409" colspan="2"><input type="text" name="trackno" id="trackno" value="<?php echo $row['trackno'];?>"/><input type="hidden" name="orderid" value="<?php echo $_GET['orderid'];?>" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input type="button" name="submit" id="submit" value="Submit" onclick="return EnterTracking();"/> <input type="button" name="cancel" id="cancel" value="Cancel" onclick="tb_remove();"/> </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
