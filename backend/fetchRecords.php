<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off display errors in production
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '/path/to/error.log'); // Path to error log file

include_once "../includes/db.php";

header('Content-Type: application/json');

// Initialize the $response variable as an array
$response = [];

// Fetch records from the database, ordering by year and month in ascending order
$records = query($conn, "SELECT * FROM `records` WHERE `record_status` = 'A' ORDER BY `record_year` DESC, `record_month` ASC");

// Check if records were returned
if ($records) {
    foreach ($records as $record) {
        // Convert the numeric month to the month name
        $monthNumber = htmlspecialchars($record['record_month'], ENT_QUOTES, 'UTF-8');
        $monthName = DateTime::createFromFormat('!m', $monthNumber)->format('F');
        
        $response[] = [
            'id' => htmlspecialchars($record['record_id'], ENT_QUOTES, 'UTF-8'),
            'title' => htmlspecialchars($record['record_title'], ENT_QUOTES, 'UTF-8'),
            'year' => htmlspecialchars($record['record_year'], ENT_QUOTES, 'UTF-8'),
            'month' => $monthName
        ];
    }
}

// Output the response as JSON
echo json_encode($response);
?>
