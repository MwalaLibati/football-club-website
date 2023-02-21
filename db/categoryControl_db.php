<?php
include_once 'connect.php';

$type = $_POST["type"];
$id = $_POST["id"];

if ($type === 'disable') {
    $sql = "UPDATE productCategoryConfig SET active = 0 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'enable') {
    $sql = "UPDATE productCategoryConfig SET active = 1 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'empty') {
    //get category name to delete
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT categoryName FROM productCategoryConfig WHERE id = $id"));
    $categoryName = $user["categoryName"];
    $sql = 'DELETE FROM products WHERE category LIKE \'' . $categoryName . '\'';
    if (mysqli_query($conn, $sql)) {
        // if (1 === 1) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'delete') {

    //get category name to delete
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT categoryName FROM productCategoryConfig WHERE id = $id"));
    $categoryName = $user["categoryName"];
    $sql = 'DELETE FROM products WHERE category LIKE \'' . $categoryName . '\'';
    $sql1 = 'DELETE FROM productCategoryConfig WHERE id = ' . $id;
    if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql1)) {
        // if (1 === 1) {
        echo 'success';
    } else {
        echo 'fail';
    }
} elseif ($type === 'categoryNameEditField') {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT categoryName FROM productCategoryConfig WHERE id = $id"));
    $categoryName = $user["categoryName"];
    $newCategoryName = $_POST["newCategoryName"];

    $sql1 = "UPDATE productCategoryConfig SET categoryName = '$newCategoryName' WHERE id = $id";
    $sql2 = "UPDATE products SET category = '$newCategoryName' WHERE category = '$categoryName'";
    if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'fail';
}
