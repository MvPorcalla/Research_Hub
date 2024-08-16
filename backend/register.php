<?php
include_once "..\includes\db.php";

// checks if value of name="lrn" is set
if ((isset($_POST['lrn']) || isset($_POST['email'])) && $_FILES['idImage']['error'] == '0') {

    //transfers value of name="" from form to variable
    $r_role = $_POST['role'];
    $r_lastName = trim($_POST['lastName']);
    $r_firstName = trim($_POST['firstName']);
    $r_middleInitial = trim($_POST['middleInitial'] ?? NULL);
    $r_username = trim($_POST['username']);
    $r_email = trim($_POST['email']);
    $r_lrn = trim($_POST['lrn'] ?? NULL);
    $r_trackStrand = trim($_POST['trackStrand'] ?? NULL);
    $r_school = trim($_POST['school'] ?? NULL);
    $r_reason = trim($_POST['reason'] ?? NULL);

    //for id image file
    $fileName = "{$r_lastName}, {$r_firstName} {$r_middleInitial}";
    $file = $_FILES['idImage']['name']; //[basename.ext]
    $fileext = pathinfo($file, PATHINFO_EXTENSION); //[ext]
    $temp = $_FILES['idImage']['tmp_name']; //temporary location
    $r_idImage = "../idImages/{$fileName}.{$fileext}"; //target location

    //hashes value of name="reg_password" from form then transfered to variable
    $r_pwdhash = password_hash($_POST['password'], PASSWORD_ARGON2ID);

    // create session variables
    $_SESSION["username"] = $r_username;
    $_SESSION["password"] = $r_pwdhash;

    // echo "
    //     'user_lastname' => $r_lastName,<br>
    //     'user_firstname' => $r_firstName,<br>
    //     'user_mi' => $r_middleInitial,<br>
    //     'user_username' => $r_username,<br>
    //     'user_emailadd' => $r_email,<br>
    //     'user_lrn' => $r_lrn,<br>
    //     'user_trackstrand' => $r_trackStrand,<br>
    //     'user_idpicture_imgdir' => $r_idImage,<br>
    //     'user_school' => $r_school,<br>
    //     'user_reason' => $r_reason,<br>
    //     'user_pwdhash' => $r_pwdhash,<br>
    //     'user_type' => '{$r_role}',<br>
    //     'user_status' => 'A'
    // ";

    // exit;

    $filter = [$r_lrn];

    //preparing arguments for insert()
    $table = "users";
    $fields = [
        'user_lastname' => $r_lastName,
        'user_firstname' => $r_firstName,
        'user_mi' => $r_middleInitial,
        'user_username' => $r_username,
        'user_emailadd' => $r_email,
        'user_trackstrand' => $r_trackStrand,
        'user_idpicture_imgdir' => $r_idImage,
        'user_school' => $r_school,
        'user_reason' => $r_reason,
        'user_pwdhash' => $r_pwdhash,
        'user_type' => $r_role,
        'user_status' => 'A'
    ];

    $role = ($r_role == 'S') ? "Student" : "Guest";

    //checks if $r_lrn exists in table `lrn`
    $sql = "SELECT `lrn_id`, `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?";
    $result = query($conn, $sql, $filter);

    //if $r_lrn does not exist in table `lrn`, then go back to registration page, else proceed
    if (empty($result) && $r_role == 'S') {
        header("location: ../register{$role}.php?registration=wronglrn");
        exit();
    } else {

        $fields['lrn_id'] = $result[0]['lrn_id'];

        //checks if $r_lrn exists in table `users`
        $sql = "SELECT u.lrn_id, lrn.lrn_id, lrn.lrn_lrnid
                FROM `users` u
                JOIN `lrn` ON u.lrn_id = lrn.lrn_id
                WHERE lrn.lrn_lrnid = ?";
        $result = query($conn, $sql, $filter);


        //if $r_lrn does not exist in table `users`, then proceed, else go back to registration page
        if (empty($result)) {

            // if uploaded file is successfully moved, then proceed, else go back to registration page
            if (move_uploaded_file($temp, $r_idImage)) {
                // if data is successfully inserted to database, then proceed, else go back to registration page
                if (insert($conn, $table, $fields)) {

                    if ($r_role == 'G') {
                        header("location: ../index.php?registration=success");
                        exit();
                    } else {
                        header("location: ../pages/user/index.php?login=success");
                        exit();
                    }
                } else {
                    header("location: ../register{$role}.php?registration=failed");
                    exit();
                }
            } else {
                header("location: ../register{$role}.php?registration=failed");
                exit();
            }
        }
        //if $result is not empty
        else {
            header("location: ../register{$role}.php?registration=existing");
            exit();
        }
    }
}