<section id="bottom">
  <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="About-Us">
          <h3>About Us</h3>
          <div class="footer-address">
          <div class="address-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i></div>
          <div class="address-description">
            <h4>Address</h4>
            <address>
            Floor, No. 110 Henan <br>
            Communication Industry Park
            </address>
          </div>
          </div>
          <div class="footer-phone">
          <div class="address-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
          <div class="address-description">
            <h4>Phone</h4>
            <P>+86 875369208 - Central Office</P>
          </div>
          </div>
          <div class="footer-fax">
          	<div class="address-icon"><i class="fa fa-print" aria-hidden="true"></i></div>
          <div class="address-description">
            <h4>Fax</h4>
            <P>+86 875369208 - Central Office </P>
          </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 hidden-sm">
        <div class="quick-links">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="/"><i class="fa fa-angle-right" aria-hidden="true"></i> Home</a></li>
            <li><a href="aboutus.html"><i class="fa fa-angle-right" aria-hidden="true"></i> Product</a></li>
            <li><a href="template.html"><i class="fa fa-angle-right" aria-hidden="true"></i> Free Templats</a></li>
            <li><a href="customquote.html"><i class="fa fa-angle-right" aria-hidden="true"></i> Custome Quote</a></li>
            <li><a href="aboutus.html"><i class="fa fa-angle-right" aria-hidden="true"></i> About Us</a></li>
            <li><a href="testimonials.html"><i class="fa fa-angle-right" aria-hidden="true"></i> Testimonials</a></li>
            <li><a href="faq.html"><i class="fa fa-angle-right" aria-hidden="true"></i> FAQs</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-info">
          <h3>Get In Touch With Us</h3>
			<?php include("inc/formcontact.php");?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/#bottom-->

<footer id="footer" class="midnight-blue">
  <div class="container">
    <div class="row">
      <div class="col-sm-6"> &copy; 2017 <a target="_blank" href="http://www.printingperiod.com">Printingperiod</a>. All Rights Reserved. </div>
      <div class="col-sm-6">
        <ul class="pull-right">
          <li><a href="#"><img src="<?php echo LINK_PATH;?>images/visa.png"></a></li>
          <li><a href="#"><img src="<?php echo LINK_PATH;?>images/paypal.png"></a></li>
          <li><a href="#"><img src="<?php echo LINK_PATH;?>images/cradit.png"></a></li>
          <li><a href="#"><img src="<?php echo LINK_PATH;?>images/cradit-withdraw.png"></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--/#footer--> 
<!-- Video / Generic Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"> 
        <!-- content dynamically inserted --> 
      </div>
    </div>
  </div>
</div>
<script src="<?php echo LINK_PATH;?>js/jquery.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo LINK_PATH;?>js/bootstrap.min.js"></script> 
<script src="<?php echo LINK_PATH;?>js/jquery.prettyPhoto.js"></script> 
<script src="<?php echo LINK_PATH;?>js/jquery.isotope.min.js"></script> 
<script src="<?php echo LINK_PATH;?>js/main.js"></script> 
<script src="<?php echo LINK_PATH;?>js/wow.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo LINK_PATH;?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo LINK_PATH;?>js/jquery-ui.js"></script> 
<script src="<?php echo LINK_PATH;?>js/cloud-zoom.js"></script> 
<script src="<?php echo LINK_PATH;?>js/html5shiv.js"></script>
<script src="<?php echo LINK_PATH;?>js/jquery.validate.js"></script>

<script src="<?php echo LINK_PATH;?>rating/js/star-rating.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH;?>js/scripts.js"></script>

<script type="text/javascript">
$( "#IPCalculator" ).load(function() {
	InstantPrice();
	});
$.ajaxPrefilter(function( options, original_Options, jqXHR ) {
    options.async = true;
});
</script>
<script type="text/javascript">
function InstantPrice(){
	var $inputs = $('#IPCalculator :input');
    var datavalues ='';
    $inputs.each(function(){
        if(datavalues==''){
			datavalues = this.name+ ':' +$(this).val();
		}else{
			datavalues += '|'+ this.name+ ':' +$(this).val();
		}
    });
	
	var baseval,
	element = document.getElementById('base');
	if (element != null) {
		baseval = element.value;
	}
	else {
		baseval = null;
	}

	
	$.ajax({
		url: '<?php echo LINK_PATH;?>ipcalc.php',
		type:'GET',
		data: {data:datavalues,base:baseval},
		success: function(data){
			
			document.getElementById('hide_result').value=parseFloat(data);
			document.getElementById('result').value='$'+parseFloat(data);
			$('.result1').html(data);
		}
		
	});
}

