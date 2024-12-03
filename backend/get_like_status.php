<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "../includes/db.php";

header('Content-Type: application/json');

// Get parameters
$record_type = $_GET['record_type'];
$recordId = $_GET['recordId'];
$userId = $_GET['userId'];

$sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `{$record_type}_id` = ?";
$filter = [$userId, $recordId];
$result = query($conn, $sql, $filter);

if (!empty($result)) {
    $row = $result[0];
    echo json_encode(['like_status' => $row['like_status']]);
} else {
    echo json_encode(['like_status' => 'I']); // Default to inactive if not found
}
