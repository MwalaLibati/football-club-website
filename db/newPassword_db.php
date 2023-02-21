<?php

include_once 'validator.php';

if (!validate_password($_POST["password"], 'required')) {
    echo "Please Provide New password";
} elseif (!validate_signup_password($_POST["password"], 'required')) {
    echo "Password Must Contain At Least 4 Characters";
} elseif (!validate_password($_POST["confirmPassword"], 'required')) {
    echo "Please Confirm New password";
} elseif (!validate_passwords_match($_POST["password"], $_POST["confirmPassword"])) {
    echo "Passwords Do Not Match";
} else {
    if (isset($_COOKIE["email"])) {
        $email = stripOff($conn, $_COOKIE["email"]);
        $password = stripOff($conn, $_POST["password"]);
        $token = md5(md5(time() . 'KB2Letter' . rand(0, 9999)));
        $data = mysqli_query($conn, "SELECT password FROM users WHERE email LIKE '$email' AND active = 1");
        if (mysqli_num_rows($data) == 1) {
            $user = mysqli_fetch_assoc($data);
            if (password_verify($password, $user["password"])) {
                echo "Do Not Use Your Old Password";
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
                $sql = "UPDATE users SET password = '$password', token = '$token' WHERE email = '$email' and active = 1";

                /*************send email*************/
                $heading = 'Password Changed Successfully!';
                $mainComment = 'Please be sure you keep your new password private';
                $btnHref = '';
                $subComment = 'If you did not request for password reset, please contact support.';
                include_once '../partials/templates/emailTemplate.php';
                $message = $emailTemplate;
                $to = $email;
                $subject = "Password Reset";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
                if ($onLocalhost && mysqli_query($conn, $sql)) {
                    file_put_contents("../../emailOffline.html", $message); //offline test email
                    setcookie('displayUI', '', time() - 3600, "/");
                    // setcookie('email', '', time() - 3600, "/");
                    echo 'success';
                } elseif (!$onLocalhost) {
                    if (mail($to, $subject, $message, $headers) && mysqli_query($conn, $sql)) {
                        setcookie('displayUI', '', time() - 3600, "/");
                        // setcookie('email', '', time() - 3600, "/");
                        echo 'success';
                    } else {
                        echo "OOPS! An error occurred. Please try again";
                    }
                } else {
                    echo "OOPS! An error occurred... Please try again";
                }
                /*************send email*************/
            }
        }
    } else {
        echo "OOPS! An error occurred.. Please try again";
    }
}
