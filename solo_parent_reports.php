<?php
// Include database connection code here
include 'db_conn.php';
// Execute SQL query to get list of solo parents by category
$sql_category = "SELECT solo_parent_category, COUNT(*) AS total
                FROM solo_parents
                WHERE id IS NOT NULL
                GROUP BY solo_parent_category";
$result_category = $conn->query($sql_category);

// Execute SQL query to get list of solo parents by barangay
$sql_barangay = "SELECT barangay, COUNT(*) AS total
                 FROM solo_parents
                 WHERE id IS NOT NULL
                 GROUP BY barangay";
$result_barangay = $conn->query($sql_barangay);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Parent Reports</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your custom CSS */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>List of Solo Parents by Category</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_category = $result_category->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row_category['solo_parent_category']; ?></td>
                    <td><?php echo $row_category['total']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>List of Solo Parents by Barangay</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Barangay</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_barangay = $result_barangay->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row_barangay['barangay']; ?></td>
                    <td><?php echo $row_barangay['total']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
