<?php
// fetch_data.php
include '../includes/db.php'; // Adjust the path as needed

$sql = "SELECT file_icon, title FROM research_papers"; // Adjust the query based on your table structure
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data); // Encode data as JSON
$conn->close();
?>
