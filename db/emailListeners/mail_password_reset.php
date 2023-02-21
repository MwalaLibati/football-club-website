<?php
include_once '../validator.php';

if (!validate_email($_GET["email"], 'required') || !validate_text($_GET["token"], 'required')) {
	header("Location: ../../index.php?msg=Invalid URL&type=error");
} else {

	$email = stripOff($conn, $_GET["email"]);
	$token = stripOff($conn, $_GET["token"]);

	$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND token='$token' AND active = 1");

	if (mysqli_num_rows($result) == 1) {
		setcookie('displayUI', 'newPassword', time() + (3600), "/");
		if (!isset($_COOKIE["email"])) {
			setcookie('email', $email, time() + (3600), "/");
		}
		header("Location: ../../newPassword.php");
	} else {
		header("Location: ../../index.php?msg=Password Reset Failed. Please Contact Support&type=error");
	}
}
