<?php
session_start();
session_save_path('tmp/');
include('/inc/global.php');
include("/inc/header.php");
require_once ("simple_html_dom.php");
?>
<?php 
$link = "http://www.uprinting.com/vinyl-banner.html";
$html = file_get_html($link);

//$items = $html->find('div[class=calculator]');  

foreach($html->find('div.calc-attributes') as $e){
    echo $e->innertext . '<br>';
}


?>


<?php
include("inc/footer.php");
?>
