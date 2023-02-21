<?php
include_once 'validator.php';
include_once 'getRefNumber.php';
include_once 'fileUploadManager.php';

$category = stripOff($conn, $_POST["category"]);
$name = stripOff($conn, $_POST["name"]);
$quantity = stripOff($conn, $_POST["quantity"]);
$description = stripOff($conn, $_POST["description"]);
if (isset($_POST["available"])) {
    $available = stripOff($conn, $_POST["available"]);
}
$price = stripOff($conn, $_POST["price"]);
$oldPrice = stripOff($conn, $_POST["oldPrice"]);

$validCategory = false;
$data = mysqli_query($conn, "SELECT id FROM productCategoryConfig WHERE categoryName LIKE '$category' AND active = 1");
if (mysqli_num_rows($data) == 1) {
    $validCategory = true;
}

if (!validate_text($category, 'required') || !$validCategory) {
    $output = "Please Provide Valid Category";
} elseif (!validate_text($name, 'required')) {
    $output = "Please Provide Valid Product Name";
} elseif (!isFileSelected($_FILES, 'required', 'img')) { //types: img, pdf, video, word, excel, ...
    $output = "Please Select Image<br>Max Size: 5MB<br>Format: (.jpg / .png / .jpeg)";
} elseif (!validate_decimal_or_whole_number($quantity, 'required')) {
    $output = "Please Provide Valid Quantity";
} elseif (!validate_text($description, '')) {
    $output = "Please Provide Valid Description";
} elseif (!validate_text($available, '')) {
    $output = "Please Provide Valid Availability Value";
} elseif (!validate_money($price, 'required')) {
    $output = "Please Provide Valid Price";
} elseif (!validate_money($oldPrice, '')) {
    $output = "Please Provide Valid Old Price";
} else {

    $ref = getRef('product', $conn);

    if ($available == 'available') {
        $active = 1;
    } else {
        $active = 0;
    }

    $sql = "INSERT INTO products (
                        name,
                        quantity,
                        category,
                        description,
                        price,
                        oldPrice,
                        ref,
                        path,
                        active
                        ) VALUES (
                            '$name',
                            '$quantity',
                            '$category',
                            '$description',
                            '$price',
                            '$oldPrice',
                            '$ref',
                            'path',
                            '$active'
                            )";

    $sql2 = 'SELECT * FROM products WHERE name LIKE \'' . $name . '\' AND  description LIKE \'' . $description . '\' AND category LIKE \'' . $category . '\' AND price = ' . $price . '';
    $data2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($data2) == 0) {
        if (mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);
            //upload file path to db & move file to new directory
            //add '../' to help navigate to images folder from current db folder
            if (uploadFiles($_FILES, "images/uploads/products", 'product', $last_id, "../", true, $conn)) {
                $output = "success";
            } else {
                $output = "Product Uploaded Successfully<br>However, Product Images Failed To Upload";
            }
        } else {
            $output = "Product Upload Failed. Please Try Again";
        }
    } else {
        //duplicate post
        $output = "Product already exists";
    }
}

echo $output;
