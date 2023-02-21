<?php
include_once 'validator.php';

if (!validate_text($_POST["firstName"], 'required')) {
    echo "Please Provide Valid First Name";
} elseif (!validate_text($_POST["lastName"], 'required')) {
    echo "Please Provide Valid Last Name";
} elseif (!validate_email($_POST["email"], 'required')) {
    echo "Please Provide Valid Email";
} elseif (!validate_password($_POST["password"], 'required')) {
    echo "Please Provide password";
} elseif (!validate_signup_password($_POST["password"], 'required')) {
    echo "Password Must Contain At Least 4 Characters";
} elseif (!validate_password($_POST["confirmPassword"], 'required')) {
    echo "Please Confirm password";
} elseif (!validate_passwords_match($_POST["password"], $_POST["confirmPassword"])) {
    echo "Passwords Do Not Match";
} else {

    $firstName = stripOff($conn, $_POST["firstName"]);
    $lastName = stripOff($conn, $_POST["lastName"]);
    $email = stripOff($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 10]);
    $token = md5(md5(time() . 'Good And Loved' . rand(0, 9999)));

    $sql = '';
    $sql0 = "INSERT INTO users (
            firstName,
            lastName,
            email,
            password,
            token,
            contact,
            gender,
            nrc,
            address,
            town,
            country
            ) VALUES (
                '$firstName', 
                '$lastName', 
                '$email', 
                '$password', 
                '$token', 
                '', 
                '', 
                '', 
                '', 
                '', 
                '' 
                )";

    $sql1 = "UPDATE users SET 
        firstName = '$firstName', 
        lastName = '$lastName', 
        token = '$token', 
        password = '$password', 
        contact = '', 
        gender = '', 
        nrc = '', 
        address = '', 
        town = '', 
        country = '', 
        active = 0,
        signup_date = NOW(),
        superActive = 1
            WHERE email = '$email' AND active = 0  AND superActive = 0";

    $goodToGoUser = mysqli_query($conn, "SELECT userId from users WHERE email = '$email' AND active = 1  AND superActive = 1");
    $preExistedUser = mysqli_query($conn, "SELECT userId from users WHERE email = '$email' AND active = 0  AND superActive = 0");
    $notActivatedUser = mysqli_query($conn, "SELECT userId from users WHERE email = '$email' AND active = 0  AND superActive = 1");
    $firstTimer = mysqli_query($conn, "SELECT userId from users WHERE email = '$email'");

    if (mysqli_num_rows($preExistedUser) == 1) { //if user deleted account before
        $sql = $sql1;
    }
    if (mysqli_num_rows($notActivatedUser) == 1) { //if signed up  but not activated yet
        die("Please Activate Your Account Using The Link Sent To Your Email");
    }
    if (mysqli_num_rows($goodToGoUser) == 1) { //if signed up  but not activated yet
        die("Account Already Exists");
    }
    if (mysqli_num_rows($firstTimer) == 0) { //first time here
        $sql = $sql0;
    }


    if ($sql != '') {
        /*************send email*************/
        $heading = 'Thanks for signing up<br>' . $firstName . '!';
        $mainComment = 'Please verify your email address by clicking the button below.';
        if ($onLocalhost) {
            $url = 'http://localhost:8080/myprojects/football-club-website/';
        } elseif (!$onLocalhost) {
            $url = 'https://mufulirawanderers.com/';
        }
        $btnHref = '
        <a href="' . $url . 'db/emailListeners/verifyAccount.php?email=' . $email . '&token=' . $token . '"
        style="background-color:#029141; border:1px solid #029141; border-color:#029141; border-radius:0px; border-width:1px; color:#ffffff; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 40px 12px 40px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;"
        target="_blank">
            Verify Email
        </a>';
        $subComment = 'If you did not request an account activation, please ignore this email or contact support';
        include_once '../partials/templates/emailTemplate.php';
        $message = $emailTemplate;
        $to = $email;
        $subject = "Account Verification";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
        if ($onLocalhost && mysqli_query($conn, $sql)) {
            file_put_contents("../../emailOffline.html", $message); //offline test email
            echo 'success';
        } elseif (!$onLocalhost) {
            if (mysqli_query($conn, $sql) && mail($to, $subject, $message, $headers)) { //for production
                echo 'success';
            } else {
                echo "OOPS! An error occurred. Please try again";
            }
        } else {
            echo "OOPS! An error occurred... Please try again";
        }
    } else {
        echo "OOPS! An error occurred.... Please try again";
    }
}
