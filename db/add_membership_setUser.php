<?php
//select user to be registered for membership
if (!isset($_GET["user"])) {
    setcookie('userTempToken', '', time() - 3600, "/");
    header('Location: ../admin/view_users.php');
} elseif (isset($_GET["user"])) {
    setcookie('userTempToken', $_GET["user"], time() + (3600), "/");
    header('Location: ../admin/add_membership.php');
}
