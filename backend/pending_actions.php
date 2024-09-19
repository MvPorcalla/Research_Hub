<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

include_once "..\includes\db.php";

$data = json_decode(file_get_contents('php://input'), true);

// assignment of passed variables
$action = $data['action'] ?? null;
$user_id = $data['userId'] ?? null;

// select user based on user id
$sql = "SELECT * FROM `users` WHERE `user_id` = ?";
$result = query($conn, $sql, [$user_id]);
$row = $result[0];

function generateRandomPassword($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
    }
    
    return $randomPassword;
}

$table = "users";
$filter = ['user_id' => $user_id];

if ($action == 'accept') {

    // generate random username and password
    $user_name = "user_" . rand(100000, 999999);
    $password = generateRandomPassword();

    // hash password
    $pwdhash = password_hash($password, PASSWORD_ARGON2ID);

    // prepare field arguments for update
    $fields = [
        'user_username' => $user_name,
        'user_pwdhash' => $pwdhash,
        'user_status' => 'A',
    ];

    if (update($conn, $table, $fields, $filter)) {
        echo json_encode([
            'userName' => $user_name,
            'userEmail' => $row['user_emailadd'],
            'password' => $password,
            'firstName' => $row['user_firstname'],
        ]);
    }
} else {
    $sql = "DELETE FROM `users` WHERE `user_id` = ?";
    
    // Prepare the statement to avoid SQL injection
    $stmt = $conn->prepare($sql);
    
    // Bind the parameter (the record ID)
    $stmt->bind_param("i", $user_id); // "i" indicates that the parameter is an integer
    
    // Step 4: Execute the query
    if ($stmt->execute()) {
        echo json_encode(['action' => 'deleted']);
    }
    
    // Step 5: Close the statement and connection
    $stmt->close();
    $conn->close();
}
