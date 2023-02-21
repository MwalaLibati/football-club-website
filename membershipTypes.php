<?php
//check if user logged in
if (isset($_COOKIE["boss"])) {
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
                <h1>Membership Types</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Membership Types</li>
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

                <div class="col-md-12">
                    <div class="ritekhela-shop ritekhela-shop-view1">
                        <ul class="row">

                            <?php
                            $data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE active = 1 ORDER BY price ASC");
                            if (mysqli_num_rows($data) != 0) {
                                while ($result = mysqli_fetch_assoc($data)) {

                                    $DisplayMonthDuration = '';
                                    if ($result["monthDuration"] == 0) {
                                        $DisplayMonthDuration = '';
                                    } elseif ($result["monthDuration"] == 1) {
                                        $DisplayMonthDuration = '(Per Month)';
                                    } elseif ($result["monthDuration"] == 3) {
                                        $DisplayMonthDuration = '(Per 3 Month)';
                                    } elseif ($result["monthDuration"] == 6) {
                                        $DisplayMonthDuration = '(Per 6 Month)';
                                    } elseif ($result["monthDuration"] == 12) {
                                        $DisplayMonthDuration = '(Per Year)';
                                    }

                                    $path = $result["path"];
                                    $currentMembershipBadge = '';
                                    $btn = '<a href="#" data-toggle="modal" data-target="#ritekhelamodalcenter" class="btn btn-sm bg-gray-dark mt-3 border-1 border-darkish-1">Subscribe</a>';
                                    if (isset($_COOKIE['userId'])) {
                                        $btn = '<a href="membershipApply.php?memberType=' . $result["memberType"] . '" class="btn btn-sm bg-gray-dark mt-3 border-1 border-darkish-1">Subscribe</a>';

                                        if ($_COOKIE["currentMembershipType"] == $result["memberType"]) {
                                            $currentMembershipBadge = '<span class="badge badge-light productBadge m-1">Your Current</span>';
                                            /* if (isset($_COOKIE["currentMembershipPaidFor"])) {
                                                $currentMembershipBadge = '<span class="badge badge-success productBadge m-1">Your Current</span>';
                                            } elseif (!isset($_COOKIE["currentMembershipPaidFor"])) {
                                                $currentMembershipBadge = '<span data-toggle="tooltip" title="Subscription Fee Not Yet Paid" class="badge badge-danger productBadge m-1">Your Current</span>';
                                            } */
                                        }
                                    }

                                    echo '<div class="col-md-3">
                                            <div class="card profile-card-3">
                                                <div class="background-block">
                                                    <span class="productBadgeCover">' . $currentMembershipBadge . '</span>
                                                    <img src="images/placeholders/net2.jpg" alt="profile-sample1" class="background" />
                                                </div>
                                                <div class="profile-thumb-block">
                                                    <img src="' . getFilePath('membershipType', $result["id"], $conn)[0] . '" alt="profile-image" class="profile" />
                                                </div>
                                                <div class="card-content">
                                                    <h2>' . $result["memberType"] . '</h2>
                                                    <p class="font-medium">K ' . $result["price"] . ' ' . $DisplayMonthDuration . '</p>
                                                    <p class="font-small" style="height:50px;">Write text describing what it means when a user subscribe to this</p>
                                                    ' . $btn . '
                                                </div>
                                            </div>
                                        </div>';
                                }
                            } else {


                                echo '<div class="col-md-4">
                                        <div class="card profile-card-3">
                                            <div class="background-block">
                                                <img src="images/placeholders/net2.jpg" alt="profile-sample1" class="background" />
                                            </div>
                                            <div class="profile-thumb-block">
                                                <img src="images/placeholders/not.jpg" alt="profile-image" class="profile" />
                                            </div>
                                            <div class="card-content">
                                                <h3>Memberships Are Currently Unavailable</h3>
                                            </div>
                                        </div>
                                    </div>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--// Main Section //-->

</div>
<!--// Content //-->
<?php
include_once 'partials/footer.php';
?>