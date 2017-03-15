<?php
define("DR_BASE_ROOT","/");
define("DR_ADMIN_BASE_ROOT",DR_BASE_ROOT);
define("DR_ROOT","http://bnews.local:8080/");
define("DR_SSLROOT","http://bnews.local:8080/");
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