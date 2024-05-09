<?php
// Include database connection code here
include 'db_conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Retrieve solo parent ID
    $id = $_POST['id'];

    // Delete solo parent from the database
    $sql = "DELETE FROM solo_parents WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Solo parent deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: manage_solo_parents.php");
    exit;
    // Close database connection
    $conn->close();
}
?>
