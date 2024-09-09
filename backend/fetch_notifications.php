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
$user_lastlogin = $_SESSION['user_lastlogin']; // previous log in\

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

    // ======================== COMMENTS AND LIKES ========================

    $sql = "SELECT `entry_id` FROM `forum_entry` WHERE `entry_status` = 'A' AND `user_id` = ?";
    $result = query($conn, $sql, [$user_id]);

    foreach ($result as $key => $value) {
        $entry_id = $value['entry_id'];

        $sql = "SELECT
                    e.entry_id AS `entry_id`,
                    e.entry_content AS `entry_content`,
                    COALESCE(c.comment_count, 0) AS `comment_count`, 
                    COALESCE(l.like_count, 0) AS `like_count`, 
                    GREATEST(COALESCE(c.latest_comment, '0000-00-00 00:00:00'), COALESCE(l.latest_like, '0000-00-00 00:00:00')) AS `latest_activity`
                FROM `forum_entry` e
                LEFT JOIN (
                    SELECT 
                        c.entry_id,
                        COUNT(*) AS `comment_count`,
                        MAX(c.comment_timestamp) AS `latest_comment`
                    FROM `comments` c
                    WHERE c.comment_status = 'A'
                    AND c.comment_timestamp > ?
                    AND c.user_id != ?
                    GROUP BY c.entry_id
                ) c ON e.entry_id = c.entry_id
                LEFT JOIN (
                    SELECT 
                        l.entry_id,
                        COUNT(*) AS `like_count`,
                        MAX(l.like_timestamp) AS `latest_like`
                    FROM `likes` l
                    WHERE l.like_status = 'A'
                    AND l.like_timestamp > ?
                    AND l.user_id != ?
                    GROUP BY l.entry_id
                ) l ON e.entry_id = l.entry_id
                WHERE e.user_id = ?
                AND e.entry_id = ?;
        ";

        $filter = [$user_lastlogin, $user_id, $user_lastlogin, $user_id, $user_id, $entry_id];
        $result = query($conn, $sql, $filter);
    
        $row = $result[0];
    
        $entry_id = $row['entry_id'];
        $entry_content = $row['entry_content'];
        $comment_count = $row['comment_count'];
        $like_count = $row['like_count'];
        $latest_activity = $row['latest_activity'];

        if ($comment_count > 0) {
            $response['notifications'][] = [
                'type' => 'comment',
                'entryId' => $entry_id,
                'entryContent' => $entry_content,
                'count' => $comment_count,
                'latest' => $latest_activity
            ];
        }
        
        if ($like_count > 0) {
            $response['notifications'][] = [
                'type' => 'like',
                'entryId' => $entry_id,
                'entryContent' => $entry_content,
                'count' => $like_count,
                'latest' => $latest_activity
            ];
        }

        $total_notif_count += $comment_count + $like_count;
    }
    
    $response['totalNotifCount'] = $total_notif_count;
    $response['status'] = 'success';
}

echo json_encode($response);
exit;