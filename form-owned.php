<?php 
    $title = "E-Forms";
    $site = "form-owned";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include_once ('database_afia_forms.php'); 
    include_once ('database_forms.php'); 
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
                                    $type_id = $row["type"];                                    $file_actitle = $row["file_title"];
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
                    <?php if($current_client != 1): ?>
                        <?php if($current_userEmployeeID == 0 OR $current_userEmployeeID == 64 OR $current_userEmployeeID == 81  OR $current_userEmployeeID == 78): ?>
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
        	        <?php endif; ?>
        	        <?php if($current_client == 1): ?>
                        <?php if($current_userAdminAccess == 1): ?>
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
        	        <?php endif; ?>
        	        
        	        <?php if( $_COOKIE['ID'] == 481 OR $_COOKIE['ID'] == 153 ): ?>
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
                                                	<a data-toggle="modal" data-target="#create_form">Generate Form</a>
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
                                        <?php
                                            if($_COOKIE['ID'] == 481):
                                        ?>
                                        <td>KPI(%)</td>
                                        <?php endif; ?>
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
                                                    $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE enterprise_id = '$switch_user_id' AND user_id = {$_COOKIE['ID']}"); 
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
                                                            <?php
                                                                if($_COOKIE['ID'] == 481):
                                                                   $select_kpi_reviewer = "SELECT * FROM kpi_reviewer INNER JOIN kpi_frequency ON kpi_frequency.PK_id =  kpi_reviewer.id WHERE kpi_reviewer.employee_id = {$_COOKIE['employee_id']} AND kpi_reviewer.form_id = {$row['PK_id']}";
                                                                    $kpi_reviewer_result = mysqli_query($e_connection,$select_kpi_reviewer);
                                                                    if($kpi_reviewer_result){
                                                                        $kpi_assoc = mysqli_fetch_assoc($kpi_reviewer_result);
                                                                        $btn_color = 'green';
                                                                        if($kpi_assoc['reviewer'] == 1){
                                                                            $manilaTimezone = new DateTimeZone('Asia/Manila');
                                                                        
                                                                            $to = DateTime::createFromFormat('H:i', $kpi_assoc['time_to'], $manilaTimezone);
                                                                            $currentTime = new DateTime(null, $manilaTimezone);
                                                                        
                                                                            if ($currentTime >= $to) {
                                                                                $btn_color = "red"; 
                                                                            } 
                                                                        }
                                                                    }
                                                            ?>
                                                            <td>100%</td>
                                                            <?php endif; ?>
                                                            <td>
                                                                <?php
                                                                    if($row['form_free'] != 1):
                                                                ?>
                                                                    <a onclick="myfunction('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn <?= $btn_color ?> btn-outline">Add Records</a>
                                                                    <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                        <!--<a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>-->
                                                                    <?php endif; ?>
                                                                    <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                        <a onclick="myfunction('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                    <?php endif; ?>
                                                                    <?php if($_COOKIE['ID'] == 481 AND $row['afl_form_code'] == 'fscs'): ?>
                                                                        <a data-toggle="modal"  data-target="#modal_nav_records" class="btn blue btn-outline">Review</a>
                                                                    <?php endif ?>
                                                                <?php else: ?>
                                                                    <a onclick="myfunction('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn <?= $btn_color ?> btn-outline">Add Records</a>
                                                                    <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                        <!--<a onclick="myfunction('<?= $current_userEmployerID ?>', '<?= $enterp_logo ?>')" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>-->
                                                                    <?php endif; ?>
                                                                    <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                        <a onclick="myfunction('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
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
                                                                        <a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                        <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                            <!--<a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>-->
                                                                        <?php endif; ?>
                                                                        <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
                                                                        <?php if($row['pending_records'] != 0 OR $row['pending_records'] == NULL): ?>
                                                                            <!--<a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/pending/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">Pending Records</a>-->
                                                                        <?php endif; ?>
                                                                        <?php if($row['view_records'] == 0 OR $row['view_records'] == NULL): ?>
                                                                            <a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/1/<?= $_COOKIE['ID'] ?>/<?= $row['afl_form_code'] ?>/view_records/<?= $row['PK_id'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php if($switch_user_id == 185 OR $switch_user_id == 1  OR $switch_user_id == 163 OR $switch_user_id == 78): ?>
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
<?php

    $performer_count = 0;
    // Construct your SQL query
    $count_performer = "SELECT COUNT(*) as count FROM kpi_performer";
    
    // Execute the query
    $count_result = mysqli_query($e_connection, $count_performer);
    
    if (mysqli_num_rows($count_result) > 0) {
        // Output data of each row
        $row_count_result = mysqli_fetch_assoc($count_result);
        $performer_count = $row_count_result["count"];
    } else {
        echo "0 results";
    }
?>
	</div><!-- END CONTENT BODY -->
	<form action="controller.php" method="POST">
        <!-- Modal -->
        <div class="modal fade" id="modal_review" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Today's Action Items - <a href="#">View Records</a> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--<div id="chartdiv"></div>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Total Performer:<?= $performer_count ?></label>
                        <hr>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" style="height:70px"></textarea>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="save_kpi_records" class="btn btn-primary">Update</button>
              </div>
            </div>
          </div>
        </div>
    </form>
<?php 
$record_count = 0;
$sql_record = "SELECT COUNT(PK_id) AS count FROM tbl_fscs_records WHERE DATE(date) = CURDATE()";

$record_result = mysqli_query($e_connection,$sql_record);
if (mysqli_num_rows($record_result) > 0) {
    // Output data of each row
    $record_counts = mysqli_fetch_assoc($record_result);
    $record_count = $record_counts["count"];
}
?>
<form action="controller.php" method="POST">    
    <!-- Modal -->
<div class="modal fade" id="modal_nav_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width:1100px !important">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Forms</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Form</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Records</a>
          </li>
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>-->
          <!--</li>-->
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active" id="home" role="tabpanel" aria-labelledby="home-tab">
              
                <div class="row">
                    <div class="col-md-6">
                        <div id="chartdiv"></div>
                        <label>Total Performer:<?= $performer_count ?></label>
                    </div>
                    <div class="col-md-6">
                        <div id="chartdiv1"></div>
                        <label>Total Records:<?= $record_count ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold">Action Items</th>
                                    <th class="font-weight-bold">Yes</th>
                                    <th class="font-weight-bold">No</th>
                                </tr>
                                <?php
                                    $count = 0;
                                    // Construct your SQL query
                                    $sql_count = "SELECT COUNT(DISTINCT employee_id) AS count FROM kpi_daily_perform WHERE DATE(date_perform) = CURDATE();";
                                    
                                    // Execute the query
                                    $sql_result = mysqli_query($e_connection, $sql_count);
                                    
                                    if (mysqli_num_rows($sql_result) > 0) {
                                        // Output data of each row
                                        $row_count = mysqli_fetch_assoc($sql_result);
                                        $count = $row_count["count"];
                                    }
                                    
                                    
                                    
                                    $not_review_count = 0;
                                    $sql_not_review = "SELECT COUNT(PK_id) AS count FROM tbl_fscs_records WHERE DATE(date) = CURDATE() AND approver_name IS NULL";
                                    $not_review_result = mysqli_query($e_connection,$sql_not_review);
                                    if (mysqli_num_rows($not_review_result) > 0) {
                                        // Output data of each row
                                        $not_review_counts = mysqli_fetch_assoc($not_review_result);
                                        $not_review_count = $not_review_counts["count"];
                                    }
                                    $review_count = $record_count - $not_review_count;
                                    
                                    $total_not_perform = $performer_count - $count;
                                    $action_items = "SELECT * FROM kpi_action_items WHERE employee_id = {$_COOKIE['employee_id']}";
                                    $action_items_result = mysqli_query($e_connection, $action_items);
                                    $counter = -1;
                                    foreach($action_items_result as $rows):
                                        $counter++;
                                ?>
                                <tr>
                                    <input type="hidden" name="performed" value="<?= $count ?>">
                                    <input type="hidden" name="not_perform" value="<?= $total_not_perform ?>">
                                    <td><?= $rows['action_items'] ?><input type="hidden" value="<?= $rows['action_items'] ?>" name="action_items[]"></label></td>
                                    <td><input name="answer_<?= $counter ?>" value="Y" type="radio"></td>
                                    <td><input name="answer_<?= $counter ?>" value="N" type="radio"></td>
                                </tr>
                                <?php endforeach; ?>
                            </thead>
                            
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" style="height:70px"></textarea>
                    </div>
                    <div class="col-md-12" style="display:flex;justify-content:flex-end;margin-top:15px">
                        <button type="submit" name="save_kpi_records" class="btn btn-primary">Update</button>
                    </div>
                </div> 
          </div>
          
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="row">
                    <div class="col-md-12" style="width: 100%; overflow-x: auto;">
                        <!-- HTML -->
                        <div id="chartdiv5" style="width: 1200px"></div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold">Date</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                    $action_records =  "SELECT DISTINCT DATE(date_submitted) AS date_only FROM kpi_action_items_records;";
                                    $records_result = mysqli_query($e_connection,$action_records);
                                    foreach($records_result as $records_row):
                                ?>
                                <tr>
                                    <td><?= $records_row['date_only'] ?></td>
                                    <td><a data-toggle="modal" data-target="#modal_view_records">View - ongoing development</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </thead>
                        </table>
                    </div>
                </div>
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal -->
<div class="modal fade" id="modal_view_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:1100px !important">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="chartdiv3"></div>
                    <label>Total Performer:3</label>
                </div>
                <div class="col-md-6">
                    <div id="chartdiv2"></div>
                    <label>Total Records:3</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Action Items</th>
                                <th class="font-weight-bold">Yes</th>
                                <th class="font-weight-bold">No</th>
                            </tr>
                            <?php
                                $count = 0;
                                // Construct your SQL query
                                $sql_count = "SELECT COUNT(DISTINCT employee_id) AS count FROM kpi_daily_perform WHERE DATE(date_perform) = CURDATE();";
                                
                                // Execute the query
                                $sql_result = mysqli_query($e_connection, $sql_count);
                                
                                if (mysqli_num_rows($sql_result) > 0) {
                                    // Output data of each row
                                    $row_count = mysqli_fetch_assoc($sql_result);
                                    $count = $row_count["count"];
                                }
                                
                                
                                
                                $not_review_count = 0;
                                $sql_not_review = "SELECT COUNT(PK_id) AS count FROM tbl_fscs_records WHERE DATE(date) = CURDATE() AND approver_name IS NULL";
                                $not_review_result = mysqli_query($e_connection,$sql_not_review);
                                if (mysqli_num_rows($not_review_result) > 0) {
                                    // Output data of each row
                                    $not_review_counts = mysqli_fetch_assoc($not_review_result);
                                    $not_review_count = $not_review_counts["count"];
                                }
                                $review_count = $record_count - $not_review_count;
                                
                                $total_not_perform = $performer_count - $count;
                                $action_items = "SELECT * FROM kpi_action_items WHERE employee_id = {$_COOKIE['employee_id']}";
                                $action_items_result = mysqli_query($e_connection, $action_items);
                                $counter = -1;
                                foreach($action_items_result as $rows):
                                    $counter++;
                            ?>
                            <tr>
                                <input type="hidden" name="performed" value="<?= $count ?>">
                                <input type="hidden" name="not_perform" value="<?= $total_not_perform ?>">
                                <td><?= $rows['action_items'] ?><input type="hidden" value="<?= $rows['action_items'] ?>" name="action_items[]"></label></td>
                                <td><input name="answer_<?= $counter ?>" value="Y" type="radio" checked></td>
                                <td><input name="answer_<?= $counter ?>" value="N" type="radio"></td>
                            </tr>
                            <?php endforeach; ?>
                        </thead>
                        
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" style="height:70px">This is a testing notes</textarea>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


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

<form action="controller.php" method="POST">
<!-- Modal -->
<div class="modal fade" id="create_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>Form Name</label>
        <input type="text" class="form-control" name="form_name">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="generate_form" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<style>
    #chartdiv {
      width: 100%;
      height: 200px;
      z-index:999;
    }
    #chartdiv1 {
      width: 100%;
      height: 200px;
      z-index:999;
    }
    #chartdiv2 {
      width: 100%;
      height: 200px;
      z-index:999;
    }
    #chartdiv3 {
      width: 100%;
      height: 200px;
      z-index:999;
    }
    #chartdiv5 {
      width: 100%;
      height: 400px;
      z-index:999;
    }
