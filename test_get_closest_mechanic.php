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
    $sql = "SELECT *, 
        (6371 * acos(cos(radians($clientLatitude)) * cos(radians(mechanic_address.latitude)) * cos(radians(mechanic_address.longitude) - radians($clientLongitude)) + sin(radians($clientLatitude)) * sin(radians(mechanic_address.latitude))))
        AS distance
        FROM mechanic_address
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
