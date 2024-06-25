<?php include_once 'database_iiq.php'; ?>

<?php
//     $servername='localhost';
// 	$username='brandons_interlinkiq';
// 	$password='L1873@2019new';
// 	$dbname = "brandons_interlinkiq";
// 	$conn=mysqli_connect($servername,$username,$password,"$dbname");
// 	if(!$conn){
// 	   die('Could not Connect My Sql:' .mysql_error());
// 	}
//     $breadcrumbs = '';
//     $sub_breadcrumbs = '';

//     if ($sub_breadcrumbs) {
//         $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
//     }
//     $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // for local dev setup
    if(file_exists('local-dev.php')) {
        include_once 'local-dev.php';
    }
    
    $base_url = isset($localBaseUrl) ? $localBaseUrl : "https://interlinkiq.com/";
    $switch_user_id = '';
    $user_id = '';
    $current_client = 0;
    $current_userID = '';
    $current_userEmployeeID = '';
    $current_userEmployerID = '';
    $current_userAdminAccess = 0;
    $current_userFName = '';
    $current_userLName = '';
    $current_userEmail = '';
    $current_userType = '';
    $current_userMobile = '';
    $current_userInterest = '';
    $current_userAddress = '';
    $current_userDLicense = '';
    $current_userAlarmCode = '';
    $current_userOccupation = '';
    $current_userAbout = '';
    $current_userAvatar = '';
    $current_userPrivacy = '0, 0, 0, 0, 0';

    $current_userWebsite = '';
    $current_userLinkedIn = '';
    $current_userFacebook = '';
    $current_userTwitter = '';
    $current_userPage = '';
        
    $current_dateNow_o = date('Y/m/d');
    $current_dateNow = new DateTime($current_dateNow_o);
    $current_dateNow = $current_dateNow->format('M d, Y');
    
    $FreeAccess = 0;
    $enterp_logo = '';
    
    if (isset($_COOKIE['locked'])) {
        echo '<script>window.location.href = "locked";</script>';
        exit();
    }
    
    if (!isset($_COOKIE['ID'])) {
        // $url='login';
        // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
        // header('Location: login');

        // if (isset($_SERVER["HTTP_REFERER"])) {
        //     header("Location: " . $_SERVER["HTTP_REFERER"]);
        // }
        
        echo '<script>
            window.location.href = "login";
            // if (document.referrer == "") {
            //     window.location.href = "login";
            // } else {
            //     window.history.back();
            // }
        </script>';
        exit();
    } else {
        $user_id = $_COOKIE['ID'];
        $current_client = $_COOKIE['client'];
        $current_userWebsite = '';
        $current_userLinkedIn = '';
        $current_userFacebook = '';
        $current_userTwitter = '';
        $current_userPage = '';

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $user_id" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $current_userID = $rowUser['ID'];
            $current_userEmployeeID = $rowUser['employee_id'];
            $current_userFName = htmlentities($rowUser['first_name']);
            $current_userLName = htmlentities($rowUser['last_name']);
            $current_userEmail = htmlentities($rowUser['email']);
            $current_userType = $rowUser['type'];
        }

        $selectUserInfo = mysqli_query( $conn,"SELECT * from tbl_user_info WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectUserInfo) > 0 ) {
            $rowUserInfo = mysqli_fetch_array($selectUserInfo);
            $current_userMobile = htmlentities($rowUserInfo['mobile']);
            $current_userInterest = htmlentities($rowUserInfo['interest']);
            $current_userAddress = htmlentities($rowUserInfo['address']);
            $current_userDLicense = htmlentities($rowUserInfo['driver_license']);
            $current_userOccupation = htmlentities($rowUserInfo['occupation']);
            $current_userAbout = htmlentities($rowUserInfo['about']);
            $current_userWebsite = htmlentities($rowUserInfo['website']);
            $current_userAvatar = htmlentities($rowUserInfo['avatar']);
            if (!empty($rowUserInfo['privacy'])) { $current_userPrivacy = $rowUserInfo['privacy']; }
        }

        $selectSM = mysqli_query( $conn,"SELECT * from tbl_user_social_media WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectSM) > 0 ) {
            $rowSM = mysqli_fetch_array($selectSM);
            $current_userLinkedIn = htmlentities($rowSM['linkedin']);
            $current_userFacebook = htmlentities($rowSM['facebook']);
            $current_userTwitter = htmlentities($rowSM['twitter']);
            $current_userPage = htmlentities($rowSM['page']);
        }
        
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
                $current_userEmployerDEP = $rowEmployer['department_id'];
                $current_userAdminAccess = $rowEmployer["admin"];
                $current_userAlarmCode = $rowEmployer['alarm_code'];
            }
        } else {
            $current_userEmployerID = $current_userID;
        }
        
        // For Switch Account Profie
        if (isset($_COOKIE['switchAccount'])) {
            $id = $_COOKIE['switchAccount'];
            // $FreeAccess = false;
    
            $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $id" );
            if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                $enterp_id = $rowEnterprise['enterp_id'];
                $enterp_logo = $rowEnterprise['BrandLogos'];
                $enterp_name = htmlentities($rowEnterprise['businessname']);
                $enterp_userID = $rowEnterprise['users_entities'];
            }
        } else {
            $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $current_userEmployerID" );
            if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                $enterp_id = $rowEnterprise['enterp_id'];
                $enterp_logo = $rowEnterprise['BrandLogos'];
                $enterp_name = htmlentities($rowEnterprise['businessname']);
                $enterp_userID = $rowEnterprise['users_entities'];
            }
                
            // For Employee ONLY
            if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) {
        
                if ($current_userAdminAccess == 0) {
                    // Base on Current Page
                    $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE collab = 1 AND deleted = 0 AND name='".$site."'" );
                    if ( mysqli_num_rows($selectMenu) > 0 ) {
                        $rowMenu = mysqli_fetch_array($selectMenu);
                        $assigned_to_id = $rowMenu['assigned_to_id'];
            
                        // Redirect to 404 if no assigned
                        if (!empty($assigned_to_id)) {
                            $output = json_decode($assigned_to_id, true);
                            $exist = 0;
                            foreach ($output as $key => $value) {
                                if ($current_userEmployerID == $key) {
                                    if (in_array($current_userEmployeeID, $value['assigned_to_id'])) {
                                        $exist++;
                                        break;
                                    }
                                }
                            }
            
                            if ($exist == 0) {
                                echo '<script>window.location.href = "404";</script>';
                            }
                        } else {
                            echo '<script>window.location.href = "404";</script>';
                        }
                    }
                }
            }
            
            // $selectCustomer = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND status = 1 AND is_deleted = 0 AND email = '".$current_userEmail."'" );
            // if ( mysqli_num_rows($selectCustomer) > 0 ) { $FreeAccess = false; }
        }

    }

    function fileExtension($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        $type = 'iframe';
        if (strtolower($extension) == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
        else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
        else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
        else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
        else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
        else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
        else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

        $output['src'] = $src;
        $output['embed'] = $embed;
        $output['type'] = $type;
        $output['file_extension'] = $file_extension;
        $output['file_mime'] = $extension;
        return $output;
    }
    function employerID($ID) {
        global $conn;

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }

        return $current_userEmployerID;
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
    <!-- Google tag (gtag.js) -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-TKPT68LJ8H"></script>-->
    <!--<script>-->
    <!--    window.dataLayer = window.dataLayer || [];-->
    <!--    function gtag(){dataLayer.push(arguments);}-->
    <!--    gtag('js', new Date());-->

    <!--    gtag('config', 'G-TKPT68LJ8H');-->
    <!--</script>-->

    <base href="">
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #2 for statistics, charts, recent events and reports" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" />
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    <link rel="stylesheet" type="text/css" href="https://htmlguyllc.github.io/jAlert/dist/jAlert.css">
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN PAGE DATATABLE LEVEL PLUGINS -->
    <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <link href="assets/apps/css/todo-2.min.css" rel="stylesheet" type="text/css" />

    <!-- Summernote CSS - CDN Link -->
    <link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- //Summernote CSS - CDN Link -->

    <link rel="shortcut icon" href="assets/img/interlink icon.png" />
    <link href="custom.css" rel="stylesheet" type="text/css" />
    <script src="//js.chargebee.com/v2/chargebee.js" data-cb-site="consultareinc"></script>

    <!--chat bot-->
    <link rel="stylesheet" href="Chat_Bot/assets/style.css">
    <!--end chat bot-->
    <style type="text/css">
    <?php if (isset($_COOKIE['switchAccount'])) {
        $switch_user_id=$_COOKIE['switchAccount'];

        $selectUserSwitch=mysqli_query($conn, "SELECT * from tbl_user WHERE ID = $switch_user_id");

        if (mysqli_num_rows($selectUserSwitch) > 0) {
            $rowUserSwitch=mysqli_fetch_array($selectUserSwitch);
            $current_userEmail=htmlentities($rowUserSwitch['email']);
        }
    }

    else {
        $switch_user_id=$current_userEmployerID;
    }


    // $selectCustomer = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND status = 1 AND is_deleted = 0 AND email = '".$current_userEmail."'" );
    // if ( mysqli_num_rows($selectCustomer) > 0 ) {
    $selectMenuAccess=mysqli_query($conn, "SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 AND url = '".$site."'");

    if (mysqli_num_rows($selectMenuAccess) > 0) {
        $rowMenu=mysqli_fetch_array($selectMenuAccess);
        $menu_ID=$rowMenu['ID'];

        $countRunning=0;
        $selectMenuSubs=mysqli_query($conn, "SELECT * FROM tbl_menu_subscription WHERE deleted = 0 AND menu_id = $menu_ID AND user_id = $switch_user_id");

        if (mysqli_num_rows($selectMenuSubs) > 0) {
            while($rowMenuSub=mysqli_fetch_array($selectMenuSubs)) {
                $sub_date_start=$rowMenuSub["date_start"];
                $sub_date_start=new DateTime($sub_date_start);
                $sub_date_start_o=$sub_date_start->format('Y/m/d');
                $sub_date_start=$sub_date_start->format('M d, Y');

                $sub_date_end=$rowMenuSub["date_end"];
                $sub_date_end=new DateTime($sub_date_end);
                $sub_date_end_o=$sub_date_end->format('Y/m/d');
                $sub_date_end=$sub_date_end->format('M d, Y');

                if ($sub_date_start_o <=$current_dateNow_o && $sub_date_end_o >=$current_dateNow_o) {
                    $countRunning++;
                }
            }

            if ($countRunning > 0) {
                $FreeAccess=0;
            }
        }
    }

    // } else {
    //     if ($switch_user_id == 34) { $FreeAccess = false; }
    // }

    $selectSettings=mysqli_query($conn, "SELECT * FROM tbl_settings WHERE reset=1 AND user_id=$switch_user_id ");

    if (mysqli_num_rows($selectSettings) > 0) {
        while($rowSettings=mysqli_fetch_array($selectSettings)) {
            $background=$rowSettings["background"];
            $array_background=explode(', ', $background);

            $bgHeader=$array_background[0];
            $bgHeaderLogo=$array_background[1];
            $bgSidebar=$array_background[2];
            $bgBody=$array_background[3];
        }

        echo '.page-header.navbar .page-logo { background: '. $bgHeaderLogo .'; }';
        echo '.page-header.navbar .page-top { background: '. $bgHeader .'; }';
        echo 'body, .page-sidebar, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover { background: '. $bgSidebar .'; }';
        echo '.page-container-bg-solid .page-content { background: '. $bgBody .'; }';
    }

    ?>body {
        top: unset !important;
    }

    body>div.skiptranslate {
        display: none;
    }

    #google_translate_element select {
        background: #f6edfd;
        color: #383ffa;
        border: none;
        border-radius: 3px;
        padding: 6px 8px
    }

    .goog-logo-link {
        display: none !important;
    }

    .goog-te-gadget {
        color: transparent !important;
    }

    .goog-te-banner-frame {
        display: none !important;
    }

    #goog-gt-tt,
    .goog-te-balloon-frame {
        display: none !important;
    }

    .goog-text-highlight {
        background: none !important;
        box-shadow: none !important;
    }

    #google_translate_element select {
        background: transparent;
        color: #000;
    }

    #googleTranslate {
        display: flex;
        align-items: center;
    }

    #googleTranslate .notranslate>div,
    #googleTranslate .notranslate>div>ul {
        width: auto;
    }

    .goog-te-gadget-icon {
        display: none;
    }


    /*OFFCANVAS*/
    .offcanvas-backdrop {
        background: #000;
        opacity: 0.5;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 9999;
    }

    .offcanvas-backdrop.show {
        position: fixed;
    }

    .offcanvas,
    .offcanvas-lg,
    .offcanvas-md,
    .offcanvas-sm,
    .offcanvas-xl,
    .offcanvas-xxl {
        --bs-offcanvas-zindex: 10050;
        --bs-offcanvas-width: 400px;
        --bs-offcanvas-height: 30vh;
        --bs-offcanvas-padding-x: 1rem;
        --bs-offcanvas-padding-y: 1rem;
        --bs-offcanvas-color: ;
        --bs-offcanvas-bg: #fff;
        --bs-offcanvas-border-width: 1px;
        --bs-offcanvas-border-color: var(--bs-border-color-translucent);
        --bs-offcanvas-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .offcanvas {
        position: fixed;
        bottom: 0;
        z-index: var(--bs-offcanvas-zindex);
        display: flex;
        flex-direction: column;
        max-width: 100%;
        color: var(--bs-offcanvas-color);
        visibility: hidden;
        background-color: var(--bs-offcanvas-bg);
        background-clip: padding-box;
        outline: 0;
        transition: transform .3s ease-in-out;
    }

    .offcanvas.offcanvas-end {
        top: 0;
        right: 0;
        width: var(--bs-offcanvas-width);
        border-left: var(--bs-offcanvas-border-width) solid var(--bs-offcanvas-border-color);
        transform: translateX(100%);
    }

    .offcanvas.hiding,
    .offcanvas.show,
    .offcanvas.showing {
        visibility: visible;
    }

    .offcanvas.show:not(.hiding),
    .offcanvas.showing {
        transform: none;
    }

    .offcanvas-header {
        padding: var(--bs-offcanvas-padding-y) var(--bs-offcanvas-padding-x);
    }

    .offcanvas-body {
        flex-grow: 1;
        padding: var(--bs-offcanvas-padding-y) var(--bs-offcanvas-padding-x);
        overflow-y: auto;
    }

    .d-flex {
        display: flex !important;
    }

    .position-relative {
        position: relative !important;
    }

    .position-absolute {
        position: absolute !important;
    }

    .flex-shrink-0 {
        flex-shrink: 0 !important;
    }

    .flex-grow-1 {
        flex-grow: 1 !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .p-1 {
        padding: .25rem !important;
    }

    .p-2 {
        padding: .5rem !important;
    }

    .mb-1 {
        margin-bottom: .25rem !important;
    }

    .mt-2 {
        margin-top: .5rem !important;
    }

    .ms-3 {
        margin-left: 1rem !important;
    }

    .mb-0 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .top-0 {
        top: 0 !important;
    }

    .bottom-0 {
        bottom: 0 !important;
    }

    .start-0 {
        left: 0 !important;
    }

    .end-0 {
        right: 0 !important;
    }

    .excerpt:hover {
        background: #f3f3f3;
    }

    .excerpt p {
        /*display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                */
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /*MODAL CHAT*/
    .overflow-auto {
        overflow: auto !important;
    }

    .flex-column-reverse {
        flex-direction: column-reverse !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    #sendMessage2 .border {
        border-color: #E1E5EC !important;
    }

    #sendMessage2 .modal-body .secMessage>div {
        background: #ccc;
        display: table;
        margin-right: auto;
        margin-left: unset;
        border-radius: 10px !important;
        --bs-bg-opacity: 1;
        background-color: #E1E5EC !important;
    }

    #sendMessage2 .modal-body .secContainer.secReceiver .secMessage {
        margin-left: 1rem;
    }

    #sendMessage2 .modal-body .secContainer.secSender {
        flex-direction: row-reverse;
    }

    #sendMessage2 .modal-body .secContainer.secSender .secMessage {
        margin-right: 1rem;
    }

    #sendMessage2 .modal-body .secContainer.secSender .secMessage>div {
        margin-right: unset;
        margin-left: auto;
        color: #fff;
        background-color: #32C5D2 !important;
    }

    /*SPEAKUP*/
    .speakupList>li a {
        display: block !important;
        white-space: nowrap !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #tableData_Speakup thead th:first-child {
        width: unset !important;
    }

    /*STICKY NOTES*/
    #stickyNote .offcanvas-body .userResult:hover a {
        display: block !important;
    }

    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* MULTI SELECT*/
    .multiselect-container {
        z-index: 9999;
    }
    </style>
