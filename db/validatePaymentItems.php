<?php

include_once 'connect.php';
include_once 'getRefNumber.php';

//validate email
function validatePaymentItems($array, $email, $totalAmount, $userId, $conn)
{
    $total = 0;

    for ($i = 1; $i < json_encode(count($array)); $i++) {
        $name = $array[$i]->name;
        $price = (float)$array[$i]->price;
        $prodId = (int)$array[$i]->prodId;
        $quantity = (int)$array[$i]->quantity;
        $myQuantity = (int)$array[$i]->myQuantity;
        $originalPrice = (float)$array[$i]->originalPrice;
        $active = $array[$i]->active;
        $itemType = $array[$i]->itemType;

        // verify with db data
        /* product */
        if ($itemType == 'product') {
            $data = mysqli_query($conn, "SELECT * FROM products WHERE prodId = $prodId and active = 1");
            $productsResult = mysqli_fetch_assoc($data);
            if (mysqli_num_rows($data) == 0) {
                return 'OOPS:<br>' . $name . ' is currently unavailable';
                break;
            }
            if ($myQuantity > $productsResult["quantity"]) {
                if ($productsResult["quantity"] == 0) {
                    return 'OOPS:<br>' . $name . ' is no longer in stock<br>Please remove it from your cart';
                }
                return 'OOPS:<br>' . $name . ' now only has ' . $productsResult["quantity"] . ' item(s) currently in stock<br>Please change its quantity';
                break;
            }
            if ($originalPrice != $productsResult["price"]) {
                return 'OOPS:<br>' . $name . ' now costs K ' . $productsResult["price"] . '. <br>Kindly remove it from your cart and add it again';
                break;
            }

            /* membership */
        } elseif ($itemType == 'membership') {
            $membershipName = explode(' ', $name)[0];
            $data = mysqli_query($conn, "SELECT memberType FROM membership WHERE userId = $userId");
            $membershipResult = mysqli_fetch_assoc($data);
            if (mysqli_num_rows($data) == 0) {
                return 'OOPS:<br>Seems you have not applied for<br>' . $membershipName . ' membership.';
                break;
            } elseif (mysqli_num_rows($data) == 1) {
                $memberType = $membershipResult["memberType"];
                $data = mysqli_query($conn, "SELECT memberType FROM membership WHERE userId = $userId AND memberType LIKE '$memberType'");
                if (mysqli_num_rows($data) != 1) {
                    return 'OOPS:<br>Seems you have not applied for<br>' . $membershipName . ' membership.';
                    break;
                }
            } else {
                return 'Error occurred while processing<br>membership payment';
                break;
            }
            $data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType = '$membershipName'");
            $membershipConfigResult = mysqli_fetch_assoc($data);
            if (mysqli_num_rows($data) == 0) {
                return $name . ' is currently unavailable';
                break;
            }
            if ($originalPrice != $membershipConfigResult["price"]) {
                return $name . ' now costs K ' . $membershipConfigResult["price"] . '. <br>Kindly remove it from your cart and add it again';
                break;
            }
            if ($quantity != 1) {
                return 'You can only pay for one(1) ' . $name . ' at a time';
                break;
            }
        }

        //get total price
        $total += $price;
    } //end for()

    if ($total == 0 || !isset($total) || empty($total)) {
        return 'Payment Processing Error. Try Again.';
    } else if ($totalAmount != $total) {
        return 'Payment Processing Error. Try Again.';
    } else if ($totalAmount == $total) {
        $verifiedTotalAmount = $total;
    } else {
        return 'Payment Processing Error. Try Again.';
    }

    $data = mysqli_query($conn, "SELECT userId FROM users WHERE email LIKE '$email' and active = 1");
    if (mysqli_num_rows($data) == 0) {
        return 'Processing Error. Please contact support';
    }

    //get ref
    $txref = getRef('pay', $conn);

    return $email . '_____' . $txref . '_____' . $verifiedTotalAmount;
} //end validatePaymentItems()



