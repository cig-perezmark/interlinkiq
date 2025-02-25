<?php 
    $title = "Specialist / Job Seeker";
    $site = "profile-job";
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
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">

                                                <?php
                                                    $cv_src = '';
                                                    $cv_tmp = '';
                                                    $count_educ = 0;
                                                    $count_ref = 0;
                                                    $count_skill = 0;
                                                    $availability = array();
                                                    $preference = array();
                                                    $skill_set = "";
 
                                                    $selectJob = mysqli_query( $conn,"SELECT * FROM tbl_user_job WHERE is_active = 1 AND user_id = $current_userID" );
                                                    if ( mysqli_num_rows($selectJob) > 0 ) {
                                                        $rowJob = mysqli_fetch_array($selectJob);
                                                        $user_id = $rowJob['user_id'];

                                                        $type = '';
                                                        $cv_tmp = htmlentities($rowJob['cv'] ?? '');
                                                        if (!empty($cv_tmp)) {
                                                            $fileExtension = fileExtension($cv_tmp);
                                                            $src = $fileExtension['src'];
                                                            $embed = $fileExtension['embed'];
                                                            $type = $fileExtension['type'];
                                                            $file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'uploads/job/';
                                                            $cv_src = $src.$url.rawurlencode($cv_tmp).$embed;
                                                        }

                                                        $education = htmlentities($rowJob['education'] ?? '');
                                                        if (!empty($education)) {
                                                            $output_educ = json_decode($education,true);
                                                            $count_educ = count($output_educ);
                                                        }

                                                        $reference = htmlentities($rowJob['reference'] ?? '');
                                                        if (!empty($reference)) {
                                                            $output_ref = json_decode($reference,true);
                                                            $count_ref = count($output_ref);
                                                        }

                                                        $skill = htmlentities($rowJob['skill'] ?? '');
                                                        if (!empty($skill)) {
                                                            $output_skill = json_decode($skill,true);
                                                            $count_skill = count($output_skill);
                                                        }

                                                        $availability = explode(", ", $rowJob["availability"]);
                                                        $preference = explode(", ", $rowJob["preference"]);
                                                        $skill_set = htmlentities($rowJob["skill_set"] ?? '');
                                                    }
                                                ?>

                                                <form method="post" enctype="multipart/form-data" class="formUsers">
                                                    <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                    <h5><strong>Personal Details</strong></h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">First Name</label>
                                                                <input class="form-control" type="text" name="first_name" value="<?php echo $current_userFName; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Last Name</label>
                                                                <input class="form-control" type="text" name="last_name" value="<?php echo $current_userLName; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Mobile Number</label>
                                                                <input class="form-control" type="text" name="mobile" value="<?php echo $current_userMobile; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address</label>
                                                                <input class="form-control" type="text" name="address" value="<?php echo $current_userAddress; ?>" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Profile Picture</label>
                                                                <?php
                                                                    $type = '';
                                                                    $profile_src = '';
                                                                    if (!empty($current_userAvatar)) {
                                                                        $fileExtension = fileExtension($current_userAvatar);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/avatar/';
                                                                        $profile_src = $src.$url.rawurlencode($current_userAvatar).$embed;
                                                                    }

                                                                    echo '<input type="hidden" name="profile_tmp" value="'.$current_userAvatar.'" />
                                                                    <input class="form-control '; echo !empty($current_userAvatar) ? 'hide':''; echo '" type="file" name="profile" />
                                                                    <p class="'; echo !empty($profile_src) ? '':'hide'; echo '" style="margin: 0;"><a data-src="'.$profile_src.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>';
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Personal Website</label>
                                                                <input class="form-control" type="text" name="website" placeholder="Leave blank if not applicable" value="<?php echo $current_userWebsite; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">LinkedIn Page</label>
                                                                <input class="form-control" type="text" name="linkedin" placeholder="Leave blank if not applicable" value="<?php echo $current_userLinkedIn; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Facebook</label>
                                                                <input class="form-control" type="text" name="facebook" placeholder="Leave blank if not applicable" value="<?php echo $current_userFacebook; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Twitter</label>
                                                                <input class="form-control" type="text" name="twitter" placeholder="Leave blank if not applicable" value="<?php echo $current_userTwitter; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Attach CV</label>
                                                                <?php
                                                                    echo '<input type="hidden" name="cv_tmp" value="'.$cv_tmp.'" />
                                                                    <input class="form-control '; echo !empty($cv_src) ? 'hide':''; echo '" type="file" name="cv" />
                                                                    <p class="'; echo !empty($cv_src) ? '':'hide'; echo '" style="margin: 0;"><a data-src="'.$cv_src.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>';
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="margin-top-40"><strong>Training / Certificate / Education</strong></h5>
                                                    <div class="mt-repeater mt-repeater-educ">
                                                        <div data-repeater-list="education">
                                                            <?php
                                                                if ($count_educ > 0) {
                                                                    foreach ($output_educ as $key => $value) {
                                                                        $file = '';
                                                                        $file_src = '';
                                                                        $type = '';
                                                                        if (!empty($value['educ_diploma'])) {
                                                                            $file = $value['educ_diploma'];
                                                                            $fileExtension = fileExtension($file);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/job/';
                                                                            $file_src = $src.$url.rawurlencode($file).$embed;
                                                                        }

                                                                        echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Provider</label>
                                                                                    <input class="form-control" type="text" name="educ_school" value="'.htmlentities($value['educ_school']).'" required />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Training Title</label>
                                                                                    <input class="form-control" type="text" name="educ_degree" value="'.htmlentities($value['educ_degree']).'" required />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Certificate</label>
                                                                                    <input type="hidden" name="educ_diploma_tmp" value="'. $value['educ_diploma'] .'" />
                                                                                    <input class="form-control fileDiploma '; echo !empty($file) ? 'hide':''; echo '" type="file" name="" />
                                                                                    <p class="'; echo !empty($file) ? '':'hide'; echo '" style="margin: 0;"><a data-src="'.$file_src.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Remove</label>
                                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>';
                                                                    }
                                                                } else {
                                                                    echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Provider</label>
                                                                                <input class="form-control" type="text" name="educ_school" required />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Training Title</label>
                                                                                <input class="form-control" type="text" name="educ_degree" required />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Certificate</label>
                                                                                <input type="hidden" name="educ_diploma_tmp" value="" />
                                                                                <input class="form-control fileDiploma" type="file" name="educ_diploma" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Remove</label>
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add btnEducation"><i class="fa fa-plus"></i> Add more</a>
                                                    </div>

                                                    <h5 class="margin-top-40"><strong>References</strong></h5>
                                                    <div class="mt-repeater mt-repeater-ref">
                                                        <div data-repeater-list="reference">
                                                            <?php
                                                                if ($count_ref > 0) {
                                                                    foreach ($output_ref as $key => $value) {
                                                                        echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Full Name</label>
                                                                                    <input class="form-control" type="text" name="ref_name" value="'.htmlentities($value['ref_name'] ?? '').'" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Email</label>
                                                                                    <input class="form-control" type="email" name="ref_email" value="'.htmlentities($value['ref_email'] ?? '').'" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Phone Number</label>
                                                                                    <input class="form-control" type="text" name="ref_phone" value="'.htmlentities($value['ref_phone'] ?? '').'" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Remove</label>
                                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>';
                                                                    }
                                                                } else {
                                                                    echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Full Name</label>
                                                                                <input class="form-control" type="text" name="ref_name" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input class="form-control" type="email" name="ref_email" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Phone Number</label>
                                                                                <input class="form-control" type="text" name="ref_phone" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Remove</label>
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add btnEmergency"><i class="fa fa-plus"></i> Add more</a>
                                                    </div>

                                                    <h5 class="margin-top-40"><strong>Skill Set / Specialty</strong></h5>
                                                    <div class="mt-repeater mt-repeater-skill">
                                                        <div data-repeater-list="skill">
                                                            <?php
                                                                if ($count_skill > 0) {
                                                                    foreach ($output_skill as $key => $value) {
                                                                        echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                            <div class="col-lg-11">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Description</label>
                                                                                    <input class="form-control" type="text" name="skill_name" value="'.htmlentities($value['skill_name'] ?? '').'" required />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Remove</label>
                                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>';
                                                                    }
                                                                } else {
                                                                    echo '<div class="mt-repeater-item row" data-repeater-item>
                                                                        <div class="col-lg-11">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Description</label>
                                                                                <input class="form-control" type="text" name="skill_name" required />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Remove</label>
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add btnSkill"><i class="fa fa-plus"></i> Add more</a>
                                                    </div>

                                                    <style type="text/css">
                                                        .bootstrap-tagsinput { min-height: 100px; }
                                                    </style>
                                                    <div class="row margin-top-40">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Availability</label>
                                                                <div class="mt-checkbox-list">
                                                                    <?php
                                                                        echo '<label class="mt-checkbox mt-checkbox-outline"> Full Time
                                                                            <input type="checkbox" value="1" name="availability[]" '; echo in_array(1, $availability) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Part Time
                                                                            <input type="checkbox" value="2" name="availability[]" '; echo in_array(2, $availability) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Freelancer
                                                                            <input type="checkbox" value="3" name="availability[]" '; echo in_array(3, $availability) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Contract
                                                                            <input type="checkbox" value="4" name="availability[]" '; echo in_array(4, $availability) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Remote
                                                                            <input type="checkbox" value="5" name="availability[]" '; echo in_array(5, $availability) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>';
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Preference</label>
                                                                <div class="mt-checkbox-list">
                                                                    <?php
                                                                        echo '<label class="mt-checkbox mt-checkbox-outline"> On-Site
                                                                            <input type="checkbox" value="1" name="preference[]" '; echo in_array(1, $preference) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Virtual
                                                                            <input type="checkbox" value="2" name="preference[]" '; echo in_array(2, $preference) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Willing to Travel
                                                                            <input type="checkbox" value="3" name="preference[]" '; echo in_array(3, $preference) ? 'checked' : ''; echo '/>
                                                                            <span></span>
                                                                        </label>';
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Skill Set</label>
                                                                <input type="text" class="form-control tagsinput" name="skill_set" data-role="tagsinput" placeholder="Enter skill" value="<?php echo $skill_set; ?>" required />
                                                                <span class="form-text text-muted">Enter multiple skills separated by comma</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="margin-top-40">
                                                        <button type="submit" class="btn green ladda-button" name="btnSave_userJob" id="btnSave_userJob" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".formUsers").validate();

                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});

                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});

                fancyBoxes();
            });

            $(".formUsers").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_userJob',true);

                var l = Ladda.create(document.querySelector('#btnSave_userJob'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);

                            if (obj.website != "") { $("#profileWebsite").parent().removeClass('display-hide'); }
                            else { $("#profileWebsite").parent().addClass('display-hide'); }
                            $("#profileWebsite").html(obj.website);
                            $("#profileWebsite").attr("href", obj.website)
                            
                            if (obj.linkedin != "") { $("#profileLinkedIn").parent().removeClass('display-hide'); }
                            else { $("#profileLinkedIn").parent().addClass('display-hide'); }
                            $("#profileLinkedIn").html("LinkedIn.com");
                            $("#profileLinkedIn").attr("href", obj.linkedin)
                            
                            if (obj.facebook != "") { $("#profileFacebook").parent().removeClass('display-hide'); }
                            else { $("#profileFacebook").parent().addClass('display-hide'); }
                            $("#profileFacebook").html("Facebook.com");
                            $("#profileFacebook").attr("href", obj.facebook)

                            $(".profile-usertitle-name").html(obj.first_name+' '+obj.last_name);
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
    </body>
</html>
