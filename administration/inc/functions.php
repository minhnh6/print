<?php
// Login Function
	function confirmUser($username, $password){
	   	if(!get_magic_quotes_gpc()) {
			$username = addslashes($username);
	   	}
	   	$result = db_query ("select password from users where username = '".$username."'");
	   	if(!$result || (mysql_num_rows($result) < 1)){
			return 1; 
	   	}
		$dbarray = mysql_fetch_array($result);
		$dbarray['password'] = stripslashes($dbarray['password']);
		$password = stripslashes($password);
		if($password == $dbarray['password']){
		  	return 0; 
		} else {
		  	return 2; 
		}
	}
	
// DB Query		
	function db_query($query)
	{
		$result = mysql_query($query);
		if (!$result) {
			$errno = mysql_errno();
			$error = mysql_real_escape_string(mysql_error());
			$query = mysql_real_escape_string($query);
			$dt = date('Y-m-d H:i:s');
			mysql_query("INSERT INTO error_log VALUES ('$dt', NULL, $errno, '$error', '$query')");
		}
		return $result;
	}	
	

// Sort Drag and Drop Functions for Headlines
	class SortableExample {
		
		public function getList() {
			$sql = "SELECT * FROM headlines ORDER BY orderby";
			$recordSet = mysql_query($sql);
			$results = array();
			while($row = mysql_fetch_assoc($recordSet)) {
				$results[] = $row;
			}
			return $results;
		}
		
		public function updateList($orderArray) {
			$orderid = 1;
			foreach($orderArray as $catid) {
				$catid = (int) $catid;
			$sql = "UPDATE headlines SET orderby={$orderid} WHERE id={$catid}";
				$recordSet = mysql_query($sql);
				$orderid++;
			}
		}
		
		public function getAnList($tblName, $id=0) {
		
			if($tblName=='shop_products') {
				$sql = "SELECT shop_products.*, shop_category.catname FROM shop_products inner join shop_category on 						shop_products.catid=shop_category.catid ORDER BY shop_category.catid, 
						shop_products.productid";
			} else if($tblName=='shop_orders') {
				$sql = "SELECT * FROM ".$tblName." ORDER BY orderdate";
			}else{
				$sql = "SELECT * FROM ".$tblName." ORDER BY id";
			}
			$recordSet = mysql_query($sql) or die(mysql_error());
			$results = array();
			while($row = mysql_fetch_assoc($recordSet)) {
				$results[] = $row;
			}
			return $results;
		}
	}	

// Sort Drag and Drop Functions for Events
	class SortableExample2 {
		
		public function getList() {
			$sql = "SELECT * FROM eventtypes ORDER BY orderby";
			$recordSet = mysql_query($sql);
			$results = array();
			while($row = mysql_fetch_assoc($recordSet)) {
				$results[] = $row;
			}
			return $results;
		}
		
		public function updateList($orderArray) {
			$orderid = 1;
			foreach($orderArray as $catid) {
				$catid = (int) $catid;
			$sql = "UPDATE eventtypes SET orderby={$orderid} WHERE id={$catid}";
				$recordSet = mysql_query($sql);
				$orderid++;
			}
		}
	}
	
// Serialize Function
	function prepData($var, $serialized = 0) {
	  if ($serialized == 0)  {
		if (get_magic_quotes_gpc()) {
		  $var = stripslashes($var);
		}
	  }
	return mysql_real_escape_string($var);
	}
	
// Uploadify Insert Photo
	function insertPhoto($photo) {
		$sql="insert into photos(%s) values(%s)";
		$fields='';
		$values='';
		foreach($photo as $key=>$value) {
			if($fields=='') {
				$fields=$key;
			} else {
				$fields=$fields.",".$key;
			}
			
			if($values=='') {
				$values="'".$value."'";
			} else {
				$values=$values.","."'".$value."'";
			}			
		}
		$sql=sprintf($sql,$fields,$values);
		$result=mysql_query($sql);
		$insert_id=mysql_insert_id();
		return $insert_id;
	}
	
// Display Tooltip
	function DispTip($refname) {
		echo '<a id="'.$refname.'" class="helplink" href="javascript:void(0);" tabindex="-1"><img src="'.LINK_PATH.'administration/images/question.gif" border="0" /></a>&nbsp;&nbsp;';
        }	
?>