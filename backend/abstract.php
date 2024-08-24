<?php
include_once "../includes/db.php";

// Check if the form is submitted with a title and a file upload status
if (isset($_POST['title']) && ($_FILES['file']['error'] === UPLOAD_ERR_OK || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE)) {

    // Assign form values to variables
    $a_title = trim($_POST['title']);
    $a_authors = trim($_POST['authors']);
    $a_monthYear = trim($_POST['monthYear']);
    $a_trackStrand = trim($_POST['trackStrand'] ?? NULL);
    $a_abstract = "../uploads/records/{$a_title}.pdf";

    // Separate year and month
    [$year, $month] = explode('-', $a_monthYear);

    // Prepare fields for database insertion
    $table = "records";
    $fields = [
        'record_title' => $a_title,
        'record_authors' => $a_authors,
        'record_year' => $year,
        'record_month' => $month,
        'record_trackstrand' => $a_trackStrand,
        'record_filedir' => $a_abstract
    ];

    // If editing an existing record
    if (isset($_GET['abstractId'])) {
        $abstract_id = $_GET['abstractId'];

        // Handle file upload
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $temp = $_FILES['file']['tmp_name'];

            if (!move_uploaded_file($temp, $a_abstract)) {
                header("Location: ../pages/admin/index.php?editRecord=failed");
                exit;
            }

        } elseif ($_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            // Fetch the file directory from the database
            $sql = "SELECT `record_filedir` FROM `records` WHERE `record_id` = ?";
            $filter = [$abstract_id];
            $result = query($conn, $sql, $filter);

            if (empty($result)) {
                // Redirect if the record is not found
                header("Location: ../pages/admin/index.php?editRecord=failed");
                exit;
            } else {
                // Get the file directory from the result
                $filedir = $result[0]['record_filedir'];

                // Attempt to rename the file
                if (!rename($filedir, $a_abstract)) {
                    // Redirect if the renaming fails
                    header("Location: ../pages/admin/index.php?editRecord=failed");
                    exit;
                }
            }
        }

        // Update the existing record
        $filter = ['record_id' => $abstract_id];
        $status = update($conn, $table, $fields, $filter) ? 'success' : 'failed';
        header("Location: ../pages/admin/index.php?editRecord={$status}");
        exit;
    } else {
        // For new records, handle file upload if a file is provided
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $temp = $_FILES['file']['tmp_name'];
            $fields['record_status'] = 'A';

            // Check if the title already exists
            $sql = "SELECT `record_id`, `record_title` FROM `records` WHERE `record_title` = ?";
            $filter = [$a_title];
            $result = query($conn, $sql, $filter);

            if (empty($result)) {
                move_uploaded_file($temp, $a_abstract)
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
