<?php include_once 'database.php'; ?>
<?php 
    $title = "Enterprise Information";
    $site = "enterprise-details";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                   
                          

                            <!-- BEGIN PROFILE CONTENT -->
                            
                           
                            <!--for update-->
                            <?php
                                    // $users = $_COOKIE['ID'];
                                    if (isset($_COOKIE['switchAccount'])) { $users = $_COOKIE['switchAccount']; }
                                    else { $users = $_COOKIE['ID']; }
                                    
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
                            <div class="profile-content">
                                 <!--for new-->
                                <form action="admin_2/enterpriseDetailsFunction.php" method="POST" enctype="multipart/form-data">
                                   
                                <div class="row">
                                    <div class="container" style="background-color:#fff;padding:3rem;width:100%;">
                                        <div class="col-md-12" >
                                            <!--business Name-->
                                            <h4><strong>Legal Name</strong></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                            <input type="hidden" class="form-control" name="idss" value="<?php if($users == $row['users_entities']){ echo $row['enterp_id'];}else{ echo '';} ?>" style="color:black;"> 
                                                            <input class=" form-control" name="businessname" value="<?php echo $row['businessname']; ?>" required> 
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>City:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>State:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>Zip Code:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="businesstelephone" value="<?php echo $row['businesstelephone']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="businessfax" value="<?php echo $row['businessfax']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="businessemailAddress" value="<?php echo $row['businessemailAddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Website:</strong></label>
                                                        <input class=" form-control" name="businesswebsite" value="<?php echo $row['businesswebsite']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr >
                                             <!--Business- Contact Person(s)-->
                                            <h4><strong>Contact Person(s)</strong>&nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="contactpersonname" value="<?php echo $row['contactpersonname']; ?>" required> 
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Title:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="title" value="<?php echo $row['title']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Cell No.:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="contactpersoncellno" value="<?php echo $row['contactpersoncellno']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="contactpersonphone" value="<?php echo $row['contactpersonphone']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="contactpersonfax" value="<?php echo $row['contactpersonfax']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="contactpersonemailAddress" value="<?php echo $row['contactpersonemailAddress']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr >
                                            <!--Business - EMERGENCY: Contact Person(s)-->
                                            <h4><strong>Emergency: Contact Person(s)</strong> &nbsp;<input type="checkbox" id="" name="" value="" ><label for="Direct Buyer"> None</label>
                                            &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>
                                            </h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="emergencyname" value="<?php echo $row['emergencyname']; ?>" required> 
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Title<i style="color:orange;" title="This input box is required!!!">*</i>:</strong></label>
                                                        <input class=" form-control" name="emergencytitle" value="<?php echo $row['emergencytitle']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Cell No.:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="emergencycellno" value="<?php echo $row['emergencycellno']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="emergencyphone" value="<?php echo $row['emergencyphone']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="emergencyfax" value="<?php echo $row['emergencyfax']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="emergencyemailAddress" value="<?php echo $row['emergencyemailAddress']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Business Structure-->
                                            <hr >
                                            <h4><strong>Business Structure</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php
                                                                    $array_business = explode(", ", $row["BusinessStructure"]);
                                                                ?>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="Sole Propreitorship" name="BusinessStructure[]" value="Sole Propreitorship" <?php if($users == $row['users_entities']){ if (in_array('Sole Propreitorship', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Sole Propreitorship"> Sole Propreitorship</label>
                                                                </td>
                                                                <td>
                                                                     <a><?php echo $row['SolePropreitorship']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" name="SolePropreitorship" class="form-control" value"companyDetailsFolder/<?php echo $row['SolePropreitorship']; ?>">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="General Partnership" name="BusinessStructure[]" value="General Partnership" <?php if($users == $row['users_entities']){ if (in_array('General Partnership', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="General Partnership"> General Partnership</label>
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['GeneralPartnership']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" name="GeneralPartnership" class="form-control" value="companyDetailsFolder/<?php echo $row['GeneralPartnership']; ?>">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Corporation" name="BusinessStructure[]" value="Corporation" <?php if($users == $row['users_entities']){ if (in_array('Corporation', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="Corporation">Corporation</label>
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['Corporation']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="Corporation" class="form-control" value"companyDetailsFolder/<?php echo $row['Corporation']; ?>">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Limited Liability Company" name="BusinessStructure[]" value="Limited Liability Company" <?php if($users == $row['users_entities']){ if (in_array('Limited Liability Company', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="Limited Liability Company">Limited Liability Company</label>
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['LimitedLiabilityCompany']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="LimitedLiabilityCompany" class="form-control" value"companyDetailsFolder/<?php echo $row['LimitedLiabilityCompany']; ?>">
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Limited Partnership" name="BusinessStructure[]" value="Limited Partnership" <?php if($users == $row['users_entities']){ if (in_array('Limited Partnership', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                    <label for="Limited Partnership">Limited Partnership</label>
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['LimitedPartnership']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="LimitedPartnership" class="form-control" value"<?php echo $row['LimitedPartnership']; ?>">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Limited Liability Parnership" name="BusinessStructure[]" value="Limited Liability Parnership" <?php if($users == $row['users_entities']){ if (in_array('Limited Liability Parnership', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Limited Liability Parnership">Limited Liability Parnership</label>
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['LimitedLiabilityParnership']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" name="LimitedLiabilityParnership" class="form-control" value"<?php echo $row['LimitedLiabilityParnership']; ?>">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="BusinessStructure[]" value="Others (Please Specify)" <?php if($users == $row['users_entities']){ if (in_array('Others (Please Specify)', $array_business)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Others (Please Specify)">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersBusinessStructure" value="<?php echo $row['othersBusinessStructure']; ?>" >
                                                                 </td>
                                                                 <td>
                                                                     <a><?php echo $row['otherbStructurefile']; ?></a>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="otherbStructurefile" class="form-control" value"<?php echo $row['otherbStructurefile']; ?>">
                                                                 </td>
                                                             </tr>
                                                             
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                            <hr >
                                            <h4><strong>Business Purpose<i style="color:orange;" title="This input box is required!!!">*</i></strong></h4>
                                            <div class="row">
                                                 <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class=" form-control" name="BusinessPurpose" value="" required><?php echo $row['BusinessPurpose']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Trademarks</strong></h4>
                                            <div class="row">
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Trademark Name:</strong></label>
                                                        <input type="email" class=" form-control" name="TrademarkName" value="<?php echo $row['TrademarkName']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        
                                                        <label class="control-label"><strong>Supporting file:</strong></label>
                                                        <a class="" ><?php echo $row['TrademarkNameFile']; ?></a>
                                                        <input type="file" class=" form-control" name="TrademarkNameFile" value="<?php echo $row['TrademarkNameFile']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Tradename:</strong></label>
                                                        <input type="text" class=" form-control" name="Tradename" value="<?php echo $row['Tradename']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <hr>
                                            <h4><strong>Parent Company</strong></h4>
                                             <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Headquarters:</strong></label>
                                                        <input type="text" class=" form-control" name="Headquarters" value="<?php echo $row['Headquarters']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Parent Company Name:</strong></label>
                                                        <input type="text" class=" form-control" name="ParentCompanyName" value="<?php echo $row['ParentCompanyName']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Year Established:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="text" class=" form-control" name="YearEstablished" value="<?php echo $row['YearEstablished']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Dunn & Brad Street Number:</strong></label>
                                                        <input type="text" class=" form-control" name="Dunn" value="<?php echo $row['Dunn']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                             <hr >
                                            <h4><strong>Certification</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php
                                                                    $array_Certification = explode(", ", $row["Certification"]);
                                                                ?>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="GFSI" name="Certification[]" value="GFSI" <?php if($users == $row['users_entities']){ if (in_array('GFSI', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="GFSI"> GFSI</label>
                                                                </td>
                                                                 <td> 
                                                                    <a><?php echo $row['GFSIFILE']; ?></a>
                                                                  </td> 
                                                                 <td>
                                                                      <input type="file" class="form-control" name="GFSIFILE">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="SQF" name="Certification[]" value="SQF" <?php if($users == $row['users_entities']){ if (in_array('SQF', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="SQF">SQF</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['SQFFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="SQFFILE">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="BRC" name="Certification[]" value="BRC" <?php if($users == $row['users_entities']){ if (in_array('BRC', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="BRC">BRC</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['BRCFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="BRCFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="FSSC22000" name="Certification[]" value="FSSC22000" <?php if($users == $row['users_entities']){ if (in_array('FSSC22000', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="FSSC22000">FSSC22000</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['FSSC22000FILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="FSSC22000FILE">
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="ISO" name="Certification[]" value="ISO" <?php if($users == $row['users_entities']){ if (in_array('ISO', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                    <label for="ISO">ISO</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['ISOFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="ISOFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Primus GFS" name="Certification[]" value="Primus GFS" <?php if($users == $row['users_entities']){ if (in_array('Primus GFS', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Primus GFS">Primus GFS</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['PrimusGFSFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="PrimusGFSFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="HACCP" name="Certification[]" value="HACCP" <?php if($users == $row['users_entities']){ if (in_array('HACCP', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                    <label for="Manufacturer">HACCP</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['HACCPFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="HACCPFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="GMP" name="Certification[]" value="GMP" <?php if($users == $row['users_entities']){ if (in_array('GMP', $array_Certification)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="GMP">GMP</label>
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['GMPFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="GMPFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Certification[]" value="Others"<?php if($users == $row['users_entities']){ if (in_array('Others', $array_Certification)) { echo 'checked';}}else{ echo '';} ?> >
                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersCertification" value="<?php echo $row['othersCertification']; ?>">
                                                                 </td>
                                                                 <td> 
                                                                    <a><?php echo $row['OthersFILE']; ?></a>
                                                                  </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="OthersFILE">
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                             <h4><strong>Accreditation</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php
                                                                    $array_Accreditation = explode(", ", $row["Accreditation"]);
                                                                ?>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="Organic" name="Accreditation[]" value="Organic" <?php if($users == $row['users_entities']){ if (in_array('Organic', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Organic"> Organic</label>
                                                                </td>
                                                                <td>
                                                                    <a><?php echo $row['OrganicFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="OrganicFile">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Halal" name="Accreditation[]" value="Halal" <?php if($users == $row['users_entities']){ if (in_array('Halal', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Halal">Halal</label>
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['HalalFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="HalalFile">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Kosher" name="Accreditation[]" value="Kosher" <?php if($users == $row['users_entities']){ if (in_array('Kosher', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="Kosher">Kosher</label>
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['KosherFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="KosherFile">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Non-GMO" name="Accreditation[]" value="Non-GMO" <?php if($users == $row['users_entities']){ if (in_array('Non-GMO', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                     <label for="Non-GMO">Non-GMO</label>
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['NonGMOFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="NonGMOFile">
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Plant Based" name="Accreditation[]" value="Plant Based" <?php if($users == $row['users_entities']){ if (in_array('Plant Based', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                    <label for="Plant Based">Plant Based</label>
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['PlantBasedFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="PlantBasedFile">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Accreditation[]" value="Others" <?php if($users == $row['users_entities']){ if (in_array('Others', $array_Accreditation)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Authorized Agent / Rep.">Others</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersAccreditation" value="<?php echo $row['othersAccreditation']; ?>">
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['othersAccreditationFile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="othersAccreditationFile">
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                            <h4><strong>Regulatory</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php
                                                                    $array_Regulatory = explode(", ", $row["Regulatory"]);
                                                                ?>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="FDA" name="Regulatory[]" value="FDA" <?php if($users == $row['users_entities']){ if (in_array('FDA', $array_Regulatory)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="FDA"> FDA</label>
                                                                </td>
                                                                <td>
                                                                    <a><?php echo $row['FDAfile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="FDAfile">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="USDA" name="Regulatory[]" value="USDA" <?php if($users == $row['users_entities']){ if (in_array('USDA', $array_Regulatory)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="USDA">USDA</label>
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['USDAfile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="USDAfile">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Regulatory[]" value="Others" <?php if($users == $row['users_entities']){ if (in_array('Others', $array_Regulatory)) { echo 'checked';}}else{ echo '';} ?>>
                                                                        <label for="Authorized Agent / Rep.">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersRegulatory" value="<?php echo $row['othersRegulatory']; ?>">
                                                                 </td>
                                                                 <td>
                                                                    <a><?php echo $row['OthersRegulatoryfile']; ?></a>
                                                                </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="OthersRegulatoryfile">
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                             <h5><strong>Enterprise Records&nbsp;<i style="font-size:12px;background-color:orange;color:#fff;">Examples (Tax ID, Corporate Documents, Partnerhip agreements, certificates, accreditations, etc.)</i></strong></h5>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                 <td>Document <a><?php echo $row['EnterpriseRecordsFile']; ?></a> </td>
                                                                 <td>Title </td>
                                                                 <td>Description </td>
                                                                 <td>Document Due Date</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <tr>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="EnterpriseRecordsFile">
                                                                 </td>
                                                                  <td>
                                                                      <input class="form-control" name="DocumentTitle" value="<?php echo $row['DocumentTitle']; ?>">
                                                                  </td>
                                                                   <td>
                                                                       <textarea class="form-control" name="DocumentDesciption" ><?php echo $row['DocumentDesciption']; ?></textarea>
                                                                   </td>
                                                                    <td>
                                                                        <input type="date" class="form-control" name="DocumentDueDate" value="<?php if($users == $row['users_entities']){ echo  date("Y-m-d", strtotime($row['DocumentDueDate']));}else{ echo '';}?>">
                                                                    </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise has a facility / operation?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <select class="form-control" name="enterpriseOperation">
                                                        <option value="No" <?php  if ($row['enterpriseOperation'] == 'No') { echo 'selected';}else{echo '';} ?> >No</option>
                                                        <option value="Yes" <?php  if ($row['enterpriseOperation'] == 'Yes') { echo 'selected';}else{echo ''; }?>>Yes</option>
                                                    </select>
                                                 </div>
                                             </div>
                                             <br>
                                              <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise has employees?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <select class="form-control" name="">
                                                        <option  value="No" <?php  if ($row['enterpriseEmployees'] == 'No') { echo 'selected';}else{echo '';} ?> >No</option>
                                                        <option value="Yes" <?php  if ($row['enterpriseEmployees'] == 'Yes') { echo 'selected';}else{echo ''; }?>>Yes</option>
                                                    </select>
                                                 </div>
                                             </div>
                                             <hr>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="col-md-8">
                                                        <label>Enterprise Function (if applicable)</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <?php
                                                            $array_function = explode(", ", $row["EnterpriseFunction"]);
                                                        ?>
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Direct Buyer" name="EnterpriseFunction[]" value="Manufacturing Facilities" <?php if($users == $row['users_entities']){ if (in_array('Manufacturing Facilities', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Direct Buyer"> Manufacturing Facilities</label> <br>
                                                                <input type="checkbox" id="Warehouse Storage" name="EnterpriseFunction[]" value="Warehouse Storage" <?php if($users == $row['users_entities']){ if (in_array('Warehouse Storage', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Warehouse Storage"> Warehouse Storage</label> <br>
                                                                <input type="checkbox" id="Distribution Center" name="EnterpriseFunction[]" value="Distribution Center" <?php if($users == $row['users_entities']){ if (in_array('Distribution Center', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Distribution Center"> Distribution Center:</label> <br>
                                                                <input type="checkbox" id="Retail Location" name="EnterpriseFunction[]" value="Retail Location" <?php if($users == $row['users_entities']){ if (in_array('Retail Location', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Retail Location">Retail Location</label> <br>
                                                                <input type="checkbox" id="Facilities - None" name="EnterpriseFunction[]" value="Facilities - None" <?php if($users == $row['users_entities']){ if (in_array('Facilities - None', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Facilities - None"> Facilities - None</label> <br>
                                                                <input type="checkbox" id="Brand owner" name="EnterpriseFunction[]" value="Brand owner" <?php if($users == $row['users_entities']){ if (in_array('Brand owner', $array_function)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Brand owner"> Brand owner</label> <br>
                                                         </div>
                                                        
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                      <div class="col-md-8">
                                                        <label>Business PROCESS</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                          <?php
                                                            $array_PROCESS = explode(", ", $row["BusinessPROCESS"]);
                                                        ?>
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Manufacturing" name="BusinessPROCESS[]" value="Manufacturing" <?php if($users == $row['users_entities']){ if (in_array('Manufacturing', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Manufacturing"> Manufacturing</label> <br>
                                                                <input type="checkbox" id="Distribution" name="BusinessPROCESS[]" value="Distribution" <?php if($users == $row['users_entities']){ if (in_array('Distribution', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Distribution"> Distribution</label> <br>
                                                                <input type="checkbox" id="Co-Packer" name="BusinessPROCESS[]" value="Co-Packer" <?php if($users == $row['users_entities']){ if (in_array('Co-Packer', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Co-Packer"> Co-Packer</label> <br>
                                                                <input type="checkbox" id="Co-Manufacturer" name="BusinessPROCESS[]" value="Co-Manufacturer" <?php if($users == $row['users_entities']){ if (in_array('Co-Manufacturer', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Co-Manufacturer">Co-Manufacturer</label> <br>
                                                                <input type="checkbox" id="Retailer" name="BusinessPROCESS[]" value="Retailer" <?php if($users == $row['users_entities']){ if (in_array('Retailer', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Retailer"> Retailer</label> <br>
                                                                <input type="checkbox" id="Reseller" name="BusinessPROCESS[]" value="Reseller" <?php if($users == $row['users_entities']){ if (in_array('Reseller', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Reseller"> Reseller</label> <br>
                                                                <input type="checkbox" id="Buyer" name="BusinessPROCESS[]" value="Buyer" <?php if($users == $row['users_entities']){ if (in_array('Buyer', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Buyer">Buyer</label> <br>
                                                                 <input type="checkbox" id="Seller" name="BusinessPROCESS[]" value="Seller" <?php if($users == $row['users_entities']){ if (in_array('Seller', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Seller">Seller</label> <br>
                                                                 <input type="checkbox" id="Broker" name="BusinessPROCESS[]" value="Broker" <?php if($users == $row['users_entities']){ if (in_array('Broker', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Broker">Broker</label> <br>
                                                                 <input type="checkbox" id="Packaging" name="BusinessPROCESS[]" value="Packaging" <?php if($users == $row['users_entities']){ if (in_array('Packaging', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Packaging">Packaging</label> <br>
                                                                 <input type="checkbox" id="Professional Servicesr" name="BusinessPROCESS[]" value="Professional Services" <?php if($users == $row['users_entities']){ if (in_array('Professional Services', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Professional Services">Professional Services</label> <br>
                                                                 <input type="checkbox" id="IT Services" name="BusinessPROCESS[]" value="IT Services" <?php if($users == $row['users_entities']){ if (in_array('IT Services', $array_PROCESS)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="IT Services">IT Services</label> <br>
                                                         </div>
                                                        </div>
                                                 </div>
                                             </div>
                                             <hr>
                                               <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="col-md-8">
                                                        <label>Products/Services Offering</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <?php
                                                            $array_Offering = explode(", ", $row["ServicesOffering"]);
                                                        ?>
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Services" name="ServicesOffering[]" value="Services" <?php if($users == $row['users_entities']){ if (in_array('Services', $array_Offering)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Services">Services</label> <br>
                                                                <input type="checkbox" id="Products" name="ServicesOffering[]" value="Products" <?php if($users == $row['users_entities']){ if (in_array('Products', $array_Offering)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Productsr"> Products</label> <br>
                                                         </div>
                                                        
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                      <div class="col-md-8">
                                                        <label>Quality System</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <?php
                                                            $array_QualitySystem = explode(", ", $row["QualitySystem"]);
                                                        ?>
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="ISO" name="QualitySystem[]" value="ISO" <?php if($users == $row['users_entities']){ if (in_array('ISO', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="ISO"> ISO</label> <br>
                                                                <input type="checkbox" id="BRC" name="QualitySystem[]" value="BRC" <?php if($users == $row['users_entities']){ if (in_array('BRC', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="BRC"> BRC</label> <br>
                                                                <input type="checkbox" id="SQF" name="QualitySystem[]" value="SQF" <?php if($users == $row['users_entities']){ if (in_array('SQF', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="SQF">SQF</label> <br>
                                                                <input type="checkbox" id="FSSC 22000" name="QualitySystem[]" value="FSSC 22000" <?php if($users == $row['users_entities']){ if (in_array('FSSC 22000', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="FSSC 22000">FSSC 22000</label> <br>
                                                                <input type="checkbox" id="PrimusGFS" name="QualitySystem[]" value="PrimusGFS" <?php if($users == $row['users_entities']){ if (in_array('PrimusGFS', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="PrimusGFS"> PrimusGFS</label> <br>
                                                                <input type="checkbox" id="Other" name="QualitySystem[]" value="Other" <?php if($users == $row['users_entities']){ if (in_array('Other', $array_QualitySystem)) { echo 'checked';}}else{ echo '';} ?>>
                                                                <label for="Other"> Other</label> 
                                                         </div>
                                                        </div>
                                                 </div>
                                             </div>
                                             <hr>
                                              <div class="row">
                                                <div class="col-md-12">
                                                    <label>Food / Safety Codes<i>If Applicable:</i></label>
                                                    <textarea class="form-control"><?php echo $row['SafetyCodes']; ?></textarea>
                                                </div>
                                             </div>
                                             <hr>
                                             <div class="row">
                                                  <div class="col-md-12">
                                                    <!--<input type="submit" name="submitUpdate" value="Save" class="btn btn-primary" style="float:right;">-->
                                                  </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                 
                                </form>
                               
                            </div>
                             <?php    }else{ ?>
                                 <div class="profile-content">
                                 <!--for new-->
                                <form action="admin_2/enterpriseDetailsFunction.php" method="POST" enctype="multipart/form-data">
                                   
                                <div class="row">
                                    <div class="container" style="background-color:#fff;padding:3rem;width:100%;">
                                        <div class="col-md-12" >
                                            <!--business Name-->
                                            <h4><strong>Legal Name</strong></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                            <input type="hidden" class="form-control" name="ids" value="<?php if($users == $row['users_entities']){ echo $row['enterp_id'];}else{ echo '';} ?>" required> 
                                                            <input class=" form-control" name="businessname" value="" required> 
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <!--<input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>-->
                                                        <select class="form-control">
                                                            <option>---Select---</option>
                                                            <option>Afghanistan</option>
                                                            <option>Albania</option>
                                                            <option>Algeria</option>
                                                            <option>Andorra</option>
                                                            <option>Angola</option>
                                                            <option>Antigua and Barbuda</option>
                                                            <option>Argentina</option>
                                                             <option>Armenia</option>
                                                              <option>Australia</option>
                                                               <option>Austria</option>
                                                                <option>Azerbaijan</option>
                                                                 <option>Bahamas</option>
                                                                  <option>Bahrain</option>
                                                                   <option>Bangladesh</option>
                                                                    <option>Barbados</option>
                                                                     <option>Belarus</option>
                                                                      <option>Belgium</option>
                                                              <option>Belize</option>
                                                              <option>Benin</option>
                                                              <option>Bhutan</option>
                                                              <option>Bolivia</option>
                                                              <option>Bosnia and Herzegovina</option>
                                                              <option>Botswana</option>
                                                              <option>Brazil</option>
                                                              <option>Brunei</option>
                                                              <option>Bulgaria</option>
                                                              <option>Burkina Faso</option>
                                                              <option>Burundi</option>
                                                              <option>Côte d Ivoire</option>
                                                             <option>Cabo Verde</option>
                                                             <option>Cambodia</option>
                                                             <option>Cameroon</option>
                                                             <option>Canada</option>
                                                             <option>Central African Republic</option>
                                                             <option>Chad</option>
                                                             <option>Chile</option>
                                                             <option>China</option>
                                                             <option>Colombia</option>
                                                             <option>Comoros</option>
                                                             <option>Congo (Congo-Brazzaville)</option>
                                                             <option>Costa Rica</option>
                                                             <option>Croatia</option>
                                                             <option>Cuba</option>
                                                             <option>Cyprus</option>
                                                             <option>Czechia (Czech Republic)</option>
                                                             <option>Democratic Republic of the Congo</option>
                                                             <option>Denmark</option>
                                                             <option>Djibouti</option>
                                                             <option>Dominica</option>
                                                             <option>Dominican Republic</option>
                                                             <option>Ecuador</option>
                                                             <option>Egypt</option>
                                                             <option>El Salvador</option>
                                                             <option>Equatorial Guinea</option>
                                                             <option>Eritrea</option>
                                                             <option>Estonia</option>
                                                             <option>Eswatini (fmr. "Swaziland")</option>
                                                             <option>Ethiopia</option>
                                                             <option>Fiji</option>
                                                             <option>Finland</option>
                                                             <option>France</option>
                                                             <option>Gabon</option>
                                                             <option>Gambia</option>
                                                             <option>Georgia</option>
                                                             <option>Germany</option>
                                                             <option>Ghana</option>
                                                             <option>Greece</option>
                                                             <option>Grenada</option>
                                                             <option>Guatemala</option>
                                                             <option>Guinea</option>
                                                             <option>Guinea-Bissau</option>
                                                             <option>Guyana</option>
                                                             <option>Haiti</option>
                                                             <option>Holy See</option>
                                                             <option>Honduras</option>
                                                             <option>Hungary</option>
                                                             <option>Iceland</option>
                                                             <option>India</option>
                                                             <option>Indonesia</option>
                                                             <option>Iran</option>
                                                             <option>Iraq</option>
                                                             <option>Ireland</option>
                                                             <option>Israel</option>
                                                             <option>Italy</option>
                                                             <option>Jamaica</option>
                                                             <option>Japan</option>
                                                             <option>Jordan</option>
                                                             <option>Kazakhstan</option>
                                                             <option>Kenya</option>
                                                             <option>Kiribati</option>
                                                             <option>Kuwait</option>
                                                             <option>Kyrgyzstan</option>
                                                             <option>Laos</option>
                                                             <option>Latvia</option>
                                                             <option>Lebanon</option>
                                                             <option>Lesotho</option>
                                                            <option>Liberia</option>
                                                            <option>Libya</option>
                                                            <option>Liechtenstein</option>
                                                            <option>Lithuania</option>
                                                            <option>Luxembourg</option>
                                                            <option>Madagascar</option>
                                                            <option>Malawi</option>
                                                            <option>Malaysia</option>
                                                            <option>Maldives</option>
                                                            <option>Mali</option>
                                                            <option>Malta</option>
                                                            <option>Marshall Islands</option>
                                                            <option>Mauritania</option>
                                                            <option>Mauritius</option>
                                                            <option>Mexico</option>
                                                            <option>Micronesia</option>
                                                            <option>Moldova</option>
                                                            <option>Monaco</option>
                                                            <option>Mongolia</option>
                                                            <option>Montenegro</option>
                                                            <option>Morocco</option>
                                                            <option>Mozambique</option>
                                                            <option>Myanmar (formerly Burma)</option>
                                                            <option>Namibia</option>
                                                            <option>Nauru</option>
                                                            <option>Nepal</option>
                                                            <option>Netherlands</option>
                                                            <option>New Zealand</option>
                                                            <option>Nicaragua</option>
                                                            <option>Niger</option>
                                                            <option>Nigeria</option>
                                                            <option>North Korea</option>
                                                            <option>North Macedonia</option>
                                                            <option>Norway</option>
                                                            <option>Oman</option>
                                                            <option>Pakistan</option>
                                                            <option>Palau</option>
                                                            <option>Palestine State</option>
                                                            <option>Panama</option>
                                                            <option>Papua New Guinea</option>
                                                            <option>Paraguay</option>
                                                            <option>Peru</option>
                                                            <option>Philippines</option>
                                                            <option>Poland</option>
                                                            <option>Portugal</option>
                                                            <option>Qatar</option>
                                                            <option>Romania</option>
                                                            <option>Russia</option>
                                                            <option>Rwanda</option>
                                                            <option>Saint Kitts and Nevis</option>
                                                            <option>Saint Lucia</option>
                                                            <option>Saint Vincent and the Grenadines</option>
                                                            <option>Samoa</option>
                                                            <option>San Marino</option>
                                                            <option>Sao Tome and Principe</option>
                                                            <option>Saudi Arabia</option>
                                                            <option>Senegal</option>
                                                            <option>Serbia</option>
                                                            <option>Seychelles</option>
                                                            <option>Sierra Leone</option>
                                                            <option>Singapore</option>
                                                            <option>Slovakia</option>
                                                            <option>Slovenia</option>
                                                            <option>Solomon Islands</option>
                                                            <option>Somalia</option>
                                                            <option>South Africa</option>
                                                            <option>South Korea</option>
                                                            <option>South Sudan</option>
                                                            <option>Spain</option>
                                                            <option>Sri Lanka</option>
                                                            <option>Sudan</option>
                                                            <option>Suriname</option>
                                                            <option>Sweden</option>
                                                            <option>Switzerland</option>
                                                            <option>Syria</option>
                                                            <option>Tajikistan</option>
                                                            <option>Tanzania</option>
                                                            <option>Thailand</option>
                                                            <option>Timor-Leste</option>
                                                            <option>Togo</option>
                                                            <option>Tonga</option>
                                                            <option>Tonga</option>
                                                            <option>Trinidad and Tobago</option>
                                                            <option>Tunisia</option>
                                                            <option>Turkey</option>
                                                            <option>Turkmenistan</option>
                                                            <option>Tuvalu</option>
                                                            <option>Uganda</option>
                                                            <option>Ukraine</option>
                                                            <option>United Arab Emirates</option>
                                                            <option>United Kingdom</option>
                                                            <option>United States of America</option>
                                                            <option>Uruguay</option>
                                                            <option>Uzbekistan</option>
                                                            <option>Vanuatu</option>
                                                            <option>Venezuela</option>
                                                            <option>Vietnam</option>
                                                            <option>Yemen</option>
                                                            <option>Zambia</option>
                                                            <option>Zimbabwe</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                             <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>House/Bldg No./Street:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>City:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>State:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"><strong>Zip Code:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="businessaddress" value="<?php echo $row['businessaddress']; ?>" required>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="businesstelephone" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="businessfax" value="">
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="businessemailAddress" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Website:</strong></label>
                                                        <input class=" form-control" name="businesswebsite" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr >
                                             <!--Business- Contact Person(s)-->
                                            <h4><strong>Contact Person(s)</strong> &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>First Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="contactpersonname" required> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>Last Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="contactpersonname" required> 
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Title:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="title" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="row">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <div class="col-md-12">-->
                                            <!--            <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>-->
                                            <!--            <input class=" form-control" name="contactpersonaddress" value="" required>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Cell No.:</strong></label>
                                                        <input type="number" class=" form-control" name="contactpersoncellno" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="contactpersonphone" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="contactpersonfax" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="contactpersonemailAddress" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr >
                                            <!--Business - EMERGENCY: Contact Person(s)-->
                                            <h4><strong>Emergency: Contact Person(s)</strong> &nbsp;<input type="checkbox" id="" name="" value="" >
                                            <label for="Direct Buyer"> None</label> &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button></h4>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>First Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="" required> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="ids" value="">
                                                        <label class="control-label"><strong>Last Name:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                       
                                                            <input class=" form-control" name="" required> 
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label"><strong>Title:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="emergencytitle" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="row">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <div class="col-md-12">-->
                                            <!--            <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>-->
                                            <!--            <input class=" form-control" name="emergencyaddress" value="" required>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Cell No.:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="number" class=" form-control" name="emergencycellno" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Phone:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input class=" form-control" name="emergencyphone" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>FAX:</strong></label>
                                                        <input type="number" class=" form-control" name="emergencyfax" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Email address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                        <input type="email" class=" form-control" name="emergencyemailAddress" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Business Structure-->
                                            <hr >
                                            <h4><strong>Business Structure</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="Direct Buyer" name="BusinessStructure[]" value="Sole Propreitorship" >
                                                                        <label for="Direct Buyer"> Sole Propreitorship</label>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" name="SolePropreitorship" class="form-control" >
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Private Label Owner" name="BusinessStructure[]" value="General Partnership" >
                                                                        <label for="Private Label Owner"> General Partnership</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" name="GeneralPartnership" class="form-control" multiple>
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Authorized Agent / Rep." name="BusinessStructure[]" value="Corporation" >
                                                                     <label for="Authorized Agent / Rep.">Corporation</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="Corporation" class="form-control">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Retailer" name="BusinessStructure[]" value="Limited Liability Company" >
                                                                     <label for="Retailer">Limited Liability Company</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="LimitedLiabilityCompany" class="form-control" multiple>
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Manufacturer" name="BusinessStructure[]" value="Limited Partnership" >
                                                                    <label for="Manufacturer">Limited Partnership</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="LimitedPartnership" class="form-control" multiple>
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Distributor" name="BusinessStructure[]" value="Limited Liability Parnership" >
                                                                        <label for="Distributor">Limited Liability Parnership</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" name="LimitedLiabilityParnership" class="form-control" multiple>
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="BusinessStructure[]" value="Others (Please Specify)" >
                                                                        <label for="Authorized Agent / Rep.">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersBusinessStructure" value="">
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" name="otherbStructurefile" class="form-control" multiple>
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                   
                                                     
                                                 </div>
                                            </div>
                                            <hr >
                                            <h4><strong>Enterprise / Business Description</strong></h4>
                                            <div class="row">
                                                 <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class=" form-control" name="BusinessPurpose" value=""></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                              <div class="row">
                                                         <div class="col-md-12">
                                                              <div class="form-group">
                                                             <label class="control-label"><strong>Annual Gross Revenue</strong></label>
                                                             <input type="" id="" name="" value="Annual Gross Revenue" class="form-control">
                                                            </div>
                                                         </div>
                                            </div>
                                            <hr>
                                            <h4><strong>Trademarks </strong> &nbsp;<input type="checkbox" id="" name="" value="" ><label for="Direct Buyer"> None</label>
                                            &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>
                                            </h4>
                                            <div class="row">
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Trademark Name(s):</strong></label>
                                                        <input type="text" class=" form-control" name="TrademarkName" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Supporting file:</strong></label>
                                                        <input type="file" class=" form-control" name="TrademarkNameFile" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Tradename:</strong></label>
                                                        <input type="text" class=" form-control" name="Tradename" value="">
                                                    </div>
                                                </div>
                                            </div>
                                             <hr>
                                            <h4><strong>Parent Company</strong></h4>
                                             <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Headquarters Address:</strong></label>
                                                        <input type="text" class=" form-control" name="Headquarters" value="">
                                                    </div>
                                                </div>
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>City:</strong></label>
                                                        <input type="text" class=" form-control" name="City" value="">
                                                    </div>
                                                </div>
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>States:</strong></label>
                                                        <input type="text" class=" form-control" name="State" value="">
                                                    </div>
                                                </div>
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Zip Code:</strong></label>
                                                        <input type="text" class=" form-control" name="Zip  Code" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Parent Company Name:</strong></label>
                                                        <input type="text" class=" form-control" name="ParentCompanyName" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Year Established:</strong></label>
                                                        <input type="text" class=" form-control" name="YearEstablished" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Dunn & Brad Street Number:</strong></label>
                                                        <input type="text" class=" form-control" name="Dunn" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>What is your relationship with the enterprise?</strong></label>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <thead></thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Direct Employee</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Employee of Parent Company</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Sister Division</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Subsidiary</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Third Party</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> None</label></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                </div>
                                                
                                                 <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>What is your current position with the enterprise?  </strong></label>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <thead></thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Account Payable</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Information System</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> CFO</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Insurance</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Primary Account Represntative</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> CEO</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Marketing</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Food Safety</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Operations</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Executive</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Account Receivable</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Product Safety</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Legal</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Returns</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Transportation</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Compliance</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Finance</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Human Resources</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Logistics</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Purchase Order</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Sales</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> Orders</label></td>
                                                                <td><input type="checkbox" id="" name="" value="" > <label for="Direct Buyer"> None</label></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group">
                                                        <label class="control-label"><strong>Others </strong> <i>(Specify)</i></label>
                                                        <input class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                             <hr >
                                            <h4><strong>Certification</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="GFSI" name="Certification[]" value="GFSI" >
                                                                        <label for="GFSI"> GFSI</label>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="GFSIFILE">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="SQF" name="Certification[]" value="SQF" >
                                                                        <label for="SQF">SQF</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="SQFFILE">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="BRC" name="Certification[]" value="BRC" >
                                                                     <label for="BRC">BRC</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="BRCFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="FSSC22000" name="Certification[]" value="FSSC22000" >
                                                                     <label for="FSSC22000">FSSC22000</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="FSSC22000FILE">
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="ISO" name="Certification[]" value="ISO" >
                                                                    <label for="ISO">ISO</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="ISOFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="PrimusGFS" name="Certification[]" value="Primus GFS" >
                                                                        <label for="PrimusGFS">Primus GFS</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="PrimusGFSFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="HACCP" name="Certification[]" value="HACCP" >
                                                                    <label for="HACCP">HACCP</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="HACCPFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="GMP" name="Certification[]" value="GMP" >
                                                                        <label for="GMP">GMP</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="GMPFILE">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Certification[]" value="Others" >
                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersCertification" value="">
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="OthersFILE">
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                             <h4><strong>Factory / Facility Accreditation</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="Organic" name="Accreditation[]" value="Organic" >
                                                                        <label for="Organicr"> Organic</label>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="OrganicFile">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Halal" name="Accreditation[]" value="Halal" >
                                                                        <label for="Halal">Halal</label>
                                                                 </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="HalalFile">
                                                                 </td>
                                                               
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="Kosher" name="Accreditation[]" value="Kosher" >
                                                                     <label for="Kosher">Kosher</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="KosherFile">
                                                                 </td>
                                                             </tr>
                                                              <tr>
                                                                 <td>
                                                                     <input type="checkbox" id="Non-GMO" name="Accreditation[]" value="Non-GMO" >
                                                                     <label for="Non-GMO">Non-GMO</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="NonGMOFile">
                                                                 </td>
                                                                
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id=" Based" name="Accreditation[]" value="Plant Based" >
                                                                    <label for="Plant Based">Plant Based</label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="PlantBasedFile">
                                                                 </td>
                                                             </tr>
                                                             
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Accreditation[]" value="Others" >
                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersAccreditation" value="">
                                                                       
                                                                 </td>
                                                                 <td>
                                                                      
                                                                     <input type="file" class="form-control" name="othersAccreditationFile">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" id=" Based" name="Accreditation[]" value="None" >
                                                                    <label for="None">None</label>
                                                                 </td>
                                                                 <td>
                                                                     <!--<input type="file" class="form-control" name="PlantBasedFile">-->
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                            <h4><strong>Enterprise Regulatory Compliance Requirements</strong></h4>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                <td></td>
                                                                 <td>Supporting Files</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <tr>
                                                                 <td> 
                                                                        <input type="checkbox" id="FDA" name="Regulatory[]" value="FDA" >
                                                                        <label for="FDA"> FDA</label>
                                                                </td>
                                                                 <td>
                                                                      <input type="file" class="form-control" name="FDAfile">
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="USDA" name="Regulatory[]" value="USDA" >
                                                                        <label for="USDA">USDA</label>
                                                                 </td>
                                                                 <td>
                                                                          <input type="file" class="form-control" name="USDAfile">
                                                                 </td>
                                                               
                                                             </tr>
                                                            
                                                              <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="bs" onclick="checkMeBS()" name="Regulatory[]" value="Others" >
                                                                        <label for="Others">Others (Please Specify)</label><br>
                                                                        <input class=" form-control" id="boxBS" name="othersRegulatory" value="">
                                                                 </td>
                                                                 <td>
                                                                     
                                                                        
                                                                     <input type="file" class="form-control" name="OthersRegulatoryfile">
                                                                 </td>
                                                             </tr>
                                                               <tr>
                                                                 <td>
                                                                      <input type="checkbox" id="None" name="Regulatory[]" value="None" >
                                                                        <label for="None">None</label>
                                                                 </td>
                                                                 <td>
                                                                          
                                                                 </td>
                                                               
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     
                                                 </div>
                                            </div>
                                             <h5><strong>Enterprise Records  &nbsp;<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>&nbsp;ADD</button>&nbsp;<i style="font-size:12px;background-color:orange;color:#fff;">Examples (Tax ID, Corporate Documents, Partnerhip agreements, certificates, accreditations, etc.)</i></strong></h5>
                                             <div class="row">
                                                 <div>
                                                     <table class="table table-bordered">
                                                         <thead>
                                                             <tr>
                                                                 <td>Document</td>
                                                                 <td>Title </td>
                                                                 <td>Description </td>
                                                                 <td>Document Due Date</td>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr>
                                                                 <td>
                                                                     <input type="file" class="form-control" name="EnterpriseRecordsFile">
                                                                 </td>
                                                                  <td>
                                                                      <input class="form-control" name="DocumentTitle">
                                                                  </td>
                                                                   <td>
                                                                       <textarea class="form-control" name="DocumentDesciption"></textarea>
                                                                   </td>
                                                                    <td>
                                                                        <input type="date" class="form-control" name="DocumentDueDate">
                                                                    </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise have a Factory(ies) / Facility(ies)?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    
                                                    <select class="form-control" name="enterpriseOperation">
                                                        <option value="No" >No</option>
                                                        <option value="Yes" >Yes</option>
                                                    </select>
                                                 </div>
                                             </div>
                                             <br>
                                              <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise has employees?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <select class="form-control" name="enterpriseEmployees">
                                                        <option value="No">No</option>
                                                        <option value="Yes">Yes</option>
                                                    </select>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <label>Number of Employees&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <input type="number" class="form-control">
                                                 </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Is the enterprise an importer?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <select class="form-control" name="">
                                                        <option value="No">No</option>
                                                        <option value="Yes">Yes</option>
                                                    </select>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <label>Country&nbsp;<i style="color:orange;">(If yes)</i></label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <input type="" class="form-control">
                                                 </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise offer products?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    
                                                    <select class="form-control" name="">
                                                        <option value="No" >No</option>
                                                        <option value="Yes" >Yes</option>
                                                    </select>
                                                 </div>
                                                  <div class="col-md-2">
                                                    <label>Product &nbsp;<i style="color:orange;">(If yes)</i></label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <input type="" class="form-control">
                                                 </div>
                                             </div>
                                              <br>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                    <label>Does the enterprise offer services?</label>
                                                 </div>
                                                 <div class="col-md-2">
                                                    
                                                    <select class="form-control" name="enterpriseOperation">
                                                        <option value="No" >No</option>
                                                        <option value="Yes" >Yes</option>
                                                    </select>
                                                 </div>
                                                     <div class="col-md-2">
                                                        <label>Products/Services Offering</label>
                                                     </div>
                                                     <div class="col-md-2">
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Services" name="ServicesOffering[]" value="Services" >
                                                                <label for="Services">Services</label> <br>
                                                                <input type="checkbox" id="Products" name="ServicesOffering[]" value="Products" >
                                                                <label for="Products"> Products</label> <br>
                                                         </div>
                                                        
                                                     </div>
                                             </div>
                                             <br>
                                             <hr>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="col-md-8">
                                                        <label>Factory / Facility Function</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Manufacturing Facilities" name="EnterpriseFunction[]" value="Manufacturing Facilities" >
                                                                <label for="Manufacturing Facilities"> Manufacturing Facilities</label> <br>
                                                                <input type="checkbox" id="Warehouse Storage" name="EnterpriseFunction[]" value="Warehouse Storage" >
                                                                <label for="Warehouse Storage"> Warehouse Storage</label> <br>
                                                                <input type="checkbox" id="Distribution Center" name="EnterpriseFunction[]" value="Distribution Center" >
                                                                <label for="Distribution Center"> Distribution Center</label> <br>
                                                                <input type="checkbox" id="Retail Location" name="EnterpriseFunction[]" value="Retail Location" >
                                                                <label for="Retail Location">Retail Location</label> <br>
                                                                <input type="checkbox" id="Laboratory" name="EnterpriseFunction[]" value="Laboratory" >
                                                                <label for="Laboratory"> Laboratory</label> <br>
                                                                <input type="checkbox" id="Testing" name="EnterpriseFunction[]" value="Testing" >
                                                                <label for="Testing"> Testing</label> <br>
                                                                 <input type="checkbox" id="Sales Office" name="EnterpriseFunction[]" value="Sales Office" >
                                                                <label for="Sales Office"> Sales Office</label> <br>
                                                         </div>
                                                        
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                      <div class="col-md-8">
                                                        <label>Enterprise  Process</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="Manufacturing" name="BusinessPROCESS[]" value="Manufacturing" >
                                                                <label for="Manufacturing"> Manufacturing</label> <br>
                                                                <input type="checkbox" id="Distribution" name="BusinessPROCESS[]" value="Distribution" >
                                                                <label for="Distributionr"> Distribution</label> <br>
                                                                <input type="checkbox" id="Co-Packer" name="BusinessPROCESS[]" value="Co-Packer" >
                                                                <label for="Co-Packer"> Co-Packer</label> <br>
                                                                <input type="checkbox" id="Co-Manufacturer" name="BusinessPROCESS[]" value="Co-Manufacturer" >
                                                                <label for="Co-Manufacturer">Co-Manufacturer</label> <br>
                                                                <input type="checkbox" id="Retailer" name="BusinessPROCESS[]" value="Retailer" >
                                                                <label for="Retailer"> Retailer</label> <br>
                                                                <input type="checkbox" id="Reseller" name="BusinessPROCESS[]" value="Reseller" >
                                                                <label for="Reseller"> Reseller</label> <br>
                                                                <input type="checkbox" id="Buyer" name="BusinessPROCESS[]" value="Buyer" >
                                                                <label for="Buyerr">Buyer</label> <br>
                                                                 <input type="checkbox" id="Seller" name="BusinessPROCESS[]" value="Seller" >
                                                                <label for="Seller">Seller</label> <br>
                                                                 <input type="checkbox" id="Broker" name="BusinessPROCESS[]" value="Broker" >
                                                                <label for="Broker">Broker</label> <br>
                                                                 <input type="checkbox" id="Packaging" name="BusinessPROCESS[]" value="Packaging" >
                                                                <label for="Packaging">Packaging</label> <br>
                                                                 <input type="checkbox" id="Professional Services" name="BusinessPROCESS[]" value="Professional Services" >
                                                                <label for="Professional Servicesr">Professional Services</label> <br>
                                                                 <input type="checkbox" id="IT Services" name="BusinessPROCESS[]" value="IT Services" >
                                                                <label for="IT Services">IT Services</label> <br>
                                                                <input type="checkbox" id="Brand Owner" name="BusinessPROCESS[]" value="Brand Owner" >
                                                                <label for="Brand Owner">Brand Owner</label> <br>
                                                                <input type="checkbox" id="Cultivation" name="BusinessPROCESS[]" value="Cultivation" >
                                                                <label for="Cultivation ">Cultivation</label> <br>
                                                                <input type="checkbox" id="Others" name="BusinessPROCESS[]" value="Others" >
                                                                <label for="IT Services">Others</label> <br>
                                                                <input class="form-control">
                                                         </div>
                                                        </div>
                                                 </div>
                                             </div>
                                             <hr>
                                               <div class="row">
                                                 
                                                 <div class="col-md-6 hide">
                                                      <div class="col-md-8">
                                                        <label>Quality System</label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <div style="overflow:scroll;width:100%;height:200px;">
                                                              <input type="checkbox" id="ISO" name="QualitySystem[]" value="ISO" >
                                                                <label for="ISO"> ISO</label> <br>
                                                                <input type="checkbox" id="BRC" name="QualitySystem[]" value="BRC" >
                                                                <label for="BRC"> BRC</label> <br>
                                                                <input type="checkbox" id="SQF" name="QualitySystem[]" value="SQF" >
                                                                <label for="SQFr">SQF</label> <br>
                                                                <input type="checkbox" id="FSSC 22000" name="QualitySystem[]" value="FSSC 22000" >
                                                                <label for="DFSSC 22000">FSSC 22000</label> <br>
                                                                <input type="checkbox" id="PrimusGFS" name="QualitySystem[]" value="PrimusGFS" >
                                                                <label for="PrimusGFS"> PrimusGFS</label> <br>
                                                                <input type="checkbox" id="Other" name="QualitySystem[]" value="Other" >
                                                                <label for="Other"> Other</label> 
                                                         </div>
                                                        </div>
                                                 </div>
                                             </div>
                                              <div class="row hide">
                                                <div class="col-md-12">
                                                    <label>Food / Safety Codes<i>If Applicable:</i></label>
                                                    <textarea class="form-control" name="SafetyCodes"></textarea>
                                                </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-12">
                                                    <!--<input type="submit" name="submit" value="Save" class="btn btn-primary" style="float:right;">-->
                                                  </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                 
                                </form>
                               
                            </div>
                            <?php } ?>
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