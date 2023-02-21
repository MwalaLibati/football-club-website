<?php
include_once 'db/connect.php';

//display all products in one category
if (isset($_GET["category"])) { //view specific category products
    $categoryURL = $_GET["category"];
    $data0 = mysqli_query($conn, "SELECT * FROM productCategoryConfig WHERE active = 1 AND categoryName LIKE '$categoryURL' ORDER BY id DESC");
    if (mysqli_num_rows($data0) == 1) {
        $limit4 = "";
        $backToShops = '<a href="shop-grid.php" class="btn btn-sm btn-dark ml-2">Back</a>';
    } else {
        header('Location: shop-grid.php');
    }
} else { //view all category products
    $data0 = mysqli_query($conn, "SELECT * FROM productCategoryConfig WHERE active = 1 ORDER BY id DESC");
    $limit4 = "LIMIT 4";
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
                    <li>Our Shop</li>
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

    <?php
    if (mysqli_num_rows($data0) != 0) {
        while ($result0 = mysqli_fetch_assoc($data0)) { //loop through categories
            $backToCategory = '';
            if (!isset($_GET["category"])) {
                $backToShops = '<a href="shop-grid.php?category=' . $result0["categoryName"] . '" class="btn btn-sm viewMoreBtn" data-toggle="tooltip" title="View all \'' . $result0["categoryName"] . '\' products">View all</a>';
            } else {
                $backToCategory = '&category=' . $result0["categoryName"] . ''; //user should go back to category view if originally from category view
            }
            echo '<div class="container mb-5">
                    <div class="p-2 bg-light">
                        <h3 class="inline pr-2">' . $result0["categoryName"] . '</h3>
                        ' . $backToShops . '   
                     </div>
                    <div class="row">';

            $categoryName = $result0["categoryName"];
            $data = mysqli_query($conn, "SELECT * FROM products WHERE quantity > 0 AND category LIKE '$categoryName' ORDER BY uploadDate DESC " . $limit4);
            if (mysqli_num_rows($data) != 0) {
                while ($result = mysqli_fetch_assoc($data)) { //loop through products for each categories

                    //check if product is currently unavailable
                    $isProductAvailable = '';
                    if ($result["active"] == 0) {
                        $isProductAvailable = '<div class="overlay">Product<br>Unavailable</div>';
                        $productImgs = '<img class="rounded" src="' . getFilePath('product', $result["prodId"], $conn)[0] . '">';
                    } else {
                        //get product images
                        if (sizeof(getFilePath('product', $result["prodId"], $conn)) >= 2) {
                            $productImgs = '<a href="productDetails.php?product=' . $result["prodId"] . $backToCategory . '" data-toggle="tooltip" title="View Details"><img class="xyz rounded" src="' . getFilePath('product', $result["prodId"], $conn)[0] . '">
                                            <img class="xyz-replacement rounded" src="' . getFilePath('product', $result["prodId"], $conn)[1] . '"></a>';
                        } else {
                            $productImgs = '<a href="productDetails.php?product=' . $result["prodId"] . $backToCategory . '" data-toggle="tooltip" title="View Details"><img class="xyz rounded" src="' . getFilePath('product', $result["prodId"], $conn)[0] . '">
                                            <img class="xyz-replacement rounded" src="' . getFilePath('product', $result["prodId"], $conn)[0] . '"></a>';
                        }
                    }

                    //get old price
                    $oldPrice = '';
                    if ($result["oldPrice"] != 0) {
                        $oldPrice = 'K' . $result["oldPrice"];
                    }

                    //collect cart details
                    $productCartDetails =  $result["name"] . '_____' . $result["price"] . '_____' . getFilePath('product', $result["prodId"], $conn)[0] . '_____' . $result["prodId"] . '_____' . $result["quantity"] . '_____1_____' . $result["price"] . '_____' . $result["active"] . '_____product';

                    //our beloved product
                    echo '<div class="col-md-3">
                                <div class="productCard mt-3">
                                    <div class="product-1 align-items-center p-2 text-center">
                                        <div class="image-container">
                                            ' . $isProductAvailable . '
                                            ' . $productImgs . '
                                        </div>
                                        <h5 class="pt-3">' . $result["name"] . '</h5>
                                        <div class="m-2 info">
                                            <span class="text1">' . substr($result["description"], 0, 80) . '</span>
                                            <span class="text1 bold block pt-2" title="Currently in stock">In stock: ' . $result["quantity"] . '</span>
                                        </div>
                                        <div class="cost mt-3 text-dark">
                                            <span>K' . $result["price"] . ' <del class="font-medium" title="Old Price">' . $oldPrice . '</del></span>
                                        </div>
                                    </div>
                                    <div>';
                    if (isset($_COOKIE["userId"])) {
                        echo '<button value="' . $productCartDetails . '" class="productColor btn-outline-none bg-lightblue addToCartBtn p-3 btn-block text-center text-info mt-3 cursor cart"> <span class="text-uppercase cart-text">Add to cart</span> </button>';
                    }
                    echo '</div>
                                </div>
                            </div>';
                } //end while()
            } else {
                echo '<div class="p-5 m-5 text-center font-large">Products coming soon...</div>';
            }

            echo '</div>
            </div>';
        } //end while()
    } else {
        echo '<div class="p-5 m-5 text-center font-large">Products coming soon...</div>';
    }

    ?>


</div>
<!--// Content //-->

<?php
include_once 'partials/footer.php';
?>