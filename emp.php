<?php 
    $title = "EMP";
    $site = "emp";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include "database.php";
    error_reporting(0);
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class=" icon-layers font-dark"></span>
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
                    <div class="portlet-title tabbable-line" style="display:flex;justify-content:space-between">
                        <ul class="nav nav-tabs">
                            <!--Emjay starts here-->
                            <li>
                                <a href="#forms" data-toggle="tab">Filter -</a>
                            </li>
                            <!--Emjay Codes ends here-->
                        </ul>   
                        <div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add_area">Add Area</button>
                            <a href="emp_zone_list.php" class="btn btn-primary">View Zone List</a>
                            <a href="emp_test.php" class="btn btn-primary">View Test Categories</a>
                        </div>
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <td>Equipment/Area</td>
                                        <td>Equipment/Area Image</td>
                                        <td>Frequency</td>
                                        <td>Type</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $zone_id = $_GET['zone_id'];
                                        $sql = "SELECT * FROM new_emp_area WHERE zone_id = $zone_id" ; 
                                        $result = mysqli_query ($emp_connection, $sql);
                                        foreach($result as $row):
                                            $area_name = $row['area_name'];
                                            $image = $row['file'];
                                            if($row['equipment_id'] != 0){
                                                $equipment_id = $row['equipment_id'];
                                                $parts_id = $row['equipment_parts_id'];
                                                $sql_equip = "SELECT * FROM equipment_parts WHERE equipment_parts_id  = $parts_id" ; 
                                                $result_equip = mysqli_query ($pmp_connection, $sql_equip);
                                                $row_assoc = mysqli_fetch_array($result_equip, MYSQLI_ASSOC);
                                                $area_name = $row_assoc['equipment_name'];
                                                $image = $row_assoc['equipment_file'];
                                            }
                                    ?>
                                    <tr>
                                        <td><?= $area_name ?></td>
                                        <!--<td><?= $row['equipment'] ?></td>-->
                                        <td><img style="width:80px;height:80px" src="uploads/pmp/<?php echo $image; ?>"> </td>
                                        <td><?= $row['frequency'] ?></td>
                                        <td>Surface</td>
                                        <td><a href="emp_area_details.php?emp_id=<?= $row['id'] ?>" class="btn btn-primary">View</a></td>
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
	<form id="add_zone_area">
    <div class="modal fade" id="add_area" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Equipment - <a href="#" id="not_equipment_link">Not Equipment ?</a></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row" id="equipment_visible">
                <div class="col-md-12">
                    <label>Area Equipment</label>
                    <select id="category" class="form-control">
                        <option value="0">Please select</option>
                        <?php
                            $sql = "SELECT * FROM  equipment_reg" ; 
                            $results = mysqli_query ($pmp_connection, $sql);
                            foreach($results as $row):
                        ?>
                            <option value="<?= $row['equip_id'] ?>"><?= $row['equipment'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="row" id="equipment_visible" style="margin-top:15px">
                <div class="col-md-12" id="equipment_visible">
                    <select class="form-control" id="filtered-results">
                        
                    </select>
                </div>
            </div>
            <div class="row" id="parts_visible" style="margin-top:15px">
                <div class="col-md-12" id="parts_image">
                    
                </div>
            </div>
            <div class="row" id="area_frequency" style="display: none;">
                <div class="col-md-12" style="margin-top:15px">
                    <label>Area Name</label>
                    <input id="area_name" type="text" class="form-control">
                </div>
                <div class="col-md-12" style="margin-top:15px">
                    <label>Area Image</label>
                    <input type="file" id="file_attachment" class="form-control">
                </div>
            </div>
            <div class="row" id="others" style="display: none;">
                <div class="col-md-12" style="margin-top:15px">
                    <label>Frequency</label>
                    <div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <select id="common_options" onchange="select_common_option()" class="form-control">
                                    <option value="daily">
                                        Daily
                                    </option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12" style="margin-top:15px">
                    <label>Type</label>
                    <select class="form-control">
                        <option>Surface</option>
                        <option>Water</option>
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    </form>
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
