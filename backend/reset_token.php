<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "..\includes\db.php";

$data = json_decode(file_get_contents('php://input'), true);
// Get parameters
$email = $data['email'] ?? null;

$sql = "SELECT * FROM `users` WHERE `user_emailadd` = ?";
$result = query($conn, $sql, [$email]);

if (!empty($result)) {
    $row = $result[0];

    if ($row['user_status'] == 'I') {
        echo json_encode(['user_status' => 'I']);
        exit;
    }

    // Generate a reset token
    $token = bin2hex(random_bytes(32));
    $expires = date("U") + 3600; // 1 hour expiration
    $formattedExpires = date('Y-m-d H:i:s', $expires);

    $table = 'users';
    $fields = [
        'user_reset_token' => $token,
        'user_reset_token_expire' => $formattedExpires
    ];
    $filter = ['user_emailadd' => $email];

    if (update($conn, $table, $fields, $filter)) {

        echo json_encode([
            'user_firstname' => $row['user_firstname'],
            'user_reset_token' => $token,
            'user_status' => 'A'
        ]);
    } else {
        echo json_encode(['user_status' => 'E']);
    }
} else {
    echo json_encode(['user_status' => 'V']);
}
