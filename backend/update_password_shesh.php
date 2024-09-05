<?php
    include_once "../includes/db.php"; // Include your database connection

    // Check if the current password is provided
    if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        // Check if new password and confirm password match
        if ($newPassword !== $confirmNewPassword) {
            echo "New password and confirm password do not match!";
            exit;
        }

        // Fetch the current password hash from the database
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $filter = [$user_id];
        $result = query($conn, $sql, $filter);

        if (!empty($result)) {
            $row = $result[0];
            
            // Verify if the entered current password matches the stored hash
            if (password_verify($currentPassword, $row['user_pwdhash'])) {

                // Hash the new password
                $new_password_hashed = password_hash($newPassword, PASSWORD_ARGON2ID);

                // Update the password in the database
                $table = "users";
                $fields = [
                    'user_pwdhash' => $new_password_hashed,
                ];
                $filter = [
                    'user_id' => $user_id
                ];

                // Attempt to update the password in the database
                if (update($conn, $table, $fields, $filter)) {
                    echo "Password updated successfully!";
                } else {
                    echo "Password update failed!";
                }

            } else {
                // If the current password is incorrect
                echo "Current password is incorrect!";
            }
        } else {
            echo "User not found!";
        }
    } else {
        echo "Please fill in all required fields!";
    }
?>