<?php
class cDBConstruct {
	var $conn;
	var $columns;
	var $rows;
	var $row;
	var $currentDate;
	var $currentTime;
	var $adminEmail;
	var $serverName;
	var $serverSoftware;
	var $serverAddress;
	var $currentScript;
	function cDBConstruct(){
		global $HTTP_SERVER_VARS;

		$this->conn = NULL;
		$this->columns = NULL;
		$this->rows = NULL;	
		$this->currentDate = date("Y-m-d");
		$this->currentTime = date("H:i:s");
		$this->row = 0;
		
		$this->serverName = $HTTP_SERVER_VARS["SERVER_NAME"];
		$this->serverSoftware = $HTTP_SERVER_VARS["SERVER_SOFTWARE"];
		$this->currentScript = $HTTP_SERVER_VARS["PATH_TRANSLATED"];

		$this->SetAdminEmail();
	}
	function SetAdminEmail($email=""){
		global $admin_email;

		$email=="" ? $this->adminEmail = $admin_email : $this->adminEmail = $email;
		return true;
	}

	function _DBConnectionError(){
		global $HTTP_SERVER_VARS;
		$body = "On " . $this->currentDate . " at " . $this->currentTime . ", a user was unable to ";
		$body .= "connect to the database server.  The error occured in " . $this->currentScript . ".";

		$HTTP_SERVER_VARS["SERVER_ADDR"] == "24.78.38.253" ? $send = TRUE : $send = FALSE;
			
		if ($send)
			$this->_sendMail($body);
		else
			echo nl2br($body) . "<br>";

		return false;
	}
	
	function _DBSelectionError(){
		global $HTTP_SERVER_VARS;
		$body = "On " . $this->currentDate . " at " . $this->currentTime . ", a user connected to ";
		$body .= "the database server but was unable to select the correct database.  The error ";
		$body .= "occured in " . $this->currentScript . ".";

		$HTTP_SERVER_VARS["SERVER_ADDR"] == "24.78.38.253" ? $send = TRUE : $send = FALSE;
			
		if ($send)
			$this->_sendMail($body);
		else
			echo nl2br($body) . "<br>";

		return false;
	}

	function _SQLError($sql,$error){
		global $HTTP_SERVER_VARS;
		$body = "On " . $this->currentDate . " at " . $this->currentTime . ", an sql error occured.  ";
		$body .= "When asked the trouble, the database said:\n\n\"".trim($error)."\"\n\n";
		$body .= "The error was thrown from " . $this->currentScript . " in the function $type and ";
		$body .= "the offending sql statement is below:\n\n\n$sql";

		$HTTP_SERVER_VARS["SERVER_ADDR"] == "24.78.38.253" ? $send = TRUE : $send = FALSE;
			
		if ($send)
			$this->_sendMail($body);
		else
			echo nl2br($body) . "<br>";

		return false;
	}

	function _sendMail($body,$to="",$subject="",$headers="",$cc="",$bcc="",$html=false){
		global $HTTP_SERVER_VARS;

		if ($headers == "") {				
			$headers = "From: \"Automated Script Debugger System at " . $this->serverName . "\"\nReply-To: ";
			$headers .= "\"Automated Script Debugger System at " . $this->serverName . "\"\nX-Mailer: \"";
			$headers .= $this->serverName . " via " . $this->serverSoftware . "\"";
		}

		if ($subject == "")
			$subject = "Script Error";
		if ($html)
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
		if ($cc != "")
			$headers .= $cc;
		if ($bcc != "")
			$headers .= $bcc;

		$to == "" ? $to = $this->adminEmail : TRUE;
		$HTTP_SERVER_VARS["SERVER_ADDR"] == "127.0.0.1" ? $send = FALSE : $send = TRUE;
			
		if ($send)
			@mail($to, $subject, $body, $headers);  
		else
			echo nl2br($body) . "<br>";			
	}
}

