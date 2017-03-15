<?php if($_GET['section'] != 'changepassword') { echo '<script>window.location="index.php";</script>'; } ?>
<?php

	$action = $_GET['a'];
	if($action == '') $action=$_POST['a'];
	$errmsg = '';
	
	foreach ($_POST as $key=>$value) { $_POST[$key] = mysql_real_escape_string($value); }
	foreach ($_GET as $key=>$value) { $_GET[$key] = mysql_real_escape_string($value); }

	$checkpass = mysql_query("select pwdreset from users where id='".$_SESSION['UserId']."'");
	$rowpass = mysql_fetch_assoc($checkpass);
	
	if($_GET['do'] == "passwordchanged") {
		$successmessage = '<div id="messagebox" class="success">Your settings have been saved.</div></div>';	
	}	

	if($rowpass['pwdreset'] == "1") {
		
		$passresetmsg = '<div id="errorbox" class="errorpwd">You are required to change your password in order to continue.</div>';
	} 

	if ($action == "changepassword") {
		$currentpassword = $_POST['currentpass'];
		$currentpasswordenc = md5($currentpassword);
		$newpassword = $_POST['newpass'];
		$newpasswordenc = md5($newpassword);
		$confirmpassword = $_POST['confirmpass'];
		$confirmpasswordenc = md5($confirmpassword);		
		$sessionuserid = $_SESSION['UserId'];
		
//		echo 'Current: '.$currentpassword.' New: '.$newpassword.' Confirm: '.$confirmpassword.'';

		if($currentpassword == '') {
			$errmsg1 = 'Sorry the current password field was empty.';
		} else {
			$sqlcheck = "select * from users where id='{$sessionuserid}' and password='{$currentpasswordenc}'";
			$rescheck = mysql_query($sqlcheck);
			if(mysql_num_rows($rescheck)) {
				if(($newpassword == "") && ($confirmpassword == "")) {
					$errmsg = 'There were some issues changing your password';
					$errmsg2 = 'New and confirm password fields were empty.';
				} else if(($confirmpassword) && ($newpassword == "")) {	
					$errmsg = 'There were some issues changing your password';				
					$errmsg2 = 'New password field was empty.';
				} else if(($newpassword) && ($confirmpassword == "")) {
					$errmsg = 'There were some issues changing your password';					
					$errmsg2 = 'Confirm password field was empty.';
				} else if($newpasswordenc == $confirmpasswordenc) {
					mysql_query("UPDATE users set password='{$newpasswordenc}', pwdreset='0' where id='{$sessionuserid}'");
					$successmessage = 'Your change password request has been completed.';
				}  else if($newpasswordenc != $confirmpasswordenc) {
					$errmsg = 'There were some issues changing your password';					
					$errmsg2 = 'New and confirm passwords you entered do not match.';
				}
			} else {
				$errmsg = 'There were some issues changing your password';
				$errmsg1 = 'The password you entered as your current password is incorrect.';
			}
		}
	}
?>   
<table align="center" width="650" border="0" cellpadding="0" cellspacing="0">  
	<?php if($passresetmsg) { ?>
    <tr>
        <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><?php echo $passresetmsg; ?></div></td>
    </tr>
    <?php } ?>
	<?php if($successmessage) { ?>
    <tr>
        <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><div class="success"><?php echo $successmessage; ?></div></div></td>
    </tr>
    <?php } else { ?>

	<tr>
		<td valign="top">
            <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="a" value="changepassword">
            <table cellspacing="2" cellpadding="2" border="0" width="650">
            	<tr>
            		<td width="500" height="20">Change your Pasword</td>
                    <td width="150"></td>
				</tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>  
                <?php if($errmsg) { ?>
                <tr>
                    <td colspan="2" style="color: #C33;"><?php echo $errmsg; ?></td>
                </tr>
                <?php } ?>       
				<?php if($errmsg1) { ?>
                <tr>
                    <td colspan="2" style="color: #C33; font-weight: none;">- <?php echo $errmsg1; ?></td>
                </tr>
                <?php } ?>       
				<?php if($errmsg2) { ?>
                <tr>
                    <td colspan="2" style="color: #C33; font-weight: none;">- <?php echo $errmsg2; ?></td>
                </tr>
                <?php } ?> 
				<?php if($errmsg3) { ?>
                <tr>
                    <td colspan="2" style="color: #C33; font-weight: none;">- <?php echo $errmsg3; ?></td>
                </tr>
                <?php } ?>                                                       
                <tr>
                	<td colspan="2">
                    	<table width="100%">	                      
                            <tr>
                            	<td width="125">Enter Current:</td>
                                <td><input type="text" size="25" name="currentpass" value="<?php echo $_POST['currentpass']; ?>" /></td>
                            </tr>                            
                            <tr>
                            	<td>Enter New:</td>
                                <td><input type="text" size="25" name="newpass" value="<?php echo $_POST['newpass']; ?>" /></td>
                            </tr>                           
                            <tr>
                            	<td>Confirm New:</td>
                            	<td><input type="text" size="25" name="confirmpass" value="<?php echo $_POST['confirmpass']; ?>" /></td>
                            </tr>                           
						</table>
					</td>
				</tr>
                <tr>
                	<td colspan="2"><input type="submit" value="Change Password" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" /></td>
				</tr>
			</table>
            </form>
		</td>
	</tr>   
    <?php } ?>
</table>