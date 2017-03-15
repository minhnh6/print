<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
include("inc/header.php");
include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";
$ObjGen=new clsGeneral;
$query="select * from tbl_order where fld_userIdNo = '".$_SESSION['_SESSUSERID_']."' ORDER BY fld_orderDate DESC";
$rsq=$dbh->Query($query);
$totals=$dbh->NumRows($rsq);
?>
    <!-- right side start -->   
<div class="right-box pre_left">
  <div class="heading-bar pre_left"><h1>My Account</h1></div>
	<?php
    if($totals>0){
        $ctnum = 0;
    ?>
  <div class="heading-bar pre_left">
		<div class="HeadTitle">
          <div class="PrdImg">Order</div>
          <div class="PrdHead">Order Date</div>
          <div class="QtyHead">Order Status</div>
          <div class="PriceHead">Price</div>
        </div>
	</div>
	<div class="mid-box-ctg pre_clear pre_left mid-box-product mid-box" >        
      <div class="CartOuter">
  <?php
  $TotShop=0;
  while($itemVal=$dbh->FetchRow($rsq)){
  ?>
    <div class="HeadValues CartLine">
        <div class="PrdImg"><?php echo $itemVal['fld_orderIdNumber'];?></div>
        <div class="PrdHead"><?php echo substr($itemVal["fld_orderDate"],0,10);?></div>
        <div class="QtyHead"><?php echo $itemVal['fld_orderStatus'];?></div>
        <div class="PriceHead">$<?php echo round($itemVal['fld_totalPrice']);?></div>
    </div>
  <?php
	$TotShop += $itemVal['fld_totalPrice'];
   }
   ?>
   <div class="HeadValues">
	  <div class="PrdImg">&nbsp;</div>
      <div class="PrdHead">&nbsp;</div>
      <div class="QtyHead"><strong>Total</strong></div>
      <div class="PriceHead"><strong>$<?php echo round($TotShop);?></strong></div>
    </div>
   <?php
   } else {
   ?>
	<div class="mid-box-ctg pre_clear pre_left mid-box-product mid-box" >        
      <div class="CartOuter">
        <div class="HeadValues">
        There are no product at your cart.
        </div>
		</div>
	</div>
    <?php
   }
    ?>
</div>
</div></div>

</div><!--main container end here-->
<?php
include("inc/footer.php");
?>
