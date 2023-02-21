<?php
include_once 'admin_partials/header.php';
include_once 'dbStatsCount.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">


        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info" data-toggle="tooltip" data-html="true" title="<?php echo $userIndexUI; ?>">
            <div class="inner">
              <h3><?php echo $userCount; ?></h3>
              <p>Users</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <a href="view_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-dark" data-toggle="tooltip" data-html="true" title="<?php echo $memberIndexUI; ?>">
            <div class="inner">
              <h3><?php echo $membershipCount; ?></h3>
              <p>Registered Members</p>
            </div>
            <div class="icon">
              <i class="fas fa-address-card"></i>
            </div>
            <a href="view_registered_members.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $productsCount; ?></h3>
              <p>Products</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="view_products.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>Payments</h3>
              <p class="text-primary">.</p>
            </div>
            <div class="icon">
              <i class="fas fa-credit-card"></i>
            </div>
            <a href="view_payments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>File Manager</h3>
              <p class="text-info">.</p>
            </div>
            <div class="icon">
              <i class="fas fa-copy"></i>
            </div>
            <a href="fileManger.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-dark">
            <div class="inner">
              <h3><?php echo $inboxCount; ?><i class="text-dark">.</i></h3>
              <p class="text-white">New (Inbox)</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope-open-text"></i>
            </div>
            <a href="inbox.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


      </div>
      <!-- /.row -->
      <!-- Main row -->

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<?php include_once 'admin_partials/footer.php'; ?>