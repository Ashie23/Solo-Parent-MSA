<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Parent List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS styles here */
        body {
            padding: 20px;
            background-color: #f8f9fa; /* Light gray background */
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            background-color: #fff; /* White background for list items */
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Box shadow for list items */
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    // Include the database connection file
    require_once('db_conn.php');

    // Fetch solo parent data from the database
    $query = "SELECT * FROM solo_parents";
    $result = mysqli_query($conn, $query);

    // Check if any solo parents exist
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Solo Parent List</h2>";
        echo "<ul>";
        // Display solo parent entries with a link to generate ID
        while ($row = mysqli_fetch_assoc($result)) {
            // Combine first_name, middle_name, and last_name to form full name
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            echo "<li>{$full_name} <a href='generate_id.php?id={$row['id']}'>Generate ID</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No solo parents found.";
    }

    // Close database connection
    mysqli_close($conn);
    ?>

    <!-- Bootstrap JS (optional) -->
    <!-- You can include Bootstrap JS if you need it -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
