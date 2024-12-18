<?php
    include_once "../includes/db.php";

    header('Content-Type: application/json'); // Set content type to JSON

    $response = array('status' => 'error', 'message' => '');

    if (isset($_POST['lastName'])) {
        
        // Assign form values to variables
        $lastname = $_POST['lastName'];
        $firstname = $_POST['firstName'];
        $mi = $_POST['middleInitial'];
        $username = $_POST['usernameField'];
        $email = $_POST['emailField'];

        // Fetch the current profile data from the database
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $filter = [$_SESSION['user_id']];
        $result = query($conn, $sql, $filter);

        if (empty($result)) {
            $response['message'] = "User not found!";
            echo json_encode($response);
            exit;
        }

        $current = $result[0];

        // Check if the email already exists for another user
        $emailCheckSql = "SELECT * FROM users WHERE user_emailadd = ? AND user_id != ?";
        $emailCheckFilter = [$email, $_SESSION['user_id']];
        $emailCheckResult = query($conn, $emailCheckSql, $emailCheckFilter);

        if (!empty($emailCheckResult)) {
            // If email is found, return an error
            $response['message'] = "Email already exists!";
            echo json_encode($response);
            exit;
        }

        // Check if there are any changes
        $changes = false;
        if ($lastname !== $current['user_lastname'] || 
            $firstname !== $current['user_firstname'] || 
            $mi !== $current['user_mi'] || 
            $username !== $current['user_username'] || 
            $email !== $current['user_emailadd']) {
            $changes = true;
        }

        if (!$changes) {
            $response['message'] = "No changes detected!";
            echo json_encode($response);
            exit;
        }

        // Prepare fields for database update
        $old_imgdir = $current['user_profilepic_imgdir'];
        $fileext = pathinfo($old_imgdir, PATHINFO_EXTENSION); //[ext]

        $new_filename = "{$lastname}, {$firstname} {$mi}";
        $new_imgdir = "../uploads/profilePictures/{$new_filename}.{$fileext}";

        // Attempt to rename the file
        if (!rename($old_imgdir, $new_imgdir)) {
            $response['message'] = "Failed to rename the image file!";
            echo json_encode($response);
            exit;
        }

        // Prepare fields for database update
        $table = "users";
        $fields = [
            'user_lastname' => $lastname,
            'user_firstname' => $firstname,
            'user_mi' => $mi,
            'user_username' => $username,
            'user_emailadd' => $email,
            'user_profilepic_imgdir' => $new_imgdir
        ];
        $filter = ['user_id' => $_SESSION['user_id']];

        if (update($conn, $table, $fields, $filter)) {
            $response['status'] = 'success';
            $response['message'] = "Profile updated successfully!";
            $_SESSION['user_username'] = $username;
        } else {
            $response['message'] = "Failed to update profile!";
        }

        echo json_encode($response);
        exit;
    } else {
        $response['message'] = "Invalid request!";
        echo json_encode($response);
        exit;
    }
