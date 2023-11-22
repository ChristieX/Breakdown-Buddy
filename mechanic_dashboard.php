<?php
// Include the database connection file
include_once 'db_connect.php';
// Function to generate incident table based on status
function generateIncidentTable($status, $result)
{
    // Output the table header
    echo "<h3>$status Incidents</h3>
          <table>
              <tr>
                  <th>Incident ID</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th>Mechanic Name</th>
                  <th>Customer Name</th>
                  <th>Status</th>
              </tr>";

    // Output data from each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['incident_id']}</td>
                <td>{$row['description']}</td>
                <td>{$row['location']}</td>
                <td>{$row['mechanic_name']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }

    echo "</table>";
}

// SQL query to retrieve incidents with status 'Requested'
$sqlRequested = "SELECT incident.incident_id, incident.description, incident.location, incident.status, CONCAT_WS(' ', mechanic.first_name, mechanic.middle_name, mechanic.last_name) AS mechanic_name, CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name
        FROM incident
        LEFT JOIN mechanic ON incident.mechanic_id = mechanic.mechanic_id
        LEFT JOIN customer ON incident.customer_id = customer.user_id
        WHERE incident.status = 'Requested'";

// SQL query to retrieve incidents with status 'Accepted'
$sqlAccepted = "SELECT incident.incident_id, incident.description, incident.location, incident.status, CONCAT_WS(' ', mechanic.first_name, mechanic.middle_name, mechanic.last_name) AS mechanic_name, CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name
        FROM incident
        LEFT JOIN mechanic ON incident.mechanic_id = mechanic.mechanic_id
        LEFT JOIN customer ON incident.customer_id = customer.user_id
        WHERE incident.status = 'accepted'";

// SQL query to retrieve incidents with status 'Declined'
$sqlDeclined = "SELECT incident.incident_id, incident.description, incident.location, incident.status, CONCAT_WS(' ', mechanic.first_name, mechanic.middle_name, mechanic.last_name) AS mechanic_name, CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name
        FROM incident
        LEFT JOIN mechanic ON incident.mechanic_id = mechanic.mechanic_id
        LEFT JOIN customer ON incident.customer_id = customer.user_id
        WHERE incident.status = 'declined'";

// Execute the queries
$resultRequested = $conn->query($sqlRequested);
$resultAccepted = $conn->query($sqlAccepted);
$resultDeclined = $conn->query($sqlDeclined);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="template.css">
    <title>Incident Tables</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
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
<header>
      <button class="button" onclick="window.location.href = 'login.html';">Logout</button>
      <h1>BREAKDOWN BUDDY</h1>
    </header>
    <nav>
      <ul>
        <li><a href="mechanic_dashboard.php">Home</a></li>
        <li><a href="request_assistance.html">Request Assistance</a></li>
        <li><a href="assistance_guides1.html">Assistant Guides</a></li>
        <li><a href="contacts.html">Emergency Contacts</a></li>
        <li><a href="about_us.html">About Us</a></li>
      </ul>
    </nav>
    <marquee>~~RELIABLE HELP FOR UNRELIABLE BREAKDOWNS~~</marquee>
    <br /><br>

    <h2>Incident Tables</h2>

    <!-- Navigation Index -->
    <div>
        <p><a href="#requested">Requested Incidents</a> | <a href="#accepted">Accepted Incidents</a> | <a href="#declined">Declined Incidents</a></p>
    </div>

    <!-- Requested Incidents Table -->
    <?php generateIncidentTable('Requested', $resultRequested); ?>

    <!-- Accepted Incidents Table -->
    <?php generateIncidentTable('Accepted', $resultAccepted); ?>

    <!-- Declined Incidents Table -->
    <?php generateIncidentTable('Declined', $resultDeclined); ?>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
