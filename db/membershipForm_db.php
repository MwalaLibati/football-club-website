<?php
include_once 'validator.php';
include_once 'getRefNumber.php';
include_once 'fileUploadManager.php';

$nrc = stripOff($conn, $_POST["nrc"]);
$nrc = str_replace("/", "", "$nrc");
$output = "";

$contact = stripOff($conn, $_POST["contact"]);
$gender = stripOff($conn, $_POST["gender"]);
$address = stripOff($conn, $_POST["address"]);
$town = stripOff($conn, $_POST["town"]);
$country = stripOff($conn, $_POST["country"]);
$memberType = stripOff($conn, $_POST["memberType"]);
$userId = stripOff($conn, $_POST["userId"]);
$email = $_COOKIE["email"];

//check if user already a member
if (isset($_COOKIE["currentMembershipType"])) {
    $fileRequired = '';
} else {
    $fileRequired = 'required';
}

if (!validate_text($memberType, 'required')) {
    $output = "Please Select Membership";
} elseif (!validate_decimal_or_whole_number($userId, 'required')) {
    $output = "Error. Reload Page And Try Again";
} elseif (!isFileSelected($_FILES, $fileRequired, 'img')) { //types: img, pdf, video, word, excel, ...
    $output = "Please Select Image<br>Max Size: 5MB<br>Format: (.jpg / .png / .jpeg)";
} elseif (!validate_nrc_number($nrc, 'required')) {
    $output = "Please Provide Valid NRC Number<br>Eg: (111111/22/3)";
} elseif (!validate_text($gender, 'required')) {
    $output = "Please Select A Gender";
} elseif (!validate_phone_number($contact, 'required')) {
    $output = "Please Provide Valid 10-Digit<br>Phone number";
} elseif (!validate_text($country, 'required')) {
    $output = "Please Provide Valid Country";
} elseif (!validate_text($town, 'required')) {
    $output = "Please Provide Valid Town";
} elseif (!validate_textarea($address, 'required')) {
    $output = "Please Provide Valid Address";
} else {

    $membNo = getRef('member', $conn);
    $data = mysqli_query($conn, "SELECT memId FROM membership WHERE userId = $userId");
    if (mysqli_num_rows($data) == 0) {
        //insert new member
        $sql = "INSERT INTO membership (
                    membNo,
                    memberType,
                    path,
                    userId
                    ) VALUES (
                        '$membNo',
                        '$memberType',
                        'path',
                         $userId
                        )";
    } elseif (mysqli_num_rows($data) == 1) {
        //update existing member
        $sql = "UPDATE membership SET memberType='$memberType', membNo='$membNo', path = 'path', applyDate = NOW(), active = 0 WHERE userId = $userId";
    } else {
        $output = "OOPS! An error occurred. Please try again or contact support";
    }

    if (mysqli_query($conn, $sql)) {

        // update users details
        $sql = "UPDATE users SET 
                    contact='$contact',
                    gender='$gender',
                    nrc='$nrc',
                    address='$address',
                    town='$town',
                    country='$country' 
                        WHERE email LIKE '$email'";

        if (mysqli_query($conn, $sql)) { // update users details

            $data2 = mysqli_query($conn, "SELECT memId FROM membership WHERE userId = $userId");
            $membershipResult = mysqli_fetch_assoc($data2);
            $memId = $membershipResult["memId"];

            //upload file path to db & move file to new directory
            //add '../' to help navigate to images folder from current db folder
            uploadFiles($_FILES, "images/uploads/profile_pictures", 'profile_pic', $memId, "../", true, $conn);

            //get membership details to be added to cart later
            $data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$memberType'");
            if (mysqli_num_rows($data) == 1) {
                $membershipConfig = mysqli_fetch_assoc($data);
                $MembershipImgPath = getFilePath('membershipType', $membershipConfig["id"], $conn)[0];
                $MembershipPrice = $membershipConfig["price"];
                $membershipCartDetails =  $memberType . ' Membership_____' . $MembershipPrice . '_____' . $MembershipImgPath . '_____' . $memId . '_____1_____1_____' . $MembershipPrice . '_____1_____membership';
            }

            //set cookies
            setcookie('contact', $contact, time() + (86400 * 30), "/");
            setcookie('gender', $gender, time() + (86400 * 30), "/");
            setcookie('nrc', $nrc, time() + (86400 * 30), "/");
            setcookie('address', $address, time() + (86400 * 30), "/");
            setcookie('town', $town, time() + (86400 * 30), "/");
            setcookie('country', $country, time() + (86400 * 30), "/");
            setcookie('currentMembershipType', $memberType, time() + (86400 * 30), "/");
            setcookie('currentMembershipPaidFor', false, time() + (86400 * 30), "/");

            /*************send email*************/
            $heading = $memberType . " Membership Form Received";
            $mainComment = 'Thank you for applying. Go ahead and click the button below to pay the subscription fee';
            if ($onLocalhost) {
                $url = 'http://localhost:8080/myprojects/football-club-website/';
            } elseif (!$onLocalhost) {
                $url = 'https://mufulirawanderers.com/';
            }
            $btnHref = '<a href="' . $url . 'autoAddToCartService.php?payMembershipSubscription"
                        style="background-color:#029141; border:1px solid #029141; border-color:#029141; border-radius:0px; border-width:1px; color:#ffffff; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 40px 12px 40px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;"
                        target="_blank">
                            Make Payment
                        </a>';
            $subComment = 'If you did not submit this membership form, please contact support.';
            include_once '../partials/templates/emailTemplate.php';
            $message = $emailTemplate;
            $to = $email;
            $subject = "Membership Form Submission";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
            if ($onLocalhost) { //for localhost
                file_put_contents("../../emailOffline.html", $message); //offline test email
                $output = $membershipCartDetails;
            } elseif (!$onLocalhost) {
                if (mail($to, $subject, $message, $headers)) {
                    $output = $membershipCartDetails;
                } else {
                    $output = "OOPS! An error occurred. Please try again";
                }
            } else {
                $output = "OOPS! An error occurred... Please try again";
            }
            /*************send email*************/
        } else {
            $output = "OOPS! An error occurred. Please try again";
        }
    } else {
        $output = "OOPS! An error occurred. Please try again";
    }
}

echo $output;
