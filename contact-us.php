<?php
include_once 'partials/header.php';
?>

<!--// Header //-->

<!--// SubHeader //-->
<div class="ritekhela-subheader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Contact Us</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--// SubHeader //-->

<!--// Content //-->
<div class="ritekhela-main-content">

    <!--// Main Section //-->
    <!-- <div class="ritekhela-main-section ritekhela-contact-map-full">
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div id="map" class="col-md-12" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--// Main Section //-->

    <!--// Main Section //-->
    <div class="ritekhela-main-section ritekhela-fixture-list-full">
        <div class="container">
            <div class="row">

                <!--// Full Section //-->
                <div class="col-md-12">
                    <div class="ritekhela-fancy-title-two">
                        <h2>Contact Information</h2>
                    </div>
                    <div class="ritekhela-contact-list">
                        <ul class="row">
                            <li class="col-md-4">
                                <i class="fa fa-phone"></i>
                                <span>
                                    <a href="tel:+260966666666" class="hover-black-green">
                                        +26 0966 666666
                                    </a>
                                </span>
                                <span>
                                    <a href="tel:+260977777777" class="hover-black-green">
                                        +26 0977 777777
                                    </a>
                                </span>
                            </li>
                            <li class="col-md-4">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:support@mufulirawanderers.com?Subject=Hello Support Team" target="_blank" class="hover-black-green">
                                    support@mufulirawanderers.com
                                </a>
                                <a href="mailto:business@mufulirawanderers.com?Subject=Hello Business Team" target="_blank" class="hover-black-green">
                                    business@mufulirawanderers.com
                                </a>
                            </li>
                            <li class="col-md-4">
                                <i class="fa fa-map-marker-alt"></i>
                                <span>
                                    Physical Address
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!--// Fancy Title //-->
                    <div class="ritekhela-fancy-title-two">
                        <h2>Contact Here</h2>
                    </div>
                    <!--// Fancy Title //-->
                    <p class="contactFormMsg p-0"></p>
                    <div class="ritekhela-form">
                        <form id="contactForm">
                            <p>
                                <input value="<?php if (isset($_COOKIE["firstName"])) {
                                                    echo $_COOKIE["firstName"] . ' ' . $_COOKIE["lastName"];
                                                } ?>" type="text" placeholder="Full Name" name="fullName">
                            </p>

                            <p>
                                <input value="<?php if (isset($_COOKIE["email"])) {
                                                    echo $_COOKIE["email"];
                                                } ?>" type="text" placeholder="Your Email Address" name="email">
                            </p>

                            <p class="ritekhela-comment">
                                <textarea placeholder="Comment" name="comment"></textarea>
                            </p>

                            <p class="ritekhela-submit">
                                <input type="submit" value="Send Now" class="ritekhela-bgcolor btn btn-block btn-lg submitBtnContact">
                            </p>
                        </form>
                    </div>


                    <!-- <div class="ritekhela-fancy-title-two mt-5">
                        <h2>Locate Us</h2>
                    </div> -->
                    <!--// Fancy Title //-->
                    <div class="ritekhela-form mt-5">
                        <div id="map" class="col-md-12" style="height: 400px;"></div>
                    </div>


                    <!--// Fancy Title //-->
                    <!-- <div class="ritekhela-fancy-title">
                        <div class="ritekhela-fancy-title-inner">
                            <h2>our Partner</h2>
                            <span>Is Your Team Ready For Next Match!</span>
                        </div>
                    </div> -->
                    <!--// Fancy Title //-->

                    <!--// Partner //-->
                    <!-- <div class="ritekhela-partner-view1">
                        <ul class="row">
                            <li class="col-md-3"><a href="#"><img src="extra-images/partner-logo-1.jpg" alt=""></a></li>
                            <li class="col-md-3"><a href="#"><img src="extra-images/partner-logo-2.jpg" alt=""></a></li>
                            <li class="col-md-3"><a href="#"><img src="extra-images/partner-logo-3.jpg" alt=""></a></li>
                            <li class="col-md-3"><a href="#"><img src="extra-images/partner-logo-1.jpg" alt=""></a></li>
                        </ul>
                    </div> -->
                    <!--// Partner //-->
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
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb5QTtOqAeW7jvKamFDHUWXHSuvxT5__A&callback=initMap">
</script>