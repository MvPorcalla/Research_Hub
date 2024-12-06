<?php
include_once "../includes/db.php";

if (isset($_POST['token']) && isset($_POST['password'])) {

    $token = $_POST['token'];
    $pwdhash = password_hash($_POST['password'], PASSWORD_ARGON2ID);

    $table = 'users';
    $fields = [
        'user_pwdhash' => $pwdhash,
        'user_reset_token_expire' => $current_timestamp
    ];
    $filter = ['user_reset_token' => $token];

    if (update($conn, $table, $fields, $filter)) {
        header("Location: ../login.php?reset=success");
        exit;
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&reset=failed");
        exit;
    }
}
