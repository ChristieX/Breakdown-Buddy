<?php
// Include the database connection file
include_once 'db_connect.php';

// Check if a button is clicked
if (isset($_POST['approve'])) {
    // Handle approval logic here
    $incident_id = $_POST['approve'];
    $update_status_query = "UPDATE incident SET status = 'approved' WHERE incident_id = $incident_id";
    $conn->query($update_status_query);
}

if (isset($_POST['disapprove'])) {
    // Handle disapproval logic here
    $incident_id = $_POST['disapprove'];
    $update_status_query = "UPDATE incident SET status = 'disapproved' WHERE incident_id = $incident_id";
    $conn->query($update_status_query);
}

// Check if the user is logged in and get their user_id from the session variable
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT incident.incident_id, 
               CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name,
               customer.phone_number AS customer_phone,  -- Added this line
               incident.description, 
               incident.location, 
               incident.status,
               incident.geolocation_id
        FROM incident
        INNER JOIN customer ON incident.customer_id = customer.user_id
        WHERE incident.status = 'Requested' AND incident.mechanic_id = $user_id";


    // Execute the query
    $result = $conn->query($sql);

    // Output the HTML
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Incident Table</title>
        <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\" />
        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin />
        <link
          href=\"https://fonts.googleapis.com/css2?family=Gasoek+One&family=Slackside+One&display=swap\"
          rel=\"stylesheet\"
        />
        <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\" />
        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin />
        <link
          href=\"https://fonts.googleapis.com/css2?family=Cherry+Bomb+One&display=swap\"
          rel=\"stylesheet\"
        />
        <style>
        * {
            margin: 0;
            padding: 0;
          }
          header {
            background-color: #780000;
            color: #fff;
            padding: 20px;
            text-align: center;
            width: 100%;
          }
      
          h1 {
            margin: 0;
          }
          header h1 {
            font-family: \"Cherry Bomb One\", cursive;
          }
          .button{
            top: 2%;
            right: 1%;
            position: absolute;
            background: linear-gradient(to right, #ae474d, #780000);
            color: #fff;
            border-radius: 30px;
            padding: 10px 30px;
            cursor: pointer;
            display: block;
            transition-duration: 0.5s;
            border: 0;
            outline: none;
          }
          nav {
            background-color: #c1121f;
            padding: 10px;
            position: sticky;
            width: 100%;
          }
          ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
          }
      
          li {
            display: inline;
            margin-right: 10px;
          }
      
          li a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
          }
      
          li a:hover {
            background-color: #730b12;
          }
          marquee {
            font-family: \"Slackside One\", cursive;
            font-size: 50px;
            padding: 0;
          }
          body {
            width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
          }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            /* Style for the 'View Location' button */
            button.view-location {
                padding: 5px 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 3px;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    <header>
      <button class=\"button\" onclick=\"window.location.href = 'login.html';\">Logout</button>
      <h1>BREAKDOWN BUDDY</h1>
    </header>
    <nav>
      <ul>
      <li><a href=\"homepage.html\">Home</a></li>
      <li><a href=\"history.php\">History</a></li>
      <li><a href=\"assistance_guides1.html\">Assistant Guides</a></li>
        <li><a href=\"contacts.html\">Emergency Contacts</a></li>
        <li><a href=\"about_us.html\">About Us</a></li>
      </ul>
    </nav>
    <marquee>~~RELIABLE HELP FOR UNRELIABLE BREAKDOWNS~~</marquee>

        <h2>Incident Table</h2>";

    // Check if there are rows returned from the query
    if ($result->num_rows > 0) {
        echo "<form method='post'>";
        echo "<table>
        <tr>
            <th>Customer Name</th>
            <th>Customer Phone</th>  
            <th>Description</th>
            <th>Location</th>
            <th>Status</th>
            <th>Action</th>
        </tr>";

        // Output data from each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['customer_phone']}</td>
                    <td>{$row['description']}</td>
                    <td>";

            // Add a 'View Location' button if geolocation_id is present
            if (!empty($row['geolocation_id'])) {
                echo "<button class='view-location' type='button'><a href='view_location.php?incident_id={$row['incident_id']}'>View Location</a></button>";
            }

            echo "{$row['location']}</td>
                    <td>{$row['status']}</td>
                    <td>";

            // Add buttons to change the status
            echo "<button type='submit' name='approve' value='{$row['incident_id']}'>Approve</button>
                  <button type='submit' name='disapprove' value='{$row['incident_id']}'>Disapprove</button>";

            echo "</td></tr>";
        }

        echo "</table>";
        echo "</form>";
    } else {
        echo "No incident found for the logged-in mechanic.";
    }

    // Close the database connection
    $conn->close();

    echo "</body>
    </html>";
} else {
    echo "User not logged in.";
}
?>
