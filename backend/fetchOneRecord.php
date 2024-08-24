<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable error display in production
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '/path/to/error.log'); // Log file path

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
} else {
    echo json_encode(['error' => 'No ID provided']);
}