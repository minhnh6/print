<?php
include("inc/global.php");
$sqlmail="SELECT * FROM tbl_users WHERE fld_userName='".$_GET['data']."'";
$resmail=mysql_query($sqlmail);
if(!mysql_num_rows($resmail)){
 echo 'Invalid Email Address.';
}else{
	$rowmail=mysql_fetch_assoc($resmail);
	$message='<p>Dear '.$rowmail['fld_fullName'].', <br /><br />Here is your password to login to <a href="http://www.printingperiod.com" target="">www.printingperiod.com/</a></p>
	<p><a href="http://www.printingperiod.com/" target="_self">www.printingperiod.com/</a><br /><br /> Password: '.$rowmail['fld_passWd'].'</p>
	<p><a href="http://www.printingperiod.com/" target="_self">PrintingPeriod</a></p>';
	$to=$rowmail['fld_userName'];
	$from='support@printingperiod.com';
	$subject='Contct form requested on http://www.printingperiod.com ';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'To:'.$to . "\r\n";
	$headers .= 'From:'.$from. "\r\n";
	mail($to, $subject, $message, $headers);
	echo 'Your password has been sent to your email address '.$to.' Please check your email account for your password.<br /><br />';
}
?>
