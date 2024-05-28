<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Contacts Relationship Management";
    $site = "contact_relationship_management";
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
                <div class="caption" style="width:50%;">
                    <!-- BEGIN HEADER SEARCH BOX -->
                    <div class="form-group" >
                        <input type="text" class="form-control data_search" placeholder="Search...">
                    </div>
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
                            <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163 OR $_COOKIE['ID']== 38): ?>
                                <li>
                                    <a data-toggle="modal"  href="<?php echo $FreeAccess == false ? '#modal_video':'#modalService'; ?>">Add Demo Video</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                     <div style="overflow: scroll;width:100%;height:750px;"> 
                    <table id="table_data_tr" class="table table-striped table-bordered table-hover dt-responsive" style="table-layout:; width: 100%">
                        	<thead>
                                <tr>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Account Rep.</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Date</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Account Name</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Email</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Contacts</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Address</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Uploaded by</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Certification</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Source</a></th>
                                    <th><a class="column_sort" id="id" data-order="desc" href="#">Status</a></th>
                                    <th></th>
                                </tr>
                            </thead>
                             <tbody>
                                 <!--<tr>-->
                                 <!--    <td>1</td>-->
                                 <!--    <td>a</td>-->
                                 <!--    <td>d</td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--</tr>-->
                                 <!--<tr>-->
                                 <!--    <td>2</td>-->
                                 <!--    <td>b</td>-->
                                 <!--    <td>e</td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--</tr>-->
                                 <!--<tr>-->
                                 <!--    <td>3</td>-->
                                 <!--    <td>c</td>-->
                                 <!--    <td>f</td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--    <td></td>-->
                                 <!--</tr>-->
                             </tbody>
                            <!--<tbody></tbody>-->
                    </table>
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
                                                    <option value="Customer">Customer</option>
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
<script src="customjs/sort_table.js"></script>
<script>
	
$(document).ready(function(){
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
	}); // Emjay script ends here 
});
            
</script>
        
<script>
$(document).ready(function(){
    $('.data_search').keyup(function(){
		search_table($(this).val());
	});
	function search_table(value){
		$('#table_data_tr tr').each(function(){
			var found = 'false';
			$(this).each(function(){
				if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
				{
					found = 'true';
				}
			});
			if(found =='true')
			{
				$(this).show();
			}
			else{
				$(this).hide();
			}
		});
	}
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
    
    
//getData CRM
$(document).ready(function(){
   getData('getCRM');
   //sort
$(document).on('click', '.column_sort', function(){  
       var column_name = $(this).attr("id");  
       var order = $(this).data("order");  
       var arrow = '';  
       //glyphicon glyphicon-arrow-up  
       //glyphicon glyphicon-arrow-down  
       if(order == 'desc')  
       {  
            arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-down"></span>';  
       }  
       else  
       {  
            arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-up"></span>';  
       }  
       $.ajax({  
            url:"sort.php",  
            method:"POST",  
            data:{column_name:column_name, order:order},  
            success:function(data)  
            {  
                 $('#employee_table').html(data);  
                 $('#'+column_name+'').append(arrow);  
            }  
       })  
  });
});

function getData(key) {
    $.ajax({
       url:'Customer_Relationship_Folder/fetch_crm_data2.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'getCRM')
               $('tbody').html(response);
       }
    });
}



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
thead th span.icon-arrow {
    display: inline-block;
    width: 1.3rem;
    height: 1.3rem;
    border-radius: 50%;
    border: 1.4px solid transparent;
    
    text-align: center;
    font-size: 1rem;
    
    margin-left: .5rem;
    transition: .2s ease-in-out;
}

thead th.active span.icon-arrow{
    border: 1.4px solid #6c00bd;
}

thead th.asc span.icon-arrow{
    transform: rotate(180deg);
}
thead th.active,tbody td.active {
    color: #6c00bd;
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