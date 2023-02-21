<?php
// die('success');
include_once 'validator.php';

if (!validate_text($_POST["fullName"], 'required')) {
    echo "Please Provide Valid Full Name";
} elseif (!validate_email($_POST["email"], 'required')) {
    echo "Please Provide Valid Email";
} elseif (!validate_textarea($_POST["comment"], 'required')) {
    echo "Please Provide Valid Comment (No Special Characters Allowed)";
} else {

    $fullName = stripOff($conn, $_POST["fullName"]);
    $email = stripOff($conn, $_POST["email"]);
    $comment = stripOff($conn, $_POST["comment"]);
    $userId = 'anonymous';
    if (isset($_COOKIE["userId"])) {
        $userId = stripOff($conn, $_COOKIE["userId"]);
    }

    $sql = "INSERT INTO contactus (
            userId,
            fullName,
            email,
            comment
            ) VALUES (
                '$userId', 
                '$fullName', 
                '$email', 
                '$comment'
                )";

    /*************send email*************/
    $heading = 'Message From User:<br>' . $fullName;
    $mainComment = $comment;
    $btnHref = '';
    $subComment = '';
    include_once '../partials/templates/emailTemplate.php';
    $message = $emailTemplate;
    $to = 'support@mufulirawanderers.com';
    $subject = "User Query";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <' . $email . '>' . "\r\n";
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
    /*************send email*************/
}
