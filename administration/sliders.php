<?php if($_GET['section'] != 'sliders') { echo '<script>window.location="index.php";</script>'; } ?>
<?php	

	$_SESSION['MyIsLoggedInState'] = true;
	$_SESSION['imagemanager.MyRootPath'] = SLIDERS_SERVER;

	$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
	$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }

	foreach ($_POST as $key=>$value) { $_POST[$key] = mysql_real_escape_string($value); }
	foreach ($_GET as $key=>$value) { $_GET[$key] = mysql_real_escape_string($value); }
	
	if($_GET['do'] == "activated") {
		$successmessage = '<div id="messagebox" class="success">Your slider has been activated.</div></div>';	
	} else if($_GET['do'] == "deactivated") { 
		$successmessage = '<div id="messagebox" class="success">Your slider has been deactivated.</div>';			
	} else if($_GET['do'] == "deleted") { 
		$successmessage = '<div id="messagebox" class="success">Your slider has been deleted.</div>';			
	} else if($_GET['do'] == "updated") { 
		$successmessage = '<div id="messagebox" class="success">Your slider has been updated.</div>';			
	} else if($_GET['do'] == "created") { 
		$successmessage = '<div id="messagebox" class="success">Your slider has been created.</div>';			
	}
	
	if($action=='activate') {
		mysql_query("UPDATE sliders set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section='. $_GET['section'] .'&do=activated";</script>';
	}
	
	if($action=='deactivate') {
		mysql_query("UPDATE sliders set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());		
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deactivated";</script>';			
	}	
	
	if ($action=="delete") {
		mysql_query("DELETE FROM sliders WHERE id='" . $_GET['id'] . "' LIMIT 1");			
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deleted";</script>';			
		$action="";
	}  	

	if ($action=="editnow") {
		$edited = time();
		$sql="UPDATE sliders SET isactive = '{$_POST['isactive']}', imgpath = '{$_POST['imgpath']}', customlink = '{$_POST['customlink']}', edited = '{$edited}' WHERE id='{$_POST['sliderid']}' LIMIT 1";
		mysql_query($sql) or die(mysql_error().' '.$sql);
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=updated";</script>';	
		$action="";
	}
  
	if ($action=="addnow") {
		$created = time();		
		$sql="INSERT INTO sliders (`isactive`, `imgpath`,`customlink`, `created`) VALUES ('{$_POST['isactive']}', '{$_POST['imgpath']}', '{$_POST['customlink']}', '{$created}')";
		mysql_query($sql) or die(mysql_error().' '.$sql);			
		
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=created";</script>';
	  
		$action="";
	}  
	
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
            <table width="710" border="0" cellpadding="3" cellspacing="0"><tr><td>         
                <div style="float:left; width:710px;">
                	<div style="float:left; width:494px; padding:3px;"><b>Slider</b></div>
                    <div style="float:left; width:64px; padding:3px;"><b>Added</b></div>
                    <div style="float:left; width:64px; padding:3px;"><b>Updated</b></div>
                    <div style="float:left; width:64px; padding:3px;"><b>Actions</b></div>
                </div>
                <div style="float:left; width:710px;"><hr></div>
                    <div id="SortableList" style="float:left; width:710px;">
<?php
	$sql = mysql_query("SELECT * FROM sliders ORDER BY orderby");
	$i=0;
	while($row=mysql_fetch_assoc($sql)) {
	
	if($row['isactive']=='1') {
		$isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatus('.$row['id'].',0);" title="Deactivate Slider"><img src="images/deactivate.png" border="0" /></a>';
	} else {
		$isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatus('.$row['id'].',1);" title="Activate Slider"><img src="images/activate.png" border="0" /></a>';
	} 				
?>
				<div id="SortableList_<?php echo $row['id'];?>" class="normal" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="float:left;">
                    <div style="width:494px; float:left; padding:3px;"><img src="<?php echo $row['imgpath']; ?>" width="250" /></div>
                    <div style="width:64px; float:left;padding:3px;"><?php echo ($row['created']!=''?date('m/d/y', $row['created']):'n/a'); ?></div>
                    <div style="width:64px; float:left;padding:3px;"><?php echo ($row['edited']!=''?date('m/d/y', $row['edited']):'n/a'); ?></div>
					<div style="width:64px; float:left;padding:3px;" ><a href="?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>"><img src="images/edit.png" title="Edit" alt="Edit" border="0"></a><?php echo $isactivehtml; ?>&nbsp;<a href="#" onclick="confirm_delete('<?php echo $row['id']; ?>',0);"><img src="images/delete.png" title="Delete" alt="Delete" border="0"></a></div>
				</div>
<?php $i++; } ?>
</div>
</td></tr></table>
<?php } ?>
<?php
// Edit
	if ($action=="edit") {
		$sql = mysql_query("SELECT * FROM sliders WHERE id='{$id}' LIMIT 1");
		$row = mysql_fetch_assoc($sql);			
?>
            <form method="POST" name="sliders" id="sliders" enctype="multipart/form-data">
            <input type="hidden" name="a" value="editnow">
            <input type="hidden" name="sliderid" value="<?php echo $id; ?>">         
            <table width="650" border="0" cellpadding="3" cellspacing="0">      
            	<tr>
            		<td colspan="2" height="20">Editing Slider</td>
				</tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                
                <tr>
                	<td colspan="2">
                    	<table width="650" border="0" cellpadding="3" cellspacing="0">     
                        	<tr>
                            	<td>Active</td>
                                <td><select name="isactive" />
                                    <option value="1"<?php echo ($row['isactive']=="1"?" selected":""); ?>>Yes</option>
                                    <option value="0"<?php echo ($row['isactive']=="0"?" selected":""); ?> >No</option>			
                                </select></td>
                            </tr> 	                           
                            <tr height="125">
                                <td width="125">Slider Image:</td>
                                <td>
									<div class="field" id="imgupload" style="margin:15px 0;" >
									<?php 
									if($row['imgpath']!='') {
									?>
									<img src="<?php echo $row['imgpath'];?>" border="0" height="90" id=""  />
									<?php
									}
									?>
									</div>
									<div id="title" class="block Posttext margin-l"  style="float:left;">
									<div class="field" style="float:left;" >
									<input type="hidden" id="imgpath" name="imgpath" value="<?php echo $row['imgpath'];?>" />
									<input type="file" name="file_upload" id="file_upload" size="1"/> 
									</div>
									</div>
								</td>
                            </tr>
                            <tr>
                                <td>Hyperlink:</td>
                                <td><input type="text" name="customlink" id="customlink" value="<?php echo $row['customlink']; ?>" size="30"  /></td>
                            </tr>                       
						</table>
					</td>
				</tr>
                <tr>
                	<td colspan="2"><input type="submit" value="Update this Slider" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
			</table>
            </form>
<?php } ?>
<?php
// Add
	if ($action=="add") {
?>
            <form method="POST" name="sliders" id="sliders" enctype="multipart/form-data">
            <input type="hidden" name="a" value="addnow">
            <table width="650" border="0" cellpadding="3" cellspacing="0">
            	<tr>
            		<td colspan="2" height="20">Adding Slider</td>
				</tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                
                <tr>
                	<td colspan="2">
                    	<table width="100%" border="0">	
                            <tr>
                              <td>Active:</td>
                              <td><select name="isactive" />
                                    <option value="1" selected="selected">Yes</option>
                                    <option value="0">No</option>			
                                </select></td>
                            </tr>                                                      
                            <tr height="125">
                                <td width="125">Slider Image:</td>
                                <td>
									<div class="field" id="imgupload" style="margin-bottom:15px;" >
									</div>
									<div id="title" class="block Posttext margin-l"  style="float:left;">
									<div class="field" style="float:left;" >
									<input type="hidden" id="imgpath" name="imgpath" value="" />
									<input type="file" name="file_upload" id="file_upload" size="1"/> 
									</div>
									</div>
								</td>
                            </tr>      
                            <tr>
                                <td>Hyperlink:</td>
                                <td><input type="text" name="customlink" id="customlink" value="" size="30"  /></td>
                            </tr>                                                                             
						</table>
					</td>
				</tr>
                <tr>
                	<td colspan="2"><input type="submit" value="Add new Slider" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
			</table>            
            </form>
<?php } ?>            
        </td>
	</tr>
</table>
<div id="info"> </div>