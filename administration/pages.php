<?php if($_GET['section'] != 'pages') { echo '<script>window.location="index.php";</script>'; } ?>
<?php	

	$_SESSION['MyIsLoggedInState'] = true;
	$_SESSION['imagemanager.MyRootPath'] = PAGES_SERVER;
	$_SESSION['filemanager.MyRootPath'] = PAGES_FM_SERVER;
	
	$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
	$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }


	
	if($_GET['do'] == "activated") {
		$successmessage = '<div id="messagebox" class="success">Your page has been activated.</div></div>';	
	} else if($_GET['do'] == "deactivated") { 
		$successmessage = '<div id="messagebox" class="success">Your page has been deactivated.</div>';			
	} else if($_GET['do'] == "recycled") { 
		$successmessage = '<div id="messagebox" class="success">Your page has been moved to the recycle bin.</div>';			
	} else if($_GET['do'] == "created") { 
		$successmessage = '<div id="messagebox" class="success">Your page has been created.</div>';			
	} else if($_GET['do'] == "updated") { 
		$successmessage = '<div id="messagebox" class="success">Your page has been updated.</div>';			
	}	
	
	if($action=='activate') {
		mysql_query("UPDATE pages set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section='. $_GET['section'] .'&do=activated";</script>';
	}
	
	if($action=='deactivate') {
		mysql_query("UPDATE pages set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());	
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deactivated";</script>';			
	}	
	
	if ($action=="delete") {
		mysql_query("delete from pages where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deleted";</script>';		
	}
	
	if ($action=="editnow") {
		$id = $_POST['pageid'];
		$name = mysql_real_escape_string($_POST['name']);
		$name = stripslashes(ucfirst($name));		
		$headertitle = mysql_real_escape_string($_POST['headertitle']);
		$headertitle = ucfirst($headertitle);
		$metakeywords = mysql_real_escape_string($_POST['metakeywords']);
		$metadescription = mysql_real_escape_string($_POST['metadescription']);
		
		$content = mysql_real_escape_string($_POST['content']);
		$created = time();
		$edited = time();  
		$created = time();
		$isactive = $_POST['isactive'];

		mysql_query("UPDATE pages SET headertitle = '{$headertitle}', metakeywords = '{$metakeywords}', metadescription = '{$metadescription}', name = '{$name}', content = '{$content}', isactive = '{$isactive}' WHERE id='{$id}' LIMIT 1") or die(mysql_error());					
		
		
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=updated";</script>';		

		$action="";
		
	}
  
	if ($action=="addnow") {
		$id = $_POST['id'];
		$name = str_replace("'","\'",$_POST['name']);
		$name = stripslashes(ucfirst($name));		
		$headertitle = str_replace("'","\'",$_POST['headertitle']);
		$headertitle = stripslashes(ucfirst($headertitle));
		$metakeywords = str_replace("'","\'",$_POST['metakeywords']);
		$metakeywords = stripslashes($metakeywords);
		$metadescription = str_replace("'","\'",$_POST['metadescription']);
		$metadescription = stripslashes($metadescription);
		
		$content = mysql_real_escape_string($_POST['content']);
		$created = time();
		$edited = time();  
		$created = time();
		$isactive = $_POST['isactive'];
		mysql_query("INSERT INTO pages (`headertitle`, `metakeywords`, `metadescription`, `name`, `content`, `created`, `isactive`) VALUES('{$headertitle}', '{$metakeywords}', '{$metadescription}', '{$name}',  '{$content}', '{$created}', '{$isactive}')") or die(mysql_error());	
		
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
            <table width="710" border="0" cellpadding="3" cellspacing="0">
                <tr>
                    <td width="480"><b>Page Title</b></td>
                    <td width="70"><b>Actions</b></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                   
<?php
	$sql = mysql_query("SELECT * FROM pages");
	while($row=mysql_fetch_assoc($sql)) {
		
	$row['name'] = str_replace('\\','',$row['name']);
	
	if($i%2) {
		$bgcolor="oddrow";
	} else {
		$bgcolor="evenrow";
	}	
	
	
		$editable = '<a href="?section='.$_GET['section'].'&a=edit&id='.$row['id'].'"><img src="images/edit.png" title="Edit" alt="Edit" border="0"></a>';
	 
		
			$recycle = '<a href="#" onclick="confirm_delete('.$row['id'].');"><img src="images/delete.png" title="Recycle Bin" alt="Recycle Bin" border="0"></a>';
		
		
		if($row['isactive']=='1') {
			$isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatus('.$row['id'].',0);" title="Deactivate Page"><img src="images/deactivate.png" border="0" /></a>';
		} else {
			$isactivehtml = '&nbsp;<a href="#" onclick="ChangeStatus('.$row['id'].',1);" title="Activate Page"><img src="images/activate.png" border="0" /></a>';
		} 		
		
	

?>
				<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                    <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($row['headertitle'])); ?></td>
                    <td><?php echo $editable; ?><?php echo $isactivehtml; ?>&nbsp;<?php echo $recycle; ?></td>
				</tr>
<?php $i++; } ?>
			</table>
<?php } ?>
<?php
// Edit
	if ($action=="edit") {
		$sql = mysql_query("SELECT * FROM pages WHERE id='{$id}' LIMIT 1");
		
		$row = mysql_fetch_assoc($sql);
		$row['content'] = str_replace("\\","",$row['content']);

?>
            <form method="POST" name="pages" id="pages" enctype="multipart/form-data" />
            <input type="hidden" name="a" value="editnow" />
            <input type="hidden" name="pageid" value="<?php echo $id; ?>" />
          <table width="650" border="0" cellpadding="3" cellspacing="0" >      
            	<tr>
					<td colspan="2" width="650" height="20" align="left">Editing Page:</b>&nbsp;<?php echo $row['name']; ?></td>
				</tr>  
            	<tr>
					<td colspan="2"><hr /></td>
				</tr>  
                <?php if($row['id'] != 64) { ?>                        
            	<tr>
                	<td width="650"><?php DispTip('active'); ?>Active:</td>
                    <td><select name="isactive" />
                        <option value="0"<?php echo ($row['isactive']=="0"?" selected":""); ?>>No</option>
                        <option value="1"<?php echo ($row['isactive']=="1"?" selected":""); ?>>Yes</option>			
                    </select></td>
                </tr>
                <?php } ?>
                <tr>
                    <td width="650"><?php DispTip('pagename'); ?>Page Title:</td>
                    <td><input type="text" size="45" name="name" id="name" value="<?php echo stripslashes($row['name']); ?>" /></td>
                </tr>
                <tr>
                    <td width="650"><?php DispTip('pagetitle'); ?>Browser Title:</td>
                    <td><input type="text" size="45" name="headertitle" id="headertitle" value="<?php echo stripslashes($row['headertitle']); ?>" /></td>
                </tr>
                <tr>
                  <td><?php DispTip('metakeywords'); ?>Meta Keywords:</td>
                  <td><input type="text" size="45" name="metakeywords" value="<?php echo stripslashes($row['metakeywords']); ?>" /></td>
                </tr>
                <tr>
                  <td><?php DispTip('metadescription'); ?>Meta Description:</td>
                  <td><input type="text" size="45" name="metadescription" value="<?php echo stripslashes($row['metadescription']); ?>" /></td>
                </tr> 
            </table>
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
            	<tr>
 					<td valign="top"><textarea id="content" name="content" rows="10" cols="80"><?php echo $row['content']; ?></textarea></td>
				</tr>
				<tr>
                	<td><input type="submit" class="btn" value="Publish Changes" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
		  </table>
            </form>
<?php } ?>
<?php
// Add
	if ($action=="add") {
?>
            <form method="POST" name="pages" id="pages" enctype="multipart/form-data" />
            <input type="hidden" name="a" value="addnow" />
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
            	<tr>
					<td colspan="2" height="20">New Page</td>
                </tr>              
            	<tr>
					<td colspan="2"><hr /></td>
				</tr>                          
            	<tr>
                	<td width="125"><?php DispTip('active'); ?>Active:</td>
                    <td width="525"><select name="isactive" />
                        <option value="0">No</option>
                        <option value="1">Yes</option>			
                    </select></td>
                </tr>                                
                <tr>
                    <td><?php DispTip('pagename'); ?>Page Title:</td>
                    <td><input type="text" size="45" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td><?php DispTip('pagetitle'); ?>Browser Title:</td>
                    <td><input type="text" size="45" name="headertitle" id="headertitle" /></td>
                </tr>
                <tr>
                	<td><?php DispTip('metakeywords'); ?>Meta Keywords:</td>
                	<td><input type="text" size="45" name="metakeywords" id="metakeywords" /></td>
                </tr>
                <tr>
                	<td><?php DispTip('metadescription'); ?>Meta Description:</td>
                	<td><input type="text" size="45" name="metadescription" id="metadescription" /></td>
                </tr>  
            </table>

            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
            	<tr>
 					<td valign="top"><textarea name="content" rows="25" cols="72" /></textarea></td>
				</tr>
				<tr>
                	<td><input type="submit" class="btn" value="Add new page" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
			</table>
            </form>
<?php } ?>            
        </td>
	</tr>
</table>