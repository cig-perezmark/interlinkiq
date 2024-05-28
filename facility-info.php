
<?php 
error_reporting(0);
    $title = "Facility Information";
    
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Facility Information';
    $site = "facility-info";
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
                                                    <span class="caption-subject font-dark bold uppercase">Facility Details</span>
                                                    <?php
                                                        if($current_client == 0 OR $current_userEmployeeID == 78) {
                                                            $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo ' - <a class="view_videos" data-src="'.$row['youtube_link'].'" data-fancybox><i class="fa fa-youtube"></i> '.$row['file_title'].'</a>';
                                                            }
                                                
                                                            if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163 OR $current_userEmployeeID == 78) {
                                                                echo ' <a href="#modal_video" class="btn btn-circle btn-success btn-xs" data-toggle="modal">Add Demo Video</a>';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#EI" data-toggle="tab">Facility Information</a>
                                                    </li> 
                                                     <li>
                                                        <a href="#ro" data-toggle="tab"><?php echo $_COOKIE['client'] == 1 ? 'Licenses and Permits':'Registration / Organization'; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="#cc" data-toggle="tab">Crisis Management / Customer Service</a>
                                                    </li>
                                                     <li>
                                                        <a href="#fo" data-toggle="tab">Functions (Operations)</a>
                                                    </li>
                                                     <li>
                                                        <a href="#CA" data-toggle="tab">Certification / Accreditation</a>
                                                    </li>
                                                    <?php if($_COOKIE['client'] != 1 ): ?>
                                                        <li>
                                                            <a href="#aq" data-toggle="tab">Allergens / Quality System</a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="#ppf" data-toggle="tab"><?php if($_COOKIE['client'] == 1 ){ echo 'Premises';}else{echo 'Physical Plant / Facilities ';} ?></a>
                                                    </li>
                                                    <?php if($_COOKIE['client'] == 1 or $_COOKIE['ID'] == 38): ?>
                                                         <li>
                                                            <a href="#bond" data-toggle="tab">Insurance and Bond</a>
                                                        </li>
                                                        <li>
                                                            <a href="#vehicles" data-toggle="tab">Vehicles</a>
                                                        </li>
                                                        <li>
                                                            <a href="#deficiency" data-toggle="tab">Deficiency Notices</a>
                                                        </li>
                                                    <?php endif; ?>
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
                                                    $getids = $_GET['facility_id'];
                                                    $query = "SELECT * FROM tblFacilityDetails where  facility_id = '$getids' ";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result)) {
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
                                                           <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label class="control-label"><strong>Facility Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['facility_id'];}else{ echo '';} ?>" required> 
                                                                    <input type="" class="form-control" name="facility_category" value="<?php echo $row['facility_category']; ?>" > 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <select class="form-control mt-multiselects" name="countrys" >
                                                                        <option value="0">---Select---</option>
                                                                        
                                                                        <?php 
                                                                            while($rowcountry = mysqli_fetch_array($resultcountry)) {
                                                                                echo '<option value="'.$rowcountry['id'].'" '; echo $rowcountry['id'] == $row['country'] ? 'SELECTED':''; echo '>'.utf8_encode($rowcountry['name']).'</option>';
                                                                            }
                                                                        ?>                                                                        
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
                                                                        <td>Email address</td>
                                                                        <td>Website</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input type="text" min="6" class=" form-control" name="facility_phone" value="<?php echo $row['facility_phone']; ?>"></td>
                                                                        <td><input type="text" class=" form-control" name="facility_fax" value="<?php echo $row['facility_fax']; ?>" ></td>
                                                                        <td><input type="email" class=" form-control" name="facility_Address" value="<?php echo $row['facility_Address']; ?>"></td>
                                                                        <td><input type="" class=" form-control" name="facility_website" value="<?php echo $row['facility_website']; ?>"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="submit" name="submitFacility_Details" value="Save Changes" class="btn btn-success">
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
                                                                        <td>Email address</td>
                                                                        <td></td>
                                                                    </tr>
                                                                </thead>
                                                                <?php 
                                                                    // $usersQuery = $_COOKIE['ID'];
                                                                    $usersQuery = $switch_user_id;
                                                                    $facility_id = $_GET['facility_id'];
                                                                    $queries = "SELECT * FROM tblFacilityDetails_contact where deleted = 0 AND user_cookies = $usersQuery and facility_entities = $facility_id ";
                                                                    $resultQuery = mysqli_query($conn, $queries);
                                                                    while($rowc = mysqli_fetch_array($resultQuery)){?>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td> 
                                                                                    <?php echo htmlentities($rowc['contactpersonname']); ?>
                                                                                </td>
                                                                                <td>  <?php echo htmlentities($rowc['contactpersonlastname']); ?></td>
                                                                                <td> <?php echo htmlentities($rowc['titles']); ?></td>
                                                                                <td>  <?php echo htmlentities($rowc['contactpersoncellno']); ?></td>
                                                                                <td> <?php echo htmlentities($rowc['contactpersonphone']); ?></td>
                                                                                <td>  <?php echo htmlentities($rowc['contactpersonfax']); ?></td>
                                                                                <td> <?php echo htmlentities($rowc['contactpersonemailAddress']); ?></td>
                                                                                <td style="text-align: right;">
                                                                                    <a class="btn blue btn-outline btnViewCon " data-toggle="modal" href="#modalGetContact" data-id="<?php echo $rowc["con_id"]; ?>">VIEW</a>
                                                                                    <a class="btn btn-outline red" onclick="btnDelete_F_Contact(<?php echo $rowc["con_id"]; ?>, this)">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    <?php } 
                                                                ?>
                                                            </table>
                                                        </div>
                                                        <hr >
                                                        <!--Business - EMERGENCY: Contact Person(s)-->
                                                        <h4><strong>Emergency: Contact Person(s)</strong> 
                                                        <!-- &nbsp;<input type="checkbox" id="" name="" value="" ><label for="Direct Buyer"> None</label>-->
                                                        &nbsp;<a data-toggle="modal" href="#addEmergencyContactModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
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
                                                                        <td>Email address</td>
                                                                        <td></td>
                                                                    </tr>
                                                                </thead>
                                                                <?php 
                                                                    // $usersQuery = $_COOKIE['ID'];
                                                                    $usersQuery = $switch_user_id;
                                                                    $facility_id = $_GET['facility_id'];
                                                                    $queries = "SELECT * FROM tblFacilityDetails_Emergency where deleted = 0 AND user_cookies = $usersQuery and emergency_contact_entities = $facility_id";
                                                                    $resultQuery = mysqli_query($conn, $queries);
                                                                    while($rowq = mysqli_fetch_array($resultQuery)){ ?>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td> <?php echo htmlentities($rowq['emergencyname']); ?></td>
                                                                                <td> <?php echo htmlentities($rowq['emergencycontact_last_name']); ?></td>
                                                                                <td> <?php echo htmlentities($rowq['emergency_contact_title']); ?></td>
                                                                                <td> <?php echo htmlentities($rowq['emergencycellno']); ?></td>
                                                                                <td> <?php echo htmlentities($rowq['emergencyphone']); ?></td>
                                                                                <td>  <?php echo htmlentities($rowq['emergencyfax']); ?></td>
                                                                                <td>  <?php echo htmlentities($rowq['emergencyemailAddress']); ?></td>
                                                                                <td style="text-align: right;">
                                                                                    <a class="btn blue btn-outline btnView " data-toggle="modal" href="#modalGetEmergencyContact" data-id="<?php echo $rowq["emerg_id"]; ?>">VIEW</a>
                                                                                    <a class="btn btn-outline red" onclick="btnDelete_F_Emergency(<?php echo $rowq["emerg_id"]; ?>, this)">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    <?php }
                                                                ?>
                                                            </table>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <!--end--> 
                                                    <!--start-->
                                                    <div class="tab-pane" id="ro">
                                                        <h4><strong><?php echo $_COOKIE['client'] == 1 ? 'Licensing and Permitting Requirements':'Regulatory Compliance Requirements'; ?></strong>&nbsp;<a data-toggle="modal" href="#addFacility_registration" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        
                                                        <div class="row">
                                                            <div class="table-scrollable">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Registration</th>
                                                                            <th>Supporting Files</th>
                                                                            <th>Registration Date</th>
                                                                            <th>Expiration Date</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="data_registration">
                                                                        <?php 
                                                                            $usersQuery = $_COOKIE['ID'];
                                                                            $facility_id = $_GET['facility_id'];
                                                                            $query_reg = mysqli_query($conn, "SELECT * FROM tblFacilityDetails_registration where ownedby = $switch_user_id and table_entities = 2 and facility_id = $facility_id");
                                                                            foreach($query_reg as $row_reg){ ?>
                                                                                <tr id="row_registration<?= $row_reg['reg_id']; ?>">
                                                                                    <td><?= htmlentities($row_reg['registration_name']); ?></td>
                                                                                    <td><a href="facility_files_Folder/<?= $row_reg['supporting_file']; ?>" target="_blank"><?= $row_reg['supporting_file']; ?></a></td>
                                                                                    <td><?= date('Y-m-d', strtotime($row_reg['registration_date'])); ?></td>
                                                                                    <td><?= date('Y-m-d', strtotime($row_reg['expiry_date'])); ?></td>
                                                                                    <td width="150px">
                                                                                        <div class="btn-group btn-group-circle">
                                                                                            <a  href="#modal_update_registration" data-toggle="modal" type="button" id="update_registration" data-id="<?=$row_reg['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                    	                    <a href="#modal_delete_registration" data-toggle="modal" type="button" id="delete_registration" data-id="<?=$row_reg['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <?php if($_COOKIE['client'] != 1 ): ?>
                                                            <h4><strong>Facility Organization</strong>&nbsp;<a data-toggle="modal" href="#addFacility_Organization" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                            <h4>Facility Representative</h4>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Title</th>
                                                                                <th>Phone</th>
                                                                                <th>Cell No</th>
                                                                                <th>Email</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                // $usersQuery = $_COOKIE['ID'];
                                                                                $usersQuery = $switch_user_id;
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $queries = "SELECT * FROM tblFacilityDetails_Facility_Organization where user_entities = $usersQuery and facility_entities = $facility_id  order by Org_id desc";
                                                                                $resultQuery = mysqli_query($conn, $queries);
                                                                                while($rowr = mysqli_fetch_array($resultQuery)){ ?>
                                                                                    <tr>
                                                                                        <td><?php echo htmlentities($rowr['Organization_name']); ?>&nbsp;<?php echo $rowr['Organization_last_name']; ?></td>
                                                                                        <td><?php echo htmlentities($rowr['Organization_title']); ?></td>
                                                                                        <td><?php echo htmlentities($rowr['Organization_cellno']); ?></td>
                                                                                        <td><?php echo htmlentities($rowr['Organization_phone']); ?></td>
                                                                                        <td><?php echo htmlentities($rowr['Organization_emailAddress']); ?></td>
                                                                                        <td>
                                                                                            <a class="btn blue btn-outline btnViewOrganization " data-toggle="modal" href="#modalGeFacilitytOrganization" data-id="<?php echo $rowr["Org_id"]; ?>" style="float:right;margin-right:20px;">VIEW</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--end-->
                                                    <!--start-->
                                                    <div class="tab-pane" id="cc">
                                                        <h4><strong>Crisis Management Team</strong> &nbsp;<a data-toggle="modal" href="#modalNew" class="btn btn-xs btn-primary"> <i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Primary Name</th>
                                                                            <th>Phone</th>
                                                                            <th>Email</th>
                                                                            <th>Alternate Name</th>
                                                                             <th>Phone</th>
                                                                            <th>Email</th>
                                                                            <td></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $i = 1;
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $facility_id = $_GET['facility_id'];
                                                                            $queriesPri = "SELECT * FROM tbl_critical_operation left join tbl_hr_employee on ID = addPrimaryNameField where user_cookies = $usersQuery and assign_area = $facility_id";
                                                                            $resultQuery = mysqli_query($conn, $queriesPri);
                                                                             
                                                                            while($rowPri = mysqli_fetch_array($resultQuery)){ 
                                                                                $alt = $rowPri['addAlternateNameField'];
                                                                                $altEmail = $rowPri['email'];
                                                                                
                                                                                $queriesAlt = "SELECT * FROM tbl_hr_employee where ID = $alt";
                                                                                $resultQueryAlt = mysqli_query($conn, $queriesAlt);
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++;  ?></td>
                                                                                    <td><?php echo $rowPri['first_name'];  ?> <?php echo $rowPri['last_name'];  ?></td>
                                                                                    <td></td>
                                                                                    <td><?php echo $rowPri['email'];  ?></td>
                                                                                     <?php while($rowAlt = mysqli_fetch_array($resultQueryAlt)){ ?>
                                                                                    <td>
                                                                                        <?php echo $rowAlt['first_name'];  ?> <?php echo $rowAlt['last_name'];  ?>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td> 
                                                                                        <?php echo $rowAlt['email'];  ?> 
                                                                                    </td>
                                                                                     <?php } ?>
                                                                                    <td></td>
                                                                                </tr>
                                                                            <?php }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Customer Service Team</strong>&nbsp;<a data-toggle="modal" href="#addService_Team" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Title</th>
                                                                            <th>Phone</th>
                                                                            <th>Cell No</th>
                                                                            <th>Email</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $facility_id = $_GET['facility_id'];
                                                                            $queries = "SELECT * FROM tblFacilityDetails_Service_Team where user_entities = $usersQuery and facility_entities = $facility_id order by Service_Team_id desc";
                                                                            $resultQuery = mysqli_query($conn, $queries);
                                                                            while($rowr = mysqli_fetch_array($resultQuery)){ ?>
                                                                                <tr>
                                                                                    <td><?php echo $rowr['Service_Team_name']; ?>&nbsp;<?php echo $rowr['Service_Team_last_name']; ?></td>
                                                                                    <td><?php echo $rowr['Service_Team_title']; ?></td>
                                                                                    <td><?php echo $rowr['Service_Team_cellno']; ?></td>
                                                                                    <td><?php echo $rowr['Service_Team_phone']; ?></td>
                                                                                    <td><?php echo $rowr['Service_Team_emailAddress']; ?></td>
                                                                                    <td>
                                                                                        <a class="btn blue btn-outline btnViewService_Team" data-toggle="modal" href="#modalGetService_Team" data-id="<?php echo $rowr["Service_Team_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <?php if($_COOKIE['client'] == 1 OR $_COOKIE['ID'] == 38): ?>
                                                            <hr>
                                                            <h4><strong>Community Relations Program</strong>&nbsp;<a data-toggle="modal" href="#addCST" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                            <div class="row">
                                                                <div class="table-scrollable" style="border:none;">
                                                                    <div class="col-md-12">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Title</th>
                                                                                    <th>Supporting Files</th>
                                                                                    <th>Expiration Date</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="data_cst">
                                                                                <?php 
                                                                                    $facility_id = $_GET['facility_id'];
                                                                                    $query_cst = mysqli_query($conn, "select * from tblFacilityDetails_community where enterprise_pk = $switch_user_id and facility_entities = $facility_id");
                                                                                    foreach($query_cst as $row_cst){?>
                                                                                        <tr id="row_cst<?= $row_cst['cst_pk']; ?>">
                                                                                            <td><?=$row_cst['cst_title']; ?></td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_cst['cst_files']; ?>" target="_blank"><?= $row_cst['cst_files']; ?></a></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_cst['expiry_date'])); ?></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_cst" data-toggle="modal" type="button" id="update_cst" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_cst" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--end-->
                                                     <!--start-->
                                                    <div class="tab-pane" id="CA">
                                                       <h4><strong>Accreditation</strong>&nbsp;<a data-toggle="modal" href="#addAccreditationModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Accreditation</th>
                                                                        <th>Type</th>
                                                                        <th>Description</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Expiration Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $i = 1;
                                                                        // $usersQuery = $_COOKIE['ID'];
                                                                        $usersQuery = $switch_user_id;
                                                                        $facility_id = $_GET['facility_id'];
                                                                        $queries = "SELECT * FROM tblFacilityDetails_Accreditation where user_cookies = $usersQuery and facility_entities = $facility_id  order by Accreditation_id desc";
                                                                        $resultQuery = mysqli_query($conn, $queries);
                                                                        while($rowAcc = mysqli_fetch_array($resultQuery)){ 
                                                                            $idate=date_create($rowAcc['Issue_Date_Type_Accreditation']);
                                                                            $edate=date_create($rowAcc['Expiration_Date_Type_Accreditation']);
                                                                        ?>

                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                <td><a href="facility_files_Folder/<?php echo $rowAcc['Accreditation']; ?>" target="_blank"><?php echo $rowAcc['Accreditation']; ?></a></td>
                                                                                <td><?php echo $rowAcc['Type_Accreditation']; ?></td>
                                                                                <td><?php echo $rowAcc['Descriptions_Accreditation']; ?></td>
                                                                                <td><?php echo date_format($idate,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($edate,"Y/m/d"); ?></td>
                                                                            </tr>
                                                                         <?php }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Accreditation History</strong></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date of Accreditation</th>
                                                                        <th>Audit Type</th>
                                                                        <th>Accreditation Segment</th>
                                                                        <th>Accreditation Authority</th>
                                                                        <th>Scope of Accreditation</th>
                                                                        <th>Accreditation Rating/Status</th>
                                                                        <th>Audit Report</th>
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
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Certification</strong>&nbsp;<a data-toggle="modal" href="#addCertificationModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                        <div class="row" >
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Certification</th>
                                                                        <th>Type</th>
                                                                        <th>Description</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Expiration Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   <?php 
                                                                        $i = 1;
                                                                        // $usersQuery = $_COOKIE['ID'];
                                                                        $usersQuery = $switch_user_id;
                                                                        $facility_id = $_GET['facility_id'];
                                                                        $queries = "SELECT * FROM tblFacilityDetails_Certification where user_cookies = $usersQuery and facility_entities = $facility_id  order by Certification_id desc";
                                                                        $resultQuery = mysqli_query($conn, $queries);
                                                                        while($rowAcc = mysqli_fetch_array($resultQuery)){ 
                                                                            $idate=date_create($rowAcc['Issue_Date_Certification']);
                                                                            $edate=date_create($rowAcc['Expiration_Date_Certification']);
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                <td><a href="facility_files_Folder/<?php echo $rowAcc['Certification']; ?>" target="_blank"><?php echo $rowAcc['Certification']; ?></a></td>
                                                                                <td><?php echo $rowAcc['Type_Certification']; ?></td>
                                                                                <td><?php echo $rowAcc['Descriptions_Certification']; ?></td>
                                                                                <td><?php echo date_format($idate,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($edate,"Y/m/d"); ?></td>
                                                                            </tr>
                                                                        <?php }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <hr>
                                                        <h4><strong>Certification  History</strong></h4>
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date of Certification </th>
                                                                        <th>Audit Type</th>
                                                                        <th>Accreditation Segment</th>
                                                                        <th>Accreditation Authority</th>
                                                                        <th>Scope of Accreditation</th>
                                                                        <th>Accreditation Rating/Status</th>
                                                                        <th>Audit Report</th>
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
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!--end-->
                                                    <!--start-->
                                                    <div class="tab-pane" id="fo">
                                                        <h4><strong>Facility Functions</strong></h4>
                                                        <br>
                                                        <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <?php
                                                                    $array_data = explode(", ", $row["Facilty_Functions"]); 
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['facility_id'];}else{ echo '';} ?>" required> 
                                                                    
                                                                    <input type="checkbox" name="Facilty_Functions[]" value="1" <?php if(in_array('1', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Manufacturer</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Facilty_Functions[]" value="9" <?php if(in_array('9', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Distribution</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Facilty_Functions[]" value="10" <?php if(in_array('10', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Retailer</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Facilty_Functions[]" value="13" <?php if(in_array('13', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Microbusiness</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="checkbox" name="Facilty_Functions[]" value="14" <?php if(in_array('14', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Cultivation</label>
                                                                    <br>
                                                                    <?php if($_COOKIE['client'] != 1 ): ?>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="6" <?php if(in_array('6', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Packaging</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="5" <?php if(in_array('5', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Co-Packer</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="8" <?php if(in_array('8', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Storage</label>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php if($_COOKIE['client'] != 1 ): ?>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="2" <?php if(in_array('2', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Co-Manufacturer</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="3" <?php if(in_array('3', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Processor</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="4" <?php if(in_array('4', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Packer</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="7" <?php if(in_array('7', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Warehouse</label>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php if($_COOKIE['client'] != 1 ): ?>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="11" <?php if(in_array('11', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Testing</label>
                                                                        <br>
                                                                        <input type="checkbox" name="Facilty_Functions[]" value="12" <?php if(in_array('12', $array_data)){echo 'checked';}else{echo '';} ?>> 
                                                                        <label>Transport</label>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Number of Shifts:</label>
                                                                        <input type="number" class="form-control" name="Number_of_Shifts" value="<?php echo $row["Number_of_Shifts"]?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Number of Employees:</label>
                                                                        <input type="number" class="form-control" name="Number_of_Employees" value="<?php echo $row["Number_of_Employees"]?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php if($_COOKIE['client'] != 1 ): ?>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Number of Lines:</label>
                                                                            <input type="number" class="form-control" name="Number_of_Lines" value="<?php echo $row["Number_of_Lines"]?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Number of HACCPs / Food Safety Plans</label>
                                                                            <input type="number" class="form-control" name="Number_of_HACCPs" value="<?php echo $row["Number_of_HACCPs"]?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <hr>
                                                            <h4><strong>Details</strong></h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><strong>Year Established:</strong></label>
                                                                        <input type="date" name="Year_Establish" value="<?php echo $row["Year_Establish"]?>" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="submit" name="btn_form_function" value="Save" class="btn btn-success" style="float:right;margin-right:20px;">
                                                            <br>
                                                        </form>
                                                        <hr>
                                                        <?php if($_COOKIE['client'] != 1 ): ?>
                                                            <div class="row">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Permits &nbsp;<a data-toggle="modal" href="#addPermitsModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></th>
                                                                            <th>Type</th>
                                                                            <th>Description</th>
                                                                            <th>Issue Date</th>
                                                                            <th>Expiration Date</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            // $usersQuery = $_COOKIE['ID'];
                                                                            $usersQuery = $switch_user_id;
                                                                            $facility_id = $_GET['facility_id'];
                                                                            $queries = "SELECT * FROM tblFacilityDetails_Permits where user_cookies = $usersQuery and facility_entities = $facility_id";
                                                                            $resultQuery = mysqli_query($conn, $queries);
                                                                            while($rowq = mysqli_fetch_array($resultQuery)){ ?>
                                                                                <tr>
                                                                                    <td><a href="facility-function/facility-download-functions.php?pathPermits=<?php echo $rowq['Permits_id']; ?>"><?php echo $rowq['Permits']; ?></a></td>
                                                                                    <td><?php echo $rowq['Type_s']; ?></td>
                                                                                    <td><?php echo $rowq['Descriptions']; ?></td>
                                                                                    <td><?php echo $rowq['Issue_Date']; ?></td>
                                                                                    <td><?php echo $rowq['Expiration_Date']; ?></td>
                                                                                    <td>
                                                                                        <a class="btn blue btn-outline btnViewPermits" data-toggle="modal" href="#modalGetPermits" data-id="<?php echo $rowq["Permits_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            Edit
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--end-->
                                                     <!--start-->
                                                    <div class="tab-pane" id="aq">
                                                        <h4><strong>Allergens List (Handled in the Facility)</strong></h4>
                                                        <br>
                                                        <div class="row">
                                                            <?php
                                                                $array_Allergens = explode(", ", $row["Allergens"]); 
                                                            ?>
                                                        <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                                            <div class="col-md-4">
                                                                <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['facility_id'];}else{ echo '';} ?>" required> 
                                                                <input type="checkbox" name="Allergens[]" value="1" <?php if(in_array('1', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Milk</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="2" <?php if(in_array('2', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Tree Nuts</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="3" <?php if(in_array('3', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Eggs</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="4" <?php if(in_array('4', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Peanuts</label>
                                                                <br>      
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="checkbox" name="Allergens[]" value="5" <?php if(in_array('5', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Fish</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="6" <?php if(in_array('6', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Wheat</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="7" <?php if(in_array('7', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Shell Fish</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="8" <?php if(in_array('8', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Soy Beans</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="checkbox" name="Allergens[]" value="9" <?php if(in_array('9', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Sesame</label>
                                                                <br>
                                                                <input type="checkbox" name="Allergens[]" value="10" <?php if(in_array('10', $array_Allergens)){echo 'checked';}else{echo '';} ?>> 
                                                                <label>Other</label>
                                                                <br>
                                                                <input class="form-control" type="" name="Allergens_specify" value="<?php echo $row['Allergens_specify']; ?>"> 
                                                            </div>
                                                        </div>
                                                            <hr>
                                                            <h4><strong>Quality System Used?</strong></h4>
                                                            <br>
                                                            <div class="row">
                                                                <?php
                                                                    $array_Quality_System = explode(", ", $row["Quality_System"]); 
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <input type="checkbox" name="Quality_System[]" value="1" <?php if(in_array('1', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>ISO</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="2" <?php if(in_array('2', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Good Manufacturing Practices</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="3" <?php if(in_array('3', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>SQF</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="4" <?php if(in_array('4', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>BRC</label>
                                                                     <br>      
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="checkbox" name="Quality_System[]" value="5" <?php if(in_array('5', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>FSSC 22000</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="6" <?php if(in_array('6', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>PrimusGFS</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="7" <?php if(in_array('7', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Good Laboratory Practices</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="8" <?php if(in_array('8', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Good Agricultural Practices</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="checkbox" name="Quality_System[]" value="9" <?php if(in_array('9', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>FSMS</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="10" <?php if(in_array('10', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>QMS</label>
                                                                    <br>
                                                                    <input type="checkbox" name="Quality_System[]" value="11" <?php if(in_array('11', $array_Quality_System)){echo 'checked';}else{echo '';} ?>> 
                                                                    <label>Other</label>
                                                                    <br>
                                                                    <input class="form-control" type="" name="Quality_System_specify" value="<?php echo $row['Quality_System_specify']; ?>"> 
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <input type="submit" name="btn_aqs_function" value="Save" class="btn btn-success" style="float:right;margin-right:20px;">
                                                            <br>
                                                            <br>
                                                        </div> 
                                                        </form>
                                                    <!--end-->
                                                    <!--start-->
                                                    <div class="tab-pane" id="ppf">
                                                        <?php if($_COOKIE['client'] == 1 OR $_COOKIE['ID'] == 38): ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><strong>Premises Diagram</strong>&nbsp;<a data-toggle="modal" href="#addDiagram" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Title</th>
                                                                                <th>Supporting Files</th>
                                                                                <th>Expiration Date</th>
                                                                                <!--<th></th>-->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_diagram">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_pm = mysqli_query($conn, "select * from tblFacilityDetails_Diagram where enterprise_pk = $switch_user_id and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_pm)){
                                                                                foreach($query_pm as $row_pm){?>
                                                                                    <tr id="row_diagram<?=$row_pm['diagram_pk']; ?>">
                                                                                        <td><?=$row_pm['diagram_title']; ?></td>
                                                                                        <td><a href="facility_files_Folder/<?= $row_pm['diagram_files']; ?>" target="_blank"><?= $row_pm['diagram_files']; ?></a></td>
                                                                                        <td><?= $row_pm['expiry_date']; ?></td>
                                                                                        <td width="150px">
                                                                                            <div class="btn-group btn-group-circle">
                                                                                                <a  href="#modal_update_diagram" data-toggle="modal" type="button" id="update_diagram" data-id="<?=$row_pm['diagram_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                        	                    <a href="#modal_delete_diagram" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row_pm['diagram_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <hr>
                                                                    <h4><strong>Security Plan</strong>&nbsp;<a data-toggle="modal" href="#addPlan" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Title</th>
                                                                                <th>Supporting Files</th>
                                                                                <th>Expiration Date</th>
                                                                                <!--<th></th>-->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_plan">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_plan = mysqli_query($conn, "select * from tblFacilityDetails_Plan where enterprise_pk = $switch_user_id and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_plan)){
                                                                                    foreach($query_plan as $row_plan){?>
                                                                                        <tr id="row_plan<?=$row_plan['plan_pk']; ?>">
                                                                                            <td><?=$row_plan['plan_title']; ?></td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_plan['plan_files']; ?>" target="_blank"><?= $row_plan['plan_files']; ?></a></td>
                                                                                            <td><?= $row_plan['expiry_date']; ?></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_plan" data-toggle="modal" type="button" id="update_plan" data-id="<?= $row_plan['plan_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_plan" data-id="<?= $row_plan['plan_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($_COOKIE['client'] != 1 ): ?>
                                                            <?php
                                                                $array_N_A = explode(", ", $row["N_A"]); 
                                                            ?>
                                                            <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" class="form-control" name="ids" value="<?php  echo $_GET['facility_id']; ?>" required> 
                                                                        <div class="col-md-4">
                                                                        <label>Facility / Plant Total Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Facility_Plant_Total_Sq" id="FPT" value="<?php echo $row['Facility_Plant_Total_Sq']; ?>" <?php  if($row['Facility_Plant_Total_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]"  id="FPTNA" onclick="FPTfunction()" value="1" <?php if(in_array('1', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                            <label>Warehouse Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Warehouse_Sq" id="WS" value="<?php echo $row['Warehouse_Sq']; ?>" <?php  if($row['Warehouse_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="WSNA" onclick="WSfunction()" value="2" <?php if(in_array('2', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                            <label>Cooler(s) / Chiller(s) Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Cooler_Chiller_Sq" id="CC" value="<?php echo $row['Cooler_Chiller_Sq']; ?>" <?php  if($row['Cooler_Chiller_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="CCNA" onclick="CCfunction()" value="3" <?php if(in_array('3', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                            <label>Freezer(s) Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Freezer_Sq" id="FS" value="<?php echo $row['Freezer_Sq']; ?>" <?php  if($row['Freezer_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="FSNA" onclick="FSfunction()" value="4" <?php if(in_array('4', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                            <label>Production Area Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Production_Area_Sq" id="PA" value="<?php echo $row['Production_Area_Sq']; ?>" <?php  if($row['Production_Area_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="PANA" onclick="PAfunction()" value="5" <?php if(in_array('5', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                        <label>Packaging Area Sq. Ft</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Packaging_Area_Sq" id="PAS" value="<?php echo $row['Packaging_Area_Sq']; ?>" <?php  if($row['Packaging_Area_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="PASNA" onclick="PASfunction()" value="6" <?php if(in_array('6', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-4">
                                                                            <label>Farm Area Sq. Ft.</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input class="form-control" name="Farm_Area_Sq" id="FA" value="<?php echo $row['Farm_Area_Sq']; ?>" <?php  if($row['Farm_Area_Sq'] == ""){echo 'readonly';}else{echo '';} ?>> 
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="checkbox" name="N_A[]" id="FANA" onclick="FAfunction()" value="7" <?php if(in_array('7', $array_N_A) || is_null($row["N_A"])){echo 'checked';}else{echo '';} ?>> 
                                                                            <label>N/A</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                     <div class="col-md-6">
                                                                        <input type="submit" name="save_Btnsq" class="btn btn-success" value="Save">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--end--> 
                                                    <!--start-->
                                                    
                                                    <?php if($_COOKIE['client'] == 1 OR $_COOKIE['ID'] == 38): ?>
                                                        <div class="tab-pane" id="bond">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><strong>Insurance</strong>&nbsp;<a data-toggle="modal" href="#addInsurance1" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Insurance Company Name</th>
                                                                                <th>Policy Number</th>
                                                                                <th>Effective Date</th>
                                                                                <th>Expiration Date</th>
                                                                                <th></th>
                                                                                <th>Status</th>
                                                                                <th>Supporting Files</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_ib1">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_ib = mysqli_query($conn, "select * from tblFacilityDetails_Bond where enterprise_pk = $switch_user_id and type_id = 1 and is_deleted = 0 and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_ib)){
                                                                                    foreach($query_ib as $row_ib){?>
                                                                                        <tr id="row_bond<?=$row_ib['bond_pk']; ?>">
                                                                                            <td><?=  $row_ib['ib_title']; ?></td>
                                                                                            <td><?= $row_ib['policy_number']; ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_ib['effective_date'])); ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_ib['expiry_date'])); ?></td>
                                                                                            <td><?= $row_ib['policy_type']; ?></td>
                                                                                            <td>
                                                                                                <?php 
                                                                                                    if($row_ib['in_status'] == 1){ echo 'Active';}else{ echo 'Inactive'; }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_ib['ib_files']; ?>" target="_blank"><?= $row_ib['ib_files']; ?></a></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_bond1" data-toggle="modal" type="button" id="update_bond1" data-id="<?=$row_ib['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row_ib['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><strong>Bond</strong>&nbsp;<a data-toggle="modal" href="#addInsurance2" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Bond Company Name</th>
                                                                                <th>Bond Number</th>
                                                                                <th>Effective Date</th>
                                                                                <th>Expiration Date</th>
                                                                                <th>Cannabis Bond Type</th>
                                                                                <th>Supporting Files</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_ib2">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_ib = mysqli_query($conn, "select * from tblFacilityDetails_Bond where enterprise_pk = $switch_user_id and type_id = 2 and is_deleted = 0 and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_ib)){
                                                                                    foreach($query_ib as $row_ib){?>
                                                                                        <tr id="row_bond<?=$row_ib['bond_pk']; ?>">
                                                                                            <td><?=  $row_ib['ib_title']; ?></td>
                                                                                            <td><?= $row_ib['policy_number']; ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_ib['effective_date'])); ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_ib['expiry_date'])); ?></td>
                                                                                            <td><?= $row_ib['policy_type']; ?></td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_ib['ib_files']; ?>" target="_blank"><?= $row_ib['ib_files']; ?></a></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_bond" data-toggle="modal" type="button" id="update_bond" data-id="<?=$row_ib['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row_ib['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end-->
                                                        <!--start-->
                                                        <div class="tab-pane" id="vehicles">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><strong>Vehicles</strong>&nbsp;<a data-toggle="modal" href="#addVehicles" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Driver's Name</th>
                                                                                <th>License Plate Number</th>
                                                                                <th>Year</th>
                                                                                <th>Make</th>
                                                                                <th>Model</th>
                                                                                <th>Vin #.</th>
                                                                                <th>Color</th>
                                                                                <th>Status</th>
                                                                                <th>Supporting Files</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_vehicle">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_vehicle = mysqli_query($conn, "select * from tblFacilityDetails_vehicles where enterprise_pk = $switch_user_id and is_deleted = 0 and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_vehicle)){
                                                                                    foreach($query_vehicle as $row_vehicle){?>
                                                                                        <tr id="row_vehicle<?=$row_vehicle['vehicle_pk']; ?>">
                                                                                            <td>
                                                                                                <?php
                                                                                                    $drivers_id = $row_vehicle['driver_name']; 
                                                                                                    $drivers = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$drivers_id'");
                                                                                                    foreach($drivers as $name_driver){
                                                                                                        echo $name_driver['first_name'].' '.$name_driver['last_name'];
                                                                                                    }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?=$row_vehicle['lisence_plate']; ?></td>
                                                                                            <td><?=$row_vehicle['vehicle_yr']; ?></td>
                                                                                            <td><?=$row_vehicle['vehicle_make']; ?></td>
                                                                                            <td><?=$row_vehicle['vehicle_model']; ?></td>
                                                                                            <td><?=$row_vehicle['vin_number']; ?></td>
                                                                                            <td><?=$row_vehicle['vehicle_color']; ?></td>
                                                                                            <td>
                                                                                                <?php 
                                                                                                    if($row_vehicle['vehicle_status']== 1){ echo 'Active'; }else{ echo'Inactive'; } 
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_vehicle['vehicle_files']; ?>" target="_blank"><?= $row_vehicle['vehicle_files']; ?></a></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_vehicle" data-toggle="modal" type="button" id="update_vehicle" data-id="<?=$row_vehicle['vehicle_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_vehicle" data-toggle="modal" type="button" id="delete_vehicle" data-id="<?=$row_vehicle['vehicle_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="deficiency">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><strong>Deficiency Notice</strong>&nbsp;<a data-toggle="modal" href="#addDeficiency" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</a></h4>
                                                                    <br>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Regulatory Agency</th>
                                                                                <th>Date of Issuance</th>
                                                                                <th>Date Due</th>
                                                                                <th>Number of Violations</th>
                                                                                <th>Supporting Files</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data_deficiency">
                                                                            <?php
                                                                                $facility_id = $_GET['facility_id'];
                                                                                $query_deficiency = mysqli_query($conn, "select * from tblFacilityDetails_deficiency where enterprise_pk = $switch_user_id and is_deleted = 0 and facility_id = $facility_id");
                                                                                if(mysqli_fetch_row($query_deficiency)){
                                                                                    foreach($query_deficiency as $row_deficiency){?>
                                                                                        <tr id="row_deficiency<?=$row_deficiency['deficiency_pk']; ?>">
                                                                                            <td><?=$row_deficiency['regulatory_agency']; ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_deficiency['date_issuance'])); ?></td>
                                                                                            <td><?= date('Y-m-d', strtotime($row_deficiency['date_due'])); ?></td>
                                                                                            <td><?= $row_deficiency['number_violations']; ?></td>
                                                                                            <td><a href="facility_files_Folder/<?= $row_deficiency['deficiency_files']; ?>" target="_blank"><?= $row_deficiency['deficiency_files']; ?></a></td>
                                                                                            <td width="150px">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a  href="#modal_update_deficiency" data-toggle="modal" type="button" id="update_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                            	                    <a href="#modal_delete_deficiency" data-toggle="modal" type="button" id="delete_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } 
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
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
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                    		            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
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
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
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
                    <!--view modalGeFacilitytOrganization modal-->
                    <div class="modal fade bs-modal-lg" id="modalGeFacilitytOrganization" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Facility Organization</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="submit" name="btnOrganizationUpdate" value="Update" class="btn btn-info">       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--view modalGeService_Team modal-->
                    <div class="modal fade bs-modal-lg" id="modalGetService_Team" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Customer Service Team</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="submit" name="btnService_Team" value="Update" class="btn btn-info">       
                                     </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modalGetPermits-->
                    <div class="modal fade bs-modal-lg" id="modalGetPermits" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="facility-function/facility-update-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Permits</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="submit" name="btnPermitsUpdate" value="Update" class="btn btn-info">       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!--Free Add Contact Person modal MODAL AREA-->
                    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">ADD CONTACT PERSON</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
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
                                                    <input class="form-control" type="text" name="titles" id="titles" />
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
                                                    <input class="form-control" type="text" id="contactpersonphone" name="contactpersonphone"  />
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
                                                    <input class="form-control" type="text" id="contactpersonfax" name="contactpersonfax" />
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
                                                    <input class="form-control" type="email" id="contactpersonemailAddress" name="contactpersonemailAddress" required/>
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
                    
                    <!-- MODAL AREA CRISIS TEAM-->
                    <div class="modal fade" id="modalNew"  tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Add Crisis Management Team </h4>
                                </div>
                                <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                    <div class="modal-body">
                                        <div class="mb-3 row">
                                            <label for="addOperationField" class="col-md-3 form-label">Operation</label>
                                            <div class="col-md-9">
                                                <input type="hidden" class="form-control" name="ids" value="<?php echo $_GET['facility_id']; ?>" required> 
                                                <input type="text" class="form-control" id="addOperationField" name="addOperationField" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mb-3 row">
                                            <label for="addPrimaryNameField" class="col-md-3 form-label">Primary Name</label>
                                            <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" id="addPrimaryNameField" name="addPrimaryNameField"> -->

                                                <select class="form-control" name="addPrimaryNameField" id="addPrimaryNameField" required>
                                                    <option value="">Select</option>
                                                    <?php
                                             
                                                        $u = 1;
                                                        // $usersQuery = $_COOKIE['ID'];
                                                        $usersQuery = $switch_user_id;
                                                        //  where user_cookies = $usersQuery
                                                        $queries = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID";
                                                        $resultQuery = mysqli_query($conn, $queries);
                                                        while($rowcrm = mysqli_fetch_array($resultQuery)){ ?>
                                                            <option value="<?php echo $rowcrm['ID']; ?>"><?php echo $rowcrm['first_name']; ?> <?php echo $rowcrm['last_name']; ?></option>
                                                        <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mb-3 row">
                                            <label for="addAlternateNameField" class="col-md-3 form-label">Alternate Name</label>
                                            <div class="col-md-9">
                                            
                                                <select class="form-control" name="addAlternateNameField" id="addAlternateNameField" required>
                                                    <option value="">Select</option>
                                                    <?php
                                         
                                                        $u = 1;
                                                        // $usersQuery = $_COOKIE['ID'];
                                                        $usersQuery = $switch_user_id;
                                                        //  where user_cookies = $usersQuery
                                                        $queries = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID";
                                                        $resultQuery = mysqli_query($conn, $queries);
                                                        while($rowcrm = mysqli_fetch_array($resultQuery)){ ?>
                                                            <option value="<?php echo $rowcrm['ID']; ?>"><?php echo $rowcrm['first_name']; ?> <?php echo $rowcrm['last_name']; ?></option>
                                                        <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success" name="btnSave_critical_operation_facility">Save</button>
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
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
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
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
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
                                                    <input class="form-control" type="text" name="emergency_contact_title" id="emergency_contact_title">
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
                                                    <input class="form-control" type="text" id="emergencyphone" name="emergencyphone" id="emergencyphone" >
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
                                                    <input class="form-control" type="text" id="emergencyfax" name="emergencyfax" >
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
                                                    <input class="form-control" type="email" id="emergencyemailAddress" name="emergencyemailAddress" required/>
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
                    <!--Permits MODAL AREA-->
                    <div class="modal fade" id="addPermitsModal" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">ADD PERMITS</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Permits</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                                    <input class="form-control" type="file" name="Permits" id="Permits" required />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Type</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="text" name="Type_s" id="Type_s" required />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                 <div class="col-md-12">
                                                    <label>Descriptions</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" type="text" name="Descriptions" id="Descriptions"required /></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Issue Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date" id="Issue_Date" name="Issue_Date" />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Expiration Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date"  name="Expiration_Date" id="Expiration_Date" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnPermits" value="Insert" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Accreditation MODAL AREA-->
                    <div class="modal fade" id="addAccreditationModal" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">ADD ACCREDITATION</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Accreditation</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                                    <input class="form-control" type="file" name="Accreditation" id="Accreditation" required />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Type</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="text" name="Type_Accreditation" id="Type_Accreditation" required />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                 <div class="col-md-12">
                                                    <label>Descriptions</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" type="text" name="Descriptions_Accreditation" id="Descriptions"required /></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Issue Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date" id="Issue_Date_Type_Accreditation" name="Issue_Date_Type_Accreditation" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Expiration Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date"  name="Expiration_Date_Type_Accreditation" id="Expiration_Date_Type_Accreditation" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnAccreditation" value="Insert" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Community Relations Program-->
                    <div class="modal fade" id="addCST" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addCST">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Community Relations</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Title</label>
                                                <input class="form-control" type="text" name="cst_title" required>
                                            </div>
                                        </div>
                                       <br>
                                       <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="cst_files" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnCst" id="btnCst" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update_cst-->
                    <div class="modal fade" id="modal_update_cst" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_cst">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Community Relations Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_cst" id="btnSave_cst" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_delete_cst-->
                    <div class="modal fade" id="modal_delete_cst" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_cst">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_cst" id="btndelete_cst" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--addDiagram-->
                    <div class="modal fade" id="addDiagram" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addDiagram">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Premises Diagram</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" type="text" name="diagram_title" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="diagram_files" required>
                                            </div>
                                        </div>
                                        <br>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnDiagram" id="btnDiagram" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!--modal_update_diagram-->
                    <div class="modal fade" id="modal_update_diagram" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_diagram">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Premises Diagram</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_diagram" id="btnSave_diagram" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_delete_diagram-->
                    <div class="modal fade" id="modal_delete_diagram" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_diagram">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_diagram" id="btndelete_diagram" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        
                    <!--Security Plan-->
                    <div class="modal fade" id="addPlan" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addPlan">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Security Plan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" type="text" name="plan_title" required />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="plan_files" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnPlan" id="btnPlan" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!--modal_update_plan-->
                    <div class="modal fade" id="modal_update_plan" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_plan">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Security Plan Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_plan" id="btnSave_plan" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_delete_plan-->
                    <div class="modal fade" id="modal_delete_plan" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_plan">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_plan" id="btndelete_plan" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Vehicles-->
                    <div class="modal fade" id="addVehicles" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addVehicles">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Vehicles</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Driver's Name</label>
                                                <select class="form-control mt-multiselect btn btn-default" type="text" name="driver_name" required>
                                                    <option value="">---Select---</option>
                                                    <?php
                                                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID order by first_name ASC";
                                                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                                                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                                        { 
                                                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'</option>'; 
                                                        }
                                                       
                                                    ?>
                                                    <option value="0">Others</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>License Plate Number</label>
                                                <input class="form-control" type="text" name="lisence_plate" required />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Year</label>
                                                <input class="form-control" type="text" name="vehicle_yr" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Make</label>
                                                <input class="form-control" type="text" name="vehicle_make" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Model</label>
                                                <input class="form-control" type="text" name="vehicle_model" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Vin #.</label>
                                                <input class="form-control" type="text" name="vin_number" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Color</label>
                                                <input class="form-control" type="text" name="vehicle_color" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Status</label>
                                                <br>
                                                <label>
                                                    <input type="radio" name="vehicle_status" value="1"> Active
                                                </label>
                                                &nbsp;
                                                <label>
                                                    <input type="radio" name="vehicle_status" value="0"> Inactive
                                                </label>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-md-12">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="vehicle_files">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnVehicles" id="btnVehicles" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update Vehicle-->
                    <div class="modal fade" id="modal_update_vehicle" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_vehicle">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Vehicle Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_vehicle" id="btnSave_vehicle" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--delete Vehicle-->
                    <div class="modal fade" id="modal_delete_vehicle" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_vehicle">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_vehicle" id="btndelete_vehicle" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        
                    <!-- Deficiency-->
                    <div class="modal fade" id="addDeficiency" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="modalForm addDeficiency">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Deficiency Notice</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="form-group">
                                            <label>Regulatory Agency</label>
                                            <input class="form-control" type="text" name="regulatory_agency" required />
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Issuance</label>
                                            <input class="form-control" type="date" name="date_issuance" required />
                                        </div>
                                        <div class="form-group">
                                            <label>Date Due</label>
                                            <input class="form-control" type="date" name="date_due" required />
                                        </div>
                                        <div class="form-group <?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>">
                                            <label>Date Responded</label>
                                            <input class="form-control" type="date" name="date_responded" />
                                        </div>
                                        <div class="form-group">
                                            <label>Number of Violations</label>
                                            <input class="form-control" type="text" name="number_violations" required />
                                        </div>
                                        <div class="form-group"> 
                                            <label>Supporting Files</label>
                                            <input class="form-control" type="file" name="deficiency_files">
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnDeficiency" id="btnDeficiency" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update Deficiency-->
                    <div class="modal fade" id="modal_update_deficiency" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="modalForm modal_update_deficiency">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Deficiency Notice Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_deficiency" id="btnSave_deficiency" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--delete Deficiency-->
                    <div class="modal fade" id="modal_delete_deficiency" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_deficiency">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_deficiency" id="btndelete_deficiency" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        
                    <!-- Insurance and Bond-->
                    <div class="modal fade" id="addInsurance1" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addInsurance1">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Insurance</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Insurance Company Name</label>
                                                <input class="form-control" type="text" name="ib_title" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Policy Number</label>
                                                <input class="form-control" type="text" name="policy_number" required />
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-md-12">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="ib_files">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Effective Date</label>
                                                <input class="form-control" type="date"  name="effective_date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Policy Type</label>
                                                <input class="form-control" type=""  name="policy_type" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Status</label>
                                                <br>
                                                <label>
                                                    <input type="radio"  name="in_status" value="1"> Active
                                                </label>
                                                &nbsp;
                                                <label>
                                                    <input  type="radio"  name="in_status" value="0" checked> Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnInsurance1" id="btnInsurance1" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update Insurance and Bond 2-->
                    <div class="modal fade" id="modal_update_bond1" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_bond1">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Insurance and Bond Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_insurance1" id="btnSave_insurance1" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Insurance and Bond-->
                    <div class="modal fade" id="addInsurance2" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addInsurance2">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Bond</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Bond Company Name</label>
                                                <input class="form-control" type="text" name="ib_title" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Bond Number</label>
                                                <input class="form-control" type="text" name="policy_number" required />
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-md-12">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="ib_files">
                                            </div>
                                        </div><div class="form-group">
                                            <div class="col-md-6">
                                                <label>Effective Date</label>
                                                <input class="form-control" type="date"  name="effective_date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Cannabis Bond Type</label>
                                                <input class="form-control" type="" name="policy_type" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnInsurance2" id="btnInsurance2" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update Insurance and Bond-->
                    <div class="modal fade" id="modal_update_bond" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_bond">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Bond Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_insurance2" id="btnSave_insurance2" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--btndelete_insurance-->
                    <div class="modal fade" id="modal_delete_bond" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_bond">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_insurance" id="btndelete_insurance" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        
                    <!-- addFacility_registration -->
                    <div class="modal fade" id="addFacility_registration" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm addFacility_registration">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Facility Registration</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="facility_id" value="<?php echo $_GET['facility_id']; ?>" />
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Registration</label>
                                                <input class="form-control" type="registration_name" name="registration_name" required />
                                            </div>
                                        </div>
                                       <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supporting Files</label>
                                                <input class="form-control" type="file" name="supporting_file" required>
                                            </div>
                                        </div>
                                        <br>
                                         <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Registration Date</label>
                                                <input class="form-control" type="date"  name="registration_date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label>Expiration Date</label>
                                                <input class="form-control" type="date"  name="expiry_date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnRegistration" id="btnRegistration" value="Add" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_update_registration-->
                    <div class="modal fade" id="modal_update_registration" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_update_registration">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Registration Details</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnSave_registration" id="btnSave_registration" value="Save" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--modal_delete_registration-->
                    <div class="modal fade" id="modal_delete_registration" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modal_delete_registration">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btndelete_registration" id="btndelete_registration" value="Yes" class="btn btn-warning">
                                        <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--Certification MODAL AREA-->
                    <div class="modal fade" id="addCertificationModal" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">ADD CERTIFICATION</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Certification</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                                    <input class="form-control" type="file" name="Certification" id="Certification" required />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                         <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Type</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="text" name="Type_Certification" id="Type_Certification" required />
                                                </div>
                                            </div>
                                        </div>
                                       <br>
                                        <div class="row">
                                            <div class="form-group">
                                                 <div class="col-md-12">
                                                    <label>Descriptions</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" type="text" name="Descriptions_Certification" id="Descriptions_Certification"required /></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                         <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Issue Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date" id="Issue_Date_Certification" name="Issue_Date_Certification" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                         <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Expiration Date</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="date"  name="Expiration_Date_Certification" id="Expiration_Date_Certification" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnCertification" value="Insert" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--addFacility_Organization-->
                    <div class="modal fade" id="addFacility_Organization" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">ADD FACILITY ORGANIZATION</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>First Name</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                                    <input class="form-control" type="text" name="Organization_name" id="Organization_name" required />
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
                                                    <input class="form-control" type="text" name="Organization_last_name" id="Organization_last_name" required />
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
                                                    <input class="form-control" type="text" name="Organization_title" id="Organization_title" />
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
                                                    <input class="form-control" type="text" id="Organization_cellno" name="Organization_cellno" />
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
                                                    <input class="form-control" type="text" name="Organization_phone" id="Organization_phone"  />
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
                                                    <input class="form-control" type="email" id="Organization_emailAddress" name="Organization_emailAddress" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnOrganizationMore" value="Insert" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--add Service Team -->
                    <div class="modal fade" id="addService_Team" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Customer Service Team</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>First Name</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                                    <input class="form-control" type="text" name="Service_Team_name" id="Service_Team_name" required />
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
                                                    <input class="form-control" type="text" name="Service_Team_last_name" id="Service_Team_last_name" required />
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
                                                    <input class="form-control" type="text" name="Service_Team_title" id="Service_Team_title" />
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
                                                    <input class="form-control" type="text" id="Service_Team_cellno" name="Service_Team_cellno" />
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
                                                    <input class="form-control" type="text" name="Service_Team_phone" id="Service_Team_phone" />
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
                                                    <input class="form-control" type="text" id="Service_Team_emailAddress" name="Service_Team_emailAddress" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-top:10px;">
                                        <input type="submit" name="btnService_Team" value="Insert" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
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
                fancyBoxes();
            });
            // View  Contact
            $(".btnViewCon").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "facility-function/fetch-contact.php?modalViewApp="+id,
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
                    url: "facility-function/fetch-emergency-contact.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetEmergencyContact .modal-body").html(data);
                       
                    }
                });
            });
            // View Organization
            $(".btnViewOrganization").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "facility-function/fetch-Organization.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGeFacilitytOrganization .modal-body").html(data);
                       
                    }
                });
            });
            // View Service_Team
            $(".btnViewService_Team").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "facility-function/fetch-Service_Team.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetService_Team .modal-body").html(data);
                       
                    }
                });
            });
            // View permits
            $(".btnViewPermits").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "facility-function/fetch-permits.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetPermits .modal-body").html(data);
                       
                    }
                });
            });
        
            function FPTfunction() {
                var checkBox = document.getElementById("FPTNA");
                if(checkBox.checked == true){
                    document.getElementById("FPT").readOnly = true;
                    document.getElementById("FPT").value = "";
                }
                else{
                    document.getElementById("FPT").readOnly = false;
                }
            }
            function CCfunction() {
             var checkBox = document.getElementById("CCNA");
              if(checkBox.checked == true){
                  document.getElementById("CC").readOnly = true;
                  document.getElementById("CC").value = "";
              }
              else{
                  document.getElementById("CC").readOnly = false;
              }
            }
            function PAfunction() {
             var checkBox = document.getElementById("PANA");
              if(checkBox.checked == true){
                  document.getElementById("PA").readOnly = true;
                  document.getElementById("PA").value = "";
              }
              else{
                  document.getElementById("PA").readOnly = false;
              }
            }
            function FAfunction() {
             var checkBox = document.getElementById("FANA");
              if(checkBox.checked == true){
                  document.getElementById("FA").readOnly = true;
                  document.getElementById("FA").value = "";
              }
              else{
                  document.getElementById("FA").readOnly = false;
              }
            }
            function WSfunction() {
             var checkBox = document.getElementById("WSNA");
              if(checkBox.checked == true){
                  document.getElementById("WS").readOnly = true;
                  document.getElementById("WS").value = "";
              }
              else{
                  document.getElementById("WS").readOnly = false;
              }
            }
            function FSfunction() {
             var checkBox = document.getElementById("FSNA");
              if(checkBox.checked == true){
                  document.getElementById("FS").readOnly = true;
                  document.getElementById("FS").value = "";
              }
              else{
                  document.getElementById("FS").readOnly = false;
              }
            }
            function PASfunction() {
             var checkBox = document.getElementById("PASNA");
              if(checkBox.checked == true){
                  document.getElementById("PAS").readOnly = true;
                  document.getElementById("PAS").value = "";
              }
              else{
                  document.getElementById("PAS").readOnly = false;
              }
            }
            function btnDelete_F_Contact(id, e) {
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
                        url: "facility-function/function.php?btnDelete_F_Contact="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDelete_F_Emergency(id, e) {
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
                        url: "facility-function/function.php?btnDelete_F_Emergency="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            
            // Community Relations
            $(".addCST").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnCst',true);

                var l = Ladda.create(document.querySelector('#btnCst'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_cst').append(response);
                            $('#addCST').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));   

            //update btnSave_cst
            $(document).on('click', '#update_cst', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_cst_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_cst .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_cst").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_cst',true);

                var l = Ladda.create(document.querySelector('#btnSave_cst'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_cst'+row_id).empty();
                             $('#row_cst'+row_id).append(response);
                             $('#modal_update_cst').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete btndelete_cst
            $(document).on('click', '#delete_diagram', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_cst_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_cst .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_cst").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_cst',true);

                var l = Ladda.create(document.querySelector('#btndelete_cst'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_cst'+row_id).empty();
                             $('#modal_delete_cst').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            // Diagram
            $(".addDiagram").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnDiagram',true);

                var l = Ladda.create(document.querySelector('#btnDiagram'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_diagram').append(response);
                            $('#addDiagram').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            //update diagram
            $(document).on('click', '#update_diagram', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_diagram_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_diagram .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_diagram").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_diagram',true);

                var l = Ladda.create(document.querySelector('#btnSave_diagram'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_diagram'+row_id).empty();
                             $('#row_diagram'+row_id).append(response);
                             $('#modal_update_diagram').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete diagram
            $(document).on('click', '#delete_diagram', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_diagram_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_diagram .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_diagram").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_diagram',true);

                var l = Ladda.create(document.querySelector('#btndelete_diagram'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_diagram'+row_id).empty();
                             $('#modal_delete_diagram').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Plan
            $(".addPlan").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnPlan',true);

                var l = Ladda.create(document.querySelector('#btnPlan'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_plan').append(response);
                            $('#addPlan').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            //update get_plan_id
            $(document).on('click', '#update_plan', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_plan_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_plan .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_plan").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_plan',true);

                var l = Ladda.create(document.querySelector('#btnSave_plan'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_plan'+row_id).empty();
                             $('#row_plan'+row_id).append(response);
                             $('#modal_update_plan').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            //delete delete_plan
            $(document).on('click', '#delete_plan', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_plan_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_plan .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_plan").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_plan',true);

                var l = Ladda.create(document.querySelector('#btndelete_plan'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_plan'+row_id).empty();
                             $('#modal_delete_plan').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // Insurance and Bond
            $(".addInsurance1").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnInsurance1',true);

                var l = Ladda.create(document.querySelector('#btnInsurance1'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_ib1').append(response);
                            $('#addInsurance1').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            $(".addInsurance2").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnInsurance2',true);

                var l = Ladda.create(document.querySelector('#btnInsurance2'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_ib2').append(response);
                            $('#addInsurance2').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update get_insurance_id
            $(document).on('click', '#update_bond', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_insurance_id2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_bond .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_bond").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_insurance2',true);

                var l = Ladda.create(document.querySelector('#btnSave_insurance2'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_bond'+row_id).empty();
                             $('#row_bond'+row_id).append(response);
                             $('#modal_update_bond').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update get_insurance_id2
            $(document).on('click', '#update_bond1', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_insurance_id1="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_bond1 .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_bond1").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_insurance1',true);

                var l = Ladda.create(document.querySelector('#btnSave_insurance1'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_bond'+row_id).empty();
                             $('#row_bond'+row_id).append(response);
                             $('#modal_update_bond1').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            //delete modal_delete_bond
            $(document).on('click', '#delete_bond', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_insurance_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_bond .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_bond").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_insurance',true);

                var l = Ladda.create(document.querySelector('#btndelete_insurance'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_bond'+row_id).empty();
                             $('#modal_delete_bond').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // addFacility_registration
            $(".addFacility_registration").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnRegistration',true);

                var l = Ladda.create(document.querySelector('#btnRegistration'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        // alert(response);
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_registration').append(response);
                            $('#addFacility_registration').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update Registration
            $(document).on('click', '#update_registration', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_registration_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_registration .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_registration").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_registration',true);

                var l = Ladda.create(document.querySelector('#btnSave_registration'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_registration'+row_id).empty();
                             $('#row_registration'+row_id).append(response);
                             $('#modal_update_registration').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete Registration
            $(document).on('click', '#delete_registration', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_registration_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_registration .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_registration").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_registration',true);

                var l = Ladda.create(document.querySelector('#btndelete_registration'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_registration'+row_id).empty();
                             $('#modal_delete_registration').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Add vehicles
            $(".addVehicles").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnVehicles',true);

                var l = Ladda.create(document.querySelector('#btnVehicles'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_vehicle').append(response);
                            $('#addVehicles').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update vehicle
            $(document).on('click', '#update_vehicle', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_vehicle_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_vehicle .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_vehicle").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_vehicle',true);

                var l = Ladda.create(document.querySelector('#btnSave_vehicle'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_vehicle'+row_id).empty();
                             $('#row_vehicle'+row_id).append(response);
                             $('#modal_update_vehicle').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete vehicle
            $(document).on('click', '#delete_vehicle', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_vehicle_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_vehicle .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_vehicle").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_vehicle',true);

                var l = Ladda.create(document.querySelector('#btndelete_vehicle'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_vehicle'+row_id).empty();
                             $('#modal_delete_vehicle').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // Add deficiency
            $(".addDeficiency").on('submit',(function(e) {
                e.preventDefault();
                //  var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnDeficiency',true);

                var l = Ladda.create(document.querySelector('#btnDeficiency'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Added!";
                            $('#data_deficiency').append(response);
                            $('#addDeficiency').modal('hide');;
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update deficiency
            $(document).on('click', '#update_deficiency', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?get_deficiency_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_deficiency .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_deficiency").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_deficiency',true);

                var l = Ladda.create(document.querySelector('#btnSave_deficiency'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#row_deficiency'+row_id).empty();
                             $('#row_deficiency'+row_id).append(response);
                             $('#modal_update_deficiency').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete deficiency
            $(document).on('click', '#delete_deficiency', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "facility-function/function.php?delete_deficiency_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_deficiency .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_deficiency").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_deficiency',true);

                var l = Ladda.create(document.querySelector('#btndelete_deficiency'));
                l.start();

                $.ajax({
                    url: "facility-function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#row_deficiency'+row_id).empty();
                             $('#modal_delete_deficiency').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
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
            .uuploader:hover{
                opacity:1;
            }
        </style>
    </body>
</html>