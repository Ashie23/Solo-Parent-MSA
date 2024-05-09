<?php
include 'db_conn.php';

// Initialize error message variable
$error_message = "";

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data for solo parent
    // Sanitize and validate user inputs
    $solo_parent_id = $_POST['solo_parent_id'];
    $barangay_name = $_POST['barangay_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['surname'];
    $birthdate = $_POST['dob'];
    $place_of_birth = $_POST['pob'];
    $address = $_POST['current_address'];
    $solo_parent_category = $_POST['solo_parent_category'];
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $emergency_contact_name = $_POST['emergency_name'];
    $emergency_contact_relation = $_POST['emergency_relation'];
    $emergency_contact_number = isset($_POST['emergency_contact']) ? $_POST['emergency_contact'] : '';
    $emergency_contact_address = $_POST['emergency_address'];

    // Update solo parent information in the database
    $sql = "UPDATE solo_parents 
            SET barangay = ?, first_name = ?, middle_name = ?, last_name = ?, birthdate = ?, place_of_birth = ?, address = ?, solo_parent_category = ?, contact_number = ?, emergency_contact_name = ?, emergency_contact_relation = ?, emergency_contact_number = ?, emergency_contact_address = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssi", $barangay_name, $first_name, $middle_name, $last_name, $birthdate, $place_of_birth, $address, $solo_parent_category, $contact_number, $emergency_contact_name, $emergency_contact_relation, $emergency_contact_number, $emergency_contact_address, $solo_parent_id);

    if ($stmt->execute()) {
        echo "Solo parent updated successfully!";
    } else {
        echo "Error updating solo parent: " . $stmt->error;
    }
    $stmt->close();

    // Process children information
    if (isset($_POST['child_name']) && is_array($_POST['child_name'])) {
        // Delete existing children records
        $delete_child_sql = "DELETE FROM children WHERE solo_parent_id = ?";
        $delete_child_stmt = $conn->prepare($delete_child_sql);
        $delete_child_stmt->bind_param("i", $solo_parent_id);
        $delete_child_stmt->execute();
        $delete_child_stmt->close();

        // Insert updated children records
        $insert_child_sql = "INSERT INTO children (solo_parent_id, child_name, child_dob, child_relationship) VALUES (?, ?, ?, ?)";
        $insert_child_stmt = $conn->prepare($insert_child_sql);

        foreach ($_POST['child_name'] as $index => $child_name) {
            $child_dob = $_POST['child_dob'][$index];
            $child_relationship = $_POST['child_relationship'][$index];
            $insert_child_stmt->bind_param("isss", $solo_parent_id, $child_name, $child_dob, $child_relationship);
            $insert_child_stmt->execute();
        }
        $insert_child_stmt->close();
    }

    // Write form data to a CSV file
    // Ensure CSV file writing logic works as intended
    $file = fopen("registrations.csv", "w");
    if ($file) {
        foreach ($_POST['child_name'] as $key => $value) {
            fputcsv($file, array(
                $first_name . ' ' . $middle_name . ' ' . $last_name,
                $birthdate . ' ' . $place_of_birth,
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
        echo "Error opening CSV file for writing.";
    }
}

// Fetch solo parent details for pre-filling the form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $solo_parent_id = $_GET['id'];
    // Retrieve solo parent record from the database
    $sql = "SELECT * FROM solo_parents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solo_parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Solo parent record not found!";
        exit; // Stop execution if record not found
    }
    $stmt->close();
} 
// Display error message if applicable
if (!empty($error_message)) {
    echo $error_message;
    exit; // Stop execution for error message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Solo Parent</title>
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
    <h2 class="text-center">Update Solo Parent</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="solo_parent_id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <div class="form-group">
            <label for="barangay_name">Barangay Name:</label>
            <select class="form-control" id="barangay_name" name="barangay_name" required>
                <option value="">Select Barangay</option>
                <?php
                   // Fetch barangay names from the database
                   $sql = "SELECT barangay_name FROM barangays";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {
                       while($barangay_row = $result->fetch_assoc()) {
                           $selected = ($barangay_row["barangay_name"] == $row['barangay']) ? "selected" : "";
                           echo "<option value='" . $barangay_row["barangay_name"] . "' $selected>" . $barangay_row["barangay_name"] . "</option>";
                       }
                   } else {
                       echo "<option value=''>No Barangays Found</option>";
                   }
                ?>
            </select>
        </div>

        <div class="form-group">
    <label for="first_name">First Name:</label>
    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required>
</div>

<div class="form-group">
    <label for="middle_name">Middle Name:</label>
    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $row['middle_name']; ?>" required>
</div>

<div class="form-group">
    <label for="surname">Surname:</label>
    <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $row['last_name']; ?>" required>
</div>

<div class="form-group">
    <label for="dob">Date of Birth:</label>
    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['birthdate']; ?>" required>
</div>

<div class="form-group">
    <label for="pob">Place of Birth:</label>
    <input type="text" class="form-control" id="pob" name="pob" value="<?php echo $row['place_of_birth']; ?>" required>
</div>

<div class="form-group">
    <label for="current_address">Current Address:</label>
    <textarea class="form-control" id="current_address" name="current_address" required><?php echo $row['address']; ?></textarea>
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
            <?php
            // Fetch and display children information
            $sql_children = "SELECT * FROM children WHERE solo_parent_id = ?";
            $stmt_children = $conn->prepare($sql_children);
            $stmt_children->bind_param("i", $solo_parent_id);
            $stmt_children->execute();
            $result_children = $stmt_children->get_result();

            // Check if children records were found
            if ($result_children->num_rows > 0) {
                // Display form fields for each child
                while ($child_row = $result_children->fetch_assoc()) {
                    ?>
                    <div class="form-group">
                        <label for="child_name">Name of Child:</label>
                        <input type="text" class="form-control" id="child_name" name="child_name[]" value="<?php echo $child_row['child_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="child_dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="child_dob" name="child_dob[]" value="<?php echo $child_row['child_dob']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="child_relationship">Relationship:</label>
                        <input type="text" class="form-control" id="child_relationship" name="child_relationship[]" value="<?php echo $child_row['child_relationship']; ?>" required>
                    </div>
                    <?php
                }
            }
            $stmt_children->close();
            ?>
        </div>
        <button type="button" class="btn btn-primary mb-3" onclick="addChild()">Add Child</button>

        <h3>Emergency Contact:</h3>
        <div class="form-group">
            <label for="emergency_name">Name:</label>
            <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="<?php echo $row['emergency_contact_name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="emergency_relation">Relation:</label>
            <input type="text" class="form-control" id="emergency_relation" name="emergency_relation" value="<?php echo $row['emergency_contact_relation']; ?>" required>
        </div>

        <div class="form-group">
            <label for="emergency_contact">Contact Number:</label>
            <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" value="<?php echo $row['emergency_contact_number']; ?>" required>
        </div>

        <div class="form-group">
            <label for="emergency_address">Address:</label>
            <textarea class="form-control" id="emergency_address" name="emergency_address" required><?php echo $row['emergency_contact_address']; ?></textarea>
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
