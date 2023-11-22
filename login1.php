<?php
// Include the database connection file
include_once 'db_connect.php';

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $username = $_POST['login-username'];
    $password = $_POST['login-password'];

    // SQL query to retrieve hashed password based on the username for mechanic
    $mechanic_query = "SELECT * FROM mechanic WHERE username = '$username'";
    // SQL query to retrieve hashed password based on the username for customer
    $customer_query = "SELECT * FROM customer WHERE username = '$username'";

    // Execute the queries
    $mechanic_result = $conn->query($mechanic_query);
    $customer_result = $conn->query($customer_query);

    // Check if a matching user is found in the mechanic table
    if ($mechanic_result->num_rows > 0) {
        $row1 = $mechanic_result->fetch_assoc();
        $hashed_password = $row1['password'];

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Passwords match, check mechanic status
            $mechanic_status = $row1['status'];

            // Redirect based on mechanic status
            if ($mechanic_status == 'pending' || $mechanic_status == 'disapproved') {
                echo '<script>alert("Mechanic login successful! Redirecting to waiting page."); window.location.href = "waiting.html";</script>';
            } else {
                echo '<script>alert("Mechanic login successful! Redirecting to mechanic dashboard."); window.location.href = "mechanic_profile.html";</script>';
            }
        } else {
            // Incorrect password for mechanic
            echo '<script>alert("Invalid password for mechanic."); window.location.href = "login.html";</script>';
        }
    }
    // Check if a matching user is found in the customer table
    elseif ($customer_result->num_rows > 0) {
        $row2 = $customer_result->fetch_assoc();

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $row2['password'])) {
            // Passwords match, perform login actions for customer
            echo '<script>alert("Customer login successful! Redirecting to customer dashboard."); window.location.href = "homepage.html";</script>';
        } else {
            // Incorrect password for customer
            echo '<script>alert("Invalid password for customer."); window.location.href = "login.html";</script>';
        }
    } else {
        // No matching user found in either table
        echo '<script>alert("Invalid username or password."); window.location.href = "login.html";</script>';
    }
}

// Close the database connection
$conn->close();
?>
