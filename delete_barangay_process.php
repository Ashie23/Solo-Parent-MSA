<?php
// Include database connection file
include_once "db_conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if barangay ID is set
    if(isset($_POST['barangay_id'])) {
        // Escape user input for security
        $barangay_id = $conn->real_escape_string($_POST['barangay_id']);

        // Delete barangay record from the database
        $sql = "DELETE FROM barangays WHERE barangay_id='$barangay_id'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Barangay deleted successfully.');</script>";
        } else {
            echo "<script>alert('Error deleting barangay: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Barangay ID not provided.');</script>";
    }
} else {
    echo "<script>alert('Invalid request.');</script>";
}
header("Location: barangay.php");
exit;
?>
 