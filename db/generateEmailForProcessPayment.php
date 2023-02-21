<?php

function generateEmailForProcessPayment($array, $amountPaid, $ref, $onLocalhost)
{
    /*************send email*************/
    $heading = "Purchased Products";
    $mainComment =
        '<table class="productsTable">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>';
    for ($i = 1; $i < json_encode(count($array)); $i++) {
        $name = $array[$i]->name;
        $price = (float)$array[$i]->price;
        $myQuantity = (int)$array[$i]->myQuantity; //user defined quantity
        $path = $array[$i]->path;

        if ($onLocalhost) {
            $url = 'http://localhost:8080/myprojects/football-club-website/';
        } elseif (!$onLocalhost) {
            $url = 'https://mufulirawanderers.com/';
        }

        $mainComment .=
            '<tr>
                <td>
                    <a target="_blank" href="' . $url . $path . '"><img src="' . $url . $path . '" height="30" width="30" alt="product Image"></a>
                </td>
                <td>' . $name . '</td>
                <td>' . $myQuantity . '</td>
                <td>K ' . $price . '</td>
            </tr>';
    } //end for()

    $mainComment .=
        '<tr>
        <td><b>TOTAL:</b></td>
        <td></td>
        <td></td>
        <td>
            <b>K ' . $amountPaid . '</b>
        </td>
    </tr>
    </table>
    <p style="padding: 5px; margin-top:30px; background:#f2f2f2;">Payment Reference No: <b>' . $ref . '</b></p>
    <p style="padding: 5px; margin-top:30px;">Contact our <a style="text-decoration:underline;" target="_blank" href="mailto:support@mufulirawanderers.com?Subject=Hello Support Team">Sells</a> office to collect you products</p>';
    $btnHref = '';
    $subComment = 'You may use this <b>List & Payment Reference No.</b> as proof of payment when collecting your purchased products';
    include_once '../partials/templates/emailTemplate.php';
    $message = $emailTemplate;
    $to = $email;
    $subject = "Membership Form Submission";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";
    if ($onLocalhost) {
        file_put_contents("../../emailOffline.html", $message);
    } elseif (!$onLocalhost) {
        mail($to, $subject, $message, $headers);
    }
}//end generateEmailForProcessPayment()
