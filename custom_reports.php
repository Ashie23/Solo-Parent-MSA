<?php
// Include database connection code here
include 'db_conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['location'])) {
    $location = $_POST['location'];

    // Execute SQL query to get solo parents from the selected location
    $sql_custom_report = "SELECT *
                         FROM solo_parents
                         WHERE barangay = '$location'";

    $result_custom_report = $conn->query($sql_custom_report);

    // Display the custom report
    // You can format and display the report data here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Reports</title>
</head>
<body>
    <h2>Generate Custom Report</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="location">Select Location:</label>
        <select id="location" name="location">
            <!-- Populate with options for locations -->
            <option value="barangay1">Barangay 1</option>
            <option value="barangay2">Barangay 2</option>
            <!-- Add more options as needed -->
        </select>
        <input type="submit" value="Generate Report">
    </form>
</body>
</html>
