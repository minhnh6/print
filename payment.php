<?php

session_start();

include("inc/global.php");

include_once ('tco_payment_class.php');

$newSale = new TCO_Payment();

$newSale->setAcctInfo('2026872', 'printingperiod', 'N');

$newSale->setCheckout('single_page');



#$newSale->addParam('ssspl', '2026872');



$newSale->addParam('mode', '2CO');





$sqlcart="SELECT * FROM tbl_shopcart WHERE fld_shopSessionId= '".session_id()."'";

$rescart=mysql_query($sqlcart);

$i=0;

while($rowcart=mysql_fetch_assoc($rescart)){

	$sqlprd="SELECT ptitle, cat_id FROM products WHERE id= '".$rowcart['fld_productId']."'";

	$resprd=mysql_query($sqlprd);

	$rowprd=mysql_fetch_assoc($resprd);

	$sqlcat="SELECT title FROM category WHERE id= '".$rowprd['cat_id']."'";

	$rescat=mysql_query($sqlcat);

	$rowcat=mysql_fetch_assoc($rescat);

	$newSale->addParam('li_'.$i.'_type',$rowcat['title']);

	$newSale->addParam('li_'.$i.'_name',$rowprd['ptitle']);

	$newSale->addParam('li_'.$i.'_price',$rowcart['fld_price']);

	$newSale->addParam('li_'.$i.'_quantity','1');

	$newSale->addParam('li_'.$i.'_product_id',$rowcart['fld_productId']);

	$i++;

}





//"update ".TB_USERS." set cust_name = '".trim($_POST['card_name'])."', cust_address ='".trim($_POST['card_address'])."', cust_city = '".trim($_POST['card_city'])."', cust_state= '".trim($_POST['card_state'])."', cust_country = '".trim($_POST['card_country'])."', cust_zip = '".trim($_POST['card_zip'])."' where fld_userId= '".$_SESSION['_SESSUSERID_']."'");



$sqlcust="SELECT * FROM tbl_users WHERE fld_userId = '".$_SESSION['_SESSUSERID_']."'";

$rescust=mysql_query($sqlcust);

$rowcust=mysql_fetch_assoc($rescust);



//Customer Billing Information

$newSale->addParam('first_name',$rowcust['fld_fullName']);

$newSale->addParam('email',$rowcust['fld_userName']);

$newSale->addParam('street_address',$rowcust['cust_address']);

$newSale->addParam('city',$rowcust['cust_city']);

$newSale->addParam('state',$rowcust['cust_state']);

$newSale->addParam('zip',$rowcust['cust_zip']);

$newSale->addParam('country',$rowcust['cust_country']);



//Customer Shipping Information

$newSale->addParam('ship_name',$rowcust['fld_fullName']);

$newSale->addParam('ship_street_address',$rowcust['cust_address']);

$newSale->addParam('ship_city',$rowcust['cust_city']);

$newSale->addParam('ship_state',$rowcust['cust_state']);

$newSale->addParam('ship_zip',$rowcust['cust_zip']);

$newSale->addParam('ship_country',$rowcust['cust_country']);



$newSale->submitPayment();



?>