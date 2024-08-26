<?php
include_once "..\includes\db.php";

// Get the JSON payload
$data = json_decode(file_get_contents('php://input'), true);
$recordId = $data['recordId'];
$userId = $data['userId'];

$table = 'likes';
$fields = [
    'like_timestamp' => date('Y-m-d H:i:s')
];

// Check if the user has already liked this record
$sql = "SELECT * FROM likes WHERE user_id = ? AND record_id = ?";
$filter = [$userId, $recordId];
$result = query($conn, $sql, $filter);


if (!empty($result)) {
    // If the record exists, toggle the status
    
    $like = $result[0];

    $fields['like_status'] = $like['like_status'] === 'A' ? 'I' : 'A';
    $filter = [
        'like_id' => $like['like_id']
    ];
    
    update($conn, $table, $fields, $filter);

} else {
    // If the record does not exist, add a new like

    $fields = array_merge($fields, [
        'user_id' => $userId,
        'record_id' => $recordId,
        'like_status' => 'A'
    ]);
    
    insert($conn, $table, $fields);
}

$liked = true;

// Return JSON response
echo json_encode(['liked' => $liked]);