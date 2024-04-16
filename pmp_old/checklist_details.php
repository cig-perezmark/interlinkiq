<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    include 'connection/config.php';
    // if they click the button to submit/add new data
    $get_id = $_GET['id'];
    $result = mysqli_query($conn,"SELECT * FROM parts_maintenance_history  
    INNER JOIN  parts_maintainance ON parts_maintenance_history.PK_id = parts_maintainance.parts_id
    INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id
    WHERE parts_maintenance_history.id='" . $_GET['id'] . "'
    ");
    $row= mysqli_fetch_array($result);
    
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

                </div>
            </div>
            <div class="container-fluid mb-4">
            <header class="main-header">
                <p id="header" class="text-center my-1">Equipment Maintenance Checklist Details</p>
            </header>
            <div id="person_data"></div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label>Parts Name</label>
                        <input type="text" class="form-control" value="<?= $row['equipment_name'] ?>" name="">
                    </div>
                    <div class="col-md-6">
                        <labe>Date Performed</labe>
                        <input type="text" class="form-control" value="<?= $row['date_performed'] ?>" name="">
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Equipment Name</label>
                        <input type="text" class="form-control" value="<?= $row['history_equipment_name'] ?>" name="">
                    </div>
                    <div class="col-md-6">
                        <labe>Parts Status</labe>
                        <input type="text" class="form-control" value="<?= $row['part_status'] ?>" name="">
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Remarks</label>
                        <textarea class="form-control" style="height:70px"><?= $row['parts_remarks'] ?></textarea>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Parts Checklist</label>
                <?php
                    $sql = "SELECT * FROM parts_maintenance_history  
                            INNER JOIN  parts_maintainance ON parts_maintenance_history.PK_id = parts_maintainance.parts_id
                            INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id
                            INNER JOIN parts_checklist ON equipment_parts.equipment_parts_id = parts_checklist.PK_id
                            WHERE parts_maintenance_history.id='" . $_GET['id'] . "'
                            " ; 
            		$result1 = mysqli_query ($conn, $sql);
                	while($row1 = mysqli_fetch_array($result1))
                	{
                	    $row_id = $row1['id'];
                	    $query = "SELECT * FROM parts_checked_list WHERE PK_id = '$get_id' AND checklist_PK_id = '$row_id' ";
                	    $query_result = mysqli_query ($conn, $query);
                	    $rows = mysqli_fetch_array($query_result);
                	    $checked_row_id = $rows['checklist_PK_id'];
                        if($checked_row_id == $row_id){
                            echo '
                        	   <div class="col-md-12">
                        	       <input type="checkbox" value="" checked> <label>'.$row1['checklist'].'</label>
                        	   </div>
                	        ';
                        }
                        else{
                            echo '
                        	   <div class="col-md-12">
                        	       <input type="checkbox" value=""> <label>'.$row1['checklist'].'</label>
                        	   </div>
                	        ';  
                        }
                	   
                	}
                
                ?>
                    </div>
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