function updateItemsInDB($array, $payId, $userId, $email, $conn)
{
    $bad = 0;

    for ($i = 1; $i < json_encode(count($array)); $i++) {
        $name = $array[$i]->name;
        $price = (float)$array[$i]->price;
        $prodId = (int)$array[$i]->prodId;
        $quantity = (int)$array[$i]->quantity; //original admin defined quantity
        $myQuantity = (int)$array[$i]->myQuantity; //user defined quantity
        $originalPrice = (int)$array[$i]->originalPrice;
        $active = $array[$i]->active;
        $itemType = $array[$i]->itemType;
        $path = $array[$i]->path;

        /* update if itemType =  membership-------------------------------------------------------------------------------------------------------------------------*/
        if ($itemType == 'membership') {
            $data = mysqli_query($conn, "SELECT * FROM membership WHERE userId = $userId");
            if (mysqli_num_rows($data) == 1) {
                $membershipResult = mysqli_fetch_assoc($data);
                $membNo = $membershipResult["membNo"];
                $memberType = $membershipResult["memberType"];
                $memId = $membershipResult["memId"];
                $sql = "UPDATE membership SET active = 1 WHERE userId = $userId";
                if (mysqli_query($conn, $sql)) {
                    $sql = "INSERT INTO membershipLogs (membNo, memberType, userId, memId) VALUES ('$membNo', '$memberType', $userId, $memId)";
                    if (mysqli_query($conn, $sql)) {

                        $sql = "INSERT INTO paidForItems (name,itemType,myQuantity,priceByQuantity,originalPrice,itemId,payId,userId) 
                                VALUES ('$name','$itemType',$myQuantity,$price,$originalPrice,$prodId,$payId,$userId)";
                        if (mysqli_query($conn, $sql)) {


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
                            file_put_contents("../../emailOffline.html", $message); //offline test email
                            setcookie('currentMembershipPaidFor', true, time() + (86400 * 30), "/");
                            // if (mail($to, $subject, $message, $headers)) { //for production
                            if (true) {
                                //good
                                setcookie('currentMembershipPaidFor', true, time() + (86400 * 30), "/");
                            } else {
                                $bad++;
                            }
                        } else {
                            $bad++;
                        }
                    } else {
                        $bad++;
                    }
                } else {
                    $bad++;
                }
            } else {
                $bad++;
            }
            /* update if itemType =  product-------------------------------------------------------------------------------------------------------------------------*/
        } elseif ($itemType == 'product') {
            $data = mysqli_query($conn, "SELECT * FROM products WHERE prodId = $prodId");
            if (mysqli_num_rows($data) == 1) {
                $productsResult = mysqli_fetch_assoc($data);
                $oldQuantity = $productsResult["quantity"]; //quantity in db right now
                $newQuantity = $oldQuantity - $myQuantity;
                $sql = "UPDATE products SET quantity = $newQuantity WHERE prodId = $prodId"; //update new quantity
                if (mysqli_query($conn, $sql)) {
                    //insert record into paidForItems table
                    $sql = "INSERT INTO paidForItems (name,itemType,myQuantity,priceByQuantity,originalPrice,itemId,payId,userId) 
                                VALUES ('$name','$itemType',$myQuantity,$price,$originalPrice,$prodId,$payId,$userId)";
                    if (mysqli_query($conn, $sql)) {
                        if ($newQuantity == 0) { //if nothing is left standing
                            $sql = "UPDATE products SET active = 0 WHERE prodId = $prodId"; //deactivate product
                            if (mysqli_query($conn, $sql)) {
                                //good
                            } else {
                                $bad++;
                            }
                        } else {
                            // $bad++;
                        }
                    } else {
                        $bad++;
                    }
                } else {
                    $bad++;
                }
            } else {
                $bad++;
            }

            /* update if itemType =  product-------------------------------------------------------------------------------------------------------------------------*/
        } elseif ($itemType == 'ticket') {
        }
    } //end for()

    return $bad;
}//end updateItemsInDB()
