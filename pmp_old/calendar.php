<?php
    include 'connection/config.php';
    // if they click the button to submit/add new data

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preventive Maintenance</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
    <script src="//code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    

    <!--Custom styles-->
    <link rel="stylesheet" href="dashboard.css">
    
    <script>
    $(document).ready(function(){
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:'fetch-event.php',
            editable:true,
            eventDrop:function(event){
                // alert(event.title + " was dropped on " + event.start.toISOString());

                var start = event.start.toISOString();
                var end = event.end.toISOString();
                var title = event.title;
                var equipment_parts_PK_id = event.equipment_parts_PK_id;
                var id = event.id;
                $.ajax({
                    url:"update.php",
                    type:"POST",
                    data:{
                        title:title,
                        start:start,
                        end:end,
                        equipment_parts_PK_id:equipment_parts_PK_id,
                        id:id
                    },
                    success:function(data){
                        calendar.fullCalendar('refetchEvents');
                         console.log('done : ' + data);
                    }
                });
            }
        });
    });
    </script>
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
                <p id="header" class="text-center my-1">Equipment Parts Maintenance Schedule</p>
            </header>
                <!--ADD Modal Form-->
                <div class="container">
                    <div id="calendar">
                        
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>


<script src='//fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='//fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="//fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='//fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

</body>
</html>
