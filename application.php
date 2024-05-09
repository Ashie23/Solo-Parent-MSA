<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Parent Registration Form</title>
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
    <div class="container">
        <h2 class="text-center">Solo Parent Registration Form</h2>
        <form action="process_registration.php" method="post">
        <div class="form-group">
                <label for="barangay_name">Barangay Name:</label>
                <select class="form-control" id="barangay_name" name="barangay_name" required>
                    <option value="">Select Barangay</option>
                    <?php
                   include 'db_conn.php';

                   $sql = "SELECT barangay_name FROM barangays";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["barangay_name"] . "'>" . $row["barangay_name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No Barangays Found</option>";
                    }
                    $conn->close();
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
                <select class="form-control" id="solo_parent_category" name="solo_parent_category">
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
    </div>

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
