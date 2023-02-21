<?php
include_once 'validator.php';

if (!validate_email($_POST["email"], 'required')) {
    echo "Invalid Email";
} else {

    $email = stripOff($conn, $_POST["email"]);

    $data = mysqli_query($conn, "SELECT * FROM users WHERE email LIKE '$email' AND active = 1");
    if (mysqli_num_rows($data) == 1) {
        $user = mysqli_fetch_assoc($data);
        $token = $user["token"];

        /*************send email*************/
        $heading = 'Password Reset';
        $mainComment = 'Click the button below to reset your password';
        if ($onLocalhost) {
            $url = 'http://localhost:8080/myprojects/football-club-website/';
        } elseif (!$onLocalhost) {
            $url = 'https://mufulirawanderers.com/';
        }
        $btnHref = '
        <a href="' . $url . 'db/emailListeners/mail_password_reset.php?email=' . $email . '&token=' . $token . '"
        style="background-color:#029141; border:1px solid #029141; border-color:#029141; border-radius:0px; border-width:1px; color:#ffffff; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 40px 12px 40px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;"
        target="_blank">
            Reset Password
        </a>';
        $subComment = 'If you did not request for password reset, please contact support.';
        include_once '../partials/templates/emailTemplate.php';
        $message = $emailTemplate;
        $to = $email;
        $subject = "Password Reset";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
        if ($onLocalhost) { //for localhost
            file_put_contents("../../emailOffline.html", $message); //offline test email
            echo 'success';
        } elseif (!$onLocalhost) {
            if (mail($to, $subject, $message, $headers)) {
                echo 'success';
            } else {
                echo "OOPS! An error occurred. Please try again";
            }
        } else {
            echo "OOPS! An error occurred... Please try again";
        }
        /*************send email*************/
    } else {
        echo "Invalid Email.";
    }
}
