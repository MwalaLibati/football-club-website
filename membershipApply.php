<?php
include_once 'db/connect.php';
include_once 'db/fileUploadManager.php';

//check if user logged in
if (!isset($_COOKIE["userId"])) {
    header('Location: index.php');
}
$userId = $_COOKIE["userId"];

//get price of membership
$price = $path = '';
if (isset($_GET["memberType"])) {
    $memberType = $_GET["memberType"];
    $data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$memberType' AND active = 1");
    if (mysqli_num_rows($data) == 1) {
        $membershipConfig = mysqli_fetch_assoc($data);
        $price = $membershipConfig["price"];
        $path = getFilePath('membershipType', $membershipConfig["id"], $conn)[0];
        $monthDuration = $membershipConfig["monthDuration"];
        $newMemberType = $membershipConfig["memberType"];
    } else {
        header('Location: membershipTypes.php?msg=' . $memberType . ' membership<br>is currently unavailable&type=neutral');
    }
} else {
    header('Location: membershipTypes.php');
}

//check if already a member
$someText = '';
$currentMembershipType = $currentMemId = $currentPrice = $currentPath = '';
if (isset($_COOKIE["currentMembershipType"])) {
    $currentMembershipType = $_COOKIE["currentMembershipType"];
    $data = mysqli_query($conn, "SELECT memId, membNo, active FROM membership WHERE userId = $userId");
    $membership2 = mysqli_fetch_assoc($data);
    if (mysqli_num_rows($data) == 1) {
        $currentMemId = $membership2["memId"];
        $someText = '<h6 class="font-weight-bold text-white">Current Membership:</h6><p class="text-white">' . $currentMembershipType . '</p> <br>';
        $someText .= '<h6 class="font-weight-bold text-white">Reference No:</h6><p class="text-white">' . $membership2["membNo"] . '</p>';

        if ($membership2["active"] == 0) {
            $data2 = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$currentMembershipType' AND active = 1");
            if (mysqli_num_rows($data2) == 1) {
                $membershipConfig2 = mysqli_fetch_assoc($data2);
                $currentPrice = $membershipConfig2["price"];
                $currentPath = getFilePath('membershipType', $membershipConfig2["id"], $conn)[0];
                $membershipCartDetails =  $currentMembershipType . ' Membership_____' . $currentPrice . '_____' . $currentPath . '_____' . $currentMemId . '_____1_____1_____' . $currentPrice . '_____1_____membership';
                $someText .= '<i class="badge badge-danger badge-pill">Not yet paid...</i><br><br><button value="' . $membershipCartDetails . '" class="btn btn-sm buyBtn btn-light">Pay Now</button>';
            } else {
                $someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b> <br><br> It seems the membership you previously applied for is currently unavailable.<br><br> Please go ahead and fill in this form to apply for a new <b>' . $newMemberType . '</b> membership';
            }
        } elseif ($membership2["active"] == 1) {
            $someText .= '<br><i class="badge badge-success badge-pill font-small">Paid</i>';
            // $someText .= '<br><br><i class="badge badge-light text-dark font-small badge-pill">You are currently a ' . $currentMembershipType . ' Member</i>';
        } else {
            $someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b>.. <br> Kind fill in and submit the form to get started';
        }
    } else {
        $someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b>.. <br> Kind fill in and submit the form to get started';
    }
} else {
    $someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b>. <br> Kind fill in and submit the form to get started';
}
include_once 'partials/header.php';
?>

<!--// Header //-->

