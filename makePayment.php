<?php
//check if user logged in
if (!(isset($_COOKIE["userId"]) || isset($_COOKIE["boss"]))) {
    header('Location: ../index.php');
}

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
                <div class="col-md-12">
                    <div class="ritekhela-playoff-staning">
                        <h4>
                            MY CART
                            <p style="font-size: small;" class="pt-2">What I am paying for</p>
                        </h4>

                        <table class="ritekhela-client-detail table table-hover table-bordered makePaymentTable hide">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-right p-o m-0" style="font-size: small;">*you can remove what you do not need</p>

                    <ul class="ritekhela-offstanding-text">
                        <li>
                            <b>TOTAL: </b><b class="cartTotal"></b>
                        </li>
                    </ul>
                    <form id="makePaymentsForm" action="db/paymentsCollectDetails_db.php" method="POST">
                        <input type="hidden" name="totalAmount" class="cartTotalHidden">
                        <input type="hidden" name="email" value="<?php if (isset($_COOKIE["email"])) echo $_COOKIE["email"]; ?>">
                        <input type="hidden" name="cartArrayInputField" id="cartArrayInputFieldId">
                        <button type="submit" class="btn btn-dark btn-lg btn-block makeCartPaymentBtn hide">
                            Make Payment : <span class="cartTotal"></span>
                        </button>
                    </form>
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
<script>
    $(document).ready(function() {
        cartDBManager(); //update cart items
    });
</script>