php 
<?php
// Start the session
session_start();
// Include your database connection file here
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];  
    $mechanic_id = $_SESSION['user_id']; 
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    //$date_of_birth = $_POST["date_of_birth"];
    $address_state = $_POST["address_state"];
    $address_city = $_POST["address_city"];
    $address_street = $_POST["address_street"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $employment_history = $_POST["employment_history"];

    $working_license = $_FILES['working_license']['tmp_name'];
    $imgContent1 = addslashes(file_get_contents($working_license));
    $proof_identity = $_FILES['proof_identity']['tmp_name'];
    $imgContent2 = addslashes(file_get_contents($proof_identity));
    //$additional_certifications = $_FILES['additional_certifications']['tmp_name'];
    //$imgContent3 = addslashes(file_get_contents($additional_certifications));
    //additional_requirements='$imgContent3' 
    // Upload files and store file paths in the database
    //$working_license_path = uploadFile("working_license");
    //$proof_identity_path = uploadFile("proof_identity");
    //$additional_certifications_path = uploadFile("additional_certifications");
    //address_street='$address_street',


    // SQL query to insert data into the database
    $sql = "UPDATE mechanic SET 
    first_name='$first_name',
    last_name='$last_name',

    phone_number='$contact_number',
    email='$email',
    working_license= '$imgContent1',
    proof_of_identity='$imgContent2',

    WHERE username='$username'";

    $sql = "INSERT INTO mechanic_address (id, state, city, phone) VALUES('$mechanic_id','$address_state','$address_city','$contact_number')";


    if ($conn->query($sql) === TRUE) {
        header("Location: homepage.html");
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