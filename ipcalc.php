<?php
include("inc/global.php");
//$BasePrice=floatval($_GET['base']);
$OptionType=explode('|',$_GET['data']);
$BasePriceArr=explode(':',$OptionType[0]);
$sqlbase="SELECT baseprice FROM products WHERE id='".$BasePriceArr[1]."'";

$prdid=$BasePriceArr[1];

$resbase=mysql_query($sqlbase);
$rowbase=mysql_fetch_assoc($resbase);
$BasePrice=$rowbase['baseprice'];
$FinalPrice=0.00;
$i=0;
$optarray=array();
$optcstmar=array();
foreach($OptionType as $TypeName){
	$OptionValue=explode(':',$TypeName);
	$FinalValues=explode('_',$OptionValue[0]);
	if($FinalValues[0]=='SelOption'){
		$sqlcheckcustom="select iscustom from option_type where id='".$FinalValues[1]."'";
		$rescheckcustom=mysql_query($sqlcheckcustom);
		$rowcheckcustom=mysql_fetch_assoc($rescheckcustom);
		if($rowcheckcustom['iscustom']==1) {
			$optcstmar[]=$OptionValue[1];	
		} else {
			$optarray[]=$OptionValue[1];	
		}
	}
}

$sqladd=" WHERE productid='".$prdid."' ";

foreach($optcstmar as $cstmval) {
	$sqladd .=" AND (optcombiid like '".$cstmval."|%' or optcombiid like '%|".$cstmval."|%' or optcombiid like '%|".$cstmval."') ";	
}
$sqlcombos="select * from custom_value ".$sqladd;
//echo $sqlcombos;
$rescombos=mysql_query($sqlcombos);
$rowcombos=mysql_fetch_assoc($rescombos);
$bsprice= $rowcombos['price'];
$FinalPrice=$bsprice;

foreach($optarray as $newopt) {
	$sqlval="SELECT * FROM option_values WHERE id='".$newopt."'";
	$resval=mysql_query($sqlval);
	if(mysql_num_rows($resval)){
		$rowval=mysql_fetch_assoc($resval);
		if($rowval['price_type']=='Percentage'){
			$FinalPrice +=($bsprice/100*$rowval['price_add']);
		}else{
			$FinalPrice +=$rowval['price_add'];
		}
	}	
}

/*foreach($OptionType as $TypeName){
	$OptionValue=explode(':',$TypeName);
	$FinalValues=explode('_',$OptionValue[0]);
	if($FinalValues[0]=='SelOption'){
		
		$sqloptval="SELECT * FROM custom_value WHERE opt_id= '".$OptionValue[1]."' AND productid='".$prdid."'";
		$resoptval=mysql_query($sqloptval);
		if(mysql_num_rows($resoptval)){
			$rowoptval=mysql_fetch_assoc($resoptval);
			$FinalPrice +=$rowoptval['price'];
		}else{
			$sqlval="SELECT * FROM option_values WHERE id='".$OptionValue[1]."'";
			$resval=mysql_query($sqlval);
			if(mysql_num_rows($resval)){
				$rowval=mysql_fetch_assoc($resval);
				if($rowval['price_type']=='Percentage'){
					$FinalPrice +=($BasePrice/100*$rowval['price_add']);
				}else{
					$FinalPrice +=$rowval['price_add'];
				}
			}	
		}
	}
}
echo round($BasePrice+$FinalPrice);*/
echo round($FinalPrice);
?>