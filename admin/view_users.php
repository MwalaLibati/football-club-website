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
          <h1>USERS </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
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
                REGISTERED USERS
                <a href="add_user.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Register New User</a>
              </h3>
            </div>

            <div class="card card-light shadow-md m-3">
              <div class="card-header">
                <h3 class="card-title">Total Users (<?php echo $userCount; ?>)</h3>
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
                  <?php echo $userUI; ?>
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
                    <th>Email</th>
                    <th>Account</th>
                    <th>Signup Date</th>
                    <th>Membership</th>
                    <th>Profile</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $data = mysqli_query($conn, "SELECT users.*, membership.*, membership.active AS paid, users.active AS activeUser FROM membership LEFT JOIN users ON users.userId = membership.userId UNION SELECT users.*, membership.*, membership.active AS paid, users.active AS activeUser FROM membership RIGHT JOIN users ON users.userId = membership.userId;");
                  if (mysqli_num_rows($data) != 0) {
                    $count = 0;
                    while ($result = mysqli_fetch_assoc($data)) {
                      $isMember = '<span class="badge badge-danger">Account Not Active</span>';
                      $count++;
                      $activeUser = '<span class="badge badge-danger">Not Active</span>';
                      if ($result["activeUser"] == 1 && $result["superActive"] == 1) {
                        $activeUser = '<span class="badge badge-success">Active</span>';

                        //if not a member
                        $isMember = '<a href="../db/add_membership_setUser.php?user=' . $result["token"] . '" type="button" class="btn btn-primary btn-sm">Register</a>';
                        if (!empty($result["memberType"])) {
                          $isMember = $result["memberType"];
                          if ($result["paid"] == 1) {
                            $isMember .= ' <span class="badge badge-success">Paid</span>';
                          } else if ($result["paid"] == 0) {
                            $isMember .= ' <span class="badge badge-danger">Not Paid</span>';
                          }
                        }
                      } elseif ($result["activeUser"] == 0 && $result["superActive"] == 0) {
                        $activeUser = '<span class="badge badge-danger">Account Deleted</span>';
                      }
                      $dt = new DateTime($result["signup_date"]);
                      $newDate = $dt->format('d-m-Y | h:m A');
                      $memberTypeImg = '<img src="../membershipForms/images/' . $result["memberType"] . '.jpg" class="mr-2" width="20" height="20">';
                      $memberTypeImg = '';


                      echo '<tr>
                              <td>' . $count . '.</td>
                              <td>' . $result["firstName"] . ' ' . $result["lastName"] . '</td>
                              <td>' . $result["email"] . '</td>
                              <td>' . $activeUser . '</td>
                              <td>' . $newDate . '</td>
                              <td>' . $isMember . '</td>
                              <td>
                                <button class="btn btn-sm btn-primary m-0 viewProfileAdminBtn" data-from="users" value="' . $result["token"] . '">View</button>
                              </td>
                            </tr>';
                    }
                  }
                  ?>
                </tbody>

                <tfoot>
                  <th>No.</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Account</th>
                  <th>Signup Date</th>
                  <th>Membership</th>
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