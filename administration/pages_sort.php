<?php if($_GET['section'] != 'sortmenu') { echo '<script>window.location="index.php";</script>'; } ?>
<?php

	$action = $_POST['a']; if (!$action) { $action=$_GET['a']; }
	$id = $_POST['id']; if (!$id) { $id=$_GET['id']; }
	$callname = $_POST['callname']; if (!$id) { $id=$_GET['callname']; }	

	foreach ($_POST as $key=>$value) { $_POST[$key] = mysql_real_escape_string($value); }
	foreach ($_GET as $key=>$value) { $_GET[$key] = mysql_real_escape_string($value); }

	$sqlsec = mysql_query("SELECT parentname FROM pages where mpID!='0' and isactive='1' and recycled='0' and callname='{$_GET['callname']}' LIMIT 1");	
	$rowsec = mysql_fetch_assoc($sqlsec);	
	
?>
<table align="center" width="650" border="0" cellpadding="0" cellspacing="0">  
    <tr>
        <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><?php echo $successmessage; ?></div></td>
    </tr>   
	<tr>
		<td valign="top">
<?php
// Sort
	if ($action=="") {		
?>
            <table width="710" border="0" cellpadding="3" cellspacing="0"><tr><td>         
                <div style="float:left; width:710px;">
                	<div style="float:left; width:600px; padding:3px;"><b>Section</b></div>
                    <div style="float:left; width:98px; padding:3px;"><b>Menu Links</b></div>
                </div>
                <div style="float:left; width:710px;"><hr></div>
                
                <div id="SortableList" style="float:left; width:710px;">
<?php
	$sql = mysql_query("SELECT * FROM callcats ORDER BY dispname ASC");
	while($row=mysql_fetch_assoc($sql)) {	
?>
				<div id="SortableList_<?php echo $row['id'];?>"  onclick="DoNav('?section=<?php echo $_GET['section']; ?>&a=sort&callname=<?php echo $row['catname']; ?>')" class="normal" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="float:left;">
                    <div style="width:634px; float:left; padding:3px;"><?php echo $row['dispname']; ?></div>
                    <div style="width:64px; float:left;padding:3px;">#</div>
				</div>                
<?php $i++; } ?>    
</div>   
</td></tr></table>        
<?php } ?>           
<?php
// Sort
	if ($action=="sort") {
?>
            <table width="710" border="0" cellpadding="3" cellspacing="0"><tr><td>         
                <div style="float:left; width:710px;">
                    <div style="float:left; width:710px; padding:3px;"><b>Sorting Menu Links for <?php echo $rowsec['parentname']; ?></b></div>
                </div>
                <div style="float:left; width:710px;"><hr></div>
                <div id="SortableList" style="float:left; width:710px;">
<?php
	$sql = mysql_query("SELECT * FROM pages where mpID!='0' and isactive='1' and issub='0' and recycled='0' and callname='{$_GET['callname']}' ORDER BY orderby");
	while($row=mysql_fetch_assoc($sql)) {
				
	$row['menuname'] = str_replace('\\','',$row['menuname']);	
	$editsubs = '';
	if($row['hassubs'] == 1) {
		$sectionname = $_GET['section'];
		$callname = $_GET['callname'];
		$hassubid = $row['id'];
		$editsubs = '&nbsp;>&nbsp;<a href="?section='.$sectionname.'&a=sortsubs&callname='.$callname.'&subid='.$hassubid.'">Edit Sub Menu Links</a>';
	}
?>

                    <div id="SortableList_<?php echo $row['id'];?>" class="normal" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="float:left;">
                        <div style="width:710px; float:left; padding:3px;"><?php echo $row['menuname']; ?><?php echo $editsubs; ?></div>
                    </div>
<?php $i++; } ?>
				</div>
			</td></tr></table>
<?php } ?>
<?php
// Sort
	if ($action=="sortsubs") {
	$subid = $_GET['subid'];
	$sqlname = mysql_query("SELECT menuname FROM pages where mpID!='0' and isactive='1' and recycled='0' and id='{$subid}' LIMIT 1");	
	$rowname = mysql_fetch_assoc($sqlname);			
?>
            <table width="710" border="0" cellpadding="3" cellspacing="0"><tr><td>         
                <div style="float:left; width:710px;">
                    <div style="float:left; width:710px; padding:3px;"><b>Sorting Menu Links under <?php echo $rowname['menuname']; ?></b></div>
                </div>
                <div style="float:left; width:710px;"><hr></div>
               
                <div id="SortableList" style="float:left; width:710px;">
<?php
	$subid = $_GET['subid'];
	$sql = mysql_query("SELECT * FROM pages where mpID!='0' and issub='1' and subof='{$subid}' and isactive='1' and recycled='0' and callname='{$_GET['callname']}' ORDER BY orderby");
	while($row=mysql_fetch_assoc($sql)) {
				
	$row['menuname'] = str_replace('\\','',$row['menuname']);	
	$editsubs = '';
	if($row['hassubs'] == 1) {
		$sectionname = $_GET['section'];
		$callname = $_GET['callname'];
		$hassubid = $row['id'];
		$editsubs = '&nbsp;>&nbsp;<a href="?section='.$sectionname.'&a=sort&callname='.$callname.'&id='.$hassubid.'">Edit Sub Menu Links</a>';
	}
?>

                    <div id="SortableList_<?php echo $row['id'];?>" class="normal" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="float:left;">
                        <div style="width:710px; float:left; padding:3px;"><?php echo $row['menuname']; ?><?php echo $editsubs; ?></div>
                    </div>
<?php $i++; } ?>
				</div>
			</td></tr></table>
<?php } ?>       
        </td>
	</tr>
</table>
<div id="info"> </div>