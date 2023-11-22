<?php
// Include the database connection file
include_once 'db_connect.php';

// SQL query to retrieve approved mechanics' information with location
$sql = "SELECT CONCAT_WS(' ', m.first_name, m.middle_name, m.last_name) AS mechanic_name,
               m.company_name, m.phone_number, m.email,
               CONCAT_WS(', ', ma.street, ma.city, ma.state) AS location
        FROM mechanic AS m
        INNER JOIN mechanic_address AS ma ON m.mechanic_id = ma.id
        WHERE m.status = 'accepted'";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="template.css">
    <title>Approved Mechanics</title>
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
    <br /><br>
    <h2>Approved Mechanics</h2>
    <br/>
    <?php
    // Check if there are rows returned from the query
    if ($result->num_rows > 0) {
        // Output the table header
        echo "<table>
                <tr>
                    <th>Mechanic Name</th>
                    <th>Company Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Location</th>
                </tr>";

        // Output data from each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['mechanic_name']}</td>
                    <td>{$row['company_name']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['location']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No approved mechanics found.";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
