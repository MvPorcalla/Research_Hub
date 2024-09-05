<?php
    include_once "../includes/db.php";

    // Check if the current password is provided
    if (isset($_POST['currentPassword'])) {

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];
        $current_password = $_POST['currentPassword'];
        $new_password = $_POST['newPassword'];
        $confirm_new_password = $_POST['confirmNewPassword'];

        // Check if new password matches confirm new password
        if ($new_password !== $confirm_new_password) {
            echo "New password and confirm password do not match!";
            exit;
        }

        // Hash the new password after confirming it matches
        $hashed_new_password = password_hash($new_password, PASSWORD_ARGON2ID);

        // Fetch the user's current password from the database
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $filter = [$user_id];
        $result = query($conn, $sql, $filter);

        // Check if a user was found
        if ($result) {
            $row = $result[0];

            // Verify the current password entered matches the stored password
            if (password_verify($current_password, $row['user_pwdhash'])) {
                // Update the password in the database
                $table = "users";
                $fields = [
                    'user_pwdhash' => $hashed_new_password,
                ];
                $filter = [
                    'user_id' => $user_id
                ];

                if (update($conn, $table, $fields, $filter)) {
                    echo "Password updated successfully!";
                } else {
                    echo "Failed to update password!";
                }
            } else {
                echo "Incorrect current password!";
            }
        } else {
            echo "User not found!";
        }
    }
?>
