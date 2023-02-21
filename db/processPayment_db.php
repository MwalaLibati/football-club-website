<?php

include_once 'validatePaymentItems.php';
include_once 'generateEmailForProcessPayment.php';


if (isset($_GET['txref'])) {

    //get payment record by ref No.
    $txref =  $_GET['txref'];
    $data = mysqli_query($conn, "SELECT * FROM payments WHERE status = 0 AND ref LIKE '$txref'");
    $paymentResults = mysqli_fetch_assoc($data);
    if (mysqli_num_rows($data) != 1) {
        header('Location: ../makePayment.php?msg=Payment Failed. Please Try Again&type=error');
    }

    //get user's email
    $userId = $paymentResults["userId"];
    $data1 = mysqli_query($conn, "SELECT email FROM users WHERE userId = $userId AND active = 1");
    if (mysqli_num_rows($data1) != 1) {
        header('Location: ../makePayment.php?msg=Payment Failed.. Please Try Again&type=error');
    }
    $user = mysqli_fetch_assoc($data1);


    $totalAmount = 0;

    //validate our cart array's contents
    $email = $user['email'];
    $myData = validatePaymentItems(json_decode($paymentResults['cartArray']), $email, $paymentResults['amountPaid'], $userId, $conn);

    if (strpos($myData, '_____')) {

        //get validated result
        $result = explode('_____', $myData);

        $ref = $_GET['txref'];
        $amount = $result[2]; //Correct Amount from Server
        $currency = "ZMW"; //Correct Currency from Server

        $query = array(
            "SECKEY" => "FLWSECK_TEST-69aac86601e29eb4440e5bc2af6a5aa7-X",
            "txref" => $ref
        );

        $data_string = json_encode($query);

        $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $resp = json_decode($response, true);

        $paymentStatus = $resp['data']['status'];
        $chargeResponseCode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];

        // $val = '<br>chargeResponseCode=' . $chargeResponseCode . '<br>paymentStatus=' . $paymentStatus . '<br>chargeAmount=' . $chargeAmount . '<br>amount=' . $amount . '<br>chargeCurrency=' . $chargeCurrency . '<br>currency=' . $currency;
        if (
            mysqli_query($conn, "UPDATE payments SET status = 1 WHERE ref LIKE '$txref' AND status = 0") &&
            ($chargeResponseCode == "00" || $chargeResponseCode == "0") &&
            ($chargeAmount == $amount)  &&
            ($chargeCurrency == $currency)
        ) {
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            //Give Value and return to Success page

            //triple checking item before payment confirmation
            $updateItemsInDB = updateItemsInDB(json_decode($paymentResults['cartArray']), $paymentResults['payId'], $userId, $email, $conn);
            generateEmailForProcessPayment(json_decode($paymentResults['cartArray']), $paymentResults['amountPaid'], $paymentResults['ref'], $onLocalhost);
            header('Location: ../makePayment.php?msg=Payment Made Successfully.<br>Check your email for receipt&type=success&paid=' . $updateItemsInDB);
        } else {
            //Don't Give Value and return to Failure page
            header('Location: ../makePayment.php?msg=Payment Failed... Please Try Again&type=error');
        }
    } else {
        header('Location: ../makePayment.php?msg=' . $myData . '&type=error');
    }
} else {
    // die('No reference supplied');
    header('Location: ../makePayment.php?msg=Payment Failed.... Please Try Again&type=error');
}
