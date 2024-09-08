<?php
include_once "../includes/db.php";

header('Content-Type: application/json'); // Set content type to JSON

$response = [
    'status' => 'error',
    'notifications' => [],
    'totalNotifCount' => 0
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

$total_notif_count = 0;

if ($user_type == 'A') {
    // ========================= PENDING REQUESTS =========================

    $sql = "SELECT
                COUNT(*) AS `pending_count`,
                MAX(`user_registration_timestamp`) AS `latest_registered` 
            FROM `users` 
            WHERE `user_status` = 'P'";
    $result = query($conn, $sql);

    $row = $result[0];

    $pending_count = $row['pending_count'];
    $latest_registered = $row['latest_registered'];

    if ($pending_count != 0) {

        $response['notifications'][] = [
            'type' => 'pending',
            'count' => $pending_count,
            'latest' => $latest_registered
        ];
        $response['status'] = 'success';

    }
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
                AND e.entry_id = ?";
        $filter = [$user_lastlogin, $user_id, $entry_id];
        $result = query($conn, $sql, $filter);
    
        $row = $result[0];
    
        $entry_id = $row['entry_id'];
        $entry_content = $row['entry_content'];
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

        $total_notif_count += $comment_count;
    }

    // ============================ LIKES =============================

    $sql = "SELECT `entry_id` FROM `forum_entry` WHERE `entry_status` = 'A' AND `user_id` = ?";
    $result = query($conn, $sql, [$user_id]);

    foreach ($result as $key => $value) {
        $entry_id = $value['entry_id'];

        $sql = "SELECT
                    e.entry_id AS `entry_id`,
                    e.entry_content AS `entry_content`,
                    COUNT(*) AS `like_count`, 
                    MAX(`like_timestamp`) AS `latest_like` 
                FROM `likes` l
                JOIN `forum_entry` e ON e.entry_id = l.entry_id
                WHERE l.like_status = 'A'
                AND l.like_timestamp > ?
                AND e.user_id = ?
                AND e.entry_id = ?
                AND l.user_id != ?";
        $filter = [$user_lastlogin, $user_id, $entry_id, $user_id];
        $result = query($conn, $sql, $filter);
    
        $row = $result[0];
    
        $entry_id = $row['entry_id'];
        $entry_content = $row['entry_content'];
        $like_count = $row['like_count'];
        $latest_like = $row['latest_like'];

        if ($like_count != 0) {
            $response['notifications'][] = [
                'type' => 'like',
                'entryId' => $entry_id,
                'entryContent' => $entry_content,
                'count' => $like_count,
                'latest' => $latest_like
            ];
        }

        $total_notif_count += $like_count;
    }
    
    $response['totalNotifCount'] = $total_notif_count;
    $response['status'] = 'success';
}

echo json_encode($response);
exit;