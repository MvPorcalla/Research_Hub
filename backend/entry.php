<?php
include_once "../includes/db.php";

if (isset($_POST['question'])) {

    //transfers value of name="" from form to variable
    $user_id = $_SESSION['user_id'];
    $question = $_POST['question'];
    
    $table = 'forum_entry';
    $fields = [
        'user_id' => $user_id,
        'entry_content' => $question,
    ];

    $status = insert($conn, $table, $fields) ? "success" : "failed";
    header("Location: ../pages/user/forum.php?entry={$status}");
    exit;
}
