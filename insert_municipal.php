<?php
// Include the database connection file
require_once('db_conn.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $municipal_name = $_POST['municipal_name'];
    $mswdo_head = $_POST['mswdo_head'];
    $municipal_mayor = $_POST['municipal_mayor'];
    $expiration_of_id = $_POST['expiration_of_id'];

    // Prepare and execute SQL insert statement
    $stmt = $conn->prepare("INSERT INTO municipal_info (municipal_name, mswdo_head,  municipal_mayor, expiration_of_id) VALUES (?, ?,  ?, ?)");
    $stmt->bind_param("ssss", $municipal_name, $mswdo_head, $municipal_mayor, $expiration_of_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Municipal details added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
