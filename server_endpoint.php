<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the JSON data from the request body
  $data = json_decode(file_get_contents('php://input'), true);

  // Get the latitude and longitude values
  $latitude = $data['latitude'];
  $longitude = $data['longitude'];

  // TODO: Validate and sanitize the data (e.g., check if values are present, validate latitude and longitude range, etc.)

  // Save the geolocation data to the database (Replace 'your_database', 'your_username', 'your_password' with your actual database credentials)
  $connection = new mysqli('localhost', 'root', '', 'your_database_name');
  if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
  }

  $sql = "INSERT INTO client_geolocation (latitude, longitude) VALUES ('$latitude', '$longitude')";
  if ($connection->query($sql) === TRUE) {
    echo json_encode(array('status' => 'success', 'message' => 'Location data saved successfully'));
  } else {
    echo json_encode(array('status' => 'error', 'message' => 'Error saving location data: ' . $connection->error));
  }

  $connection->close();
}
?>
