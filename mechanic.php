<?php
// Start the session
session_start();
// Include your database connection file here
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];   
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address_state = $_POST["address_state"];
    $address_street = $_POST["address_street"];
    $address_city = $_POST["address_city"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $employment_history = $_POST["employment_history"];

    $working_license = $_FILES['working_license']['tmp_name'];
    $imgContent1 = addslashes(file_get_contents($working_license));
    $proof_identity = $_FILES['proof_identity']['tmp_name'];
    $imgContent2 = addslashes(file_get_contents($proof_identity));

    // Geocode the address to obtain latitude and longitude
    $address = urlencode("$address_street, $address_city, $address_state");
    $apiKey = "13c22622b8ab4d18a7b0da680ad2a475"; // Replace with your OpenCage API key
    $geocodeUrl = "https://api.opencagedata.com/geocode/v1/json?q=$address&key=$apiKey";

    $ch = curl_init($geocodeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $geocodeResponseJson = curl_exec($ch);
    $geocodeResponseStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($geocodeResponseStatus == 200) {
        $geocodeResponse = json_decode($geocodeResponseJson, true);

        if ($geocodeResponse && $geocodeResponse['results'] && !empty($geocodeResponse['results'][0])) {
            $latitude = $geocodeResponse['results'][0]['geometry']['lat'];
            $longitude = $geocodeResponse['results'][0]['geometry']['lng'];

            // SQL query to update data in the mechanic table
            $sql_mechanic = "UPDATE mechanic SET 
            first_name='$first_name',
            last_name='$last_name',
            phone_number='$contact_number',
            email='$email',
            working_license= '$imgContent1',
            proof_of_identity='$imgContent2'
            WHERE username='$username'";

            // Execute the main query
            if ($conn->query($sql_mechanic) === TRUE) {
                // Check if the record exists in mechanic_address
                $mechanic_id = $_SESSION['user_id'];
                $check_query = "SELECT * FROM mechanic_address WHERE mechanic_id = '$mechanic_id'";
                $check_result = $conn->query($check_query);

                if ($check_result->num_rows > 0) {
                    // Update the existing record
                    $sql_mechanic_address = "UPDATE mechanic_address SET 
                    state='$address_state',
                    city='$address_city',
                    streetName='$address_street',
                    latitude='$latitude',
                    longitude='$longitude'
                    WHERE mechanic_id='$mechanic_id'";
                } else {
                    // Insert a new record
                    $sql_mechanic_address = "INSERT INTO mechanic_address (mechanic_id, state, city, streetName, latitude, longitude) 
                    VALUES ('$mechanic_id','$address_state','$address_city','$address_street', '$latitude', '$longitude')";
                }

                if ($conn->query($sql_mechanic_address) === TRUE) {
                    // Check the mechanic status
                    $status_query = "SELECT status FROM mechanic WHERE username='$username'";
                    $status_result = $conn->query($status_query);
                    if ($status_result->num_rows > 0) {
                        $row = $status_result->fetch_assoc();
                        $mechanic_status = $row['status'];

                        // Redirect based on mechanic status
                        if ($mechanic_status == 'pending' || $mechanic_status == 'disapprove') {
                            header("Location: waiting.html");
                            exit();
                        } else {
                            header("Location: homepage.html");
                            exit();
                        }
                    } else {
                        echo "Error: Unable to retrieve mechanic status.";
                    }
                } else {
                    echo "Error: " . $sql_mechanic_address . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql_mechanic . "<br>" . $conn->error;
            }
        } else {
            echo "Error decoding geocode response or empty results.";
        }
    } else {
        echo "Error in geocode request. HTTP Status: $geocodeResponseStatus";
    }
}
$conn->close();
?>
