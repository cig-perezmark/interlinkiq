<?php 
    $title = "Good Laboratory Practices Management";
    $site = "emp_settings";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include "database.php";
    ini_set('display_errors', '0');

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
                                <a href="#forms" data-toggle="tab">Settings - <button class="btn btn-primary" data-toggle="modal" data-target="#add_micro">Add Parameter</button></a>
                            </li>
                            <!--Emjay Codes ends here-->
                        </ul>   
                    </div>
    	        
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                        <form method="POST" action="controller.php" enctype="multipart/form-data">
                        <input type="hidden" name="owner_id" value="<?= $switch_user_id ?>">
                    <div class="tab-content">
                        <div class="row" style="margin-top:25px" id="micro_div">
                            <div class="col-md-12" style="padding:10px">
                                <label class="caption-subject font-dark bold uppercase"><?= $_GET['area_name'] ?> - List of Equipments</label><br>
                                <div id="data_container">
                                    <?php
                                        $select_registered = "SELECT * FROM equipment_reg_glp WHERE location = '{$_GET['area_name']}' AND enterprise_owner = $switch_user_id AND deleted != 1";
                                            $registered_result = mysqli_query($pmp_connection, $select_registered);
                                            
                                            if ($registered_result) {
                                                foreach ($registered_result as $registered_result_row) {
                                                    // Explode the valuess from equipment_registered using a comma as the delimiter
                                                        $sql_frequency = "SELECT * FROM new_emp_equipment_frequency_glp WHERE equipment_id = {$registered_result_row['equip_id']}";
                                                        $sql_frequency_result = mysqli_query($emp_connection,$sql_frequency);
                                                        $sql_frequency_result_assoc = mysqli_fetch_assoc($sql_frequency_result);
                                                            ?>
                                                                <input type="hidden" name="equipments_id[]" value="<?= $registered_result_row['equip_id'] ?>">
                                                                <div class="row">
                                                                    <div class="col-md-6" style="margin-top:25px;border:solid 1px #999;padding:10px;min-height:300px ">
                                                                        <label class="font-dark bold uppercase"><?= $registered_result_row['equipment'] ?></label><br><br>
                                                                        <label style="margin-top:5px">Procedure Reference <span class="add-file" data-id="<?= $registered_result_row['equip_id'] ?>">+</span></label><br>
                                                                        <div id="file-attachments<?= $registered_result_row['equip_id'] ?>" style="width:50%;margin-bottom:20px">
                                                                            <input type="file" class="form-control" name="file_attachment[]">
                                                                        </div>
                                                                        <?php 
                                                                            $select_files = "SELECT * FROM new_emp_files_glp WHERE equipment_id = {$registered_result_row['equip_id']}";
                                                                            $files_result = mysqli_query($emp_connection,$select_files);
                                                                            if($files_result):
                                                                                foreach($files_result as $files_row):
                                                                        ?>
                                                                            <a href="uploads/emp/<?=$files_row['file_name'] ?>" target="_blank"><?= $files_row['file_name'] ?></a><br>
                                                                        <?php endforeach; endif; ?>
                                                                        <label for="frequency" style="margin-top:10px">Select frequency:</label>
                                                                        <select class="form-control" name="frequency[]" id="frequency<?= $registered_result_row['equip_id'] ?>" onchange="showAdditionalFields(<?= $registered_result_row['equip_id'] ?>)" style="width:50%">
                                                                            <option value="">Select</option>
                                                                            <option value="Daily" <?php if ($sql_frequency_result_assoc['frequency'] == 'Daily') echo 'selected'; ?>>Daily</option>
                                                                            <option value="Weekly" <?php if ($sql_frequency_result_assoc['frequency'] == 'Weekly') echo 'selected'; ?>>Weekly</option>
                                                                            <option value="Monthly" <?php if ($sql_frequency_result_assoc['frequency'] == 'Monthly') echo 'selected'; ?>>Monthly</option>
                                                                            <option value="Yearly" <?php if ($sql_frequency_result_assoc['frequency'] == 'Yearly') echo 'selected'; ?>>Yearly</option>
                                                                        </select>
                                                                        <div id="additionalFields<?= $registered_result_row['equip_id'] ?>" <?php if ($sql_frequency_result_assoc['frequency'] == 'Weekly'){ echo 'style="display: block"';}else{ echo 'style="display: none"';} ?>>
                                                                            <br>
                                                                            <div id="dayOfWeekSection<?= $registered_result_row['equip_id'] ?>">
                                                                                <label for="dayOfWeek">Day of the week:</label>
                                                                                <select class="form-control" name="day_of_the_week[]" style="width:50%" id="dayOfWeek">
                                                                                    <option value="1" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '1') echo 'selected'; ?>>Monday</option>
                                                                                    <option value="2" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '2') echo 'selected'; ?>>Tuesday</option>
                                                                                    <option value="3" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '3') echo 'selected'; ?>>Wednesday</option>
                                                                                    <option value="4" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '4') echo 'selected'; ?>>Thursday</option>
                                                                                    <option value="5" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '5') echo 'selected'; ?>>Friday</option>
                                                                                    <option value="6" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '6') echo 'selected'; ?>>Saturday</option>
                                                                                    <option value="7" <?php if ($sql_frequency_result_assoc['day_of_the_week'] == '7') echo 'selected'; ?>>Sunday</option>
                                                                                </select>
                                                                                <br><br>
                                                                            </div>
                                                                            <div id="dayOfMonthSection<?= $registered_result_row['equip_id'] ?>" style="display: none;">
                                                                                <label for="dayOfMonth">Day of the month:</label>
                                                                                <input type="number" id="dayOfMonth" class="form-control" style="width:50%" min="1" max="31" placeholder="Enter day of the month">
                                                                                <br><br>
                                                                            </div>
                                                                            <div id="monthAndDayOfYearSection<?= $registered_result_row['equip_id'] ?>" style="display: none;">
                                                                                <label for="monthOfYear">Month of the year:</label>
                                                                                <select class="form-control" style="width:50%" id="monthOfYear">
                                                                                    <option value="January">January</option>
                                                                                    <option value="February">February</option>
                                                                                    <option value="March">March</option>
                                                                                    <!-- Add options for other months -->
                                                                                </select>
                                                                                <br><br>
                                                                                <label for="dayOfMonth">Day of the month:</label>
                                                                                <input style="width:50%" type="number" class="form-control" id="dayOfMonthYearly<?= $registered_result_row['equip_id'] ?>" min="1" max="31" placeholder="Enter day of the month">
                                                                            </div>
                                                                        </div>
                                                                        <div class="md-checkbox-inline" style="padding: 15px; display: flow">
                                                                          <label class="caption-subject font-dark bold uppercase">Parameters:</label><br>
                                                                        
                                                                          <?php
                                                                          $i = 0;
                                                                          $check_sql = "SELECT * FROM new_emp_parameters_glp WHERE owner_id = $switch_user_id ";
                                                                          $check_result = mysqli_query($emp_connection, $check_sql);
                                                                          
                                                                            $select_oum = "SELECT * FROM `new_emp_uom_glp` WHERE owner_id = $switch_user_id";
                                                                            $oum_result = mysqli_query($emp_connection,$select_oum);
                                                                            
                                                                          foreach ($check_result as $check_row):
                                                                            $sql_check = "SELECT * FROM new_emp_equipment_settings_glp WHERE parameter_id = {$check_row['id']} AND equip_id = {$registered_result_row['equip_id']}";
                                                                            $sql_cehck_result = mysqli_query($emp_connection, $sql_check);
                                                                            $sql_check_result_assoc = mysqli_fetch_assoc($sql_cehck_result);
                                                                        
                                                                            // Check if the query result is not null
                                                                            $check_stat = '';
                                                                            $minimum_input = 0;
                                                                            $maximum_input = 0;
                                                                        
                                                                            if ($sql_check_result_assoc !== null) {
                                                                              $check_stat = "checked";
                                                                              $minimum_input = $sql_check_result_assoc['minimum_input'];
                                                                              $maximum_input = $sql_check_result_assoc['maximum_input'];
                                                                            }
                                                                          ?>
                                                                            <div class="col-md-4">
                                                                                <div class="md-checkbox  <?= $check_row['id'] ?>" id="checkboxContainer<?= $i . '' . $registered_result_row['equip_id'] ?>">
                                                                                  <input type="checkbox" value="<?= $check_row['id'] ?>" id="checkbox<?= $i . '' . $registered_result_row['equip_id'] ?>" name="parameter_id[]" class="md-check" onclick="toggleInputBoxes('<?= $check_row['parameter_name'] ?>', <?= $i ?>, <?= $registered_result_row['equip_id'] ?>,'not_checked',<?= $minimum_input ?>,<?= $maximum_input ?>)" <?= $check_stat ?>>
                                                                                  <label for="checkbox<?= $i . '' . $registered_result_row['equip_id'] ?>" oncontextmenu="handleContextMenu(event, 'checkboxContainer<?= $i . '' . $registered_result_row['equip_id'] ?>')">
                                                                                    <span></span>
                                                                                    <span class="check"></span>
                                                                                    <span class="box"></span> <?= $check_row['parameter_name'] ?>
                                                                                  </label>
                                                                                  <div class="delete-button" onclick="deleteCheckbox('checkboxContainer<?= $i . '' . $registered_result_row['equip_id'] ?>', <?= $check_row['id'] ?>)">Delete</div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $i++; endforeach; ?>
                                                                        </div>
                                                                        <div id="inputBoxesContainer<?= $registered_result_row['equip_id'] ?>"></div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                            } else {
                                                echo 'Error fetching data: ' . mysqli_error($pmp_connection);
                                            }
                                    ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="display:flex;justify-content:flex-end;">
                                <button class="btn btn-primary" name="test_post_glp" style="margin-right:30px">Save</button>
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

    <!-- Modal -->
    <div class="modal fade" id="add_micro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Parameter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>Parameter Name</label>
            <input type="text" class="form-control" name="parameter_name">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save_micro">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="add_equipment" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageUploadModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_equipemnt_form">
                    <!-- Image Upload Input -->
                    <div class="form-group">
                        <label for="imageUpload">Upload Image</label>
                        <input type="file" class="form-control-file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage()">
                        <img src="" alt="Preview" id="imagePreview" class="img-fluid mt-2" style="display: none;width:170px">
                    </div>
                    
                    <!-- Equipment Name Input -->
                    <div class="form-group">
                        <label for="equipmentName">Equipment Name</label>
                        <input type="text" class="form-control" name="equipmentName" id="equipmentName" placeholder="Enter equipment name">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save_equipment()">Save</button>
            </div>
        </div>
    </div>
