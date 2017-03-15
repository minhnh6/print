<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
include("inc/header.php");
include("inc/leftmenu.php");
?>
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
<div class="right-box pre_left">
	<form action="<?php echo LINK_PATH;?>" method="post" name="contactus" id="contactus" onsubmit="javascript: return false;">
    <div class="heading-bar pre_left">
      <h1>Forgot Password</h1>
    </div>
    <div class="mid-box-ctg pre_clear pre_left mid-box-product mid-box" >
    <div class="CartOuter">
      <?php
        if(!$_SESSION['_SESSUSERID_']){
        ?>
        <div class="checform">
            <p>Enter your email adress:<br />
	            <input type="text" name="register_email" id="register_email"  class="accountTxtFild" value="Email Address">
                <input class="btn" id="ordernow" name="ordernow" type="submit" value="Submit" onclick="ForgotPassword();" />
            </p>
            <p id="ErrMsg">
            </p>
        </div>
    </div>
    <?php
	}
	?>
<!-- right side end -->
</div>
</form>
</div>
<?php
include("inc/footer.php");
?>