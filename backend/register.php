<?php
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log');

// ==================================== data connection ====================================
include_once "..\includes\db.php";

// ================================ Set content type to JSON ================================
header('Content-Type: application/json');

// ================================= initialize $response =================================
$response = ['status' => 'error', 'message' => '', 'redirect' => ''];

// checks if value of name="lrn" is set
if ((isset($_POST['lrn']) || isset($_POST['email'])) && $_FILES['idImage']['error'] == '0') {

    // ======================== transfer value from form to variable ========================
    $role_symbol = $_POST['role'];

    $lastName = trim($_POST['lastName']);
    $firstName = trim($_POST['firstName']);
    $middleInitial = trim($_POST['middleInitial'] ?? NULL);

    $username = trim($_POST['username'] ?? NULL);
    $email = trim($_POST['email']);

    $lrn = trim($_POST['lrn'] ?? NULL);
    $trackStrand = trim($_POST['trackStrand'] ?? NULL);
    $school = trim($_POST['school'] ?? NULL);
    $reason = trim($_POST['reason'] ?? NULL);

    $password = trim($_POST['password'] ?? NULL); 
    $confirm_password = trim($_POST['confirmPassword'] ?? NULL);

    // ================================= for ID image file =================================
    $fileName = "{$lastName}, {$firstName} {$middleInitial}";
    $file = $_FILES['idImage']['name']; //[basename.ext]
    $fileext = pathinfo($file, PATHINFO_EXTENSION); //[ext]

    $temp = $_FILES['idImage']['tmp_name']; //temporary location
    $idImage = "../uploads/idImages/{$fileName}.{$fileext}"; //target location

    // ================================== declare status  ==================================
    $status = ($role_symbol == 'G') ? 'P' : 'A';

    // ====================== prepare arguments for insert() function ======================
    $table = "users";
    $fields = [
        'user_lastname' => $lastName,
        'user_firstname' => $firstName,
        'user_mi' => $middleInitial,

        'user_username' => $username,
        'user_emailadd' => $email,

        'user_trackstrand' => $trackStrand,
        'user_idpicture_imgdir' => $idImage,
        'user_school' => $school,
        'user_reason' => $reason,

        'user_type' => $role_symbol,
        'user_status' => $status
    ];

    if (isset($_POST['password'])) {

        // =============================== compare password ===============================
        if ($password !== $confirm_password) {
            $response['message'] = "Passwords do not match.";
            echo json_encode($response);
            exit();
        }
        // ================================= hash password =================================
        $pwdhash = password_hash($_POST['password'], PASSWORD_ARGON2ID);

        $fields['user_pwdhash'] = $pwdhash;
    }

    if ($role_symbol == 'S') {
        
        // =============== select row from `LRN` table with matching details ===============
        // ========================= to check if details are valid =========================
        $sql = "SELECT *
                FROM `lrn`
                WHERE `lrn_lrnid` = ?
                AND `lrn_lastname` = ?
                AND `lrn_firstname` = ?
                AND `lrn_mi` = ?";
        $filter = [$lrn, $lastName, $firstName, $middleInitial];
        $result = query($conn, $sql, $filter);

        // ============================== if result is empty ==============================
        // ================================ warn: no match ================================
        if (empty($result)) {
    
            $response['message'] = "
                Your name and/or LRN do not match any record in the database.<br>
                <small>Ensure your details are correct. Please contact the admin if you believe there has been a mistake.</small>
            ";
            echo json_encode($response);
            exit();

        }
        // ========== add keys and values to fields argument for insert() function ==========
        $fields['lrn_id'] = $result[0]['lrn_id'];
    }

    // =========================== select rows from `users` table ===========================
    // ================= to check if with username, email is already in use =================
    $sql = "SELECT `user_username`, `user_emailadd`
            FROM `users`
            WHERE `user_username` = ?
            OR `user_emailadd` = ?";
    $filter = [$username, $email];
    $result = query($conn, $sql, $filter);

    if (empty($result)) {
        // ================== move uploaded file to $idImage directory ==================
        if (move_uploaded_file($temp, $idImage)) {
                // ==================== insert arguments to database ====================
                if (insert($conn, $table, $fields)) {
                    
                    $response['status'] = 'success';
                    
                    // =================== redirect according to role ===================
                    ($role_symbol == 'G')
                        ? $response['redirect'] = "index.php?registration=success"
                        : $response['redirect'] = "login.php?login=registered";

                } else {
                    $response['message'] = "Your registration failed. Please try again.";
                }
        } else {
            // ========================= if moving file failed =========================
            // ===================== warn: failed ID picture upload =====================
            $response['message'] = "Your registration failed. Please try again.";
        }
    } else {
        // =========== identify which field(s) matched to an existing account ===========
        $matchedFields = [];
        foreach ($result as $key => $row) {
            if (strcasecmp($row['user_username'], $username) === 0) $matchedFields[] = 'username';
            if (strcasecmp($row['user_emailadd'], $email) === 0) $matchedFields[] = 'email address';
        }
        $response['message'] = "Your entered " . implode(', ', $matchedFields) . " already exists in the database";
    }
}
// ================================ pass info to register.js ================================
echo json_encode($response);