</style>
	<?php include('footer.php'); ?>
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(
  am5percent.PieChart.new(root, {
    endAngle: 270
  })
);

// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(
  am5percent.PieSeries.new(root, {
    valueField: "value",
    categoryField: "category",
    endAngle: 270
  })
);

series.states.create("hidden", {
  endAngle: -90
});

// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([
  {
  category: "Not Performed",
  value: <?= $total_not_perform ?>
}, {
  category: "Performed",
  value: <?= $count ?>
}]);

series.appear(1000, 100);

}); // end am5.ready()

 $(document).ready(function(){
     var tbody = $('tbody');

    var rows = tbody.find('tr').get();
    rows.sort(function(a, b) {
        var keyA = $(a).find('td:first').text().toUpperCase();
        var keyB = $(b).find('td:first').text().toUpperCase();

        return keyA.localeCompare(keyB);
    });

    $.each(rows, function(index, row) {
        tbody.append(row);
    });
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
 function myfunction(id,enterpriseLogo){
  const d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = `enterprise_logo=${enterpriseLogo}; user_company_id=${id};  ${expires}; path=/`;
  document.cookie = `user_company_id=${id}; ${expires}; path=/`;
 }
 function form_code(id){
     $('#form_ownded').val(id);
 }
 function myfunction1(id,enterpriseLogo){
  const d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = ` enterprise_logo=${enterpriseLogo}; user_company_id=${id}; ${expires}; path=/`;
  document.cookie = `user_company_id=${id}; ${expires}; path=/`;
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
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv1");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(am5percent.PieChart.new(root, {
  layout: root.verticalLayout
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(am5percent.PieSeries.new(root, {
  valueField: "value",
  categoryField: "category"
}));


// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([
  { value: <?= $review_count ?>, category: "Reviewed" },
  { value: <?= $not_review_count ?>, category: "For Reviewed" },
]);


legend.data.setAll(series.dataItems);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series.appear(1000, 100);

}); // end am5.ready()
</script>