</head>
<!-- END HEAD -->

<?php
        function menu($name, $current_userEmployerID, $current_userEmployeeID) {
            global $conn;
            global $current_userAdminAccess;

            if ($current_userAdminAccess == 0) {
                $displayMenu = "hide";
                // $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE name='".$name."'" );
                // if ( mysqli_num_rows($selectMenu) > 0 ) {
                //     $rowMenu = mysqli_fetch_array($selectMenu);
                //     $assigned_to_id = $rowMenu['assigned_to_id'];
    
                //     if (!isset($_COOKIE['switchAccount'])) {
                //         if (!empty($assigned_to_id)) {
                //             $output = json_decode($assigned_to_id, true);
                //             $exist = 0;
                //             foreach ($output as $key => $value) {
                //                 if ($current_userEmployerID == $key) {
                //                     if (in_array($current_userEmployeeID, $value['assigned_to_id'])) {
                //                         $exist++;
                //                         break;
                //                     }
                //                 }
                //             }
        
                //             if ($exist > 0) { $displayMenu = ""; }
                //         }
                //     } else {
                //         $displayMenu = "";
                //     }
                // }
                
                if (!isset($_COOKIE['switchAccount'])) {
                    $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE name='".$name."'" );
                    if ( mysqli_num_rows($selectMenu) > 0 ) {
                        $rowMenu = mysqli_fetch_array($selectMenu);
                        $assigned_to_id = $rowMenu['assigned_to_id'];
        
                        if (!empty($assigned_to_id)) {
                            $output = json_decode($assigned_to_id, true);
                            $exist = 0;
                            foreach ($output as $key => $value) {
                                if ($current_userEmployerID == $key) {
                                    if (in_array($current_userEmployeeID, $value['assigned_to_id'])) {
                                        $exist++;
                                        break;
                                    }
                                }
                            }
        
                            if ($exist > 0) { $displayMenu = ""; }
                        }
                    }
                } else {
                    $displayMenu = "";
                }
    
                return $displayMenu;
            }
        }
    ?>