<!--// SubHeader //-->
<div class="ritekhela-subheader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Apply Membership</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Apply Membership</li>
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

            <form id="wizard" class="membershipForm" enctype="multipart/form-data">
                <h3>Intro</h3>
                <section class="center-block text-center">
                    <div class="row">
                        <div class="col-md-5 p-3 m-1 border-grayish-1 rounded">
                            <img src="<?php echo $path; ?>" alt="pic" class="rounded-circle pt-2 membershipImgPath" width="150" height="150">
                            <h5 class="bd-wizard-step-title m-2"><?php echo $newMemberType; ?> Membership</h5>
                            <br>
                            <h6 class="font-weight-bold">Price</h6>
                            <p class="mb-4 bg-transparent text-dark text-u nderline">
                                K <?php
                                    $DisplayMonthDuration = '';
                                    if ($monthDuration == 0) {
                                        $DisplayMonthDuration = '';
                                    } elseif ($monthDuration == 1) {
                                        $DisplayMonthDuration = '(Per Month)';
                                    } elseif ($monthDuration == 3) {
                                        $DisplayMonthDuration = '(Per 3 Month)';
                                    } elseif ($monthDuration == 6) {
                                        $DisplayMonthDuration = '(Per 6 Month)';
                                    } elseif ($monthDuration == 12) {
                                        $DisplayMonthDuration = '(Per Year)';
                                    }
                                    echo $price . ' ' . $DisplayMonthDuration;
                                    ?>
                            </p>
                            <h6 class="font-weight-bold">Benefits</h6>
                            <p>
                                Write some text describing what it means when a user subscribes for this membership
                            </p>
                        </div>
                        <div class="col-md-5 p-3 m-1 rounded" style="background-color: #00d69f;">
                            <h5 class="bd-wizard-step-title m-4 text-white">My Membership Status</h5>
                            <p class="text-white"><?php echo $someText; ?></p>

                        </div>
                    </div>
                </section>

                <h3>Step 2</h3>
                <section>
                    <h5 class="bd-wizard-step-title mb-2">Step 2</h5>
                    <h3 class="section-heading font-medium">Account Details</h3>
                    <div class="row">
                        <div class="col-md-5 m-2">
                            <div class="card height-400">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="<?php echo getFilePath('profile_pic', $currentMemId, $conn)[0]; ?>" id="membershipProfilePic" alt="profile pic" class="rounded-circle" style="width: 150px; height: 150px;">
                                        <div class="mt-5">
                                            <p>Upload Profile Picture</p>
                                            <div class="form-group">
                                                <input type="file" name="file[]" accept="image/*" multiple onchange="previewImg(this);" class="userProfileField p-3 form-control-file border rounded">
                                                <small class="font-small text-dark italic m-0 p-0 block">
                                                    Max Size: 5MB <br>
                                                    Formats: (.jpg / .png / .jpeg) <br>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 m-2">
                            <div class="card height-400">
                                <h6 class="d-flex align-items-center m-3">
                                    Account Details
                                </h6>
                                <div class="card-body pt-1" style="width: 100%;">
                                    <div class="form-group mb-0">
                                        <label class="mb-0 block">First Name</label>
                                        <input type="text" disabled style="font-size: medium;" class="userProfileField form-control border rounded" value="<?php echo $_COOKIE["firstName"]; ?>" title="<?php echo $_COOKIE["firstName"]; ?>">
                                        <small class="font-x-small text-right text-dark m-0 p-0 block">Cannot be edited</small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="mb-0 block">Last Name</label>
                                        <input type="text" disabled style="font-size: medium;" class="userProfileField form-control border rounded" value="<?php echo $_COOKIE["lastName"]; ?>" title="<?php echo $_COOKIE["lastName"]; ?>">
                                        <small class="font-x-small text-right text-dark m-0 p-0 block">Cannot be edited</small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="mb-0 block">Account Email</label>
                                        <input type="text" disabled style="font-size: medium;" class="userProfileField form-control border rounded" value="<?php echo $_COOKIE["email"]; ?>" title="<?php echo $_COOKIE["email"]; ?>">
                                        <small class="font-x-small text-right text-dark m-0 p-0 block">Cannot be edited</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <h3>Step 3</h3>
                <section>
                    <h5 class="bd-wizard-step-title mb-2">Step 3</h5>
                    <h2 class="section-heading">Enter Personal Details</h2>

                    <div class="form-group">
                        <label class="mb-0 block">NRC Number</label>
                        <input type="text" name="nrc" style="font-size: medium;" placeholder="Eg. 111111/22/3" value="<?php echo $_COOKIE["nrc"] ?>" class="form-control font-medium formatNRC bg-transparent">
                    </div>
                    <div class="form-group">
                        <label class="mb-0 block">Gender</label>
                        <select class="form-control text-dark p-3 bg-transparent" style="font-size: medium;" name="gender">
                            <option>- Select -</option>
                            <option <?php if ($_COOKIE["gender"] == 'Male') {
                                        echo 'selected';
                                    } ?> value="Male">Male</option>
                            <option <?php if ($_COOKIE["gender"] == 'Female') {
                                        echo 'selected';
                                    } ?> value="Female">Female</option>
                            <option <?php if ($_COOKIE["gender"] == 'Other') {
                                        echo 'selected';
                                    } ?> value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 block">Phone Number</label>
                        <input type="text" name="contact" style="font-size: medium;" value="<?php echo $_COOKIE["contact"] ?>" class="form-control bg-transparent" placeholder="Eg. 09/07...">
                    </div>
                </section>

                <h3>Step 4</h3>
                <section>
                    <h5 class="bd-wizard-step-title mb-2">Step 4</h5>
                    <h2 class="section-heading">Enter Address Details</h2>

                    <div class="form-group">
                        <label class="mb-0 block">Country</label>
                        <select class="form-control text-dark p-3 bg-transparent" style="font-size: medium;" name="country">
                            <?php
                            include_once 'membershipForms/countriesList.php';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 block">Town</label>
                        <input type="text" name="town" value="<?php echo $_COOKIE["town"] ?>" style="font-size: medium;" class="bg-transparent form-control" placeholder="E.g Kitwe">
                    </div>
                    <div class="form-group">
                        <label class="mb-0 block">Physical Address</label>
                        <textarea rows="4" style="height: max-content;" style="font-size: medium;" class="form-control bg-transparent" type="text" name="address" placeholder="Your Current Address"><?php echo $_COOKIE["address"] ?></textarea>
                    </div>
                </section>

                <h3>Step 5</h3>
                <section>
                    <h5 class="bd-wizard-step-title mb-2">Step 5</h5>
                    <h2 class="section-heading mb-5">Finish</h2>
                    <div class="row">
                        <div class="col-md-6 membershipMsg">
                            <h6 class="font-weight-bold">You're almost done!</h6>
                            <p class="mb-4" id="business-type">Click finish below to submit your <?php echo $_GET["memberType"]; ?> membership form.</p>
                        </div>
                    </div>
                </section>
                <input type="hidden" name="memberType" value="<?php echo $_GET["memberType"]; ?>">
                <input type="hidden" class="appliedForMemberType" value="<?php echo $_GET["memberType"]; ?>">
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                <input type="hidden" class="membershipPrice" value="<?php echo $price . ' ' . $DisplayMonthDuration; ?>">
            </form>

        </div>
    </div>
    <!--// Main Section //-->

</div>
<!--// Content //-->
<?php
include_once 'partials/footer.php';
?>