<?php
session_start();
// Include your database connection code (db_connect.php or similar)
include('db_connect.php');

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract data from the request
    $mechanicId = $data['mechanic_id'];
    $userId = $_SESSION['user_id']; // Assuming you have the user_id stored in the session
    $geolocationId = $_SESSION['geolocation_id']; // Assuming you have the geolocation_id stored in the session

    // Validate and sanitize the data (perform validation based on your requirements)

    // Insert data into the incident table
    $sql = "INSERT INTO incident (mechanic_id, customer_id, geolocation_id) VALUES ('$mechanicId', '$userId', '$geolocationId')";

    if ($conn->query($sql) === TRUE) {
        // Successfully inserted into the incident table
        $response = array('status' => 'success', 'message' => 'Incident saved successfully');
        header('Content-Type: application/json'); // Set Content-Type header
        echo json_encode($response);
    } else {
        // Error in the database operation
        $response = array('status' => 'error', 'message' => 'Error saving incident: ' . $conn->error);
        header('Content-Type: application/json'); // Set Content-Type header
        http_response_code(500); // Set a 500 Internal Server Error status code
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    header('Content-Type: application/json'); // Set Content-Type header
    http_response_code(400); // Set a 400 Bad Request status code
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