</div>

	</div><!-- END CONTENT BODY -->
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
<script>
    document.getElementById('save_micro').addEventListener('click', function () {
        var parameterName = document.getElementsByName('parameter_name')[0].value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'controller.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reload the content of the micro_div
                $('#micro_div').load(location.href + ' #micro_div');
    
                // Hide the modal using Bootstrap's modal function
                // $('#add_micro').modal('hide');
            }
        };
        xhr.send('action=save_micro_glp&parameter_name=' + parameterName+'&owner_id='+<?= $switch_user_id ?>);
    });
    
    // Remove the modal backdrop when the modal is hidden
$('#add_micro').on('hidden.bs.modal', function () {
    $('.modal-backdrop').remove();
});
document.addEventListener('DOMContentLoaded', function() {
    // Loop through each checkbox and trigger the toggleInputBoxes function

    <?php foreach($registered_result as $registered_result_row): 
            $i = 0; 
            $equipment_id = $registered_result_row['equip_id'];
            foreach ($check_result as $check_row): 
                $sql_check = "SELECT * FROM new_emp_equipment_settings_glp WHERE parameter_id = {$check_row['id']} AND equip_id = {$equipment_id}";
                $sql_cehck_result = mysqli_query($emp_connection,$sql_check);
                $sql_check_result_assoc = mysqli_fetch_assoc($sql_cehck_result);
                // Check if the query result is not null
                if ($sql_check_result_assoc !== null) {
    ?>
                    var minimum_input<?= $i ?> = <?= $sql_check_result_assoc['minimum_input'] ?>;
                    var maximum_input<?= $i ?> = <?= $sql_check_result_assoc['maximum_input'] ?>;
                    var uom<?= $i ?> = "<?= $sql_check_result_assoc['oum'] ?>";
                    var checkbox<?= $i ?> = document.getElementById('checkbox<?= $i .''.$registered_result_row['equip_id'] ?>');
                    var parameterName<?= $i ?> = '<?= $check_row['parameter_name'] ?>';
                    var checkboxIndex<?= $i ?> = <?= $i ?>;
                    var equipment_id<?= $i ?> = <?= $registered_result_row['equip_id'] ?>;
                    // Check if the checkbox is initially checked
                    if (checkbox<?= $i ?> && checkbox<?= $i ?>.checked) {
                        toggleInputBoxes(parameterName<?= $i ?>, checkboxIndex<?= $i ?>, equipment_id<?= $i ?>, 'not_checked', minimum_input<?= $i ?>, maximum_input<?= $i ?>, uom<?= $i ?>);
                    }
    <?php }
                $i++;
            endforeach;
          endforeach; ?>
});
function toggleInputBoxes(parameterName, checkboxIndex, equipment_id,status, minimum_input, maximum_input,uom) {
    const inputBoxesContainer = document.getElementById('inputBoxesContainer' + equipment_id);
    
    // Check if the checkbox is checked
    const checkbox = document.getElementById('checkbox' + checkboxIndex + equipment_id);
    if (checkbox.checked) {
        // Create div for column
        const colDiv = document.createElement('div');
        colDiv.classList.add('col-md-6');
        colDiv.id = 'column' + checkboxIndex + equipment_id;

        // Create label
        const label = document.createElement('label');
        label.textContent = parameterName;
        label.style.marginTop = '10px';
        label.classList.add('font-dark', 'bold', 'uppercase');

        // Create minimum input box
        const minimumInput = document.createElement('input');
        minimumInput.type = 'text';
        minimumInput.placeholder = 'Minimum';
        minimumInput.classList.add('form-control','input-field');
        minimumInput.style.marginTop = '10px';
        minimumInput.setAttribute('name', 'minimum_input[]');
        minimumInput.value = minimum_input;
        minimumInput.setAttribute('required', 'required');
        
        // Create label
        const minimum_label = document.createElement('span');
        minimum_label.textContent = 'Minimum Value:';
        minimum_label.setAttribute('for', 'equip_id[]');
        
        // Create label
        const maximum_label = document.createElement('span');
        maximum_label.textContent = 'Maximum Value:';
        maximum_label.setAttribute('for', 'equip_id[]');
        
        
        const equip_id = document.createElement('input');
        equip_id.type = 'hidden';
        equip_id.placeholder = 'Minimum';
        equip_id.classList.add('form-control','input-field');
        equip_id.style.marginTop = '10px';
        equip_id.setAttribute('name', 'equip_id[]');
        equip_id.value = equipment_id; 
        
        // Create maximum input box
        const maximumInput = document.createElement('input');
        maximumInput.type = 'text';
        maximumInput.placeholder = 'Maximum';
        maximumInput.classList.add('form-control','input-field');
        maximumInput.style.marginTop = '10px';
        maximumInput.setAttribute('name', 'maximum_input[]');
        maximumInput.value = maximum_input;
        maximumInput.setAttribute('required', 'required');
        // Create select element for UOM
        const selectUom = document.createElement('select');
        selectUom.classList.add('form-control');
        selectUom.id = 'select_uom_' + equipment_id;
        selectUom.style.marginTop = '10px';
        selectUom.setAttribute('name', 'oum[]');
        
        // Create default /option
        const defaultOption = document.createElement('option');
        defaultOption.textContent = '--UOM--';
        selectUom.appendChild(defaultOption);
        
        <?php foreach($oum_result as $row): ?>
            console.log();
            
            const cfuOption<?= $row['id'] ?> = document.createElement('option');
            cfuOption<?= $row['id'] ?>.value = '<?= $row['uom'] ?>';
            cfuOption<?= $row['id'] ?>.textContent = '<?= $row['uom'] ?>';
            if(uom === "<?= $row['uom'] ?>") {
                cfuOption<?= $row['id'] ?>.selected = true;
            }
            selectUom.appendChild(cfuOption<?= $row['id'] ?>);
        <?php endforeach ?>
    
        // Create "Others" option
        const othersOption = document.createElement('option');
        othersOption.value = 'others';
        othersOption.textContent = 'Others';
        othersOption.setAttribute('name', 'others_oum[]');
        selectUom.appendChild(othersOption);

        // Create input element for UOM
        const inputUom = document.createElement('input');
        inputUom.type = 'text';
        inputUom.id = 'input_uom_' + equipment_id;
        inputUom.classList.add('form-control', 'input_uom', 'input-field');
        inputUom.style.display = 'none';
        inputUom.style.marginTop = '10px';
        inputUom.placeholder = 'Enter UOM';
        inputUom.setAttribute('name', 'input_oum[]');
        // Add event listener to the select element to toggle input visibility
        selectUom.addEventListener('change', function() {
            const selectedValue = selectUom.value;
            if (selectedValue === 'others') {
                inputUom.style.display = 'block';
            } else {
                inputUom.style.display = 'none';
            }
        });
        
        // Create button to toggle superscript
        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.classList.add('btn', 'btn-primary', 'toggle-button');
        toggleButton.textContent = 'Toggle Superscript';
        toggleButton.style.marginTop = '10px';

        // Append the elements to the column div
        colDiv.appendChild(label);
        colDiv.appendChild(document.createElement('br'));
        colDiv.appendChild(minimum_label);
        colDiv.appendChild(minimumInput);
        colDiv.appendChild(maximum_label);
        colDiv.appendChild(maximumInput);
        colDiv.appendChild(equip_id);
        colDiv.appendChild(selectUom);
        colDiv.appendChild(inputUom);
        colDiv.appendChild(toggleButton);
        
        
        toggleButton.addEventListener("click", toggleSuperscript);
        // Append the column div to the inputBoxesContainer
        inputBoxesContainer.appendChild(colDiv);
    } else {
        // If checkbox is unchecked, remove the corresponding column
        const columnToRemove = document.getElementById('column' + checkboxIndex + equipment_id);
        if (columnToRemove) {
            columnToRemove.remove();
        }
    }
}

