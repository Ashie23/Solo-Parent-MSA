<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include_once "db_conn.php";

    // Get form data
    $barangay_name = $_POST['barangay_name'];
    $captain_name = $_POST['captain_name'];
    $captain_contact = $_POST['captain_contact'];
    $secretary_name = $_POST['secretary_name'];
    $secretary_contact = $_POST['secretary_contact'];

    // Insert data into brgy table
    $sql = "INSERT INTO barangays (barangay_name, captain_name, captain_contact, secretary_name, secretary_contact)
            VALUES ('$barangay_name', '$captain_name', '$captain_contact','$secretary_name',  '$secretary_contact')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Barangay added successfully");</script>';
    } else {
        echo '<script>alert("Error: ' . $sql . '\\n' . $conn->error . '");</script>';
    }
    header("Location: barangay.php");
    exit;
    // Close database connection
    $conn->close();
}
?>