</script>
<script type="text/javascript">

function ForgotPassword(){

	var datavalues;

	datavalues=document.getElementById('register_email').value;

	$.ajax({
		url: '<?php echo LINK_PATH;?>forgotmail.php',
		type:'get',

		data: {data:datavalues},

		success: function(data){
			
			document.getElementById('ErrMsg').innerHTML=data;
		}

	});

}

</script>

<script>
	
	$().ready(function() {
		if($("#IPCalculator").length != 0) {
			  InstantPrice();
			 }
		$("#contactus").validate({
			rules: {
				Name: "required",
				Email: "required",
				tel: "required",
				message: "required"
			},
			messages: {
				Name: "Please enter your Name",
				Email: "Please enter your Email",
				tel: "Please enter your Phone",
				message: "Please enter your Comment"
			
			}
		});
		$('#contactusForm').click(function() {
			 if($("#contactus").valid()){ // This is not working and is not validating the form
				 SendEnquiry();
			 }
		});
		
		
		$("#BillingForm").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				phone: "required",//address
				address: "required",
				agree: "required"
				
			},
			messages: {
				firstname: "Please enter your First name",
				lastname: "Please enter your Last name",
				phone: "Please enter your Phone",
				address: "Please enter your Address",
				agree: "Please accept our policy"
			
			}
		});

		$("#PaymentForm").validate({
			rules: {
				paynumber: "required",
				ddate: "required",
				pnum: "required"
				
			},
			messages: {
				paynumber: "Please enter your field",
				ddate: "Please enter your Last field",
				pnum: "Please enter your field"
			
			}
		});
		
		$('#bt1').click(function() {
			 if($("#BillingForm").valid()){ // This is not working and is not validating the form
			 	document.getElementById('bt1').style.display = 'none';
			  	document.getElementById('bt2').style.display = 'block';
			 }
		});
		$('#bt3').click(function() {
			 if($("#PaymentForm").valid()){ // This is not working and is not validating the form
			 	document.getElementById('bt3').style.display = 'none';
			  	document.getElementById('bt4').style.display = 'block';
			 }
			});

		$("#BillingForm").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				phone: "required",//address
				address: "required",
				agree: "required"
				
			},
			messages: {
				firstname: "Please enter your First name",
				lastname: "Please enter your Last name",
				phone: "Please enter your Phone",
				address: "Please enter your Address",
				agree: "Please accept our policy"
			
			}
		});
		$('#bt1').click(function() {
			 if($("#BillingForm").valid()){ // This is not working and is not validating the form
			 	document.getElementById('bt1').style.display = 'none';
			  	document.getElementById('bt2').style.display = 'block';
			 }
			});
		$("#CustomQuote").validate({
			rules: {
				fname: "required",
				lname: "required",
				email: "required",
				phone: "required",
				company: "required",
				//quantity: "required",
				quantity: {
					required: true,
				
					number: true
				},
				ddate: "required",
				comment: "required"
				
			},
			messages: {
				fname: "Please enter your First Name",
				lname: "Please enter your Last Name",
				email: "Please enter your Email",
				phone: "Please enter your Phone",
				company: "Please enter your Company Name",
				quantity: "Please enter your Quantity",
				ddate: "Please enter your Date",
				comment: "Please enter your Comment"
			
			}
		});
		$('#btnCustomQuote').click(function() {
			 if($("#CustomQuote").valid()){ // This is not working and is not validating the form
				 document.getElementById('CustomQuote').submit();
			 }
			});
		$("#loginForm").validate({
			rules: {
				login_email: "required",
				login_password: "required"
				
			},
			messages: {
				login_email: "Please enter your Email",
				login_password: "Please enter your Password",
			
			}
		});
	});
	$('#btnlogin').click(function() {
		 if($("#loginForm").valid()){ // This is not working and is not validating the form
			 document.getElementById('loginForm').submit();
		 }
	});

	$("#registerFrom").validate({
		rules: {
			register_fname: "required",
			register_lname: "required",
			register_email: "required",
			register_phone: "required",
			register_password: "required"
			
		},
		messages: {
			register_fname: "Please enter your First Name",
			register_lname: "Please enter your Last Name",
			register_email: "Please enter your Email",
			register_phone: "Please enter your Phone",
			register_password: "Please enter your Password"
		
		}
	});
	$("#bv-submitreview-product_Form").validate({
		rules: {
			title: "required",
			reviewtext: "required",
			usernickname: "required",
			userlocation: "required",
			email: "required",
		
			
		},
		messages: {
			title: "Please enter your field",
			reviewtext: "Please enter your field",
			usernickname: "Please enter your field",
			userlocation: "Please enter your field",
			email: "Please enter your field",
		
			
		
		}
	});
	$('#btn_rating').click(function() {
			var rating = $('#kv-gly-star').val();
			if(rating ==""){
				$('.rating_error').css('display', 'block');
				$('.rating_error').css('background', 'red');
				$('.rating_succecs1').css('display', 'none');
			}
       
			if($("#bv-submitreview-product_Form").valid()){ 
				var $inputs = $('#bv-submitreview-product_Form :input');
			    var datavalues ='';
			    $inputs.each(function(){
			        if(datavalues==''){
						datavalues = this.name+ ':' +$(this).val();
					}else{
						datavalues += '|'+ this.name+ ':' +$(this).val();
					}
			    });
			
			    $.ajax({
					url: '<?php echo LINK_PATH;?>rating_sumit.php',
					type:'post',
					data: {data:datavalues},
					success: function(data){
						$(".modal").modal("hide");
					}

				});
				
			 }
	});
