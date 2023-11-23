<?php
include('db_connect.php');
session_start();
// Get the mechanic ID and status from the URL parameters
$mechanicId = isset($_GET['mechanic_id']) ? $_GET['mechanic_id'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$admin_id = $_SESSION['user_id'];
if ($mechanicId && ($status == 'approved' || $status == 'disapproved')) {
    $sql = "UPDATE mechanic SET status = '$status',admin_id = '$admin_id' WHERE mechanic_id = $mechanicId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}

// Close the database connection
mysqli_close($conn);
?>
