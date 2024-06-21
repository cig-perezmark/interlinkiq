<?php 
    $title = "Trainings";
    $site = "trainings";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'HR';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

<style type="text/css">
    /*REPEATER*/
    .mt-repeater > div > .mt-repeater-item-hide:first-child {
        display: none;
    }
</style>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Trainings</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-clock"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success green-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Trainings</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-reload"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success red-haze"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>No. of Trainings not yet completed by employee</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>No. of Training with no Document</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-doc"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success purple-soft"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Category Type</th>
                                                    <th>No. of Trainings</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT ID, name FROM tbl_hr_trainings_type ORDER BY name" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = htmlentities($row['ID'] ?? '');
                                                                $name = htmlentities($row['name'] ?? '');
                                                                $records = 0;

                                                                $selectTrainings = mysqli_query( $conn,'SELECT ID FROM tbl_hr_trainings WHERE deleted = 0 AND user_id="'.$switch_user_id.'" AND type="'. $ID .'"' );
                                                                if ( mysqli_num_rows($selectTrainings) > 0 ) {
                                                                    while($row = mysqli_fetch_array($selectTrainings)) {
                                                                        $records++;
                                                                    }
                                                                }

                                                                if ($records > 0) {
                                                                    echo '<tr id="tr_'. $ID .'" onclick="btnViewType('. $ID .')">
                                                                        <td>'. $name .'</td>
                                                                        <td>'. $records .'</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <button class="btn btn-success hide" id="tableDataViewAll" onclick="btnViewAll(<?php echo $switch_user_id; ?>)">View All</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="icon-graduation font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">List of Trainings</span>
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
                                                    
                                                    $icon = $row["icon"];
                                                    if (!empty($icon)) { 
                                                        if ($type_id == 0) {
                                                            echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        } else {
                                                            echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        }
                                                    }
	                                            }
                                            }
                                        ?>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" onclick="btnNew(1, 'modalNew')">Add New Training</a>
                                                </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">No.</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <!--<th>Under Job Description/s</th>-->
                                                    <th class="text-center" style="width: 120px;">Compliance %</th>
                                                    <th style="width: 80px;" class="text-center">Status</th>
                                                    <th style="width: 150px;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    // $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE deleted = 0 AND user_id = $switch_user_id" );
                                                    // if ( mysqli_num_rows($result) > 0 ) {
                                                    //     $i=0;
                                                    //     while($row = mysqli_fetch_array($result)) {
                                                            
                                                    //         echo '<tr id="tr_'. $row["ID"] .'">
                                                    //             <td>'. $row["title"] .'</td>
                                                    //             <td>'. $row["description"] .'</td>';

                                                    //             $countTraining = 0;
                                                    //             $countApproved = 0;
                                                    //             $countEmployee = 0;
                                                    //             $percentage = 0;

                                                    //             $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id" );
                                                    //             if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                    //                 while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                    //                     $found = null;
                                                    //                     $employee_id = $rowEmployee["ID"];
                                                    //                     $array_rowEmployee = explode(", ", $rowEmployee["job_description_id"]);
                                                    //                     $array_rowTraining = explode(", ", $row["job_description_id"]);
                                                    //                     foreach($array_rowEmployee as $emp_JD) {
                                                    //                         if (in_array($emp_JD,$array_rowTraining)) {
                                                    //                             $found = true;
                                                    //                         }
                                                    //                     }

                                                    //                     if ( $found == true ) {
                                                    //                         $trainingStatus = "Not Yet Started";
                                                    //                         $trainingResult = 0;
                                                    //                         $completed_date = '';
                                                    //                         $due_date = '';

                                                    //                         $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id = $employee_id" );
                                                    //                         if ( mysqli_num_rows($selectUser) > 0 ) {
                                                    //                             $rowUser = mysqli_fetch_array($selectUser);
                                                    //                             $employee_user_ID = $rowUser['ID'];

                                                    //                             $selectQuizResult = mysqli_query( $conn,"SELECT * FROM tbl_hr_quiz_result WHERE user_id = $employee_user_ID " );
                                                    //                             if ( mysqli_num_rows($selectQuizResult) > 0 ) {
                                                    //                                 while($rowQuizResult = mysqli_fetch_array($selectQuizResult)) {
                                                    //                                     $trainingResultID = $rowQuizResult['ID'];
                                                    //                                     $trainingQuizID = $rowQuizResult['quiz_id'];

                                                    //                                     if (!empty($row['quiz_id'])) {
                                                    //                                         $array_quiz_id = explode(', ', $row['quiz_id']);
                                                    //                                         if (in_array($trainingQuizID, $array_quiz_id)) {
                                                    //                                             $trainingResult = $rowQuizResult['result'];

                                                    //                                             if ($trainingResult == 100) { $trainingStatus = "Completed"; }
                                                    //                                             else { $trainingStatus = "Not Yet Started"; }
                                                                                
                                                    //                                             $completed_date = $rowQuizResult['last_modified'];
                                                    //                                             $completed_date = new DateTime($completed_date);
                                                    //                                             $completed_date = $completed_date->format('M d, Y');
                                                                                                
                                                    //                                             $due_date = date('Y-m-d', strtotime('+1 year', strtotime($completed_date)) );
                                                    //                                             $due_date = new DateTime($due_date);
                                                    //                                             $due_date = $due_date->format('M d, Y');
                                                    //                                         }
                                                    //                                     }
                                                    //                                 }
                                                    //                                 if ($trainingResult == 100) { $countApproved++; }
                                                    //                             }
                                                    //                         }

                                                    //                         $countEmployee++;
                                                    //                     }
                                                    //                 }
                                                    //             }

                                                    //             if ($countEmployee > 0) {
                                                    //                 $percentage = (100 / $countEmployee) * $countApproved;
                                                    //             } else {
                                                    //                 $countApproved = 0;
                                                    //             }

                                                    //             echo ' <td class="text-center">'. intval($percentage) .'% ('. $countApproved .'/'. $countEmployee .')</td>';

                                                    //             if ( $row["status"] == 0 ) {
                                                    //                 echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                    //             } else if ( $row["status"] == 1 ) {
                                                    //                 echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                    //             } else {
                                                    //                 echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                    //             }

                                                    //             echo '<td class="text-center">
                                                    //                 <div class="mt-action-buttons">
                                                    //                     <div class="btn-group btn-group-circle">
                                                    //                         <a href="#modalView" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('. $row["ID"].', \'modalView\')">View</a>
                                                    //                         <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnDelete('. $row["ID"].')">Delete</a>
                                                    //                     </div>
                                                    //                 </div>
                                                    //             </td>
                                                    //         </tr>';
                                                    //         $i++;
                                                    //     }
                                                    // } else {
                                                    //     echo '<tr class="text-center text-default"><td colspan="8">Empty Record</td></tr>';
                                                    // }
                                                ?>
                                            </tbody>
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
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Training Form</h4>
                                        </div>
                                        <div class="modal-body dashboard-stat2"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_Trainings" id="btnSave_HR_Trainings" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Training Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_Trainings" id="btnUpdate_HR_Trainings" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                        
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
                        
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "trainings";
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
    			
    			
                // Emjay script ends here
                
                var site = '<?php echo $site; ?>';
                $.ajax({
                    url: 'function.php?counterup='+site,
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
                repeaterForm();
            });
            function uiBlock() {
                $('#tableData').block({
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            function btnViewType(id) {
                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Trainings_Type="+id,
                    dataType: "html",
                    success: function(data){
                        // $('#tableDataViewAll').removeClass('hide');
                        $("#tableData tbody").html(data);
                        $('#tableData').unblock();
                    }
                });
            }
            function btnViewAll(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Trainings_TypeAll="+id,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').addClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function selectType(id) {
                if (id.value == "other") { $('.type_other').removeClass('hide'); }
                else { $('.type_other').addClass('hide'); }
            }
            function btnDelete(id) {
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
                        url: "function.php?modalView_HR_Trainings_Delete="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            function repeaterForm() {
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
                                            setTimeout(function() { 
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }
            function btnNew(id, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_HR_Trainings="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNew .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                        selectMulti();
                        repeaterForm();
                    }
                });
            }
            function btnView(id, count, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_HR_Trainings="+id+"&c="+count,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                        selectMulti();
                        repeaterForm();
                    }
                });
            }
            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_Trainings',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_Trainings'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);

                                $('.modalSave .uploadPercentage').removeClass('hide');
                                $('.modalSave .uploadPercentage .progress-bar').css('width', percentComplete + '%');
                                $('.modalSave .uploadPercentage .status-number').html((percentComplete) + '%');
                            }
                       }, false);
                       return xhr;
                    },
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var tbl_counter = $("#tableData tbody > tr").length + 1;
                            var obj = jQuery.parseJSON(response);
                            
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+tbl_counter+'</td>';
                                result += '<td>'+obj.title+'</td>';
                                result += '<td>'+obj.description+'</td>';
                                // result += '<td>'+obj.job_description_id+'</td>';
                                result += '<td class="text-center">'+obj.compliance+'</td>';
                                result += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                result += '<td class="text-center">';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalView" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('+obj.ID+','+tbl_counter+', \'modalView\')">View</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $('#tableData tbody').append(result);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            $('.counterup').counterUp();
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_HR_Trainings',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_Trainings'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);

                                $('.modalUpdate .uploadPercentage').removeClass('hide');
                                $('.modalUpdate .uploadPercentage .progress-bar').css('width', percentComplete + '%');
                                $('.modalUpdate .uploadPercentage .status-number').html((percentComplete) + '%');
                            }
                       }, false);
                       return xhr;
                    },
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.c+'</td>';
                            result += '<td>'+obj.title+'</td>';
                            result += '<td>'+obj.description+'</td>';
                            // result += '<td>'+obj.job_description_id+'</td>';
                            result += '<td class="text-center">'+obj.compliance+'</td>';

                            if ( obj.status == 1) { result += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>'; }
                            else { result += '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>'; }

                            result += '<td class="text-center">';
                                result += '<div class="mt-action-buttons">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('+obj.ID+', '+obj.c+', \'modalView\')">View</a>';
                                        result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</td>';
                            
                            $('#tableData tbody #tr_'+obj.ID).html(result);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            $('.counterup').counterUp();
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
        </script>
    </body>
</html>