$('.close').click(function() {
	$('#kv-gly-star').rating('reset');
	$('#kv-gly-quality').rating('reset');//clear-rating
	$('#kv-gly-value').rating('reset');//clear-rating
	$('.rating_succecs1').css('display', 'block');
	$('.rating_succecs1').css('background', '#FFF');
	$('.rating_succecs2').css('display', 'block');
	$('.rating_succecs2').css('background', '#FFF');
	$('.rating_succecs3').css('display', 'block');
	$('.rating_succecs3').css('background', '#FFF');
	$('.rating_error').css('display', 'none');
});

$('#btnregister').click(function() {
	 if($("#registerFrom").valid()){ // This is not working and is not validating the form
		 document.getElementById('registerFrom').submit();
	 }
});

	
	function shipping(){
			document.getElementById('bt2').style.display = 'none';
			document.getElementById('bt3').style.display = 'block';
	}
</script>
<script>
    $(document).on('ready', function () {
    	$('.rating-product').rating('refresh', {disabled: true, showClear: false, showCaption: false});
    	$('#input-21f').rating('refresh', {disabled: true, showClear: false, showCaption: false});
    	$('#kv-gly-star').on('rating.change', function () {
    		$('.rating_error').css('display', 'none');
			$('.rating_succecs1').css('display', 'block');
    		$('.rating_succecs1').css('background', '#5cb85c');
         });
    	var $inp = $('#kv-gly-quality');
        $inp.rating({
            showClear: false,
        });
        $inp.on('rating.change', function () {
    		$('.rating_succecs2').css('background', '#5cb85c');
         });
        var $inpv = $('#kv-gly-value');
        $inpv.rating({
            showClear: false,
        });
        $inpv.on('rating.change', function () {
    		$('.rating_succecs3').css('background', '#5cb85c');
         });
    });
</script>
<script type="text/javascript">
function modal_rating(id_pro){
	var base_url = '<?php echo LINK_PATH;?>';
		$.ajax({
			url: '<?php echo LINK_PATH;?>modal_rating.php',
			type:'post',
			data: {id:id_pro},
			 dataType  : 'json',
			success: function(data){
				var ptitle = data["ptitle"]; 
				var main_image = data["main_image"]; 
				$('.ptitle').html(ptitle);
				$('.ajxa-img').html('<img class="bv-subject-image" src="' + base_url +'' + main_image + '" >');
				
				
			
			}

	});
}
</script>
</body>
</html>