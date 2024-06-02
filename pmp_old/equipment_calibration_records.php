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
                <p id="header" class="text-center my-1">Equipment Calibration Records</p>
            </header>
                
                <table id="dt" class="table table-borderless table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Verified By</th>
                            <th>Verified Date</th>
                            <th>Performed By</th>
                            <th>Performed Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--Display all Equipment-->
                    <?php
                        $get= mysqli_query($conn,"SELECT * FROM equipment_calibration_review ");
                        
                        while($row=mysqli_fetch_array($get)) {
                    ?>
                    <tr>
                            <td><?= $row['verified_by'] ?><input name="calibration_id[]" type="hidden" value="<?= $row['id'] ?>"></td>
                            <td><?= $row['verified_date'] ?></td>
                            <td><?= $row['performed_by'] ?></td>
                            <td><?= $row['performed_date'] ?></td>
                            <td>
                                <a class="btn edit btn-sm shadow-none" href="equipment_calibration_records_details.php?id=<?= $row['id'] ?>"><i class="fas fa-eye"></i></a>
                                <button type="button" class="btn delete btn-sm shadow-none" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                    </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                
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
