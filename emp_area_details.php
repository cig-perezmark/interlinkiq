<?php 
    $title = "EMP";
    $site = "emp_area_details.php";
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
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Interlink E-Forms</span>
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
                    <div class="portlet-title tabbable-line">
              
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                        <?php
                                $emp_id = $_GET['emp_id'];
                                $sql = "SELECT * FROM new_emp_area WHERE id = $emp_id" ; 
                                $result = mysqli_query ($emp_connection, $sql);
                                $row_assoc = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                $image = $row_assoc['file'];
                                $parts_id = $row_assoc['equipment_parts_id'];
                                $sql_equip = "SELECT * FROM equipment_parts WHERE equipment_parts_id  = $parts_id" ; 
                                $result_equip = mysqli_query ($pmp_connection, $sql_equip);
                                $row_assoc_parts = mysqli_fetch_array($result_equip, MYSQLI_ASSOC);
                                if($row_assoc['equipment_id'] != 0){
                                   $image = $row_assoc_parts['equipment_file'];
                                }
                        ?>
                            <div class="row">
                                <div class="col-md-6" style="display:flex;flex-direction:column">
                                    <label>Equipment/Area Image</label>
                                    <img style="width:200px;height:200px" src="uploads/pmp/<?php echo $image; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="caption-subject font-dark bold uppercase">Type</label>
                                    <input type="text" class="form-control" value="Surface">
                                </div>
                                <div class="col-md-4">
                                    <label class="caption-subject font-dark bold uppercase">Frequency</label>
                                    <input type="text" class="form-control" value="<?= $row_assoc['frequency'] ?>">
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-6">
                                    <label class="caption-subject font-dark bold uppercase">Supporting Document</label><br>
                                    <a href="#">Area Documents and Images</a>
                                </div>
                            </div>
                            <div class="row" style="margin-top:30px">
                                <label class="caption-subject font-dark bold uppercase">Collected Sample Records</label> - <button class="btn btn-primary" data-toggle="modal" data-target="#modal_collect">Collect Sample</button>
                                <table class="table table-bordered" style="margin-top:15px">
                                    <thead class="bg-primary">
                                        <tr>
                                            <td>Image of Sampling Point</td>
                                            <td>Sampled By</td>
                                            <td>Sampled Date</td>
                                            <td>Result</td>
                                            <td>Tolerance Limit</td>
                                            <td>Analytical Lab</td>
                                            <td>Comment</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img></td>
                                            <td>Quincy</td>
                                            <td>ABC</td>
                                            <td>2</td>
                                            <td>Good</td>
                                            <td>March 5, 2023</td>
                                            <td>Test</td>
                                            <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal_view_collected">View</a></td>
                                        </tr>
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
    <div class="modal fade" id="modal_collect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Collect Sample</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Image of Sampling Point</label>
                    <input type="file" class="form-control">
                </div>
            </div>
            <div class="row mt-3"  style="margin-top:15px">
                <div class="col-md-4">
                    <label>Sampled By</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Sampled Date and Time</label>
                    <input type="datetime-local" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Analytical Lab</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Samply QTY</label>
                    <input type="text" class="form-control">
                </div>
                
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-12">
                    <label class="caption-subject font-dark bold uppercase">Tested for <span id="add_parameter" style="color:green;font-size:14px;font-weight:bold">+</span></label>
                    <div id="parameter-container">
                        <!-- Input boxes will be added here dynamically -->
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-12" id="categories-container">
                    <!-- Categories will be displayed here -->
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Result</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Tolerance Limit</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Comment</label>
                    <textarea class="form-control" style="height:70px;"></textarea>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <hr>
                <div class="col-md-4">
                    <label class="caption-subject font-dark bold uppercase">Sample Records</label>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label style="margin-top:15px">Report Number</label>
                    <input type="text" class="form-control">
                    <label style="margin-top:5px">Report Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label style="margin-top:15px">Reviewed By</label>
                    <input type="text" class="form-control">
                    <label style="margin-top:5px">Reviewed Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label style="margin-top:15px">Added By</label>
                    <input type="text" class="form-control">
                    <label style="margin-top:5px">Added Date</label>
                    <input type="date" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Approved By</label>
                    <input type="text" class="form-control">
                    <label style="margin-top:5px">Approved Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Supporting Documents <span style="color:green;font-weight:500">+</span></label>
                    <input type="file" class="form-control" style="margin-top:5px">
                    <input type="file" class="form-control" style="margin-top:5px">
                    <input type="file" class="form-control" style="margin-top:5px">
                    <input type="file" class="form-control" style="margin-top:5px">
                    <input type="file" class="form-control" style="margin-top:5px">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!--modal end-->
    
    <!-- Modal -->
    <div class="modal fade" id="modal_view_collected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Collect Sample</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                    <label>Image of Sampling Point</label>
                    <img>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Sampled By</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Sampled Date and Time</label>
                    <input type="datetime-local" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Analytical Lab</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Samply QTY</label>
                    <input type="text" class="form-control">
                </div>
                
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-6">
                    <label class="caption-subject font-dark bold uppercase">Tested for</label>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <?php
                    $sql = "SELECT * FROM parameter_categories" ; 
                    $result = mysqli_query ($emp_connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)){?>   
                        <div class="col-md-4">
                            <label ><?= $row['category_name'] ?></label>
                        </div>
                <?php } ?>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Result</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Tolerance Limit</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Comment</label>
                    <textarea class="form-control" style="height:70px;"></textarea>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <hr>
                <div class="col-md-4">
                    <label class="caption-subject font-dark bold uppercase">Sample Records</label>
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label style="margin-top:15px">Report Number</label>
                    <input type="text" value="GHS32AA" class="form-control">
                    <label style="margin-top:5px">Report Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label style="margin-top:15px">Reviewed By</label>
                    <input type="text" value="Quincy" class="form-control">
                    <label style="margin-top:5px">Reviewed Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label style="margin-top:15px">Added By</label>
                    <input type="text" value="Quincy" class="form-control">
                    <label style="margin-top:5px">Added Date</label>
                    <input type="date" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-4">
                    <label>Approved By</label>
                    <input type="text" value="Quincy" class="form-control">
                    <label style="margin-top:5px">Approved Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Supporting Documents <span style="color:green;font-weight:500">+</span></label><br>
                    <a href="#">Supporting Documents and Images.pdf</a>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </div>
    <!--modal end-->
	<?php include('footer.php'); ?>

