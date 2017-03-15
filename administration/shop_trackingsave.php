<?php
include("../inc/global_admin.php");
$sql="update shop_orders set trackno='".$_GET['track']."' where orderno='".$_GET['id']."'";
mysql_query($sql);
if($_GET['track']!='') {
	//include("regeninv.php");
	$sql="select orders.*, customers.email from shop_orders as orders inner join shop_customers as customers on orders.reguserid=customers.id where orders.orderno='".$_GET['id']."'";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	
	$toemail=$row['email'];
	
	$sqlsett="select * from site_settings where setting_name='AdminEmail'";
	$ressett=mysql_query($sqlsett);
	$rowsett=mysql_fetch_assoc($ressett);
	
	$fromemail=$rowsett['setting_value'];
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Vinyl Accent <$fromemail>\r\n";
	
	$sqlemail="select dispatchemail from emailtemplates";
	$resemail=mysql_query($sqlemail);
	$rowemail=mysql_fetch_assoc($resemail);
	
	$mailstr=$rowemail['dispatchemail'];
	$mailstr=str_replace('%name%',$row['fname'].' '.$row['lname'],$mailstr);
	$mailstr=str_replace('%orderno%',$row['orderno'],$mailstr);
	$mailstr=str_replace('%trackno%',$row['trackno'],$mailstr);
	
	mail($toemail,"Your order has been dispatched",$mailstr,$headers);
}
echo "Tracking Number saved successfully.";
?>