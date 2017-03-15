<?php 
include("inc/global.php");
$id_pro = $_POST['id'];
$sqlpro="SELECT * FROM products WHERE isactive=1  and id={$id_pro} ";
$respro=mysql_query($sqlpro);
$rowpro=mysql_fetch_assoc($respro);
$return_value= array();
$return_value['id'] = $rowpro['id'];
$return_value['ptitle'] = $rowpro['ptitle'];
$return_value['main_image'] = $rowpro['main_image'];
echo json_encode($return_value);
die();
?>

