
<?php include_once 'database.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="LandingPageFiles/img/iiq ico.ico" type="image/x-icon" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>InterlinkIQ</title>

        <!-- Google tag (gtag.js) -->
        <script async="" src="./Interlink_files/js"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', 'G-TKPT68LJ8H');
        </script>
        

        <link rel="shortcut icon" href="assets/img/interlink%20icon.png" type="image/png">

        <!-- Icon css link -->
        <link href="LandingPageFiles/css/font-awesome.min.css" rel="stylesheet">
        <link href="LandingPageFiles/vendors/elegant-icon/style.css" rel="stylesheet">
        <link href="LandingPageFiles/vendors/themify-icon/themify-icons.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="LandingPageFiles/css/bootstrap.min.css" rel="stylesheet">

        <!-- Rev slider css -->
        <link href="LandingPageFiles/vendors/revolution/css/settings.css" rel="stylesheet">
        <link href="LandingPageFiles/vendors/revolution/css/layers.css" rel="stylesheet">
        <link href="LandingPageFiles/vendors/revolution/css/navigation.css" rel="stylesheet">
        <link href="LandingPageFiles/vendors/animate-css/animate.css" rel="stylesheet">

        <!-- Extra plugin css -->
        <link href="LandingPageFiles/vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">

        <link href="LandingPageFiles/css/style.css" rel="stylesheet">
        <link href="LandingPageFiles/css/responsive.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
        <!-- Cookies -->
        <script>
            window.addEventListener("load", function(){
                window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#000"
                    },
                    "button": {
                        "background": "#f1d600"
                    },
                },
                content: {
                    header: 'Cookiessss used on the website!',
                    message: 'We use cookies and similar technologies to enable services and functionality on our site and to understand your interaction with our service. <br>By clicking on accept, you agree to our use of such technologies for marketing and analytics.',
                    dismiss: 'Accept',
                    allow: 'Allow cookies',
                    deny: 'Decline',
                    link: 'See Privacy Policy',
                    href: 'http://google.com',
                    close: '&#x274c;',
                }
                })
                
                // if (getCookie('modalCMS') == null) {
                //     setCookie('modalCMS','1','30'); //(key,value,expiry in days)
                //     $("#modalCMS").modal('show');
                // } 
            });
            function setCookie(key, value, expiry) {
                var expires = new Date();
                expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
                document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
            }
        
            function getCookie(key) {
                var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
                return keyValue ? keyValue[2] : null;
            }
        
            function eraseCookie(key) {
                var keyValue = getCookie(key);
                setCookie(key, keyValue, '-1');
            }
        </script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .hide{
                display:none;
            }
            #modalCMS .close-modal {
                display: none !important;
            }
        </style>
    </head>
    <body>

        <!--================Search Area =================-->
        <section class="search_area">
            <div class="search_inner">
                <input type="text" placeholder="Enter Your Search...">
                <i class="ti-close"></i>
            </div>
        </section>
        <!--================End Search Area =================-->

        <!--================Header Menu Area =================-->
        <header class="main_menu_area">
            <nav class="navbar navbar-expand-xl navbar-light bg-light">
                <a class="navbar-brand" href="#"><img src="LandingPageFiles/img/iiq logo white.png" alt="" width="30%"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"><a class="nav-link" style="font-size:14px !important;" href="/">Home</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="//consultareinc.com/shop">SOPKing</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="management_services">Services</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="directory">Directory</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="//www.youtube.com/@AllAboutCompliance/videos">Vlog</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="forum/index">Forum</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="specialist">Specialist</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="marketplace">Marketplace</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="grant">Grant Services</a></li>
                        <li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="contact">Contact</a></li>
                        <!--<li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="login">Login</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="login"><i class="fa fa-sign-in"  aria-hidden="true"></i> Login</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="contact-us.html">Contact</a></li>-->
                        <li><a style="font-size:14px !important;" href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
                    </ul>
                    <!--<ul class="navbar-nav mr-auto justify-content-end">-->
                    <!--</ul>-->
                </div>
            </nav>
        </header>
        <!--================End Header Menu Area =================-->

        <!--================Slider Area =================-->
        <section class="main_slider_area" id="home_block">
            <canvas style="position: absolute;z-index:21;" id="demo-canvas" width="100%" height="100%"></canvas>
            <div id="main_slider" class="rev_slider" data-version="5.3.1.6">
                <ul>
                    
                <?php
                         
                                        $query = "SELECT * FROM tblLandingPage ORDER BY RAND() ";
                                        $result = mysqli_query($conn, $query);
                                                                    
                                        while($row = mysqli_fetch_array($result)){?>
                                        
                    <li data-index="<?php echo $row['rs_number']; ?>" data-transition="slidevertical" data-slotamount="1" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <!-- MAIN IMAGE -->
                        <img src="LandingPageFiles/img/home-slider/<?php echo $row['image_name'] ?>"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>

                        <!-- LAYER NR. 1 -->

                        <div class="slider_text_box">

                            <div class="tp-caption tp-resizeme rev-btn first_text"
                                data-x="['center','center','center','center','center','center']"
                                data-hoffset="['0','0','0','0']"
                                data-y="['middle','middle','middle','middle']"
                                data-voffset="['-170','-170','-170','-110','-120','-120']"
                                data-fontsize="['12','12','12','12','12']"
                                data-lineheight="['64','64','64','50','35']"
                                data-width="100%"
                                data-height="none"
                                data-whitespace="normal"
                            data-frames="[{&quot;delay&quot;:10,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:0px;s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;y:[175%];&quot;,&quot;mask&quot;:&quot;x:inherit;y:inherit;s:inherit;e:inherit;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;}]"
                            data-textAlign="['center','center','center','center','center','center']"
                            style="z-index: 8;font-family: 'Poppins', sans-serif;font-weight:600;color:#fff;text-transform: uppercase;">
                            <img src="LandingPageFiles/img/iqlogo_small.png" alt="interlinkiq logo small">
                            </div>


                            <div class="tp-caption tp-resizeme secand_text"
                                data-x="['center','center','center','center','center','center']"
                                data-hoffset="['0','0','0','0']"
                                data-y="['middle','middle','middle','middle']"
                                data-voffset="['0','0','0','0','0']"
                                data-fontsize="['48','48','48','28','28','22']"
                                data-lineheight="['60','60','60','36','36','30']"
                                data-width="100%"
                                data-height="none"
                                data-whitespace="normal"
                                data-type="text"
                                data-responsive_offset="on"
                                data-transform_idle="o:1;"
                                data-frames="[{&quot;delay&quot;:10,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:[100%];s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;y:[175%];&quot;,&quot;mask&quot;:&quot;x:inherit;y:inherit;s:inherit;e:inherit;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;}]"
                                data-textAlign="['center','center','center','center','center','center']"

                                style="z-index: 8;font-family:'Poppins', sans-serif;font-weight:700;color:#fff;"><?php echo $row['description1'] ?>
                                <br /><?php echo $row['description2'] ?>
                            </div>

                            <div class="tp-caption tp-resizeme slider_button"
                                data-x="['center','center','center','center','center','center']"
                                data-hoffset="['0','0','0','0']"
                                data-y="['middle','middle','middle','middle']"
                                data-voffset="['130','130','130','100','100','100']"
                                data-width="none"
                                data-height="none"
                                data-whitespace="nowrap"
                                data-type="text"
                                data-responsive_offset="on"
                                data-frames="[{&quot;delay&quot;:10,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:[100%];s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;y:[175%];&quot;,&quot;mask&quot;:&quot;x:inherit;y:inherit;s:inherit;e:inherit;&quot;,&quot;ease&quot;:&quot;Power2.easeInOut&quot;}]"
                                data-textAlign="['center','center','center','center','center','center']">
                                <!--<article id="btn-freeaccess" data-index-number="99">
                                    <a class="tp_btn"  href="#" >About Us</a>
                                </article>-->
                            </div>
                        </div>
                    </li>
                                        
                                        
                                        
                                        
                <?php 
                                        }
                ?>
                                        
                                        
                                        
            
                </ul>
            </div>
        </section>
        <!--================End Slider Area =================-->

        <!--================Creative Feature Area =================-->
        <section class="creative_feature_area">

            <div class="container">
                <div class="c_feature_box" style="background: transparent;">

                
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="button-holder" style="width:100%;float:left;margin-top: -30vh;text-align:center;"><a class="bg_btn" href="login">Free Access</a></div>
                        </div>
                    </div>
                    <div class="row d-none">
                        <div class="col-lg-4">
                            <div class="c_box_item">
                                <a href="#"><h4><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Free Listing and Tools</h4></a>
                                <p>Jobs, RFQs, Buyers, Sellers, Products, and Services Offerings; Candidates, Employees, Training, Contacts, Buyers, Customers, and Supplier Management. </p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="c_box_item">
                                <a href="#"><h4><i class="fa fa-clock-o" aria-hidden="true"></i> Integrated Connectivity</h4></a>
                                <p>Managed communications for Processes, Personnel, Documentation, Controls, Prerequisites Programs, Requirements, Standards, and Compliance. </p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="c_box_item">
                                <a href="#"><h4><i class="fa fa-diamond" aria-hidden="true"></i> Premium Services</h4></a>
                                <p>Support for regulatory, accreditation, and certification standards requirements. </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="digital_feature p_100">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d_feature_text">
                                <div class="main_title">
                                    <h2>Welcome to <br /> InterlinkIQ</h2>
                                </div>
                                <p>InterlinkIQ is where process meets industry connectivity developed for “You”, the owner, entrepreneur, operator, the agent in charge of a facility or process, the practitioner.</p>
                                <p>InterlinkIQ connects technologies and services that enable enterprises and users to interlink their activities and processes to meet their employees, customers, suppliers, regulatory, accreditation, and certification requirements while growing and expanding their professional communities and enterprises worldwide.</p>
                                <a class="read_btn" href="login">FREE ACCESS</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d_feature_img">
                                <img src="LandingPageFiles/img/feature-right.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Creative Feature Area =================-->

        <!--================Industries Area =================-->
        <section class="industries_area">
            <div class="left_indus">
                <div class="indus_img">
                    <img src="LandingPageFiles/img/iiq-laptop.png" alt="">
                </div>
            </div>
            <div class="right_indus">
                <div class="indus_text">
                    <div class="main_title">
                        <h2>Industry Categories</h2>
                        <p>Acidified Foods, Agricultural, Animal Feed, Aquaculture, Beverages, Candies, Cannabis, Catering, Cereals, Chemicals, Confectionery, CPG/FMCG, Cosmetics, Dairy, Dietary Supplements, Dips, Distribution, Equipment, Fats, Fishery, Flavoring, Food, Functional Foods, Grains, Gravies, Herbal / Herbs, Ingredients, Juice, Kitchen, Medical Device, Medical Food, Nutraceuticals, Nuts, Oils, Organic, Packaging, Pet Food, Pharmaceuticals, Produce, Proteins, Raw Materials, Restaurant, Sauces, Seafood, Seeds, Soups, Spices, Systems, Tobacco, Transportation, Utensils, and Others.</p>
                    </div>
                    <div class="our_skill_inner">
                        <div class="single_skill">
                            <h3>Compliance</h3>
                            <div class="progress" data-value="100">
                                <div class="progress-bar">
                                    <div class="progress_parcent"><span class="counter">100</span>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="read_btn" href="login">FREE ACCESS</a>
                </div>
            </div>
        </section>
        <!--================End Industries Area =================-->

        <!--================Our Service Area =================-->
        <section class="service_area d-none">
            <div class="container">
                <div class="center_title" >
                    <h2 style="color:#232d37;">Main Services</h2>
                    <p style="color:#232d37;">In addition to the above services we offer, we mainly do the following:</p>
                </div>
                <div class="row service_item_inner">
                    <div class="col-lg-3">
                        <div class="service_item">
                            <i class="ti-check-box"></i>
                            <h4>Compliance Services</h4>
                            <p>Regulatory – FDA, USDA, FSMA, Foreign Supplier Verification Program (FSVP), Food Fraud Vulnerability Assessment (FFVA), FTC, HARPC, HACCP, Food Safety Plan, Dietary Supplement, cGMP, GAP, GLP, GDP, GWP, Supply Chain-Program, OSHA, Cannabis, Organic (USDA NOP), Label & Marketing Claims, CFIA.</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="service_item">
                            <i class="ti-medall"></i>
                            <h4>Certification Services</h4>
                            <p>GFSI, SQF, BRCGS, IFS, FSSC 22000, PrimusGFS, ISO, Organic (USDA NOP, JAS, EU, Taiwan, Korea, China), Halal, Kosher, Non-GMO, USP, Vegan, GMP, HACCP, Plant-Based, Cannabis, Gluten-Free.</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="service_item">
                            <i class="ti-link"></i>
                            <h4>InterlinkIQ Connectivity</h4>
                            <p>Customer & Supplier Requirements, Document Sharing, Inventory Management, Production Planning, Product Release, Formulation, MMR/BMR, Traceability, Employees Assigned Duties, QC Forms, SOPs, Training Materials, and System Software.</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="service_item">
                            <i class="ti-comments"></i>
                            <h4>Consulting Services</h4>
                            <p>PCQI, FSVPQI, KATVAQI, QC/QA - On-Site & Remote, Implementation & Monitoring, Training, Coaching & Mentoring, Software, Full Support, End-to-End Services, HACCP & Food Safety Plan Development, Verification, and Validation, Technical Writing, FDA/USDA/FTC/OSHA Warning Letters, Importing & Exporting, Audit, Label & Marketing Claims Review.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Our Service Area =================-->

        <!--================Testimonials Area =================-->
        <!-- <section class="testimonials_area p_100">
            <div class="container">
                <div class="testimonials_slider owl-carousel">
                    <div class="item">
                        <div class="media">
                            <img class="d-flex rounded-circle" src="img/testimonials-1.png" alt="">
                            <div class="media-body">
                                <img src="img/dotted-icon.png" alt="">
                                <p>I wanted to mention that these days, when the opposite of good customer and tech support tends to be the norm, it’s always great having a team like you guys at Fancy! So, be sure that I’ll always spread the word about how good your product is and the extraordinary level of support that you provide any time there is any need for it.</p>
                                <h4><a href="#">Aigars Silkalns</a> - CEO DeerCreative</h4>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="media">
                            <img class="d-flex rounded-circle" src="img/testimonials-1.png" alt="">
                            <div class="media-body">
                                <img src="img/dotted-icon.png" alt="">
                                <p>I wanted to mention that these days, when the opposite of good customer and tech support tends to be the norm, it’s always great having a team like you guys at Fancy! So, be sure that I’ll always spread the word about how good your product is and the extraordinary level of support that you provide any time there is any need for it.</p>
                                <h4><a href="#">Aigars Silkalns</a> - CEO DeerCreative</h4>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="media">
                            <img class="d-flex rounded-circle" src="img/testimonials-1.png" alt="">
                            <div class="media-body">
                                <img src="img/dotted-icon.png" alt="">
                                <p>I wanted to mention that these days, when the opposite of good customer and tech support tends to be the norm, it’s always great having a team like you guys at Fancy! So, be sure that I’ll always spread the word about how good your product is and the extraordinary level of support that you provide any time there is any need for it.</p>
                                <h4><a href="#">Aigars Silkalns</a> - CEO DeerCreative</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--================End Testimonials Area =================-->

        
        
        <!--================Customized System Management Area =================-->
        <section class="latest_news_area p_100" id="customizedmanagement">
            <div class="container">
                <div class="b_center_title">
                    <h2>InterlinkIQ Customized System Management</h2>
                    <p></p>
                </div>
                <div class="l_news_inner">
                    <!-- <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="l_news_item">
                                <div class="l_news_img"><a href="#"><img class="img-fluid" src="img/blog/l-news/l-news-1.jpg" alt=""></a></div>
                                <div class="l_news_content">
                                    <a href="#"><h4>We Create Experiences</h4></a>
                                    <p>The Fancy that recognize the talent and effort of the best web designers, develop-ers and agencies in the world.</p>
                                    <a class="more_btn" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                        
                    </div> -->
                    <p>510k, Accounting, Accreditation (Organic, HALAL, Kosher, Non-GMO, Vegan, Plant Based, Gluten Free, et al.), Advertising, Analytical, Auditing (Internal, Preparation, CAPA, et al.), Branding, Brand Owner, Broker, Buyer, Calibration, Certification (ISO, GFSI, SQF, BRC, FSSC 22000, et al.), Chemicals, Coaching, Compliance, Consulting, Crisis Management, Cultivation, Customer Services, Distribution, Document Control Management, Engineering, Equipment, Exporting, Facility, Food Safety, Formulations, Fulfillment, FFVA, FSVP, GAP, GDP, GLP, GMP, GWP, HACCP, HR, Implementation, Importing, Inspection, IT, Inventory Management, Labels, Labs, Legal, Maintenance, Manufacturing/Co-Man, Marketing, Operation (MMR, et al.), Organic, OSHA/CAL, Packaging, PCQI, Pest Control, Practitioner, Preventive Controls, Premarket Approval, Private Label, Process Controls, Product (Process, Proficiency Testing, Commercial Sterility, et al.), Production, PRPs, Purchasing, Quality (Assurance, Control, et al.), R & D (DQ, IQ, OQ, PQ), Recall (Withdrawal, Disposition, Disposal, et al.), Receiving, Regulatory (FDA, USDA), Safety, Sales, Sanitation, Shipping, Social Compliance, Sourcing, Staffing, Supply Chain, Training, Translation, Transportation, Testing (Allergen, Shelf-Life, Stability, Authenticity, Hazards, Organoleptic, Micro, Physical, Chemical, Foreign Object, Water, Air, Carbon Footprint, et al.), Validation, Vendor, Verification, Warehousing, Waste, Writing (Content, Technical, SOPs, et al.), Others.</p>
                </div>
            </div>
        </section>
        <!--================End Customized System Management Area =================-->


        <!--================Project Area =================-->
        <section class="project_area d-none">
            <div class="container">
                <div class="project_inner">
                    <div class="center_title">
                        <h2>Ready To Discuss Your Project? </h2>
                        <p>There are many ways to contact us. You may drop us a line, give us a call or send an email, choose what suits you the most.</p>
                    </div>
                    <a class="tp_btn" href="login">WORK WITH US</a>
                </div>
            </div>
        </section>
        <!--================End Project Area =================-->



        <!--================Latest News Area =================-->
        <section class="latest_news_area p_100 d-none">
            <div class="container">
                <div class="b_center_title">
                    <h2>Latest News</h2>
                    <p>Check out our blog page to <a href="#">read more.</a></p>
                </div>
                <div class="l_news_inner">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="l_news_item">
                                <div class="l_news_img">
                                    <!--     <a href="#"><img class="img-fluid" src="img/blog/l-news/l-news-1.jpg" alt=""></a> -->
                                    <iframe frameborder="0" src="//www.youtube.com/embed/WYgpmhOIaXs" width="100%" height="220" class="note-video-clip"></iframe>
                                </div>

                                <div class="l_news_content">
                                    <a href="#"><h4>FSQA Compliance Services</h4></a>
                                    <p>FSQA Services – covers both internal programs, policies, procedures, forms for records, and lessons for training as well as the federal, state, and certification requirements.<br>All-Inclusive – customized to the Code of Federal Regulation, Certification Standards, and to your customer requirements.</p>
                                    <a class="more_btn" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="l_news_item">
                                <div class="l_news_img">
                                    <a href="#"><img class="img-fluid" src="LandingPageFiles/img/blog/l-news/l-news-2.jpg" alt=""></a>
                                </div>
                                <div class="l_news_content">
                                    <a href="#"><h4>Amazon Supplier Compliance Management</h4></a>
                                    <p>I invite you to interact with the Amazon Supplier Compliance Management Dashboard by connecting via www.interlinkiq.com<br>If your company or facility is looking to start implementing regulatory, certification, or accreditation prerequisite programs to meet your customer requirements, look no further.</p>
                                    <a class="more_btn" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="l_news_item">
                                <div class="l_news_img">
                                    <a href="#"><img class="img-fluid" src="LandingPageFiles/img/blog/l-news/l-news-3.jpg" alt=""></a>
                                </div>
                                <div class="l_news_content">
                                    <a href="#"><h4>Brand Risk Management Services – Systematic Cross Functional Deep Dive Audit</h4></a>
                                    <p>A systematic cross-functional audit management that provides a deep dive assessment into the most critical areas of risk management.<br>From regulatory (FDA, USDA, and State), accreditation, and certification body requirements compliance best practices, procedures and mitigation of risk.</p>
                                    <a class="more_btn" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--================End Latest News Area =================-->



        <!--================Footer Area =================-->
        <footer class="footer_area">
            <div class="footer_widgets_area">
                <div class="container">
                    <div class="f_widgets_inner row">
                        <div class="col-lg-3 col-md-6x">
                            <aside class="f_widget subscribe_widget">
                                <div class="f_w_title">
                                    <h3>Our Newsletter</h3>
                                </div>
                                <p>Subscribe to our mailing list to get the updates to your email inbox.</p>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="E-mail" aria-label="E-mail">
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary submit_btn" type="button">Subscribe</button>
                                    </span>
                                </div>
                                <ul>
                                    <li><a href="//www.facebook.com/ConsultareIncConsulting/"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="//twitter.com/consultarei?lang=en"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="//www.youtube.com/channel/UCLbjTwJUmtaa25OPqRjIwfA"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="//ph.linkedin.com/company/consultareinc?trk=public_profile_experience-item_profile-section-card_subtitle-click"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </aside>
                        </div>
                        <div class="col-lg-3 col-md-6x">
                            <!-- <aside class="f_widget twitter_widget">
                                <div class="f_w_title">
                                    <h3>Twitter Feed</h3>
                                </div>
                                <div class="tweets_feed"></div>
                            </aside> -->
                            <aside class="f_widget categories_widget">
                                <div class="f_w_title">
                                    <h3>Sites</h3>
                                </div>
                                 <ul style="width: auto;">
                                    <li><a href="https://consultareinc.com/" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Consultare Inc. Group</a></li>
                                    <li><a href="https://consultareinc.com/training-ace/" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Training Ace</a></li>
                                    <li><a href="https://consultareinc.com/shop/" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>SOPKing</a></li>
                                    <li><a class="d-none" href="https://interlinkiq.com/" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>InterlinkIQ</a></li>
                                    <li><a href="https://itblaster.net/" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>IT Blaster</a></li>
                                </ul>
                            </aside>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <aside class="f_widget categories_widget">
                                <div class="f_w_title">
                                    <h3>Link Categories</h3>
                                </div>
                                 <ul style="width: auto;">
                                    <li><a class="d-none" href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Home</a></li>
                                    <li><a class="d-none" href="directory"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Directory</a></li>
                                    <li><a class="d-none" href="blog_posts_table"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Blog</a></li>
                                    <li><a href="terms_of_services/Terms%20of%20Service.pdf"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Terms of Service</a></li>
                                </ul>
                            </aside>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <aside class="f_widget contact_widget">
                                <div class="f_w_title">
                                    <h3>Contact Us</h3>
                                </div>
                                <a href="#">202-982-3002</a>
                                <a href="#">services@interlinkiq.com</a>
                                <h6>Open hours: 8.00-18.00 Mon-Fri</h6>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy_right_area">
                <div class="container">
                    <div class="float-md-left">
                        <h5>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | InterlinkIQ</a></h5>
                    </div>
                    <div class="float-md-right">
                        <ul class="nav">
                            <!-- <li class="nav-item">
                                <a class="nav-link active" href="#">Disclaimer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Privacy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Advertisement</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!--================End Footer Area =================-->

        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line scrollup__icon"></i>
        </a>
        
        
    	<!-- Modal -->
    	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    		<div class="modal-dialog modal-lg">
    			<div class="modal-content">
    				<div class="modal-body text-center">
    					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem;"></button>
    					<img src="uploads/icon_compliance.png" />
    					<h1>Compliance Management Software starting @ $249.00</h1>
    					<a href="contant" class="btn btn-lg btn-primary mt-5">Contact Us!</a>
    				</div>
    			</div>
    		</div>
    	</div>
    	
    	<div id="modalCMS" class="modal text-center">
			<img src="uploads/icon_compliance.png" />
			<h1 class="mb-5">Compliance Management Software starting @ $249.00</h1>
			<a href="contact" class="btn btn-lg btn-primary">Contact Us!</a>
			<a href="#" class="btn btn-lg btn-outline-primary" rel="modal:close">Close</a>
        </div>
    	
        <!--=============== SCROLL REVEAL===============-->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- thirdparty -->
        <script src="//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/EasePack.min.js"></script>
        <script src="//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/rAF.js"></script>
        <script src="//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/TweenLite.min.js"></script>

        <script> 
            // const article = document.querySelector("#btn-freeaccess");
            // article.dataset.indexNumber; // "99"
        </script>

        <script>
            // $(document).ready(function(){
            //     // $("#modalCMS").modal({
            //     //     show: true,
            //     //     fadeDuration: 1000,
            //     //     fadeDelay: 0.50
            //     // });
                
            //     $("#modalCMS").modal('open');
            // }


            // for background animated
            (function() {

            var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

            // Main
            initHeader();
            initAnimation();
            addListeners();

            function initHeader() {
                width = window.innerWidth;
                height = window.innerHeight;
                target = {x: width/2, y: height/2};

                largeHeader = document.getElementById('home_block');
                largeHeader.style.height = height+'%';

                canvas = document.getElementById('demo-canvas');
                canvas.width = width;
                canvas.height = height;
                ctx = canvas.getContext('2d');

                // create points
                points = [];
                for(var x = 0; x < width; x = x + width/20) {
                    for(var y = 0; y < height; y = y + height/20) {
                        var px = x + Math.random()*width/20;
                        var py = y + Math.random()*height/20;
                        var p = {x: px, originX: px, y: py, originY: py };
                        points.push(p);
                    }
                }

                // for each point find the 5 closest points
                for(var i = 0; i < points.length; i++) {
                    var closest = [];
                    var p1 = points[i];
                    for(var j = 0; j < points.length; j++) {
                        var p2 = points[j]
                        if(!(p1 == p2)) {
                            var placed = false;
                            for(var k = 0; k < 5; k++) {
                                if(!placed) {
                                    if(closest[k] == undefined) {
                                        closest[k] = p2;
                                        placed = true;
                                    }
                                }
                            }

                            for(var k = 0; k < 5; k++) {
                                if(!placed) {
                                    if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                        closest[k] = p2;
                                        placed = true;
                                    }
                                }
                            }
                        }
                    }
                    p1.closest = closest;
                }

                // assign a circle to each point
                for(var i in points) {
                    var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
                    points[i].circle = c;
                }
            }

            // Event handling
            function addListeners() {
                if(!('ontouchstart' in window)) {
                    window.addEventListener('mousemove', mouseMove);
                }
                window.addEventListener('scroll', scrollCheck);
                window.addEventListener('resize', resize);
            }

            function mouseMove(e) {
                var posx = posy = 0;
                if (e.pageX || e.pageY) {
                    posx = e.pageX;
                    posy = e.pageY;
                }
                else if (e.clientX || e.clientY)    {
                    posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
                    posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
                }
                target.x = posx;
                target.y = posy;
            }

            function scrollCheck() {
                if(document.body.scrollTop > height) animateHeader = false;
                else animateHeader = true;
            }

            function resize() {
                width = window.innerWidth;
                height = window.innerHeight;
                largeHeader.style.height = height+'px';
                canvas.width = width;
                canvas.height = height;
            }

            // animation
            function initAnimation() {
                animate();
                for(var i in points) {
                    shiftPoint(points[i]);
                }
            }

            function animate() {
                if(animateHeader) {
                    ctx.clearRect(0,0,width,height);
                    for(var i in points) {
                        // detect points in range
                        if(Math.abs(getDistance(target, points[i])) < 4000) {
                            points[i].active = 0.3;
                            points[i].circle.active = 0.6;
                        } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                            points[i].active = 0.1;
                            points[i].circle.active = 0.3;
                        } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                            points[i].active = 0.02;
                            points[i].circle.active = 0.1;
                        } else {
                            points[i].active = 0;
                            points[i].circle.active = 0;
                        }

                        drawLines(points[i]);
                        points[i].circle.draw();
                    }
                }
                requestAnimationFrame(animate);
            }

            function shiftPoint(p) {
                TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
                    y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
                    onComplete: function() {
                        shiftPoint(p);
                    }});
            }

            // Canvas manipulation
            function drawLines(p) {
                if(!p.active) return;
                for(var i in p.closest) {
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(p.closest[i].x, p.closest[i].y);
                    ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
                    ctx.stroke();
                }
            }

            function Circle(pos,rad,color) {
                var _this = this;

                // constructor
                (function() {
                    _this.pos = pos || null;
                    _this.radius = rad || null;
                    _this.color = color || null;
                })();

                this.draw = function() {
                    if(!_this.active) return;
                    ctx.beginPath();
                    ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
                    ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
                    ctx.fill();
                };
            }

            // Util
            function getDistance(p1, p2) {
                return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
            }

            })();


            // for cookies
            let cookieModal = document.querySelector(".cookie-consent-modal")
            let cancelCookieBtn = document.querySelector(".btn.cancel")
            let acceptCookieBtn = document.querySelector(".btn.accept")

            cancelCookieBtn.addEventListener("click", function (){
                cookieModal.classList.remove("active")
            })
            acceptCookieBtn.addEventListener("click", function (){
                cookieModal.classList.remove("active")
                localStorage.setItem("cookieAccepted", "yes")
            })

            setTimeout(function (){
                let cookieAccepted = localStorage.getItem("cookieAccepted")
                if (cookieAccepted != "yes"){
                    cookieModal.classList.add("active")
                }
            }, 2000) 

        </script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="LandingPageFiles/js/jquery-3.2.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="LandingPageFiles/js/popper.min.js"></script>
        <script src="LandingPageFiles/js/bootstrap.min.js"></script>
        <!-- Rev slider js -->
        <script src="LandingPageFiles/vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="LandingPageFiles/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <!-- Extra plugin css -->
        <script src="LandingPageFiles/vendors/counterup/jquery.waypoints.min.js"></script>
        <script src="LandingPageFiles/vendors/counterup/jquery.counterup.min.js"></script>
        <script src="LandingPageFiles/vendors/counterup/apear.js"></script>
        <script src="LandingPageFiles/vendors/counterup/countto.js"></script>
        <script src="LandingPageFiles/vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="LandingPageFiles/vendors/parallaxer/jquery.parallax-1.1.3.js"></script>
        <!--Tweets-->
        <script src="LandingPageFiles/vendors/tweet/tweetie.min.js"></script>
        <script src="LandingPageFiles/vendors/tweet/script.js"></script>

        <script src="LandingPageFiles/js/theme.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    </body>
</html>
