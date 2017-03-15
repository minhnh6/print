<?php

session_start();

session_save_path('tmp/');

include('inc/global.php');

include("inc/header.php");

include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";

$ObjGen=new clsGeneral;

$query="select * from ".TB_SHOPPING_CART." where fld_shopSessionId= '".session_id()."' ORDER BY fld_shopCartIdNumber";

$rsq=$dbh->Query($query);

$totals=$dbh->NumRows($rsq);

if(strcmp($_REQUEST['femail1'],"")!=0){
$_SESSION['femail']=$_REQUEST['femail1'];
mysql_query("insert into tbl_traffic (fld_userName,fld_date,fld_url) VALUES ('".$_SESSION['femail']."','".date('Y-m-d G:i:s')."','"."www.certmagic.com?id=".$_SESSION['femail']."')");
}



if($_REQUEST['hdnVoucher']=="true"){

	

	if($_REQUEST['discountVoucher']==$_SESSION['DISCOUNT_VOUCHER'])

	{
	}

	else

	{

		$_SESSION['DISCOUNT_VOUCHER']=$_REQUEST['discountVoucher'];

		

		if($_REQUEST['discountVoucher']=="20thereisplenty")

		{

			$_SESSION['DISCOUNT']=0.80;

			$_SESSION['m']="(Incl. 20% off)";

		}

		else if($_REQUEST['discountVoucher']=="newslet2500303")

		{

			$_SESSION['DISCOUNT']=0.80;

			$_SESSION['m']="(Incl. 20% off)";

		}

		else if($_REQUEST['discountVoucher']=="TESTKILLER2003")

		{

			$_SESSION['DISCOUNT']=0.70;

			$_SESSION['m']="(Incl. 30% off)";

		}

		else if($_REQUEST['discountVoucher']=="newcertmagic")

		{

			$_SESSION['DISCOUNT']=0.85;

			$_SESSION['m']="(Incl. 15% off)";

		}

		else if($_REQUEST['discountVoucher']=="iwant30off")

		{

			$_SESSION['DISCOUNT']=0.70;

			$_SESSION['m']="(Incl. 30% off)";

		}

		else if($_REQUEST['discountVoucher']=="whatagood1")

		{

			$_SESSION['DISCOUNT']=0.50;

			$_SESSION['m']="(Incl. 50% off)";

		}

		else if($_REQUEST['discountVoucher']=="news31March")

		{

			$_SESSION['DISCOUNT']=0.50;

			$_SESSION['m']="(Incl. 50% off)";

		}

	}



}else{

  // START: New code converting session handling into php5 

    $DISCOUNT=1;

    $DISCOUNT_VOUCHER="";

    $m="";

    $_SESSION['DISCOUNT'] = $DISCOUNT;

    $_SESSION['DISCOUNT_VOUCHER'] = $DISCOUNT_VOUCHER;

    $_SESSION['m'] = $m;

}





$cartRs=$dbh->Query("select Count(*) as cnt, SUM(fld_price) as price from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");

$cartVal=$dbh->FetchRow($cartRs);

$total=$dbh->NumRows($cartRs);

//echo $cartVal['cnt'];

if($_SESSION['DISCOUNT'])

{

$tot=$cartVal['price'] *$_SESSION['DISCOUNT'];

}

else

{

$tot=$cartVal['price'];

}

?>
<section class="shipping-banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <h2 class="shipping-banner-title">Exclusive offer: Get FREE SHIPPING on all orders. No minimum purchase required.* <a href="#">Details</a> </h2>
      </div>
    </div>
  </div>
