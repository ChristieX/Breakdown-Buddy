<?php
// Start the session
session_start();

// Include your database connection file here
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_SESSION['username'];    
    $driving_license = $_POST["driving_license"];
    $vehicle_number = $_POST["vehicle_number"];

    // Prepare and execute SQL query
    $sql = "UPDATE customer SET license='$driving_license', vehicle_number='$vehicle_number' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: homepage.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
