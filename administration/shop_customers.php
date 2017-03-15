<?php if($_GET['section'] != 'shop' || $_GET['do'] != 'customers') { echo '<script>window.location="index.php";</script>'; } ?>
<?php
$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }

if($_GET['st'] == "activated") {
	$successmessage = '<div id="messagebox" class="success">Your customer has been activated.</div></div>';	
} else if($_GET['st'] == "deactivated") { 
	$successmessage = '<div id="messagebox" class="success">Your customer has been deactivated.</div>';			
} else if($_GET['st'] == "deleted") { 
	$successmessage = '<div id="messagebox" class="success">Your customer has been deleted.</div>';			
} else if($_GET['st'] == "updated") { 
	$successmessage = '<div id="messagebox" class="success">Your customer has been updated.</div>';			
} else if($_GET['st'] == "created") { 
	$successmessage = '<div id="messagebox" class="success">Your customer has been created.</div>';			
}

if($action=='activate') {
	mysql_query("UPDATE shop_customers set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=activated";</script>';
}

if($action=='deactivate') {
	mysql_query("UPDATE shop_customers set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());		
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deactivated";</script>';		
}	

if ($action=="delete") {
	mysql_query("DELETE FROM tbl_users WHERE fld_userId='" . $_GET['id'] . "' LIMIT 1");			
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deleted";</script>';		
	$action="";
}  


if($action=='editnow') {
	$sql="UPDATE tbl_users set fld_userName='".$_POST['fld_userName']."', fld_fullName='".$_POST['fld_fullName']."' ,cust_name = '".trim($_POST['cust_name'])."', cust_address ='".trim($_POST['cust_address'])."', cust_city = '".trim($_POST['cust_city'])."', cust_state= '".trim($_POST['cust_state'])."', cust_country = '".trim($_POST['cust_country'])."', cust_zip = '".trim($_POST['cust_zip'])."'  where fld_userId='".$_POST['id']."'";
	mysql_query($sql)or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=updated";</script>';
	$action='';
}
if($action=='addcustomers') {
	$sql="insert into tbl_users (fld_userName, fld_fullName,fld_passWd,cust_name, cust_address, cust_city, cust_state, cust_country, cust_zip,fld_addedOn) values('".$_POST['fld_userName']."', '".$_POST['fld_fullName']."','".$_POST['fld_passWd']."','".$_POST['cust_name']."', '".$_POST['cust_address']."','".$_POST['cust_city']."', '".$_POST['cust_state']."','".$_POST['cust_country']."', '".$_POST['cust_zip']."','".date('Y-m-d G:i:s')."')";
	mysql_query($sql)or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=created";</script>';
	$action='';
}  
?>
<div id="admrightcontent">
<table align="center" width="650" border="0" cellpadding="0" cellspacing="0">  
    <tr>
        <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><?php echo $successmessage; ?></div></td>
    </tr>   
	<tr>
		<td valign="top">
	<?php
    if($action=='' || $action=='view')  {
		$sql = "SELECT * FROM tbl_users ORDER BY fld_fullName,fld_addedOn";
		$res=mysql_query($sql);
        ?>
        <div style="float:left; width:710px;">
            <div style="float:left; width:410px; padding:3px;"><b>Customer Name</b></div>
            <div style="float:left; width:218px; padding:3px;"><b>Registration Date</b></div>
            <div style="float:left; width:64px; padding:3px;"><b>Actions</b></div>
        </div>
        <div style="float:left; width:710px;"><hr></div>
            <div id="SortableList" style="float:left; width:710px;">
			<?php
            while($row=mysql_fetch_assoc($res)) {
                if($row['isactive']=='1') {
                    $isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatusShop('.$row['id'].',0);" title="Deactivate Customer"><img src="images/deactivate.png" border="0" /></a>&nbsp;';
                } else {
                    $isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatusShop('.$row['id'].',1);" title="Activate Customer"><img src="images/activate.png" border="0" /></a>&nbsp;';
                } 		
            $i=0;
            ?>
			<div id="SortableList_<?php echo $row['id'];?>" class="normal" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="float:left;">
                <div style="float:left; width:410px; padding:3px;"><?php echo $row['fld_fullName'];?></div>
                <div style="float:left; width:218px; padding:3px;"><?php echo $row['fld_addedOn'];?></div>
                <div style="float:left; width:64px; padding:3px;">
                <a href="index.php?section=shop&do=customers&a=edit&id=<?php echo $row['fld_userId'];?>"><img src="images/edit.png" alt="Edit" width="16" height="16" border="0"></a>
				<?php //echo $isactivehtml; ?>
                <a href="index.php?section=shop&do=customers&a=delete&id=<?php echo $row['fld_userId'];?>" onclick="confirm_deleteShop('<?php echo $row['fld_userId'];?>');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0"></a>
				</div>
            </div>
            <?php
            }
            ?>
		</div>
	<?php
    }
    ?>
<!-- <div id="listForm">-->
	<?php
    if ($action=="edit") {
		$sql="select * from tbl_users where fld_userId='".$_GET['id']."'";
		$res=mysql_query($sql)or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		?>
		<form name="edtusr" id="edtusr"  method="post" onsubmit="return custValueValidate();">
		<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
		<input type="hidden" name="a" value="editnow" />
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr>
				<td colspan="2" height="5"></td>
			</tr>
			<tr>
				<td colspan="2" class="adminheader">Edit Customer Profile > <?php echo $row['fld_fullName'];?></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Name:</td>
				<td class="admlsttxt"><input class="formfields" name="fld_fullName" type="text" id="fld_fullName" value="<?php echo $row['fld_fullName'];?>" size="30"/>
			<span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Email/ User Name:</td>
				<td class="admlsttxt"><input class="formfields" name="fld_userName" type="text" id="fld_userName" value="<?php echo $row['fld_userName'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>

			<tr>
				<td class="admlsttxt">Customer Name:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_name" type="text" id="cust_name" value="<?php echo $row['cust_name'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Address:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_address" type="text" id="cust_address" value="<?php echo $row['cust_address'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer City:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_city" type="text" id="cust_city" value="<?php echo $row['cust_city'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer State:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_state" type="text" id="cust_state" value="<?php echo $row['cust_state'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Country:</td>
				<td class="admlsttxt">
		<?php $_POST['cust_country']=$row['cust_country']; ?>
        <select class="formfields" name="cust_country">
          <option value="AL" <?php if(trim($_POST['cust_country'])=="AL"){ ?> selected <?php } ?>>Albania</option>
          <option value="DZ" <?php if(trim($_POST['cust_country'])=="DZ"){ ?> selected <?php } ?>>Algeria</option>
          <option value="AD" <?php if(trim($_POST['cust_country'])=="AD"){ ?> selected <?php } ?>>Andorra</option>
          <option value="AO" <?php if(trim($_POST['cust_country'])=="AO"){ ?> selected <?php } ?>>Angola</option>
          <option value="AI" <?php if(trim($_POST['cust_country'])=="AI"){ ?> selected <?php } ?>>Anguilla</option>
          <option value="AG" <?php if(trim($_POST['cust_country'])=="AG"){ ?> selected <?php } ?>>Antigua and Barbuda</option>
          <option value="AR" <?php if(trim($_POST['cust_country'])=="AR"){ ?> selected <?php } ?>>Argentina</option>
          <option value="AM" <?php if(trim($_POST['cust_country'])=="AM"){ ?> selected <?php } ?>>Armenia</option>
          <option value="AW" <?php if(trim($_POST['cust_country'])=="AW"){ ?> selected <?php } ?>>Aruba</option>
          <option value="AU" <?php if(trim($_POST['cust_country'])=="AU"){ ?> selected <?php } ?>>Australia</option>
          <option value="AT" <?php if(trim($_POST['cust_country'])=="AT"){ ?> selected <?php } ?>>Austria</option>
          <option value="AZ" <?php if(trim($_POST['cust_country'])=="AZ"){ ?> selected <?php } ?>>Azerbaijan Republic</option>
          <option value="BS" <?php if(trim($_POST['cust_country'])=="BS"){ ?> selected <?php } ?>>Bahamas</option>
          <option value="BH" <?php if(trim($_POST['cust_country'])=="BH"){ ?> selected <?php } ?>>Bahrain</option>
          <option value="BB" <?php if(trim($_POST['cust_country'])=="BB"){ ?> selected <?php } ?>>Barbados</option>
          <option value="BE" <?php if(trim($_POST['cust_country'])=="BE"){ ?> selected <?php } ?>>Belgium</option>
          <option value="BZ" <?php if(trim($_POST['cust_country'])=="BZ"){ ?> selected <?php } ?>>Belize</option>
          <option value="BJ" <?php if(trim($_POST['cust_country'])=="BJ"){ ?> selected <?php } ?>>Benin</option>
          <option value="BM" <?php if(trim($_POST['cust_country'])=="BM"){ ?> selected <?php } ?>>Bermuda</option>
          <option value="BT" <?php if(trim($_POST['cust_country'])=="BT"){ ?> selected <?php } ?>>Bhutan</option>
          <option value="BO" <?php if(trim($_POST['cust_country'])=="BO"){ ?> selected <?php } ?>>Bolivia</option>
          <option value="BA" <?php if(trim($_POST['cust_country'])=="BA"){ ?> selected <?php } ?>>Bosnia and Herzegovina</option>
          <option value="BW" <?php if(trim($_POST['cust_country'])=="BW"){ ?> selected <?php } ?>>Botswana</option>
          <option value="BR" <?php if(trim($_POST['cust_country'])=="BR"){ ?> selected <?php } ?>>Brazil</option>
          <option value="VG" <?php if(trim($_POST['cust_country'])=="VG"){ ?> selected <?php } ?>>British Virgin Islands</option>
          <option value="BN" <?php if(trim($_POST['cust_country'])=="BN"){ ?> selected <?php } ?>>Brunei</option>
          <option value="BG" <?php if(trim($_POST['cust_country'])=="BG"){ ?> selected <?php } ?>>Bulgaria</option>
          <option value="BF" <?php if(trim($_POST['cust_country'])=="BF"){ ?> selected <?php } ?>>Burkina Faso</option>
          <option value="BI" <?php if(trim($_POST['cust_country'])=="BI"){ ?> selected <?php } ?>>Burundi</option>
          <option value="KH" <?php if(trim($_POST['cust_country'])=="KH"){ ?> selected <?php } ?>>Cambodia</option>
          <option value="CA" <?php if(trim($_POST['cust_country'])=="CA"){ ?> selected <?php } ?>>Canada</option>
          <option value="CV" <?php if(trim($_POST['cust_country'])=="CV"){ ?> selected <?php } ?>>Cape Verde</option>
          <option value="KY" <?php if(trim($_POST['cust_country'])=="KY"){ ?> selected <?php } ?>>Cayman Islands</option>
          <option value="TD" <?php if(trim($_POST['cust_country'])=="TD"){ ?> selected <?php } ?>>Chad</option>
          <option value="CL" <?php if(trim($_POST['cust_country'])=="CL"){ ?> selected <?php } ?>>Chile</option>
          <option value="C2" <?php if(trim($_POST['cust_country'])=="C2"){ ?> selected <?php } ?>>China Worldwide</option>
          <option value="CO" <?php if(trim($_POST['cust_country'])=="CO"){ ?> selected <?php } ?>>Colombia</option>
          <option value="KM" <?php if(trim($_POST['cust_country'])=="KM"){ ?> selected <?php } ?>>Comoros</option>
          <option value="CK" <?php if(trim($_POST['cust_country'])=="CK"){ ?> selected <?php } ?>>Cook Islands</option>
          <option value="CR" <?php if(trim($_POST['cust_country'])=="CR"){ ?> selected <?php } ?>>Costa Rica</option>
          <option value="HR" <?php if(trim($_POST['cust_country'])=="HR"){ ?> selected <?php } ?>>Croatia</option>
          <option value="CY" <?php if(trim($_POST['cust_country'])=="CY"){ ?> selected <?php } ?>>Cyprus</option>
          <option value="CZ" <?php if(trim($_POST['cust_country'])=="CZ"){ ?> selected <?php } ?>>Czech Republic</option>
          <option value="CD" <?php if(trim($_POST['cust_country'])=="CD"){ ?> selected <?php } ?>>Democratic Republic of the Congo</option>
          <option value="DK" <?php if(trim($_POST['cust_country'])=="DK"){ ?> selected <?php } ?>>Denmark</option>
          <option value="DJ" <?php if(trim($_POST['cust_country'])=="DJ"){ ?> selected <?php } ?>>Djibouti</option>
          <option value="DM" <?php if(trim($_POST['cust_country'])=="DM"){ ?> selected <?php } ?>>Dominica</option>
          <option value="DO" <?php if(trim($_POST['cust_country'])=="DO"){ ?> selected <?php } ?>>Dominican Republic</option>
          <option value="EC" <?php if(trim($_POST['cust_country'])=="EC"){ ?> selected <?php } ?>>Ecuador</option>
          <option value="EG" <?php if(trim($_POST['cust_country'])=="EG"){ ?> selected <?php } ?>>Egypt</option>
          <option value="SV" <?php if(trim($_POST['cust_country'])=="SV"){ ?> selected <?php } ?>>El Salvador</option>
          <option value="ER" <?php if(trim($_POST['cust_country'])=="ER"){ ?> selected <?php } ?>>Eritrea</option>
          <option value="EE" <?php if(trim($_POST['cust_country'])=="EE"){ ?> selected <?php } ?>>Estonia</option>
          <option value="ET" <?php if(trim($_POST['cust_country'])=="ET"){ ?> selected <?php } ?>>Ethiopia</option>
          <option value="FK" <?php if(trim($_POST['cust_country'])=="FK"){ ?> selected <?php } ?>>Falkland Islands</option>
          <option value="FO" <?php if(trim($_POST['cust_country'])=="FO"){ ?> selected <?php } ?>>Faroe Islands</option>
          <option value="FM" <?php if(trim($_POST['cust_country'])=="FM"){ ?> selected <?php } ?>>Federated States of Micronesia</option>
          <option value="FJ" <?php if(trim($_POST['cust_country'])=="FJ"){ ?> selected <?php } ?>>Fiji</option>
          <option value="FI" <?php if(trim($_POST['cust_country'])=="FI"){ ?> selected <?php } ?>>Finland</option>
          <option value="FR" <?php if(trim($_POST['cust_country'])=="FR"){ ?> selected <?php } ?>>France</option>
          <option value="GF" <?php if(trim($_POST['cust_country'])=="GF"){ ?> selected <?php } ?>>French Guiana</option>
          <option value="PF" <?php if(trim($_POST['cust_country'])=="PF"){ ?> selected <?php } ?>>French Polynesia</option>
          <option value="GA" <?php if(trim($_POST['cust_country'])=="GA"){ ?> selected <?php } ?>>Gabon Republic</option>
          <option value="GM" <?php if(trim($_POST['cust_country'])=="GM"){ ?> selected <?php } ?>>Gambia</option>
          <option value="DE" <?php if(trim($_POST['cust_country'])=="DE"){ ?> selected <?php } ?>>Germany</option>
          <option value="GI" <?php if(trim($_POST['cust_country'])=="GI"){ ?> selected <?php } ?>>Gibraltar</option>
          <option value="GR" <?php if(trim($_POST['cust_country'])=="GR"){ ?> selected <?php } ?>>Greece</option>
          <option value="GL" <?php if(trim($_POST['cust_country'])=="GL"){ ?> selected <?php } ?>>Greenland</option>
          <option value="GD" <?php if(trim($_POST['cust_country'])=="GD"){ ?> selected <?php } ?>>Grenada</option>
          <option value="GP" <?php if(trim($_POST['cust_country'])=="GP"){ ?> selected <?php } ?>>Guadeloupe</option>
          <option value="GT" <?php if(trim($_POST['cust_country'])=="GT"){ ?> selected <?php } ?>>Guatemala</option>
          <option value="GN" <?php if(trim($_POST['cust_country'])=="GN"){ ?> selected <?php } ?>>Guinea</option>
          <option value="GW" <?php if(trim($_POST['cust_country'])=="GW"){ ?> selected <?php } ?>>Guinea Bissau</option>
          <option value="GY" <?php if(trim($_POST['cust_country'])=="GY"){ ?> selected <?php } ?>>Guyana</option>
          <option value="HN" <?php if(trim($_POST['cust_country'])=="HN"){ ?> selected <?php } ?>>Honduras</option>
          <option value="HK" <?php if(trim($_POST['cust_country'])=="HK"){ ?> selected <?php } ?>>Hong Kong</option>
          <option value="HU" <?php if(trim($_POST['cust_country'])=="HU"){ ?> selected <?php } ?>>Hungary</option>
          <option value="IS" <?php if(trim($_POST['cust_country'])=="IS"){ ?> selected <?php } ?>>Iceland</option>
          <option value="IN" <?php if(trim($_POST['cust_country'])=="IN"){ ?> selected <?php } ?>>India</option>
          <option value="ID" <?php if(trim($_POST['cust_country'])=="ID"){ ?> selected <?php } ?>>Indonesia</option>
          <option value="IE" <?php if(trim($_POST['cust_country'])=="IE"){ ?> selected <?php } ?>>Ireland</option>
          <option value="IL" <?php if(trim($_POST['cust_country'])=="IL"){ ?> selected <?php } ?>>Israel</option>
          <option value="IT" <?php if(trim($_POST['cust_country'])=="IT"){ ?> selected <?php } ?>>Italy</option>
          <option value="JM" <?php if(trim($_POST['cust_country'])=="JM"){ ?> selected <?php } ?>>Jamaica</option>
          <option value="JP" <?php if(trim($_POST['cust_country'])=="JP"){ ?> selected <?php } ?>>Japan</option>
          <option value="JO" <?php if(trim($_POST['cust_country'])=="JO"){ ?> selected <?php } ?>>Jordan</option>
          <option value="KZ" <?php if(trim($_POST['cust_country'])=="KZ"){ ?> selected <?php } ?>>Kazakhstan</option>
          <option value="KE" <?php if(trim($_POST['cust_country'])=="KE"){ ?> selected <?php } ?>>Kenya</option>
          <option value="KI" <?php if(trim($_POST['cust_country'])=="KI"){ ?> selected <?php } ?>>Kiribati</option>
          <option value="KW" <?php if(trim($_POST['cust_country'])=="KW"){ ?> selected <?php } ?>>Kuwait</option>
          <option value="KG" <?php if(trim($_POST['cust_country'])=="KG"){ ?> selected <?php } ?>>Kyrgyzstan</option>
          <option value="LA" <?php if(trim($_POST['cust_country'])=="LA"){ ?> selected <?php } ?>>Laos</option>
          <option value="LV" <?php if(trim($_POST['cust_country'])=="LV"){ ?> selected <?php } ?>>Latvia</option>
          <option value="LS" <?php if(trim($_POST['cust_country'])=="LS"){ ?> selected <?php } ?>>Lesotho</option>
          <option value="LI" <?php if(trim($_POST['cust_country'])=="LI"){ ?> selected <?php } ?>>Liechtenstein</option>
          <option value="LT" <?php if(trim($_POST['cust_country'])=="LT"){ ?> selected <?php } ?>>Lithuania</option>
          <option value="LU" <?php if(trim($_POST['cust_country'])=="LU"){ ?> selected <?php } ?>>Luxembourg</option>
          <option value="MG" <?php if(trim($_POST['cust_country'])=="MG"){ ?> selected <?php } ?>>Madagascar</option>
          <option value="MW" <?php if(trim($_POST['cust_country'])=="MW"){ ?> selected <?php } ?>>Malawi</option>
          <option value="MY" <?php if(trim($_POST['cust_country'])=="MY"){ ?> selected <?php } ?>>Malaysia</option>
          <option value="MV" <?php if(trim($_POST['cust_country'])=="MV"){ ?> selected <?php } ?>>Maldives</option>
          <option value="ML" <?php if(trim($_POST['cust_country'])=="ML"){ ?> selected <?php } ?>>Mali</option>
          <option value="MT" <?php if(trim($_POST['cust_country'])=="MT"){ ?> selected <?php } ?>>Malta</option>
          <option value="MH" <?php if(trim($_POST['cust_country'])=="MH"){ ?> selected <?php } ?>>Marshall Islands</option>
          <option value="MQ" <?php if(trim($_POST['cust_country'])=="MQ"){ ?> selected <?php } ?>>Martinique</option>
          <option value="MR" <?php if(trim($_POST['cust_country'])=="MR"){ ?> selected <?php } ?>>Mauritania</option>
          <option value="MU" <?php if(trim($_POST['cust_country'])=="MU"){ ?> selected <?php } ?>>Mauritius</option>
          <option value="YT" <?php if(trim($_POST['cust_country'])=="YT"){ ?> selected <?php } ?>>Mayotte</option>
          <option value="MX" <?php if(trim($_POST['cust_country'])=="MX"){ ?> selected <?php } ?>>Mexico</option>
          <option value="MN" <?php if(trim($_POST['cust_country'])=="MN"){ ?> selected <?php } ?>>Mongolia</option>
          <option value="MS" <?php if(trim($_POST['cust_country'])=="MS"){ ?> selected <?php } ?>>Montserrat</option>
          <option value="MA" <?php if(trim($_POST['cust_country'])=="MA"){ ?> selected <?php } ?>>Morocco</option>
          <option value="MZ" <?php if(trim($_POST['cust_country'])=="MZ"){ ?> selected <?php } ?>>Mozambique</option>
          <option value="NA" <?php if(trim($_POST['cust_country'])=="NA"){ ?> selected <?php } ?>>Namibia</option>
          <option value="NR" <?php if(trim($_POST['cust_country'])=="NR"){ ?> selected <?php } ?>>Nauru</option>
          <option value="NP" <?php if(trim($_POST['cust_country'])=="NP"){ ?> selected <?php } ?>>Nepal</option>
          <option value="NL" <?php if(trim($_POST['cust_country'])=="NL"){ ?> selected <?php } ?>>Netherlands</option>
          <option value="AN" <?php if(trim($_POST['cust_country'])=="AN"){ ?> selected <?php } ?>>Netherlands Antilles</option>
          <option value="NC" <?php if(trim($_POST['cust_country'])=="NC"){ ?> selected <?php } ?>>New Caledonia</option>
          <option value="NZ" <?php if(trim($_POST['cust_country'])=="NZ"){ ?> selected <?php } ?>>New Zealand</option>
          <option value="NI" <?php if(trim($_POST['cust_country'])=="NI"){ ?> selected <?php } ?>>Nicaragua</option>
          <option value="NE" <?php if(trim($_POST['cust_country'])=="NE"){ ?> selected <?php } ?>>Niger</option>
          <option value="NU" <?php if(trim($_POST['cust_country'])=="NU"){ ?> selected <?php } ?>>Niue</option>
          <option value="NF" <?php if(trim($_POST['cust_country'])=="NF"){ ?> selected <?php } ?>>Norfolk Island</option>
          <option value="NO" <?php if(trim($_POST['cust_country'])=="NO"){ ?> selected <?php } ?>>Norway</option>
          <option value="OM" <?php if(trim($_POST['cust_country'])=="OM"){ ?> selected <?php } ?>>Oman</option>
          <option value="PW" <?php if(trim($_POST['cust_country'])=="PW"){ ?> selected <?php } ?>>Palau</option>
          <option value="PA" <?php if(trim($_POST['cust_country'])=="PA"){ ?> selected <?php } ?>>Panama</option>
          <option value="PG" <?php if(trim($_POST['cust_country'])=="PG"){ ?> selected <?php } ?>>Papua New Guinea</option>
          <option value="PE" <?php if(trim($_POST['cust_country'])=="PE"){ ?> selected <?php } ?>>Peru</option>
          <option value="PH" <?php if(trim($_POST['cust_country'])=="PH"){ ?> selected <?php } ?>>Philippines</option>
          <option value="PN" <?php if(trim($_POST['cust_country'])=="PN"){ ?> selected <?php } ?>>Pitcairn Islands</option>
          <option value="PL" <?php if(trim($_POST['cust_country'])=="PL"){ ?> selected <?php } ?>>Poland</option>
          <option value="PT" <?php if(trim($_POST['cust_country'])=="PT"){ ?> selected <?php } ?>>Portugal</option>
          <option value="QA" <?php if(trim($_POST['cust_country'])=="QA"){ ?> selected <?php } ?>>Qatar</option>
          <option value="CG" <?php if(trim($_POST['cust_country'])=="CG"){ ?> selected <?php } ?>>Republic of the Congo</option>
          <option value="RE" <?php if(trim($_POST['cust_country'])=="RE"){ ?> selected <?php } ?>>Reunion</option>
          <option value="RO" <?php if(trim($_POST['cust_country'])=="RO"){ ?> selected <?php } ?>>Romania</option>
          <option value="RU" <?php if(trim($_POST['cust_country'])=="RU"){ ?> selected <?php } ?>>Russia</option>
          <option value="RW" <?php if(trim($_POST['cust_country'])=="RW"){ ?> selected <?php } ?>>Rwanda</option>
          <option value="VC" <?php if(trim($_POST['cust_country'])=="VC"){ ?> selected <?php } ?>>Saint Vincent and the Grenadines</option>
          <option value="WS" <?php if(trim($_POST['cust_country'])=="WS"){ ?> selected <?php } ?>>Samoa</option>
          <option value="SM" <?php if(trim($_POST['cust_country'])=="SM"){ ?> selected <?php } ?>>San Marino</option>
          <option value="ST" <?php if(trim($_POST['cust_country'])=="ST"){ ?> selected <?php } ?>>São Tomé and Príncipe</option>
          <option value="SA" <?php if(trim($_POST['cust_country'])=="SA"){ ?> selected <?php } ?>>Saudi Arabia</option>
          <option value="SN" <?php if(trim($_POST['cust_country'])=="SN"){ ?> selected <?php } ?>>Senegal</option>
          <option value="SC" <?php if(trim($_POST['cust_country'])=="SC"){ ?> selected <?php } ?>>Seychelles</option>
          <option value="SL" <?php if(trim($_POST['cust_country'])=="SL"){ ?> selected <?php } ?>>Sierra Leone</option>
          <option value="SG" <?php if(trim($_POST['cust_country'])=="SG"){ ?> selected <?php } ?>>Singapore</option>
          <option value="SK" <?php if(trim($_POST['cust_country'])=="SK"){ ?> selected <?php } ?>>Slovakia</option>
          <option value="SI" <?php if(trim($_POST['cust_country'])=="SI"){ ?> selected <?php } ?>>Slovenia</option>
          <option value="SB" <?php if(trim($_POST['cust_country'])=="SB"){ ?> selected <?php } ?>>Solomon Islands</option>
          <option value="SO" <?php if(trim($_POST['cust_country'])=="SO"){ ?> selected <?php } ?>>Somalia</option>
          <option value="ZA" <?php if(trim($_POST['cust_country'])=="ZA"){ ?> selected <?php } ?>>South Africa</option>
          <option value="KR" <?php if(trim($_POST['cust_country'])=="KR"){ ?> selected <?php } ?>>South Korea</option>
          <option value="ES" <?php if(trim($_POST['cust_country'])=="ES"){ ?> selected <?php } ?>>Spain</option>
          <option value="LK" <?php if(trim($_POST['cust_country'])=="LK"){ ?> selected <?php } ?>>Sri Lanka</option>
          <option value="SH" <?php if(trim($_POST['cust_country'])=="SH"){ ?> selected <?php } ?>>St. Helena</option>
          <option value="KN" <?php if(trim($_POST['cust_country'])=="KN"){ ?> selected <?php } ?>>St. Kitts and Nevis</option>
          <option value="LC" <?php if(trim($_POST['cust_country'])=="LC"){ ?> selected <?php } ?>>St. Lucia</option>
          <option value="PM" <?php if(trim($_POST['cust_country'])=="PM"){ ?> selected <?php } ?>>St. Pierre and Miquelon</option>
          <option value="SR" <?php if(trim($_POST['cust_country'])=="SR"){ ?> selected <?php } ?>>Suriname</option>
          <option value="SJ" <?php if(trim($_POST['cust_country'])=="SJ"){ ?> selected <?php } ?>>Svalbard and Jan Mayen Islands</option>
          <option value="SZ" <?php if(trim($_POST['cust_country'])=="SZ"){ ?> selected <?php } ?>>Swaziland</option>
          <option value="SE" <?php if(trim($_POST['cust_country'])=="SE"){ ?> selected <?php } ?>>Sweden</option>
          <option value="CH" <?php if(trim($_POST['cust_country'])=="CH"){ ?> selected <?php } ?>>Switzerland</option>
          <option value="TW" <?php if(trim($_POST['cust_country'])=="TW"){ ?> selected <?php } ?>>Taiwan</option>
          <option value="TJ" <?php if(trim($_POST['cust_country'])=="TJ"){ ?> selected <?php } ?>>Tajikistan</option>
          <option value="TZ" <?php if(trim($_POST['cust_country'])=="TZ"){ ?> selected <?php } ?>>Tanzania</option>
          <option value="TH" <?php if(trim($_POST['cust_country'])=="TH"){ ?> selected <?php } ?>>Thailand</option>
          <option value="TG" <?php if(trim($_POST['cust_country'])=="TG"){ ?> selected <?php } ?>>Togo</option>
          <option value="TO" <?php if(trim($_POST['cust_country'])=="TO"){ ?> selected <?php } ?>>Tonga</option>
          <option value="TT" <?php if(trim($_POST['cust_country'])=="TT"){ ?> selected <?php } ?>>Trinidad and Tobago</option>
          <option value="TN" <?php if(trim($_POST['cust_country'])=="TN"){ ?> selected <?php } ?>>Tunisia</option>
          <option value="TR" <?php if(trim($_POST['cust_country'])=="TR"){ ?> selected <?php } ?>>Turkey</option>
          <option value="TM" <?php if(trim($_POST['cust_country'])=="TM"){ ?> selected <?php } ?>>Turkmenistan</option>
          <option value="TC" <?php if(trim($_POST['cust_country'])=="TC"){ ?> selected <?php } ?>>Turks and Caicos Islands</option>
          <option value="TV" <?php if(trim($_POST['cust_country'])=="TV"){ ?> selected <?php } ?>>Tuvalu</option>
          <option value="UG" <?php if(trim($_POST['cust_country'])=="UG"){ ?> selected <?php } ?>>Uganda</option>
          <option value="UA" <?php if(trim($_POST['cust_country'])=="UA"){ ?> selected <?php } ?>>Ukraine</option>
          <option value="AE" <?php if(trim($_POST['cust_country'])=="AE"){ ?> selected <?php } ?>>United Arab Emirates</option>
          <option value="GB" <?php if(trim($_POST['cust_country'])=="GB"){ ?> selected <?php } ?>>United Kingdom</option>
          <option value="US" <?php if(trim($_POST['cust_country'])=="US" || trim($_POST['cust_country'])==""){ ?> selected <?php } ?>>United States of America</option>
          <option value="UY" <?php if(trim($_POST['cust_country'])=="UY"){ ?> selected <?php } ?>>Uruguay</option>
          <option value="VU" <?php if(trim($_POST['cust_country'])=="VU"){ ?> selected <?php } ?>>Vanuatu</option>
          <option value="VA" <?php if(trim($_POST['cust_country'])=="VA"){ ?> selected <?php } ?>>Vatican City State</option>
          <option value="VE" <?php if(trim($_POST['cust_country'])=="VE"){ ?> selected <?php } ?>>Venezuela</option>
          <option value="VN" <?php if(trim($_POST['cust_country'])=="VN"){ ?> selected <?php } ?>>Vietnam</option>
          <option value="WF" <?php if(trim($_POST['cust_country'])=="WF"){ ?> selected <?php } ?>>Wallis and Futuna Islands</option>
          <option value="YE" <?php if(trim($_POST['cust_country'])=="YE"){ ?> selected <?php } ?>>Yemen</option>
          <option value="ZM" <?php if(trim($_POST['cust_country'])=="ZM"){ ?> selected <?php } ?>>Zambia</option>
        </select>
                
                 <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Zip:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_zip" type="text" id="cust_zip" value="<?php echo $row['cust_zip'];?>" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">&nbsp;</td>
				<td class="admlsttxt"><input type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"name="Register" id="Register" value="Update Profile" /></td>
			</tr>
		</table>
		</form>
		<!-- </div>-->
    <?php 
    }
    ?>
	</div>
	<?php
    if ($action=="add") {
    ?>   
        <form name="addcust" id="addcust"  method="post" onsubmit="return custValueValidate();">
        <input type="hidden" name="a" value="addcustomers" />
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr>
				<td colspan="2" height="5"></td>
			</tr>
			<tr>
				<td colspan="2" class="adminheader">Add New Customer Profile > <?php echo $row['fld_fullName'];?></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Name:</td>
				<td class="admlsttxt"><input class="formfields" name="fld_fullName" type="text" id="fld_fullName" value="" size="30"/>
                <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Email/ User Name:</td>
				<td class="admlsttxt"><input class="formfields" name="fld_userName" type="text" id="fld_userName" value="" size="30"/>
                <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Password:</td>
				<td class="admlsttxt"><input class="formfields" name="fld_passWd" type="password" id="fld_passWd" value="" size="30"/>
                <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Name:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_name" type="text" id="cust_name" value="" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Address:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_address" type="text" id="cust_address" value="" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer City:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_city" type="text" id="cust_city" value="" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer State:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_state" type="text" id="cust_state" value="" size="30"/> <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Country:</td>
				<td class="admlsttxt">
                    <select class="formfields" name="cust_country">
                      <option value="AL" <?php if(trim($_POST['cust_country'])=="AL"){ ?> selected <?php } ?>>Albania</option>
                      <option value="DZ" <?php if(trim($_POST['cust_country'])=="DZ"){ ?> selected <?php } ?>>Algeria</option>
                      <option value="AD" <?php if(trim($_POST['cust_country'])=="AD"){ ?> selected <?php } ?>>Andorra</option>
                      <option value="AO" <?php if(trim($_POST['cust_country'])=="AO"){ ?> selected <?php } ?>>Angola</option>
                      <option value="AI" <?php if(trim($_POST['cust_country'])=="AI"){ ?> selected <?php } ?>>Anguilla</option>
                      <option value="AG" <?php if(trim($_POST['cust_country'])=="AG"){ ?> selected <?php } ?>>Antigua and Barbuda</option>
                      <option value="AR" <?php if(trim($_POST['cust_country'])=="AR"){ ?> selected <?php } ?>>Argentina</option>
                      <option value="AM" <?php if(trim($_POST['cust_country'])=="AM"){ ?> selected <?php } ?>>Armenia</option>
                      <option value="AW" <?php if(trim($_POST['cust_country'])=="AW"){ ?> selected <?php } ?>>Aruba</option>
                      <option value="AU" <?php if(trim($_POST['cust_country'])=="AU"){ ?> selected <?php } ?>>Australia</option>
                      <option value="AT" <?php if(trim($_POST['cust_country'])=="AT"){ ?> selected <?php } ?>>Austria</option>
                      <option value="AZ" <?php if(trim($_POST['cust_country'])=="AZ"){ ?> selected <?php } ?>>Azerbaijan Republic</option>
                      <option value="BS" <?php if(trim($_POST['cust_country'])=="BS"){ ?> selected <?php } ?>>Bahamas</option>
                      <option value="BH" <?php if(trim($_POST['cust_country'])=="BH"){ ?> selected <?php } ?>>Bahrain</option>
                      <option value="BB" <?php if(trim($_POST['cust_country'])=="BB"){ ?> selected <?php } ?>>Barbados</option>
                      <option value="BE" <?php if(trim($_POST['cust_country'])=="BE"){ ?> selected <?php } ?>>Belgium</option>
                      <option value="BZ" <?php if(trim($_POST['cust_country'])=="BZ"){ ?> selected <?php } ?>>Belize</option>
                      <option value="BJ" <?php if(trim($_POST['cust_country'])=="BJ"){ ?> selected <?php } ?>>Benin</option>
                      <option value="BM" <?php if(trim($_POST['cust_country'])=="BM"){ ?> selected <?php } ?>>Bermuda</option>
                      <option value="BT" <?php if(trim($_POST['cust_country'])=="BT"){ ?> selected <?php } ?>>Bhutan</option>
                      <option value="BO" <?php if(trim($_POST['cust_country'])=="BO"){ ?> selected <?php } ?>>Bolivia</option>
                      <option value="BA" <?php if(trim($_POST['cust_country'])=="BA"){ ?> selected <?php } ?>>Bosnia and Herzegovina</option>
                      <option value="BW" <?php if(trim($_POST['cust_country'])=="BW"){ ?> selected <?php } ?>>Botswana</option>
                      <option value="BR" <?php if(trim($_POST['cust_country'])=="BR"){ ?> selected <?php } ?>>Brazil</option>
                      <option value="VG" <?php if(trim($_POST['cust_country'])=="VG"){ ?> selected <?php } ?>>British Virgin Islands</option>
                      <option value="BN" <?php if(trim($_POST['cust_country'])=="BN"){ ?> selected <?php } ?>>Brunei</option>
                      <option value="BG" <?php if(trim($_POST['cust_country'])=="BG"){ ?> selected <?php } ?>>Bulgaria</option>
                      <option value="BF" <?php if(trim($_POST['cust_country'])=="BF"){ ?> selected <?php } ?>>Burkina Faso</option>
                      <option value="BI" <?php if(trim($_POST['cust_country'])=="BI"){ ?> selected <?php } ?>>Burundi</option>
                      <option value="KH" <?php if(trim($_POST['cust_country'])=="KH"){ ?> selected <?php } ?>>Cambodia</option>
                      <option value="CA" <?php if(trim($_POST['cust_country'])=="CA"){ ?> selected <?php } ?>>Canada</option>
                      <option value="CV" <?php if(trim($_POST['cust_country'])=="CV"){ ?> selected <?php } ?>>Cape Verde</option>
                      <option value="KY" <?php if(trim($_POST['cust_country'])=="KY"){ ?> selected <?php } ?>>Cayman Islands</option>
                      <option value="TD" <?php if(trim($_POST['cust_country'])=="TD"){ ?> selected <?php } ?>>Chad</option>
                      <option value="CL" <?php if(trim($_POST['cust_country'])=="CL"){ ?> selected <?php } ?>>Chile</option>
                      <option value="C2" <?php if(trim($_POST['cust_country'])=="C2"){ ?> selected <?php } ?>>China Worldwide</option>
                      <option value="CO" <?php if(trim($_POST['cust_country'])=="CO"){ ?> selected <?php } ?>>Colombia</option>
                      <option value="KM" <?php if(trim($_POST['cust_country'])=="KM"){ ?> selected <?php } ?>>Comoros</option>
                      <option value="CK" <?php if(trim($_POST['cust_country'])=="CK"){ ?> selected <?php } ?>>Cook Islands</option>
                      <option value="CR" <?php if(trim($_POST['cust_country'])=="CR"){ ?> selected <?php } ?>>Costa Rica</option>
                      <option value="HR" <?php if(trim($_POST['cust_country'])=="HR"){ ?> selected <?php } ?>>Croatia</option>
                      <option value="CY" <?php if(trim($_POST['cust_country'])=="CY"){ ?> selected <?php } ?>>Cyprus</option>
                      <option value="CZ" <?php if(trim($_POST['cust_country'])=="CZ"){ ?> selected <?php } ?>>Czech Republic</option>
                      <option value="CD" <?php if(trim($_POST['cust_country'])=="CD"){ ?> selected <?php } ?>>Democratic Republic of the Congo</option>
                      <option value="DK" <?php if(trim($_POST['cust_country'])=="DK"){ ?> selected <?php } ?>>Denmark</option>
                      <option value="DJ" <?php if(trim($_POST['cust_country'])=="DJ"){ ?> selected <?php } ?>>Djibouti</option>
                      <option value="DM" <?php if(trim($_POST['cust_country'])=="DM"){ ?> selected <?php } ?>>Dominica</option>
                      <option value="DO" <?php if(trim($_POST['cust_country'])=="DO"){ ?> selected <?php } ?>>Dominican Republic</option>
                      <option value="EC" <?php if(trim($_POST['cust_country'])=="EC"){ ?> selected <?php } ?>>Ecuador</option>
                      <option value="EG" <?php if(trim($_POST['cust_country'])=="EG"){ ?> selected <?php } ?>>Egypt</option>
                      <option value="SV" <?php if(trim($_POST['cust_country'])=="SV"){ ?> selected <?php } ?>>El Salvador</option>
                      <option value="ER" <?php if(trim($_POST['cust_country'])=="ER"){ ?> selected <?php } ?>>Eritrea</option>
                      <option value="EE" <?php if(trim($_POST['cust_country'])=="EE"){ ?> selected <?php } ?>>Estonia</option>
                      <option value="ET" <?php if(trim($_POST['cust_country'])=="ET"){ ?> selected <?php } ?>>Ethiopia</option>
                      <option value="FK" <?php if(trim($_POST['cust_country'])=="FK"){ ?> selected <?php } ?>>Falkland Islands</option>
                      <option value="FO" <?php if(trim($_POST['cust_country'])=="FO"){ ?> selected <?php } ?>>Faroe Islands</option>
                      <option value="FM" <?php if(trim($_POST['cust_country'])=="FM"){ ?> selected <?php } ?>>Federated States of Micronesia</option>
                      <option value="FJ" <?php if(trim($_POST['cust_country'])=="FJ"){ ?> selected <?php } ?>>Fiji</option>
                      <option value="FI" <?php if(trim($_POST['cust_country'])=="FI"){ ?> selected <?php } ?>>Finland</option>
                      <option value="FR" <?php if(trim($_POST['cust_country'])=="FR"){ ?> selected <?php } ?>>France</option>
                      <option value="GF" <?php if(trim($_POST['cust_country'])=="GF"){ ?> selected <?php } ?>>French Guiana</option>
                      <option value="PF" <?php if(trim($_POST['cust_country'])=="PF"){ ?> selected <?php } ?>>French Polynesia</option>
                      <option value="GA" <?php if(trim($_POST['cust_country'])=="GA"){ ?> selected <?php } ?>>Gabon Republic</option>
                      <option value="GM" <?php if(trim($_POST['cust_country'])=="GM"){ ?> selected <?php } ?>>Gambia</option>
                      <option value="DE" <?php if(trim($_POST['cust_country'])=="DE"){ ?> selected <?php } ?>>Germany</option>
                      <option value="GI" <?php if(trim($_POST['cust_country'])=="GI"){ ?> selected <?php } ?>>Gibraltar</option>
                      <option value="GR" <?php if(trim($_POST['cust_country'])=="GR"){ ?> selected <?php } ?>>Greece</option>
                      <option value="GL" <?php if(trim($_POST['cust_country'])=="GL"){ ?> selected <?php } ?>>Greenland</option>
                      <option value="GD" <?php if(trim($_POST['cust_country'])=="GD"){ ?> selected <?php } ?>>Grenada</option>
                      <option value="GP" <?php if(trim($_POST['cust_country'])=="GP"){ ?> selected <?php } ?>>Guadeloupe</option>
                      <option value="GT" <?php if(trim($_POST['cust_country'])=="GT"){ ?> selected <?php } ?>>Guatemala</option>
                      <option value="GN" <?php if(trim($_POST['cust_country'])=="GN"){ ?> selected <?php } ?>>Guinea</option>
                      <option value="GW" <?php if(trim($_POST['cust_country'])=="GW"){ ?> selected <?php } ?>>Guinea Bissau</option>
                      <option value="GY" <?php if(trim($_POST['cust_country'])=="GY"){ ?> selected <?php } ?>>Guyana</option>
                      <option value="HN" <?php if(trim($_POST['cust_country'])=="HN"){ ?> selected <?php } ?>>Honduras</option>
                      <option value="HK" <?php if(trim($_POST['cust_country'])=="HK"){ ?> selected <?php } ?>>Hong Kong</option>
                      <option value="HU" <?php if(trim($_POST['cust_country'])=="HU"){ ?> selected <?php } ?>>Hungary</option>
                      <option value="IS" <?php if(trim($_POST['cust_country'])=="IS"){ ?> selected <?php } ?>>Iceland</option>
                      <option value="IN" <?php if(trim($_POST['cust_country'])=="IN"){ ?> selected <?php } ?>>India</option>
                      <option value="ID" <?php if(trim($_POST['cust_country'])=="ID"){ ?> selected <?php } ?>>Indonesia</option>
                      <option value="IE" <?php if(trim($_POST['cust_country'])=="IE"){ ?> selected <?php } ?>>Ireland</option>
                      <option value="IL" <?php if(trim($_POST['cust_country'])=="IL"){ ?> selected <?php } ?>>Israel</option>
                      <option value="IT" <?php if(trim($_POST['cust_country'])=="IT"){ ?> selected <?php } ?>>Italy</option>
                      <option value="JM" <?php if(trim($_POST['cust_country'])=="JM"){ ?> selected <?php } ?>>Jamaica</option>
                      <option value="JP" <?php if(trim($_POST['cust_country'])=="JP"){ ?> selected <?php } ?>>Japan</option>
                      <option value="JO" <?php if(trim($_POST['cust_country'])=="JO"){ ?> selected <?php } ?>>Jordan</option>
                      <option value="KZ" <?php if(trim($_POST['cust_country'])=="KZ"){ ?> selected <?php } ?>>Kazakhstan</option>
                      <option value="KE" <?php if(trim($_POST['cust_country'])=="KE"){ ?> selected <?php } ?>>Kenya</option>
                      <option value="KI" <?php if(trim($_POST['cust_country'])=="KI"){ ?> selected <?php } ?>>Kiribati</option>
                      <option value="KW" <?php if(trim($_POST['cust_country'])=="KW"){ ?> selected <?php } ?>>Kuwait</option>
                      <option value="KG" <?php if(trim($_POST['cust_country'])=="KG"){ ?> selected <?php } ?>>Kyrgyzstan</option>
                      <option value="LA" <?php if(trim($_POST['cust_country'])=="LA"){ ?> selected <?php } ?>>Laos</option>
                      <option value="LV" <?php if(trim($_POST['cust_country'])=="LV"){ ?> selected <?php } ?>>Latvia</option>
                      <option value="LS" <?php if(trim($_POST['cust_country'])=="LS"){ ?> selected <?php } ?>>Lesotho</option>
                      <option value="LI" <?php if(trim($_POST['cust_country'])=="LI"){ ?> selected <?php } ?>>Liechtenstein</option>
                      <option value="LT" <?php if(trim($_POST['cust_country'])=="LT"){ ?> selected <?php } ?>>Lithuania</option>
                      <option value="LU" <?php if(trim($_POST['cust_country'])=="LU"){ ?> selected <?php } ?>>Luxembourg</option>
                      <option value="MG" <?php if(trim($_POST['cust_country'])=="MG"){ ?> selected <?php } ?>>Madagascar</option>
                      <option value="MW" <?php if(trim($_POST['cust_country'])=="MW"){ ?> selected <?php } ?>>Malawi</option>
                      <option value="MY" <?php if(trim($_POST['cust_country'])=="MY"){ ?> selected <?php } ?>>Malaysia</option>
                      <option value="MV" <?php if(trim($_POST['cust_country'])=="MV"){ ?> selected <?php } ?>>Maldives</option>
                      <option value="ML" <?php if(trim($_POST['cust_country'])=="ML"){ ?> selected <?php } ?>>Mali</option>
                      <option value="MT" <?php if(trim($_POST['cust_country'])=="MT"){ ?> selected <?php } ?>>Malta</option>
                      <option value="MH" <?php if(trim($_POST['cust_country'])=="MH"){ ?> selected <?php } ?>>Marshall Islands</option>
                      <option value="MQ" <?php if(trim($_POST['cust_country'])=="MQ"){ ?> selected <?php } ?>>Martinique</option>
                      <option value="MR" <?php if(trim($_POST['cust_country'])=="MR"){ ?> selected <?php } ?>>Mauritania</option>
                      <option value="MU" <?php if(trim($_POST['cust_country'])=="MU"){ ?> selected <?php } ?>>Mauritius</option>
                      <option value="YT" <?php if(trim($_POST['cust_country'])=="YT"){ ?> selected <?php } ?>>Mayotte</option>
                      <option value="MX" <?php if(trim($_POST['cust_country'])=="MX"){ ?> selected <?php } ?>>Mexico</option>
                      <option value="MN" <?php if(trim($_POST['cust_country'])=="MN"){ ?> selected <?php } ?>>Mongolia</option>
                      <option value="MS" <?php if(trim($_POST['cust_country'])=="MS"){ ?> selected <?php } ?>>Montserrat</option>
                      <option value="MA" <?php if(trim($_POST['cust_country'])=="MA"){ ?> selected <?php } ?>>Morocco</option>
                      <option value="MZ" <?php if(trim($_POST['cust_country'])=="MZ"){ ?> selected <?php } ?>>Mozambique</option>
                      <option value="NA" <?php if(trim($_POST['cust_country'])=="NA"){ ?> selected <?php } ?>>Namibia</option>
                      <option value="NR" <?php if(trim($_POST['cust_country'])=="NR"){ ?> selected <?php } ?>>Nauru</option>
                      <option value="NP" <?php if(trim($_POST['cust_country'])=="NP"){ ?> selected <?php } ?>>Nepal</option>
                      <option value="NL" <?php if(trim($_POST['cust_country'])=="NL"){ ?> selected <?php } ?>>Netherlands</option>
                      <option value="AN" <?php if(trim($_POST['cust_country'])=="AN"){ ?> selected <?php } ?>>Netherlands Antilles</option>
                      <option value="NC" <?php if(trim($_POST['cust_country'])=="NC"){ ?> selected <?php } ?>>New Caledonia</option>
                      <option value="NZ" <?php if(trim($_POST['cust_country'])=="NZ"){ ?> selected <?php } ?>>New Zealand</option>
                      <option value="NI" <?php if(trim($_POST['cust_country'])=="NI"){ ?> selected <?php } ?>>Nicaragua</option>
                      <option value="NE" <?php if(trim($_POST['cust_country'])=="NE"){ ?> selected <?php } ?>>Niger</option>
                      <option value="NU" <?php if(trim($_POST['cust_country'])=="NU"){ ?> selected <?php } ?>>Niue</option>
                      <option value="NF" <?php if(trim($_POST['cust_country'])=="NF"){ ?> selected <?php } ?>>Norfolk Island</option>
                      <option value="NO" <?php if(trim($_POST['cust_country'])=="NO"){ ?> selected <?php } ?>>Norway</option>
                      <option value="OM" <?php if(trim($_POST['cust_country'])=="OM"){ ?> selected <?php } ?>>Oman</option>
                      <option value="PW" <?php if(trim($_POST['cust_country'])=="PW"){ ?> selected <?php } ?>>Palau</option>
                      <option value="PA" <?php if(trim($_POST['cust_country'])=="PA"){ ?> selected <?php } ?>>Panama</option>
                      <option value="PG" <?php if(trim($_POST['cust_country'])=="PG"){ ?> selected <?php } ?>>Papua New Guinea</option>
                      <option value="PE" <?php if(trim($_POST['cust_country'])=="PE"){ ?> selected <?php } ?>>Peru</option>
                      <option value="PH" <?php if(trim($_POST['cust_country'])=="PH"){ ?> selected <?php } ?>>Philippines</option>
                      <option value="PN" <?php if(trim($_POST['cust_country'])=="PN"){ ?> selected <?php } ?>>Pitcairn Islands</option>
                      <option value="PL" <?php if(trim($_POST['cust_country'])=="PL"){ ?> selected <?php } ?>>Poland</option>
                      <option value="PT" <?php if(trim($_POST['cust_country'])=="PT"){ ?> selected <?php } ?>>Portugal</option>
                      <option value="QA" <?php if(trim($_POST['cust_country'])=="QA"){ ?> selected <?php } ?>>Qatar</option>
                      <option value="CG" <?php if(trim($_POST['cust_country'])=="CG"){ ?> selected <?php } ?>>Republic of the Congo</option>
                      <option value="RE" <?php if(trim($_POST['cust_country'])=="RE"){ ?> selected <?php } ?>>Reunion</option>
                      <option value="RO" <?php if(trim($_POST['cust_country'])=="RO"){ ?> selected <?php } ?>>Romania</option>
                      <option value="RU" <?php if(trim($_POST['cust_country'])=="RU"){ ?> selected <?php } ?>>Russia</option>
                      <option value="RW" <?php if(trim($_POST['cust_country'])=="RW"){ ?> selected <?php } ?>>Rwanda</option>
                      <option value="VC" <?php if(trim($_POST['cust_country'])=="VC"){ ?> selected <?php } ?>>Saint Vincent and the Grenadines</option>
                      <option value="WS" <?php if(trim($_POST['cust_country'])=="WS"){ ?> selected <?php } ?>>Samoa</option>
                      <option value="SM" <?php if(trim($_POST['cust_country'])=="SM"){ ?> selected <?php } ?>>San Marino</option>
                      <option value="ST" <?php if(trim($_POST['cust_country'])=="ST"){ ?> selected <?php } ?>>São Tomé and Príncipe</option>
                      <option value="SA" <?php if(trim($_POST['cust_country'])=="SA"){ ?> selected <?php } ?>>Saudi Arabia</option>
                      <option value="SN" <?php if(trim($_POST['cust_country'])=="SN"){ ?> selected <?php } ?>>Senegal</option>
                      <option value="SC" <?php if(trim($_POST['cust_country'])=="SC"){ ?> selected <?php } ?>>Seychelles</option>
                      <option value="SL" <?php if(trim($_POST['cust_country'])=="SL"){ ?> selected <?php } ?>>Sierra Leone</option>
                      <option value="SG" <?php if(trim($_POST['cust_country'])=="SG"){ ?> selected <?php } ?>>Singapore</option>
                      <option value="SK" <?php if(trim($_POST['cust_country'])=="SK"){ ?> selected <?php } ?>>Slovakia</option>
                      <option value="SI" <?php if(trim($_POST['cust_country'])=="SI"){ ?> selected <?php } ?>>Slovenia</option>
                      <option value="SB" <?php if(trim($_POST['cust_country'])=="SB"){ ?> selected <?php } ?>>Solomon Islands</option>
                      <option value="SO" <?php if(trim($_POST['cust_country'])=="SO"){ ?> selected <?php } ?>>Somalia</option>
                      <option value="ZA" <?php if(trim($_POST['cust_country'])=="ZA"){ ?> selected <?php } ?>>South Africa</option>
                      <option value="KR" <?php if(trim($_POST['cust_country'])=="KR"){ ?> selected <?php } ?>>South Korea</option>
                      <option value="ES" <?php if(trim($_POST['cust_country'])=="ES"){ ?> selected <?php } ?>>Spain</option>
                      <option value="LK" <?php if(trim($_POST['cust_country'])=="LK"){ ?> selected <?php } ?>>Sri Lanka</option>
                      <option value="SH" <?php if(trim($_POST['cust_country'])=="SH"){ ?> selected <?php } ?>>St. Helena</option>
                      <option value="KN" <?php if(trim($_POST['cust_country'])=="KN"){ ?> selected <?php } ?>>St. Kitts and Nevis</option>
                      <option value="LC" <?php if(trim($_POST['cust_country'])=="LC"){ ?> selected <?php } ?>>St. Lucia</option>
                      <option value="PM" <?php if(trim($_POST['cust_country'])=="PM"){ ?> selected <?php } ?>>St. Pierre and Miquelon</option>
                      <option value="SR" <?php if(trim($_POST['cust_country'])=="SR"){ ?> selected <?php } ?>>Suriname</option>
                      <option value="SJ" <?php if(trim($_POST['cust_country'])=="SJ"){ ?> selected <?php } ?>>Svalbard and Jan Mayen Islands</option>
                      <option value="SZ" <?php if(trim($_POST['cust_country'])=="SZ"){ ?> selected <?php } ?>>Swaziland</option>
                      <option value="SE" <?php if(trim($_POST['cust_country'])=="SE"){ ?> selected <?php } ?>>Sweden</option>
                      <option value="CH" <?php if(trim($_POST['cust_country'])=="CH"){ ?> selected <?php } ?>>Switzerland</option>
                      <option value="TW" <?php if(trim($_POST['cust_country'])=="TW"){ ?> selected <?php } ?>>Taiwan</option>
                      <option value="TJ" <?php if(trim($_POST['cust_country'])=="TJ"){ ?> selected <?php } ?>>Tajikistan</option>
                      <option value="TZ" <?php if(trim($_POST['cust_country'])=="TZ"){ ?> selected <?php } ?>>Tanzania</option>
                      <option value="TH" <?php if(trim($_POST['cust_country'])=="TH"){ ?> selected <?php } ?>>Thailand</option>
                      <option value="TG" <?php if(trim($_POST['cust_country'])=="TG"){ ?> selected <?php } ?>>Togo</option>
                      <option value="TO" <?php if(trim($_POST['cust_country'])=="TO"){ ?> selected <?php } ?>>Tonga</option>
                      <option value="TT" <?php if(trim($_POST['cust_country'])=="TT"){ ?> selected <?php } ?>>Trinidad and Tobago</option>
                      <option value="TN" <?php if(trim($_POST['cust_country'])=="TN"){ ?> selected <?php } ?>>Tunisia</option>
                      <option value="TR" <?php if(trim($_POST['cust_country'])=="TR"){ ?> selected <?php } ?>>Turkey</option>
                      <option value="TM" <?php if(trim($_POST['cust_country'])=="TM"){ ?> selected <?php } ?>>Turkmenistan</option>
                      <option value="TC" <?php if(trim($_POST['cust_country'])=="TC"){ ?> selected <?php } ?>>Turks and Caicos Islands</option>
                      <option value="TV" <?php if(trim($_POST['cust_country'])=="TV"){ ?> selected <?php } ?>>Tuvalu</option>
                      <option value="UG" <?php if(trim($_POST['cust_country'])=="UG"){ ?> selected <?php } ?>>Uganda</option>
                      <option value="UA" <?php if(trim($_POST['cust_country'])=="UA"){ ?> selected <?php } ?>>Ukraine</option>
                      <option value="AE" <?php if(trim($_POST['cust_country'])=="AE"){ ?> selected <?php } ?>>United Arab Emirates</option>
                      <option value="GB" <?php if(trim($_POST['cust_country'])=="GB"){ ?> selected <?php } ?>>United Kingdom</option>
                      <option value="US" <?php if(trim($_POST['cust_country'])=="US" || trim($_POST['cust_country'])==""){ ?> selected <?php } ?>>United States of America</option>
                      <option value="UY" <?php if(trim($_POST['cust_country'])=="UY"){ ?> selected <?php } ?>>Uruguay</option>
                      <option value="VU" <?php if(trim($_POST['cust_country'])=="VU"){ ?> selected <?php } ?>>Vanuatu</option>
                      <option value="VA" <?php if(trim($_POST['cust_country'])=="VA"){ ?> selected <?php } ?>>Vatican City State</option>
                      <option value="VE" <?php if(trim($_POST['cust_country'])=="VE"){ ?> selected <?php } ?>>Venezuela</option>
                      <option value="VN" <?php if(trim($_POST['cust_country'])=="VN"){ ?> selected <?php } ?>>Vietnam</option>
                      <option value="WF" <?php if(trim($_POST['cust_country'])=="WF"){ ?> selected <?php } ?>>Wallis and Futuna Islands</option>
                      <option value="YE" <?php if(trim($_POST['cust_country'])=="YE"){ ?> selected <?php } ?>>Yemen</option>
                      <option value="ZM" <?php if(trim($_POST['cust_country'])=="ZM"){ ?> selected <?php } ?>>Zambia</option>
                    </select>
                
                 <span class="redtext">*</span></td>
			</tr>
			<tr>
				<td class="admlsttxt">Customer Zip:</td>
				<td class="admlsttxt"><input class="formfields" name="cust_zip" type="text" id="cust_zip" value="" size="30"/><span class="redtext">*</span></td>
			</tr>
            
			<tr>
				<td class="admlsttxt">&nbsp;</td>
				<td class="admlsttxt"><input type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"name="Register" id="Register" value="Save Profile" /></td>
			</tr>
		</table>
        </form>
    <?php 
    }
    ?>
        </td>
	</tr>
</table>
</div>

