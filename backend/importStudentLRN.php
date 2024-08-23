<?php
include_once "../includes/db.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['save_excel_data'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed_ext = ['xls', 'xlsx'];

        if (in_array($file_ext, $allowed_ext)) {
            $inputFileNamePath = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $count = 0;

            // Prepare the SQL statement
            $sql = 'INSERT INTO lrn (lrn_student, lrn_lrnid, lrn_status) VALUES (?, ?, ?)';
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                die("Failed to prepare the SQL statement: " . mysqli_error($conn));
            }

            foreach ($data as $row) {
                if ($count > 0) { // Skip the first row (header)
                    $studentName = isset($row[0]) ? trim($row[0]) : '';
                    $lrn = isset($row[1]) ? trim($row[1]) : '';
                    $status = 'A'; // Default status

                    // Bind parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, 'sss', $studentName, $lrn, $status);
                    mysqli_stmt_execute($stmt);
                } else {
                    $count = 1; // Move past the header row
                }
            }

            mysqli_stmt_close($stmt);
            header('Location: ../pages/admin/listLRN.php?success=1');
            exit();
        } else {
            echo "Invalid file format. Only xls and xlsx files are allowed.";
        }
    } else {
        echo "Error uploading file. Please try again.";
    }
} else {
    echo "No file uploaded.";
}
?>
