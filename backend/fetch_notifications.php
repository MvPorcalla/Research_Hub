<?php
include_once "../includes/db.php";

header('Content-Type: application/json'); // Set content type to JSON

$response = [ 'notifications' => [] ];

$user_id = $_SESSION['user_id'];
$user_lastlogin = $_SESSION['user_lastlogin']; // previous log in


// FOR PENDING NOTIFICATION
//========================= retrieve when admin last logged in
//========================= count how many registered and became pending from admin's last log in to now
// insert notification details to database in notifications table
    // columns consisting the response[notifications][] + user_id + status
    // status: A: Active, I: Inactive
// remove/decrease count on notif bell once seen

// ========================= PENDING REQUESTS =========================

$sql = "SELECT COUNT(*) AS pending_count 
        FROM `users` 
        WHERE `user_status` = 'P' 
        AND `user_registration_timestamp` > ?";
$filter = [$user_lastlogin];
$result = query($conn, $sql, $filter);

$row = $result[0];

$pending_count = $row['pending_count'];

$response['notifications'][] = [
    'type' => 'pending',
    'count' => $pending_count
];

// ============================ ABSTRACTS ============================

$sql = "SELECT
            COUNT(*) AS abstract_count,
            MAX(`record_timestamp`) AS latest_added 
        FROM `records` 
        WHERE `record_status` = 'A' 
        AND `record_timestamp` > ?";
$filter = [$user_lastlogin];
$result = query($conn, $sql, $filter);

$row = $result[0];

$abstract_count = $row['abstract_count'];
$latest_added = $row['latest_added'];
$response['notifications'][] = [
    'type' => 'abstract',
    'count' => $abstract_count,
    'latest' => $latest_added
];

// ============================ COMMENTS =============================

// count how many commented on a single user entry
// latest commment timestamp

// ====================================================================

echo json_encode($response);
exit;