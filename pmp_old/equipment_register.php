<?php
    include 'connection/config.php';
    // if they click the button to submit/add new data

    // if they click the button to edit data
    if (isset($_POST['edit'])) {
        
        $e_filename=addslashes($_FILES['e_image']['name']);
        $e_tmpname=addslashes(file_get_contents($_FILES['e_image']['tmp_name']));

        $e_equipment=mysqli_real_escape_string($conn,$_POST['e_equipment']);
        $e_serial=mysqli_real_escape_string($conn,$_POST['e_serial']);
        $e_equipmentid=mysqli_real_escape_string($conn,$_POST['e_equipmentid']);
        $e_location=mysqli_real_escape_string($conn,$_POST['e_location']);
        $e_parts=mysqli_real_escape_string($conn,$_POST['e_parts']);
        $e_processowner=mysqli_real_escape_string($conn,$_POST['e_processowner']);
        $e_freq=mysqli_real_escape_string($conn,$_POST['e_freq']);
        $e_supplier=mysqli_real_escape_string($conn,$_POST['e_supplier']);
        $e_status=mysqli_real_escape_string($conn,$_POST['e_status']);
        //insert the data for maintenance Checklist
        $equip_id=mysqli_real_escape_string($conn,$_POST['equip_id']);
        $M_job_no=mysqli_real_escape_string($conn,$_POST['M_job_no']);
        $M_engr=mysqli_real_escape_string($conn,$_POST['M_engr']);
        $M_date=mysqli_real_escape_string($conn,$_POST['M_date']);
        $M_action=mysqli_real_escape_string($conn,$_POST['M_action']);
        $N_date=mysqli_real_escape_string($conn,$_POST['N_date']);
        //get the ID of Equipment
        $getID=mysqli_query($conn,"SELECT * FROM equipment_reg WHERE equip_id='$equip_id' ");
        while($row=mysqli_fetch_array($getID))
        {
            $M_ID=$row['equip_id'];
        }
        $M_add=mysqli_query($conn,"INSERT INTO `maintenance_checklist`(`m_id`, `equipment_id`, `job_no`, `engr`, `date`, `m_action`, `N_date`) VALUES (' $M_ID',' $M_job_no',' $M_engr',' $M_date',' $M_action',' $N_date')");
        //id of the equipment you want to change/edit
        $equip_ID=mysqli_real_escape_string($conn,$_POST['e_id']);

        $array=array('jpg','jpeg' ,'png');
        $ext=pathinfo($e_filename,PATHINFO_EXTENSION);

        if(!empty($e_filename))
        {
            if(in_array($ext,$array))
            {
                //query to edit the equipment image, base on what you choose (ID)
                $edit=mysqli_query($conn,"UPDATE equipment_reg SET pic_name='$e_filename', image='$e_tmpname' WHERE equip_id ='$equip_ID'");
                header('Location:equipment_register.php');
                exit();
            }
        }
        else {
            //query to edit the equipment details, base on what you choose (ID)
            $edit=mysqli_query($conn,"UPDATE equipment_reg SET equipment='$e_equipment', serial_no='$e_serial', equip_id_no='$e_equipmentid', location='$e_location', parts_to_maintain='$e_parts', process_owner='$e_processowner', freq_maintain='$e_freq', supplier='$e_supplier', status='$e_status' WHERE equip_id ='$equip_ID'");
            header('Location:equipment_register.php');
            exit();
        }
    }
    // if they click the button to delete  data
    else if (isset($_POST['delete'])) {
        
        $d_equip=mysqli_real_escape_string($conn,$_POST['d_id']);

        $delete=mysqli_query($conn,"DELETE FROM equipment_reg WHERE equip_id='$d_equip' ");
        header('Location:equipment_register.php');
        exit();
    }
   

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preventive Maintenance</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
    <!--Custom styles-->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Preventive Maintenance</a>
<div class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a class="nav-link" href="#"><?php
date_default_timezone_set("Asia/Manila");
echo "" . date("h:i:sa");
?></a>
    </li>