$(document).ready(function() {
    $('.add-file').click(function() {
        var id = $(this).data('id');
        var newInput = $('<input type="file" class="form-control" name="file_attachment[' + id + '][]">');
        $('#file-attachments' + id).append(newInput);
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
        alert(uomValue);
        // if (uomValue.trim() !== "") {
        //     // Save the entered data to the database using AJAX
        //     $.ajax({
        //         type: "POST", // Use POST method to send data
        //         url: "controller.php", // Replace with the correct URL
        //         data: { 
        //             uom: uomValue, 
        //             action: "save_uom"
        //         }, // Send the entered UOM value
        //         success: function(response) {
        //             // Handle success (e.g., show a success message)
        //             bootstrapGrowl("UOM saved successfully!");
        //             console.log(response);
        //         },
        //         error: function() {
        //             // Handle error (e.g., show an error message)
        //             alert("Error saving UOM");
        //         }
        //     });
        // }
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

// Now we'll update the event listener for the input fields
// This will handle input fields that are dynamically created
document.addEventListener('input', function(event) {
    const target = event.target;
    if (isSuperscriptMode && target.classList.contains('input-field')) {
        const inputValue = target.value;
        const lastChar = inputValue.charAt(inputValue.length - 1);

        if (!isNaN(lastChar) && lastChar >= '0' && lastChar <= '9') {
            const superscriptChars = ['⁰', '¹', '²', '³', '⁴', '⁵', '⁶', '⁷', '⁸', '⁹'];
            target.value = inputValue.substring(0, inputValue.length - 1) + superscriptChars[parseInt(lastChar)];
        }
    }
});
function showAdditionalFields(itemId) {
    const frequency = document.getElementById("frequency"+itemId).value;
    const additionalFieldsDiv = document.getElementById("additionalFields"+itemId);
    const dayOfWeekSection = document.getElementById("dayOfWeekSection"+itemId);
    const dayOfMonthSection = document.getElementById("dayOfMonthSection"+itemId);
    const monthAndDayOfYearSection = document.getElementById("monthAndDayOfYearSection"+itemId);

    if (frequency === "Weekly") {
        additionalFieldsDiv.style.display = "block";
        dayOfWeekSection.style.display = "block";
        dayOfMonthSection.style.display = "none";
        monthAndDayOfYearSection.style.display = "none";
    } else if (frequency === "Monthly") {
        additionalFieldsDiv.style.display = "block";
        dayOfWeekSection.style.display = "none";
        dayOfMonthSection.style.display = "block";
        monthAndDayOfYearSection.style.display = "none";
    } else if (frequency === "Yearly") {
        additionalFieldsDiv.style.display = "block";
        dayOfWeekSection.style.display = "none";
        dayOfMonthSection.style.display = "none";
        monthAndDayOfYearSection.style.display = "block";
    } else {
        additionalFieldsDiv.style.display = "none";
    }
}
var activeCheckboxContainer = null;

  function handleContextMenu(event, checkboxId) {
    event.preventDefault();

    var mdCheckbox = document.getElementById(checkboxId);

    if (mdCheckbox !== activeCheckboxContainer) {
      // Hide the delete button for the previously right-clicked label
      if (activeCheckboxContainer) {
        activeCheckboxContainer.classList.remove('right-clicked');
        var deleteButton = activeCheckboxContainer.querySelector('.delete-button');
        if (deleteButton) {
          deleteButton.style.display = 'none';
        }
      }

      activeCheckboxContainer = mdCheckbox;

      mdCheckbox.classList.add('right-clicked');

      var deleteButton = mdCheckbox.querySelector('.delete-button');

      if (deleteButton) {
        deleteButton.style.display = 'block';
      }

      document.addEventListener('click', function handleClickOutside() {
        mdCheckbox.classList.remove('right-clicked');

        if (deleteButton) {
          deleteButton.style.display = 'none';
        }

        document.removeEventListener('click', handleClickOutside);
      });
    }
  }

  function deleteCheckbox(containerId, parameterId) {
    // Ask for confirmation
    var confirmed = window.confirm("Are you sure you want to delete this checkbox?");

    if (confirmed) {
        // Continue with the delete operation
        console.log(`Checkbox with ID ${parameterId} deleted`);

        $.ajax({
            type: "POST",
            url: "controller.php",
            data: {
                action: "delete_parameter_glp",
                parameter_id: parameterId
            },
            success: function (response) {
                console.log(response);
                    // Hide the checkbox container after successful deletion
                $('.' + parameterId).hide();
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });

        // Hide the delete button after deletion
        var activeCheckboxContainer = document.getElementById(containerId);
        if (activeCheckboxContainer) {
            activeCheckboxContainer.classList.remove('right-clicked');
            var deleteButton = activeCheckboxContainer.querySelector('.delete-button');
            if (deleteButton) {
                deleteButton.style.display = 'none';
            }
        }
    }
}
function previewImage() {
    var input = document.getElementById('imageUpload');
    var preview = document.getElementById('imagePreview');
    var reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
}

function uploadImage() {
    var equipmentName = document.getElementById('equipmentName').value;
    var input = document.getElementById('imageUpload');
    var file = input.files[0];

    if (equipmentName && file) {
        // Perform your image upload logic here
        console.log('Equipment Name:', equipmentName);
        console.log('Uploaded Image:', file);

        // Close the modal
        $('#imageUploadModal').modal('hide');
    } else {
        alert('Please enter equipment name and select an image.');
    }
}
function save_equipment() {
        // bootstrapGrowl("Uploading Image Please Wait ");
        var formData = new FormData(document.getElementById('add_equipemnt_form'));
        formData.append('file', $('#imageUpload')[0].files[0]);
        formData.append('action', 'save_new_equipment_glp');
        formData.append('location','<?= $_GET['area_name'] ?>')
        formData.append('enterprise_owner', <?= $switch_user_id ?>);
        $.ajax({
            type: 'POST',
            url: 'controller.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                // console.log(data);
                $('#containter_data').load(location.href + ' #containter_data');
                $('#add_zone').modal('hide');
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
</script>
   
	<style>
	.md-checkbox {
        position: relative;
        cursor: pointer;
        display: inline-block;
      }
    
      .delete-button {
        position: absolute;
        top: -30px; /* Adjust this value to position the delete button */
        right: -5px;
        background-color: red;
        border-radius:5px !important;
        color: white;
        padding: 5px;
        display: none;
      }
    
      .md-checkbox.right-clicked .delete-button {
        display: block;
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
