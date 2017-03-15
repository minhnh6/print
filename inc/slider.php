<div id="coin-slider" class="coin-slider">
<?php
$sqlslide="SELECT * FROM sliders WHERE isactive='1' ORDER BY id";
$resslide=mysql_query($sqlslide);
while($rowslide=mysql_fetch_assoc($resslide)){
	echo '<a href="'.LINK_PATH.($rowslide['customlink']?$rowslide['customlink']:'#').'"><img src="'.$rowslide['imgpath'].'" alt="Banner2" width="693" height="317" /></a>';
}
?>
</div>