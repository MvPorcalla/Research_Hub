<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');
// =================================== FOR FETCHING ABSTRACTS, STUDENTS, GUESTS AND LRNS ===================================

// Database connection
include_once "../includes/db.php";

header('Content-Type: application/json');

// Get the search query and filters
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$month = isset($_GET['month']) ? trim($_GET['month']) : '';
$year = isset($_GET['year']) ? trim($_GET['year']) : '';
$track = isset($_GET['track']) ? trim($_GET['track']) : '';

$data = [];

if (isset($_GET['record_type'])) {
    switch ($_GET['record_type']) {

        // ================================================ FETCH ABSTRACTS ================================================
        case 'record':
            
            // Base SQL query to select records which are (record_status = 'A')
            $sql = "SELECT * FROM `records` WHERE `record_status` = 'A'";

            // Check if a search query is provided
            if ($query !== '') {
                // Escape and format the search query for use in the SQL statement
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                
                // Append conditions to the SQL query for searching by title or authors
                $sql .= " AND (
                            `record_title` LIKE ?
                            OR `record_authors` LIKE ?
                        )";
            }
            
            // Map the column names to their corresponding filter variables
            $conditions = [
                'record_month' => $month, 
                'record_year' => $year, 
                'record_trackstrand' => $track
            ];

            // Loop through each condition and append it to the SQL query if the filter value is not empty
            foreach ($conditions as $column => $value) {
                if ($value !== '') {
                    $sql .= " AND `$column` = ?"; // Add the condition to the SQL query
                }
            }

            // Append an ORDER BY clause to sort the results first by record_year in descending order
            // Then, within each year, sort by record_month in descending order
            $sql .= " ORDER BY `record_year` DESC, `record_month` DESC";

            // Prepare and bind parameters
            $stmt = $conn->prepare($sql);

            // Initialize an empty array to hold the parameter values for the prepared statement
            $params = [];

            // Initialize an empty string to hold the types of the parameters (e.g., "s" for strings, "i" for integers)
            $types = '';


            if ($query !== '') {
                // If a search query is provided, add it to the parameters array twice (for matching two columns)
                $params = [$search_query, $search_query];
                // Add "ss" to types (two string types for the search query parameters)
                $types .= "ss";
            }
            
            // Define an associative array for additional filters (month, year, track)
            $filters = [
                $month => $month, 
                $year => $year, 
                $track => $track
            ];
            
            // Loop through each filter, and if it's not empty, add it to the parameters array and types string
            foreach ($filters as $key => $value) {
                if ($key !== '') {
                    $params[] = $value;
                    $types .= "s";  // Add "s" to types (indicating a string parameter)
                }
            }
            
            // If types are defined (meaning there are parameters to bind), bind them to the prepared statement
            if ($types) {
                $stmt->bind_param($types, ...$params);
            }

            break;

        // ================================================= FETCH STUDENTS =================================================
        case 'student':

            // Base SQL query to select users who are students (user_type = 'S') and active (user_status = 'A')
            // Also includes a JOIN with the 'lrn' table on lrn_id
            $sql = "SELECT * 
                    FROM `users` u 
                    JOIN `lrn` ON u.lrn_id = lrn.lrn_id 
                    WHERE u.`user_type` = 'S' AND u.`user_status` = 'A'";

            // Check if a search query is provided
            if ($query !== '') {
                // Escape and format the search query for use in the SQL statement
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                
                // Append conditions to the SQL query for searching by lastname, firstname, middle initial, LRN ID, or track/strand
                $sql .= "  AND (
                                u.`user_lastname` LIKE ?
                                OR u.`user_firstname` LIKE ?
                                OR u.`user_mi` LIKE ?
                                OR lrn.`lrn_lrnid` LIKE ?
                                OR u.`user_trackstrand` LIKE ?
                            )";
            }

            // Append an ORDER BY clause to sort results by user_lastname in ascending order
            $sql .= "   ORDER BY u.`user_lastname` ASC";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters if a search query is provided (binds the same search query to all search conditions)
            if ($query !== '') {
                $stmt->bind_param("sssss", $search_query, $search_query, $search_query, $search_query, $search_query);
            }

            break;

        // ================================================== FETCH TEACHERS ==================================================
        case 'teacher':

            // Base SQL query to select users who are teachers (user_type = 'T') and active (user_status = 'A')
            $sql = "SELECT * 
                    FROM `users` 
                    WHERE `user_type` = 'T' AND `user_status` = 'A'";

            // Check if a search query is provided
            if ($query !== '') {
                // Escape and format the search query for use in the SQL statement
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                
                // Append conditions to the SQL query for searching by lastname, firstname, middle initial
                $sql .= "  AND (
                                `user_lastname` LIKE ?
                                OR `user_firstname` LIKE ?
                                OR `user_mi` LIKE ?
                            )";
            }

            // Append an ORDER BY clause to sort results by user_lastname in ascending order
            $sql .= "   ORDER BY `user_lastname` ASC";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters if a search query is provided (binds the same search query to all search conditions)
            if ($query !== '') {
                $stmt->bind_param("sss", $search_query, $search_query, $search_query);
            }

            break;

        // ================================================== FETCH GUESTS ==================================================
        case 'guest':

            // Base SQL query to select users who are guests (user_type = 'G') and active (user_status = 'A')
            $sql = "SELECT * 
                    FROM `users` 
                    WHERE `user_type` = 'G' AND `user_status` = 'A'";

            // Check if a search query is provided
            if ($query !== '') {
                // Escape and format the search query for use in the SQL statement
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                
                // Append conditions to the SQL query for searching by lastname, firstname, middle initial, or school
                $sql .= "  AND (
                                `user_lastname` LIKE ?
                                OR `user_firstname` LIKE ?
                                OR `user_mi` LIKE ?
                                OR `user_school` LIKE ?
                            )";
            }

            // Append an ORDER BY clause to sort results by user_lastname in ascending order
            $sql .= "   ORDER BY `user_lastname` ASC";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters if a search query is provided (binds the same search query to all search conditions)
            if ($query !== '') {
                $stmt->bind_param("ssss", $search_query, $search_query, $search_query, $search_query);
            }

            break;

        // =================================================== FETCH LRNS ===================================================
        case 'lrn':

            // Base SQL query to select records from the 'lrn' table where 'lrn_status' is active ('A')
            $sql = "SELECT *
                    FROM `lrn` 
                    WHERE `lrn_status` = 'A'";

            // Check if a search query is provided
            if ($query !== '') {
                // Escape and format the search query for use in the SQL statement
                $search_query = "%" . $conn->real_escape_string($query) . "%";
                
                // Append conditions to the SQL query for searching by student name or LRN ID
                $sql .= "  AND (
                                `lrn_student` LIKE ?
                                OR `lrn_lrnid` LIKE ?
                            )";
            }

            // Append an ORDER BY clause to sort results by lrn_id in descending order
            $sql .= "   ORDER BY `lrn_id` DESC";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters if a search query is provided (binds the same search query to both search conditions)
            if ($query !== '') {
                $stmt->bind_param("ss", $search_query, $search_query);
            }

            break;

    }
    // Execute the prepared statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    // Fetch each row of the result and add it to the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
    
    echo json_encode($data);
}
