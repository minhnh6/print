<?php

session_start();

session_save_path('tmp/');

include('inc/global.php');

include("inc/header.php");

include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";

$ObjGen=new clsGeneral;

$successmessage="";

if($_POST['finalize']){
	$message="";
	if(!$_SESSION['_SESSUSERID_']){
		if(trim($_POST['login_email']) != "" and trim($_POST['login_password']) != "" and trim($_POST['login_email']) != "Email Address"){

			if($ObjGen->chkLogin(TB_USERS, "fld_userName", trim($_POST['login_email']),"fld_passWd",  trim($_POST['login_password']))){

				//session_register("_SESSUSERID_");
				
				$_SESSION['_SESSUSERID_']=$ObjGen->getVal(TB_USERS,"fld_userName",trim($_POST['login_email']), "fld_userId");

				if($totals>0){
					//echo '<script>window.location="checkout.php";</script>';
					echo '<script>window.location="payment-paypal.php";</script>';

				}else{

					echo '<script>window.location="index.php"</script>';

				}

			}else{

				$message="Login information you have provided is wrong.";

			}

		}else if(trim($_POST['register_email']) != "" and trim($_POST['register_password']) != "" and trim($_POST['register_fname']) != ""  and trim($_POST['register_email']) != "Email Address"){
		
			if(!$ObjGen->isExist(TB_USERS,"fld_userName",trim($_POST['register_email']))){
				$fld_fullName = trim($_POST['register_fname']).' '.trim($_POST['register_lname']);
				if($dbh->Query("insert into ".TB_USERS." (fld_userName,fld_passWd,fld_fullName,fld_lName,fld_fName,fld_phone,fld_addedOn) values ('".trim($_POST['register_email'])."','".trim($_POST['register_password'])."','".$fld_fullName."','".trim($_POST['register_lname'])."','".trim($_POST['register_fname'])."','".trim($_POST['register_phone'])."','".date('Y-m-d G:i:s')."')")){

					//session_register('_SESSUSERID_');

					$_SESSION['_SESSUSERID_']=$ObjGen->getVal(TB_USERS,"fld_userName",trim($_POST['register_email']), "fld_userId");

					if($totals>0){
						//echo '<script>window.location="checkout.php";</script>';
						echo '<script>window.location="payment-paypal.php";</script>';

					}else{

						echo '<script>window.location="index.php"</script>';

					}

				}else{

					$message="Some errors occured. Please try again.";

				}

			}else{

				$message="User with this email address already exists. Use another email address.";

			}

		}else{

			$message="Please check all inputs.";

		}

	}else{

		$message="";

	}

}

if($_POST['makepayment']=='Make Payment' && $_SESSION['_SESSUSERID_']!=''){
	$_SESSION['MakePayment']='';
	if($totals>0){
		echo '<script>window.location="payment-paypal.php";</script>';
		//echo '<script>window.location="checkout.php";</script>';
	}else{
		echo '<script>window.location="index.php"</script>';
	}
}
?>



<section class="login-register">
  <div class="container">
   <?php
		if($successmessage != ""){
			echo $successmessage;
		}else{
		?>
	
    <div class="login-register-title">
      <h1>Login or Register</h1>
    </div>
    <div class="row">
    	  <p id="ErrMsg">

            </p>
    	 <?php
			if($message!= ""){
			?>
				<span style="color:red"> <?php echo urldecode($message) ?> </span>
			<?php 
			}
			if(!$_SESSION['_SESSUSERID_']){
		
		  ?>
			

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="login-form">
          	<form method="post" name="checkout" action="" onsubmit="return checkmyform(this);" id="loginForm" name="finalize">
			<input type="hidden" name="makepayment" id="makepayment" value="<?php echo $_POST['makepayment'];?>" />
		
            <h4>Returning Customers</h4>
            <p>Please login below to continue:</p>
            <div class="form-group">
              <label for="usr">Email Address:</label>
              <input type="email"  id="login_email" name="login_email" class="form-control" id="usr" placeholder="Email"  />
            </div>
            <div class="form-group">
              <label for="usr">Password</label>
              <input type="password"  id="login_password" name="login_password" class="form-control" id="usr" placeholder="Password" />
            </div>
             <input  id="finalize" name="finalize" type="hidden" value="Finalize" />
            <button type="button" id="btnlogin" >Login</button>
             <a href="#"  data-toggle="modal" data-target="#forgot-password">Forgot Password?</a>
             </form>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="register-form">
        	<form method="post" name="checkout" action="" onsubmit="return checkmyform(this);" id="registerFrom" name="finalize">
		
			  <h4>Returning Customers</h4>
            <p>Please login below to continue:</p>
            <div class="form-group">
              <label for="usr">First Name:</label>
              <input type="text" id="register_fname" name="register_fname"  class="form-control"  placeholder="First Name" >
            </div>
            <div class="form-group">
              <label for="usr">Last Name:</label>
              <input type="text" class="form-control" id="register_lname" name="register_lname" placeholder="Last Name">
            </div>
            <div class="form-group">
              <label for="usr">Email Address:</label>
              <input type="email" name="register_email"   class="form-control" id="register_email" placeholder="Email" >
            </div>
            <div class="form-group">
              <label for="usr">Phone Number</label>
              <input type="text" class="form-control" id="register_phone" name="register_phone" placeholder="(888) 888-8888">
            </div>
            <div class="form-group">
              <label for="usr">Password</label>
              <input type="password" name="register_password"   class="form-control" id="register_password" placeholder="Password">
            </div>
             <input  id="finalize" name="finalize" type="hidden" value="Finalize" />
            <button  id="btnregister" type="button">Create Account</button>
            <p> By clicking "Create Account" you are agreeing to PrintRunner's <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>. PrintRunner.com may send you discounts and other offers. </p>
         	</form>
        </div>
        <?php } ?>
      </div>
    </div>
   	
    
  <?php } ?>
  </div>
</section>



<!--Forgot Password Modal-->
<div id="forgot-password" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reset Your Password</h4>
      </div>
      <div class="modal-body">
        <p>Please enter your email address below to receive a link for resetting your password:</p>
        <div class="alert alert-danger error-msg" id="file-error-forgot" style=" display:none">
          <h4><span class="glyphicon glyphicon-alert"></span> Error </h4>
          <ul id="forgot-error-display">
            <li><span for="email" class="error" style="display: inline;">Email is required.</span></li>
          </ul>
        </div>
        <form action="<?php echo LINK_PATH;?>" method="post" name="contactus" id="contactus" onsubmit="javascript: return false;">
        <div class="form-group">
        	
          <input type="text" name="register_email" id="register_email"  class="accountTxtFild" class="form-control" id="usr" placeholder="Enter Your Email Address">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" onclick="ForgotPassword();" class="btn btn-default forgot-password" data-dismiss="modal">Send Link</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php

include("inc/footer.php");

?>