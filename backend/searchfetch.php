<?php
    header('Content-Type: application/json');

    // Database connection
    include_once "../includes/db.php";

    // Get the search query
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

    if (isset($_GET['record_type'])) {
        if ($_GET['record_type'] == 'record') {

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
                                OR `record_trackstrand` LIKE ?
                            )";
            $sql .= "ORDER BY `record_year` DESC, `record_month` DESC";
            }

            $stmt = $conn->prepare($sql);
            if ($query !== '') {
                $stmt->bind_param("sssss", $search_query, $search_query, $search_query, $search_query, $search_query);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $stmt->close();
            $conn->close();

        } else if ($_GET['record_type'] == 'student') {

            // Only include the WHERE clause if there's a query
            $sql = "SELECT * 
                    FROM `users` u 
                    JOIN `lrn` ON u.lrn_id = lrn.lrn_id 
                    WHERE u.`user_type` = 'S' AND u.`user_status` = 'A'";
            if ($query !== '') {
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                $sql .= "  AND (
                                u.`user_lastname` LIKE ?
                                OR u.`user_firstname` LIKE ?
                                OR u.`user_mi` LIKE ?
                                OR lrn.`lrn_lrnid` LIKE ?
                                OR u.`user_trackstrand` LIKE ?
                            )";
            }

            $stmt = $conn->prepare($sql);
            if ($query !== '') {
                $stmt->bind_param("sssss", $search_query, $search_query, $search_query, $search_query, $search_query);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $stmt->close();
            $conn->close();

        } else if ($_GET['record_type'] == 'guest') {

            // Only include the WHERE clause if there's a query
            $sql = "SELECT * 
                    FROM `users` 
                    WHERE `user_type` = 'G' AND `user_status` = 'A'";
            if ($query !== '') {
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                $sql .= "  AND (
                                `user_lastname` LIKE ?
                                OR `user_firstname` LIKE ?
                                OR `user_mi` LIKE ?
                                OR `user_school` LIKE ?
                            )";
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

        } else if ($_GET['record_type'] == 'lrn') {

            // Only include the WHERE clause if there's a query
            $sql = "SELECT *
                    FROM `lrn` 
                    WHERE `lrn_status` = 'A'";
            if ($query !== '') {
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                $sql .= "  AND (
                                `lrn_student` LIKE ?
                                OR `lrn_lrnid` LIKE ?
                            )";
            }

            $stmt = $conn->prepare($sql);
            if ($query !== '') {
                $stmt->bind_param("ss", $search_query, $search_query);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $stmt->close();
            $conn->close();

        }
    echo json_encode($data);
    }
?>
