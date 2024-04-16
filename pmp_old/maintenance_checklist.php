<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    include 'connection/config.php';
    // if they click the button to submit/add new data
    if (isset($_POST['submit'])) {

        $equip_id=mysqli_real_escape_string($conn,$_POST['equip_id']);
        $job_no=mysqli_real_escape_string($conn,$_POST['job']);
        $engr=mysqli_real_escape_string($conn,$_POST['engr']);
        $date=mysqli_real_escape_string($conn,$_POST['p_date']);
        $serial=mysqli_real_escape_string($conn,$_POST['serial_no']);
        $equip_number=mysqli_real_escape_string($conn,$_POST['equip_id_no']);
        $location=mysqli_real_escape_string($conn,$_POST['location']);
        $schedule=mysqli_real_escape_string($conn,$_POST['m_schedule']);
        $status= "OK";
        $action=mysqli_real_escape_string($conn,$_POST['m_action']);
        $parts_PK_id=mysqli_real_escape_string($conn,$_POST['parts_PK_id']);


        $get = mysqli_query($conn,"SELECT * FROM equipment_reg WHERE equip_id ='$equip_id'");
        // to get the name of the equipment based on the equipment id
        while ($row=mysqli_fetch_array($get)) 
        {
            $equipment_n=$row['equipment'];
        }
        //add data to equipment table
        $add=mysqli_query($conn," INSERT INTO `maintenance_checklist` (`job_no`, `engr`, `date`, `equip_id`, `equipment`, `serial_no`, `equip_id_no`, `location`, `m_schedule`, `status`, `m_action`, `parts_PK_id`) VALUES ('$job_no', '$engr', '$date', '$equip_id', '$equipment_n', '$serial', '$equip_number', '$location', '$schedule', '$status', '$action','$parts_PK_id')");

        header('Location:maintenance_checklist.php');
        exit();
    }
    // if they click the button to edit
    else if (isset($_POST['edit'])) {

        $m_id=mysqli_real_escape_string($conn,$_POST['m_id']);
        $e_id=mysqli_real_escape_string($conn,$_POST['e_id']);

        $e_equipn=mysqli_real_escape_string($conn,$_POST['e_equipn']);
        $e_job_no=mysqli_real_escape_string($conn,$_POST['e_job']);
        $e_engr=mysqli_real_escape_string($conn,$_POST['e_engr']);
        $e_date=mysqli_real_escape_string($conn,$_POST['e_date']);
        $e_serial=mysqli_real_escape_string($conn,$_POST['e_serial']);
        $e_equip_number=mysqli_real_escape_string($conn,$_POST['e_equipno']);
        $e_location=mysqli_real_escape_string($conn,$_POST['e_location']);
        $e_sched=mysqli_real_escape_string($conn,$_POST['e_sched']);
        $e_status=mysqli_real_escape_string($conn,$_POST['e_status']);
        $e_action=mysqli_real_escape_string($conn,$_POST['e_action']);  

        //query to edit the maintenance checlist details, base on what you choose (ID)
        $edit=mysqli_query($conn,"UPDATE maintenance_checklist SET job_no='$e_job_no', engr='$e_engr', `date`='$e_date', equip_id='$e_id', equipment='$e_equipn', serial_no='$e_serial', equip_id_no='$e_equip_number', location='$e_location', m_schedule='$e_sched', status='$e_status', m_action='$e_action' WHERE m_id ='$m_id'");
        header('Location:maintenance_checklist.php');
        exit();
    }
      // if they click the button to delete  data
    else if (isset($_POST['delete'])) {

        $d_equip=mysqli_real_escape_string($conn,$_POST['d_id']);

        $delete=mysqli_query($conn,"DELETE FROM maintenance_checklist WHERE m_id='$d_equip' ");
        header('Location:maintenance_checklist.php');
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- Include Moment.js CDN -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
    <!--Custom styles-->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Preventive Maintenance</a>
<ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a class="nav-link" href="#">Sign out</a>
    </li>
</ul>
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
                <p id="header" class="text-center my-1">Equipment Maintenance Checklist</p>
            </header>
            <div id="person_data"></div>
                <!--ADD Modal Form-->
                <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white">Maintenance Checklist </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="controller.php" method="post">
                                <div id="add-modal-body" class="modal-body bg-white">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputJob">Job No. <span style="color:red">*</span></label>
                                            <input type="text" name="job_no" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEngineer">Assignee <span style="color:red">*</span></label>
                                            <select id="assignee" name="assignee" class="custom-select form-control"  >
                                                <option disabled selected>Choose...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDate">Last Date Performed <span style="color:red">*</span></label>
                                        <input type="date" name="last_date_performed" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                                        <select name="equipment_PK_id" id="select_parts" class="custom-select form-control"  >
                                            <option disabled selected>Choose...</option>
                                            <?php
                                                $get_equip=mysqli_query($conn,"SELECT * FROM equipment_reg");
                                                
                                                while ($row=mysqli_fetch_array($get_equip)) {
                                            ?>
                                                <option equipment_id="<?= $row['equipment'] ?>" value="<?php echo $row['equipment']; ?>"><?php echo $row['equipment']; ?></option> 
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3" >
                                        <labe>Equipment parts to be maintain</labe>
                                        <select name="equipment_parts_PK_id" id="equipment_parts" class="custom-select form-control"  >
                                            <!--<option>Choose...</option>-->
                                            <!--<option>Choose...</option>-->
                                        </select>
                                    </div>
                                    <div class="row mt-3" id="checklist" >
                                        <labe>Equipment parts checklist</labe><br><br> 
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDate">Type of activity <span style="color:red">*</span></label>
                                        <input type="text" name="type_of_activity" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDate">Description <span style="color:red">*</span></label>
                                        <textarea name="description" class="form-control" style="height:70px"></textarea>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputFrequency">Next Maintenance Schedule <span style="color:red">*</span></label>
                                            <input type="date" name="next_maintainance" class="form-control"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputFrequency">Frequency of Maintenance</label>
                                            <select id="inputFrequency" name="frequency" class="custom-select form-control"  >
                                                <option selected>Choose...</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Quarterly">Quarterly</option>
                                                <option value="Semi-Annual">Semi-Annual</option>
                                                <option value="Annual">Annual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAction">Remarks <span style="color:red">*</span></label>
                                        <textarea class="form-control" rows="5" name="remarks"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info shadow-none " name="save_maintainance">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--EDIT Modal Form-->
                <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="EditEquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="EditEquipmentDetails">Edit Maintenance Checklist</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="maintenance_checklist.php" method="post">
                                <div id="edit-modal-body" class="modal-body bg-white">
                                    <!-- ID of maintenance checklist to be edited, it's hidden  -->
                                    <input type="hidden" name="m_id" id="m_id">
                                    <!-- ID of maintenance equipment id to be edited, it's hidden  -->
                                    <input type="hidden" name="e_id" id="e_id">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputJob">Job No.</label>
                                            <input type="text" name="e_job" class="form-control" id="inputJob"  >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEngineer">Assignee</label>
                                            <input type="text" name="e_engr" class="form-control" id="inputEngineer"  >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDate">Date Performed</label>
                                        <input type="date" name="e_date" class="form-control" id="inputDate"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEquipment">Equipment</label>
                                        <input type="text" name="e_equipn" class="form-control" id="inputEquipment" readonly>
                                        
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputSerial">Serial #</label>
                                            <input  type="text" name="e_serial" class="form-control" id="inputSerial" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEquipmentID">Equipment ID No.</label>
                                            <input  type="text" name="e_equipno" class="form-control" id="inputEquipmentID" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputLocation">Location</label>
                                            <input type="text" name="e_location" class="form-control" id="inputLocation" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputFrequency">Maintenance Schedule</label>
                                            <input type="text" name="e_sched" class="form-control" id="inputFrequency" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStatus">Status</label>
                                            <select id="inputStatus" name="e_status" class="custom-select form-control"  >
                                                <option selected>Choose...</option>
                                                <option value="OK">OK</option>
                                                <option value="DEFECT">DEFECT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAction">Maintenance Action</label>
                                        <textarea class="form-control" name="e_action" rows="5" id="inputAction"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" name="edit" class="btn btn-info shadow-none" >Update</button>
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
                            <form action="maintenance_checklist.php" method="post">
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
                            <th>Job No.</th>
                            <th>Assignee</th>
                            <th>Equipment Name</th>
                            <th>Equipment Part Name</th>
                            <th>Maintenance Schedule</th>
                            <th>Status</th>
                            <th>Maintenance Action</th>
                            <th>Due Date Schedule</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--Display all Equipment-->
                    <?php
                        $get= mysqli_query($conn,"SELECT * FROM parts_maintainance 
                        INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id 
                        INNER JOIN equipment_reg ON parts_maintainance.equipment_PK_id = equipment_reg.equipment 
                        INNER JOIN ( SELECT DISTINCT parts_maintenance_history.PK_id FROM  parts_maintenance_history ) parts_maintenance_history ON parts_maintainance.parts_id = parts_maintenance_history.PK_id");

                        while($row=mysqli_fetch_array($get)) {
                    ?>
                    <tr>
                            <td><?php echo $row['job_no']; ?></td>
                            <td><?php echo $row['assignee']; ?></td>
                            <td style="display:none"><?php echo $row['last_date_performed']; ?></td>
                            <td><?php echo $row['equipment']; ?></td>
                            <td><?php echo $row['equipment_name']; ?></td>
                            <td><?php echo $row['frequency']; ?></td>
                            <?php 
                                if($row['part_status']=='OK') {
                            ?>
                                <td style='color:green; font-weight:500;'><?php echo $row['part_status']; ?></td>
                            <?php
                                }
                                else {
                            ?>
                                <td style='color:red; font-weight:500;'><?php echo $row['part_status']; ?></td>
                            <?php
                                }
                            ?>
                            <td><?php echo $row['parts_remarks']; ?></td>
                            <td><?= $row['next_maintainance'] ?></td>
                            <td>
                                <button type="button" id="update_maintenance_checklist" image_name="<?= $row['equipment_file'] ?>" maintenance_id="<?= $row['equipment_parts_id'] ?>" parts_id="<?= $row['parts_id'] ?>" part_name = "<?= $row['equipment_name'] ?>" job_no="<?= $row['job_no'] ?>" assignee="<?= $row['assignee'] ?>" parts_status="<?= $row['part_status'] ?>" frequency="<?= $row['frequency'] ?>" equipment_name="<?= $row['equipment_name'] ?>"  equipment="<?= $row['equipment'] ?>" last_date_performed="<?= $row['last_date_performed'] ?>"  class="btn edit btn-sm shadow-none" data-toggle="modal" data-target="#update_equipment" title="Edit"><i class="fas fa-eye"></i></button>
                                <button type="button" id="parts_history" equipment="<?= $row['equipment'] ?>"  parts_id="<?= $row['parts_id'] ?>"  data-toggle="modal" data-target="#maintenance_history "  class="btn edit btn-sm shadow-none" ><i class="fas fa-clipboard-list"></i></button>
                                <button type="button" class="btn delete btn-sm shadow-none" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                    </tr>
                    <!--DETAILS Modal-->
                    <div class="modal fade" id="details-<?php echo $row['m_id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="text-center mt-2 mb-3">Maintenance Checklist</h5>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Job No. : <?php echo $row['job_no']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Assignee : <?php echo $row['engr']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Date Performed : <?php echo $row['date']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Equipment : <?php echo $row['equipment']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Serial # : <?php echo $row['serial_no']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Equipment ID No. : <?php echo $row['equip_id_no']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <p>Location : <?php echo $row['location']; ?></p>
                                        </div>
                                        <div class="col-6">
                                        <p>Maintenance Schedule : <?php echo $row['m_schedule']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        <?php
                                            if($row['status']=='OK') {
                                        ?>
                                            <p>Status : <span style='color:green; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <p>Status : <span style='color:red; font-weight:500;'><?php echo $row['status']; ?></span></p>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                        <div class="col-6">
                                        <p>Maintenance Action : <?php echo $row['m_action']; ?></p>
                                        </div>
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

<!-- Modal -->
<form action="controller.php" method="POST">
    <div class="modal fade" id="update_equipment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header bg-info">
            <h5 class="modal-title" id="exampleModalLongTitle" style="color:#ffff">EDIT MAINTENANCE CHECKLIST</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <label>Parts image</label>
                <div class="col-md-6">
                    <img id="my_image"  style="width:170px" >
                </div>
              </div>
             <div class="row mt-3">
                <div class="col-md-6">
                    <label>Parts Name</label>
                    <input type="text" class="form-control" id="part_name" name="" readonly>
                    <input type="hidden" class="form-control" id="PK_id" name="PK_id">
                </div>
                <div class="col-md-6">
                    <label>Equipment Name</label>
                    <input type="text" class="form-control" id="equipment" name="history_equipment_name" readonly>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Job no.</label>
                    <input type="text" class="form-control" id="job_no" name="" readonly>
                </div>
                <div class="col-md-6">
                    <label>Assigned to</label>
                    <input type="text" class="form-control" id="assignee" name="" readonly>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Last Date Performed</label>
                    <input type="text" class="form-control" id="last_date_performed" name="" readonly>
                </div>
                <div class="col-md-6">
                    <label>Maintenance Frequency</label>
                    <input type="text" class="form-control" id="frequency" name="" readonly>
                </div>
            </div>
            <div class="row" id="check_list_container">
                    
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date_performed">
                </div>
                <div class="col-md-6">
                    <label>Status</label>
                    <select class="form-control" id="parts_status" name="parts_status">
                        <option value="OK">OK</option>
                        <option value="DEFECT">Defect</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Remarks</label>
                    <textarea class="form-control" name="parts_remarks" style="height:70px"></textarea>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="save_new_maintenance" class="btn btn-info shadow-none">Update</button>
          </div>
        </div>
      </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="maintenance_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLongTitle" style="color:#ffff">MAINTENANCE CHECKLIST HISTORY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="dt" class="table table-borderless table-striped table-hover" width="100%">
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Part Status</th>
                    <th>Performed Date</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="maintenance_history_table">
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#dt').DataTable({
            lengthMenu: [[7, 35, 50, -1], [7, 35, 50, "All"]]
        });
    });
</script>
<script>
    $(document).ready(function() {
        
        $(document).on('click', '[id*="update_maintenance_checklist"]', function() {
           var job_no = $(this).attr('job_no');
           var assignee = $(this).attr('assignee');
           var parts_status = $(this).attr('parts_status');
           var frequency = $(this).attr('frequency');
           var equipment_name = $(this).attr('equipment_name');
           var equipment = $(this).attr('equipment');
           var last_date_performed = $(this).attr('last_date_performed');
           var part_name = $(this).attr('part_name');
           var parts_id = $(this).attr('parts_id');
           var maintenance_id = $(this).attr('maintenance_id');
           
           $('#job_no').val(job_no);
           $('#assignee').val(assignee);
           $('#parts_status').val(parts_status);
           $('#frequency').val(frequency);
           $('#equipment_name').val(equipment_name);
           $('#equipment').val(equipment);
           $('#part_name').val(part_name);
           $('#last_date_performed').val(last_date_performed);
           $('#PK_id').val(parts_id);
           $("#parts_status option[value="+parts_status+"]").attr('selected','selected');
           
           var pic_name = $(this).attr('image_name')
           $('#my_image').attr('src','uploads/'+pic_name+'');
            
           var action = "get_checklist";
            $.get("controller.php", 
            {
                maintenance_id: maintenance_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                $('#check_list_container').html(data);
            });
        });
        
        $(document).on('click', '[id*="parts_history"]', function() {
        var equipment = $(this).attr('equipment');
        var parts_id = $(this).attr('parts_id');
        var action = "get_parts_history";
            $.get("controller.php", 
            {
                parts_id: parts_id,
                equipment:equipment,
                action:action
            },
            function(data){
                // Display the returned data in browser
                $('#maintenance_history_table').html(data);
                
            });
        });
    });
</script>
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

<script>
    $(document).ready(function(){
        var action = "ae1b3a66a4df526c79a788eaca7481095cfc04f5";
        // Send the input data to the server using get
        $.get("https://www.prpcompliance.com/View/New_Features/BGL_PPP_CULTIVATION/prpblaster_get_data.php", 
        {
            action:action
        },
        function(data){
            // Display the returned data in browser
            $("#assignee").html(data);
        }); 

       $(document).on('change','#select_parts',function(){
            var equipment_id = $('option:selected', this).attr('equipment_id');
            var action = "get_equipment_parts";
            $.get("controller.php", 
            {
                equipment_id: equipment_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                 $('#equipment_parts').html(data);
                // console.log('done : ' + data);
            });
        });
        
        $(document).on('change','#equipment_parts',function(){
            var parts_PK_id = $('option:selected', this).attr('parts_PK_id');
            var action = "get_parts_checklist";
            $.get("controller.php", 
            {
                parts_PK_id: parts_PK_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                 $('#checklist').html(data);
                // console.log('done : ' + data);
            });

        });
    });
</script>
</body>
</html>