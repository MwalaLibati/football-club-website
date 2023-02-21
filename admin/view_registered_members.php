<?php
include_once 'admin_partials/header.php';
include_once 'dbStatsCount.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>MEMBERSHIP </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Members</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">


          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title bold">
                REGISTERED MEMBERS
                <a href="view_users.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Register New Member</a>
                <a href="add_membership_type.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Membership Types</a>
              </h3>
            </div>


            <div class="card card-light shadow-md m-3">
              <div class="card-header">
                <h3 class="card-title">Total Members (<?php echo $membershipCount; ?>)</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool pl-5 pr-5" data-card-widget="collapse">
                    <i class="fas fa-minus text-primary"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group">
                  <?php echo $memberUI; ?>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Membership</th>
                    <th>Status</th>
                    <th>Activate</th>
                    <th>Ref. No</th>
                    <th>Date Applied</th>
                    <th>Edit</th>
                    <th>Profile</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $data = mysqli_query($conn, "SELECT users.*, membership.*, membership.active AS paid FROM membership INNER JOIN users ON users.userId = membership.userId;");
                  if (mysqli_num_rows($data) != 0) {
                    $count = 0;
                    while ($result = mysqli_fetch_assoc($data)) {
                      $count++;
                      $paidBadge = '<span class="badge badge-danger">Not Paid</span>';

                      //get memberType price
                      $memberType = $result["memberType"];
                      $data2 = mysqli_query($conn, "SELECT price FROM membershipConfig WHERE memberType = '$memberType'");
                      $membershipConfig = mysqli_fetch_assoc($data2);
                      $price = $membershipConfig['price'];

                      $activateMembershipAdminBtn = '<button data-toggle="tooltip" title="Activate membership only after user makes payment of K' . $price . '" class="btn btn-sm btn-primary m-0 activateMembershipAdminBtn" value="' . $result["token"] . '">Activate</button>';
                      if ($result["paid"] == 1) {
                        $paidBadge = '<span class="badge badge-success">Paid</span>';
                        $activateMembershipAdminBtn = '<button class="btn btn-sm btn-success m-0" disabled>Active</button>';
                      }

                      $editMember = '<a href="../db/add_membership_setUser.php?user=' . $result["token"] . '" type="button" data-toggle="tooltip" title="Edit Membership" class="btn btn-primary btn-sm">Edit</a>';


                      $dt = new DateTime($result["applyDate"]);
                      $newDate = $dt->format('d-m-Y | h:m A');
                      $memberTypeImg = '<img src="../membershipForms/images/' . $result["memberType"] . '.jpg" class="mr-2" width="20" height="20">';
                      $memberTypeImg = '';
                      echo '<tr>
                              <td>' . $count . '.</td>
                              <td>' . $result["firstName"] . ' ' . $result["lastName"] . '</td>
                              <td>' . $result["gender"] . '</td>
                              <td>' . $memberTypeImg . $result["memberType"] . '</td>
                              <td class="paidBadgeRow' . $result["token"] . '">' . $paidBadge . '</td>
                              <td class="activateMembershipAdminBtnRow' . $result["token"] . '">' . $activateMembershipAdminBtn . '</td>
                              <td>' . $result["membNo"] . '</td>
                              <td>' . $newDate . '</td>
                              <td>' . $editMember . '</td>
                              <td>
                                <button class="btn btn-sm btn-primary m-0 viewProfileAdminBtn" data-from="membership" value="' . $result["token"] . '">View</button>
                              </td>
                            </tr>';
                    }
                  }
                  ?>
                </tbody>

                <tfoot>
                  <th>No.</th>
                  <th>Full Name</th>
                  <th>Gender</th>
                  <th>Membership</th>
                  <th>Status</th>
                  <th>Activate</th>
                  <th>Ref. No</th>
                  <th>Date Applied</th>
                  <th>Edit</th>
                  <th>Profile</th>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>



        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>