</div>
</nav>
<!--Container-->
<div class="container-fluid">
    <div class="row">
        <!--Sidebar-->
        <?php include "templates/sidebar.php" ?>
        <!--Main-->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-3">
            <!--Button Trigger Modal-->
            <div class="row">
                <div class="col-sm-12 ml-1 mt-1">
                    <button id="addbtn" type="button" class="btn btn-info float-right shadow-none mb-2" data-toggle="modal" data-target="#addmodal">
                    <i class="fas fa-plus"></i>Add New</button>
                </div>
            </div>
            <div class="container-fluid mb-4">
            <header class="main-header">
                <p id="header" class="text-center my-1">Equipment Maintenance Register</p>
            </header>
                <!--ADD Modal Form-->
                <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="EquipmentDetails">Equipment Details</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="controller.php" method="post" enctype="multipart/form-data">
                                <script>
                                    $(document).ready(function() {
                                        var i = 1;
                                        $('#add').click(function(){  
                                           i++;  
                                           $('#dynamic_field').append('<div class="row mt-2" id="row'+i+'"><div class="col-md-6"> <label for="inputParts">Manual Name<span style="color:red">*</span></label><input type="text" name="manual_name[]" class="form-control"  ></div><div class="col-md-6"><label>Manual File<span style="color:red">*</span></label><input type="file" name="manual_file[]" class="form-control"  ></div></div>');  
                                      }); 
                                    });
                                </script>
                                <div id="add-modal-body" class="modal-body bg-white">
                                    <div class="form-group">
                                        <label>Equipment Image <span style="color:red">*</span></label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <input type="file" name="equipment_image" class="custom-file-input"  >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                                        <input type="text" name="equipment" class="form-control"  >
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSerial">Serial # <span style="color:red">*</span></label>
                                            <input type="text" name="serial" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEquipmentID">Equipment ID No. <span style="color:red">*</span></label>
                                            <input type="text" name="equipmentid" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputLocation">Location <span style="color:red">*</span></label>
                                        <input type="text" name="location" class="form-control"  >
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="inputProcessOwner">Assign to <span style="color:red">*</span></label>
                                        <input type="text" name="processowner" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputFrequency">Frequency of Maintenance <span style="color:red">*</span></label>
                                        <select name="freq" class="custom-select form-control"  >
                                            <option value"">Choose...</option>
                                            <option value="Daily">Daily</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Semi-Annual">Semi-Annual</option>
                                            <option value="Annual">Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSupplier">Supplier Vendor <span style="color:red">*</span></label>
                                            <input type="text" name="supplier" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStatus">Status <span style="color:red">*</span></label>
                                            <select name="status" class="custom-select form-control"  >
                                                <option value"">Choose...</option>
                                                <option value="In Use">In Use</option>
                                                <option value="Not In Use">Not In Use</option>
                                                <option value="Out of Service">Out of Service</option>
                                                <option value="Clean">Clean</option>
                                                <option value="Soiled">Soiled</option>
                                                <option value="Calibrated">Calibrated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="dynamic_field">
                                        <label for="inputParts">Equipment Manual</label><i class="fas fa-plus" style="font-size:15px;color:green;cursor:pointer" id="add"></i>
                                        <div class="inputs_container row" >
                                            <div class="col-md-6">
                                                <label for="inputParts">Manual File Name<span style="color:red">*</span></label>
                                                <input type="text" name="manual_name[]" class="form-control"  >
                                            </div>
                                            <div class="col-md-6">
                                                <label>Manual File<span style="color:red">*</span></label>
                                                <input type="file" name="manual_file[]" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info shadow-none " name="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--EDIT Modal Form-->
                <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="EditEquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white">Edit Equipment Details</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="controller.php" method="post" enctype="multipart/form-data">
                                <div id="edit-modal-body" class="modal-body bg-white">
                                    <!-- ID of equipment to be edited, it's hidden  -->
                                    <input type="hidden" name="e_id" id="e_id">
                                    <label>Equipment image</label>
                                    <div class="form-group">
                                        <img id="my_image"  style="width:170px" >
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="inputEquipment">Equipment Name</label>
                                        <input type="text" name="e_equipment" class="form-control" id="inputEquipment"  >
                                    </div>
                                    <div class="form-group" id="equipment_manuals" style="display:grid">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSerial">Serial #</label>
                                            <input type="text" name="e_serial" class="form-control" id="inputSerial"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEquipmentID">Equipment ID No.</label>
                                            <input type="text" name="e_equipmentid" class="form-control" id="inputEquipmentID"  >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputLocation">Location</label>
                                        <input type="text" name="e_location" class="form-control" id="inputLocation"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputParts">Parts to Maintain</label>
                                        <input type="text" name="e_parts" class="form-control" id="inputParts"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputProcessOwner">Assigned to</label>
                                        <input type="text" name="e_processowner" class="form-control" id="inputProcessOwner"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputFrequency">Frequency of Maintenance</label>
                                        <select id="inputFrequency" name="e_freq" class="custom-select form-control"  >
                                            <option selected>Choose...</option>
                                            <option value="Daily">Daily</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Semi-Annual">Semi-Annual</option>
                                            <option value="Annual">Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSupplier">Supplier Vendor</label>
                                            <input type="text" name="e_supplier" class="form-control" id="inputSupplier"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStatus">Status</label>
                                            <select id="inputStatus" name="e_status" class="custom-select form-control"  >
                                                <option selected>Choose...</option>
                                                <option value="In Use">In Use</option>
                                                <option value="Not In Use">Not In Use</option>
                                                <option value="Out of Service">Out of Service</option>
                                                <option value="Clean">Clean</option>
                                                <option value="Soiled">Soiled</option>
                                                <option value="Calibrated">Calibrated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAction">Remarks</label>
                                        <textarea class="form-control" rows="5" name="m_action"></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="inputFrequency">Calibration Requirements</label>
                                        <select name="equipment_calibration" id="calibration" class="custom-select form-control"  >
                                            <option value"">Choose...</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3" id="calibrated" style="display:none">
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label for="inputEquipmentID">Calibration Period <span style="color:red">*</span></label>
                                                <input type="date" name="calibration_period" class="form-control"  >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputFrequency">Last Calibration Date <span style="color:red">*</span></label>
                                                <input type="date" name="last_calibration_date" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <label for="inputFrequency">Calibration Due Date<span style="color:red">*</span></label>
                                                <input type="date" name="calibration_due_date" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <label for="inputFrequency">Calibration Body/Organization<span style="color:red">*</span></label>
                                                <textarea class="form-control" name="calibration_body_organization" style="height:70px"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label for="inputFrequency">Result<span style="color:red">*</span></label>
                                                <select name="result" id="calibration" class="custom-select form-control"  >
                                                    <option value"">Choose...</option>
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" name="edit_equipment" class="btn btn-info shadow-none" >Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--DELETE Modal Form-->
                <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="DeleteEquipment" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-danger">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="DeleteEquipment">Confirm Delete</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="equipment_register.php" method="post">
                                <div class="modal-body bg-white text-center">
                                    <!--ID of equipment to be deleted, it's hidden-->
                                    <input type="hidden" name="d_id" id="d_id">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h6>Are you sure you want to delete the selected item?</h6>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" name="delete" class="btn btn-danger shadow-none" >Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table id="dt" class="table table-borderless table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th style="display:none;">ID</th>
                            <th>Equipment</th>
                            <th>Serial #</th>
                            <th>Equipment ID No.</th>
                            <th>Location</th>
                            <th>Parts to Maintain</th>
                            <th>Process Owner</th>
                            <th>Frequency</th>
                            <th style="display:none;">Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--Display all Equipment-->
                    <?php
                        $get= mysqli_query($conn,"SELECT * FROM equipment_reg");
                        
                        while($row=mysqli_fetch_array($get)) {
                    ?>
                    <tr>
                            <td style='display:none;'><?php echo $row['equip_id']; ?></td>
                            <td><?php echo $row['equipment']; ?></td>
                            <td><?php echo $row['serial_no']; ?></td>
                            <td><?php echo $row['equip_id_no']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['parts_to_maintain']; ?></td>
                            <td><?php echo $row['process_owner']; ?></td>
                            <td><?php echo $row['freq_maintain']; ?></td>
                            <td style='display:none;'><?php echo $row['supplier']; ?></td>
                            <?php 
                                if($row['status']=='In Use') {
                            ?>
                                <td style='color:green; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                                else if($row['status']=='Not In Use') {
                            ?>
                                <td style='color:blue; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                                else if($row['status']=='Out of Service') {
                            ?>
                                <td style='color:red; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                                else if($row['status']=='Clean') {
                            ?>
                                <td style='color:orange; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                                else if($row['status']=='Soiled') {
                            ?>
                                <td style='color:brown; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                                else {
                            ?>
                                <td style='color:yellow; font-weight:500;'><?php echo $row['status']; ?></td>
                            <?php
                                }
                            ?>
                            <td>
                                <button type="button" equipment_id="<?= $row['equip_id'] ?>" image_name="<?= $row['pic_name'] ?>" class="btn edit btn-sm shadow-none" title="Edit"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn delete btn-sm shadow-none" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                    </tr>
                            <!--Maintenance Checklist Modal Form-->
                <div class="modal fade" id="check" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white">Maintenance Checklist</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="equipment_register.php" method="post">
                            <div id="edit-modal-body" class="modal-body bg-white">
                                    <!-- ID of equipment to be hidden  -->
                                    <input type="hidden" name="M_id" id="M_id">
                                    <div class="form-group">
                                <div id="add-modal-body" class="modal-body bg-white">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputJob">Job No.</label>
                                            <input type="text" name="job" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEngineer">Engineer</label>
                                            <input type="text" name="engr" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDate">Date Performed</label>
                                        <input type="date" name="p_date" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="M_inputEquipment">Equipment</label>
                                        <input type="text" name="e_equipment" class="form-control" id="M_inputEquipment"  >
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputSerial">Serial #</label>
                                            <input type="text" name="M_serial_no" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEquipmentID">Equipment ID No.</label>
                                            <input type="text" name="M_equip_id_no" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputLocation">Location</label>
                                            <input type="text" name="M_location" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputFrequency">Maintenance Schedule</label>
                                            <input type="text" name="M_schedule" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStatus">Status</label>
                                            <select name="M_status" class="custom-select form-control"  >
                                                <option disabled selected>Choose...</option>
                                                <option value="OK">OK</option>
                                                <option value="DEFECT">DEFECT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAction">Maintenance Action</label>
                                        <textarea class="form-control" rows="5" name="m_action"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info shadow-none " name="check">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <!--DETAILS Modal-->
                    <div class="modal fade" id="details-<?php echo $row['equip_id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <?php echo '<img src="data:image/jpg;base64,'.base64_encode($row['image']).'"class="rounded img-fluid" alt="Responsive image" id="Image">' ?>
                                    <h5 class="text-center mt-2 mb-3">Equipment Details</h5>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Equipment : <?php echo $row['equipment']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Serial # : <?php echo $row['serial_no']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Equipment ID No. : <?php echo $row['equip_id_no']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Location : <?php echo $row['location']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Parts to Maintain : <?php echo $row['parts_to_maintain']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Process Owner : <?php echo $row['process_owner']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Frequency of Maintenance : <?php echo $row['freq_maintain']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Supplier Vendor : <?php echo $row['supplier']; ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                            if($row['status']=='In Use') {
                                        ?>
                                            <p>Status : <span style='color:green; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else if($row['status']=='Not In Use') {
                                        ?>
                                            <p>Status : <span style='color:blue; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else if($row['status']=='Out of Service') {
                                        ?>
                                            <p>Status : <span style='color:red; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else if($row['status']=='Clean') {
                                        ?>
                                            <p>Status : <span style='color:orange; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else if($row['status']=='Soiled') {
                                        ?>
                                            <p>Status : <span style='color:brown; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <p>Status : <span style='color:yellow; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dt').DataTable({
            lengthMenu: [[7, 35, 50, -1], [7, 35, 50, "All"]]
        });
    });
