<?php
session_start();
/*
Copyright (c) 2009 Ronnie Garcia, Travis Nickels

This file is part of Uploadify v1.6.2

Permission is hereby granted, free of charge, to any person obtaining a copy
of Uploadify and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

UPLOADIFY IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$newfilename= time().'-'.$_FILES['Filedata']['name'];
	$targetFile =  str_replace('//','/',$targetPath) .$newfilename;
	if(!file_exists($targetPath)){
		$old_umask=umask(0);
		mkdir($targetPath,0777);
		umask($old_umask);
		//mkdir(str_replace('//','/',$targetPath), 0755, true);
	}
	
	$imgresamp=0;
	list($width, $height,$type) = getimagesize($tempFile) ;
	if($width>800) {
		$modwidth=800;
		$modheight=800*$height/$width;
		if($modheight>600) {
			$modheight=600;
			$modwidth=600*$width/$height;
		}
		$imgresamp=1;
	} 
	
	if($height>600) {
		$modheight=600;
		$modwidth=600*$width/$height;
		if($modheight>800) {
			$modwidth=800;
			$modheight=600*$height/$width;
		}
		$imgresamp=1;
	}
	if($imgresamp==1) {
		$tn = imagecreatetruecolor($modwidth, $modheight) ;
		if($type==1){
			$image = imagecreatefromgif($tempFile) ;
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
			imagegif($tn, $targetFile, 80) ;
		}
		if($type==2){
			$image = imagecreatefromjpeg($tempFile) ;
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
			imagejpeg($tn, $targetFile, 80) ;
		}
		if($type==3){
			$image = imagecreatefrompng($tempFile) ;
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
			imagepng($tn, $targetFile, 9) ;
		}
	} else {
		move_uploaded_file($tempFile,$targetFile);
	}
}
echo '1';
?>
