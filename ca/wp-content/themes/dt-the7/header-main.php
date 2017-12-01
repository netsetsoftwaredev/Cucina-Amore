<?php
/**
 * @since 1.0.0
 */

// File Security Check
if (!defined('ABSPATH')) {
    exit;
} ?>

    <?php do_action('presscore_before_main_container'); ?>

        <?php if (presscore_is_content_visible()): ?>

            <?php if (is_front_page()) {


        $access_token = '1827773285.54da927.0f2cbc78ff754214bf8b23a51a90bd73';
        // $tag = 'entrepreneurship';
        $return = rudr_instagram_api_curl_connect('https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $access_token);
        // echo '<pre>';
        // var_dump($return);
        // exit();
        // if you want to display everything the function returns   ?>
                <?php
        $videoUrl = "";

        foreach ($return->data as $numPost => $post) {
            if ($post->type == "video"/* && in_array('website', $post->tags)*/) {
                $videoUrl = $post->videos->standard_resolution->url;
                break;
            }
        }
        ?>

                    <head>
                        <title>Accelerate</title>

                        <meta charset="utf-8">
                        <meta http-equiv="x-ua-compatible" content="ie=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="css/foundation.css">
                        <link rel="stylesheet" href="css/app.css">
                        <link rel="stylesheet" href="css/animate.css">
                        <link href="css/hover-min.css" rel="stylesheet">
                        <link href="css/accelerate.css" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,500,600,700,800,900" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900" rel="stylesheet">
                    </head>

                    <body>
                        <div id="gallery"></div>
                        <div class="wrapper_s">



                            <div class="row perro_malo ">
                                <div class="large-12 columns ">
                                    <div class="row">
                                        <video id="govideo" poster="images/poster.png" width="100%" height="100%" loop="" muted="" preload="auto" playsinline>
                                            <source src="wp-content/uploads/2017/04/shutterstock_v14115686-1.mp4">
                                            <source src="images/shutterstock_v14115686-1.webm" onerror="fallback(parentNode)">
                                            <img src="images/shutterstock_v14115686-1.gif">
                                        </video>
                                    </div>
                                </div>
                            </div>
                            <div class="row rsg_move">
                                <div class="large-12 columns ">
                                    <div class=" move31">
                                        <h1>
                            <div id="ready" style="display: none!important;">READY.&nbsp;</div>
                            <div id="set" style="display: none!important;">SET.&nbsp;</div>
                            <div id="go" style="display: none!important;">GROW.&nbsp;</div>
                        </h1>

                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="large-12 columns ">
                                    <div class="row">
                                        <div class="new_container_">
                                            <h1 class="ti00 move32">
                                We are a growth engine for small to mid-market organizations.
                            </h1>
                                            <a class="get_start hvr-grow-shadow " href="/contact-us">GET STARTED</a>
                                            <i class="arrow_as"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="par_re">
                                <ul id="scene" class="scene">
                                    <li class="layer" data-depth="1.00"><img src="images/bfs.png"></li>

                                </ul>
                            </div>
                            <div class="par_re_">
                                <ul id="scene_" class="scene">
                                    <li class="layer" data-depth="1.00"><img src="images/BAckgroundFollowUs.png"></li>

                                </ul>
                            </div>

                            <div class="row container2 fe45">
                                <div class="large-12 columns style00">
                                    <div class="row">
                                        <i class="icoon_row"></i>
                                        <h1 class="ti00 move33 rest des">
                            We've helped over <span id="cnterhome"> 317</span> companies accelerate
                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row container2 move31">
                                <div class="large-12 columns style00">
                                    <div class="row mobile_dont_show">
                                        <h1 class="ti0">Driving GROWTH and COMMERCE
                            <br />through the convergence of Creative,<br />Technology, and
                            Strategy.</h1>
                                    </div>
                                    <div class="row mobile_show">
                                        <h1 class="ti0">Driving GROWTH and COMMERCE
                            through the convergence of Creative,Technology, and
                            Strategy.</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="row containerre">
                                <div class="large-12 columns ">
                                    <div class="row">
                                        <div class="large-6 medium-6 columns aj style0">
                                            <div class="widcol">
                                                <p>We are a digital agency
                                                    <br> that achieves results,
                                                    <br> where others fail</p>
                                                <p class="tet mobile_dont_show">Accelerate prides itself on creating a culture of excellence, We
                                                    <br> are excellent problem solvers, we work with companies to
                                                    <br>create a better future for their companies, and families.
                                                    <br>Our goal is growth, and we wont stop until we achieve it.</p>
                                                <p class="tet mobile_show">Accelerate prides itself on creating a culture of excellence, We are excellent problem solvers, we work with companies to create a better future for their companies, and families. Our goal is growth, and we wont stop until we achieve it.</p>

                                                <a href="/about-us/" class="effect_a hvr-grow-shadow "> About us</a>
                                            </div>

                                        </div>

                                        <div class="large-6 medium-6 columns">
                                            <div class="row moveefx">
                                                <div class="large-6 medium-6 columns aj style1
                                        hvr-back-pulse-a">
                                                    <div class="widcol2">
                                                        <p>Services</p>
                                                        <span> We provide great creative, technology, and strategy.</span>
                                                        <a href="/services"> Learn More >> </a>
                                                    </div>
                                                </div>

                                                <div class="large-6 medium-6 columns aj style2 hvr-back-pulse">
                                                    <div class="widcol2">

                                                        <p>Get accelerated</p>
                                                        <span class="blog">BLOG / JAN 2017</span>
                                                        <span> Stingray Gaming Engine - The engine for B2B Gaming</span>
                                                        <a href="/stingray-gaming-engine-the-engine-for-b2b-gaming/"> Learn More >> </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row moveefx">
                                                <div class="large-6 medium-6 columns aj style2 hvr-back-pulse movethis1 ">
                                                    <div class="widcol2">

                                                        <p>Get accelerated</p>
                                                        <span class="blog">BLOG / JAN 2017</span>
                                                        <span> What Effects Conversion Rate on an Ecommerce Site</span>
                                                        <a href="/what-effects-conversion-rate-on-an-ecommerce-site/"> Learn More >> </a>
                                                    </div>
                                                </div>

                                                <div class="large-6 medium-6 columns aj style1 movethis2 hvr-back-pulse-a">
                                                    <div class="widcol2">
                                                        <p>Get accelerated</p>
                                                        <span class="blog">BLOG / JAN 2017</span>
                                                        <span> Vision Remix Video - Get to know us.</span>
                                                        <a href="/vision-remix-video-get-to-know-us/"> Learn More >> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="large-12 columns ">
                                <div class="row tri_boun">
                                    <div class="large-6 medium-6 columns carr_op">
                                        <div class="widcol23">

                                            <p>Get accelerated</p>
                                            <span> We're doing big things here at accelerate. Building culture, building businesses. Follow us on our journey, and even join in by watching our facebook live videos.</span>
                                        </div>
                                    </div>
                                    <div class="large-6 medium-6 columns circle_as">

                                        <div class="rouncontmobile">
                                            <img src="images/diagram.png" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row container2">
                                <div class="large-12 columns style00">
                                    <div class="row">
                                        <div class="widcol231">
                                            <p>Grow with us</p>
                                            <span> We're doing big things here at accelerate. Building culture, building businesses.<br /> Follow Us on our journey, and even join in by watching our facebook live videos.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="large-12 columns ">
                                <div class="row">
                                    <div class="large-6 medium-6 columns">
                                        <div class="socialplug ins">
                                            <p>Follow our journey and get to know Accelerate and its people on Instagram.</p>
                                            <a href="https://www.instagram.com/accelerateagncy/" class="hvr-grow-shadow"><i class="icon"></i> Instagram</a>
                                        </div>

                                    </div>
                                    <div class="large-6 medium-6 columns moveplugininsta">
                                        <div class="socialplug back_insta">
                                            <video id="instaVideo" width="100%" height="100%" loop="" muted="" preload="auto" controls>
                                                <source src="<?php echo $videoUrl  ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="large-12 columns moveallface">
                                <div class="row">
                                    <div class="large-6 medium-6 columns movepluginface ">
                                        <div class="fb-video" data-href="https://www.facebook.com/commerceacceleration/videos/1716033822042749/" data-width="500" data-show-text="false">
                                            <blockquote cite="https://www.facebook.com/commerceacceleration/videos/1716033822042749/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/commerceacceleration/videos/1716033822042749/">5 Things Every Ecommerce Retailer Needs to Know</a>
                                                <p>CEO Brad McCrory clues you in on vital strategic metrics you should look at to make sure you&#039;re not wasting money!</p>Posted by <a href="https://www.facebook.com/commerceacceleration/">Accelerate Digital Agency</a> on Tuesday, January 31, 2017</blockquote>
                                        </div>
                                    </div>
                                    <div class="large-6 medium-6 columns moveface">
                                        <div class="socialplug face">

                                            <p>Check out our Facebook page for industry trought leadership, and insights.</p>
                                            <a href="https://www.facebook.com/commerceacceleration/" class="hvr-grow-shadow "><i class="icon"></i> Facebook</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <script src="js/vendor/jquery.js"></script>
                        <script src="js/count.js"></script>
                        <script src="js/parallax.js"></script>
                        <script src="js/countUp.js"></script>
                        <script src="js/vendor/what-input.js"></script>
                        <script src="js/vendor/foundation.js"></script>
                        <script src="js/app.js"></script>
                        <script src="js/jquery.parallax.js"></script>

                        <script type="text/javascript">
                            var options = {
                                useEasing: true,
                                useGrouping: false,
                                separator: '',
                                decimal: '',
                                prefix: '',
                                suffix: ''
                            };
                            var demo = new CountUp("cnterhome", 117, 317, 0, 3.5, options);
                            $('.arrow_as').addClass('animated pulse');
                            $('.gallery').parallax();

                            $(function () {


                                $("#ready").delay(1500).fadeIn(500);
                                $("#set").delay(2700).fadeIn(500);
                                $("#go").delay(4000).fadeIn(500);
                                $("#go").promise().done(function () {
                                    $("#govideo").get(0).play();
                                });

                                $('.get_start ').hover(function () {

                                    $(this).css({
                                        'background-color': 'white',
                                        'color': '#a756a2'
                                    })

                                }, function () {
                                    $(this).css({
                                        'background-color': '#a756a2',
                                        'color': '#fff'
                                    })
                                });




                            })

                            $(window).scroll(function () {
                                var offset = $(".effect_a").offset().top;
                                var offsetass = $('.move31').offset().top;
                                if ($(window).scrollTop() >= offset) {
                                    $('.rouncont').css({
                                        'display': 'block'
                                    })
                                    $('.a_r').addClass('animated bounceInLeft');
                                    $('.a_s').addClass('animated bounceInRight');
                                    $('.a_t').addClass('animated bounceInUp');
                                    $('.a_v').addClass('animated fadeIn');
                                }
                                if ($(window).scrollTop() >= (offsetass - 200)) {

                                    demo.start();

                                }


                            });
                            $('#scene,#scene_').parallax();

                            $('.style1').hover(function () {
                                $(this).find('.widcol2 > p').css({
                                    'color': '#000'
                                })
                            }, function () {
                                $(this).find('.widcol2 > p').css({
                                    'color': '#fff'
                                })
                            })


                            $('.style2').hover(function () {
                                $(this).find('.widcol2 > p').css({
                                    'color': '#fff'
                                })
                            }, function () {
                                $(this).find('.widcol2 > p').css({
                                    'color': '#000'
                                })
                            })



                            $(function () {
                                var isAndroid = /(android)/i.test(navigator.userAgent);
                                if (isAndroid) {

                                    $('.rouncont.ip6').remove();
                                    $('.rouncontmobile').css({
                                        'display': 'block',
                                        'position': 'relative',
                                        'top': '170px',
                                        'width': '336px',
                                        'height': '300px',
                                        'left': '0px',
                                        'right': '0px',
                                        'margin': '0 auto'
                                    })
                                }

                            })

                            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                                var header_wi = "<div class='masthead inline-header right widgets full-height line-decoration masthead-mobile' role='banner' style='transform: translateY(0px);'><header class='header-bar'><div class='branding'><a href='http://commerceacceleration.com/'><img class=' preload-me' src='http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png' srcset='http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png 243w, http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png 243w' width='243' height='50' sizes='243px' alt='Accelerate'></a><div id='site-title' class='assistive-text'>Accelerate</div><div id='site-description' class='assistive-text'>San Diego Digital Agency, San Diego Web Design</div></div><ul id='primary-menu' class='main-nav underline-decoration l-to-r-line outside-item-remove-margin' role='menu'><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-393 first'><a href='http://commerceacceleration.com/about-us/' data-level='1'><span class='menu-item-text'><span class='menu-text'>About us</span><i class='underline'></i></span></a></li><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-117'><a href='http://commerceacceleration.com/projects/' data-level='1'><span class='menu-item-text'><span class='menu-text'>Our Work</span><i class='underline'></i></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-451 has-children dt-mega-menu mega-full-width mega-column-5'><a href='#' class='not-clickable-item' data-level='1'><span class='menu-item-text'><span class='menu-text'>Services</span><i class='underline'></i></span></a><div class='dt-mega-menu-wrap'><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-450 first has-children no-link dt-mega-parent wf-1-5'><a href='http://commerceacceleration.com/web/' class='not-clickable-item' data-level='2'><span class='menu-item-text'><span class='menu-text'>Web</span></span></a><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-215 first'><a href='http://commerceacceleration.com/web/' data-level='3'><span class='menu-item-text'><span class='menu-text'>WordPress</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-216'><a href='http://commerceacceleration.com/web/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Maintenance &amp; Support</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-217'><a href='http://commerceacceleration.com/web/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Custom Application Development</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-218'><a href='http://commerceacceleration.com/web/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Lead Gen Sites</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-214'><a href='http://commerceacceleration.com/web/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Ecommerce</span></span></a></li></ul></li><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-205 has-children no-link dt-mega-parent wf-1-5'><a href='http://commerceacceleration.com/mobile/' class='not-clickable-item' data-level='2'><span class='menu-item-text'><span class='menu-text'>Mobile</span></span></a><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-219 first'><a href='http://commerceacceleration.com/mobile/' data-level='3'><span class='menu-item-text'><span class='menu-text'>iPhone Applications</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-220'><a href='http://commerceacceleration.com/mobile/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Android Applications</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-221'><a href='http://commerceacceleration.com/mobile/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Responsive Sites</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-222'><a href='http://commerceacceleration.com/mobile/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Mobile Sites</span></span></a></li></ul></li><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-206 has-children no-link dt-mega-parent wf-1-5'><a href='http://commerceacceleration.com/marketing/' class='not-clickable-item' data-level='2'><span class='menu-item-text'><span class='menu-text'>Marketing</span></span></a><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-223 first'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Paid Media</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-224'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Earned Media</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-225'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Email Marketing</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-226'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Analytics</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-227'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Consulting &amp; Coaching</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-228'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Conversion Optimization</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-229'><a href='http://commerceacceleration.com/marketing/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Social Media</span></span></a></li></ul></li><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-207 has-children no-link dt-mega-parent wf-1-5'><a href='http://commerceacceleration.com/creative/' class='not-clickable-item' data-level='2'><span class='menu-item-text'><span class='menu-text'>Creative</span></span></a><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-208 first'><a href='http://commerceacceleration.com/creative/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Branding</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-212'><a href='http://commerceacceleration.com/creative/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Web Design</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-209'><a href='http://commerceacceleration.com/creative/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Photography</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-210'><a href='http://commerceacceleration.com/creative/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Video</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-213'><a href='http://commerceacceleration.com/creative/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Mobile Design</span></span></a></li></ul></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-230 has-children no-link dt-mega-parent wf-1-5'><a href='http://commerceacceleration.com/technology/' class='not-clickable-item' data-level='2'><span class='menu-item-text'><span class='menu-text'>Technology</span></span></a><ul class='sub-nav gradient-hover hover-style-bg level-arrows-on'><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-235 first'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Virtual Reality</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-236'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Game Development</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-231'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Hosting &amp; Network Admin</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-232'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Database Support</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-233'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Site Speed Optimization</span></span></a></li><li class='menu-item menu-item-type-custom menu-item-object-custom menu-item-234'><a href='http://commerceacceleration.com/technology/' data-level='3'><span class='menu-item-text'><span class='menu-text'>Consulting Services</span></span></a></li></ul></li></ul></div></li><li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-242'><a href='http://commerceacceleration.com/blog/' data-level='1'><span class='menu-item-text'><span class='menu-text'>Get Accelerated</span><i class='underline'></i></span></a></li><li class='menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-237 current_page_item menu-item-240 act'><a href='http://commerceacceleration.com/contact-us/' data-level='1'><span class='menu-item-text'><span class='menu-text'>Contact Us</span><i class='underline'></i></span></a></li></ul><div class='mini-widgets'><div class='mini-search show-on-desktop near-logo-first-switch near-logo-second-switch'><form class='searchform' role='search' method='get' action='http://commerceacceleration.com/' data-form-processed='true'><input type='text' class='field searchform-s' name='s' value='' placeholder='Type and hit enter …' style='opacity: 0; visibility: hidden;'><input type='submit' class='assistive-text searchsubmit' value='Go!'><a href='#go' id='trigger-overlay' class='submit icon-off'>&nbsp;</a></form></div></span></div></header><div class='mobile-header-bar'><div class='mobile-navigation'><a href='#' class='dt-mobile-menu-icon floating-btn'><span class='lines'></span></a><a href='#' class='dt-mobile-menu-icon active'><span class='lines'></span></a></div><div class='mobile-mini-widgets'><div class='mini-search show-on-desktop near-logo-first-switch near-logo-second-switch'><form class='searchform' role='search' method='get' action='http://commerceacceleration.com/' data-form-processed='true'><input type='text' class='field searchform-s' name='s' value='' placeholder='Type and hit enter …' style='opacity: 0; visibility: hidden;'><input type='submit' class='assistive-text searchsubmit' value='Go!'><a href='#go' id='trigger-overlay' class='submit icon-off'>&nbsp;</a></form></div><div class='mini-search show-on-desktop near-logo-first-switch near-logo-second-switch show-on-second-switch first last'><form class='searchform' role='search' method='get' action='http://commerceacceleration.com/' data-form-processed='true'><input type='text' class='field searchform-s' name='s' value='' placeholder='Type and hit enter …' style='opacity: 0; visibility: hidden;'><input type='submit' class='assistive-text searchsubmit' value='Go!'><a href='#go' id='trigger-overlay' class='submit icon-off'>&nbsp;</a></form></div></div><div class='mobile-branding'><a href='http://commerceacceleration.com/'><img class=' preload-me' src='http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png' srcset='http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png 243w, http://commerceacceleration.com/wp-content/uploads/2016/12/mob_logo1.png 243w' width='243' height='50' sizes='243px' alt='Accelerate'></a></div></div></div>"

                                $(".masthead.inline-header").remove();
                                $("a.skip-link").before(header_wi);

                                $('.dt-close-mobile-menu-icon ').css({
                                    'opacity': '0'
                                })

                                $(".dt-mobile-menu-icon").on('click', function () {
                                    $(".dt-mobile-header").css({
                                        'right': '330px',
                                        'position': 'absolute'
                                    });
                                    $('.dt-close-mobile-menu-icon ').css({
                                        'opacity': '1'
                                    })
                                })
                                $(".dt-close-mobile-menu-icon").on('click', function () {
                                    $(".dt-mobile-header").css({
                                        'right': '-330px',
                                        'position': 'absolute'
                                    });
                                    $('.dt-close-mobile-menu-icon ').css({
                                        'opacity': '0'
                                    })
                                })
                            } else {

                            }




                            $('.menu-item-451 > a.not-clickable-item').on('click', function () {
                                $(this).addClass('active_ass');
                                $('.dt-mega-menu-wrap').css({
                                    'height': '200px',
                                    'width': '100%',
                                    'display': 'inline-block'

                                });


                                $('ul.sub-nav.gradient-hover.hover-style-bg.level-arrows-on').css({
                                    'position': 'absolute',
                                    'top': '0',
                                });
                                $('a.not-clickable-item.active_ass').on('click', function () {
                                    $('.dt-mega-menu-wrap').css({
                                        'height': '0px',
                                        'width': '100%',
                                        'display': 'none'

                                    });
                                })



                            })


                            $(function () {
                                $('a.not-clickable-item.active_ass').on('click', function () {
                                    $('.dt-mega-menu-wrap').css({
                                        'height': '0px',
                                        'width': '100%',
                                        'display': 'none'

                                    });
                                })
                            })
                        </script>
                        <script>
                            (function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));

                            function fallback(video) {
                                var img = video.querySelector('img');
                                if (img)
                                    video.parentNode.replaceChild(img, video);
                            }
                        </script>
                        <div id="fb-root"></div>


                    </body>

                    <?php } ?>
                        <div id="main" <?php presscore_main_container_classes(); ?>
                            <?php presscore_main_container_style(); ?> >

                            
            <link href="https://fonts.googleapis.com/css?family=Merriweather:400,500,600,700,800,900" rel="stylesheet">
             <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900" rel="stylesheet">
                            
                                <?php do_action('presscore_main_container_begin'); ?>

                                    <div class="main-gradient"></div>
                                    <div class="wf-wrap">
                                        <div class="wf-container-main">

                                            <?php do_action('presscore_before_content'); ?>

                                                <?php endif; ?>
