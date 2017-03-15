<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";
$ObjGen=new clsGeneral;

$cartRs=$dbh2->Query("select Count(*) as cnt, SUM(fld_price) as price from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");
$cartVal=$dbh->FetchRow($cartRs);
$totalPrice=$cartVal['price'];
$totalItem=$cartVal['cnt'];
$orderNo=$_POST['invoice_id'];
$item=$dbh2->Query("insert into ".TB_ORDER." (fld_userIdNo, fld_orderIdNo, fld_totalPrice, fld_orderDate, fld_orderStatus, fld_disVoucher, fld_discount) values ('".$_SESSION['_SESSUSERID_']."','".$orderNo."', '".$totalPrice."', '".date("Y-m-d G:i:s")."','Pending', '".$_SESSION['DISCOUNT_VOUCHER']."', '".$_SESSION['DISCOUNT']."')");
$item=$dbh->Query("select * from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");
while($itemVal=$dbh->FetchRow($item)){
		$q="insert into ".TB_ORDER_DETAILS." (fld_orderIdNo, fld_productIdNo, fld_quantity,	fld_value,fld_price) values ('".$orderNo."', '".$itemVal['fld_productId']."','".$itemVal['fld_qty']."','".$itemVal['fld_value']."','".$itemVal['fld_price']."')";
		$dbh2->Query($q);
}
$dbh2->Query("delete from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");
$userid=$_SESSION['_SESSUSERID_'];
$q="select fld_productIdNo from ".TB_ORDER_DETAILS." where fld_orderIdNo='".$orderNo."'";
$rs=$dbh->Query($q);
$numrow = $dbh->NumRows($rs);
$prdArr = array();
while($prdID=$dbh->FetchRow($rs)){
	array_push($prdArr, $examID[0]);
}
$user1=$ObjGen->getVal(TB_USERS,"fld_userId",$userid,"fld_userName");
$pass1=$ObjGen->getVal(TB_USERS,"fld_userId",$userid,"fld_passWd");
$string="";
for($i=0;$i<count($prdArr); $i++){
	$string.=$ObjGen->getVal(TB_PRODUCTS,"ptitle",$prdArr[$i],"id")."<br>";
}
$message1="Thank You for your Purchase at Printing Period .  The following transaction has been processed:<br><br>
 Important Note : You will be charged as NextAge Technologies in your Credit Card Statement for this Purchase.<br>
 Transaction ID: ".$myvalues[intTransID]."<br>
 Time: ".date("Y:m:d h:s",time())."<br>
 Amount: ".$myvalues[amount]."<br>
 Currency: USD<br>
 Description: PrintingPeriod.com ".$string."<br>
 Purchaser's E-mail: ".$user1."<br>
 Purchaser Name: ".$nameOnCard."<br>
 Purchaser's IP: ".$_SERVER['REMOTE_ADDR']."<br><br>
 CV2 result: PASSED<br><br>	
If you have any Queries , Please contact us at support@CertArea.com<br>
and one of our representative will get back to you asap<br><br>
Best Regards,<br>
PrintingPeriod.com Team<br>
";
//echo  $message1;
//mail($user1, 'CertArea Order Information', $message1,$headers);
//mail("orders@CertArea.com", 'CertArea Order Information', $message1,$headers);
//mail("cs@supportpassion.com", 'CertArea Order Information', $message1,$headers);
echo '<script>window.location="orderdtl.php?order='.$orderNo.'";</script>';
?>