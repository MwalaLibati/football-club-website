<?php
if (!isset($_COOKIE["displayUI"]) || (isset($_COOKIE["displayUI"]) && $_COOKIE["displayUI"] != "newPassword")) {
    header("Location: index.php");
}
include_once 'partials/header.php';
?>
<!--// Header //-->

<!--// Content //-->
<div class="ritekhela-main-content">

    <!--// Main Section //-->
    <div class="ritekhela-main-section ritekhela-fixture-list-full">
        <div class="container">
            <div class="row">

                <!--// Full Section //-->
                <div class="col-md-6">
                    <!--// Fancy Title //-->
                    <div class="ritekhela-fancy-title-two">
                        <h2>New Password</h2>
                    </div>
                    <!--// Fancy Title //-->
                    <div class="ritekhela-form">
                        <p class="newPasswordFormMsg p-0 text-center"></p>
                        <form class="loginmodalbox-search" id="newPasswordForm">
                            <div class="form-group m-3">
                                <label class="text-dark">Enter New Password</label>
                                <input type="password" name="password" class="form-control p-4" autofocus>
                            </div>

                            <div class="form-group m-3">
                                <label class="text-dark">Confirm New Password</label>
                                <input type="password" name="confirmPassword" class="form-control p-4">
                            </div>
                            <input type="submit" value="SUBMIT" class="club-theme-bg btn btn-lg btn-block text-white submitBtnNewPassword">
                        </form>
                    </div>

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