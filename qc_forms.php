<?php 
    $title = "Dashboard";
    $site = "qc_forms";
    
     $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
     include "header.php"; 
     if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Interlink QC Forms (Owned)</span>
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
                    <?php if($current_userEmployeeID == 0): ?>
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
                                                	<a data-toggle="modal" data-target="#exampleModal"> Assign Form</a>
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
					                    <td>#</td>
    					                 <td>Form Name</td>
    					                 <td>Action</td>
					             </tr>
					         </thead>
					         <tbody>
					            <?php
					                $query = "SELECT * FROM tbl_afia_forms_list WHERE afl_status_flag = 'A'";
                                    $result = mysqli_query($qc_connection, $query);
                                    foreach($result as $row):
					            ?>
					                    <tr>
        					                 <td>
        					                     <?= $row['PK_id']; ?>
        					                 </td>
        					                 <td>
        					                     <?= $row['afl_form_name']; ?>
        					                 </td>
        					                 <td>
        					                    <a onclick="myfunction(<?= $current_userEmployerID; ?>)" href="/afia_forms/forms/afia/<?= $row['afl_form_code'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
        					                    <a  onclick="myfunction1(<?= $current_userEmployerID; ?>)" href="/afia_forms/records/afia/<?= $row['afl_form_code'] ?>" target="_blank" class="btn blue btn-outline">View Records</a>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Select Form</label>
                            <?php
                                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_user WHERE ID = '" . $_COOKIE['ID'] . "'");
					            $check_result = mysqli_fetch_array($check_form_owned);
					            $array_counter = explode(",", $check_result["form_owned"]);
                            ?>
                            <select name="" class="form-control" id="form_id">
                                <?php foreach($array_counter as $value):
                                    $query = "SELECT * FROM tbl_afia_forms_list WHERE afl_status_flag = 'A' AND PK_id = '$value'";
                                    $result = mysqli_query($qc_connection, $query);
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
                                $get_users = "SELECT * FROM `tbl_hr_employee` WHERE user_id = '" . $_COOKIE['ID'] . "' ";
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
    <!-- Modal end -->


	<?php include('footer.php'); ?>
<script>

 function myfunction(id){
  const d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
 }
 
 
$(document).ready(function(){
 $('#assign').click(function(){
    var eform_id = $('#form_id').find(":selected").val();
    var form_owner = $('#form_owner').val();
    $.ajax({
          url:"app-function/controller.php",
          method:"POST",
          data:{
              action:"add_form",
              eform_id:eform_id,
              form_owner:form_owner
          },
          success:function(data)
          {
            window.location.reload();
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
