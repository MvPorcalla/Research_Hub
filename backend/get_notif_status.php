<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "..\includes\db.php";

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

$sql = "SELECT `user_notif_abstracts`, `user_notif_likescomments` FROM `users` WHERE `user_id` = ?";
$result = query($conn, $sql, [ $user_id ]);
$row = $result[0];

echo json_encode([
    'newAbstracts' => $row['user_notif_abstracts'],
    'likesComments' => $row['user_notif_likescomments']
]);
