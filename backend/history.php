<?php
include_once "..\..\includes\db.php";

$userId = $_SESSION['user_id'];
$abstractId = $_GET['abstractId'];

$currentTimestamp = date('Y-m-d H:i:s');

$table = 'histories';
$fields = [
    'history_timestamp' => $currentTimestamp,
    'history_status' => 'A'
];

// Check if the user has already liked this record
$sql = "SELECT * FROM `histories` WHERE `user_id` = ? AND `record_id` = ? AND DATE(`history_timestamp`) = DATE(?)";
$filter = [$userId, $abstractId, $currentTimestamp];
$result = query($conn, $sql, $filter);


if (!empty($result)) {
    // If the record exists, toggle the status
    
    $row = $result[0];

    $filter = [
        'history_id' => $row['history_id']
    ];
    
    update($conn, $table, $fields, $filter);

} else {
    // If the record does not exist, add a new like

    $fields = array_merge($fields, [
        'user_id' => $userId,
        'record_id' => $abstractId,
    ]);
    
    insert($conn, $table, $fields);
}