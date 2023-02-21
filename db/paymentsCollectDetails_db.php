<?php

include_once 'validatePaymentItems.php';

if (isset($_POST["cartArrayInputField"]) && isset($_POST["email"]) && isset($_POST["totalAmount"]) && isset($_COOKIE["userId"])) {

    $total = $txref = $email = '';

    //validate our cart array
    $myData = validatePaymentItems(json_decode($_POST["cartArrayInputField"]), $_POST['email'], $_POST['totalAmount'], $_COOKIE["userId"], $conn);

    if (strpos($myData, '_____')) {

        //get validated result
        $result = explode('_____', $myData);

        $cartArray = $_POST["cartArrayInputField"];
        $userId = $_COOKIE["userId"];
        $customer_email = $result[0];
        $txref = $result[1];
        $amount = $result[2];
        $currency = "ZMW";

        $curl = curl_init();
        $PBFPubKey = "FLWPUBK_TEST-2a552495007b791d650bf838177fb9be-X"; // get your public key from the dashboard.
        if ($onLocalhost) {
            $redirect_url = "http://localhost:8080/myprojects/football-club-website/db/processPayment_db.php";
        } elseif (!$onLocalhost) {
            $redirect_url = "https://www.mufulirawanderers.com/db/processPayment_db.php";
        } else {
            header('Location: ../makePayment.php?msg=Failing to connect to API. Try again.&type=error');
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'customer_email' => $customer_email,
                'currency' => $currency,
                'txref' => $txref,
                'PBFPubKey' => $PBFPubKey,
                'redirect_url' => $redirect_url
            ]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the rave API
            // die('Curl returned error: ' . $err);
            header('Location: ../makePayment.php?msg=Failing to connect to API. Try again.&type=error');
        }

        $transaction = json_decode($response);

        if (!isset($transaction)) {
            header('Location: ../makePayment.php?msg=Failing to connect to API. Try again.&type=error');
        }
        if (!$transaction->data && !$transaction->data->link) {
            // there was an error from the API
            // print_r('API returned error: ' . $transaction->message);
            header('Location: ../makePayment.php?msg=Failing to connect to API. Try again.&type=error');
        }

        //save in database-------------------------------------------------------------
        $data = mysqli_query($conn, "SELECT * FROM payments WHERE userId = $userId AND status = 0 AND cartArray LIKE '$cartArray'");
        if (mysqli_num_rows($data) == 0) {
            //insert in payments table
            $sql = "INSERT INTO payments (
                userId,
                ref,
                cartArray,
                amountPaid
                ) VALUES (
                    $userId,
                    '$txref',
                    '$cartArray',
                     $amount
                    )";
        } elseif (mysqli_num_rows($data) == 1) {
            // update payments table
            $sql = "UPDATE payments SET ref = '$txref' WHERE userId = $userId AND status = 0 AND cartArray LIKE '$cartArray' AND amountPaid = $amount";
        } else if (mysqli_num_rows($data) > 1) {
            if (mysqli_query($conn, "DELETE FROM payments WHERE userId = $userId AND status = 0 AND cartArray LIKE '$cartArray'")) {
                header('Location: ../makePayment.php?msg=Payment Processing Error. Try Again.&type=error');
            } else {
                header('Location: ../makePayment.php?msg=Payment Processing Error. Try Again.&type=error');
            }
        } else {
            header('Location: ../makePayment.php?msg=Payment Processing Error. Try Again.&type=error');
        }

        if (mysqli_query($conn, $sql)) {
            // redirect to page so User can pay
            // uncomment this line to allow the user redirect to the payment page
            header('Location: ' . $transaction->data->link);
        } else {
            header('Location: ../makePayment.php?msg=Payment Processing Error. Try Again.&type=error');
        }
        //save in database-------------------------------------------------------------

    } else {
        header('Location: ../makePayment.php?msg=' . $myData . '&type=error');
    }
} else {
    header('Location: ../makePayment.php?msg=Payment Processing Error. Try Again.&type=error');
}
