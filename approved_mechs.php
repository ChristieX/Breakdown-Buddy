<?php
// Include the database connection file
include_once 'db_connect.php';
include_once 'template.html';

// SQL query to retrieve approved mechanics' information with location
$sql = "SELECT CONCAT_WS(' ', m.first_name, m.middle_name, m.last_name) AS mechanic_name,
               m.company_name, m.phone_number, m.email,
               CONCAT_WS(', ', ma.streetName, ma.city, ma.state) AS location
        FROM mechanic AS m
        INNER JOIN mechanic_address AS ma ON m.mechanic_id = ma.mechanic_id
        WHERE m.status = 'approve'";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <h2>Approved Mechanics</h2>

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
