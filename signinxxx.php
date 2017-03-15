<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
include("inc/header.php");
include("inc/leftmenu.php");
include DR_ADMIN_BASE_ROOT."classes/clsGeneral.php";
$ObjGen=new clsGeneral;
$successmessage="";
if($_POST['finalize']){
	$message="";
	if(!$_SESSION['_SESSUSERID_']){
		if(trim($_POST['login_email']) != "" and trim($_POST['login_password']) != "" and trim($_POST['login_email']) != "Email Address"){
			if($ObjGen->chkLogin(TB_USERS, "fld_userName", trim($_POST['login_email']),"fld_passWd",  trim($_POST['login_password']))){
				session_register("_SESSUSERID_");
				$_SESSION['_SESSUSERID_']=$ObjGen->getVal(TB_USERS,"fld_userName",trim($_POST['login_email']), "fld_userId");
				if($totals>0){
					echo '<script>window.location="payment.php";</script>';
				}else{
					echo '<script>window.location="index.php"</script>';
				}
			}else{
				$message="Login information you have provided is wrong.";
			}
		}else if(trim($_POST['register_email']) != "" and trim($_POST['register_password']) != "" and trim($_POST['register_fname']) != ""  and trim($_POST['register_email']) != "Email Address"){
			if(!$ObjGen->isExist(TB_USERS,"fld_userName",trim($_POST['register_email']))){
				if($dbh->Query("insert into ".TB_USERS." (fld_userName,fld_passWd,fld_fullName,fld_addedOn) values ('".trim($_POST['register_email'])."','".trim($_POST['register_password'])."','".trim($_POST['register_fname'])."','".date('Y-m-d G:i:s')."')")){
					session_register('_SESSUSERID_');
					$_SESSION['_SESSUSERID_']=$ObjGen->getVal(TB_USERS,"fld_userName",trim($_POST['register_email']), "fld_userId");
					if($totals>0){
						echo '<script>window.location="payment.php";</script>';
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
	echo '<script>window.location="payment.php";</script>';
}
?>
<script language="JavaScript">
function editInfo(){
	location.replace("<?php echo DR_ROOT;?>editInfo.php");
}
function frm(){
document.frme.submit();
//alert(document.frme.femail1.value);
}
function validateSignupEmail( strValue){
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{2,4})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
//check for valid email
//return objRegExp.test(strValue);
return true;
}
	function validate(){
		if(!validateSignupEmail(document.frme.femail1.value)){
			alert("Please enter a valid email address.");
			document.frme.femail1.focus();
			return false;
		}
	}
	function checkmyform(form){
		if((form.register_email.value=="" && form.login_email.value=="") || (form.register_email.value=="Email Address" && form.login_email.value=="Email Address")){
			alert("Please Register or login as user to proceed");
			form.login_email.focus();
			return false;
		}
		if(form.register_email.value!=""){
			if(!validateSignupEmail(form.register_email.value)){
				alert("Please check your email address");
				form.register_email.focus();
				return false;
			}
			if(form.register_password.value==""){
				alert("Enter your password");
				form.register_password.focus();
				return false;
			}
			if(form.register_confpassword.value==""){
				alert("Please confirm your password");
				form.register_password.focus();
				return false;
			}
			if(form.register_confpassword.value!=form.register_password.value){
				alert("Your confirmation password doesn't match");
				form.register_confpassword.focus();
				return false;
			}
			if(form.register_fname.value==""){
				alert("Please enter your name");
				form.register_fname.focus();
				return false;
			}
		}else{
			if(form.login_email.value==""){
				alert("Enter your email address for login");
				form.login_email.focus();
				return false;
			}
			if(form.login_password.value==""){
				alert("Please enter your password");
				form.login_password.focus();
				return false;
			}
		}
	}
</script>

<div class="right-box pre_left">
  <?php
		if($successmessage != ""){
			echo $successmessage;
		}else{
		?>
  <form method="post" name="checkout" action="signin.php" onsubmit="return checkmyform(this)">
	<input type="hidden" name="makepayment" id="makepayment" value="<?php echo $_POST['makepayment'];?>" />
    <?php
	if($message!= ""){
	?>
    <div class="heading-bar pre_left">
      <h1>Message</h1>
    </div>
    <div class="mid-box-ctg pre_clear pre_left mid-box-product mid-box" >
      <div class="CartOuter"> <?php echo urldecode($message) ?> </div>
    </div>
    <?php
	}
 ?>
    <div class="heading-bar pre_left">
      <h1>Sign in/ Register</h1>
    </div>
    <div class="mid-box-ctg pre_clear pre_left mid-box-product mid-box" >
    <div class="CartOuter">
      <?php
        if(!$_SESSION['_SESSUSERID_']){
        ?>
      <div class="checform">
        <h1>New User</h1>
        ( Please fill this Portion only if you do not have a Account)<br />
        <p>Email Address<br />
          <input type="text" name="register_email" onfocus="blank(this)" onblur="unblank(this)" class="accountTxtFild" value="Email Address">
        </p>
        <p> Password<br />
          <input type="password" name="register_password" onfocus="blank(this)" onblur="unblank(this)" class="accountTxtFild" value="Password">
        </p>
        <p> Confirm Password<br />
          <input type="password" name="register_password" onfocus="blank(this)" onblur="unblank(this)" class="accountTxtFild" value="Password">
        </p>
        <p> Full Name<br />
          <input type="text" name="register_fname" onfocus="blank(this)" onblur="unblank(this)" class="accountTxtFild" value="Full Name">
        </p>
      </div>
      <div class="checform">
        <h1>Existing User</h1>
        ( Please fill this Portion only if you have a Account)
        <p>Email Address<br />
          <input type="text" onfocus="blank(this)" onblur="unblank(this)" name="login_email" class="accountTxtFild" value="Email Address">
        </p>
        <p> Password<br />
          <input type="password" onfocus="blank(this)" onblur="unblank(this)" name="login_password" class="accountTxtFild" value="Password">
        </p>
        <p align="right"><strong style="padding-right:80px;"><a href="<?php echo LINK_PATH;?>forgotpassword.php" style="color:#FF0000; text-decoration:none;">Forgot Password</a></strong></p>
      </div>
    </div>
    <?php
	}
	?>
    <div class="HeadValues">
	    <div style="float:right;width:auto;"><input class="BlueBtn" id="finalize" name="finalize" type="submit" value="Finalize" /></div>
	</div>
<!-- right side end -->
<?php
}?>
</div>
</form>
</div>
<?php
include("inc/footer.php");
?>