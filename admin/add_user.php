<?php include_once 'admin_partials/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>REGISTER NEW USER</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Register User</li>
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
              NEW USER
                <a href="view_users.php" class="quickLinks btn btn-sm border-1 border-white ml-3">View Users</a>
               </h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form class="col-md-6 mt-3" data-db="admin" id="signupForm">
            <p class="signupFormMsg p-0 m-0 text-center"></p>
              <div class="card-body">
                               
                <div class="form-group">
                  <label class="label-color" for="name">FIRST NAME</label>
                  <input type="text" name="firstName" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                  <label class="label-color" for="name">LAST NAME</label>
                  <input type="text" name="lastName" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                  <label class="label-color" for="quantity">EMAIL</label>
                  <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                  <label class="label-color" for="quantity">PASSWORD</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                  <label class="label-color" for="quantity">CONFIRM PASSWORD</label>
                  <input type="password" name="confirmPassword" class="form-control" placeholder="Password">
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div align="center">
                  <button type="submit" class="btn btn-lg btn-primary m-1 btn-block">
                    Register
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>

        <!-- <div class="col-md-6">
          <div class="position-relative p-3 bg-primary" style="height: 180px">
            <div class="ribbon-wrapper">
              <div class="ribbon bg-white p-2">
                Products
              </div>
            </div>
            <h4>Products</h4>
            <br>
            <a href="../shop-grid.php"><button class="btn-lg btn btn-light text-primary">View Uploaded Products</button></a>
            <a href="add_category.php"><button class="btn-lg btn btn-light text-primary m-2">Upload Products</button></a>
          </div>
          <br>
          <br>
        </div> -->
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<?php include_once 'admin_partials/footer.php'; ?>