<?php
//check IF user logged in
/* if (!isset($_COOKIE["userId"]) && !isset($_COOKIE["boss"])) {
    header('Location: index.php?' . $_COOKIE["userId"]);
} */
include_once 'partials/header.php';
?>
<!--// Header //-->


<!--// SubHeader //-->
<div class="ritekhela-subheader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>PAYMENTS</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Payments</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--// SubHeader //-->

<!--// Content //-->
<div class="ritekhela-main-content">

    <!--// Main Section //-->
    <div class="ritekhela-main-section ritekhela-fixture-list-full">
        <div class="container">
            <div class="row">

                <!--// Full Section //-->
                <div class="col-md-12 text-center align-center">

                    <a href="index.php">GO HOME</a>
                    <br>
                    <br>
                    <?php
                    if (isset($_GET["cancelled"])) {
                        if ($_GET["cancelled"] == "true") {
                            echo '<h2 class="align-center text-danger pb-5">Payment cancelled</h2>';
                            echo '<br><br><br><br><br><br>';
                        } else {
                            echo '<h2 class="align-center text-danger pb-5">Payment Error. Try Again</h2>';
                            echo '<br><br><br><br><br><br>';
                        }
                    } else if (isset($_GET["paymentSuccessful"])) {
                        echo '<h2 class="align-center pb-5 text-success">Payment successful!<br><br>Please check your email for your receipt</h2>';
                        echo '<br><br><br><br><br><br>';
                    } else {
                        echo '<h2 class="align-center text-danger pb-5">Payment Error. Try Again</h2>';
                        echo '<br><br><br><br><br><br>';
                    }
                    print_r($_GET);
                    ?>

                </div>
                <!--// Full Section //-->

            </div>
        </div>
    </div>
    <!--// Main Section //-->

</div>
<!--// Content //-->


<?php
include_once 'partials/footer.php';
?>