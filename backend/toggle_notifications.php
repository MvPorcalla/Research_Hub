<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

// Include database connection file
include_once "../includes/db.php";

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];
    $status = $data['status'];
    $user_id = $_SESSION['user_id'];

    $table = "users";
    $filter = [ 'user_id' => $user_id ];

    $fields = match ($id) {
        'notificationCheckbox' => [
            'user_notif_abstracts' => $status,
            'user_notif_likescomments' => $status,
        ],
        'newAbstracts' => [
            'user_notif_abstracts' => $status
        ],
        'likesComments' => [
            'user_notif_likescomments' => $status
        ]
    };

    echo (update($conn, $table, $fields, $filter))
        ? json_encode(['success' => true])
        : json_encode(['success' => false, 'message' => 'Failed to update notif status.']);
}
