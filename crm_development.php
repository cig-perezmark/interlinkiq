<?php 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "Contacts Relationship Management";
    $site = "Customer_Relationship_Management";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /*Loader*/
    .loader {
      display: inline-block;
      width: 30px;
      height: 30px;
      position: relative;
      border: 4px solid #Fff;
      top: 50%;
      animation: loader 2s infinite ease;
    }
    
    .loader-inner {
      vertical-align: top;
      display: inline-block;
      width: 100%;
      background-color: #fff;
      animation: loader-inner 2s infinite ease-in;
    }
    
    @keyframes loader {
      0% {
        transform: rotate(0deg);
      }
      
      25% {
        transform: rotate(180deg);
      }
      
      50% {
        transform: rotate(180deg);
      }
      
      75% {
        transform: rotate(360deg);
      }
      
      100% {
        transform: rotate(360deg);
      }
    }
    
    @keyframes loader-inner {
      0% {
        height: 0%;
      }
      
      25% {
        height: 0%;
      }
      
      50% {
        height: 100%;
      }
      
      75% {
        height: 100%;
      }
      
      100% {
        height: 0%;
      }
    }
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
    /* Define spinning animation */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Apply spinning animation to glyphicon-refresh class */
    .glyphicon-spin {
        display: inline-block;
        -webkit-animation: spin 1s infinite linear;
        animation: spin 1s infinite linear;
    }
    .d-none {
        display:none!important;
    }
    .margin-5 {
        margin-top: 5em;
    }
    .modal-xxl {
        width: 1700px;
    }
    .list-group-item {
        border:none;
    }
    .border {
        border: 1px solid #e7ecf1;
        margin-top:3.28;
    }
    .filter-flex {
        display:flex;
        flex-direction: column;
    }
    .filter--title {
        margin-top: 2rem;
    }
    table th{
        text-transform: uppercase;
        /*text-align: center;*/
    }
    .d-flex {
        display: flex;
    }
    .justify-content-end{
        justify-content: end;
    }
    .mt-2{
        margin-top: 2rem;
    }
    .nav-tabs {
        border-bottom: 1px solid transparent;
    }
    #actionBtn {
        position: fixed;
        right: 0;
        bottom: 0;
        padding: 0 100px 25px 0;
        z-index: 4;
    }
    .col1{
        padding: 1rem 0;
    }
    .col2 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }
    .d-flex {
        display: flex;
    }
    .justify-content-center {
        justify-content: center;
    }
    .justify-content-between {
        justify-content: space-between;
    }
    .dt-buttons {
        margin: 2rem 0;
    }
