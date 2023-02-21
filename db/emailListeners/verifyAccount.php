<?php

include_once '../connect.php';
include_once '../validator.php';

if (
    validate_email($_GET['email'], 'required') &&
    validate_token($_GET['token'], 'required')
) {

    $email = stripOff($conn, $_GET['email']);
    $token = stripOff($conn, $_GET['token']);

    $result = mysqli_query($conn, "SELECT * from users WHERE email='$email' and token='$token' and active='0'");
    $result1 = mysqli_query($conn, "SELECT * from users WHERE email='$email' and token='$token' and active='1'");

    if (mysqli_num_rows($result) == 0) {

        $feedback = "Account does not exist&type=error";
    }
    if (mysqli_num_rows($result1) == 1) {

        $feedback = "Account has already been activated&type=neutral";
    }
    if (mysqli_num_rows($result) == 1) {

        if (mysqli_query($conn, "UPDATE users SET active='1' where email='$email'")) {
            $feedback = "Verification Successfully.<br>You can now login to your account&type=success";
        } else {
            $feedback = "Verification Unsuccessfully. Please try again&type=error";
        }
    }
} else {
    $feedback = "Incorrect URL.";
}

header("Location: ../../index.php?msg=" . $feedback);
