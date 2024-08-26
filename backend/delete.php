<?php
include_once "..\includes\db.php";

if (isset($_GET['abstractId'])) {

    $table = "records";
    $fields = ['record_status' => 'I'];
    $filter = ['record_id' => $_GET['abstractId']];

    if (update($conn, $table, $fields, $filter)) {
        header("location: ..\pages\admin\index.php?deleteRecord=success");
        exit();
    } else {
        header("location: ..\pages\admin\index.php?deleteRecord=failed");
        exit();
    }

} else if (isset($_GET['userId'])) {

    $table = "users";
    $fields = ['user_status' => 'I'];
    $filter = ['user_id' => $_GET['userId']];

    if (update($conn, $table, $fields, $filter)) {
        header("location: ..\pages\admin\listUser.php?deleteRecord=success");
        exit();
    } else {
        header("location: ..\pages\admin\listUser.php?deleteRecord=failed");
        exit();
    }

} else if (isset($_GET['lrnId'])) {

    $table = "lrn";
    $fields = ['lrn_status' => 'I'];
    $filter = ['lrn_id' => $_GET['lrnId']];

    if (update($conn, $table, $fields, $filter)) {

        $table = "users";
        $fields = ['user_status' => 'I'];
        $filter = ['lrn_id' => $_GET['lrnId']];

        if (update($conn, $table, $fields, $filter)) {

            header("location: ..\pages\admin\listLRN.php?deleteRecord=success");
            exit();
        }

    } else {
        header("location: ..\pages\admin\listLRN.php?deleteRecord=failed");
        exit();
    }

}