<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "..\includes\db.php";

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
        $fields[$key] = $_POST[$key];

        $status = insert($conn, $table, $fields) ? "success" : "error";
        $response['status'] = $status;
    }
}
echo json_encode($response);
exit;
