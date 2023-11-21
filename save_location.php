<?php
session_start();
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the JSON data from the request body
  $data = json_decode(file_get_contents('php://input'), true);

  // Get the latitude and longitude values
  $latitude = $data['latitude'];
  $longitude = $data['longitude'];
  $customer_id = $_SESSION['user_id'];

  // TODO: Validate and sanitize the data (e.g., check if values are present, validate latitude and longitude range, etc.)

  include('db_connect.php');
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO client_geolocation (latitude, longitude,customer_id) VALUES ('$latitude', '$longitude','$customer_id')";
  if ($conn->query($sql) === TRUE) {
    echo json_encode(array('status' => 'success', 'message' => 'Location data saved successfully'));
  } else {
    echo json_encode(array('status' => 'error', 'message' => 'Error saving location data: ' . $conn->error));
  }

  $conn->close();
}
?>