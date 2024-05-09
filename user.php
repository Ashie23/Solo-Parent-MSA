<?php
session_start();

// Include database connection file
include 'db_conn.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login page
    header("Location: user.php");
    exit;
}

// Query to fetch all registered users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>User Management</h2>
        <!-- User list table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>" . ucfirst($row['approval_status']) . "</td>";
                        echo "<td>";
                        if (strtolower($row['approval_status']) == 'pending') {
                            echo "<a href='approve.php?id=" . $row['id'] . "' class='btn btn-success'>Approve</a> ";
                            echo "<a href='reject.php?id=" . $row['id'] . "' class='btn btn-danger'>Reject</a>";
                        } else {
                            echo "N/A"; // No action needed for users with status other than pending
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No registered users</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
