<?php
session_start();

include 'db_conn.php';
// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

// Retrieve user data from database
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        // Update user information in the database
        $update_sql = "UPDATE users SET name = '$name', email = '$email'";

        // Update password if new password is provided
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql .= ", password = '$hashed_password'";
        }

        $update_sql .= " WHERE email = '$user_email'";

        if ($conn->query($update_sql) === TRUE) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    } else {
        echo "Incorrect current password.";
    }
} else {
    echo "User not found.";
}
header("Location: login.php");
exit;

$conn->close();
?>
