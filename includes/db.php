<?php
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="rh_db";

    $conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

    // Check connection
    if (!$conn){
        die("Maintenance Mode.");
    }

    session_start();
    date_default_timezone_set('Asia/Manila');
    include_once "sql_utilities.php";
    
    $current_timestamp = date('Y-m-d H:i:s');