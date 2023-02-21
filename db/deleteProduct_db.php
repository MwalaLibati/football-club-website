<?php
include_once 'connect.php';

if (isset($_POST["prodId"])) {

    $prodId = $_POST["prodId"];

    $sql = 'DELETE FROM products WHERE prodId = ' . $prodId;
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'fail';
}
