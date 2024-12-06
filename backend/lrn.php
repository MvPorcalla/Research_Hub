<?php
include_once "../includes/db.php";

// Check if the form is submitted with a lastname
if (isset($_POST['lastName'])) {

    // Assign form values to variables
    $l_lastName = $_POST['lastName'];
    $l_firstName = $_POST['firstName'];
    $l_mi = $_POST['middleInitial'];
    $l_lrn = $_POST['lrn'];

    // Prepare fields for database insertion
    $table = "lrn";
    $fields = [
        'lrn_lastname' => $l_lastName,
        'lrn_firstname' => $l_firstName,
        'lrn_mi' => $l_mi,
        'lrn_lrnid' => $l_lrn
    ];

    // If editing an existing record
    if (isset($_GET['lrnId'])) {
        $lrn_id = $_GET['lrnId'];

        // Update the existing record
        $filter = ['lrn_id' => $lrn_id];
        $status = update($conn, $table, $fields, $filter) ? 'success' : 'failed';
        header("Location: ../pages/admin/ListIDPage.php?editRecord={$status}");
        exit;
    } else {

        // Check if the title already exists
        $sql = "SELECT `lrn_id`, `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?";
        $filter = [$l_lrn];
        $result = query($conn, $sql, $filter);

        empty($result)
            ? $status = insert($conn, $table, $fields) ? 'success' : 'failed'
            : $status = 'existing';

        header("Location: ../pages/admin/ListIDPage.php?addRecord={$status}");
        exit;
    }
}
