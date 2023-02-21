<?php
session_start();
session_unset();
session_destroy();

setcookie('userId', '', time() - 3600, "/");
setcookie('firstName', '', time() - 3600, "/");
setcookie('lastName', '', time() - 3600, "/");
setcookie('email', '', time() - 3600, "/");
setcookie('contact', '', time() - 3600, "/");
setcookie('gender', '', time() - 3600, "/");
setcookie('nrc', '', time() - 3600, "/");
setcookie('address', '', time() - 3600, "/");
setcookie('town', '', time() - 3600, "/");
setcookie('country', '', time() - 3600, "/");
setcookie('admin', '', time() - 3600, "/");
setcookie('boss', '', time() - 3600, "/");
setcookie('displayUI', '', time() - 3600, "/");
setcookie('currentMemberType', '', time() - 3600, "/");
setcookie('currentMembershipPaidFor', '', time() - 3600, "/");

include_once 'connect.php';

$data = mysqli_query($conn, "SELECT * from users WHERE email LIKE 'test@mufulirawanderers.com'");

if (mysqli_num_rows($data) == 1) {
    $user = mysqli_fetch_assoc($data);
    $userId = $user["userId"];
    $sql1 = 'DELETE FROM membership WHERE userId = ' . $userId;
    $sql2 = 'DELETE FROM users WHERE email LIKE \'test@mufulirawanderers.com\'';
    if (mysqli_query($conn, $sql1)) {
        if (mysqli_query($conn, $sql2)) {
            header('Location:../index.php#TestDeleted');
        } else {
            header('Location:../index.php#Error!');
        }
    } else {
        header('Location:../index.php#Error');
    }
} else {
    header('Location:../index.php#tNotFound');
}
