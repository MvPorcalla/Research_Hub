<?php
include_once "../includes/db.php";

// Check if the form is submitted with a fullname
if (isset($_POST['fullName'])) {

    // Assign form values to variables
    $l_student = $_POST['fullName'];
    $l_lrn = $_POST['lrn'];

    // Prepare fields for database insertion
    $table = "lrn";
    $fields = [
        'lrn_student' => $l_student,
        'lrn_lrnid' => $l_lrn
    ];

    // If editing an existing record
    if (isset($_GET['lrnId'])) {
        $lrn_id = $_GET['lrnId'];

        // Update the existing record
        $filter = ['lrn_id' => $lrn_id];
        $status = update($conn, $table, $fields, $filter) ? 'success' : 'failed';
        header("Location: ../pages/admin/listLRN.php?editRecord={$status}");
        exit;
    } else {

        // Check if the title already exists
        $sql = "SELECT `lrn_id`, `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?";
        $filter = [$l_lrn];
        $result = query($conn, $sql, $filter);

        empty($result)
            ? $status = insert($conn, $table, $fields) ? 'success' : 'failed'
            : $status = 'existing';

        header("Location: ../pages/admin/listLRN.php?addRecord={$status}");
        exit;
    }
}
