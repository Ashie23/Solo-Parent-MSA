<?php
include "db_conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['solo_parent_id']) && isset($_POST['parental_leave']) && isset($_POST['health_insurance_coverage']) && isset($_POST['monthly_allowances']) && isset($_POST['discounts']) && isset($_POST['scholarship_programs'])) {
        // Retrieve form data
        $solo_parent_id = $_POST['solo_parent_id'];
        $parental_leave = $_POST['parental_leave'];
        $health_insurance_coverage = $_POST['health_insurance_coverage'];
        $monthly_allowances = $_POST['monthly_allowances'];
        $discounts = $_POST['discounts'];
        $scholarship_programs = $_POST['scholarship_programs'];

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO solo_parent_benefits (solo_parent_id, parental_leave, health_insurance_coverage, monthly_allowances, discounts, scholarship_programs) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $solo_parent_id, $parental_leave, $health_insurance_coverage, $monthly_allowances, $discounts, $scholarship_programs);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Redirect to confirmation page
            header("Location: confirmation.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required!";
    }
} else {
    // Redirect user back to the form if accessed directly
    header("Location: benefit.php");
    exit();
}
?>
