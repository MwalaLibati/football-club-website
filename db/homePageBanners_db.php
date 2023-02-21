<?php
include_once 'connect.php';
include_once 'validator.php';
include_once 'fileUploadManager.php';

if (isset($_POST["bannerId"]) && isset($_POST["type"])) {
    $bannerId = $_POST["bannerId"];

    if ($_POST["type"] == 'delete') {
        $data = mysqli_query($conn, "SELECT bannerId FROM banners WHERE bannerId = $bannerId");
        if (mysqli_num_rows($data) == 1) {
            if (deleteFile("sourceId", $bannerId, $conn)) {
                if (mysqli_query($conn, "DELETE FROM banners WHERE bannerId = $bannerId")) {
                    // if (true) {
                    // if (true) {
                    $output = 'success';
                } else {
                    $output = 'Failed to delete banner. Try again';
                }
            } else {
                $output = 'Failed to delete banner. Try again';
            }
        } else {
            $output = 'Failed to delete banner. Try again';
        }
        //-//
    } elseif ($_POST["type"] == 'upload' || $_POST["type"] == 'edit') {

        $type = stripOff($conn, $_POST["type"]);
        $bannerId = stripOff($conn, $_POST["bannerId"]);
        $priority = stripOff($conn, $_POST["priority"]);
        $description1 = stripOff($conn, $_POST["description1"]);
        $description2 = stripOff($conn, $_POST["description2"]);

        $required = '';
        if ($type == "upload") {
            $required = 'required';
        }

        if (!isFileSelected($_FILES, $required, 'img')) { //types: img, pdf, video, word, excel, ...
            $output = "Please Select Image<br>Max Size: 5MB<br>Format: (.jpg / .png / .jpeg)";
        } elseif (!validate_decimal_or_whole_number($priority, $required)) {
            $output = "Please Provide Valid Priority";
        } elseif (!validate_textarea($description1, "")) {
            $output = "Please Provide Valid Content in Header";
        } elseif (!validate_textarea($description2, "")) {
            $output = "Please Provide Valid Content in Header";
        } else {
            if (empty($description1)) {
                $description1 = "";
            }
            if (empty($description2)) {
                $description2 = "";
            }
            if ($type == "upload") {
                $sql = "INSERT INTO banners (priority, bannertype, description1, description2) VALUES ($priority, 'homePageBanner', '$description1', '$description2')";
            } elseif ($type == "edit") {
                $sql = "UPDATE banners SET priority = $priority, description1 = '$description1', description2 = '$description2' WHERE bannerId = $bannerId";
            }

            if (mysqli_query($conn, $sql)) {
                $last_id = mysqli_insert_id($conn);
                if ($type == "upload") {
                    if (uploadFiles($_FILES, "images/uploads/homepage_banners", 'homePageBanner', $last_id, "../", true, $conn)) {
                        $output = 'success';
                    } else {
                        $output = 'Upload Successful, but image upload failed..';
                    }
                } elseif ($type == "edit") {
                    uploadFiles($_FILES, "images/uploads/homepage_banners", 'homePageBanner', $bannerId, "../", true, $conn);
                    $output = 'success';
                } else {
                    $output = 'Upload failed. Try again';
                }
            } else {
                $output = 'Upload failed... Try again';
            }
        } //end validate else{}
    } else {
        $output = 'Error occurred. Reload page & try again';
    }
} else {
    $output = 'Error occurred. Reload page & try again';
}
echo $output;
