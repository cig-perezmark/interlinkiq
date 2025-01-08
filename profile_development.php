<?php 
    $title = "Account Setting";
    $site = "profile-setting";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

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
                                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tabPersonal" data-toggle="tab">Personal Info</a>
                                                    </li>
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
                                                        <a href="#tabOthers" data-toggle="tab">Other Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <!-- PERSONAL INFO TAB -->
                                                    
                                                    <div class="tab-pane active" id="tabPersonal">
                                                        <form method="post" class="formUsers formInfo">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userEmployeeID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">First Name</label>
                                                                <input class="form-control" type="text" name="first_name" id="first_name" placeholder="" value="<?php echo $current_userFName; ?>" required />
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
                                                    <?php
                                                        $employee_details = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = '$current_userEmployeeID'" );
                                                        $row_employee= mysqli_fetch_array($employee_details);
                                                        $personal_email = '';
                                                        $company_email = '';
                                                        $address = '';
                                                        $contact_no = '';
                                                        $emergency_name = '';
                                                        $emergency_address = '';
                                                        $emergency_contact_no = '';
                                                        $emergency_email = '';
                                                        $emergency_relation = '';
                                                        if($row_employee){
                                                            $personal_email = $row_employee['personal_email'];
                                                            $company_email = $row_employee['company_email'];
                                                            $address = $row_employee['address'];
                                                            $contact_no = $row_employee['contact_no'];
                                                            $emergency_name  = $row_employee['emergency_name'];
                                                            $emergency_address = $row_employee['emergency_address'];
                                                            $emergency_contact_no = $row_employee['emergency_contact_no'];
                                                            $emergency_email = $row_employee['emergency_email'];
                                                            $emergency_relation = $row_employee['emergency_relation'];
                                                        }
                                                    ?>
                                                    <!--START OTHER DETAILS TAB-->
                                                    <div class="tab-pane" id="tabOthers">
                                                        <form method="post" action="controller.php">
                                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                            <input class="form-control" type="hidden" name="employee_id" value="<?php echo $current_userEmployeeID; ?>" />
                                                            <div class="form-group">
                                                                <label class="control-label">Personal Email</label>
                                                                <input class="form-control" type="text" name="personal_email" id="personal_email" placeholder="" value="<?= $personal_email ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Company Email</label>
                                                                <input class="form-control" type="text" name="company_email" id="company_email" placeholder="" value="<?= $company_email ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address<span style="font-weight:600"> (House No., Street, Brgy, City, Zip)</span></label>
                                                                <input class="form-control" type="text" name="address" id="address" placeholder=""value="<?= $address ?>" required />
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
                                                                <input class="form-control" type="text" name="emergency_relation" id="emergency_relation" placeholder="" value="<?= $emergency_relation ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <hr>
                                                            </div>
                                                            <div class="form-group">
                                                                <span class="caption-subject font-blue-madison bold uppercase">Bank Details</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Name</label>
                                                                <select name="bankno" class="form-control">
                                                                    <?php 
                                                                        $employee_details = mysqli_query($payroll_connection,"SELECT * FROM payee WHERE payeeid = '$current_userEmployeeID' " );
                                                                        $employee_details_row = mysqli_fetch_array($employee_details);
                                                                        $accountname = '';
                                                                        $accountno = '';
                                                                        if($employee_details_row){
                                                                            $accountname = $employee_details_row['accountname'];
                                                                            $accountno = $employee_details_row['accountno'];
                                                                        }
                                                                        $bankno = $employee_details_row['bankno'];
                                                                        $bank_name = mysqli_query($payroll_connection,"SELECT * FROM bankname " );
                                                                        foreach($bank_name as $rows):
                                                                        $bank_id =  $rows['bankno'];
                                                                        $bankno = $employee_details_row['bankno'];
                                                                        $selected = '';
                                                                        if($bank_id == $bankno){
                                                                            $selected = 'selected';
                                                                        }
                                                                    ?>
                                                                    <option value="<?= $rows['bankno'] ?>" <?php echo ($bank_id === $bankno) ? 'selected' : ''; ?>><?= $rows['bankname'] ?></option>
                                                                    <?php
                                                                        endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Account</label>
                                                                <input type="text" name="accountname" value="<?= $accountname ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Account Number</label>
                                                                <input type="text" name="accountno" value="<?= $accountno ?>" class="form-control">
                                                            </div>
                                                            <div class="margiv-top-10">
                                                                <input type="submit" class="btn green" name="save_others" id="save_others" value="Save Changes" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--END OTHER DETAILS TAB-->
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
    </body>
</html>