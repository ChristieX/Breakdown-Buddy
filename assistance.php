<?php
// Start or resume a session
session_start();
include('db_connect.php');

// Check if geolocation ID is set in the session
if (!isset($_SESSION['incident_id'])) {
    echo 'Error: Geolocation ID not found in the session.';
    exit();
}

$incident_id = $_SESSION['incident_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Prepare and execute SQL statement to update data in the incident table
    $stmt = $conn->prepare("UPDATE incident SET description = ?, location = ? WHERE incident_id = ?");
    $stmt->bind_param("sss", $description, $location, $incident_id);
    $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

    // Display success message
    echo "Details updated for Geolocation ID: $incident_id<br>Description: $description<br>Location: $location";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
</head>
<body>
    <h2>Update Details</h2>
    <form action="" method="post">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
