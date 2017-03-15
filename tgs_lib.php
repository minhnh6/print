<?php

// set to 1 to show xml
$showXml = 0;

// posting url
$url = "https://tgs.ecsuite.com/merchant_interface/XMLServlet";

// Posts the given request to the hardcoded url abovc. 
function httpsPost($strRequest)
{
   global $url;
   // Initialisation
   $ch=curl_init();
   // Set parameters
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HEADER, TRUE);
   #curl_setopt($ch, CURLOPT_SSLVERSION, 2);
   // Return a variable instead of posting it directly
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // Active the POST method
   curl_setopt($ch, CURLOPT_POST, 1) ;
   // Request
   curl_setopt($ch, CURLOPT_POSTFIELDS, $strRequest);
   // disabled for now. To re-enable when procer certificates are in place.
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   //do not include headers in the response
   curl_setopt($ch, CURLOPT_HEADER, 0);
   // Uncomment the following for debugging
/* 
    $fh = fopen('/tmp/php/error.txt', 'w'); 
   curl_setopt($ch, CURLOPT_STDERR, $fh); 
  curl_setopt($ch, CURLOPT_VERBOSE, 1); 
  */
   // execute the connexion
   $result = curl_exec($ch);
  // curl_setopt($ch, CURLOPT_URL, $urlDebug);
  // curl_exec($ch);
   // Close it
   curl_close($ch);
   // Uncomment the following line for debugging
 //  fclose($fh);
   return $result;
 }
 
 function node_exists($xml, $childpath)
 {
    return count($xml->xpath($childpath));
 }
  
						   
// Handles the response back from the server
 function process_response($response) {
	global $showXml; 	
	if ($response === false) {
			print "Error while posting";
	} else {
		// Uncomment the following 2 lines for debugging
		header('Content-Type: application/xml');
		//if ($showXml){
			print $response;	
		//}
		$xml = simplexml_load_string(utf8_decode((string)$response));
		if (node_exists($xml, "//CCResponse")){
			$x = "Communication OK. Server said: ";
			if ($xml->Responses->CCResponse->Approved == "N") {
				$x = "Not approved. Reason: " . $xml->Responses->CCResponse->ResponseText;
				// redirect, bring up a page, print an error, etc.
			} else {
				$x = "Approved.";
			}
		} else if (node_exists($xml, "//ErrorResponse")){
			print "Failure. Server said: ";
			print $xml->Responses->ErrorResponse->ResponseText;
		} else {
			print "Unknown content received.";
		}
	}
 }
?>
