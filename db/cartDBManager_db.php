<?php
include_once 'connect.php';
include_once 'fileUploadManager.php';

//data from cart item (assessed one @ a time)
$cartData = $_POST['cartData'];
// $cartData['name'] = name of item
// $cartData['price'] = total price (quantity*pricePerItem)
// $cartData['path'] = //path to item's image in directory
// $cartData['prodId'] = product ID in db table
// $cartData['quantity'] = original quantity set by admin
// $cartData['myQuantity'] = user set quantity (always less than or equal to Original quantity)
// $cartData['originalPrice'] = price per each item set by admin
// $cartData['active'] = if(active==1){add to cart} else if(active==1){do not add to cart or remove from cart if already exists in cart}
// $cartData['itemType'] = items added to cart can be [product][membership][tickets][ect...]
// var_dump($cartData);

//place cart details in response array
$response = array(
    'actionOther' => '', //any other action other than remove
    'actionRemove' => '', //only listen for the remove action
    'msg' => '',
    'result' => '',
    'name' => '',
    'price' => '',
    'path' => '',
    'prodId' => $cartData['prodId'],
    'quantity' => '',
    'myQuantity' => '',
    'originalPrice' => '',
    'active' => '',
    'itemType' => $cartData['itemType']
);

if ($cartData['itemType'] == 'product') { //if item is product
    $data = mysqli_query($conn, "SELECT * FROM products WHERE prodId = " . $cartData['prodId'] . " AND active = 1");
    $productsResult = mysqli_fetch_assoc($data);
    if (mysqli_num_rows($data) == 1) { //if item exists & is active 
        if ($cartData['myQuantity'] > $productsResult['quantity']) { //if user's quantity is greater than product's quantity in stock
            if ($productsResult['quantity'] <= 0) { //if product's quantity is 0 or less
                $response['actionRemove'] = 'remove';
                $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart because it is no longer in stock';
            } elseif ($productsResult['quantity'] > 0) { //if quantity is less than what the user needs
                $response['actionOther'] = 'quantity';
                $cartData['myQuantity'] = 1;
                $cartData['price'] = $cartData['originalPrice'] = $productsResult['price'];
                $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] quantity is less than what you require';
            } else { //if... well... I don't know
                $response['actionRemove'] = 'remove';
                $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart for no apparent reason';
            }
        } elseif ($cartData['quantity'] != $productsResult['quantity']) {
            $response['actionOther'] = 'quantity';
            $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] quantity changed';
        }
        if ($cartData['originalPrice'] != $productsResult['price']) { //if price changed
            $response['actionOther'] = 'price';
            $cartData['myQuantity'] = 1;
            $cartData['price'] = $cartData['originalPrice'] = $productsResult['price'];
            $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] price changed';
        }
        if ($cartData['name'] != $productsResult['name']) { //if price changed
            $response['actionOther'] = 'name';
            $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] name changed';
        }

        //update ALL item details @ the end!
        $response['name'] = $productsResult['name']; //item name
        $response['price'] = $cartData['price']; //total price (quantity*pricePerItem)
        $response['path'] = getFilePath('product', $productsResult['prodId'], $conn)[0];
        $response['quantity'] = $productsResult['quantity']; //admin-set quantity
        $response['myQuantity'] = $cartData['myQuantity']; //user-set quantity
        $response['originalPrice'] = $cartData['originalPrice']; //price per each item set by admin
        $response['active'] = $productsResult['active'];

        //prep data to add to cart
        $response['result'] = $response['name'] . "_____" . $response['price'] . "_____" . $response['path'] . "_____" . $response['prodId'] . "_____" . $response['quantity'] . "_____" . $response['myQuantity'] . "_____" . $response['originalPrice'] . "_____" . $response['active'] . "_____" . $response['itemType'];
    } else {
        $response['actionRemove'] = 'remove'; //if product don't exist no more
        $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart.';
    } //end else
}
if ($cartData['itemType'] == 'membership_00000') { //if item is membership
    $memberType = explode(' ', $cartData['name'])[0];
    $data = mysqli_query($conn, "SELECT memberType, active FROM membership WHERE memberType LIKE '$memberType' AND userId = " . $_COOKIE["userId"]);
    $membershipResult = mysqli_fetch_assoc($data);
    if (mysqli_num_rows($data) == 0) { //not applied
        $response['actionRemove'] = 'remove';
        $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart.';
    } elseif (mysqli_num_rows($data) == 1) { //applied 
        if ($membershipResult["active"] == 1) { //already paid for
            $response['actionRemove'] = 'remove';
            $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart..';
        } elseif ($membershipResult["active"] == 0) { //not paid for [further testing below]
            $data1 = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE active = 1 AND memberType LIKE '$memberType'");
            $membershipConfigResult = mysqli_fetch_assoc($data1);
            if (mysqli_num_rows($data1) == 0) { //memberType currently unavailable
                $response['actionRemove'] = 'remove';
                $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart...';
            } elseif (mysqli_num_rows($data1) == 1) { //memberType is available
                if ($cartData['originalPrice'] != $membershipConfigResult["price"]) { //price changed
                    $response['actionOther'] = 'price';
                    $cartData['price'] = $cartData['originalPrice'] = $membershipConfigResult['price'];
                }
                if ($cartData['quantity'] != 1 || $cartData['myQuantity'] != 1) { //quantity must always equal 1
                    $cartData['quantity'] = $cartData['myQuantity'] = 1;
                }
            } else {
                $response['actionRemove'] = 'remove';
                $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart!';
            }

            //update ALL item details @ the end!
            $response['name'] = $membershipConfigResult['memberType']; //item name
            $response['price'] = $cartData['price']; //total price (quantity*pricePerItem)
            $response['originalPrice'] = $cartData['originalPrice']; //price per each item set by admin
            $response['path'] = $membershipConfigResult['path'];
            $response['quantity'] = $cartData['quantity']; //admin-set quantity
            $response['myQuantity'] = $cartData['myQuantity']; //user-set quantity
            $response['active'] = $cartData['active'];

            //prep data to add to cart
            $response['result'] = $response['name'] . "_____" . $response['price'] . "_____" . $response['path'] . "_____" . $response['prodId'] . "_____" . $response['quantity'] . "_____" . $response['myQuantity'] . "_____" . $response['originalPrice'] . "_____" . $response['active'] . "_____" . $response['itemType'];
        } else {
            $response['actionRemove'] = 'remove';
            $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart!!';
        }
    } else {
        $response['actionRemove'] = 'remove';
        $response['msg'] = $cartData['itemType'] . ' [' . $cartData['name'] . '] removed from cart!!!';
    }
} elseif ($cartData['itemType'] == 'ticket') {
    $response['msg'] = "Coming soon...";
}

echo json_encode($response);
