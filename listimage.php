<?php
$targetpath=$_GET['imagepath'];
if(isset($_GET['height']) || isset($_GET['width'])) {
	list($width, $height,$type) = getimagesize($targetpath) ;
	if(isset($_GET['height']) ) {
		$modheight = $_GET['height'];
		$modwidth = ($width * $modheight)/ $height;
		if(isset($_GET['min-width']) && $modwidth<$_GET['min-width']) {
			$modwidth = $_GET['min-width'];
			$modheight = ($height * $modwidth)/ $width;
		} else {
			if(isset($_GET['width'])) {
				if($modwidth > $_GET['width']) {
					$tmpwidth=$modwidth;
					$modwidth = $_GET['width'];
					$modheight = ($modwidth * $modheight)/ $tmpwidth;
				}
			}
		}
	} else {
		$modwidth = $_GET['width'];
		$modheight = ($height * $modwidth)/ $width;
	}
	
	$tn = imagecreatetruecolor($modwidth, $modheight);
	if($type==1){
		$image = imagecreatefromgif($targetpath) ;
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
		header("Content-type: image/gif");
		imagegif($tn, null, 80) ;
	}
	if($type==2){
		$image = imagecreatefromjpeg($targetpath) ;
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
		header("Content-type: image/jpeg");
		imagejpeg($tn, null, 80) ;
	}
	if($type==3){
		imagecolortransparent($tn, imagecolorallocate($tn, 0, 0, 0));
		imagealphablending($tn, false);
		imagesavealpha($tn, true); 
		$image = imagecreatefrompng($targetpath) ;
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
		header("Content-type: image/png");
		imagepng($tn) ;
	}
	imagedestroy($tn);
}

?>