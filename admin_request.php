<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="template.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanics with Pending Status</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px; /* Adjust margin top as needed */
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .hidden-image {
            display: none;
        }
        .show_license{
          background: #3E28A9;
          color: #fff;
          border-radius: 30px;
          padding: 10px 20px;
          cursor: pointer;
          display: block;
          transition-duration: 0.5s;
          border: 0;
          outline: none;
          text-decoration: none;
        }
        .approve-btn{
          /* Apply styles similar to the .button class */
          background: #4CAF50;
            color: #fff;
            border-radius: 30px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
            transition-duration: 0.5s;
            margin-right: 10px;
            border: 0;
            outline: none;
            text-decoration: none; /* Ensures button text doesn't have underline */
        }
        .disapprove-btn {
            /* Apply styles similar to the .button class */
            background: #c1121f;
            color: #fff;
            border-radius: 30px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
            transition-duration: 0.5s;
            border: 0;
            outline: none;
            text-decoration: none; /* Ensures button text doesn't have underline */
        }
    </style>
    <script>
        function showImage(imageId) {
            var imageElement = document.getElementById('image-' + imageId);
            if (imageElement.style.display === 'none') {
                imageElement.style.display = 'table-row';
            } else {
                imageElement.style.display = 'none';
            }
        }

        function updateStatus(mechanicId, status) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Reload the page after the status is updated
                    location.reload();
                }
            };
            xhttp.open("GET", "update_status.php?mechanic_id=" + mechanicId + "&status=" + status, true);
            xhttp.send();
        }
    </script>
</head>
<body>
<header>
      <button class="button" onclick="window.location.href = 'login.html';">Logout</button>
      <h1>BREAKDOWN BUDDY</h1>
    </header>
    <nav>
      <ul>
        <li><a href="admintest.html">Home</a></li>
        <li><a href="request_assistance.html">Request Assistance</a></li>
        <li><a href="assistance_guides1.html">Assistant Guides</a></li>
        <li><a href="contacts.html">Emergency Contacts</a></li>
        <li><a href="about_us.html">About Us</a></li>
      </ul>
    </nav>
    <marquee>~~RELIABLE HELP FOR UNRELIABLE BREAKDOWNS~~</marquee>
    <br/><br>
    <h2>Pending Requests</h2>
    <br>
<?php

include('db_connect.php');

// Query to select mechanics with status 'pending'
$query = "SELECT mechanic_id, CONCAT_WS(' ', first_name, middle_name, last_name) AS full_name, status, working_license FROM mechanic WHERE status = 'pending'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Display the results in a table
    echo "<table>";
    echo "<tr><th>Mechanic ID</th><th>Name</th><th>Status</th><th>License</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['mechanic_id']}</td>";
        echo "<td>{$row['full_name']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td><button class='show_license'  onclick=\"showImage('{$row['mechanic_id']}')\">Show License</button></td>";
        echo "<td>";
        echo "<button class='approve-btn'  onclick=\"updateStatus('{$row['mechanic_id']}', 'accepted')\">Accept</button>";
        echo "<button class='disapprove-btn' onclick=\"updateStatus('{$row['mechanic_id']}', 'declined')\">Decline</button>";
        echo "</td>";
        echo "</tr>";
        echo "<tr class='hidden-image' id='image-{$row['mechanic_id']}'>";
        echo "<td colspan='5'>";
        echo "<img src='display_image.php?image_id={$row['mechanic_id']}' alt='Mechanic License'>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Free the result set
    mysqli_free_result($result);
} else {
    // Print an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

?>

</body>
</html>
