<?php
session_start();
session_save_path('tmp/');
include "inc/global.php";
//$dbh->Query("delete from ".TB_SHOPPING_CART." where fld_shopSessionId='".session_id()."'");
//session_unregister("_SESSUSERID_");
session_unset();
echo '<script>window.location="index.php"</script>';
?>