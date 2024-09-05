<?php
    include_once "../includes/db.php"; // Include your database connection

    // Check if the current password is provided
    if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        // Check if new password and confirm password match
        if ($new_password !== $confirm_new_password) {
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
            if (password_verify($current_password, $row['user_pwdhash'])) {

                // Hash the new password
                $new_password_hashed = password_hash($new_password, PASSWORD_ARGON2ID);

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