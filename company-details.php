<?php include_once 'database.php'; ?>
<?php 
    $title = "Company Details";
    $site = "company-details";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                   
                            <?php include_once ('profile-sidebar.php'); ?>

                            <!-- BEGIN PROFILE CONTENT -->
                            
                           
                            <!--for update-->
                            <?php
                                    $users = $_COOKIE['ID'];
                                    $query = "SELECT * FROM tbl_companyDetails";
                                    $result = mysqli_query($conn, $query);
                                            
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $done = false;
                                        if($users == $row['usersEntities']){
                                             $done = true;
                                             break;
                                        }
                                        
                                    }
                                    if($done == true){?>
                            <div class="profile-content">
                                 <!--for new-->
                                <form action="admin_2/companyDetailsFunction.php" method="POST" enctype="multipart/form-data">
                                   
                                <div class="row">
                                    <div class="container" style="background-color:#fff;padding:3rem;width:100%;">
                                        <div class="col-md-12" >
                                            <h4><strong>General Company Information</strong></h4>
                                            <h4><strong>I.</strong></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="ids" value="<?php if($users == $row['usersEntities']){ echo $row['details_id'];}else{ echo '';} ?>">
                                                        <label class="control-label"><strong>Purpose:</strong></label>
                                                       
                                                            <textarea class=" form-control" name="purpose"> <?php if($users == $row['usersEntities']){ echo $row['purpose'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Current modified Date:</strong></label>
                                                        <input type="date" class=" form-control" value="<?php if($users == $row['usersEntities']){ echo  date("Y-m-d", strtotime($row['dateUpdated']));}else{ echo '';}?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Company Name:</strong></label>
                                                        <input class=" form-control" name="companyName" value="<?php if($users == $row['usersEntities']){ echo $row['companyName'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Description:</strong></label>
                                                        <input class=" form-control" name="description" value="<?php if($users == $row['usersEntities']){ echo $row['description']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Primary Contact:</strong></label>
                                                        <input class=" form-control" name="primaryContact" value="<?php if($users == $row['usersEntities']){ echo $row['primaryContact']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Address:</strong></label>
                                                        <input class=" form-control" name="address" value="<?php if($users == $row['usersEntities']){ echo $row['address']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>City / State / Zip:</strong></label>
                                                        <input class=" form-control" name="City_State_Zip" value="<?php if($users == $row['usersEntities']){ echo $row['City_State_Zip']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Country:</strong></label>
                                                        <input class=" form-control" name="country" value="<?php if($users == $row['usersEntities']){ echo $row['country'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Telephone:</strong></label>
                                                        <input type="number" class=" form-control" name="telephone" value="<?php if($users == $row['usersEntities']){  echo $row['telephone'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="fax" value="<?php if($users == $row['usersEntities']){  echo $row['fax'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:</strong></label>
                                                        <input type="email" class=" form-control" name="emailAddress" value="<?php if($users == $row['usersEntities']){ echo $row['emailAddress'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Website:</strong></label>
                                                        <input class=" form-control" name="website" value="<?php if($users == $row['usersEntities']){ echo $row['website']; }else{ echo '';}?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Trademark Name:</strong></label>
                                                        <input class=" form-control" name="trademarkName" value="<?php if($users == $row['usersEntities']){ echo $row['trademarkName'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Tradenames:</strong></label>
                                                        <input class=" form-control" name="tradenames" value="<?php if($users == $row['usersEntities']){ echo $row['tradenames'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Headquarters:</strong></label>
                                                        <input class=" form-control" name="headquarters" value="<?php if($users == $row['usersEntities']){ echo $row['headquarters'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Production Plant:</strong></label>
                                                        <input class=" form-control" name="productionPlant" value="<?php if($users == $row['usersEntities']){echo $row['productionPlant'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Parent Company:</strong></label>
                                                        <input class=" form-control" name="parentCompany" value="<?php if($users == $row['usersEntities']){ echo $row['parentCompany'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Subsidiaries:</strong></label>
                                                        <input class=" form-control" name="subsidiaries" value="<?php if($users == $row['usersEntities']){ echo $row['subsidiaries'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Year Established:</strong></label>
                                                        <input class=" form-control" name="yearEstablished" value="<?php if($users == $row['usersEntities']){ echo $row['yearEstablished'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Certification / Audit & Inspection History</strong></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td>Date of Inspection/Audit</td>
                                                                <td>Audit Type</td>
                                                                <td>Certification Audit/Segment</td>
                                                                <td>Inspection Authority</td>
                                                                <td>Scope of Certification  </td>
                                                                <td>Audit Rating/Status</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit1" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType1" value="<?php if($users == $row['usersEntities']){  echo $row['auditType1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment1" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority1" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification1" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus1" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus1']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit2" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType2" value="<?php if($users == $row['usersEntities']){  echo $row['auditType2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment2" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority2" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification2" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus2" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus2']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit3" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType3" value="<?php if($users == $row['usersEntities']){  echo $row['auditType3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment3" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority3" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification3" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus3" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus3']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                     Type of Business
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                        $array_business = explode(", ", $row["businessType"]);
                                                    ?>
                                                   
                                                    <input type="checkbox" id="Direct Buyer" name="businessType[]" value="Direct Buyer" <?php if($users == $row['usersEntities']){ if (in_array('Direct Buyer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Direct Buyer"> Direct Buyer</label><br>
                                                    <input type="checkbox" id="Private Label Owner" name="businessType[]" value="Private Label Owner" <?php if($users == $row['usersEntities']){ if (in_array('Private Label Owner', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Private Label Owner"> Private Label Owner</label><br>
                                                    <input type="checkbox" id="Authorized Agent / Rep." name="businessType[]" value="Authorized Agent / Rep." <?php if($users == $row['usersEntities']){ if (in_array('Authorized Agent / Rep.', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Authorized Agent / Rep.">Authorized Agent / Rep.</label><br>
                                                    
                                                    <input type="checkbox" id="Retailer" name="businessType[]" value="Retailer" <?php if($users == $row['usersEntities']){ if (in_array('Retailer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Retailer"> Retailer</label><br>
                                                    <input type="checkbox" id="Manufacturer" name="businessType[]" value="Manufacturer" <?php if($users == $row['usersEntities']){ if (in_array('Manufacturer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Manufacturer">Manufacturer</label><br>
                                                    <input type="checkbox" id="Distributor" name="businessType[]" value="Distributor" <?php if($users == $row['usersEntities']){ if (in_array('Distributor', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Distributor">Distributor</label><br>
                                                    
                                                    <input type="checkbox" id="Importer" name="businessType[]" value="Importer" <?php if($users == $row['usersEntities']){ if (in_array('Importer', $array_business)) { echo 'checked';} }else{ echo '';}?>>
                                                    <label for="Importer">Importer</label><br>
                                                    <input type="checkbox" id="Broker" name="businessType[]" value="Broker" <?php if($users == $row['usersEntities']){ if (in_array('Broker', $array_business)) { echo 'checked';} }else{ echo '';}?>>
                                                    <label for="Broker">Broker</label><br>
                                                    <input type="checkbox" id="bs" onclick="checkMeBS()" name="businessType[]" value="Others (Please Specify)" <?php if($users == $row['usersEntities']){ if (in_array('Others (Please Specify)', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Authorized Agent / Rep.">Others (Please Specify)</label><br>
                                                    <input class=" form-control" id="boxBS" name="othersBusiness" value="<?php if($users == $row['usersEntities']){ echo $row['othersBusiness'];}else{ echo '';} ?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Business Activity:</strong></label>
                                                        <textarea class=" form-control" name="businessActivity"><?php if($users == $row['usersEntities']){ echo $row['businessActivity'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Certifications:</strong></label>
                                                        <textarea class=" form-control" name="certifications"><?php if($users == $row['usersEntities']){ echo $row['certifications'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>II.</strong></h4>
                                            <h4><strong>Organization</strong></h4>
                                            <br>
                                             <div class="row">
                                                <table class="table table-bordered">
                                                    <thead> 
                                                     </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> 
                                                                    <label class="">Operations -Manager/Director/Executive:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="operationsManager" value="<?php if($users == $row['usersEntities']){ echo $row['operationsManager'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailOM" value="<?php if($users == $row['usersEntities']){ echo $row['emailOM']; }else{ echo '';}?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberOM" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNumberOM'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                             <tr>
                                                                <td> 
                                                                    <label class="">Quality Assurance - Manager/Director/Executive	</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="qualityAssurance" value="<?php if($users == $row['usersEntities']){  echo $row['qualityAssurance'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailQA" value="<?php if($users == $row['usersEntities']){  echo $row['emailQA'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNuberQA" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNuberQA'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                             <tr>
                                                                <td> 
                                                                    <label class="">SQF Practitioner</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="SQFPractitioner" value="<?php if($users == $row['usersEntities']){  echo $row['SQFPractitioner']; }else{ echo '';}?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailSP" value="<?php if($users == $row['usersEntities']){  echo $row['emailSP'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberSP" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNumberSP'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                            <tr>
                                                                <td> 
                                                                    <label class="">Document Approver - Manager/Director/Executive	</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="documentApprover" value="<?php if($users == $row['usersEntities']){  echo $row['documentApprover'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailDA" value="<?php if($users == $row['usersEntities']){  echo $row['emailDA'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberDA" value="<?php if($users == $row['usersEntities']){   echo $row['phoneNumberDA'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                        </tbody>
                                                </table>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Employees:</strong></label>
                                                        <input class=" form-control" name="employees" value="<?php if($users == $row['usersEntities']){  echo $row['employees'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Language:</strong></label>
                                                        <input class=" form-control" name="languages" value="<?php   if($users == $row['usersEntities']){ echo $row['languages'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Type of Organization</label><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                        $array_organization = explode(", ", $row["organizationType"]);
                                                    ?>
                                                    <input type="radio" id="Public Enterprise" name="organizationType[]" value="Public Enterprise" <?php if($users == $row['usersEntities']){ if (in_array('Public Enterprise', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Public Enterprise">Public Enterprise</label><br>
                                                    <input type="radio" id="Private Enterprise" name="organizationType[]" value="Private Enterprise" <?php if($users == $row['usersEntities']){ if (in_array('Private Enterprise', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Private Enterprise">Private Enterprise</label><br>
                                                    <input type="radio" id="Government" name="organizationType[]" value="Government" <?php if($users == $row['usersEntities']){ if (in_array('Government', $array_organization)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Government">Government</label><br>
                                                    <input type="radio" id="to" onclick="checkMeTO()" name="organizationType[]" value="Others (Please Specify)" <?php if($users == $row['usersEntities']){ if (in_array('Others (Please Specify)', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Others (Please Specify)">Others (Please Specify)</label>
                                                    <input class=" form-control" id="boxTO" name="othersOrg" value="<?php if($users == $row['usersEntities']){ echo $row['othersOrg'];}else{ echo '';} ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Partner / Owners</strong></h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Name 1:</label>
                                                    <input class=" form-control" name="partnerOwners1" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners1']; }else{ echo '';} ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Name 2:</label>
                                                    <input class=" form-control" name="partnerOwners2" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners2']; }else{ echo '';} ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Name 3:</label>
                                                    <input class=" form-control" name="partnerOwners3" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners3']; }else{ echo '';} ?>">
                                                </div>
                                            </div>
                                             <hr>
                                            <h4><strong>Plant Facility</strong></h4>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td><a href="admin_2/uploadfileCdetails.php?file_id_plantFacility=<?php  if($users == $row['usersEntities']){ echo $row['details_id'];}else{ echo '';} ?>">Download Template</a></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="file" class=" form-control" name="plantFacility" value="<?php  if($users == $row['usersEntities']){ echo $row['plantFacility']; }else{ echo '';} ?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <h4><strong>III.</strong></h4>
                                             <hr>
                                            <h4><strong>Audit Information</strong></h4>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td><a href="admin_2/uploadfileCdetails.php?file_id_auditInformations=<?php if($users == $row['usersEntities']){ echo $row['details_id']; }else{ echo '';} ?>">Download Template</a></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="file" class=" form-control" name="auditInformations" value="<?php if($users == $row['usersEntities']){ echo $row['auditInformations']; }else{ echo '';} ?>"> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                             <hr>
                                            <h4><strong>IV.</strong></h4>
                                             <hr>
                                              <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Assigned Coordinator:</strong></label>
                                                        <input class=" form-control" name="assignedCoordinator" value="<?php if($users == $row['usersEntities']){ echo $row['assignedCoordinator'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Alternate Coordinator:</strong></label>
                                                        <input class=" form-control" name="alternateCoordinator" value="<?php if($users == $row['usersEntities']){ echo $row['alternateCoordinator'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="row">-->
                                            <!--     <div class="col-md-3">-->
                                            <!--        <div class="form-group">-->
                                            <!--            <label class="control-label"><strong>Assigned Substitute:</strong></label>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--     <div class="col-md-9">-->
                                            <!--        <div class="form-group">-->
                                            <!--            <select class=" form-control">-->
                                            <!--                <option>---Select---</option>-->
                                            <!--            </select>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <hr>
                                            
                                            <input type="submit" name="submitnew" class="btn btn-info" value="Save Changes" />
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                 
                                </form>
                               
                            </div>
                             <?php    }else{?>
                                 
                                  <div class="profile-content">
                                 <!--for new-->
                                <form action="admin_2/companyDetailsFunction.php" method="POST" enctype="multipart/form-data">
                                   
                                <div class="row">
                                    <div class="container" style="background-color:#fff;padding:3rem;width:100%;">
                                        <div class="col-md-12" >
                                            <h4><strong>General Company Information</strong></h4>
                                            <h4><strong>I.</strong></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="ids" value="<?php if($users == $row['usersEntities']){ echo $row['details_id'];}else{ echo '';} ?>">
                                                        <label class="control-label"><strong>Purpose:</strong></label>
                                                       
                                                            <textarea class=" form-control" name="purpose"> <?php if($users == $row['usersEntities']){ echo $row['purpose'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Current modified Date:</strong></label>
                                                        <input type="date" class=" form-control" value="<?php if($users == $row['usersEntities']){ echo  date("Y-m-d", strtotime($row['dateUpdated']));}else{ echo '';}?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Company Name:</strong></label>
                                                        <input class=" form-control" name="companyName" value="<?php if($users == $row['usersEntities']){ echo $row['companyName'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Description:</strong></label>
                                                        <input class=" form-control" name="description" value="<?php if($users == $row['usersEntities']){ echo $row['description']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Primary Contact:</strong></label>
                                                        <input class=" form-control" name="primaryContact" value="<?php if($users == $row['usersEntities']){ echo $row['primaryContact']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Address:</strong></label>
                                                        <input class=" form-control" name="address" value="<?php if($users == $row['usersEntities']){ echo $row['address']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>City / State / Zip:</strong></label>
                                                        <input class=" form-control" name="City_State_Zip" value="<?php if($users == $row['usersEntities']){ echo $row['City_State_Zip']; }else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Country:</strong></label>
                                                        <input class=" form-control" name="country" value="<?php if($users == $row['usersEntities']){ echo $row['country'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Telephone:</strong></label>
                                                        <input type="number" class=" form-control" name="telephone" value="<?php if($users == $row['usersEntities']){  echo $row['telephone'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="fax" value="<?php if($users == $row['usersEntities']){  echo $row['fax'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:</strong></label>
                                                        <input type="email" class=" form-control" name="emailAddress" value="<?php if($users == $row['usersEntities']){ echo $row['emailAddress'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Website:</strong></label>
                                                        <input class=" form-control" name="website" value="<?php if($users == $row['usersEntities']){ echo $row['website']; }else{ echo '';}?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Trademark Name:</strong></label>
                                                        <input class=" form-control" name="trademarkName" value="<?php if($users == $row['usersEntities']){ echo $row['trademarkName'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Tradenames:</strong></label>
                                                        <input class=" form-control" name="tradenames" value="<?php if($users == $row['usersEntities']){ echo $row['tradenames'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Headquarters:</strong></label>
                                                        <input class=" form-control" name="headquarters" value="<?php if($users == $row['usersEntities']){ echo $row['headquarters'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Production Plant:</strong></label>
                                                        <input class=" form-control" name="productionPlant" value="<?php if($users == $row['usersEntities']){echo $row['productionPlant'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Parent Company:</strong></label>
                                                        <input class=" form-control" name="parentCompany" value="<?php if($users == $row['usersEntities']){ echo $row['parentCompany'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Subsidiaries:</strong></label>
                                                        <input class=" form-control" name="subsidiaries" value="<?php if($users == $row['usersEntities']){ echo $row['subsidiaries'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Year Established:</strong></label>
                                                        <input class=" form-control" name="yearEstablished" value="<?php if($users == $row['usersEntities']){ echo $row['yearEstablished'];}else{ echo '';}  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Certification / Audit & Inspection History</strong></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td>Date of Inspection/Audit</td>
                                                                <td>Audit Type</td>
                                                                <td>Certification Audit/Segment</td>
                                                                <td>Inspection Authority</td>
                                                                <td>Scope of Certification  </td>
                                                                <td>Audit Rating/Status</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit1" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType1" value="<?php if($users == $row['usersEntities']){  echo $row['auditType1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment1" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority1" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification1" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification1']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus1" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus1']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit2" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType2" value="<?php if($users == $row['usersEntities']){  echo $row['auditType2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment2" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority2" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification2" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification2']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus2" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus2']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td> <input class=" form-control" name="inspectionAudit3" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAudit3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditType3" value="<?php if($users == $row['usersEntities']){  echo $row['auditType3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="auditSegment3" value="<?php if($users == $row['usersEntities']){  echo $row['auditSegment3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="inspectionAuthority3" value="<?php if($users == $row['usersEntities']){  echo $row['inspectionAuthority3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="scopeCertification3" value="<?php if($users == $row['usersEntities']){  echo $row['scopeCertification3']; }else{ echo '';}  ?>"></td>
                                                                <td> <input class=" form-control" name="ratingStatus3" value="<?php if($users == $row['usersEntities']){  echo $row['ratingStatus3']; }else{ echo '';}  ?>"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                     Type of Business
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                        $array_business = explode(", ", $row["businessType"]);
                                                    ?>
                                                   
                                                    <input type="checkbox" id="Direct Buyer" name="businessType[]" value="Direct Buyer" <?php if($users == $row['usersEntities']){ if (in_array('Direct Buyer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Direct Buyer"> Direct Buyer</label><br>
                                                    <input type="checkbox" id="Private Label Owner" name="businessType[]" value="Private Label Owner" <?php if($users == $row['usersEntities']){ if (in_array('Private Label Owner', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Private Label Owner"> Private Label Owner</label><br>
                                                    <input type="checkbox" id="Authorized Agent / Rep." name="businessType[]" value="Authorized Agent / Rep." <?php if($users == $row['usersEntities']){ if (in_array('Authorized Agent / Rep.', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Authorized Agent / Rep.">Authorized Agent / Rep.</label><br>
                                                    
                                                    <input type="checkbox" id="Retailer" name="businessType[]" value="Retailer" <?php if($users == $row['usersEntities']){ if (in_array('Retailer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Retailer"> Retailer</label><br>
                                                    <input type="checkbox" id="Manufacturer" name="businessType[]" value="Manufacturer" <?php if($users == $row['usersEntities']){ if (in_array('Manufacturer', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Manufacturer">Manufacturer</label><br>
                                                    <input type="checkbox" id="Distributor" name="businessType[]" value="Distributor" <?php if($users == $row['usersEntities']){ if (in_array('Distributor', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Distributor">Distributor</label><br>
                                                    
                                                    <input type="checkbox" id="Importer" name="businessType[]" value="Importer" <?php if($users == $row['usersEntities']){ if (in_array('Importer', $array_business)) { echo 'checked';} }else{ echo '';}?>>
                                                    <label for="Importer">Importer</label><br>
                                                    <input type="checkbox" id="Broker" name="businessType[]" value="Broker" <?php if($users == $row['usersEntities']){ if (in_array('Broker', $array_business)) { echo 'checked';} }else{ echo '';}?>>
                                                    <label for="Broker">Broker</label><br>
                                                    <input type="checkbox" id="bs" onclick="checkMeBS()" name="businessType[]" value="Others (Please Specify)" <?php if($users == $row['usersEntities']){ if (in_array('Others (Please Specify)', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Authorized Agent / Rep.">Others (Please Specify)</label><br>
                                                    <input class=" form-control" id="boxBS" name="othersBusiness" value="<?php if($users == $row['usersEntities']){ echo $row['othersBusiness'];}else{ echo '';} ?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Business Activity:</strong></label>
                                                        <textarea class=" form-control" name="businessActivity"><?php if($users == $row['usersEntities']){ echo $row['businessActivity'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Certifications:</strong></label>
                                                        <textarea class=" form-control" name="certifications"><?php if($users == $row['usersEntities']){ echo $row['certifications'];}else{ echo '';} ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>II.</strong></h4>
                                            <h4><strong>Organization</strong></h4>
                                            <br>
                                             <div class="row">
                                                <table class="table table-bordered">
                                                    <thead> 
                                                     </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> 
                                                                    <label class="">Operations -Manager/Director/Executive:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="operationsManager" value="<?php if($users == $row['usersEntities']){ echo $row['operationsManager'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailOM" value="<?php if($users == $row['usersEntities']){ echo $row['emailOM']; }else{ echo '';}?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberOM" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNumberOM'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                             <tr>
                                                                <td> 
                                                                    <label class="">Quality Assurance - Manager/Director/Executive	</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="qualityAssurance" value="<?php if($users == $row['usersEntities']){  echo $row['qualityAssurance'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailQA" value="<?php if($users == $row['usersEntities']){  echo $row['emailQA'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNuberQA" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNuberQA'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                             <tr>
                                                                <td> 
                                                                    <label class="">SQF Practitioner</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="SQFPractitioner" value="<?php if($users == $row['usersEntities']){  echo $row['SQFPractitioner']; }else{ echo '';}?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailSP" value="<?php if($users == $row['usersEntities']){  echo $row['emailSP'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberSP" value="<?php if($users == $row['usersEntities']){  echo $row['phoneNumberSP'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                            <tr>
                                                                <td> 
                                                                    <label class="">Document Approver - Manager/Director/Executive	</label>
                                                                </td>
                                                                <td> 
                                                                    <input class="form-control" name="documentApprover" value="<?php if($users == $row['usersEntities']){  echo $row['documentApprover'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Email:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="emailDA" value="<?php if($users == $row['usersEntities']){  echo $row['emailDA'];}else{ echo '';} ?>">
                                                                </td>
                                                                
                                                                 <td> 
                                                                    <label class="">Phone Number:</label>
                                                                </td>
                                                                <td> 
                                                                    <input class=" form-control" name="phoneNumberDA" value="<?php if($users == $row['usersEntities']){   echo $row['phoneNumberDA'];}else{ echo '';} ?>">
                                                                </td>
                                                               
                                                            </tr>
                                                        </tbody>
                                                </table>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Employees:</strong></label>
                                                        <input class=" form-control" name="employees" value="<?php if($users == $row['usersEntities']){  echo $row['employees'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Language:</strong></label>
                                                        <input class=" form-control" name="languages" value="<?php   if($users == $row['usersEntities']){ echo $row['languages'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Type of Organization</label><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                        $array_organization = explode(", ", $row["organizationType"]);
                                                    ?>
                                                    <input type="radio" id="Public Enterprise" name="organizationType[]" value="Public Enterprise" <?php if($users == $row['usersEntities']){ if (in_array('Public Enterprise', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Public Enterprise">Public Enterprise</label><br>
                                                    <input type="radio" id="Private Enterprise" name="organizationType[]" value="Private Enterprise" <?php if($users == $row['usersEntities']){ if (in_array('Private Enterprise', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Private Enterprise">Private Enterprise</label><br>
                                                    <input type="radio" id="Government" name="organizationType[]" value="Government" <?php if($users == $row['usersEntities']){ if (in_array('Government', $array_organization)) { echo 'checked';}}else{ echo '';} ?>>
                                                    <label for="Government">Government</label><br>
                                                    <input type="radio" id="to" onclick="checkMeTO()" name="organizationType[]" value="Others (Please Specify)" <?php if($users == $row['usersEntities']){ if (in_array('Others (Please Specify)', $array_organization)) { echo 'checked';} }else{ echo '';} ?>>
                                                    <label for="Others (Please Specify)">Others (Please Specify)</label>
                                                    <input class=" form-control" id="boxTO" name="othersOrg" value="<?php if($users == $row['usersEntities']){ echo $row['othersOrg'];}else{ echo '';} ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Partner / Owners</strong></h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Name 1:</label>
                                                    <input class=" form-control" name="partnerOwners1" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners1']; }else{ echo '';} ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Name 2:</label>
                                                    <input class=" form-control" name="partnerOwners2" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners2']; }else{ echo '';} ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Name 3:</label>
                                                    <input class=" form-control" name="partnerOwners3" value="<?php  if($users == $row['usersEntities']){ echo $row['partnerOwners3']; }else{ echo '';} ?>">
                                                </div>
                                            </div>
                                             <hr>
                                            <h4><strong>Plant Facility</strong></h4>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td><a href="admin_2/uploadfileCdetails.php?file_id_plantFacility=<?php  if($users == $row['usersEntities']){ echo $row['details_id'];}else{ echo '';} ?>">Download Template</a></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="file" class=" form-control" name="plantFacility" value="<?php  if($users == $row['usersEntities']){ echo $row['plantFacility']; }else{ echo '';} ?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <h4><strong>III.</strong></h4>
                                             <hr>
                                            <h4><strong>Audit Information</strong></h4>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td><a href="admin_2/uploadfileCdetails.php?file_id_auditInformations=<?php if($users == $row['usersEntities']){ echo $row['details_id']; }else{ echo '';} ?>">Download Template</a></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="file" class=" form-control" name="auditInformations" value="<?php if($users == $row['usersEntities']){ echo $row['auditInformations']; }else{ echo '';} ?>"> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                             <hr>
                                            <h4><strong>IV.</strong></h4>
                                             <hr>
                                              <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Assigned Coordinator:</strong></label>
                                                        <input class=" form-control" name="assignedCoordinator" value="<?php if($users == $row['usersEntities']){ echo $row['assignedCoordinator'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Alternate Coordinator:</strong></label>
                                                        <input class=" form-control" name="alternateCoordinator" value="<?php if($users == $row['usersEntities']){ echo $row['alternateCoordinator'];}else{ echo '';} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="row">-->
                                            <!--     <div class="col-md-3">-->
                                            <!--        <div class="form-group">-->
                                            <!--            <label class="control-label"><strong>Assigned Substitute:</strong></label>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--     <div class="col-md-9">-->
                                            <!--        <div class="form-group">-->
                                            <!--            <select class=" form-control">-->
                                            <!--                <option>---Select---</option>-->
                                            <!--            </select>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <hr>
                                            
                                            <input type="submit" name="submitnew" class="btn btn-info" value="Save Changes" />
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                 
                                </form>
                               
                            </div>
                            <?php  } 
                            
                             ?>
                            <!-- END PROFILE CONTENT -->

        <?php include_once ('footer.php'); ?>
  
        <script>
        function checkMeBS(){
            var businessSpecify = document.getElementById("bs");
            var inputBS = document.getElementById("boxBS");
            if(businessSpecify.checked == true){
                inputBS.style.display = "block";
            } else{
                inputBS.style.display = "none";
            }
        }
         function checkMeTO(){
            var orgSpecify = document.getElementById("to");
            var inputTO = document.getElementById("boxTO");
            if(orgSpecify.checked == true){
                inputTO.style.display = "block";
            } else{
                inputTO.style.display = "none";
            }
        }
           
        </script>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="admin_2/profileSidebar.js" type="text/javascript"></script>
    </body>
</html>
