<?php if($_GET['section'] != 'category') { echo '<script>window.location="index.php";</script>'; }
	$_SESSION['MyIsLoggedInState'] = true;
	$_SESSION['imagemanager.MyRootPath'] = PAGES_SERVER;
	$_SESSION['filemanager.MyRootPath'] = PAGES_FM_SERVER;
	
	$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
	$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }
	foreach ($_POST as $key=>$value) { 
		if(!is_array($_POST[$key])) $_POST[$key] = mysql_real_escape_string($value); 
	}
	foreach ($_GET as $key=>$value) { $_GET[$key] = mysql_real_escape_string($value); }

	
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
		mysql_query("UPDATE category set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section='. $_GET['section'] .'&do=activated";</script>';
	}
	
	if($action=='deactivate') {
		mysql_query("UPDATE category set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());	
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deactivated";</script>';			
	}	
	
	if ($action=="delete") {
		mysql_query("delete from category where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deleted";</script>';		
	}
	
	if ($action=="editnow") {
		$id = $_POST['catid'];
		$title = $_POST['title'];
		$prod_title = ($_POST['prod_title']!=''?$_POST['prod_title']:$_POST['title']);
		$adsnl_image = $_POST['adsnl_image'];
		$main_image = $_POST['main_image'];
		$keyfeature = $_POST['keyfeature'];
		$learnmore_top = $_POST['learnmore_top'];
		$learnmore_bottom = $_POST['learnmore_bottom'];		
		$isactive = $_POST['isactive'];
		$iscustom = $_POST['iscustom'];
		$metatitle = $_POST['metatitle'];
		$metakeywords = $_POST['metakeywords'];
		$metadescriprtion = $_POST['metadescriprtion'];
		
		
		mysql_query("UPDATE category SET title = '{$title}', prod_title = '{$prod_title}', adsnl_image = '{$_POST['adsnl_image']}', main_image = '{$main_image}', keyfeature = '{$keyfeature}', learnmore_top = '{$learnmore_top}', learnmore_bottom = '{$learnmore_bottom}',metatitle = '{$metatitle}', metakeywords = '{$metakeywords}', metadescriprtion = '{$metadescriprtion}', iscustom = '{$iscustom}', isactive = '{$isactive}' WHERE id='{$id}' LIMIT 1") or die(mysql_error());
		
		
		$sql="delete from category_options where cat_id='".$id."'";
		mysql_query($sql);
		if($_POST['OptVal']){
			foreach($_POST['OptVal'] as $OptVal){
				$sql="insert into category_options (option_value_id,cat_id) values('".$OptVal."', '".$id."')";
				mysql_query($sql)or die(mysql_error());
			}
		}
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=updated";</script>';
		$action="";
	}
	if ($action=="addnow") {
		$title = $_POST['title'];
		$prod_title = ($_POST['prod_title']!=''?$_POST['prod_title']:$_POST['title']);
		$adsnl_image = $_POST['adsnl_image'];
		$main_image = $_POST['main_image'];
		$keyfeature = $_POST['keyfeature'];
		$learnmore_top = $_POST['learnmore_top'];
		$learnmore_bottom = $_POST['learnmore_bottom'];
		$isactive = $_POST['isactive'];
		$iscustom = $_POST['iscustom'];
		$isactive = $_POST['isactive'];
		$metatitle = $_POST['metatitle'];
		$metakeywords = $_POST['metakeywords'];
		$metadescriprtion = $_POST['metadescriprtion'];
		
		mysql_query("INSERT INTO category (`title`, `prod_title`, `adsnl_image`, `main_image`, `keyfeature`, `learnmore_top`, `learnmore_bottom`, `metatitle`, `metakeywords`, `metadescriprtion`, `iscustom`, `isactive`) VALUES('{$title}', '{$prod_title}', '{$_POST['adsnl_image']}', '{$main_image}',  '{$keyfeature}', '{$learnmore_top}', '{$learnmore_bottom}', '{$metatitle}', '{$metakeywords}', '{$metadescriprtion}', '{$iscustom}', '{$isactive}')") or die(mysql_error());	
		$catid=mysql_insert_id();
		if($_POST['OptVal']){
			foreach($_POST['OptVal'] as $OptVal){
				$sql="insert into category_options (option_value_id,cat_id) values('".$OptVal."', '".$catid."')";
				mysql_query($sql)or die(mysql_error());
			}
		}
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
                    <td width="480"><b>Title</b></td>
                    <td width="70"><b>Actions</b></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                   
<?php
	$sql = mysql_query("SELECT * FROM category");
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
                    <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($row['title'])); ?></td>
                    <td><?php echo $editable; ?><?php echo $isactivehtml; ?>&nbsp;<?php echo $recycle; ?></td>
				</tr>
<?php $i++; } ?>
			</table>
<?php } ?>
<?php
// Edit
	if ($action=="edit") {
		$sql = mysql_query("SELECT * FROM category WHERE id='{$id}' LIMIT 1");
		
		$row = mysql_fetch_assoc($sql);
		$row['content'] = str_replace("\\","",$row['content']);

?>
            <form method="POST" name="category" id="category" enctype="multipart/form-data">
            <input type="hidden" name="a" value="editnow" />
            <input type="hidden" name="catid" value="<?php echo $id; ?>" />
          <table width="650" border="0" cellpadding="3" cellspacing="0" >      
            	<tr>
					<td colspan="2" width="650" height="20" align="left">Editing Category:</b>&nbsp;<?php echo $row['name']; ?></td>
				</tr>  
            	<tr>
					<td colspan="2"><hr /></td>
				</tr>  
            	<tr>
                	<td width="650">Active:</td>
                    <td><select name="isactive" />
                        <option value="0"<?php echo ($row['isactive']=="0"?" selected":""); ?>>No</option>
                        <option value="1"<?php echo ($row['isactive']=="1"?" selected":""); ?>>Yes</option>			
                    </select></td>
                </tr>
                <tr>
                    <td>Category Title:</td>
                    <td><input type="text" size="45" name="title" id="title" value="<?php echo stripslashes($row['title']); ?>" /></td>
                </tr>
                <tr>
                    <td>Product Title:</td>
                    <td><input type="text" size="45" name="prod_title" id="prod_title" value="<?php echo stripslashes($row['prod_title']); ?>" /></td>
                </tr>
                <tr>
                    <td valign="top">Sample Images:</td>
                   <td width="525">             
                        <br />
                        <input id="main_image" type="hidden" value="<?php echo $row['main_image'];?>" name="main_image">
                        <input id="adsnl_image" type="hidden" value="<?php echo $row['adsnl_image'];?>" name="adsnl_image">
                        <input id="addimg" class="btn" type="button" onClick="javascript:openDialogue();" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" value="Add Pictures" name="addimg">
                        <table id="files" width="100%;"><tr>
                        <td align="center">
                        <?php //get all images name
                        $totimages=explode(',',$row['adsnl_image']);
                        if(!empty($totimages)) {
                        foreach($totimages as $oneimg) {
                        if($oneimg!='') {
                        ?>
                        <div class="block" style="padding-right:5px;" id="<?php echo $oneimg;?>"><img src="<?php echo IMG_PATH;?>products/<?php echo $oneimg;?>" height="100" border="0"><div>
                        <input type="radio" name="primages[]" id="primages[]" value="<?php echo $oneimg;?>" onClick="javascript:setMainImage(this.value);" <?php echo ($oneimg==$row['main_image']?'checked':'');?>>Default &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onClick="javascript:removeImage('<?php echo $oneimg;?>');"><img src="images/trash.png" border="0" /></a></div>
                        </div>
                        <?php } } }?>
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td valign="top">Key Feature:</td>
 					<td valign="top"><textarea name="keyfeature" id="keyfeature" rows="6" cols="60"><?php echo stripslashes($row['keyfeature']); ?></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Learn More Top:</td>
 					<td valign="top"><textarea name="learnmore_top" id="learnmore_top" rows="6" cols="60"><?php echo stripslashes($row['learnmore_top']); ?></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Learn More Bottom:</td>
 					<td valign="top"><textarea name="learnmore_bottom" id="learnmore_bottom" rows="6" cols="60"><?php echo stripslashes($row['learnmore_bottom']); ?></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Title:</td>
 					<td valign="top"><textarea name="metatitle" id="metatitle" rows="6" cols="60"><?php echo stripslashes($row['metatitle']); ?></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Keywords:</td>
 					<td valign="top"><textarea name="metakeywords" id="metakeywords" rows="6" cols="60"><?php echo stripslashes($row['metakeywords']); ?></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Descriprtion:</td>
 					<td valign="top"><textarea name="metadescriprtion" id="metadescriprtion" rows="6" cols="60"><?php echo stripslashes($row['metadescriprtion']); ?></textarea></td>
                </tr>
            	<tr>
                	<td width="125">Custom:</td>
                    <td width="525"><select name="iscustom" />
                        <option value="0"<?php echo ($row['iscustom']=="0"?" selected":""); ?>>No</option>
                        <option value="1"<?php echo ($row['iscustom']=="1"?" selected":""); ?>>Yes</option>			
                    </select></td>
                </tr>
                <tr>
                  <td valign="top">Variants:</td>
                  <td width="525">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <?php
                        $catsql1 = mysql_query("SELECT * FROM option_type");
                        while($catrow1 = mysql_fetch_assoc($catsql1)) {
							$optsql=mysql_query("SELECT * FROM category_options where cat_id=".$row['id']."");
							$selectedoption=array();
							while($optrow = mysql_fetch_assoc($optsql)) {
								$selectedoption[]=$optrow['option_value_id'];
							}
								
                            $values='';
                            $sqlval = mysql_query("SELECT * FROM option_values where type_id=".$catrow1['id']."");
                            $i=0;
                            if(mysql_num_rows($sqlval)){
                                echo '<tr><td><fieldset><legend>'.$catrow1['typename'].'</legend>';
                                while($rowval = mysql_fetch_assoc($sqlval)) {
                                    echo '<span style=" float:left;width:160px;"><span><input type="checkbox" name="OptVal[]" id="OptVal_'.$rowval['id'].'" value="'.$rowval['id'].'" '.(in_array($rowval['id'],$selectedoption)?'checked="checked"':'').' /></span>';
                                    echo '<span>'.$rowval['name'].'</span></span>';
                                    $values .='|'.$rowval['id'];
                                    if($i==2){
                                        echo '<br>';
                                        $i=0;
                                    }else{
                                        $i++;
                                    }
                                }
                                echo '<input type="hidden" name="option_value_id_'.$catrow1['id'].'" id="option_value_id_'.$catrow1['id'].'" value="'.$catrow1['id'].'" />';
                                echo '</fieldset></td></tr>';
                            }
                        }
                        ?>
                    </table>
                  </td>
                </tr>

            </table>
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
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
            <form method="POST" name="category" id="category" enctype="multipart/form-data">
            <input type="hidden" name="a" value="addnow" />
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
            	<tr>
					<td colspan="2" height="20">New Category</td>
                </tr>              
            	<tr>
					<td colspan="2"><hr /></td>
				</tr>                          
            	<tr>
                	<td width="125">Active:</td>
                    <td width="525"><select name="isactive" />
                        <option value="0">No</option>
                        <option value="1">Yes</option>			
                    </select></td>
                </tr>                                
                <tr>
                    <td>Category Title:</td>
                    <td><input type="text" size="45" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td>Product Title:</td>
                    <td><input type="text" size="45" name="prod_title" id="prod_title" /></td>
                </tr>
                <tr>
                    <td>Sample Images:</td>
                    <td>
                        <br />
                        <input id="adsnl_image" type="hidden" value="" name="adsnl_image">
                        <input id="main_image" type="hidden" value="" name="main_image">
                        <input id="addimg" class="btn" type="button" onClick="javascript:openDialogue();" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" value="Add Pictures" name="addimg">
                        <table id="files"><tr>
                        <td></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Key Feature:</td>
 					<td valign="top"><textarea name="keyfeature" id="keyfeature" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Learn More Top:</td>
 					<td valign="top"><textarea name="learnmore_top" id="learnmore_top" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Learn More Bottom:</td>
 					<td valign="top"><textarea name="learnmore_bottom" id="learnmore_bottom" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Title:</td>
 					<td valign="top"><textarea name="metatitle" id="metatitle"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Keywords:</td>
 					<td valign="top"><textarea name="metakeywords" id="metakeywords"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Descriprtion:</td>
 					<td valign="top"><textarea name="metadescriprtion" id="metadescriprtion"></textarea></td>
                </tr>
            	<tr>
                	<td width="125">Custom:</td>
                    <td width="525"><select name="iscustom" />
                        <option value="0">No</option>
                        <option value="1">Yes</option>			
                    </select></td>
                </tr>
			  <tr>
              <td valign="top">Variants:</td>
              <td width="525">
              	<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<?php
                    $catsql1 = mysql_query("SELECT * FROM option_type");
                    while($catrow1 = mysql_fetch_assoc($catsql1)) {
						$values='';
						$sqlval = mysql_query("SELECT * FROM option_values where type_id=".$catrow1['id']."");
						$i=0;
						if(mysql_num_rows($sqlval)){
							echo '<tr><td><fieldset><legend>'.$catrow1['typename'].'</legend>';
							while($rowval = mysql_fetch_assoc($sqlval)) {
								echo '<span style=" float:left;width:160px;"><span><input type="checkbox" name="OptVal[]" id="OptVal_'.$rowval['id'].'" value="'.$rowval['id'].'" /></span>';
								echo '<span>'.$rowval['name'].'</span></span>';
								$values .='|'.$rowval['id'];
								if($i==2){
									echo '<br>';
									$i=0;
								}else{
									$i++;
								}
							}
							echo '<input type="hidden" name="option_value_id_'.$catrow1['id'].'" id="option_value_id_'.$catrow1['id'].'" value="'.$catrow1['id'].'" />';
							echo '</fieldset></td></tr>';
						}
					}
					?>
              	</table>
              </td>
            </tr>
            </table>
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
				<tr>
                	<td><input type="submit" class="btn" value="Add new page" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
			</table>
            </form>
<?php } ?>            
        </td>
	</tr>
</table>
<div id="info"> </div>
<script>
function removeImage(rmvimage){
	var adsnlimages=document.getElementById('adsnl_image').value;
	var removeImage=false;
	if(window.XMLHttpRequest){
		removeImage=new XMLHttpRequest();
	}else if(window.ActiveXObject){
		removeImage=new ActiveXObject("Microsoft.XMLHTTP");	
	}
	
	if(removeImage){
		var link_to_open="img_ajax.php?imagename="+rmvimage+"&adsnlimg="+adsnlimages;
		removeImage.open("GET", link_to_open);
		removeImage.onreadystatechange=function(){ 
			if(removeImage.readyState==4 && removeImage.status==200){
				document.getElementById(rmvimage).innerHTML='';
			data=removeImage.responseText;
			temp=data.split('~');
			document.getElementById('adsnl_image').value=temp[0];
			if(temp[1]!=''){
				alert(temp[1]);
			}
			}
		}
		removeImage.send(null);
	}
}
 function setMainImage(mainImage){
	 document.getElementById('main_image').value=mainImage;
 }
 function openDialogue(){
	 Shadowbox.open({
        content:    'multimg.php',
        player:     "iframe",
        title:      "Project Image Upload",
        height:     220,
        width:      400
    }); 
 }
</script>