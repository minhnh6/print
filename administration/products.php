<?php if($_GET['section'] != 'products') { echo '<script>window.location="index.php";</script>';}
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
		mysql_query("UPDATE products set isactive='1' where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section='. $_GET['section'] .'&do=activated";</script>';
	}

	if($action=='deactivate') {
		mysql_query("UPDATE products set isactive='0' where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deactivated";</script>';
	}

	if ($action=="delete") {
		mysql_query("DELETE FROM custom_value WHERE productid = '".$_GET['id']."'") or die(mysql_error());
		mysql_query("delete from products where id='" . $_GET['id'] . "'") or die(mysql_error());
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=deleted";</script>';
	}

	if ($action=="editnow") {
		$id = $_POST['proid'];
		$ptitle = $_POST['ptitle'];
		$cat_id = $_POST['cat_id'];
		$iscustom = $_POST['iscustom'];
		$isseo = $_POST['isseo'];
		$keyfeature = $_POST['keyfeature'];
		$learnmore_top = $_POST['learnmore_top'];
		$learnmore_bottom = $_POST['learnmore_bottom'];
		$main_image = $_POST['imgpath'];
		$cat_img = $_POST['cat_imgpath'];
		$baseprice = $_POST['baseprice'];
		$isactive = $_POST['isactive'];
		$metatitle = $_POST['metatitle'];
		$metakeywords = $_POST['metakeywords'];
		$metadescriprtion = $_POST['metadescriprtion'];
		mysql_query("UPDATE products SET ptitle = '{$ptitle}', cat_id = '{$cat_id}', baseprice = '{$baseprice}',cat_img = '{$cat_img}',main_image = '{$main_image}', keyfeature = '{$keyfeature}', learnmore_top = '{$learnmore_top}', learnmore_bottom = '{$learnmore_bottom}', metatitle = '{$metatitle}', metakeywords = '{$metakeywords}', metadescriprtion = '{$metadescriprtion}', iscustom = '{$iscustom}', isactive = '{$isactive}', isseo='{$isseo}' WHERE id='{$id}' LIMIT 1") or die(mysql_error());
		
		mysql_query("DELETE FROM custom_value WHERE productid = '".$id."'") or die(mysql_error());

		if($_POST['opttype']){
			foreach($_POST['opttype'] as $opttype){
				mysql_query("INSERT INTO custom_value (`optcombiid`, `price`, `productid`) VALUES('".$opttype."', '".$_POST['optval_'.$opttype]."', '".$id."')") or die(mysql_error());
			}
		}
		echo '<script>window.location="?section=' . $_GET['section'] . '&do=updated";</script>';
		$action="";
	}
	if ($action=="addnow") {
		$ptitle = $_POST['ptitle'];
		$cat_id = $_POST['cat_id'];
		$iscustom = $_POST['iscustom'];
		$isseo = $_POST['isseo'];
		$keyfeature = $_POST['keyfeature'];
		$learnmore_top = $_POST['learnmore_top'];
		$learnmore_bottom = $_POST['learnmore_bottom'];
		$main_image = $_POST['imgpath'];
		$cat_img = $_POST['cat_imgpath'];
		$baseprice = $_POST['baseprice'];
		$isactive = $_POST['isactive'];
		$isactive = $_POST['isactive'];
		$metatitle = $_POST['metatitle'];
		$metakeywords = $_POST['metakeywords'];
		$metadescriprtion = $_POST['metadescriprtion'];
		mysql_query("INSERT INTO products (`ptitle`, `cat_id`, `iscustom`, `keyfeature`, `learnmore_top`, `learnmore_bottom`, `cat_img`, `main_image`, `baseprice`, `metatitle`, `metakeywords`, `metadescriprtion`,`isactive`,`isseo`) VALUES('{$ptitle}', '{$cat_id}', '{$iscustom}', '{$keyfeature}',  '{$learnmore_top}', '{$learnmore_bottom}', '{$cat_img}', '{$main_image}', '{$baseprice}', '{$metatitle}', '{$metakeywords}', '{$metadescriprtion}', '{$isactive}','{$isseo}' )") or die(mysql_error());
		$productid=mysql_insert_id();

		if($_POST['opttype']){
			foreach($_POST['opttype'] as $opttype){
						mysql_query("INSERT INTO custom_value (`optcombiid`, `price`, `productid`) VALUES('".$opttype."', '".$_POST['optval_'.$opttype]."', '".$productid."')") or die(mysql_error());
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
<?php if ($action=="") { ?>
            <table width="710" border="0" cellpadding="3" cellspacing="0">
                <tr>
                    <td width="480"><b>Page Title</b></td>
                    <td width="70"><b>Actions</b></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>                   
<?php 
	$sql = mysql_query("SELECT * FROM products");
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
		}?>
            <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                <td onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=edit&id=<?php echo $row['id']; ?>')"><?php echo stripslashes(ucfirst($row['ptitle'])); ?></td>
                <td><?php echo $editable; ?><?php echo $isactivehtml; ?>&nbsp;<?php echo $recycle; ?></td>
            </tr>
<?php $i++; } ?>
        </table>
<?php }
	if ($action=="edit") {
		$sql = mysql_query("SELECT * FROM products WHERE id='{$id}' LIMIT 1");
		$row = mysql_fetch_assoc($sql);
		$row['content'] = str_replace("\\","",$row['content']);
?>
            <form method="POST" name="products" id="products" enctype="multipart/form-data" />
            <input type="hidden" name="a" value="editnow" />
            <input type="hidden" name="proid" value="<?php echo $id; ?>" />
			<table width="650" border="0" cellpadding="3" cellspacing="0" >      
				<tr>
					<td colspan="2" width="650" height="20" align="left">Editing Product:</b>&nbsp;<?php echo $row['name']; ?></td>
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
                  <td>SEO Product</td>
                  <td><select name="isseo" id="isseo" onchange="javascript:GetCustomVal('<?php echo $id; ?>');">
                        <option value="0"<?php echo ($row['isseo']=="0"?" selected":""); ?>>No</option>
                        <option value="1"<?php echo ($row['isseo']=="1"?" selected":""); ?>>Yes</option>			
                    </select></td>
                </tr>
                <tr>
                    <td>Product Title:</td>
                    <td><input type="text" size="45" name="ptitle" id="ptitle" value="<?php echo stripslashes($row['ptitle']); ?>" /></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="cat_id" id="cat_id" style="width:331px" onchange="javascript:GetCustomVal('<?php echo $id; ?>');">
                        	<option value="0">Select</option>
	                        <?php
    	                    $catsql = mysql_query("SELECT * FROM category");
        	                while($catrow = mysql_fetch_assoc($catsql)){
            	        	    echo "<option value=\"".$catrow['id']."\"";
                	        	if($row['cat_id'] == $catrow['id'])
		                    	    echo " selected=\"selected\" ";
        		                echo ">".$catrow['title']."</option>";
                	        }
                    	    ?>
                        </select>
					</td>
                </tr>
                
                
                <tr>
                    <td colspan="2" id="CustomVal">
					<?php if($row['isseo']=="0"){?>
                    <?php
					function OptName($tid) {
						$sqlname="select ov.name, ot.typename from option_values ov inner join option_type ot on ov.type_id=ot.id where ov.id='".$tid."'";
						$resname=mysql_query($sqlname);
						$rowname=mysql_fetch_assoc($resname);
						return $rowname['typename'].': '.$rowname['name'];
					}
					function GetOptPrice($optid, $pid) {
						$sqloptval="SELECT price FROM custom_value WHERE optcombiid = '".$optid."' AND productid='".$pid."'";
						$resoptval=mysql_query($sqloptval);
						if(mysql_num_rows($resoptval)) {
							$rowoptval=mysql_fetch_assoc($resoptval);
							$price= $rowoptval['price'];
						} else {
							$price =0;
						}
						return $price;
					}
					
					$optype=array();
					$opvals=array();
					$sqlopttype="SELECT opttype.id FROM option_values as opt inner join option_type as opttype on opt.type_id=opttype.id inner join category_options as cattype on cattype.option_value_id=opt.id WHERE cattype.cat_id='".$row['cat_id']."' AND opttype.iscustom=1 group by opttype.id";
					$resopttype=mysql_query($sqlopttype);
					if(mysql_num_rows($resopttype)) {
						while($rowopttype=mysql_fetch_array($resopttype)) {
							$optype[]=$rowopttype['id'];
							$sqlov="SELECT opt.id FROM option_values as opt inner join option_type as opttype on opt.type_id=opttype.id inner join category_options as cattype on cattype.option_value_id=opt.id WHERE cattype.cat_id='".$row['cat_id']."' AND opttype.iscustom=1 and opttype.id='".$rowopttype['id']."' order by opt.id";
							$resov=mysql_query($sqlov);
							while($rowov=mysql_fetch_array($resov)) {
								$opvals[$rowopttype['id']][]=$rowov['id'];
							}
							
						}
					}
					if(count($opvals)) {
					echo '<table width="100%" cellpadding="3" cellspacing="2" style="background-color:#FAFAFA; border:1px solid #CCC;"><tr><td><strong>Custom Options</strong></td><td>&nbsp;</td></tr>';
					foreach($opvals[$optype[0]] as $opval) {
						if(count($optype)>=2) {
							foreach($opvals[$optype[1]] as $opval1) {
								if(count($optype)>=3) {
									foreach($opvals[$optype[2]] as $opval2) {
										if(count($optype)>=4) {
											foreach($opvals[$optype[3]] as $opval3) {
												echo '<tr><td>'.OptName($opval).' | '.OptName($opval1).' | '.OptName($opval2).' | '.OptName($opval3).'</td><td><input type="text" name="optval_'.$opval.'|'.$opval1.'|'.$opval2.'|'.$opval3.'" id="optval_'.$opval.$opval1.$opval2.$opval3.'" value="'.GetOptPrice($opval.'|'.$opval1.'|'.$opval2.'|'.$opval3, $id).'"><input type="hidden" name="opttype[]" id="opttype_'.$opval.'|'.$opval1.'|'.$opval2.'|'.$opval3.'" value="'.$opval.'|'.$opval1.'|'.$opval2.'|'.$opval3.'"></td></tr>';
											}
										} else {
											echo '<tr><td>'.OptName($opval).' | '.OptName($opval1).' | '.OptName($opval2).'</td><td><input type="text" name="optval_'.$opval.'|'.$opval1.'|'.$opval2.'" id="optval_'.$opval.'|'.$opval1.'|'.$opval2.'" value="'.GetOptPrice($opval.'|'.$opval1.'|'.$opval2, $id).'"><input type="hidden" name="opttype[]" id="opttype_'.$opval.'|'.$opval1.'|'.$opval2.'" value="'.$opval.'|'.$opval1.'|'.$opval2.'"></td></tr>';
										}
									}
								} else {
									echo '<tr><td>'.OptName($opval).' | '.OptName($opval1).'</td><td><input type="text" name="optval_'.$opval.'|'.$opval1.'" id="optval_'.$opval.'|'.$opval1.'" value="'.GetOptPrice($opval.'|'.$opval1, $id).'"><input type="hidden" name="opttype[]" id="opttype_'.$opval.'|'.$opval1.'" value="'.$opval.'|'.$opval1.'"></td></tr>';
								}
							}
						} else {
							echo '<tr><td>'.OptName($opval).'</td><td><input type="text" name="optval_'.$opval.'" id="optval_'.$opval.'" value="'.GetOptPrice($opval, $id).'"><input type="hidden" name="opttype[]" id="opttype_'.$opval.'" value="'.$opval.'"></td></tr>';
						}
					}
					echo '</table>';
					}
					?>
				<?php } ?>
                    </td>
                </tr>
<input type="hidden" name="basepriceHide" id="basepriceHide" value="<?php echo stripslashes($row['baseprice']); ?>" />
                <tr id="HideBase">
                    <td>Base Price:</td>
                    <td><input type="text" size="45" name="baseprice" id="baseprice" value="<?php echo stripslashes($row['baseprice']); ?>" /></td>
                </tr>
				
                <tr>
                    <td>Category Page Images:</td>
                    <td>
                        <div class="field" id="cat_imgupload" style="margin:15px 0;" >
                        <?php 
                        if($row['cat_img']!='') {
                        ?>
                        <img src="../<?php echo $row['cat_img'];?>" border="0" height="90" id=""  />
                        <?php
                        }
                        ?>
                        </div>
                        <div id="title" class="block Posttext margin-l"  style="float:left;">
                            <div class="field" style="float:left;" >
                                <input type="hidden" id="cat_imgpath" name="cat_imgpath" value="<?php echo $row['cat_img'];?>" />
                                <input type="file" name="cat_file_upload" id="cat_file_upload" size="1"/> 
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Products Page  Images:</td>
                    <td>
                        <div class="field" id="imgupload" style="margin:15px 0;" >
                        <?php 
                        if($row['main_image']!='') {
                        ?>
                        <img src="../<?php echo $row['main_image'];?>" border="0" height="90" id=""  />
                        <?php
                        }
                        ?>
                        </div>
                        <div id="title" class="block Posttext margin-l"  style="float:left;">
                        <div class="field" style="float:left;" >
                        <input type="hidden" id="imgpath" name="imgpath" value="<?php echo $row['main_image'];?>" />
                        <input type="file" name="file_upload" id="file_upload" size="1"/> 
                        </div>
                        </div>
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
 					<td valign="top"><textarea name="learnmore_bottom" id="learnmore_bottom" rows="6" cols="60"><?php echo stripslashes($row['learnmore_bottom']); ?></textarea></td></tr>
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
            </table>
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
			  <tr>
                	<td><input type="submit" class="btn" value="Publish Changes" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
		  </table>
            </form>
<?php }
	if ($action=="add") {
?>
            <form method="POST" name="products" id="products" enctype="multipart/form-data" />
            <input type="hidden" name="a" value="addnow" />
            <table width="650" border="0" cellpadding="3" cellspacing="0" > 
            	<tr>
					<td colspan="2" height="20">New Product</td>
                </tr>              
            	<tr>
					<td colspan="2"><hr /></td>
				</tr>                          
            	<tr>
                	<td width="125">Active:</td>
                    <td width="525"><select name="isactive" />
                        <option value="0">No</option>
                        <option value="1" selected="selected">Yes</option>			
                    </select></td>
                </tr>  
                <tr>
                  <td>SEO Product</td>
                  <td><select name="isseo"  id="isseo" onchange="javascript:GetCustomVal('0');">
                        <option value="0" selected="selected">No</option>
                        <option value="1">Yes</option>			
                    </select></td>
                </tr>                              
                <tr>
                    <td>Product Title:</td>
                    <td><input type="text" size="45" name="ptitle" id="ptitle" value="<?php echo stripslashes($row['ptitle']); ?>" /></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td><select name="cat_id" id="cat_id" style="width:331px" onchange="javascript:GetCustomVal('0');">
                                    <option value="0">Select</option>		
									<?php 
                                            $catsql = mysql_query("SELECT * FROM category");
                                            while($catrow = mysql_fetch_assoc($catsql)) {
                                        echo "<option value=\"".$catrow['id']."\"";
                                        if($row['cat'] == $catrow['id']) 
                                            echo " selected=\"selected\" ";
                                        echo ">".$catrow['title']."</option>";
                                        }
                                        ?>	
                                </select></td>
                </tr>
                <tr>
                    <td colspan="2" id="CustomVal">&nbsp;</td>
                </tr>
<input type="hidden" name="basepriceHide" id="basepriceHide" value="<?php echo stripslashes($row['baseprice']); ?>" />
                <tr id="HideBase">
                    <td>Base Price:</td>
                    <td><input type="text" size="45" name="baseprice" id="baseprice" value="<?php echo stripslashes($row['baseprice']); ?>" /></td>
                </tr>
                <tr>
                    <td>Category Page Images:</td>
                    <td>
                        <div class="field" id="cat_imgupload" style="margin-bottom:15px;" ></div>
                        <div id="title" class="block Posttext margin-l"  style="float:left;">
	                        <div class="field" style="float:left;" >
    		                    <input type="hidden" id="cat_imgpath" name="cat_imgpath" value="" />
            	            <input type="file" name="cat_file_upload" id="cat_file_upload" size="1"/> 
                	        </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Products Page Images:</td>
                    <td>
                        <div class="field" id="imgupload" style="margin-bottom:15px;" ></div>
                        <div id="title" class="block Posttext margin-l"  style="float:left;">
	                        <div class="field" style="float:left;" >
    		                    <input type="hidden" id="imgpath" name="imgpath" value="" />
            	            <input type="file" name="file_upload" id="file_upload" size="1"/> 
                	        </div>
                        </div>
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
 					<td valign="top"><textarea name="metatitle" id="metatitle" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Keywords:</td>
 					<td valign="top"><textarea name="metakeywords" id="metakeywords" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Meta Descriprtion:</td>
 					<td valign="top"><textarea name="metadescriprtion" id="metadescriprtion" rows="6" cols="60"></textarea></td>
                </tr>
            	<tr>
                	<td width="125">Custom:</td>
                    <td width="525"><select name="iscustom" />
                        <option value="0">No</option>
                        <option value="1">Yes</option>			
                    </select></td>
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
<script type="text/javascript">
function GetCustomVal(prdid){
	var catid=document.getElementById('cat_id').value;
	var isseo=document.getElementById('isseo').value;
	var BasePrice=document.getElementById('basepriceHide').value;
	
	$.ajax({
		url: 'ajax_custom.php',
		type:'get',
		data: {catid:catid,prdid:prdid},
		success: function(data){
			document.getElementById('CustomVal').innerHTML=data;
			if(isseo==1){
				document.getElementById('CustomVal').innerHTML='&nbsp;';
				document.getElementById('HideBase').innerHTML='<td>&nbsp;</td><td>&nbsp;</td>';
			}else{	
				document.getElementById('CustomVal').innerHTML=data;
				document.getElementById('HideBase').innerHTML='<td>Base Price:</td><td><input type="text" size="45" name="baseprice" id="baseprice" value="'+BasePrice+'" /></td>';
			}
			
		}
	});	
}
</script>