<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable error display in production
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '/path/to/error.log'); // Log file path

include_once "../includes/db.php";

header('Content-Type: application/json');

if (isset($_GET['abstractId'])) {
    $abstractId = $_GET['abstractId'];
    $sql = "SELECT * FROM `records` WHERE `record_id` = ?";
    $filter = [$abstractId];
    $result = query($conn, $sql, $filter);

    if (!empty($result)) {
        // Return the data as JSON
        echo json_encode($result[0]);
    } else {
        // Return an error message if no record is found
        echo json_encode(['error' => 'Record not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>
