<?php
session_start();
session_save_path('tmp/');
include('/inc/global.php');
include("/inc/header.php");
require_once ("simple_html_dom.php");
?>
<?php 
$link = "http://www.uprinting.com/banner-printing.html";
//$link = "http://www.uprinting.com/brochure-printing.html";
$html = file_get_html($link);

//lấy tên sp catelogue
$arr_proCate = array();
foreach($html->find('div.single-category') as $category){
                 $item['href']    ='http://www.uprinting.com'.$category->find('a',0)->href;
				$arr_proCate[] = $item;
               
}

echo "<pre>";
	print_r($arr_proCate);
echo "</pre>";


$arr_infoCate = array();
foreach($html->find('section.product-details') as $infocategory){
           
                 $itemifo['des']     = preg_replace('/\s\s+/', ' ', trim($infocategory->find('h2',1)->plaintext));
                 foreach($infocategory->find('p') as $info){
                 	$itemifo['conten'] .= $info->outertext;
                 }
				 $arr_infoCate[] = $itemifo;
               
}
echo "<pre>";
	//print_r($arr_infoCate);
echo "</pre>";

//kay thông tin tung sp

$arr_product = array();
foreach($html->find('section.product-main') as $infopro){
                  $arr_product['name']     = preg_replace('/\s\s+/', ' ', trim($infopro->find('h1.pull-left',0)->plaintext));
				  $arr_product['src']    =$infopro->find('img',0)->src;
			
}
echo "<pre>";
	print_r($arr_product);
echo "</pre>";
?>



<?php
include("inc/footer.php");
?>
