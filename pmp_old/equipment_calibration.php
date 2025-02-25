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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
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
                <p id="header" class="text-center my-1">Equipment Calibration</p>
            </header>
                <!--ADD Modal Form-->
                <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-info">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="EquipmentDetails">Parts Details</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Code Here-->
                            <form action="controller.php" method="post" enctype="multipart/form-data">
                           
                                <div id="add-modal-body" class="modal-body bg-white">
                                    <div class="form-group">
                                        <label>Equipment ID <span style="color:red">*</span></label>
                                        <select class="form-control"  name="equipment_id_no" id="equipment_id" >
                                            <option >-- Please Select --</option>
                                            <?php
                                                $get= mysqli_query($conn,"SELECT * FROM equipment_reg");
                                                while($row=mysqli_fetch_array($get)) { ?>
                                                    <option equipment_id="<?= $row['equip_id_no'] ?>" value"<?= $row['equip_id'] ?>" ><?= $row['equip_id_no'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="display_data">
                                <!--    <div class="form-group">-->
                                <!--        <label for="inputEquipment">Equipment Description <span style="color:red">*</span></label>-->
                                <!--        <input type="text" name="" class="form-control"  >-->
                                <!--    </div>-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="inputEquipment">Equipment Manufacturer<span style="color:red">*</span></label>-->
                                <!--        <input type="text" name="" value="<?= $row['supplier'] ?>" class="form-control"  >-->
                                <!--    </div>-->
                                <!--    <div class="form-row">-->
                                <!--        <div class="form-group col-md-6">-->
                                <!--            <label for="inputSerial">Serial # <span style="color:red">*</span></label>-->
                                <!--            <input type="text" name="" class="form-control"  >-->
                                <!--        </div>-->
                                <!--        <div class="form-group col-md-6">-->
                                <!--            <label for="inputEquipmentID">Calibration Period <span style="color:red">*</span></label>-->
                                <!--            <input type="text" name="" class="form-control"  >-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="inputFrequency">Last Calibration Date <span style="color:red">*</span></label>-->
                                <!--        <input type="text" name="" class="form-control"  >-->
                                <!--    </div>-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="inputFrequency">Calibration Due Date<span style="color:red">*</span></label>-->
                                <!--        <input type="text" name="" class="form-control"  >-->
                                <!--    </div>-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="inputFrequency">Calibration Body/Organization<span style="color:red">*</span></label>-->
                                <!--        <input type="text" name="" class="form-control"  >-->
                                <!--    </div>-->
                                </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info shadow-none " name="save_equipment_calibration">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form action="controller.php" method="POST">
                <table id="dt" class="table table-borderless table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Equipment ID</th>
                            <th>Serial #</th>
                            <th>Calibration Period</th>
                            <th>Last Calibration Date</th>
                            <th>Calibration Due Date</th>
                            <th>Calibrating Body/Organization</th>
                            <th>Result</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--Display all Equipment-->
                    <?php
                        $get= mysqli_query($conn,"SELECT * FROM equipment_calibration INNER JOIN equipment_reg ON equipment_calibration.equipment_id_no = equipment_reg.equip_id_no 
                        WHERE equipment_calibration.PK_id = 0 AND equipment_calibration.status = 0
                        ");
                        
                        while($row=mysqli_fetch_array($get)) {
                    ?>
                    <tr>
                            <td><?= $row['equipment_id_no'] ?><input name="calibration_id[]" type="hidden" value="<?= $row['id'] ?>"></td>
                            <td><?= $row['serial_no'] ?></td>
                            <td><?= $row['calibration_period'] ?></td>
                            <td><?= $row['last_calibration_date'] ?></td>
                            <td><?= $row['calibration_due_date'] ?></td>
                            <td><?= $row['calibration_body_organization'] ?></td>
                            <td><?= $row['result'] ?></td>
                            <td>
                                <button type="button" class="btn edit btn-sm shadow-none" title="Edit"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn delete btn-sm shadow-none" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                    </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label>Verified By</label>
                        <input type="text" name="verified_by" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Performed By</label>
                        <input type="text" name="performed_by" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Verified Date</label>
                        <input type="date" name="verified_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Performed Date</label>
                        <input type="date" name="performed_date" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-info shadow-none mt-3 " name="submit_equipment_calibration">Submit</button>
            </div>
            </form>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>

<script>
    $(document).on('change','#equipment_id',function(){
            var equipment_id = $('option:selected', this).attr('equipment_id');
            var action = "get_equipment_calibration";
            $.get("controller.php", 
            {
                equipment_id: equipment_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                 $('#display_data').html(data);
                 //console.log('done : ' + data);
            });
        });
        
</script>
