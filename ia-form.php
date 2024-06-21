<?php include_once 'database_iiq.php'; ?>

<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_COOKIE['locked'])) {
        echo '<script>alert("locked");window.location.href = "locked";</script>';
    }

    if (!isset($_COOKIE['ID'])) {
        // $url='login';
        // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
        // header('Location: login');
        // header($_SERVER['HTTP_REFERER']);

        echo '<script>
            window.location.href = "login";
            // alert(document.referrer);
            // if (document.referrer == "") {
            //     window.location.href = "login";
            // } else {
            //     window.history.back();
            // }
        </script>';
    } else {
        $base_url = "//localhost/dev/consultare/fsms/theme/admin_2/";
        $user_id = $_COOKIE['ID'];
        $current_client = $_COOKIE['client'];
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

        $FreeAccess = 1;
        // setcookie('FreeAccess', $FreeAccess, time() + (86400 * 1), "/");  // 86400 = 1 day

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $user_id" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $current_userID = $rowUser['ID'];
            $current_userEmployeeID = $rowUser['employee_id'];
            $current_userFName = $rowUser['first_name'];
            $current_userLName = $rowUser['last_name'];
            $current_userEmail = $rowUser['email'];
            $current_userType = $rowUser['type'];
        }

        $selectUserInfo = mysqli_query( $conn,"SELECT * from tbl_user_info WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectUserInfo) > 0 ) {
            $rowUserInfo = mysqli_fetch_array($selectUserInfo);
            $current_userMobile = $rowUserInfo['mobile'];
            $current_userInterest = $rowUserInfo['interest'];
            $current_userAddress = $rowUserInfo['address'];
            $current_userDLicense = $rowUserInfo['driver_license'];
            $current_userOccupation = $rowUserInfo['occupation'];
            $current_userAbout = $rowUserInfo['about'];
            $current_userWebsite = $rowUserInfo['website'];
            $current_userAvatar = $rowUserInfo['avatar'];
            if (!empty($rowUserInfo['privacy'])) { $current_userPrivacy = $rowUserInfo['privacy']; }
        }

        $selectSM = mysqli_query( $conn,"SELECT * from tbl_user_social_media WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectSM) > 0 ) {
            $rowSM = mysqli_fetch_array($selectSM);
            $current_userLinkedIn = $rowSM['linkedin'];
            $current_userFacebook = $rowSM['facebook'];
            $current_userTwitter = $rowSM['twitter'];
            $current_userPage = $rowSM['page'];
        }

        // Redirect page base on user type
        // $link = $_SERVER['PHP_SELF'];
        // $link_array = explode('/',$link);
        // $page = end($link_array);
        // if ($current_userType == 1) {
        //     $array_page = array('admin_2','app-store','employee','job-description','trainings','department','customer','supplier','profile','profile-setting');
        //     if (!in_array($page, $array_page)) {
        //         echo '<script>window.history.back();</script>';
        //     }
        // } else if ($current_userType == 2) {
        //     $array_page = array('admin_2.php','app-store.php','profile.php','profile-setting.php');
        //     if (!in_array($page, $array_page)) {
        //         echo '<script>window.history.back();</script>';
        //     }
        // }

        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
                $current_userAdminAccess = $rowEmployer["admin"];
            }
        } else {
            $current_userEmployerID = $current_userID;
        }


        // For Switch Account Profie
        if (isset($_COOKIE['switchAccount'])) {
            $id = $_COOKIE['switchAccount'];

            // $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $id" );
            // if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            //     $rowEnterprise = mysqli_fetch_array($selectEnterprise);
            //     $enterp_id = $rowEnterprise['enterp_id'];
            //     $enterp_logo = $rowEnterprise['BrandLogos'];
            //     $enterp_name = $rowEnterprise['businessname'];
            //     $enterp_userID = $rowEnterprise['users_entities'];
            // }

            $enterp_id = 123;
            $enterp_logo = 'no_images.png';
            $enterp_name = 'GFS';
            $enterp_userID = 1;
        }
        // For Employee ONLY
        else {
            // $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $current_userEmployerID" );
            // if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            //     $rowEnterprise = mysqli_fetch_array($selectEnterprise);
            //     $enterp_id = $rowEnterprise['enterp_id'];
            //     $enterp_logo = $rowEnterprise['BrandLogos'];
            //     $enterp_name = $rowEnterprise['businessname'];
            //     $enterp_userID = $rowEnterprise['users_entities'];
            // } else {
                $enterp_id = 123;
                $enterp_logo = 'no_images.png';
                $enterp_name = 'GFS';
                $enterp_userID = 1;
            // }
                
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
<html>
	<head>
	    <base href="../">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>IAC Form</title>
	    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" />
	    <link rel="stylesheet" type="text/css" href="assets/global/plugins/font-awesome/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" />
	    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap/css/bootstrap.min.css" />
	    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" />
	    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <link href="assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
        
        <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet" type="text/css" />

        <link href="assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />

        <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

        <link href="assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- <link href="assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" /> -->
        <!-- END THEME LAYOUT STYLES -->

        <link rel="shortcut icon" href="assets/img/interlink icon.png" />
        <!-- <link href="custom.css" rel="stylesheet" type="text/css" /> -->

		<style>
		    .modal .bs-select small {
		        display: block;
		    }
		    .bootstrap-tagsinput { min-height: 100px; }

		    .m-0 {
		        margin: 0 !important;
		    }

            .sorting_highlight {
                background: yellow;
                cursor: move;
                height: 50px;
            }

		    @media only screen and (min-width: 600px) {
		        #modalView table tr.bg-default {
		            white-space: nowrap;
		        }
		    }

		    .modal-footer--sticky {
				position: sticky;
				bottom: 0;
				background-color: inherit; /* [1] */
				z-index: 1055; /* [2] */
			}
		    .gauge {
		        width: 320px;
		        height: 240px;
		        margin-left: auto;
		    }

            .sweet-overlay {
                z-index: 10400;
            }
            .sweet-alert {
                z-index: 20000;
            }
            .ui-helper-hidden-accessible, .ui-tooltip {
                display: none !important;
            }
            .blockUI {
                position: unset !important;
            }
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<?php
				if (!empty($_COOKIE['switchAccount'])) {
					$portal_user = $_COOKIE['ID'];
					$user_id = $_COOKIE['switchAccount'];
				}
				else {
					$portal_user = $_COOKIE['ID'];
					$user_id = employerID($portal_user);
				}

				if (isset($_GET['i']) AND isset($_GET['t'])) {
					$ID = $_GET['i'];
					if ($_GET['t'] == 1) {
                        $selectData = mysqli_query( $conn,"SELECT
                            i.timestamp_id AS s_timestamp_id,
                            i.title AS i_title,
                            i.description AS i_description,
                            i.last_modified AS i_last_modified,
                            i.sheet_id AS i_sheet_id
                            FROM tbl_ia AS i

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_ia_sheet
                                WHERE deleted = 0
                                AND LENGTH(timestamp_id) > 0
                            ) AS s
                            ON FIND_IN_SET(s.ID, REPLACE(REPLACE(i.sheet_id, ' ', ''), '|',','  )  ) > 0

                            WHERE i.deleted = 0 
                            AND i.ID = $ID

                            GROUP BY i.ID" );
						if ( mysqli_num_rows($selectData) > 0 ) {
                            $rowIA = mysqli_fetch_array($selectData);
                            $ia_title = $rowIA['i_title'];
                            $ia_description = $rowIA['i_description'];
                            $ia_sheet_id = $rowIA['i_sheet_id'];
                            $s_timestamp_id = $rowIA['s_timestamp_id'];

                            $ia_last_modified = $rowIA['i_last_modified'];
							$ia_last_modified = new DateTime($ia_last_modified);
							$ia_last_modified = $ia_last_modified->format('M d, Y');

                            $type_arr = array();
                            $label_arr = array();
                            $label_name_arr = array();

                            $sub_header = '';
                            if (!empty($s_timestamp_id)) {
                                $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $s_timestamp_id ORDER BY order_id" );
                                if ( mysqli_num_rows($selectFormat) > 0 ) {
                                    while($rowFormat = mysqli_fetch_array($selectFormat)) {
                                        if ($rowFormat['type'] > 0) {
                                            if ($rowFormat['type'] == 1 OR $rowFormat['type'] == 3 OR $rowFormat['type'] == 4) {
                                                $sub_header .= '<td class="bold">'.$rowFormat['label'].'</td>';
                                            } else if ($rowFormat['type'] == 2) {
                                                $radio_arr = explode(",", $rowFormat['label']);
                                                foreach ($radio_arr as $r) {
                                                    $sub_header .= '<td class="bold">'.$r.'</td>';
                                                }
                                            }
                                            
                                            array_push($type_arr, $rowFormat['type']);
                                            array_push($label_arr, $rowFormat['ID']);
                                            array_push($label_name_arr, $rowFormat['label']);
                                        }
                                    }
                                }
                                $type = implode(' | ', $type_arr);
                                $label = implode(' | ', $label_arr);
                                $label_name = implode(' | ', $label_name_arr);
    
    							echo '<div id="modalGenerate">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalGenerate">
                                        <div class="modal-body">
            								<input class="form-control" type="hidden" name="ID" value = "'. $ID .'" />
                                            <input class="form-control" type="hidden" name="timestamp_id" value = "'. $s_timestamp_id .'" />
            								<h4 class="bold">'.stripcslashes($ia_title).'</h5>
            								<div class="row">
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label>Organization</label>
            									        <input type="text" class="form-control" name="organization" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label>Audit Type</label>
            									        <input type="text" class="form-control" name="audit_type" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label>Inspected By</label>
            									        <input type="text" class="form-control" name="inspected_by" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label>Auditee</label>
            									        <input type="text" class="form-control" name="auditee" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label>Verified By</label>
            									        <input type="text" class="form-control" name="verified_by" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Date</label>
            									        <div class="input-group">
            									            <input type="text" class="form-control daterange" name="daterange" />
            									            <span class="input-group-btn">
            									                <button class="btn default date-range-toggle" type="button">
            									                    <i class="fa fa-calendar"></i>
            									                </button>
            									            </span>
            									        </div>
            									    </div>
            									</div>
    
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Operation</label>
            									        <textarea class="form-control" name="operation"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Shipper</label>
            									        <textarea class="form-control" name="shipper"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Operation Type</label>
            									        <textarea class="form-control" name="operation_type"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Audit Executive Summary</label>
            									        <textarea class="form-control" name="audit_ex"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Addendum(s) included in the audit</label>
            									        <textarea class="form-control" name="addendum"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Product(s) observed during audit</label>
            									        <textarea class="form-control" name="product_observed"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Similar product(s)/process(es) not observed</label>
            									        <textarea class="form-control" name="similar_product"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Product(s) applied for but not observed</label>
            									        <textarea class="form-control" name="product_applied"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Auditor</label>
            									        <textarea class="form-control" name="auditor"></textarea>
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Preliminary Audit Score</label>
            									        <input type="text" class="form-control" name="preliminary_audit" readonly />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Final Audit Score</label>
            									        <input type="text" class="form-control" name="final_audit" readonly />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Certificate Valid From</label>
            									        <div class="input-group">
            									            <input type="text" class="form-control daterange" name="cert_valid" />
            									            <span class="input-group-btn">
            									                <button class="btn default date-range-toggle" type="button">
            									                    <i class="fa fa-calendar"></i>
            									                </button>
            									            </span>
            									        </div>
            									    </div>
            									</div>
    
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Date Documentation Review Started</label>
            									        <input type="datetime-local" class="form-control" name="date_review_started" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Date Documentation Review Finished</label>
            									        <input type="datetime-local" class="form-control" name="date_review_finished" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Total Amount of Time on the Documentation Review</label>
            									        <input type="text" class="form-control" name="total_time_review" />
            									    </div>
            									</div>
    
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Date Visual Inspection Started</label>
            									        <input type="datetime-local" class="form-control" name="date_inspection_started" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Date Visual Inspection Finished</label>
            									        <input type="datetime-local" class="form-control" name="date_inspection_finished" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Total Amount of Time on Visual Inspection</label>
            									        <input type="text" class="form-control" name="total_time_inspection" />
            									    </div>
            									</div>
    
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Company Logo <i>(Leave blank if not applicable)</i></label>
            									        <input type="file" class="form-control" name="file" accept="image/*" />
            									    </div>
            									</div>
            									<div class="col-md-4">
            									    <div class="form-group">
            									        <label class="control-label">Set Scoring</label>
            									        <select class="form-control" name="score_type" onchange="changeType(this, this.value)">
            									            <option value="0">Default</option>
            									            <option value="1">Custom</option>
            									        </select>
            									    </div>
            									</div>
            									<div class="col-md-12 score_data hide">
            									    <p>Custom Score Field(s) <a href="javascript:;" class="btn btn-success" onclick="btnRepeaterScoreAdd()"><i class="fa fa-plus"></i></a></p>
            									    <div class="scoreCustom"></div>
            									</div>
    
            									<div class="col-md-12">
            									    <div class="form-group">
            									        <label>Audit Scope</label>
            									        <textarea class="form-control summernote summernote_audit_scope" name="audit_scope"></textarea>
            									    </div>
            									</div>
            								</div>
    
            					            <p>Custom Field(s) <a href="javascript:;" class="btn btn-success" onclick="btnRepeaterFormAdd()"><i class="fa fa-plus"></i></a></p>
            					            <div class="formCustom"></div>
    
            					            <div class="box">
            					                <div id="gauge_'.$ID.'" class="gauge"></div>
            					            </div>
    
            								<table class="table margin-top-20" id="tableForm_'.$ID.'">';
    
            							        if (!empty($ia_sheet_id)) {
            							        	$ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
            							        	foreach($ia_sheet_id_arr as $sheet_id) {
    
            							        		$selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
            							        		if ( mysqli_num_rows($selectSheet) > 0 ) {
            							        			$rowSheet = mysqli_fetch_array($selectSheet);
            												$sheet_name = $rowSheet['name'];
            							        		}
    
            							        		echo '<tr class="bg-warning">
            												<td colspan="100%" class="text-center bold">'.$sheet_name.'</td>
            											</tr>
            							                <tr class="bg-default" id="'.$sheet_id.'">'.$sub_header.'</tr>';
    
                                                        $array_ID = array();
    
                                                        $selectDataRow = mysqli_query( $conn,"WITH RECURSIVE cte (rowID, rowOrder, rowParent, rowInclude, rowData) AS
                                                            (
                                                                SELECT
                                                                t1.ID AS rowID,
                                                                t1.order_id AS rowOrder,
                                                                t1.parent_id AS rowParent,
                                                                t1.include AS rowInclude,
                                                                t1.data AS rowData
                                                                FROM tbl_ia_data AS t1
                                                                WHERE t1.parent_id = 0 
                                                                AND t1.deleted = 0 
                                                                AND LENGTH(t1.data) > 0 
                                                                AND t1.sheet_id = $sheet_id
    
                                                                UNION ALL
    
                                                                SELECT
                                                                t2.ID AS rowID,
                                                                t2.order_id AS rowOrder,
                                                                t2.parent_id AS rowParent,
                                                                t2.include AS rowInclude,
                                                                t2.data AS rowData
                                                                FROM tbl_ia_data AS t2
                                                                JOIN cte ON cte.rowID = t2.parent_id
                                                                WHERE t2.deleted = 0 
                                                                AND LENGTH(t2.data) > 0 
                                                                AND t2.sheet_id = $sheet_id
                                                            )
                                                            SELECT 
                                                            rowID, rowOrder, rowParent, rowInclude, rowData
                                                            FROM cte
                                                            ORDER BY rowOrder ASC, rowID ASC" );
            											if ( mysqli_num_rows($selectDataRow) > 0 ) {
            												while($rowData = mysqli_fetch_array($selectDataRow)) {
            													$data_ID = $rowData['rowID'];
    
            													$include_arr = array();
            													if ($rowData['rowInclude'] != NULL) { $include_arr = explode(" | ", $rowData['rowInclude']); }
    
            							                        $data_arr = json_decode($rowData['rowData'],true);
    
                                                                echo '<tr id="tr_'.$data_ID.'">';
                                                                    $type_arr = explode(" | ", $type);
                                                                    $label_arr = explode(" | ", $label);
                                                                    $label_name_arr = explode(" | ", $label_name);
                                                                    
                                                                    $i = 0;
                                                                    foreach ($type_arr as $value) {
                                                                        if ($value > 0) {
                                                                            if ($value == 1 OR $value == 3 OR $value == 4) {
                                                                                if (in_array($label_arr[$i], $include_arr)) {
                                                                                    echo '<td>';
    
                                                                                        foreach($data_arr as $key => $val) {
                                                                                            if ($label_arr[$i] == $val['ID']) {
                                                                                                if (!empty($val['content'])) {
                                                                                                    echo $val['content'];
                                                                                                } else {
                                                                                                    $formatID = $label_arr[$i];
                                                                                                    $rowColumnData = '';
                                                                                                    if (!empty($form_data)) {
                                                                                                        $form_data_arr = json_decode($form_data,true);
    
                                                                                                        if (in_array($data_ID, array_column($form_data_arr, 'row'))) {
                                                                                                            $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($data_ID, $formatID) {
                                                                                                                if ($item['row'] === $data_ID && $item['content']['column'] === $formatID) {
                                                                                                                    return $item['content']['data'];
                                                                                                                }
                                                                                                                return $carry;
                                                                                                            });
                                                                                                        }
                                                                                                    }
                                                                                                    echo '<a href="javascript:;" onClick="btnEdit_summernote(this, '.$data_ID.', '.$label_arr[$i].')"><i class="fa fa-pencil"></i> [edit]</a>';
    
                                                                                                    if (!empty($rowColumnData)) { echo '<div class="textarea_value">'.$rowColumnData.'</div>'; }
    
                                                                                                    echo '<textarea class="hide" id="summernote_'.$data_ID.'_'.$label_arr[$i].'" name="columnData_'.$data_ID.'_'.$label_arr[$i].'">'.$rowColumnData.'</textarea>';
                                                                                                }
                                                                                            } 
                                                                                        }
                                                                                    echo '</td>';
                                                                                }
                                                                            } else if ($value == 2) {
                                                                                $radio_arr = explode(",", $label_name_arr[$i]);
    
                                                                                if (in_array($label_arr[$i], $include_arr)) {
                                                                                    $rowColumnData = '';
                                                                                    foreach ($radio_arr as $r) {
                                                                                        if (("n/a" === strtolower($r)) OR ("na" === strtolower($r))) {
                                                                                            echo '<td><input type="radio" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" onclick="changeRadio(this.value, '.$data_ID.', '.$label_arr[$i].', '.$ID.')" checked/></td>';
                                                                                            $rowColumnData = $r;
                                                                                        } else {
                                                                                            echo '<td><input type="radio" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" onclick="changeRadio(this.value, '.$data_ID.', '.$label_arr[$i].', '.$ID.')" /></td>';
                                                                                        }
                                                                                    }
                                                                                    echo '<td class="hide"><input type="hidden" class="radio_'.$data_ID.'_'.$label_arr[$i].'" name="columnData_'.$label_arr[$i].'[]" value="'.$rowColumnData.'" /></td>';
                                                                                } else {
                                                                                    echo '<td colspan="'.count($radio_arr).'"></td>
                                                                                    <td class="hide"></td>';
                                                                                }
                                                                            }
                                                                            $i++;
                                                                        }
                                                                    }
                                                                echo '</tr>';
            												}
            											}
            							        	}
            							        }
    
            								echo '</table>
                                        </div>
        								<div class="modal-footer modal-footer--sticky bg-white text-right">
        			                        <button type="submit" class="btn btn-danger ladda-button" name="btnGenerate2" id="btnGenerate2" data-style="zoom-out"><span class="ladda-label">Save as Draft</span></button>
        			                        <button type="submit" class="btn btn-info ladda-button" name="btnGenerate" id="btnGenerate" data-style="zoom-out"><span class="ladda-label">Submit for Preliminary</span></button>
        								</div>
        							</form>
                                </div>';
                            } else {
                                echo 'Please try again!';
                            }
						} else {
							echo 'Please try again!';
						}
					} else if ($_GET['t'] == 2) {
                        $selectData = mysqli_query( $conn,"SELECT 
                            f.*,
                            i.title AS i_title,
                            i.sheet_id AS i_sheet_id,
                            i.timestamp_id AS s_timestamp_id
                            FROM tbl_ia_form AS f

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_ia
                                WHERE deleted = 0
                            ) AS i
                            ON i.ID = f.ia_id

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_ia_sheet
                                WHERE deleted = 0
                                AND LENGTH(timestamp_id) > 0
                            ) AS s
                            ON FIND_IN_SET(s.ID, REPLACE(REPLACE(i.sheet_id, ' ', ''), '|',','  )  ) > 0

                            WHERE f.deleted = 0 
                            AND f.ID = $ID

                            GROUP BY f.ID" );
	                    if ( mysqli_num_rows($selectData) > 0 ) {
	                        $rowForm = mysqli_fetch_array($selectData);
	                        $form_organization = $rowForm['organization'];
	                        $form_audit_type = $rowForm['audit_type'];
	                        $form_inspected_by = $rowForm['inspected_by'];
	                        $form_auditee = $rowForm['auditee'];
	                        $form_verified_by = $rowForm['verified_by'];
	                        $form_date_start = $rowForm['date_start'];
	                        $form_date_end = $rowForm['date_end'];
	                        $form_audit_scope = $rowForm['audit_scope'];
	                        $form_file = $rowForm['file'];
	                        $form_data = $rowForm['data'];
	                        $form_label = $rowForm['label'];
	                        $form_description = $rowForm['description'];

	                        $form_score_type = $rowForm['score_type'];
	                        $form_score_data = array();
	                        if (!empty($rowForm['score_data'])) {
	                            $form_score_data = json_decode($rowForm['score_data'],true);
	                        }

                            $form_ia_title = $rowForm['i_title'];
                            $ia_sheet_id = $rowForm['i_sheet_id'];
                            $s_timestamp_id = $rowForm['s_timestamp_id'];

                            $type_arr = array();
                            $label_arr = array();
                            $label_name_arr = array();

                            $sub_header = '';
                            if (!empty($s_timestamp_id)) {
                                $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $s_timestamp_id ORDER BY order_id" );
                                if ( mysqli_num_rows($selectFormat) > 0 ) {
                                    while($rowFormat = mysqli_fetch_array($selectFormat)) {
                                        if ($rowFormat['type'] > 0) {
                                            if ($rowFormat['type'] == 1 OR $rowFormat['type'] == 3 OR $rowFormat['type'] == 4) {
                                                $sub_header .= '<td class="bold">'.$rowFormat['label'].'</td>';
                                            } else if ($rowFormat['type'] == 2) {
                                                $radio_arr = explode(",", $rowFormat['label']);
                                                foreach ($radio_arr as $r) {
                                                    $sub_header .= '<td class="bold">'.$r.'</td>';
                                                }
                                                $sub_header .= '<td class="bold hide">Result</td>';
                                            }
                                            
                                            array_push($type_arr, $rowFormat['type']);
                                            array_push($label_arr, $rowFormat['ID']);
                                            array_push($label_name_arr, $rowFormat['label']);
                                        }
                                    }
                                }
                                $type = implode(' | ', $type_arr);
                                $label = implode(' | ', $label_arr);
                                $label_name = implode(' | ', $label_name_arr);
    
                                echo '<div id="modalEditForm">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEditForm">
                                        <div class="modal-body">
        	                                <input class="form-control" type="hidden" name="ID" value = "'. $ID .'" />
                                            <input class="form-control" type="hidden" name="timestamp_id" value = "'. $s_timestamp_id .'" />
        	                                <h4 class="bold">'.stripcslashes($form_ia_title).'</h5>
        	                                <div class="row">
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label>Organization</label>
        	                                            <input type="text" class="form-control" name="organization" value="'.$form_organization.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label>Audit Type</label>
        	                                            <input type="text" class="form-control" name="audit_type" value="'.$form_audit_type.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label>Inspected By</label>
        	                                            <input type="text" class="form-control" name="inspected_by" value="'.$form_inspected_by.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label>Auditee</label>
        	                                            <input type="text" class="form-control" name="auditee" value="'.$form_auditee.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label>Verified By</label>
        	                                            <input type="text" class="form-control" name="verified_by" value="'.$form_verified_by.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Date</label>
        	                                            <div class="input-group">
        	                                                <input type="text" class="form-control daterange" name="daterange" value="'.$form_date_start.' - '.$form_date_end.'" />
        	                                                <span class="input-group-btn">
        	                                                    <button class="btn default date-range-toggle" type="button">
        	                                                        <i class="fa fa-calendar"></i>
        	                                                    </button>
        	                                                </span>
        	                                            </div>
        	                                        </div>
        	                                    </div>
    
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Operation</label>
        	                                            <textarea class="form-control" name="operation">'.$rowForm['operation'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Shipper</label>
        	                                            <textarea class="form-control" name="shipper">'.$rowForm['shipper'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Operation Type</label>
        	                                            <textarea class="form-control" name="operation_type">'.$rowForm['operation_type'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Audit Executive Summary</label>
        	                                            <textarea class="form-control" name="audit_ex">'.$rowForm['audit_ex'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Addendum(s) included in the audit</label>
        	                                            <textarea class="form-control" name="addendum">'.$rowForm['addendum'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Product(s) observed during audit</label>
        	                                            <textarea class="form-control" name="product_observed">'.$rowForm['product_observed'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Similar product(s)/process(es) not observed</label>
        	                                            <textarea class="form-control" name="similar_product">'.$rowForm['similar_product'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Product(s) applied for but not observed</label>
        	                                            <textarea class="form-control" name="product_applied">'.$rowForm['product_applied'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Auditor</label>
        	                                            <textarea class="form-control" name="auditor">'.$rowForm['auditor'].'</textarea>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Preliminary Audit Score</label>
        	                                            <input type="text" class="form-control" name="preliminary_audit" value="'.$rowForm['preliminary_audit'].'" readonly />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Final Audit Score</label>
        	                                            <input type="text" class="form-control" name="final_audit" value="'.$rowForm['final_audit'].'" readonly />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Certificate Valid From</label>
        	                                            <div class="input-group">
        	                                                <input type="text" class="form-control daterange" name="cert_valid" value="'.$rowForm['cert_valid'].'" />
        	                                                <span class="input-group-btn">
        	                                                    <button class="btn default date-range-toggle" type="button">
        	                                                        <i class="fa fa-calendar"></i>
        	                                                    </button>
        	                                                </span>
        	                                            </div>
        	                                        </div>
        	                                    </div>
    
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Date Documentation Review Started</label>
        	                                            <input type="datetime-local" class="form-control" name="date_review_started" value="'.$rowForm['date_review_started'].'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Date Documentation Review Finished</label>
        	                                            <input type="datetime-local" class="form-control" name="date_review_finished" value="'.$rowForm['date_review_finished'].'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Total Amount of Time on the Documentation Review</label>
        	                                            <input type="text" class="form-control" name="total_time_review" value="'.$rowForm['total_time_review'].'" />
        	                                        </div>
        	                                    </div>
    
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Date Visual Inspection Started</label>
        	                                            <input type="datetime-local" class="form-control" name="date_inspection_started" value="'.$rowForm['date_inspection_started'].'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Date Visual Inspection Finished</label>
        	                                            <input type="datetime-local" class="form-control" name="date_inspection_finished" value="'.$rowForm['date_inspection_finished'].'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Total Amount of Time on Visual Inspection</label>
        	                                            <input type="text" class="form-control" name="total_time_inspection" value="'.$rowForm['total_time_inspection'].'" />
        	                                        </div>
        	                                    </div>
    
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Company Logo <i>(Leave blank if not applicable)</i></label>';
    
        	                                            if (!empty($form_file)) {
        	                                                echo '<input class="form-control '; echo !empty($form_file) ? 'hide':''; echo '" type="file" name="file" accept="image/*" />
        	                                                
        	                                                <p class="'; echo !empty($form_file) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$form_file.'" data-src="'.$form_file.'" data-fancybox class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>';
        	                                            } else {
        	                                                echo '<input type="file" class="form-control" name="file" accept="image/*" />';
        	                                            }
    
        	                                            echo '<input type="hidden" name="file_temp" value="'.$form_file.'" />
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-4">
        	                                        <div class="form-group">
        	                                            <label class="control-label">Set Scoring</label>
        	                                            <select class="form-control" name="score_type" onchange="changeType(this, this.value)">
        	                                                <option value="0" '; echo $form_score_type == 0 ? 'SELECTED':''; echo '>Default</option>
        	                                                <option value="1" '; echo $form_score_type == 1 ? 'SELECTED':''; echo '>Custom</option>
        	                                            </select>
        	                                        </div>
        	                                    </div>
        	                                    <div class="col-md-12 score_data '; echo $form_score_type == 1 ? '':'hide'; echo '">
        	                                        <p>Custom Score Field(s) <a href="javascript:;" class="btn btn-success" onclick="btnRepeaterScoreAdd()"><i class="fa fa-plus"></i></a></p>
        	                                        <div class="scoreCustom">';
        	                                            if (count($form_score_data) >  0) {
        	                                                $array_data = array();
        	                                                foreach ($form_score_data as $key => $value) {
        	                                                    $output = array(
        	                                                        'score_label' => $value['score_label'],
        	                                                        'score_rate' => $value['score_rate'],
        	                                                        'score_color' => $value['score_color'],
        	                                                    );
        	                                                    array_push($array_data, $output);
    
        	                                                    echo '<div class="row">
        	                                                        <div class="col-md-4">
        	                                                            <div class="form-group">
        	                                                                <input type="text" class="form-control" name="score_label[]" placeholder="Label" value="'.$value['score_label'].'" required />
        	                                                            </div>
        	                                                        </div>
        	                                                        <div class="col-md-4">
        	                                                            <div class="form-group">
        	                                                                <div class="input-group">
        	                                                                    <input type="text" class="form-control" name="score_rate[]" placeholder="Score Rate" value="'.$value['score_rate'].'" required />
        	                                                                    <span class="input-group-addon" style="padding: 0;">
        	                                                                        <input type="color" name="score_color[]" style="border: 0;" value="'.$value['score_color'].'" required />
        	                                                                    </span>
        	                                                                </div>
        	                                                            </div>
        	                                                        </div>
        	                                                        <div class="col-md-4 text-right">
        	                                                            <div class="form-group">
        	                                                                <a href="javascript:;" class="btn btn-danger" onclick="btnRepeaterScoreRemove(this)"><i class="fa fa-close"></i></a>
        	                                                            </div>
        	                                                        </div>
        	                                                    </div>';
        	                                                }
    
    
        	                                                echo '<textarea class="form-control hide" id="range_'.$ID.'">';
        	                                                    $ranges = [];
    
        	                                                    // sort data result
        	                                                    usort($array_data, function($a, $b) {
        	                                                        return $a['score_rate'] - $b['score_rate'];
        	                                                    });
    
        	                                                    // convert into json
        	                                                    for ($i=0; $i < count($array_data); $i++) { 
        	                                                        $lo = $i == 0 ? 0 : $array_data[$i - 1]['score_rate'] + 1;
        	                                                        $hi = $array_data[$i]['score_rate'];
        	                                                        $color = $array_data[$i]['score_color'];
        	                                                        $score_label = $array_data[$i]['score_label'];
    
        	                                                        $ranges[] = [
        	                                                            'label' => $score_label,
        	                                                            'color' => $color,
        	                                                            'lo' => $lo,
        	                                                            'hi' => $hi
        	                                                        ];
        	                                                    }
    
        	                                                    // echo (json_encode($array_data));
        	                                                    echo (json_encode($ranges));
        	                                                echo '</textarea><textarea class="form-control hide" id="label_'.$ID.'">';
        	                                                    foreach ($ranges as $item) {
        	                                                        echo 'if (val >= '.$item['lo'].' && val <= '.$item['hi'].') {
        	                                                            return "'.$item['label'].'";
        	                                                        }';
        	                                                    }
        	                                                echo '</textarea>';
        	                                            }
        	                                        echo '</div>
        	                                    </div>
    
        	                                    <div class="col-md-12">
        	                                        <div class="form-group">
        	                                            <label>Audit Scope</label>
        	                                            <textarea class="form-control summernote summernote_audit_scope" name="audit_scope">'.$form_audit_scope .'</textarea>
        	                                        </div>
        	                                    </div>
        	                                </div>
    
        	                                <p>Custom Field(s) <a href="javascript:;" class="btn btn-success" onclick="btnRepeaterFormAdd()"><i class="fa fa-plus"></i></a></p>
        	                                <div class="formCustom">';
    
        	                                    if (!empty($form_label)) {
        	                                        $form_label_arr = explode(' | ', $form_label);
        	                                        $form_description_arr = explode(' | ', $form_description);
        	                                        foreach($form_label_arr as $key => $value) {
        	                                            echo '<div class="row">
        	                                                <div class="col-md-4">
        	                                                    <div class="form-group">
        	                                                        <input type="text" class="form-control" name="label[]" placeholder="Label" value="'.$value.'" required="" />
        	                                                    </div>
        	                                                </div>
        	                                                <div class="col-md-6">
        	                                                    <div class="form-group">
        	                                                        <input type="text" class="form-control" name="description[]" placeholder="Description" value="'.$form_description_arr[$key].'" required="" />
        	                                                    </div>
        	                                                </div>
        	                                                <div class="col-md-2 text-right">
        	                                                    <div class="form-group">
        	                                                        <a href="javascript:;" class="btn btn-danger" onclick="btnRepeaterFormRemove(this)"><i class="fa fa-close"></i></a>
        	                                                    </div>
        	                                                </div>
        	                                            </div>';
        	                                        }
        	                                    }
    
        	                                echo '</div>
    
        	                                <div class="box">
        	                                    <div id="gauge_'.$ID.'" class="gauge"></div>
        	                                </div>
    
        	                                <table class="table margin-top-20" id="tableForm_'.$ID.'">';
    
        	                                    if (!empty($ia_sheet_id)) {
        	                                        $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
        	                                        foreach($ia_sheet_id_arr as $sheet_id) {
    
        	                                            $selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
        	                                            if ( mysqli_num_rows($selectSheet) > 0 ) {
        	                                                $rowSheet = mysqli_fetch_array($selectSheet);
        	                                                $sheet_name = $rowSheet['name'];
        	                                            }
    
        	                                            echo '<tr class="bg-warning">
        	                                                <td colspan="100%" class="text-center bold">'.$sheet_name.'</td>
        	                                            </tr>
        	                                            <tr class="bg-default">'.$sub_header.'</tr>';
    
                                                        $selectDataRow = mysqli_query( $conn,"WITH RECURSIVE cte (rowID, rowOrder, rowParent, rowInclude, rowData) AS
                                                            (
                                                                SELECT
                                                                t1.ID AS rowID,
                                                                t1.order_id AS rowOrder,
                                                                t1.parent_id AS rowParent,
                                                                t1.include AS rowInclude,
                                                                t1.data AS rowData
                                                                FROM tbl_ia_data AS t1
                                                                WHERE t1.parent_id = 0 
                                                                AND t1.deleted = 0 
                                                                AND LENGTH(t1.data) > 0 
                                                                AND t1.sheet_id = $sheet_id
    
                                                                UNION ALL
    
                                                                SELECT
                                                                t2.ID AS rowID,
                                                                t2.order_id AS rowOrder,
                                                                t2.parent_id AS rowParent,
                                                                t2.include AS rowInclude,
                                                                t2.data AS rowData
                                                                FROM tbl_ia_data AS t2
                                                                JOIN cte ON cte.rowID = t2.parent_id
                                                                WHERE t2.deleted = 0 
                                                                AND LENGTH(t2.data) > 0 
                                                                AND t2.sheet_id = $sheet_id
                                                            )
                                                            SELECT 
                                                            rowID, rowOrder, rowParent, rowInclude, rowData
                                                            FROM cte
                                                            ORDER BY rowOrder ASC, rowID ASC" );
                                                        if ( mysqli_num_rows($selectDataRow) > 0 ) {
        	                                                while($rowData = mysqli_fetch_array($selectDataRow)) {
                                                                $data_ID = $rowData['rowID'];
    
                                                                $include_arr = array();
                                                                if ($rowData['rowInclude'] != NULL) { $include_arr = explode(" | ", $rowData['rowInclude']); }
    
                                                                $data_arr = json_decode($rowData['rowData'],true);
    
                                                                echo '<tr id="tr_'.$data_ID.'">';
                                                                    $type_arr = explode(" | ", $type);
                                                                    $label_arr = explode(" | ", $label);
                                                                    $label_name_arr = explode(" | ", $label_name);
                                                                    
                                                                    $i = 0;
                                                                    foreach ($type_arr as $value) {
                                                                        if ($value > 0) {
                                                                            if ($value == 1 OR $value == 3 OR $value == 4) {
                                                                                if (in_array($label_arr[$i], $include_arr)) {
                                                                                    echo '<td>';
    
                                                                                        foreach($data_arr as $key => $val) {
                                                                                            if ($label_arr[$i] == $val['ID']) {
                                                                                                if (!empty($val['content'])) {
                                                                                                    echo $val['content'];
                                                                                                } else {
                                                                                                    $formatID = $label_arr[$i];
                                                                                                    $rowColumnData = '';
                                                                                                    if (!empty($form_data)) {
                                                                                                        $form_data_arr = json_decode($form_data,true);
    
                                                                                                        if (in_array($data_ID, array_column($form_data_arr, 'row'))) {
                                                                                                            $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($data_ID, $formatID) {
                                                                                                                if ($item['row'] === $data_ID && $item['content']['column'] === $formatID) {
                                                                                                                    return $item['content']['data'];
                                                                                                                }
                                                                                                                return $carry;
                                                                                                            });
                                                                                                        }
                                                                                                    }
                                                                                                    echo '<a href="javascript:;" onClick="btnEdit_summernote(this, '.$data_ID.', '.$label_arr[$i].')"><i class="fa fa-pencil"></i> [edit]</a>';
    
                                                                                                    if (!empty($rowColumnData)) { echo '<div class="textarea_value">'.$rowColumnData.'</div>'; }
    
                                                                                                    echo '<textarea class="hide" id="summernote_'.$data_ID.'_'.$label_arr[$i].'" name="columnData_'.$data_ID.'_'.$label_arr[$i].'">'.$rowColumnData.'</textarea>';
                                                                                                }
                                                                                            } 
                                                                                        }
                                                                                    echo '</td>';
                                                                                }
                                                                            } else if ($value == 2) {
                                                                                $radio_arr = explode(",", $label_name_arr[$i]);
    
                                                                                if (in_array($label_arr[$i], $include_arr)) {
                                                                                    $formatID = $label_arr[$i];
                                                                                    $rowColumnData = '';
                                                                                    if (!empty($form_data)) {
                                                                                        $form_data_arr = json_decode($form_data,true);
    
                                                                                        if (in_array($data_ID, array_column($form_data_arr, 'row'))) {
                                                                                            $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($data_ID, $formatID) {
                                                                                                if ($item['row'] === $data_ID && $item['content']['column'] === $formatID) {
                                                                                                    return $item['content']['data'];
                                                                                                }
                                                                                                return $carry;
                                                                                            });
                                                                                        }
                                                                                    }
    
                                                                                    if (!empty($rowColumnData)) {
                                                                                        foreach ($radio_arr as $r) {
                                                                                            if ($rowColumnData === $r) {
                                                                                                echo '<td><input type="radio" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" onclick="changeRadio(this.value, '.$data_ID.', '.$label_arr[$i].', '.$ID.')" checked /></td>';
                                                                                            } else {
                                                                                                echo '<td><input type="radio" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" onclick="changeRadio(this.value, '.$data_ID.', '.$label_arr[$i].', '.$ID.')" /></td>';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                         echo '<td colspan="'.count($radio_arr).'"></td>';
                                                                                    }
                                                                                    echo '<td class="hide"><input type="hidden" class="radio_'.$data_ID.'_'.$label_arr[$i].'" name="columnData_'.$label_arr[$i].'[]" value="'.$rowColumnData.'" /></td>';
                                                                                } else {
                                                                                    echo '<td colspan="'.count($radio_arr).'"></td>
                                                                                    <td class="hide"></td>';
                                                                                }
                                                                            }
                                                                            $i++;
                                                                        }
                                                                    }
                                                                echo '</tr>';
        	                                                }
        	                                            }
        	                                        }
        	                                    }
    
        	                                echo '</table>
                                        </div>
    	                                <div class="modal-footer modal-footer--sticky bg-white text-right">
    	                                    <button type="submit" class="btn btn-danger ladda-button" name="btnEdit_Form2" id="btnEdit_Form2" data-style="zoom-out"><span class="ladda-label">Save as Draft</span></button>
    	                                    <button type="submit" class="btn btn-info ladda-button" name="btnEdit_Form3" id="btnEdit_Form3" data-style="zoom-out"><span class="ladda-label">Submit for Preliminary</span></button>
    	                                    <button type="submit" class="btn green ladda-button" name="btnEdit_Form" id="btnEdit_Form" data-style="zoom-out"><span class="ladda-label">Submit for Final</span></button>
    	                                </div>
    	                            </form>
                                </div>';
                            } else {
                                echo 'Please try again!';
                            }
	                    } else {
							echo 'Please try again!';
						}
					} else if ($_GET['t'] == 3) {
                        $modal = 2;

                        $selectData = mysqli_query( $conn,"SELECT
                            s.timestamp_id AS s_timestamp_id,
                            i.timestamp_id AS i_timestamp_id,
                            i.title AS i_title,
                            i.description AS i_description,
                            i.last_modified AS i_last_modified,
                            i.sheet_id AS i_sheet_id
                            FROM tbl_ia AS i

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_ia_sheet
                                WHERE deleted = 0
                                AND LENGTH(timestamp_id) > 0
                            ) AS s
                            ON FIND_IN_SET(s.ID, REPLACE(REPLACE(i.sheet_id, ' ', ''), '|',','  )  ) > 0

                            WHERE i.deleted = 0 
                            AND i.ID = $ID

                            GROUP BY i.ID" );
                        if ( mysqli_num_rows($selectData) > 0 ) {
                            $rowIA = mysqli_fetch_array($selectData);
                            $ia_title = $rowIA['i_title'];
                            $ia_description = $rowIA['i_description'];
                            $ia_last_modified = $rowIA['i_last_modified'];
                            $ia_sheet_id = $rowIA['i_sheet_id'];
                            $i_timestamp_id = $rowIA['i_timestamp_id'];
                            $s_timestamp_id = $rowIA['s_timestamp_id'];

                            if (!empty($i_timestamp_id)) {
                                echo '<div id="modalEdit">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEdit margin-top-15">
                                        <div class="modal-body">
                                            <input type="hidden" name="ID" value="'.$ID.'" />
                                            <input type="hidden" name="modal" value="'.$modal.'" />
                                            <input type="hidden" name="i_timestamp_id" value="'.$i_timestamp_id.'" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Audit Title</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="title" value="'.stripcslashes($ia_title).'" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="description" required>'.stripcslashes($ia_description).'</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date</label>
                                                <div class="col-md-8">
                                                    <input type="date" class="form-control" name="date" value="'.$ia_last_modified.'" required />
                                                </div>
                                            </div>
                                            <div class="tabbable tabbable-tabdrop">
                                                <ul class="nav nav-tabs">
                                                    <li class="">
                                                        <a href="#modalNewSheet" data-toggle="modal" onclick="btnNewSheet('.$modal.', \''.$i_timestamp_id.'\')"><i class="fa fa-plus"></i></a>
                                                    </li>';
    
                                                    if (!empty($ia_sheet_id)) {
                                                        $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
                                                        foreach($ia_sheet_id_arr as $sheet_id) {
                                                            $selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
                                                            if ( mysqli_num_rows($selectSheet) > 0 ) {
                                                                $rowSheet = mysqli_fetch_array($selectSheet);
                                                                $sheet_name = $rowSheet['name'];
    
                                                                echo '<li class="" id="li_'.$sheet_id.'">
                                                                    <input type="hidden" name="sheetID[]" value="'.$sheet_id.'">
                                                                    <a href="#tabSheet_'.$sheet_id.'" data-toggle="tab" aria-expanded="true" onClick="btnTabSheet('.$sheet_id.', '.$s_timestamp_id.')">'.$sheet_name.' <i class="fa fa-pencil text-danger" data-toggle="modal" href="#modalViewSheet" onclick="btnViewSheet('.$sheet_id.', '.$modal.', '.$s_timestamp_id.')"></i></a>
                                                                </li>';
                                                            }
                                                        }
                                                    }
    
                                                echo '</ul>
                                                <div class="tab-content margin-top-20">';
    
                                                    if (!empty($ia_sheet_id)) {
                                                        $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
                                                        foreach($ia_sheet_id_arr as $sheet_id) {
    
                                                            echo '<div class="tab-pane" id="tabSheet_'.$sheet_id.'"></div>';
                                                        }
                                                    }
    
                                                echo '</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer modal-footer--sticky bg-white text-right">
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_IA" id="btnUpdate_IA" data-style="zoom-out"><span class="ladda-label">Update</span></button>
                                        </div>
                                    </form>
                                </div>';
                            } else {
                                echo 'Please try again!';
                            }
                        } else {
                            echo 'Please try again!';
                        }
                    } else if ($_GET['t'] == 4) {
                        $selectData = mysqli_query( $conn,"SELECT
                            i.timestamp_id AS s_timestamp_id,
                            i.title AS i_title,
                            i.description AS i_description,
                            i.last_modified AS i_last_modified,
                            i.sheet_id AS i_sheet_id
                            FROM tbl_ia AS i

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_ia_sheet
                                WHERE deleted = 0
                                AND LENGTH(timestamp_id) > 0
                            ) AS s
                            ON FIND_IN_SET(s.ID, REPLACE(REPLACE(i.sheet_id, ' ', ''), '|',','  )  ) > 0

                            WHERE i.deleted = 0 
                            AND i.ID = $ID

                            GROUP BY i.ID" );
                        if ( mysqli_num_rows($selectData) > 0 ) {
                            $rowIA = mysqli_fetch_array($selectData);
                            $ia_title = $rowIA['i_title'];
                            $ia_description = $rowIA['i_description'];
                            $ia_sheet_id = $rowIA['i_sheet_id'];
                            $s_timestamp_id = $rowIA['s_timestamp_id'];

                            $ia_last_modified = $rowIA['i_last_modified'];
                            $ia_last_modified = new DateTime($ia_last_modified);
                            $ia_last_modified = $ia_last_modified->format('M d, Y');

                            $type_arr = array();
                            $label_arr = array();
                            $label_name_arr = array();

                            $sub_header = '';
                            if (!empty($s_timestamp_id)) {
                                $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $s_timestamp_id ORDER BY order_id" );
                                if ( mysqli_num_rows($selectFormat) > 0 ) {
                                    while($rowFormat = mysqli_fetch_array($selectFormat)) {
                                        if ($rowFormat['type'] > 0) {
                                            if ($rowFormat['type'] == 1 OR $rowFormat['type'] == 3 OR $rowFormat['type'] == 4) {
                                                $sub_header .= '<td class="bold">'.$rowFormat['label'].'</td>';
                                            } else if ($rowFormat['type'] == 2) {
                                                $radio_arr = explode(",", $rowFormat['label']);
                                                foreach ($radio_arr as $r) {
                                                    $sub_header .= '<td class="bold">'.$r.'</td>';
                                                }
                                            }
                                            
                                            array_push($type_arr, $rowFormat['type']);
                                            array_push($label_arr, $rowFormat['ID']);
                                            array_push($label_name_arr, $rowFormat['label']);
                                        }
                                    }
                                }
                            }
                            $type = implode(' | ', $type_arr);
                            $label = implode(' | ', $label_arr);
                            $label_name = implode(' | ', $label_name_arr);

                            echo '
                            <span class="pull-right">'.$ia_last_modified.'</span>
                            <h4 class="bold">'.stripcslashes($ia_title).'</h5>
                            <h6>'.stripcslashes($ia_description).'</h6>
                            <table class="table margin-top-20">';

                                if (!empty($ia_sheet_id)) {
                                    $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
                                    foreach($ia_sheet_id_arr as $sheet_id) {

                                        $selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
                                        if ( mysqli_num_rows($selectSheet) > 0 ) {
                                            $rowSheet = mysqli_fetch_array($selectSheet);
                                            $sheet_name = $rowSheet['name'];
                                        }

                                        echo '<tr class="bg-warning">
                                            <td colspan="100%" class="text-center bold">'.$sheet_name.'</td>
                                        </tr>
                                        <tr class="bg-default">'.$sub_header.'</tr>';

                                        $selectDataRow = mysqli_query( $conn,"WITH RECURSIVE cte (rowID, rowOrder, rowParent, rowInclude, rowData) AS
                                            (
                                                SELECT
                                                t1.ID AS rowID,
                                                t1.order_id AS rowOrder,
                                                t1.parent_id AS rowParent,
                                                t1.include AS rowInclude,
                                                t1.data AS rowData
                                                FROM tbl_ia_data AS t1
                                                WHERE t1.parent_id = 0 
                                                AND t1.deleted = 0 
                                                AND LENGTH(t1.data) > 0 
                                                AND t1.sheet_id = $sheet_id

                                                UNION ALL

                                                SELECT
                                                t2.ID AS rowID,
                                                t2.order_id AS rowOrder,
                                                t2.parent_id AS rowParent,
                                                t2.include AS rowInclude,
                                                t2.data AS rowData
                                                FROM tbl_ia_data AS t2
                                                JOIN cte ON cte.rowID = t2.parent_id
                                                WHERE t2.deleted = 0 
                                                AND LENGTH(t2.data) > 0 
                                                AND t2.sheet_id = $sheet_id
                                            )
                                            SELECT 
                                            rowID, rowOrder, rowParent, rowInclude, rowData
                                            FROM cte
                                            ORDER BY rowOrder ASC, rowID ASC" );
                                        if ( mysqli_num_rows($selectDataRow) > 0 ) {
                                            while($rowData = mysqli_fetch_array($selectDataRow)) {
                                                $data_ID = $rowData['rowID'];

                                                $include_arr = array();
                                                if ($rowData['rowInclude'] != NULL) { $include_arr = explode(" | ", $rowData['rowInclude']); }

                                                $data_arr = json_decode($rowData['rowData'],true);

                                                echo '<tr id="tr_'.$data_ID.'">';
                                                    $type_arr = explode(" | ", $type);
                                                    $label_arr = explode(" | ", $label);
                                                    
                                                    $i = 0;
                                                    foreach ($type_arr as $value) {
                                                        if ($value > 0) {
                                                            if ($value == 1 OR $value == 3 OR $value == 4) {
                                                                if (in_array($label_arr[$i], array_column($data_arr, 'ID'))) {;
                                                                    $targetId = $label_arr[$i];
                                                                    
                                                                    // Create an associative array with "ID" as keys and "content" as values
                                                                    $idToContentMap = array_column($data_arr, 'content', 'ID');
                                                                    
                                                                    if (isset($idToContentMap[$targetId])) {
                                                                        $content = $idToContentMap[$targetId];
                                                                        echo '<td>'.$content.'</td>';
                                                                    } else {
                                                                        echo '<td></td>';
                                                                    }
                                                                } else {
                                                                    echo '<td></td>';
                                                                }
                                                            } else if ($value == 2) {
                                                                $radio_arr = explode(",", $label_name);

                                                                if (in_array($label_arr[$i], $include_arr)) {
                                                                    foreach ($radio_arr as $r) {
                                                                        echo '<td><input type="radio" class="m-0 radio_'.$data_ID.'_'.$label_arr[$i].'" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" /></td>';
                                                                    }
                                                                } else {
                                                                    echo '<td colspan="'.count($radio_arr).'"></td>';
                                                                }
                                                                
                                                                
                                                                // if (in_array($label_arr[$i], array_column($data_arr, 'ID'))) {;
                                                                //     foreach ($radio_arr as $r) {
                                                                //         echo '<td><input type="radio" class="m-0 radio_'.$data_ID.'_'.$label_arr[$i].'" value="'.$r.'" name="radio_'.$data_ID.'_'.$label_arr[$i].'" /></td>';
                                                                //     }
                                                                // } else {
                                                                //     echo '<td colspan="'.count($radio_arr).'"></td>';
                                                                // }
                                                                
                                                                // echo '<td colspan="'.count($radio_arr).'">'.$value.' -- '.$i.' -- '.$label_arr[$i].'</td>';
                                                            }
                                                            $i++;
                                                        }
                                                    }
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                }

                            echo '</table>';
                        } else {
                            echo 'Please try again!';
                        }
                    } else {
						echo 'Please try again!';
					}
				} else {
					echo 'Please try again!';
				}
			?>
		</div>

        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNewSheet" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" class="form-horizontal modalForm modalNewSheet">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Sheet Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer modal-footer--sticky bg-white">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="submit" class="btn green ladda-button" name="btnSave_Sheet" id="btnSave_Sheet" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalViewSheet" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" class="form-horizontal modalForm modalViewSheet">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Sheet Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer modal-footer--sticky bg-white">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Delete" onclick="btnDeleteSheet(this)" />
                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Sheet" id="btnUpdate_Sheet" data-style="zoom-out"><span class="ladda-label">Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNewRow" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNewRow">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Row Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer modal-footer--sticky bg-white">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="submit" class="btn green ladda-button" name="btnSave_Row" id="btnSave_Row" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditRow" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEditRow">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Row Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer modal-footer--sticky bg-white">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Row" id="btnUpdate_Row" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalImport">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Import Data</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer modal-footer--sticky bg-white">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="submit" class="btn green ladda-button" name="btnSave_Import" id="btnSave_Import" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

		<!-- BEGIN CORE PLUGINS -->
		<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
		
		<script src="assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
		<script src="assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
		<script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
		<script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->

        <script type="text/javascript" src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script type="text/javascript" src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script type="text/javascript" src="exes/tableExport.js"></script>
        <script type="text/javascript" src="raphael.min.js"></script>
        <script type="text/javascript" src="justgage.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
            	var id = <?php echo $ID; ?>;
                var template = <?php echo $_GET['t']; ?>;
				$(".modalForm").validate();
                $('.summernote_audit_scope').summernote({
                    height: 100
                });

                widget_date();
                widget_gauge(id);

                if (template == 3) {
                    $("tr").on( "mousedown", function() {
                        tr_parent = $(this).parent().parent().parent().attr('id');
                        if (tr_parent != null) {
                            tr_parent_id = tr_parent.replace('tabSheet_', '');

                            $('#tabSheet_'+tr_parent_id+' tbody').sortable({
                                placeholder: 'sorting_highlight',
                                update: function(event, ui) {
                                    var page_id_array = new Array();

                                    $('#tabSheet_'+tr_parent_id+' table:not(#tableTemplate_'+tr_parent_id+') tbody tr').each(function () {
                                        tr_row = $(this).attr('id');
                                        page_id_array.push(tr_row.replace('tr_', ''));
                                    });

                                    $.ajax({
                                        url: "function.php?modalSort_Row="+tr_parent_id,
                                        method: "POST",
                                        data: {page_id_array:page_id_array},
                                        success: function(data) {
                                            // alert(data);
                                        }
                                    })
                                }
                            });
                        }
                    });
                } else {
                    $('.formCustom').sortable({
                        placeholder: 'sorting_highlight',
                        update: function(event, ui) {
                            var page_id_array = new Array();
                        }
                    });
                }
            });

            function load_country_data(sheet_id, limit, start) {
                $.ajax({
                    url:"function.php?ia_view="+sheet_id+"&l="+limit+"&s="+start,
                    method:"POST",
                    cache:false,
                    success:function(data) {
                        if (data) {
                            $(data).insertAfter('#'+sheet_id);
                            load_country_data(sheet_id, limit, start+limit);
                        }
                    }
                });
            }

			function bootstrapGrowl(msg) {
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
			function fancyBoxes() {
				Fancybox.bind('[data-fancybox]', {
					Toolbar: {
						display: [
							{ id: "prev", position: "center" },
							{ id: "counter", position: "center" },
							{ id: "next", position: "center" },
							"zoom",
							"slideshow",
							"fullscreen",
							"download",
							"thumbs",
							"close",
						],
					},
				});
			}
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function selectType(e) {
                if (e.value == 1 || e.value == 3 || e.value == 4) {
                    $(e).parent().next().html('<input type="hidden" name="formatID[]" value="0" /><input type="text" class="form-control" name="label[]" placeholder="Label" required />');
                } else if (e.value == 2) {
                    $(e).parent().next().html('<input type="hidden" name="formatID[]" value="0" /><input type="text" class="form-control tagsinput" name="label[]" data-role="tagsinput" placeholder="Enter Options" required />');
                    widget_inputTag();
                } else {
                    $(e).parent().next().html('');
                }
            }
            function changeType(e, type) {
                if (type == 1) {
                    $(e).parent().parent().next('.score_data').removeClass('hide');
                } else {
                    $(e).parent().parent().next('.score_data').addClass('hide');
                }
            }
            function changeRadio(val, row, formatID, id) {
                $('.radio_'+row+'_'+formatID).val(val);
                widget_gauge(id);
            }
            function checkRadio() {
                var total_item = 0;
                var total_yes = 0;
                var total_na = 0;
                var total_sum = 0;
                var total_percentage = 0;
                $.map($("input:radio:checked"), function(elem, idx) {
                    if ($(elem).val().toLowerCase() == 'yes') {
                        total_yes++;
                    } else if ($(elem).val().toLowerCase() == 'na' || $(elem).val().toLowerCase() == 'n/a') {
                        total_na++;
                    }
                    total_item++;
                });

                if (total_item > total_na) {
                    total_sum = total_yes / (total_item - total_na)
                }
                total_percentage = total_sum * 100;

                return total_percentage;
            }
            function checkInclude(e, modal, type) {
                if (e.checked == true) {
                    $(e).parent().parent().parent().find('> input').show();
                    $(e).parent().parent().parent().find('> select').show();
                    $(e).parent().parent().parent().find('> div').not('.mt-checkbox-list').show();

                    widget_summernote(modal, type);
                } else {
                    $(e).parent().parent().parent().find('> input').hide();
                    $(e).parent().parent().parent().find('> select').hide();
                    $(e).parent().parent().parent().find('> div').not('.mt-checkbox-list').hide();
                }
            }
            function btnEdit_summernote(e, row, column) {
                $(e).next('.textarea_value').hide();
                widget_summernote(row, column);
            }
            function widget_summernote(modal, type) {
                $('#summernote_'+modal+'_'+type).summernote({
                    height: 100
                });
            }
            function widget_repeaterForm() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }
            function widget_inputTag() {
                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});
            }
            function widget_date() {
                $('.daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "opens": "left",
                    "drops": "auto"
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_gauge(id) {
                let newValue = '';
                var total_item = 0;
                var total_yes = 0;
                var total_na = 0;
                var total_sum = 0;
                var total_percentage = 0;
                $.map($("#tableForm_"+id+" input:radio:checked"), function(elem, idx) {
                    if ($(elem).val().toLowerCase() == 'yes') {
                        total_yes++;
                    } else if ($(elem).val().toLowerCase() == 'na' || $(elem).val().toLowerCase() == 'n/a') {
                        total_na++;
                    }
                    total_item++;
                });
                if (total_item > total_na) {
                    total_sum = total_yes / (total_item - total_na)
                }
                
                if (!$('#range_'+id).val()) {
                    newRange = [{ color : "#ff3b30", lo : 0, hi : 0 },{ color : "#43bf58", lo : 1, hi : 100 }];
                    newValue = 'if(val == 100) { return "Compliance"; } else { return "Non-Compliance"; }';
                    maxValue = $(newRange).last().prop('hi');
                    total_percentage = total_sum * maxValue;

                    if (total_percentage < maxValue) {
                        total_percentage = 0;
                    } else {
                        total_percentage = maxValue;
                    }
                } else {
                    newRange = JSON.parse($('#range_'+id).val());
                    newValue = $('#label_'+id).val();
                    maxValue = $(newRange).last().prop('hi');
                    total_percentage = total_sum * maxValue;
                }
                let newFunction = Function('val', newValue);

                console.log(maxValue);
                console.log(total_item);
                console.log(total_na);
                console.log(total_yes);
                console.log(total_sum);
                console.log(total_percentage);

                var newGauge = $('#gauge_'+id+' > svg');
                if (newGauge.length > 0) {
                    g1.refresh(total_percentage);
                } else {
                    g1 = new JustGage({
                        id: 'gauge_'+id,
                        value: total_percentage,
                        min: 0,
                        max: maxValue,
                        symbol: '%',
                        pointer: true,
                        gaugeWidthScale: 0.6,
                        customSectors: {
                            // percents: true, // lo and hi values are in %
                            ranges: newRange
                        },
                        // pointerOptions: {
                        //     toplength: null,
                        //     bottomlength: null,
                        //     bottomwidth: null,
                        //     stroke: 'none',
                        //     stroke_width: 0,
                        //     stroke_linecap: 'square',
                        //     color: '#000000'
                        // },

                        textRenderer: function (val) {
                            val = Math.round(val);
                            // console.log(newFunction(val));

                            return newFunction(val);

                            // if (val < 50) {
                            //     return 'Cold';
                            // } else if (val > 50) {
                            //     return 'Hot';
                            // } else if (val === 100) {
                            //     return 'OK';
                            // }
                        },
                        counter: true
                    });
                }
            }
            function widget_uiBlock(id) {
                $('#tabSheet_'+id).block({
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            function btnRepeaterAdd() {
                var data = '<div class="mt-repeater-item row" data-repeater-item>';
                    data += '<div class="col-md-3">';
                        data += '<select class="form-control" name="type[]" onchange="selectType(this)">';
                            data += '<option value="0" SELECTED>Select Type</option>';
                            data += '<option value="1">Text</option>';
                            data += '<option value="2">Radio Button</option>';
                            data += '<option value="3">Date</option>';
                            // data += '<option value="4">File Upload</option>';
                        data += '</select>';
                    data += '</div>';
                    data += '<div class="col-md-7"></div>';
                    data += '<div class="col-md-2 text-right">';
                        data += '<a href="javascript:;" data-repeater-delete class="btn btn-danger" onclick="btnRepeaterRemove(this)"><i class="fa fa-close"></i></a>';
                    data += '</div>';
                data += '</div>';

                $('.format').append(data);
            }
            function btnRepeaterRemove(e) {
                $(e).parents('.mt-repeater-item').remove();
            }
            function btnRepeaterFormAdd() {
                var data = '<div class="row">';
                    data += '<div class="col-md-4">';
                        data += '<div class="form-group">';
                            data += '<input type="text" class="form-control" name="label[]" placeholder="Label" required />';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-6">';
                        data += '<div class="form-group">';
                            data += '<input type="text" class="form-control" name="description[]" placeholder="Description" required />';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-2 text-right">';
                        data += '<div class="form-group">';
                            data += '<a href="javascript:;" class="btn btn-danger" onclick="btnRepeaterFormRemove(this)"><i class="fa fa-close"></i></a>';
                        data += '</div>';
                    data += '</div>';
                data += '</div>';

                $('.formCustom').append(data);
            }
            function btnRepeaterFormRemove(e) {
                $(e).parent().parent().parent().remove();
            }
            function btnRepeaterScoreAdd() {
                var data = '<div class="row">';
                    data += '<div class="col-md-4">';
                        data += '<div class="form-group">';
                            data += '<input type="text" class="form-control" name="score_label[]" placeholder="Label" required />';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-4">';
                        data += '<div class="form-group">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control" name="score_rate[]" placeholder="Score Rate" required />';
                                data += '<span class="input-group-addon" style="padding: 0;">';
                                    data += '<input type="color" name="score_color[]" value="#000000" style="border: 0;" required />';
                                data += '</span>';
                            data += '</div>';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-4 text-right">';
                        data += '<div class="form-group">';
                            data += '<a href="javascript:;" class="btn btn-danger" onclick="btnRepeaterScoreRemove(this)"><i class="fa fa-close"></i></a>';
                        data += '</div>';
                    data += '</div>';
                data += '</div>';

                $('.scoreCustom').append(data);
            }
            function btnRepeaterScoreRemove(e) {
                $(e).parent().parent().parent().remove();
            }
            function btnNewSheet(modal, timestamp_id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Sheet="+modal+"&t="+timestamp_id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewSheet .modal-body").html(data);

                        $('.modalNewSheet .format').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnViewSheet(id, modal, timestamp_id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Sheet="+id+"&modal="+modal+"&t="+timestamp_id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewSheet .modal-body").html(data);
                        widget_inputTag();

                        $('.modalViewSheet .format').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnTabSheet(id, timestamp_id) {
                var newTab = $('#tabSheet_'+id+' > table');
                if (newTab.length == 0) {
                    widget_uiBlock(id);
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalTab_Sheet="+id+"&t="+timestamp_id,
                        dataType: "html",
                        success: function(data){
                            $("#tabSheet_"+id).html(data);
                            $("#tabSheet_"+id).unblock();

                            $("tr").on( "mousedown", function() {
                                tr_parent = $(this).parent().parent().parent().attr('id');
                                if (tr_parent != null) {
                                    tr_parent_id = tr_parent.replace('tabSheet_', '');

                                    $('#tabSheet_'+tr_parent_id+' tbody').sortable({
                                        placeholder: 'sorting_highlight',
                                        update: function(event, ui) {
                                            var page_id_array = new Array();

                                            $('#tabSheet_'+tr_parent_id+' table:not(#tableTemplate_'+tr_parent_id+') tbody tr').each(function () {
                                                tr_row = $(this).attr('id');
                                                page_id_array.push(tr_row.replace('tr_', ''));
                                            });

                                            $.ajax({
                                                url: "function.php?modalSort_Row="+tr_parent_id,
                                                method: "POST",
                                                data: {page_id_array:page_id_array},
                                                success: function(data) {
                                                    // alert(data);
                                                }
                                            })
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            }
            function btnDeleteSheet(e) {
                var id = $(e).parent().prev().find('input[name="ID"]').val();

                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Sheet="+id,
                        dataType: "html",
                        success: function(response){
                            $("#modalNew .modal-body .tabbable .nav-tabs #li_"+id).remove();
                            $("#modalNew .modal-body .tabbable .tab-content #tabSheet_"+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDeleteFormat(e, id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Format="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDeleteData(e) {
                $(e).parent().parent().remove();
            }
            function btnNewRow(id, row, modal, timestamp_id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Row="+id+"&row="+row+"&modal="+modal+"&t="+timestamp_id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewRow .modal-body").html(data);
                        $('.summernoteOpen').summernote({
                            height: 100
                        });
                    }
                });
            }
            function btnEditRow(id, row, modal, timestamp_id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Row="+id+"&row="+row+"&modal="+modal+"&t="+timestamp_id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditRow .modal-body").html(data);
                        $('.summernoteOpen').summernote({
                            height: 100
                        });
                    }
                });
            }
            function btnDeleteRow(e, row) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Row="+row,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnImport(id, timestamp_id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalImport="+id+"&t="+timestamp_id,
                    dataType: "html",
                    success: function(data){
                        $("#modalImport .modal-body").html(data);
                    }
                });
            }
            function btnTemplate(id){
                $('#tableTemplate_'+id).tableExport({
                    // headings: true,                     // (Boolean), display table headings (th/td elements) in the <thead>
                    // footers: true,                      // (Boolean), display table footers (th/td elements) in the <tfoot>
                    // formats: ["xls", "csv", "txt"],     // (String[]), filetype(s) for the export
                    // fileName: "id",                     // (id, String), filename for the downloaded file
                    // bootstrap: true,                    // (Boolean), style buttons using bootstrap
                    // position: "bottom",                 // (top, bottom), position of the caption element relative to table
                    // ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file
                    // ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file
                    // ignoreCSS: ".tableexport-ignore"    // (selector, selector[]), selector(s) to exclude from the exported file

                    fileName: 'template',
                    type: 'csv',
                    htmlHyperlink: 'href',
                    numbers: {
                        html: {
                            decimalMark: '.',
                            thousandsSeparator: ','
                        },
                        output: {
                            decimalMark: ',',
                            thousandsSeparator: ''
                        }
                    }
                });
            }

            $(".modalNewSheet").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Sheet',true);

                var l = Ladda.create(document.querySelector('#btnSave_Sheet'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var sheet = '<li class="active" id="li_'+obj.ID+'">';
                                sheet += '<input type="hidden" name="sheetID[]" value="'+obj.ID+'" />';
                                sheet += '<a href="#tabSheet_'+obj.ID+'" data-toggle="tab" aria-expanded="true">'+obj.name+' <i class="fa fa-pencil text-danger" data-toggle="modal" href="#modalViewSheet" onclick="btnViewSheet('+obj.ID+', '+obj.modal+', '+obj.timestamp_id+')"></i></a>';
                            sheet += '</li>';

                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $("#"+modalView+" .modal-body .tabbable .nav-tabs li").removeClass('active');
                            $("#"+modalView+" .modal-body .tabbable .nav-tabs").append(sheet);

                            $("#"+modalView+" .modal-body .tabbable .tab-content .tab-pane").removeClass('active');
                            $("#"+modalView+" .modal-body .tabbable .tab-content").append(obj.data);
                            $("#"+modalView+" .modal-body .tabbable .tab-content table thead").html(obj.data_thead);
                            $('#'+modalView+' .modal-body .tabbable .tab-content table:first-child').html(obj.data_export);

                            $('#modalNewSheet').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalViewSheet").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Sheet',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Sheet'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                            var sheet = '<input type="hidden" name="sheetID[]" value="'+obj.ID+'" />';
                            sheet += '<a href="#tabSheet_'+obj.ID+'" data-toggle="tab" aria-expanded="true">'+obj.name+' <i class="fa fa-pencil text-danger" data-toggle="modal" href="#modalViewSheet" onclick="btnViewSheet('+obj.ID+', '+obj.modal+', '+obj.timestamp_id+')"></i></a>';
                        
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $('#'+modalView+' .modal-body .tabbable .nav-tabs #li_'+obj.ID).html(sheet);
                            $('#'+modalView+' .modal-body .tabbable #tabSheet_'+obj.ID+' > table:last-child').html(obj.data);
                            $("#"+modalView+" .modal-body .tabbable .tab-content table thead").html(obj.data_thead);
                            $('#'+modalView+' .modal-body .tabbable .tab-content table:first-child').html(obj.data_export);

                            $('#'+modalView+' .modal-body .tabbable #tabSheet_'+obj.ID+' table tbody tr').on( "mousedown", function() {
                                tr_parent = $(this).parent().parent().parent().attr('id');
                                if (tr_parent != null) {
                                    tr_parent_id = tr_parent.replace('tabSheet_', '');

                                    $('#tabSheet_'+tr_parent_id+' tbody').sortable({
                                        placeholder: 'sorting_highlight',
                                        update: function(event, ui) {
                                            var page_id_array = new Array();

                                            $('#tabSheet_'+tr_parent_id+' tbody tr').each(function () {
                                                tr_row = $(this).attr('id');
                                                page_id_array.push(tr_row.replace('tr_', ''));
                                            });

                                            $.ajax({
                                                url: "function.php?modalSort_Row="+tr_parent_id,
                                                method: "POST",
                                                data: {page_id_array:page_id_array},
                                                success: function(data) {
                                                    // alert(data);
                                                }
                                            })
                                        }
                                    });
                                }
                            });

                            $('#modalViewSheet').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalNewRow").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Row',true);

                var l = Ladda.create(document.querySelector('#btnSave_Row'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            if (obj.parent_id == 0) {
                                $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody").append(obj.data);
                            } else {
                                var child = $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody > .child_"+obj.parent_id).length;
                                if (child > 0) {
                                    $(obj.data).insertAfter("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody .child_"+obj.parent_id+":last");
                                } else {
                                    $(obj.data).insertAfter("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody #tr_"+obj.parent_id);
                                }
                            }
                            
                            $('#modalNewRow').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEditRow").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Row',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Row'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody  #tr_"+obj.parent_id).html(obj.data);
                            
                            $('#modalEditRow').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_IA',true);

                var l = Ladda.create(document.querySelector('#btnSave_IA'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $("#tableData tbody").append(obj.data);
                            
                            // $("#modalNew .modal-body").html('');
                            // $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_IA',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_IA'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $("#tableData tbody #tr_"+obj.ID).html(obj.data);
                            
                            $('#modalEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalGenerate").on('submit',(function(e) {
                e.preventDefault();

                var button = $(e.target).find("button[type=submit]:focus").attr("id");

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                // var formData = $(".modalGenerate").serializeArray()
                // console.log(formData);
                var formData = new FormData(this);
                formData.append('btnGenerate',true);
                formData.append('btnType', button);

                var l = Ladda.create(document.querySelector('#'+button));
                l.start();

                $.ajax({
                    url: "function_ia_new.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    datatype: "html",
                    success:function(response) {
                        if ($.trim(response)) {
                            // alert(response);
                            msg = "Sucessfully Save!";
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEditForm").on('submit',(function(e) {
                e.preventDefault();

                var button = $(e.target).find("button[type=submit]:focus").attr("id");

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnEdit_Form',true);
                formData.append('btnType', button);

                var l = Ladda.create(document.querySelector('#'+button));
                l.start();

                $.ajax({
                    url: "function_ia_update.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    datatype: "html",
                    success:function(response) {
                        if ($.trim(response)) {
                            // alert(response);
                            msg = "Sucessfully Save!";

                            // var obj = jQuery.parseJSON(response);
                            // $("#tableDataOpen tbody #tr_"+obj.ID).html(obj.data);
                            
                            // $('#modalEditForm').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalImport").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Import',true);

                var l = Ladda.create(document.querySelector('#btnSave_Import'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        console.log(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);

                            $("#modalEdit .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" table:not(#tableTemplate_"+obj.sheet_id+") tbody").html(obj.data);
                            
                            $('#modalImport').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
        </script>
	</body>
</html>