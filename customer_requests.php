<?php
// Start the session
session_start();

// Include your database connection file here
include('db_connect.php');
if (!isset($_SESSION['user_id'])) {
    // Set 'user_id' based on your authentication logic
    $user_id = $_SESSION['user_id']; // Replace with the actual user ID
}
// Fetch incident details for the logged-in mechanic (adjust the query based on your database structure)
$user_id = $_SESSION['user_id']; // Assuming you have mechanic ID stored in session after login
/*$sql = "SELECT incident.incident_id, incident.description, incident.customer_id, customer.username
        FROM incident
        INNER JOIN customer ON incident.customer_id = customer.user_id";*/

$sql = "SELECT i.incident_id, i.customer_id, i.description, c.username AS customer_name FROM incident i
        INNER JOIN customer c ON i.customer_id = c.user_id 
        WHERE i.mechanic_id = '$user_id'";
//$sql = "SELECT incident_id, customer_id, description FROM incident WHERE mechanic_id = '$user_id'";
$result = $conn->query($sql);

$incidentDetails = array();


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incidentDetails[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($incidentDetails);

$conn->close();
?>
