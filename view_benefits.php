<?php
include "db_conn.php";

// Query to retrieve solo parents with benefits and their benefits
$sql_with_benefits = "SELECT sp.id, sp.first_name, sp.last_name, sb.parental_leave, sb.health_insurance_coverage, sb.monthly_allowances, sb.discounts, sb.scholarship_programs 
                        FROM solo_parents sp 
                        LEFT JOIN solo_parent_benefits sb ON sp.id = sb.solo_parent_id";

$result_with_benefits = $conn->query($sql_with_benefits);

// Query to retrieve solo parents without benefits
$sql_without_benefits = "SELECT id, first_name, last_name FROM solo_parents WHERE id NOT IN (SELECT solo_parent_id FROM solo_parent_benefits)";

$result_without_benefits = $conn->query($sql_without_benefits);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Solo Parents with Benefits</title>
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
        <h2>Solo Parents with Benefits</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Parental Leave</th>
                    <th>Health Insurance Coverage</th>
                    <th>Monthly Allowances</th>
                    <th>Discounts</th>
                    <th>Scholarship Programs</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_with_benefits->num_rows > 0) {
                    while ($row = $result_with_benefits->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['first_name']."</td>";
                        echo "<td>".$row['last_name']."</td>";
                        echo "<td>".$row['parental_leave']."</td>";
                        echo "<td>".$row['health_insurance_coverage']."</td>";
                        echo "<td>".$row['monthly_allowances']."</td>";
                        echo "<td>".$row['discounts']."</td>";
                        echo "<td>".$row['scholarship_programs']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No solo parents with benefits found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Solo Parents without Benefits</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_without_benefits->num_rows > 0) {
                    while ($row = $result_without_benefits->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['first_name']."</td>";
                        echo "<td>".$row['last_name']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>All solo parents have benefits</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
