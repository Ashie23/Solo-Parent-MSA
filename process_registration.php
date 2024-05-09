<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $barangay = $_POST['barangay_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $current_address = $_POST['current_address'];
    $solo_parent_category = $_POST['solo_parent_category'];
    $child_names = $_POST['child_name'];
    $child_dobs = $_POST['child_dob'];
    $child_relationships = $_POST['child_relationship'];
    $emergency_name = $_POST['emergency_name'];
    $emergency_relation = $_POST['emergency_relation'];
    $emergency_contact = $_POST['emergency_contact'];
    $emergency_address = $_POST['emergency_address'];

    include 'db_conn.php';

    // Prepare and bind SQL statement
    $sql = "INSERT INTO solo_parents (barangay, first_name, middle_name, surname, dob, pob, current_address, solo_parent_category, child_name, child_dob, child_relationship, emergency_name, emergency_relation, emergency_contact, emergency_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssss", $barangay, $first_name, $middle_name, $surname, $dob, $pob, $current_address, $solo_parent_category, $child_name, $child_dob, $child_relationship, $emergency_name, $emergency_relation, $emergency_contact, $emergency_address);

    // Insert data into database
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
