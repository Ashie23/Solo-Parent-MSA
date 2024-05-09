<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in
if(!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];

// Fetch user data based on email
$sql = "SELECT * FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
    $user_email = $row['email'];
    // Other user data you want to display
} else {
    // User not found
    echo "User not found.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Validate current password
    if (!password_verify($current_password, $row['password'])) {
        echo "Incorrect current password.";
        exit;
    }

    // Update user data
    $update_sql = "UPDATE users SET name='$new_name', email='$new_email'";
    
    // Update password if a new password is provided
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql .= ", password='$hashed_password'";
    }

    $update_sql .= " WHERE email='$user_email'";

    if ($conn->query($update_sql) === TRUE) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <form action="profile.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="new_name" class="form-control" value="<?php echo $user_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="new_email" class="form-control" value="<?php echo $user_email; ?>" required>
            </div>
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>
        <p class="text-center"><a href="logout.php">Logout</a></p>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
