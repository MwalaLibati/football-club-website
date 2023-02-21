<?php

include_once 'admin_partials/header.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Payments</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Payments</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

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
                        <th>Username</th>
                        <th>Ref No.</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Purchases</th>
                        <th>User Profile</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $data = mysqli_query($conn, "SELECT users.*, payments.*, payments.userId AS payUserId, users.userId AS usersUserId FROM payments LEFT JOIN users ON users.userId = payments.userId ORDER BY payDate DESC");
                      if (mysqli_num_rows($data) != 0) {
                        $count = 0;
                        while ($result = mysqli_fetch_assoc($data)) {
                          if ($result["payUserId"] == $result["usersUserId"]) {
                            $count++;
                            $payStatus = '<span class="badge badge-danger">Failed</span>';
                            if ($result["status"] == 1) {
                              $payStatus = '<span class="badge badge-success">Paid</span>';
                            }
                            $dt = new DateTime($result["payDate"]);
                            $newDate = $dt->format('d-m-Y | h:m A');
                            echo '<tr>
                                  <td>' . $count . '.</td>
                                  <td class="hand hover-black-green" data-toggle="tooltip" title="' . $result["email"] . '">' . $result["firstName"] . ' ' . $result["lastName"] . '</td>
                                  <td>' . $result["ref"] . '</td>
                                  <td>K ' . $result["amountPaid"] . '</td>
                                  <td>' . $newDate . '</td>
                                  <td>' . $payStatus . '</td>
                                  <td>
                                    <button value="' . $result["ref"] . '" class="btn btn-sm btn-primary m-0 text-white viewPaidItemsBtn">View</button>
                                  </td>
                                  <td>
                                    <button class="btn btn-sm btn-primary m-0 viewProfileAdminBtn" data-from="users" value="' . $result["token"] . '">Open</button>
                                  </td>
                                </tr>';
                          }
                        }
                      }
                      ?>
                    </tbody>

                    <tfoot>
                      <th>No.</th>
                      <th>Username</th>
                      <th>Ref No.</th>
                      <th>Amount Paid</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Purchases</th>
                      <th>User Profile</th>
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
                      $data = mysqli_query($conn, "SELECT paidForItems.*, payments.* FROM paidForItems LEFT JOIN payments ON paidForItems.payId = payments.payId ORDER BY ref DESC");
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
                          echo '<tr>
                                  <td>' . $count . '.</td>
                                  <td style = "text-transform:capitalize;">' . $result["name"] . '</td>
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