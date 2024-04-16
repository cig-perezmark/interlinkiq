<?php 
    $title = "Good Laboratory Practices Management";
    $site = "emp_zone_details";
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
                    <div class="portlet-title tabbable-line" style="display:flex;justify-content:space-between">
                        <ul class="nav nav-tabs">
                            <!--Emjay starts here-->
                            <li>
                                <a href="#forms" data-toggle="tab">Form</a>
                            </li>
                            <!--Emjay Codes ends here-->
                        </ul>   
                    </div>
    	            <?php
    	                $select_sql = "SELECT * FROM new_emp_records WHERE id = {$_GET['id']}";
    	                $select_result = mysqli_query($emp_connection,$select_sql);
    	                $row_result = mysqli_fetch_assoc($select_result);
    	            ?>
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    <div class="tab-content">
                        <form action="controller.php" method="POST" enctype="multipart/form-data">
                            <div id="forms" class="tab-pane active">
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label>Procedure Reference</label><br>
                                            <?php
                                                $sql = "SELECT * FROM new_emp_files_glp WHERE equipment_id = {$_GET['equip_id']}";
                                                $result = mysqli_query($emp_connection,$sql);
                                                foreach($result as $row):
                                                $file_name = $row['file_name'];
                                                $file_path = 'uploads/emp/' . $file_name; // Set the path to the files
                                            ?>
                                                <a href="<?= $file_path ?>" target="_blank"><?= $file_name ?></a><br>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Sampled By</label>
                                            <input type="text" value="<?= $row_result['sampled_by'] ?>" name="sampled_by" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Sampled Date/Time</label>
                                            <input type="text" name="sampled_date" value="<?= $row_result['sampled_date'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <!--<button type="button" class="btn btn-primary" onclick="toggleSuperscript()">Toggle Superscript</button>-->
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:25px">
                                        <div class="col-md-12">
                                            <label class="caption-subject font-dark bold uppercase">Registered Equipment</label>
                                            <div id="data_container">
                                                <?php
                                                    function convertSuperscriptToExponent($value) {
                                                        // Define a mapping of superscript characters to their corresponding numeric digits
                                                        $superscriptToDigit = [
                                                            '⁰' => '0',
                                                            '¹' => '1',
                                                            '²' => '2',
                                                            '³' => '3',
                                                            '⁴' => '4',
                                                            '⁵' => '5',
                                                            '⁶' => '6',
                                                            '⁷' => '7',
                                                            '⁸' => '8',
                                                            '⁹' => '9'
                                                        ];
                                                    
                                                        // Replace superscript characters with numeric digits
                                                        $valueWithExponent = str_replace(array_keys($superscriptToDigit), array_values($superscriptToDigit), $value);
                                                    
                                                        // Replace 'x10' with 'x10^'
                                                        $valueWithExponent = str_replace('x10', 'x10^', $valueWithExponent);
                                                    
                                                        return $valueWithExponent;
                                                    }
                                                    if(!empty($_GET['equip_id'])){
                                                        $select_registered = "SELECT * FROM new_emp_equipment_frequency_glp WHERE equipment_id = {$_GET['equip_id']}";
                                                        $registered_result = mysqli_query($emp_connection, $select_registered);
                                                        
                                                        if ($registered_result) {
                                                                foreach ($registered_result as $equipmentId) {
                                                                    // Fetch corresponding data from the equipment_parts_glp table for each exploded value
                                                                    $select_equipment = "SELECT * FROM equipment_parts_glp WHERE equipment_parts_glp_id = {$equipmentId['equipment_id']}";
                                                                    $equipment_result = mysqli_query($pmp_connection, $select_equipment);
                                                                     $equipment_row = mysqli_fetch_assoc($equipment_result);
                                                                        // Display the data from equipment_parts_glp
                                                                        if($equipment_row):
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="item-list" style="margin-top:15px">
                                                                                    <div class="item">
                                                                                        <span class="item-text"><?= $equipment_row['equipment_name']?></span>
                                                                                    </div>
                                                                                    <!-- Add more items as needed -->
                                                                                </div>
                                                                                
                                                                                <div class="row">
                                                                                    <?php
                                                                                        $select_params = "SELECT * FROM new_emp_equipment_settings_glp INNER JOIN new_emp_parameters_glp ON new_emp_parameters_glp.id = new_emp_equipment_settings_glp.parameter_id WHERE new_emp_equipment_settings_glp.equip_id = {$equipmentId['equipment_id']}";
                                                                                        $param_results = mysqli_query($emp_connection,$select_params);
                                                                                        foreach($param_results as $param_row):
                                                                                            // Sample usage
                                                                                            $minimum_value = $param_row['minimum_input'];
                                                                                            $maximum_value = $param_row['maximum_input'];
                                                                                            
                                                                                            // Convert to the format with "^"
                                                                                            $minimum_value = convertSuperscriptToExponent($minimum_value);
                                                                                            $maximum_value = convertSuperscriptToExponent($maximum_value);
                                                                                    ?>
                                                                                    <div class="col-md-3">
                                                                                        <label style="margin-top:10px"><?= $param_row['parameter_name'] ?></label>
                                                                                        <div class="d-flex">
                                                                                            <input type="hidden" name="equip_id" value="<?= $_GET['equip_id'] ?>">
                                                                                            <input type="hidden" name="minimum_value" value="<?=$minimum_value ?>" >
                                                                                            <input type="hidden" name="maximum_value" value="<?=$maximum_value ?>" >
                                                                                            <input type="text" value="<?= $row_result['result'] ?>" name="result" class="form-control result-input input-field" data-min="<?= $minimum_value ?>" data-max="<?= $maximum_value ?>" placeholder="Enter result">
                                                                                            <input type="text" value="<?= $row_result['oum'] ?>" class="form-control" value="<?= $param_row['oum']?>" style="width:120px" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; 
                                                                    
                                                                }
                                                        } else {
                                                            echo 'Error fetching data: ' . mysqli_error($emp_connection);
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px" id="append_it_here">
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label>Remarks</label>
                                            <textarea class="form-control" name="remarks" style="height:70px"><?= $row_result['remarks'] ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Result Reference</label><br>
                                            <?php
                                                $sql = "SELECT * FROM new_emp_files_glp WHERE equipment_id = {$_GET['equip_id']}";
                                                $result = mysqli_query($emp_connection,$sql);
                                                foreach($result as $row):
                                                $file_name = $row['file_name'];
                                                $file_path = 'uploads/emp/' . $file_name; // Set the path to the files
                                            ?>
                                                <a href="<?= $file_path ?>" target="_blank"><?= $file_name ?></a><br>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Received By</label>
                                            <input name="received_by" value="<?= $row_result['received_by'] ?>" type="text" name="received_by" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="caption-subject font-dark bold uppercase">Received Date/Time</label>
                                            <input name="received_date" type="text" value="<?= $row_result['received_date'] ?>" name="recevied_date" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            </form>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->

	<?php include('footer.php'); ?>

    <script>
    $('.add-file').click(function() {
        var newInput = $('<input style="margin-top:10px" type="file" class="form-control" name="file_attachment[]">');
        $('#file-attachments').append(newInput);
    });
    // const notEquipmentLink = document.getElementById('not_equipment_link');
    const areaFrequencySection = document.getElementById('area_frequency');
    const area_others = document.getElementById('others');
    const area_visible_equipment = document.getElementById('equipment_visible');
    const area_visible_parts = document.getElementById('parts_visible');
    const area_visible_drop = document.getElementById('filtered-results');
    // notEquipmentLink.addEventListener('click', () => {
    //     areaFrequencySection.style.display = 'block';
    //     area_others.style.display = 'block';
    //     area_visible_equipment.style.display = 'none';
    //     area_visible_parts.style.display = 'none';
    //     area_visible_drop.style.display = 'none';
    //     // Hide other input fields here
    // });
    
        $(document).ready(function() {
            $('.result-input').on('input', function () {
                var input = $(this);
                var min = parseScientificNotation(input.data('min'));
                var max = parseScientificNotation(input.data('max'));
                
                // Convert the input value to caret notation
                var userInputCaretNotation = convertSuperscriptToCaretNotation(input.val());
                var value = parseScientificNotation(userInputCaretNotation);
            
                console.log('User input:', input.val());
                console.log('Converted value:', userInputCaretNotation);
                console.log('Parsed value:', value);
                console.log('Minimum value:', min);
                console.log('Maximum value:', max);
            
                if (!isNaN(min) && value < min) {
                    input.css('color', 'red');
                } else if (!isNaN(max) && value > max) {
                    input.css('color', 'red');
                } else {
                    input.css('color', ''); // Remove red color
                }
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
        });
        
        function appendInputs(checkbox) {
            if (checkbox.checked) {
                var label = checkbox.value;
                var defaultTolerance = checkbox.getAttribute('data-default');
                var div = document.createElement('div');
                div.className = 'col-md-3';
                div.innerHTML = '<label style="margin-top:10px">' + label + '</label>' +
                    '<input type="text" name="result_' + label + '" class="form-control" placeholder="Result">' +
                    '<input type="text" name="tolerance_' + label + '" class="form-control" placeholder="Tolerance" value="' + defaultTolerance + '">';
                document.getElementById('append_it_here').appendChild(div);
            } else {
                var inputName = checkbox.value;
                var elements = document.getElementsByName("result_" + inputName);
                for (var i = 0; i < elements.length; i++) {
                    elements[i].remove();
                }
                elements = document.getElementsByName("tolerance_" + inputName);
                for (var i = 0; i < elements.length; i++) {
                    elements[i].remove();
                }
            }
        }
        function parseScientificNotation(value) {
            if (typeof value !== 'string') {
                // Convert to string if it's not already
                value = value.toString();
            }
        
            // Convert superscript to caret notation
            value = value.replace(/x10⁽(\d+)⁾/g, 'x10^$1');
            value = value.replace(/(\d+)x10⁽(\d+)⁾/g, '$1x10^$2');  // Handle coefficients
            
            var match = value.match(/([\d.]+)x10\^?(\d+)/);
            if (match && match.length === 3) {
                var coefficient = parseFloat(match[1]);
                var exponent = parseInt(match[2]);
                return coefficient * Math.pow(10, exponent);
            } else {
                return parseFloat(value);
            }
        }
        function convertSuperscriptToCaretNotation(input) {
            // Define a mapping of superscript numbers to regular numbers
            var superscriptToRegular = {
                '⁰': '0',
                '¹': '1',
                '²': '2',
                '³': '3',
                '⁴': '4',
                '⁵': '5',
                '⁶': '6',
                '⁷': '7',
                '⁸': '8',
                '⁹': '9'
            };
        
            // Replace superscript 'x10' with caret notation 'x10^'
            input = input.replace(/x10⁽/g, 'x10^');
        
            // Replace superscript numbers with regular numbers
            input = input.replace(/⁰|¹|²|³|⁴|⁵|⁶|⁷|⁸|⁹/g, function(match) {
                return superscriptToRegular[match];
            });
        
            // Replace 'x10' with 'x10^'
            input = input.replace(/x10/g, 'x10^');
        
            return input;
        }
        
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

    function removeItem(button) {
        var itemDiv = button.parentElement.parentElement.parentElement;
        itemDiv.remove();
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
    .add-file{
        font-size:20px;
    }
    .add-file:hover{
        cursor:pointer;
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