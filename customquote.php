<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='Custom Quote : PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");


?>
<section class="Custom-Quote">
  <div class="container">
    <div class="Custom-Quote-title">
      <h1>Custom Quote</h1>
    </div>
    <div class="Custom-Quote-inner">
	<?php
		$errflag=false;
		$errmsg='';
		$succmsg=0;
		//$_POST['fname'] = $_POST['email'] = '';
		if($_POST['submitquote']=='submitquote') {
			
			if($_POST['fname']=='') {
				$errmsg .='<br /> First Name is required.';
				$errflag=true;
			}
			if($_POST['email']=='') {
				$errmsg .='<br /> Email Address is required.';
				$errflag=true;
			}
			if($errflag) {
				$errmsg = 'Please complete following fields.'.$errmsg;
			}else{
				
				$message='<strong>First Name:</strong>'.$_POST['fname'].'<br />
				<strong>Last Name:</strong>'.$_POST['lname'].'<br />
				<strong>Email Address:</strong>'.$_POST['email'].'<br />
				<strong>Phone #:</strong>'.$_POST['phone'].'<br />
				<strong>Company Name:</strong>'.$_POST['company'].'<br />
				<strong>Product:</strong>'.$_POST['product'].'<br />
				<strong>Quantity:</strong>'.$_POST['quantity'].'<br />
				<strong>Required Delivery Date:</strong>'.$_POST['ddate'].'<br />
				<strong>Additional Comments:</strong>'.$_POST['comment'].'<br />';
				
				$mailto='hauhongphan05t4@gmail.com';
				$from_mail=($_POST['email']?$_POST['email']:$mailto);
				$from_name=$_POST['fname'].' '.$_POST['lname'];
				$subject='Custom quote requested on PrintingPeriod.com ';
				$replyto=$mailto;
				
				
				
				
				
				if($_FILES['file1']['tmp_name']) {
				$filename=$_FILES['file1']['name'];
				$file ='uploads/'.$filename;
				if(move_uploaded_file($_FILES['file1']['tmp_name'], $file)) {
					$file_size = filesize($file);
					$handle = fopen($file, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
					$content = chunk_split(base64_encode($content));
					$uid = md5(uniqid(time()));
					$name = basename($file);
					$eol = PHP_EOL;
					$header = "From: ".$from_name." <".$from_mail.">\r\n".$eol;
					$header .= "Reply-To: ".$replyto."\r\n".$eol;
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n".$eol;
					
					$header .= "This is a multi-part message in MIME format.\r\n".$eol;
					$header .= "--".$uid."\r\n".$eol;
					$header .= "Content-type:text/plain; charset=iso-8859-1\r\n".$eol;
					$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n".$eol;
					$header .= $message."\r\n\r\n".$eol;
					$header .= "--".$uid."\r\n".$eol;
					$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n".$eol; 
					$header .= "Content-Transfer-Encoding: base64\r\n";
					$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n".$eol;
					$header .= $content."\r\n\r\n".$eol;
					$header .= "--".$uid."--".$eol;
					
				}else{
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'To:'.$mailto . "\r\n";
					$headers .= 'From:'.$from_mail. "\r\n";	
				}
			}else{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'To:'.$mailto . "\r\n";
				$headers .= 'From:'.$from_mail. "\r\n";	
			}
			
			
			
			mail($mailto, $subject, $message, $header);
			$succmsg=1;
			}
		}
	?>
		
      <form action="" method="post" name="CustomQuote" id="CustomQuote" onsubmit="javascript: return false;" enctype="multipart/form-data">
		<div class="form-group">
           <?php
			if($succmsg==1) {
				echo '<h2>Dear Customer, your custom quote request has been received. Our team will email your custom quote within one business day.</h2>';
			} else { 
				echo $errmsg;
			
			}
			?>
       </div>
	   <input type="hidden" name="submitquote" id="submitquote" value="submitquote" />
		<div class="form-group">
          <label for="usr">First Name:</label>
          <input type="text" class="form-control"  name="fname" id="fname" value="<?php echo $_POST['fname'];?>" placeholder="First Name">
        </div>
        <div class="form-group">
          <label for="usr">Last Name:</label>
          <input type="text" class="form-control"  name="lname" id="lname" value="<?php echo $_POST['lname'];?>" placeholder="Last Name">
        </div>
        <div class="form-group">
          <label for="usr">Email Address:</label>
          <input type="email" class="form-control"  name="email" id="email" value="<?php echo $_POST['email'];?>" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="usr">Phone Number</label>
          <input type="number"  class="form-control" name="phone" id="phone" value="<?php echo $_POST['phone'];?>" placeholder="(888) 888-8888">
        </div>
        <div class="form-group">
          <label for="usr">Company Name:</label>
          <input type="text" class="form-control" name="company" id="company" value="<?php echo $_POST['company'];?>" placeholder="Company Name">
        </div>
        <div class="form-group">
          <label for="sel1">Product:</label>
          <select class="form-control" id="sel1" name="product" >
            <?php
			$sqlcat="SELECT * FROM products";
			$rescat=mysql_query($sqlcat);
			$check=0;
			if(mysql_num_rows($rescat)){
				 while($rowcat=mysql_fetch_assoc($rescat)){
					 if($rowcat['ptitle']==$_POST['product']){
						 $selected = ' selected="selected" ';
					 }else{
						 $selected= '';
					 }
					
				?>
            <option <?php echo $selected; ?> value="<?php echo $rowcat['ptitle'];?>"><?php echo $rowcat['ptitle'];?></option>
				 <?php  } } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="usr">Quantity:</label>
          <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $_POST['quantity'];?>" placeholder="Quantity">
        </div>
        <div class="input-group date" data-provide="datepicker">
          <input type="text" class="form-control" name="ddate" id="ddate" value="<?php echo $_POST['ddate'];?>" placeholder="Required Delivery Date">
          <div class="input-group-addon"> <span class="glyphicon glyphicon-th"></span> </div>
        </div>
        <div class="form-group">
          <label for="comment">Additional Comments::</label>
          <textarea class="form-control" rows="5" name="comment" id="comment"><?php echo $_POST['comment'];?></textarea>
        </div>
        <div class="uplod-file">
          <label for="usr">Attach File(s):</label>
          <i class="fa fa-upload" aria-hidden="true"></i>
          <input type="file" id="usr" name="file1" placeholder="Company Name">
        </div>
        <button type="button" id="btnCustomQuote">Submit</button>
      </form>
    </div>
  </div>
</section>
<?php
include("inc/footer.php");
?>