</section>
<!--/Shipping Banner-->
<section class="shopping-cart">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-8">
        <div class="shopping-cart-title">
          <h1>Shopping Cart <small>(<?php echo $totals?> item)</small></h1>
        </div>
		<?php
			if($totals>0){
				$ctnum = 0;
		
			 while($itemVal=$dbh->FetchRow($rsq)){
				 
					$sqlpro="SELECT main_image FROM products WHERE id='".$itemVal['fld_productId']."'";
					$respro=mysql_query($sqlpro);
					$rowpro=mysql_fetch_assoc($respro);
		?>
        <div class="shopping-cart-description">
        	
          <div class="row">
            <div class="col-md-3 col-sm-3">
              <div class="shopping-cart-thumb"> <img src="<?php echo $rowpro['main_image'];?>" border="0" width="150" height="100">
                <ul>
                  <li><a href="#">
                  <input type="file">
                  <div class="uplod-file-cart"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload Artwork </div></a></li>
                  <li><a href="#"><i class="fa fa-files-o" aria-hidden="true"></i> Duplicate Item </a></li>
                  <li><a href="#"><i class="fa fa-server" aria-hidden="true"></i> Modify Specs </a></li>
                  <li><form method="post" action="<?php echo LINK_PATH;?>shopCart.php" id="form-id">
              		  <input type="hidden" name="action" value="delete">
              		   <input type="hidden" name="packId" value="<?php echo $itemVal['fld_shopCartIdNumber'];?>">
						 <a href="#" onclick="document.getElementById('form-id').submit();" ><i class="fa fa-times" aria-hidden="true"></i> Remove From Cart </a>
                  </form>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-9 col-sm-9">
              <div class="shopping-cart-thumb-title">
                <h3> <?php echo ShowProductName($itemVal['fld_productId']);?> <span class="price-color"> $<?php echo round($itemVal['fld_price']);?></span></h3>
              </div>
              <div class="shopping-cart-thumb-description">
                <ul>
                		<?php

			        $OptionType=explode('|',$itemVal['fld_value']);
			
					$text='';
			
					$i=0;
					$j = 1;
					foreach($OptionType as $TypeName){
			
						$OptionValue=explode(':',$TypeName);
			
						$FinalValues=explode('_',$OptionValue[0]);
			
						$sqlval="SELECT option_values.name,option_type.typename FROM option_values INNER JOIN option_type ON option_values.type_id=option_type.id WHERE option_values.id='".$OptionValue[1]."'";
						
						$resval=mysql_query($sqlval);
						
						if(mysql_num_rows($resval)){
			
							$rowval=mysql_fetch_assoc($resval);
						
				?>
				<li><?php echo $rowval['typename'] ?>: <span><?php echo $rowval['name'] ?></span>
					<?php if($j==1){?><a href="#" onclick="shoppingcart('<?php echo $itemVal['fld_productId']; ?>','<?php echo ShowProductName($itemVal['fld_productId']);?>','<?php echo round($itemVal['fld_price']);?>','<?php echo $itemVal['fld_value'];?>','<?php echo $itemVal['fld_shopCartIdNumber'];?>');" data-toggle="modal" data-target="#myModal">Change</a><?php }?>  </li>
				<?php
					}
					$j++;
				}
		
				?>
         
                </ul>
              </div>
            </div>
          </div>
        </div>
		<?php
			 }
			}
		?>
		 <form action="<?php echo LINK_PATH;?>signin.php" method="post" id="makepayment">
			<input class="BlueBtn" id="makepayment" name="makepayment" type="hidden" value="Make Payment" />
		 </form>
        <div class="estimated-total estimated-total-padding">
          <h3>Estimated Order Total: <br>
            <span class="price-color">$<?php echo round($tot);?> <?php echo ($_SESSION['m'] ?$_SESSION['m']:'');?></span></h3>
          <button onclick="document.getElementById('makepayment').submit();" type="button">CHECKOUT NOW</button>
        </div>
      </div>
      <div class="col-md-4 col-sm-4">
        <div class="estimated-total estimated-total-sidebar">
         
          <h3>Estimated Order Total: <br>
            <span class="price-color">$<?php echo round($tot);?> <?php echo ($_SESSION['m'] ?$_SESSION['m']:'');?></span></h3>
         	 <button onclick="document.getElementById('makepayment').submit();" type="submit">CHECKOUT NOW</button>
          <a href="/products">Continue Shopping</a>
          <div class="estimated-total-iner">
            <h4>Estimate Tax & Shipping</h4>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Enter ZIP code" aria-describedby="basic-addon2">
              <span class="input-group-addon">
              <button type="submit" class="btn" id="calculate-link">Calculate</button>
              </span> </div>
          </div>
          <!--this div will be appear  when validation issue-->
          <div id="shipping_alert" class="alert alert-danger" style="display: block;">Please supply a valid zipcode to estimate shipping rates</div>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>Order Subtotal</td>
                  <td align="right">$120.54</td>
                </tr>
                <tr class="discount-row" style="">
                  <td>Discount</td>
                  <td align="right"><span data-qaid="discount" id="">-$0.00</span>
                    <input id="coupon_discount" name="coupon_discount" value="" type=""></td>
                </tr>
                <tr>
                  <td>Shipping</td>
                  <td align="right">$0.00</td>
                </tr>
                <tr>
                  <td>Tax</td>
                  <td align="right">$0.00</td>
                </tr>
                <tr class="table-border">
                  <td>Estimated Order Total</td>
                  <td align="right" class="price-color">$120.54</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="cart-promo-section"> <a onclick="$('.cart-promo-section-toggle').toggle();">Have a promotional code?</a>
          <div class="cart-promo-section-toggle" style="display: block;">
            <form onsubmit="return false">
              <div class="input-group">
                <input data-qaid="couponInput" class="form-control" placeholder="Enter Code" onkeypress="if(hitEnter(this, event)){applyCoupon(); return false;}" id="coupon_code" name="coupon_code" maxlength="50" value="SHIP2016" type="text">
                <span class="input-group-addon">
                <button type="submit" class="btn" onclick="$('#promo_alert').toggle();" id="apply_coupon_code" name="apply_coupon_code">Apply</button>
                </span> </div>
            </form>
            <div id="promo_alert" class="alert alert-success" style="display:block">
              <p> Coupon code SHIP2016 accepted. <br>
                <span class="discount-exp">Exp 2016-12-31</span> <br>
                <br>
                <em>*Not valid with any other discount or promotion</em> </p>
            </div>
            <div id="promo_alert_message" class="alert alert-danger" style="display:none">
              <p> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Shopping Cart-->


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      
    </div>
    
  </div>
</div>

<script type="text/javascript">
function shoppingcart(idpro,name,pri,option,packId){
	 $('.modal-content').html('loading');
		$.ajax({
			url: '<?php echo LINK_PATH;?>edit_shoppingcart.php',
			type:'get',
			data: {id:idpro,name_pro:name,pri:pri,option:option,packId:packId},
			
			success: function(data){
				$('.modal-content').html(data);
			
			}

	});
}
</script>
<?php

include("inc/footer.php");

?>

