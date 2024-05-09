<!DOCTYPE html>
<html>
<head>
    <title>Delete Barangay</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px;
        }
        .confirmation-message {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Delete Barangay</h2>

    <?php
    // Include database connection file
    include_once "db_conn.php";

    // Check if Barangay ID is provided in the URL
    if(isset($_GET['barangay_id'])) {
        $barangay_id = $_GET['barangay_id'];

        // Fetch Barangay record from the database
        $sql = "SELECT * FROM barangays WHERE barangay_id = $barangay_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            ?>
            <div class="confirmation-message">
                <p>Are you sure you want to delete the barangay "<?php echo $row['barangay_name']; ?>"?</p>
            </div>
            <form action="delete_barangay_process.php" method="post">
                <input type="hidden" name="barangay_id" value="<?php echo $barangay_id; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <?php
        } else {
            echo "<p>Barangay not found.</p>";
        }
    } else {
        echo "<p>Barangay ID not provided.</p>";
    }
    ?>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
