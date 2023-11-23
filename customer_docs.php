<?php
// Start the session
session_start();

// Include your database connection file here
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_SESSION['username'];    
    $name_first = $_POST["name_first"];
    $name_middle = $_POST["name_middle"];
    $name_last = $_POST["name_last"];
    $phone_number = $_POST["phone_number"];
    $driving_license = $_POST["driving_license"];
    $vehicle_number = $_POST["vehicle_number"];

    // Prepare and execute SQL query
    $sql = "UPDATE customer 
            SET name_first='$name_first', 
                name_middle='$name_middle', 
                name_last='$name_last', 
                phone_number='$phone_number', 
                license='$driving_license', 
                vehicle_number='$vehicle_number' 
            WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: homepage.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
