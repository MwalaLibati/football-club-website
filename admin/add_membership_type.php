<?php
include_once '../db/membershipTypeUpload_db.php';
include_once 'admin_partials/header.php';
include_once '../db/fileUploadManager.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>MEMBERSHIP TYPES</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Membership Type</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title bold">
                NEW MEMBERSHIP TYPE
                <a href="view_registered_members.php" class="quickLinks btn btn-sm border-1 border-white ml-3">View Members</a>
                <a href="add_membership.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Register Member</a>
              </h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form method="POST" class="col-md-12" id="createMemberTypeForm" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

              <!-- <?php include_once 'admin_partials/URL_msg.php'; ?> -->
              <?php
              if (isset($_GET["msg"])) {

                if ($_GET["type"] == 'success') {
                  $class = 'success';
                  $icon = '<h5><i class="icon fas fa-check"></i> Success!</h5>';
                } elseif ($_GET["type"] == 'error') {
                  $class = 'danger';
                  $icon = '<h5><i class="icon fas fa-ban"></i> Error!</h5>';
                } elseif ($_GET["type"] == 'neutral') {
                  $class = 'info';
                  $icon = '<h5><i class="icon fas fa-info"></i> Info!</h5>';
                } else {
                  $class = 'info';
                  $icon = '<h5><i class="icon fas fa-info"></i> Info!</h5>';
                }
                echo '<div class="alert alert-' . $class . ' alert-dismissible m-1">
                        <a href="add_membership_type.php" class="close text-decoration-none">&times;</a>
                        ' . $icon . '
                        ' . $_GET["msg"] . '
                      </div>';
              }
              ?>

              <div class="card-body">
                <div class="form-group">
                  <label class="label-color" for="name">MEMBERSHIP NAME</label>
                  <div class="input-group mb-3">
                    <input type="text" name="memberType" class="form-control" value="<?php echo $memberType; ?>" placeholder="Eg: Gold, Silver...">
                    <div class="input-group-append">
                      <span class="input-group-text">Membership</span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="label-color" for="price">SUBSCRIPTION FEE</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">K</span>
                    </div>
                    <input type="number" min="0" step="0.01" name="price" class="form-control" value="<?php echo $price; ?>" placeholder="Enter Amount">
                    <div class="input-group-prepend" data-toggle="tooltip" title="Select (None) If Duration Not Required">
                      <select name="monthDuration">
                        <option value="">- Select Duration -</option>
                        <option <?php if ($monthDuration == '0') {
                                  echo 'selected';
                                } ?> value="0">None</option>
                        <option <?php if ($monthDuration == '1') {
                                  echo 'selected';
                                } ?> value="1">Per Month</option>
                        <option <?php if ($monthDuration == '3') {
                                  echo 'selected';
                                } ?> value="3">Per 3 Months</option>
                        <option <?php if ($monthDuration == '6') {
                                  echo 'selected';
                                } ?> value="6">Per 6 Months</option>
                        <option <?php if ($monthDuration == '12') {
                                  echo 'selected';
                                } ?> value="12">Per Year</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="label-color">ATTACH IMAGE | <i class="font-small">Allowed Formats: (.jpg / .png)</i></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file[]" data-toggle="tooltip" title="Max Size: 5MB" class="custom-file-input" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div>
                  <input type="submit" value="SAVE" class="btn btn-block btn-lg btn-primary" />
                </div>
              </div>
            </form>

          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title bold">
                MANAGE MEMBERSHIP TYPES
                <!--(<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM membershipConfig")); ?>)-->
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 400px;">
              <table class="table table-hover table-head-fixed text-nowrap controlTable">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Fee</th>
                    <th>Members</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $count = 0;
                  $data = mysqli_query($conn, "SELECT * FROM membershipConfig");
                  while ($result = mysqli_fetch_assoc($data)) {
                    if (mysqli_num_rows($data) !== 0) {
                      $count++;

                      if ($result["active"] == 1) {
                        $memberTypeActiveBtn = '<button data-toggle="tooltip" title="Users will NOT be able to apply for this membership" class="btn btn-sm btn-light memberTypeDeactivateBtn" value="' . $result["id"] . '">Deactivate</button>';
                        $status = '<span class="badge badge-success">Active</span>';
                      } else {
                        $memberTypeActiveBtn = '<button class="btn btn-sm btn-light memberTypeActivateBtn" data-toggle="tooltip" title="Users will be able to apply for this membership" value="' . $result["id"] . '">Activate</button>';
                        $status = '<span class="badge badge-danger">Not Active</span>';
                      }
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

                      $getMemberType = $result["memberType"];
                      $data1 = mysqli_query($conn, "SELECT memId FROM membership WHERE memberType LIKE '$getMemberType'");
                      $memberCount = mysqli_num_rows($data1);
                      echo '<tr class="memberTypeRow' . $result["id"] . '">
                              <td>' . $count . '.</td>
                              <td class="hand hover-black-green" data-toggle="tooltip"  data-html="true" title="<img width=\'100px\' height=\'100px\' src=\' ../' . getFilePath('membershipType', $result["id"], $conn)[0] . ' \'>">' . $result["memberType"] . '</td>
                              <td>K ' . $result["price"] . '' . $DisplayMonthDuration . '</td>
                              <td>' . $memberCount . '</td>
                              <td class="memberTypeStatus' . $result["id"] . '">' . $status . '</td>
                              <td>
                                ' . $memberTypeActiveBtn . '
                                <button data-toggle="modal" data-target="#memberTypeEditModal" class="btn btn-sm btn-info memberTypeEditBtn" value="' . $result["id"] . '___' . $result["memberType"] . '___' . $result["price"] . '___' . $result["monthDuration"] . '" data-toggle="tooltip">Edit</button>
                                <button class="btn btn-sm btn-danger memberTypeDeleteBtn" data-toggle="tooltip" title="Membership will no longer exist" value="' . $result["id"] . '">Delete</button>
                              </td>
                            </tr>';
                    } else {
                      echo '<tr>
                              <h3>No Membership Types</h3>
                            </tr>';
                    }
                  }
                  ?>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>






        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- MODEL-EDIT MEMBERSHIP -->
<div class="modal fade" id="memberTypeEditModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title membershipEditText"></h4>
        <button type="button" class="close cancelEditMemberType">×</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!-- form start -->
        <form method="POST" class="col-md-12" id="editMemberTypeForm" enctype="multipart/form-data" action="../db/editMemberType_db.php">

          <div class="card-body">
            <div class="form-group">
              <label class="label-color" for="name">MEMBERSHIP NAME</label>
              <div class="input-group mb-3">
                <input type="text" name="memberType" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text bg-white">Membership</span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="label-color" for="price">SUBSCRIPTION FEE</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">K</span>
                </div>
                <input type="number" min="0" step="0.01" name="price" class="form-control" placeholder="Enter Amount">
                <div class="input-group-prepend" data-toggle="tooltip" title="Select (None) If Duration Not Required">
                  <select name="monthDuration">
                    <option value="">- Select Duration -</option>
                    <option value="0">None</option>
                    <option value="1">Per Month</option>
                    <option value="3">Per 3 Months</option>
                    <option value="6">Per 6 Months</option>
                    <option value="12">Per Year</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="label-color">ATTACH IMAGE | <i class="font-small">Allowed Formats: (.jpg / .png)</i></label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="file[]" data-toggle="tooltip" title="Max Size: 5MB" class="custom-file-input" accept="image/*">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
              </div>
            </div>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <div>
              <input type="hidden" name="id" />
              <input type="hidden" name="memberTypeOld" />
              <input type="submit" value="EDIT" class="btn btn-block btn-lg btn-primary" />
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php include_once 'admin_partials/footer.php'; ?>