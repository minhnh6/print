<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if($_SERVER['HTTP_HOST']=='localhost') {
	define('MYSQL_HOST','localhost');							
	define('MYSQL_DB_USER', 'i2682996_wp1');										
	define('MYSQL_DB_PASS', 'Z#fYjORgig19V(J^sm@22#.2');										
	define('MYSQL_DB_NAME', 'printing_period');
	define('RDBMS','MYSQL');

	define('LINK_PATH','/print/');		
	define('LINK_PATH2','/print');		
	define('IMG_PATH','/print/images/');		
	define('INCLUDE_PATH','/print/inc/');		
	define('CONTENT_PATH','/print/inc/content/');	
	define('INC_ROOT','/print/');	
	define('ROOT_PATH','/print/');
	define('LINK_PATH2','/print');	
} else {
	define('MYSQL_HOST','localhost');							
	define('MYSQL_DB_USER', 'i2682996_wp1');										
	define('MYSQL_DB_PASS', 'Z#fYjORgig19V(J^sm@22#.2');											
	define('MYSQL_DB_NAME', 'printing_period');
	define('RDBMS','MYSQL');
	
	define('LINK_PATH','/');	
	define('LINK_PATH2','/');		
	define('IMG_PATH','/images/');		
	define('INCLUDE_PATH','/inc/');	
	define('CONTENT_PATH','/inc/content/');	
	define('INC_ROOT','/');	
	define('ROOT_PATH','/home/users/printing/public_html/print/');	
}
mysql_connect(MYSQL_HOST,MYSQL_DB_USER,MYSQL_DB_PASS) or die (mysql_error());												
mysql_select_db(MYSQL_DB_NAME);						
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>