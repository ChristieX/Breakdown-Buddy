<?php
// Include the database connection file
include_once 'db_connect.php';
include_once 'template.html';

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

    // SQL query to retrieve incident information for the logged-in mechanic with status 'requested' or geolocation_id is present
    $sql = "SELECT incident.incident_id, incident.description, incident.location, incident.status, incident.geolocation_id, CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name
            FROM incident
            INNER JOIN customer ON incident.customer_id = customer.user_id
            WHERE (incident.status = 'requested' OR incident.geolocation_id IS NOT NULL) AND incident.mechanic_id = $user_id";

    // Execute the query
    $result = $conn->query($sql);

    // Output the HTML
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Incident Table</title>
        <style>
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

        <h2>Incident Table</h2>";

    // Check if there are rows returned from the query
    if ($result->num_rows > 0) {
        // Output the table header
        echo "<table>
                <tr>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";

        // Output data from each row
        while ($row = $result->fetch_assoc()) {
            echo "<form method='post'>";
            echo "<tr>
                    <td>{$row['description']}</td>
                    <td>{$row['location']}";

            // Add a 'View Location' button if geolocation_id is present
            if (!empty($row['geolocation_id'])) {
                echo "<button class='view-location' type='button'><a href='view_location.php?incident_id={$row['incident_id']}'>View Location</a></button>";
            }

            echo "</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['status']}</td>
                    <td>";

            // Add buttons to change the status
            echo "<button type='submit' name='approve' value='{$row['incident_id']}'>Approve</button>
                  <button type='submit' name='disapprove' value='{$row['incident_id']}'>Disapprove</button>";

            echo "</td></tr>";
            echo "</form>";
        }

        echo "</table>";
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
