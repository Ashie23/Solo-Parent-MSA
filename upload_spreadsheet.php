<?php
// Include database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $file_name = $_FILES["file"]["name"];
        $tmp_name = $_FILES["file"]["tmp_name"];

        // Process the uploaded file
        // Example: Parse the spreadsheet, extract data, and insert into the database
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if ($file_ext == 'csv') {
            $handle = fopen($tmp_name, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Insert data into database
                $barangay = $data[0];
                $first_name = $data[1];
                $middle_name = $data[2];
                $last_name = $data[3];
                $birthdate = $data[4];
                $place_of_birth = $data[5];
                $address = $data[6];
                $solo_parent_category = $data[7];
                $contact_number = $data[8];
                $emergency_contact_name = $data[9];
                $emergency_contact_relation = $data[10];
                $emergency_contact_number = $data[11];
                $emergency_contact_address = $data[12];

                $sql = "INSERT INTO solo_parents (barangay, first_name, middle_name, last_name, birthdate, place_of_birth, address, solo_parent_category, contact_number, emergency_contact_name, emergency_contact_relation, emergency_contact_number, emergency_contact_address) 
                        VALUES ('$barangay', '$first_name', '$middle_name', '$last_name', '$birthdate', '$place_of_birth', '$address', '$solo_parent_category', '$contact_number', '$emergency_contact_name', '$emergency_contact_relation', '$emergency_contact_number', '$emergency_contact_address')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Solo parent added successfully!<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            fclose($handle);
        } else {
            echo "Invalid file format. Please upload a CSV file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Spreadsheet</title>
</head>
<body>
    <h2>Upload Spreadsheet</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file" required><br><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
