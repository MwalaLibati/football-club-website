<?php

/* Mark product as available/unavailable by admin*/

include_once 'connect.php';

$data = $_POST["data"];
$prodId = $_POST["prodId"];

if ($data === 'markOut') {
    $active = 0;
} elseif ($data === 'markIn') {
    $active = 1;
} else {
    $active = '';
}

$sql = "UPDATE products SET active = $active WHERE prodId = $prodId";

$data1 = mysqli_query($conn, "SELECT quantity FROM products WHERE prodId = $prodId");
if (mysqli_num_rows($data1) == 1) {
    $result = mysqli_fetch_assoc($data1);
    if ($result["quantity"] > 0 && $active == 1) {
        if (mysqli_query($conn, $sql) && $active !== '') {
            echo 'success';
        } else {
            echo 'fail';
        }
    } elseif ($active == 0) {
        if (mysqli_query($conn, $sql) && $active !== '') {
            echo 'success';
        } else {
            echo 'fail';
        }
    } elseif ($result["quantity"] <= 0 && $active == 1) {
        echo 'quantityFail';
    } else {
        echo 'fail';
    }
} else {
    echo 'fail';
}
