<?php
session_start(); // Start session

// Check if user is not logged in or not an admin, redirect to login page
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS for the layout */
        header {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 10px 0;
            margin-bottom: 5px;
        }

        nav ul {
            list-style-type: none;
            padding: 5;
            margin: 5;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        main {
            text-align: center;
        }

        /* CSS for the logo */
        header img {
            width: 50px;
            margin-right: 10px;
        }

        /* CSS for the system name */
        header h1 {
            margin-top: 10px;
            font-size: 24px;
            font-weight: bold;
            display: inline;
        }

        /* CSS for the navigation links */
        nav ul li a {
            color: #333;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #007bff;
        }

        /* CSS for the content */
        #content {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <!-- Header with logo and system name -->
        <img src="./images/logo.jpg" alt="Logo">
        <h1>Solo Parent Management System with Analytics</h1>
    </header>

    <nav>
        <!-- Navigation menu -->
        
        <ul>
            <li><a href="#" onclick="loadContent('dashboard.php')">Dashboard</a></li>
            <li><a href="#" onclick="loadContent('barangay.php')">Barangay</a></li>
            <li><a href="#" onclick="loadContent('manage_solo_parents.php')">Solo Parents</a></li>
            <li><a href="#" onclick="loadContent('user.php')">User</a></li>
            <li><a href="#" onclick="loadContent('solo_parent_id.php')">Solo Parent ID</a></li>
            <li><a href="#" onclick="loadContent('services.php')">Services</a></li>
            <li><a href="#" onclick="loadContent('reports.php')">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main content area -->
    <main>
        <div id="content">
            !-- Content loaded dynamically will be displayed here -->
        </div>
    </main>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function loadContent(url) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    document.getElementById("content").style.display = "block"; // Display content
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    </script>
</body>
</html>
