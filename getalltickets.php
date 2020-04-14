<?php
require("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Create database
$sql = "SELECT * FROM `ticket`";

$result = $conn->query($sql);

    $response = array();

  while ($row = $result->fetch_assoc()) {
    $response[] = $row;
  }
  header('Content-type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
?>
