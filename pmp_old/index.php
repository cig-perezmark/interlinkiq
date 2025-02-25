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
        </div>
        <!--Main-->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-3">
            <div class="row text-center mx-5 mt-1">
                <div class="col-sm-4 mt-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">
                            <i class="fas fa-exclamation"></i>
                            <h6>Maintenance Requests</h6>
                        </div>
                        <div class="card-body">
                            <!--Code Here-->
                            <h3>0</h3>
                            <a class="btn text-white shadow-none" href="#"><h6><i class="fas fa-sync"></i>check information</h6></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">
                            <i class="fas fa-clipboard-check"></i>
                            <h6>Equipments Maintained</h6>
                        </div>
                        <div class="card-body">
                            <!--Code Here-->
                            <h3>0</h3>
                            <a class="btn text-white shadow-none" href="#"><h6><i class="fas fa-sync"></i>check information</h6></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">
                            <i class="fas fa-clipboard-list"></i>
                            <h6>Equipments Total</h6>
                        </div>
                        <div class="card-body">
                            <!--Code Here-->
                            <?php
                            //to count all equipment in equipment_reg table
                            $count=mysqli_query($conn,"SELECT COUNT(*) c FROM equipment_reg");
                            $row=mysqli_fetch_array($count);
                            ?>
                            <h3><?php /*display it*/ echo $row['c'] ?></h3>
                            <a class="btn text-white shadow-none" href="#"><h6><i class="fas fa-sync"></i>check information</h6></a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dt').DataTable();
    } );
</script>
</body>
</html>
