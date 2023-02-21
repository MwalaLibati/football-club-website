<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once 'validator.php';
    include_once 'fileUploadManager.php';

    $memberType = stripOff($conn, $_POST["memberType"]);
    $memberTypeOld = stripOff($conn, $_POST["memberTypeOld"]);
    $price = stripOff($conn, $_POST["price"]);
    $monthDuration = stripOff($conn, $_POST["monthDuration"]);
    $id = stripOff($conn, $_POST["id"]);

    if (!validate_text($memberType, 'required') || !validate_text($memberTypeOld, 'required')) {
        $output = "msg=Please Provide Valid Membership Name&type=error";
    } elseif (!validate_money($price, 'required')) {
        $output = "msg=Please Provide Valid Subscription Fee&type=error";
    } elseif ($monthDuration != '0' && !validate_decimal_or_whole_number($monthDuration, 'required')) {
        $output = "msg=Please Select Duration&type=error";
    } elseif (!isFileSelected($_FILES, '', 'img')) { //types: img, pdf, video, word, excel, ...
        $output = "msg=Please Select Image<br>Max Size: 5MB<br>Format: (.jpg / .png / .jpeg)&type=error";
    } elseif (!validate_decimal_or_whole_number($id, 'required')) {
        $output = "msg=System Error&type=error";
    } else {

        $data = mysqli_query($conn, "SELECT id FROM membershipConfig WHERE id = $id AND memberType LIKE '$memberTypeOld'");
        if (mysqli_num_rows($data) == 1) {
            $membershipConfigResult = mysqli_fetch_assoc($data);
            $sql = "UPDATE membershipConfig SET memberType = '$memberType', price = '$price', monthDuration = '$monthDuration' WHERE id = $id AND memberType LIKE '$memberTypeOld'";
            $sql2 = "UPDATE membership SET memberType = '$memberType' WHERE memberType LIKE '$memberTypeOld'";
            if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
                uploadFiles($_FILES, "images/uploads/membership_type_images", 'membershipType', $membershipConfigResult["id"], "../", true, $conn);
                $output = "msg=Membership Edited Successfully&type=success";
                $memberType = $price = $monthDuration = '';
            } else {
                $output = "msg=Failed to create membership type. Please Try Again&type=error";
            }
        } else {
            //does not exist
            $output = "msg=Membership type does not exist&type=error";
        }
    }
    header('Location: ../admin/add_membership_type.php?' . $output);
}
