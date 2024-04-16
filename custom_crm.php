<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Contacts Relationship Management";
    $site = "custom crm";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
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
        display:none;
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
</style>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit ">
                <div class="portlet-title mb-5">
                    <div class="caption">
                        <i class="icon-users font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Contacts Relationship Management</span>
                        <?php
                            if($current_client == 0) {
                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
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
                                   
                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalMultiUpload':'#modalService'; ?>" >Add Multiple Contacts</a>
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
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 border d-none" id="filter-side">
                            <h4 class="block"><i class="fa fa-filter"></i> Filter</h4>
                            <div class="filter-flex">
                               <form id="searchForm">
                                    <div class="input-group" style="margin-bottom:1rem">
                                        <input type="text" class="form-control" id="searchValue" placeholder="Search customer name">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn green" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                                <label class="bold font-dark mt-3">Status</label>
                                <div class="bd-highlight"> 
                                    <label class="mt-checkbox"> Active 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Active"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight"> 
                                    <label class="mt-checkbox"> Contact 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Contact"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight">
                                    <label class="mt-checkbox"> Costumer 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Costumer"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight">
                                    <label class="mt-checkbox"> Follow up 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Follow up"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight">
                                    <label class="mt-checkbox"> For demo 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="For demo"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight">
                                    <label class="mt-checkbox"> In active
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="In active"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight">
                                    <label class="mt-checkbox"> Leads 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Leads"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight"> 
                                    <label class="mt-checkbox"> Presentation 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Presentation"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight"> 
                                    <label class="mt-checkbox"> Prospect 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Prospect"/>
                                        <span></span>
                                    </label>
                                </div>
                                
                                <div class="bd-highlight" style="border-bottom: 1px solid #e7ecf1; margin-bottom:2rem;"> 
                                    <label class="mt-checkbox"> Service proposal 
                                        <input type="checkbox" class="filter_value" data-value="account_category" value="Service proposal"/>
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
                            <!--<div id="spinner" class="glyphicon glyphicon-refresh glyphicon-spin text-info" style="padding: 10px; font-size:20px"></div> <span id="spinner-text" style="display:18px" class="">Fetching data, a momment please . . .</span>-->
                            <table class="table table-bordered table-hover d-none" id="dataTable_2">
                            	<thead>
                                    <tr role="row">
                                        <th>Company Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-hover d-none" id="dataTable_1">
                            	<thead>
                                    <tr role="row">
                                        <th>Company Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
                    <form method="post" action="customer_relationship_account.php" enctype="multipart/form-data" class="modalForm modalSave">
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Account Name</label>
                                                    <input class="form-control" type="text" name="account_name" id="account_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Parent Acount</label>
                                                   <input class="form-control" id="parent_account" name="parent_account">
                                                </div>
                                            </div>
                                            <!--<div class="col-md-4">-->
                                            <!--    <div class="form-control-plaintext form-check-inline">-->
                                            <!--        <label class="control-label">Status</label>-->
                                            <!--        <br>-->
                                            <!--        <input type="radio" class="form-check-input" name="account_status" id="status_active" value="Active">-->
                                            <!--        <label class="control-label">Active</label>-->
                                            <!--       &nbsp;-->
                                            <!--        <input type="radio" class="form-check-input" name="account_status" id="status_inactive" value="In-Active">-->
                                            <!--        <label class="control-label">In-Active</label>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                   <select class="form-control mt-multiselect btn btn-default" id="status_active" name="account_status" required>
                                                        <option>Select Category</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Follow up">Follow up</option>
                                                        <option value="For demo">For demo</option>
                                                        <option value="In active">In active</option>
                                                        <option value="Leads">Leads</option>
                                                        <option value="Prospects">Prospects</option>
                                                        <option value="Service Proposal">Service Proposal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email<i style="font-size:12px;color:orange;">&nbsp;(0ne email only!!)</i></label>
                                                    <input class="form-control" type="email" id="account_email" name="account_email" required />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                   <input class="form-control" id="account_phone" name="account_phone">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input class="form-control" id="account_fax" name="account_fax">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <input class="form-control" type="text" id="account_address" name="account_address" required />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Website</label>
                                                    <input class="form-control" type="text" id="account_website" name="account_website">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Facebook</label>
                                                   <input class="form-control" id="account_facebook" name="account_facebook">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
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
                                                    <label class="control-label">Certification/s</label>
                                                   <input class="form-control" id="account_certification" name="account_certification">
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                <button type="submit" class="btn btn-success ladda-button" name="btnacct_submit" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                            </div>
                                        </div>
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
                    <form method="post" action="Customer_relationship_multi_upload.php" enctype="multipart/form-data" class="modalForm modalSave">
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
                                            <input class="form-control-plaintext mb-2" type="file" name="file" accept=".csv">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btn_Multi_acct_submit" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src=".assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
    // Marvin's script starts here
        $(document).ready(function() {
            
            var dataTable1, dataTable2;

            function initializeDataTable(selector) {
                return $(selector).dataTable({
                    // Your DataTable initialization options here
                    language: {
                        aria: {
                            sortAscending: ": activate to sort column ascending",
                            sortDescending: ": activate to sort column descending"
                        },
                        emptyTable: "No data available in table",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries found",
                        infoFiltered: "(filtered1 from _MAX_ total entries)",
                        lengthMenu: "_MENU_ entries",
                        search: "Search:",
                        zeroRecords: "No matching records found"
                    },
                    buttons: [
                        { extend: 'print', className: 'btn default' },
                        { extend: 'pdf', className: 'btn red' },
                        { extend: 'csv', className: 'btn green' }
                    ],
                   
                    lengthMenu: [
                        [5, 10, 15, 20, -1],
                        [5, 10, 15, 20, "All"]
                    ],
                    pageLength: 20,
                    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells.
                    // The default datatable layout setup uses scrollable div(table-scrollable) with overflow:auto
                    // to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                    // So when dropdowns used the scrollable div should be removed. 
                    // "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    // ... additional DataTable initialization options ...
                });
            }

            load_data();
            
            function load_data() {
                if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                    $('#dataTable_1').DataTable().destroy();
                }
                $.ajax({
                    url: "custom_crm/fetch_contacts.php",
                    method: "POST",
                    data: { query: true },
                    success: function(data) {
                        $('#dataTable_1 tbody').html(data);
                        initializeDataTable('#dataTable_1');
                        initializeDataTable('#dataTable_3');
                        $('#site_activities_loading, #spinner-text').addClass('d-none');
                        $('.portlet-body').addClass('margin-5');
                        $('#search, #dataTable_1, #filter-side').removeClass('d-none');
                    }
                });
            }
            
            $(document).on('click', '.manageContact', function() {
                var contact_id = $(this).data('id'); // Use .data() to retrieve the data-id attribute
                // alert(contact_id)
                $.post({
                    url: 'custom_crm/fetch_contacts.php',
                    data: {
                        get_notification_count: true,
                        contact_id: contact_id
                    },
                    success: function(response) {
                        $('#notifCount' + contact_id).html(response);
                    }
                });
            });

            $(document).on('click', '.addRemarks', function(e) {
                e.preventDefault()
                $('#add_remarks').modal('show'); 
                var contact_id = $(this).data('id');
                $('#contactid').val(contact_id)
                $.post({
                    url: 'custom_crm/fetch_contacts.php',
                    data: {
                        get_crm_remarks: true,
                        contact_id: contact_id
                    },
                    success: function(response) {
                        $('#chatThreads').html(response);
                    }
                })
            })
            
           $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                var searchVal = $('#searchValue').val();
                
                if ($.fn.DataTable.isDataTable('#dataTable_1')) {
                    $('#dataTable_1').DataTable().destroy();
                    $('#dataTable_1').addClass('d-none');
                }
                if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                    $('#dataTable_2').DataTable().destroy();
                    $('#dataTable_2').addClass('d-none');
                }
                $('#site_activities_loading, #spinner-text').removeClass('d-none');
                $.post({
                    url: "custom_crm/fetch_contacts.php",
                    data: {
                        search_contact: true,
                        searchVal: searchVal,
                    },
                    success: function(response) {
                        $('#dataTable_2').removeClass('d-none');
                        $('#dataTable_2 tbody').html(response);
                        initializeDataTable('#dataTable_2');
                        $('#site_activities_loading, #spinner-text').addClass('d-none');
                    }
                });
            });

            
            $('#sendMessage').on('click', function() {
                var contactid = $('#contactid').val();
                var message = $('#messageContent').val()
                
                console.log(contactid)
                console.log(message)
                
                
            })
            
            $('.replyMessage').on('click', function(e) {
                e.preventDefault()
                var contactid = $()
                var parentid = $()
                var message = $()
                var action = $()
                
                $.post({
                    url: '',
                    data: {
                        add_remarks: true,
                        contactid: contactid,
                        parentid: parentid,
                        message: message,
                        action:action
                    },
                    success:function(response) {
                        alert('Message send');
                    }
                })
            })
            
            function destroyDataTable(dataTable) {
                if (dataTable) {
                    dataTable.destroy();
                }
            }
            
            $('#filter-via-date').on('submit', function(e) {
                e.preventDefault();
                var from = $('#date-from').val();
                var to = $('#date-to').val();
                console.log(from)
                console.log(to)
                if (!from.length || !to.length) {
                    alert('Date input are required');
                }
                if ($.fn.DataTable.isDataTable('#dataTable_1')) {
                    $('#dataTable_1').DataTable().destroy();
                    $('#dataTable_1').addClass('d-none');
                }
                if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                    $('#dataTable_2').DataTable().destroy();
                    $('#dataTable_2').addClass('d-none');
                }
                $('#site_activities_loading, #spinner-text').removeClass('d-none');
                $.post({
                    url: "custom_crm/fetch_contacts.php",
                    data: {
                        filter_range: true,
                        from: from,
                        to: to
                    },
                    success: function(response) {
                        
                        $('#dataTable_2').removeClass('d-none');
                        $('#dataTable_2 tbody').html(response);
                        initializeDataTable('#dataTable_2');
                        $('#site_activities_loading, #spinner-text').addClass('d-none');
                    }
                });
            });
            
            $('.filter_value').on('click', function(e) {
                var isChecked = $(this).prop('checked');
                if(isChecked == true) {
                    var column = $(this).attr('data-value');
                    var value = $(this).val();
                    
                    if ($.fn.DataTable.isDataTable('#dataTable_1')) {
                        $('#dataTable_1').DataTable().destroy();
                        $('#dataTable_1').addClass('d-none');
                    }
                    if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                        $('#dataTable_2').DataTable().destroy();
                        $('#dataTable_2').addClass('d-none');
                    }
                    $('#site_activities_loading, #spinner-text').removeClass('d-none');
                
                    $.post({
                        url: "custom_crm/fetch_contacts.php",
                        data: {
                            filter_value: true,
                            column: column,
                            value: value
                        },
                        success: function(response) {
                            // $('#dataTable_1 tbody').html(response);
                        $('#dataTable_1').removeClass('d-none');
                        $('#dataTable_1 tbody').html(response);
                        initializeDataTable('#dataTable_1');
                        
                        $('#site_activities_loading, #spinner-text').addClass('d-none');
                            console.log(response)
                            $(this).prop('checked', false);
                        }
                    })
                }
            })
            
            $(document).on('click', '.contactHistory', function(e) {
                e.preventDefault()
                $('#history_modal').modal('show'); 
                const contact_id = $(this).attr('data-id');
                if ($.fn.DataTable.isDataTable('#dataTable_3')) {
                    $('#dataTable_3').DataTable().destroy();
                }
                console.log(contact_id)
                $.post({
                    url: 'custom_crm/fetch_contacts.php',
                    data: {
                        get_history_data: true,
                        contact_id: contact_id
                    },
                    success: function(response) {
                        $('#contactHistoryDetails').html(response);
                        initializeDataTable('#dataTable_3');
                    }
                })
            })
            
            $('.filter_value').on('change', function() {
                // Uncheck all other checkboxes with the same class
                $('.filter_value').not(this).prop('checked', false);
            });
            
            
            // Set Aside function script
            // $('#searchContacts').on('submit', function(e) {
            //     e.preventDefault();
            //     var searchVal = $('#search-queued').val();
            //     if(!searchVal.length) {
            //         alert('Search input is required');
            //     }
            //     $.post({
            //         url: "custom_crm/fetch_contacts.php",
            //         data: {
            //             search_contact: searchVal
            //         },
            //         success: function(response) {
            //             $('#search-result').html(response);
            //         }
            //     })
            // })
            
            
            
            // Summernote
            $("#your_summernote").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
            
            // end Marvin's script
            
            
            // Emjay script starts here
            fancyBoxes();
            $('#save_video').click(function(){
                
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "supplier";
                var user_id = $('#switch_user_id').val();
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
                 
    			 $.ajax({
    				method:"POST",
    				url:"controller.php",
    				data:fd,
    				processData: false, 
                    contentType: false,  
                    timeout: 6000000,
    				success:function(data) {
    					console.log('done : ' + data);
    					if(data == 1){
    					    window.location.reload();
    					}
    					else{
    					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
    					}
    				}
			    });
			}); // Emjay script ends here 
        });
    </script>
    <script>
    // $('#search_text').keyup(function() {
    //     var search = $(this).val();
    //     if (search !== '') {
    //         load_data(search);
    //     } else {
    //         load_data();
    //     }
    // });
        // $(document).ready(function(){
        //     $('.data_search').keyup(function(){
        // 		search_table($(this).val());
        // 	});
        // 	function search_table(value){
        // 		$('#table_data_tr tr').each(function(){
        // 			var found = 'false';
        // 			$(this).each(function(){
        // 				if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
        // 				{
        // 					found = 'true';
        // 				}
        // 			});
        // 			if(found =='true')
        // 			{
        // 				$(this).show();
        // 			}
        // 			else{
        // 				$(this).hide();
        // 			}
        // 		});
        // 	}
        // });
        // $(document).ready(function() {
        //         $("#your_summernote").summernote({
        //             placeholder:'',
        //             height: 400
        //         });
        //         $('.dropdown-toggle').dropdown();
        //     });
           // View Contact
        //  $(".btnViewContact").click(function() {
        //         var id = $(this).data("id");
        //         $.ajax({    
        //             type: "GET",
        //             url: "custom_crm/fetch-colab.php?modalView="+id,
        //             dataType: "html",
        //             success: function(data){
        //                 $("#modalGetContact .modal-body").html(data);
                       
        //             }
        //         });
        //     });
        //getDat CRM
        // $(document).ready(function(){
        //     $("#data_search").keyup(function(){
        //         var search = $(this).val();
        //         if(search != ""){
        //             $.ajax({
        //                 url:'custom_crm/fetch_crm_data.php',
        //                 method: 'POST',
        //                 data: {search:search},
        //                 success:function(data){
        //                     $("#searched_data").html(data);
        //                 }
        //             });
        //         }else{
        //             $("#searched_data").css("display","none");
        //         }
        //     });
        //   getData('getCRM');
        // });
        // getData();
        // function getData(key) {
        //     $.ajax({
        //       url:'custom_crm/fetch_crm_data.php',
        //       method: 'POST',
        //       dataType: 'text',
        //       data: {
        //           key: key
        //       }, success: function (response) {
        //           if (key == 'getCRM') {
        //               $('#dataTable_1 tbody').append(response);
        //               initializeDataTable(); // Reinitialize DataTable after loading data
        //               $('#spinner, #spinner-text').addClass('d-none');
        //               $('.portlet-body').addClass('margin-5');
        //               $('#search, #dataTable_1').removeClass('d-none');
        //           }
                      
        //       }
        //     });
        // }
    //--------------
   
    </script>
    <style>
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
        </style>
    </body>
</html>