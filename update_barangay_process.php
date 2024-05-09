<?php
// Include database connection file
include_once "db_conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if barangay ID and other fields are set
    if(isset($_POST['barangay_id']) && isset($_POST['barangay_name']) && isset($_POST['captain_name']) && isset($_POST['captain_contact']) && isset($_POST['secretary_name']) && isset($_POST['secretary_contact'])) {
        // Escape user inputs for security
        $barangay_id = $conn->real_escape_string($_POST['barangay_id']);
        $barangay_name = $conn->real_escape_string($_POST['barangay_name']);
        $captain_name = $conn->real_escape_string($_POST['captain_name']);
        $captain_contact = $conn->real_escape_string($_POST['captain_contact']);
        $secretary_name = $conn->real_escape_string($_POST['secretary_name']);
        $secretary_contact = $conn->real_escape_string($_POST['secretary_contact']);

        // Update barangay record in the database
        // Update barangay record in the database
$sql = "UPDATE barangays SET barangay_name='$barangay_name', captain_name='$captain_name', captain_contact='$captain_contact', secretary_name='$secretary_name', secretary_contact='$secretary_contact' WHERE barangay_id='$barangay_id'";


        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Barangay updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating barangay: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
} else {
    echo "<script>alert('Invalid request.');</script>";
}
header("Location: barangay.php");
exit;
?>
