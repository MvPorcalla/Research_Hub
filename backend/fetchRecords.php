<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json');

// Initialize $response array
$response = [];

$fetchType = $_GET['fetch'] ?? '';

if ($fetchType == 'entries' && isset($_GET['entry_id'])) {
    $entry_id = $_GET['entry_id'] ?? '';

    $sql = "SELECT * 
            FROM `forum_entry` e 
            JOIN `users` u ON u.user_id = e.user_id 
            WHERE e.entry_status = 'A' 
            AND e.entry_id = $entry_id 
            ORDER BY e.entry_timestamp DESC";
    $entry_result = query($conn, $sql);

    if (!empty($entry_result)) {
        $row = $entry_result[0];
        $response[] = [
            'entryId' => htmlspecialchars($row['entry_id'], ENT_QUOTES, 'UTF-8'),
            'userId' => htmlspecialchars($row['user_user'], ENT_QUOTES, 'UTF-8'),
            'userName' => htmlspecialchars($row['user_username'], ENT_QUOTES, 'UTF-8'),
            'imgDir' => htmlspecialchars($row['user_idpicture_imgdir'], ENT_QUOTES, 'UTF-8'),
            'lastName' => htmlspecialchars($row['user_lastname'], ENT_QUOTES, 'UTF-8'),
            'firstName' => htmlspecialchars($row['user_firstname'], ENT_QUOTES, 'UTF-8'),
            'mi' => htmlspecialchars($row['user_mi'], ENT_QUOTES, 'UTF-8'),
            'entryContent' => htmlspecialchars($row['entry_content'], ENT_QUOTES, 'UTF-8'),
            'entryTimestamp' => htmlspecialchars($row['entry_timestamp'], ENT_QUOTES, 'UTF-8'),
            'entryLikes' => htmlspecialchars($row['entry_likes'], ENT_QUOTES, 'UTF-8'),
            'entryComments' => htmlspecialchars($row['entry_comments'], ENT_QUOTES, 'UTF-8'),
        ];
    }
}

$comment_type = ($fetchType == 'comments') ? $_GET['comment_on'] : '';
$record_id = $_GET['record_id'] ?? null;

$queries = [
    'abstracts' => "SELECT * FROM `records` WHERE `record_status` = 'A' ORDER BY `record_year` DESC, `record_month` DESC",
    'students' => "SELECT * FROM `users` u JOIN `lrn` ON u.lrn_id = lrn.lrn_id WHERE `user_type` = 'S' AND `user_status` = 'A'",
    'guests' => "SELECT * FROM `users` WHERE `user_type` = 'G' AND `user_status` = 'A'",
    'LRNs' => "SELECT * FROM `lrn` WHERE lrn_status = 'A'",
    'pending' => "SELECT * FROM `users` WHERE `user_type` = 'G' AND `user_status` = 'P'",
    'favorites' => "SELECT * FROM `likes` l JOIN `records` r ON r.record_id = l.record_id WHERE l.user_id = {$user_id} and l.like_status = 'A' ORDER BY l.like_timestamp DESC",
    'comments' => "SELECT * FROM `comments` c JOIN `users` u ON u.user_id = c.user_id WHERE {$comment_type} = {$record_id} AND `comment_status` = 'A' ORDER BY `comment_timestamp` DESC",
    'entries' => "SELECT * FROM `forum_entry` e JOIN `users` u ON u.user_id = e.user_id WHERE e.entry_status = 'A' ORDER BY e.entry_timestamp DESC",
];

$results = $queries[$fetchType] ? query($conn, $queries[$fetchType]) : null;

