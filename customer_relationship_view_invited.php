
<?php 
error_reporting(0);
    $title = "Customer Relationship Management";
    
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Customer Relationship Management';
    $site = "Customer Relationship Management";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php  ?>
                        
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-tabdrop tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Customer Relationship Management</span>
                                                     
                                                </div>
                                                 <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#details" data-toggle="tab">Details</a>
                                                    </li> 
                                                    <li>
                                                        <a href="#products" data-toggle="tab">Products and Services</a>
                                                    </li>
                                                     <li>
                                                        <a href="#contacts" data-toggle="tab">Contacts</a>
                                                    </li>
                                                     <li class="hide">
                                                        <a href="#tasks" data-toggle="tab">Tasks</a>
                                                    </li>
                                                     <li class="hide">
                                                        <a href="#email" data-toggle="tab">Email</a>
                                                    </li>
                                                     <li class="hide">
                                                        <a href="#notes" data-toggle="tab">Notes</a>
                                                    </li>
                                                     <li class="hide">
                                                        <a href="#references" data-toggle="tab">References</a>
                                                    </li>
                                                </ul>
                                                
                                            </div>
                                              
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <?php   
                                                    // for display country
                                                    $querycountry = "SELECT * FROM countries order by name ASC";
                                                    $resultcountry = mysqli_query($conn, $querycountry);
                                                                        
                                                    // for display details
                                                    $i=1;
                                                    $a=1;
                                                    $b=1;
                                                    $c=1;
                                                    $d=1;
                                                    $e=1;
                                                    $z=1;
                                                    $users = $_COOKIE['ID'];
                                                    $getids = $_GET['view_id'];
                                                    $query = "SELECT * FROM tbl_Customer_Relationship left join tbl_hr_employee on ID = contact_name  where  crm_id = '$getids' ";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    { ?>
                                                        
                                                    <!--start-->
                                                   <div class="tab-pane active" id="details">
                                                       <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                       <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Account Name<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['userID']){ echo $row['crm_id'];}else{ echo '';} ?>" required> 
                                                                    <input type="" class="form-control" name="account_name" value="<?php echo $row['account_name']; ?>" readonly> 
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Parent Account<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>    
                                                                    <input type="" class="form-control" name="parent_account" value="<?php echo $row['parent_account']; ?>" readonly> 
                                                                </div>
                                                             </div> 
                                                       </div>
                                                       <br> 
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="" class="form-control" name="account_address" value="<?php echo $row['account_address']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <select class="form-control" name="account_country" disabled>
                                                                        <option value="0">---Select---</option>
                                                                        
                                                                        <?php 
                                                                         while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                         { ?>
                                                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['account_country']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br> 
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Email</strong></label>
                                                                    <input type="" class="form-control" name="account_email" value="<?php echo $row['account_email']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Phone</strong></label>
                                                                    <input type="" class="form-control" name="account_phone" value="<?php echo $row['account_phone']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Fax</strong></label>
                                                                    <input type="" class="form-control" name="account_fax" value="<?php echo $row['account_fax']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Website</strong></label>
                                                                    <input type="" class="form-control" name="contact_website" value="<?php echo $row['contact_website']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Facebook</strong></label>
                                                                    <input type="" class="form-control" name="contact_facebook" value="<?php echo $row['contact_facebook']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Twitter</strong></label>
                                                                    <input type="" class="form-control" name="contact_twitter" value="<?php echo $row['contact_twitter']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>LinkedIn</strong></label>
                                                                    <input type="" class="form-control" name="contact_linkedin" value="<?php echo $row['contact_linkedin']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Interlink</strong></label>
                                                                    <input type="" class="form-control" name="contact_interlink" value="<?php echo $row['contact_interlink']; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <div class="form-control-plaintext form-check-inline">
                                                                    <label class="control-label">Status</label>
                                                                    <br>
                                                                    <input type="radio" class="form-check-input" name="account_status" id="status_active" value="Active" <?php  if($row['account_status']=='Active'){echo 'checked';}else{echo '';} ?> readonly>
                                                                    <label class="control-label" >Active</label>
                                                                   &nbsp;
                                                                    <input type="radio" class="form-check-input" name="account_status" id="status_inactive" value="In-Active" <?php  if($row['account_status']=='In-Active'){echo 'checked';}else{echo '';} ?> readonly>
                                                                    <label class="control-label">In-Active</label>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row hide">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <input type="submit" class="btn btn-primary" name="update_details_account" value="Save Changes" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <!--end-->
                                                      <!--Start-->
                                                         <div class="tab-pane" id="products">
                                                             <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Products:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                        <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['userID']){ echo $row['crm_id'];}else{ echo '';} ?>" required> 
                                                                        <input type="" class="form-control" name="account_product" value="<?php echo $row['account_product']; ?>" readonly>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Services:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                        <input type="" class="form-control" name="account_service" value="<?php echo $row['account_service']; ?>" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                            <label class="control-label">Industry</label>
                                                                            <select class="form-control" id="account_industry" name="account_industry" disabled>
                                                                                <option value="none" <?php if($row['account_industry']=='none'){echo 'selected';}else{echo '';} ?>>Select Industry</option>
                                                                                <option value="510k" <?php if($row['account_industry']=='510k'){echo 'selected';}else{echo '';} ?>>510k</option>
                                                                                <option value="Accounting" <?php if($row['account_industry']=='Accounting'){echo 'selected';}else{echo '';} ?>>Accounting</option>
                                                                                <option value="Acidified Foods" <?php if($row['account_industry']=='Acidified Foods'){echo 'selected';}else{echo '';} ?>>Acidified Foods</option>
                                                                                <option value="Agricultural" <?php if($row['account_industry']=='Agricultural'){echo 'selected';}else{echo '';} ?>> Agricultural</option>
                                                                                <option value="Animal Feed" <?php if($row['account_industry']=='Animal Feed'){echo 'selected';}else{echo '';} ?>>Animal Feed</option>
                                                                                <option value="Aquaculture" <?php if($row['account_industry']=='Aquaculture'){echo 'selected';}else{echo '';} ?>>Aquaculture</option>
                                                                                <option value="Baked Products" <?php if($row['account_industry']=='Baked Products'){echo 'selected';}else{echo '';} ?>> Baked Products</option>
                                                                                <option value="Beef" <?php if($row['account_industry']=='Beef'){echo 'selected';}else{echo '';} ?>>Beef</option>
                                                                                <option value="Beverage" <?php if($row['account_industry']=='Beverage'){echo 'selected';}else{echo '';} ?>>Beverage</option>
                                                                                <option value="Candies" <?php if($row['account_industry']=='Candies'){echo 'selected';}else{echo '';} ?>>Candies</option>
                                                                                <option value="Cannabis" <?php if($row['account_industry']=='Cannabis'){echo 'selected';}else{echo '';} ?>>Cannabis</option>
                                                                                <option value="Catering" <?php if($row['account_industry']=='Catering'){echo 'selected';}else{echo '';} ?>>Catering</option>
                                                                                <option value="Cereals" <?php if($row['account_industry']=='Cereals'){echo 'selected';}else{echo '';} ?>>Cereals</option>
                                                                                <option value="Chemicals" <?php if($row['account_industry']=='Chemicals'){echo 'selected';}else{echo '';} ?>>Chemicals</option>
                                                                                <option value="Chocolate" <?php if($row['account_industry']=='Chocolate'){echo 'selected';}else{echo '';} ?>>Chocolate</option>
                                                                                <option value="Coffee"  <?php if($row['account_industry']=='Coffee'){echo 'selected';}else{echo '';} ?>>Coffee</option>
                                                                                <option value="Confectionery" <?php if($row['account_industry']=='Confectionery'){echo 'selected';}else{echo '';} ?>>Confectionery</option>
                                                                                <option value="CPG/FMCG" <?php if($row['account_industry']=='CPG/FMCG'){echo 'selected';}else{echo '';} ?>>CPG/FMCG</option>
                                                                                <option value="Chicken Products" <?php if($row['account_industry']=='Chicken Products'){echo 'selected';}else{echo '';} ?>>Chicken Products</option>
                                                                                <option value="Cosmetics" <?php if($row['account_industry']=='Cosmetics'){echo 'selected';}else{echo '';} ?>>Cosmetics</option>
                                                                                <option value="Dairy" <?php if($row['account_industry']=='Dairy'){echo 'selected';}else{echo '';} ?>>Dairy</option>
                                                                                <option value="Deli" <?php if($row['account_industry']=='Deli'){echo 'selected';}else{echo '';} ?>>Deli</option>
                                                                                <option value="Dietary Supplement" <?php if($row['account_industry']=='Dietary Supplement'){echo 'selected';}else{echo '';} ?>>Dietary Supplement</option>
                                                                                <option value="Dips" <?php if($row['account_industry']=='Dips'){echo 'selected';}else{echo '';} ?>>Dips</option>
                                                                                <option value="Distribution" <?php if($row['account_industry']=='Distribution'){echo 'selected';}else{echo '';} ?>>Distribution</option>
                                                                                <option value="Equipment" <?php if($row['account_industry']=='Equipment'){echo 'selected';}else{echo '';} ?>>Equipment</option>
                                                                                <option value="Fats" <?php if($row['account_industry']=='Fats'){echo 'selected';}else{echo '';} ?>>Fats</option>
                                                                                <option value="Finance" <?php if($row['account_industry']=='Finance'){echo 'selected';}else{echo '';} ?>>Finance</option>
                                                                                <option value="Fishery" <?php if($row['account_industry']=='Fishery'){echo 'selected';}else{echo '';} ?>>Fishery</option>
                                                                                <option value="Flavoring" <?php if($row['account_industry']=='Flavoring'){echo 'selected';}else{echo '';} ?>>Flavoring</option>
                                                                                <option value="Food" <?php if($row['account_industry']=='Food'){echo 'selected';}else{echo '';} ?>>Food</option>
                                                                                <option value="Functional Foods" <?php if($row['account_industry']=='Functional Foods'){echo 'selected';}else{echo '';} ?>>Functional Foods</option>
                                                                                <option value="Fruits" <?php if($row['account_industry']=='Fruits'){echo 'selected';}else{echo '';} ?>>Fruits</option>
                                                                                <option value="Grains" <?php if($row['account_industry']=='Grains'){echo 'selected';}else{echo '';} ?>>Grains</option>
                                                                                <option value="Gravies" <?php if($row['account_industry']=='Gravies'){echo 'selected';}else{echo '';} ?>>Gravies</option>
                                                                                <option value="Heat to Eat" <?php if($row['account_industry']=='Heat to Eat'){echo 'selected';}else{echo '';} ?>>Heat to Eat</option>
                                                                                <option value="Herbal / Herbs" <?php if($row['account_industry']=='Herbal / Herbs'){echo 'selected';}else{echo '';} ?>>Herbal / Herbs</option>
                                                                                <option value="Honey" <?php if($row['account_industry']=='Honey'){echo 'selected';}else{echo '';} ?>>Honey</option>
                                                                                <option value="Ingredients" <?php if($row['account_industry']=='Ingredients'){echo 'selected';}else{echo '';} ?>>Ingredients</option>
                                                                                <option value="Juice" <?php if($row['account_industry']=='Juice'){echo 'selected';}else{echo '';} ?>>Juice</option>
                                                                                <option value="Kitchen" <?php if($row['account_industry']=='Kitchen'){echo 'selected';}else{echo '';} ?>>Kitchen</option>
                                                                                <option value="Lamb" <?php if($row['account_industry']=='Lamb'){echo 'selected';}else{echo '';} ?>>Lamb</option>
                                                                                <option value="Legal" <?php if($row['account_industry']=='Legal'){echo 'selected';}else{echo '';} ?>>Legal</option>
                                                                                <option value="Manufacturing" <?php if($row['account_industry']=='Manufacturing'){echo 'selected';}else{echo '';} ?>>Manufacturing</option>
                                                                                <option value="Medical Device" <?php if($row['account_industry']=='Medical Device'){echo 'selected';}else{echo '';} ?>>Medical Device</option>
                                                                                <option value="Medical Food" <?php if($row['account_industry']=='Medical Food'){echo 'selected';}else{echo '';} ?>>Medical Food</option>
                                                                                <option value="Nutraceuticals" <?php if($row['account_industry']=='Nutraceuticals'){echo 'selected';}else{echo '';} ?>>Nutraceuticals</option>
                                                                                <option value="Nuts" <?php if($row['account_industry']=='Nuts'){echo 'selected';}else{echo '';} ?>>Nuts</option>
                                                                                <option value="Oils" <?php if($row['account_industry']=='Oils'){echo 'selected';}else{echo '';} ?>>Oils</option>
                                                                                <option value="Organic" <?php if($row['account_industry']=='Organic'){echo 'selected';}else{echo '';} ?>>Organic</option>
                                                                                <option value="Packaging" <?php if($row['account_industry']=='Packaging'){echo 'selected';}else{echo '';} ?>>Packaging</option>
                                                                                <option value="Pharmaceutical" <?php if($row['account_industry']=='Pharmaceutical'){echo 'selected';}else{echo '';} ?>>Pharmaceutical</option>
                                                                                <option value="Pasta" <?php if($row['account_industry']=='Pasta'){echo 'selected';}else{echo '';} ?>>Pasta</option>
                                                                                <option value="Pet Food" <?php if($row['account_industry']=='Pet Food'){echo 'selected';}else{echo '';} ?>>Pet Food</option>
                                                                                <option value="Produce" <?php if($row['account_industry']=='Produce'){echo 'selected';}else{echo '';} ?>>Produce</option>
                                                                                <option value="PMTA" <?php if($row['account_industry']=='PMTA'){echo 'selected';}else{echo '';} ?>>PMTA</option>
                                                                                <option value="Poultry" <?php if($row['account_industry']=='Poultry'){echo 'selected';}else{echo '';} ?>>Poultry</option>
                                                                                <option value="Proteins" <?php if($row['account_industry']=='Proteins'){echo 'selected';}else{echo '';} ?>>Proteins</option>
                                                                                <option value="Raw Materials" <?php if($row['account_industry']=='Raw Materials'){echo 'selected';}else{echo '';} ?>>Raw Materials</option>
                                                                                <option value="Ready-to-Cook" <?php if($row['account_industry']=='Ready-to-Cook'){echo 'selected';}else{echo '';} ?>>Ready-to-Cook</option>
                                                                                <option value="Ready-to-Eat" <?php if($row['account_industry']=='Ready-to-Eat'){echo 'selected';}else{echo '';} ?>>Ready-to-Eat</option>
                                                                                <option value="Reduce Oxygen" <?php if($row['account_industry']=='Reduce Oxygen'){echo 'selected';}else{echo '';} ?>>Reduce Oxygen</option>
                                                                                <option value="Restaurant" <?php if($row['account_industry']=='Restaurant'){echo 'selected';}else{echo '';} ?>>Restaurant</option>
                                                                                <option value="Sauces" <?php if($row['account_industry']=='Sauces'){echo 'selected';}else{echo '';} ?>>Sauces</option>
                                                                                <option value="Sausage" <?php if($row['account_industry']=='Sausage'){echo 'selected';}else{echo '';} ?>>Sausage</option>
                                                                                <option value="Seafood" <?php if($row['account_industry']=='Seafood'){echo 'selected';}else{echo '';} ?>>Seafood</option>
                                                                                <option value="Seeds" <?php if($row['account_industry']=='Seeds'){echo 'selected';}else{echo '';} ?>>Seeds</option>
                                                                                <option value="Soups" <?php if($row['account_industry']=='Soups'){echo 'selected';}else{echo '';} ?>>Soups</option>
                                                                                <option value="Spices" <?php if($row['account_industry']=='Spices'){echo 'selected';}else{echo '';} ?>>Spices</option>
                                                                                <option value="Sushi" <?php if($row['account_industry']=='Sushi'){echo 'selected';}else{echo '';} ?>>Sushi</option>
                                                                                <option value="Systems" <?php if($row['account_industry']=='Systems'){echo 'selected';}else{echo '';} ?>>Systems</option>
                                                                                <option value="Tobacco" <?php if($row['account_industry']=='Tobacco'){echo 'selected';}else{echo '';} ?>>Tobacco</option>
                                                                                <option value="Transportation" <?php if($row['account_industry']=='Transportation'){echo 'selected';}else{echo '';} ?>>Transportation</option>
                                                                                <option value="Utensils" <?php if($row['account_industry']=='Utensils'){echo 'selected';}else{echo '';} ?>>Utensils</option>
                                                                                <option value="Vacuum Packaging" <?php if($row['account_industry']=='Vacuum Packaging'){echo 'selected';}else{echo '';} ?>>Vacuum Packaging</option>
                                                                                <option value="Veal" <?php if($row['account_industry']=='Veal'){echo 'selected';}else{echo '';} ?>>Veal</option>
                                                                                <option value="Vegetables" <?php if($row['account_industry']=='Vegetables'){echo 'selected';}else{echo '';} ?>>Vegetables</option>
                                                                                <option value="Others" <?php if($row['account_industry']=='Others'){echo 'selected';}else{echo '';} ?>>Others</option>
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Category</strong></label>
                                                                           <select class="form-control" id="account_category" name="account_category" disabled>
                                                                                <option value="none" <?php if($row['account_category']=='none'){echo 'selected';}else{echo '';} ?>>Select Category</option>
                                                                                <option value="Prospect" <?php if($row['account_category']=='Prospect'){echo 'selected';}else{echo '';} ?>>Prospect</option>
                                                                                <option value="Contact" <?php if($row['account_category']=='Contact'){echo 'selected';}else{echo '';} ?>>Contact</option>
                                                                                <option value="Presentation" <?php if($row['account_category']=='Presentation'){echo 'selected';}else{echo '';} ?>>Presentation</option>
                                                                                <option value="Follow Up" <?php if($row['account_category']=='Follow Up'){echo 'selected';}else{echo '';} ?>>Follow Up</option>
                                                                                <option value="Close the lead" <?php if($row['account_category']=='Close the lead'){echo 'selected';}else{echo '';} ?>>Close the lead</option>
                                                                            </select>
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Certification/s</strong></label>
                                                                        <input type="" class="form-control" name="account_certification" value="<?php echo $row['account_certification']; ?>" readonly>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <hr>
                                                                <div class="row hide">
                                                                    <div class="form-group">
                                                                        <div class="col-md-4">
                                                                            <input type="submit" class="btn btn-primary" name="update_details_contact" value="Save Changes" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                         <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="contacts">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Name</th>
                                                                                <th>Title</th>
                                                                                <th>Report to</th>
                                                                                <th>Address</th>
                                                                                <th>Email</th>
                                                                                <th>Phone</th>
                                                                                <th>Fax</th>
                                                                                <th class="hide"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                                                <td><?php echo $row['contact_title']; ?></td>
                                                                                <td><?php echo $row['contact_report']; ?></td>
                                                                                <td><?php echo $row['contact_address']; ?></td>
                                                                                <td><?php echo $row['contact_email']; ?></td>
                                                                                <td><?php echo $row['contact_phone']; ?></td>
                                                                                <td><?php echo $row['contact_fax']; ?></td>
                                                                                <td class="hide">
                                                                                    <a class="btn blue btn-outline btnViewContact " data-toggle="modal" href="#modalGetContact" data-id="<?php echo $row["crm_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="tasks">
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    
                                                                    <a data-toggle="modal" href="#modalNewTask" class="btn btn-primary">Add Task</a>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Current Task</th>
                                                                                <th>Assigned to</th>
                                                                                <th>Date Added</th>
                                                                                <th>Deadline</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Task left join tbl_hr_employee on ID = Assigned_to where  user_cookies = '$users' ";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowt = mysqli_fetch_array($result))
                                                                            {
                                                                            $dateadded = date_create($rowt['Task_added']);
                                                                            $deadline = date_create($rowt['Deadline']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $z++; ?></td>
                                                                                <td><?php echo $rowt['assign_task']; ?></td>
                                                                                <td><?php echo $rowt['first_name']; ?> <?php echo $rowt['last_name']; ?></td>
                                                                                <td><?php echo date_format($dateadded,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($deadline,"Y/m/d"); ?></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Completed Task</th>
                                                                                <th>Assigned to</th>
                                                                                <th>Date Added</th>
                                                                                <th>Date Completed</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="email">
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#composeMail" class="btn btn-primary"> Compose</a>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Recipient</th>
                                                                                <th>Subject</th>
                                                                                <th>Message</th>
                                                                                <th>Date</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Mailing where  user_cookies = '$users' ";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowm = mysqli_fetch_array($result))
                                                                            {
                                                                            $date_mail = date_create($rowm['mail_date']); ?>
                                                                            <tr>
                                                                                <td><?php echo $b++; ?></td>
                                                                                <td><?php echo $rowm['Recipients']; ?></td>
                                                                                <td><?php echo $rowm['Subject']; ?></td>
                                                                                <td><?php echo $rowm['Message_body']; ?></td>
                                                                                <td><?php echo date_format($date_mail,"Y/m/d"); ?></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane " id="notes">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#addNotes" class="btn btn-primary"> add Notes</a>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Title</th>
                                                                                <th>Notes</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Notes where  user_cookies = '$users' ";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rown = mysqli_fetch_array($result))
                                                                            {?>
                                                                            <tr>
                                                                                <td><?php echo $c++; ?></td>
                                                                                <td><?php echo $rown['Title']; ?></td>
                                                                                <td><?php echo $rown['Notes']; ?></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="references">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#addReference" class="btn btn-primary"> add References</a>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Title</th>
                                                                                <th>Description</th>
                                                                                <th>Date Added</th>
                                                                                <th>Date End</th>
                                                                                <th>Documents</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_References where  user_cookies = '$users' ";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowf = mysqli_fetch_array($result))
                                                                            {
                                                                            $dateadded = date_create($rowf['Date_Added']);
                                                                            $dateend = date_create($rowf['Date_End']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $d++; ?></td>
                                                                                <td><?php echo $rowf['Title']; ?></td>
                                                                                <td><?php echo $rowf['Description']; ?></td>
                                                                                <td><?php echo date_format($dateadded,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($dateend,"Y/m/d"); ?></td>
                                                                                <td><a href="Customer_Relationship_Folder/customer_relationship_download.php?pathDoc=<?php echo $rowf['reference_id']; ?>"><?php echo $rowf['Documents']; ?></a></td>
                                                                                <td></td>
                                                                            </tr>
                                                                             <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->     
                                                    <?php } ?>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
           <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNewTask" tabindex="-1" role="basic" aria-hidden="true">
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
                                                        <label class="control-label">Task Name</label>
                                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                                        <?php
                                                           // for display country
                                                            // where user_id = $trap_user
                                                            $trap_user = $_COOKIE['ID'];
                                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                 { ?>
                                                        <input class="form-control" type="hidden" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                                        <?php } ?>
                                                        <input class="form-control" type="text" name="assign_task" id="assign_task" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <div class="form-group">
                                                        <label class="control-label">Assign to</label>
                                                        <select class="form-control" id="Assigned_to" name="Assigned_to" required>
                                                            <option value="">---Select---</option>
                                                         <?php
                                                           // for display country
                                                            // where user_id = $trap_user
                                                            $trap_user = $_COOKIE['ID'];
                                                            $query = "SELECT * FROM tbl_hr_employee where user_id = '$trap_user' order by first_name ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            while($rowu = mysqli_fetch_array($result))
                                                                 { ?>
                                                                <option value="<?php echo $rowu['ID']; ?>"><?php echo utf8_encode($rowu['first_name']); ?>&nbsp;<?php echo utf8_encode($rowu['last_name']); ?></option>
                                                        <?php } ?>
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
                          <!--Mail box MODAL AREA-->
        <div class="modal fade" id="composeMail" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" style="width:100%;">
                <div class="modal-content">
                    <form action="customer_relationship_mailer.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Message</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>From</label>
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $trap_user = $_COOKIE['ID'];
                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                            $resultuser = mysqli_query($conn, $queryuser);
                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                 { ?>
                                        <input class="form-control" type="email" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6" >
                                        <label>To</label>
                                        <input class="form-control" type="email" name="Recipients" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Subject</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Subject" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Message</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Message_body" id="your_summernote" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnmail_submit" value="Send" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
         <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_details_contact2" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
           <!--Mail box MODAL AREA-->
        <div class="modal fade" id="addNotes" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Notes</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <input class="form-control" type="text" name="Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Notes</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <textarea class="form-control" type="text" name="Notes" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnnotes_submit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- References MODAL AREA-->
        <div class="modal fade" id="addReference" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Reference</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <input class="form-control" type="text" name="Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <textarea class="form-control" type="text" name="Description" required /></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date Added</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="date" name="Date_Added" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date End</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="date" name="Date_End" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Documents</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="file" name="Documents" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnreference_submit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
                   
                        <!-- / END MODAL AREA -->
          
        <?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      <script>
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
                    url: "Customer_Relationship_Folder/fetch-contact.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetContact .modal-body").html(data);
                       
                    }
                });
            });
        </script>
        
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
       <style>
       .hide{
           display:none;
       }
       .brandAv{
           height:300px;
           width:300px;
           position:relative;
           border-radius:50%;
           border:solid 3px #fff;
           background-color:#F6FBF4;
           background-size:100% 100%;
           margin:5px auto;
           overflow:hidden;
       }
       .uuploader{
           position:absolute;
           bottom:0;
           outline:none;
           color:transparent;
           width:100%;
           box-sizing:border-box;
           padding:15px 140px;
           cursor:pointer;
             transition: 0.5s;
         background:rgba(0,0,0,0.5);
         opacity:0;
       }
       .uuploader::-webkit-file-upload-button{
        visibility:hidden;
    }
    .uuploader::before{
    	content:'\f030';
    	font-family:fontAwesome;
    	font-size:20px;
        color:#fff;
        display:inline-block;
        text-align:center;
        float:center;
        -webkit-user-select:none;
        }
        /*.uuploader::after{*/
        /*     width:100%;*/
        /*   content:'Update';*/
        /*  font-family:'arial';*/
        /*   font-weight:bold;*/
        /*    color:#fff;*/
        /*    display:block;*/
        /*    top:30px;-->*/
        /*   font-size:12px;*/
        /*   position:abosolute;*/
        /*    text-align:center;*/
        /*}*/
        .uuploader:hover{
         opacity:1;
        }
       </style>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
    </body>
</html>