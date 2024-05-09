<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Parent Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS styles here */
        body {
            padding: 20px;
        }
        h2 {
            margin-top: 40px;
        }
        /* You can add more custom styles as needed */
    </style>
</head>
<body>

<?php
// Include the database connection file
require_once('db_conn.php');

// Get the selected solo parent ID from the URL
if (isset($_GET['id'])) {
    $solo_parent_id = $_GET['id'];

    // Fetch solo parent information including children based on the ID
    $query = "SELECT sp.*, c.* FROM solo_parents sp LEFT JOIN children c ON sp.id = c.solo_parent_id WHERE sp.id = $solo_parent_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Fetch solo parent data
        $solo_parent_info = mysqli_fetch_assoc($result);

        // Reset data pointer to fetch children data
        mysqli_data_seek($result, 0);

        // Fetch children data into an array
        $children_info = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row['child_name'])) {
                $children_info[] = $row;
            }
        }

        // Display solo parent information
        echo "<h2>Solo Parent Information</h2>";
        echo "<p>ID: {$solo_parent_info['solo_parent_id']}</p>";
        echo "<p>Name: {$solo_parent_info['first_name']} {$solo_parent_info['middle_name']} {$solo_parent_info['last_name']}</p>";
        echo "<p>Date of Birth: {$solo_parent_info['birthdate']}</p>";
        echo "<p>Place of Birth: {$solo_parent_info['place_of_birth']}</p>";
        echo "<p>Address: {$solo_parent_info['address']}</p>";
        echo "<p>Solo Parent Category: {$solo_parent_info['solo_parent_category']}</p>";

        // Display children information
        echo "<h2>Children Information</h2>";
        if (empty($children_info)) {
            echo "No children found.";
        } else {
            foreach ($children_info as $child) {
                echo "<p>Child Name: {$child['child_name']}</p>";
                echo "<p>Child Date of Birth: {$child['child_dob']}</p>";
                echo "<p>Child Relationship: {$child['child_relationship']}</p>";
            }
        }

        // Display emergency contact information
        echo "<h2>Emergency Contact Information</h2>";
        echo "<p>Contact Name: {$solo_parent_info['emergency_contact_name']}</p>";
        echo "<p>Contact Relation: {$solo_parent_info['emergency_contact_relation']}</p>";
        echo "<p>Contact Number: {$solo_parent_info['emergency_contact_number']}</p>";
        echo "<p>Contact Address: {$solo_parent_info['emergency_contact_address']}</p>";

         // Fetch and display municipal information
   $municipal_query = "SELECT * FROM municipal_info";
   $municipal_result = mysqli_query($conn, $municipal_query);

   if (mysqli_num_rows($municipal_result) > 0) {
       echo "<h2>Municipal Information</h2>";
       while ($municipal_row = mysqli_fetch_assoc($municipal_result)) {
           echo "<p>Municipal Name: {$municipal_row['municipal_name']}</p>";
           echo "<p>MSWDO Head: {$municipal_row['mswdo_head']}</p>";
           echo "<p>Municipal Mayor: {$municipal_row['municipal_mayor']}</p>";
           echo "<p>Expiration of ID: {$municipal_row['expiration_of_id']}</p>";
       }
   } else {
       echo "No municipal information found.";
   }
} else {
    echo "Solo parent not found.";
 }
 } else {
 echo "Invalid request.";
 }
 
        // Add button for generating ID
        echo "<form action='generate_pdf.php' method='post'>";
        echo "<input type='hidden' name='solo_parent_id' value='{$solo_parent_id}'>";
        // Add other hidden fields or inputs as needed
        echo "<input type='submit' name='generate_pdf' value='Generate PDF' class='btn btn-primary'>";
        echo "<input type='submit' name='print' value='Print' class='btn btn-secondary'>";
        echo "</form>";
 
// Close database connection
mysqli_close($conn);
?>

</body>
</html>
