<?php include_once 'database_iiq.php'; ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <base href="../">
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
        <link href="assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />

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

        <link href="assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->

        <style type="text/css">
            
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
            .offcanvas, .offcanvas-lg, .offcanvas-md, .offcanvas-sm, .offcanvas-xl, .offcanvas-xxl {
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
            .offcanvas.hiding, .offcanvas.show, .offcanvas.showing {
                visibility: visible;
            }
            .offcanvas.show:not(.hiding), .offcanvas.showing {
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
                display: flex!important;
            }
            .position-relative {
                position: relative!important;
            }
            .position-absolute {
                position: absolute!important;
            }
            .flex-shrink-0 {
                flex-shrink: 0!important;
            }
            .flex-grow-1 {
                flex-grow: 1!important;
            }
            .align-items-center {
                align-items: center!important;
            }
            .justify-content-between {
                justify-content: space-between !important;
            }
            .p-1 {
                padding: .25rem!important;
            }
            .p-2 {
                padding: .5rem!important;
            }
            .mb-1 {
                margin-bottom: .25rem!important;
            }
            .mt-2 {
                margin-top: .5rem!important;
            }
            .ms-3 {
                margin-left: 1rem!important;
            }
            .mb-0 {
                margin-top: 0!important;
                margin-bottom: 0!important;
            }
            .top-0 {
                top: 0!important;
            }
            .bottom-0 {
                bottom: 0!important;
            }
            .start-0 {
                left: 0!important;
            }
            .end-0 {
                right: 0!important;
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
                overflow: auto!important;
            }
            .flex-column-reverse {
                flex-direction: column-reverse!important;
            }
            .rounded-circle {
                border-radius: 50% !important;
            }
            #sendMessage2 .border {
                border-color: #E1E5EC !important;
            }
            #sendMessage2 .modal-body .secMessage > div {
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
            #sendMessage2 .modal-body .secContainer.secSender .secMessage > div {
                margin-right: unset;
                margin-left: auto;
                color: #fff;
                background-color: #32C5D2 !important;
            }

            /*SPEAKUP*/
            .speakupList > li a {
                display: block !important;
                white-space: nowrap !important;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #tableData_Speakup thead th:first-child{
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
        </style>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" id="bodyView">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top bg-white">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse" style="filter: invert(100%);"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN PAGE ACTIONS -->
                <!-- DOC: Remove "hide" class to enable the page header actions -->
                <div class="page-actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-circle btn-outline red dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-plus"></i>&nbsp;
                            <span class="hidden-sm hidden-xs">New&nbsp;</span>&nbsp;
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
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
                <!-- END PAGE ACTIONS -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <!-- BEGIN HEADER SEARCH BOX -->
                    <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                    <form class="search-form search-form-expanded" action="page_general_search_3.html" method="GET">
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
                    
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-extended" id="googleTranslate">
                                <div class="dropdown-toggle" id="google_translate_element"></div>
                            </li>
                            

                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class below "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            <li class="dropdown dropdown-extended dropdown-notification hide" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default"> 7 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold">12 pending</span> notifications</h3>
                                        <a href="page_user_profile_1.html">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">just now</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                        </span> New user registered. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">3 mins</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Server #12 overloaded. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">10 mins</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span> Server #2 not responding. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">14 hrs</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span> Application error. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">2 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Database overloaded 68%. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">3 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> A user IP blocked. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">4 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span> Storage Server #4 not responding dfdfdfd. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">5 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span> System Error. </span>
                                                </a>
                                            </li>
                                            <li>
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
                                            <span class="bold">7 New</span> Messages</h3>
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
                                            <span class="bold">12 pending</span> tasks</h3>
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
                                            echo '<img src="admin_2/uploads/avatar/'. $current_userAvatar .'" class="img-circle" alt="Avatar" />';
                                        }
                                    ?>
                                    <span class="username username-hide-on-mobile notranslate"></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="admin_2/profile"><i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li class="hide">
                                        <a href="app_calendar.html"><i class="icon-calendar"></i> My Calendar </a>
                                    </li>
                                    <li class="hide">
                                        <a href="app_inbox.html"><i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">3</span></a>
                                    </li>
                                    <li>
                                        <a href="app_todo_2.html"><i class="icon-rocket"></i> My Tasks <span class="badge badge-success myTask"></span></a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="javascript:;" onclick="btnLocked()"><i class="icon-lock"></i> Lock Screen</a>
                                    </li>

                                    <li>
                                        <a href="javascript:;" onclick="btnLogout()"><i class="icon-key"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-extended quick-sidebar-toggler hidex">
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
                    <!-- <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200"> -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenux page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start ">
                                    <a href="index.html" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard 1</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a href="dashboard_2.html" class="nav-link ">
                                        <i class="icon-bulb"></i>
                                        <span class="title">Dashboard 2</span>
                                        <span class="badge badge-success">1</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a href="dashboard_3.html" class="nav-link ">
                                        <i class="icon-graph"></i>
                                        <span class="title">Dashboard 3</span>
                                        <span class="badge badge-danger">5</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?php echo $site === "compliance" ? "active" : ""; ?>">
                            <a href="admin_2" class="nav-link">
                                <i class="icon-check"></i>
                                <span class="title">Compliance</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "tracking" ? "active" : ""; ?>">
                            <a href="admin_2/tracking" class="nav-link">
                                <i class="icon-check"></i>
                                <span class="title">Tracking Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "appstore" ? "active" : ""; ?>">
                            <a href="admin_2/app-store" class="nav-link">
                                <i class="icon-grid"></i>
                                <span class="title">App Catalog</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item hide <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" || $site === "training-requirements" ? "active open start" : ""; ?>" id="menuHR">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user-female"></i>
                                <span class="title">HR</span>
                                <span class="selected"></span>
                                <span class="arrow <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" || $site === "training-requirements" ? "open" : ""; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?php echo $site === "employee" ? "active" : ""; ?>">
                                    <a href="admin_2/employee" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Employee Roster</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "job-description" ? "active" : ""; ?>">
                                    <a href="admin_2/job-description" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Job Description</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "trainings" ? "active" : ""; ?>">
                                    <a href="admin_2/trainings" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Trainings</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "training-requirements" ? "active" : ""; ?>">
                                    <a href="admin_2/training-requirements" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Training Requirements</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "department" ? "active" : ""; ?>">
                                    <a href="admin_2/department" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Department</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?php echo $site === "customer" ? "active" : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('customer', $current_userEmployerID, $current_userEmployeeID); } ?>">
                            <a href="admin_2/customer" class="nav-link">
                                <i class="icon-users"></i>
                                <span class="title">Customer</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "supplier" ? " active " : ""; if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) { echo menu('supplier', $current_userEmployerID, $current_userEmployeeID); } ?> ">
                            <a href="admin_2/supplier" class="nav-link">
                                <i class="icon-basket-loaded"></i>
                                <span class="title">Supplier</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "rd" ? "active" : ""; ?>">
                            <a href="admin_2/research-and-development" class="nav-link">
                                <i class="icon-puzzle"></i>
                                <span class="title">R and D</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "services" ? "active" : ""; ?>">
                            <a href="admin_2/services" class="nav-link">
                                <i class="icon-list"></i>
                                <span class="title">Services</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "library" ? "active" : ""; ?>">
                            <a href="admin_2/library" class="nav-link">
                                <i class="icon-folder"></i>
                                <span class="title">Library</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "products" ? "active" : ""; ?>">
                            <a href="admin_2/products" class="nav-link">
                                <i class="icon-social-dropbox"></i>
                                <span class="title">Products</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "job-listing" ? "active" : ""; ?>">
                            <a href="admin_2/job-listing" class="nav-link">
                                <i class="icon-briefcase"></i>
                                <span class="title">Job Listing</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "listing" ? "active" : ""; ?>">
                            <a href="admin_2/listing" class="nav-link">
                                <i class="icon-briefcase"></i>
                                <span class="title">Listing</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "job-ticket" ? "active" : ""; ?>">
                            <a href="admin_2/job-ticket" class="nav-link">
                                <i class="icon-earphones-alt"></i>
                                <span class="title">Job Ticket Tracker</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "job-ticket-request" || $site === "job-ticket-service" ? "active open start" : ""; ?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-earphones"></i>
                                <span class="title">Job Ticket Tracker</span>
                                <span class="selected"></span>
                                <span class="arrow <?php echo $site === "job-ticket-request" || $site === "job-ticket-service" ? "open" : ""; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?php echo $site === "job-ticket-request" ? "active" : ""; ?>">
                                    <a href="admin_2/job-ticket-request" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Request</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "job-ticket-service" ? "active" : ""; ?>">
                                    <a href="admin_2/job-ticket-service" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Service</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-section hide">
                            <h4 class="menu-text">Layout</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="nav-item <?php echo $site === "archiving" ? "active" : ""; ?>">
                            <a href="admin_2/archiving" class="nav-link">
                                <i class="icon-folder-alt"></i>
                                <span class="title">Archiving</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "formulation" ? "active" : ""; ?>">
                            <a href="admin_2/formulation" class="nav-link">
                                <i class="icon-calculator"></i>
                                <span class="title">Formulation</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "ffva" ? "active" : ""; ?>">
                            <a href="admin_2/ffva" class="nav-link">
                                <i class="icon-doc"></i>
                                <span class="title">FFVA</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "ffva-library" ? "active" : ""; ?>">
                            <a href="admin_2/ffva-library" class="nav-link">
                                <i class="icon-doc"></i>
                                <span class="title">FFVA Library</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "rvm" ? "active" : ""; ?>">
                            <a href="admin_2/rvm" class="nav-link">
                                <i class="icon-docs"></i>
                                <span class="title">RVM</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $site === "inventory-management" ? "active" : ""; ?>">
                            <a href="admin_2/inventory-management" class="nav-link">
                                <i class="icon-social-dropbox"></i>
                                <span class="title">Inventory Management</span>
                                <span class="selected"></span>
                                <span class="badge badge-warning">Trial</span>
                            </a>
                        </li>
                       
                        <li class="nav-item hide <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" ? "active open start" : ""; ?>" id="menuHRss">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user-female"></i>
                                <span class="title">HR</span>
                                <span class="selected"></span>
                                <span class="arrow <?php echo $site === "employee" || $site === "job-description" || $site === "trainings" || $site === "department" ? "open" : ""; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?php echo $site === "employee" ? "active" : ""; ?>">
                                    <a href="admin_2/employee" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Employee Roster</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "job-description" ? "active" : ""; ?>">
                                    <a href="admin_2/job-description" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Job Description</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "trainings" ? "active" : ""; ?>">
                                    <a href="admin_2/trainings" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Trainings</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $site === "department" ? "active" : ""; ?>">
                                    <a href="admin_2/department" class="nav-link ">
                                        <i class="fa fa-minus" style="font-size: 10px;"></i>
                                        <span class="title">Department</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-puzzle"></i>
                                    <span class="title" title="Research and Development">R and D</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="components_date_time_pickers.html" class="nav-link ">
                                            <span class="title">Date & Time Pickers</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_color_pickers.html" class="nav-link ">
                                            <span class="title">Color Pickers</span>
                                            <span class="badge badge-danger">2</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_select2.html" class="nav-link ">
                                            <span class="title">Select2 Dropdowns</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_multiselect_dropdown.html" class="nav-link ">
                                            <span class="title">Bootstrap Multiselect Dropdowns</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_select.html" class="nav-link ">
                                            <span class="title">Bootstrap Select</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_multi_select.html" class="nav-link ">
                                            <span class="title">Bootstrap Multiple Select</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_select_splitter.html" class="nav-link ">
                                            <span class="title">Select Splitter</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_clipboard.html" class="nav-link ">
                                            <span class="title">Clipboard</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_typeahead.html" class="nav-link ">
                                            <span class="title">Typeahead Autocomplete</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_tagsinput.html" class="nav-link ">
                                            <span class="title">Bootstrap Tagsinput</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_switch.html" class="nav-link ">
                                            <span class="title">Bootstrap Switch</span>
                                            <span class="badge badge-success">6</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_maxlength.html" class="nav-link ">
                                            <span class="title">Bootstrap Maxlength</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_fileinput.html" class="nav-link ">
                                            <span class="title">Bootstrap File Input</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_bootstrap_touchspin.html" class="nav-link ">
                                            <span class="title">Bootstrap Touchspin</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_form_tools.html" class="nav-link ">
                                            <span class="title">Form Widgets & Tools</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_context_menu.html" class="nav-link ">
                                            <span class="title">Context Menu</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_editors.html" class="nav-link ">
                                            <span class="title">Markdown & WYSIWYG Editors</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_code_editors.html" class="nav-link ">
                                            <span class="title">Code Editors</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_ion_sliders.html" class="nav-link ">
                                            <span class="title">Ion Range Sliders</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_noui_sliders.html" class="nav-link ">
                                            <span class="title">NoUI Range Sliders</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_knob_dials.html" class="nav-link ">
                                            <span class="title">Knob Circle Dials</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Quality</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="form_controls.html" class="nav-link ">
                                            <span class="title">Bootstrap Form
                                                <br>Controls</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_controls_md.html" class="nav-link ">
                                            <span class="title">Material Design
                                                <br>Form Controls</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_validation.html" class="nav-link ">
                                            <span class="title">Form Validation</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_validation_states_md.html" class="nav-link ">
                                            <span class="title">Material Design
                                                <br>Form Validation States</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_validation_md.html" class="nav-link ">
                                            <span class="title">Material Design
                                                <br>Form Validation</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_layouts.html" class="nav-link ">
                                            <span class="title">Form Layouts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_repeater.html" class="nav-link ">
                                            <span class="title">Form Repeater</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_input_mask.html" class="nav-link ">
                                            <span class="title">Form Input Mask</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_editable.html" class="nav-link ">
                                            <span class="title">Form X-editable</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_wizard.html" class="nav-link ">
                                            <span class="title">Form Wizard</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_icheck.html" class="nav-link ">
                                            <span class="title">iCheck Controls</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_image_crop.html" class="nav-link ">
                                            <span class="title">Image Cropping</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_fileupload.html" class="nav-link ">
                                            <span class="title">Multiple File Upload</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="form_dropzone.html" class="nav-link ">
                                            <span class="title">Dropzone File Upload</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-bulb"></i>
                                    <span class="title">Production</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="elements_steps.html" class="nav-link ">
                                            <span class="title">Steps</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="elements_lists.html" class="nav-link ">
                                            <span class="title">Lists</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="elements_ribbons.html" class="nav-link ">
                                            <span class="title">Ribbons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="elements_overlay.html" class="nav-link ">
                                            <span class="title">Overlays</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="elements_cards.html" class="nav-link ">
                                            <span class="title">User Cards</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">Logistics</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="table_static_basic.html" class="nav-link ">
                                            <span class="title">Warehousing</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="table_static_responsive.html" class="nav-link ">
                                            <span class="title">Inbound</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="table_bootstrap.html" class="nav-link ">
                                            <span class="title">Outbound</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link nav-toggle">
                                            <span class="title">Inventory</span>
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item ">
                                                <a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_scroller.html" class="nav-link "> Scroller Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_responsive.html" class="nav-link "> Responsive Extension </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_editable.html" class="nav-link "> Editable Datatables </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="?p=" class="nav-link nav-toggle">
                                    <i class="icon-wallet"></i>
                                    <span class="title">Maintenance</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="portlet_boxed.html" class="nav-link ">
                                            <span class="title">Equipment</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="portlet_light.html" class="nav-link ">
                                            <span class="title">Facility and Grounds</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="portlet_solid.html" class="nav-link ">
                                            <span class="title">Pest Control</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="portlet_ajax.html" class="nav-link ">
                                            <span class="title">Measuring Devices</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="portlet_draggable.html" class="nav-link ">
                                            <span class="title">Utilities-Water</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="portlet_draggable.html" class="nav-link ">
                                            <span class="title">Boiler</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-bar-chart"></i>
                                    <span class="title">Purchasing/Supply Chain</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="charts_amcharts.html" class="nav-link ">
                                            <span class="title">amChart</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="charts_flotcharts.html" class="nav-link ">
                                            <span class="title">Flot Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="charts_flowchart.html" class="nav-link ">
                                            <span class="title">Flow Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="charts_google.html" class="nav-link ">
                                            <span class="title">Google Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="charts_echarts.html" class="nav-link ">
                                            <span class="title">eCharts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="charts_morris.html" class="nav-link ">
                                            <span class="title">Morris Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link nav-toggle">
                                            <span class="title">HighCharts</span>
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item ">
                                                <a href="charts_highcharts.html" class="nav-link "> HighCharts </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="charts_highstock.html" class="nav-link "> HighStock </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a href="charts_highmaps.html" class="nav-link "> HighMaps </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
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
                                <span> THEME COLOR </span>
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
                    <!-- END PAGE HEADER-->