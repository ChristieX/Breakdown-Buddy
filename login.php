<?php
// Start the session
session_start();

// Include your database connection file here
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get login form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username exists in either customer or mechanic table
    $customer_query = "SELECT * FROM customer WHERE username='$username'";
    $mechanic_query = "SELECT * FROM mechanic WHERE username='$username'";

    $customer_result = $conn->query($customer_query);
    $mechanic_result = $conn->query($mechanic_query);

    if ($customer_result->num_rows > 0 || $mechanic_result->num_rows > 0) {
        // Username already exists
        echo "Username already taken. Please choose a different username.";
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $hashed_password;
        $_SESSION['email'] = $email;
        header("Location: signup.html"); // Change this to the actual page you want to redirect to
        exit();
    }

    // Close the database connection
    $conn->close();
}
?>
