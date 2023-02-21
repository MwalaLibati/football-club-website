<?php
include_once 'validator.php';

if (!validate_text($_POST["categoryName"], 'required')) {
    die("Please Provide Valid Category");
} else {

    $category = stripOff($conn, $_POST["categoryName"]);

    $data = mysqli_query($conn, "SELECT * FROM productCategoryConfig WHERE categoryName LIKE '$category'");

    if (mysqli_num_rows($data) == 0) {

        $sql = "INSERT INTO productCategoryConfig (
            categoryName
            ) VALUES (
                '$category'
                )";

        if (mysqli_query($conn, $sql)) {
            echo 'success';
        } else {
            echo 'Failed To Create Category. Try Again';
        }
    } elseif (mysqli_num_rows($data) == 1) {
        echo 'Category Already Exists';
    } else {
        echo 'Failed To Create Category. Try Again';
    }
}
