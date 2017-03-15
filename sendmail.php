<?php
session_start();
include("inc/global.php");
$message='';
$OptionType=explode('|',$_GET['data']);
$GetVal=explode(':',$OptionType['0']);
$Fname=$GetVal['1'];

$GetVal=explode(':',$OptionType['1']);
$Lname=$GetVal['1'];

$GetVal=explode(':',$OptionType['3']);
$Phone=$GetVal['1'];

$GetVal=explode(':',$OptionType['2']);
$Email=$GetVal['1'];

$GetVal=explode(':',$OptionType['4']);
$Cname=$GetVal['1'];

$GetVal=explode(':',$OptionType['5']);
$Product=$GetVal['1'];

$GetVal=explode(':',$OptionType['6']);
$Product=$GetVal['1'];

$GetVal=explode(':',$OptionType['7']);
$Color=$GetVal['1'];

$GetVal=explode(':',$OptionType['8']);
$Quantity=$GetVal['1'];

$GetVal=explode(':',$OptionType['9']);
$Ddate=$GetVal['1'];

$GetVal=explode(':',$OptionType['11']);
$Comment=$GetVal['1'];

$GetVal=explode(':',$OptionType['10']);
$Scode=$GetVal['1'];

if($_SESSION['security_code']==$Scode){
	$flag=1;
}else{
	$flag=0;
}
if($Fname=='' || $Email=='' || $flag==0){
	if($flag==0){
		echo 'Security Code dont`t metch.';
	}else{
		echo 'Mail Not Sent';
	}
}else{
	
	$message='<strong>First Name:</strong>'.$Fname.'<br />
	<strong>Last Name:</strong>'.$Lname.'<br />
	<strong>Email Address:</strong>'.$Email.'<br />
	<strong>Phone #:</strong>'.$Phone.'<br />
	<strong>Company Name:</strong>'.$Cname.'<br />
	<strong>Product:</strong>'.$Product.'<br />
	<strong>Color:</strong>'.$Color.'<br />
	<strong>Quantity:</strong>'.$Quantity.'<br />
	<strong>Required Delivery Date:</strong>'.$Ddate.'<br />
	<strong>Additional Comments:</strong>'.$Comment.'<br />';
	
	$mailto='hauhongphan05t4@gmail.com';
	//$mailto='ak.triphathi1711@gmail.com';
	$from_mail=($Email?$Email:$mailto);
	$from_name=$Fname.' '.$Lname;
	$subject='Custom quote requested on http://www.printingperiod.com ';
	//mail($to, $subject, $message, $headers);
	//mail('ak.triphathi1711@gmail.com', $subject, $message, $headers);
	$replyto=$mailto;
	if($_GET['filename'] && file_exists('uploads/'.$_GET['filename'])){
		$filename=$_GET['filename'];
		$file ='uploads/'.$_GET['filename'];
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
	}else{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To:'.$mailto . "\r\n";
		$headers .= 'From:'.$from_mail. "\r\n";	
	}
	mail($mailto, $subject, $message, $header);
	echo 'Mail Sent';
}
?>
