<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #780000;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        nav {
            background-color: #c1121f;
            padding: 10px;
            position: sticky;
            top: 0;
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

        main {
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
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
        <h1>Client Dashboard</h1>
    </header>

    <nav>
        <ul>
            <li><a href="client_dashboard.php">Dashboard</a></li>
            <li><a href="request_assistance.html">Request Assistance</a></li>
            <li><a href="incident_history.php">Incident History</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main>
        <h2>Incident History</h2>

        <?php
        // Include the database connection file
        include_once 'db_connect.php';
        
        // Check if the user is logged in and get their user_id from the session variable
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // SQL query to retrieve incident information for the logged-in client
            $sql = "SELECT * FROM incident WHERE customer_id = $user_id";
            
            // Execute the query
            $result = $conn->query($sql);

            // Check if there are rows returned from the query
            if ($result->num_rows > 0) {
                // Output the table header
                echo "<table>
                        <tr>
                            <th>Incident ID</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>";

                // Output data from each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['incident_id']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "No incident found for the logged-in client.";
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "User not logged in.";
        }
        ?>

    </main>

</body>
</html>
