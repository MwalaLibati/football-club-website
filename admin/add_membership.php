<?php

if (!isset($_COOKIE["userTempToken"])) {
  header('Location: view_users.php?');
}
include_once 'admin_partials/header.php';
$token = $_COOKIE["userTempToken"];
$isMembership = $memberType = "";
$data = mysqli_query($conn, "SELECT * FROM users WHERE token='$token' AND active = 1");
if (mysqli_num_rows($data) == 1) {
  $user = mysqli_fetch_assoc($data);
  $userId = $user["userId"];

  $data = mysqli_query($conn, "SELECT memId, memberType FROM membership WHERE userId = $userId");
  if (mysqli_num_rows($data) == 1) {
    $membership = mysqli_fetch_assoc($data);
    $memberType = $membership["memberType"];
  } elseif (mysqli_num_rows($data) == 0) {
    $isMembership = "required";
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>REGISTER NEW MEMBER</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="view_users.php">Users</a></li>
            <li class="breadcrumb-item active">Add Member</li>
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
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title bold">
                ADD MEMBER
                <a href="view_registered_members.php" class="quickLinks btn btn-sm border-1 border-white ml-3">View Members</a>
                <a href="add_membership_type.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Membership Types</a>
              </h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form class="col-md-6 mt-3 membershipAdminForm" enctype="multipart/form-data">

              <div class="card-body">
                <div class="form-group">

                  <label class="label-color">SELECT MEMBERSHIP</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <a class="text-dark" data-toggle="tooltip" title="Add New Membership Type" href="add_membership_type.php">
                          <i class="fas fa-plus text-gray"></i>
                          Add
                        </a>
                      </span>
                    </div>
                    <select class="form-control" name="memberType">
                      <option>- Select Membership-</option>
                      <?php
                      if ($query_run = mysqli_query($conn, "SELECT memberType FROM membershipConfig WHERE active=1")) {
                        if (mysqli_num_rows($query_run) != 0) {
                          while ($query_row = mysqli_fetch_assoc($query_run)) {
                            if ($memberType == $query_row["memberType"]) {
                              echo '<option selected value="' . $query_row["memberType"] . '">' . $query_row["memberType"] . '</option>';
                            } else {
                              echo '<option value="' . $query_row["memberType"] . '">' . $query_row["memberType"] . '</option>';
                            }
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label-color" for="name">FIRST NAME</label>
                  <input type="text" name="firstName" class="form-control bg-light" title="Cannot be edited" value="<?php echo $user["firstName"]; ?>" disabled>
                </div>
                <div class="form-group">
                  <label class="label-color" for="name">LAST NAME</label>
                  <input type="text" name="lastName" class="form-control bg-light" title="Cannot be edited" value="<?php echo $user["lastName"]; ?>" disabled>
                </div>
                <div class="form-group">
                  <label class="label-color">EMAIL</label>
                  <input type="email" name="email" class="form-control bg-light" title="Cannot be edited" value="<?php echo $user["email"]; ?>" disabled>
                </div>
                <div class="form-group">
                  <label class="label-color" for="path">PROFILE PICTURE | <i class="font-small">Allowed Formats: (.jpg / .png)</i></label>
                  <input type="file" name="file[]" data-toggle="tooltip" title="Max Size: 5MB." class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                  <label class="label-color">NRC</label>
                  <input type="text" name="nrc" class="form-control formatNRC" value="<?php echo $user["nrc"]; ?>" placeholder="National Registration Card Number">
                </div>
                <div class="form-group">
                  <label class="label-color">GENDER</label>
                  <select class="form-control" name="gender">
                    <option>- Select -</option>
                    <option <?php if ($user["gender"] == 'Male') {
                              echo 'selected';
                            } ?> value="Male">Male</option>
                    <option <?php if ($user["gender"] == 'Female') {
                              echo 'selected';
                            } ?> value="Female">Female</option>
                    <option <?php if ($user["gender"] == 'Other') {
                              echo 'selected';
                            } ?> value="Other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="label-color">Phone Number</label>
                  <input type="text" name="contact" class="form-control" value="<?php echo $user["contact"]; ?>" placeholder="Eg. 09/07...">
                </div>
                <div class="form-group">
                  <label class="label-color">COUNTRY</label>
                  <select class="form-control" name="country">
                    <?php
                    include_once '../membershipForms/countriesList.php';
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="label-color">TOWN</label>
                  <input type="text" name="town" class="form-control" value="<?php echo $user["town"]; ?>" placeholder="Town">
                </div>
                <div class="form-group">
                  <label class="label-color" for="price">ADDRESS</label>
                  <textarea name="address" class="form-control" placeholder="Enter physical address"><?php echo $user["address"]; ?></textarea>
                </div>
              </div>
              <input type="hidden" name="isMembership" value="<?php echo $isMembership; ?>">
              <input type="hidden" name="userId" value="<?php echo $userId; ?>">
              <input type="hidden" name="email" value="<?php echo $user["email"]; ?>">
              <!-- /.card-body -->
              <div class="card-footer">
                <div align="center">
                  <button type="submit" class="btn btn-lg btn-primary m-1 adminAddMemberSubmitBtn btn-block">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<?php include_once 'admin_partials/footer.php'; ?>