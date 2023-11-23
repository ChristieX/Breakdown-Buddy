<?php
include('db_connect.php');

// Fetch data from the mechanic table based on search criteria
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT m.mechanic_id, m.company_name, m.phone_number, ma.streetName, ma.city, ma.state 
        FROM mechanic m
        INNER JOIN mechanic_address ma ON m.mechanic_id = ma.mechanic_id
        WHERE (m.company_name LIKE '%$search%' OR 
               ma.streetName LIKE '%$search%' OR 
               ma.city LIKE '%$search%' OR 
               ma.state LIKE '%$search%')
               AND m.status = 'approved'";

$result = $conn->query($sql);

// Output data as HTML
echo "<table id='mechanic-table'>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Phone</th>
                <th>Location</th>
                <th>Request Assistance</th>
            </tr>
        </thead>
        <tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $location = $row['streetName'] . ', ' . $row['city'] . ', ' . $row['state'];
        
        echo "<tr>
                <td>" . $row['company_name'] . "</td>
                <td>" . $row['phone_number'] . "</td>
                <td>" . $location . "</td>
                <td><button data-mechanic-id='" . $row['mechanic_id'] . "' onclick='requestAssistance(" . $row['mechanic_id'] . ")'>Request</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No matching data found</td></tr>";
}

echo "</tbody></table>";

// Close the database connection
$conn->close();
?>
