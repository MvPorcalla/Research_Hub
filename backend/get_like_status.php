<?php
include_once "..\includes\db.php";

header('Content-Type: application/json');

// Get parameters
$record_type = $_GET['record_type'];
$recordId = $_GET['recordId'];
$userId = $_GET['userId'];

$sql = ($record_type == 'abstract')
        ? "SELECT * FROM `likes` WHERE `user_id` = ? AND `record_id` = ?"
        : "SELECT * FROM `likes` WHERE `user_id` = ? AND `comment_id` = ?";
$filter = [$userId, $recordId];
$result = query($conn, $sql, $filter);

if (!empty($result)) {
    $row = $result[0];
    echo json_encode(['like_status' => $row['like_status']]);
} else {
    echo json_encode(['like_status' => 'I']); // Default to inactive if not found
}