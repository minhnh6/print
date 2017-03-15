<?php
$to='ak.triphathi1711@gmail.com';
$from='ak.triphathi1711@gmail.com';
$subject='Test Mail';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To:'.$to . "\r\n";
$headers .= 'From:'.$from. "\r\n";
$message='TEST MAIL';
echo mail($to, $subject, $message, $headers);
?>