<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php'; // Ensure you have PHPMailer installed via Composer

include_once "..\includes\db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_email = $_POST['email'];

    if (filter_var($f_email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists in database
        $sql = "SELECT `user_id` FROM `users` WHERE `user_emailadd` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $f_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Generate a reset token
            $token = bin2hex(random_bytes(32));
            $expires = date("U") + 3600; // 1 hour expiration

            // Update the token and expiration in the database
            $sql = "UPDATE `users` SET `user_reset_token` = ?, `user_reset_token_expire` = ? WHERE `user_emailadd` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $token, $expires, $f_email);
            $stmt->execute();

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'research.hub0811@gmail.com';
                $mail->Password = 'greatwallofchina';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('research.hub0811@gmail.com', 'Research Hub');
                $mail->addAddress($f_email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Click <a href='http://localhost/research_Hub/resetPassword.php?token={$token}'>here</a> to reset your password.";

                $mail->send();
                echo 'Reset link has been sent to your email.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'No account found with that email address.';
        }
    } else {
        echo 'Invalid email format.';
    }
    $stmt->close();
}
$conn->close();