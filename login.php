<?php include_once 'database_iiq.php'; ?>
<?php
    // echo '<script>alert(document.referrer);</script>';
    if(isset($_COOKIE['ID'])) {
        // $url='profile';
        // $url=$_SERVER['HTTP_REFERER'];
        // // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
        // // header('Location: profile');
        
        echo '<script>
            prev_link = document.referrer;
            if (prev_link == "") {
                window.location.href = "profile";
            } else if (prev_link.indexOf("management_services") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("directory") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("blog_posts_table") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("forum") > -1) {
                window.location.href = "profile";
            } else if (prev_link == "https://interlinkiq.com/") {
                window.location.href = "profile";
            } else if (prev_link == "https://www.interlinkiq.com/") {
                window.location.href = "profile";
            } else {
                // window.history.back();
                window.location.href = "profile";
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
        <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="assets/img/interlink icon.png" />
        <link href="custom.css" rel="stylesheet" type="text/css" />
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="/"><img src="assets/img/interlinkiq%20v3.png" alt="" style="height: 70px; filter: brightness(0) invert(1);" /></a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content" style="margin-top: 0;">
            <?php
                $confirm = false;
                $predefine = false;
                $ID = '';

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

                // Reset
                if ( !empty( $_GET['i'] ) AND !empty( $_GET['p'] ) AND $_GET['p'] == 1 ) {
                    $ID = $_GET['i'];
                } 
            ?>

            <!-- Login Section -->
            <form method="post" class="login-formx formSignIn">
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert_msg"><?php echo $confirm === true ? '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;"><button class="close" data-close="alert"></button>Account confirmed! Please enter your login details</div>' : ''; ?></div>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <input class="form-control" type="hidden" name="client" value="0" />
                <div class="form-group">
                    <label class="control-label">Email Address</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="email" value="" autocomplete="off" name="email" required />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div class="input-icon right">
                        <i class="fa fa-eye font-green viewPW"></i>
                        <input type="password" class="form-control form-control-solid placeholder-no-fix" name="password" value="" autocomplete="off" required />
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success ladda-button" id="btnSignIn" data-style="zoom-out"><span class="ladda-label">Login</span></button>
                    <a href="javascript:;" id="btnForget" class="forget-password">Forgot Password?</a>
                </div>
                <div class="create-account" style="background-color:#1C3879;color:#fff; border-radius: 5px !important; margin: unset;">
                    <p>
                        <a href="javascript:;" id="btnJoin" class="uppercase ">Create A Free Account</a>
                    </p>
                </div>
            </form>
            
            <!-- Registration Section -->
            <form method="post" class="register-form formSignUp display-hide">
                <h3 class="font-green">FREE ACCOUNT SIGNUP</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="alert_msg"></div>
                <input class="form-control" type="hidden" name="ID" value="<?php echo !empty($invited_id) ? $invited_id : ''; ?>" />
                <input class="form-control" type="hidden" name="client" value="0" />
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input class="form-control placeholder-no-fix" type="text" name="first_name" value="<?php echo $predefine === true ? $data_first_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
                </div>
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input class="form-control placeholder-no-fix" type="text" name="last_name" value="<?php echo $predefine === true ? $data_last_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control placeholder-no-fix" type="email" name="email" value="<?php echo $predefine === true ? $data_email : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div class="input-icon right">
                        <i class="fa fa-eye font-green viewPW"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="password" name="password" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Re-type Your Password</label>
                    <div class="input-icon right">
                        <i class="fa fa-eye font-green viewPW"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" name="rpassword" required /> 
                    </div>
                </div>
                <div class="form-group hide" id="secPurpose">
                    <label>Purpose</label>
                    <div class="mt-radio-list">
                        <label class="mt-radio mt-radio-outline"> Are you an organization?
                            <input type="radio" value="0" name="purpose" checked="checked">
                            <span></span>
                        </label>
                        <label class="mt-radio mt-radio-outline"> Are you a specialist/consultant?
                            <input type="radio" value="1" name="purpose">
                            <span></span>
                        </label>
                        <label class="mt-radio mt-radio-outline"> Are you a job seeker?
                            <input type="radio" value="2" name="purpose">
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group margin-top-20 margin-bottom-20 hide">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> I agree to the
                        <a href="javascript:;">Terms of Service </a> &
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline btnBack">Back</button>
                    <button type="submit" class="btn btn-success pull-right ladda-button" id="btnSignUp" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>

            <!-- Forgot Password Section -->
            <form method="post" class="forget-form formReset display-hide">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="alert_msg"></div>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" required />
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline btnBack">Back</button>
                    <button type="button" class="btn btn-success pull-right pull-right ladda-button" id="btnReset" data-style="zoom-out"><span class="ladda-label">SUBMIT</span></button>
                </div>
            </form>
            
            <!-- Reset Password Section -->
            <form method="post" class="forget-form formResetPassword display-hide">
                <h3 class="font-green">Update Password</h3>
                <p>Please check you email and enter the details below.</p>
                <div class="alert_msg"></div>
                <input class="form-control" type="hidden" name="ID" value="<?php echo $ID; ?>" />
                <div class="form-group">
                    <label class="control-label">Verification Code</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="number" autocomplete="off" name="code" value="" required />
                </div>
                <div class="form-group">
                    <label class="control-label">New Password</label>
                    <div class="input-icon right">
                        <i class="fa fa-eye font-green viewPW"></i>
                        <input type="password" class="form-control form-control-solid placeholder-no-fix" id="npassword" name="npassword" autocomplete="off" value="" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Confirm New Password</label>
                    <div class="input-icon right">
                        <i class="fa fa-eye font-green viewPW"></i>
                        <input type="password" class="form-control form-control-solid placeholder-no-fix" name="cnpassword" autocomplete="off" value="" required />
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline btnBack">Back</button>
                    <button type="button" class="btn btn-success pull-right pull-right ladda-button" id="btnResetPassword" data-style="zoom-out"><span class="ladda-label">SUBMIT</span></button>
                </div>
            </form>

            <!-- Service Modal Section -->
            <div class="modal fade" id="modalService" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalService">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Service Request</h4>
                            </div>
                            <div class="modal-body">
                                <input class="form-control" type="hidden" name="ID" value="0" />
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Category</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="category" required>
                                            <option value=""></option>
                                            <option value="1">IT Services</option>
                                            <option value="2">Techinical Services</option>
                                            <option value="3">Sales</option>
                                            <option value="4">Request Demo</option>
                                            <option value="5">Suggestion</option>
                                            <option value="6">Problem</option>
                                            <option value="7">Praise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Request Title</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" name="title" placeholder="Example: Website, SOP, etc" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="description" placeholder="Describe your service request here" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Number</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" name="contact" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="email" name="email" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Attached Reference File</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="file" name="file" />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success ladda-button" id="btnSave_Services" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright"> 2022 © Interlink IQ</div>
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

        <script src="assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <!-- <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->

        <script type="text/javascript">
            $(document).ready(function(){
                $(".modalService").validate();
 
                <?php if ($predefine == true) { ?> Reg(); <?php } ?>
                
                <?php if ( !empty( $_GET['i'] ) AND !empty( $_GET['p'] ) AND $_GET['p'] == 1 ) { ?> ResetPassword(); <?php } ?>
                function ResetPassword() {
                    $(".formSignIn").hide();
                    $(".formReset").hide();
                    $(".formSignUp").hide();
                    $(".formResetPassword").show();
                }
                
                $("#btnJoin").click(function(){ Reg(); });
                function Reg() { $(".formSignIn").hide(),$(".formSignUp").show(); }

                $("#btnForget").click(function(){ Forgot(); });
                function Forgot() { $(".formSignIn").hide(),$(".formReset").show(); }

                $(".btnBack").click(function(){
                   $(this).parent().parent().hide(),$(".formSignIn").show();
                });

                $('.formSignUp').validate({ // initialize the plugin
                    rules : {
                        password : {
                            minlength : 5
                        },
                        rpassword : {
                            minlength : 5,
                            equalTo : "#password"
                        }
                    }
                });
                $('.formResetPassword').validate({ // initialize the plugin
                    rules : {
                        npassword : {
                            minlength : 5
                        },
                        cnpassword : {
                            minlength : 5,
                            equalTo : "#npassword"
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

                prev_link = document.referrer;
                if (prev_link.indexOf('special') > -1) { $('#secPurpose').removeClass('hide'); }
            });

            $('#btnSignIn').click(function(e){
                e.preventDefault();

                formObj = $(this).parents().parents();
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

                            // window.location.href = 'profile';
                            // localStorage.setItem('islogin','yes');

                            localStorage.setItem('islogin','yes');

                            prev_link = document.referrer;
                            if (prev_link.indexOf('forum/index.php') > -1) { window.location.href = prev_link; }
                            else if (prev_link.indexOf('special') > -1) { window.location.href = prev_link; }
                            else if (prev_link.indexOf('marketplace-view') > -1) { window.location.href = prev_link; }
                            else { window.location.href = 'profile'; }
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

                            $(".formSignUp").hide();
                            $(".formSignIn").show();

                            $('.formSignIn .alert_msg').html(data);
                        } else {
                            var data = '<div class="alert alert-danger display-hide" style="display: block; margin-top: 0;">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                            
                            $('.formSignUp .alert_msg').html(data);
                        }
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
                        console.log(response);
                        if (response.exist == true) {
                            var data = '<div class="alert alert-success">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        } else {
                            var data = '<div class="alert alert-danger">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                        }
                        $('.formReset .alert_msg').html(data);
                        l.stop();
                    }
                });
            });
            $('#btnResetPassword').click(function(e){
                e.preventDefault();

                formObj = $(this).parents().parents();
                if (!formObj.validate().form()) return false;

                var data = $('.formResetPassword').serialize()+'&btnResetPassword=btnResetPassword';

                var l = Ladda.create(this);
                l.start();

                $.ajax({
                    url:'function.php',
                    type:'post',
                    dataType:'JSON',
                    data:data,
                    success:function(response) {
                        if (response.exist == true) {
                            var data = '<div class="alert alert-success">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';

                            $(".formResetPassword").hide();
                            $(".formSignIn").show();
                            
                            $('.formSignIn .alert_msg').html(data);
                        } else {
                            var data = '<div class="alert alert-danger">';
                            data += '<button class="close" data-close="alert"></button>';
                            data += response.message;
                            data += '</div>';
                            
                            $('.formResetPassword .alert_msg').html(data);
                        }
                        l.stop();
                    }
                });
            });


            $(".modalService").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Services',true);

                var l = Ladda.create(document.querySelector('#btnSave_Services'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Service Request has been sent!";
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        $.bootstrapGrowl(msg,{
                            ele:"body",
                            type:"success",
                            offset:{
                                from:"top",
                                amount:100
                            },
                            align:"right",
                            width:250,
                            delay:5000,
                            allow_dismiss:1,
                            stackup_spacing:10
                        })
                    }        
                });
            }));
        </script>
    </body>
</html>