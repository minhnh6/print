<?php
include_once("../../inc/global_admin.php");
$output='';
$delimiter='\n';
$output = 'var tinyMCELinkList = new Array(';

$srchquery="select title,post from blog_posts where isactive=1 order by title";
$resquery=mysql_query($srchquery)or die(mysql_error());
while($getvalue=mysql_fetch_assoc($resquery)){
	$progt=str_replace(" ","-",$getvalue['title']);
	$output .= '["[BLOG] - '.utf8_encode($getvalue['title']). '", "'. utf8_encode("http://www.ourcenter.org/content/newsroom/blog/posts/".$progt). '"],';
}

$srchquery="select pagetype,crumb1,crumb2,crumb3,callname,parentname,name,menuname from pages where showadmin=1 and isactive=1 and editable=1 and recycled=0 order by parentname,name";
$resquery=mysql_query($srchquery)or die(mysql_error());
while($getvalue=mysql_fetch_assoc($resquery)){
	$progt=str_replace(" ","-",$getvalue['menuname']);
	if($getvalue['pagetype'] == "C" || $getvalue['pagetype'] == "CM") { 
		$output .= '["[CMS] - '.utf8_encode($getvalue['parentname']). ' > '.utf8_encode($getvalue['name']). '", "'. utf8_encode('http://www.ourcenter.org/content/page/'.strtolower(str_replace(" ","-",$getvalue['name']))).'"],';	
	} else if($getvalue['crumb3']) {
		$output .= '["[CMS] - '.utf8_encode($getvalue['parentname']). ' > '.utf8_encode($getvalue['crumb2']). ' > '.utf8_encode($getvalue['crumb3']). '", "'. utf8_encode('http://www.ourcenter.org/content/'.$getvalue['callname'].'/'.strtolower(str_replace(" ","-",$getvalue['menuname']))).'"],';				
	} else if($getvalue['crumb2']) {
		$output .= '["[CMS] - '.utf8_encode($getvalue['parentname']). ' > '.utf8_encode($getvalue['crumb2']). '", "'. utf8_encode('http://www.ourcenter.org/content/'.$getvalue['callname'].'/'.strtolower(str_replace(" ","-",$getvalue['menuname']))).'"],';				
	} else if($getvalue['crumb2'] == "" && $getvalue['crumb3'] == "") {
		$output .= '["[CMS] - '.utf8_encode($getvalue['parentname']). ' > '.utf8_encode($getvalue['menuname']). '", "'. utf8_encode('http://www.ourcenter.org/content/'.$getvalue['callname'].'/'.strtolower(str_replace(" ","-",$getvalue['menuname']))).'"],';
	} else {
		$output .= '["[CMS] - '.utf8_encode($getvalue['parentname']). '", "'. utf8_encode('http://www.ourcenter.org/content/'.$getvalue['callname'].'/'.strtolower(str_replace(" ","-",$getvalue['menuname']))).'"],';
	}
}

$srchquery="select crumb2,callname,name,menuname from pages where pagetype='C' and isactive=1 and editable=1 order by name";
$resquery=mysql_query($srchquery)or die(mysql_error());
while($getvalue=mysql_fetch_assoc($resquery)){
	$progt=str_replace(" ","-",$getvalue['name']);
		$output .= '["[CMS] - Content Page > '.utf8_encode($getvalue['name']). '", "'. utf8_encode('http://www.ourcenter.org/content/page/'.strtolower(str_replace(" ","-",$getvalue['name']))).'"],';		
}

$srchquery="select g.title,g.imgcatid,p.galleryid from photos p inner join imggallery g on p.galleryid=g.id where p.isactive=1 order by title";
$resquery=mysql_query($srchquery)or die(mysql_error());
while($getvalue=mysql_fetch_assoc($resquery)){
	$progt=str_replace(" ","-",$getvalue['title']);
	$output .= '["[IMAGE] - '.utf8_encode($getvalue['title']). '", "'. utf8_encode('http://www.ourcenter.org/content/ourcommunity/photo-gallery/'.$getvalue['imgcatid'].'/'.$getvalue['galleryid']).'"],';
}

$srchquery="select id,videocatid,title from videos where isactive=1 order by title";
$resquery=mysql_query($srchquery)or die(mysql_error());
while($getvalue=mysql_fetch_assoc($resquery)){
	$progt=str_replace(" ","-",$getvalue['title']);
	$output .= '["[VIDEO] - '.utf8_encode($getvalue['title']). '", "'. utf8_encode('http://www.ourcenter.org/content/ourcommunity/video-gallery/'.$getvalue['id'].'/'.$getvalue['videocatid']).'"],';
}


$output = substr($output, 0, -1); // remove last comma from array item list (breaks some browsers)
//$output .= $delimiter;
$output .= ');';
header('Content-type: text/javascript'); // browser will now recognize the file as a valid JS file
header('pragma: no-cache');
header('expires: 0'); // i.e. contents have already expired
echo $output;
?>