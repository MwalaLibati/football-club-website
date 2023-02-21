<?php
include_once 'validator.php';

if (!validate_text($_POST["firstName"], 'required')) {
    echo "Please Provide Valid First Name";
} elseif (!validate_text($_POST["lastName"], 'required')) {
    echo "Please Provide Valid Last Name";
} elseif (!validate_email($_POST["email"], 'required')) {
    echo "Please Provide Valid Email";
} else {

    $firstName = stripOff($conn, $_POST["firstName"]);
    $lastName = stripOff($conn, $_POST["lastName"]);
    $email = stripOff($conn, $_POST["email"]);

    $token = md5(md5(time() . 'In The Glorious Land' . rand(0, 9999)));

    $sql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', token = '$token' WHERE email = '$email' and active = 1";

    $data = mysqli_query($conn, "SELECT userId from users WHERE email = '$email' and active = 1");

    if (mysqli_num_rows($data) == 1) {
        if (mysqli_query($conn, $sql)) {
            setcookie('firstName', $firstName, time() + (86400 * 30), "/");
            setcookie('lastName', $lastName, time() + (86400 * 30), "/");
            echo 'success';
        } else {
            echo "Failed To Save Changes";
        }
    } else {
        echo "Failed To Save Changes";
    }
}
