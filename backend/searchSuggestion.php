<?php
header('Content-Type: application/json');

// Database connection
include_once "../includes/db.php";

    // Get the search query
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

    // Only include the WHERE clause if there's a query
    $sql = "SELECT record_title FROM records WHERE record_status = 'A'";
    if ($query !== '') {
        // Escape and prepare the query string
        $search_query = "%" . $conn->real_escape_string($query) . "%";
        $sql .= " AND record_title LIKE ?";
    }

    $stmt = $conn->prepare($sql);
    if ($query !== '') {
        $stmt->bind_param("s", $search_query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $suggestions = [];

    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['record_title'];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($suggestions);
