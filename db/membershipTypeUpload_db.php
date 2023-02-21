<?php

$memberType = $price = $monthDuration = '';
if (isset($_GET["memberType"])) {
    $memberType = $_GET["memberType"];
}
if (isset($_GET["price"])) {
    $price = $_GET["price"];
}
if (isset($_GET["price"])) {
    $monthDuration = $_GET["monthDuration"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once 'validator.php';
    include_once 'fileUploadManager.php';


    $memberType = stripOff($conn, $_POST["memberType"]);
    $price = stripOff($conn, $_POST["price"]);
    $monthDuration = stripOff($conn, $_POST["monthDuration"]);

    if (!validate_text($memberType, 'required')) {
        $output = "msg=Please Provide Valid Membership Name&type=error";
    } elseif (!validate_money($price, 'required')) {
        $output = "msg=Please Provide Valid Subscription Fee&type=error";
    } elseif ($monthDuration != '0' && !validate_decimal_or_whole_number($monthDuration, 'required')) {
        $output = "msg=Please Select Duration&type=error";
    } elseif (!isFileSelected($_FILES, 'required', 'img')) { //types: img, pdf, video, word, excel, ...
        $output = "msg=Please Select Image<br>Max Size: 5MB<br>Format: (.jpg / .png / .jpeg)&type=error";
    } else {

        $sql = "INSERT INTO `membershipConfig` (`memberType`, `price`, `path`, `monthDuration`) VALUES ('$memberType', $price, 'path', $monthDuration);";
        $sql2 = "SELECT id FROM membershipConfig WHERE memberType LIKE '$memberType'";
        $data2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($data2) == 0) {
            if (mysqli_query($conn, $sql)) {
                $last_id = mysqli_insert_id($conn);
                if (uploadFiles($_FILES, "images/uploads/membership_type_images", 'membershipType', $last_id, "../", true, $conn)) {
                    $output = "msg=Membership type created successfully&type=success";
                } else {
                    $output = "msg=Membership type created successfully<br>However, image failed to upload&type=success";
                }
                $memberType = $price = $monthDuration = '';
            } else {
                $output = "msg=Failed to create membership type. Please Try Again&type=error";
            }
        } else {
            //duplicate post
            $output = "msg=Membership type already exists&type=error";
        }
    }
    header('Location: add_membership_type.php?' . $output . '&memberType=' . $memberType . '&price=' . $price . '&monthDuration=' . $monthDuration);
}
