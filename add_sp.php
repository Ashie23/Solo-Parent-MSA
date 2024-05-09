<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data for solo parent
    $barangay_name = $_POST['barangay_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['surname'];
    $birthdate = $_POST['dob'];
    $place_of_birth = $_POST['pob'];
    $address = $_POST['current_address'];
    $solo_parent_category = $_POST['solo_parent_category'];
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : ''; // Check if set
    $emergency_contact_name = $_POST['emergency_name'];
    $emergency_contact_relation = $_POST['emergency_relation'];
    $emergency_contact_number = isset($_POST['emergency_contact']) ? $_POST['emergency_contact'] : ''; // Check if set
    $emergency_contact_address = $_POST['emergency_address'];

    // Insert solo parent into database
    $sql = "INSERT INTO solo_parents (barangay, first_name, middle_name, last_name, birthdate, place_of_birth, address, solo_parent_category, contact_number, emergency_contact_name, emergency_contact_relation, emergency_contact_number, emergency_contact_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $barangay_name, $first_name, $middle_name, $last_name, $birthdate, $place_of_birth, $address, $solo_parent_category, $contact_number, $emergency_contact_name, $emergency_contact_relation, $emergency_contact_number, $emergency_contact_address);

    if ($stmt->execute()) {
        echo "Solo parent added successfully!";
        
        // Retrieve the auto-generated ID of the inserted solo parent
        $solo_parent_id = $conn->insert_id;
        
        // Process children information
        $child_names = $_POST['child_name']; // Assuming 'child_name' is an array of child names
        $child_relationships = $_POST['child_relationship']; // Assuming 'child_relationship' is an array of child relationships
        $child_dobs = $_POST['child_dob']; // Assuming 'child_dob' is an array of child dates of birth

        // Process children information
        if (!empty($child_names) && is_array($child_names)) {
            foreach ($child_names as $index => $child_name) {
                // Insert child information into database with the retrieved solo_parent_id
                $child_sql = "INSERT INTO children (solo_parent_id, child_name, child_dob, child_relationship) VALUES (?, ?, ?, ?)";
                $child_stmt = $conn->prepare($child_sql);
                $child_stmt->bind_param("isss", $solo_parent_id, $child_name, $child_dobs[$index], $child_relationships[$index]);
                $child_stmt->execute();
                $child_stmt->close();
            }
        }

   // Write form data to a CSV file
$file = fopen("registrations.csv", "a");
foreach ($_POST['child_name'] as $key => $value) {
    fputcsv($file, array(
        $first_name . ' ' . $middle_name . ' ' . $last_name, 
        $birthdate . ' ' . $place_of_birth, // Fix typo, change $dob to $birthdate
        $address, 
        $solo_parent_category, 
        $emergency_contact_name, 
        $emergency_contact_relation, 
        $emergency_contact_number, 
        $emergency_contact_address, 
        $_POST['child_name'][$key], 
        $_POST['child_dob'][$key], 
        $_POST['child_relationship'][$key]
    ));
}
fclose($file);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Solo Parent</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        label {
            font-weight: bold;
        }
        h3 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Add Solo Parent</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="barangay_name">Barangay Name:</label>
            <select class="form-control" id="barangay_name" name="barangay_name" required>
                <option value="">Select Barangay</option>
                <?php
                   // Fetch barangay names from the database
                   $sql = "SELECT barangay_name FROM barangays";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {
                       while($row = $result->fetch_assoc()) {
                           echo "<option value='" . $row["barangay_name"] . "'>" . $row["barangay_name"] . "</option>";
                       }
                   } else {
                       echo "<option value=''>No Barangays Found</option>";
                   }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name">
        </div>

        <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>

        <div class="form-group">
            <label for="pob">Place of Birth:</label>
            <input type="text" class="form-control" id="pob" name="pob" required>
        </div>

        <div class="form-group">
            <label for="current_address">Current Address:</label>
            <textarea class="form-control" id="current_address" name="current_address" required></textarea>
        </div>

        <div class="form-group">
            <label for="solo_parent_category">Solo Parent Category:</label>
            <select class="form-control" id="solo_parent_category" name="solo_parent_category" required>
                <option value="widow">Widow</option>
                <option value="unmarried">Unmarried</option>
                <option value="separated">Separated</option>
                <option value="victims_of_violence">Victims of Violence</option>
                <option value="parents_of_pwd">Parents of PWD</option>
            </select>
        </div>

        <h3>Children Information:</h3>
        <div id="children_fields">
            <div class="form-group">
                <label for="child_name">Name of Child:</label>
                <input type="text" class="form-control" id="child_name" name="child_name[]" required>
            </div>
            <div class="form-group">
                <label for="child_dob">Date of Birth:</label>
                <input type="date" class="form-control" id="child_dob" name="child_dob[]" required>
            </div>
            <div class="form-group">
                <label for="child_relationship">Relationship:</label>
                <input type="text" class="form-control" id="child_relationship" name="child_relationship[]" required>
            </div>
        </div>
        <button type="button" class="btn btn-primary mb-3" onclick="addChild()">Add Child</button>

        <h3>Emergency Contact:</h3>
        <div class="form-group">
            <label for="emergency_name">Name:</label>
            <input type="text" class="form-control" id="emergency_name" name="emergency_name" required>
        </div>

        <div class="form-group">
            <label for="emergency_relation">Relation:</label>
            <input type="text" class="form-control" id="emergency_relation" name="emergency_relation" required>
        </div>

        <div class="form-group">
            <label for="emergency_contact">Contact Number:</label>
            <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" required>
        </div>

        <div class="form-group">
            <label for="emergency_address">Address:</label>
            <textarea class="form-control" id="emergency_address" name="emergency_address" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function addChild() {
            var childFields = document.getElementById("children_fields");
            var childDiv = document.createElement("div");
            childDiv.classList.add("form-group");
            childDiv.innerHTML = '<div class="form-group">' +
                '<label for="child_name">Name of Child:</label>' +
                '<input type="text" class="form-control" id="child_name" name="child_name[]" required>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="child_dob">Date of Birth:</label>' +
                '<input type="date" class="form-control" id="child_dob" name="child_dob[]" required>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="child_relationship">Relationship:</label>' +
                '<input type="text" class="form-control" id="child_relationship" name="child_relationship[]" required>' +
                '</div>';
            childFields.appendChild(childDiv);
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
