<?php 
session_start();

session_save_path('tmp/');

include('inc/global.php');

include("inc/header.php");

include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";

$ObjGen=new clsGeneral;


?>
<!--/header-->
<section class="check-out">
<div class="container">
<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="check-out-inner-1">
    <!--  <div class="email-address">
        <div class="blue-circle"> <span>1</span> </div>
        <div class="email-title">
          <h2>Email Address</h2>
        </div>
        <div class="email-inner">
          <div class="form-group">
            <input type="email" class="form-control" id="usr" placeholder="Email" required>
          </div>
          <button type="button" class="btn btn-info">Login</button>
          <button type="button" class="btn btn-info">Create Account</button>
          <button type="button" class="btn btn-info">Continue</button>
        </div>
      </div> -->
      <div class="billing-info">
        <div class="blue-circle"> <span>1</span> </div>
        <div class="email-title">
          <h2>Billing Information</h2>
        </div>
        <form class="cmxform" id="BillingForm" method="post" action="javascript:void(0)">
	
          <div class="form-group">
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" >
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" >
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone(555)-555-5555" >
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="company" id="company" placeholder="Company" >
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" >
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="city" id="city" placeholder="City" >
          </div>
		   <div class="form-group">
            <input type="text" class="form-control" name="state" id="state" placeholder="State" >
          </div>
         
          <div class="form-group">
            <input type="text" class="form-control" id="zip" placeholder="Zip Code" name="zip" value="">
          </div>
          <div class="form-group">
            <?php include_once('country.php');?>
          </div>
          <div class="form-group">
			<input type="checkbox" id="agree" name="agree">
            <label class="same" for="same_as_shipping">Same As Shipping Address</label>
           </div>
          <button type="button"  class="btn btn-info" id="bt1">Continue</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="check-out-inner-1">
      <div class="email-address">
        <div class="blue-circle"> <span>2</span> </div>
        <div class="email-title">
          <h2>Shipping Information</h2>
        </div>
        <div class="clear"></div>
        <div class="email-inner">
		
          <div class="radio">
            <label>
              <input type="radio" checked="checked" name="optradio">
              Standard Shipping $4.00</label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="optradio">
              Express Shipping $8.00</label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="optradio">
              Overnight Shipping $12.00</label>
          </div>
          <button type="button" style="display:none" onclick="shipping();" class="btn btn-info" id="bt2">Continue</button>
        </div>
      </div>
      <div class="blue-circle"> <span>3</span> </div>
      <div class="email-title">
        <h2>Payment Information</h2>
      </div>
      <form class="cmxform" id="PaymentForm" method="post" action="javascript:void(0)">
        <div class="form-group">
          <input type="text" class="form-control" name="paynumber"  id="paynumber" placeholder="xxxx-xxxx-xxxx-xxxx">
        </div>
        <div class="input-group date"  data-provide="datepicker">
          <input type="text" class="form-control" name="ddate"  id="ddate" placeholder="Expiry Date">
          <div class="input-group-addon"> <span class="glyphicon glyphicon-th"></span> </div>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="pnum"  id="pnum" id="usr" placeholder="123">
        </div>
      </form>
      <div class="accepted">
        <ul>
          <li><img src="http://i.imgur.com/Z5HVIOt.png"></li>
          <li><img src="http://i.imgur.com/Le0Vvgx.png"></li>
          <li><img src="http://i.imgur.com/D2eQTim.png"></li>
          <li><img src="http://i.imgur.com/Pu4e7AT.png"></li>
          <li><img src="http://i.imgur.com/ewMjaHv.png"></li>
          <li><img src="http://i.imgur.com/3LmmFFV.png"></li>
        </ul>
      </div>
      <div class="clear"></div>
      <div class="secured"> <img class="lock" src="http://i.imgur.com/hHuibOR.png">
        <p class="security info">What, well you mean like a date? Doc? Am I to understand you're still hanging around with Doctor Emmett Brown, McFly? Tardy slip for you, Miss Parker. And one for you McFly I believe that makes four in a row.</p>
      </div>
      <button type="button" style="display:none" class="btn btn-info" id="bt3">Continue</button>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="check-out-inner-1">
      <div class="email-inner">
        <div class="email-address">
          <div class="blue-circle"> <span>4</span> </div>
          <div class="email-title">
            <h2>Finalize Order</h2>
          </div>
          <div class="clear"></div>
          <div class="left" id="ordered">
            <div class="products">
              <div class="product_image"> <img src="images/Bumper-sticker.jpg"> </div>
              <div class="product_details"> <span class="product_name">Cherry Bikini</span> <span class="quantity">1</span> <span class="price">$45.00</span> </div>
            </div>
            <div class="clear"></div>
            <div class="totals"> <span class="subtitle">Subtotal <span id="sub_price">$45.00</span></span> <span class="subtitle">Tax <span id="sub_tax">$2.00</span></span> <span class="subtitle">Shipping <span id="sub_ship">$4.00</span></span> </div>
            <div class="final"> <span class="title">Total <span id="calculated_total">$51.00</span></span> </div>
          </div>
          <div class="table-responsive">
            <table class="table custom-shipping-info">
              <tbody>
                <tr>
                  <td style="font-weight:bold"> Billing:</td>
                  <td class="shipping-adres"> John Smith <br>
                    123 Main Street<br>
                    Everytown, USA, 12345<br>
                    (123)867-5309 </td>
                </tr>
                <tr>
                  <td style="font-weight:bold"> Shipping:</td>
                  <td class="shipping-adres"> John Smith 123 Main Street <br>
                    Everytown, USA, 12345<br>
                    (123)867-5309 </td>
                </tr>
                <tr>
                  <td style="font-weight:bold"> Payment:</td>
                  <td class="shipping-adres"> Visa<br>
                    xxxx-xxxx-xxxx-1111 </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <button type="button" style="display:none" class="btn btn-info" id="bt4">Complete Order</button>
    </div>
  </div>
</div>
</section>
<div class="clear"></div>

<?php include('inc/footer.php'); ?>
