<?php
// Establish database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle sign-up form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    // Perform necessary checks
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password)) {
        echo "Please fill in all the fields.";
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Email already exists. Please use a different email.";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (first_name, last_name, email, phone, password) 
                    VALUES ('$first_name', '$last_name', '$email', '$phone', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "Sign-up successful!";
                // Redirect to the next page
                echo "<script>redirectToNextPage();</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>
