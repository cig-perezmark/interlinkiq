<?php 
    $title = "E-Forms";
    $site = "form-owned";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    error_reporting(0);
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Interlink E-Forms</span>
                        <?php
                            if($current_client == 0) {
                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $type_id = $row["type"];
                                    $file_title = $row["file_title"];
                                    $video_url = $row["youtube_link"];
                                    
                                    $file_upload = $row["file_upload"];
                                    if (!empty($file_upload)) {
                        	            $fileExtension = fileExtension($file_upload);
                        				$src = $fileExtension['src'];
                        				$embed = $fileExtension['embed'];
                        				$type = $fileExtension['type'];
                        				$file_extension = $fileExtension['file_extension'];
                        	            $url = $base_url.'uploads/instruction/';
                        
                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                    }
                                    
                                    if ($type_id == 0) {
                                		echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><i class="fa '. $file_extension .'"></i> '.$file_title.'</a>';
                                	} else {
                                		echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><i class="fa fa-youtube"></i> '.$file_title.'</a>';
                                	}
                                }
                                
                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                    echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--BEGIN SEARCH BAR        -->
                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <!--Emjay starts here-->
                            <li>
                                <a href="#forms" data-toggle="tab">Forms</a>
                            </li>
                            <!--Emjay Codes ends here-->
                        </ul>               
                    </div>
             	
                    <!--END SEARCH BAR-->
                    <?php if($current_userEmployeeID == 0 OR $current_userEmployeeID == 64 OR $current_userEmployeeID == 81  OR $current_userEmployeeID == 78 OR $current_userEmployeeID == 163): ?>
						<div class="row">
							<div class="col-lg-12">
                        		<div class="portlet-title" style="margin-bottom:10px;float:right">
                                	<div class="actions">
                                    	<div class="btn-group">
        	                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
            	                                <i class="fa fa-angle-down"></i>
                	                        </a>
                    	                    <ul class="dropdown-menu pull-right">
                        	                    <li>
                                                	<a data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#exampleModal':'#modalService'; ?>"> Assign Form</a>
                                            	</li>
                                            	<?php if($switch_user_id == 163): ?>
                                            	<li>
                                                	<a data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#clone_modal':'#modalService'; ?>"> Clone Form</a>
                                            	</li>
                                            	<?php endif; ?>
                                        	</ul>
                                    	</div>
                                	</div>
                            	</div>
                            </div>
						</div>
        	        <?php endif; ?>
        	        
        	        <?php if($current_userEmployeeID == 78): ?>
						<div class="row">
							<div class="col-lg-12">
                        		<div class="portlet-title" style="margin-bottom:10px;float:right">
                                	<div class="actions">
                                    	<div class="btn-group">
        	                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
            	                                <i class="fa fa-angle-down"></i>
                	                        </a>
                    	                    <ul class="dropdown-menu pull-right">
                        	                    <li>
                                                	<a data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#exampleModal1':'#modalService'; ?>"> Assign Form</a>
                                            	</li>
                                        	</ul>
                                    	</div>
                                	</div>
                            	</div>
                            </div>
						</div>
        	        <?php endif; ?>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <td>Form Name</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($current_client != 1) {
                                            if($current_userEmployeeID == 0){
                                                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '" . $_COOKIE['ID'] . "' AND enterprise_id = '" . $_COOKIE['ID'] . "'"); 
                                            }
                                            else{
                                                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE enterprise_id = '$switch_user_id' AND user_id = '$current_userEmployeeID'"); 
                                            }
                                            $num_rows = mysqli_num_rows($check_form_owned);
                                            if($num_rows > 0 ){
                                                $check_result = mysqli_fetch_array($check_form_owned);
                                                $array_counter = explode(",", $check_result["form_owned"]); 
                                                foreach($array_counter as $value):
                                                    $query = "SELECT * FROM tbl_afia_forms_list WHERE PK_id = '$value'";
                                                    $result = mysqli_query($e_connection, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {?> 
                                                        <tr>
                                                            <td>
                                                                <?= $row['afl_form_name']; ?>
                                                            </td>
                                                        
                                                            <td>
                                                                <?php
                                                                    if($row['form_free'] != 1):
                                                                ?>
                                                                    <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                    <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>
                                                                    <?php endif; ?>
                                                                    <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                    <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>
                                                                    <?php endif; ?>
                                                                    <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163 OR $current_userEmployeeID == 78): ?>
                                                                    <a onclick="form_code(<?= $row['PK_id'] ?>)" class="btn blue btn-outline" data-toggle="modal" data-target="#e_forms_modal_video">Attach Video</a>
                                                                <?php endif; ?>
                                                                <?php
                                                                    $form_id = $row['PK_id'];
                                                                    $query_videos = "SELECT * FROM tbl_form_videos WHERE form_id = '$form_id'";
                                                                    $result_videos = mysqli_query($conn, $query_videos);
                                                                    foreach($result_videos as $video_row):
                                                                ?>
                                                                    ( <a class="view_videos" data-src="<?= $video_row['video_link'] ?>" data-fancybox> <?= $video_row['video_name'] ?></a>)
                                                                <?php endforeach; ?>
                                                                <?php
                                                                    if($current_userEmployerID == '34'){
                                                                        $check_form_owned1 = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE enterprise_id = '308' AND user_id = '308'"); 
                                                                        $check_result1 = mysqli_fetch_array($check_form_owned1);
                                                                        $array_counter1 = explode(",", $check_result1["form_owned"]);
                                                                        foreach($array_counter1 as $value1){
                                                                            if($value1 == $row['PK_id']){
                                                                                echo "Activated";
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                endforeach;
                                            }
                                        }
                                        else{
                                            $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '$switch_user_id' AND enterprise_id = '$switch_user_id'"); 
                                            $num_rows = mysqli_num_rows($check_form_owned);
                                            foreach($check_form_owned as $form_own_row){
                                                if($num_rows > 0 ){
                                                    $check_result = mysqli_fetch_array($check_form_owned);
                                                    $array_counter = explode(",",  $form_own_row['form_owned']); 
                                                    foreach($array_counter as $value):
                                                        $query = "SELECT * FROM tbl_afia_forms_list WHERE PK_id = '$value'";
                                                        $result = mysqli_query($e_connection, $query);
                                                        while($row = mysqli_fetch_array($result))
                                                        {?> 
                                                            <tr>
                                                                <td>
                                                                    <?= $row['afl_form_name']; ?>
                                                                </td>
                                                            
                                                                <td>
                                                                    <?php
                                                                        if($row['form_free'] != 1):
                                                                    ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                        <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>
                                                                        <?php endif; ?>
                                                                        <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                        <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>
                                                                        <?php endif; ?>
                                                                        <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163 OR $current_userEmployeeID == 78): ?>
                                                                        <a onclick="form_code(<?= $row['PK_id'] ?>)" class="btn blue btn-outline" data-toggle="modal" data-target="#e_forms_modal_video">Attach Video</a>
                                                                    <?php endif; ?>
                                                                    <?php
                                                                        $form_id = $row['PK_id'];
                                                                        $query_videos = "SELECT * FROM tbl_form_videos WHERE form_id = '$form_id'";
                                                                        $result_videos = mysqli_query($conn, $query_videos);
                                                                        foreach($result_videos as $video_row):
                                                                    ?>
                                                                        ( <a class="view_videos" data-src="<?= $video_row['video_link'] ?>" data-fancybox> <?= $video_row['video_name'] ?></a>)
                                                                    <?php endforeach; ?>
                                                                    <?php
                                                                        if($current_userEmployerID == '34'){
                                                                            $check_form_owned1 = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE enterprise_id = '308' AND user_id = '308'"); 
                                                                            $check_result1 = mysqli_fetch_array($check_form_owned1);
                                                                            $array_counter1 = explode(",", $check_result1["form_owned"]);
                                                                            foreach($array_counter1 as $value1){
                                                                                if($value1 == $row['PK_id']){
                                                                                    echo "Activated";
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    endforeach;
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->
	

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Select Form</label>
                            <?php
                                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '" . $switch_user_id . "'");
					            $check_result = mysqli_fetch_array($check_form_owned);
					            $array_counter = explode(",", $check_result["form_owned"]);
                            ?>
                            <select name="" class="form-control" id="form_id">
                                <?php foreach($array_counter as $value):
                                    $query = "SELECT * FROM tbl_afia_forms_list WHERE PK_id = '$value'";
                                    $result = mysqli_query($e_connection, $query);
                                ?>
                                <?php foreach($result as $row): ?>
                                    <option value="<?= $row['PK_id'] ?>"><?= $row['afl_form_name'] ?></option>
                                <?php endforeach; ?>
                                
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Select Owner</label>
                            <?php
                                $get_users = "SELECT * FROM `tbl_hr_employee` WHERE user_id = '$switch_user_id' AND status != 0 AND type_id = 1 ";
                                $user_result = mysqli_query($conn, $get_users);
                            ?>
                            <select id="form_owner"  class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple">
                                <?php foreach($user_result as $rows): ?>
                                    <?php 
                                        $get_users_form = "SELECT * FROM `tbl_user` WHERE employee_id = '" . $rows['ID'] . "' ";
                                        $user_form_result = mysqli_query($conn, $get_users_form);
                                        foreach($user_form_result as $user_list):
                                    ?>
                                    <option value="<?= $user_list['employee_id'] ?>"><?= $user_list['email'] ?></option>
                                <?php endforeach;endforeach; ?>
                            </select>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="assign" class="btn btn-primary">Assign</button>
              </div>
            </div>
          </div>
        </div>
        
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
    
    <div class="modal fade" id="e_forms_modal_video" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <input type="hidden" id="form_ownded" name="form_video" value="">

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
                        <button type="submit" class="btn btn-success" name="save_e_form_video"><span id="save_video_text">Save</span></button>
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
    <!-- Modal end -->
<form action="controller.php" method="POST">
    <div class="modal fade" id="clone_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" class="modalForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Clone Form</h4>
                    </div>
                    <div class="modal-body">
                        <label>Form Name</label>
                        <input type="text" class="form-control" name="afl_form_name">
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                        <button type="submit" class="btn btn-success" name="save_clone_form">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>
	<?php include('footer.php'); ?>
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
	});
 }); 			
 function myfunction(id){
  const d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
 }
 function form_code(id){
     $('#form_ownded').val(id);
 }
 function myfunction1(id){
  const d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
 }
 
$(document).ready(function(){
 $('#assign').click(function(){
    var eform_id = $('#form_id').find(":selected").val();
    var form_owner = $('#form_owner').val();
    var enterprise_id = <?= $switch_user_id ?>;
    $.ajax({
          url:"app-function/controller.php",
          method:"POST",
          data:{
              action:"add_form",
              eform_id:eform_id,
              enterprise_id:enterprise_id,
              form_owner:form_owner
          },
          success:function(data)
          {
            window.location.reload();
            // console.log(data); 
          }
        })
 });
// for gallery
}); 

</script>

	<style>
    .mt_element_card .mt_card_item {
        border: 1px solid;
        border-color: #e7ecf1;
        position: relative;
        margin-bottom: 30px;
    }
    .mt_element_card .mt_card_item .mt_card_avatar {
        margin-bottom: 15px;
    }
    .mt_element_card.mt_card_round .mt_card_item {
        padding: 50px 50px 10px 50px;
    }
    .mt_element_card.mt_card_round .mt_card_item .mt_card_avatar {
        border-radius: 50% !important;
        -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
    }
    .mt_element_card .mt_card_item .mt_card_content {
        text-align: center;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_desc {
        font-size: 14px;
        margin: 0 0 10px 0;
       
    }
    .mt_element_overlay .mt_overlay_1 {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }
    .mt_element_overlay .mt_overlay_1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
        opacity: 0.5;
    }
    
.card{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.card::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #283593;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.card::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3949ab;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for free cards*/
.cardFree{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
  
}

.cardFree::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #3CCF4E;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.cardFree::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 9rem;
  background: #3CCF4E;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for gallery view*/

.container-gallery {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: #003865;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: #A6D1E6;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #003865;
  padding: 2px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 14px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
 font-weight:600;
 color:#003865;
  background-color: #F1F1F1;
  border-bottom:solid #003865 4px;
}

/* Style the tab content */
.tabcontent{
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.tabcontent2{
  display: block;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
    
	</style>
    </body>
</html>