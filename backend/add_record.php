<?php
include_once "..\includes\db.php";

// checks if value of name="lrn" is set
if (isset($_POST['title']) && $_FILES['file']['error'] == '0') {

    //transfers value of name="" from form to variable
    $ar_title = $_POST['title'];
    $ar_authors = trim($_POST['authors']);
    $ar_monthYear = trim($_POST['monthYear']);
    $ar_trackStrand = trim($_POST['trackStrand'] ?? NULL);

    //separates year and month
    [$year, $month] = explode('-', $ar_monthYear);

    //for abstract file
    $temp = $_FILES['file']['tmp_name']; //temporary location
    $ar_abstract = "../uploads/records/{$ar_title}.pdf"; //target location

    // echo "
    // 'record_title' => $ar_title,<br>
    // 'record_authors' => $ar_authors,<br>
    // 'record_year' => $year,<br>
    // 'record_month' => $month,<br>
    // 'record_filedir' => $ar_abstract,<br>
    // 'record_trackstrand' => $ar_trackStrand
    // ";

    // exit;

    //preparing arguments for insert()
    $table = "records";
    $fields = [
        'record_title' => $ar_title,
        'record_authors' => $ar_authors,
        'record_year' => $year,
        'record_month' => $month,
        'record_filedir' => $ar_abstract,
        'record_trackstrand' => $ar_trackStrand,
        'record_status' => 'A'
    ];

    //checks if $ar_title exists in table `records`
    $sql = "SELECT `record_id`, `record_title` FROM `records` WHERE `record_title` = ?";
    $filter = [$ar_title];
    $result = query($conn, $sql, $filter);

    empty($result)
        ? (
            move_uploaded_file($temp, $ar_abstract)
            ? (
                insert($conn, $table, $fields)
                ? header("location: ..\pages\admin\addRecord.php?addRecord=success")
                : header("location: ..\pages\admin\addRecord.php?addRecord=failed")
            )
            : header("location: ..\pages\admin\addRecord.php?addRecord=failed")
        )
        : header("location: ..\pages\admin\addRecord.php?addRecord=failed");

    exit;
}