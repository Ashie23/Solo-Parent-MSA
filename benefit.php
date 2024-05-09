<?php
include "db_conn.php";

// Retrieve solo parent data based on ID from the URL
if (isset($_GET['solo_parent_id'])) {
    $solo_parent_id = $_GET['solo_parent_id'];
    $sql = "SELECT id, first_name, middle_name, last_name FROM solo_parents WHERE id = $solo_parent_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $solo_parent_id = $row["id"];
        $first_name = $row["first_name"];
        $middle_name = $row["middle_name"];
        $last_name = $row["last_name"];
    } else {
        echo "Solo parent not found";
        exit();
    }
} else {
    echo "Solo parent ID not provided";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Solo Parent Benefit</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Benefits</h2>
        <form action="add_benefit_process.php" method="post">
            <!-- Display solo parent ID -->
            <div class="form-group">
                <label for="solo_parent_id">Solo Parent ID:</label>
                <span><?php echo $solo_parent_id; ?></span>
            </div>
            <!-- Hidden input to store solo parent ID -->
            <input type="hidden" name="solo_parent_id" value="<?php echo $solo_parent_id; ?>">
            
            <!-- Parental Leave -->
            <div class="form-group">
                <label for="parental_leave">Parental Leave:</label>
                <select id="parental_leave" name="parental_leave" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            
            <!-- Health Insurance Coverage -->
            <div class="form-group">
                <label for="health_insurance_coverage">Health Insurance Coverage:</label>
                <select id="health_insurance_coverage" name="health_insurance_coverage" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            
            <!-- Monthly Allowances -->
            <div class="form-group">
                <label for="monthly_allowances">Monthly Allowances:</label>
                <input type="text" id="monthly_allowances" name="monthly_allowances" class="form-control">
            </div>
            
            <!-- Discounts -->
            <div class="form-group">
                <label for="discounts">Discounts:</label>
                <select id="discounts" name="discounts" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            
            <!-- Scholarship Programs -->
            <div class="form-group">
                <label for="scholarship_programs">Scholarship Programs:</label>
                <select id="scholarship_programs" name="scholarship_programs" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Add Benefit</button>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
