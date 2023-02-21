<?php
include_once 'partials/header.php';
include_once 'db/timeAgo.php';


if (isset($_COOKIE["userId"])) {
    $userId = $_COOKIE["userId"];

    //check if already a member
    $monthDuration = $memberType = '';
    $currentMemId = $MembershipPrice = '';
    $alreadyPaidFor = false;
    $data = mysqli_query($conn, "SELECT memId, active FROM membership WHERE userId = $userId");
    if (mysqli_num_rows($data) == 1) {
        $membership = mysqli_fetch_assoc($data);
        $currentMemId = $membership["memId"];
        if ($membership["active"] == 1) {
            $alreadyPaidFor = true;
        }

        //get price
        $memberType = $_COOKIE["currentMembershipType"];
        $previousMembershipStillAvailable = true;
        $data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$memberType'");
        if (mysqli_num_rows($data) == 1) {
            $membershipConfig = mysqli_fetch_assoc($data);
            $MembershipPrice = $membershipConfig["price"];
            $monthDuration = $membershipConfig["monthDuration"];
            $MembershipImgPath = getFilePath('membershipType', $membershipConfig["id"], $conn)[0];
        } else {
            $previousMembershipStillAvailable = false;
        }
    }
}
?>

<head>
    <!-- DataTables -->
    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="admin/dist/css/adminlte.min.css"> -->

</head>
<!--// Header //-->

