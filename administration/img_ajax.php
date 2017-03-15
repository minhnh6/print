<?php
if(isset($_GET['imagename'])){
	$toimages=explode(',',$_GET['adsnlimg']);
	foreach($toimages as $key=>$aimag){
		if($aimag==$_GET['imagename']){
			unset($toimages[$key]);
		}
	}
	if(file_exists('../images/products/'.$_GET['imagename'])){
	if(unlink('../images/products/'.$_GET['imagename'])) {$rtdata=implode(',',$toimages);
	echo $rtdata.'~';} else {$rtdata=implode(',',$toimages);
	echo $rtdata; echo '~There is a problem with image removing!!'; }
	}
	
}
?>