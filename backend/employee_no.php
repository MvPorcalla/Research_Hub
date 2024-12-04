<?php
include_once "../includes/db.php";

// Check if the form is submitted with a lastname
if (isset($_POST['lastName'])) {

    // Assign form values to variables
    $e_lastName = trim($_POST['lastName']);
    $e_firstName = trim($_POST['firstName']);
    $e_mi = trim($_POST['middleInitial']);
    $e_employeeno = trim($_POST['employeeNo']);

    // Prepare fields for database insertion
    $table = "teachers";
    $fields = [
        'teacher_lastname' => $e_lastName,
        'teacher_firstname' => $e_firstName,
        'teacher_mi' => $e_mi,
        'teacher_depedno' => $e_employeeno
    ];

    // If editing an existing record
    if (isset($_GET['teacherId'])) {
        $teacher_id = $_GET['teacherId'];

        // Update the existing record
        $filter = ['teacher_id' => $teacher_id];
        $status = update($conn, $table, $fields, $filter) ? 'success' : 'failed';
        header("Location: ../pages/admin/listIDPage.php?editRecord={$status}");
        exit;
    } else {

        // Check if the deped number already exists
        $sql = "SELECT `teacher_id`, `teacher_depedno` FROM `teachers` WHERE `teacher_depedno` = ?";
        $filter = [$e_employeeno];
        $result = query($conn, $sql, $filter);

        empty($result)
            ? $status = insert($conn, $table, $fields) ? 'success' : 'failed'
            : $status = 'existing';

        header("Location: ../pages/admin/listIDPage.php?addRecord={$status}");
        exit;
    }
}
