<?php if($_GET['section'] != 'options' || $_GET['do'] != 'optiontype') { echo '<script>window.location="index.php";</script>'; } ?>
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
	mysql_query("UPDATE option_type set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=activated";</script>';
}
if($action=='deactivate') {
	mysql_query("UPDATE option_type set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());		
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deactivated";</script>';		
}	
if ($action=="delete"){
	mysql_query("DELETE FROM option_type WHERE id='" . $_GET['id'] . "'");			
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=deleted";</script>';		
	$action="";
}  
if($action=='editnow'){
	$sql="UPDATE option_type set typename='".$_POST['typename']."', iscustom='".$_POST['iscustom']."' where ID='".$_POST['id']."'";
	mysql_query($sql)or die(mysql_error());
	echo '<script>window.location="index.php?section=' . $_GET['section'] . '&do=' . $_GET['do'] . '&st=updated";</script>';
	$action='';
}
if($action=='addcustomers'){
	$sql="insert into option_type (typename, iscustom) values('".$_POST['typename']."', '".$_POST['iscustom']."')";
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
                    <td width="480"><b>Title</b></td>
                    <td width="70"><b>Actions</b></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                   
<?php
	$sql = mysql_query("SELECT * FROM option_type ORDER BY id");
	while($row=mysql_fetch_assoc($sql)) {
		
	$row['name'] = str_replace('\\','',$row['name']);
	
	if($i%2) {
		$bgcolor="oddrow";
	} else {
		$bgcolor="evenrow";
	}	
	
	
		$editable = '<a href="?section='.$_GET['section'].'&do='.$_GET['do'].'&a=edit&id='.$row['id'].'"><img src="images/edit.png" title="Edit" alt="Edit" border="0"></a>';
	 	$recycle = '<a href="#" onclick="confirm_deleteShop('.$row['id'].');"><img src="images/delete.png" title="Recycle Bin" alt="Recycle Bin" border="0"></a>';
		
			
		
	

?>
				<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                    <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($row['typename'])); ?></td>
                    <td><?php echo $editable; ?>&nbsp;<?php echo $recycle; ?></td>
				</tr>
<?php $i++; } ?>
			</table>
<?php }
    ?>
<!-- <div id="listForm">-->
	<?php
    if ($action=="edit") {
		$sql="select * from option_type where id='".$_GET['id']."'";
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
				<td colspan="2" class="adminheader">Edit Option Type <?php echo $row['typename'];?></td>
			</tr>
			<tr>
				<td width="20%" class="admlsttxt">Type Name :</td>
				<td width="80%" class="admlsttxt">
                	<input class="formfields" name="typename" type="text" id="typename" value="<?php echo $row['typename'];?>" size="30"/>
				<span class="redtext">*</span></td>
			</tr>
			<tr>
				<td width="20%" class="admlsttxt">Custom Price:</td>
				<td width="80%" class="admlsttxt"><input type="checkbox" value="1" name="iscustom" id="iscustom" <?php echo ($row['iscustom']==1?'checked="checked"':'');?> /></td>
			</tr>
			<tr>
				<td class="admlsttxt">&nbsp;</td>
				<td class="admlsttxt"><input type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"name="Register" id="Register" value="Update Option Type" /></td>
			</tr>
		</table>
		</form>
		<!-- </div>-->
    <?php } ?>
	</div>
	<?php if($action=="add"){ ?>
        <form name="addcust" id="addcust"  method="post" onsubmit="return custValueValidate();">
        <input type="hidden" name="a" value="addcustomers" />
        <table width="650" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <td colspan="2" height="20">Add New Option Type </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr> 
            <tr>
                <td width="20%" class="admlsttxt">Type Name :</td>
                <td width="80%" class="admlsttxt"><input class="formfields" name="typename" type="text" id="typename" value="" size="30"/><span class="redtext">*</span></td>
            </tr>
			<tr>
				<td width="20%" class="admlsttxt">Custom Price:</td>
				<td width="80%" class="admlsttxt"><input type="checkbox" value="1" name="iscustom" id="iscustom" /></td>
			</tr>
            <tr>
                <td class="admlsttxt">&nbsp;</td>
                <td class="admlsttxt"><input type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'"name="Addcust" id="Addcust" value="Save Option Type" /></td>
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