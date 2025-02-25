<?php 
    $title = "Good Laboratory Practices Management";
    $site = "glp_zone";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include "database.php";
    include_once ('header.php'); 
    error_reporting(0);

    // $select_collab_exist = "SELECT * FROM new_emp_collab WHERE employee_id = {$current_userEmployeeID}";
    // $exist_result = mysqli_query($emp_connection, $select_collab_exist);
    // if (!$exist_result) {
    //     // Handle query execution errors
    //     header('Location: https://interlinkiq.com/404.php');
        
    // } else {
    //     // Check if any rows were returned
    //     if (mysqli_num_rows($exist_result) == 0) {
    //         // No record found, redirect to 404
    //         echo '<script>window.location.href = "https://interlinkiq.com/404.php";</script>';
    //     }
    //     // Continue processing if the record exists
    // }
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Good Laboratory Practices Management</span>
                        
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
                    <div class="portlet-title tabbable-line" style="display:flex;justify-content:flex-end">
                        <div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add_zone">Add Area</button>
                            <a class="btn btn-secondary" href="glp_filter.php">List of Inspection</a>
                        </div>
                        <div style="align-items:center;display:flex">
                            <a style="margin-left:10px"  data-toggle="modal" data-target="#modal_assign"><i class="icon-settings"></i></a>
                        </div>
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body" id="containter_data">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active" style="display:flex;flex-wrap:wrap">
                            <?php 
                                $sql = "SELECT * FROM area_list_glp WHERE deleted = 0 AND area_list_glp.enterprise_owner = $switch_user_id";
                                $result = mysqli_query($pmp_connection,$sql);
                                foreach($result as $row):
                                    $image_path = 'uploads/emp/photos.avif';
                                    if($row['image_blob'] != ''){
                                        $image_path = $row['image_blob'];
                                    }
                                    $area_name = $row['area_name'];
                            ?>
                                <div class="card">
                                  <div style="display:flex;justify-content:flex-end">
                                      <a href="#" onclick="btnDelete_LA(<?= $row['id']?>,this)"><i class="icon-trash"></i></a>
                                  </div>
                                  <div class="card-header" id="card_image<?= $row['id'] ?>" style="background-image:url('<?= $image_path ?>')">
                                    <!-- Input element for image selection -->
                                    <div class="card-header-bar">
                                        <!-- Your existing content for card-header-bar -->
                                        <input type="file" class="form-control" id="imageInput" onchange="uploadImage(this, <?= $row['id'] ?>)">
                                    </div>
                                
                                    <div class="card-header-slanted-edge"></div>
                                </div>
                            
                                  <div class="card-body" style="margin-top:50px">
                                      <span class="name" data-id="<?= $row['id'] ?>" id="dbl_click<?= $row['id'] ?>"><?= $row['area_name'] ?></span><br>
                                  </div>
                            
                                  <div class="card-footer">
                                      <div class="stats">
                                          <div class="stat">
                                            <span class="label">Equipment</span>
                                            <span class="value">2</span>
                                          </div>
                                        </div>
                                         <div class="stat">
                                              <?php
                                                $zone_id = $row['id'];
                                                $user_cookie = $_COOKIE['employee_id'];
                                                $sql_select = "SELECT tbl_hr_employee.ID, tbl_hr_employee.department_id,tbl_hr_job_description.title,tbl_hr_job_description.ID FROM tbl_hr_employee INNER JOIN tbl_hr_job_description ON tbl_hr_employee.job_description_id = tbl_hr_job_description.ID  WHERE tbl_hr_employee.ID = 78";
                                                $result = mysqli_query($conn, $sql_select);
                                                if ($result):
                                                    // Fetch all the rows into an array
                                                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                
                                                    // Free result set
                                                    mysqli_free_result($result);
                                                    foreach ($rows as $row):
                                                        $job_title = $row['title'];
                                                        if (strpos($job_title, 'Supervisor') !== false || strpos($job_title, 'Manager') !== false):
                                              ?>
                                                <!--<span class="label">Settings</span>-->
                                                <button class="cta">
                                                  <span id="redirect_page" onclick="redirectToOtherPage1('<?= $area_name ?>')">Settings</span>
                                                  <svg viewBox="0 0 13 10" height="10px" width="15px">
                                                    <path d="M1,5 L11,5"></path>
                                                    <polyline points="8 1 12 5 8 9"></polyline>
                                                  </svg>
                                                </button>
                                            <?php endif; endforeach;endif ?>
                                        </div>
                                  </div>
                              </div>
                          <?php endforeach; ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div id="imagePreview"></div>
                                <label>Select image</label>
                                <input type="file" class="form-control" name="zone_image" id="fileInput" accept="image/*">
                            </div>
                            <div class="col-md-12" style="margin-top:10px">
                                <label>Area Name</label>
                                <input type="text" name="zone_name" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="saveZone()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Use your existing jQuery library -->
