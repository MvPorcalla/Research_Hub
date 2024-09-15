<?php
include_once "../includes/db.php";

// Ensure the connection is available
if (!$conn) {
    $response = array('status' => 'error', 'message' => 'Database connection failed!');
    echo json_encode($response);
    exit();
}

header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => '');

if (isset($_FILES['profilePic']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details to get the last name, first name, and middle initial
    $sql = "SELECT user_lastname, user_firstname, user_mi FROM users WHERE user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $user_id); // 'i' for integer
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && $user['user_lastname'] && $user['user_firstname']) {
            $lastname = $user['user_lastname'];
            $firstname = $user['user_firstname'];
            $mi = $user['user_mi'] ? $user['user_mi'] : ''; // Optional middle initial

            $file = $_FILES['profilePic'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileName = $lastname . ', ' . $firstname . ' ' . $mi . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadDir = '../uploads/idImages/';
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    $sql = "UPDATE users SET user_idpicture_imgdir = ? WHERE user_id = ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param('si', $uploadFile, $user_id); // 's' for string, 'i' for integer
                        if ($stmt->execute()) {
                            $response['status'] = 'success';
                            $response['message'] = "Profile picture updated successfully!";
                        } else {
                            $response['message'] = "Database update failed!";
                        }
                        $stmt->close();
                    } else {
                        $response['message'] = "Failed to prepare update statement!";
                    }
                } else {
                    $response['message'] = "File upload failed!";
                }
            } else {
                $response['message'] = "No file uploaded or file upload error!";
            }
        } else {
            $response['message'] = "User details not found!";
        }
    } else {
        $response['message'] = "Failed to prepare query!";
    }
} else {
    $response['message'] = "Invalid request!";
}

echo json_encode($response);
?>
