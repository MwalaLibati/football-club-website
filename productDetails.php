<?php
include_once 'db/connect.php';

//display a product's details
if (isset($_GET["product"])) {
    $prodId = $_GET["product"];
    $data0 = mysqli_query($conn, "SELECT * FROM products WHERE prodId = '$prodId'");
    if (mysqli_num_rows($data0) == 1) {
        $result = mysqli_fetch_assoc($data0);
    } else {
        header('Location: shop-grid.php');
    }
} else {
    header('Location: shop-grid.php');
}

include_once 'partials/header.php';
?>
<!--// Header //-->

<!--// SubHeader //-->
<div class="ritekhela-subheader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Our Shop</h1>
                <ul class="ritekhela-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Product Details</li>
                </ul>
                <?php
                if (isset($_COOKIE["boss"])) {
                    echo '<ul class="ritekhela-breadcrumb">
                            <li><a class="btn btn-sm border-1 border-white" href="admin/view_products.php">Manage Products</a></li>
                        </ul>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--// SubHeader //-->

<!--// Content //-->
<div class="ritekhela-main-content">

    <div class="container mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    <img id="main-image" src="<?php echo getFilePath('product', $result["prodId"], $conn)[0]; ?>" style="width: 250px; height: 250px;" />
                                </div>
                                <div class="thumbnail text-center">
                                    <?php
                                    foreach (getFilePath('product', $result["prodId"], $conn) as $path) {
                                        echo '<img onclick="change_image(this)" src="' . $path . '" style="width: 50px; height: 50px; border: 1px solid #ccc" class="round m-1 p-1">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="productDetailCover p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="d-flex align-items-center">
                                        Product Details
                                    </h4>
                                    <a href="shop-grid.php<?php if (isset($_GET["category"])) {
                                                                echo "?category=" . $_GET["category"];
                                                            } ?>" class="d-flex align-items-center text-right btn btn-sm btn-dark text-white font-small">
                                        <i class="fa fa-arrow-left"></i>
                                        <span class="ml-1">Back</span>
                                    </a>
                                </div>
                                <div class="mt-4 mb-3"> <span class="text-uppercase text-muted brand"><?php echo $result["category"]; ?></span>
                                    <h5 class="text-uppercase mb-3"><?php echo $result["name"]; ?></h5>
                                    <div class="price d-flex flex-row align-items-center">
                                        <span class="text-success act-price font-medium">K<span class="newPrice"><?php echo $result["price"]; ?></span></span>
                                        <div class="ml-2">
                                            <?php
                                            $oldPrice = '';
                                            if ($result["oldPrice"] != 0) {
                                                $oldPrice = 'K' . $result["oldPrice"];
                                            }
                                            ?>
                                            <del class="pr-3 font-x-small" title="Old Price"><?php echo $oldPrice; ?></del>
                                        </div>
                                        <div class="block" title="Cost percentage off">
                                            <?php
                                            if ($result["oldPrice"] != 0 && $result["oldPrice"] > $result["price"]) {
                                                $percentOff = round(($result["price"] / $result["oldPrice"]) * 100, 1);
                                                echo $percentOff . "% OFF";
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php if (isset($_COOKIE["userId"])) { ?>
                                        <div class="block mt-3">
                                            <label class="inline" title="Currently in stock">In stock: </label>
                                            <input class="minicart-quantity-product p-1 m-0" data-originalprice="<?php echo $result["price"]; ?>" title="Enter Quantity (Max = <?php echo $result["quantity"]; ?>)" min="1" max="<?php echo $result["quantity"]; ?>" data-minicart-idx="0" type="number" value="1" autocomplete="off">
                                        </div>
                                    <?php } else { ?>
                                        <div class="block mt-3">
                                            <label class="inline" title="Currently in stock">In stock: </label><?php echo $result["quantity"]; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <p class="about height-100"><?php echo substr($result["description"], 0, 200); ?></p>

                                <div class="cart mt-4 align-items-center">
                                    <?php
                                    //collect cart details
                                    $productCartDetails =  $result["name"] . '_____' . $result["price"] . '_____' . getFilePath('product', $result["prodId"], $conn)[0] . '_____' . $result["prodId"] . '_____' . $result["quantity"] . '_____1_____' . $result["price"] . '_____' . $result["active"] . '_____product';
                                    ?>
                                    <?php if (isset($_COOKIE["userId"])) { ?>
                                        <button value="<?php echo $productCartDetails; ?>" class="btn productColor addToCartBtn addProdToCartBtn text-white text-uppercase px-4 mt-auto">
                                            <i class="fa fa-shopping-cart text-white"></i>
                                            Add to cart
                                        </button>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--// Content //-->

<?php
include_once 'partials/footer.php';
?>