<!-- Modal -->
<form method="POST" action="controller.php">
    <div class="modal fade" id="modal_assign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Assign Personel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>Select User</label>
            <input type="hidden" name="enterprise_id" value="<?= $switch_user_id ?>">
            <select name="employee_id[]" class="form-control mt-multiselect" multiple="multiple">
                <?php
                    // Fetch already selected employees for the given enterprise_id
                    $selected_employee_ids = [];
                    $fetch_query = "SELECT employee_id FROM new_emp_collab WHERE enterprise_id = '$switch_user_id'";
                    $fetch_result = mysqli_query($emp_connection, $fetch_query);
                    
                    if ($fetch_result) {
                        while ($row = mysqli_fetch_assoc($fetch_result)) {
                            $selected_employee_ids[] = $row['employee_id'];
                        }
                    }

                    $employee_sql = "SELECT * FROM tbl_hr_employee WHERE user_id = {$switch_user_id} AND status = 1";
                    $employee_result = mysqli_query($conn,$employee_sql);
                    foreach($employee_result as $employee_row):
                        $selected = in_array($employee_row['ID'], $selected_employee_ids) ? 'selected' : '';
                ?>
                    <option value="<?= $employee_row['ID'] ?>"  <?= $selected ?>><?= $employee_row['first_name'] .' '.$employee_row['last_name'] ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="save_collab" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</form>
	<?php include('footer.php'); ?>

<script>
function uploadImage(input, id) {
    // Your existing code for handling the file upload
    var file = input.files[0];

    var formData = new FormData();
    formData.append('action', 'update_emp_image_glp');
    formData.append('image', file);
    formData.append('id', id); // Include the ID in the form data

    // Make an AJAX request
    $.ajax({
        type: 'POST',
        url: 'controller.php', // Replace with the actual path to your PHP file
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Handle the response from the server
            console.log(response);
            var imageUrl = response;
            var previewImage = document.getElementById('card_image'+id).style.backgroundImage="url("+'uploads/emp/' + imageUrl+")";;
            // previewImage.src = 'uploads/emp/' + imageUrl;
        },
        error: function (error) {
            // Handle the error
            console.error(error);
        }
    });
}
function redirectToOtherPage() {
    // Replace 'other_page.html' with the URL you want to redirect to
    window.location.href = 'glp_zone_details.php?zone_id=1';
  }
function redirectToOtherPage1(zone_id) {
// Replace 'other_page.html' with the URL you want to redirect to/
window.location.href = 'glp_settings.php?area_name='+zone_id;
}
$(document).on('click','.name',function(){
    let id = $(this).data('id');

    $('#dbl_click'+id).attr("contenteditable", true)
    $('#dbl_click'+id).on('blur',function(){
        var area_name = $('#dbl_click'+id).text();
        $.post({
            url:'controller.php',
            data:{
                area_name:area_name,
                area_id:id,
                enterprise_id : <?= $switch_user_id ?>,
                action:"update_area_name"
            },
            success: function(response){
                console.log(response);
                $('#dbl_click'+id).attr("contenteditable", false) 
            }
        });
      
    })
});

