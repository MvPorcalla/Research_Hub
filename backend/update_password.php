<?php
include_once "../includes/db.php";

header('Content-Type: application/json'); // Set content type to JSON

$response = array('status' => 'error', 'message' => '');

if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {
    $user_id = $_SESSION['user_id'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if ($newPassword !== $confirmNewPassword) {
        $response['message'] = "New password and confirm password do not match!";
        echo json_encode($response);
        exit;
    }

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $filter = [$user_id];
    $result = query($conn, $sql, $filter);

    if (!empty($result)) {
        $row = $result[0];
        
        if (password_verify($currentPassword, $row['user_pwdhash'])) {
            if ($currentPassword === $newPassword) {
                $response['message'] = "New password cannot be the same as the current password!";
            } else {
                $new_password_hashed = password_hash($newPassword, PASSWORD_ARGON2ID);
                $table = "users";
                $fields = ['user_pwdhash' => $new_password_hashed];
                $filter = ['user_id' => $user_id];

                if (update($conn, $table, $fields, $filter)) {
                    $response['status'] = 'success';
                    $response['message'] = "Password updated successfully!";
                } else {
                    $response['message'] = "Password update failed!";
                }
            }
        } else {
            $response['message'] = "Current password is incorrect!";
        }
    } else {
        $response['message'] = "User not found!";
    }
} else {
    $response['message'] = "Please fill in all required fields!";
}

echo json_encode($response);
?>
