<?php
include_once 'db/connect.php';
include_once 'db/fileUploadManager.php';
?>
 <!--// SideBaar //-->
 <aside class="col-md-4">
                            
                            <!--// Widget Popular News //-->
                           <!-- <div class="widget widget_categories">
                                <div class="ritekhela-fancy-title-two">
                                    <h2>categories</h2>
                                </div>
                                <ul>
                                    <li><a href="#">Boxing</a> 03</li>
                                    <li><a href="#">Championship</a> 05</li>
                                    <li><a href="#">Cycling</a> 03</li>
                                    <li><a href="#">Football</a> 19</li>
                                    <li><a href="#">NFL</a> 02</li>
                                    <li><a href="#">Golf</a> 11</li>
                                    <li><a href="#">Premier League</a> 12</li>
                                    <li><a href="#">Tennis</a> 04</li>
                                    <li><a href="#">Super Ball</a> 03</li>
                                </ul>
                            </div>-->
                            <!--// Widget Popular News //-->

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
                                        <a href="#" class="fb">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>3,794</span>
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
                                    <h5>Eden University/Faz National LeagueS</h5>
                                    <span>Saturday, November 21th, 2020</span>
                                </div>
                                <ul>
                                    <li>
                                        <img src="images/fixtures/muflogo.png" alt="">
                                        <h6><a href="fixture-detail.html">Mufulira</a></h6>
                                        <small>Wanderers</small>
                                    </li>
                                    <li>
                                        <div class="widget_next_match_option">
                                            <h6>09:00 pm</h6>
                                            <small>Shinde Stadium</small>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="images/fixtures/nchangarangers.png" alt="">
                                        <h6><a href="fixture-detail.html">Nchanga</a></h6>
                                        <small>Rangers</small>
                                    </li>
                                </ul>
                                <div class="widget_match_countdown">
                                    <h6>Game Countdown</h6>
                                    <div id="ritekhela-match-countdowntw"></div>
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
                                    <p>Subscribe to our Newsletters.</p>
                                    <input type="text" value="Your Name" onblur="if(this.value == '') { this.value ='Your Name'; }" onfocus="if(this.value =='Your Name') { this.value = ''; }">
                                    <input type="text" value="Enter Your email" onblur="if(this.value == '') { this.value ='Enter Your email'; }" onfocus="if(this.value =='Enter Your email') { this.value = ''; }">
                                    <input type="submit" value="Subscribe Now">
                                </form>
                            </div>
                            <!--// Widget Newsletter //-->

                            <!--// Widget Add's //-->
                            <div class="widget widget_add">
                                <img src="images/ads/hoodie.jpg" alt="">
                            </div>
                            <!--// Widget Add's //-->
                            
                            <!--// Widget Gallery //-->
                           <!-- <div class="widget widget_gallery">
                                <div class="ritekhela-fancy-title-two">
                                    <h2>Flicker Photos</h2>
                                </div>
                                <ul>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-1.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-2.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-3.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-4.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-5.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-6.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-7.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-8.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-1.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-2.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-3.jpg" alt=""></a></li>
                                    <li><a data-fancybox-group="group" href="extra-images/widget-gallery-1.jpg" class="fancybox"><img src="extra-images/widget-gallery-4.jpg" alt=""></a></li>
                                </ul>
                            </div>-->
                            <!--// Widget Gallery //-->

                        </aside>