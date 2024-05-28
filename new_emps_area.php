<?php 
    $title = "EMP";
    $site = "new_emps";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include "database.php";

?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Interlink EMP</span>
                        <?php
                            if($current_client == 0) {
                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo ' - <a class="view_videos" data-src="'.$row['youtube_link'].'" data-fancybox><i class="fa fa-youtube"></i> '.$row['file_title'].'</a>';
                                }
                                
                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                    echo ' <a href="#modal_video" class="btn btn-circle btn-success btn-xs" data-toggle="modal">Add Demo Video</a>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--BEGIN SEARCH BAR        -->
                    <div class="portlet-title tabbable-line" style="display:flex;justify-content:space-between">
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    <div class="tab-content">
                        <?php 
                            $emp_id = $_GET['emp_id'];
                            $query = "SELECT * FROM new_emps WHERE id = $emp_id";
                            $result = mysqli_query($emp_connection, $query);
                            $row_assoc = mysqli_fetch_assoc($result);
                        ?>
                            <div id="forms" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="caption-subject font-dark bold uppercase">Equipment/Area Image</label><br>
                                            <img src="uploads/emp/<?= $row_assoc['image_sampling'] ?>" style="height:120px;widht:120px">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Equipment/Area Collection Description</label>
                                            <input type="text" value="<?= $row_assoc['equipment_area'] ?>" name="equipment_area" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Type: (Sruface / Scrappings / Water / Airt</label>
                                            <input type="text" value="<?= $row_assoc['type'] ?>" name="type" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Sampled By</label>
                                            <input type="text" value="<?= $row_assoc['sampled_by'] ?>" name="sampled_by" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Sampled Date/Time</label>
                                            <input type="datetime-local" value="<?= $row_assoc['sampled_date'] ?>" name="sampled_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Result</label>
                                            <input type="text" value="<?= $row_assoc['result'] ?>" name="result" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Tolerance</label>
                                            <input type="text" value="<?= $row_assoc['tolerance'] ?>" name="tolerance" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Received By</label>
                                            <input type="text"  value="<?= $row_assoc['received_by'] ?>" name="received_by" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Received Date/Time</label>
                                            <input type="datetime-local" value="<?= $row_assoc['received_date'] ?>" name="recevied_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-12">
                                            <label class="caption-subject font-dark bold uppercase">Tested For</label>
                                            <div class="row">

                                                <!--<div class="col-md-3">-->
                                                <!--    <label class="font-dark bold"><?= $row['category_name'] ?></label><br>-->
                                                <!--    <label><input type="checkbox">&nbsp;<?= $row['Parameter'] ?></label>-->
                                                <!--</div>-->
                                                <div class="col-md-3">
                                                    <label class="caption-subject font-dark bold uppercase">Indicator</label><br>
                                                    <label><input type="checkbox" checked>&nbsp;Total Plate Count</label><br>
                                                    <label><input type="checkbox" checked>&nbsp;Coliforms</label><br>
                                                    <label><input type="checkbox">&nbsp;E.coli</label><br>
                                                    <label><input type="checkbox">&nbsp;ATP</label><br>
                                                    <label><input type="checkbox">&nbsp;Listeria</label><br>
                                                    <label><input type="checkbox">&nbsp;Salmonella</label><br>
                                                    <label><input type="checkbox">&nbsp;Staphylococus Aureus</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="caption-subject font-dark bold uppercase">Spoilage</label><br>
                                                    <label ><input type="checkbox" checked>&nbsp;Yeast</label><br>
                                                    <label><input type="checkbox" checked>&nbsp;Molds</label><br>
                                                    <label><input type="checkbox">&nbsp;Lactic Acid Bacteria</label><br>
                                                    <label><input type="checkbox">&nbsp;Total Plate Count</label><br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="caption-subject font-dark bold uppercase">Pathogen</label><br>
                                                    <label><input type="checkbox" checked>&nbsp;E.coli</label><br>
                                                    <label><input type="checkbox" checked>&nbsp;Enterobactericeae</label><br>
                                                    <label><input type="checkbox">&nbsp;Listeria</label><br>
                                                    <label><input type="checkbox">&nbsp;Salmonella</label><br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="caption-subject font-dark bold uppercase">Others</label><br>
                                                    <label><input type="checkbox">&nbsp;ns</label><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                            </div>
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
    const notEquipmentLink = document.getElementById('not_equipment_link');
    const areaFrequencySection = document.getElementById('area_frequency');
    const area_others = document.getElementById('others');
    const area_visible_equipment = document.getElementById('equipment_visible');
    const area_visible_parts = document.getElementById('parts_visible');
    const area_visible_drop = document.getElementById('filtered-results');
    notEquipmentLink.addEventListener('click', () => {
        areaFrequencySection.style.display = 'block';
        area_others.style.display = 'block';
        area_visible_equipment.style.display = 'none';
        area_visible_parts.style.display = 'none';
        area_visible_drop.style.display = 'none';
        // Hide other input fields here
    });
    
        $(document).ready(function() {
            $('#category').on('change', function() {
                var selectedCategory = $(this).val();
                $.ajax({
                    url: 'controller.php', // Path to your PHP script
                    type: 'GET',
                    data: { 
                        action: "get_emp_parts",
                        category: selectedCategory 
                    },
                    success: function(response) {
                        $('#filtered-results').html(response);
                    }
                });
            });
            $('#filtered-results').on('change', function() {
                var selectedCategory = $('#filtered-results').val();
                $.ajax({
                    url: 'controller.php', // Path to your PHP script
                    type: 'GET',
                    data: { 
                        action: "get_emp_parts_image",
                        category: selectedCategory 
                    },
                    success: function(response) {
                        $("#others").show();
                        $('#parts_image').html(response);
                    }
                });
            });
            $("#frequencySelect").change(function() {
                if ($(this).val() === "Others") {
                    $("#freq_input").show();
                } else {
                    $("#freq_input").hide();
                }
            });
            $("#add_zone_area").submit(function(e) {
                e.preventDefault();
            
                var area_name = $("#area_name").val();
                var filtered_results = $('#filtered-results').val();
                var common_options = $('#common_options').val();
                var category = $('#category').val();
                var formData = new FormData();
                var zone_id = <?= $_GET['zone_id'] ?>
                // Append file attachment to FormData
                formData.append("file_attachment", $('#file_attachment')[0].files[0]);
            
                // Append other form data to FormData
                formData.append("action", "save_area");
                formData.append("area_name", area_name);
                formData.append("filtered_results", filtered_results);
                formData.append("category", category);
                formData.append("common_options",common_options);
                formData.append("zone_id",zone_id);
                $.ajax({
                    type: "POST",
                    url: "controller.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Update the table with the new zone
                        var newRow = '<tr><td>' + area_name + '</td><td>' + category + '<td><td>' + filtered_results + '<td></tr>';
                        $("table tbody").append(newRow);
            
                        // Clear the input and close the modal
                        $("#area_name").val("");
                        $("#filtered-results").val("");
                        $("#category").val("");
                        $("#file_attachment").val("");
                        $("#add_zone_area_modal").modal("hide");
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
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