<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv3");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(am5percent.PieChart.new(root, {
  layout: root.verticalLayout
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(am5percent.PieSeries.new(root, {
  valueField: "value",
  categoryField: "category"
}));


// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([
  { value: 3, category: "Performed" },
  { value: 0, category: "Not Perform" },
]);


legend.data.setAll(series.dataItems);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series.appear(1000, 100);

}); // end am5.ready()
</script>

<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv2");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(am5percent.PieChart.new(root, {
  layout: root.verticalLayout
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(am5percent.PieSeries.new(root, {
  valueField: "value",
  categoryField: "category"
}));


// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([
  { value: 3, category: "Reviewed" },
  { value: 0, category: "For Reviewed" },
]);


legend.data.setAll(series.dataItems);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series.appear(1000, 100);

}); // end am5.ready()
</script>

<script>
am5.ready(function() {


// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv5");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  paddingLeft: 0,
  wheelX: "panX",
  wheelY: "zoomX",
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(
  am5.Legend.new(root, {
    centerX: am5.p50,
    x: am5.p50
  })
);

var data = [{
  "year": "I received food safety training\nbefore they allow me to work.",
  "s_agree": 10,
  "agree": 7,
  "disagree": 2,
  "s_disagree": 1
}, {
  "year": "I appreciate when a co-worker\npoints out to me if I am doing something\nthat could affect food safety in a bad way",
  "s_agree": 8,
  "agree": 12,
  "disagree": 1,
  "s_disagree": 0
},
{
  "year": "I am comfortable stopping \n the line whenever I see something that might \n harm the quality and safety of the food we make. ",
  "s_agree": 11,
  "agree": 12,
  "disagree": 2,
  "s_disagree": 2
},
{
  "year": "I think my supervisor always puts\nfood safety ahead of production.",
  "s_agree": 9,
  "agree": 5,
  "disagree": 4,
  "s_disagree": 1
}]


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  cellStartLocation: 0.1,
  cellEndLocation: 0.9,
  minorGridEnabled: true
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

xRenderer.grid.template.setAll({
  location: 1
})

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  })
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "year"
  }));

  series.columns.template.setAll({
    tooltipText: "{name}, {categoryX}:{valueY}",
    width: am5.percent(90),
    tooltipY: 0,
    strokeOpacity: 0
  });

  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationY: 0,
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: 0,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Strongly Agree", "s_agree");
makeSeries("Agree", "agree");
makeSeries("Disagree", "disagree");
makeSeries("Strongly Disagree", "s_disagree");


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
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