class cFrontBase extends cDBConstruct {
	 function cFrontBase(){
		  $this->cDBConstruct();
		  return true;
	 }

	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		$this->conn = @fbsql_pconnect($strHost, $strUser, $strPassword) or $this->_DBConnectionError();
		if (!@fbsql_select_db($strDatabase, $this->conn)) {
			$this->Disconnect();
			$this->_DBSelectionError();
		}
		$this->columns = 0;
		$this->rows = 0;
	}
	
	function Disconnect(){
		@fbsql_close($this->conn);
		$this->conn = null;
	}
	
	function Query($strSQL){
		$this->columns = 0;
		$this->rows = 0;
		$rs = @fbsql_query("$strSQL;", $this->conn) or $this->_SQLError($strSQL,$this->GetLastMessage());
		if ($rs > 0) {
			$this->columns = @fbsql_num_fields($rs);
			$this->rows = @fbsql_num_rows($rs);
		}
		return $rs;			
	}
	
	function ColumnName($rs, $col){
		if ($rs) return @fbsql_field_name($rs, $col);
	}

	function ColumnLength($rs, $col){
		if ($rs) return @fbsql_field_len($rs, $col);
	}

	function ColumnType($rs, $col){
		if ($rs) return @fbsql_field_type($rs, $col);
	}

	function FetchRow($rs,$type=2){
		if (is_resource($rs)) return @fbsql_fetch_array($rs,$type);
	}
	
	function NumRows($rs){
		if (is_resource($rs)) return @fbsql_num_rows($rs);
	}

	function NextResult($rs){
		$ret = false;
		if ($rs > 0) {
			if (@fbsql_next_result($rs)) {
				$this->columns = @fbsql_num_fields($rs);
				$this->rows = @fbsql_num_rows($rs);
				$ret = true;
			}
			else {
				$this->columns = 0;
				$this->rows = 0;
				$ret = false;
			}
		}
		return $ret;
	}

	function FreeResult($rs){
		if ($rs > 0) @fbsql_free_result($rs);
	}

	function GetLastMessage(){
		if ($this->conn) {
			$strError = @fbsql_error($this->conn);
			if ($strError)
				return str_replace("\r\n", "\r", $strError);
			else
				return false;
		}
		else
			return false;
	}
}


class cPostgreSQL extends cDBConstruct {
	 function cPostgreSQL() 
	 {
		  $this->cDBConstruct();
		  return true;
	 }
	
	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		$this->conn = @pg_pconnect("host=$strHost user=$strUser password=$strPassword dbname=$strDatabase") or $this->_DBConnectionError();
		$this->columns = 0;
		$this->rows = 0;
	}
	
	function Disconnect(){
		@pg_close($this->conn);
		$this->conn = null;
	}
	
	function Query($strSQL){
		$this->columns = 0;
		$this->rows = 0;
		$this->row = 0;
		$rs = @pg_exec($this->conn, $strSQL) or $this->_SQLError($strSQL,$this->GetLastMessage());
		if ($rs > 0) {
			$this->columns = @pg_numfields($rs);
			$this->rows = @pg_numrows($rs);
		}
		return $rs;			
	}
	
	function ColumnName($rs, $col){
		if ($rs) return @pg_fieldname($rs, $col);
	}

	function ColumnLength($rs, $col){
		if ($rs) return @pg_fieldsize($rs, $col);
	}

	function ColumnType($rs, $col){
		if ($rs) return @pg_fieldname($rs, $col);
	}

	function FetchRow($rs, $type=2){
		if (is_resource($rs) && $this->row < $this->NumRows($rs)) {
			$num = $this->row;
			$this->row = ($num + 1);
			return pg_fetch_array($rs,$num,$type);
		}
	}
	
	function NumRows($rs){
		if (is_resource($rs)) return @pg_numrows($rs);
	}

	function NextResult($rs){
		return true;
	}

	function FreeResult($rs){
		if ($rs > 0) @pg_freeresult($rs);
	}

	function GetLastMessage(){
		if ($this->conn) {
			$strError = @pg_errormessage($this->conn);
			if ($strError)
				return str_replace("\r\n", "\r", $strError);
			else
				return false;
		}
		else
			return false;
	}
}

class cMSSQL extends cDBConstruct {

