<?php
include_once "../includes/db.php";

$userId = $_SESSION['user_id'];

$sql = "SELECT h.record_id, h.history_timestamp, r.record_title 
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
    $dataByDate[$date][] = $history['record_title'];
}

header('Content-Type: application/json');
echo json_encode($dataByDate);
?>
