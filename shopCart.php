<?php
session_start();
session_save_path('tmp/');
include "inc/global.php";
include "classes/clsGeneral.php";

if(isset($_POST['SecCode'])){
	echo '<form  name="frm1" method="post" id="frm1" action="'.$_SERVER['HTTP_REFERER'].'"><input type="hidden" name="valcheck" id="valcheck" value="1"></form>';
	
	
	if($_SESSION['security_code']!=$_POST['SecCode']){
		$_SESSION['msg']='Security Code don`t  Metch.';
		echo '<script type="text/javascript">document.getElementById("frm1").submit();</script>';
	}
}

$sqlopt="SELECT * FROM option_type";
$resopt=mysql_query($sqlopt);
$CalcValue='';
$Quantity='';
while($rowopt=mysql_fetch_assoc($resopt)){
	$CalcValue .='SelOption_'.$rowopt['id'].':'.($_REQUEST['SelOption_'.$rowopt['id']]?$_REQUEST['SelOption_'.$rowopt['id']]:'Null').'|';
	if($rowopt['typename']=='Quantity'){
		$Quantity=$_REQUEST['SelOption_'.$rowopt['id']];
	}	
}

$sqlqty="SELECT * FROM option_values WHERE id='".$Quantity."'";
$resqty=mysql_query($sqlqty);
$rowqty=mysql_fetch_assoc($resqty);
$Quantity=$rowqty['name'];
	
if(!session_id())
{
	$sessionId=md5 (uniqid (rand()));
	session_register('sessionId');
}

$ObjGen=new clsGeneral;

if($_SESSION['_SESSUSERID_'])
{
	$userId=$_SESSION['_SESSUSERID_'];
}
else
{
	$userId="0";
}
switch($_REQUEST['action'])
{
	case "add":
		$examPrice=$_REQUEST['hide_result'];
	       if($_SESSION['security_code']==$_POST['SecCode']){
				$dbh->Query("insert into ".TB_SHOPPING_CART." (fld_shopSessionId, fld_userIdNo, fld_productId, fld_qty, fld_price, fld_catIdNo, fld_value) values('".session_id()."','".$userId."','".$_REQUEST['pro_id']."','".$Quantity."','".$examPrice."', '".$_REQUEST['cat_id']."','".$CalcValue."')");
				echo "<script language=\"JavaScript\">location.replace('cart.php');</script>";
              }
	break;
	case "edit":
		$examPrice=$_REQUEST['hide_result'];
		$productId = $_REQUEST['pro_id'];
		$cat_id = $_REQUEST['cat_id'];
			$dbh->Query("UPDATE  ".TB_SHOPPING_CART." SET fld_userIdNo={$userId},fld_productId={$productId},fld_qty={$Quantity},fld_price={$examPrice},fld_catIdNo={$cat_id},fld_value='.$CalcValue.' WHERE fld_shopSessionId='".session_id()."' and fld_shopCartIdNumber='".$_REQUEST['packId']."' ");
			echo "<script language=\"JavaScript\">location.replace('cart.php');</script>";
		break;
	case "delete":
		$dbh->Query("delete from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."' and fld_shopCartIdNumber='".$_REQUEST['packId']."'");
		echo "<script language=\"JavaScript\">location.replace('".$_SERVER['HTTP_REFERER']."');</script>";	
	break;
	
	case "empty";
		$dbh->Query("delete from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");
		$_SESSION['fld_productId'] = "";
		echo "<script language=\"JavaScript\">location.replace('".$_SERVER['HTTP_REFERER']."');</script>";
	break;
}
?>