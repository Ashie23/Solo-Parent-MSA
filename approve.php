<?php
session_start();

// Include database connection code here
include 'db_conn.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Check if the request contains an ID parameter
if (!isset($_GET['id'])) {
    // Redirect to admin dashboard
    header("Location: admin_dashboard.php");
    exit;
}

// Update the approval status of the user with the provided ID to "Approved"
$id = $_GET['id'];
$sql = "UPDATE users SET approval_status = 'Approved' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to admin dashboard
    header("Location: admin_dashboard.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
