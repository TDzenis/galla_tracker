<?php
require("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Create database
$sql = "SELECT * FROM `ticket` LIMIT 2;"; //replace LIMIT 3 with how many records you want returned

$result = $conn->query($sql);

    $response = array();

  while ($row = $result->fetch_assoc()) {
    $response[] = $row;
  }
  header('Content-type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
?>
