<?php if($_GET['section'] != 'options' || $_GET['do'] != 'optionvalue') { echo '<script>window.location="index.php";</script>'; } ?>
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
	mysql_query("UPDATE option_values set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=activated";</script>';
}

if($action=='deactivate') {
	mysql_query("UPDATE option_values set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());		
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deactivated";</script>';		
}	

if ($action=="delete"){
	mysql_query("DELETE FROM option_values WHERE id='" . $_GET['id'] . "' LIMIT 1");			
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deleted";</script>';		
	$action="";
}  


if($action=='editnow'){
	$sql="UPDATE option_values set type_id='".$_POST['type_id']."',name='".$_POST['name']."',price_add='".$_POST['price_add']."',price_type='".$_POST['price_type']."' where id='".$_POST['id']."'";
	mysql_query($sql)or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=updated";</script>';
	$action='';
}
if($action=='addcustomers'){
	$sql="insert into option_values (type_id, name, price_add, price_type) values('".$_POST['type_id']."', '".$_POST['name']."', '".$_POST['price_add']."', '".$_POST['price_type']."')";
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
?>
            <table width="710" border="0" cellpadding="3" cellspacing="0">
                <tr>
                    <td width="280"><b>Value</b></td>
                    <td width="250"><b>Option Type</b></td>
                    <td width="70"><b>Actions</b></td>
                </tr>
                <tr>
                    <td colspan="3"><hr></td>
                </tr>                   
<?php
	$sql = mysql_query("SELECT * FROM option_values ORDER BY type_id,name");
	while($row=mysql_fetch_assoc($sql)) {
		$sqltype = mysql_query("SELECT typename FROM option_type where id=".$row['type_id']."");
		$rowtype=mysql_fetch_assoc($sqltype);
		
		
		if($i%2) {
			$bgcolor="oddrow";
		} else {
			$bgcolor="evenrow";
		}	
		$editable = '<a href="?section='.$_GET['section'].'&do='.$_GET['do'].'&a=edit&id='.$row['id'].'"><img src="images/edit.png" title="Edit" alt="Edit" border="0"></a>';
	 	$recycle = '<a href="#" onclick="confirm_deleteShop('.$row['id'].');"><img src="images/delete.png" title="Recycle Bin" alt="Recycle Bin" border="0"></a>';
?>
				<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                    <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($row['name'])); ?></td>
                    <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($rowtype['typename'])); ?></td>
                    <td><?php echo $editable; ?>&nbsp;<?php echo $recycle; ?></td>
				</tr>
<?php $i++; } ?>
			</table>
<?php }
    ?>
<!-- <div id="listForm">-->
	<?php
    if ($action=="edit") {
		$sql="select * from option_values where id='".$_GET['id']."'";
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
				<td colspan="2" class="adminheader">Edit Option Value <?php echo $row['name'];?></td>
			</tr>
            <tr>
              <td>Option Type:</td>
              <td><select name="type_id" id="type_id" style="width:150px">
                    <option value="0">Select</option>		
                    <?php 
                        $catsql = mysql_query("SELECT * FROM option_type");
                        while($catrow = mysql_fetch_assoc($catsql)) {
                    echo "<option value=\"".$catrow['id']."\"";
                    if($row['type_id'] == $catrow['id']) 
                        echo " selected=\"selected\" ";
                    echo ">".$catrow['typename']."</option>";
                    }
                    ?>	
                </select></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Value Name :</td>
                <td width="80%" class="admlsttxt"><input class="formfields" name="name" type="text" id="name" value="<?php echo $row['name'];?>" size="30"/><span class="redtext">*</span></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Price Add :</td>
                <td width="80%" class="admlsttxt"><input class="formfields" name="price_add" type="text" id="price_add" value="<?php echo $row['price_add'];?>" size="30"/><span class="redtext">*</span></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Price Type :</td>
                <td width="80%" class="admlsttxt">
                  <select class="formfields" name="price_type" id="price_type"style="width:150px">
                	<option value="Amount" <?php echo ($row['price_type']=='Amount'?'selected="selected"':'');?>>Amount</option>
                	<option value="Percentage" <?php echo ($row['price_type']=='Percentage'?'selected="selected"':'');?>>Percentage</option>
                </select>
                <span class="redtext">*</span></td>
            </tr>
			<tr>
				<td class="admlsttxt">&nbsp;</td>
				<td class="admlsttxt"><input type="submit" class="btn" name="Register" id="Register" value="Update Option Value" /></td>
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
        <table width="650" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <td colspan="2" height="20">Add New Option Value </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
              <td>Option Type:</td>
              <td><select name="type_id" id="type_id" style="width:150px">
                    <option value="0">Select</option>		
                    <?php 
                        $catsql = mysql_query("SELECT * FROM option_type");
                        while($catrow = mysql_fetch_assoc($catsql)) {
                    echo "<option value=\"".$catrow['id']."\"";
                    if($row['cat'] == $catrow['id']) 
                        echo " selected=\"selected\" ";
                    echo ">".$catrow['typename']."</option>";
                    }
                    ?>	
                </select></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Value Name :</td>
                <td width="80%" class="admlsttxt"><input class="formfields" name="name" type="text" id="name" value="" size="30"/><span class="redtext">*</span></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Price Add :</td>
                <td width="80%" class="admlsttxt"><input class="formfields" name="price_add" type="text" id="price_add" value="" size="30"/><span class="redtext">*</span></td>
            </tr>
            <tr>
                <td width="20%" class="admlsttxt">Price Type :</td>
                <td width="80%" class="admlsttxt">
                <select class="formfields" name="price_type" id="price_type"style="width:150px">
                	<option value="Amount" selected="selected">Amount</option>
                	<option value="Percentage">Percentage</option>
                </select>
                <span class="redtext">*</span></td>
            </tr>
            <tr>
                <td class="admlsttxt">&nbsp;</td>
                <td class="admlsttxt"><input type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"name="Addcust" id="Addcust" value="Save Option Value" /></td>
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

