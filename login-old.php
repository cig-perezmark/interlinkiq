<?php include_once 'database_iiq.php'; ?>
<?php
    if(isset($_COOKIE['ID'])) {
        // $url='profile';
        // $url=$_SERVER['HTTP_REFERER'];
        // // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
        // // header('Location: profile');
        
        echo '<script>
            if (document.referrer == "") {
                window.location.href = "profile";
            } else {
                window.history.back();
            }
        </script>';
    }
?>

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <base href="">
        <meta charset="utf-8" />
        <title>Interlink IQ Login Page</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #2 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="assets/img/interlink icon.png" />
        <link href="custom.css" rel="stylesheet" type="text/css" />
    </head>
    <!-- END HEAD -->

    <body class="login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(assets/pages/img/login/bg1.jpg)"><img class="login-logo" src="assets/img/interlinkiq v3.png" height="70"  /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
            
                    <div class="login-content">
                        <h1>Welcome to Interlink IQ</h1>
                        <p> Where process meets industry connectivity developed for "You", the owner, entrepreneur, operator, the agent in charge of a facility or process, the practitioner. </p>

                        <?php
                            $confirm = false;
                            $predefine = false;

                            // Registration
                            if ( !empty( $_GET['i'] ) AND !empty( $_GET['r'] ) AND $_GET['r'] == 1 ) {
                                $ID = $_GET['i'];
                                $invited_id = '';
                                $selectEmployee = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE verified = 0 AND ID = "'. $ID .'"' );
                                if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                    $rowEmployee = mysqli_fetch_array($selectEmployee);
                                    $predefine = true;
                                    $invited_id = $rowEmployee['ID'];
                                    $data_email = $rowEmployee['email'];
                                    $data_first_name = $rowEmployee['first_name'];
                                    $data_last_name = $rowEmployee['last_name'];
                                }
                            }

                            // Confirm
                            if ( !empty( $_GET['i'] ) AND !empty( $_GET['c'] ) AND $_GET['c'] == 1 ) {
                                $ID = $_GET['i'];
                                $selectUser = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE is_verified = 0 AND is_active = 1 AND ID = "'. $ID .'"' );
                                if ( mysqli_num_rows($selectUser) > 0 ) {
                                    $rowUser = mysqli_fetch_array($selectUser);
                                    $data_employee_id = $rowUser['employee_id'];

                                    if ( !empty($data_employee_id) ) {
                                        mysqli_query( $conn,"UPDATE tbl_hr_employee set status='1' WHERE ID='". $data_employee_id ."'" );
                                    }

                                    mysqli_query( $conn,"UPDATE tbl_user set is_verified='1' WHERE ID='". $ID ."'" );
                                    $confirm = true;
                                }
                            }

                            // Forgot
                            if ( !empty( $_GET['i'] ) AND !empty( $_GET['f'] ) AND $_GET['f'] == 1 ) {
                                $ID = $_GET['i'];
                                $password = "Interlink2022";
                                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                                mysqli_query( $conn,"UPDATE tbl_user set password='". $password_hash ."' WHERE is_verified = 1 AND is_active = 1 AND ID='". $ID ."'" );
                                if (!mysqli_error($conn)) {
                                    $confirm = true;
                                }
                            }
                        ?>

                        <!-- LOGIN FORM -->
                        <form method="post" class="formSignIn">
                            <div class="alert_msg"><?php echo $confirm === true ? '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;"><button class="close" data-close="alert"></button>Account confirmed! Please enter your login details</div>' : ''; ?></div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        <input type="text" class="form-control" placeholder="Username / Email Address" name="username" autocomplete="off" required />
                                        <!-- <label>Username / Email</label> -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        <!-- <input type="password" class="form-control" name="password" autocomplete="off" required /> -->
                                        
                                        <div class="input-icon right">
                                            <i class="fa fa-eye font-green viewPW"></i>
                                            <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required />
                                        </div>
                                        <!-- <label>Password</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 margin-top-10">
                                    <div class="rem-password hide">
                                        <label class="rememberme mt-checkbox mt-checkbox-outline">
                                            <input type="checkbox" name="remember" value="1" /> Remember me
                                            <span></span>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-success ladda-button" id="btnSignIn" data-style="zoom-out"><span class="ladda-label">Sign In</span></button>
                                    <a href="javascript:;" id="btnForget" class="btn btn-link">Forgot Password?</a>
                                </div>
                                <div class="col-sm-6 margin-top-10 text-right">
                                    <a href="javascript:;" id="btnJoin" class="btn btn-success btn-outline green">Join Interlink</a>
                                </div>
                            </div>
                            <div class="row hide" style="margin-top: 2rem;">
                                <div class="col-sm-12 text-center">
                                    <a href="javascript:;" id="btnJoin" class=" btn btn-success">Join Interlink</a>
                                </div>
                            </div>
                        </form>

                        <!-- FORGOT PASSWORD FORM -->
                        <form method="post" class="formReset display-hide">
                            <h3 class="font-green">Forgot Password ?</h3>
                            <p> Enter your e-mail address below to reset your password. </p>
                            <div class="alert_msg"></div>

                            <div class="form-group">
                                <input class="form-control" type="email" autocomplete="off" placeholder="Email Address" name="email" required />
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn green btn-outline btnBack">Back</button>
                                <button type="submit" class="btn btn-success pull-right ladda-button" id="btnReset" data-style="zoom-out"><span class="ladda-label">Reset Password</span></button>
                            </div>
                        </form>

                        <!-- REGISTRATION FORM -->
                        <form method="post" class="formSignUp display-hide">
                            <h3 class="font-green">Register Here !</h3>
                            <p> Enter your details below to create your account. </p>
                            <div class="alert_msg"></div>
                            <input class="form-control" type="hidden" name="ID" value="<?php echo $invited_id; ?>" />
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" type="text" autocomplete="off" placeholder="Enter Your Username" name="username" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" autocomplete="off" placeholder="Enter Your Email" name="email" value="<?php echo $predefine === true ? $data_email : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required/>
                                    </div>
                                </div>
                                <div class="col-sm-6 hide">
                                    <div class="form-group">
                                        <select class="form-control" name="type">
                                            <option value="">Select Type</option>
                                            <option value="1">Enterprise</option>
                                            <option value="2">Job Seeker</option>
                                            <option value="3">Employee</option>
                                            <option value="4">Customer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-eye font-green viewPW"></i>
                                            <input class="form-control" type="password" autocomplete="off" placeholder="Enter Your Password" name="password" id="password" required />
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-eye font-green viewPW"></i>
                                            <input class="form-control" type="password" autocomplete="off" placeholder="Enter Your Confirm Password" name="confirm_password" required /> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" autocomplete="off" placeholder="Enter Your First Name" name="first_name" value="<?php echo $predefine === true ? $data_first_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required /> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" autocomplete="off" placeholder="Enter Your Last Name" name="last_name" value="<?php echo $predefine === true ? $data_last_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required /> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label>Company Name</label>
                                <input class="form-control" type="text" autocomplete="off" placeholder="Enter Your Company Name(Optional)" name="company_name" /> 
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn green btn-outline btnBack">Back</button>
                                <button type="submit" class="btn btn-success pull-right ladda-button" id="btnSignUp" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
                                <ul class="login-social">
                                    <li>
                                        <a href="https://web.facebook.com/search/top?q=consultare%20inc">
                                            <i class="icon-social-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-dribbble"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>Copyright &copy; Consultare Inc. 2022</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-1 -->
        <!--[if lt IE 9]>
        <script src="assets/global/plugins/respond.min.js"></script>
        <script src="assets/global/plugins/excanvas.min.js"></script> 
        <script src="assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login-5.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/ui-buttons.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <!-- CUSTOM THEME PAGE SCRIPTS -->
        <script type="text/javascript">
            $(document).ready(function(){
 
                <?php if ($predefine == true) { ?>
                    Reg();
                <?php } ?>
                

                $("#btnJoin").click(function(){ Reg(); });
                function Reg() { $(".formSignIn").hide(),$(".formSignUp").show() }

                $("#btnForget").click(function(){ Forgot(); });
                function Forgot() { $(".formSignIn").hide(),$(".formReset").show() }

                $(".btnBack").click(function(){
                   $(this).parent().parent().hide(),$(".formSignIn").show()
                });

                $('.formSignIn').validate({ // initialize the plugin
                    errorElement: 'span'
                });
                $('.formSignUp').validate({ // initialize the plugin
                    rules : {
                        password : {
                            minlength : 5
                        },
                        confirm_password : {
                            minlength : 5,
                            equalTo : "#password"
                        }
                    }
                });

                $('.viewPW').click(function(){
                    var x = $(this).next().attr('type');
                    if (x === "password") {
                        $(this).next().prop("type", "text");
                        $(this).addClass('fa-eye-slash');
                    } else {
                        $(this).next().prop("type", "password");
                        $(this).removeClass('fa-eye-slash');
                    }
                });
            });

            $('#btnSignIn').click(function(e){
                e.preventDefault();

                formObj = $(this).parents().parents().parents();
                if (!formObj.validate().form()) return false;

                var data = $('.formSignIn').serialize()+'&btnSignIn=btnSignIn';

                var l = Ladda.create(this);
                l.start();

                $.ajax({
                    url:'function.php',
                    type:'post',
                    dataType:'JSON',
                    data:data,
                    success:function(response) {
                        if (response.exist == true) {
                            var data = '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';

                            window.location.href = 'profile';
                        } else {
                            var data = '<div class="alert alert-danger display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        }
                        $('.formSignIn .alert_msg').html(data);
                        l.stop();
                    }
                });
            });

            $('#btnReset').click(function(e){
                e.preventDefault();

                formObj = $(this).parents().parents();
                if (!formObj.validate().form()) return false;

                var data = $('.formReset').serialize()+'&btnReset=btnReset';

                var l = Ladda.create(this);
                l.start();

                $.ajax({
                    url:'function.php',
                    type:'post',
                    dataType:'JSON',
                    data:data,
                    success:function(response) {
                        if (response.exist == true) {
                            var data = '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        } else {
                            var data = '<div class="alert alert-danger display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        }
                        $('.formReset .alert_msg').html(data);
                        l.stop();
                    }
                });
            });

            $('#btnSignUp').click(function(e){
                e.preventDefault();

                formObj = $(this).parents().parents();
                if (!formObj.validate().form()) return false;

                var data = $('.formSignUp').serialize()+'&btnSignUp=btnSignUp';

                var l = Ladda.create(this);
                l.start();

                $.ajax({
                    url:'function.php',
                    type:'post',
                    dataType:'JSON',
                    data:data,
                    success:function(response) {
                        if (response.exist == false) {
                            var data = '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        } else {
                            var data = '<div class="alert alert-danger display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        }
                        $('.formSignUp .alert_msg').html(data);
                        l.stop();
                    }
                });
            });
        </script>
    </body>

</html>