<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" id="bodyView">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top bg-white">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <center>
                    <?php
                            if ($current_client == 1) {
                                if ($switch_user_id == 27) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="assets/img/Canna-OS-Logo_gear.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="assets/img/Canna-OS-Logo_gear.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 2) {
                                if ($switch_user_id == 1360) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="/companyDetailsFolder/252423%20-%20FoodSafety%20360%20V1%20with%20register%20logo.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="/companyDetailsFolder/252423%20-%20FoodSafety%20360%20V1%20with%20register%20logo.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 3) {
                                if ($switch_user_id == 1365) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="/companyDetailsFolder/190391%20-%20SafeCannabis%20360%20(2).png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="/companyDetailsFolder/190391%20-%20SafeCannabis%20360%20(2).png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 4) {
                                if ($switch_user_id == 1366) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="/companyDetailsFolder/190391%20-%20SafeCannabis%20360%20(2).png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="/companyDetailsFolder/190391%20-%20SafeCannabis%20360%20(2).png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 5) {
                                if ($switch_user_id == 1453) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="/companyDetailsFolder/574189 - Viking Atlantic Sales Group, LLC.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="/companyDetailsFolder/574189 - Viking Atlantic Sales Group, LLC.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 7) {
                                if ($switch_user_id == 1469) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/388267 - Cannabis360.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="companyDetailsFolder/388267 - Cannabis360.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 8) {
                                if ($switch_user_id == 1471) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/165028 - SafeSupplements 360.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="companyDetailsFolder/165028 - SafeSupplements 360.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 9) {
                                if ($switch_user_id == 1477) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/175668 - FS_RGB_R_Stacked_SiennaTuscany.jpg" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="companyDetailsFolder/175668 - FS_RGB_R_Stacked_SiennaTuscany.jpg" height="60px" alt="logo" /></a>';
                                }
                                
                            } else if ($current_client == 10) {
                                if ($switch_user_id == 1479) {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/852876 - New Focuss Logo.png" height="60px" alt="logo" /></a>';
                                    }
                                } else {
                                    echo '<a href="dashboard"><img src="companyDetailsFolder/852876 - New Focuss Logo.png" height="60px" alt="logo" /></a>';
                                }
                                
                            } else {
                                if (isset($_COOKIE['switchAccount'])) {
                                    echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                } else {
                                    if(!empty($enterp_logo)) {
                                        echo '<a href="dashboard"><img src="companyDetailsFolder/'.$enterp_logo.'" height="60px" alt="logo" /></a>';
                                    } else {
                                        echo '<a href="dashboard"><img src="assets/img/interlinkiq v3.png" height="60px" alt="logo" /></a>';
                                    }
                                }
                            }
                        ?>
                </center>
                <!-- <img src="../assets/layouts/layout2/img/default-logo.jpg" alt="logo" class="logo-default" width="30" height="30" /> </a> -->

                <!-- <div class="menu-toggler sidebar-toggler"> -->
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                <!-- </div> -->
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse" style="filter: invert(100%);"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN PAGE ACTIONS -->
            <!-- DOC: Remove "hide" class to enable the page header actions -->
            <?php if ($current_client == 0) { ?>
                <div class="page-actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-circle btn-outline red dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-plus"></i>&nbsp;
                            <span class="hidden-sm hidden-xs">New&nbsp;</span>&nbsp;
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if ($current_userType == 1) { ?>
                            <li>
                                <a href="employee#new"><i class="icon-user"></i> Employee Roster</a>
                            </li>
                            <li>
                                <a href="job-description#new"><i class="icon-notebook"></i> Job Description</a>
                            </li>
                            <li>
                                <a href="trainings#new"><i class="icon-graduation"></i> Trainings</a>
                            </li>
                            <li>
                                <a href="department#new"><i class="icon-directions"></i> Department</a>
                            </li>
                            <li>
                                <a href="customer#new"><i class="icon-users"></i> Customer</a>
                            </li>
                            <li>
                                <a href="supplier#new"><i class="icon-basket-loaded"></i> Supplier</a>
                            </li>
                            <li class="divider hide"> </li>
                            <?php } ?>
    
                            <li class="hide">
                                <a href="javascript:;">
                                    <i class="icon-flag"></i> Comments
                                    <span class="badge badge-success">4</span>
                                </a>
                            </li>
                            <li class="hide">
                                <a href="javascript:;">
                                    <i class="icon-users"></i> Feedbacks
                                    <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <?php
                    if ($current_client == 1) {
                        echo '<div class="page-actions" style="margin-top: 10px;">
                            <div id="resultCheck" style="color: red; font-weight: 700; font-size: 1.5rem;">
                                <div style="display: flex">';
                                
                                    $contactHeader = '';
                                    $selectHeader = mysqli_query($conn, "SELECT * FROM tblEnterpiseDetails_Header WHERE LENGTH(content) > 0 AND user_id = $switch_user_id");
                                    if(mysqli_num_rows($selectHeader) > 0) {
                                        $rowHeader = mysqli_fetch_assoc($selectHeader);
                                        $contactHeader = $rowHeader['content'];
                                        
                                        $data = json_decode($contactHeader, true);
                                        $sections = array_column($data, "section"); 
                                        $unique_sections = array_unique($sections);
                                        $arr = implode(', ', $unique_sections);
                                        $arr_ex = explode(', ', $arr);
                                        
                                        // $unique_sections = count(array_unique(array_column($data, 'section')));
                            
                                    
                                        for ($x = 0; $x < count($unique_sections); $x++) {
                                            echo '<div style="margin-right: 15px;">';
                                                if($arr_ex[$x] == 1) { echo 'Contact Person'; }
                                                else if($arr_ex[$x] == 2) { echo 'Emergency Contact'; }
                                                else if($arr_ex[$x] == 3) { echo 'Private Patrol Officer'; }
                                                else if($arr_ex[$x] == 4) {
                                                    // $selectHeaderSet = mysqli_query($conn, "SELECT * FROM tblEnterpiseDetails_Contact_Set WHERE LENGTH(content) > 0 AND user_id = $switch_user_id");
                                                    // $selectHeaderSet = mysqli_query($conn, "SELECT 
                                                    //     s.title AS s_title 
                                                    //     FROM tblEnterpiseDetails_Contact_SetData AS d
                                                        
                                                    //     LEFT JOIN (
                                                    //     	SELECT
                                                    //         *
                                                    //         FROM tblEnterpiseDetails_Contact_Set
                                                    //         WHERE deleted = 0
                                                    //     ) AS s
                                                    //     ON d.set_id = s.ID
                                                        
                                                    //     WHERE d.deleted = 0
                                                    //     AND d.ID = 1");
                                                    // if(mysqli_num_rows($selectHeaderSet) > 0) {
                                                    //     $rowHeader = mysqli_fetch_assoc($selectHeaderSet);
                                                    //     $contactHeader = $rowHeader['content'];
                                                        
                                                    // }
                                                    echo 'Others';
                                                }
                                                
                                                echo '<ul class="list-inline">';
                                                
                                                    foreach ($data as $key => $value) {
                                                        if ($arr_ex[$x] == $value['section']) {
                                                            echo '<li class="list-inline-item">'.$value['value'].'</li>';
                                                        }
                                                    }
                                            
                                                echo '</ul>
                                            </div>';
                                        }
                                    }
                                                
                                echo '</div>
                            </div>
                        </div>';
                    }
                ?>
            <!-- END PAGE ACTIONS -->
            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
                <?php if ($current_client == 0) { ?>
                <!-- BEGIN HEADER SEARCH BOX -->
                <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                <form class="search-form search-form-expanded hide" action="page_general_search_3.html" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." name="query">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END HEADER SEARCH BOX -->
                <?php } ?>

                <?php
                    if ($switch_user_id == 1 OR $switch_user_id == 34 OR $switch_user_id == 163) {
                        echo '<div class="offcanvas offcanvas-end" id="chatbox">
                            <div class="offcanvas-header pb-0">';

                                $sql = mysqli_query($conn, "SELECT * FROM tbl_user WHERE is_active = 1 AND ID = $current_userID");
                                if(mysqli_num_rows($sql) > 0) {
                                    $row = mysqli_fetch_assoc($sql);

                                    $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                    if(mysqli_num_rows($selectUserInfo) > 0) {
                                        $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                        $current_userAvatar = $rowInfo['avatar'];
                                    }
                                }
                               
                               echo '<div class="d-flex flex-columnx justify-content-betweenx align-items-center w-100 border-1 margin-bottom-15">
                                    <span class="position-relative me-2">
                                        <img class="d-flex justify-content-center border border-default bg-white img-circle" style="width:80px; height:80px; object-fit: contain;" src="'.$base_url.'uploads/avatar/'.$current_userAvatar.'" alt="Avatar" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image\';" />
                                    </span>
                                    <h4 class="bold ms-3">'.htmlentities($row['first_name']). " " . htmlentities($row['last_name']).'</h4>
                                </div>
                                <div class="input-icon right">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="form-control input-circle" placeholder="search" id="txtSearch">
                                </div>
                            </div>
                            <div class="offcanvas-body">
                                <div class="users-list mt-2" style="max-height:calc(100vh - 185px) !important" id="userList"></div>
                            </div>
                        </div>
                        <div class="offcanvas-backdrop" id="chatboxDrop" onClick="offCanvas(1)"></div>';
                    }

                    echo '<div class="offcanvas offcanvas-end" id="stickyNote">
                        <div class="offcanvas-header pb-0">';

                            $sql = mysqli_query($conn, "SELECT * FROM tbl_user WHERE is_active = 1 AND ID = $current_userID");
                            if(mysqli_num_rows($sql) > 0) {
                                $row = mysqli_fetch_assoc($sql);

                                $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                if(mysqli_num_rows($selectUserInfo) > 0) {
                                    $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                    $current_userAvatar = $rowInfo['avatar'];
                                }
                            }
                           
                            echo '<div class="d-flex justify-content-between align-items-center">
                                <a href="javascript:;" class="page-quick-sidebar-togglerx h3" style="margin: 0;" data-toggle="modal" data-target="#modalNotes">
                                    <i class="icon-plus"></i>
                                </a>
                                <span class="sbold">My Notes</span>
                                <a href="javascript:;" class="page-quick-sidebar-togglerx h3" style="margin: 0;" onclick="offCanvas(2)">
                                    <i class="icon-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="users-list mt-2" style="max-height:calc(100vh - 100px) !important" id="userNotes">';

                                // $selectNote = mysqli_query( $conn,"SELECT * FROM tbl_notes WHERE deleted = 0 AND (user_id = $current_userID OR assigned_to IN ($current_userEmployeeID) OR copy_to IN ($current_userEmployyeeID)) ORDER BY ID DESC" );
                                $selectNote = mysqli_query( $conn,"SELECT * FROM tbl_notes WHERE deleted = 0 AND user_id = $current_userID ORDER BY ID DESC" );
                                if ( mysqli_num_rows($selectNote) > 0 ) {
                                    while($rowNote = mysqli_fetch_array($selectNote)) {
                                        $note_ID = $rowNote['ID'];
                                        $note_user_id = htmlentities($rowNote['user_id']);
                                        $note_description = htmlentities($rowNote['description']);
                                        $note_last_modified = $rowNote['last_modified'];

                                        echo '<div class="userResult" id="note_'.$note_ID.'">
                                            <div class="d-flex align-items-center img-rounded excerpt p-2 position-relative">
                                                <div class="userData flex-grow-1" data-toggle="modal" data-target="#modalNotesView'; echo $note_user_id == $current_userID ? '':'Copy'; echo '" onclick="noteView'; echo $note_user_id == $current_userID ? '':'Copy'; echo '('.$note_ID.')">
                                                    <p class="mb-0 bold" style="font-size: 15px;">'.nl2br($note_description).'</p>
                                                    <p class="mb-0 text-muted " style="font-size: 13px;">'.$note_last_modified.'</p>
                                                </div>';

                                                if ($note_user_id == $current_userID) {
                                                    echo '<a href="javascript:;" class="hide h4 text-danger p-2 position-absolute end-0" style="margin: 0;" onclick="noteDelete('.$note_ID.')">
                                                        <i class="icon-trash"></i>
                                                    </a>';
                                                }
                                                
                                            echo '</div>
                                        </div>';
                                    }
                                }
                                
                            echo '</div>
                        </div>
                    </div>
                    <div class="offcanvas-backdrop" id="stickyNoteDrop" onClick="offCanvas(2)"></div>';
                ?>

                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">

                    <ul class="nav navbar-nav pull-right">
                        <?php if ($current_client == 0) { ?>
                            <li class="dropdown dropdown-extended" id="googleTranslate">
                                <div id="google_translate_element"></div>
                                <script type="text/javascript">
                                    function googleTranslateElementInit() {
                                        new google.translate.TranslateElement({
                                            pageLanguage: 'en',
                                            autoDisplay: 'true',
                                            includedLanguages: 'en,fr,zh-CN,zh-TW,ja,ko,es,it,pt,ar,sw',
                                            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                                        }, 'google_translate_element');
                                }
                                </script>
    
                                <!--<div id="customLang"></div>-->
                                <!--<select class="selectpicker notranslate" data-width="fit" onchange="translateLanguage(this.value);">-->
                                <!--    <option data-content='<span class="fi fi-us"></span> English' value="English">English</option>-->
                                <!--    <option data-content='<span class="fi fi-sa"></span> Arabic' value="Arabic" <?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/ar') { echo 'SELECTED'; } ?> >Arabic</option>-->
                                <!--    <option data-content='<span class="fi fi-fr"></span> French' value="French"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/fr') { echo 'SELECTED'; } ?> >French</option>-->
                                <!--    <option data-content='<span class="fi fi-it"></span> Italian' value="Italian"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/it') { echo 'SELECTED'; } ?> >Italian</option>-->
                                <!--    <option data-content='<span class="fi fi-jp"></span> Japanese' value="Japanese"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/ja') { echo 'SELECTED'; } ?> >Japanese</option>-->
                                <!--    <option data-content='<span class="fi fi-kr"></span> Korean' value="Korean"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/ko') { echo 'SELECTED'; } ?> >Korean</option>-->
                                <!--    <option data-content='<span class="fi fi-pt"></span> Portuguese' value="Portuguese"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/pt') { echo 'SELECTED'; } ?> >Portuguese</option>-->
                                <!--    <option data-content='<span class="fi fi-es"></span> Spanish' value="Spanish"<?php if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/es') { echo 'SELECTED'; } ?> >Spanish</option>-->
                                <!--</select>-->
                                <script type="text/javascript">
                                    function googleTranslateElementInit() {
                                        new google.translate.TranslateElement({
                                            pageLanguage: 'en',
                                            autoDisplay: 'true',
                                            includedLanguages: 'en,fr,zh-CN,zh-TW,ja,ko,es,it,pt,ar,sw',
                                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                                        }, 'google_translate_element');
                                    }
                                    // function googleTranslateElementInit() {
                                    //     // new google.translate.TranslateElement({
                                    //     //     pageLanguage: 'en',
                                    //     //     autoDisplay: 'true',
                                    //     //     layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                                    //     // }, 'google_translate_element');
                                    // }
    
                                    function translateLanguage(lang) {
                                        googleTranslateElementInit();
                                        var $frame = $('.goog-te-menu-frame:first');
                                        // if (!$frame.size()) {
                                        //     alert("Error: Could not find Google translate frame.");
                                        //     return false;
                                        // }
                                        if (lang == "English") {
                                            location.reload();
                                        }
                                        $frame.contents().find('.goog-te-menu2-item span.text:contains(' + lang + ')').get(0).click();
                                        return false;
                                    }
                                </script>
                                <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>
                            </li>
                        <?php } ?>
                        <?php
                            // if ($switch_user_id == 1) {
                            //     echo '<li class="dropdown dropdown-extended">
                            //         <a href="javascript:;" class="dropdown-toggle" onclick="offCanvas(2)">
                            //             <i class="icon-note"></i>
                            //         </a>
                            //         <ul class="dropdown-menu hide"></ul>
                            //     </li>';
                            // }
                            if ($switch_user_id == 1 OR $switch_user_id == 34 OR $switch_user_id == 163) {
                                echo '<li class="dropdown dropdown-extended">
                                    <a href="javascript:;" class="dropdown-toggle" onclick="offCanvas(1)">
                                        <i class="icon-envelope"></i>
                                        <span class="hide badge badge-success" id="countNotif"></span>
                                    </a>
                                    <ul class="dropdown-menu hide"></ul>
                                </li>
                                <li class="dropdown dropdown-extended">
                                    <a href="javascript:;" class="dropdown-toggle" onclick="offCanvas(2)">
                                        <i class="icon-note"></i>
                                    </a>
                                    <ul class="dropdown-menu hide"></ul>
                                </li>';

                                if ($current_userEmployeeID == 129 OR $current_userEmployeeID == 128) {
                                    $selectSpeak = mysqli_query($conn, "SELECT * FROM tbl_speakup WHERE reply_to = 0 AND seen = 0 AND user_id = $current_userEmployerID ORDER BY ID DESC");
                                    echo '<li class="dropdown dropdown-extended" id="speakup_employer">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false" style="padding-top: 22px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 512 512"><path fill="#48677E" d="M292.834 280.647a8.344 8.344 0 0 0 3.415 11.305c4.577 2.457 13.948 4.158 20.393 5.094c3.623.526 6.089 4.226 5.041 7.734c-10.601 35.504-41.8 50.113-82.55 55.398v25.865c52.399 4.923 93.405 49.025 93.405 102.711c0 9.525-7.721 17.246-17.246 17.246H59.747c-9.525 0-17.246-7.721-17.246-17.246c0-53.686 41.006-97.789 93.405-102.711v-34.758C103.807 336.26 83.351 308.4 70.313 278.99c-1.909.367-3.115.417-3.408.103c-19.506-20.89-38.863-74.881-38.863-128.64c0-53.76 36.755-147.634 137.924-147.634c58.21 0 139.255 13.239 141.821 15.35c2.587 2.128-5.389 18.791-2.83 21.231c5.335 5.086 10.637 10.871 16.016 17.45c4.545 5.558-1.443 8.837-21.675 10.114c18.337 19.668 28.944 46.551 28.944 80.468l-.372 18.779l.004-.008c-.002.001-.002.007-.004.01l-.006.295c.464 3.721 12.114 40.293 19.704 56.085c8.582 17.858-2.743 21.798-21.257 22.374l-.602 30.426c0 5.576-16.126 4.762-21.571 1.844c-4.119-2.184-9.159-.638-11.304 3.41zm80.636-27.338l91.264-42.482a3.279 3.279 0 0 0 1.326-4.771l-14.046-21.22a3.28 3.28 0 0 0-4.91-.644l-75.219 66.701c-1.259 1.117.059 3.126 1.585 2.416zm-1.207 62.314l73.979 66.62a3.279 3.279 0 0 0 4.912-.651l13.992-21.242a3.279 3.279 0 0 0-1.341-4.77l-89.943-42.363c-1.52-.716-2.848 1.282-1.599 2.406zm3.159-30.571l112.456 14.619a3.28 3.28 0 0 0 3.702-3.251v-25.535a3.278 3.278 0 0 0-3.702-3.251l-112.456 14.619c-1.64.213-1.64 2.586 0 2.799z"></path></svg>
                                            <span class="badge badge-default">'; if(mysqli_num_rows($selectSpeak) > 0) { echo mysqli_num_rows($selectSpeak); } echo '</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                <h3 class="hide"><a href="#modalSpeakUp" data-toggle="modal" class="btn btn-success btn-xs xdropdown-toggle">Create New</a></h3>
                                                <h3>SpeakUp!</h3>
                                                <a href="#modalSpeakUpViewAll" data-toggle="modal" onclick="btnSpeakupAll('.$current_userEmployerID.')">view all</a>
                                            </li>';

                                            if(mysqli_num_rows($selectSpeak) > 0) {
                                                echo '<li>
                                                    <ul class="dropdown-menu-list speakupList" style="max-height: 275px; overflow: auto;">';

                                                        while($rowSpeak = mysqli_fetch_array($selectSpeak)) {
                                                            $speak_ID = $rowSpeak['ID'];
                                                            $speak_comment = htmlentities(stripcslashes($rowSpeak['comment']));

                                                            $speak_last_modified = $rowSpeak['last_modified'];
                                                            $speak_last_modified = new DateTime($speak_last_modified);
                                                            $speak_last_modified = $speak_last_modified->format('M d, Y');

                                                            echo '<li>
                                                                <a href="#modalSpeakUpView" data-toggle="modal" onclick="btnSpeakup('.$speak_ID.')" style="text-decoration: none;">
                                                                    <span class="sbold">'.$speak_comment.'</span>
                                                                    <div class="time text-right">'.$speak_last_modified.'</div>
                                                                </a>
                                                            </li>';
                                                        }

                                                    echo '</ul>
                                                </li>';
                                            }

                                        echo '</ul>
                                    </li>';
                                } else {
                                    $selectSpeak = mysqli_query($conn, "SELECT * FROM tbl_speakup WHERE reply_to = 0 AND user_id = $current_userEmployerID AND portal_user = $current_userID ORDER BY ID DESC");
                                    echo '<li class="dropdown dropdown-extended" id="speakup_employee">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false" style="padding-top: 22px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 512 512"><path fill="#48677E" d="M292.834 280.647a8.344 8.344 0 0 0 3.415 11.305c4.577 2.457 13.948 4.158 20.393 5.094c3.623.526 6.089 4.226 5.041 7.734c-10.601 35.504-41.8 50.113-82.55 55.398v25.865c52.399 4.923 93.405 49.025 93.405 102.711c0 9.525-7.721 17.246-17.246 17.246H59.747c-9.525 0-17.246-7.721-17.246-17.246c0-53.686 41.006-97.789 93.405-102.711v-34.758C103.807 336.26 83.351 308.4 70.313 278.99c-1.909.367-3.115.417-3.408.103c-19.506-20.89-38.863-74.881-38.863-128.64c0-53.76 36.755-147.634 137.924-147.634c58.21 0 139.255 13.239 141.821 15.35c2.587 2.128-5.389 18.791-2.83 21.231c5.335 5.086 10.637 10.871 16.016 17.45c4.545 5.558-1.443 8.837-21.675 10.114c18.337 19.668 28.944 46.551 28.944 80.468l-.372 18.779l.004-.008c-.002.001-.002.007-.004.01l-.006.295c.464 3.721 12.114 40.293 19.704 56.085c8.582 17.858-2.743 21.798-21.257 22.374l-.602 30.426c0 5.576-16.126 4.762-21.571 1.844c-4.119-2.184-9.159-.638-11.304 3.41zm80.636-27.338l91.264-42.482a3.279 3.279 0 0 0 1.326-4.771l-14.046-21.22a3.28 3.28 0 0 0-4.91-.644l-75.219 66.701c-1.259 1.117.059 3.126 1.585 2.416zm-1.207 62.314l73.979 66.62a3.279 3.279 0 0 0 4.912-.651l13.992-21.242a3.279 3.279 0 0 0-1.341-4.77l-89.943-42.363c-1.52-.716-2.848 1.282-1.599 2.406zm3.159-30.571l112.456 14.619a3.28 3.28 0 0 0 3.702-3.251v-25.535a3.278 3.278 0 0 0-3.702-3.251l-112.456 14.619c-1.64.213-1.64 2.586 0 2.799z"></path></svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                <h3>SpeakUp!</h3>
                                                <a href="#modalSpeakUp" data-toggle="modal">say something</a>
                                                <p class="small text-muted" style="margin-bottom: 0;">
                                                    Our secret weapon for building the best culture is open and honest feedback.<br>
                                                    <span class="sbold text-danger">Note: Your name will not be logged.</span>
                                                </p>
                                            </li>';

                                            if(mysqli_num_rows($selectSpeak) > 0) {
                                                echo '<li>
                                                    <ul class="dropdown-menu-list speakupList" style="max-height: 275px; overflow: auto;">';

                                                        while($rowSpeak = mysqli_fetch_array($selectSpeak)) {
                                                            $speak_ID = $rowSpeak['ID'];
                                                            $speak_comment = stripcslashes($rowSpeak['comment']);

                                                            $speak_last_modified = $rowSpeak['last_modified'];
                                                            $speak_last_modified = new DateTime($speak_last_modified);
                                                            $speak_last_modified = $speak_last_modified->format('M d, Y');

                                                            echo '<li>
                                                                <a href="#modalSpeakUpView" data-toggle="modal" onclick="btnSpeakup('.$speak_ID.')" style="text-decoration: none;">
                                                                    <span class="sbold">'.$speak_comment.'</span>
                                                                    <div class="time text-right">'.$speak_last_modified.'</div>
                                                                </a>
                                                            </li>';
                                                        }

                                                    echo '</ul>
                                                </li>';
                                            }

                                        echo '</ul>
                                    </li>';
                                }
                            }
                        ?>
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class below "dropdown-extended" to change the dropdown styte -->
                        <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                        <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <?php if($user_id == 1 || $user_id == 35 || $user_id == 42 || $user_id == 163 || $user_id == 38 || $user_id == 88 || $user_id == 34 || $user_id == 100 || $user_id == 55 || $user_id == 54 || $user_id == 387 || $user_id == 693 || $user_id == 1231): ?>
                                <a href="quotation.php" class="dropdown-toggle">
                                    <i class="fa fa-qrcode"></i>
                                </a>
                            <?php endif; ?>
                        </li>
                        
                        <?php if($_COOKIE['ID'] == 481): ?>
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default"> 1 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold">1 pending</span> notifications
                                        </h3>
                                        <a href="#">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">30 min. ago</span>
                                                    <span class="details"> Cindiy Compliance fail to review the Health Declaration Form. </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                        <?php endif; ?>
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <?php if($user_id == 1 || $user_id == 2 || $user_id == 13 || $user_id == 42 || $user_id == 44 || $user_id == 185 || $user_id == 95 || $user_id == 38): ?>
                                    <a href="blog_pages.php" class="dropdown-toggle">
                                        <i class="icon-earphones-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </li>

                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <?php if($user_id == 163 OR $user_id == 1): ?>
                                    <a data-toggle="modal" data-target="#modal_video" class="dropdown-toggle">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php if($_COOKIE['ID'] == 108): ?>
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default"> 9 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                        $select_pending = mysqli_query($conn, "SELECT * FROM leave_details INNER JOIN leave_types ON leave_types.leave_id = leave_details.leave_id INNER JOIN tbl_user ON tbl_user.ID = leave_details.payeeid WHERE approve_status = 0");
                                    ?>
                                    <li class="external">
                                        <h3>
                                            <span class="bold">9 pending</span> for approval
                                        </h3>
                                        <a href="page_user_profile_1.html">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <?php foreach($select_pending as $row): ?>
                                                    <a href="pto_request_for_approve.php">
                                                        <span class="time"><?= $row['leave_name'] ?></span>
                                                        <span class="details">
                                                            <span class="label label-sm label-icon label-success">
                                                                <i class="fa fa-check"></i>
                                                            </span> <?= htmlentities($row['first_name']).' '.htmlentities($row['last_name']) ?> </span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <?php if($user_id == 108 OR $user_id == 1): ?>
                                <a data-toggle="modal" data-target="#modal_export" class="dropdown-toggle">
                                    <i class="icon-cloud-upload"></i>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <?php if($user_id == 2 || $user_id == 1 || $user_id == 19 || $user_id == 43 || $user_id == 35 || $user_id == 54 || $user_id == 40 || $user_id == 41 || $user_id == 42 || $user_id == 178 || $user_id == 55 || $user_id == 100 || $user_id == 693 || $user_id == 88 || $user_id == 1027 || $user_id == 1360 || $user_id == 1365 || $user_id == 1366 || $user_id == 1453): ?>
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default">
                                        <?php    
                                            $users = $user_id;
                                            $result = mysqli_query($conn, "SELECT count(*) AS count FROM tbl_user WHERE client = $current_client ORDER BY ID desc");
                                                                                                
                                            while($row = mysqli_fetch_array($result)) {
                                                echo $row['count'];
                                            }
                                        ?>
                                    </span>
                                </a>
                            <?php endif; ?>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3>
                                        <span class="bold hide">12 pending</span> Notifications
                                    </h3>
                                    <a href="#">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                        <?php 
                                            $users = $user_id;
                                            $result = mysqli_query($conn, "SELECT count(*) AS count FROM tbl_user WHERE client = $current_client ORDER BY ID desc");
                                                                                                
                                            while($row = mysqli_fetch_array($result)) {
                                                echo '<li>
                                                    <form action="enterprise-function/export_users.php" method="POST" style="margin-top: 10px;">
                                                        <a style="text-decoration:none;" href="users-details-record">
                                                            <span class="time" style="background-color:red;color:white;margin-right:20px;">'; echo $row['count']; echo '</span>
                                                            <span class="details">
                                                                <span class="label label-sm label-icon ">
                                                                    <button class="btn btn-xs btn-success" type="submit" name="exportExcel"><i class="fa fa-download"></i></button>
                                                                </span>
                                                                User registered.
                                                            </span>
                                                        </a>
                                                    </form>
                                                </li>';   
                                            }
                                            
                                            if ($current_client == 0) {
                                                
                                                $users = $user_id;
                                                $query = "SELECT count(*) as count FROM tblEnterpiseDetails";
                                                $result = mysqli_query($conn, $query);
                                                                                                    
                                                while($row = mysqli_fetch_array($result)) {
                                                    echo '<li>
                                                        <form action="enterprise-function/export_users.php" method="POST" style="margin-top: 10px;">
                                                            <a style="text-decoration:none;" href="enterprise_record">
                                                                <span class="time" style="background-color:red;color:white;margin-right:20px;">'; echo $row['count'] ?? '0'; /* added nullish fallback operator */ echo '</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon ">
                                                                        <button class="btn btn-xs btn-success" type="submit" name="exportExcelEnterprise"><i class="fa fa-book"></i></button>
                                                                    </span>
                                                                    Enterprise Record
                                                                </span>
                                                            </a>
                                                        </form>
                                                    </li>';
                                                }
                                            }
                                        ?>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">10 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Server #2 not responding. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">14 hrs</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> Application error. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">2 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Database overloaded 68%. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">3 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> A user IP blocked. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">4 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Storage Server #4 not responding dfdfdfd. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">5 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> System Error. </span>
                                            </a>
                                        </li>
                                        <li class="hide">
                                            <a href="javascript:;">
                                                <span class="time">9 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Storage server failed. </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN INBOX DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-inbox hide" id="header_inbox_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-envelope-open"></i>
                                <span class="badge badge-default"> 4 </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3>You have
                                        <span class="bold">7 New</span> Messages
                                    </h3>
                                    <a href="app_inbox.html">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">Just Now </span>
                                                </span>
                                                <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">16 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Bob Nilson </span>
                                                    <span class="time">2 hrs </span>
                                                </span>
                                                <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">40 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">46 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END INBOX DROPDOWN -->
                        <!-- BEGIN TODO DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-tasks hide" id="header_task_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-calendar"></i>
                                <span class="badge badge-default"> 3 </span>
                            </a>
                            <ul class="dropdown-menu extended tasks">
                                <li class="external">
                                    <h3>You have
                                        <span class="bold">12 pending</span> tasks
                                    </h3>
                                    <a href="app_todo.html">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New release v1.2 </span>
                                                    <span class="percent">30%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Application deployment</span>
                                                    <span class="percent">65%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">65% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile app release</span>
                                                    <span class="percent">98%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">98% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Database migration</span>
                                                    <span class="percent">10%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">10% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Web server upgrade</span>
                                                    <span class="percent">58%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">58% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile development</span>
                                                    <span class="percent">85%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">85% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New UI release</span>
                                                    <span class="percent">38%</span>
                                                </span>
                                                <span class="progress progress-striped">
                                                    <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">38% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle profile-avatar" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <?php
                                        if ( empty($current_userAvatar) ) {
                                            echo '<img src="https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image" class="img-circle" alt="Avatar" />';
                                        } else {
                                            echo '<img src="uploads/avatar/'. $current_userAvatar .'" class="img-circle" alt="Avatar" />';
                                        }
                                    ?>
                                <span class="username username-hide-on-mobile"><?php echo $current_userFName .' '. $current_userLName; ?></span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="profile"><i class="icon-user"></i> My Profile </a>
                                </li>
                                <?php if($user_id == 35 || $user_id == 42 || $user_id == 185 || $user_id == 38 || $user_id == 95): ?>
                                <li>
                                    <a href="executive_assistant_services"><i class="icon-layers"></i>Mgmt. Services </a>
                                </li>
                                <?php endif; ?>
                                <?php // if ($current_userEmployerID == 1) { ?>
                                <li><a href="#modalSwitch" data-toggle="modal"><i class="icon-equalizer"></i> Switch Account </a></li>
                                <?php // } ?>
                                <li class="hide">
                                    <a href="app_calendar.html"><i class="icon-calendar"></i> My Calendar </a>
                                </li>
                                <?php if ($current_userEmployerID == 34 || $user_id == 34) { ?>
                                <li>
                                    <a href="service_log_index.php"><i class="icon-pie-chart"></i> Service logs</a>
                                </li>
                                <?php } ?>
                                <li class="hide">
                                    <a href="app_inbox.html"><i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">3</span></a>
                                </li>
                                <?php if ($current_userEmployerID == 34 || $user_id == 34) { ?>
                                <li>
                                    <a href="auto_service_log.php"><i class="icon-rocket"></i> Auto Logs <span class="badge badge-success myTask"></span></a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="#"><i class="icon-rocket"></i> My Tasks <span class="badge badge-success myTask"></span></a>
                                </li>
                                <li class="divider"> </li>
                                <?php
                                        if ($current_userID == 34 || $current_userID == 163 || $current_userEmployerID == 27 || $current_userEmployerID == 464 || $current_userID == 1360 || $current_userID == 1365 || $current_userID == 1366 || $current_userID == 1453) {
                                            if ($current_userEmployeeID == 0 || ($current_userEmployeeID > 0 && $current_userAdminAccess == 1)) {
                                                echo '<li><a href="sidebar"><i class="icon-login"></i> Sidebar Setting</a></li>';
                                            }
                                        }
                                    ?>
                                <li>
                                    <a href="javascript:;" onclick="btnLocked()"><i class="icon-lock"></i> Lock Screen</a>
                                </li>
                                <?php if ($current_userEmployerID == 1) { ?>
                                <li><a href="settings"><i class="icon-settings"></i> System Settings</a></li>
                                <?php } ?>
                                <?php if($switch_user_id == 34): ?>
                                <li><a href="#request_pto" data-toggle="modal"><i class="icon-calendar"></i> Request PTO</a></li>
                                <?php endif; ?>
                                <?php if ($user_id == 34  OR $_COOKIE['ID'] == 456 OR $_COOKIE['ID'] == 108 ) { ?>
                                <li><a href="pto_request.php"><i class="icon-calendar"></i> PTO For Approval(HR)</a></li>
                                <?php } ?>
                                <?php if($switch_user_id == 34 && $user_id != 34 ): ?>
                                <li><a href="pto_request_for_approve.php"><i class="icon-calendar"></i> PTO For Approval</a></li>
                                <?php endif ?>
                                <?php if($switch_user_id == 34 && $user_id != 34 ): ?>
                                <li><a href="pto.php"><i class="icon-calendar"></i>My PTO Dashboard</a></li>
                                <?php endif ?>
                                <?php if ($user_id == 108 OR $user_id == 1 OR $user_id == 2 OR $user_id == 387 OR $user_id == 54 OR $user_id == 1105  OR $user_id == 32 OR $user_id == 1105) { ?>
                                <li><a href="https://interlinkiq.com/Accounting_system/Login/login_validation/<?= $user_id ?>" target="_blank"><i class="icon-calendar"></i> Accounting</a></li>
                                <?php } ?>
                                <?php if ($current_userEmployerID == 34) { ?>
                                <li><a href="payslip"><i class="icon-wallet"></i> Payslip</a></li>
                                <?php } ?>
                                <?php if ($_COOKIE['ID'] == 108) { ?>
                                <li><a href="#generate_pto" data-toggle="modal"><i class="icon-wallet"></i> Generate PTO</a></li>
                                <?php } ?>
                                <?php if($switch_user_id == 34 && $user_id == 34 ): ?>
                                <li><a href="pto_tracker.php"><i class="icon-calendar"></i> PTO Tracker</a></li>
                                <?php endif ?>
                                <li>
                                    <a href="javascript:;" onclick="btnLogout()"><i class="icon-key"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended quick-sidebar-toggler hide">
                            <span class="sr-only">Toggle Quick Sidebar</span>
                            <i class="icon-logout"></i>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- END SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenux page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

                    <li class="nav-item <?php echo $site === "dashboard" ? "active" : ""; ?>">
                        <a href="dashboard" class="nav-link">
                            <i class="icon-check"></i>
                            <span class="title">Compliance</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 1210 || $_COOKIE['ID'] == 42):?>
                    <li class="nav-item">
                        <a href="custom_crm.php" class="nav-link nav-toggle">
                            <i class="icon-users"></i>
                            <span class="title">CRM <?php if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 42)echo '<i class="font-yellow" style="font-size: 12px; margin-left:4px"> ( Customize )</i>';?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif?>
                    <?php if(($current_client == 0 AND $switch_user_id <> 1106) OR $switch_user_id == 1360 OR $switch_user_id == 1366 OR $switch_user_id == 1453 OR $switch_user_id == 1482 OR $switch_user_id == 1365 OR $switch_user_id == 1477 OR $switch_user_id == 145) { ?>
                        <li class="nav-item hide <?php echo $site === "tracking" ? "active" : ""; ?>">
                            <a href="tracking" class="nav-link">
                                <i class="icon-target"></i>
                                <span class="title">Tracking Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item hide <?php echo $site === "app-store" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('app-store', $current_userEmployerID, $current_userEmployeeID); } ?>">
                            <a href="app-store" class="nav-link">
                                <i class="icon-grid"></i>
                                <span class="title">App Catalog</span>
                                <span class="selected"></span>
                            </a>
                        </li> 

                        <?php
                            if ($current_userEmployerID == 46400 OR $switch_user_id == 464) {
                                echo '<li class="nav-item ">
                                    <a href="form-owned" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">E-Forms</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                            }
                        ?>

                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-support" style="color: #ffff00;"></i>
                                <span class="title" style="color: #ffff00; font-weight: bold;">Risk Assessment</span>
                                <span class="selected"></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="survey" class="nav-link " target="_blank" onclick="myfunction(<?= $current_userEmployerID; ?>)">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Qualification Survey</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="e-forms/Sanitary_controller/Sanitary/gmp_food_v" class="nav-link " target="_blank" onclick="set_newCookie(<?= $switch_user_id; ?>)">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Food and Beverage</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php } ?>

                    <li class="nav-item <?php echo $site === "enterprise-info" ? "active open start" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('enterprise-info', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-layers"></i>
                            <span class="title">Enterprise</span>
                            <span class="selected"></span>
                            <span class="arrow <?php echo $site === "enterprise-info" ? "open" : ""; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?php echo $site === "enterprise-info" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('enterprise-info', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="enterprise-info" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Organization </span>
                                </a>
                            </li>

                            <?php if($user_id==19 OR $user_id==1 OR $user_id==481 OR $user_id==963): ?>
                            <li class="nav-item <?php echo $site === "insurance_info" ? "active " : ""; 
                                 //if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('insurance_info', $current_userEmployerID, $current_userEmployeeID); } 
                                 ?>
                                 ">
                                <!--<a href="insurance_info" class="nav-link ">-->
                                <a href="risk_and_liabilities" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Risk And Liabilities</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item hide hidden <?php echo $site === "enterprise-info-subscription" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('enterprise-info-subscription', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="#" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Subscription </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php
                            // if ($current_userEmployeeID == 0 OR isset($_COOKIE['switchAccount'])) {
                            $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseOperation = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) { ?>
                    <li class="nav-item hide <?php echo $site === "facility-info" ? "active open start" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('enterprise-info-subscription', $current_userEmployerID, $current_userEmployeeID); } ?>" id="menuFacility">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-layers"></i>
                            <span class="title">Facility</span>
                            <span class="selected"></span>
                            <span class="arrow <?php echo $site === "facility-info" ? "open" : ""; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <?php
                                        $queryFacility = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails where users_entities = $switch_user_id " );
                                        if ( mysqli_num_rows($queryFacility) > 0 ) {
                                            while($rowFacility = mysqli_fetch_array($queryFacility)) {
                                                echo '<li class="nav-item">
                                                    <a href="facility-info?facility_id='.$rowFacility['facility_id'].'" class="nav-link ">
                                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                                        <span class="title">'.htmlentities($rowFacility['facility_category']).'</span>
                                                    </a>
                                                </li>';
                                            }
                                        }
                                    ?>
                        </ul>
                    </li>
                    <?php 
                            }
                            // }
                        ?>

                    <?php $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseEmployees = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) { ?>
                    <li class="nav-item hide <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" || $site === "quiz" || $site === "training-requirements" ? "active open start" : ""; ?>" id="menuHR">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-user-female"></i>
                            <span class="title">Human Resources</span>
                            <span class="selected"></span>
                            <span class="arrow <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" || $site === "quiz" || $site === "training-requirements" ? "open" : ""; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?php echo $site === "department" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('department', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="department" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Department</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "job-description" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('job-description', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="job-description" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Job Description</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "employee" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('employee', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="employee" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Employee Roster</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "trainings" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('trainings', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="trainings" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Trainings</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "quiz" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('quiz', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="quiz" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Comprehension Quiz</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "training-requirements" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('training-requirements', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="training-requirements" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Training Requirements</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseProducts = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) { ?>
                    <li class="nav-item <?php echo $site === "products" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('products', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="products" class="nav-link">
                            <i class="icon-social-dropbox"></i>
                            <span class="title">Products</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseServices = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) { ?>
                    <li class="nav-item <?php echo $site === "services" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('services', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="services" class="nav-link">
                            <i class="icon-list"></i>
                            <span class="title">Services</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php } ?>

                    <li class="nav-item <?php echo $site === "customer" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('customer', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="customer" class="nav-link">
                            <i class="icon-users"></i>
                            <span class="title">Customer</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $site === "supplier" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('supplier', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="supplier" class="nav-link">
                            <i class="icon-basket-loaded"></i>
                            <span class="title">Supplier</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <?php if($switch_user_id == 34) { ?>
                    <li class="nav-item <?php echo $site === "Directory_Dashboard" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('Directory_Dashboard', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="Directory_Dashboard" class="nav-link">
                            <i class="icon-layers"></i>
                            <span class="title">Directory</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php if($current_client == 0 AND ($switch_user_id == 1 OR $switch_user_id == 34 OR $switch_user_id == 163)) { ?>
                    <li class="nav-item <?php echo $site === "listing" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('listing', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="listing" class="nav-link">
                            <i class="icon-briefcase"></i>
                            <span class="title">Listing</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if($_COOKIE['ID'] == 481): ?>
                        <li class="nav-item">
                            <a href="eform_dashboard" class="nav-link" disabled>
                                <i class="icon-graph"></i>
                                <span class="title">E-Form Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!--if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('job-ticket', $current_userEmployerID, $current_userEmployeeID); }-->
                    <?php //  if($current_userEmployeeID == 0 OR $current_userID == 95 OR $current_userID == 42 OR $current_userID == 88) { ?>
                    <?php if($current_userEmployeeID == 0) { ?>
                        <li class="nav-item <?php echo $site === "job-ticket" ? "active " : ""; ?>">
                            <a href="job-ticket" class="nav-link">
                                <i class="icon-earphones-alt"></i>
                                <span class="title">Job Ticket Tracker</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item <?php echo $site === "job-ticket-request" || $site === "job-ticket-service" ? "active open start" : ""; ?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-earphones"></i>
                                <span class="title">Job Ticket Tracker</span>
                                <span class="selected"></span>
                                <span class="arrow <?php echo $site === "job-ticket-request" || $site === "job-ticket-service" ? "open" : ""; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?php echo $site === "job-ticket-request" ? "active" : ""; ?>">
                                    <a href="job-ticket-request" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Request</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <?php
                                    echo '<li class="nav-item '; $site === "job-ticket-service" ? "active" : ""; echo '">
                                        <a href="job-ticket-service" class="nav-link ">
                                            <i class="fa fa-minus" style="font-size: 10px;"></i>
                                            <span class="title">Service</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>';
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                    
                    <?php if($switch_user_id == 1479) { ?>
                        <li class="nav-item ">
                            <a href="fsvp" class="nav-link">
                                <i class="icon-graph"></i>
                                <span class="title">FSVP</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($_COOKIE['ID'] == 481) { ?>
                        <li class="nav-item ">
                            <a href="rvm" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">RVM</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php
                            // Sidebar Menu
                            function sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID) {
                                global $conn;
                                $output = '';

                                if (!empty($menu_url)) {
                                    $output = '<li class="nav-item '; if ($site == $menu_url) { $output .= 'active'; } if ($menu_collab == 1 AND $current_userEmployeeID > 0) { $output .= menu($menu_url, $current_userEmployerID, $current_userEmployeeID); } $output .= '">
                                        <a href="'.$menu_url.'" class="nav-link">
                                            <i class="'.$menu_icon.'"></i>
                                            <span class="title">'.$menu_description.'</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>';
                                } else {
                                    $selectMenuDown = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE deleted = 0 AND parent_id = $menu_ID ORDER BY ordering ASC" );
                                    if ( mysqli_num_rows($selectMenuDown) > 0 ) {
                                        $menuDown_array = array();
                                        while($rowMenuDown = mysqli_fetch_array($selectMenuDown)) {
                                            array_push($menuDown_array, $rowMenuDown['url']);
                                        }
                                    }

                                    $output = '<li class="nav-item '; if (in_array($site, $menuDown_array)) { $output .= 'active open start'; } $output .= '">
                                        <a href="javascript:;" class="nav-link nav-toggle">
                                            <i class="icon-user-female"></i>
                                            <span class="title">'.$menu_description.'</span>
                                            <span class="selected"></span>
                                            <span class="arrow '; if (in_array($site, $menuDown_array)) { $output .= 'open'; } $output .= '"></span>
                                        </a>
                                        <ul class="sub-menu">';

                                            $selectMenuDown = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE deleted = 0 AND parent_id = $menu_ID ORDER BY ordering ASC" );
                                            if ( mysqli_num_rows($selectMenuDown) > 0 ) {
                                                while($rowMenuDown = mysqli_fetch_array($selectMenuDown)) {
                                                    $menuDown_ID = $rowMenuDown['ID'];
                                                    $menuDown_collab = $rowMenuDown['collab'];
                                                    $menuDown_url = $rowMenuDown['url'];
                                                    $menuDown_description = htmlentities($rowMenuDown['description']);

                                                    $output .= '<li class="nav-item '; if ($site == $menuDown_url) { $output .= 'active'; } if ($menuDown_collab == 1 AND $current_userEmployeeID > 0) { $output .= menu($menuDown_url, $current_userEmployerID, $current_userEmployeeID); } $output .= '">
                                                        <a href="'.$menuDown_url.'" class="nav-link ">
                                                            <i class="fa fa-minus" style="font-size: 10px;"></i>
                                                            <span class="title">'.$menuDown_description.'</span>
                                                            <span class="selected"></span>
                                                        </a>
                                                    </li>';
                                                }
                                            }

                                        $output .= '</ul>
                                    </li>';
                                }

                                return $output;
                            }
                            
                            // PAID Section
                            $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 ORDER BY description ASC" );
                            if ( mysqli_num_rows($selectMenu) > 0 ) {
                                while($rowMenu = mysqli_fetch_array($selectMenu)) {
                                    $menu_ID = $rowMenu['ID'];
                                    $menu_collab = $rowMenu['collab'];
                                    $menu_icon = $rowMenu['icon'];
                                    $menu_url = $rowMenu['url'];
                                    $menu_description = htmlentities($rowMenu['description']);

                                    $selectMenuSubs = mysqli_query( $conn,"SELECT * FROM tbl_menu_subscription WHERE display = 1 AND deleted = 0 AND type = 2 AND menu_id = $menu_ID AND user_id = $switch_user_id" );
                                    if ( mysqli_num_rows($selectMenuSubs) > 0 ) {
                                        $rowMenuSub = mysqli_fetch_array($selectMenuSubs);
    		                            $sub_date_start = $rowMenuSub["date_start"];
    						            $sub_date_start = new DateTime($sub_date_start);
    						            $sub_date_start_o = $sub_date_start->format('Y/m/d');
    						            $sub_date_start = $sub_date_start->format('M d, Y');
    
    		                            $sub_date_end = $rowMenuSub["date_end"];
    						            $sub_date_end = new DateTime($sub_date_end);
    						            $sub_date_end_o = $sub_date_end->format('Y/m/d');
    						            $sub_date_end = $sub_date_end->format('M d, Y');

                                        if ($sub_date_start_o <= $current_dateNow_o && $sub_date_end_o >= $current_dateNow_o) {
                                            echo sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID);
                                        }
                                    }
                                }
                            }
                            
                            
                            // TRIAL Section
                            $countTrial = 0;
                            $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 ORDER BY description ASC" );
                            if ( mysqli_num_rows($selectMenu) > 0 ) {
                                while($rowMenu = mysqli_fetch_array($selectMenu)) {
                                    $menu_ID = $rowMenu['ID'];

                                    $selectMenuSubs = mysqli_query( $conn,"SELECT * FROM tbl_menu_subscription WHERE display = 1 AND deleted = 0 AND type = 1 AND menu_id = $menu_ID AND user_id = $switch_user_id" );
                                    if ( mysqli_num_rows($selectMenuSubs) > 0 ) {
                                        $rowMenuSub = mysqli_fetch_array($selectMenuSubs);
    		                            $sub_date_start = $rowMenuSub["date_start"];
    						            $sub_date_start = new DateTime($sub_date_start);
    						            $sub_date_start_o = $sub_date_start->format('Y/m/d');
    						            $sub_date_start = $sub_date_start->format('M d, Y');
    
    		                            $sub_date_end = $rowMenuSub["date_end"];
    						            $sub_date_end = new DateTime($sub_date_end);
    						            $sub_date_end_o = $sub_date_end->format('Y/m/d');
    						            $sub_date_end = $sub_date_end->format('M d, Y');

                                        if ($sub_date_start_o <= $current_dateNow_o && $sub_date_end_o >= $current_dateNow_o) { $countTrial++; }
                                    }
                                }
                            }
                            if ($countTrial > 0) {
                                echo '<li class="nav-item nav-item-section nav-item-section-trial active">
                                    <a href="javascript:;" class="nav-link disabled-link disable-targetx" style="cursor: unset !important;">
                                        <span class="title"><b>TRIAL</b></span>
                                    </a>
                                </li>';
                            }
                            
                            $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 ORDER BY description ASC" );
                            if ( mysqli_num_rows($selectMenu) > 0 ) {
                                while($rowMenu = mysqli_fetch_array($selectMenu)) {
                                    $menu_ID = $rowMenu['ID'];
                                    $menu_collab = $rowMenu['collab'];
                                    $menu_icon = $rowMenu['icon'];
                                    $menu_url = $rowMenu['url'];
                                    $menu_description = htmlentities($rowMenu['description']);

                                    $selectMenuSubs = mysqli_query( $conn,"SELECT * FROM tbl_menu_subscription WHERE display = 1 AND deleted = 0 AND type = 1 AND menu_id = $menu_ID AND user_id = $switch_user_id" );
                                    if ( mysqli_num_rows($selectMenuSubs) > 0 ) {
                                        $rowMenuSub = mysqli_fetch_array($selectMenuSubs);
    		                            $sub_date_start = $rowMenuSub["date_start"];
    						            $sub_date_start = new DateTime($sub_date_start);
    						            $sub_date_start_o = $sub_date_start->format('Y/m/d');
    						            $sub_date_start = $sub_date_start->format('M d, Y');
    
    		                            $sub_date_end = $rowMenuSub["date_end"];
    						            $sub_date_end = new DateTime($sub_date_end);
    						            $sub_date_end_o = $sub_date_end->format('Y/m/d');
    						            $sub_date_end = $sub_date_end->format('M d, Y');

                                        if ($sub_date_start_o <= $current_dateNow_o && $sub_date_end_o >= $current_dateNow_o) {
                                            echo sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID);
                                        }
                                    }
                                }
                            }
                            
                            
                            // AVAILABLE MODULE
                            // if($current_userID <> 27 AND $current_userID <> 20 AND $current_userID <> 458 AND $current_userID <> 550 AND $current_userID <> 552 AND $current_userID <> 553) {
                            //     $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 ORDER BY description ASC" );
                            //     if ( mysqli_num_rows($selectMenu) > 0 ) {
                            //         echo '<li class="nav-item nav-item-section nav-item-section-module active">
                            //             <a href="javascript:;" class="nav-link disabled-link disable-targetx" style="cursor: unset !important;">
                            //                 <span class="title"><b>AVAILABLE MODULE</b></span>
                            //             </a>
                            //         </li>';
    
                            //         while($rowMenu = mysqli_fetch_array($selectMenu)) {
                            //             $menu_ID = $rowMenu['ID'];
                            //             $menu_collab = $rowMenu['collab'];
                            //             $menu_icon = $rowMenu['icon'];
                            //             $menu_url = $rowMenu['url'];
                            //             $menu_description = $rowMenu['description'];
    
                            //             $countRunning = 0;
                            //             $countExclusive = 0;
                            //             $countExclusive_arr = array();
                            //             $countOther = 0;
                            //             $countOther_arr = array();
                            //             $selectMenuSubs = mysqli_query( $conn,"SELECT * FROM tbl_menu_subscription WHERE deleted = 0 AND menu_id = $menu_ID" );
                            //             if ( mysqli_num_rows($selectMenuSubs) > 0 ) {
                            //                 while($rowMenuSub = mysqli_fetch_array($selectMenuSubs)) {
                            //                     $sub_type = $rowMenuSub["type"];
                            //                     $sub_user_id = $rowMenuSub["user_id"];
                            //                     $sub_date_start = $rowMenuSub["date_start"];
                            //                     $sub_date_start = new DateTime($sub_date_start);
                            //                     $sub_date_start_o = $sub_date_start->format('Y/m/d');
                            //                     $sub_date_start = $sub_date_start->format('M d, Y');
                                                
                            //                     $sub_date_end = $rowMenuSub["date_end"];
                            //                     $sub_date_end = new DateTime($sub_date_end);
                            //                     $sub_date_end_o = $sub_date_end->format('Y/m/d');
                            //                     $sub_date_end = $sub_date_end->format('M d, Y');
    
                            //                     if ($sub_date_start_o <= $current_dateNow_o && $sub_date_end_o >= $current_dateNow_o) {
                            //                         $countRunning++;
    
                            //                         if ($sub_type == 3) {
                            //                             $countExclusive++;
                            //                             array_push($countExclusive_arr, $sub_user_id);
                            //                         } else {
                            //                             $countOther++;
                            //                             array_push($countOther_arr, $sub_user_id);
                            //                         }
                            //                     }
                            //                 }
    
                            //                 if ($countRunning == 0) {
                            //                     echo sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID);
                            //                 } else {
                            //                     if ($countExclusive == 0 && !in_array($switch_user_id, $countOther_arr)) {
                            //                         echo sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID);
                            //                     }
                            //                 }
                            //             } else {
                            //                 echo sidebarDisplay($site, $menu_ID, $menu_collab, $menu_icon, $menu_url, $menu_description, $current_userEmployerID, $current_userEmployeeID);
                            //             }
                            //         }
                            //     }
                            // }
                            
                            
                            
                            if ($current_userEmployerID == 464000 OR $switch_user_id == 464) {
                                echo '<li class="nav-item ">
                                    <a href="inventory" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">Inventory</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                                echo '<li class="nav-item ">
                                    <a href="sales" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">Sales</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                                echo '<li class="nav-item ">
                                    <a href="production" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">Production</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                                echo '<li class="nav-item ">
                                    <a href="product_and_formulation" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">Product and Formulation</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                                echo '<li class="nav-item ">
                                    <a href="fsvp" class="nav-link">
                                        <i class="icon-graph"></i>
                                        <span class="title">FSVP</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                            }
                        ?>
                    <?php if($_COOKIE['ID'] == 48100 OR $switch_user_id == 163 OR $_COOKIE['ID'] == 1167 OR $_COOKIE['ID'] == 117 OR $switch_user_id == 464 ): ?>
                    <li class="nav-item">
                        <a href="glp_dashboard" class="nav-link" disabled>
                            <i class="icon-graph"></i>
                            <span class="title">GLP</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if($_COOKIE['ID'] == 48100 OR $switch_user_id == 163 OR $_COOKIE['ID'] == 1167 OR $_COOKIE['ID'] == 117 OR $switch_user_id == 464 ): ?>
                    <li class="nav-item">
                        <a href="equipment_register" class="nav-link" disabled>
                            <i class="icon-graph"></i>
                            <span class="title">Equipment Calibration</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item hide <?php echo $site === "form-owned" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('form-owned', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="form-owned" class="nav-link" disabled>
                            <i class="icon-graph"></i>
                            <span class="title">E-Forms</span>
                            <span class="selected"></span>
                        </a>
                    </li>


                    <li class="nav-item hide <?php echo $site === "archive" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('archive', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="archive" class="nav-link">
                            <i class="icon-folder-alt"></i>
                            <span class="title">Archive</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    
                    <?php if($switch_user_id == 1362): ?>
                        <!--<li class="nav-item">-->
                        <!--    <a href="batchproduction" class="nav-link" disabled>-->
                        <!--        <i class="icon-wrench"></i>-->
                        <!--        <span class="title">Batch Production</span>-->
                        <!--        <span class="selected"></span>-->
                        <!--    </a>-->
                        <!--</li>-->
                    <?php endif; ?>

                    <?php
                        // if($switch_user_id == 1362) {
                        //     $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseProducts = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) {
                        //         echo '<li class="nav-item '; echo $site === "batchproduction" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('products', $current_userEmployerID, $current_userEmployeeID); echo '">
                        //             <a href="batchproduction" class="nav-link">
                        //                 <i class="icon-wrench"></i>
                        //                 <span class="title">Batch Production</span>
                        //                 <span class="selected"></span>
                        //             </a>
                        //         </li>';
                        //     }
                        // }
                    ?>

                    <li class="nav-item hide <?php echo $site === "ffva" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('ffva', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="ffva" class="nav-link">
                            <i class="icon-doc"></i>
                            <span class="title">FFVA Module</span>
                            <span class="selected"></span>
                        </a>
                    </li>




                    <!--247 - Scandic-->
                    <!--324 - Tom Sonchai-->
                    <!--34 -Consultare-->
                    <!--19 - Quincy-->

                    <?php if($current_userEmployerID == 247 || $current_userEmployerID == 34 || $user_id == 34): ?>
                    <li class="nav-item hide <?php echo $site === "meeting_minutes" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('meeting_minutes', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="meeting_minutes.php" class="nav-link">
                            <i class="icon-clock"></i>
                            <span class="title">Meeting Minutes</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php  endif;?>
                    <?php if($current_userEmployerID == 254 || $current_userEmployerID == 247 || $current_userEmployerID == 34 || $user_id == 34 || $user_id == 1 || $user_id == 185 || $user_id == 19 || $user_id == 155 || $user_id == 308 || $user_id == 189 || $user_id == 337): ?>
                    <li class="nav-item hide <?php echo $site === "MyPro" ? "active" : ""; ?>">
                        <a href="MyPro" class="nav-link">
                            <i class="icon-earphones-alt"></i>
                            <span class="title">My Pro.</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php  endif;?>
                    <?php if($current_client == 1 || $current_userID == 42 || $current_userID == 693 || $current_userID == 88 || $current_userID == 667 || $current_userID == 748 || $current_userID == 149 || $current_userID == 943 || $current_userID == 153 || $current_userID == 41 || $current_userID == 154 || $current_userID == 43 || $current_userID == 387 || $current_userID == 54 || $current_userID == 55 || $current_userID == 35 || $current_userID == 43 || $current_userID == 1474): ?>
                    <li class="nav-item <?php echo $site === "MyPro" ? "active" : ""; ?>">
                        <a href="test_MyPro" class="nav-link">
                            <i class="icon-earphones-alt"></i>
                            <span class="title">My Pro (New)</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php  endif;?>
                    <?php if($current_client == 1): ?>
                    <li class="nav-item <?php echo $site === "EMP" ? "active" : ""; ?>">
                        <a href="emp_bgl_dashboard_development" class="nav-link" style="color:yellow">
                            <i class="icon-earphones-alt"></i>
                            <span class="title">EMP</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php  endif;?>
                    <?php if($current_userEmployerID == 247 || $current_userEmployerID == 324 || $switch_user_id == 34 || $current_userEmployeeID == 34): ?>
                    <li class="nav-item hide <?php echo $site === "Customer_Relationship_Management" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('Customer_Relationship_Management', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="Customer_Relationship_Management" class="nav-link">
                            <i class="icon-users"></i>
                            <span class="title">Contacts Relationship Management</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if($user_id == 185 || $user_id == 34 || $user_id == 42 || $user_id == 35 || $user_id == 55 || $user_id == 54 || $user_id == 41 || $user_id == 32 || $user_id == 109): ?>
                    <li class="nav-item hide <?php echo $site === "Internal_Audit" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { // echo menu('Internal_Audit', $current_userEmployerID, $current_userEmployeeID); 
                            } ?>">
                        <a href="Internal_Audit" class="nav-link">
                            <i class="icon-layers"></i>
                            <span class="title">Internal Audit</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if($current_userEmployerID == 247 || $current_userEmployerID == 34 || $user_id == 362): ?>
                    <li class="nav-item hide <?php echo $site === "inventory-management" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('inventory-management', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="inventory-management" class="nav-link">
                            <i class="icon-social-dropbox"></i>
                            <span class="title">Inventory Management</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if($current_userEmployerID == 254 || $current_userEmployerID == 247 || $current_userEmployerID == 34 || $user_id == 1 || $user_id == 362): ?>
                    <li class="nav-item hide <?php echo $site === "library" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('library', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="library" class="nav-link">
                            <i class="icon-folder"></i>
                            <span class="title">Library</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if($user_id <> 259 || $user_id <> 155): ?>
                    <li class="nav-item hide <?php echo $site === "rvm" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('rvm', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="rvm" class="nav-link">
                            <i class="icon-docs"></i>
                            <span class="title">RVM</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if($switch_user_id <> 249): ?>
                    <li class="nav-item hide <?php echo $site === "pmp" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('pmp', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="pmp.php" class="nav-link">
                            <i class="icon-layers"></i>
                            <span class="title">Preventive Maintenance Program</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if($_COOKIE['ID'] == 48100 OR $switch_user_id == 464): ?>
                    <li class="nav-item <?php echo $site === "emp_dashboard" ? "active" : ""; ?>">
                        <a href="emp_dashboard" class="nav-link">
                            <i class="icon-target"></i>
                            <span class="title">EMP</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php $query = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE enterpriseEmployees = 'Yes' AND users_entities = $switch_user_id " ); if ( mysqli_num_rows($query) > 0 ) { ?>
                    <?php if($switch_user_id == 34 || $switch_user_id == 19): ?>
                    <li class="nav-item hide <?php echo $site === "Legal_Expert" || $site === "Critical_Operation" || $site === "Types_Of_Crisis" ? "active open start" : "";  ?>" id="menuCMAA">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-graph"></i>
                            <span class="title">Crisis Management</span>
                            <span class="selected"></span>
                            <span class="arrow <?php echo $site === "Legal_Expert" || $site === "Critical_Operation" || $site === "Types_Of_Crisis" ? "open" : ""; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?php echo $site === "Legal_Expert" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('Legal_Expert', $current_userEmployerID, $current_userEmployeeID); }?>">
                                <a href="Legal_Expert" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Legal & Expert</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "Critical_Operation" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('Critical_Operation', $current_userEmployerID, $current_userEmployeeID); }?> ?>">
                                <a href="Critical_Operation" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Critical Operation</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "Types_Of_Crisis" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('Types_Of_Crisis', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="Types_Of_Crisis" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Types Of Crisis</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "crisis_incidents" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('crisis_incidents', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="crisis_incidents" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Crisis Incidents</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo $site === "crisis_annual_review" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('crisis_annual_review', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="crisis_annual_review" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Annual Review</span>
                                </a>
                            </li>
                            <?php if($user_id == 185): ?>
                            <li class="nav-item <?php echo $site === "crisis_testing_verification" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('crisis_testing_verification', $current_userEmployerID, $current_userEmployeeID); } ?>">
                                <a href="crisis_testing_verification" class="nav-link ">
                                    <i class="fa fa-minus" style="font-size: 10px;"></i>
                                    <span class="title">Testing And Verification</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php } ?>

                    <?php if($switch_user_id == 1360 OR $switch_user_id == 1365 OR $switch_user_id == 1366 OR $switch_user_id == 1453 OR $switch_user_id == 1482 OR $switch_user_id == 1477): ?>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Environmental Monitoring Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Equipment Calibration Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Food Safety Culture Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Formula / Recipe Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">HACCP / Food Safety Plan Builder Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Laboratory Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Positive Product Release Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Residue Testing Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Risk Assessment</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Shelf Life Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Stability Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Storage and Distribution Report Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif ?>
                    
                    <?php if($switch_user_id == 1372): ?>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Production Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Foreign Supplier Verification Program (FSVP) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Sanitation Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Preventive Maintenance Program (PMP) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Formulation/Product Realization Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Product Testing Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Environmental Monitoring Program (EMP) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Records Verification Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Food Fraud Vulnerability Assessment (FFVA) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Certificate of Analysis (COA) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Internal Audit (IA) Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Shelf Life Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Stability Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Food Safety/ HACCP Plan Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Bill of Material (BOM) / Mock Recall Traceability Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Calibration Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Crisis Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Customer Complaint Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Food Safety Culture Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Laboratory Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Inventory Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Storage and Distribution Report Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Sales Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Positive Product Release Program Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Residue Testing Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Purchasing Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">QA/QC Activity Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="coming-soon" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">Receiving Management</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif ?>
                    
                    
                    
                    <li class="nav-item <?php echo $site === "forms" ? "active" : ""; ?>">
                        <a href="forms" class="nav-link">
                            <i class="icon-docs" style="color: orange !important;"></i>
                            <span class="title">Forms</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $site === "module" ? "active" : ""; ?>">
                        <a href="module" class="nav-link">
                            <i class="icon-social-dropbox" style="color: orange !important;"></i>
                            <span class="title">Module</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item hide <?php echo $site === "pro_services" ? "active" : ""; ?>">
                        <a href="pro-services" class="nav-link">
                            <i class="icon-flag" style="color: orange !important;"></i>
                            <span class="title">Pro-Serives</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $site === "app-store" ? "active" : ""; ?>">
                        <a href="https://consultareinc.com/shop/" target="_blank" class="nav-link">
                            <i class="icon-book-open" style="color: orange !important;"></i>
                            <span class="title">SOPs</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $site === "app-store" ? "active" : ""; ?>">
                        <a href="https://consultareinc.com/training-ace/" target="_blank" class="nav-link">
                            <i class="icon-screen-desktop" style="color: orange !important;"></i>
                            <span class="title">Training Ace</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $site === "app-store" ? "active" : ""; ?>">
                        <a href="https://consultareinc.com/fda/fda-registration-information-sheet/" target="_blank" class="nav-link">
                            <i class="icon-pencil" style="color: orange !important;"></i>
                            <span class="title">FDA Registration</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <?php
                        if($current_client == 0) {
                            $hasLibrary = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE user_id = $switch_user_id" );
                            if ( mysqli_num_rows($hasLibrary) == 0 OR $switch_user_id == 163) {
                                echo '<li class="nav-item '; echo $site === "pricing" ? "active" : ""; echo '">
                                    <a href="pricing" class="nav-link">
                                        <i class="icon-tag" style="color: #ffff00;"></i>
                                        <span class="title" style="color: #ffff00; font-weight: bold;">Software Package</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>';
                            }
                        }
                    ?>


                    <li class="nav-item hide <?php echo $site === "researchandDev" ? "active" : ""; ?>">
                        <a href="researchandDev" class="nav-link">
                            <i class="icon-puzzle"></i>
                            <span class="title">R and D</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <?php if($user_id == 185 || $user_id == 34 || $user_id == 42 || $user_id == 35 || $user_id== 88 || $user_id== 95 || $user_id== 228 || $user_id== 208): ?>
                    <li class="nav-item <?php echo $site === "Task_Tracker" ? "active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { // echo menu('Task_Tracker', $current_userEmployerID, $current_userEmployeeID); 
                            } ?>">
                        <a href="Task_Tracker" class="nav-link">
                            <i class="icon-earphones-alt"></i>
                            <span class="title">Task Tracker</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if($user_id == 34): ?>
                    <li class="nav-item <?php echo $site === "pto_request" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('pto_requestt', $current_userEmployerID, $current_userEmployeeID); } ?>">
                        <a href="pto_request" class="nav-link">
                            <i class="icon-social-dropbox"></i>
                            <span class="title">PTO Request</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php endif ?>

                    <?php
                            $query = mysqli_query( $conn,"SELECT * FROM tbl_GetApps left join tbl_appstore on app_id = apps_entities where appType = 'IA' and users_entities = $switch_user_id " );
                            if ( mysqli_num_rows($query) > 0 ) {                             
                                while($row = mysqli_fetch_array($query)) {
                        ?>
                    <li class="nav-item hide">
                        <a href="<?php echo $row['app_url']; ?>" target="_blank" class="nav-link">
                            <i class="icon-layers"></i>
                            <span class="title"><?php echo htmlentities($row['application_name']); ?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php }} ?>
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN THEME PANEL -->
                <div class="theme-panel hide">
                    <div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
                        <i class="icon-settings"></i>
                    </div>
                    <div class="toggler-close">
                        <i class="icon-close"></i>
                    </div>
                    <div class="theme-options">
                        <div class="theme-option theme-colors clearfix">
                            <span>THEME COLOR</span>
                            <ul>
                                <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                                <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                                <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                                <li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark"> </li>
                                <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                            </ul>
                        </div>
                        <div class="theme-option">
                            <span> Theme Style </span>
                            <select class="layout-style-option form-control input-small">
                                <option value="square" selected="selected">Square corners</option>
                                <option value="rounded">Rounded corners</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Layout </span>
                            <select class="layout-option form-control input-small">
                                <option value="fluid" selected="selected">Fluid</option>
                                <option value="boxed">Boxed</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Header </span>
                            <select class="page-header-option form-control input-small">
                                <option value="fixed" selected="selected">Fixed</option>
                                <option value="default">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Top Dropdown</span>
                            <select class="page-header-top-dropdown-style-option form-control input-small">
                                <option value="light" selected="selected">Light</option>
                                <option value="dark">Dark</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Sidebar Mode</span>
                            <select class="sidebar-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Sidebar Style</span>
                            <select class="sidebar-style-option form-control input-small">
                                <option value="default" selected="selected">Default</option>
                                <option value="compact">Compact</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Sidebar Menu </span>
                            <select class="sidebar-menu-option form-control input-small">
                                <option value="accordion" selected="selected">Accordion</option>
                                <option value="hover">Hover</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Sidebar Position </span>
                            <select class="sidebar-pos-option form-control input-small">
                                <option value="left" selected="selected">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span> Footer </span>
                            <select class="page-footer-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END THEME PANEL -->

                <h1 class="page-title"><?php echo $title; ?></h1>
                <!--<input type='text' id='secondsRemaining' value='' readonly>-->
                <!--<a href='#' class='60Left btn btn-default'>60 Secs Left</a>-->
                <!--<a href='#' class='0Left btn btn-default'>Timed Out</a>-->
                <!--<a href='#' class='1440Left btn btn-default'>Reset</a>-->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="<?php 
                                    $uri = $_SERVER['REQUEST_URI'];
                                    $baseURI = explode('?', $uri)[0];
                                    echo $baseURI;
                                ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <?php echo $breadcrumbs; ?>
                    </ul>
                    <div class="page-toolbar <?php if ($site == '404' OR $site == '505' OR $site == 'dashboard' OR $current_userEmployerID > 0) { echo 'hide'; } else if (!isset($_COOKIE['switchAccount'])) { if ($current_userEmployeeID > '0' AND $current_userAdminAccess == 0 AND $current_userID <> 532) { echo 'hide'; } } ?>">
                        <!--<div class="page-toolbar <?php //if ($site == '404' OR $site == '505' OR $site == 'dashboard' OR $current_userEmployeeID > '0') { echo 'hide'; } ?>">-->
                        <a href="#modalCollab" data-toggle="modal" class="btn btn-success btn-fit-height">
                            Collaborator <i class="icon-settings"></i>
                        </a>
                    </div>
                </div>
                <!-- END PAGE HEADER-->

                <!--Emjay Modal Start-->
                <form action="controller.php" method="POST">
                    <div class="modal fade" id="request_pto" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Request PTO
                                            (Remaining Leave:
                                            <?php 
                                                    $selectOtherEmployee = mysqli_query( $conn,"SELECT * FROM others_employee_details WHERE employee_id = $current_userEmployeeID" );
                                        			if ( mysqli_num_rows($selectOtherEmployee) > 0 ) {
                                        				$rowOtherEmployee = mysqli_fetch_array($selectOtherEmployee);
                                                        $total_leave =  $rowOtherEmployee['total_leave'];
                                                        echo $rowOtherEmployee['total_leave'];
                                                        echo '<input type="hidden" name="remaining_leave" value="'.$total_leave.'" >';
                                        			}
                                                ?>
                                            )
                                        </h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Type of Leave</label>
                                                <select class="form-control" name="leave_type">
                                                    <?php
                                                    $sql = "SELECT * FROM leave_types WHERE leave_id != 0" ; 
                                                    $result = mysqli_query ($conn, $sql);
                                                    if($result):
                                                    foreach($result as $rows):
                                                    ?>
                                                    <option value="<?= $rows['leave_id'] ?>"><?= $rows['leave_name'] ?></option>
                                                    <?php endforeach; endif ?>
                                                </select>
                                            </div>
                                            <!--<div class="col-md-6">-->
                                            <!--    <label>Leave Count</label>-->
                                            <!--    <input type="text" name="leave_count" class="form-control">-->
                                            <input type="hidden" name="payeeid" value="<?= $user_id ?>">
                                            <!--</div>-->
                                        </div>
                                        <div class="row" style="margin-top:15px">
                                            <div class="col-md-6">
                                                <label>Start Date</label>
                                                <input type="date" id="fromDate" name="start_date" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>End Date</label>
                                                <input type="date" id="toDate" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px">
                                            <div class="col-md-6">
                                                <label>Note</label>
                                                <textarea class="form-control" name="note" row="3"></textarea>
                                            </div>
                                            <?php if($_COOKIE['ID'] == 108): ?>
                                            <div class="col-md-6">
                                                <label>Attachment(Optional)</label>
                                                <input type="file" class="form-control">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success" name="save_pto"><span id="save_pto">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="generate_pto" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="controller_extract.php" method="post" enctype="multipart/form-data" class="modalForm">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row" style="margin-top:15px">
                                            <div class="col-md-6">
                                                <label>Start Date</label>
                                                <input type="date" name="start_date" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>End Date</label>
                                                <input type="date" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success" name="generate_pto"><span id="save_pto">Generate</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Export Modal -->
                    <div class="modal fade" id="modal_export" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="export.php">
                                        <div class="form-group">
                                            <label for="fromDate">From Date</label>
                                            <input type="date" class="form-control" id="fromDate" name="fromDate" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="toDate">To Date</label>
                                            <input type="date" class="form-control" id="toDate" name="toDate" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Emjay Modal End-->

                    <script>
                    function myfunction(id) {
                        const d = new Date();
                        d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
                        let expires = "expires=" + d.toUTCString();
                        document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
                    }
                    const fromDateInput = document.getElementById('fromDate');
                    const toDateInput = document.getElementById('toDate');

                    fromDateInput.addEventListener('change', function() {
                        // Get the selected date from the first input
                        const fromDateValue = new Date(this.value);

                        // Set the minimum selectable date for the second input
                        toDateInput.min = this.value;

                        // Check if the selected date is valid in the second input
                        const toDateValue = new Date(toDateInput.value);
                        if (fromDateValue > toDateValue) {
                            toDateInput.value = this.value; // Reset the second input if the selected date is less than the first input
                        }
                    });
                    </script>