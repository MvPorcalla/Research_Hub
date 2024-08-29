<?php
    header('Content-Type: application/json');

    // Database connection
    include_once "../includes/db.php";

    // Get the search query
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

    // Only include the WHERE clause if there's a query
    $sql = "SELECT * 
            FROM `records` 
            WHERE `record_status` = 'A'";
    if ($query !== '') {
        $search_query = "%" . $conn->real_escape_string($query) . "%";
        $sql .= "  AND (
                        `record_title` LIKE ?
                        OR `record_authors` LIKE ?
                        OR `record_year` LIKE ?
                        OR `record_month` LIKE ?
                    )";
    $sql .= "ORDER BY `record_year` DESC, `record_month` DESC";
    }

    $stmt = $conn->prepare($sql);
    if ($query !== '') {
        $stmt->bind_param("ssss", $search_query, $search_query, $search_query, $search_query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($data);
?>
