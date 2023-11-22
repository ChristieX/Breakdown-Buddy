<?php
include('db_connect.php');

// Get the image ID from the URL parameter
$imageId = isset($_GET['image_id']) ? $_GET['image_id'] : null;

if ($imageId) {
    $sql = "SELECT working_license FROM mechanic WHERE mechanic_id = $imageId";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Display the image
        header("Content-type: image/jpeg");  // Adjust based on your image type (e.g., image/png for PNG)
        echo $row['working_license'];
    } else {
        echo "Image not found.";
    }
} else {
    echo "Invalid image ID.";
}

// Close the database connection
mysqli_close($conn);
?>
