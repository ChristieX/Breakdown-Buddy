<!-- ?php -->
<!-- include('db_connect.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT latitude, longitude FROM client_geolocation ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clientLatitude = $row['latitude'];
    $clientLongitude = $row['longitude'];

    header('Content-type: application/json');
    echo json_encode(['latitude' => $clientLatitude, 'longitude' => $clientLongitude]);
} -->