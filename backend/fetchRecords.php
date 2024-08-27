<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable error display in production
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '/path/to/error.log'); // Log file path

include_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json');

// Initialize $response array
$response = [];

$queries = [
    'abstracts' => "SELECT * FROM `records` WHERE `record_status` = 'A' ORDER BY `record_year` DESC, `record_month` DESC",
    'students' => "SELECT * FROM `users` u JOIN `lrn` ON u.lrn_id = lrn.lrn_id WHERE `user_type` = 'S' AND `user_status` = 'A'",
    'guests' => "SELECT * FROM `users` u WHERE `user_type` = 'G' AND `user_status` = 'A'",
    'LRNs' => "SELECT * FROM `lrn` WHERE lrn_status = 'A'",
    'pending' => "SELECT * FROM `users` u WHERE `user_type` = 'G' AND `user_status` = 'P'",
    'favorites' => "SELECT * FROM `likes` l JOIN `records` r ON r.record_id = l.record_id WHERE l.user_id = {$user_id} and l.like_status = 'A' ORDER BY l.like_timestamp DESC",
];

$fetchType = $_GET['fetch'] ?? '';
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
                'title' => htmlspecialchars($result['record_title'], ENT_QUOTES, 'UTF-8')
            ],
            default => []
        };
    }
}

echo json_encode($response);
?>