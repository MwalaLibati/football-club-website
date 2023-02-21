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
          <h1>Home Page Banners</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Home Page Banners</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="images p-3">
            <div class="text-center">
              <span class="productBadge" data-toggle="tooltip" title="Edit This Banner">
                <button disabled class="fas fa-edit text-dark btn btn-light border-darkish-1 productBadge editBannerBtn"></button>
              </span>
              <button data-toggle="tooltip" data-src="" disabled title="Are you sure you want to delete this banner" class="text-danger btn btn-light border-1 border-danger deleteBannerBtn"><i class="fas fa-trash"></i></button>
              <div class="overlayText p-2">
                <h2 class="overlay_description1">Main Heading</h2>
                <p class="overlay_description2">Sub Heading...</p>
              </div>
              <img id="main-image" name="mainImage" class="p-4 border-darkish-1" src="../images/placeholders/placeholder.png" style="width: 100%; height: 500px;" />
            </div>

            <div class="thumbnail text-center">
              <button data-toggle="tooltip" title="Upload New Banner" style="width: 50px; height: 50px;" class="round uploadBannerBtn m-1 p-1 btn btn-light border-darkish-1"><i class="fas fa-plus text-gray"></i></button>
              <?php
              $data = mysqli_query($conn, "SELECT * FROM banners WHERE bannertype LIKE 'homePageBanner' ORDER BY priority");
              if (mysqli_num_rows($data) != 0) {
                while ($bannerResult = mysqli_fetch_assoc($data)) {
                  echo '<img data-bannerid="' . $bannerResult["bannerId"] . '" data-priority="' . $bannerResult["priority"] . '" data-description1="' . $bannerResult["description1"] . '" data-description2="' . $bannerResult["description2"] . '"  name="thumbnailImg" onclick="change_image(this)" data-src="' . getFilePath('homePageBanner', $bannerResult["bannerId"], $conn)[0] . '" src="../' . getFilePath('homePageBanner', $bannerResult["bannerId"], $conn)[0] . '" style="width: 50px; height: 50px; border: 1px solid #ccc" class="round m-1 p-1 thumbnailImg">';
                } //end while()
              } //end if()
              ?>
              <!-- get values to edit -->
              <input type="hidden" name="bannerId">
              <input type="hidden" name="priority">
              <input type="hidden" name="description1">
              <input type="hidden" name="description2">
            </div>

          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="bannerModel">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close closeBannerModel">×</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!-- form start -->
        <form class="col-md-12" id="bannerModelForm" enctype="multipart/form-data">
          <p class="bannerModelFormMsg text-center"></p>
          <div class="card-body">

            <div class="form-group">
              <label class="label-color">Attach Image | <i class="font-small">Allowed Formats: (.jpg / .png)</i></label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="file[]" data-toggle="tooltip" title="Max Size: 5MB" class="custom-file-input" accept="image/*">
                  <label class="custom-file-label fileLabel" for="exampleInputFile">Choose file</label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="label-color">Priority</label>
              <select class="form-control" name="priority" id="priority" data-toggle="tooltip" title="The order in which the images will display">
                <option>- Select -</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
            </div>

            <div class="form-group">
              <label class="label-color" for="description1">Header</label>
              <textarea name="description1" id="description1" class="form-control" maxlength="40" placeholder="Type here..."></textarea>
            </div>

            <div class="form-group">
              <label class="label-color" for="description2">Sub-Header</label>
              <textarea name="description2" id="description2" class="form-control" maxlength="100" placeholder="Type here..."></textarea>
            </div>

            <input type="hidden" name="type" id="type">
            <input type="hidden" name="bannerId" id="bannerId">

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <input type="submit" value="SAVE" class="btn btn-block btn-lg btn-primary bannerSubmitBtn" />
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<?php include_once 'admin_partials/footer.php'; ?>