</style>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#list" data-toggle="tab"> Contact List </a>
                </li>
                
                <li>
                    <a href="#contribution" data-toggle="tab"> My Contribution </a>
                </li>
                
                <li>
                    <a href="#report" data-toggle="tab"> Report </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="list">
                    <div class="portlet light portlet-fit ">
                        <div class="portlet-title mb-5">
                            <div class="caption">
                                <i class="icon-users font-dark"></i>
                                <span class="caption-subject font-dark bold uppercase">Contacts Relationship Management</span>
                                <?php
                                    if($current_client == 0) {
                                        $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $type_id = $row["type"];
                                            $file_title = $row["file_title"];
                                            $video_url = $row["youtube_link"];
                                            
                                            $file_upload = $row["file_upload"];
                                            if (!empty($file_upload)) {
                                	            $fileExtension = fileExtension($file_upload);
                                				$src = $fileExtension['src'];
                                				$embed = $fileExtension['embed'];
                                				$type = $fileExtension['type'];
                                				$file_extension = $fileExtension['file_extension'];
                                	            $url = $base_url.'uploads/instruction/';
                                
                                        		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                            }
                                            
                                            if ($type_id == 0) {
                                        		echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><i class="fa '. $file_extension .'"></i> '.$file_title.'</a>';
                                        	} else {
                                        		echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><i class="fa fa-youtube"></i> '.$file_title.'</a>';
                                        	}
                                        }
                                    }
                                ?>
                            </div>
                            <div class="actions">
                                <div class="btn-group">
                                    <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" >Add New Contacts</a>
                                           
                                            <a data-toggle="modal" class="" href="<?php echo $FreeAccess == false ? '#modalMultiUpload':'#modalService'; ?>" >Add Multiple Contacts</a>
                                        </li>
                                        <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                            <li>
                                                <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--<div style="display: flex!important; justify-content: start; padding: 0 20px;">-->
                        <!--    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#search_modal':'#modalService'; ?>" class="btn green d-none" id="search">Search Contact</a>-->
                        <!--</div>-->
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-2 border d-none" id="filter-side">
                                    <h4 class="block"><i class="fa fa-filter"></i> Filter</h4>
                                    <div class="filter-flex">
                                        <form id="searchForm">
                                            <label>Contact name</label>
                                            <div class="input-group" style="margin-bottom:1rem">
                                                <input type="text" class="form-control" id="searchValue" placeholder="Search customer name">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn green" type="button"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                        <form id="searchFormEmail">
                                            <label>Contact email</label>
                                            <div class="input-group" style="margin-bottom:1rem">
                                                <input type="text" class="form-control" id="searchEmailValue" placeholder="Search contact email">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn green" type="button"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                        <form id="searchFormNo">
                                            <label>Contact no.</label>
                                            <div class="input-group" style="margin-bottom:1rem">
                                                <input type="text" class="form-control" id="searchNoValue" placeholder="Search contact no.">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn green" type="button"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                        <form id="searchFormSource">
                                            <label>Contact source.</label>
                                            <div class="input-group" style="margin-bottom:1rem">
                                                <input type="text" class="form-control" id="searchSourceValue" placeholder="Search contact source">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn green" type="button"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                        <label>Person Activity</label>
                                        <div class="input-group" style="margin-bottom:1rem">
                                            <select class="form-control mt-multiselect btn btn-default get-person-activity" name="email" type="text" required style="width: 100%">
                                                <option>Select Person</option>
                                                <?php
                                                    $user_id = $switch_user_id ?? 34 ;
                                                    $query = mysqli_prepare($conn, "SELECT first_name, last_name FROM tbl_hr_employee WHERE user_id = ? ORDER BY first_name ASC");
                                                    mysqli_stmt_bind_param($query, 'i', $user_id);
                                                    mysqli_stmt_execute($query);
                                                    if(!$query){
                                                        die('Error: '. mysqli_error($conn));
                                                    }
                                                    mysqli_stmt_bind_result($query, $first_name, $last_name);
                                                    while(mysqli_stmt_fetch($query)) {
                                                        echo '<option value="'.$first_name.' '.$last_name.'">'.$first_name.' '.$last_name.'</option>'; 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="bold font-dark mt-3">Campaign</label>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Has Campaign 
                                                <input type="checkbox" class="filter_value_campaign" value="has_campaign"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> No Campaign 
                                                <input type="checkbox" class="filter_value_campaign" value="no_campaign"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        <label class="bold font-dark mt-3">Status</label>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Active 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Active"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Contact 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Contact"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight">
                                            <label class="mt-checkbox"> Customer 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Customer"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight">
                                            <label class="mt-checkbox"> Follow up 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Follow up"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight">
                                            <label class="mt-checkbox"> For demo 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="For demo"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight">
                                            <label class="mt-checkbox"> Inactive
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Inactive"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight">
                                            <label class="mt-checkbox"> Leads 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Leads"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Presentation 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Presentation"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Prospect 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Prospect"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Service proposal 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Service proposal"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Manual 
                                                <input type="checkbox" class="filter_value" data-value="account_status" value="Manual"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight" style="border-bottom: 1px solid #e7ecf1; margin-bottom:2rem;"> 
                                            <label class="mt-checkbox"> Archived 
                                                <input type="checkbox" class="filter_value" data-value="flag" value="0"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <label class="bold font-dark mt-2 filter--title">Date</label>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Latest Record 
                                                <input type="checkbox" class="filter_value" data-value="crm_date_added" value="1 MONTH"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> 3 Months Record 
                                                <input type="checkbox" class="filter_value" data-value="crm_date_added" value="3 MONTH"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> 6 Months Record 
                                                <input type="checkbox" class="filter_value" data-value="crm_date_added" value="6 MONTH"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="bd-highlight"> 
                                            <label class="mt-checkbox"> Annual Record 
                                                <input type="checkbox" class="filter_value" data-value="crm_date_added" value="1 YEAR"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        
                                        <label class="bold font-dark mt-2 filter--title">Custom Date Range</label>
                                        <div class="bd-highlight">
                                            <form method="POST" id="filter-via-date">
                                               <div class="form-group">
                                                    <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                        <input type="text" id="date-from" class="form-control" name="date_from">
                                                        <span class="input-group-addon"> to </span>
                                                        <input type="text" id="date-to" class="form-control" name="date_to"> 
                                                    </div>
                                                    <button type="submit" id="filter_date" class="btn green" style="width: 100%; margin-top: 10px">APPLY</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div id="site_activities_loading">
                                        <span id="spinner-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                                    </div>
                                    <div class="clearfix d-none" id="actionBtn">
                                        <div class="btn-group btn-group-solid">
                                            <?php if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 108): ?>
                                                <!--<a class="btn blue tooltips" id="sendEmailCampaign" data-toggle="modal" href="#sendCampaign">Test Campaign</a>-->
                                            <?php endif?>
                                            <a class="btn blue tooltips" id="sendEmailCampaign" data-toggle="modal" href="#sendCampaign">Send Campaign</a>
                                            <!--<a class="btn dark tooltips" id="sendEmailGreetings" data-toggle="modal" href="#sendGreetings">Send Greetings</a>-->
                                            <!--<a class="btn default tooltips" id="sendEmail" data-toggle="modal" href="#sendEmail">Send Email</a>-->
                                            <a class="btn yellow tooltips" id="archiveContact" data-id="archive"></i>Archive</a>
                                            <a class="btn green tooltips" id="restoreContact" data-id="restore"></i>Restore</a>
                                            <!--<a class="btn red tooltips" id="deleteContact" data-id="delete"></i>Delete</a>-->
                                        </div>
                                    </div>
                                    <!--<div id="spinner" class="glyphicon glyphicon-refresh glyphicon-spin text-info" style="padding: 10px; font-size:20px"></div> <span id="spinner-text" style="display:18px" class="">Fetching data, a momment please . . .</span>-->
                                     <table class="table table-bordered table-hover d-none" id="dataTable_2">
                                    	<thead>
                                            <tr role="row">
                                                <th width="5%" class="text-center">
                                                    <!--<label class="mt-checkbox">-->
                                                    <!--    <input type="checkbox" class="select-all"/>-->
                                                    <!--    <span></span>-->
                                                    <!--</label>-->
                                                </th>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Contact no.</th>
                                                <th>Source</th>
                                                <th>Status</th>
                                                <th>Activity Date</th>
                                                <th>Performer</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <table class="table table-bordered table-hover d-none" id="dataTable_1">
                                    	<thead>
                                            <tr role="row">
                                                <th  width="5%" class="text-center">
                                                    <!--<label class="mt-checkbox">-->
                                                    <!--    <input type="checkbox" class="select-all"/>-->
                                                    <!--    <span></span>-->
                                                    <!--</label>-->
                                                </th>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Contact no.</th>
                                                <th>Source</th>
                                                <th>Status</th>
                                                <th>Activity Date</th>
                                                <th>Performer</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="report">
                    <div class="row widget-row">
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Contacts</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-green icon-users"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="contactCount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Active Campaigns</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red icon-envelope-letter"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="campaignCount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Active Campaigners</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-purple icon-user-following"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="activeCampaignerCount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Average Campaign Send Monthly</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="monthlyCampaignAverage">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="widget-thumb-heading">Active Campaigns</h4>
                                <div class="widget-thumb-wrap">
                                    <div class="scroller" style="height: 1065px;" data-always-visible="1" data-rail-visible="0">
                                        <ul class="feeds campaignsArea">
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col2">
                                                            <div class="desc"> No campaigns yet!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="widget-thumb-heading"></h4>
                                <div class="widget-thumb-wrap">
                                    <div id="chartdiv1" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="widget-thumb-heading"></h4>
                                <div class="widget-thumb-wrap">
                                    <div id="chartdiv2" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                            
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="widget-thumb-heading"></h4>
                                <div class="widget-thumb-wrap">
                                    <div id="chartdiv3" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
               
                <div class="tab-pane" id="contribution">
                    <div class="row widget-row">
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Contacts</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-green icon-users"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="userContacts">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Active Campaigns</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red icon-envelope-letter"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="userCampaigns">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Campaigns Sent Today</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-purple icon-user-following"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="userSentToday">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                <h4 class="widget-thumb-heading">Daily Average Campaign sent</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat" id="userDailyAverage">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Task</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalTaskForm" >Add New Ticket</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover dataTable no-footer" id="dataTable_3">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Originator</th>
                                                <th>Assigned to</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Due</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Campaigns</h4>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover dataTable no-footer" id="dataTable_4">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Total Campaign Sent</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="d-flex justify-content-center h4">Daily Sent Campaign Chart</h4>
                                <div class="widget-thumb-wrap">
                                    <div id="chartdiv4" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                            
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                <h4 class="widget-thumb-heading"></h4>
                                <div class="widget-thumb-wrap">
                                    <div id="chartdiv2" style="width: 100%; height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>

        <!-- MODAL AREA-->
        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave" id="addContactForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Account</h4>
                        </div>
                        <div class="modal-body">
                            <div class="tabbable tabbable-tabdrop">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tabBasic_1" data-toggle="tab">Details</a>
                                    </li>
                                    <li>
                                        <a href="#tabContact_1" data-toggle="tab">Contact</a>
                                    </li>
                                    <li>
                                        <a href="#tabProducts_1" data-toggle="tab">Products & Services</a>
                                    </li>
                                </ul>
                                <div class="tab-content margin-top-20">
                                    <div class="tab-pane active" id="tabBasic_1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Account  Representative</label>
                                                    <input class="form-control" type="hidden" name="from" id="from" value="<?php echo $current_userEmail; ?>">
                                                    <input class="form-control" type="text" name="account_rep" id="account_rep" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Account Name</label>
                                                    <input class="form-control" type="text" name="account_name" id="account_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Parent Acount</label>
                                                   <input class="form-control" id="parent_account" name="parent_account">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                   <select class="form-control mt-multiselect btn btn-default" id="status_active" name="account_status" required>
                                                        <option selected value="Active">Active</option>
                                                        <option value="Contact">Contact</option>
                                                        <option value="Customer">Customer</option>
                                                        <option value="Follow up">Follow up</option>
                                                        <option value="For demo">For demo</option>
                                                        <option value="Inactive">Inactive</option>
                                                        <option value="Leads">Leads</option>
                                                        <option value="Presentation">Presentation</option>
                                                        <option value="Prospects">Prospects</option>
                                                        <option value="Service Proposal">Service Proposal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email<i style="font-size:12px;color:orange;">&nbsp;(0ne email only!!)</i></label>
                                                    <input class="form-control" type="email" id="account_email" name="account_email" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                   <select class="form-control mt-multiselect btn btn-default" id="account_country" name="account_country">
                                                       <option value="">---Select---</option>
                                                   <?php
                                                   // for display country
                                                    $querycountry = "SELECT * FROM countries order by name ASC";
                                                    $resultcountry = mysqli_query($conn, $querycountry);
                                                    while($rowcountry = mysqli_fetch_array($resultcountry))
                                                         { ?>
                                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == 233){ echo 'selected';}else{ echo ''; } ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                   <input class="form-control" id="account_phone" name="account_phone">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input class="form-control" id="account_fax" name="account_fax">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <input class="form-control" type="text" id="account_address" name="account_address" required />
                                                </div>
                                            </div>
                                            <!--country here-->
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Website</label>
                                                    <input class="form-control" type="text" id="account_website" name="account_website">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Facebook</label>
                                                   <input class="form-control" id="account_facebook" name="account_facebook">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Twitter</label>
                                                   <input class="form-control" id="account_twitter" name="account_twitter">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">LinkedIn</label>
                                                    <input class="form-control" id="account_linkedin" name="account_linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label class="control-label">Interlink</label>
                                                    <input class="form-control" id="account_interlink" name="account_interlink">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Source/Tag</label>
                                                    <input class="form-control" id="Account_Source" name="Account_Source">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabContact_1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Contact Name</label>
                                                    <input class="form-control" type="text" id="contact_name" name="contact_name">
                                                </div>
                                            </div>  
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Title</label>
                                                   <input class="form-control" id="contact_title" name="contact_title">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Report to</label>
                                                    <input class="form-control" id="contact_report" name="contact_report">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input class="form-control" type="email" id="contact_email" name="contact_email">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                   <input class="form-control" id="contact_phone" name="contact_phone">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input class="form-control" id="contact_fax" name="contact_fax">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <input class="form-control" type="text" id="contact_address" name="contact_address">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Website</label>
                                                   <input class="form-control" id="contact_website" name="contact_website">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Facebook</label>
                                                    <input class="form-control" type="text" id="contact_facebook" name="contact_facebook">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Twitter</label>
                                                   <input class="form-control" id="contact_twitter" name="contact_twitter">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">LinkedIn</label>
                                                    <input class="form-control" id="contact_linkedin" name="contact_linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Interlink</label>
                                                    <input class="form-control" id="contact_interlink" name="contact_interlink">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabProducts_1">
                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Products</label>
                                                    <input class="form-control" type="text" id="account_product" name="account_product" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Services</label>
                                                   <input class="form-control" id="account_service" name="account_service">
                                                </div>
                                            </div>
                                        </div>  
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Industry</label>
                                                    <select class="form-control mt-multiselect btn btn-default" id="account_industry" name="account_industry">
                                                        <option value="none">Select Industry</option>
                                                        <option value="510k">510k</option>
                                                        <option value="Accounting">Accounting</option>
                                                        <option value="Acidified Foods">Acidified Foods</option>
                                                        <option value="Agricultural"> Agricultural</option>
                                                        <option value="Animal Feed">Animal Feed</option>
                                                        <option value="Aquaculture">Aquaculture</option>
                                                        <option value="Baked Products"> Baked Products</option>
                                                        <option value="Beef">Beef</option>
                                                        <option value="Beverage">Beverage</option>
                                                        <option value="Candies">Candies</option>
                                                        <option value="Cannabis">Cannabis</option>
                                                        <option value="Catering">Catering</option>
                                                        <option value="Cereals">Cereals</option>
                                                        <option value="Chemicals">Chemicals</option>
                                                        <option value="Chocolate">Chocolate</option>
                                                        <option value="Coffee">Coffee</option>
                                                        <option value="Confectionery">Confectionery</option>
                                                        <option value="CPG/FMCG">CPG/FMCG</option>
                                                        <option value="Chicken Products">Chicken Products</option>
                                                        <option value="Cosmetics">Cosmetics</option>
                                                        <option value="Dairy">Dairy</option>
                                                        <option value="Deli">Deli</option>
                                                        <option value="Dietary Supplement">Dietary Supplement</option>
                                                        <option value="Dips">Dips</option>
                                                        <option value="Distribution">Distribution</option>
                                                        <option value="Equipment">Equipment</option>
                                                        <option value="Fats">Fats</option>
                                                        <option value="Finance">Finance</option>
                                                        <option value="Fishery">Fishery</option>
                                                        <option value="Flavoring">Flavoring</option>
                                                        <option value="Food">Food</option>
                                                        <option value="Functional Foods">Functional Foods</option>
                                                        <option value="Fruits">Fruits</option>
                                                        <option value="Grains">Grains</option>
                                                        <option value="Gravies">Gravies</option>
                                                        <option value="Heat to Eat">Heat to Eat</option>
                                                        <option value="Herbal / Herbs">Herbal / Herbs</option>
                                                        <option value="Honey">Honey</option>
                                                        <option value="Ingredients">Ingredients</option>
                                                        <option value="Juice">Juice</option>
                                                        <option value="Kitchen">Kitchen</option>
                                                        <option value="Lamb">Lamb</option>
                                                        <option value="Legal">Legal</option>
                                                        <option value="Manufacturing">Manufacturing</option>
                                                        <option value="Medical Device">Medical Device</option>
                                                        <option value="Medical Food">Medical Food</option>
                                                        <option value="Nutraceuticals">Nutraceuticals</option>
                                                        <option value="Nuts">Nuts</option>
                                                        <option value="Oils">Oils</option>
                                                        <option value="Organic">Organic</option>
                                                        <option value="Packaging">Packaging</option>
                                                        <option value="Pharmaceutical">Pharmaceutical</option>
                                                        <option value="Pasta">Pasta</option>
                                                        <option value="Pet Food">Pet Food</option>
                                                        <option value="Produce">Produce</option>
                                                        <option value="PMTA">PMTA</option>
                                                        <option value="Poultry">Poultry</option>
                                                        <option value="Proteins">Proteins</option>
                                                        <option value="Raw Materials">Raw Materials</option>
                                                        <option value="Ready-to-Cook">Ready-to-Cook</option>
                                                        <option value="Ready-to-Eat">Ready-to-Eat</option>
                                                        <option value="Reduce Oxygen">Reduce Oxygen</option>
                                                        <option value="Restaurant">Restaurant</option>
                                                        <option value="Sauces">Sauces</option>
                                                        <option value="Sausage">Sausage</option>
                                                        <option value="Seafood">Seafood</option>
                                                        <option value="Seeds">Seeds</option>
                                                        <option value="Soups">Soups</option>
                                                        <option value="Spices">Spices</option>
                                                        <option value="Sushi">Sushi</option>
                                                        <option value="Systems">Systems</option>
                                                        <option value="Tobacco">Tobacco</option>
                                                        <option value="Transportation">Transportation</option>
                                                        <option value="Utensils">Utensils</option>
                                                        <option value="Vacuum Packaging">Vacuum Packaging</option>
                                                        <option value="Veal">Veal</option>
                                                        <option value="Vegetables">Vegetables</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Category</label>
                                                    <select class="form-control mt-multiselect btn btn-default" id="account_category" name="account_category">
                                                        <option value="none">Select Category</option>
                                                        <option value="Human Food/Food Packaging Enterprise ">Human Food/Food Packaging Enterprise </option>
                                                        <option value="Manufacturer/Co-Manufacturer/White Label">Manufacturer/Co-Manufacturer/White Label</option>
                                                        <option value="APacker/Co-Packer">Packer/Co-Packer</option>
                                                        <option value="Brand Owner"> Brand Owner</option>
                                                        <option value="Distributor/Retailer/Reseller">Distributor/Retailer/Reseller</option>
                                                        <option value="Logistics/Brokerage/Storage & Distribution">Logistics/Brokerage/Storage & Distribution</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div class="form-group">
                                                    <label class="control-label">Certification/s</label>
                                                   <input class="form-control" id="account_certification" name="account_certification">
                                                </div>
                                            </div>
                                        </div>
                                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    <button type="submit" class="btn btn-success ladda-button" data-style="zoom-out" id="addContactBtn"><span class="ladda-label">Save</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="massUploadResult" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave" id="addContactForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Mass Upload Results</h4>
                        </div>
                        <div class="modal-body">
                            <div class="tabbable tabbable-tabdrop">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#existTab" data-toggle="tab">Exist Entries</a>
                                    </li>
                                    <li>
                                        <a href="#failedTab" data-toggle="tab">Inserted Entries</a>
                                    </li>
                                </ul>
                                <div class="tab-content margin-top-20">
                                    <div class="tab-pane active" id="existTab">
                                        <div class="caption">
                                            <i class="icon-users font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Existing Contact Email Entries</span>
                                        </div>
                                        <table class="table table-bordered table-hover" id="dataTable_3">
                                            <thead>
                                                <tr role="row">
                                                    <th></th>
                                                    <th>Account Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Source</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="failedTab">
                                        <div class="caption">
                                            <i class="icon-users font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Inserted Contact Email Entries</span>
                                        </div>
                                        <table class="table table-bordered table-hover" id="dataTable_4">
                                            <thead>
                                                <tr role="row">
                                                    <th></th>
                                                    <th>Account Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Source</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
         <!-- MODAL AREA-->
        <div class="modal fade" id="modalMultiUpload" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" id="massUploadForm" enctype="multipart/form-data" class="modalForm modalSave">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add Multiple Contacts <a href="Customer_relationship_template_account.php">&nbsp;<i style="font-size:14px;">(Template here...)</i></a></h4>
                        </div>
                        <div class="modal-body">
                            <div class="tabbable tabbable-tabdrop">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Upload Template</label>
                                            <input class="form-control" type="hidden" name="from" id="from" value="<?php echo $current_userEmail; ?>">
                                            <input class="form-control-plaintext mb-2" id="uploadFileCsvInput" type="file" name="csvfile" id="csvfile" accept=".csv">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" id="massUploadFormBtn" class="btn btn-success ladda-button" name="upload_multiple_contacts" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalEditTaskForm" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateTaskForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Edit Task</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <input class="form-control" type="text" name="task_name" id="task-name" required>
                                        <input class="form-control" type="hidden" name="old_assigned" id="old-assigned" required>
                                        <input class="form-control" type="hidden" name="taskid" id="taskid" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <select class="form-control" name="status" id="task-status">
                                            <option value="3">Completed</option>
                                            <option value="1">Pending</option>
                                            <option value="2">In Progress</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Description</label></label>
                                            <textarea  class="form-control" name="description" rows="5" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Assign to
                                            <span class="text-success">Current Assigned: </span> <span class="text-blue" id="assigned-to"> </span>
                                        </label>
                                        <select class="form-control" name="assign_to" type="text" required style="width: 100%">
                                            <option>Select Person</option>
                                            <?php
                                                $user_id = $switch_user_id ?? 34 ;
                                                $query = mysqli_prepare($conn, "SELECT first_name, last_name, email FROM tbl_hr_employee WHERE user_id = ? AND status = 1 ORDER BY first_name ASC");
                                                mysqli_stmt_bind_param($query, 'i', $user_id);
                                                mysqli_stmt_execute($query);
                                                if(!$query){
                                                    die('Error: '. mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($query, $first_name, $last_name, $email);
                                                while(mysqli_stmt_fetch($query)) {
                                                    echo '<option value="'.$email.'">'.$first_name.' '.$last_name.'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label>
                                        <input class="form-control" type="date" name="startdate" id="startdate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deadline</label>
                                        <input class="form-control" type="date" name="duedate" id="duedate" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<input type="submit" class="btn btn-info">Save Changes</button>      -->
                             <input type="submit" name="update_task" class="btn btn-info" value="Save Changes">
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalTaskForm" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="customer_relationship_AddTask.php" enctype="multipart/form-data" class="modalForm modalSave">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Task</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Assign to</label>
                                        <select class="form-control" name="email" type="text" required>
                                            <option>Select Email</option>
                                            <?php
                                                $flag = 1;
                                                $status = 'Manual';      
                                                $stmt = mysqli_prepare($conn, 'SELECT account_email, account_name FROM tbl_Customer_Relationship WHERE flag = ? AND account_status != ?');
                                                mysqli_stmt_bind_param($stmt, 'is', $flag, $status);
                                                mysqli_stmt_execute($stmt);
                                                if(!$stmt) {
                                                    die('Error: ' . mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($stmt, $account_email, $account_name);
                                                while(mysqli_stmt_fetch($stmt)) {
                                                    echo '<option value="'.$account_name.'">'.$account_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <input class="form-control" type="text" name="assign_task" id="assign_task" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Description</label></label>
                                            <textarea  class="form-control" name="Task_Description" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Assign to</label>
                                        <select class="form-control mt-multiselect btn btn-default get-person-activity" name="email" type="text" required style="width: 100%">
                                            <option>Select Person</option>
                                            <?php
                                                $user_id = $switch_user_id ?? 34 ;
                                                $query = mysqli_prepare($conn, "SELECT first_name, last_name FROM tbl_hr_employee WHERE user_id = ? ORDER BY first_name ASC");
                                                mysqli_stmt_bind_param($query, 'i', $user_id);
                                                mysqli_stmt_execute($query);
                                                if(!$query){
                                                    die('Error: '. mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($query, $first_name, $last_name);
                                                while(mysqli_stmt_fetch($query)) {
                                                    echo '<option value="'.$first_name.' '.$last_name.'">'.$first_name.' '.$last_name.'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label>
                                        <input class="form-control" type="date" name="Task_added" id="Task_added" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deadline</label>
                                        <input class="form-control" type="date" name="Deadline" id="Deadline" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <input type="submit" class="btn btn-success" name="btntask_submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="activity-history" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Activities</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalCampaignList" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog" style="width:88%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Campaign List</h4>
                    </div>
                    <div class="modal-body">
                        <div id="site_activities_loading">
                            <span id="spinner-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                        </div>
                        <table class="table table-bordered table-hover no-footer d-none" id="dataTable_5">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th>Date</th>
                                    <th>Label</th>
                                    <th>Recipient</th>
                                    <th>Message</th>
                                    <th>Frequency</th>
                                    <th>Status</th>
                                    <th>Expiration</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalCampaignList" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog" style="width:85%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Campaign List</h4>
                    </div>
                    <div class="modal-body">
                        <div id="site_activities_loading">
                            <span id="spinner-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade bs-modal-lg" id="view-campaign-message" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content" style="border-radius: 6px!important;">
                    <div class="modal-body">
                        <div id="site_campaign_loading">
                            <span id="campaign-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                        </div>
                        <div id="campaignMessageBody" class="d-none">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>      
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade bs-modal-lg" id="modalCampaignDetails" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:95%;">
                <div class="modal-content">
                    <form id="updateCampaignForm" method="POST" action="crm/functions.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Campaign Details</h4>
                        </div>
                        <div class="modal-body">
                    		<div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Campaign Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" name="name" id="campaign-name">
                                        <input class="form-control" name="campaignid" id="campaignid">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Recipient</label>
                                        <input class="form-control" name="recipient" id="campaign-recipient">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Subject</label>
                                        <input class="form-control" name="subject" id="campaign-subject">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Body</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control summernote" name="body" id="campaign-message"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                <div class="col-md-6">
                                        <label>Frequency</label>
                                        <select class="form-control" name="frequency" id="campaign-frequency">
                							<option value="1">Once Per Day</option>
                							<option value="2">Once Per Week</option>
                							<option value="3">On the 1st and 15th of the Month</option>
                							<option value="4">Once Per Month</option>
                							<option value="6">Once Per Two Months (Every Other Month)</option>
                							<option value="7">Once Per Three Months (Quarterly)</option>
                							<option value="8">Once Per Six Months (Bi-Annual)</option>
                							<option value="5">Once Per Year</option>
                						</select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Auto Email</label>
                                        <select class="form-control" name="status" id="campaign-status">
                                            <option value="0">Stop</option>
                                            <option value="1">Activate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="update_campaign" class="btn btn-info">Save Changes</button>      
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade bs-modal-lg" id="campaignDetails" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content" style="border-radius: 6px!important;">
                    <div class="modal-body">
                        <div id="site_campaign_loading">
                            <span id="campaign-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                        </div>
                        <div id="campaignMessageBody" class="d-none">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>      
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade bs-modal-lg" id="view-content" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content" style="border-radius: 6px!important;">
                    <div class="modal-body">
                        <div id="emailMessageBody">
                            <div id="site_activities_loading">
                                <span id="spinner-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>      
                    </div>
                </div>
            </div>
        </div>
        
        <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="customer_relationship_collaboration.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Shared Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="btn_Collab" value="Share" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Emjay modal-->
        <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="modalForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Upload Demo Video</h4>
                        </div>
                        <div class="modal-body">
                                <label>Video Title</label>
                                <input type="text" id="file_title" name="file_title" class="form-control mt-2">

                                <label style="margin-top:15px">Video File</label>
                                <input type="file" id="file" name="file" class="form-control mt-2">

                                <label style="margin-top:15px">Privacy</label>
                                <select class="form-control" name="privacy" id="privacy" required>
                                    <option value="Private">Private</option>
                                    <option value="Public">Public</option>
                                </select>
                            
                            <div style="margin-top:15px" id="message">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="button" class="btn btn-success" id="save_video" name="save_video"><span id="save_video_text">Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="view_video" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="modalForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Demo Video</h4>
                        </div>

                        <div class="modal-body">
                            <video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">
                              <source src="" >
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / END MODAL AREA -->
        
        <!--Marvin's modal starts here-->
        <div class="modal fade" id="history_modal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">History</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-hover" id="dataTable_3">
                                	<thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Perform by</th>
                                            <th>Date updated</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contactHistoryDetails">
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="add_remarks" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">-</h4>
                    </div>
                    <div class="modal-body">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bubble font-hide hide"></i>
                                    <span class="caption-subject font-hide bold uppercase">Chats</span>
                                </div>
                                <div class="actions">
                                    <div class="portlet-input input-inline">
                                        <div class="input-icon right">
                                            <i class="icon-magnifier"></i>
                                            <input type="text" class="form-control input-circle" placeholder="search..."> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-body" id="chats">
                                <div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1" id="chatThreads">
                                    
                                </div>
                                <form method="POST">
                                    <div class="chat-form">
                                        <div class="input-cont">
                                            <input class="form-control" type="text" id="contactid" /> 
                                            <input class="form-control" type="text" id="messageContent" placeholder="Type a message here..." /> 
                                        </div>
                                        <div class="btn-cont" id="sendMessage">
                                            <span class="arrow"> </span>
                                            <a href="" class="btn blue icn-only">
                                                <i class="fa fa-check icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="modalForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Upload Demo Video</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="button" class="btn btn-success" id="save_video" name="save_video"><span id="save_video_text">Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="sendCampaign" tabindex="-1" role="dialog" >
            <div class="modal-dialog" style="width: 95%">
                <div class="modal-content">
                    <form id="emailCampaignForm">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Campaign <i style="color:#fff;font-size:14px;"></i></h4>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Campaign Name</label>
                                        <input class="form-control" type="text" id="campaign-name" name="campaign_name" required>
                                        <input class="form-control" type="hidden" name="from" id="current-email" value="<?=$current_userEmail?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input class="form-control" type="text" name="subject" id="campaign-subject" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea class="form-control summernoteEditor" type="text" name="body" rows="4" id="campaign-body" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Frequency </label>
                                        <select class="form-control mt-multiselect btn btn-default" name="frequency" id="campaign-frequency" required>
        									<option value="1">Once Per Day</option>
        									<option value="2">Once Per Week</option>
        									<option value="3">On the 1st and 15th of the Month</option>
        									<option value="4" selected="">Once Per Month</option>
        									<option value="6">Once Per Two Months (Every Other Month)</option>
        									<option value="7">Once Per Three Months (Quarterly)</option>
        									<option value="8">Once Per Six Months (Bi-Annual)</option>
        									<option value="5">Once Per Year</option>
        								</select>
                                    </div>
                                </div>
                            </div>
                           <br>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" id="sendCampaignMessage" class="btn btn-info">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--end-->
                     
    </div><!-- END CONTENT BODY -->

    <?php include_once ('footer.php'); ?>
    <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
    <script src="crm/crm_script_development.js"></script>
    <script src="crm/graph.js"></script>
    </body>
</html>