<?php 
    $title = "Environmental Monitoring Program";
    $site = "emp_zone_list";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include "database.php";
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
                        <span class="caption-subject font-dark bold uppercase">Environmental Monitoring Program</span>
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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_zone">Add Zone</button>
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <td>Zone Name</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM  new_emp_zones" ; 
                                    $results = mysqli_query ($emp_connection, $sql);
                                    foreach($results as $row):
                                    ?>
                                    <tr class="editable-row" data-original-zone="<?= htmlspecialchars($row['zone_name']) ?>">
                                        <td class="zone-name" contenteditable><?= $row['zone_name'] ?></td>
                                        <td><a href="new_emps.php?zone_id=<?php echo $row['id']; ?>" class="btn btn-primary">view</a><a href="#" class="btn btn-danger">Delete</a><a class="btn btn-secondary open-settings" data-toggle="modal" data-target="#set_default" data-id="<?php echo $row['id']; ?>">Settings</a></td>
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
   <!-- Modal -->
<div class="modal fade" id="add_zone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Zone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_zone_form">
                    <label>Zone Name</label>
                    <input type="text" class="form-control" id="zone_name">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="set_default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set Default</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="controller.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="caption-subject font-dark bold uppercase">Equipment/Area Collection Description</label>
                            <select id="category" class="form-control">
                                <?php
                                    $select_sql = "SELECT * FROM equipment_reg";
                                    $select_result = mysqli_query($pmp_connection,$select_sql);
                                    foreach($select_result as $select_result_row):
                                ?>
                                    <option value="<?= $select_result_row['equip_id'] ?>"><?= $select_result_row['equipment'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label  class="caption-subject font-dark bold uppercase">Equipment Parts</label>
                            <select class="form-control select2-multiple" id="filtered-results" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-6">
                            <label class="caption-subject font-dark bold uppercase">Zone registered Equipment/Area</label><br>
                            <div id="data_container">
                                <?php
                                    $select_registered = "SELECT * FROM new_emp_zone_equipment WHERE zone_id = 1";
                                        $registered_result = mysqli_query($emp_connection, $select_registered);
                                        
                                        if ($registered_result) {
                                            foreach ($registered_result as $registered_result_row) {
                                                // Explode the values from equipment_registered using a comma as the delimiter
                                                $equipmentIds = explode(',', $registered_result_row['equipment_registered']);
                                        
                                                foreach ($equipmentIds as $equipmentId) {
                                                    // Fetch corresponding data from the equipment_parts table for each exploded value
                                                    $select_equipment = "SELECT * FROM equipment_parts WHERE equipment_parts_id = '$equipmentId'";
                                                    $equipment_result = mysqli_query($pmp_connection, $select_equipment);
                                        
                                                     $equipment_row = mysqli_fetch_assoc($equipment_result)
                                                        // Display the data from equipment_parts
                                                        ?>
                                                        <div class="col-md-6 item-list">
                                                            <div class="item">
                                                                <span class="item-text"><?= $equipment_row['equipment_name'] ?></span>
                                                                <span class="remove-item">x</span>
                                                            </div>
                                                            <!-- Add more items as needed -->
                                                        </div>
                                                        <?php
                                                    
                                                }
                                            }
                                        } else {
                                            echo 'Error fetching data: ' . mysqli_error($emp_connection);
                                        }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="caption-subject font-dark bold uppercase">Type: (Surface / Scrappings / Water / Airt</label>
                            <input type="text" name="type" class="form-control">
                        </div>
                    </div>
                    <input type="text" name="zone_id" id="zone_id" style="display:none">
                    <?php
                    $sql = "SELECT * FROM parameter_categories";
                    $result = mysqli_query($emp_connection, $sql);
                    foreach ($result as $row) :
                        $id = $row['id'];
                        $category_sql = "SELECT * FROM parameters WHERE standard_PK_id = $id";
                        $category_result = mysqli_query($emp_connection, $category_sql);
                        ?>
                        <div class="row" style="margin-top: 25px">
                            <div class="col-md-12">
                                <label class="caption-subject font-dark bold uppercase"><?= $row['category_name'] ?></label>
                            </div>
                            <div class="col-md-12 input-container">
                                <?php foreach ($category_result as $category_row) :
                                    $param_id = $category_row['parameter_id'];
                                    $sql_category = "SELECT * FROM new_emp_default WHERE parameter_cateogry_id = $param_id";
                                    $category_sql = mysqli_query($emp_connection, $sql_category);
                                    $category_assoc = mysqli_fetch_array($category_sql);
                                    $minimum = '';
                                    $maximum = '';
                                    if ($category_assoc['minimum_value']) {
                                        $minimum = $category_assoc['minimum_value'];
                                    }
                                    if ($category_assoc['maximum_value']) {
                                        $maximum = $category_assoc['maximum_value'];
                                    }
                                    ?>
                                    <input type="text" name="parameter_id[]" value="<?= $row['id'] ?>" style="display:none">
                                    <input type="text" name="parameter_cateogry_id[]" value="<?= $category_row['parameter_id'] ?>" style="display:none">
                                    <div class="item-list">
                                        <div class="item">
                                            <span class="item-text"><?= $category_row['Parameter'] ?></span>
                                            <span class="remove-item">x</span>
                                        </div>
                                        <!-- Add more items as needed -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="md-checkbox-inline">
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="checkbox<?= $category_row['parameter_id'] ?>" class="md-check">
                                                    <label for="checkbox<?= $category_row['parameter_id'] ?>">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Integer ? </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="checkbox<?= $category_row['parameter_id'] ?>1" class="md-check">
                                                    <label for="checkbox<?= $category_row['parameter_id'] ?>1">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Scientific Notation ? </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="checkbox<?= $category_row['parameter_id'] ?>2" class="md-check">
                                                    <label for="checkbox<?= $category_row['parameter_id'] ?>2">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Percentage ? </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 12px;display:flex ">
                                            <select class="form-control" style="width: 130px" id="select_uom_<?php echo $category_row['parameter_id']; ?>">
                                                <option>--UOM--</option>
                                            </select>
                                            <input type="text" id="input_uom_<?php echo $category_row['parameter_id']; ?>" class="form-control input_uom input-field" style="display: none; margin-top: 10px; width: 100px" placeholder="Enter UOM">
                                            &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" onclick="toggleSuperscript()">Toggle Superscript</button>
                                        </div>
                                        <div class="col-md-6" style="margin-top: 10px">
                                            <div>
                                                <label>Minimum value</label>
                                            </div>
                                            <div style="display: flex">
                                                <input type="text" value="<?= $minimum ?>" name="minimum_value[]" class="form-control input-field" style="margin-top: 10px">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-top: 10px">
                                            <div>
                                                <label>Maximum value</label>
                                            </div>
                                            <div style="display: flex">
                                                <input type="text" value="<?= $maximum ?>" name="maximum_value[]" class="form-control input-field" style="margin-top: 10px">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                
            </div>
            <div class="modal-footer">
                <button type="submit" name="save_default"  class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Use your existing jQuery library -->

	<?php include('footer.php'); ?>
	<!-- BEGIN CORE PLUGINS -->
            <script src="assets//global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="assets//global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="assets//global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="assets//pages/scripts/components-select2.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="assets//layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
            <script src="assets//layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
            <script src="assets//layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <script src="assets//layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
<script>
$(document).ready(function() {
    $('#filtered-results').on('change', function () {
        var selectedValues = $(this).val();
        var selectedOptions = selectedValues.join(',');

        $.ajax({
            type: 'POST',
            url: 'controller.php', // Replace with your PHP script URL
            data: { 
                selectedOptions: selectedOptions,
                action:"save_emp_registered"
            },
            success: function (response) {
                console.log('Options saved successfully.');
                $("#data_container").load(window.location + " #data_container");
            },
            error: function () {
                console.error('Error saving options.');
            }
        });
    });
            
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
    // Attach a blur event listener to all input elements with class "input_uom"
    $(".input_uom").on("blur", function() {
        var uomValue = $(this).val();
        
        if (uomValue.trim() !== "") {
            // Save the entered data to the database using AJAX
            $.ajax({
                type: "POST", // Use POST method to send data
                url: "controller.php", // Replace with the correct URL
                data: { 
                    uom: uomValue, 
                    action: "save_uom"
                }, // Send the entered UOM value
                success: function(response) {
                    // Handle success (e.g., show a success message)
                    bootstrapGrowl("UOM saved successfully!");
                    console.log(response);
                },
                error: function() {
                    // Handle error (e.g., show an error message)
                    alert("Error saving UOM");
                }
            });
        }
    });

   
    // Attach a mousedown event listener to all select elements
    $("select[id^='select_uom']").on("mousedown", function() {
        // Store a reference to the select element
        var $select = $(this);
    
        // Get the unique identifier from the select element's ID
        var selectId = $select.attr("id");
        var itemId = selectId.split("_")[2]; // Assuming your ID format is "select_uom_x"
    
        // Get the corresponding input element using the data attribute
        var inputId = "input_uom_" + itemId;
        var $input = $("#" + inputId);
    
        // Check if the "Others" option is clicked
        $select.on("change", function() {
            var selectedOption = $select.val();
            if (selectedOption === "others") {
                // Hide the select and show the input field if "Others" was selected
                $select.hide();
                $input.show();
            }
        });
    
        // Make an AJAX request to fetch data (modify the URL as needed)
        $.ajax({
            type: "GET",
            url: "controller.php", // Replace with the correct URL
            dataType: "json",
            data: { action: "get_uom" },
            success: function(data) {
                // Clear existing options except the default one
                $select.find("option:not(:first)").remove();
    
                // Populate the select with new options based on the data
                $.each(data, function(index, value) {
                    $select.append("<option>" + value + "</option>");
                });
                $select.append("<option value='others'>Others</option>");
            },
            error: function() {
                alert("Error fetching data");
            }
        });
    });


    $("#add_zone_form").submit(function(e) {
        e.preventDefault(); // Prevent form submission

        var zoneName = $("#zone_name").val();

        $.ajax({
            type: "POST",
            url: "controller.php",
            data: { 
                action:"save_zone",
                zone_name: zoneName 
            },
            success: function(response) {
                // Update the table with the new zone
                var newRow = '<tr><td>' + zoneName + '</td><td><a href="#" class="btn btn-primary">Update</a><a href="#" class="btn btn-danger">Delete</a></td></tr>';
                $("table tbody").append(newRow);

                // Clear the input and close the modal
                $("#zone_name").val("");
                $("#add_zone").modal("hide");
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    });
      $(".zone-name").on("blur", function() {
        var zoneNameCell = $(this);
        var newZoneName = zoneNameCell.text().trim();
        var originalZoneName = zoneNameCell.parent().data("original-zone"); // Get the original zone name
        if (newZoneName !== originalZoneName) {
            // Perform AJAX request to update the data in the database
            $.ajax({
                type: "POST",
                url: "controller.php",
                data: { 
                    action: "update_zone",
                    original_name: originalZoneName, 
                    new_name: newZoneName 
                },
                success: function(response) {
                    // Handle success
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });
    $(".open-settings").on("click", function () {
        // Get the value from the data-id attribute of the clicked button
        var zoneId = $(this).data("id");
        
        // Set the value of the input field in the modal
        $("#zone_id").val(zoneId);
    });
    $('#saveButton').on('click', function() {
        // Serialize form data
        var formData = $('#defaultForm').serialize();
        formData += '&action=save_category_value';
        $.ajax({
            type: 'POST',
            url: $('#defaultForm').attr('action'), // Use the form's action attribute as the URL
            data: formData,
            success: function(response) {
                // Handle success (e.g., show a success message or refresh the page)
                console.log(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle errors (e.g., display an error message)
                console.error(errorThrown);
            }
        });
    });
    // Delete button click handler
    $(".delete-button").click(function () {
        $(this).closest(".input-container").remove();
    });
});
    let isSuperscriptMode = false;

    function toggleSuperscript() {
        isSuperscriptMode = !isSuperscriptMode;
        const inputFields = document.querySelectorAll(".input-field");

        if (isSuperscriptMode) {
            inputFields.forEach(function(inputField) {
                inputField.placeholder = "Superscript mode: Enter a number";
            });
        } else {
            inputFields.forEach(function(inputField) {
                inputField.placeholder = "Enter a number";
            });
        }
    }

    document.querySelectorAll(".toggle-button").forEach(function(button) {
        button.addEventListener("click", toggleSuperscript);
    });

    document.querySelectorAll(".input-field").forEach(function(inputField) {
        inputField.addEventListener("input", function() {
            if (isSuperscriptMode) {
                const inputValue = inputField.value;
                const lastChar = inputValue.charAt(inputValue.length - 1);

                if (!isNaN(lastChar) && lastChar >= '0' && lastChar <= '9') {
                    const superscriptChars = ['⁰', '¹', '²', '³', '⁴', '⁵', '⁶', '⁷', '⁸', '⁹'];
                    inputField.value = inputValue.substring(0, inputValue.length - 1) + superscriptChars[parseInt(lastChar)];
                }
            }
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
    
    /* Style for the item list container */
.item-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px; /* Adjust the spacing between items */
    align-items: center; /* Center items vertically */
    padding-top:5px;
}

/* Style for each item */
.item {
    background: #EEEEEE;
    padding: 5px 10px;
    border: 1px solid #CCCCCC;
    border-radius: 5px;
    display: flex;
    align-items: center;
}

/* Style for the item text */
.item-text {
    margin-right: 5px;
    font-size: 14px;
    color: #555555;
}

/* Style for the remove button */
.remove-item {
    cursor: pointer;
    font-size: 14px;
    color: red;
    padding: 2px 5px;
    border-radius: 50%;
    user-select: none;
}

/* Hover effect for the remove button */
.remove-item:hover {
    background: #FFCCCC;
}



	</style>
    </body>
</html>
