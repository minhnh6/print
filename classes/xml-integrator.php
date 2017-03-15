<?php 
/*
  xml-integrator.php version 0.8

  cb@ctpe.net
  
  XML connection method with ctpe.net.

*/

  class _ctpexmlpost {
	var $server = "test.ctpe.net";	// test server address 
	var $path = "/payment/ctpe";
	var $sender = "8a90818a14e0602d0114e06a29f10049";
	var $channel = "8a90818a14e0602d0114e06a29f3004e";
	var $userid = "8a90818a14e0602d0114e06a29f2004d";
	var $userpwd = "PeS2qjpj";

	var $transaction_mode = "CONNECTOR_TEST";
	var $transaction_response = "ASYNC";

	var $user_agent="php ctpepost";
	var $request_version="1.0";

    
    function _ctpexmlpost ($server,$path,$sender,$channel,$userid,$userpwd,$transaction_mode,$transaction_response) {
      $this->server = $server;
      $this->path = $path;
      $this->sender = $sender;
      $this->channel = $channel;
      $this->userid = $userid;
      $this->userpwd = $userpwd;
	  $this->transaction_mode = $transaction_mode;
	  $this->transaction_response = $transaction_response;
    }

    /* 
      using HTTP/POST send message to ctpe server
    */
    function sendToCTPE($host,$path,$data) {

	 	$cpt = curl_init();	

		$xmlpost="load=".urlencode($data);
		curl_setopt($cpt, CURLOPT_URL, "https://$host$path");
		curl_setopt($cpt, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($cpt, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($cpt, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cpt, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_setopt($cpt, CURLOPT_SSL_VERIFYPEER, 1);

		curl_setopt($cpt, CURLOPT_POST, 1);
		curl_setopt($cpt, CURLOPT_POSTFIELDS, $xmlpost);

		$this->resultURL = curl_exec($cpt);
		$this->error = curl_error($cpt);
		$this->info = curl_getinfo($cpt);

		curl_close($cpt);
	}

	function setAccountInformation($account_holder,$account_brand,$account_number,$account_bankname,$account_country,$account_authorisation,$account_verification,$account_year,$account_month)
	{
		$this->account_holder=$account_holder;
		$this->account_brand=$account_brand;
		$this->account_number=$account_number;
		$this->account_bankname=$account_bankname;
		$this->account_country=$account_country;
		$this->account_authorisation=$account_authorisation;
		$this->account_verification=$account_verification;
		$this->account_year=$account_year;
		$this->account_month=$account_month;
	}

	function setPaymentCode($payment_code)
	{
		$this->payment_code=$payment_code;
	}

	function setPaymentInformation($payment_amount,$payment_usage,$identification_transactionid,$payment_currency)
	{
		$this->payment_amount=$payment_amount;
		$this->payment_usage=$payment_usage;
		$this->identification_transactionid=$identification_transactionid;
		$this->payment_currency=$payment_currency;
	}

	function setCustomerContact($contact_email,$contact_mobile,$contact_ip,$contact_phone)
	{
		$this->contact_email=$contact_email;
		$this->contact_mobile=$contact_mobile;
		$this->contact_ip=$contact_ip;
		$this->contact_phone=$contact_phone;
	}
	
	function setCustomerAddress($address_street,$address_zip,$address_city,$address_state,$address_country)
	{
		$this->address_street=$address_street;
		$this->address_zip=$address_zip;
		$this->address_city=$address_city;
		$this->address_state=$address_state;
		$this->address_country=$address_country;
	}

	function setCustomerName($name_salutation,$name_title,$name_give,$name_family,$name_company)
	{
		$this->name_salutation=$name_salutation;
		$this->name_title=$name_title;
		$this->name_give=$name_give;
		$this->name_family=$name_family;
		$this->name_company=$name_company;
	}
	
	function setSessionID($sessionID)
	{
		$this->sessionID = $sessionID;
	}

    function commitXMLPayment() {

	$strXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

	// set account and user information.
	$strXML .= "<Request version=\"$this->request_version\">";
	$strXML .= "<Header>";
	$strXML .= "<Security sender=\"$this->sender\"/>";
	$strXML .= "</Header>";
	$strXML .= "<Transaction mode=\"$this->transaction_mode\" channel=\"$this->channel\">";
	$strXML .= "<User login=\"$this->userid\" pwd=\"$this->userpwd\" />";
	$strXML .= "<Identification>";
	$strXML .= "<TransactionID>$this->identification_transactionid</TransactionID>";
	$strXML .= "</Identification>";

	// set payment information

	$strXML .= "<Payment code=\"$this->payment_code\">";
	$strXML .= "<Presentation>";
	$strXML .= "<Amount>$this->payment_amount</Amount>";
	$strXML .= "<Currency>$this->payment_currency</Currency>";	
	$strXML .= "<Usage>$this->payment_usage</Usage>";
	$strXML .= "</Presentation>";
	$strXML .= "</Payment>";
	
	// set account information

	$strXML .= "<Account>";
	$strXML .= "<Holder>$this->account_holder</Holder>";
	$strXML .= "<Number>$this->account_number</Number>";
	$strXML .= "<Brand>$this->account_brand</Brand>";	
	$strXML .= "<Month>$this->account_month</Month>";
	$strXML .= "<Year>$this->account_year</Year>";	
	$strXML .= "<Verification>$this->account_verification</Verification>";
	$strXML .= "</Account>";

	// set customer information

	$strXML .= "<Customer>";
	$strXML .= "<Name>";
	$strXML .= "<Salutation>$this->name_salutation</Salutation>";
	$strXML .= "<Title>$this->name_title</Title>";
	$strXML .= "<Given>$this->name_give</Given>";
	$strXML .= "<Family>$this->name_family</Family>";
	$strXML .= "<Company>$this->name_company</Company>";
	$strXML .= "</Name>";
	$strXML .= "<Address>";
	$strXML .= "<Street>$this->address_street</Street>";
	$strXML .= "<Zip>$this->address_zip</Zip>";
	$strXML .= "<City>$this->address_city</City>";
	$strXML .= "<State>$this->address_state</State>";
	$strXML .= "<Country>$this->address_country</Country>";
	$strXML .= "</Address>";		
	$strXML .= "<Contact>";
	$strXML .= "<Phone>$this->contact_phone</Phone>";	
	$strXML .= "<Mobile>$this->contact_mobile</Mobile>";	
	$strXML .= "<Email>$this->contact_email</Email>";
	$strXML .= "<Ip>$this->contact_ip</Ip>";
	$strXML .= "</Contact>";
	$strXML .= "</Customer>";
	
	$strXML .= "<RiskManagement process=\"AUTO\"/>";
	$strXML .= "<Frontend>";
	$strXML .= "<ResponseUrl>http://www.certarea.com/checkout_G11.async.php</ResponseUrl>";
	$strXML .= "<SessionID>$this->sessionID</SessionID>";
	$strXML .= "</Frontend>";

	$strXML .= "</Transaction>";
	$strXML .= "</Request>";

	$this->sendToCTPE($this->server,$this->path,$strXML);

	if ($this->resultURL)
	{
		return $this->parserResult($this->resultURL);
	} 
	else
	{
		return false;
	}
	}

    /*
      Parser XML message returned by CTPE server.
    */
    function parserResult($resultURL) 
	{
		$resultXML= ($resultURL);
		return $resultXML;
		//print "<br>$resultXML";
    }

  }
	function extract_substr($Haystack, $Begin, $End, $Offset = 0)
	{ 
		$Start = strpos($Haystack, $Begin, $Offset);
		$StartParse = $Start + strlen($Begin);
		$End = strpos($Haystack, $End, $StartParse);
		$Text = substr($Haystack, $StartParse, $End - $StartParse);
		return $Text;
	}  
?>
