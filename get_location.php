<?php
// Replace 'your_database', 'your_username', 'your_password' with your actual database credentials
$connection = new mysqli('localhost', 'root', '', 'your_database_name');
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT latitude, longitude FROM client_geolocation ORDER BY id DESC LIMIT 1";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $latitude = $row['latitude'];
  $longitude = $row['longitude'];
  echo json_encode(array('status' => 'success', 'latitude' => $latitude, 'longitude' => $longitude));
} else {
  echo json_encode(array('status' => 'error', 'message' => 'No location data found.'));
}

$connection->close();
?>