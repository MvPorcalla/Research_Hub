<?php

include_once "../includes/db.php";

header('Content-Type: application/json');

// Function to fetch record and return as JSON
function fetchRecord($conn, $table, $idColumn, $idValue) {
    $sql = "SELECT * FROM `{$table}` WHERE `{$idColumn}` = ?";
    $filter = [$idValue];
    $result = query($conn, $sql, $filter);

    if (!empty($result)) {
        return json_encode($result[0]);
    }
    return json_encode(['error' => 'Record not found']);
}

// Determine which parameter is present and fetch the corresponding record
if (isset($_GET['abstractId'])) {
    echo fetchRecord($conn, 'records', 'record_id', $_GET['abstractId']);
} elseif (isset($_GET['lrnId'])) {
    echo fetchRecord($conn, 'lrn', 'lrn_id', $_GET['lrnId']);
} elseif (isset($_GET['teacherId'])) {
    echo fetchRecord($conn, 'teachers', 'teacher_id', $_GET['teacherId']);
} elseif (isset($_GET['userId'])) {
    echo fetchRecord($conn, 'users', 'user_id', $_GET['userId']);
} else {
    echo json_encode(['error' => 'No ID provided']);
}
