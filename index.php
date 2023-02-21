<?php
include_once 'partials/header.php';
?>

<!--// Banner //-->
<div class="ritekhela-banner-one screenHeight">

    <?php
    $homePageBanners = '';
    if (isset($_COOKIE["boss"])) {
        $homePageBanners = '<a href="admin/homePageBanners.php" data-toggle="tooltip" title="Edit Banner" class="productBadge bg-danger btn btn-lg m-2 p-3"><i class="fas fa-edit text-white"></i></a>';
    }
    //placeholder banner
    $placeholderBanner = '<div class="ritekhela-banner-one-layer">
                <span class="ritekhela-banner-transparent"></span>
                <img src="images/placeholders/homePageBanner-placeholder.png" class="screenHeight width100Percent" alt="">
                ' . $homePageBanners . '
                <div class="ritekhela-banner-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-5 rounded bg-shade-3">
                                <h1>The <strong class="club-theme-color-light">Mighty</strong> Mufulira Wanderers</h1>
                                <div class="clearfix"></div>
                                <p>Mufulira Wanderers are Zambia’s most successful football club, based in the Copperbelt town of Mufulira</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';


    $data = mysqli_query($conn, "SELECT * FROM banners WHERE bannertype LIKE 'homePageBanner' ORDER BY priority");
    if (mysqli_num_rows($data) != 0) {
        if (true) { //set to false if placeholder banner not needed
            echo $placeholderBanner;
        }
        while ($bannerResult = mysqli_fetch_assoc($data)) {
    ?>
            <!-- banner -->
            <div class="ritekhela-banner-one-layer">
                <span class="ritekhela-banner-transparent"></span>
                <img src="<?php echo getFilePath('homePageBanner', $bannerResult["bannerId"], $conn)[0]; ?>" class="screenHeight width100Percent" alt="Banner">
                <?php
                if (isset($_COOKIE["boss"])) {
                    echo '<a href="admin/homePageBanners.php" data-toggle="tooltip" title="Edit Banner" class="productBadge bg-danger btn btn-lg m-2 p-3"><i class="fas fa-edit text-white"></i></a>';
                }
                ?>
                <?php if (!empty($bannerResult["description1"]) || !empty($bannerResult["description1"])) { ?>
                    <div class="ritekhela-banner-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 pt-5 rounded bg-shade-3">
                                    <h1>
                                        <?php
                                        if (!empty($bannerResult["description1"])) {
                                            echo $bannerResult["description1"];
                                        }
                                        ?>
                                    </h1>
                                    <?php
                                    if (!empty($bannerResult["description2"])) {
                                        echo '<div class="clearfix"></div>';
                                        echo '<p>' . $bannerResult["description2"] . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

    <?php
        } //end while()
    } else {

        //placeholder banner
        echo $placeholderBanner;
    } ?>

</div>
<!--// Banner //-->

<!--// Content //-->
<div class="ritekhela-main-content">

    <!--// Main Section //-->
    <div class="ritekhela-main-section ritekhela-fixture-slider-full">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    <!--// Fixture Slider //-->
                    <div class="ritekhela-fixture-slider">
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ritekhela-fixture-slider-layer">
                            <div class="ritekhela-fixture-box">
                                <span class="layer-shape"></span>
                                <time datetime="2008-02-14 20:00">August TBA, 2020</time>
                                <ul>
                                    <li>BRC <span>05</span></li>
                                    <li>RM <span>02</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--// Fixture Slider //-->

                </div>

                <!--// Left Section //-->
                <div class="col-md-8">

                    <!--// Fancy Title Two //-->
                    <div class="ritekhela-fancy-title-two">
                        <h2>Latest News</h2>
                    </div>
                    <!--// Fancy Title Two //-->

                    <!--// Latest Blog's //-->
                    <div class="ritekhela-blogs ritekhela-blog-view1">
                        <ul class="row">
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf3.jpg" alt=""> <i class="fa fa-link"></i> </a></figure>
                                <div class="ritekhela-blog-view1-text">
                                    <ul class="ritekhela-blog-options">
                                        <li><i class="far fa-calendar-alt"></i> January 3, 2019</li>
                                        <li><a href="#"><i class="far fa-comment"></i> Comments</a></li>
                                    </ul>
                                    <h2><a href="blog-detail.php">Incredible claims Could sickly man be worst serial killer?</a></h2>
                                    <p>Lorem ipsum dolor sit amet, consectet ad elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magnaLorem ipsum dolor sit amet, consectet ad elit sed onummy.</p>
                                    <a href="blog-detail.php" class="ritekhela-blog-view1-btn">Read More</a>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf4.jpg" alt=""> <i class="fa fa-link"></i> </a></figure>
                                <div class="ritekhela-blog-view1-text">
                                    <ul class="ritekhela-blog-options">
                                        <li><i class="far fa-calendar-alt"></i> January 3, 2019</li>
                                        <li><a href="#"><i class="far fa-comment"></i> Comments</a></li>
                                    </ul>
                                    <h2><a href="blog-detail.php">TV host’s hand impaled on nail in failed magic trick</a></h2>
                                    <p>Lorem ipsum dolor sit amet, consectet ad elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magnaLorem ipsum dolor sit amet, consectet ad elit sed onummy.</p>
                                    <a href="blog-detail.php" class="ritekhela-blog-view1-btn">Read More</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="ritekhela-blogs ritekhela-blog-view2">
                        <ul class="row">
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf5.jpg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">Ipsum cursus leo vel metus</a></h2>
                                    <time datetime="2008-02-14 20:00">July 01, 2019 5:50 am</time>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf7.jpg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">TV host’s hand impaled</a></h2>
                                    <time datetime="2008-02-14 20:00">June 01, 2019 6:20 am</time>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf6.jpeg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">One more time? Federer</a></h2>
                                    <time datetime="2008-02-14 20:00">March 01, 2019 2:40 am</time>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf3.jpg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">Federer golden opportunity</a></h2>
                                    <time datetime="2008-02-14 20:00">April 01, 2019 1:80 am</time>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf5.jpg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">Ipsum cursus leo vel metus</a></h2>
                                    <time datetime="2008-02-14 20:00">May 01, 2019 9:50 am</time>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <figure><a href="blog-detail.php"><img src="images/match_pics/muf4.jpg" alt=""></a></figure>
                                <div class="ritekhela-blog-view2-text">
                                    <h2><a href="blog-detail.php">TV host’s hand impaled</a></h2>
                                    <time datetime="2008-02-14 20:00">Jan 01, 2019 3:10 am</time>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--// Latest Blog's //-->

                    <!--// Fancy Title Two //-->
                    <div class="ritekhela-fancy-title-two">
                        <h2>Popular Players</h2>
                    </div>
                    <!--// Fancy Title Two //-->

                    <!--// Player //-->
                    <div class="ritekhela-team ritekhela-team-view1">
                        <ul class="row">
                            <li class="col-md-4">
                                <figure>
                                    <a href="player-detail.php"><img src="images/mwfc_images/player.png" alt=""></a>
                                    <figcaption>
                                        <a href="#" class="fab fa-facebook-f"></a>
                                        <a href="#" class="fab fa-twitter"></a>
                                        <a href="#" class="fab fa-instagram"></a>
                                        <a href="#" class="fab fa-dribbble"></a>
                                    </figcaption>
                                </figure>
                                <div class="ritekhela-team-view1-text">
                                    <h2><a href="player-detail.php">Player name</a></h2>
                                    <span>Forward</span>
                                    <p>Lorem ipsum dolor sit met, con etur adipiscing elit. Ut c males ante.</p>
                                    <a href="player-detail.php" class="ritekhela-team-view1-btn">Read More <i class="fa fa-angle-right"></i></a>
                                </div>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a href="player-detail.php"><img src="images/mwfc_images/player.png" alt=""></a>
                                    <figcaption>
                                        <a href="#" class="fab fa-facebook-f"></a>
                                        <a href="#" class="fab fa-twitter"></a>
                                        <a href="#" class="fab fa-instagram"></a>
                                        <a href="#" class="fab fa-dribbble"></a>
                                    </figcaption>
                                </figure>
                                <div class="ritekhela-team-view1-text">
                                    <h2><a href="player-detail.php">Player name</a></h2>
                                    <span>Defensive</span>
                                    <p>Lorem ipsum dolor sit met, con etur adipiscing elit. Ut c males ante.</p>
                                    <a href="player-detail.php" class="ritekhela-team-view1-btn">Read More <i class="fa fa-angle-right"></i></a>
                                </div>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a href="player-detail.php"><img src="images/mwfc_images/player.png" alt=""></a>
                                    <figcaption>
                                        <a href="#" class="fab fa-facebook-f"></a>
                                        <a href="#" class="fab fa-twitter"></a>
                                        <a href="#" class="fab fa-instagram"></a>
                                        <a href="#" class="fab fa-dribbble"></a>
                                    </figcaption>
                                </figure>
                                <div class="ritekhela-team-view1-text">
                                    <h2><a href="player-detail.php">Player name</a></h2>
                                    <span>Attacker</span>
                                    <p>Lorem ipsum dolor sit met, con etur adipiscing elit. Ut c males ante.</p>
                                    <a href="player-detail.php" class="ritekhela-team-view1-btn">Read More <i class="fa fa-angle-right"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--// Player //-->

                    <!--// Match Result //-->
                    <div class="ritekhela-match-result">
                        <div class="ritekhela-match-title">
                            <h4>Latest Match Result</h4>
                            <span>Saturday, June 24th, 2020</span>
                        </div>
                        <ul>
                            <li>
                                <img src="images/mwfc_images/logos/logo1.png" alt="">
                                <h4><a href="#">Mufulira Wanderers</a></h4>
                                <span></span>
                            </li>
                            <li class="ritekhela-match-score">
                                <h5>FINAL SCORE</h5>
                                <p><strong>4</strong> <small>:</small>3</p>
                            </li>
                            <li>
                                <img src="images/logos/greeneagles.png" alt="">
                                <h4><a href="#">Zesco United</a></h4>
                                <span></span>
                            </li>
                        </ul>
                    </div>
                    <!--// Match Result //-->

                    <!--// Fancy Title Two //-->
                    <div class="ritekhela-fancy-title-two">
                        <h2>Club Media</h2>
                    </div>
                    <!--// Fancy Title Two //-->

                    <!--// Gallery //-->
                    <div class="ritekhela-gallery ritekhela-gallery-view1">
                        <ul class="row">
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">11 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>The Champion Final will be played</h2>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">06 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>will be played The Champion Final</h2>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">14 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>Champion Final The will be played</h2>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">12 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>will be The Chamn Final played</h2>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">25 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>be played The Champion Final will</h2>
                            </li>
                            <li class="col-md-4">
                                <figure>
                                    <a data-fancybox-group="group" href="images/mwfc_images/muf1.jpg" class="fancybox"><img src="images/mwfc_images/muf1.jpg" alt=""> <i class="fa fa-plus ritekhela-bgcolor"></i> </a>
                                    <figcaption>
                                        <span class="ritekhela-bgcolor-two">04 Photos</span>
                                    </figcaption>
                                </figure>
                                <h2>played The Chaion Final will be</h2>
                            </li>
                        </ul>
                    </div>
                    <!--// Gallery //-->

                </div>
                <!--// Left Section //-->

                <!--// SideBaar //-->
                <aside class="col-md-4">

                    <!--// Widget Popular News //-->
                    <div class="widget widget_popular_news">
                        <div class="ritekhela-fancy-title-two">
                            <h2>Popular News</h2>
                        </div>
                        <ul>
                            <li>
                                <span>01</span>
                                <div class="popular_news_text">
                                    <small>The Team</small>
                                    <a href="blog-detail.php">Basketball Stadium will a max capacity</a>
                                    <time datetime="2008-02-14 20:00">December 21, 2017</time>
                                </div>
                            </li>
                            <li class="widget-injuries">
                                <span>02</span>
                                <div class="popular_news_text">
                                    <small>Injuries</small>
                                    <a href="blog-detail.php">The Clovers defense must reinvent itself without</a>
                                    <time datetime="2008-02-14 20:00">December 21, 2017</time>
                                </div>
                            </li>
                            <li class="widget-theleague">
                                <span>03</span>
                                <div class="popular_news_text">
                                    <small>The League</small>
                                    <a href="blog-detail.php">Take look to the brand new helmets season</a>
                                    <time datetime="2008-02-14 20:00">December 21, 2017</time>
                                </div>
                            </li>
                            <li>
                                <span>04</span>
                                <div class="popular_news_text">
                                    <small>The Team</small>
                                    <a href="blog-detail.php">The Basketball women division started training</a>
                                    <time datetime="2008-02-14 20:00">December 21, 2017</time>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--// Widget Popular News //-->

                    <!--// Widget Team Ranking //-->
                    <div class="widget widget_team_ranking">
                        <div class="ritekhela-fancy-title-two">
                            <h2>Team Standings</h2>
                        </div>
                        <div class="ranking-title-table">
                            <ul class="ranking-title-row">
                                <li>Team Rank</li>
                                <li>P</li>
                                <li>W</li>
                                <li>L</li>
                                <li>PTS</li>
                            </ul>
                        </div>
                        <div class="ranking-content-table">
                            <ul class="ranking-content-row">
                                <li>1</li>
                                <li> <img src="images/logos/zesco.png" alt="">
                                    <div class="ranking-logo"><span>Zesco</span> <small> United</small> </div>
                                </li>
                                <li>08</li>
                                <li>08</li>
                                <li>03</li>
                                <li>24</li>
                            </ul>
                        </div>
                        <div class="ranking-content-table">
                            <ul class="ranking-content-row">
                                <li>2</li>
                                <li> <img src="images/mwfc_images/logos/logo1.png" alt="">
                                    <div class="ranking-logo"><span>Mufulira</span> <small> Wanderers</small> </div>
                                </li>
                                <li>08</li>
                                <li>08</li>
                                <li>07</li>
                                <li>14</li>
                            </ul>
                        </div>
                        <div class="ranking-content-table">
                            <ul class="ranking-content-row">
                                <li>3</li>
                                <li> <img src="images/logos/zanaco.png" alt="">
                                    <div class="ranking-logo"><span>Zanaco</span> <small>FC</small> </div>
                                </li>
                                <li>07</li>
                                <li>07</li>
                                <li>07</li>
                                <li>14</li>
                            </ul>
                        </div>
                        <div class="ranking-content-table">
                            <ul class="ranking-content-row">
                                <li>4</li>
                                <li> <img src="images/logos/nkana.png" alt="">
                                    <div class="ranking-logo"><span>Nkana</span> <small>FC</small> </div>
                                </li>
                                <li>08</li>
                                <li>08</li>
                                <li>07</li>
                                <li>14</li>
                            </ul>
                        </div>
                        <div class="ranking-content-table">
                            <ul class="ranking-content-row">
                                <li>5</li>
                                <li> <img src="images/logos/greeneagles.png" alt="">
                                    <div class="ranking-logo"><span>Green</span> <small>Eagles</small> </div>
                                </li>
                                <li>08</li>
                                <li>08</li>
                                <li>08</li>
                                <li>16</li>
                            </ul>
                        </div>
                    </div>
                    <!--// Widget Team Ranking //-->

                    <!--// Widget Social Media //-->
                    <div class="widget widget_social_media">
                        <div class="ritekhela-fancy-title-two">
                            <h2>Social Media</h2>
                        </div>
                        <ul>
                            <li>
                                <a href="#" class="rss">
                                    <i class="fa fa-rss"></i>
                                    <span>2,035</span>
                                    <small>Subscribers</small>
                                </a>
                            </li>
                            <li>
                                <a href="https://web.facebook.com/mufulirawanderersfootballclub" target="_blank" class="fb">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>12,413</span>
                                    <small>Fans</small>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="g_plus">
                                    <i class="fab fa-google-plus-g"></i>
                                    <span>941</span>
                                    <small>Followers</small>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="you_tube">
                                    <i class="fab fa-youtube"></i>
                                    <span>7,820</span>
                                    <small>Subscribers</small>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="twitter">
                                    <i class="fab fa-twitter"></i>
                                    <span>1,562</span>
                                    <small>Followers</small>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="pint">
                                    <i class="fab fa-pinterest-p"></i>
                                    <span>1,310</span>
                                    <small>Followers</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--// Widget Social Media //-->

                    <!--// Widget Next Match //-->
                    <div class="widget widget_next_match">
                        <div class="ritekhela-fancy-title-two">
                            <h2>Next Match</h2>
                        </div>
                        <div class="widget_next_match_title">
                            <h5>ABSA CUP Quarter Finals</h5>
                            <span>Saturday, May 17th, 2020</span>
                        </div>
                        <ul>
                            <li>
                                <img src="images/logos/greeneagles.png" alt="">
                                <h6><a href="fixture-detail.php">Green Eagles</a></h6>
                                <small></small>
                            </li>
                            <li>
                                <div class="widget_next_match_option">
                                    <h6>09:00 pm</h6>
                                    <small>Levy Mwanawasa Stadium</small>
                                </div>
                            </li>
                            <li>
                                <img src="images/mwfc_images/logos/logo1.png" alt="">
                                <h6><a href="fixture-detail.php">MUFC</a></h6>
                                <small></small>
                            </li>
                        </ul>
                        <div class="widget_match_countdown">
                            <h6>Game Countdown</h6>
                            <div id="ritekhela-match-countdown"></div>
                        </div>
                        <a href="#" class="widget_match_btn">Buy Ticket Now</a>
                    </div>
                    <!--// Widget Next Match //-->

                    <!--// Widget Newsletter //-->
                    <div class="widget widget_newsletter">
                        <div class="ritekhela-fancy-title-two">
                            <h2>Our Newsletter</h2>
                        </div>
                        <form>
                            <label>Subscribe Now</label>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac malesuada ante.</p>
                            <input type="text" value="Your Name" onblur="if(this.value == '') { this.value ='Your Name'; }" onfocus="if(this.value =='Your Name') { this.value = ''; }">
                            <input type="text" value="Enter Your email" onblur="if(this.value == '') { this.value ='Enter Your email'; }" onfocus="if(this.value =='Enter Your email') { this.value = ''; }">
                            <input type="submit" value="Subscribe Now">
                        </form>
                    </div>
                    <!--// Widget Newsletter //-->
                </aside>
                <!--// SideBaar //-->

            </div>
        </div>
    </div>
    <!--// Main Section //-->

</div>
<!--// Content //-->

<?php
include_once 'partials/footer.php';
?>