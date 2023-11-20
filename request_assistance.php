<?php
include('db_connect.php');

// Fetch data from the mechanic_address table based on search criteria
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT id, companyName, phone, shopName, city, state FROM mechanic_address WHERE 
        companyName LIKE '%$search%' OR 
        phone LIKE '%$search%' OR 
        shopName LIKE '%$search%' OR 
        city LIKE '%$search%' OR 
        state LIKE '%$search%'";

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
        $location = $row['shopName'] . ', ' . $row['city'] . ', ' . $row['state'];
        echo "<tr>
                <td>" . $row['companyName'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $location . "</td>
                <td><button onclick='requestAssistance(" . $row['id'] . ")'>Request</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No matching data found</td></tr>";
}

echo "</tbody></table>";

// Close the database connection
$conn->close();
?>
