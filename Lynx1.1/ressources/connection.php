<?php
require("constantes.php");

//CONNEXION A LA BASE CLIENTS



// 1. Create a database connection
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select = mysql_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}


//CONNEXION A LA BASE CAKESHOP



$connection_cakeshop = mysql_connect(DB_SERVER_cakeshop,DB_USER_cakeshop,DB_PASS_cakeshop);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select_cakeshop = mysql_select_db(DB_NAME_cakeshop,$connection_cakeshop);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}

//CONNEXION A LA BASE THELIA CAKESHOP

$connection_cakeshop_thelia = mysql_connect(DB_SERVER_cakeshop_thelia,DB_USER_cakeshop_thelia,DB_PASS_cakeshop_thelia);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select_cakeshop_thelia = mysql_select_db(DB_NAME_cakeshop_thelia,$connection_cakeshop_thelia);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}


?>
