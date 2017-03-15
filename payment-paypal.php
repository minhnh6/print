 <?php  
error_reporting('0');
 session_start(); 

 ?>
 
 <?php

include("inc/global.php");


$return='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/paypal_success.php';

$return_cancel='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/paypal_cancel.php';




$sqlcart="SELECT * FROM tbl_shopcart WHERE fld_shopSessionId= '".session_id()."'";

$rescart=mysql_query($sqlcart);

$i=0;
$totPrice=0;
while($rowcart=mysql_fetch_assoc($rescart)){

	$sqlprd="SELECT ptitle, cat_id FROM products WHERE id= '".$rowcart['fld_productId']."'";

	$resprd=mysql_query($sqlprd);

	$rowprd=mysql_fetch_assoc($resprd);

	$sqlcat="SELECT title FROM category WHERE id= '".$rowprd['cat_id']."'";

	$rescat=mysql_query($sqlcat);

	$rowcat=mysql_fetch_assoc($rescat);
	
	$totPrice=$totPrice+$rowcart['fld_price'];
	
	$ornum=$rowcart['fld_productId'];
	$strDesc=$rowprd['ptitle'];
	//$newSale->addParam('li_'.$i.'_type',$rowcat['title']);

//	$newSale->addParam('li_'.$i.'_name',$rowprd['ptitle']);

	//$newSale->addParam('li_'.$i.'_price',$rowcart['fld_price']);

//	$newSale->addParam('li_'.$i.'_quantity','1');

	//$newSale->addParam('li_'.$i.'_product_id',$rowcart['fld_productId']);

	$i++;

}

?>





<form name="frmGateway1" action="https://www.paypal.com/cgi-bin/webscr" method="post">

  		 <input type="hidden" name="charset" value="utf-8"> 
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="item_name" value="PrintingPeriod.com <?php echo $strDesc; ?>" />
        <input type="hidden" name="return" value="http://printingperiod.com/paypal_success.php" />
        <input type="hidden" name="cancel_return" value="http://printingperiod.com/paypal_cancel.php" />
        <input type="hidden" name="business" value="bx78lunch@gmail.com" />
        <input type="hidden" name="currency_code" value="USD" />
        <input type="hidden" name="amount" value="<?php echo $totPrice; ?>" />


</form>




<script>

	document.frmGateway1.submit();

</script>