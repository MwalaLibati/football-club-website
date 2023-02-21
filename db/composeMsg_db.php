<?php
include_once 'validator.php';

if (!validate_email($_POST["email"], 'required')) {
    echo "Please Provide Valid Email";
} elseif (!validate_text($_POST["subject"], 'required')) {
    echo "Please Provide Valid Subject";
} elseif (!validate_textarea($_POST["comment"], 'required')) {
    echo "Please Provide Valid Content In Body (No Special Characters Allowed)";
} elseif (!validate_decimal_or_whole_number($_POST["contactId"], 'required')) {
    echo "Please Reload Page And Try Again";
} else {

    $subject1 = stripOff($conn, $_POST["subject"]);
    $contactId = stripOff($conn, $_POST["contactId"]);
    $email = stripOff($conn, $_POST["email"]);
    $comment = stripOff($conn, $_POST["comment"]);

    $sql = "INSERT INTO adminreplys (
            contactId,
            comment
            ) VALUES (
                 $contactId, 
                '$comment'
                )";

    /*************send email*************/
    $heading = $subject1;
    $mainComment = $comment;
    $btnHref = '';
    $subComment = 'If this response does not satisfy your query, please contact support.';
    include_once '../partials/templates/emailTemplate.php';
    $message = $emailTemplate;
    $to = $email;
    $subject = $subject1;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
    if ($onLocalhost && mysqli_query($conn, $sql)) {
        file_put_contents("../../emailOffline.html", $message); //offline test email
        echo 'success';
    } elseif (!$onLocalhost) {
        if (mail($to, $subject, $message, $headers) && mysqli_query($conn, $sql)) {
            echo 'success';
        } else {
            echo "OOPS! An error occurred. Please try again";
        }
    } else {
        echo "OOPS! An error occurred... Please try again";
    }
    /*************send email*************/
}
