<?php
include_once "../includes/db.php";

// Check if the form is submitted with a title and a file upload status
if (isset($_POST['title']) && ($_FILES['file']['error'] === UPLOAD_ERR_OK || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE)) {

    // Assign form values to variables
    $ar_title = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['title']); // Sanitize title
    $ar_authors = trim($_POST['authors']);
    $ar_monthYear = trim($_POST['monthYear']);
    $ar_trackStrand = trim($_POST['trackStrand'] ?? NULL);
    $ar_abstract = "../uploads/records/{$ar_title}.pdf";

    // Separate year and month
    [$year, $month] = explode('-', $ar_monthYear);

    // Prepare fields for database insertion
    $table = "records";
    $fields = [
        'record_title' => $ar_title,
        'record_authors' => $ar_authors,
        'record_year' => $year,
        'record_month' => $month,
        'record_trackstrand' => $ar_trackStrand,
        'record_filedir' => $ar_abstract
    ];

// If editing an existing record
if (isset($_GET['abstractId'])) {
    $abstractId = $_GET['abstractId'];

    // Handle file upload
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $temp = $_FILES['file']['tmp_name'];

        if (!move_uploaded_file($temp, $ar_abstract)) {
            header("Location: ../pages/admin/record.php?editRecord=failed");
            exit;
        }

    } elseif ($_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
        // Fetch the file directory from the database
        $sql = "SELECT `record_filedir` FROM `records` WHERE `record_id` = ?";
        $filter = [$abstractId];
        $result = query($conn, $sql, $filter);

        if (empty($result)) {
            // Redirect if the record is not found
            header("Location: ../pages/admin/record.php?editRecord=failed");
            exit;
        } else {
            // Get the file directory from the result
            $filedir = $result[0]['record_filedir'];

            // Attempt to rename the file
            if (!rename($filedir, $ar_abstract)) {
                // Redirect if the renaming fails
                header("Location: ../pages/admin/record.php?editRecord=failed");
                exit;
            }
        }
    }

    // Update the existing record
    $filter = ['record_id' => $abstractId];
    update($conn, $table, $fields, $filter)
    ? header("Location: ../pages/admin/index.php?editRecord=success")
    : header("Location: ../pages/admin/record.php?editRecord=failed");
    exit;
} else {
        // For new records, handle file upload if a file is provided
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $temp = $_FILES['file']['tmp_name'];
            $fields['record_status'] = 'A';

            // Check if the title already exists
            $sql = "SELECT `record_id`, `record_title` FROM `records` WHERE `record_title` = ?";
            $filter = [$ar_title];
            $result = query($conn, $sql, $filter);

            if (empty($result)) {
                move_uploaded_file($temp, $ar_abstract)
                    ? $status = insert($conn, $table, $fields) ? 'success' : 'failed'
                    : $status = 'failed';
            } else {
                $status = 'existing';
            }

            header("Location: ../pages/admin/index.php?addRecord={$status}");
            exit;
        }
    }
}
