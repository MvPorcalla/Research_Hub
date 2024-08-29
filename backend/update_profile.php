<?php
include_once "../includes/db.php";

if (isset($_POST['lastName'])) {
    
    // Assign form values to variables
    $lastname = $_POST['lastName'];
    $firstname = $_POST['firstName'];
    $mi = $_POST['middleInitial'];
    $username = $_POST['usernameField'];
    $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

    // Fetch the image directory from the database
    $sql = "SELECT `user_idpicture_imgdir` FROM `users` WHERE `user_id` = ?";
    $filter = [$_SESSION['user_id']];
    $result = query($conn, $sql, $filter);

    $old_imgdir = $result[0]['user_idpicture_imgdir'];
    $fileext = pathinfo($old_imgdir, PATHINFO_EXTENSION); //[ext]

    $new_filename = "{$lastname}, {$firstname} {$mi}";
    $new_imgdir = "../uploads/idImages/{$new_filename}.{$fileext}";

    $page_type = ($_SESSION['user_type'] == 'A') ? "admin" : "user";

    // Attempt to rename the file
    if (!rename($old_imgdir, $new_imgdir)) {
        // Redirect if the renaming fails
        header("Location: ../pages/{$page_type}/setting.php?editInfo=failed");
        exit;
    }

    // Prepare fields for database insertion
    $table = "users";
    $fields = [
        'user_lastname' => $lastname,
        'user_firstname' => $firstname,
        'user_mi' => $mi,
        'user_username' => $username,
        'user_pwdhash' => $password,
        'user_idpicture_imgdir' => $new_imgdir
    ];
    $filter = ['user_id' => $_SESSION['user_id']];

    $status = update($conn, $table, $fields, $filter) ? 'success' : 'failed';
    header("Location: ../pages/{$page_type}/setting.php?editInfo={$status}");
    exit;
}