<?php
include('db_connect.php');
echo $_SERVER['REQUEST_METHOD'];

// Check if the user is logged in and if the user ID is available in the session
session_start();

if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Check if the request is a POST request (form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the mechanic ID is set in the POST data
        if (isset($_POST['mechanic_id'])) {
            // Sanitize the input
            $mechanicId = $conn->real_escape_string($_POST['mechanic_id']);

            // Insert the data into the 'incident' table
            $insertSql = "INSERT INTO incident (customer_id, mechanic_id) VALUES ('$userId', '$mechanicId')";
            $conn->query($insertSql);
            $_SESSION['incident_id'] = $conn->insert_id;

            // You can add additional logic or redirection here if needed
        } else {
            // Handle the case where the mechanic ID is not set in the POST data
            echo "Mechanic ID is not set.";
        }
    } else {
        // Handle the case where the request is not a POST request
        echo "Invalid request method.";
    }
} else {
    // Handle the case where the user is not logged in or the user ID is not available in the session
    echo "User not logged in or user ID not available.";
}
header("Location: assistance.php");

// Close the database connection
$conn->close();
?>
