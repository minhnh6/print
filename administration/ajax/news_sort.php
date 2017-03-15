<?php
include('../../inc/global_admin.php');
if(isset($_GET['SortableList'])){
	foreach($_GET['SortableList'] as $key=>$value){
		mysql_query("UPDATE news SET orderby='".$key."' WHERE id='".$value."'") or die(mysql_error());
	}
}

?>