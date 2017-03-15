<?php
$section = $_GET['section'];

if ($section == 'login') {
	include('login.php');
} else if ($section == 'logout') {
	include('logout.php');
	echo '<script>window.location="?section=login"</script>';
} else {
	include('layout.php');
}

?>