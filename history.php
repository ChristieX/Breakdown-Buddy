<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Gasoek+One&family=Slackside+One&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cherry+Bomb+One&display=swap"
      rel="stylesheet"
    />
  </head>
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
      font-family: "Cherry Bomb One", cursive;
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
      font-family: "Slackside One", cursive;
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
            margin-top: 10px;
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
  <body>
  <header>
      <button class="button" onclick="window.location.href = 'login.html';">Logout</button>
      <h1>BREAKDOWN BUDDY</h1>
    </header>
    <nav>
      <ul>
        <li><a href="homepage.html">Home</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="assistance_guides1.html">Assistant Guides</a></li>
        <li><a href="contacts.html">Emergency Contacts</a></li>
        <li><a href="about_us.html">About Us</a></li>
      </ul>
    </nav>
    <marquee>~~RELIABLE HELP FOR UNRELIABLE BREAKDOWNS~~</marquee>
    <?php
    // Include the database connection file
    include_once 'db_connect.php';

    // Start a session
    session_start();

    // Check if the user is logged in (mechanic)
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        // Retrieve the mechanic_id from the session
        $mechanic_id = $_SESSION['user_id'];

        // Query to fetch history from the incident table
        $query = "SELECT incident.incident_id,
                         CONCAT_WS(' ', customer.name_first, customer.name_middle, customer.name_last) AS customer_name,
                         incident.description,
                         incident.location,
                         incident.status
                   FROM incident
                   LEFT JOIN customer ON incident.customer_id = customer.user_id
                   WHERE incident.mechanic_id = $mechanic_id";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if there are results
        if ($result) {
            echo "<h2>Mechanic History</h2>";
            echo "<table>";
            echo "<tr><th>Incident ID</th><th>Customer Name</th><th>Description</th><th>Location</th><th>Status</th></tr>";

            // Display the results in a table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['incident_id']}</td>";
                echo "<td>{$row['customer_name']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "<td>{$row['location']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Error fetching history: " . mysqli_error($conn);
        }
    } else {
        // Redirect to login if the user is not logged in
        header("Location: login.html");
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
