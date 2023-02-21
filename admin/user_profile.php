<?php
include_once '../db/connect.php';

if (!isset($_GET["user"]) || !isset($_GET["breadcrumb"])) {
  header('Location: index.php');
}
$breadcrumb = '';
if ($_GET["breadcrumb"] == 'membership') {
  $breadcrumb = '<li class="breadcrumb-item"><a href="view_registered_members.php">Members</a></li>';
} elseif ($_GET["breadcrumb"] == 'users') {
  $breadcrumb = '<li class="breadcrumb-item"><a href="view_users.php">Users</a></li>';
}
$token = $_GET["user"];

// get userId
$data = mysqli_query($conn, "SELECT userId FROM users WHERE token LIKE '$token'");
$user2 = mysqli_fetch_assoc($data);
if (mysqli_num_rows($data) != 1) {
  header('Location: view_users.php');
}
$userId = $user2["userId"];

//get user(membership) details
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT users.*, membership.*, membership.active AS paid, users.active AS activeUser FROM membership LEFT JOIN users ON users.userId = membership.userId WHERE users.token = '$token' UNION SELECT users.*, membership.*, membership.active AS paid, users.active AS activeUser FROM membership RIGHT JOIN users ON users.userId = membership.userId WHERE users.token = '$token'"));

//is an active user?
$activeUser = '<span class="badge badge-danger">Not Active</span>';
if ($user["activeUser"] == 1 && $user["superActive"] == 1) {
  $activeUser = '<span class="badge badge-success">Active</span>';
} elseif ($user["activeUser"] == 0 && $user["superActive"] == 0) {
  $activeUser = '<span class="badge badge-danger">Account Deleted</span>';
}

//is member?
$memberStatus = 'NOT A MEMBER';
$memberState = false;
$paidBadge = '';
$profilePicPath = '../images/placeholders/profile.jpg';
$memberTypePath = '../images/placeholders/not2.png';
if (!empty($user["memberType"])) {
  $memberStatus = $user["memberType"] . ' Member';
  $profilePicPath = $user["path"];
  $memberState = true;

  //is paid up member?
  $paidBadge = '<span class="badge badge-danger">Not Paid</span>';
  if ($user["paid"] == 1) {
    $paidBadge = '<span class="badge badge-success">Paid</span>';
  }

  //get membership Img
  $getMemberType = $user["memberType"];
  $membershipConfigResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT path FROM membershipConfig WHERE memberType LIKE '$getMemberType'"));
  if (!empty($membershipConfigResult["path"])) {
    $memberTypePath = $membershipConfigResult["path"];
  }
}

//get signup date
$signup_date = new DateTime($user["signup_date"]);
$signup_date = $signup_date->format('d-m-Y | h:m A');

include_once 'admin_partials/header.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <?php echo $breadcrumb; ?>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <!-- Widget: user widget style 1 -->
          <div class="card card-widget widget-user bg-light" style="min-height: 400px">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
              <h5 class="widget-user-desc">ACCOUNT DETAILS</h5>
              <h3 class="widget-user-username"><?php echo $user["firstName"] . ' ' . $user["lastName"]; ?></h3>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2 profileSize100" src="<?php echo "../" . getFilePath('profile_pic', $user["memId"], $conn)[0]; ?>" alt="profile pic">
            </div>
            <div class="card-footer bg-light">
              <div class="row">
                <div class="col-sm-12">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $user["email"]; ?></h5>
                    <span class="description-text">Email Address</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $activeUser; ?></h5>
                    <span class="description-text">Account Status</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $signup_date; ?></h5>
                    <span class="description-text">Account Created</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        <div class="col-md-6">
          <!-- Widget: user widget style 2 -->
          <div class="card card-widget widget-user-2 bg-light" style="min-height: 400px">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-dark">
              <div class="widget-user-image">
                <img class="img-circle elevation-2" style="max-height: 100px; max-width: 100px;" src="<?php echo $memberTypePath; ?>" alt="Image">
              </div>
              <!-- /.widget-user-image -->
              <h5 class="widget-user-desc">MEMBERSHIP DETAILS</h5>
              <p class="widget-user-username"><?php echo $memberStatus; ?></p>
              <h5 class="widget-user-desc"><?php echo $paidBadge; ?></h5>
            </div>
            <div class="card-footer p-0 bg-light">
              <ul class="nav flex-column">
                <?php if ($memberState) { ?>
                  <li class="nav-item">
                    <a class="nav-link">
                      Contact: <span class="float-right badge bg-light font-medium"><?php echo $user["contact"]; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Gender: <span class="float-right badge bg-light font-medium"><?php echo $user["gender"]; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      NRC Number: <span class="float-right badge bg-light font-medium formatNRC"><?php echo $user["nrc"]; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Country: <span class="float-right badge bg-light font-medium"><?php echo $user["country"]; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Town: <span class="float-right badge bg-light font-medium"><?php echo $user["town"]; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link m-0 p-0">
                      <p class="font-medium m-2 text-center">
                        <a class="bold">Address:</a>
                        <?php echo $user["address"]; ?>
                      </p>
                    </a>
                  </li>
                <?php } else {
                  if ($user["activeUser"] == 1 && $user["superActive"] == 1) {
                    echo '<a href="../db/add_membership_setUser.php?user=' . $user["token"] . '" class="m-3 btn btn-light bg-dark">CLICK TO REGISTER</a>';
                  }
                } ?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
      </div>










      <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
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
                  <table id="example22" class="table table-bordered table-hover table-striped">
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
                          if ($result["itemType"] == 'product') {
                            $itemType = '<span class="badge badge-warning">' . $result["itemType"] . '</span>';
                          }
                          $dt = new DateTime($result["payDate"]);
                          $newDate = $dt->format('d-m-Y | h:m A');

                          $fileType = '';
                          if ($result["itemType"] == 'product') {
                            $fileType = 'product';
                          } elseif ($result["itemType"] == 'membership') {
                            $fileType = 'membershipType';
                          }
                          $imgs = '<img width=\'100px\' height=\'100px\' src=\' ../' . getFilePath($fileType, $result["itemId"], $conn)[0] . ' \'>';
                          echo '<tr>
                                  <td>' . $count . '.</td>
                                  <td style = "text-transform:capitalize;" class="hand hover-black-green" data-toggle="tooltip" data-html="true" title="' . $imgs . '">' . $result["name"] . '</td>
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
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>
<script>
  $(document).ready(function() {
    //view payment's purchased items
    $(document).on("click", ".viewPaidItemsBtn", function() {
      let ref = $(this).val();
      $('.nav-item a[href="#purchaseDetails"]').tab('show');
      $('input[aria-controls="example22"]').addClass('auto-focus-border');
      // setTimeout(function() {
      //   $('input[aria-controls="example22"]').removeClass('auto-focus-border');
      // }, 5000);
      $("#example22").dataTable().fnFilter(ref)
    });
  });
</script>