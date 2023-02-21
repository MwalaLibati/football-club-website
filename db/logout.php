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
setcookie('currentMembershipType', '', time() - 3600, "/");
setcookie('userTempToken', '', time() - 3600, "/");

if (isset($_GET["accountDeleted"])) {
    header('Location:../index.php?msg=Account Deleted Successfully&type=success');
} else {
    header('Location:../index.php');
}
