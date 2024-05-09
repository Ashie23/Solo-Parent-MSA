<?php
// Include the FPDF library
require('./fpdf186/fpdf.php');

// Include the database connection file
include 'db_conn.php';

// Get the selected solo parent ID from the form submission
if (isset($_POST['solo_parent_id'])) {
    $solo_parent_id = $_POST['solo_parent_id'];

    // Fetch solo parent information based on the ID
    $query = "SELECT * FROM solo_parents WHERE id = $solo_parent_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Fetch solo parent data
        $solo_parent = mysqli_fetch_assoc($result);

        // Fetch children data
        $children_query = "SELECT * FROM children WHERE solo_parent_id = $solo_parent_id";
        $children_result = mysqli_query($conn, $children_query);
        $children = mysqli_fetch_all($children_result, MYSQLI_ASSOC);

        // Combine first_name, middle_name, and last_name to form full name
        $full_name = $solo_parent['first_name'] . ' ' . $solo_parent['middle_name'] . ' ' . $solo_parent['last_name'];
        $birth = $solo_parent['birthdate'] . ' ' . $solo_parent['place_of_birth'];

        // Load the front and back view template images
        $front_template_image = './images/frontview.png'; // Update with your front view template image path
        $back_template_image = './images/backview.png'; // Update with your back view template image path

        // Create a new PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();

        // Add front view template image to the PDF with border
        $pdf->Image($front_template_image, 50, 30, 88.9, 50.8); // 3.5 inches width, 2 inches height
        $pdf->Rect(50, 30, 88.9, 50.8); // Add border around front template image

        // Add solo parent information to the front view
        $pdf->SetFont('helvetica', '', 6.5);
        $pdf->SetXY(95, 50.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$full_name}", 0, 1);
        $pdf->SetXY(120, 46.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['id']}", 0, 1);
        $pdf->SetXY(100, 56.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$birth}", 0, 1);
        $pdf->SetXY(93, 59); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['address']}", 0, 1);
        $pdf->SetXY(98, 64.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['solo_parent_category']}", 0, 1); 
        // Add other solo parent information as needed

        // Add back view template image to the PDF with border
        $pdf->Image($back_template_image, 50, 120, 88.9, 50.8); // 3.5 inches width, 2 inches height
        $pdf->Rect(50, 120, 88.9, 50.8); // Add border around back template image

        // Add children information to the back view
        $pdf->SetFont('helvetica', '', 6.5);
        $y = 121; // Initial y-coordinate for children information
        foreach ($children as $child) {
            $pdf->SetXY(55, $y); // Adjust coordinates as needed
            $pdf->Cell(0, 10, "{$child['child_name']}", 0, 1);
            $pdf->SetXY(90, $y); // Adjust coordinates as needed
            $pdf->Cell(0, 10, "{$child['child_dob']}", 0, 1);
            $pdf->SetXY(115, $y); // Adjust coordinates as needed
            $pdf->Cell(0, 10, "{$child['child_relationship']}", 0, 1);
            $y += 4; // Increase y-coordinate for the next child
        }

        // Add emergency contact information to the back view
        $pdf->SetXY(60, 145); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['emergency_contact_name']}", 0, 1);
        $pdf->SetXY(90.5, 145); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['emergency_contact_relation']}", 0, 1);
        $pdf->SetXY(120, 145); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['emergency_contact_number']}", 0, 1);
        $pdf->SetXY(62, 147.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$solo_parent['emergency_contact_address']}", 0, 1);


        
        // Fetch municipal information
        $municipal_query = "SELECT * FROM municipal_info";
        $municipal_result = mysqli_query($conn, $municipal_query);
        $municipal = mysqli_fetch_assoc($municipal_result);

        // Add municipal information to the front view
        $pdf->SetXY(100, 33); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$municipal['municipal_name']}", 0, 1);
        $pdf->SetXY(110, 153.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$municipal['mswdo_head']}", 0, 1);
        $pdf->SetXY(60, 153.5); // Adjust coordinates as needed
        $pdf->Cell(0, 10, "{$municipal['municipal_mayor']}", 0, 1);
        $pdf->SetXY(112, 74); // Adjust coordinates as needed
        $pdf->Cell(0, 10,  "{$municipal['expiration_of_id']}", 0, 1);


        // Output the PDF to the browser
        $pdf->Output();
    } else {
        echo "Solo parent not found.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
