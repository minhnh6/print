<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(!isset($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST'] = "";
if(!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = "";

$base_url  =  ((isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$full_path = ((isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if($_SERVER['HTTP_HOST']=='localhost') {
	define('MYSQL_HOST','localhost');							
	define('MYSQL_DB_USER', 'root');										
	define('MYSQL_DB_PASS', '');										
	define('MYSQL_DB_NAME', 'printing_printing');
	define('RDBMS','MYSQL');
	
	define('LINK_PATH',$base_url);
         define('FULL_PATH',$full_path);
	define('LINK_PATH2','/print');		
	define('IMG_PATH','/print/images/');		
	define('INCLUDE_PATH','/print/inc/');		
	define('CONTENT_PATH','/print/inc/content/');	
	define('INC_ROOT','/print/');	
	define('ROOT_PATH','/print/');
	define('LINK_PATH2','/print');	
} else {
	define('MYSQL_HOST','localhost');							
	define('MYSQL_DB_USER', 'root');										
	define('MYSQL_DB_PASS', '');										
	define('MYSQL_DB_NAME', 'printing_printing');
	define('RDBMS','MYSQL');
							
	define('LINK_PATH',$base_url);	
         define('FULL_PATH',$full_path);
	define('LINK_PATH2','/print/');		
	define('IMG_PATH','/print/images/');		
	define('INCLUDE_PATH','/print/inc/');	
	define('CONTENT_PATH','/print/inc/content/');	
	define('INC_ROOT','/');
	define('ROOT_PATH','/usr/home/printing/public_html/print/');
}						
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define("DR_BASE_ROOT","");
define("DR_ADMIN_BASE_ROOT",DR_BASE_ROOT);
define("DR_ROOT","http://dalocthinh.com/print/");
define("DR_SSLROOT","http://dalocthinh.com/print/");
define("DR_IMAGES",DR_ROOT."images/");
define("DR_ADMIN_ROOT",DR_ROOT."admin/");
define("DR_ADMIN_IMAGES",DR_ADMIN_ROOT."images/");



define("TB_CATEGORY","category");
define("TB_PRODUCTS","products");
define("TB_ORDER","tbl_order");
define("TB_ORDER_DETAILS","tbl_order_details");
define("TB_SHOPPING_CART","tbl_shopcart");
define("TB_USERS","tbl_users");

require("database.inc");
$dbh = &new cDatabases();
$dbh->Set(RDBMS);
$dbh->Connect(MYSQL_HOST,MYSQL_DB_USER,MYSQL_DB_PASS,MYSQL_DB_NAME); 

$dbh2 = &new cDatabases();
$dbh2->Set(RDBMS);
$dbh2->Connect(MYSQL_HOST,MYSQL_DB_USER,MYSQL_DB_PASS,MYSQL_DB_NAME); 

$dbh3 = &new cDatabases();
$dbh3->Set(RDBMS);
$dbh3->Connect(MYSQL_HOST,MYSQL_DB_USER,MYSQL_DB_PASS,MYSQL_DB_NAME); 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>