<?php 
    $title = "PTO-Requests";
    $site = "pto_request";
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
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Accounting PTO Request
                        <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                            (<a data-toggle="modal" data-target="#modal_video">Add Video</a>)
                        <?php endif; ?>
                        </span>- 
                            <?php
                                $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND user_id = '$switch_user_id' OR page = '$site' AND user_id = '163' OR page = '$site' AND user_id = '$current_userEmployerID' " ; 
                                $result = mysqli_query ($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)){?>   
                                    <!--<a data-toggle="modal" data-target="#view_video" class="view_videos"  file_name="<?= $row['youtube_link'] ?>"><?= $row['file_title'] ?></a>-->
                                    <a class="view_videos" data-src="<?= $row['youtube_link'] ?>" data-fancybox><i class="fa fa-youtube"></i><?= $row['file_title'] ?></a>
                                    <?= "/" ?>
                            <?php } ?>
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
                                        <td>Full Name</td>
                                        <td>Position</td>
                                        <td>Leave Type</td>
                                        <td>Leave Count</td>
                                        <td>Start Date</td>
                                        <td>End Date</td>
                                        <td>Notes</td>
                                        <td>Status</td>
                                        <td>Attachment</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM leave_details 
                                    INNER JOIN tbl_user ON tbl_user.ID = leave_details.payeeid 
                                    INNER JOIN leave_types ON leave_types.leave_id = leave_details.leave_id 
                                    WHERE leave_details.approve_status = 1 OR leave_details.approve_status = 5" ; 
                                    $result = mysqli_query ($conn, $sql);
                                    
                                    foreach($result as $rows):
                                    ?>
                                    <tr>
                                        <td><?= $rows['first_name'].' '.$rows['last_name'] ?></td>
                                        <td></td>
                                        <td><?= $rows['leave_name'] ?></td>
                                        <td>
                                            <?php if($rows['leave_id'] == -7): ?>
                                                .5
                                            <?php else: ?>
                                                <?= $rows['leave_count'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $rows['start_date'] ?></td>
                                        <td><?= $rows['end_date'] ?></td>
                                        <td><?= $rows['notes'] ?></td>
                                        <td>
                                            <?php
                                                if($rows['approve_status'] == 1){
                                                    echo '<span class="badge badge-success">For Approval</span>';
                                                }
                                                else{
                                                    echo '<span class="badge badge-danger">For Cancel</span>';
                                                }
                                                
                                            ?>
                                        </td>
                                        <td> <a href="#"><?= $rows['attachment'] ?></a></td>
                                        <td>
                                            <?php
                                             if($rows['approve_status'] == 1): ?>
                                                    <a id="approve_pto" leave_count="<?= $rows['leave_count'] ?>" minute="<?= $rows['leave_id'] ?>" task_date="<?= $rows['start_date'] ?>" end_date="<?= $rows['end_date'] ?>" user_id="<?= $rows['payeeid'] ?>" class="btn btn-outline blue edit">Approve</a>
                                              <?php else: ?>
                                                    <a id="pto_cancel" users_id="<?= $rows['payeeid'] ?>" leave_count="<?= $rows['leave_count'] ?>" leave_ids="<?= $rows['ids'] ?>" class="btn btn-outline yellow edit">Cancel</a>
                                            <?php endif; ?>
                                            <!--<a class="btn btn-outline red">Disapprove</a>-->
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



	<?php include('footer.php'); ?>
<script>
 
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
            //console.log(data); 
          }
        })
 });
 
 $('[id*="pto_cancel"]').click(function(){
        var leave_ids = $(this).attr('leave_ids');
        var leave_count = $(this).attr('leave_count');
        var users_id = $(this).attr('users_id');
        $.ajax({
          url:"app-function/controller.php",
          method:"POST",
          data:{
              action:"cancel_pto",
              leave_count:leave_count,
              leave_ids:leave_ids,
              users_id:users_id
          },
          success:function(data)
          {
            //window.location.reload();
            console.log(data); 
          }
        })
        
 });
 
  $('[id*="approve_pto"]').click(function(){
        var user_id = $(this).attr('user_id');
        var task_date = $(this).attr('task_date');
        var minute = $(this).attr('minute');
        var leave_count = $(this).attr('leave_count');
        var end_date = $(this).attr('end_date');
        $.ajax({
          url:"app-function/controller.php",
          method:"POST",
          data:{
              action:"insert_leave",
              user_id:user_id,
              minute:minute,
              task_date:task_date,
              leave_count:leave_count,
              end_date:end_date
          },
          success:function(data)
          {
            window.location.reload();
            //console.log(data); 
          }
        })
        
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
