<?php
// Assuming you have a MySQL database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vehicle_breakdown";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $date_of_birth = $_POST["date_of_birth"];
    $address = $_POST["address"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $employment_history = $_POST["employment_history"];

    // Upload files and store file paths in the database
    $working_license_path = uploadFile("working_license");
    $proof_identity_path = uploadFile("proof_identity");
    $additional_certifications_path = uploadFile("additional_certifications");

    // SQL query to insert data into the database
    $sql = "INSERT INTO mechanics1 (full_name, date_of_birth, address, contact_number, email, working_license, proof_identity, employment_history, additional_certifications)
            VALUES ('$full_name', '$date_of_birth', '$address', '$contact_number', '$email', '$working_license_path', '$proof_identity_path', '$employment_history', '$additional_certifications_path')";

    if ($conn->query($sql) === TRUE) {
        header("Location: waiting.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function uploadFile($fileInputName) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES[$fileInputName]["name"]);
    move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile);
    return $targetFile;
}

$conn->close();
?>
