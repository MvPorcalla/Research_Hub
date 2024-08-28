<?php
include_once "..\includes\db.php";

if (isset($_POST['comment_content'])) {

    //transfers value of name="" from form to variable
    $record_id = $_POST['record_id'];
    $user_id = $_POST['user_id'];
    $comment_content = $_POST['comment_content'];

    echo "Record: {$record_id}<br>";
    echo "User: {$user_id}<br>";
    echo "Comment: {$comment_content}<br>";
    
    $table = 'comments';
    $fields = [
        'record_id' => $record_id,
        'user_id' => $user_id,
        'comment_content' => $comment_content,
    ];

    $status = insert($conn, $table, $fields) ? "success" : "failed";
    header("Location: ../pages/user/abstractView.php?abstractId={$record_id}&comment={$status}");
    exit;
}