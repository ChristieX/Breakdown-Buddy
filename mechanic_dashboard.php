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

// SQL query to retrieve incident information and customer names for mechanics with status 'requested'
$sql = "SELECT incident.incident_id, incident.description, incident.location, incident.status, CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name
        FROM incident
        INNER JOIN customer ON incident.customer_id = customer.user_id
        WHERE incident.status = 'requested'";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>

    <h2>Incident Table</h2>

    <?php
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
                    <td>{$row['location']}</td>
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
        echo "No incident found.";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