if ($results) {
    foreach ($results as $result) {
        $response[] = match ($fetchType) {
            'abstracts' => [
                'id' => htmlspecialchars($result['record_id'], ENT_QUOTES, 'UTF-8'),
                'title' => htmlspecialchars($result['record_title'], ENT_QUOTES, 'UTF-8'),
                'yearmonth' => DateTime::createFromFormat('!m', htmlspecialchars($result['record_month'], ENT_QUOTES, 'UTF-8'))->format('F') . ' ' . htmlspecialchars($result['record_year'], ENT_QUOTES, 'UTF-8'),
                'authors' => htmlspecialchars($result['record_authors'], ENT_QUOTES, 'UTF-8'),
                'trackstrand' => htmlspecialchars($result['record_trackstrand'], ENT_QUOTES, 'UTF-8'),
                'filedir' => htmlspecialchars($result['record_filedir'], ENT_QUOTES, 'UTF-8')
            ],
            'students' => [
                'id' => htmlspecialchars($result['user_id'], ENT_QUOTES, 'UTF-8'),
                'fname' => htmlspecialchars($result['user_firstname'], ENT_QUOTES, 'UTF-8'),
                'mi' => htmlspecialchars($result['user_mi'], ENT_QUOTES, 'UTF-8'),
                'lname' => htmlspecialchars($result['user_lastname'], ENT_QUOTES, 'UTF-8'),
                'lrn' => htmlspecialchars($result['lrn_lrnid'], ENT_QUOTES, 'UTF-8'),
                'track' => htmlspecialchars($result['user_trackstrand'], ENT_QUOTES, 'UTF-8')
            ],
            'guests' => [
                'id' => htmlspecialchars($result['user_id'], ENT_QUOTES, 'UTF-8'),
                'fname' => htmlspecialchars($result['user_firstname'], ENT_QUOTES, 'UTF-8'),
                'mi' => htmlspecialchars($result['user_mi'], ENT_QUOTES, 'UTF-8'),
                'lname' => htmlspecialchars($result['user_lastname'], ENT_QUOTES, 'UTF-8'),
                'school' => htmlspecialchars($result['user_school'], ENT_QUOTES, 'UTF-8')
            ],
            'LRNs' => [
                'id' => htmlspecialchars($result['lrn_id'], ENT_QUOTES, 'UTF-8'),
                'fullname' => htmlspecialchars($result['lrn_student'], ENT_QUOTES, 'UTF-8'),
                'lrn' => htmlspecialchars($result['lrn_lrnid'], ENT_QUOTES, 'UTF-8')
            ],
            'pending' => [
                'id' => htmlspecialchars($result['user_id'], ENT_QUOTES, 'UTF-8'),
                'fname' => htmlspecialchars($result['user_firstname'], ENT_QUOTES, 'UTF-8'),
                'mi' => htmlspecialchars($result['user_mi'], ENT_QUOTES, 'UTF-8'),
                'lname' => htmlspecialchars($result['user_lastname'], ENT_QUOTES, 'UTF-8'),
                'email' => htmlspecialchars($result['user_emailadd'], ENT_QUOTES, 'UTF-8'),
                'school' => htmlspecialchars($result['user_school'], ENT_QUOTES, 'UTF-8'),
                'reason' => htmlspecialchars($result['user_reason'], ENT_QUOTES, 'UTF-8')
            ],
            'favorites' => [
                'id' => htmlspecialchars($result['like_id'], ENT_QUOTES, 'UTF-8'),
                'record_id' => htmlspecialchars($result['record_id'], ENT_QUOTES, 'UTF-8'),
                'title' => htmlspecialchars($result['record_title'], ENT_QUOTES, 'UTF-8')
            ],
            'comments' => [
                'userName' => htmlspecialchars($result['user_username'], ENT_QUOTES, 'UTF-8'),
                'userIdImage' => htmlspecialchars($result['user_idpicture_imgdir'], ENT_QUOTES, 'UTF-8'),
                'commentId' => htmlspecialchars($result['comment_id'], ENT_QUOTES, 'UTF-8'),
                'commentContent' => htmlspecialchars($result['comment_content'], ENT_QUOTES, 'UTF-8'),
                'commentTimestamp' => htmlspecialchars($result['comment_timestamp'], ENT_QUOTES, 'UTF-8'),
                'commentLikes' => htmlspecialchars($result['comment_likes'], ENT_QUOTES, 'UTF-8')
            ],
            'entries' => [
                'entryId' => htmlspecialchars($result['entry_id'], ENT_QUOTES, 'UTF-8'),
                'userId' => htmlspecialchars($result['user_user'], ENT_QUOTES, 'UTF-8'),
                'userName' => htmlspecialchars($result['user_username'], ENT_QUOTES, 'UTF-8'),
                'imgDir' => htmlspecialchars($result['user_idpicture_imgdir'], ENT_QUOTES, 'UTF-8'),
                'lastName' => htmlspecialchars($result['user_lastname'], ENT_QUOTES, 'UTF-8'),
                'firstName' => htmlspecialchars($result['user_firstname'], ENT_QUOTES, 'UTF-8'),
                'mi' => htmlspecialchars($result['user_mi'], ENT_QUOTES, 'UTF-8'),
                'entryContent' => htmlspecialchars($result['entry_content'], ENT_QUOTES, 'UTF-8'),
                'entryTimestamp' => htmlspecialchars($result['entry_timestamp'], ENT_QUOTES, 'UTF-8'),
                'entryLikes' => htmlspecialchars($result['entry_likes'], ENT_QUOTES, 'UTF-8'),
                'entryComments' => htmlspecialchars($result['entry_comments'], ENT_QUOTES, 'UTF-8'),
            ],
            default => []
        };
    }
}

echo json_encode($response);
