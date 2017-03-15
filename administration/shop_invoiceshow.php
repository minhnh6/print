<?php
session_start(); 
include("../inc/global_admin.php");
if (isset($_GET['orderno'])) {
	$sqlstr="select * from tbl_order where fld_orderIdNumber = '".$_GET['orderno']."'";
	$resOrder=mysql_query($sqlstr) or die(mysql_error());
	$rowOrder=mysql_fetch_assoc($resOrder);
	
	$sqlcust="select * from tbl_users where fld_userId = '".$rowOrder['fld_userIdNo']."'";
	$rescust=mysql_query($sqlcust) or die(mysql_error());
	$rowcust=mysql_fetch_assoc($rescust);	
	$resPrdOrd = mysql_query("SELECT * FROM tbl_order_details WHERE fld_orderIdNo = '".$rowOrder['fld_orderIdNo']."'") or die(mysql_error());
} else {
	echo '<script>window.location="index.php?section=shop&do=orders";</script>';
	exit;
}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style media="print">
	#PrintDiv {
		display:none;	
	}
</style>
<style media="screen">
	#PrintDiv {
		display:block;	
	}
</style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" valign="top" background="imgs/bg_bar.gif"><table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="100%" colspan="2"><table wIdth="100%" height="98" border="0" cellspacing="0">
      
      <tr>
        <td height="24" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="34%"><img src="../images/logo.png" alt="PrintingPeriod" /></td>
            <td width="39%">
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td colspan="2"><span style="font-size:20px;"><strong>INVOICE</strong></span></td>
                </tr>
              <tr>
            <td width="225" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;" ><strong>Order #</strong></td>
            <td width="577" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;" ><?php echo $rowOrder["fld_orderIdNumber"];?></td>
          </tr>
          <tr >
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;"><strong>Order Date </strong></td>
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;"><?php echo $rowOrder["fld_orderDate"];?></td>
          </tr>
          <tr>
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;" ><b>Payment method:</b>&nbsp;</td>
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;" >Credit Card</td>
          </tr>
          
          <tr >
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;" ><b>Order status:</b></td>
            <td height="26" align="left" valign="top" class="admlsttxt" style="border-bottom:1px solid #EEE;"><?php echo $rowOrder["fld_orderStatus"];?></td>
          </tr>
            </table></td>
            <td width="27%" align="right" valign="bottom"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td><div align="right">
                  <input type="button" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"value="Print Invoice" name="prninvoice"  onclick="javascript:window.print(); " />
                </div></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="24" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="background-color:#FFF; border:1px solid #EEE; padding:5px;" class="admlsttxt">
          
          <tr>
            <td width="802" height="26" colspan="2" align="left" valign="top" class="admlsttxt"><table width="650" border="0" cellpadding="5" cellspacing="0">
              
              <tr>
                <td colspan="5" class="admlsttxt" style="background-color:#EEE;" width="49%"><b>Billing Address</b>&nbsp;</td>
                </tr>
              <tr>
              
                <td width="25%" valign="top" class="admlsttxt" colspan="2" style="line-height:18px;"><b>Name:</b><br />
                  <b>User Name:</b><br /><b>Address:</b><br /><b>City:</b><br /><b>State:</b><br /><b>Country</b><br /><b>Zip/Postal code:</b></td>
                <td width="24%" valign="top" class="admlsttxt" colspan="3" style="line-height:18px;">
				<?php echo $rowcust["fld_fullName"]; ?><br />
                <?php echo $rowcust["fld_userName"]; ?><br />
				<?php echo $rowcust["cust_address"]; ?><br />
				<?php echo $rowcust["cust_city"]; ?><br />
				<?php echo $rowcust["cust_state"]; ?><br />
				<?php echo $rowcust["cust_country"]; ?><br />
				<?php echo $rowcust["cust_zip"]; ?></td>
                </tr>
              <tr>
                <td colspan="5" align="center" class="admlsttxt">&nbsp;</td>
                </tr>
              </table>
              <table width="650" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFF">
                <tr>
                  <td width="62%" align="center" class="admlsthead" style="background-color:#EEE;"><strong>Product Descriptions</strong></td>
                  <td width="15%" align="center" class="admlsthead" style="background-color:#EEE;"><strong>Quantity</strong></td>
                  <td width="13%" align="center" class="admlsthead" style="background-color:#EEE;"><strong>Product Price</strong></td>
                  </tr>
                 <?php 
		$subTotal =0;
		while($rowPrdOrd=mysql_fetch_assoc($resPrdOrd)){
			$sqlpro="SELECT ptitle FROM products WHERE id='".$rowPrdOrd['fld_productIdNo']."'";
			$respro=mysql_query($sqlpro);
			$rowpro=mysql_fetch_assoc($respro);
		?>
            <tr>
                <td class="admlsttxt" style="border-bottom:1px solid #EEE;">
                	<strong><?php echo $rowpro["ptitle"];?></strong>
					<?php
                    $OptionType=explode('|',$rowPrdOrd['fld_value']);
                    $text='';
                    $i=0;
                    foreach($OptionType as $TypeName){
                        $OptionValue=explode(':',$TypeName);
                        $FinalValues=explode('_',$OptionValue[0]);
                        $sqlval="SELECT * FROM option_values WHERE id='".$OptionValue[1]."'";
                        $resval=mysql_query($sqlval);
                        if(mysql_num_rows($resval)){
                            $rowval=mysql_fetch_assoc($resval);
                            echo '<br />'.$rowval['name'];
                        }
                    }
                    ?>              
                </td>
                <td align="center" class="admlsttxt" style="border-bottom:1px solid #EEE;"><?php echo $rowPrdOrd["fld_quantity"];?></td>
                <td align="center" class="admlsttxt" style="border-bottom:1px solid #EEE;"><div align="right">$<?php echo number_format($rowPrdOrd["fld_price"],2);?></div></td>
            </tr>
		<?php 
		  $subTotal += $rowPrdOrd["fld_price"];
		}?>
               <tr>
                  <td colspan="2" align="center" class="admlsttxt" style="border-bottom:1px solid #EEE;"><div align="right"><span style="padding-top:10px;"><b>Subtotal</b></span></div></td>
                  <td align="center" class="admlsttxt" style="border-bottom:1px solid #EEE;"><div align="right"><span style="padding-top:10px;">$<?php echo number_format($subTotal,2); ?></span></div></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" bgcolor="#EEE" class="admlsttxt"><div align="right"><span class="sepratorLine5"><b>Total</b></span></div></td>
                  <td align="center" bgcolor="#EEE" class="admlsttxt"><div align="right"><span class="sepratorLine5">$<?php echo number_format(($subTotal + $rowOrder["shipamount"] + $rowOrder["bulkshipamt"]+$rowOrder["taxamount"]-$rowOrder["discount"]),2);?></span></div></td>
                  </tr>
                </table>	  </td>
          </tr>
	    </table>
        </td>
      </tr>
	 
    </table></td>
                </tr>
                
              </table></td>
            </tr>
        </table></td>
        
      </tr>
    </table>

</body>
</html>