<?php
// Include the database connection file
include_once 'db_connect.php';

// Start a session
session_start();

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $username = $_POST['login-username'];
    $password = $_POST['login-password'];

    // SQL query to retrieve user information based on the username
    $mechanic_query = "SELECT * FROM mechanic WHERE username = '$username'";
    $customer_query = "SELECT * FROM customer WHERE username = '$username'";
    $admin_query = "SELECT * FROM admin WHERE username = '$username'";

    // Execute the queries
    $mechanic_result = $conn->query($mechanic_query);
    $customer_result = $conn->query($customer_query);
    $admin_result = $conn->query($admin_query);

    // Check if a matching user is found in the mechanic table
    if ($mechanic_result->num_rows > 0) {
        $row1 = $mechanic_result->fetch_assoc();
        $hashed_password = $row1['password'];

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Passwords match, check mechanic status
            $mechanic_status = $row1['status'];

            // Store mechanic_id in the session variable
            $_SESSION['user_id'] = $row1['mechanic_id'];

            // Redirect based on mechanic status
            if ($mechanic_status == 'pending' || $mechanic_status == 'disapproved') {
                echo '<script> window.location.href = "waiting.php";</script>';
            } else {
                echo '<script>alert("Mechanic login successful! Redirecting to mechanic dashboard."); window.location.href = "mechanic_dashboard.php";</script>';
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

            // Store customer_id in the session variable
            $_SESSION['user_id'] = $row2['user_id'];

            echo '<script>alert("Customer login successful! Redirecting to customer dashboard."); window.location.href = "homepage.html";</script>';
        } else {
            // Incorrect password for customer
            echo '<script>alert("Invalid password for customer."); window.location.href = "login.html";</script>';
        }
    }elseif ($admin_result->num_rows > 0) {
        $row3 = $admin_result->fetch_assoc();

        if ($password == $row3['password']) {
            // Passwords match, perform login actions for customer

            $_SESSION['user_id'] = $row3['admin_id'];

            echo '<script>alert("admin login successful! Redirecting to admin dashboard. "); window.location.href = "admintest.php";</script>';
        } else {
            // Incorrect password for customer
            echo '<script>alert("Invalid password for admin."); window.location.href = "login.html";</script>';
        }
    } else {
        // No matching user found in either table
        echo '<script>alert("Invalid username or password."); window.location.href = "login.html";</script>';
    }
}

// Close the database connection
$conn->close();
?>
