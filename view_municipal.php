<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Municipal Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS styles here */
        body {
            padding: 20px;
        }
        /* You can add more custom styles as needed */
    </style>
</head>
<body>
   <h2> Municipal Information</h2>
<a href="add_municipal.php" class="btn btn-secondary mb-3">Add Municipality</a>
<div class="container">
    <?php
    // Include the database connection file
    require_once('db_conn.php');

    // Retrieve municipal data from the database
    $query = "SELECT * FROM municipal_info";
    $result = $conn->query($query);

    // Check if there are any municipal entries
    if ($result->num_rows > 0) {
        echo "<h2>Municipal Data</h2>";
        echo "<table class='table table-striped'>";
        echo "<thead class='thead-dark'><tr><th>ID</th><th>Municipal Name</th><th>MSWDO Head</th><th>Municipal Mayor</th><th>Expiration of ID</th><th>Action</th></tr></thead>";
        echo "<tbody>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['municipal_name']}</td><td>{$row['mswdo_head']}</td><td>{$row['municipal_mayor']}</td><td>{$row['expiration_of_id']}</td><td>";
            echo "<form action='edit_municipal.php' method='post' style='display: inline;'>";
            echo "<input type='hidden' name='edit_municipal' value='{$row['id']}'>";
            echo "<button type='submit' class='btn btn-primary btn-sm'>Update</button>";
            echo "</form>";
            echo "</td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning' role='alert'>No municipal data found.</div>";
    }

    // Close connection
    $conn->close();
    ?>
</div>

</body>
</html>
