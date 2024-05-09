<?php
// Include the database connection file
require_once('db_conn.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $municipal_id = $_POST['municipal_id'];
    $municipal_name = $_POST['municipal_name'];
    $mswdo_head = $_POST['mswdo_head'];
    $municipal_mayor = $_POST['municipal_mayor'];
    $expiration_of_id = $_POST['expiration_of_id'];

    // Prepare and execute SQL update statement
    $stmt = $conn->prepare("UPDATE municipal_info SET municipal_name = ?, mswdo_head = ?, municipal_mayor = ?, expiration_of_id = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $municipal_name, $mswdo_head, $municipal_mayor, $expiration_of_id, $municipal_id);

    if ($stmt->execute()) {
         // Redirect to barangay.php after successful update
         header("Location: barangay.php");
         exit(); // Terminate script execution
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
  
?>
