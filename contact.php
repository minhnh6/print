<?php
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='Contact Us: PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");
include("inc/leftmenu.php");;
?>
<script type="text/javascript">
function SendEnquiry(){
	var $inputs = $('#contactus :input');
    var datavalues ='';
    $inputs.each(function(){
        if(datavalues==''){
			datavalues = this.name+ ':' +$(this).val();
		}else{
			datavalues += '|'+ this.name+ ':' +$(this).val();
		}
    });
	$.ajax({
		url: '<?php echo INC_ROOT;?>contactmail.php',
		type:'get',
		data: {data:datavalues},
		success: function(data){
			if(data=='Mail Sent'){
				document.getElementById('ContactUsForm').innerHTML='Dear Customer, your request has been received. Our team will contact you soon.<br /><br />';
			}else{
				if(data=='security code dont`t metch.'){
					document.getElementById('ErrorMSG').innerHTML='security code dont`t match.<br /><br />';
				}else{
					document.getElementById('ErrorMSG').innerHTML='You Must Fill All Fields.<br /><br />';
				}
			}
		}
	});
}
</script>
<div class="contact pre_right"><h1>Contact Us</h1></div>
<div class="right-side">
<div class="right-side-form" id="ContactUsForm">
	<fieldset>
    <strong>Corporate HeadQuarters :</strong><br />
    PrintingPeriod LLC<br />
    one Commerce Center - 1201 Orange St #600<br />
    Wilmington - 19899<br />
    <span style="color:#1362D5;">24 Hours Friendly Phone Support +1(347)809-3342<br /><br /></span>
    <div id="ErrorMSG" class="block" style="clear:both;width:100%"></div>
	<form action="<?php echo LINK_PATH;?>" method="post" name="contactus" id="contactus" onsubmit="javascript: return false;">
    <h2>Name:</h2>
    <input name="Name" type="text" value="" />
    <h2>Email:</h2>
    <input name="Email" type="text" value="" />
    <h2>Telephone:</h2>
	<input name="tel" type="text" value="" />
    <h2>Message:</h2>
    <textarea name="message" cols="" rows=""></textarea>
     <h2>
		<?php
        require_once('recaptchalib.php');
        $publickey = "6Ler-uASAAAAAH2NaYnhnonbMqAOQgO_WLAf1rJF ";
        $privatekey = "6Ler-uASAAAAAOeiDoJ6e7x_vlwSxnocctw0EzME ";
        $resp = null;
        $error = null;
        echo recaptcha_get_html($publickey, $error);
        ?>
	</h2>

    <?php /*?><div class="send-now  pre_left"><a href="javascript:void(0);" onclick="formReset();">Reset</a></div><?php */?>
    <div class="send-now pre_right"><a href="javascript:void(0);" onclick="SendEnquiry();">Submit</a></div>
		<script type="text/javascript">
        function formReset(){
            document.getElementById("contactus").reset();
        }
        </script>
    </form>
   </fieldset>
</div>
<h1 style="padding-left:40px;">Questions or comments? Contact our customer support today</h1>
<ul>
  <li>For printing questions -  please see the FAQs in the
    Members' Area before contacting support. Clear answers to all common questions are posted there.</li>
  <li>For other information, please see our General FAQs.
    For password issues and questions not covered in FAQs, <br />
    Please contact <a href="mailto:support@printingperiod.com">support@printingperiod.com</a>.</li>
  <li>For licensing, advertising or resale opportunities, 
    Please contact <a href="mailto:manager@printingperiod.com">manager@printingperiod.com</a></li>
  <li>If you think you have what it takes, we invite you to <br />
    Introduce yourself: <a href="mailto:careers@printingperiod.com">careers@printingperiod.com.</a> See also our Careers page.</li>
  <li>If you have problems, questions or concerns with website performance, <br />
    Please contact <a href="mailto:webmaster@printingperiod.com">webmaster@printingperiod.com.</a></li>
</ul>
<p><br /></p>

</div>
</div>
 <!--main container end here-->
<?php
include("inc/footer.php");
?>
