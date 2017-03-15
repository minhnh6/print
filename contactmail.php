<?php
include("inc/global.php");
$message='';
$OptionType=explode('|',$_GET['data']);

$GetVal=explode(':',$OptionType['0']);
$Name=$GetVal['1'];
$GetVal=explode(':',$OptionType['1']);
$Email=$GetVal['1'];
$GetVal=explode(':',$OptionType['2']);
$Phone=$GetVal['1'];
$GetVal=explode(':',$OptionType['3']);
$Msg=$GetVal['1'];
$GetVal=explode(':',$OptionType['4']);

        
        $resp = null;
        $error = null;
      
if($Name=='Your Name' || $Name=='' || $Email=='abcd@gmail.com' || $Email=='' || $Phone=='+9452133144' || $Phone=='' || $Msg=='' ){
	echo 'Mail Not Sent';
	
}else{
	$message='<strong>Name:</strong>'.$Name.'<br />
	<strong>Email:</strong>'.$Email.'<br />
	<strong>Telephone #:</strong>'.$Phone.'<br />
	<strong>Message:</strong>'.$Msg;
	$to='support@printingperiod.com';
	$from=($Email?$Email:$to);
	$subject='Contct form requested on http://www.printingperiod.com ';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'To:'.$to . "\r\n";
	$headers .= 'From:'.$from. "\r\n";
	mail($to, $subject, $message, $headers);
	echo 'Mail Sent';
}
?>
