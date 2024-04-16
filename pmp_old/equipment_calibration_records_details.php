<?php
    include 'connection/config.php';

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
            <div class="container-fluid mb-4">
            <header class="main-header">
                <p id="header" class="text-center my-1">Equipment Calibration</p>
            </header>
             
                <table id="dt" class="table table-borderless table-striped table-hover mt-5" width="100%">
                    <thead>
                        <tr>
                            <th>Equipment ID</th>
                            <th>Equipment Description</th>
                            <th>Serial #</th>
                            <th>Calibration Period</th>
                            <th>Last Calibration Date</th>
                            <th>Calibration Due Date</th>
                            <th>Calibrating Body/Organization</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--Display all Equipment-->
                    <?php
                        $id = $_GET['id'];
                        $get= mysqli_query($conn,"SELECT * FROM equipment_calibration INNER JOIN equipment_reg ON equipment_calibration.equipment_id_no = equipment_reg.equip_id_no 
                        WHERE equipment_calibration.PK_id = '$id'
                        ");
                        
                        while($row=mysqli_fetch_array($get)) {
                    ?>
                    <tr>
                            <td><?= $row['equipment_id_no'] ?><input name="calibration_id[]" type="hidden" value="<?= $row['id'] ?>"></td>
                            <td><?= $row['equipment_description'] ?></td>
                            <td><?= $row['serial_no'] ?></td>
                            <td><?= $row['calibration_period'] ?></td>
                            <td><?= $row['last_calibration_date'] ?></td>
                            <td><?= $row['calibration_due_date'] ?></td>
                            <td><?= $row['calibration_body_organization'] ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                <?php
                        $id = $_GET['id'];
                        $get= mysqli_query($conn,"SELECT * FROM equipment_calibration_review WHERE id = '$id'");
                        
                        while($row=mysqli_fetch_array($get)) {
                    ?>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label>Verified By</label>
                        <input type="text" name="verified_by" value="<?= $row['verified_by'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Performed By</label>
                        <input type="text" name="performed_by" value="<?= $row['performed_by'] ?>"  class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Verified Date</label>
                        <input type="date" name="verified_date"  value="<?= $row['verified_date'] ?>"class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Performed Date</label>
                        <input type="date" name="performed_date" value="<?= $row['performed_date'] ?>" class="form-control" readonly>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
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
