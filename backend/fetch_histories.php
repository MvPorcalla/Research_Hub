<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "../includes/db.php";

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];

$sql = "SELECT h.history_id, h.record_id, h.history_timestamp, r.record_title 
        FROM `histories` h
        JOIN `records` r ON h.record_id = r.record_id
        WHERE h.user_id = ? AND h.history_status = 'A'
        ORDER BY DATE(h.history_timestamp) DESC, h.history_timestamp DESC
";
$filter = [$userId];
$histories = query($conn, $sql, $filter);

$dataByDate = [];

foreach ($histories as $history) {
    $date = date('Y-m-d', strtotime($history['history_timestamp']));
    if (!isset($dataByDate[$date])) {
        $dataByDate[$date] = [];
    }
    $dataByDate[$date][] = [
        'history_id' => $history['history_id'],
        'record_id' => $history['record_id'],
        'record' => $history['record_title'],
    ];
}

echo json_encode($dataByDate);
