<?php if($_GET['section'] != 'settings') { echo '<script>window.location="index.php";</script>'; } ?>
<?php	

	$_SESSION['MyIsLoggedInState'] = true;
	$_SESSION['imagemanager.MyRootPath'] = ADVT_SERVER;

	$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
	$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }

	foreach ($_POST as $key=>$value) { $_POST[$key] = mysql_real_escape_string($value); }
	foreach ($_GET as $key=>$value) { $_GET[$key] = mysql_real_escape_string($value); }
	
	if($_GET['do'] == "updated") {
		$successmessage = '<div id="messagebox" class="success">Your settings have been saved.</div></div>';	
	}
		
	if(isset($_POST['Submit'])) {
		while ($Value = current($_POST)) {
			mysql_query("Update settings set configvalue='".$Value."' where configname='".key($_POST)."'") or die(mysql_error());
			next($_POST);
		}
	} 
	$sqlsetting = "select * from settings";
	$ressetting = mysql_query($sqlsetting);
?>
<table align="center" width="650" border="0" cellpadding="0" cellspacing="0">  
    <tr>
        <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><?php echo $successmessage; ?></div></td>
    </tr>   
	<tr>
		<td valign="top">
<?php
// Home
	if ($action=="") {
?>
                    
			<form name="frmSettings" id="frmSettings" method="post" action="">
            <table width="710" border="0" cellpadding="3" cellspacing="0"> 
                <tr>
                	<td colspan="3" height="20"><strong>Website Settings</strong></td>
                </tr>
                <tr>
                    <td colspan="3"><hr></td>
                </tr>
                <?php
				while($rowsetting = mysql_fetch_array($ressetting)) {?>
                <tr>
                	<td height="25"><?php echo $rowsetting['configname'];?></td>
                	<td colspan="2">
                    <?php
					if($rowsetting['configname']=='SecureActive' || $rowsetting['configname']=='WebsiteActive'){
					?>
                    <select name="<?php echo $rowsetting['configname'];?>" id="<?php echo $rowsetting['configname'];?>">
                        <option value="Yes"  <?php echo ($rowsetting['configvalue']=='Yes'?'selected="selected"':'');?>>Yes</option>
                        <option value="No"  <?php echo ($rowsetting['configvalue']=='No'?'selected="selected"':'');?>>No</option>
                    </select>
					<?php
					}else{
					?>
                    <input type="text" name="<?php echo $rowsetting['configname'];?>" id="<?php echo $rowsetting['configname'];?>" size="50" value="<?php echo $rowsetting['configvalue'];?>" />
					<?php
					}
					?>
                    </td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="3"><hr></td>
                </tr>
                <tr>
                	<td colspan="3" align="center"><input type="hidden" name="Submit" id="Submit" value="Submit" /><input type="submit" name="submit" value="Update Settings" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
                </tr>
			</table>
			</form>
<?php } ?>            
        </td>
	</tr>
</table>