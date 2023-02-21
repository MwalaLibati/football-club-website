<?php
include_once 'connect.php';
include_once 'fileUploadManager.php';

$type = $_POST["type"];
$id = $_POST["id"];

if ($type === 'deactivate') { //deactivate membership
    $sql = "UPDATE membershipConfig SET active = 0 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'activate') { //activate membership
    $sql = "UPDATE membershipConfig SET active = 1 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'delete') { //delete membership
    if (deleteFile("sourceId", $id, $conn)) {
        $sql = 'DELETE FROM membershipConfig WHERE id = ' . $id;
        if (mysqli_query($conn, $sql)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    } else {
        echo 'fail.';
    }
} else {
    echo 'fail';
}
