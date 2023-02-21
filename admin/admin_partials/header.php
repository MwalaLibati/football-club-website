<?php
include_once '../db/connect.php';
include_once '../db/fileUploadManager.php';
if (!isset($_COOKIE["boss"])) {
  header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Mufulira Wanderers FC</title>

  <link rel="shortcut icon" type="image/x-icon" href="../images/mwfc_images/logos/logo1.png" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="../css/style1.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Admin Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="../index.php" class="nav-link">User Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="../db/logout.php" class="nav-link">Log Out</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form> -->

      <!-- Right navbar links -->
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link mt-3 mb-3 pb-4">
        <img src="../images/mwfc_images/logos/logo1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ADMIN</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../images/mwfc_images/logos/logo1.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a class="text-white" class="d-block">Hello Boss</a>
          </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="index.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
              <!-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Edit Pages
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right">6</span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Home Page</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>League Table</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fixtures</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Players</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>News <small>+ Custom Area</small></p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contact us</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fixed Footer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Collapsed Sidebar</p>
                  </a>
                </li>
              </ul>
            </li> -->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-address-card"></i>
                <p>
                  Membership
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="view_users.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add New Member</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="view_registered_members.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Members</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="add_membership_type.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Membership Types</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                  Users
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="view_users.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="add_user.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Register User</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Manage Store
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="view_products.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="uploadProduct.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add New Product</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="add_category.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Categories</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="view_payments.php" class="nav-link">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>
                  Payments
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="fileManger.php" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  File Manager
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="inbox.php" class="nav-link">
                <i class="nav-icon fas fa-envelope-open-text"></i>
                <p>
                  Inbox
                  <span class="badge badge-info right">
                    <?php
                    $data = mysqli_query($conn, "SELECT contactId FROM contactus WHERE markRead = 0");
                    $inboxCount = mysqli_num_rows($data);
                    if (!isset($inboxCount) || empty($inboxCount)) {
                      $inboxCount = 0;
                    }
                    echo $inboxCount;
                    ?>
                  </span>
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-image"></i>
                <p>
                  Banners
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="homePageBanners.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Homepage</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div id="toastsContainerTopLeft" class="toasts-top-left fixed hide toast2">
      <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"><strong class="mr-auto">INFO</strong>
          <button data-dismiss="toast" type="button" class="ml-2 mb-1 close toast-close" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="toast-body"></div>
      </div>
    </div>