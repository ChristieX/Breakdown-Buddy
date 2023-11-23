<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="template.css">        
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #efefef;
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

        nav {
            background-color: #c1121f;
            padding: 10px;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
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

        main {
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            width: 300px;
            height: 200px;
            background: white;
            margin: 20px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            transition: transform 0.3s ease-in-out;
            color: #c1121f;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .box {
            text-align: center;
        }

        h1, h3 {
            margin: 0;
        }

        .button {
            top: 2%;
            right: 1%;
            position: absolute;
            background: linear-gradient(to right, #c1121f, #780000);
            color: #fff;
            border-radius: 30px;
            padding: 10px 30px;
            cursor: pointer;
            display: block;
            transition-duration: 0.5s;
            border: 0;
            outline: none;
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
        <li><a href="homepage.html">Home</a></li>
        <li><a href="request_assistance.html">Request Assistance</a></li>
        <li><a href="assistance_guides1.html">Assistant Guides</a></li>
        <li><a href="contacts.html">Emergency Contacts</a></li>
        <li><a href="about_us.html">About Us</a></li>
      </ul>
    </nav>
    <marquee>~~RELIABLE HELP FOR UNRELIABLE BREAKDOWNS~~</marquee>



<main>
    <div class="container">
        <div class="cards">
        <a style="text-decoration: none" href="approved_mechs.php">
            <div class="card">
                <div class="box">
                    <h3>APPROVED MECHANICS</h3>
                </div>
            </div>
        </a>
        <a style="text-decoration: none" href="breakdown_request.php">
            <div class="card">
                <div class="box">
                    <h3>BREAKDOWN REQUESTS</h3>
                </div>
            </div>
        </a>
        <a style="text-decoration: none" href="admin_request.php">
            <div class="card">
                <div class="box">
                    <h3>NEW MECHANICS</h3>
                </div>
            </div>
        </a>
        </div>
    </div>
</main>

</body>
</html>
