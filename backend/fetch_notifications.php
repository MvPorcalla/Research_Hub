<?php
include_once "../includes/db.php";

header('Content-Type: application/json'); // Set content type to JSON

$response = [
    'status' => 'error',
    'notifications' => [],
    'totalCommentCount' => 0
];

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$user_lastlogin = $_SESSION['user_lastlogin']; // previous log in


// FOR PENDING NOTIFICATION
//========================= retrieve when admin last logged in
//========================= count how many registered and became pending from admin's last log in to now
// insert notification details to database in notifications table
    // columns consisting the response[notifications][] + user_id + status
    // status: A: Active, I: Inactive
// remove/decrease count on notif bell once seen

if ($user_type == 'A') {
    // ========================= PENDING REQUESTS =========================

    $sql = "SELECT COUNT(*) AS pending_count 
            FROM `users` 
            WHERE `user_status` = 'P' 
            AND `user_registration_timestamp` > ?";
    $result = query($conn, $sql, [$user_lastlogin]);

    $row = $result[0];

    $pending_count = $row['pending_count'];

    $response['notifications'][] = [
        'type' => 'pending',
        'count' => $pending_count
    ];
    $response['status'] = 'success';
} else {
    // ============================ ABSTRACTS ============================

    $sql = "SELECT
                COUNT(*) AS abstract_count,
                MAX(`record_timestamp`) AS latest_added 
            FROM `records` 
            WHERE `record_status` = 'A' 
            AND `record_timestamp` > ?";
    $result = query($conn, $sql, [$user_lastlogin]);

    $row = $result[0];

    $abstract_count = $row['abstract_count'];
    $latest_added = $row['latest_added'];
    $response['notifications'][] = [
        'type' => 'abstract',
        'count' => $abstract_count,
        'latest' => $latest_added
    ];

    // ============================ COMMENTS =============================

    $total_comment_count = 0;

    $sql = "SELECT `entry_id` FROM `forum_entry` WHERE `entry_status` = 'A' AND `user_id` = ?";
    $result = query($conn, $sql, [$user_id]);

    foreach ($result as $key => $value) {
        $entry_id = $value['entry_id'];

        $sql = "SELECT
                    e.entry_id AS `entry_id`,
                    e.entry_content AS `entry_content`,
                    COUNT(*) AS `comment_count`, 
                    MAX(`comment_timestamp`) AS `latest_comment` 
                FROM `comments` c
                JOIN `forum_entry` e ON e.entry_id = c.entry_id
                WHERE c.comment_status = 'A'
                AND c.comment_timestamp > ?
                AND e.user_id = ?
                AND e.entry_id = ?
                AND c.user_id != ?";
        $filter = [$user_lastlogin, $user_id, $entry_id, $user_id];
        $result = query($conn, $sql, $filter);
    
        $row = $result[0];
    
        $entry_content = $row['entry_content'];
        $entry_id = $row['entry_id'];
        $comment_count = $row['comment_count'];
        $latest_comment = $row['latest_comment'];

        if ($comment_count != 0) {
            $response['notifications'][] = [
                'type' => 'comment',
                'entryId' => $entry_id,
                'entryContent' => $entry_content,
                'count' => $comment_count,
                'latest' => $latest_comment
            ];
        }

        $total_comment_count += $comment_count;
    }
    
    $response['totalCommentCount'] = $total_comment_count;
    $response['status'] = 'success';
}

echo json_encode($response);
exit;