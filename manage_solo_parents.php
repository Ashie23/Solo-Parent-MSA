<?php
// Include database connection code here
include "db_conn.php"; // Update this with your actual database connection code

// Initialize $solo_parents array
$solo_parents = [];

// Fetch all solo parents from the database
$sql = "SELECT * FROM solo_parents";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch solo parents and store them in $solo_parents array
    while ($row = $result->fetch_assoc()) {
        $solo_parents[] = $row;
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Solo Parents</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your custom styles */
        .button {
            /* Style your button as needed */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Solo Parents</h2>
        <a href="add_sp.php" class="btn btn-primary">Add Solo Parent</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solo_parents as $solo_parent) : ?>
                <tr>
                    <td><?php echo $solo_parent['id']; ?></td>
                    <td><?php echo $solo_parent['first_name']; ?></td>
                    <td><?php echo $solo_parent['last_name']; ?></td>
                    <td>
                        <a href="update_solo_parent.php?id=<?php echo $solo_parent['id']; ?>" class="btn btn-info">Update</a>
                        <form action="delete_solo_parent.php" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $solo_parent['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this solo parent?')" class="btn btn-danger">Delete</button>
                        </form>
                        <a href="benefit.php?solo_parent_id=<?php echo $solo_parent['id']; ?>" class="btn btn-success">Add Benefits</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
