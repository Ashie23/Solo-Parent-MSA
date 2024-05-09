<!DOCTYPE html>
<html>
<head>
    <title>Barangay Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Your custom CSS styles here */
        .action-button {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            margin-right: 5px;
        }
        .add-button {
            background-color: #6c757d; /* Gray */
        }
        .update-button {
            background-color: #007bff; /* Blue */
        }
        .delete-button {
            background-color: #dc3545; /* Red */
        }
    </style>
</head>
<body>
    <h2>Barangay Information</h2>
    <a href="add_barangay.php" class="btn btn-secondary mb-3">Add Barangay</a>
    <a href="view_municipal.php" class="btn btn-secondary mb-3">View Municipality</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Barangay ID</th>
                    <th>Barangay Name</th>
                    <th>Captain Name</th>
                    <th>Captain Contact</th>
                    <th>Secretary Name</th>
                    <th>Secretary Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection file
                include_once "db_conn.php";

                // Fetch all barangay records from the database
                $sql = "SELECT * FROM barangays";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>".$row["barangay_id"]."</td>
                        <td>".$row["barangay_name"]."</td>
                        <td>".$row["captain_name"]."</td>
                        <td>".$row["captain_contact"]."</td>
                        <td>".$row["secretary_name"]."</td>
                        <td>".$row["secretary_contact"]."</td>
                        <td>
                            <a href='update_barangay.php?id=".$row["barangay_id"]."' class='btn btn-primary action-button update-button'>Update</a>
                            <a href='delete_barangay.php?barangay_id=".$row["barangay_id"]."' class='btn btn-danger action-button delete-button'>Delete</a>
                        </td>
                    </tr>";
                
                    }
                } else {
                    echo "<tr><td colspan='7'>No barangay records found.</td></tr>";
                }

                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