$(document).ready(function() {
    // $('[id*="update_area_name"]').dblclick(function(){
    //     $(this).attr("contenteditable", true)
    //     console.log($(this).text())
    // });

    $("#fileInput").change(function() {
        previewImage(this);
      });
    
     function previewImage(input) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#imagePreview").html('<img src="' + e.target.result + '" width="200px" height="200px">');
      }
      reader.readAsDataURL(input.files[0]);
    }

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

    function saveZone() {
        bootstrapGrowl("Uploading Image Please Wait ");
        var formData = new FormData(document.getElementById('add_zone_form'));
        formData.append('file', $('#fileInput')[0].files[0]);
        formData.append('action', 'save_new_zones_glp');
        formData.append('enterprise_owner', <?= $switch_user_id ?>);
        $.ajax({
            type: 'POST',
            url: 'controller.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#containter_data').load(location.href + ' #containter_data');
                $('#add_zone').modal('hide');
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    function btnDelete_LA(id, e) {
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
                url: "controller.php?pmp_la_del_glp="+id,
                dataType: "html",
                success: function(response){
                    $(e).parent().parent().remove();
                }
            });
            swal("Done!", "This item has been deleted.", "success");
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

.card {
  position: relative;
  width: 315px;
  height: 450px;
  margin: 30px auto;
  box-shadow: 0 0 100px rgba(0,0,0, .3);
  border-radius: 10px;
}

.card-header {
  position: relative;
  height: 220px;
  background-size: cover;
  background-position: top;
}

.card-header:after {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background-size: auto;
  background-repeat: no-repeat;
  background-position: center center; /* Positions the image at the center */
  border-radius: 10px;
}

.image {
  position: absolute;
  margin-top: 100px;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #222;
  font-size: 20px;
  font-weight: 400;
}

.card-header-bar {
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 1;
  width: 100%;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  clip: rect(0,0,0,0);
  border: none;
  overflow: hidden;
}

.btn-message {
  display: inline-block;
  width: 19.37px;
  height: 16.99px;
  margin-right: 10px;
  margin-top: 10px;
  float: right;
}

.btn-menu {
  display: inline-block;
  background: width: 19px;
  height: 12.16px;
  margin-left: 10px;
  margin-top: 10px;
  float: left;
}

.card-header-slanted-edge {
  position: absolute;
  bottom: -3px;
  z-index: 1;
  width: 100%;
  right: 0;
  left: 0;
}

.card-body {
  text-align: center;
  padding-left: 10px;
}

.name {
  font-size: 20px;
  font-weight: 700;
  text-transform: uppercase;
  margin: 0 auto;
}

.job-title {
  font-size: 14px;
  font-weight: 300;
  margin-top: 15px;
  color: #919191;
}

.bio {
  font-size: 14px;
  color: #7B7B7B;
  font-weight: 300;
  margin: 10px auto;
  line-height: 20px;
}

.social-accounts img {
  width: 15px;
}

.social-accounts a {
  margin-left: 10px;
}

.social-accounts a:first-child {
  margin-left: 0;
}

.card-footer {
  position: absolute;
  left: 50px;
  width: 100%;
  bottom: 20px;
}

.stat {
  box-sizing: border-box;
  width: calc(100% / 3);
  float: left;
  text-align: center;
}

.stat:nth-child(2) {
  border-left: 1px solid grey;
}

.stat:nth-child(3) {
  border-left: 1px solid grey;
}

.stat .label {
  display: block;
  text-transform: uppercase;
  font-weight: 300;
  font-size: 11px;
  letter-spacing: 1px;
  color: #95989A;
}

.stat .value {
  display: block;
  font-weight: 700;
  font-size: 20px;
  margin-top: 5px;
}

.cta {
 position: relative;
 margin: auto;
 padding: 5px;
 transition: all 0.2s ease;
 border: none;
 background: none;
}

.cta:before {
 content: "";
 position: absolute;
 top: 0;
 left: 0;
 display: block;
 border-radius: 50px;
 background: #b1dae7;
 width: 30px;
 height: 30px;
 transition: all 0.3s ease;
}

.cta span {
 position: relative;
 font-size: 12px;
 font-weight: 700;
 letter-spacing: 0.05em;
 color: #234567;
}

.cta svg {
 position: relative;
 top: 0;
 margin-left: 10px;
 fill: none;
 stroke-linecap: round;
 stroke-linejoin: round;
 stroke: #234567;
 stroke-width: 2;
 transform: translateX(-5px);
 transition: all 0.3s ease;
}

.cta:hover:before {
 width: 100%;
 background: #b1dae7;
}

.cta:hover svg {
 transform: translateX(0);
}

.cta:active {
 transform: scale(0.95);
}

	</style>
    </body>
</html>
