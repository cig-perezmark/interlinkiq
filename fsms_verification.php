<?php 
    session_start();
    if(!isset($_SESSION['email'])){
        //echo "no session"; redirect back to login or register
        header('Location: http://192.168.2.103:8080/interlink_system/theme/admin_2/fsms_login_page.html');
    }else{
        //echo $_SESSION['email'];
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
        <meta charset="utf-8" />
        <title>FSMS Verification</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #2 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(../assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src="../assets/pages/img/login/fsms_logo.png" width="150" height="150" /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
            
                    <div class="login-content">
                        <h1>Welcome to Interlink</h1>
                        <p> Where process meets industry connectivity developed for "You", the owner, entrepreneur, operator, the agent in charge of a facility or process, the practitioner. </p>
                        <form action="javascript:;" method="post">
                            
                            <h3 class="font-green">Verify your account.</h3>
                            <p id="verification-form-instructions"  class=""> Enter the verification code sent to <b class="font-primary"><?php echo $_SESSION['email']; ?></b> for verification. </p>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Verification Code" id="c_verification_code" name="c_verification_code" maxlength="5" /> </div>
                            <div class="form-actions">
                                <!--button type="button" id="back-btn" class="btn green btn-outline">Back</button-->
                                <button id="c_verification_code-submit-btn" type="submit" class="btn btn-success uppercase pull-right" disabled>Submit</button>
                            </div>
                            
                            <!-- 5/2/2022 New Requirement for Interlink System, AC - Registration Form -->
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
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->


        <!-- CUSTOM THEME PAGE SCRIPTS -->
        <script type="text/javascript">
            $(document).ready(function(){
                //Global Var
                var email = '<?php echo $_SESSION['email']; ?>';
                var verification_code = '<?php echo $_SESSION['verification_code']; ?>';
                var c_verification_code;

                //update_flag
                var update_flag=false;
                var default_instructions = "Enter the verification code sent to <b>"+email+"</b> for verification.";

                //prevent backbutton on browser

                history.pushState(null, null, location.href);
                window.onpopstate = function () {
                    history.go(1);
                };

                console.log(email+" "+verification_code);
                
                //prevent backbutton on browser
               
                $('#c_verification_code').keyup(function(e){
                    console.log($('#c_verification_code').val());
                     $('#verification-form-instructions').html(default_instructions);
                    $('#verification-form-instructions').removeClass('font-red');
                    var verification_code_len = $('#c_verification_code').val();
                    c_verification_code = $('#c_verification_code').val();
                    if(verification_code_len.length == 5){
                        $('#c_verification_code-submit-btn').prop('disabled',false);

                    }else{
                        $('#c_verification_code').removeClass('has-error');
                        $('#c_verification_code-submit-btn').prop('disabled',true);
                    }
                    console.log(verification_code_len.length);
                });

                $('#c_verification_code-submit-btn').click(function(){
                    var res1 = checkStringForSpecialCharacter(c_verification_code); //check for illegal characters
                    var res = checkVerificationCode(c_verification_code); //check if generated code = input code
                    console.log("verification code input and in session is = "+res);

                    if(res == true && res1 == false){//generated verification code is not equal to the input verification code
                        updateStatusToVerified();
                        $('#verification-form-instructions').addClass('font-green');
                        $('#verification-form-instructions').html("Successfully Verified! You may now login. Thanks!");
                          setTimeout(function(){ $('#c_verification_code').val(""); }, 500); //empty 
                         setTimeout(function(){ window.location.href = "http://192.168.2.103:8080/interlink_system/theme/admin_2/fsms_verification.php"; }, 1500);
                    }else{
                        $('#c_verification_code').addClass('has-error');
                        //$('#verification-form-instructions-div').removeClass('display-hide').addClass('display-show');
                        $('#verification-form-instructions').addClass('font-red');
                        $('#verification-form-instructions').html("Verification code error! Please check the email <b>"+email+"</b>.");
                    }
                });

                function checkStringForSpecialCharacter(c_verification_code){
                    //console.log('word is='+str);
                    if (/^[a-zA-Z0-9- ]*$/.test(c_verification_code) == false) {
                        //alert('Your String Contains illegal Characters.');
                        return true; //return true if contains illegal
                    }

                    return false;//return false if it does not
                }

                function checkVerificationCode(c_verification_code){
                    if(verification_code === c_verification_code){
                        //c_verification_code = verification_code;
                        return true;

                    }else{
                        return false;
                    }
                }

                function updateStatusToVerified(){
                    var data = "&email="+email+"&verification_code="+c_verification_code;
                    console.log("data to be updated to verified"+data);
                    $.ajax({
                            url: "../assets/pages/ajax/users.action.php",
                        type: "POST",
                        data: "action=update-verified-status"+data,
                        success: function(result) {
                            console.log("update = "+result);
                            /*if(result == "true"){
                                validationEmail_flag = true;

                            }else if(result == "false"){
                                validationEmail_flag = false;
                            }*/
                        } 
                    });
                }
            });
        </script>
    </body>

</html>
