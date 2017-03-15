<?php
session_start();
include('../inc/global_admin.php');
include('inc/functions.php');

	if (!isset($_SESSION['UserId'])) {
		
		if (isset($_POST['adminloginok'])) {
			
		   if(!$_GET['usern'] || !$_GET['pass']) {
				$errormsg = "Invalid Login";
   		   }
		   
		   $md5pass = md5($_POST['pass']);
		   $result = confirmUser($_POST['usern'], $md5pass);
			   if($result != 0) {
					$errormsg = "Invalid Login";
			   } else {
					$_POST['usern'] = stripslashes($_POST['usern']);
					$_SESSION['username'] = $_POST['usern'];
					$_SESSION['password'] = $md5pass;
		
					$result = db_query ("select * from users where username = '".$_POST["usern"]."'");
					$rowuser=mysql_fetch_assoc($result);
					$_SESSION['UserId'] = $rowuser['id'];
					$_SESSION['AdminUserName'] = $rowuser['username'];
					$_SESSION['AdminName'] = $rowuser['fullname'];   
			   }
		}
	}

if (isset($_SESSION['UserId'])) {
	echo '<script>window.location="?section=dashboard"</script>';
} else {
	
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/login.css" title="style" media="screen" />
<script type="text/javascript">
/* <![CDATA[ */
	$(document).ready(function(){
			$(".block").fadeIn(1000);				   
			$(".idea").fadeIn(1000);
			$('.idea').supersleight();
			$('#username').example('Username');	
			$('#password').example('Password');
	});
/* ]]> */
</script>
</head>

<body onLoad="document.login.usern.focus();">
<div align="center">
<div id="wrap">
	<div class="acsmlogo"><div align="center"><img src="images/acsm.png" border="0"></div></div>
<?php if (isset($errormsg)){ ?>
    <div class="error">
    <img src="css/images/message.png" alt=""/>
    <p><?php echo $errormsg; ?></p>
    </div>
<?php }?>
	<div class="login">
        <form method="post" name="login" id="login">
        <input type="hidden" name="adminloginok" value="adminloginok">
        <div class="div-row">
        <input type="text" id="username" name="usern"  onfocus="this.value='';" onBlur="if (this.value=='') {this.value='Username';}" value="Username" />
        <input type="password" id="password" name="pass" onFocus="this.value='';" onBlur="if (this.value=='') {this.value='************';}" value="************" />
        </div>
        <div class="send-row">
        <button id="login" value="" type="submit" name="login"></button>
        </div>
        </form>
    </div>
    <div class="footer"><p>Site Manager</p><p style="float:right;">&reg;&nbsp;Powered by Site Manager</p></div>    
</div>
<?php } ?><br>
</div>
</body>
</html>