</script>
<!--ADD script-->
<script>
    $(document).ready(function() {
        $(document).on('click', '.edit', function() {
            $('#edit').modal('show');

            $tr=$(this).closest('tr');

            var data=$tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#e_id').val(data[0]);
            $('#inputEquipment').val(data[1]);
            $('#inputSerial').val(data[2]);
            $('#inputEquipmentID').val(data[3]);
            $('#inputLocation').val(data[4]);
            $('#inputParts').val(data[5]);
            $('#inputProcessOwner').val(data[6]);
            $('#inputFrequency').val(data[7]);
            $('#inputSupplier').val(data[8]);
            $('#inputStatus').val(data[9]);
            $('#customFile').val(data[10]);
            
            var pic_name = $(this).attr('image_name')
            $('#my_image').attr('src','uploads/'+pic_name+'');
            
            var equipment_id = $(this).attr('equipment_id');
            var action = "get_equipment_manual";
            $.get("controller.php", 
            {
                equipment_id: equipment_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                $('#equipment_manuals').html(data);
                // console.log('done : ' + data);
            });
            
        });
    });
</script>

<!--DELETE script-->
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete', function() {
            $('#delete').modal('show');

            $tr=$(this).closest('tr');

            var data=$tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#d_id').val(data[0]);
        });
    });
</script>

</script>
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    
    $("#calibration").on("change", function() {
        var option_value = $('#calibration').find(":selected").text();
        
        if(option_value == "Yes"){
            $("#calibrated").css("display", "block");
        }
        else{
           $("#calibrated").css("display", "none"); 
        }
    });
    
</script>

</body>
</html>