	 function cMSSQL() 
	 {
		  $this->cDBConstruct();
		  return true;
	 }

	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		$this->conn = @mssql_connect($strHost, $strUser, $strPassword) or $this->_DBConnectionError();
		if ($this->conn) {
			@mssql_select_db($strDatabase, $this->conn) or $this->_DBSelectionError();
		}
		@mssql_min_error_severity(100);
		@mssql_min_message_severity(100);
		$this->columns = 0;
		$this->rows = 0;
	}

	function Disconnect(){
		@mssql_close($this->conn);
		$this->conn = null;
	}

	function Query($strSQL){
		$this->columns = 0;
		$this->rows = 0;
		$rs = @mssql_query($strSQL, $this->conn) or $this->_SQLError($strSQL,$this->GetLastMessage());
		if (is_resource($rs)) {
			$this->columns = @mssql_num_fields($rs);
			$this->rows = @mssql_num_rows($rs);
		}
		return $rs;			
	}

	function ColumnName($rs, $col){
		if ($rs) return @mssql_field_name($rs, $col);
	}

	function ColumnLength($rs, $col){
		if ($rs) return @mssql_field_length($rs, $col);
	}

	function ColumnType($rs, $col){
		if ($rs) return @mssql_field_type($rs, $col);
	}

	function FetchRow($rs,$type=2){
		if (is_resource($rs)) {
			if ($result = @mssql_fetch_row($rs)) {
				$rowData = array();
				for ($i = 0; $i < $this->columns; $i++) {
					if ($type==1) {
						return $result;
					}
					else if ($type==3) {
						$rowData[] = $result[$i];			
						$rowData[@mssql_field_name($rs, $i)] = $result[$i];
					}
					else {
						$rowData[@mssql_field_name($rs, $i)] = $result[$i];					
					}
				}
			}
		}
		unset($result);
		return $rowData;
	}

	function NumRows($rs){
		if (is_resource($rs)) return @mssql_num_rows($rs);
	}

	function NextResult($rs){
		$ret = false;
		if (is_resource($rs)) {
			if (@mssql_next_result($rs)) {
				$this->columns = @mssql_num_fields($rs);
				$this->rows = @mssql_num_rows($rs);
				$ret = true;
			}
			else {
				$this->columns = 0;
				$this->rows = 0;
				$ret = false;
			}
		}
		return $ret;
	}

	function FreeResult($rs){
		if (is_resource($rs)) @mssql_free_result($rs);
	}

	function GetLastMessage(){
		$strError = @mssql_get_last_message();
		if (trim($strError) != "")
			return str_replace("\r\n", "\r", $strError);
		else
			return false;
	}
}

class cODBC extends cDBConstruct {

	 function cODBC() 
	 {
		  $this->cDBConstruct();
		  return true;
	 }

	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		$this->conn = @odbc_connect($strHost, $strUser, $strPassword) or $this->_DBConnectionError();
		$this->columns = 0;
		$this->rows = 0;
	}

	function Disconnect(){
		@odbc_close($this->conn);
		$this->conn = null;
	}

	function Query($strSQL){
		$this->columns = 0;
		$this->rows = 0;
		$rs = @odbc_exec($this->conn, $strSQL) or $this->_SQLError($strSQL,$this->GetLastMessage());
		if ($rs) {
			$this->columns = @odbc_num_fields($rs);
			$this->rows = @odbc_num_rows($rs);
		}
		return $rs;			
	}

	function ColumnName($rs, $col){
		if ($rs) return @odbc_field_name($rs, $col + 1);
	}

	function ColumnLength($rs, $col){
		if ($rs) return @odbc_field_len($rs, $col + 1);
	}

	function ColumnType($rs, $col){
		if ($rs) return @odbc_field_type($rs, $col + 1);
	}

	function FetchRow($rs,$type=2){
		$rowData = array();
		if (is_resource($rs)) {
			if (@odbc_fetch_row($rs)) {
				for ($i = 0; $i < $this->columns; $i++) {
					if ($type==1) {
						$rowData[@odbc_field_name($rs, $i + 1)] = @odbc_result($rs, $i + 1);
					}
					else if ($type==3) {
						$result = @odbc_result($rs, $i + 1);
						$rowData[@odbc_field_name($rs, $i + 1)] = $result;
						$rowData[] = $result;
					}
					else {
						$rowData[] = @odbc_result($rs, $i + 1);
					}
				}
			}
		}
		unset($key);
		unset($result);
		return $rowData;
	}

	function NumRows($rs){
		if (is_resource($rs)) return @odbc_num_rows($rs);
	}

	function NextResult($rs){
		$ret = true;
		return $ret;
	}

	function FreeResult($rs){
		if ($rs) @odbc_free_result($rs);
	}

	function GetLastMessage(){
		if ($this->conn) {
			$strError = @odbc_error($this->conn);
			if ($strError)
				return str_replace("\r\n", "\r", $strError);
			else
				return false;
		}
		else
			return false;
	}
}

