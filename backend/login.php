<?php
include_once "../includes/db.php";

if (isset($_POST['username'])) {

    //transfers value of name="" from form to variable
    $l_username = $_POST['username'];
    $l_password = $_POST['password'];

    //checks if $l_username exists in table `users`
    $sql = "SELECT `user_id`, `user_username`, `user_pwdhash`, `user_type`, `user_status`, `user_lastlogin_timestamp` FROM `users` WHERE user_username = ?";
    $result = query($conn, $sql, [$l_username]);

    //if does not exist in table `users`, then go back to login page, else proceed
    if (empty($result)) {
        header("location: ../login.php?login=failed");
        exit();
    } else {
        $row = $result[0];

        //transfers values from db to variables
        $stored_password = $row['user_pwdhash'];
        $user_status = $row['user_status'];

        if ($user_status == 'I') {
            header("location: ../login.php?login=inactive");
            exit();
        }
        //verifies the pwd typed vs the pwd stored in db
        else if (password_verify($l_password, $stored_password)) {
                
            //transfers value from db to sessioin variable
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_username'] = $row['user_username'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['user_lastlogin'] = $row['user_lastlogin_timestamp'];

            $table = 'users';
            $fields = [ 'user_lastlogin_timestamp' => date('Y-m-d H:i:s') ];
            $filter = [ 'user_id' => $row['user_id'] ];

            update($conn, $table, $fields, $filter);

            $status = $_SESSION['user_type'] == 'A' ? 'admin' : 'user';
            header("location: ../pages/{$status}/index.php?login=success");
            exit();

        } else {
            header("location: ../login.php?login=failed");
            exit();
        }
    }
}
