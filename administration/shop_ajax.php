<?php
class SortableExample {
	protected $conn;
	//protected $user = 'vadesign_dbuser';
	//protected $pass = '#eEnz7M#fq?1';
	//protected $dbname = 'vadesign_db';	
	protected $user = 'root';
	protected $pass = 'root';
	protected $dbname = 'allcity_ziggis';
	protected $host = 'localhost';
	
	public function __construct() {
		$this->conn = mysql_connect($this->host, $this->user, $this->pass);
		mysql_select_db($this->dbname,$this->conn);
	}
}
if(isset($_GET['imagename'])){
	$toimages=explode(',',$_GET['adsnlimg']);
	foreach($toimages as $key=>$aimag){
		if($aimag==$_GET['imagename']){
			unset($toimages[$key]);
		}
	}
	if(unlink('../images/shop/products/'.$_GET['imagename'])) {$rtdata=implode(',',$toimages);
	echo $rtdata.'~';} else {$rtdata=implode(',',$toimages);
	echo $rtdata; echo '~There is a problem with image removing!!'; }
	
}
?>