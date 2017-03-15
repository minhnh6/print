<?php

//This script is of course GNU, and used at your own risk..and so on..... ;-)

class TCO_Payment
{
// Construct return URL
    public function __construct()
    {
		$this->x_receipt_link_url = "http://".$_SERVER['HTTP_HOST'] . "/thankyou.php";
    }
	
	
//Define 2Checkout account info
	function setAcctInfo($account_number, $secret_word, $demo) 
	{
		$this->sid = $account_number;
		$this->secret_word = $secret_word;
		$this->demo = $demo;
	}

//Define purchase routine selection (single page or standard multi_page)
	function setCheckout($purchase_routine)
	{
		if ($purchase_routine == 'multi_page') 
		{
			$this->purchase_url = "https://www.2checkout.com/checkout/purchase";
		}	
		else if ($purchase_routine == 'single_page') 
		{	
			$this->purchase_url = "https://www.2checkout.com/checkout/spurchase";
		}
	}

//Add parameters to the form
	function addParam($name, $value)
	{
		$this->params["$name"] = $value;
	}

//Remove parameters from the form	
	function removeParam($name)
	{
		unset($this->params[$name]);
	}

//Builds out HTML form and submits the payment to 2Checkout
//Please note that the sid, demo and x_receipt_lnik_url parameters are already being defined here so they do not need to be added as params using the addParam function 
	function submitPayment()
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
		. '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Passing sale to 2Checkout</title></head>'
		.'<body onload="document.form.submit();"><h3>Passing sale to 2Checkout for Processing</h3>';
		echo "<form name=\"form\" action=\"$this->purchase_url\" method=\"post\">\n";

		echo "<input type=\"hidden\" name=\"sid\" value=\"$this->sid\"/>\n";
		echo "<input type=\"hidden\" name=\"demo\" value=\"$this->demo\"/>\n";
		echo "<input type=\"hidden\" name=\"x_receipt_link_url\" value=\"$this->x_receipt_link_url\"/>\n";
		
        foreach ($this->params as $name => $value)
        {
             echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
        }

		echo "<input type=\"submit\" value=\"Click here to pay using 2Checkout\" /></form></body></html>";
	}

//Prints out the return parameters and checks against the MD5 Hash to confirm the validity of the sale
	function getResponse() 
	{
		//Print Return Parameters
		echo "<h1>Get Parameter/s:</h1>";
		echo "<pre>";
		if($_GET)
			print_r($_GET);
		else
		echo "There are no get parameters.";
		echo "</pre>";
		echo "<hr/>";
		echo "<h1>Post Parameter/s:</h1>";
		echo "<pre>";
		if($_POST)
			print_r($_POST);
		else
			echo "There are no post parameters.";
		echo "</pre>";
        
		//Quick sanitation and variable assignment
		foreach ($_REQUEST as $k => $v) {
            $v = htmlspecialchars($v);
            $v = stripslashes($v);
            $post[$k] = $v;
        }
		//Check to see if Auth.net params are being used and assign variables for hash
		if (isset($post['x_MD5_Hash'])) {
		$hashTotal = $post['x_amount'];
		$returned_hash = $post['x_MD5_Hash'];		
		} elseif (isset($post['key'])){
		$hashTotal = $post['total'];
		$returned_hash = $post['key'];
		}
		
		//Assign variables for hash from AcctInfo()
		$hashSecretWord = $this->secret_word;
   	    $hashSid = $this->sid;

		//2Checkout breaks the hash on demo sales, we must do the same here so the hashes match.
		if (($this->demo) == 'Y') {
			$hashOrder = '1';
			}
			else 
			{
       	    	$hashOrder = $post['order_number'];
			}
		//Create hash
        $our_hash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

		//Compare hashes to check the validity of the sale and print the response
		if ($our_hash == $returned_hash) {
            echo "<h3>The MD5 Hash matched!</h3></br>";
			echo "Returned Hash: ";
			print_r($returned_hash);
			echo "</br>";
			echo "Our Hash: ";
			print_r($our_hash);
			} else {
	       	 	echo "<h3>The MD5 Hash did not match!</h3> <h4>If you are placing a demo sale, please make sure you are passing 'Y' for the demo argument in setAcctInfo()</h3>";
				echo "Returned Hash: ";
				print_r($returned_hash);
				echo "</br>";
				echo "Our Hash: ";
				print_r($our_hash);
				}
	}
}
		
?>
