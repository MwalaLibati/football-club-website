<?php
include_once 'connect.php';

if (
    isset($_GET["email"]) &&
    isset($_COOKIE["userId"]) &&
    $_GET["email"] == $_COOKIE["email"]
) {

    $email = $_GET["email"];

    $data = mysqli_query($conn, "SELECT userId FROM users WHERE email LIKE '$email' AND active = 1");
    if (mysqli_num_rows($data) == 1) {
        $user = mysqli_fetch_assoc($data);
        if ($user["userId"] == $_COOKIE["userId"]) {
            $userId = $user["userId"];

            $sql1 = "DELETE FROM membership WHERE userId = " . $userId;
            $sql2 = "UPDATE users SET active = '0', superActive = '0' WHERE email = '$email'";
            if (mysqli_query($conn, $sql1)) {
                if (mysqli_query($conn, $sql2)) {
                    header('Location:logout.php?accountDeleted');
                } else {
                    header('Location:../index.php?msg=Failed To Delete Account.&type=error');
                }
            } else {
                header('Location:../index.php?msg=Failed To Delete Account..&type=error');
            }
        } else {
            header('Location:../index.php?msg=Failed To Delete Account...&type=error');
        }
    } else {
        header('Location:../index.php?msg=Failed To Delete Account....&type=error');
    }
} else {
    header('Location:../index.php?msg=Failed To Delete Account.....&type=error');
}
