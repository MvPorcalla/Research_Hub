<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

// Include database connection file
include_once "../includes/db.php";

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if entryId is provided
if (isset($data['entryId'])) {
    $entryId = $data['entryId'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE forum_entry SET entry_status = 'I' WHERE entry_id = ?");
    $stmt->bind_param("i", $entryId);

    // Execute the statement
    if ($stmt->execute()) {
        // Send JSON response
        echo json_encode(['success' => true]);
    } else {
        // Send JSON response
        echo json_encode(['success' => false, 'message' => 'Failed to update entry status.']);
    }

    // Close the statement
    $stmt->close();
} else {
    // Send JSON response if no entryId is provided
    echo json_encode(['success' => false, 'message' => 'No entry ID provided.']);
}

// Close the connection
$conn->close();
