<?php 
    $title = "PTO";
    $site = "pto";
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
                        <span class=" icon-layers font-green"></span>
                        <span class="caption-subject font-green bold uppercase">PTO Dashboard
                        <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                            (<a data-toggle="modal" data-target="#modal_video">Add Video</a>)
                        <?php endif; ?>
                        </span>- 
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

                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <td>Leave Type</td>
                                        <td>Leave Count</td>
                                        <td>Start Date</td>
                                        <td>End Date</td>
                                        <td>Notes</td>
                                        <td>Status</td>
                                        <td>Approver Notes</td>
                                        <td>Attachment</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $session = $_COOKIE['ID'];
                                    $sql = "SELECT * FROM leave_details 
                                    INNER JOIN leave_types ON leave_types.leave_id = leave_details.leave_id WHERE leave_details.payeeid = '$session' " ; 
                                    $result = mysqli_query ($conn, $sql);
                                    foreach($result as $rows):
                                    ?>
                                    <tr>
                                        <td><?= $rows['leave_name'] ?></td>
                                        <td><?= $rows['leave_count'] ?></td>
                                        <td><?= $rows['start_date'] ?></td>
                                        <td><?= $rows['end_date'] ?></td>
                                        <td><?= $rows['notes'] ?></td>
                                        <td>
                                            <?php
                                                if($rows['approve_status'] == 0){
                                                    echo '<span class="badge badge-success">For Approval</span>';
                                                }
                                                if($rows['approve_status'] == 1){
                                                    echo '<span class="badge badge-warning">Approved by Manager</span>';
                                                }
                                                if($rows['approve_status'] == 2){
                                                    echo '<span class="badge badge-primary">Approved by HR</span>';
                                                }
                                                if($rows['approve_status'] == 4){
                                                    echo '<span class="badge badge-danger">Disapproved</span>'; 
                                                }
                                                if($rows['approve_status'] == 5){
                                                    echo '<span class="badge badge-danger">For Cancel</span>'; 
                                                }
                                                if($rows['approve_status'] == 6){
                                                    echo '<span class="badge badge-info">Cancelled</span>'; 
                                                }
                                            ?>
                                        </td>
                                        <td><?= $rows['approve_notes'] ?></td>
                                        <td> <a href="file_download.php"><?= $rows['attachment'] ?></a></td>
                                        <td>
                                            <?php if($rows['approve_status'] != 6): ?>
                                            <a data-toggle="modal" data-target="#exampleModalCenter" id="update_pto" notes="<?= $rows['notes'] ?>" leave_count="<?= $rows['leave_count'] ?>" leave_ids="<?= $rows['ids'] ?>" minute="<?= $rows['leave_id'] ?>" task_date="<?= $rows['start_date'] ?>" end_date="<?= $rows['end_date'] ?>" user_id="<?= $rows['payeeid'] ?>" class="btn btn-outline primary">Update PTO</a>
                                            <a data-toggle="modal" data-target="#cancel_pto_modal" id="pto_cancel" user_notes="<?= $rows['notes'] ?>" leave_count="<?= $rows['leave_count'] ?>" id_leave="<?= $rows['ids'] ?>" minute="<?= $rows['leave_id'] ?>" task_date="<?= $rows['start_date'] ?>" end_date="<?= $rows['end_date'] ?>" user_id="<?= $rows['payeeid'] ?>" class="btn btn-outline red">Request Cancel</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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

<!-- Modal -->
<form action="app-function/controller.php" method="POST">
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update PTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-6">
                <label>Leave Count</label>
                <input type="text" name="leave_count" id="leave_count" class="form-control">
                <input type="hidden" name="leave_id" id="leave_id">
            </div>
        </div>
        <div class="row" style="margin-top:15px">
            <div class="col-md-6">
                <label>Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
        </div>
        <div class="row" style="margin-top:15px">
            <div class="col-md-6">
                <label>Note</label>
                <textarea class="form-control" id="notes" name="notes" row="3"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update_pto" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
</form>
<form action="app-function/controller.php" method="POST">
<div class="modal fade" id="cancel_pto_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cacnel PTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" style="margin-top:15px">
            <input type="hidden" name="id_leave" id="id_leave">
            <div class="col-md-6">
                <label>Note</label>
                <input type="hidden" name="leave_counts" id="leave_counts">
                <textarea class="form-control" id="user_notes" name="user_notes" row="3"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="cancel_pto" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
</form>
	<?php include('footer.php'); ?>
<script>
 
$(document).ready(function(){
 $('[id*="update_pto"]').click(function(){
        var user_id = $(this).attr('user_id');
        var leave_count = $(this).attr('leave_count');
        var start_date = $(this).attr('task_date');
        var leave_ids = $(this).attr('leave_ids');
        var end_date = $(this).attr('end_date');
        var notes = $(this).attr('notes');
        $('#leave_id').val(leave_ids);
        $('#leave_count').val(leave_count);
        $('#start_date').val(start_date);
        $('#end_date').val(end_date);
        $('#notes').val(notes);
 });
 
 $('[id*="pto_cancel"]').click(function(){
        var id_leave = $(this).attr('id_leave');
        var user_notes = $(this).attr('user_notes');
        $('#id_leave').val(id_leave);
        $('#user_notes').val(user_notes);
 });
 
// for gallery
}); 
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

function apps(evt, appName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(appName).style.display = "block";
  evt.currentTarget.className += " active";
}

function btnClone(id) {
    $.ajax({
        type: "GET",
        url: "function.php?btnClone="+id,
        dataType: "html",
        success: function(data){
            // $("#modalReport .modal-body").html(data);

            alert(data);
        }
    });
}
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