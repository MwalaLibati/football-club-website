<?php
include_once 'db/connect.php';
include_once 'db/fileUploadManager.php';
?>

<!doctype html>
<html lang="zxx">

<head>

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mufulira Wanderers FC</title>

    <link rel="shortcut icon" type="image/x-icon" href="images/mwfc_images/logos/logo1.png" />

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <link rel="stylesheet" href="css/slick-slider.css">
    <link rel="stylesheet" href="css/fancybox.css">
    <link rel="stylesheet" href="css/smartmenus.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="membershipForms/membership_assets/css/bd-wizard.css">

</head>

<body class="home">
    <div id="ritekhela-loader">
        <div id="ritekhela-loader-inner">
            <div id="ritekhela-shadow"></div>
            <div id="ritekhela-box"></div>
        </div>
    </div>

    <div class="ritekhela-wrapper">

        <!--// Header //-->
        <header id="ritekhela-header" class="ritekhela-header-one">

            <!--// TopStrip //-->
            <div class="ritekhela-topstrip">
                <div class="container">
                    <div class="row">

                        <aside class="col-md-6">
                            <strong>
                                <a href="#" class="text-white comingSoon latestNews">
                                    <!-- <i class="fas fa-hand-point-right"></i> -->
                                    LATEST NEWS :
                                </a>
                            </strong>
                            <div class="ritekhela-latest-news-slider">
                                <div class="ritekhela-latest-news-slider-layer">Mufulira Wanderers News</div>
                                <div class="ritekhela-latest-news-slider-layer">Results - ZESCO 0 : 4 MWFC</div>
                                <div class="ritekhela-latest-news-slider-layer">League Final: Thursday, 24th December 2020</div>
                                <div class="ritekhela-latest-news-slider-layer">New Signing: No.9 - Renford Kalaba</div>
                            </div>
                        </aside>
                        <aside class="col-md-6">
                            <ul class="ritekhela-user-strip hideOnSmScreen">
                                <!-- <li><a href="#" data-toggle="modal" data-target="#supportModel"><i class="fa fa-globe-africa"></i> Contact Us</a></li> -->
                                <li><a href="contact-us.php"><i class="fa fa-globe-africa"></i> Contact Us</a></li>

                                <?php
                                if (isset($_COOKIE["boss"])) { //admin
                                    echo '<li><a class="text-white"><i class="fa fa-user"></i>Hi ' . $_COOKIE["boss"] . ' </a></li>';
                                    echo '<li><a href="#!" class="logoutLink"><i class="fa fa-sign-in-alt"></i>Logout</a></li>';
                                } elseif (isset($_COOKIE["userId"])) { //user
                                    echo '<li><a href="userProfile.php"><i class="fa fa-user"></i>Hi <span class="firstNameDisplay">' . $_COOKIE["firstName"] . ' </span></a></li>';
                                    echo '<li><a href="#!" class="logoutLink"><i class="fa fa-sign-in-alt"></i>Logout</a></li>';
                                } else { //logged out
                                    echo '<li><a href="#!" data-toggle="modal" data-target="#ritekhelamodalcenter"><i class="fa fa-user-alt"></i> Login</a></li>';
                                    echo '<li><a href="#!" data-toggle="modal" data-target="#ritekhelamodalrg"><i class="fas fa-user-circle"></i> Create Account</a></li>';
                                }
                                ?>
                                
                            </ul>
                        </aside>

                    </div>
                </div>
            </div>
            <!--// TopStrip //-->

            <!--// Main Header //-->
            <div class="ritekhela-main-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="index.php" class="ritekhela-logo">
                                <img src="images/mwfc_images/logos/logo1.png" width="40%" height="20%" alt="">
                            </a>
                            <a class="ritekhela-logo hand nav-bars-menu hide smScreenShow">
                                <span class="text-white nav-bars" style="right: 25px; font-size:1.5em;">
                                    <?php
                                    if (isset($_COOKIE["boss"])) { //admin
                                        echo $_COOKIE["boss"];
                                    } elseif (isset($_COOKIE["userId"])) { //user
                                        echo $_COOKIE["firstName"];
                                    }
                                    ?>
                                </span>
                                <i class="fas fa-bars text-white nav-bars"></i>
                            </a>
                            <div class="ritekhela-right-section">
                                <div class="ritekhela-navigation">
                                    <!-- <span class="ritekhela-menu-link hide hideOnSmScreen">
                                        <span class="menu-bar"></span>
                                        <span class="menu-bar"></span>
                                        <span class="menu-bar"></span>
                                    </span> -->
                                    <nav id="main-nav">
                                        <ul id="main-menu" class="sm sm-blue">
                                            <?php
                                            if (isset($_COOKIE["boss"]) && !isset($_COOKIE["userId"])) {
                                                echo '<li class="active"><a href="admin/index.php">Admin</a></li>';
                                            }
                                            ?>
                                            <li class=""><a href="index.php">Home</a></li>

                                            <?php
                                            //check membership status
                                            if (isset($_COOKIE["userId"]) && !isset($_COOKIE["boss"])) {
                                                echo '<li class=""><a href="userProfile.php">Profile</a></li>';

                                                $data3 = mysqli_query($conn, "SELECT memberType FROM membership WHERE active = 1 AND userId = " . $_COOKIE["userId"]);
                                                $membership3 = mysqli_fetch_assoc($data3);
                                                if (mysqli_num_rows($data3) == 1) {
                                                    echo '<li class=""><a href="membershipTypes.php">' . $membership3["memberType"] . ' Member</a></li>';
                                                } else {
                                                    echo '<li class=""><a href="membershipTypes.php">Membership</a></li>';
                                                }
                                            } else {
                                                echo '<li class=""><a href="membershipTypes.php">Membership</a></li>';
                                            }

                                            ?>
                                            <li><a href="#">Team</a>
                                                <ul>
                                                    <li><a href="#" class="comingSoon">Players</a></li>
                                                    <li><a href="#" class="comingSoon">Coaching Staff</a></li>
                                                    <li><a href="#" class="comingSoon">Management</a></li>
                                                    <!-- <li><a href="player-grid.php" class="comingSoon">Players</a></li>
                                                    <li><a href="player-grid.php" class="comingSoon">Coaching Staff</a></li>
                                                    <li><a href="player-grid.php" class="comingSoon">Management</a></li>-->
                                                </ul>
                                            </li>
                                            <li><a href="#">Tickets</a>
                                                <ul>
                                                    <li><a href="#" class="comingSoon">Match Tickets</a></li>
                                                    <li><a href="#" class="comingSoon">Season Tickets</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="blog-large-wrsb.php">Our News</a>
                                                <!-- <ul>
                                                    <li><a href="#">Blog Grid</a>
                                                        <ul>
                                                            <li><a href="blog-grid.php">Blog Grid W/O/S</a></li>
                                                            <li><a href="blog-grid-wlsb.php">Blog Grid W/L/S</a></li>
                                                            <li><a href="blog-grid-wrsb.php">Blog Grid W/R/S</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Blog Large</a>
                                                        <ul>
                                                            <li><a href="blog-large.php">Blog Large W/O/S</a></li>
                                                            <li><a href="blog-large-wlsb.php">Blog Large W/L/S</a></li>
                                                            <li><a href="blog-large-wrsb.php">Blog Large W/R/S</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Blog Detail</a>
                                                        <ul>
                                                            <li><a href="blog-detail.php">Blog Detail W/Thumb</a></li>
                                                            <li><a href="blog-detail-waudio.php">Blog W/SounCloud</a></li>
                                                            <li><a href="blog-detail-wvideo.php">Blog Detail W/Video</a></li>
                                                        </ul>
                                                    </li>
                                                </ul> -->
                                            </li>
                                            <li><a href="shop-grid.php">Our Shop</a>
                                                <!--<ul>
                                                    <li><a href="shop-grid.php">Shop Grid W/O/S</a></li>
                                                    <li><a href="shop-grid-wlsb.php">Shop Grid W/L/S</a></li>
                                                    <li><a href="shop-grid-wrsb.php">Shop Grid W/R/S</a></li>
                                                    <li><a href="shop-detail.php">Shop Detail</a></li>
                                                </ul>-->
                                            </li>
                                        </ul>
                                    </nav>
                                </div>

                                <?php
                                if (!isset($_COOKIE["boss"]) && isset($_COOKIE["userId"])) {
                                    include_once 'cartBox.php';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// Main Header //-->

        </header>
        <!--// Header //-->

        <!-- Toast msg -->
        <div class="toast m-3 text-center hide p-2 bg-white">
            <div class="toast-header">
                <span class="mdi mdi-message mdi-18px"></span>
                <strong class="mr-auto ml-2">INFO</strong>
                <button type="button" class="ml-2 mb-1 close toast-close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body p-4">
                Hello there, in the weldi!
            </div>
        </div>