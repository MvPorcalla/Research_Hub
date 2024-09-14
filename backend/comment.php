<?php
include_once "..\includes\db.php";

if (isset($_POST['comment_content'])) {

    //transfers value of name="" from form to variable
    $user_id = $_SESSION['user_id'];
    $comment_content = $_POST['comment_content'];
    
    $table = 'comments';
    $fields = [
        'user_id' => $user_id,
        'comment_content' => $comment_content,
    ];

    if (isset($_POST['record_id']) || isset($_POST['entry_id'])) {
        $key = isset($_POST['record_id']) ? 'record_id' : 'entry_id';
        $fields[$key] = $_POST[$key];
        
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'abstractView') !== false) {
            $file = "abstractView.php?abstractId={$fields[$key]}&";
        } else {
            $file = 'index.php?';
        }

        $status = insert($conn, $table, $fields) ? "success" : "failed";
        $redirectUrl = $key === 'record_id' ? "../pages/user/{$file}comment={$status}" : "../pages/user/forum.php?comment={$status}";
        
        header("Location: $redirectUrl");
        exit;
    }
}
