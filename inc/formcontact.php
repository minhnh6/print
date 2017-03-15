<form method="post" action="javascript:void(0);" name="contactus" id="contactus" onsubmit="javascript: return false;">
	<div class="row">
	  <div class="col-md-6 col-sm-6">
		<div class="form-group">
		  <input type="text" class="form-control" name="Name" id="Name" class="email" placeholder="Name">
		</div>
		<div class="form-group">
		  <input type="email" class="form-control" name="Email" id="Email" class="email" placeholder="Email">
		</div>
		<div class="form-group">
		  <input type="number"  class="form-control" name="tel" id="tel" class="email" placeholder="Phone">
		</div>
		<div class="form-group" style="color:white" id="ContactUsForm">
		  
		</div>
	  </div>
	  <div class="col-md-6 col-sm-6">
		<div class="form-group">
		  <textarea class="form-control" rows="5" name="message"  class="comment" placeholder="Message"></textarea>
		</div>
		<button type="button" id="contactusForm"  class="form-btn">Send</button>
	  </div>
	</div>
  </form>
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
		url: '<?php echo LINK_PATH;?>contactmail.php',
		type:'get',
		data: {data:datavalues},
		success: function(data){
			if(data=='Mail Sent'){
				document.getElementById('ContactUsForm').innerHTML='<fieldset>Dear Customer, your request has been received. Our team will contact you soon.<br /><br /></fieldset>';
			}else{
				if(data=='security code dont`t metch.'){
					document.getElementById('ContactUsForm').innerHTML='security code dont`t match.<br /><br />';
				}else{
					document.getElementById('ContactUsForm').innerHTML='You Must Fill All Fields.<br /><br />';
				}
			}
			document.getElementById("contactus").reset();
		}
	});
	
}
</script>
