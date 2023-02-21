<?php
include_once 'validator.php';

if (!validate_email($_POST["email"], 'required') || !validate_password($_POST["password"], 'required')) {
    echo "Invalid Credentials.";
} else {

    $email = stripOff($conn, $_POST["email"]);
    $password = stripOff($conn, $_POST["password"]);

    $data = mysqli_query($conn, "SELECT * FROM admin WHERE email LIKE '$email' AND password LIKE '$password'");
    if (mysqli_num_rows($data) == 0) {

        $data = mysqli_query($conn, "SELECT * FROM users WHERE email LIKE '$email' AND active = 1 AND superActive = 1");
        $data2 = mysqli_query($conn, "SELECT * FROM users WHERE email LIKE '$email' AND active = 0 AND superActive = 1");

        if (mysqli_num_rows($data) == 1) {
            $user = mysqli_fetch_assoc($data);
            if (password_verify($password, $user["password"])) {

                setcookie('userId', $user['userId'], time() + (86400 * 30), "/");
                setcookie('firstName', $user['firstName'], time() + (86400 * 30), "/");
                setcookie('lastName', $user['lastName'], time() + (86400 * 30), "/");
                setcookie('email', $user['email'], time() + (86400 * 30), "/");
                setcookie('active', $user["active"], time() + (86400 * 30), "/");
                setcookie('contact', $user['contact'], time() + (86400 * 30), "/");
                setcookie('gender', $user['gender'], time() + (86400 * 30), "/");
                setcookie('nrc', $user['nrc'], time() + (86400 * 30), "/");
                setcookie('address', $user['address'], time() + (86400 * 30), "/");
                setcookie('town', $user['town'], time() + (86400 * 30), "/");
                setcookie('country', $user['country'], time() + (86400 * 30), "/");
                setcookie('signup_date', $user['signup_date'], time() + (86400 * 30), "/");

                /* HOUSE PRE-KEEPING BELOW */
                //get current membership if any
                $userId = $user['userId'];
                $data = mysqli_query($conn, "SELECT memberType FROM membership WHERE userId = $userId");
                if (mysqli_num_rows($data) == 1) {
                    $membership = mysqli_fetch_assoc($data);
                    setcookie('currentMembershipType', $membership['memberType'], time() + (86400 * 30), "/");

                    //check if already paid for current membership
                    $data = mysqli_query($conn, "SELECT memId FROM membership WHERE userId = $userId AND active = 1");
                    if (mysqli_num_rows($data) == 1) {
                        setcookie('currentMembershipPaidFor', true, time() + (86400 * 30), "/");
                    }
                } //end if()

                echo "success";
            } else {
                echo "Invalid Credentials.";
            }
        } elseif (mysqli_num_rows($data2) == 1) {
            echo "Click link sent to your email to activate your account";
        } else {
            echo "Invalid Credentials.";
        }
    } elseif (mysqli_num_rows($data) == 1) {
        if ($onLocalhost) {
            setcookie('boss', 'boss', time() + (86400 * 30), "/");
        } else {
            setcookie('boss', 'boss', time() + (3600), "/");
        }
        echo "admin";
    } else {
        echo "Invalid Credentials.";
    }
}
