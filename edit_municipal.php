<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Details</title>
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

<div class="container">
    <h2>Municipal Details</h2>
    <?php
    // Include the database connection file
    require_once('db_conn.php');

    // Check if form is submitted for editing
    if (isset($_POST['edit_municipal'])) {
        // Get the municipal ID to edit
        $municipal_id = $_POST['edit_municipal'];
        
        // Retrieve municipal data from the database
        $query = "SELECT * FROM municipal_info WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $municipal_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Display the form for editing municipal details
        echo "
        <form method='post' action='update_municipal.php'>
            <input type='hidden' name='municipal_id' value='{$municipal_id}'>
            <div class='form-group'>
                <label for='municipal_name'>Municipal Name:</label>
                <input type='text' class='form-control' id='municipal_name' name='municipal_name' value='{$row['municipal_name']}' required>
            </div>
            <div class='form-group'>
                <label for='mswdo_head'>MSWDO Head:</label>
                <input type='text' class='form-control' id='mswdo_head' name='mswdo_head' value='{$row['mswdo_head']}' required>
            </div>
            <div class='form-group'>
                <label for='municipal_mayor'>Municipal Mayor:</label>
                <input type='text' class='form-control' id='municipal_mayor' name='municipal_mayor' value='{$row['municipal_mayor']}' required>
            </div>
            <div class='form-group'>
                <label for='expiration_of_id'>Expiration of ID:</label>
                <input type='date' class='form-control' id='expiration_of_id' name='expiration_of_id' value='{$row['expiration_of_id']}'>
            </div>
            <button type='submit' class='btn btn-primary'>Update Municipal Details</button>
        </form>
        ";
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
