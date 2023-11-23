<?php
// echo "hi";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connect.php');

    // Get client's location from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $clientLatitude = $data['latitude'];
    $clientLongitude = $data['longitude'];

    // TODO: Validate and sanitize the data

    // Use the Haversine formula to calculate distances and get closest mechanics
    $sql = "SELECT ma.*, 
        (6371 * acos(cos(radians($clientLatitude)) * cos(radians(ma.latitude)) * cos(radians(ma.longitude) - radians($clientLongitude)) + sin(radians($clientLatitude)) * sin(radians(ma.latitude))))
        AS distance
        FROM mechanic_address ma
        INNER JOIN mechanic m ON ma.mechanic_id = m.mechanic_id
        WHERE m.status = 'approved'
        ORDER BY distance ASC";

$result = $conn->query($sql);

    if ($result) {
        $mechanics = array();

        // echo "Client Latitude: " . $clientLatitude . ", Client Longitude: " . $clientLongitude;

        while ($row = $result->fetch_assoc()) {
            $mechanics[] = array(
                'mechanic_id' => $row['mechanic_id'],
                'companyName' => $row['companyName'],
                'state' => $row['state'],
                'city' => $row['city'],
                'shopName' => $row['streetName'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'distance' => $row['distance']
            );
        }
        

        // Set the Content-Type header to indicate JSON response
        header('Content-Type: application/json');

        // Return the list of mechanics as JSON
        echo json_encode($mechanics);
    } else {
        // Set the Content-Type header to indicate JSON response
        header('Content-Type: application/json');

        echo json_encode(array('status' => 'error', 'message' => 'Error fetching mechanics: ' . $conn->error));
    }

    $conn->close();
}
?>
