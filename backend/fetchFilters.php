<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database connection
include_once "../includes/db.php";

// Prepare SQL query to get distinct months
$monthSql = "SELECT DISTINCT record_month
            FROM records
            WHERE record_status = 'A'
            ORDER BY record_month DESC";

$monthResult = $conn->query($monthSql);
$months = [];
while ($row = $monthResult->fetch_assoc()) {
    $months[] = $row['record_month'];
}

// Prepare SQL query to get distinct years
$yearSql = "SELECT DISTINCT record_year
            FROM records
            WHERE record_status = 'A'
            ORDER BY record_year DESC";

$yearResult = $conn->query($yearSql);
$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['record_year'];
}

// Prepare SQL query to get distinct tracks/strands
$trackSql = "SELECT DISTINCT record_trackstrand
             FROM records
             WHERE record_status = 'A'
             ORDER BY record_trackstrand ASC";

$trackResult = $conn->query($trackSql);
$tracks = [];
while ($row = $trackResult->fetch_assoc()) {
    $tracks[] = $row['record_trackstrand'];
}

$conn->close();

echo json_encode([
    'months' => $months,
    'years' => $years,
    'tracks' => $tracks
]);
?>
