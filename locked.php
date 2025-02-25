<?php include_once 'database_iiq.php'; ?>
<?php
    if (!isset($_COOKIE['locked'])) {
        setcookie('locked', 1, time() + (86400 * 1), "/");  // 86400 = 1 day
    }

    $current_userID = '';
    $current_client = '';
    $current_userEmployeeID = '';
    $current_userFName = '';
    $current_userLName = '';
    $current_userName = '';
    $current_userEmail = '';
    $current_userMobile = '';
    $current_userInterest = '';
    $current_userOccupation = '';
    $current_userAbout = '';
    $current_userWebsite = '';
    $current_userAvatar = '';
    $current_userPrivacy = '';

    if (!isset($_COOKIE['ID'])) {
        echo '<script>window.location.href = "login";</script>';
    } else {
        $user_id = $_COOKIE['ID'];
        $current_client = $_COOKIE['client'];

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $user_id" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $current_userID = $rowUser['ID'];
            $current_userEmployeeID = $rowUser['employee_id'];
            $current_userFName = $rowUser['first_name'];
            $current_userLName = $rowUser['last_name'];
            $current_userName = $rowUser['username'];
            $current_userEmail = $rowUser['email'];
        }

        $selectUserInfo = mysqli_query( $conn,"SELECT * from tbl_user_info WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectUserInfo) > 0 ) {
            $rowUserInfo = mysqli_fetch_array($selectUserInfo);
            $current_userMobile = $rowUserInfo['mobile'];
            $current_userInterest = $rowUserInfo['interest'];
            $current_userOccupation = $rowUserInfo['occupation'];
            $current_userAbout = $rowUserInfo['about'];
            $current_userWebsite = $rowUserInfo['website'];
            $current_userAvatar = $rowUserInfo['avatar'];
            $current_userPrivacy = $rowUserInfo['privacy'];
        }
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
        <title>Locked Screen</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #2 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../assets/pages/css/lock.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="../assets/img/interlink icon.png" />
        <link href="custom.css" rel="stylesheet" type="text/css" />
    </head>
    <!-- END HEAD -->

    <body class="">
        <div class="page-lock">
            <div class="page-logo">
                <a class="brand" href="index.html"><img src="assets/img/interlinkiq v3.png" alt="logo" style="max-width: 250px; filter: brightness(0) invert(1);" /> </a>
            </div>
            <div class="alert_msg"></div>
            <div class="page-body">
                <div class="lock-head"> Locked </div>
                <div class="lock-body">
                    <div class="pull-left lock-avatar-block">
                        <?php
                            if ( empty($current_userAvatar) ) {
                                echo '<img src="//via.placeholder.com/110x110/EFEFEF/AAAAAA.png?text=no+image" class="lock-avatar" alt="Avatar" />';
                            } else {
                                echo '<img src="uploads/avatar/'. $current_userAvatar .'" class="lock-avatar" alt="Avatar" />';
                            }
                        ?>
                    </div>
                    <form method="post" class="lock-form pull-left formSignIn">
                        <h4><?php echo $current_userFName .' '. $current_userLName; ?></h4>
                        <input class="form-control" type="hidden" name="email" value="<?php echo $current_userEmail; ?>" />
                        <input class="form-control" type="hidden" name="client" value="<?php echo $current_client; ?>" />
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" autocomplete="off" required />
                        </div>
                        <div class="form-actions">
                            <input type="submit" class="btn red uppercase" id="btnSignIn" value="Login" />
                        </div>
                    </form>
                </div>
                <div class="lock-bottom">
                    <a href="javascript:;" onclick="btnLogout()">Do you want to Logout?</a>
                </div>

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
            <div class="page-footer-custom">2022 &copy; <a target="_blank" href="https://Consultareinc.com">INTERLINKIQ. V1</a></div>
        </div>
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
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/lock.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->

        <script type="text/javascript">
            $(document).ready(function(){
                BtnSignIn.init()
                $('.formSignIn').validate({ // initialize the plugin
                    errorElement: 'span'
                });
            });

            function btnLogout() {
                var id = '<?php echo $current_userID; ?>';
                window.location.href = 'function.php?logout='+id;
                // $.ajax({
                //     url: 'function.php?logout='+id,
                //     context: document.body,
                //     contentType: false,
                //     processData:false,
                //     cache: false,
                //     success: function(response) {
                //         window.location.href = response;
                //     }
                // });
            }

            var BtnSignIn=function(){
                return{
                    init:function(){
                        $("#btnSignIn").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formSignIn').serialize()+'&btnSignIn=btnSignIn';
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

                                        prev_link = document.referrer;
                                        if (prev_link == "") { window.location.href = "profile"; }
                                        else { window.location.href = prev_link;  }
                                    } else {
                                        var data = '<div class="alert alert-danger display-hide" style="display: block; margin-top: 0;">';
                                        data += '<button class="close" data-close="alert"></button>';
                                        data += response.message;
                                        data += '</div>';
                                    }
                                    $('.page-lock .alert_msg').html(data);
                                }
                            });
                        })
                    }
                }
            }();

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
