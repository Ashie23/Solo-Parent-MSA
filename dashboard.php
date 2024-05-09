<?php
// Include database connection file
include_once 'db_conn.php';

// Fetch the count of all barangays
$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM barangays");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $barangayCount = $row['count'];
} else {
    $barangayCount = 0; // Default value if query fails
}

// Search functionality
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

if (!empty($search_query)) {
    // Sanitize the search query to prevent SQL injection
    $search_query = mysqli_real_escape_string($conn, $search_query);

    // Perform SQL query to search for barangays with the given name
    $search_result = mysqli_query($conn, "SELECT * FROM barangays WHERE barangay_name LIKE '%$search_query%'");
} else {
    // If no search query is provided, fetch all barangays
    $search_result = mysqli_query($conn, "SELECT * FROM barangays");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .search-container {
            padding: 0 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Dashboard</h1>
                <!-- Display Barangay Count -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Barangay Count</h5>
                        <p class="card-text"><?php echo $barangayCount; ?></p>
                    </div>
                </div>
                <!-- Display Search Results -->
                <h3>Search Results</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through search results and display them in a table
                            if ($search_result && mysqli_num_rows($search_result) > 0) {
                                while ($row = mysqli_fetch_assoc($search_result)) {
                                    echo "<tr>";
                                    echo "<td>".$row['barangay_id']."</td>";
                                    echo "<td>".$row['barangay_name']."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No results found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 search-container">
                <!-- Search Form -->
                <form action="dashboard.php" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Barangay" name="search_query">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