class cMYSQL extends cDBConstruct {

	 function cMYSQL() 
	 {
		  $this->cDBConstruct();
		  return true;
	 }

	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		$this->conn = @mysql_connect($strHost, $strUser, $strPassword) or $this->_DBConnectionError();
		if (!@mysql_select_db($strDatabase, $this->conn)) {
			$this->Disconnect();
			$this->_DBSelectionError();
		}
		$this->columns = 0;
		$this->rows = 0;
	}

	function Disconnect(){
		@mysql_close($this->conn);
		$this->conn = null;
	}

	function Select($strSQL)	{
		if ((empty($strSQL)) || (!eregi("^select",$strSQL))) {
		  $this->_SQLError($strSQL,$this->GetLastMessage());
		  return false;
		} else {
		  $results = mysql_query($strSQL);
		  if ((!$results) || (empty($results))) {
		$this->_SQLError($strSQL,$this->GetLastMessage());
		return false;
		  } else {
		$i = 0;
		$data = array();
		while ($row = mysql_fetch_array($results)) {
			$data[$i] = $row;
			$i++;
		}
		mysql_free_result($results);
		return $data;
		  }
		}
	}

	function Query($strSQL){
		$this->columns = 0;
		$this->rows = 0;
		$rs = @mysql_query($strSQL) or $this->_SQLError($strSQL,$this->GetLastMessage());

		if (is_resource($rs)) {
			$this->columns = @mysql_num_fields($rs);
			$this->rows = @mysql_num_rows($rs);
		}
		return $rs;			
	}

	function ColumnName($rs, $col){
		if (is_resource($rs)) return @mysql_field_name($rs, intval($col));
	}

	function ColumnLength($rs, $col){
		if (is_resource($rs)) return @@mysql_field_len($rs, intval($col));
	}

	function ColumnType($rs, $col){
		if (is_resource($rs)) return @@mysql_field_type($rs, intval($col));
	}

	function FetchRow($rs,$type=MYSQL_BOTH){
		if (is_resource($rs)) return @mysql_fetch_array($rs);
	}

	function NumRows($rs){
		if (is_resource($rs)) return @mysql_num_rows($rs);
	}

	function NextResult($rs){
		return true;
	}

	function FreeResult($rs){
		if ($rs) @mysql_free_result($rs);
	}

	function GetLastMessage(){
		if ($this->conn) {
			$strError = @mysql_error($this->conn);
			if ($strError)
				return str_replace("\r\n", "\r", $strError);
			else
				return false;
		}
		else
			return false;
	}




}

class cDatabases {

	var $databaseTypes;

	var $currentDB;
	
	function cDatabases(){
		$this->databaseTypes = array();
		$this->currentDB = null;

		if (extension_loaded("fbsql")) {
			$db = new cFrontBase();
			$this->Register("FRONTBASE", $db);
		}

		if (extension_loaded("pgsql")) {
			$db = new cPostgreSQL();
			$this->Register("POSTGRES", $db);
		}

		if (extension_loaded("mssql")) {			
			$db = new cMSSQL();
			$this->Register("MSSQL", $db);
		}

		if (extension_loaded("odbc")) {
			$db = new cODBC();
			$this->Register("ODBC", $db);
		}

		if (extension_loaded("mysql")) {
			$db = new cMYSQL();
			$this->Register("MYSQL", $db);
		}
	}
	
