<?php
include ("sql_data/sql_login.php");

//Following code is located in a seperate file and needs for DB to run
//
/*
$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "DBname";
*/
include ("functions.php");
createDB($servername, $username, $password, $dbname);
createTables($servername, $username, $password, $dbname);
?>