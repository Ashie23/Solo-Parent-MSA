<!DOCTYPE html>
<html>
<head>
    <title>Update Barangay</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Update Barangay</h2>

    <?php
    // Include database connection file
    include_once "db_conn.php";

    // Check if ID is provided in the URL
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch barangay record from the database
        $sql = "SELECT * FROM barangays WHERE barangay_id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            ?>
            <form action="update_barangay_process.php" method="post">
                <input type="hidden" name="barangay_id" value="<?php echo $row['barangay_id']; ?>">
                <div class="form-group">
                    <label for="barangay_name">Barangay Name:</label>
                    <input type="text" class="form-control" id="barangay_name" name="barangay_name" value="<?php echo $row['barangay_name']; ?>">
                </div>

                <div class="form-group">
                    <label for="captain_name">Captain Name:</label>
                    <input type="text" class="form-control" id="captain_name" name="captain_name" value="<?php echo $row['captain_name']; ?>">
                </div>

                <div class="form-group">
                    <label for="captain_contact">Captain Contact:</label>
                    <input type="text" class="form-control" id="captain_contact" name="captain_contact" value="<?php echo $row['captain_contact']; ?>">
                </div>

                <div class="form-group">
                    <label for="secretary_name">Secretary Name:</label>
                    <input type="text" class="form-control" id="secretary_name" name="secretary_name" value="<?php echo $row['secretary_name']; ?>">
                </div>

                <div class="form-group">
                    <label for="secretary_contact">Secretary Contact:</label>
                    <input type="text" class="form-control" id="secretary_contact" name="secretary_contact" value="<?php echo $row['secretary_contact']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
        } else {
            echo "Barangay not found.";
        }
    } else {
        echo "Barangay ID not provided.";
    }
    ?>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
