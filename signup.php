<?php
// Start the session
session_start();

include('db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user type from the form
    $user_type = $_POST['user_type'];
    echo"{$user_type}";
    
    // Rest of your form data
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $email = $_SESSION['email'];

    // Insert data into the appropriate table based on user type
    $table_name = ($user_type == 'mechanic') ? 'mechanic' : 'customer';
    $sql = "INSERT INTO $table_name (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        
        echo "Data added successfully!";
        $_SESSION['user_id'] = $conn->insert_id;
        if($user_type == 'mechanic')
            {header("Location: mechanic_docs.html");}
        else
            {header("Location: customer_docs.html");}
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: login.html"); 
    exit();
}
?>
