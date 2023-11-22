<?php
include('db_connect.php');

// Get the mechanic ID and status from the URL parameters
$mechanicId = isset($_GET['mechanic_id']) ? $_GET['mechanic_id'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;

if ($mechanicId && ($status == 'accepted' || $status == 'declined')) {
    $sql = "UPDATE mechanic SET status = '$status' WHERE mechanic_id = $mechanicId";
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
