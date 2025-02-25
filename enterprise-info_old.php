<?php 
    $title = "Enterprise Information";
    $site = "enterprise-info";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php include_once ('enterprise-sidebar.php'); ?>
                        
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title  tabbable-tabdrop tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Enterprise Details 
                                                    <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                        <a data-toggle="modal" data-target="#modal_video">(Add Video)</a>
                                                    <?php endif; ?>
                                                    - 
                                                    <?php
                                                        $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND user_id = '$switch_user_id' OR page = '$site' AND user_id = '163' OR page = '$site' AND user_id = '$current_userEmployerID'  " ; 
                                                        $result = mysqli_query ($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)){?>   
                                                            <a class="view_videos" data-src="<?= $row['youtube_link'] ?>" data-fancybox><i class="fa fa-youtube"></i><?= $row['file_title'] ?></a>
                                                            <?= "/" ?>
                                                    <?php } ?>
                                                    </span>
                                                </div>
                                                 <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#EI" data-toggle="tab">Enterprise Information</a>
                                                    </li>
                                                    <li>
                                                        <a href="#ED" data-toggle="tab">Description</a>
                                                    </li>
                                                    <li>
                                                        <a href="#Logo" data-toggle="tab">Logo</a>
                                                    </li>
                                                    <li>
                                                        <a href="#BS" data-toggle="tab">Business Structure </a>
                                                    </li>
                                                    <li>
                                                        <a href="#PC" data-toggle="tab">Parent Company</a>
                                                    </li>
                                                     <li>
                                                        <a href="#CA" data-toggle="tab">Certification / Accreditation</a>
                                                    </li>
                                                     <li>
                                                        <a href="#Regulatory" data-toggle="tab">Regulatory</a>
                                                    </li>
                                                    <li>
                                                        <a href="#Rec" data-toggle="tab">Records </a>
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
                                                    // $users = $_COOKIE['ID'];
                                                    $users = $switch_user_id;
                                                    $query = "SELECT * FROM tblEnterpiseDetails";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                         $done = false;
                                                        if($users == $row['users_entities']){
                                                            $done = true;
                                                             break;
                                                        }
                                                                            
                                                    }
                                                    if($done == true){?>
                                                    <!--start-->
                                                   <div class="tab-pane active" id="EI">
                                                       <div class="row">
                                                           <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label class="control-label"><strong>Legal Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['enterp_id'];}else{ echo '';} ?>" required> 
                                                                    <input type="" class="form-control" name="LegalNameUpdate" id="LegalNameUpdate" value="<?php echo $row['businessname']; ?>" > 
                                                                </div>
                                                             </div>
                                                       </div>
                                                       <br>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <!--<input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>-->
                                                                    <select class="form-control" name="country" >
                                                                        <option value="0">---Select---</option>
                                                                        
                                                                        <?php 
                                                                         while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                         { ?>
                                                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['country']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                             <table class="table">
                                                                 <thead>
                                                                    <tr>
                                                                        <td>Bldg./Street</td>  
                                                                        <td>City</td>
                                                                        <td>State</td>
                                                                        <td>Zip Code</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input class=" form-control" name="Bldg" value="<?php echo $row['Bldg']; ?>" >
                                                                        </td>  
                                                                        <td>
                                                                            <input class="form-control" name="city" value="<?php echo $row['city']; ?>" >
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control" name="States" value="<?php echo $row['States']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input class=" form-control" name="ZipCode" value="<?php echo $row['ZipCode']; ?>" >
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                            <table class="table" >
                                                                <thead>
                                                                    <tr>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                        <td>Website</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input type="text" min="6" class=" form-control" name="businesstelephone" value="<?php echo $row['businesstelephone']; ?>"  ></td>
                                                                        <td><input type="text" class="form-control" name="businessfax" value="<?php echo $row['businessfax']; ?>" ></td>
                                                                        <td><input type="email" class="form-control" name="businessemailAddress" value="<?php echo $row['businessemailAddress']; ?>"></td>
                                                                        <td><input type="url" class=" form-control" name="businesswebsite" value="<?php echo $row['businesswebsite']; ?>" ></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                             
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="submit" name="submitEmp_Details" value="Save Changes" class="btn btn-success">
                                                            </div>
                                                        </div>
                                                        
                                                        </form>
                                                        <hr>
                                                        <!--Business- Contact Person(s)-->
                                                        <h4><strong>Contact Person(s)</strong> &nbsp;<a data-toggle="modal" href="#addContactModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead style="border-bottom:solid #003865 2px;">
                                                                    <tr>
                                                                        <td>First Name</td>
                                                                        <td>Last Name</td>
                                                                        <td>Title</td>
                                                                        <td>Cell No.</td>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                        <td></td>
                                                                    </tr>
                                                                </thead>
                                                                <?php 
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $queries = "SELECT * FROM tblEnterpiseDetails_Contact where user_cookies = $usersQuery";
                                                                            $resultQuery = mysqli_query($conn, $queries);
                                                                            while($rowc = mysqli_fetch_array($resultQuery)){ ?>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> 
                                                                            <?php echo $rowc['contactpersonname']; ?>
                                                                        </td>
                                                                        <td>  <?php echo $rowc['contactpersonlastname']; ?></td>
                                                                        <td> <?php echo $rowc['titles']; ?></td>
                                                                        <td>  <?php echo $rowc['contactpersoncellno']; ?></td>
                                                                        <td> <?php echo $rowc['contactpersonphone']; ?></td>
                                                                        <td>  <?php echo $rowc['contactpersonfax']; ?></td>
                                                                        <td> <?php echo $rowc['contactpersonemailAddress']; ?></td>
                                                                        <td>
                                                                            <a class="btn blue btn-outline btnViewCon " data-toggle="modal" href="#modalGetContact" data-id="<?php echo $rowc["con_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <?php } ?>
                                                            </table>
                                                           
                                                        </div>
                                                        <hr >
                                                         <!--Business - EMERGENCY: Contact Person(s)-->
                                                        <h4><strong>Emergency: Contact Person(s)</strong> &nbsp;<input type="checkbox" id="" name="" value="" >
                                                        <label for="Direct Buyer"> None</label> &nbsp;<a data-toggle="modal" href="#addEmergencyContactModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row">
                                                            <table class="table" >
                                                                <thead style="border-bottom:solid #003865 2px;">
                                                                    <tr>
                                                                        <td>First Name</td>
                                                                        <td>Last Name</td>
                                                                        <td>Title</td>
                                                                        <td>Cell No.</td>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                        <td>
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                        <?php 
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $queries = "SELECT * FROM tblEnterpiseDetails_Emergency where user_cookies = $usersQuery";
                                                                            $resultQuery = mysqli_query($conn, $queries);
                                                                            while($rowq = mysqli_fetch_array($resultQuery)){ ?>
                                                                             <tbody>
                                                                                <tr>
                                                                                    <td> <?php echo $rowq['emergencyname']; ?></td>
                                                                                    <td> <?php echo $rowq['emergencycontact_last_name']; ?></td>
                                                                                    <td> <?php echo $rowq['emergency_contact_title']; ?></td>
                                                                                    <td> <?php echo $rowq['emergencycellno']; ?></td>
                                                                                    <td> <?php echo $rowq['emergencyphone']; ?></td>
                                                                                    <td>  <?php echo $rowq['emergencyfax']; ?></td>
                                                                                    <td>  <?php echo $rowq['emergencyemailAddress']; ?></td>
                                                                                     <td>
                                                                                        <a class="btn blue btn-outline btnView " data-toggle="modal" href="#modalGetEmergencyContact" data-id="<?php echo $rowq["emerg_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                         </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                     <?php } ?>
                                                            </table>
                                                           
                                                            <hr>
                                                            
                                                        </div>
                                                    </div>
                                                    <!--end--> 
                                                    <!--start-->
                                                   <div class="tab-pane" id="ED">
                                                       <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                       <h4><strong>Enterprise / Business Description</strong></h4>
                                                        <div class="row" >
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                    <textarea class="form-control" name="BusinessPurpose" required><?php echo $row['BusinessPurpose']; ?></textarea>
                                                                </div>
                                                             </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise have a Factory(ies) / Facility(ies)?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseOperation" value="<?php echo $row['enterpriseOperation']; ?>" >
                                                                    <option value="No" <?php if($row['enterpriseOperation']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseOperation']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <?php 
                                                                            // $ids = $_COOKIE['ID'];
                                                                            $ids = $switch_user_id;
                                                                            $query = "SELECT * FROM tblFacilityDetails where users_entities = '$ids' ";
                                                                            $result = mysqli_query($conn, $query);
                                                                            while($rows = mysqli_fetch_array($result))
                                                                        { ?>
                                                                        <?php if(!empty($rows['facility_category'])){ echo $rows['facility_category'];echo ', ';}else{ echo '';} ?>
                                                                          <?php } ?>
                                                                &nbsp;<a data-toggle="modal" href="#addFacilityModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;Add Facility</a>
                                                              
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <label>Does the enterprise has employees?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                    <select class="form-control" name="enterpriseEmployees" value="<?php echo $row['enterpriseEmployees']; ?>" >
                                                                        <option value="No" <?php if($row['enterpriseEmployees']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                        <option value="Yes" <?php if($row['enterpriseEmployees']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                    </select>
                                                            </div>
                                                            <?php if($row['enterpriseEmployees']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Number of Employees&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="number" class="form-control" value="<?php echo $row['NumberofEmployees']; ?>" name="NumberofEmployees">
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <label>Is the enterprise an importer?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                    <select class="form-control" name="enterpriseImporter" value="<?php echo $row['enterpriseImporter']; ?>">
                                                                        <option value="No" <?php if($row['enterpriseImporter']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                        <option value="Yes" <?php if($row['enterpriseImporter']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                    </select>
                                                            </div>
                                                            <?php if($row['enterpriseImporter']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                    <label>Country&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="Country_importer" >
                                                                    <option value="0">---Select---</option>
                                                                        <?php 
                                                                            // for display country
                                                                            $querycountry = "SELECT * FROM countries order by name ASC";
                                                                            $resultcountry = mysqli_query($conn, $querycountry);
                                                                            while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                        { ?>
                                                                            <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['Country_importer']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                            
                                                                </select>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Is the enterprise an exporter?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseexporter" value="<?php echo $row['enterpriseexporter']; ?>">
                                                                    <option value="No" <?php if($row['enterpriseexporter']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseexporter']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <?php if($row['enterpriseexporter']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Country&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                                <div class="col-md-2">
                                                                    <select class="form-control" name="Country_exporter">
                                                                        <option value="0">---Select---</option>
                                                                            <?php 
                                                                            // for display country
                                                                            $querycountry = "SELECT * FROM countries order by name ASC";
                                                                            $resultcountry = mysqli_query($conn, $querycountry);
                                                                            while($rowcountry = mysqli_fetch_array($resultcountry)){ ?>
                                                                                <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['Country_exporter']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                            <?php } ?>  
                                                                    </select>
                                                                </div>
                                                                      <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise offer products?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseProducts" value="<?php echo $row['enterpriseProducts']; ?>">
                                                                    <option value="No" <?php if($row['enterpriseProducts']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseProducts']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <?php if($row['enterpriseProducts']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Product &nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <textarea type="" class="form-control" name="ProductDesc"><?php echo $row['ProductDesc']; ?></textarea>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise offer services?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseServices" value="<?php echo $row['enterpriseServices']; ?>">
                                                                    <option value="No" <?php if($row['enterpriseServices']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseServices']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4">
                                                                        <label>Enterprise  Process</label>
                                                                        <?php
                                                                            $array_busi = explode(", ", $row["BusinessPROCESS"]); 
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Manufacturing</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Distribution</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="3" <?php  if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Co-Packer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="4" <?php  if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Co-Manufacturer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="5" <?php  if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Retailer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="6" <?php  if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Reseller</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="7" <?php  if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Buyer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="8" <?php  if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Seller</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="9" <?php  if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Broker</label> <br>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="10" <?php  if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label for="Packaging">Packaging</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="11" <?php  if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Professional Services</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="12" <?php  if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>IT Services</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="13" <?php  if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Brand Owner</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="14" <?php  if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Cultivation</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="15" <?php  if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Others</label> <br>
                                                                        <?php  if(in_array('15', $array_busi)){ ?>
                                                                        <input class="form-control" name="EnterpriseProcessSpecify" value="<?php echo $row['EnterpriseProcessSpecify']; ?>" >
                                                                        <?php  }else{ ?>
                                                                        <?php  } ?>
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                                       
                                                        </div>
                                                        <hr> 
                                                        <!--__________________________________________________________________________________________________________________________________-->
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4">
                                                                        <label>Enterprise Categories</label>
                                                                        <?php
                                                                            $array_busi = explode(", ", $row["Categories"]); 
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="checkbox" name="Categories[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Acidified Foods</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Animal Feed</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="33" <?php if(in_array('33', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Animal Product</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="3" <?php  if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Aquaculture</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="4" <?php  if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Beverages</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="5" <?php  if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Cannabis</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="6" <?php  if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Chemicals</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="7" <?php  if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Confectionery</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="8" <?php  if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>CPG/FMCG</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="9" <?php  if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Cosmetics</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="10" <?php  if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label for="Packaging">Dietary Supplements</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="11" <?php  if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Equipment</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="12" <?php  if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Flavoring</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="13" <?php  if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Food</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="14" <?php  if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Functional</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="15" <?php  if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Foods</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="16" <?php if(in_array('16', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Herbal / Herbs</label> <br>
                                                                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="Categories[]" value="17" <?php if(in_array('17', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Ingredients</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="18" <?php  if(in_array('18', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Juice</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="19" <?php  if(in_array('19', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Medical Device</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="20" <?php  if(in_array('20', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label> Medical Food</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="21" <?php  if(in_array('21', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Nutraceuticals</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="22" <?php  if(in_array('22', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Packaging</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="23" <?php  if(in_array('23', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Pet Food</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="24" <?php  if(in_array('24', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Pharmaceuticals</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="25" <?php  if(in_array('25', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label for="Packaging">Produce</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="26" <?php  if(in_array('26', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Raw Materials</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="27" <?php  if(in_array('27', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Seafood</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="28" <?php  if(in_array('28', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Spices</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="29" <?php  if(in_array('29', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Systems</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="30" <?php  if(in_array('30', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Tobacco</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="31" <?php  if(in_array('31', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Utensils</label> <br>
                                                                        
                                                                        <input type="checkbox" name="Categories[]" value="32" <?php  if(in_array('32', $array_busi)){echo 'checked';}else{echo '';} ?>>
                                                                        <label>Others</label> <br>
                                                                        <!--<input class="form-control" name="EnterpriseProcessSpecify" value="<?php echo $row['EnterpriseProcessSpecify']; ?>" >-->
                                                                        <br>
                                                                    </div>
                                                                </div>      
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="submit" name="submitPROCESS"  class="btn btn-success" value="Save Changes">
                                                            </div>
                                                        </div>
                                                        
                                                         </form>  
                                                    </div>
                                                     <!--end--> 
                                                    <!--start-->
                                                    <div class="tab-pane" id="Logo">
                                                       <center>
                                                           <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['enterp_id'];}else{ echo '';} ?>" required> 
                                                            <div class="form-group">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                        <?php
                                                                            if ( empty($row['BrandLogos']) ) {
                                                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                                            } else {
                                                                                echo '<img src="companyDetailsFolder/'.$row['BrandLogos'].'" class="img-responsive" alt="Avatar" />';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                                                    <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> Select image </span>
                                                                            <span class="fileinput-exists"> Change </span>
                                                                            <input class="form-control" type="file" name="BrandLogos" />
                                                                        </span>
                                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="submitBrandLogos" id="btnSave_userAvatar" value="Save Changes" />
                                                            </div>
                                                            </form>
                                                       </center>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="BS">
                                                       <h4><strong>Business Structure</strong></h4>
                                                         <div class="row">
                                                             <div>
                                                                 <table class="table">
                                                                     <thead>
                                                                         <tr>
                                                                            <td></td>
                                                                             <td></td>
                                                                             <td>Supporting Files <i style="font-size:12px;color:orange;">(Upload)</i></td>
                                                                              <td></td>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                         <tr>
                                                                             <td> <?php if($row['SolePropreitorship'] !=''){ ?>
                                                                                    <input type="checkbox"  name="SolePropreitorship" value="" onchange="SolePropreitorship(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SolePropreitorship']=='Sole Propreitorship'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php }else{ ?>
                                                                                      <input type="checkbox"  name="SolePropreitorship" value="Sole Propreitorship" onchange="SolePropreitorship(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SolePropreitorship']=='Sole Propreitorship'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php } ?>
                                                                                    <label> Sole Proprietorship</label>
                                                                            </td>
                                                                             <?php if($row['SolePropreitorship'] !=''): ?>
                                                                             <td><a href="enterprise-details-download.php?pathSole=<?php echo $row['enterp_id']; ?>"><?php echo $row['SolePropreitorship_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="SolePropreitorship_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitSole" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                             <?php if($row['GeneralPartnership'] !=''){ ?>
                                                                                  <input type="checkbox"  name="GeneralPartnership" value=""  onchange="GeneralPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GeneralPartnership']=='General Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                    <?php }else{ ?>
                                                                                    <input type="checkbox"  name="GeneralPartnership" value="General Partnership"  onchange="GeneralPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GeneralPartnership']=='General Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php } ?>
                                                                                    <label> General Partnership</label>
                                                                             </td>
                                                                             <?php if($row['GeneralPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathGP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GeneralPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="GeneralPartnership_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitGP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                             <?php if($row['Corporation'] !=''){ ?>
                                                                                  <input type="checkbox" name="Corporation" value="" onchange="Corporation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Corporation'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="Corporation" value="Corporation" onchange="Corporation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Corporation'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php } ?>
                                                                                 <label>Corporation</label>
                                                                             </td>
                                                                             <?php if($row['Corporation'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathCorp=<?php echo $row['enterp_id']; ?>"><?php echo $row['Corporation_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="Corporation_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitCorp" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr> 
                                                                             <td>
                                                                             <?php if($row['LimitedLiabilityCompany'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityCompany" value="" onchange="LimitedLiabilityCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityCompany']=='Limited Liability Company'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityCompany" value="Limited Liability Company" onchange="LimitedLiabilityCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Limited Liability Company'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php } ?>
                                                                                 <label>Limited Liability Company</label>
                                                                             </td>
                                                                             <?php if($row['LimitedLiabilityCompany'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLLC=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityCompany_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="LimitedLiabilityCompany_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLLC" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                         <tr>
                                                                              <td>
                                                                             <?php if($row['LimitedPartnership'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedPartnership" value="" onchange="LimitedPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedPartnership']=='Limited Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedPartnership" value="Limited Partnership" onchange="LimitedPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedPartnership']=='Limited Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php } ?>
                                                                                 <label>Limited Partnership</label>
                                                                             </td>
                                                                             <?php if($row['LimitedPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="LimitedPartnership_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                            <td>
                                                                             <?php if($row['LimitedLiabilityPartnership'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityPartnership" value="" onchange="LimitedLiabilityPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityPartnership']=='Limited Liability Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityPartnership" value="Limited Liability Partnership" onchange="LimitedLiabilityPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityPartnership']=='Limited Liability Partnership'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php } ?>
                                                                                 <label>Limited Liability Partnership</label>
                                                                             </td>
                                                                             <?php if($row['LimitedLiabilityPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLPP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="LimitedLiabilityPartnership_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLPP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                              <td>
                                                                             <?php if($row['othersBusinessStructure'] !=''){ ?>
                                                                                  <input type="checkbox" name="othersBusinessStructure" value="" onchange="othersBusinessStructure(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['othersBusinessStructure']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                  
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="othersBusinessStructure" value="Others" onchange="othersBusinessStructure(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['othersBusinessStructure']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                  <?php } ?>
                                                                                 <label> Others (Please Specify)</label>
                                                                                 <?php if($row['othersBusinessStructure'] !=''){ ?>
                                                                                 <input name="BusinessStructureSpecify" class="form-control" value="<?php echo $row['BusinessStructureSpecify']; ?>" onchange="BusinessStructureSpecify(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                                  <?php } ?>
                                                                             </td>
                                                                             <?php if($row['othersBusinessStructure'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathOBS=<?php echo $row['enterp_id']; ?>"><?php echo $row['otherbStructurefile']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="otherbStructurefile" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitOBS" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                             </div> 
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Annual Gross Revenue</strong></label>
                                                                    <input type="" id="" name="AnnualGrossRevenue" value="<?php echo $row['AnnualGrossRevenue']; ?>" class="form-control" onchange="AnnualGrossRevenue(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Trademarks </strong> &nbsp;
                                                            <?php if($row['trademarkStatus'] != ''){ ?>
                                                            <input type="checkbox" id="" name="trademarkStatus" value="" onchange="trademarkStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['trademarkStatus'] == 'None'){echo 'checked';}else{echo '';}?>>
                                                            <?php }else{ ?>
                                                            <input type="checkbox" id="" name="trademarkStatus" value="None" onchange="trademarkStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['trademarkStatus'] == 'None'){echo 'checked';}else{echo '';}?>>
                                                             <?php } ?>
                                                            <label> None</label>
                                                            &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>
                                                        </h4>
                                                        <?php if($row['trademarkStatus'] != 'None'){ ?>
                                                            <div class="row">
                                                                 <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Trademark Name(s):</strong></label>
                                                                        <input type="text" class=" form-control" name="TrademarkName" value=" <?php echo $row['TrademarkName']; ?>" onchange="TrademarkName(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['TrademarkName'] == 'None'){echo 'checked';}else{echo '';}?>>
                                                                    </div>
                                                                </div>
                                                                
                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Supporting file:</strong> <a href="enterprise-details-download.php?pathTN=<?php echo $row['enterp_id']; ?>"><?php echo $row['TrademarkNameFile']; ?></a></label>
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="file" class=" form-control" name="TrademarkNameFile" value="" >
                                                                    </div>
                                                                </div>
                                                                 <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label class="control-label" style="color:transparent;"><strong>.....................</strong></label>
                                                                        <input type="submit" name="submitTN"  class="btn btn-success" value="Save">
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Tradename:</strong></label>
                                                                        <input type="text" class=" form-control" name="Tradename" value="<?php echo $row['Tradename']; ?>" onchange="Tradename(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <?php } ?>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="PC">
                                                        <h4><strong>Parent Company</strong></h4>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Parent Company Name:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyName" value="<?php echo $row['ParentCompanyName']; ?>" onchange="ParentCompanyName(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                             <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Address:</strong></label>
                                                                    <input type="text" class=" form-control" name="Headquarters" value="<?php echo $row['Headquarters']; ?>" onchange="Headquarters(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>City:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanycity" value="<?php echo $row['ParentCompanycity']; ?>" onchange="ParentCompanycity(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>State:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyStates" value="<?php echo $row['ParentCompanyStates']; ?>" onchange="ParentCompanyStates(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Zip Code:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyZipCode" value="<?php echo $row['ParentCompanyZipCode']; ?>" onchange="ParentCompanyZipCode(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Year Established:</strong></label>
                                                                    <input type="number" class=" form-control" name="YearEstablished" value="<?php echo $row['YearEstablished']; ?>" onchange="YearEstablished(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Dun & Bradstreet (D-U-N-S) Number</strong></label>
                                                                    <input type="text" class=" form-control" name="Dunn" value="<?php echo $row['Dunn']; ?>" onchange="Dunn(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                            <label class="control-label"><strong>What is your relationship with the enterprise?</strong></label>
                                                                </div>
                                                                <table class="table">
                                                                    <thead></thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['DirectEmployee'] !=''){ ?>
                                                                                <input type="checkbox" name="DirectEmployee" value="" onchange="DirectEmployee(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['DirectEmployee']=='Direct Employee'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="DirectEmployee" value="Direct Employee" onchange="DirectEmployee(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['DirectEmployee']=='Direct Employee'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Direct Employee</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['EmployeeofParentCompany'] !=''){ ?>
                                                                                <input type="checkbox" name="EmployeeofParentCompany" value="" onchange="EmployeeofParentCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['EmployeeofParentCompany']=='Employee of Parent Company'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="EmployeeofParentCompany" value="Employee of Parent Company" onchange="EmployeeofParentCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['EmployeeofParentCompany']=='Employee of Parent Company'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Employee of Parent Company</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['SisterDivision'] !=''){ ?>
                                                                                <input type="checkbox" name="SisterDivision" value="" onchange="SisterDivision(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SisterDivision']=='Sister Division'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="SisterDivision" value="Sister Division" onchange="SisterDivision(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SisterDivision']=='Sister Division'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Sister Division</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Subsidiary'] !=''){ ?>
                                                                                <input type="checkbox" name="Subsidiary" value="" onchange="Subsidiary(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Subsidiary']=='Subsidiary'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Subsidiary" value="Subsidiary" onchange="Subsidiary(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Subsidiary']=='Subsidiary'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Subsidiary</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['ThirdParty'] !=''){ ?>
                                                                                <input type="checkbox" name="ThirdParty" value="" onchange="ThirdParty(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ThirdParty']=='Third Party'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="ThirdParty" value="Third Party" onchange="ThirdParty(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ThirdParty']=='Third Party'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Third Party</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['RelationshipEnterpriseStatus'] !=''){ ?>
                                                                                <input type="checkbox" name="RelationshipEnterpriseStatus" value="" onchange="RelationshipEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['RelationshipEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="RelationshipEnterpriseStatus" value="None" onchange="RelationshipEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['RelationshipEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> None</label>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <hr>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>What is your current position with the enterprise?  </strong></label>
                                                                </div>
                                                                <table class="table">
                                                                    <thead></thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['AccountPayable'] !=''){ ?>
                                                                                <input type="checkbox" name="AccountPayable" value="" onchange="AccountPayable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountPayable']=='Accounts Payable'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="AccountPayable" value="Accounts Payable" onchange="AccountPayable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountPayable']=='Accounts Payable'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Accounts Payable</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['InformationSystem'] !=''){ ?>
                                                                                <input type="checkbox" name="InformationSystem" value="" onchange="InformationSystem(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['InformationSystem']=='Information System'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="InformationSystem" value="Information System" onchange="InformationSystem(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['InformationSystem']=='Information System'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php } ?>
                                                                                <label> Information System</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['CFO'] !=''){ ?>
                                                                                <input type="checkbox" name="CFO" value="" onchange="CFO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CFO']=='CFO'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="CFO" value="CFO" onchange="CFO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CFO']=='CFO'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php } ?>
                                                                                <label> CFO</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Insurance'] !=''){ ?>
                                                                                <input type="checkbox" name="Insurance" value="" onchange="Insurance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Insurance']=='Insurance'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Insurance" value="Insurance" onchange="Insurance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Insurance']=='Insurance'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Insurance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['PrimaryAccountRepresntative'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="PrimaryAccountRepresntative" value="" onchange="PrimaryAccountRepresntative(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimaryAccountRepresntative']=='Primary Account Representative'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="PrimaryAccountRepresntative" value="Primary Account Representative" onchange="PrimaryAccountRepresntative(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimaryAccountRepresntative']=='Primary Account Represntative'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Primary Account Representative</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['CEO'] !=''){ ?>
                                                                                <input type="checkbox" name="CEO" value="" onchange="CEO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CEO']=='CEO'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="CEO" value="CEO" onchange="CEO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CEO']=='CEO'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> CEO</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Marketing'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="Marketing" value="" onchange="Marketing(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Marketing']=='Marketing'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="Marketing" value="Marketing" onchange="Marketing(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Marketing']=='Marketing'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Marketing</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['FoodSafety'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="FoodSafety" value="" onchange="FoodSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FoodSafety']=='Food Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="FoodSafety" value="Food Safety" onchange="FoodSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FoodSafety']=='Food Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Food Safety</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Operations'] !=''){ ?>
                                                                                <input type="checkbox" name="Operations" value="" onchange="Operations(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Operations']=='Operations'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Operations" value="Operations" onchange="Operations(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Operations']=='Operations'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Operations</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Executive'] !=''){ ?>
                                                                                <input type="checkbox" name="Executive" value="" onchange="Executive(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Executive']=='Executive'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Executive" value="Executive" onchange="Executive(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Executive']=='Executive'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Executive</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['AccountReceivable'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="AccountReceivable" value="" onchange="AccountReceivable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountReceivable']=='Accounts Receivable'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="AccountReceivable" value="Accounts Receivable" onchange="AccountReceivable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountReceivable']=='Accounts Receivable'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Accounts Receivable</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['ProductSafety'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="ProductSafety" value="" onchange="ProductSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ProductSafety']=='Product Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="ProductSafety" value="Product Safety" onchange="ProductSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ProductSafety']=='Product Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Product Safety</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Legal'] !=''){ ?>
                                                                                <input type="checkbox" name="Legal" value="" onchange="Legal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Legal']=='Legal'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Legal" value="Legal" onchange="Legal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Legal']=='Legal'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Legal</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Returns'] !=''){ ?>
                                                                                <input type="checkbox" name="Returns" value="" onchange="Returns(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Returns']=='Returns'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Returns" value="Returns" onchange="Returns(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Returns']=='Returns'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Returns</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Transportation'] !=''){ ?>
                                                                                <input type="checkbox" name="Transportation" value="" onchange="Transportation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Transportation']=='Transportation'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Transportation" value="Transportation" onchange="Transportation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Transportation']=='Transportation'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Transportation</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Compliance'] !=''){ ?>
                                                                                <input type="checkbox" name="Compliance" value="" onchange="Compliance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Compliance']=='Compliance'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Compliance" value="Compliance" onchange="Compliance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Compliance']=='Compliance'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php } ?>
                                                                                <label> Compliance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Finance'] !=''){ ?>
                                                                                <input type="checkbox" name="Finance" value="" onchange="Finance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Finance']=='Finance'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Finance" value="Finance" onchange="Finance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Finance']=='Finance'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Finance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['HumanResources'] !=''){ ?>
                                                                                <input type="checkbox" name="HumanResources" value="" onchange="HumanResources(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HumanResources']=='Human Resources'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="HumanResources" value="Human Resources" onchange="HumanResources(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HumanResources']=='Human Resources'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Human Resources</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Logistics'] !=''){ ?>
                                                                                <input type="checkbox" name="Logistics" value="" onchange="Logistics(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Logistics']=='Logistics'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Logistics" value="Logistics" onchange="Logistics(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Logistics']=='Logistics'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Logistics</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['PurchaseOrder'] !=''){ ?>
                                                                                <input type="checkbox" name="PurchaseOrder" value="" onchange="PurchaseOrder(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PurchaseOrder']=='Purchase Order'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="PurchaseOrder" value="Purchase Order" onchange="PurchaseOrder(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PurchaseOrder']=='Purchase Order'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Purchase Order</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Sales'] !=''){ ?>
                                                                                <input type="checkbox" name="Sales" value="" onchange="Sales(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Sales']=='Sales'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Sales" value="Sales" onchange="Sales(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Sales']=='Sales'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Sales</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Orders'] !=''){ ?>
                                                                                <input type="checkbox" name="Orders" value="" onchange="Orders(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Orders']=='Orders'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Orders" value="Orders" onchange="Orders(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Orders']=='Orders'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Orders</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['positionEnterpriseStatus'] !=''){ ?>
                                                                                <input type="checkbox" name="positionEnterpriseStatus" value="" onchange="positionEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['positionEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="positionEnterpriseStatus" value="None" onchange="positionEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['positionEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                <?php } ?>
                                                                                <label> None</label>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Others</strong> <i>(Specify)</i></label>
                                                                    <input class="form-control" name="positionEnterpriseOthers" onchange="positionEnterpriseOthers(this.value,'<?php echo $row['enterp_id']; ?>')" value="<?php echo $row['positionEnterpriseOthers']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="CA">
                                                       <h4><strong>Certification</strong></h4>
                                                         <div class="row">
                                                             <div>
                                                                 <table class="table">
                                                                     <thead>
                                                                         <tr>
                                                                            <td></td>
                                                                             <td></td>
                                                                             <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                             <td></td>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                         <tr>
                                                                             <td> 
                                                                                    <?php if($row['GFSI'] !=''){ ?>
                                                                                    <input type="checkbox" name="GFSI" value="" onchange="GFSI(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GFSI']=='GFSI'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php }else{ ?>
                                                                                     <input type="checkbox" name="GFSI" value="GFSI" onchange="GFSI(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GFSI']=='GFSI'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php } ?>
                                                                                    <label> GFSI</label>
                                                                            </td>
                                                                            <?php if($row['GFSI'] !=''){ ?>
                                                                            <td>
                                                                                <a href="enterprise-details-download.php?pathCSP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GFSIFILE']; ?></a>
                                                                            </td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                     <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" class="form-control" name="GFSIFILE">
                                                                                 </td>
                                                                                 <td>
                                                                                    <input type="submit" name="submitCSP"  class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                                    <?php if($row['SQF'] !=''){ ?>
                                                                                  <input type="checkbox" name="SQF" value="" onchange="SQF(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SQF']=='SQF'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php }else{ ?>
                                                                                    <input type="checkbox" name="SQF" value="SQF" onchange="SQF(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SQF']=='SQF'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php } ?>
                                                                                    <label>SQF</label>
                                                                             </td>
                                                                             <?php if($row['SQF'] !=''){ ?>
                                                                            <td>
                                                                                <a href="enterprise-details-download.php?pathSQF=<?php echo $row['enterp_id']; ?>"><?php echo $row['SQFFILE']; ?></a>
                                                                            </td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                     <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" class="form-control" name="SQFFILE">
                                                                                 </td>
                                                                                 <td>
                                                                                    <input type="submit" name="submitSQF"  class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                           
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                              <?php if($row['BRC'] !=''){ ?>
                                                                                  <input type="checkbox" name="BRC" value="" onchange="BRC(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['BRC']=='BRC'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php }else{ ?>
                                                                                  <input type="checkbox" name="BRC" value="BRC" onchange="BRC(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['BRC']=='BRC'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php } ?>
                                                                                 <label>BRC</label>
                                                                             </td>
                                                                             <?php if($row['BRC'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathBRC=<?php echo $row['enterp_id']; ?>"><?php echo $row['BRCFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="BRCFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitBRC"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                 <?php if($row['FSSC22000'] !=''){ ?>
                                                                                 <input type="checkbox" name="FSSC22000" value="" onchange="FSSC22000(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FSSC22000']=='FSSC22000'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="FSSC22000" value="FSSC22000" onchange="FSSC22000(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FSSC22000']=='FSSC22000'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php } ?>
                                                                                 <label>FSSC22000</label>
                                                                             </td>
                                                                            <?php if($row['FSSC22000'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathFSSC=<?php echo $row['enterp_id']; ?>"><?php echo $row['FSSC22000FILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="FSSC22000FILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitFSSC"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                        <?php } ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                                <?php if($row['ISO'] !=''){ ?>
                                                                                 <input type="checkbox" name="ISO" value="" onchange="ISO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ISO']=='ISO'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="ISO" value="ISO" onchange="ISO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ISO']=='ISO'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php } ?>
                                                                                <label>ISO</label>
                                                                             </td>
                                                                            <?php if($row['ISO'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathISO=<?php echo $row['enterp_id']; ?>"><?php echo $row['ISOFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="ISOFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitISO"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                        <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                 <?php if($row['PrimusGFS'] !=''){ ?>
                                                                                 <input type="checkbox" name="PrimusGFS" value="" onchange="PrimusGFS(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimusGFS']=='Primus GFS'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="PrimusGFS" value="Primus GFS" onchange="PrimusGFS(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimusGFS']=='Primus GFS'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php } ?>
                                                                                    <label>PrimusGFS</label>
                                                                             </td>
                                                                             <?php if($row['PrimusGFS'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathPrimusGFS=<?php echo $row['enterp_id']; ?>"><?php echo $row['PrimusGFSFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="PrimusGFSFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitPrimusGFS"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                <?php if($row['HACCP'] !=''){ ?>
                                                                                 <input type="checkbox" name="HACCP" value="" onchange="HACCP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HACCP']=='HACCP'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="HACCP" value="HACCP" onchange="HACCP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HACCP']=='HACCP'){echo 'checked';}else{echo '';} ?>>
                                                                                 <?php } ?>
                                                                                <label>HACCP</label>
                                                                             </td>
                                                                             <?php if($row['HACCP'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathHACCP=<?php echo $row['enterp_id']; ?>"><?php echo $row['HACCPFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="HACCPFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitHACCP"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                <?php if($row['GMP'] !=''){ ?>
                                                                                 <input type="checkbox" name="GMP" value="" onchange="GMP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GMP']=='GMP'){echo 'checked';}else{echo '';} ?>>
                                                                                    <?php }else{ ?>
                                                                                    <input type="checkbox" name="GMP" value="GMP" onchange="GMP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GMP']=='GMP'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php } ?>
                                                                                    <label>GMP</label>
                                                                             </td>
                                                                              <?php if($row['GMP'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathGMP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GMPFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="GMPFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitGMP"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                    <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                  <input type="checkbox" name="CertificationOthers" value="" onchange="CertificationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CertificationOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php }else{ ?>
                                                                                   <input type="checkbox" name="CertificationOthers" value="Others" onchange="CertificationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CertificationOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php } ?>
                                                                                    <label>Others (Please Specify)</label><br>
                                                                                    <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                    <input class=" form-control" id="boxBS" name="othersCertificationSpecify" value="<?php echo $row['othersCertificationSpecify']; ?>" onchange="othersCertificationSpecify(this.value,'<?php echo $row['enterp_id']; ?>')" >
                                                                                    <?php } ?>
                                                                             </td>
                                                                             <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathcOther=<?php echo $row['enterp_id']; ?>"><?php echo $row['OthersFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="OthersFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitcOther"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                                 
                                                             </div>
                                                        </div>
                                                         <h4><strong>Accreditation</strong></h4>
                                                             <div class="row" >
                                                                 <div>
                                                                     <table class="table">
                                                                         <thead>
                                                                             <tr>
                                                                               <td></td>
                                                                                 <td></td>
                                                                                 <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                                 <td></td>
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td> 
                                                                                     <?php if($row['Organic'] !=''){ ?>
                                                                                        <input type="checkbox" name="Organic" value="" onchange="Organic(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Organic']=='Organic'){echo 'checked';}else{echo '';} ?>>
                                                                                        <?php }else{ ?>
                                                                                          <input type="checkbox" name="Organic" value="Organic" onchange="Organic(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Organic']=='Organic'){echo 'checked';}else{echo '';} ?>>
                                                                                        <?php } ?>
                                                                                        <label> Organic</label>
                                                                                </td>
                                                                                 <?php if($row['Organic'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathOrganic=<?php echo $row['enterp_id']; ?>"><?php echo $row['OrganicFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="OrganicFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitOrganic"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                    <?php if($row['Halal'] !=''){ ?>
                                                                                      <input type="checkbox" name="Halal" value="" onchange="Halal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Halal']=='Halal'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php }else{ ?>
                                                                                       <input type="checkbox" name="Halal" value="Halal" onchange="Halal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Halal']=='Halal'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php } ?>
                                                                                        <label>Halal</label>
                                                                                 </td>
                                                                                 <?php if($row['Halal'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathHalal=<?php echo $row['enterp_id']; ?>"><?php echo $row['HalalFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="HalalFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitHalal"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                               
                                                                             </tr>
                                                                              <tr>
                                                                                 <td>
                                                                                     <?php if($row['Kosher'] !=''){ ?>
                                                                                      <input type="checkbox" name="Kosher" value="" onchange="Kosher(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Kosher']=='Kosher'){echo 'checked';}else{echo '';} ?>>
                                                                                      <?php }else{ ?>
                                                                                      <input type="checkbox" name="Kosher" value="Kosher" onchange="Kosher(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Kosher']=='Kosher'){echo 'checked';}else{echo '';} ?>>
                                                                                      <?php } ?>
                                                                                     <label>Kosher</label>
                                                                                 </td>
                                                                                 <?php if($row['Kosher'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathKosher=<?php echo $row['enterp_id']; ?>"><?php echo $row['KosherFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="KosherFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitKosher"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                              <tr>
                                                                                 <td>
                                                                                 <?php if($row['NonGMO'] !=''){ ?>
                                                                                     <input type="checkbox" name="NonGMO" value="" onchange="NonGMO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['NonGMO']=='Non-GMO'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php }else{ ?>
                                                                                     <input type="checkbox" name="NonGMO" value="Non-GMO" onchange="NonGMO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['NonGMO']=='Non-GMO'){echo 'checked';}else{echo '';} ?>>
                                                                                     <?php } ?>
                                                                                     <label>Non-GMO</label>
                                                                                 </td>
                                                                                  <?php if($row['NonGMO'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathNonGMO=<?php echo $row['enterp_id']; ?>"><?php echo $row['NonGMOFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="NonGMOFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitNonGMO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                                
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                  <?php if($row['PlantBased'] !=''){ ?>
                                                                                     <input type="checkbox" name="PlantBased" value="" onchange="PlantBased(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PlantBased']=='Plant Based'){echo 'checked';}else{echo '';} ?>>
                                                                                    <?php }else{ ?>
                                                                                     <input type="checkbox" name="PlantBased" value="Plant Based" onchange="PlantBased(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PlantBased']=='Plant Based'){echo 'checked';}else{echo '';} ?>>
                                                                                   <?php } ?>
                                                                                    <label>Plant Based</label>
                                                                                 </td>
                                                                                 <?php if($row['PlantBased'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathPlantBased=<?php echo $row['enterp_id']; ?>"><?php echo $row['PlantBasedFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="PlantBasedFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitPlantBased"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             
                                                                              <tr>
                                                                                 <td>
                                                                                    <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                      <input type="checkbox" name="FacilityAccreditationOthers" value="" onchange="FacilityAccreditationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                      <?php }else{ ?>
                                                                                       <input type="checkbox" name="FacilityAccreditationOthers" value="Others" onchange="FacilityAccreditationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                      <?php } ?>
                                                                                        <label>Others (Please Specify)</label><br>
                                                                                        <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                        <input class="form-control" id="boxBS"  name="FacilityAccreditationSpecify" value="<?php echo $row['FacilityAccreditationSpecify']; ?>" onchange="FacilityAccreditationSpecify(this.value,'<?php echo $row['enterp_id']; ?>')" >
                                                                                        <?php } ?>
                                                                                       
                                                                                 </td>
                                                                                 <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathFAO=<?php echo $row['enterp_id']; ?>"><?php echo $row['othersAccreditationFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="othersAccreditationFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitFAO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                    <?php if($row['FacilityAccreditationNone'] !=''){ ?>
                                                                                     <input type="checkbox" name="FacilityAccreditationNone" value="" onchange="FacilityAccreditationNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationNone']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                    <?php }else{ ?>
                                                                                     <input type="checkbox" name="FacilityAccreditationNone" value="None" onchange="FacilityAccreditationNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationNone']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                    <?php } ?>
                                                                                    <label>None</label>
                                                                                 </td>
                                                                                 <td>
                                                                                    
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                     
                                                                 </div>
                                                            </div>
                                                    </div>
                                                    <!--end-->
                                                     <!--start-->
                                                    <div class="tab-pane" id="Regulatory">
                                                        <h4><strong>Regulatory Compliance Requirements</strong></h4>
                                                             <div class="row">
                                                                 <div>
                                                                     <table class="table">
                                                                         <thead>
                                                                             <tr>
                                                                                <td></td>
                                                                                 <td></td>
                                                                                 <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                                 <td></td>
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td> 
                                                                                        <?php if($row['FDA'] !=''){ ?>
                                                                                        <input type="checkbox" name="FDA" value="" onchange="FDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FDA']=='FDA'){echo 'checked';}else{echo '';} ?>>
                                                                                        <?php }else{ ?>
                                                                                        <input type="checkbox" name="FDA" value="FDA" onchange="FDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FDA']=='FDA'){echo 'checked';}else{echo '';} ?>>
                                                                                        <?php } ?>
                                                                                        <label> FDA</label>
                                                                                </td>
                                                                                 <?php if($row['FDA'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathFDA=<?php echo $row['enterp_id']; ?>"><?php echo $row['FDAfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="FDAfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitFDA"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                     <?php if($row['USDA'] !=''){ ?>
                                                                                      <input type="checkbox" name="USDA" value="" onchange="USDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['USDA']=='USDA'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php }else{ ?>
                                                                                        <input type="checkbox" name="USDA" value="USDA" onchange="USDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['USDA']=='USDA'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php } ?>
                                                                                        <label>USDA</label>
                                                                                 </td>
                                                                                  <?php if($row['USDA'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathUSDA=<?php echo $row['enterp_id']; ?>"><?php echo $row['USDAfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="USDAfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitUSDA"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                               
                                                                             </tr>
                                                                            
                                                                              <tr>
                                                                                 <td>
                                                                                    <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                      <input type="checkbox"  name="ComplianceRequirementsOthers" value="" onchange="ComplianceRequirementsOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php }else{ ?>
                                                                                       <input type="checkbox"  name="ComplianceRequirementsOthers" value="Others" onchange="ComplianceRequirementsOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthers']=='Others'){echo 'checked';}else{echo '';} ?>>
                                                                                       <?php } ?>
                                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                                        <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                        <input class=" form-control" id="boxBS" name="ComplianceRequirementsOthersSpecify" value="<?php echo $row['ComplianceRequirementsOthersSpecify']; ?>" onchange="ComplianceRequirementsOthersSpecify(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                                         <?php } ?>
                                                                                 </td>
                                                                                 <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathCRO=<?php echo $row['enterp_id']; ?>"><?php echo $row['ComplianceRequirementsfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="ComplianceRequirementsfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitCRO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                               <tr>
                                                                                 <td>
                                                                                    <?php if($row['ComplianceRequirementsOthersNone'] !=''){ ?>
                                                                                      <input type="checkbox" name="ComplianceRequirementsOthersNone" value="" onchange="ComplianceRequirementsOthersNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthersNone']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                         <?php }else{ ?>
                                                                                          <input type="checkbox" name="ComplianceRequirementsOthersNone" value="None" onchange="ComplianceRequirementsOthersNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthersNone']=='None'){echo 'checked';}else{echo '';} ?>>
                                                                                         
                                                                                         <?php } ?>
                                                                                        <label>None</label>
                                                                                 </td>
                                                                                 
                                                                               
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                     
                                                                 </div>
                                                            </div>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="Rec">
                                                       <h5><strong>Enterprise Records  &nbsp;<a data-toggle="modal" href="#addRecordModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a>&nbsp;<i style="font-size:12px;background-color:orange;color:#fff;">Examples (Tax ID, Corporate Documents, Partnership Agreements, Certifications, Accreditations, etc.)</i></strong></h5>
                                                        <div class="row">
                                                            <table class="table" >
                                                                <thead style="border-bottom:solid #003865 2px;">
                                                                    <tr>
                                                                        <td>Document</td>
                                                                        <td>Title</td>
                                                                        <td>Description</td>
                                                                        <td>Document Due Date</td>
                                                                        <td>
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                        <?php 
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $queries = "SELECT * FROM tblEnterpiseDetails_Records where user_cookies = $usersQuery";
                                                                            $resultQuery = mysqli_query($conn, $queries);
                                                                            while($rowf = mysqli_fetch_array($resultQuery)){ ?>
                                                                             <tbody>
                                                                                <tr>
                                                                                    <td><a href="enterprise-details-download.php?pathERF=<?php echo $rowf['rec_id']; ?>"><?php echo $rowf['EnterpriseRecordsFile']; ?></a></td>
                                                                                    <td> <?php echo $rowf['DocumentTitle']; ?></td>
                                                                                    <td> <?php echo $rowf['DocumentDesciption']; ?></td>
                                                                                    <td> <?php echo $rowf['DocumentDueDate']; ?></td>
                                                                                     <td>
                                                                                        <a class="btn blue btn-outline btnViewRec" data-toggle="modal" href="#modalGetRecord" data-id="<?php echo $rowf["rec_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                         </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                     <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!--end-->
                                                    <!--_______________________________________________________________________________________________________________________________________________________________________________________-->
                                                     <?php }else{ ?>
                                                     <!--start-->
                                               
                                                   <div class="tab-pane active" id="EI">
                                                        <form action="enterprise-information-addfunction.php" method="POST" enctype="multipart/form-data">
                                                       <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label class="control-label"><strong>Legal Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="" class="form-control" name="LegalNameNew"  required> 
                                                                </div>
                                                             </div>
                                                       </div>
                                                       <br>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <select class="form-control" name="country" required>
                                                                        <option value="">---Select---</option>
                                                                        
                                                                        <?php 
                                                                         while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                         { ?>
                                                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['country']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                             <table class="table">
                                                                 <thead>
                                                                    <tr>
                                                                        <td>Bldg No./Street</td>  
                                                                        <td>City</td>
                                                                        <td>State</td>
                                                                        <td>Zip Code</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input class=" form-control" name="Bldg" value="<?php echo $row['Bldg']; ?>" required>
                                                                        </td>  
                                                                        <td>
                                                                            <input class="form-control" name="city" value="<?php echo $row['city']; ?>" required>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control" name="States" value="<?php echo $row['States']; ?>" required>
                                                                        </td>
                                                                        <td>
                                                                            <input class=" form-control" name="ZipCode" value="<?php echo $row['ZipCode']; ?>" required>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                            <table class="table" >
                                                                <thead>
                                                                    <tr>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                        <td>Website</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input type="" min="6" class="form-control" name="businesstelephone" value="<?php echo $row['businesstelephone']; ?>" required></td>
                                                                        <td><input type="" class="form-control" name="businessfax" value="<?php echo $row['businessfax']; ?>" required></td>
                                                                        <td><input type="email" class="form-control" name="businessemailAddress" required></td>
                                                                        <td><input class=" form-control" name="businesswebsite" value="<?php echo $row['businesswebsite']; ?>" required></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <input type="submit" name="submitLN" class="btn btn-success" value="Save" style="float:left;margin-left:10px;">
                                                            
                                                            </form>
                                                        </div>
                                                        <hr>
                                                        <!--Business- Contact Person(s)-->
                                                        <h4><strong>Contact Person(s)</strong> &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <td>First Name</td>
                                                                        <td>Last Name</td>
                                                                        <td>Title</td>
                                                                        <td>Cell No.</td>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> <input class=" form-control" name="contactpersonname" value="<?php echo $row['contactpersonname']; ?>" onchange="contactpersonname(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input class=" form-control" name="contactpersonlastname" value="<?php echo $row['contactpersonlastname']; ?>" onchange="contactpersonlastname(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input class=" form-control" name="titles" value="<?php echo $row['title']; ?>" onchange="titles(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="contactpersoncellno" value="<?php echo $row['contactpersoncellno']; ?>" onchange="contactpersoncellno(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="contactpersonphone" value="<?php echo $row['contactpersonphone']; ?>" onchange="contactpersonphone(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="contactpersonfax" value="<?php echo $row['contactpersonfax']; ?>" onchange="contactpersonfax(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="email" class=" form-control" name="contactpersonemailAddress" value="<?php echo $row['contactpersonemailAddress']; ?>" onchange="contactpersonemailAddress(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <hr >
                                                         <!--Business - EMERGENCY: Contact Person(s)-->
                                                        <h4><strong>Emergency: Contact Person(s)</strong> &nbsp;<input type="checkbox" id="" name="" value="" >
                                                        <label for="Direct Buyer"> None</label> &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <td>First Name</td>
                                                                        <td>Last Name</td>
                                                                        <td>Title</td>
                                                                        <td>Cell No.</td>
                                                                        <td>Phone</td>
                                                                        <td>FAX</td>
                                                                        <td>Email Address</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> <input class=" form-control" name="emergencyname" value="<?php echo $row['emergencyname']; ?>" onchange="emergencyname(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input class=" form-control" name="emergencycontact_last_name" value="<?php echo $row['emergencycontact_last_name']; ?>" onchange="emergencycontact_last_name(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input class=" form-control" name="emergency_contact_title" value="<?php echo $row['emergency_contact_title']; ?>" onchange="emergency_contact_title(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="emergencycellno" value="<?php echo $row['emergencycellno']; ?>" onchange="emergencycellno(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="emergencyphone" value="<?php echo $row['emergencyphone']; ?>" onchange="emergencyphone(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="" class=" form-control" name="emergencyfax" value="<?php echo $row['emergencyfax']; ?>" onchange="emergencyfax(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                        <td> <input type="email" class=" form-control" name="emergencyemailAddress" value="<?php echo $row['emergencyemailAddress']; ?>" onchange="emergencyemailAddress(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>   
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    <!--end--> 
                                                    <!--start-->
                                                   <div class="tab-pane" id="ED">
                                                       <h4><strong>Enterprise / Business Description</strong></h4>
                                                        <div class="row" >
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <textarea class=" form-control" name="BusinessPurpose" onchange="BusinessPurpose(this.value,'<?php echo $row['enterp_id']; ?>')" disabled><?php echo $row['BusinessPurpose']; ?></textarea>
                                                                </div>
                                                             </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise have a Factory(ies) / Facility(ies)?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseOperation" value="<?php echo $row['enterpriseOperation']; ?>" onchange="enterpriseOperation(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    <option value="No" <?php if($row['enterpriseOperation']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseOperation']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <label>Does the enterprise has employees?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                    <select class="form-control" name="enterpriseEmployees" value="<?php echo $row['enterpriseEmployees']; ?>" onchange="enterpriseEmployees(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                        <option value="No" <?php if($row['enterpriseEmployees']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                        <option value="Yes" <?php if($row['enterpriseEmployees']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                    </select>
                                                            </div>
                                                            <?php if($row['enterpriseEmployees']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Number of Employees&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="" class="form-control" value="<?php echo $row['NumberofEmployees']; ?>" name="NumberofEmployees" onchange="NumberofEmployees(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <label>Is the enterprise an importer?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                    <select class="form-control" name="enterpriseImporter" value="<?php echo $row['enterpriseImporter']; ?>" onchange="enterpriseImporter(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                        <option value="No" <?php if($row['enterpriseImporter']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                        <option value="Yes" <?php if($row['enterpriseImporter']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                    </select>
                                                            </div>
                                                            <?php if($row['enterpriseImporter']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                    <label>Country&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="Country_importer" onchange="Country_importer(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    <option value="0">---Select---</option>
                                                                        <?php 
                                                                            // for display country
                                                                            $querycountry = "SELECT * FROM countries order by name ASC";
                                                                            $resultcountry = mysqli_query($conn, $querycountry);
                                                                            while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                        { ?>
                                                                            <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['Country_importer']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                            
                                                                </select>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Is the enterprise an exporter??</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseexporter" value="<?php echo $row['enterpriseexporter']; ?>" onchange="enterpriseexporter(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    <option value="No" <?php if($row['enterpriseexporter']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseexporter']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <?php if($row['enterpriseexporter']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Country&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                                <div class="col-md-2">
                                                                    <select class="form-control" name="Country_exporter" onchange="Country_exporter(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                        <option value="0">---Select---</option>
                                                                            <?php 
                                                                            // for display country
                                                                            $querycountry = "SELECT * FROM countries order by name ASC";
                                                                            $resultcountry = mysqli_query($conn, $querycountry);
                                                                            while($rowcountry = mysqli_fetch_array($resultcountry)){ ?>
                                                                                <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['Country_exporter']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                            <?php } ?>  
                                                                    </select>
                                                                </div>
                                                                      <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise offer products?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseProducts" value="<?php echo $row['enterpriseProducts']; ?>" onchange="enterpriseProducts(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    <option value="No" <?php if($row['enterpriseProducts']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseProducts']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <?php if($row['enterpriseProducts']=='Yes'){ ?>
                                                            <div class="col-md-2">
                                                                <label>Product &nbsp;<i style="color:orange;">(If yes)</i></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <textarea type="" class="form-control"  name="ProductDesc" onchange="ProductDesc(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> <?php echo $row['ProductDesc']; ?></textarea>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Does the enterprise offer services?</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="enterpriseServices" value="<?php echo $row['enterpriseServices']; ?>" onchange="enterpriseServices(this.options[this.selectedIndex].value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    <option value="No" <?php if($row['enterpriseServices']=='No'){echo 'selected';}else{echo '';} ?>>No</option>
                                                                    <option value="Yes" <?php if($row['enterpriseServices']=='Yes'){echo 'selected';}else{echo '';} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4">
                                                                        <label>Enterprise  Process</label>
                                                                        <?php
                                                                            $array_busi = explode(", ", $row["BusinessPROCESS"]); 
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Manufacturing</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Distribution</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="3" <?php  if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Co-Packer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="4" <?php  if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Co-Manufacturer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="5" <?php  if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Retailer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="6" <?php  if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?> disabled >
                                                                        <label>Reseller</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="7" <?php  if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Buyer</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="8" <?php  if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Seller</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="9" <?php  if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Broker</label> <br>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="10" <?php  if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label for="Packaging">Packaging</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="11" <?php  if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Professional Services</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="12" <?php  if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>IT Services</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="13" <?php  if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Brand Owner</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="14" <?php  if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Cultivation</label> <br>
                                                                        <input type="checkbox" name="BusinessPROCESS[]" value="15" <?php  if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Others</label> <br>
                                                                        <?php  if(in_array('15', $array_busi)){ ?>
                                                                        <input class="form-control" name="EnterpriseProcessSpecify" value="<?php echo $row['EnterpriseProcessSpecify']; ?>" >
                                                                        <?php  }else{ ?>
                                                                        <?php  } ?>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                  <hr>
                                                                <!--__________________________________________________________________________________________________________________________________-->
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4">
                                                                        <label>Enterprise Categories</label>
                                                                        <?php
                                                                            $array_busi = explode(", ", $row["BusinessPROCESS"]); 
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="checkbox" name="Categories[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Acidified Foods</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Animal Feed</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="3" <?php  if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Aquaculture</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="4" <?php  if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Beverages</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="5" <?php  if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Cannabis</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="6" <?php  if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Chemicals</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="7" <?php  if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Confectionery</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="8" <?php  if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>CPG/FMCG</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="9" <?php  if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Cosmetics</label> <br>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="Categories[]" value="10" <?php  if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label for="Packaging">Dietary Supplements</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="11" <?php  if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Equipment</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="12" <?php  if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Flavoring</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="13" <?php  if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Food</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="14" <?php  if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Functional</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="15" <?php  if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Foods</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="16" <?php if(in_array('16', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Herbal / Herbs</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="17" <?php if(in_array('17', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Ingredients</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="18" <?php  if(in_array('18', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Juice</label> <br>
                                                                    </div>
                                                                </div>      
                                                        </div>
                                                          <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="Categories[]" value="19" <?php  if(in_array('19', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Medical Device</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="20" <?php  if(in_array('20', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label> Medical Food</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="21" <?php  if(in_array('21', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Nutraceuticals</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="22" <?php  if(in_array('22', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Packaging</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="23" <?php  if(in_array('23', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Pet Food</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="24" <?php  if(in_array('24', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Pharmaceuticals</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="25" <?php  if(in_array('25', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label for="Packaging">Produce</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="26" <?php  if(in_array('26', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Raw Materials</label> <br>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="Categories[]" value="27" <?php  if(in_array('27', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Seafood</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="28" <?php  if(in_array('28', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Spices</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="29" <?php  if(in_array('29', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Systems</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="30" <?php  if(in_array('30', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Tobacco</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="31" <?php  if(in_array('31', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Utensils</label> <br>
                                                                        <input type="checkbox" name="Categories[]" value="32" <?php  if(in_array('32', $array_busi)){echo 'checked';}else{echo '';} ?> disabled>
                                                                        <label>Others</label> <br>
                                                                        <input class="form-control" name="EnterpriseProcessSpecify" value="<?php echo $row['EnterpriseProcessSpecify']; ?>" readonly>
                                                                        <br>
                                                                          <input type="submit" name=""  class="btn btn-success" value="Save">
                                                                    </div>
                                                                </div>        
                                                        </div>
                                                            </form>   
                                                    </div>
                                                     <!--end--> 
                                                    <!--start-->
                                                    <div class="tab-pane" id="Logo">
                                                       <center>
                                                           <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['enterp_id'];}else{ echo '';} ?>" required> 
                                                            <div class="form-group">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                        <?php
                                                                            if ( empty($row['BrandLogos']) ) {
                                                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                                            } else {
                                                                                echo '<img src="companyDetailsFolder/'.$row['BrandLogos'].'" class="img-responsive" alt="Avatar" />';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                                                    <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> Select image </span>
                                                                            <span class="fileinput-exists"> Change </span>
                                                                            <input class="form-control" type="file" name="BrandLogos" />
                                                                        </span>
                                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <!--<input type="submit" class="btn green" name="submitBrandLogos" id="btnSave_userAvatar" value="Save Changes" />-->
                                                            </div>
                                                            </form>
                                                       </center>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="BS">
                                                       <h4><strong>Business Structure</strong></h4>
                                                         <div class="row">
                                                             <div>
                                                                 <table class="table">
                                                                     <thead>
                                                                         <tr>
                                                                            <td></td>
                                                                             <td></td>
                                                                             <td>Supporting Files<i style="font-size:12px;color:orange;">(Upload)</i></td>
                                                                              <td></td>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                         <tr>
                                                                             <td> <?php if($row['SolePropreitorship'] !=''){ ?>
                                                                                    <input type="checkbox"  name="SolePropreitorship" value="" onchange="SolePropreitorship(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SolePropreitorship']=='Sole Propreitorship'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php }else{ ?>
                                                                                      <input type="checkbox"  name="SolePropreitorship" value="Sole Propreitorship" onchange="SolePropreitorship(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SolePropreitorship']=='Sole Propreitorship'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php } ?>
                                                                                    <label> Sole Proprietorship</label>
                                                                            </td>
                                                                             <?php if($row['SolePropreitorship'] !=''): ?>
                                                                             <td><a href="enterprise-details-download.php?pathSole=<?php echo $row['enterp_id']; ?>"><?php echo $row['SolePropreitorship_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>" disabled>
                                                                                      <input type="file" name="SolePropreitorship_File" class="form-control" disabled>
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitSole" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                             <?php if($row['GeneralPartnership'] !=''){ ?>
                                                                                  <input type="checkbox"  name="GeneralPartnership" value=""  onchange="GeneralPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GeneralPartnership']=='General Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                    <?php }else{ ?>
                                                                                    <input type="checkbox"  name="GeneralPartnership" value="General Partnership"  onchange="GeneralPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GeneralPartnership']=='General Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php } ?>
                                                                                    <label> General Partnership</label>
                                                                             </td>
                                                                             <?php if($row['GeneralPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathGP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GeneralPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>" disabled>
                                                                                      <input type="file" name="GeneralPartnership_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitGP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                             <?php if($row['Corporation'] !=''){ ?>
                                                                                  <input type="checkbox" name="Corporation" value="" onchange="Corporation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Corporation'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="Corporation" value="Corporation" onchange="Corporation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Corporation'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php } ?>
                                                                                 <label>Corporation</label>
                                                                             </td>
                                                                             <?php if($row['Corporation'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathCorp=<?php echo $row['enterp_id']; ?>"><?php echo $row['Corporation_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>" disabled>
                                                                                      <input type="file" name="Corporation_File" class="form-control" disabled>
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitCorp" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr> 
                                                                             <td>
                                                                             <?php if($row['LimitedLiabilityCompany'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityCompany" value="" onchange="LimitedLiabilityCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityCompany']=='Limited Liability Company'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityCompany" value="Limited Liability Company" onchange="LimitedLiabilityCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Corporation']=='Limited Liability Company'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php } ?>
                                                                                 <label>Limited Liability Company</label>
                                                                             </td>
                                                                             <?php if($row['LimitedLiabilityCompany'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLLC=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityCompany_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>" disabled>
                                                                                      <input type="file" name="LimitedLiabilityCompany_File" class="form-control" disabled>
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLLC" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                         <tr>
                                                                              <td>
                                                                             <?php if($row['LimitedPartnership'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedPartnership" value="" onchange="LimitedPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedPartnership']=='Limited Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedPartnership" value="Limited Partnership" onchange="LimitedPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedPartnership']=='Limited Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php } ?>
                                                                                 <label>Limited Partnership</label>
                                                                             </td>
                                                                             <?php if($row['LimitedPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>" disabled>
                                                                                      <input type="file" name="LimitedPartnership_File" class="form-control" disabled>
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                            <td>
                                                                             <?php if($row['LimitedLiabilityPartnership'] !=''){ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityPartnership" value="" onchange="LimitedLiabilityPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityPartnership']=='Limited Liability Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="LimitedLiabilityPartnership" value="Limited Liability Partnership" onchange="LimitedLiabilityPartnership(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['LimitedLiabilityPartnership']=='Limited Liability Partnership'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php } ?>
                                                                                 <label>Limited Liability Partnership</label>
                                                                             </td>
                                                                             <?php if($row['LimitedLiabilityPartnership'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathLPP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityPartnership_File']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="LimitedLiabilityPartnership_File" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitLPP" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                          <tr>
                                                                              <td>
                                                                             <?php if($row['othersBusinessStructure'] !=''){ ?>
                                                                                  <input type="checkbox" name="othersBusinessStructure" value="" onchange="othersBusinessStructure(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['othersBusinessStructure']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  
                                                                                  <?php }else{ ?>
                                                                                  <input type="checkbox" name="othersBusinessStructure" value="Others" onchange="othersBusinessStructure(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['othersBusinessStructure']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                  <?php } ?>
                                                                                 <label> Others (Please Specify)</label>
                                                                                 <?php if($row['othersBusinessStructure'] !=''){ ?>
                                                                                 <input name="BusinessStructureSpecify" class="form-control" value="<?php echo $row['BusinessStructureSpecify']; ?>" onchange="BusinessStructureSpecify(this.value,'<?php echo $row['enterp_id']; ?>')">
                                                                                  <?php } ?>
                                                                             </td>
                                                                             <?php if($row['othersBusinessStructure'] !=''): ?>
                                                                              <td><a href="enterprise-details-download.php?pathOBS=<?php echo $row['enterp_id']; ?>"><?php echo $row['otherbStructurefile']; ?></a></td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                      <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" name="otherbStructurefile" class="form-control" >
                                                                                 </td>
                                                                                  <td>
                                                                                        <input type="submit" name="submitOBS" class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                             <?php endif; ?>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                             </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Annual Gross Revenue</strong></label>
                                                                    <input type="" id="" name="AnnualGrossRevenue" value="<?php echo $row['AnnualGrossRevenue']; ?>" class="form-control" onchange="AnnualGrossRevenue(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Trademarks </strong> &nbsp;
                                                            <?php if($row['trademarkStatus'] != ''){ ?>
                                                            <input type="checkbox" id="" name="trademarkStatus" value="" onchange="trademarkStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['trademarkStatus'] == 'None'){echo 'checked';}else{echo '';}?> disabled>
                                                            <?php }else{ ?>
                                                            <input type="checkbox" id="" name="trademarkStatus" value="None" onchange="trademarkStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['trademarkStatus'] == 'None'){echo 'checked';}else{echo '';}?> disabled>
                                                             <?php } ?>
                                                            <label> None</label>
                                                            &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>
                                                        </h4>
                                                        <?php if($row['trademarkStatus'] != 'None'){ ?>
                                                            <div class="row">
                                                                 <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Trademark Name(s):</strong></label>
                                                                        <input type="text" class=" form-control" name="TrademarkName" value=" <?php echo $row['TrademarkName']; ?>" onchange="TrademarkName(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['TrademarkName'] == 'None'){echo 'checked';}else{echo '';}?> disabled>
                                                                    </div>
                                                                </div>
                                                                
                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Supporting file:</strong> <a href="enterprise-details-download.php?pathTN=<?php echo $row['enterp_id']; ?>"><?php echo $row['TrademarkNameFile']; ?></a></label>
                                                                        <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                        <input type="file" class=" form-control" name="TrademarkNameFile" value="" disabled>
                                                                    </div>
                                                                </div>
                                                                 <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label class="control-label" style="color:transparent;"><strong>.....................</strong></label>
                                                                        <input type="submit" name="submitTN"  class="btn btn-success" value="Save">
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Tradename:</strong></label>
                                                                        <input type="text" class=" form-control" name="Tradename" value="<?php echo $row['Tradename']; ?>" onchange="Tradename(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <?php } ?>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="PC">
                                                        <h4><strong>Parent Company</strong></h4>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Parent Company Name:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyName" value="<?php echo $row['ParentCompanyName']; ?>" onchange="ParentCompanyName(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                             <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Address:</strong></label>
                                                                    <input type="text" class=" form-control" name="Headquarters" value="<?php echo $row['Headquarters']; ?>" onchange="Headquarters(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>City:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanycity" value="<?php echo $row['ParentCompanycity']; ?>" onchange="ParentCompanycity(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>State:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyStates" value="<?php echo $row['ParentCompanyStates']; ?>" onchange="ParentCompanyStates(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Zip Code:</strong></label>
                                                                    <input type="text" class=" form-control" name="ParentCompanyZipCode" value="<?php echo $row['ParentCompanyZipCode']; ?>" onchange="ParentCompanyZipCode(this.value,'<?php echo $row['enterp_id']; ?>')" disabled> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Year Established:</strong></label>
                                                                    <input type="" class=" form-control" name="YearEstablished" value="<?php echo $row['YearEstablished']; ?>" onchange="YearEstablished(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Dunn & Brad Street Number:</strong></label>
                                                                    <input type="text" class=" form-control" name="Dunn" value="<?php echo $row['Dunn']; ?>" onchange="Dunn(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                            <label class="control-label"><strong>What is your relationship with the enterprise?</strong></label>
                                                                </div>
                                                                <table class="table">
                                                                    <thead></thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['DirectEmployee'] !=''){ ?>
                                                                                <input type="checkbox" name="DirectEmployee" value="" onchange="DirectEmployee(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['DirectEmployee']=='Direct Employee'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="DirectEmployee" value="Direct Employee" onchange="DirectEmployee(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['DirectEmployee']=='Direct Employee'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Direct Employee</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['EmployeeofParentCompany'] !=''){ ?>
                                                                                <input type="checkbox" name="EmployeeofParentCompany" value="" onchange="EmployeeofParentCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['EmployeeofParentCompany']=='Employee of Parent Company'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="EmployeeofParentCompany" value="Employee of Parent Company" onchange="EmployeeofParentCompany(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['EmployeeofParentCompany']=='Employee of Parent Company'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Employee of Parent Company</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['SisterDivision'] !=''){ ?>
                                                                                <input type="checkbox" name="SisterDivision" value="" onchange="SisterDivision(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SisterDivision']=='Sister Division'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="SisterDivision" value="Sister Division" onchange="SisterDivision(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SisterDivision']=='Sister Division'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Sister Division</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Subsidiary'] !=''){ ?>
                                                                                <input type="checkbox" name="Subsidiary" value="" onchange="Subsidiary(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Subsidiary']=='Subsidiary'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Subsidiary" value="Subsidiary" onchange="Subsidiary(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Subsidiary']=='Subsidiary'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Subsidiary</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['ThirdParty'] !=''){ ?>
                                                                                <input type="checkbox" name="ThirdParty" value="" onchange="ThirdParty(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ThirdParty']=='Third Party'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="ThirdParty" value="Third Party" onchange="ThirdParty(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ThirdParty']=='Third Party'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Third Party</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['RelationshipEnterpriseStatus'] !=''){ ?>
                                                                                <input type="checkbox" name="RelationshipEnterpriseStatus" value="" onchange="RelationshipEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['RelationshipEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="RelationshipEnterpriseStatus" value="None" onchange="RelationshipEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['RelationshipEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> None</label>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <hr>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>What is your current position with the enterprise?  </strong></label>
                                                                </div>
                                                                <table class="table">
                                                                    <thead></thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['AccountPayable'] !=''){ ?>
                                                                                <input type="checkbox" name="AccountPayable" value="" onchange="AccountPayable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountPayable']=='Accounts Payable'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="AccountPayable" value="Accounts Payable" onchange="AccountPayable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountPayable']=='Accounts Payable'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Accounts Payable</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['InformationSystem'] !=''){ ?>
                                                                                <input type="checkbox" name="InformationSystem" value="" onchange="InformationSystem(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['InformationSystem']=='Information System'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="InformationSystem" value="Information System" onchange="InformationSystem(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['InformationSystem']=='Information System'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php } ?>
                                                                                <label> Information System</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['CFO'] !=''){ ?>
                                                                                <input type="checkbox" name="CFO" value="" onchange="CFO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CFO']=='CFO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="CFO" value="CFO" onchange="CFO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CFO']=='CFO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php } ?>
                                                                                <label> CFO</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Insurance'] !=''){ ?>
                                                                                <input type="checkbox" name="Insurance" value="" onchange="Insurance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Insurance']=='Insurance'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Insurance" value="Insurance" onchange="Insurance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Insurance']=='Insurance'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Insurance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['PrimaryAccountRepresntative'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="PrimaryAccountRepresntative" value="" onchange="PrimaryAccountRepresntative(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimaryAccountRepresntative']=='Primary Account Representative'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="PrimaryAccountRepresntative" value="Primary Account Representative" onchange="PrimaryAccountRepresntative(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimaryAccountRepresntative']=='Primary Account Represntative'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Primary Account Representative</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['CEO'] !=''){ ?>
                                                                                <input type="checkbox" name="CEO" value="" onchange="CEO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CEO']=='CEO'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="CEO" value="CEO" onchange="CEO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CEO']=='CEO'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> CEO</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Marketing'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="Marketing" value="" onchange="Marketing(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Marketing']=='Marketing'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="Marketing" value="Marketing" onchange="Marketing(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Marketing']=='Marketing'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Marketing</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['FoodSafety'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="FoodSafety" value="" onchange="FoodSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FoodSafety']=='Food Safety'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="FoodSafety" value="Food Safety" onchange="FoodSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FoodSafety']=='Food Safety'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Food Safety</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Operations'] !=''){ ?>
                                                                                <input type="checkbox" name="Operations" value="" onchange="Operations(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Operations']=='Operations'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Operations" value="Operations" onchange="Operations(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Operations']=='Operations'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Operations</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Executive'] !=''){ ?>
                                                                                <input type="checkbox" name="Executive" value="" onchange="Executive(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Executive']=='Executive'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Executive" value="Executive" onchange="Executive(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Executive']=='Executive'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Executive</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['AccountReceivable'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="AccountReceivable" value="" onchange="AccountReceivable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountReceivable']=='Accounts Receivable'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="AccountReceivable" value="Accounts Receivable" onchange="AccountReceivable(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['AccountReceivable']=='Accounts Receivable'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Accounts Receivable</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['ProductSafety'] !=''){ ?>
                                                                                <input type="checkbox" id="" name="ProductSafety" value="" onchange="ProductSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ProductSafety']=='Product Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" id="" name="ProductSafety" value="Product Safety" onchange="ProductSafety(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ProductSafety']=='Product Safety'){echo 'checked';}else{echo '';} ?>> 
                                                                                <?php } ?>
                                                                                <label> Product Safety</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Legal'] !=''){ ?>
                                                                                <input type="checkbox" name="Legal" value="" onchange="Legal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Legal']=='Legal'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Legal" value="Legal" onchange="Legal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Legal']=='Legal'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Legal</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Returns'] !=''){ ?>
                                                                                <input type="checkbox" name="Returns" value="" onchange="Returns(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Returns']=='Returns'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Returns" value="Returns" onchange="Returns(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Returns']=='Returns'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Returns</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Transportation'] !=''){ ?>
                                                                                <input type="checkbox" name="Transportation" value="" onchange="Transportation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Transportation']=='Transportation'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Transportation" value="Transportation" onchange="Transportation(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Transportation']=='Transportation'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Transportation</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Compliance'] !=''){ ?>
                                                                                <input type="checkbox" name="Compliance" value="" onchange="Compliance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Compliance']=='Compliance'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Compliance" value="Compliance" onchange="Compliance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Compliance']=='Compliance'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php } ?>
                                                                                <label> Compliance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Finance'] !=''){ ?>
                                                                                <input type="checkbox" name="Finance" value="" onchange="Finance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Finance']=='Finance'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Finance" value="Finance" onchange="Finance(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Finance']=='Finance'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Finance</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['HumanResources'] !=''){ ?>
                                                                                <input type="checkbox" name="HumanResources" value="" onchange="HumanResources(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HumanResources']=='Human Resources'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="HumanResources" value="Human Resources" onchange="HumanResources(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HumanResources']=='Human Resources'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Human Resources</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($row['Logistics'] !=''){ ?>
                                                                                <input type="checkbox" name="Logistics" value="" onchange="Logistics(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Logistics']=='Logistics'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Logistics" value="Logistics" onchange="Logistics(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Logistics']=='Logistics'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Logistics</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['PurchaseOrder'] !=''){ ?>
                                                                                <input type="checkbox" name="PurchaseOrder" value="" onchange="PurchaseOrder(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PurchaseOrder']=='Purchase Order'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="PurchaseOrder" value="Purchase Order" onchange="PurchaseOrder(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PurchaseOrder']=='Purchase Order'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Purchase Order</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Sales'] !=''){ ?>
                                                                                <input type="checkbox" name="Sales" value="" onchange="Sales(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Sales']=='Sales'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Sales" value="Sales" onchange="Sales(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Sales']=='Sales'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Sales</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['Orders'] !=''){ ?>
                                                                                <input type="checkbox" name="Orders" value="" onchange="Orders(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Orders']=='Orders'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="Orders" value="Orders" onchange="Orders(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Orders']=='Orders'){echo 'checked';}else{echo '';} ?> disabled> 
                                                                                <?php } ?>
                                                                                <label> Orders</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['positionEnterpriseStatus'] !=''){ ?>
                                                                                <input type="checkbox" name="positionEnterpriseStatus" value="" onchange="positionEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['positionEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php }else{ ?>
                                                                                <input type="checkbox" name="positionEnterpriseStatus" value="None" onchange="positionEnterpriseStatus(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['positionEnterpriseStatus']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                <?php } ?>
                                                                                <label> None</label>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Others</strong> <i>(Specify)</i></label>
                                                                    <input class="form-control" name="positionEnterpriseOthers" onchange="positionEnterpriseOthers(this.value,'<?php echo $row['enterp_id']; ?>')" value="<?php echo $row['positionEnterpriseOthers']; ?>" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="CA">
                                                       <h4><strong>Certification</strong></h4>
                                                         <div class="row">
                                                             <div>
                                                                 <table class="table">
                                                                     <thead>
                                                                         <tr>
                                                                            <td></td>
                                                                             <td></td>
                                                                             <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                             <td></td>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                         <tr>
                                                                             <td> 
                                                                                    <?php if($row['GFSI'] !=''){ ?>
                                                                                    <input type="checkbox" name="GFSI" value="" onchange="GFSI(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GFSI']=='GFSI'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php }else{ ?>
                                                                                     <input type="checkbox" name="GFSI" value="GFSI" onchange="GFSI(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GFSI']=='GFSI'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php } ?>
                                                                                    <label> GFSI</label>
                                                                            </td>
                                                                            <?php if($row['GFSI'] !=''){ ?>
                                                                            <td>
                                                                                <a href="enterprise-details-download.php?pathCSP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GFSIFILE']; ?></a>
                                                                            </td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                     <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" class="form-control" name="GFSIFILE">
                                                                                 </td>
                                                                                 <td>
                                                                                    <input type="submit" name="submitCSP"  class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                                    <?php if($row['SQF'] !=''){ ?>
                                                                                  <input type="checkbox" name="SQF" value="" onchange="SQF(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SQF']=='SQF'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php }else{ ?>
                                                                                    <input type="checkbox" name="SQF" value="SQF" onchange="SQF(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['SQF']=='SQF'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php } ?>
                                                                                    <label>SQF</label>
                                                                             </td>
                                                                             <?php if($row['SQF'] !=''){ ?>
                                                                            <td>
                                                                                <a href="enterprise-details-download.php?pathSQF=<?php echo $row['enterp_id']; ?>"><?php echo $row['SQFFILE']; ?></a>
                                                                            </td>
                                                                            <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                 <td>
                                                                                     <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                      <input type="file" class="form-control" name="SQFFILE">
                                                                                 </td>
                                                                                 <td>
                                                                                    <input type="submit" name="submitSQF"  class="btn btn-success" value="Save">
                                                                                 </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                           
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                              <?php if($row['BRC'] !=''){ ?>
                                                                                  <input type="checkbox" name="BRC" value="" onchange="BRC(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['BRC']=='BRC'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php }else{ ?>
                                                                                  <input type="checkbox" name="BRC" value="BRC" onchange="BRC(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['BRC']=='BRC'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php } ?>
                                                                                 <label>BRC</label>
                                                                             </td>
                                                                             <?php if($row['BRC'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathBRC=<?php echo $row['enterp_id']; ?>"><?php echo $row['BRCFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="BRCFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitBRC"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                 <?php if($row['FSSC22000'] !=''){ ?>
                                                                                 <input type="checkbox" name="FSSC22000" value="" onchange="FSSC22000(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FSSC22000']=='FSSC22000'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="FSSC22000" value="FSSC22000" onchange="FSSC22000(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FSSC22000']=='FSSC22000'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php } ?>
                                                                                 <label>FSSC22000</label>
                                                                             </td>
                                                                            <?php if($row['FSSC22000'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathFSSC=<?php echo $row['enterp_id']; ?>"><?php echo $row['FSSC22000FILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="FSSC22000FILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitFSSC"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                        <?php } ?>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                                <?php if($row['ISO'] !=''){ ?>
                                                                                 <input type="checkbox" name="ISO" value="" onchange="ISO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ISO']=='ISO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="ISO" value="ISO" onchange="ISO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ISO']=='ISO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php } ?>
                                                                                <label>ISO</label>
                                                                             </td>
                                                                            <?php if($row['ISO'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathISO=<?php echo $row['enterp_id']; ?>"><?php echo $row['ISOFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="ISOFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitISO"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                        <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                 <?php if($row['PrimusGFS'] !=''){ ?>
                                                                                 <input type="checkbox" name="PrimusGFS" value="" onchange="PrimusGFS(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimusGFS']=='Primus GFS'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="PrimusGFS" value="Primus GFS" onchange="PrimusGFS(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PrimusGFS']=='Primus GFS'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php } ?>
                                                                                    <label>PrimusGFS</label>
                                                                             </td>
                                                                             <?php if($row['PrimusGFS'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathHACCP=<?php echo $row['enterp_id']; ?>"><?php echo $row['PrimusGFSFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="PrimusGFSFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitPrimusGFS"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                <?php if($row['HACCP'] !=''){ ?>
                                                                                 <input type="checkbox" name="HACCP" value="" onchange="HACCP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HACCP']=='HACCP'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php }else{ ?>
                                                                                 <input type="checkbox" name="HACCP" value="HACCP" onchange="HACCP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['HACCP']=='HACCP'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                 <?php } ?>
                                                                                <label>HACCP</label>
                                                                             </td>
                                                                             <?php if($row['HACCP'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathHACCP=<?php echo $row['enterp_id']; ?>"><?php echo $row['HACCPFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="HACCPFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitHACCP"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                <?php if($row['GMP'] !=''){ ?>
                                                                                 <input type="checkbox" name="GMP" value="" onchange="GMP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GMP']=='GMP'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                    <?php }else{ ?>
                                                                                    <input type="checkbox" name="GMP" value="GMP" onchange="GMP(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['GMP']=='GMP'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php } ?>
                                                                                    <label>GMP</label>
                                                                             </td>
                                                                              <?php if($row['GMP'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathGMP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GMPFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="GMPFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitGMP"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                          <tr>
                                                                             <td>
                                                                                    <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                  <input type="checkbox" name="CertificationOthers" value="" onchange="CertificationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CertificationOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php }else{ ?>
                                                                                   <input type="checkbox" name="CertificationOthers" value="Others" onchange="CertificationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['CertificationOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php } ?>
                                                                                    <label>Others (Please Specify)</label><br>
                                                                                    <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                    <input class=" form-control" id="boxBS" name="othersCertificationSpecify" value="<?php echo $row['othersCertificationSpecify']; ?>" onchange="othersCertificationSpecify(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                                    <?php } ?>
                                                                             </td>
                                                                             <?php if($row['CertificationOthers'] !=''){ ?>
                                                                                <td>
                                                                                    <a href="enterprise-details-download.php?pathcOther=<?php echo $row['enterp_id']; ?>"><?php echo $row['OthersFILE']; ?></a>
                                                                                </td>
                                                                                <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                     <td>
                                                                                         <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                          <input type="file" class="form-control" name="OthersFILE">
                                                                                     </td>
                                                                                     <td>
                                                                                        <input type="submit" name="submitcOther"  class="btn btn-success" value="Save">
                                                                                     </td>
                                                                             </form>
                                                                              <?php } ?>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                                 
                                                             </div>
                                                        </div>
                                                         <h4><strong>Accreditation</strong></h4>
                                                             <div class="row" >
                                                                 <div>
                                                                     <table class="table">
                                                                         <thead>
                                                                             <tr>
                                                                               <td></td>
                                                                                 <td></td>
                                                                                 <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                                 <td></td>
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td> 
                                                                                     <?php if($row['Organic'] !=''){ ?>
                                                                                        <input type="checkbox" name="Organic" value="" onchange="Organic(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Organic']=='Organic'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                        <?php }else{ ?>
                                                                                          <input type="checkbox" name="Organic" value="Organic" onchange="Organic(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Organic']=='Organic'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                        <?php } ?>
                                                                                        <label> Organic</label>
                                                                                </td>
                                                                                 <?php if($row['Organic'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathOrganic=<?php echo $row['enterp_id']; ?>"><?php echo $row['OrganicFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="OrganicFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitOrganic"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                    <?php if($row['Halal'] !=''){ ?>
                                                                                      <input type="checkbox" name="Halal" value="" onchange="Halal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Halal']=='Halal'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php }else{ ?>
                                                                                       <input type="checkbox" name="Halal" value="Halal" onchange="Halal(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Halal']=='Halal'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php } ?>
                                                                                        <label>Halal</label>
                                                                                 </td>
                                                                                 <?php if($row['Halal'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathHalal=<?php echo $row['enterp_id']; ?>"><?php echo $row['HalalFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="HalalFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitHalal"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                               
                                                                             </tr>
                                                                              <tr>
                                                                                 <td>
                                                                                     <?php if($row['Kosher'] !=''){ ?>
                                                                                      <input type="checkbox" name="Kosher" value="" onchange="Kosher(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Kosher']=='Kosher'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                      <?php }else{ ?>
                                                                                      <input type="checkbox" name="Kosher" value="Kosher" onchange="Kosher(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['Kosher']=='Kosher'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                      <?php } ?>
                                                                                     <label>Kosher</label>
                                                                                 </td>
                                                                                 <?php if($row['Kosher'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathKosher=<?php echo $row['enterp_id']; ?>"><?php echo $row['KosherFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="KosherFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitKosher"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                              <tr>
                                                                                 <td>
                                                                                 <?php if($row['NonGMO'] !=''){ ?>
                                                                                     <input type="checkbox" name="NonGMO" value="" onchange="NonGMO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['NonGMO']=='Non-GMO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php }else{ ?>
                                                                                     <input type="checkbox" name="NonGMO" value="Non-GMO" onchange="NonGMO(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['NonGMO']=='Non-GMO'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                     <?php } ?>
                                                                                     <label>Non-GMO</label>
                                                                                 </td>
                                                                                  <?php if($row['NonGMO'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathNonGMO=<?php echo $row['enterp_id']; ?>"><?php echo $row['NonGMOFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="NonGMOFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitNonGMO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                                
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                  <?php if($row['PlantBased'] !=''){ ?>
                                                                                     <input type="checkbox" name="PlantBased" value="" onchange="PlantBased(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PlantBased']=='Plant Based'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                    <?php }else{ ?>
                                                                                     <input type="checkbox" name="PlantBased" value="Plant Based" onchange="PlantBased(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['PlantBased']=='Plant Based'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                   <?php } ?>
                                                                                    <label>Plant Based</label>
                                                                                 </td>
                                                                                 <?php if($row['PlantBased'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathPlantBased=<?php echo $row['enterp_id']; ?>"><?php echo $row['PlantBasedFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="PlantBasedFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitPlantBased"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             
                                                                              <tr>
                                                                                 <td>
                                                                                    <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                      <input type="checkbox" name="FacilityAccreditationOthers" value="" onchange="FacilityAccreditationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                      <?php }else{ ?>
                                                                                       <input type="checkbox" name="FacilityAccreditationOthers" value="Others" onchange="FacilityAccreditationOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                      <?php } ?>
                                                                                        <label>Others (Please Specify)</label><br>
                                                                                        <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                        <input class="form-control" id="boxBS"  name="FacilityAccreditationSpecify" value="<?php echo $row['FacilityAccreditationSpecify']; ?>" onchange="FacilityAccreditationSpecify(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                                        <?php } ?>
                                                                                       
                                                                                 </td>
                                                                                 <?php if($row['FacilityAccreditationOthers'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathFAO=<?php echo $row['enterp_id']; ?>"><?php echo $row['othersAccreditationFile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="othersAccreditationFile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitFAO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                    <?php if($row['FacilityAccreditationNone'] !=''){ ?>
                                                                                     <input type="checkbox" name="FacilityAccreditationNone" value="" onchange="FacilityAccreditationNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationNone']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                    <?php }else{ ?>
                                                                                     <input type="checkbox" name="FacilityAccreditationNone" value="None" onchange="FacilityAccreditationNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FacilityAccreditationNone']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                    <?php } ?>
                                                                                    <label>None</label>
                                                                                 </td>
                                                                                 <td>
                                                                                    
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                     
                                                                 </div>
                                                            </div>
                                                    </div>
                                                    <!--end-->
                                                     <!--start-->
                                                    <div class="tab-pane" id="Regulatory">
                                                        <h4><strong>Regulatory Compliance Requirements</strong></h4>
                                                             <div class="row">
                                                                 <div>
                                                                     <table class="table">
                                                                         <thead>
                                                                             <tr>
                                                                                <td></td>
                                                                                 <td></td>
                                                                                 <td>Supporting Files<i style="color:orange;font-size:12px;">(Upload)</i></td>
                                                                                 <td></td>
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td> 
                                                                                        <?php if($row['FDA'] !=''){ ?>
                                                                                        <input type="checkbox" name="FDA" value="" onchange="FDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FDA']=='FDA'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                        <?php }else{ ?>
                                                                                        <input type="checkbox" name="FDA" value="FDA" onchange="FDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['FDA']=='FDA'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                        <?php } ?>
                                                                                        <label> FDA</label>
                                                                                </td>
                                                                                 <?php if($row['FDA'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathFDA=<?php echo $row['enterp_id']; ?>"><?php echo $row['FDAfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="FDAfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitFDA"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                             <tr>
                                                                                 <td>
                                                                                     <?php if($row['USDA'] !=''){ ?>
                                                                                      <input type="checkbox" name="USDA" value="" onchange="USDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['USDA']=='USDA'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php }else{ ?>
                                                                                        <input type="checkbox" name="USDA" value="USDA" onchange="USDA(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['USDA']=='USDA'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php } ?>
                                                                                        <label>USDA</label>
                                                                                 </td>
                                                                                  <?php if($row['USDA'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathUSDA=<?php echo $row['enterp_id']; ?>"><?php echo $row['USDAfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="USDAfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitUSDA"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                               
                                                                             </tr>
                                                                            
                                                                              <tr>
                                                                                 <td>
                                                                                    <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                      <input type="checkbox"  name="ComplianceRequirementsOthers" value="" onchange="ComplianceRequirementsOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php }else{ ?>
                                                                                       <input type="checkbox"  name="ComplianceRequirementsOthers" value="Others" onchange="ComplianceRequirementsOthers(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthers']=='Others'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                       <?php } ?>
                                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                                        <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                        <input class=" form-control" id="boxBS" name="ComplianceRequirementsOthersSpecify" value="<?php echo $row['ComplianceRequirementsOthersSpecify']; ?>" onchange="ComplianceRequirementsOthersSpecify(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                                         <?php } ?>
                                                                                 </td>
                                                                                 <?php if($row['ComplianceRequirementsOthers'] !=''){ ?>
                                                                                    <td>
                                                                                        <a href="enterprise-details-download.php?pathCRO=<?php echo $row['enterp_id']; ?>"><?php echo $row['ComplianceRequirementsfile']; ?></a>
                                                                                    </td>
                                                                                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                                         <td>
                                                                                             <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                              <input type="file" class="form-control" name="ComplianceRequirementsfile">
                                                                                         </td>
                                                                                         <td>
                                                                                            <input type="submit" name="submitCRO"  class="btn btn-success" value="Save">
                                                                                         </td>
                                                                                 </form>
                                                                                  <?php } ?>
                                                                             </tr>
                                                                               <tr>
                                                                                 <td>
                                                                                    <?php if($row['ComplianceRequirementsOthersNone'] !=''){ ?>
                                                                                      <input type="checkbox" name="ComplianceRequirementsOthersNone" value="" onchange="ComplianceRequirementsOthersNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthersNone']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                         <?php }else{ ?>
                                                                                          <input type="checkbox" name="ComplianceRequirementsOthersNone" value="None" onchange="ComplianceRequirementsOthersNone(this.value,'<?php echo $row['enterp_id']; ?>')" <?php if($row['ComplianceRequirementsOthersNone']=='None'){echo 'checked';}else{echo '';} ?> disabled>
                                                                                         
                                                                                         <?php } ?>
                                                                                        <label>None</label>
                                                                                 </td>
                                                                                 
                                                                               
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                     
                                                                 </div>
                                                            </div>
                                                    </div>
                                                    <!--end--> 
                                                     <!--start-->
                                                    <div class="tab-pane" id="Rec">
                                                       <h5><strong>Enterprise Records  &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>&nbsp;<i style="font-size:12px;background-color:orange;color:#fff;">Examples (Tax ID, Corporate Documents, Partnerhip agreements, certificates, accreditations, etc.)</i></strong></h5>
                                                        <div class="row">
                                                            <table class="table">
                                                                 <thead>
                                                                    <tr>
                                                                        <td>Document &nbsp; <a href="enterprise-details-download.php?pathERF=<?php echo $row['enterp_id']; ?>"><?php echo $row['EnterpriseRecordsFile']; ?></a></td>
                                                                        <td></td>
                                                                        <td>Title </td>
                                                                        <td>Description </td>
                                                                        <td>Document Due Date</td>
                                                                    </tr>
                                                                </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                         <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                                                                            <td>
                                                                                <input type="hidden" name="ids" class="form-control" value="<?php echo $row['enterp_id']; ?>">
                                                                                <input type="file" class="form-control" name="EnterpriseRecordsFile" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <input type="submit" name="submitERF"  class="btn btn-success" value="Save">
                                                                            </td>
                                                                            </form>
                                                                            <td>
                                                                                <input class="form-control" name="DocumentTitle" value="<?php echo $row['DocumentTitle']; ?>" onchange="DocumentTitle(this.value,'<?php echo $row['enterp_id']; ?>')" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <textarea class="form-control" name="DocumentDesciption" onchange="DocumentDesciption(this.value,'<?php echo $row['enterp_id']; ?>')" disabled><?php echo $row['DocumentDesciption']; ?></textarea>
                                                                            </td>
                                                                            <td>
                                                                                <input type="date" class="form-control" name="DocumentDueDate" onchange="DocumentDueDate(this.value,'<?php echo $row['enterp_id']; ?>')" value="<?php echo  date("Y-m-d", strtotime($row['DocumentDueDate']));?>" disabled>
                                                                            </td>
                                                                        </tr>
                                                                </tbody>
                                                            </table>
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
          
          
          <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="btnContactMoreUpdate" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>   
        <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetEmergencyContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Emergency: Contact Person</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="btnEmergencyMoreUpdate" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
         <!--view re modal-->
         <div class="modal fade bs-modal-lg" id="modalGetRecord" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Enterprise Records</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="submitERFUpdate" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Free Add Facility Category modal MODAL AREA-->
        <div class="modal fade" id="addFacilityModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD Facility</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Facilty Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="facility_category" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnFacilityMore" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!--Free Add Contact Person modal MODAL AREA-->
        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD CONTACT PERSON</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="contactpersonname" id="contactpersonname" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="contactpersonlastname" id="contactpersonlastname" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="titles" id="titles"required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Cell No.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="contactpersoncellno" name="contactpersoncellno" />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Phone</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="contactpersonphone" name="contactpersonphone" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>FAX</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="contactpersonfax" name="contactpersonfax" value="">
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Email Address</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="contactpersonemailAddress" name="contactpersonemailAddress" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnContactMore" value="Insert" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Free Add Contact Person modal-->
    <!--Free Add Contact Person modal MODAL AREA-->
        <div class="modal fade" id="addEmergencyContactModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD CONTACT EMERGENCY PERSON</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="emergencyname" id="emergencyname" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="emergencycontact_last_name" id="emergencycontact_last_name" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="emergency_contact_title" id="emergency_contact_title"required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Cell No.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="emergencycellno" name="emergencycellno" />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Phone</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="emergencyphone" name="emergencyphone" id="emergencyphone" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>FAX</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="emergencyfax" name="emergencyfax" value="">
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Email Address</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="emergencyemailAddress" name="emergencyemailAddress" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnEmergencyMore" value="Insert" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Free Add Contact Person modal-->
         <!--Free Add Contact Person modal MODAL AREA-->
        <div class="modal fade" id="addRecordModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="enterprise-information-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD ENTEPRISE RECORD</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="file" name="EnterpriseRecordsFile" id="EnterpriseRecordsFile" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document Title</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="DocumentTitle" id="DocumentTitle" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Desciption</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="DocumentDesciption" id="DocumentDesciption" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document Due Date</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="date" id="DocumentDueDate" name="DocumentDueDate" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="submitERFS" value="Insert" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Free Add Contact Person modal-->
        
        <!--Emjay modal-->
                        
       <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" action="controller.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Upload Demo Video</h4>
                        </div>
                        <div class="modal-body">
                                <label>Video Title</label>
                                <input type="text" id="file_title" name="file_title" class="form-control mt-2">
                                <?php if($switch_user_id != ''): ?>
                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">
                                <?php else: ?>
                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $current_userEmployerID ?>">
                                <?php endif; ?>
                                <label style="margin-top:15px">Video Link</label>
                                <!--<input type="file" id="file" name="file" class="form-control mt-2">-->
                                <input type="text" class="form-control" name="youtube_link">
                                <input type="hidden" name="page" value="<?= $site ?>">

                                <!--<label style="margin-top:15px">Privacy</label>-->
                                <!--<select class="form-control" name="privacy" id="privacy" required>-->
                                <!--    <option value="Private">Private</option>-->
                                <!--    <option value="Public">Public</option>-->
                                <!--</select>-->
                            
                            <div style="margin-top:15px" id="message">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                            <button type="submit" class="btn btn-success" name="save_video"><span id="save_video_text">Save</span></button>
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
                            <!--<video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">-->
                            <!--  <source src="" >-->
                            <!--    Your browser does not support the video tag.-->
                            <!--</video>-->
                            <!--<iframe id="myVideo" class="embed-responsive-item" width="320" height="240" src="" allowfullscreen></iframe>-->
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="myVideo" class="embed-responsive-item" width="560" height="315" src="" allowfullscreen></iframe>
                             </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
                        
        <?php include_once ('footer.php'); ?>
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
               // Emjay script starts here
               fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "enterprise-info";
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
    			
    // 			$('.view_videos').click(function(){
    // 			    var file_name = $(this).attr('file_name')
    // 			    var file_name = $(this).attr('file_name')
    // 			    $("#myVideo").attr('src', file_name);
    // 			});
    			
                // Emjay script ends here 
            });
        </script>
      <script>
      // View  Contact
         $(".btnViewCon").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "enterprise-function/fetch-contact.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetContact .modal-body").html(data);
                       
                    }
                });
            });
      // View Emergency Contact
         $(".btnView").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "enterprise-function/fetch-emergency-contact.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetEmergencyContact .modal-body").html(data);
                       
                    }
                });
            });
            // View Enterprise Record
         $(".btnViewRec").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "enterprise-function/fetch-record.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetRecord .modal-body").html(data);
                       
                    }
                });
            });
         // for New
          function LegalNameNew(value){  
              let url = "enterprise-information-addfunction";  
              window.location.href= url+"?LegalNameNew="+value;  
          } 
        //  for update
        function LegalNameUpdate(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&LegalNameUpdate="+value;  
         }
          function country(value,id){   
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&country="+value;  
         }
        
         function Bldg(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Bldg="+value; 
         }
          function city(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&city="+value; 
         }
          function States(value,id){   
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&States="+value; 
         }
          function ZipCode(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ZipCode="+value; 
         }
          function businesstelephone(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&businesstelephone="+value; 
         }
         function businessfax(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&businessfax="+value; 
         }
         function businessemailAddress(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&businessemailAddress="+value; 
         }
         function businesswebsite(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&businesswebsite="+value; 
         }
         function contactpersonname(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersonname="+value; 
         }
         function contactpersonlastname(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersonlastname="+value; 
         }
         function titles(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&titles="+value; 
         }
         function contactpersoncellno(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersoncellno="+value; 
         }
         function contactpersonphone(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersonphone="+value; 
         }
         function contactpersonfax(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersonfax="+value; 
         }
         function contactpersonemailAddress(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&contactpersonemailAddress="+value; 
         }
         function emergencyname(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencyname="+value; 
         }
         function emergencycontact_last_name(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencycontact_last_name="+value; 
         }
         function emergency_contact_title(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergency_contact_title="+value; 
         }
         function emergencycellno(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencycellno="+value; 
         }
         function emergencyphone(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencyphone="+value; 
         }
         function emergencyfax(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencyfax="+value; 
         }
         function emergencyemailAddress(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&emergencyemailAddress="+value; 
         }
         function BusinessStructure(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&BusinessStructure="+value; 
         }
         function SolePropreitorship(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&SolePropreitorship="+value; 
         }
         function GeneralPartnership(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&GeneralPartnership="+value; 
         }
         function Corporation(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Corporation="+value; 
         }
         function LimitedLiabilityCompany(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&LimitedLiabilityCompany="+value; 
         }
         function LimitedPartnership(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&LimitedPartnership="+value; 
         }
         
         function LimitedLiabilityPartnership(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&LimitedLiabilityPartnership="+value; 
         }
         function othersBusinessStructure(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&othersBusinessStructure="+value; 
         }
         function BusinessStructureSpecify(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&BusinessStructureSpecify="+value; 
         }
         function BusinessPurpose(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&BusinessPurpose="+value; 
         }
         function AnnualGrossRevenue(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&AnnualGrossRevenue="+value; 
         }
         function trademarkStatus(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&trademarkStatus="+value; 
         }
         function TrademarkName(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&TrademarkName="+value; 
         }
         function Tradename(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Tradename="+value; 
         }
         function ParentCompanyStates(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ParentCompanyStates="+value; 
         }
         function ParentCompanycity(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ParentCompanycity="+value; 
         }
         function Headquarters(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Headquarters="+value; 
         }
         function ParentCompanyZipCode(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ParentCompanyZipCode="+value; 
         }
         function ParentCompanyName(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ParentCompanyName="+value; 
         }
         function YearEstablished(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&YearEstablished="+value; 
         }
         function Dunn(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Dunn="+value; 
         }
         function DirectEmployee(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&DirectEmployee="+value; 
         }
         function EmployeeofParentCompany(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&EmployeeofParentCompany="+value; 
         }
         function SisterDivision(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&SisterDivision="+value; 
         }
         function Subsidiary(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Subsidiary="+value; 
         }
         function ThirdParty(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ThirdParty="+value; 
         }
         function RelationshipEnterpriseStatus(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&RelationshipEnterpriseStatus="+value; 
         }
         function AccountPayable(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&AccountPayable="+value; 
         }
         function InformationSystem(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&InformationSystem="+value; 
         }
         function CFO(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&CFO="+value; 
         }
         function Insurance(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Insurance="+value; 
         }
         function PrimaryAccountRepresntative(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&PrimaryAccountRepresntative="+value; 
         }
         function CEO(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&CEO="+value; 
         }
         function Marketing(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Marketing="+value; 
         }
         function FoodSafety(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FoodSafety="+value; 
         }
         function Operations(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Operations="+value; 
         }
         function Executive(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Executive="+value; 
         }
         function AccountReceivable(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&AccountReceivable="+value; 
         }
         function ProductSafety(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ProductSafety="+value; 
         }
         function Legal(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Legal="+value; 
         }
         function Returns(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Returns="+value; 
         }
         function Transportation(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Transportation="+value; 
         }
         function Compliance(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Compliance="+value; 
         }
         function Finance(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Finance="+value; 
         }
         function HumanResources(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&HumanResources="+value; 
         }
         function Logistics(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Logistics="+value; 
         }
         function PurchaseOrder(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&PurchaseOrder="+value; 
         }
         function Sales(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Sales="+value; 
         }
         function Orders(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Orders="+value; 
         }
         function positionEnterpriseStatus(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&positionEnterpriseStatus="+value; 
         }
         function positionEnterpriseOthers(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&positionEnterpriseOthers="+value; 
         }
         function GFSI(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&GFSI="+value; 
         }
         function SQF(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&SQF="+value; 
         }
         function BRC(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&BRC="+value; 
         }
         function FSSC22000(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FSSC22000="+value; 
         }
         function ISO(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ISO="+value; 
         }
         function PrimusGFS(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&PrimusGFS="+value; 
         }
         function HACCP(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&HACCP="+value; 
         }
         function GMP(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&GMP="+value; 
         }
         function CertificationOthers(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&CertificationOthers="+value; 
         }
         function othersCertificationSpecify(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&othersCertificationSpecify="+value; 
         }
         function Organic(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Organic="+value; 
         }
         function Halal(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Halal="+value; 
         }
         function Kosher(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Kosher="+value; 
         }
         function NonGMO(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&NonGMO="+value; 
         }
         function PlantBased(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&PlantBased="+value; 
         }
         function FacilityAccreditationOthers(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FacilityAccreditationOthers="+value; 
         }
         function FacilityAccreditationSpecify(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FacilityAccreditationSpecify="+value; 
         }
         function FacilityAccreditationNone(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FacilityAccreditationNone="+value; 
         }
         function FDA(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&FDA="+value; 
         }
         function USDA(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&USDA="+value; 
         }
         function ComplianceRequirementsOthers(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ComplianceRequirementsOthers="+value; 
         }
         function ComplianceRequirementsOthersSpecify(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ComplianceRequirementsOthersSpecify="+value; 
         }
         function ComplianceRequirementsOthersNone(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ComplianceRequirementsOthersNone="+value; 
         }
         function DocumentTitle(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&DocumentTitle="+value; 
         }
         function DocumentDesciption(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&DocumentDesciption="+value; 
         }
         function DocumentDueDate(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&DocumentDueDate="+value; 
         }
         function enterpriseOperation(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseOperation="+value; 
         }
        function enterpriseEmployees(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseEmployees="+value; 
         }
         function enterpriseImporter(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseImporter="+value; 
         }
         function enterpriseProducts(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseProducts="+value; 
         }
         function enterpriseServices(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseServices="+value; 
         }
         function NumberofEmployees(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&NumberofEmployees="+value; 
         }
         function Country_importer(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Country_importer="+value; 
         }
         function ProductDesc(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&ProductDesc="+value; 
         }
         function enterpriseexporter(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&enterpriseexporter="+value; 
         }
         function Country_exporter(value,id){  
           let url = "enterprise-information-function";  
           window.location.href= url+"?id="+id+"&Country_exporter="+value; 
         }
         
        </script>
        
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
       <style>
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
