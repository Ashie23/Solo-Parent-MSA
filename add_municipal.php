<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Municipal Details</title>
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
    <form method="post" action="insert_municipal.php">
        <div class="form-group">
            <label for="municipal_name">Municipal Name:</label>
            <input type="text" class="form-control" id="municipal_name" name="municipal_name" required>
        </div>
        <div class="form-group">
            <label for="mswdo_head">MSWDO Head:</label>
            <input type="text" class="form-control" id="mswdo_head" name="mswdo_head" required>
        </div>
        <div class="form-group">
            <label for="municipal_mayor">Municipal Mayor:</label>
            <input type="text" class="form-control" id="municipal_mayor" name="municipal_mayor" required>
        </div>
        <div class="form-group">
            <label for="expiration_of_id">Expiration of ID:</label>
            <input type="date" class="form-control" id="expiration_of_id" name="expiration_of_id">
        </div>
        <button type="submit" class="btn btn-primary">Add Municipal Details</button>
    </form>
</div>

</body>
</html>