	function Register($type, $handler){
		$this->databaseTypes[$type] = $handler;
	}
	
	function &Get($type, $set = 0){
		if ($set == 1)
			$this->Set($type);
		return $this->databaseTypes[strtoupper($type)];
	}

	function &Set($type){
		$this->currentDB = $this->databaseTypes[strtoupper($type)];
	}
	function Connect($strHost, $strUser, $strPassword, $strDatabase){
		return $this->currentDB->Connect($strHost, $strUser, $strPassword, $strDatabase);
	}

	function Disconnect(){
		$this->currentDB->Disconnect();
	}

	function Select($strSQL){
		return $this->currentDB->Select($strSQL);	
	}

	function Query($strSQL){
		return $this->currentDB->Query($strSQL);			
	}

	function ColumnName($rs, $col){
		return $this->currentDB->ColumnName($rs, $col);
	}

	function ColumnLength($rs, $col){
		return $this->currentDB->ColumnLength($rs, $col);
	}

	function ColumnType($rs, $col){
		return $this->currentDB->ColumnType($rs,$col);
	}

	function FetchRow($rs,$type=2){
		return $this->currentDB->FetchRow($rs,$type);
	}

	function NumRows($rs){
		return $this->currentDB->NumRows($rs);
	}

	function NextResult($rs){
		return $this->currentDB->NextResult($rs);
	}

	function FreeResult($rs){
		 $this->currentDB->FreeResult($rs);
	}

