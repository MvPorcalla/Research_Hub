<?php
include_once "..\includes\db.php";

if (isset($_GET['accept']) || isset($_GET['decline'])) {

    $table = "users";

    if (isset($_GET['accept'])) {

        $fields = ['user_status' => 'A'];
        $filter = ['user_id' => $_GET['accept']];

        if (update($conn, $table, $fields, $filter)) {
            header("location: ..\pages\admin\pendingRequest.php?action=accepted");
            exit();
        } else {
            header("location: ..\pages\admin\pendingRequest.php?action=failed");
            exit();
        }

    } else if (isset($_GET['decline'])) {

        $fields = ['user_status' => 'I'];
        $filter = ['user_id' => $_GET['decline']];

        if (update($conn, $table, $fields, $filter)) {
            header("location: ..\pages\admin\pendingRequest.php?action=declined");
            exit();
        } else {
            header("location: ..\pages\admin\pendingRequest.php?action=failed");
            exit();
        }

    }
}