<?php
include("../inc/global_admin.php");
	$return='';
	$sqlcust="SELECT opt.*,opttype.typename FROM option_values as opt inner join option_type as opttype on opt.type_id=opttype.id inner join category_options as cattype on cattype.option_value_id=opt.id WHERE cattype.cat_id='".$_GET['catid']."' AND opttype.iscustom=1 ";
	$rescust=mysql_query($sqlcust);
	if(mysql_num_rows($rescust)>0){
		$return='<table width="100%" cellpadding="3" cellspacing="3"><tr><td>Custom</td><td>&nbsp;</td></tr>';
		while($rowcust=mysql_fetch_assoc($rescust)){
			$return .='<tr><td>'.$rowcust['typename'].' :: '.$rowcust['name'].'</td><td><input type="text" name="optval_'.$rowcust['id'].'" id="optval_'.$rowcust['id'].'"><input type="hidden" name="opttype[]" id="opttype_'.$rowcust['id'].'" value="'.$rowcust['id'].'"></td></tr>';
		}
		$return .='</table>';
	}
echo $return;
?>