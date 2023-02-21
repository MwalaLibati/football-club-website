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
          <h1>UPLOAD NEW PRODUCT</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">New Product</li>
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
                ONLINE STORE
                <a href="view_products.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Manage Products</a>
                <a href="add_category.php" class="quickLinks btn btn-sm border-1 border-white ml-3">Manage Categories</a>
              </h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form class="col-md-6 mt-3" id="productUploadForm" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">

                  <label class="label-color" for="category">SELECT CATEGORY</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <a class="text-dark" data-toggle="tooltip" title="Add New Category" href="add_category.php">
                          <i class="fas fa-plus text-gray"></i>
                          Add Category
                        </a>
                      </span>
                    </div>
                    <select class="form-control" name="category">
                      <option selected>- Select Category-</option>
                      <?php
                      if ($query_run = mysqli_query($conn, "SELECT * FROM productCategoryConfig WHERE active=1")) {
                        if (mysqli_num_rows($query_run) != 0) {
                          while ($query_row = mysqli_fetch_assoc($query_run)) {
                            echo '<option value="' . $query_row["categoryName"] . '">' . $query_row["categoryName"] . '</option>';
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="label-color" for="name">NAME OF PRODUCT</label>
                  <input type="text" name="name" class="form-control" placeholder="Item Name">
                </div>
                <div class="form-group">
                  <label class="label-color">ATTACH IMAGE | <i class="font-small">Allowed Formats: (.jpg / .png)</i></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file[]" multiple data-toggle="tooltip" title="Max Size: 5MB" class="custom-file-input" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label-color" for="quantity">QUANTITY</label>
                  <input type="number" min="0" name="quantity" class="form-control" placeholder="quantity">
                </div>
                <div class="form-group">
                  <label class="label-color" for="price">DESCRIPTION</label>
                  <textarea name="description" class="form-control" data-toggle="tooltip" title="(Optional) Enter Item Description E.g Size" placeholder="(Optional) Enter Item Description E.g Size"></textarea>
                </div>
                <div class="form-group">
                  <label class="label-color" for="price">PRICE (K)</label>
                  <input type="number" min="0" step="0.01" name="price" class="form-control" placeholder="Price">
                </div>
                <div class="form-group">
                  <label class="label-color" for="oldPrice">OLD PRICE (K)</label>
                  <input type="number" min="0" step="0.01" name="oldPrice" class="form-control" data-toggle="tooltip" title="(Optional) Leave It Empty If Not Needed" placeholder="(Optional) Leave It Empty If Not Needed">
                </div>

                <br>
                <div class="custom-control custom-checkbox">
                  <input name="available" checked class="custom-control-input" id="customCheckbox1" type="checkbox" value="available">
                  <label for="customCheckbox1" data-toggle="tooltip" title="Check The Box If Product Is Available For Purchase Right Now" class="custom-control-label label-color">Product Is available</label>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div align="center">
                  <button type="submit" class="btn btn-lg btn-primary productUploadSubmitBtn m-1 btn-block">
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