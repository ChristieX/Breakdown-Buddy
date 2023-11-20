<?php
// Replace 'your_database', 'your_username', 'your_password' with your actual database credentials
// $connection = new mysqli('localhost', 'root', '', 'vehicle_breakdown');
// if ($connection->connect_error) {
//   die("Connection failed: " . $connection->connect_error);
// }
include('db_connect.php');

$sql = "SELECT latitude, longitude FROM client_geolocation ORDER BY geolocation_id DESC LIMIT 1";
$result = $conn->query($sql);
// $connection = new mysqli('localhost', 'root', '', 'vehicle_breakdown');
// if ($connection->connect_error) {
//   die("Connection failed: " . $connection->connect_error);
// }
include('db_connect.php');

$sql = "SELECT latitude, longitude FROM client_geolocation ORDER BY geolocation_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $latitude = $row['latitude'];
  $longitude = $row['longitude'];
  echo json_encode(array('status' => 'success', 'latitude' => $latitude, 'longitude' => $longitude));
} else {
  echo json_encode(array('status' => 'error', 'message' => 'No location data found.'));
}

$conn->close();
?>
