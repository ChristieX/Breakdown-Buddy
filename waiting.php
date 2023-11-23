<!DOCTYPE html>
<html>
<head>
  <title>Application Status</title>
  <style>
    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 100px;
    }
    h1 {
      color: #333;
    }
    p {
      font-size: 18px;
      color: #555;
    }
  </style>
</head>
<body>
  <?php
    // Start the session
    session_start();

    // Check if the user is logged in and the user_id is set in the session
    if(isset($_SESSION['user_id'])) {
      // Get the user ID from the session
      $user_id = $_SESSION['user_id'];

      include('db_connect.php');

      // Fetch the mechanic_id from the user_id table
      $sql = "SELECT mechanic_id, status FROM mechanic WHERE mechanic_id = $user_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mechanic_id = $row['mechanic_id'];
        $status = $row['status'];

        // Check if the status is approved
        if ($status == 'approved') {
          // Redirect to mechanic_dashboard.php
          header("Location: mechanic_dashboard.php");
          exit();
        }
      }

      // Close the database connection
      $conn->close();
    }
  ?>

  <h1>Application Status</h1>
  <p>Your application has been submitted and is currently pending approval. Please wait for further communication regarding your application status.</p>
</body>
</html>
