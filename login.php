<?php
session_start();
include 'db_conn.php'; // Include your database connection file

// Define variables to hold error messages
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            if ($row['approval_status'] == 'Approved') {
                // Set session variables and redirect to main page
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $row['role'];
                
                // Redirect based on user role
                switch ($row['role']) {
                    case 'admin':
                        header("Location: admin_main.php");
                        exit;
                    case 'staff':
                        header("Location: staff_main.php");
                        exit;
                    case 'head':
                        header("Location: head_main.php");
                        exit;
                    default:
                        // Invalid role
                        $error = "Invalid user role.";
                }
            } elseif ($row['approval_status'] == 'Pending') {
                $error = "Your registration is pending approval. Please wait for admin approval.";
            } elseif ($row['approval_status'] == 'Rejected') {
                $error = "Your registration has been rejected by the admin. Please contact the admin for more information.";
            }
        } else {
            // Incorrect password
            $error = "Invalid email or password.";
        }
    } else {
        // User not found
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 300px;
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
    <script>
        // Function to display alert message
        function showAlert(message) {
            alert(message);
        }

        // Function to check if error message is set and display alert accordingly
        function checkError() {
            <?php if (!empty($error)): ?>
                showAlert("<?php echo $error; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body onload="checkError()">
    <div class="container">
        <h2>User Login </h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
