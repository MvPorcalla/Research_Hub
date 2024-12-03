<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "../includes/db.php";

header('Content-Type: application/json'); // Set content type to JSON

$response = ['status' => 'error'];

if (isset($_POST['comment_content'])) {

    //transfers value of name="" from form to variable
    $user_id = $_SESSION['user_id'];
    $comment_content = $_POST['comment_content'];
    
    $table = 'comments';
    $fields = [
        'user_id' => $user_id,
        'comment_content' => $comment_content
    ];

    if (isset($_POST['record_id']) || isset($_POST['entry_id'])) {
        $key = isset($_POST['record_id']) ? 'record_id' : 'entry_id';
        $value = $_POST[$key];
        $fields[$key] = $value;

        $status = insert($conn, $table, $fields) ? "success" : "error";
        $response['status'] = $status;

        if ($status == 'success') {
            $sql = "SELECT c.*, u.*, l.like_status
                    FROM `comments` c
                    JOIN `users` u ON u.user_id = c.user_id
                    LEFT JOIN `likes` l  ON c.comment_id = l.comment_id  AND l.user_id = {$user_id}
                    WHERE c.{$key} = ?
                    AND u.`user_id` = ?
                    AND c.`comment_content` = ?
                    AND c.`comment_status` = 'A'";
            $filter = [ $value, $user_id, $comment_content ];
            $result = query($conn, $sql, $filter);
            $response['data'] = $result[0];
        }
    }
}
echo json_encode($response);
exit;
