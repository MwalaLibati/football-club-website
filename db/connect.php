<?php
if (!isset($_SESSION)) {
	session_start();
}
$error_msg = 'Sorry could not connect to server...';
$onLocalhost = true;

//AUTO CHECK IF ON LIVE OR LOCALHOST
$testingPath = '';
for ($i = 1; $i <= 20; $i++) {
	if (file_exists($testingPath . 'testing.txt')) {
		$onLocalhost = true;
		break;
	} else {
		$testingPath .= '../';
	}
} //end for()
if ($onLocalhost) {
	//localhost
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$db = 'mufulir1_mwfc_db';
}
//} else {
//	//production
//	$servername = 'localhost';
//	$username = 'mufulir1_admin';
//	$password = 'YpAMBxCDQL~m';
//	$db = 'mufulir1_mwfc_db';
//}

// CREATE CONNECTION
$conn = mysqli_connect($servername, $username, $password);
// CHECK CONNECTION
if (!$conn) {
	die($error_msg);
}
// CREATE THE DATABASE
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if (mysqli_query($conn, $sql)) {
	$conn = mysqli_connect($servername, $username, $password, $db);
} else {
	die($error_msg);
}