<!--// SubHeader //-->
<div class="ritekhela-subheader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Profile</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>User Profile</li>
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

                <div class="container">
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-4">
                                <div class="card userProfileCards">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="<?php echo getFilePath('profile_pic', $currentMemId, $conn)[0]; ?>" alt="profile pic" class="rounded-circle profileSize150">
                                            <div class="mt-3">
                                                <h4><span class="firstNameDisplay"><?php echo $_COOKIE["firstName"] ?></span> <span class="lastNameDisplay"><?php echo $_COOKIE["lastName"]; ?></span></h4>
                                                <span class="text-secondary p-1 block">
                                                    Joined:
                                                    <a class="font-small badge bg-transparent">
                                                        <?php
                                                        $dt = new DateTime($_COOKIE["signup_date"]);
                                                        echo getTimeAgo($_COOKIE["signup_date"]);
                                                        ?>
                                                    </a>
                                                </span>
                                                <span class="text-secondary p-1 block">
                                                    On:
                                                    <a class="font-small badge bg-transparent">
                                                        <?php
                                                        $dt = new DateTime($_COOKIE["signup_date"]);
                                                        echo $dt->format('d-m-Y | h:m A');
                                                        ?>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="col-md-4" id="userProfileForm">
                                <div class="card mb-3 userProfileCards">
                                    <h6 class="d-flex align-items-center m-3">
                                        Profile Details
                                    </h6>
                                    <div class="card-body pt-1" style="width: 100%;">
                                        <div class="ml-1 mb-3 text-secondary">
                                            <label class="mb-0 block">First Name</label>
                                            <input type="text" name="firstName" data-toggle="tooltip" title="Edit First Name" class="userProfileField bg-transparent text-dark border rounded" value="<?php echo $_COOKIE["firstName"]; ?>">
                                        </div>
                                        <div class="ml-1 mb-3 text-secondary">
                                            <label class="mb-0 block">Last Name</label>
                                            <input type="text" name="lastName" data-toggle="tooltip" title="Edit Last Name" class="userProfileField bg-transparent text-dark border rounded" value="<?php echo $_COOKIE["lastName"]; ?>">
                                        </div>
                                        <div class="ml-1 text-secondary">
                                            <label class="mb-0 block">Email</label>
                                            <input type="text" name="email" readonly class="userProfileField bg-light text-dark border rounded" value="<?php echo $_COOKIE["email"]; ?>" data-toggle="tooltip" title="<?php echo $_COOKIE["email"]; ?>">
                                            <small class="font-x-small text-dark m-0 p-0 block">(Cannot be edited)</small>
                                        </div>
                                    </div>
                                    <button type="submit" class="userProfileField btn btn-light text-dark m-0 submitBtnEditUserProfile">Save Changes</button>
                                </div>
                            </form>
                            <div class="col-md-4 userProfileCards">
                                <div class="card h-100">
                                    <h6 class="d-flex align-items-center m-3">
                                        Extras
                                    </h6>
                                    <div class="card-body row pt-1">
                                        <div class="form-group col-md-12 pb-0 mb-0">
                                            <label class="m-0">
                                                <?php
                                                if (isset($_COOKIE["currentMembershipType"])) {
                                                    if ($previousMembershipStillAvailable) {
                                                        echo $_COOKIE["currentMembershipType"] . " Member";
                                                        if ($alreadyPaidFor) {
                                                            echo '<span class="badge badge-success m-0 p-1 font-x-small m-1">Paid</span>';
                                                        } else {
                                                            echo '<span class="badge badge-danger m-0 p-1 font-x-small m-1">Not Paid</span>';
                                                        }
                                                    } else {
                                                        echo 'Membership';
                                                    }
                                                } else {
                                                    echo 'Membership';
                                                }
                                                ?>
                                            </label>
                                            <?php
                                            if (!isset($_COOKIE["currentMembershipType"])) {
                                                echo '<a href="membershipTypes.php" class="userProfileField btn bg-transparent border-1 border-dark btn-sm btn-block font-small">Apply Now <i class="fas fa-address-card"></i></a>';
                                            } elseif (isset($_COOKIE["currentMembershipType"])) {
                                                if ($previousMembershipStillAvailable) {
                                                    if ($alreadyPaidFor) {
                                                        echo '<button disabled class="userProfileField btn bg-transparent border-1 border-dark btn-sm font-small">' . $_COOKIE["currentMembershipType"] . ' <i class="fas fa-address-card"></i></button>';
                                                    } else {
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
                                                        $membershipCartDetails =  $memberType . ' Membership_____' . $MembershipPrice . '_____' . $MembershipImgPath . '_____' . $currentMemId . '_____1_____1_____' . $MembershipPrice . '_____1_____membership';
                                                        echo '<button value="' . $membershipCartDetails . '" data-toggle="tooltip" title="Pay ' . $_COOKIE["currentMembershipType"] . ' Subscription Fee: K' . $MembershipPrice . ' ' . $DisplayMonthDuration . '" class="userProfileField buyBtn btn bg-transparent border-1 border-dark btn-sm font-small">Pay: K' . $MembershipPrice . ' ' . $DisplayMonthDuration . '</button>';
                                                    }
                                                } else {
                                                    echo '<a href="membershipTypes.php" class="userProfileField btn bg-transparent border-1 border-dark btn-sm btn-block font-small">Apply Now <i class="fas fa-address-card"></i></a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="form-group col-md-12 pb-0 mb-0">
                                            <label class="block m-0">Password</label>
                                            <button type="button" value="<?php echo $_COOKIE["email"]; ?>" class="userProfileField btn bg-transparent border-1 border-dark btn-sm font-small" data-toggle="tooltip" title="A Password Reset Link Will Be Sent To Your Email" id="changeMyPasswordBtn">Change My Password <i class="fas fa-key"></i></button>
                                        </div>
                                        <div class="form-group col-md-12 pb-0 mb-0">
                                            <label class="block m-0">Account</label>
                                            <button type="button" value="<?php echo $_COOKIE["email"]; ?>" class="userProfileField btn bg-transparent border-1 border-danger btn-sm text-danger font-small" id="deleteMyAccountPreBtn">Delete My Account <i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!--// Full Section //-->
                <div class="col-md-12 mt-4">
                    <h3>PAYMENT HISTORY</h3>
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#ePaymentDetails" data-toggle="tab">Payment History</a></li>
                                <li class="nav-item"><a class="nav-link" href="#purchaseDetails" data-toggle="tab">Purchases</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="ePaymentDetails">
                                    <table id="example1" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Ref No.</th>
                                                <th>Amount Paid</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Purchased Items</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $data = mysqli_query($conn, "SELECT * FROM payments WHERE userId = " . $userId . " ORDER BY payDate DESC");
                                            if (mysqli_num_rows($data) != 0) {
                                                $count = 0;
                                                while ($result = mysqli_fetch_assoc($data)) {
                                                    $count++;
                                                    $payStatus = '<span class="badge badge-danger">Failed</span>';
                                                    if ($result["status"] == 1) {
                                                        $payStatus = '<span class="badge badge-success">Paid</span>';
                                                    }
                                                    $dt = new DateTime($result["payDate"]);
                                                    $newDate = $dt->format('d-m-Y | h:m A');
                                                    echo '<tr>
                                                            <td>' . $count . '.</td>
                                                            <td>' . $result["ref"] . '</td>
                                                            <td>K ' . $result["amountPaid"] . '</td>
                                                            <td>' . $newDate . '</td>
                                                            <td>' . $payStatus . '</td>
                                                            <td>
                                                                <button value="' . $result["ref"] . '" class="btn btn-sm btn-primary m-0 text-white viewPaidItemsBtn">View</button>
                                                            </td>
                                                        </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <th>No.</th>
                                            <th>Ref No.</th>
                                            <th>Amount Paid</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Purchased Items</th>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="tab-pane" id="purchaseDetails">
                                    <table id="example33" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Product Name</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Ref No.</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $data = mysqli_query($conn, "SELECT paidForItems.*, payments.* FROM paidForItems LEFT JOIN payments ON paidForItems.payId = payments.payId WHERE payments.userId = " . $userId . " ORDER BY payDate DESC");
                                            if (mysqli_num_rows($data) != 0) {
                                                $count = 0;
                                                while ($result = mysqli_fetch_assoc($data)) {
                                                    $count++;
                                                    $payStatus = '<span class="badge badge-danger">Failed</span>';
                                                    if ($result["status"] == 1) {
                                                        $payStatus = '<span class="badge badge-success">Paid</span>';
                                                    }
                                                    $itemType = '<span class="badge badge-dark">' . $result["itemType"] . '</span>';
                                                    $img = "";
                                                    if ($result["itemType"] == 'product') {
                                                        $itemType = '<span class="badge badge-warning">' . $result["itemType"] . '</span>';
                                                    }
                                                    $dt = new DateTime($result["payDate"]);
                                                    $newDate = $dt->format('d-m-Y | h:m A');

                                                    $fileType = "";
                                                    if ($result["itemType"] == 'product') {
                                                        $fileType = 'product';
                                                    } elseif ($result["itemType"] == 'membership') {
                                                        $fileType = 'membershipType';
                                                    }
                                                    $imgs = '<img width=\'100px\' height=\'100px\' src=\'' . getFilePath($fileType, $result["itemId"], $conn)[0] . ' \'>';

                                                    echo '<tr>
                                                            <td>' . $count . '.</td>
                                                            <td style = "text-transform:capitalize;" data-toggle="tooltip" data-html="true" title="' . $imgs . '">' . $result["name"] . '</td>
                                                            <td style = "text-transform:capitalize;">' . $itemType . '</td>
                                                            <td>' . $result["myQuantity"] . '</td>
                                                            <td class="hand hover-black-green" data-toggle="tooltip" title="K' . $result["originalPrice"] . ' each">K ' . $result["priceByQuantity"] . '</td>
                                                            <td>' . $result["ref"] . '</td>
                                                            <td>' . $payStatus . '</td>
                                                            <td>' . $newDate . '</td>
                                                        </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <th>No.</th>
                                            <th>Product Name</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Ref No.</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--// Full Section //-->

            </div>
        </div>
    </div>
    <!--// Main Section //-->

</div>
<!--// Content //-->

<!--// Footer //-->
<?php
include_once 'partials/footer.php';
?>
<script src="admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        $("#example1,#example22,#example33").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<script>
    $(document).ready(function() {
        //view payment's purchased items
        $(document).on("click", ".viewPaidItemsBtn", function() {
            let ref = $(this).val();
            $('.nav-item a[href="#purchaseDetails"]').tab('show');
            $('input[aria-controls="example33"]').addClass('auto-focus-border');
            // setTimeout(function() {
            //   $('input[aria-controls="example22"]').removeClass('auto-focus-border');
            // }, 5000);
            $("#example33").dataTable().fnFilter(ref)
        });
    });
</script>