<script>
$(document).ready(function() {
    var parameterCount = 0;

    $("#add_parameter").click(function() {
        parameterCount++;

        // Create a new input box, buttons, and a div for styling
        var inputBox = $("<input>", {
            type: "text",
            name: "new_category",
            class: "form-control",
            placeholder: "Parameter " + parameterCount
        });

        var removeButton = $("<button>", {
            class: "btn btn-danger btn-sm remove-parameter",
            text: "Remove"
        });

        var submitButton = $("<button>", {
            class: "btn btn-primary btn-sm submit-parameter",
            id: "add_new_category",
            text: "Submit"
        });

        var buttonDiv = $("<div>", {
            class: "parameter-buttons"
        }).append(removeButton).append(submitButton);

        var parameterDiv = $("<div>", {
            class: "parameter-div"
        }).append(inputBox).append(buttonDiv);

        $("#parameter-container").append(parameterDiv);
    });

    // Remove parameter button functionality
    $("#parameter-container").on("click", ".remove-parameter", function() {
        $(this).closest(".parameter-div").remove();
        parameterCount--;
    });
    
    $("#parameter-container").on("click", ".submit-parameter", function() {
        var newCategory = $(this).closest(".parameter-div").find("input.form-control").val();

        if (newCategory.trim() === "") {
            alert("Please enter a category name.");
            return;
        }

        // Send the new category to the server using AJAX
        $.ajax({
            type: "POST",
            url: "controller.php", // Replace with your server-side script
            data: { 
                category_name: newCategory ,
                action : "save_new_parameter"
            },
            success: function(response) {
                console.log(response);
                fetchAndDisplayCategories();
                // Clear the input field
                $("#new_category").val("");
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

function fetchAndDisplayCategories() {
    $.ajax({
        type: "GET",
        url: "controller.php",
        dataType: "json",
        data: { action: "get_new_parameters" },
        success: function(response) {
            var categoriesContainer = $("#categories-container");
            categoriesContainer.empty();

            response.forEach(function(category) {
                var categoryDiv = $("<div>", {
                    class: "col-md-4"
                });

                // Create a label with the category name and a plus button
                var labelWithPlus = $("<label>").text(category.category_name);
                var plusButton = $("<span>", {
                    class: "plus-button",
                    text: "+",
                    "data-id": category.id // Store the ID as a data attribute
                });
                // Attach a click event to the plus button
                plusButton.click(function() {
                    var categoryId = $(this).data("id");
                    var inputBox = $("<input>", {
                        type: "text",
                        class: "form-control",
                        placeholder: "Enter value"
                    });

                    var submitButton = $("<button>", {
                        class: "btn btn-primary submit-input",
                        text: "Submit"
                    });

                    // Append the input box and submit button below the label
                    $(this).after(inputBox, submitButton);

                    // Attach a click event to the submit button
                    submitButton.click(function() {
                        var inputValue = inputBox.val();
                        // Process the input value as needed
                        alert("Input value submitted: " + inputValue);
                    });
                });

                // Append the label and plus button to the category div
                categoryDiv.append(labelWithPlus, plusButton);

                // Append the category div to the container
                categoriesContainer.append(categoryDiv);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

    // Initial fetch and display of categories
    fetchAndDisplayCategories();
</script>

	<style>
	.parameter-buttons {
        margin-top: 5px; /* Adjust the margin as needed */
    }
    
    .parameter-buttons button {
        margin-right: 5px; /* Add spacing between buttons */
    }
    .plus-button{
        color:green;
        font-weight:14px;
        font-weight:600;
    }
    .plus-button:hover{
        cursor:pointer;
    }
	#add_parameter:hover
	{
	    cursor:pointer;
	}
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

<script>
    $(document).ready(function(){
        $('#show_paramters').change(function(){
            var parameter_id = $('option:selected', this).attr('parameter_id');
            var action = "get_parameters";
            $.ajax({
                url : "controller.php",
                data:
                {
                    parameter_id:parameter_id,
                    action:action      
                },
                method:'GET',
                success:function(data) {            
                    $('#cont').html(data);
                    // console.log('done : ' + data);
                }
            });
        });
    });
</script>