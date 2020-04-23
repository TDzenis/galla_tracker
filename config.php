<?php

$servername = "localhost";
$username = "Tomass";
$password = "9466587Tomy94";
$dbname = "myDB";

$mysqli = new mysqli($servername,$username,$password,$dbname);

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
?>