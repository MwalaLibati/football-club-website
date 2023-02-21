<?php
include_once 'connect.php';
include_once 'getRefNumber.php';

$token = $_POST["token"];
//get user data
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT userId, email FROM users WHERE token LIKE '$token'"));
$userId = $user["userId"];
$email = $user["email"];

//update membership data
$data = mysqli_query($conn, "SELECT * FROM membership WHERE userId = $userId");
if (mysqli_num_rows($data) == 1) {
    $membershipResult = mysqli_fetch_assoc($data);
    $membNo = $membershipResult["membNo"];
    $memberType = $membershipResult["memberType"];
    $memId = $membershipResult["memId"];
    $memberTypeName = $memberType . 'Membership';

    //get memberType price
    $membershipConfigResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$memberType'"));
    $price = $membershipConfigResult["price"];
    $path = $membershipConfigResult["path"];

    //update membership table
    $sql = "UPDATE membership SET active = 1 WHERE userId = $userId";
    if (mysqli_query($conn, $sql)) {

        //keep membership logs table
        $sql = "INSERT INTO membershipLogs (membNo, memberType, userId, memId) VALUES ('$membNo', '$memberType', $userId, $memId)";
        if (mysqli_query($conn, $sql)) {

            //insert new payment
            $cartArray = '["cartArray",{"name":"' . $memberTypeName . '","price":"' . $price . '","path":"' . $path . '","prodId":"' . $memId . '","quantity":"1","myQuantity":"1","originalPrice":"' . $price . '","active":"1","itemType":"membership"}]';
            $txref = getRef('pay', $conn);
            $sql = "INSERT INTO payments (
                userId,
                ref,
                cartArray,
                amountPaid,
                status
                ) VALUES (
                    $userId,
                    '$txref',
                    '$cartArray',
                     $price,
                     1
                    )";
            if (mysqli_query($conn, $sql)) {
                $payId = mysqli_insert_id($conn);

                //insert item paid for
                $sql = "INSERT INTO paidForItems (name,itemType,myQuantity,priceByQuantity,originalPrice,itemId,payId,userId) 
                            VALUES ('$memberTypeName','membership',1,$price,$price,$memId,$payId,$userId)";
                if (mysqli_query($conn, $sql)) {
                    setcookie('currentMembershipPaidFor', true, time() + (86400 * 30), "/");

                    /*************send email*************/
                    $heading = $memberType . " Membership Completed<br>Successfully";
                    $mainComment = 'We are very happy to have you on board.';
                    $mainComment .= '<br><br><b>Membership Reference No:</b> ' . $membNo;
                    $btnHref = '';
                    $subComment = '';
                    include_once '../partials/templates/emailTemplate.php';
                    $message = $emailTemplate;
                    $to = $email;
                    $subject = $memberType . " Application Completed Successfully";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
                    if ($onLocalhost) { //for localhost
                        file_put_contents("../../emailOffline.html", $message); //offline test email
                        echo 'success';
                    } elseif (!$onLocalhost) {
                        if (mail($to, $subject, $message, $headers)) {
                            echo 'success';
                        } else {
                            echo "OOPS! An error occurred. Please try again";
                        }
                    } else {
                        echo "OOPS! An error occurred... Please try again";
                    }
                } else {
                    echo 'fail.';
                }
            } else {
                echo 'fail..';
            }
        } else {
            echo 'fail...';
        }
    } else {
        echo 'fail!';
    }
} else {
    echo 'fail!!';
}
