<?php 
    $title = "Account Setting";
    $site = "profile-setting";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('database_payroll.php'); 
    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php include_once ('profile-sidebar.php'); ?>

                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase" translate="no">Profile Account</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tabPersonal" data-toggle="tab">Basic Information</a>
                                                    </li>
                                                    <?php if($switch_user_id == 34): ?>
                                                    <li style="display:nonex">
                                                        <a href="#tabOthers" data-toggle="tab">Personal Information</a>
                                                    </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="#tabSocial" data-toggle="tab">Social Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabAvatar" data-toggle="tab">Change Avatar</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabPassword" data-toggle="tab">Change Password</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabPrivacy" data-toggle="tab">Privacy Settings</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabFiles" data-toggle="tab">Files</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <!-- PERSONAL INFO TAB -->
                                                    <div class="tab-pane active" id="tabPersonal">
                                                        <form method="post" class="formUsers formInfo">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">First Name</label>
                                                                <input class="form-control" type="text" name="first_name" id="first_name" placeholder="<?php echo $current_userFName; ?>" value="<?php echo $current_userFName; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Last Name</label>
                                                                <input class="form-control" type="text" name="last_name" id="last_name" placeholder="<?php echo $current_userLName; ?>" value="<?php echo $current_userLName; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Mobile Number</label>
                                                                <input class="form-control" type="text" name="mobile" id="mobile" placeholder="<?php echo $current_userMobile; ?>" value="<?php echo $current_userMobile; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address</label>
                                                                <input class="form-control" type="text" name="address" id="address" placeholder="<?php echo $current_userAddress; ?>" value="<?php echo $current_userAddress; ?>" required />
                                                            </div>
                                                            <div class="form-group <?php echo $current_client == 1 ? '':'hide'; ?>">
                                                                <label class="control-label">Driver License #</label>
                                                                <input class="form-control" type="text" name="driver_license" id="driver_license" placeholder="<?php echo $current_userDLicense; ?>" value="<?php echo $current_userDLicense; ?>" />
                                                            </div>
                                                            <div class="form-group <?php echo $current_client == 1 ? '':'hide'; ?>">
                                                                <label class="control-label">Alarm Code</label>
                                                                <input class="form-control" type="text" value="<?php echo $current_userAlarmCode; ?>" readonly />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Interests</label>
                                                                <input class="form-control" type="text" name="interest" id="interest" placeholder="Design, Web etc." value="<?php echo $current_userInterest; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Occupation</label>
                                                                <input class="form-control" type="text" name="occupation" id="occupation" placeholder="Web Developer" value="<?php echo $current_userOccupation; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">About</label>
                                                                <textarea class="form-control" rows="3" name="about" id="about" placeholder="Tell us about you!" ><?php echo $current_userAbout; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Website Url</label>
                                                                <input class="form-control" type="text" name="website" id="website" placeholder="http://www.example.com or http://example.com" value="<?php echo !empty($current_userWebsite) ? $current_userWebsite : 'https://'; ?>" />
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="btnSave_userInfo" id="btnSave_userInfo" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END PERSONAL INFO TAB -->
                                                    <!-- SOCIAL MEDIA TAB -->
                                                    <div class="tab-pane" id="tabSocial">
                                                        <form method="post" class="formUsers formSocial">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">LinkedIn</label>
                                                                <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="username" value="<?php echo $current_userLinkedIn; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Facebook</label>
                                                                <input type="text" class="form-control" name="facebook" id="facebook" placeholder="username" value="<?php echo $current_userFacebook; ?>" />
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="btnSave_userSocial" id="btnSave_userSocial" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END SOCIAL MEDIA TAB -->
                                                    <!-- CHANGE AVATAR TAB -->
                                                    <div class="tab-pane" id="tabAvatar">
                                                        <form method="post" enctype="multipart/form-data" class="formUsers formAvatar">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <div class="form-group">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                        <?php
                                                                            if ( empty($current_userAvatar) ) {
                                                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                                            } else {
                                                                                echo '<img src="uploads/avatar/'. $current_userAvatar .'" class="img-responsive" alt="Avatar" />';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                                                    <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> Select image </span>
                                                                            <span class="fileinput-exists"> Change </span>
                                                                            <input class="form-control" type="file" name="file" />
                                                                        </span>
                                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix margin-top-10">
                                                                    <span class="label label-danger">NOTE!</span>
                                                                    <span> Attach image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                                </div>
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="btnSave_userAvatar" id="btnSave_userAvatar" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END CHANGE AVATAR TAB -->
                                                    <!-- CHANGE PASSWORD TAB -->
                                                    <div class="tab-pane" id="tabPassword">
                                                        <form method="post" class="formUsers formPassword">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">Current Password</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-eye font-green viewPW"></i>
                                                                    <input type="password" class="form-control" name="password" id="password" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">New Password</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-eye font-green viewPW"></i>
                                                                    <input type="password" class="form-control" name="password_new" id="password_new" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Re-type New Password</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-eye font-green viewPW"></i>
                                                                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" required />
                                                                </div>
                                                            </div>
                                                            <div class="margin-top-10">
                                                                <input type="submit" class="btn green" name="btnSave_userPassword" id="btnSave_userPassword" value="Change Password" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END CHANGE PASSWORD TAB -->
                                                    <!-- PRIVACY SETTINGS TAB -->
                                                    <div class="tab-pane" id="tabPrivacy">
                                                        <form method="post" class="formUsers formPrivacy">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <table class="table table-light table-hover">
                                                                <?php 
                                                                    $array_optionPrivacy = explode(',', $current_userPrivacy);
                                                                    if (empty($array_optionPrivacy[0])) { $array_optionPrivacy[0] = 0; }
                                                                    if (empty($array_optionPrivacy[1])) { $array_optionPrivacy[1] = 0; }
                                                                    if (empty($array_optionPrivacy[2])) { $array_optionPrivacy[2] = 0; }
                                                                    if (empty($array_optionPrivacy[3])) { $array_optionPrivacy[3] = 0; }
                                                                    if (empty($array_optionPrivacy[4])) { $array_optionPrivacy[4] = 0; }
                                                                ?>
                                                                <tr>
                                                                    <td>Do you want to share contact details to other employees?</td>
                                                                    <td>
                                                                        <div class="mt-radio-inline">
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy1" value="1" <?php echo $array_optionPrivacy[0] == "1" ? "checked" : ""; ?> /> Yes
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy1" value="0" <?php echo $array_optionPrivacy[0] == "0" ? "checked" : ""; ?> /> No
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Do you want to receive email to newly assigned tasks?</td>
                                                                    <td>
                                                                        <div class="mt-radio-inline">
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy2" value="1" <?php echo $array_optionPrivacy[1] == "1" ? "checked" : ""; ?> /> Yes
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy2" value="0" <?php echo $array_optionPrivacy[1] == "0" ? "checked" : ""; ?> /> No
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Do you want to receive email to newly assigned projects?</td>
                                                                    <td>
                                                                        <div class="mt-radio-inline">
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy3" value="1" <?php echo $array_optionPrivacy[2] == "1" ? "checked" : ""; ?> /> Yes
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy3" value="0" <?php echo $array_optionPrivacy[2] == "0" ? "checked" : ""; ?> /> No
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Do you want to allow your profile to be seen by other companies?</td>
                                                                    <td>
                                                                        <div class="mt-radio-inline">
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy4" value="1" <?php echo $array_optionPrivacy[3] == "1" ? "checked" : ""; ?> /> Yes
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy4" value="0" <?php echo $array_optionPrivacy[3] == "0" ? "checked" : ""; ?> /> No
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Do you want to display demo video?</td>
                                                                    <td>
                                                                        <div class="mt-radio-inline">
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy5" value="1" <?php echo $array_optionPrivacy[4] == "1" ? "checked" : ""; ?> /> Yes
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio">
                                                                                <input type="radio" name="optionPrivacy5" value="0" <?php echo $array_optionPrivacy[4] == "0" ? "checked" : ""; ?> /> No
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="btnSave_userPrivacy" id="btnSave_userPrivacy" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END PRIVACY SETTINGS TAB -->
                                                    
                                                    <!--START OTHER DETAILS TAB-->
                                                    <?php
                                                        $employee_details = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = '$current_userEmployeeID'" );
                                                        $row_employee= mysqli_fetch_array($employee_details);
                                                        $personal_email = '';
                                                        $company_email = '';
                                                        $employee_address = '';
                                                        $contact_no = '';
                                                        $emergency_name = '';
                                                        $emergency_address = '';
                                                        $emergency_contact_no = '';
                                                        $emergency_email = '';
                                                        $emergency_relation = '';
                                                        if($row_employee){
                                                            $personal_email = htmlentities($row_employee['personal_email'] ?? '');
                                                            $company_email = htmlentities($row_employee['company_email'] ?? '');
                                                            $contact_no = htmlentities($row_employee['contact_no'] ?? '');
                                                            $emergency_name  = htmlentities($row_employee['emergency_name'] ?? '');
                                                            $emergency_address = htmlentities($row_employee['emergency_address'] ?? '');
                                                            $emergency_contact_no = htmlentities($row_employee['emergency_contact_no'] ?? '');
                                                            $emergency_email = htmlentities($row_employee['emergency_email'] ?? '');
                                                            $emergency_relation = htmlentities($row_employee['emergency_relation'] ?? '');
                                                            $employee_address = htmlentities($row_employee['address'] ?? '');
                                                        }
                                                    ?>
                                                    
                                                    <div class="tab-pane" id="tabOthers">
                                                        <form method="post" action="controller.php">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <input class="form-control" type="hidden" name="employee_id" value="<?php echo $current_userEmployeeID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">Personal Email</label>
                                                                <input class="form-control" type="text" name="personal_email" id="personal_email" placeholder="" value="<?= $personal_email ?>" required />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Company Email</label>
                                                                        <input class="form-control" type="text" name="company_email" id="company_email" placeholder="" value="<?= $company_email ?>" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Start Date</label>
                                                                        <input class="form-control" type="date" name="start_date" id="start_date" placeholder="" value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address</label>
                                                                <?php
                                                                    $address = '';
                                                                    $postal_code = '';
                                                                    $region = '';
                                                                    $province = '';
                                                                    $city = '';
                                                                    $barangay = '';
                                                                    $street = '';
                                                                    $apartment ='';
                                                                    if($employee_address){
                                                                        $address = htmlentities($row_employee['address'] ?? '');
                                                                        $addresses = $address;
                                                                        $user_addres  = htmlentities($row_employee['address'] ?? '');
                                                                        // Split the address into parts based on the comma delimiter
                                                                        $values = explode('|', $user_addres);
                                                                        
                                                                        // Assign variables based on the extracted parts
                                                                        $apartment = $values[0];
                                                                        $street = $values[1];
                                                                        $barangay = $values[2];
                                                                        $city = $values[3];
                                                                        $province = $values[4];
                                                                        $region = $values[5];
                                                                        $postal_code = $values[6];
                                                                    }
                                                                ?>
                                                                <!--<input class="form-control" type="text" name="address" id="address" placeholder="" value="<?= $address ?>" required style="display:none"/>-->
                                                                <div class="row">
                                                                    <div class='col-md-4'>
                                                                        <label  class="control-label">House/Apartment Number<span>(Optional)</span></label>
                                                                        <input class="form-control" type="text" name="apartment_number"  value="<?= $apartment?>" />
                                                                    </div>
                                                                    <div class='col-md-4'>
                                                                        <label  class="control-label">Street</label>
                                                                        <input class="form-control" type="text" name="street" value="<?= $street ?>" required />
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label  class="control-label">Barangay</label>
                                                                        <input type="text" class="form-control" name="barangay" value="<?= $barangay ?>" required>
                                                                        <!--<select  class="form-control" id="barangay"></select>-->
                                                                    </div>
                                                                </div>
                                                                <div class="row"  style="margin-top:10px">
                                                                    <div class="col-md-3">
                                                                        <label  class="control-label">City</label>
                                                                        <input type="text" class="form-control" name="city" value="<?= $city ?>" required>
                                                                        <!--<select  class="form-control" id="city"></select>-->
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label  class="control-label">Province</label>
                                                                        <input type="text" class="form-control" name="province" value="<?= $province ?>" required>
                                                                        <!--<select  class="form-control" id="province"></select>-->
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label  class="control-label">Region<span>(Optional)</span></label>
                                                                        <input type="text" class="form-control" name="region" value="<?= $region ?>">
                                                                        <!--<select name="selected_region"  class="form-control" id="region"><option value="15">AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)</option><option value="14">CORDILLERA ADMINISTRATIVE REGION (CAR)</option><option value="13">NATIONAL CAPITAL REGION (NCR)</option><option value="01">REGION I (ILOCOS REGION)</option><option value="02">REGION II (CAGAYAN VALLEY)</option><option value="03">REGION III (CENTRAL LUZON)</option><option value="04">REGION IV-A (CALABARZON)</option><option value="17">REGION IV-B (MIMAROPA)</option><option value="09">REGION IX (ZAMBOANGA PENINSULA)</option><option value="05">REGION V (BICOL REGION)</option><option value="06">REGION VI (WESTERN VISAYAS)</option><option value="07">REGION VII (CENTRAL VISAYAS)</option><option value="08">REGION VIII (EASTERN VISAYAS)</option><option value="10">REGION X (NORTHERN MINDANAO)</option><option value="11">REGION XI (DAVAO REGION)</option><option value="12">REGION XII (SOCCSKSARGEN)</option><option value="16">REGION XIII (Caraga)</option></select>-->
                                                                    </div>
                                                                    <div class='col-md-3'>
                                                                        <label  class="control-label">Postal Code</label>
                                                                        <input class="form-control" type="text" name="postal_code"  value="<?= $postal_code ?>" required />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Contact Number</label>
                                                                <input class="form-control" type="text" name="contact_no" id="contact_no"  value="<?= $contact_no ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <hr>
                                                            </div>
                                                            <div class="form-group">
                                                                <span class="caption-subject font-blue-madison bold uppercase">Emergency Contact</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Name</label>
                                                                <input class="form-control" type="text" name="emergency_name" id="emergency_name" placeholder="" value="<?= $emergency_name ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address</label>
                                                                <input class="form-control" type="text" name="emergency_address" id="emergency_address" placeholder="" value="<?= $emergency_address ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Contact Number</label>
                                                                <input class="form-control" type="text" name="emergency_contact_no" id="emergency_contact_no" placeholder="" value="<?= $emergency_contact_no ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Email Address</label>
                                                                <input class="form-control" type="text" name="emergency_email" id="emergency_email" placeholder="" value="<?= $emergency_email ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Relationship</label>
                                                                <select name="relationship" class="form-control">
                                                                    <option value="" <?php if ($emergency_relation === '') echo 'selected'; ?>>Please Select</option>
                                                                    <option value="Adoptive Parent" <?php if ($emergency_relation === 'Adoptive Parent') echo 'selected'; ?>>Adoptive Parent</option>
                                                                    <option value="Babysitter" <?php if ($emergency_relation === 'Babysitter') echo 'selected'; ?>>Babysitter</option>
                                                                    <option value="Brother" <?php if ($emergency_relation === 'Brother') echo 'selected'; ?>>Brother</option>
                                                                    <option value="Care Giver" <?php if ($emergency_relation === 'Care Giver') echo 'selected'; ?>>Care Giver</option>
                                                                    <option value="Case Worker" <?php if ($emergency_relation === 'Case Worker') echo 'selected'; ?>>Case Worker</option>
                                                                    <option value="Daughter" <?php if ($emergency_relation === 'Daughter') echo 'selected'; ?>>Daughter</option>
                                                                    <option value="Father" <?php if ($emergency_relation === 'Father') echo 'selected'; ?>>Father</option>
                                                                    <option value="Financial Guarantor" <?php if ($emergency_relation === 'Financial Guarantor') echo 'selected'; ?>>Financial Guarantor</option>
                                                                    <option value="Foster Parent" <?php if ($emergency_relation === 'Foster Parent') echo 'selected'; ?>>Foster Parent</option>
                                                                    <option value="Friend" <?php if ($emergency_relation === 'Friend') echo 'selected'; ?>>Friend</option>
                                                                    <option value="Godfather" <?php if ($emergency_relation === 'Godfather') echo 'selected'; ?>>Godfather</option>
                                                                    <option value="Godmother" <?php if ($emergency_relation === 'Godmother') echo 'selected'; ?>>Godmother</option>
                                                                    <option value="Grandchild" <?php if ($emergency_relation === 'Grandchild') echo 'selected'; ?>>Grandchild</option>
                                                                    <option value="Grandparent" <?php if ($emergency_relation === 'Grandparent') echo 'selected'; ?>>Grandparent</option>
                                                                    <option value="Legal Guardian" <?php if ($emergency_relation === 'Legal Guardian') echo 'selected'; ?>>Legal Guardian</option>
                                                                    <option value="Mother" <?php if ($emergency_relation === 'Mother') echo 'selected'; ?>>Mother</option>
                                                                    <option value="Neighbor" <?php if ($emergency_relation === 'Neighbor') echo 'selected'; ?>>Neighbor</option>
                                                                    <option value="Other" <?php if ($emergency_relation === 'Other') echo 'selected'; ?>>Other</option>
                                                                    <option value="Partner" <?php if ($emergency_relation === 'Partner') echo 'selected'; ?>>Partner</option>
                                                                    <option value="Registered Domestic Partner" <?php if ($emergency_relation === 'Registered Domestic Partner') echo 'selected'; ?>>Registered Domestic Partner</option>
                                                                    <option value="Relative" <?php if ($emergency_relation === 'Relative') echo 'selected'; ?>>Relative</option>
                                                                    <option value="Roommate" <?php if ($emergency_relation === 'Roommate') echo 'selected'; ?>>Roommate</option>
                                                                    <option value="Significant Other" <?php if ($emergency_relation === 'Significant Other') echo 'selected'; ?>>Significant Other</option>
                                                                    <option value="Sister" <?php if ($emergency_relation === 'Sister') echo 'selected'; ?>>Sister</option>
                                                                    <option value="Social Worker" <?php if ($emergency_relation === 'Social Worker') echo 'selected'; ?>>Social Worker</option>
                                                                    <option value="Son" <?php if ($emergency_relation === 'Son') echo 'selected'; ?>>Son</option>
                                                                    <option value="Sponsor" <?php if ($emergency_relation === 'Sponsor') echo 'selected'; ?>>Sponsor</option>
                                                                    <option value="Spouse" <?php if ($emergency_relation === 'Spouse') echo 'selected'; ?>>Spouse</option>
                                                                    <option value="Step Parent" <?php if ($emergency_relation === 'Step Parent') echo 'selected'; ?>>Step Parent</option>
                                                                    <option value="Surrogate" <?php if ($emergency_relation === 'Surrogate') echo 'selected'; ?>>Surrogate</option>
                                                                </select>
                                                                <!--<input class="form-control" type="text" name="emergency_relation" id="emergency_relation" placeholder="" value="<?= $emergency_relation ?>" />-->
                                                            </div>
                                                            <div class="form-group">
                                                                <hr>
                                                            </div>
                                                            <div class="form-group">
                                                                <span class="caption-subject font-blue-madison bold uppercase">Bank Details</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Name</label>
                                                                <select name="bankno" class="form-control" required>
                                                                    <option value="">--Please select--</option>
                                                                    <?php 
                                                                        $employee_details = mysqli_query($payroll_connection,"SELECT accountname, accountno, bankno FROM payee WHERE payeeid = '$current_userEmployeeID' " );
                                                                        $employee_details_row = mysqli_fetch_array($employee_details);
                                                                        $accountname = '';
                                                                        $accountno = '';
                                                                        if($employee_details_row){
                                                                            $accountname = $employee_details_row['accountname'];
                                                                            $accountno = $employee_details_row['accountno'];
                                                                        }
                                                                        
                                                                        $bankno = '';
                                                                        if (!empty($employee_details_row['bankno'])) {
                                                                            $bankno = $employee_details_row['bankno'];
                                                                        }
                                                                        
                                                                        $bank_name = mysqli_query($payroll_connection,"SELECT bankno, bankname FROM bankname " );
                                                                        foreach($bank_name as $rows) {
                                                                            $bank_id =  $rows['bankno'];
                                                                            
                                                                            echo '<option value="'.$rows['bankno'].'" '; echo ($bank_id === $bankno) ? 'selected' : ''; echo '>'.htmlentities($rows['bankname'] ?? '').'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Account</label>
                                                                <input type="text" name="accountname" value="<?= $accountname ?>" class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Account Number</label>
                                                                <input type="text" name="accountno" value="<?= $accountno ?>" class="form-control" required>
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="save_others" id="save_others" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--END OTHER DETAILS TAB-->
                                                    
                                                    <div class="tab-pane" id="tabFiles">
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 80px;" class="text-center">File</th>
                                                                        <th>File Name</th>
                                                                        <th>Description</th>
                                                                        <th>Document Date</th>
                                                                        <th>Uploaded Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                        $selectFile = mysqli_query( $conn,"SELECT * FROM tbl_hr_file WHERE deleted = 0 AND user_id = $switch_user_id AND employee_id = $current_userEmployeeID ORDER BY filename" );
                                                                        if ( mysqli_num_rows($selectFile) > 0 ) {
                                                                            while($rowFile = mysqli_fetch_array($selectFile)) {
                                                                                $file_ID = htmlentities($rowFile["ID"] ?? '');
                                                                                $file_name = htmlentities($rowFile["filename"] ?? '');
                                                                                $file_description = htmlentities($rowFile["description"] ?? '');
                                                                                $file_status = htmlentities($rowFile["status"] ?? '');
                                                                                $file_reviewed_by = htmlentities($rowFile["reviewed_by"] ?? '');

                                                                                $filetype = htmlentities($rowFile['filetype'] ?? '');
                                                                                $files = htmlentities($rowFile["files"] ?? '');
                                                                                $type = 'iframe';
                                                                                if ($filetype == 1) {
                                                                                    $fileExtension = fileExtension($files);
                                                                                    $src = $fileExtension['src'];
                                                                                    $embed = $fileExtension['embed'];
                                                                                    $type = $fileExtension['type'];
                                                                                    $file_extension = $fileExtension['file_extension'];
                                                                                    $url = $base_url.'uploads/hr/';

                                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                                } else if ($filetype == 3) {
                                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                                }

                                                                                $file_start_date = htmlentities($rowFile["start_date"] ?? '');
                                                                                $file_uploaded_date = htmlentities($rowFile["uploaded_date"] ?? '');
                                                                                $file_due_date = htmlentities($rowFile["due_date"] ?? '');
                                                                                $file_due_date = new DateTime($file_due_date);
                                                                                $file_due_date = $file_due_date->format('M d, Y');
                                                                                if (empty($rowFile["start_date"])) {
                                                                                    $file_start_date = new DateTime($file_due_date);
                                                                                    $file_start_date = $file_start_date->format('Y-m-d');
                                                                                    $file_start_date = strtotime($file_start_date.' -1 year');
                                                                                    $file_start_date = date('Y-m-d', $file_start_date);
                                                                                    $file_start_date = strtotime($file_start_date.' -1 day');
                                                                                    $file_uploaded_date = date('Y-m-d', $file_start_date);
                                                                                    $file_start_date = date('M d, Y', $file_start_date);
                                                                                } else {
                                                                                    $file_start_date = new DateTime($file_start_date);
                                                                                    $file_start_date = $file_start_date->format('M d, Y');
                                                                                }
                                                                                $file_uploaded_date = new DateTime($file_uploaded_date);
                                                                                $file_uploaded_date = $file_uploaded_date->format('M d, Y');

                                                                                echo '<tr id="tr_'.$file_ID.'">
                                                                                    <td><p style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a></p></td>
                                                                                    <td >'. $file_name .'</td>
                                                                                    <td >'. $file_description .'</td>
                                                                                    <td >'. $file_start_date .' - '. $file_due_date .'</td>
                                                                                    <td >'. $file_uploaded_date .'</td>
                                                                                </tr>';
                                                                            }
                                                                        }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript">
            // Data Save
            $(document).ready(function(){
                BtnSaveInfo.init()
                BtnSaveSocial.init()
                BtnSavePassword.init()
                BtnSavePrivacy.init()
                $(".formUsers").validate();
                $('.formPassword').validate({ // initialize the plugin
                    rules : {
                        password_new : {
                            minlength : 5
                        },
                        password_confirm : {
                            minlength : 5,
                            equalTo : "#password_new"
                        }
                    }
                });

                $('.viewPW').click(function(){
                    var x = $(this).next().attr('type');
                    if (x === "password") {
                        $(this).next().prop("type", "text");
                        $(this).addClass('fa-eye-slash');
                    } else {
                        $(this).next().prop("type", "password");
                        $(this).removeClass('fa-eye-slash');
                    }
                });
            });

            var BtnSaveInfo=function(){
                return{
                    init:function(){
                        $("#btnSave_userInfo").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formInfo').serialize()+'&btnSave_userInfo=btnSave_userInfo';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {
                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";
                                        $(".formInfo #first_name").val(response.first_name);
                                        $(".formInfo #last_name").val(response.last_name);
                                        $(".formInfo #mobile").val(response.mobile);
                                        $(".formInfo #interest").val(response.interest);
                                        $("#profileInterest").html(response.interest);
                                        $(".formInfo #occupation").val(response.occupation);
                                        $(".formInfo #about").val(response.about);
                                        $("#profileAbout").html(response.about);
                                        $(".formInfo #website").val(response.website);

                                        if (response.website != "") {
                                            $("#profileWebsite").parent().removeClass('display-hide');
                                        } else {
                                            $("#profileWebsite").parent().addClass('display-hide');
                                        }
                                        $("#profileWebsite").html(response.website);
                                        $("#profileWebsite").attr("href", response.website)
                                    } else {
                                        msg = "Error!"
                                    }

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
                            });
                        })
                    }
                }
            }();

            var BtnSaveSocial=function(){
                return{
                    init:function(){
                        $("#btnSave_userSocial").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formSocial').serialize()+'&btnSave_userSocial=btnSave_userSocial';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {
                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";

                                        if (response.linkedin != "") {
                                            $("#profileLinkedIn").parent().removeClass('display-hide');
                                        } else {
                                            $("#profileLinkedIn").parent().addClass('display-hide');
                                        }
                                        $(".formInfo #linkedin").val(response.linkedin);
                                        $("#profileLinkedIn").html(response.linkedin);
                                        $("#profileLinkedIn").attr("href", response.linkedin);

                                        if (response.facebook != "") {
                                            $("#profileFacebook").parent().removeClass('display-hide');
                                        } else {
                                            $("#profileFacebook").parent().addClass('display-hide');
                                        }
                                        $(".formInfo #fb").val(response.facebook);
                                        $("#profileFacebook").html(response.facebook);
                                        $("#profileFacebook").attr("href", response.facebook)
                                    } else {
                                        msg = "Error!"
                                    }

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
                            });
                        })
                    }
                }
            }();

            $(".formAvatar").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_userAvatar',true);

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $(".profile-avatar img").attr("src", "uploads/avatar/" + obj.avatar);
                            $(".profile-userpic img").attr("src", "uploads/avatar/" + obj.avatar);
                        } else {
                            msg = "Error!"
                        }

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
                });
            }));

            var BtnSavePassword=function(){
                return{
                    init:function(){
                        $("#btnSave_userPassword").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formPassword').serialize()+'&btnSave_userPassword=btnSave_userPassword';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {
                                    $.bootstrapGrowl(response.message,{
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
                            });
                        })
                    }
                }
            }();

            var BtnSavePrivacy=function(){
                return{
                    init:function(){
                        $("#btnSave_userPrivacy").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formPrivacy').serialize()+'&btnSave_userPrivacy=btnSave_userPrivacy';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {
                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";
                                    } else {
                                        msg = "Error!"
                                    }

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
                            });
                        })
                    }
                }
            }();
        </script>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
        <script type="text/javascript" src="proxy.js"></script>
        <script type="text/javascript">
            // Modify the callback function to use the plugin's function
            function handleJSONPResponse(data) {
                $('#your_element_id').ph_locations('build_options', data);
            }
            
            var my_handlers = {
                fill_provinces: function(){
                    var region_code = $(this).val();
                    $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                },
            
                fill_cities: function(){
                    var province_code = $(this).val();
                    $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                },
            
                fill_barangays: function(){
                    var city_code = $(this).val();
                    $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
                }
            };

            var my_handlers = {

                fill_provinces:  function(){

                    var region_code = $(this).val();
                    $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                    
                },

                fill_cities: function(){

                    var province_code = $(this).val();
                    $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                },


                fill_barangays: function(){

                    var city_code = $(this).val();
                    $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
                }
            };

            $(function(){
                $('#region').on('change', my_handlers.fill_provinces);
                $('#province').on('change', my_handlers.fill_cities);
                $('#city').on('change', my_handlers.fill_barangays);

                $('#region').ph_locations({'location_type': 'regions'});
                $('#province').ph_locations({'location_type': 'provinces'});
                $('#city').ph_locations({'location_type': 'cities'});
                $('#barangay').ph_locations({'location_type': 'barangays'});

                $('#region').ph_locations('fetch_list');
            });

        </script>
        
         <script>
        //     const regionSelect = document.getElementById('region');
        //     const provinceSelect = document.getElementById('province');
        //     const citySelect = document.getElementById('city');
        //     const barangaySelect = document.getElementById('barangay');
            
        //     const apiUrl = 'https://psgc-api.wareneutron.com/api'; // Replace with your actual PSGC API URL
            
        //     regionSelect.addEventListener('change', async () => {
        //       const selectedRegion = regionSelect.value;
            
        //       // Fetch province data based on the selected region
        //       const response = await fetch(`${apiUrl}/provinces?region=${selectedRegion}`);
        //       const provinces = await response.json();
            
        //       // Update the province dropdown
        //       updateDropdown(provinceSelect, provinces);
        //     });
            
        //     provinceSelect.addEventListener('change', async () => {
        //       const selectedProvince = provinceSelect.value;
            
        //       // Fetch city data based on the selected province
        //       const response = await fetch(`${apiUrl}/cities?province=${selectedProvince}`);
        //       const cities = await response.json();
            
        //       // Update the city dropdown
        //       updateDropdown(citySelect, cities);
        //     });
            
        //     citySelect.addEventListener('change', async () => {
        //       const selectedCity = citySelect.value;
            
        //       // Fetch barangay data based on the selected city
        //       const response = await fetch(`${apiUrl}/barangays?city=${selectedCity}`);
        //       const barangays = await response.json();
            
        //       // Update the barangay dropdown
        //       updateDropdown(barangaySelect, barangays);
        //     });
            
        //     function updateDropdown(dropdown, data) {
        //       dropdown.innerHTML = '<option value="">Select...</option>';
            
        //       // Check if data is an array
        //       if (Array.isArray(data)) {
        //         data.forEach(item => {
        //           const option = document.createElement('option');
        //           option.value = item.code;
        //           option.textContent = item.name;
        //           dropdown.appendChild(option);
        //         });
        //       } else {
        //         console.error('Data is not an array:', data);
        //       }
        //     }


            
        //   function fetchData() {
        //       const apiUrl = 'proxy.php?endpoint=region/14';
            
        //       fetch(apiUrl)
        //         .then(response => {
        //           if (!response.ok) {
        //             throw new Error('Network response was not ok');
        //           }
        //           return response.json();
        //         })
        //         .then(data => console.log('Data:', data))
        //         .catch(error => console.error('Error fetching data:', error));
        //     }
  </script>
    </body>
</html>