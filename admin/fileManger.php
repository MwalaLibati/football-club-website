<?php

include_once 'admin_partials/header.php';
include_once '../db/countOldImages_db.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>File Manager</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">File Manager</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- <?php var_dump($imagesToDelete); ?> -->
      <!-- <?php var_dump($pathsToDelete); ?> -->

      <div class="row">

        <div class="col-md-4 col-sm-6 col-12">
          <div class="info-box"><a href="fileManger.php" data-toggle="tooltip" title="Refresh" class="fas fa-redo productBadge text-dark p-2"></a>
            <a class="info-box-icon"><i class="fas fa-image"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Unused Images</span>
              <span class="info-box-number"><?php echo sizeof($imagesToDelete); ?></span>
            </div>
            <a class="info-box-icon"><i class="fas fa-stream"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Unused Paths</span>
              <span class="info-box-number"><?php echo sizeof($pathsToDelete); ?></span>
            </div>
          </div>
          <a href="../db/deleteOldImages_db.php" data-toggle="tooltip" title="Delete old images & paths" class="btn btn-danger btn-block text-white">Clean Up</a>
        </div>

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>