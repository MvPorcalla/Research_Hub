<?php
    include_once "../../includes/db.php";

    if (!isset($_SESSION['user_type'])) {
        header("location: ../../index.php");
        exit;
    } elseif ($_SESSION['user_type'] != 'A') {
        header("location: ../../backend/logout.php");
        exit;
    }
?>