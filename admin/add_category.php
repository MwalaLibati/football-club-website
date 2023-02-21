<?php include_once 'admin_partials/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ADD CATEGORY</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Category</li>
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
                ONLINE STORE
                <a href="view_products.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Manage Products</a>
                <a href="uploadProduct.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Upload Products</a>
              </h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form method="POST" id="categoryUploadForm" class="col-md-12">
              <div class="categoryUploadMsg alert alert-light p-3 m-4" role="alert"></div>
              <div class="card-body">
                <label for="categoryName" class="label-color">NEW CATEGORY</label>
                <div class="form-group">

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <a class="text-dark" data-toggle="tooltip" title="Upload New Product" href="uploadProduct.php">
                          <i class="fas fa-plus text-gray"></i>
                          New Product
                        </a>
                      </span>
                    </div>
                    <input type="text" name="categoryName" class="form-control" placeholder="Enter New Category Name" autofocus>
                  </div>

                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div>
                  <input type="submit" value="Save" class="submitBtncategoryUpload btn btn-block btn-lg btn-primary" />
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
                MANAGE CATEGORIES
                <!--(<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM productCategoryConfig")); ?>)-->
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 400px;">
              <table class="table table-hover table-head-fixed text-nowrap controlTable">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>No. of Products</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $data = mysqli_query($conn, "SELECT * FROM productCategoryConfig");
                  $count = 0;
                  while ($result = mysqli_fetch_assoc($data)) {
                    if (mysqli_num_rows($data) !== 0) {
                      $count++;

                      //products per category
                      $categoryName = $result["categoryName"];
                      $productCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products WHERE category LIKE '$categoryName'"));
                      $emptyBtn = '';
                      if ($productCount == 0) {
                        $emptyBtn = '<button class="btn btn-sm btn-dark categoryControlBtn mr-1" disabled value="' . $result["id"] . '_empty" data-toggle="tooltip" title="Delete All Products In This Category But Keep Category">Empty</button>';
                      } else {
                        $emptyBtn = '<button class="btn btn-sm btn-dark categoryControlBtn mr-1" value="' . $result["id"] . '_empty" data-toggle="tooltip" title="Delete All Products In This Category But Keep Category">Empty</button>';
                      }

                      //if on/offline
                      if ($result["active"] == 1) {
                        $status = '<span class="text-success bold">Online</span>';
                        $enableDisableBtn = '<button class="btn btn-sm btn-light categoryControlBtn mr-1" value="' . $result["id"] . '_disable" data-toggle="tooltip" title="Disable And Hide All Category Products From Users">Disable</button>';
                      } else {
                        $status = '<span class="text-danger bold">Offline</span>';
                        $enableDisableBtn = '<button class="btn btn-sm btn-success categoryControlBtn mr-1" value="' . $result["id"] . '_enable" data-toggle="tooltip" title="Enable Category And Make It Visible to all Users">Enable</button>';
                      }

                      echo '<tr class="row' . $result["id"] . '">
                          <td>' . $count . '.</td>
                          <td><input data-id="' . $result["id"] . '" type="text" name="categoryNameEditField" data-toggle="tooltip" title="Edit" value="' . $categoryName . '" class="form-control m-0 text-center controlInputFields"></td>
                          <td class="productCount' . $result["id"] . '">' . $productCount . '</td>
                          <td class="categoryStatus' . $result["id"] . '">' . $status . '</td>
                          <td>
                            ' . $enableDisableBtn . '
                            ' . $emptyBtn . '
                            <button class="btn btn-sm btn-danger categoryControlBtn mr-1" value="' . $result["id"] . '_delete" data-toggle="tooltip" title="Delete Category & All Products In This Category">Delete</button>
                          </td>
                        </tr>';
                    } else {
                      echo '<tr>
                              <h3>No Categories</h3>
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

<?php include_once 'admin_partials/footer.php'; ?>