<?php
include_once '../connect.php';

if ($query_run = mysqli_query($conn, "SELECT * FROM users WHERE active=0")) {
    if (mysqli_num_rows($query_run) != 0) {
        while ($query_row = mysqli_fetch_assoc($query_run)) {
            $firstName = $query_row['firstName'];
            $email = $query_row['email'];
            $token = $query_row['token'];

            $to = $email;
            $subject = "Account Verification";
            include_once '../../partials/templates/emailVerificationTemplate.php';
            $message = $emailVerificationTemplate;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <support@mufulirawanderers.com>' . "\r\n";

            if (mail($to, $subject, $message, $headers)) { //for production
                
            }
        }//end while()
    }
}
