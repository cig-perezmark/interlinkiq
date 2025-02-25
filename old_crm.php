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
</style>


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Contacts Relationship Management - 
                                        <?php
                                            $array_optionPrivacy = explode(',', $current_userPrivacy);
                                            if($array_optionPrivacy[4]== 1){
                                                $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND privacy = 'public' OR user_id = '$current_userEmployerID'"  ; 
                                                $result = mysqli_query ($conn, $sql);
                                            }
                                            if($array_optionPrivacy[4]== 0){
                                                $user_id = $_COOKIE['ID'];
                                                $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND user_id = '$current_userEmployerID' " ; 
                                                $result = mysqli_query ($conn, $sql);
                                            }
                                            
                                            while ($row = mysqli_fetch_assoc($result)){?>   
                                                <a data-toggle="modal" data-target="#view_video" class="view_videos"  file_name="<?= $row['file_name'] ?>"><?= $row['file_title'] ?></a>
                                                <?= "/" ?>
                                        <?php } ?>
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" >Add New Contacts</a>
                                                   
                                                    <a data-toggle="modal" href="#modalMultiUpload" >Add Multiple Contacts</a>
                                                </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal"  href="#modal_video">Add Demo Video</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                     <!--<span class="loader"><span class="loader-inner"></span></span>-->
                                    <br>
                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
                                            <thead>
                                                <tr>
                                                    <th>Account Rep.</th>
                                                    <th>Date</th>
                                                    <th>Account Name</th>
                                                    <!--<th>Parent Account</th>-->
                                                    <th>Email</th>
                                                    <th>Contacts</th>
                                                    <th>Address</th>
                                                    <th>Uploaded by</th>
                                                    <th>Certification</th>
                                                    <th>Source</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID']; 
                                                $queries = "SELECT DISTINCT *,crm_id FROM tbl_Customer_Relationship left join tbl_user on ID = userID 
                                                left join tbl_hr_employee on tbl_hr_employee.ID = tbl_user.employee_id where user_ID = $current_userEmployerID || tbl_user.ID = $usersQuery order by crm_id DESC";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrm = mysqli_fetch_array($resultQuery)){ 
                                                $default_added = date_create($rowcrm['crm_date_added']);
                                                ?>
                                                <tr>
                                                    
                                                    <td><?php echo $rowcrm['account_rep'];  ?></td>
                                                    <td><?php echo date_format($default_added,"Y/m/d h:i:s"); ?></td>
                                                    <td><?php echo $rowcrm['account_name'];  ?></td>
                                                    <td>
                                                        <?php echo $rowcrm['account_email'];  ?>
                                                        <?php
                                                        $crm_ids_c = $rowcrm['crm_id'];
                                                        $query_c = "SELECT * FROM tbl_Customer_Relationship_More_Contacts where C_crm_ids = $crm_ids_c order by C_ids DESC";
                                                        $result_c = mysqli_query($conn, $query_c);
                                                                                    
                                                        while($row_c = mysqli_fetch_array($result_c))
                                                        {?>
                                                            <?php echo ','.$row_c['C_Email']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $rowcrm['account_phone'];  ?>
                                                        <?php
                                                        $crm_ids_c = $rowcrm['crm_id'];
                                                        $query_c = "SELECT * FROM tbl_Customer_Relationship_More_Contacts where C_crm_ids = $crm_ids_c order by C_ids DESC";
                                                        $result_c = mysqli_query($conn, $query_c);
                                                                                    
                                                        while($row_c = mysqli_fetch_array($result_c))
                                                        {?>
                                                            <?php echo ','.$row_c['C_Phone']; ?>
                                                            <?php echo ','.$row_c['C_Fax']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $rowcrm['account_address'];  ?></td>
                                                    <td>
                                                        <?php 
                                                            $current_task  = $rowcrm['userID'];
                                                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                                                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                echo $rowGEt['first_name'];
                                                                echo ' ';
                                                                echo $rowGEt['last_name'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $rowcrm['account_certification'];  ?></td>
                                                    <td><?php echo $rowcrm['Account_Source'];  ?></td>
                                                    <td><?php echo $rowcrm['account_category'];  ?></td>
                                                    <td >
                                                        <a href="customer_relationship_View.php?view_id=<?php echo $rowcrm['crm_id'];  ?>" class="btn blue btn-outline" >
                                                            View
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn green btn-outline btnViewContact " data-toggle="modal" href="#modalGetContact" data-id="<?php echo $rowcrm["crm_id"]; ?>" >
                                                                Share
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                               
                                            
                                             <?php
                                                $t = 1;
                                                $usersQuery = $_COOKIE['ID']; 
                                                $queriesuser = "SELECT * FROM tbl_user where ID = $usersQuery";
                                                $result = mysqli_query($conn, $queriesuser);
                                                while($rowuser = mysqli_fetch_array($result)){ 
                                                    $email = $rowuser['email'];
                                                }
                                                
                                                $queries = "SELECT * FROM tbl_Customer_Relationship_collaboration left join tbl_Customer_Relationship on crm_id = ccrm_id left join tbl_user on ID = userID  where invite_mail = '".$email."' ";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrm = mysqli_fetch_array($resultQuery)){ 
                                                ?>
                                                <tr>
                                                    <td><?php echo $rowcrm['account_rep'];  ?></td>
                                                    <td><?php echo $rowcrm['account_name'];  ?></td>
                                                    <td><?php echo $rowcrm['account_phone'];  ?></td>
                                                    <td><?php echo $rowcrm['account_address'];  ?></td>
                                                    <td></td>
                                                    <td><?php echo $rowcrm['account_certification'];  ?></td>
                                                    <td><?php echo $rowcrm['Account_Source'];  ?></td>
                                                    <td><?php echo $rowcrm['account_category'];  ?></td>
                                                    <td></td>
                                                    <td><?php echo $rowcrm['account_status'];  ?></td>
                                                    <td>
                                                        <a href="customer_relationship_view_invited.php?view_id=<?php echo $rowcrm['crm_id'];  ?>" class="btn blue btn-outline" >
                                                            View
                                                        </a>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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
                                                            <div class="col-md-4">
                                                                <div class="form-control-plaintext form-check-inline">
                                                                    <label class="control-label">Status</label>
                                                                    <br>
                                                                    <input type="radio" class="form-check-input" name="account_status" id="status_active" value="Active">
                                                                    <label class="control-label">Active</label>
                                                                   &nbsp;
                                                                    <input type="radio" class="form-check-input" name="account_status" id="status_inactive" value="In-Active">
                                                                    <label class="control-label">In-Active</label>
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
                                                                   <select class="form-control" id="account_country" name="account_country">
                                                                       <option value="">---Select---</option>
                                                                   <?php
                                                                   // for display country
                                                                    $querycountry = "SELECT * FROM countries order by name ASC";
                                                                    $resultcountry = mysqli_query($conn, $querycountry);
                                                                    while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                         { ?>
                                                                        <option value="<?php echo $rowcountry['id']; ?>"><?php echo utf8_encode($rowcountry['name']); ?></option>
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
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Industry</label>
                                                                    <select class="form-control" id="account_industry" name="account_industry">
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
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Certification/s</label>
                                                                   <input class="form-control" id="account_certification" name="account_certification">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Category</label>
                                                                   <select class="form-control" id="account_category" name="account_category">
                                                                        <option value="none">Select Category</option>
                                                                        <option value="Prospect">Prospect</option>
                                                                        <option value="Contact">Contact</option>
                                                                        <option value="Presentation">Presentation</option>
                                                                        <option value="Follow Up">Follow Up</option>
                                                                        <option value="Close the lead">Close the lead</option>
                                                                    </select>
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
                                            <!--<input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />-->
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
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function(){
               // Emjay script starts here
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "Customer_Relationship_Management";
                var user_id = <?= $current_userEmployerID ?>;
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
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
    			
    			$('.view_videos').click(function(){
    			    var file_name = $(this).attr('file_name')
    			    var vid = document.getElementById("myVideo");
    			    vid.src = "uploads/pages_demo/"+file_name;
    			});
    			
                // Emjay script ends here 
            });
        </script>
        
        <script>
        $(document).ready(function () {
            $('#tableData2').DataTable();
        });
        $(document).ready(function() {
                $("#your_summernote").summernote({
                    placeholder:'',
                    height: 400
                });
                $('.dropdown-toggle').dropdown();
            });
           // View Contact
         $(".btnViewContact").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-colab.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetContact .modal-body").html(data);
                       
                    }
                });
            });
             
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
