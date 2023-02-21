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
          <h1>Products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Products</li>
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
                <!-- <li class="nav-item"><a class="nav-link active" href="#ePaymentDetails" data-toggle="tab">Products</a></li> -->
                <a href="uploadProduct.php" class="quickLinks p-2 btn btn-primary btn-sm border-1 border-white ml-3">New Product</a>
                <a href="../shop-grid.php" class="quickLinks p-2 btn btn-primary btn-sm border-1 border-white ml-3" data-toggle="tooltip" title="View Products On User's Page">View Products</a>
                <a href="add_category.php" class="quickLinks p-2 btn btn-primary btn-sm border-1 border-white ml-3">Manage Categories</a>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">

                <div class="tab-pane active" id="ePaymentDetails">
                  <table id="example1" class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Old Price</th>
                        <th>Status</th>
                        <th>Availability</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $data = mysqli_query($conn, "SELECT * FROM products ORDER BY uploadDate DESC");
                      if (mysqli_num_rows($data) != 0) {
                        $count = 0;
                        while ($result = mysqli_fetch_assoc($data)) {
                          $count++;

                          $status = '<span class="badge badge-danger">Unavailable</span>';
                          $availability = '<button class="btn btn-sm btn-success availableProductBtn" value="' . $result["prodId"] . '" data-toggle="tooltip" title="Mark As Available">Enable</button>';
                          if ($result["active"] == 1) {
                            $status = '<span class="badge badge-success">Available</span>';
                            $availability = '<button class="btn btn-sm btn-danger availableProductBtn" value="' . $result["prodId"] . '" data-toggle="tooltip" title="Mark As Unavailable">Disable</button>';
                          }

                          $category = $result["category"];
                          $data0 = mysqli_query($conn, "SELECT active FROM productCategoryConfig WHERE categoryName LIKE '$category'");
                          if (mysqli_num_rows($data0) == 1) {
                            $result0 = mysqli_fetch_assoc($data0);
                            if ($result0["active"] == 0) {
                              $status = '<span class="badge badge-danger">Category Offline</span>';
                              $availability = '<button disabled data-toggle="tooltip" title="Products Category Is Currently Unavailable" class="btn btn-sm btn-success">Enable</button>';
                            }
                          }

                          $oldPrice = 'K ' . $result["oldPrice"];
                          if ($result["oldPrice"] == 0) {
                            $oldPrice = 'Non';
                          }

                          //get product images to display in tooltip
                          $imgs = '';
                          foreach (getFilePath('product', $result["prodId"], $conn) as $path) {
                            $imgs .= '<img width=\'100px\' height=\'100px\' src=\' ../' . $path . ' \'>';
                          }

                          $dt = new DateTime($result["uploadDate"]);
                          $newDate = $dt->format('d-m-Y | h:m A');
                          echo '<tr class="deleteProductRow' . $result["prodId"] . '">
                                  <td>' . $count . '.</td>
                                  <td class="hand hover-black-green" data-toggle="tooltip" data-html="true" title="' . $imgs . '">' . $result["name"] . '</td>
                                  <td title="' . $result["description"] . '">' . substr($result["description"], 0, 20) . '...</td>
                                  <td>' . $result["quantity"] . '</td>
                                  <td>' . $result["category"] . '</td>
                                  <td>K ' . $result["price"] . '</td>
                                  <td class="text-danger">' . $oldPrice . '</td>
                                  <td class="productBadgeCover' . $result["prodId"] . '">' . $status . '</td>
                                  <td class="availabilityBtnCover' . $result["prodId"] . '">' . $availability . '</td>
                                  <td>
                                    <button class="btn btn-sm btn-info editProductBtn comingSoon"  data-toggle="tooltip" title="Edit Product">Edit</button>
                                  </td>
                                  <td>
                                    <button data-toggle="tooltip" title="Delete Product" value="' . $result["prodId"] . '" class="btn btn-sm btn-danger deleteProductBtn">Delete</button>
                                  </td>
                                </tr>';
                        }
                      }
                      ?>
                    </tbody>

                    <tfoot>
                      <th>No.</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Old Price</th>
                      <th>Status</th>
                      <th>Availability</th>
                      <th>Edit</th>
                      <th>Delete</th>
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