	function GetLastMessage(){
		return $this->currentDB->GetLastMessage();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ShowOptions($Catid, $Optid,$TypeName) {
	$sqlcat="SELECT * FROM option_values WHERE type_id='".$Optid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	while($rowcat=mysql_fetch_assoc($rescat)){
		$sqlval="SELECT * FROM category_options WHERE cat_id='".$Catid."' AND option_value_id='".$rowcat['id']."'";
		$resval=mysql_query($sqlval);
		if(mysql_num_rows($resval)){
			if($check==0){
				echo '<span>'.$TypeName.':</span>';
				echo '<select  name="SelOption_'.$Optid.'" id="SelOption_'.$Optid.'" onchange="javascript:InstantPrice();">';
				$check=1;
			}
			echo '<option value="'.$rowcat['id'].'">'.$rowcat['name'].'</option>';	
		}
	}
		if($check==1){
			echo '</select>';
		}

}
function ShowType($Catid,$Pid=0) {
	$sqlcat="SELECT * FROM products WHERE cat_id='".$Catid."' AND isseo='0' ";
	$rescat=mysql_query($sqlcat);
	$check=0;
	if(mysql_num_rows($rescat)){
		echo '<select name="select_type" id="select_type" onchange="javascript:InstantPrice();">';
		while($rowcat=mysql_fetch_assoc($rescat)){
			echo '<option  '.($rowcat['id']==$Pid?'selected="selected"':'').' value="'.$rowcat['id'].'"> '.$rowcat['ptitle'].'</option>';	
		}
		echo '</select>';
	}
}
function ShowType_edit($Catid,$Pid=0) {
	$sqlcat="SELECT * FROM products WHERE cat_id='".$Catid."' AND isseo='0' ";
	$rescat=mysql_query($sqlcat);
	$check=0;
	if(mysql_num_rows($rescat)){
		echo '<select class="form-control" id="sel1" name="select_type" id="select_type" onchange="javascript:InstantPrice();">';
		while($rowcat=mysql_fetch_assoc($rescat)){
			echo '<option  '.($rowcat['id']==$Pid?'selected="selected"':'').' value="'.$rowcat['id'].'">'.$rowcat['ptitle'].'</option>';	
		}
		echo '</select>';
	}
}
function ShowOptions_edit($Catid, $Optid,$TypeName,$arr_OptionType) {
	//echo $arr_OptionType['SelOption_'.$Optid];
	$sqlcat="SELECT * FROM option_values WHERE type_id='".$Optid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	while($rowcat=mysql_fetch_assoc($rescat)){
		$sqlval="SELECT * FROM category_options WHERE cat_id='".$Catid."' AND option_value_id='".$rowcat['id']."'";
		$resval=mysql_query($sqlval);
		
		if(mysql_num_rows($resval)){
			if($check==0){
				echo '<label for="sel1">'.$TypeName.':</label>';
				echo '<select class="form-control" id="sel1"  name="SelOption_'.$Optid.'" id="SelOption_'.$Optid.'" onchange="javascript:InstantPrice();">';
				$check=1;
			}
			
			echo '<option '.($arr_OptionType['SelOption_'.$Optid]==$rowcat['id']?'selected="selected"':'').' value="'.$rowcat['id'].'">'.$rowcat['name'].'</option>';	
		}
	}
		if($check==1){
			echo '</select><br>';
		}

}
function ShowCategory($Catid) {
	$sqlcat="SELECT title FROM category WHERE id='".$Catid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	$rowcat=mysql_fetch_assoc($rescat);
	return $rowcat['title'];
}
function ShowProductName($Proid) {
	$sqlcat="SELECT ptitle FROM products WHERE id='".$Proid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	$rowcat=mysql_fetch_assoc($rescat);
	return $rowcat['ptitle'];
}
function convertUtf8ToLatin($text) {
        $text = str_replace(
	    array(' ','&quot;','%',"/"," - ",":",'<','>','?',"#","^","`","'","=","!",":",".","..","*","&","__","- "," -","  ",',','`','“','”','"'),
	    array(' ','','' ,''," "," "," ","","","",""," ",""," "," "," ","","","","",""," "," "," ",'','','','',''),
	    $text);
	   
	    $chars = array("a","A","e","E","o","O","u","U","i","I","d", "D","y","Y");
	   
	    $uni[0] = array("á","à","ạ","ả","ã","â","ấ","ầ", "ậ","ẩ","ẫ","ă","ắ","ằ","ặ","ẳ","ẵ");
	    $uni[1] = array("Á","À","Ạ","Ả","Ã","Â","Ấ","Ầ", "Ậ","Ẩ","Ẫ","Ă","Ắ","Ằ","Ặ","Ẳ","Ẵ");
	    $uni[2] = array("é","è","ẹ","ẻ","ẽ","ê","ế","ề" ,"ệ","ể","ễ");
	    $uni[3] = array("É","È","Ẹ","Ẻ","Ẽ","Ê","Ế","Ề" ,"Ệ","Ể","Ễ");
	    $uni[4] = array("ó","ò","ọ","ỏ","õ","ô","ố","ồ", "ộ","ổ","ỗ","ơ","ớ","ờ","ợ","ở","ỡ");
	    $uni[5] = array("Ó","Ò","Ọ","Ỏ","Õ","Ô","Ố","Ồ", "Ộ","Ổ","Ỗ","Ơ","Ớ","Ờ","Ợ","Ở","Ỡ");
	    $uni[6] = array("ú","ù","ụ","ủ","ũ","ư","ứ","ừ", "ự","ử","ữ");
	    $uni[7] = array("Ú","Ù","Ụ","Ủ","Ũ","Ư","Ứ","Ừ", "Ự","Ử","Ữ");
	    $uni[8] = array("í","ì","ị","ỉ","ĩ");
	    $uni[9] = array("Í","Ì","Ị","Ỉ","Ĩ");
	    $uni[10] = array("đ");
	    $uni[11] = array("Đ");
	    $uni[12] = array("ý","ỳ","ỵ","ỷ","ỹ");
	    $uni[13] = array("Ý","Ỳ","Ỵ","Ỷ","Ỹ");
	   
	    for($i=0; $i<=13; $i++) {
	        $text = str_replace($uni[$i],$chars[$i],$text);
	    }
	    
	    $text = str_replace(' ', '-', $text);
	    $text = strtolower($text);
	    
	    return $text;
	}
?>
