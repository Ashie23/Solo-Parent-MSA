<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Barangay</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Barangay</h2>
        <form action="add_barangay_process.php" method="post">
            <div class="form-group">
                <label for="barangay_name">Barangay Name:</label>
                <input type="text" class="form-control" id="barangay_name" name="barangay_name">
            </div>

            <div class="form-group">
                <label for="captain_name">Captain Name:</label>
                <input type="text" class="form-control" id="captain_name" name="captain_name">
            </div>

            <div class="form-group">
                <label for="captain_contact">Captain Contact:</label>
                <input type="text" class="form-control" id="captain_contact" name="captain_contact">
            </div>

            <div class="form-group">
                <label for="secretary_name">Secretary Name:</label>
                <input type="text" class="form-control" id="secretary_name" name="secretary_name">
            </div>

            <div class="form-group">
                <label for="secretary_contact">Secretary Contact:</label>
                <input type="text" class="form-control" id="secretary_contact" name="secretary_contact">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery (for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
