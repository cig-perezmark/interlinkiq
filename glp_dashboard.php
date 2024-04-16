<?php 
    $title = "Good Laboratory Practices Management";
    $site = "glp_dasboard";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include "database.php";
    include_once ('header.php'); 
    
    
    
    $sql_count = "SELECT
            COUNT(*) as total_count,
            COUNT(CASE WHEN status = 'Inspected' THEN 1 END) as inspected_count,
            COUNT(CASE WHEN status = 'To be Inspected' THEN 1 END) as to_be_inspected_count
        FROM new_emp_equipment_frequency_glp WHERE owner_id = $switch_user_id";
    
    $result = $emp_connection->query($sql_count);
    if ($result->num_rows > 0) {
        // Fetch the result as an associative array
        $row = $result->fetch_assoc();
        // Access the counts
        $totalVisitors = $row['total_count'];
        $inspectedCount = $row['inspected_count'];
        $toBeInspectedCount = $row['to_be_inspected_count'];

        $newVsReturningVisitorsDataPoints = array(
        	array("y"=> $inspectedCount, "name"=> "Completed Inspection", "color"=> "#0fd180"),
        	array("y"=> $toBeInspectedCount, "name"=> "To Be Inspected", "color"=> "#546BC1")
        );
    } else {
        echo "No results found";
    }
?>
<style>
    table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
</style>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom:20px;display:flex;justify-content:flex-end">
                            <div>
                                <a href="glp_zone" target="_blank" class="btn btn-primary">List of Areas</a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="https://interlinkiq.com/glp_filter.php" target="_blank"><i class="icon-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <!-- BEGIN PORTLET -->
                                        <div class="portlet light  tasks-widget">
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <i class="icon-bar-chart theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Today's Action Items -</span></a>
                                                </div>
                                                <div class="inputs">
                                                    <div class="portlet-input input-small input-inline">
                                                        <div class="input-icon right">
                                                            <i class="icon-magnifier"></i>
                                                            <input type="text" class="form-control form-control-solid" placeholder="search..."> </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                $select_settings = "SELECT * FROM new_emp_equipment_frequency_glp";
                                                $registered_result = mysqli_query($emp_connection, $select_settings);
                                                $row = mysqli_fetch_assoc($registered_result);
                                                if($row['frequency']){
                                                    $badge = '';
                                                    if($row['status'] == 'Inspected'){
                                                        $badge = 'checked';
                                                    }
                                                }
                                            ?>
                                            <div class="portlet-body">
                                                <div class="task-content">
                                                    <div class="scroller" style="height: 130px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                        <!-- START TASK LIST -->
                                                        <ul class="task-list">
                                                            <?php
                                                                // Get the default timezone set in PHP configuration
                                                                $timezone = date_default_timezone_get();
                                                                
                                                                // Create a DateTime object with the current date and time in the default timezone
                                                                $currentDateTime = new DateTime('now', new DateTimeZone($timezone));
                                                                
                                                                $currentDayName = $currentDateTime->format('N');
                                                                
                                                                $frequency_sql = "SELECT * FROM new_emp_equipment_frequency_glp WHERE owner_id = $switch_user_id AND day_of_the_week = $currentDayName AND frequency = 'Weekly' OR frequency = 'Daily' AND owner_id = $switch_user_id;";
                                                                $frequency_result = mysqli_query($emp_connection,$frequency_sql);
                                                                foreach($frequency_result as $row):
                                                                    $area_sql = "SELECT * FROM equipment_reg_glp INNER JOIN area_list_glp ON area_list_glp.enterprise_owner = equipment_reg_glp.enterprise_owner WHERE equipment_reg_glp.equip_id = {$row['equipment_id']}";
                                                                    $area_result = mysqli_query($pmp_connection,$area_sql);
                                                                    $area_assoc = mysqli_fetch_assoc($area_result);
                                                                    $badge = '';
                                                                    if($row['status'] == 'Inspected'){
                                                                        $badge = 'checked';
                                                                    }
                                                            ?>
                                                            <li>
                                                                <?php
                                                                    if(isset($area_assoc['equipment'])):
                                                                ?>
                                                                <div class="task-checkbox">
                                                                    <input type="checkbox" class="liChild" value="" <?= $badge ?>/> </div>
                                                                <div class="task-title">
                                                                   <a href="https://interlinkiq.com/emp_filter_details.php?equip_id=<?= $area_assoc['equip_id'] ?>" target="_blank"><span class="task-title-sp"><?= $area_assoc['equipment'] ?></span></a>
                                                                </div>
                                                                <?php
                                                                    endif;
                                                                ?>
                                                                <div class="task-config">
                                                                    <div class="task-config-btn btn-group">
                                                                        <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                            <i class="fa fa-cog"></i>
                                                                            <i class="fa fa-angle-down"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu pull-right">
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <i class="fa fa-check"></i> Complete </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <i class="fa fa-pencil"></i> Edit </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <i class="fa fa-trash-o"></i> Cancel </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <!-- END START TASK LIST -->
                                                    </div>
                                                </div>
                                                <div class="task-footer">
                                                    <div class="btn-arrow-link pull-right">
                                                        <a href="javascript:;">See All Tasks</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END PORTLET -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <div id="chartContainer" style="height: 275px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTEsT BODY -->
                    <div class="row">
                        <div class="col-md-3">
                            <label>Area</label>
                            <select id="filter_zone" class="form-control">
                                <?php
                                    $sql_zone = "SELECT * FROM area_list_glp WHERE enterprise_owner = $switch_user_id";
                                    $result_zone = mysqli_query($pmp_connection, $sql_zone);
                                    $first_area_name = null;
                                    foreach ($result_zone as $row_zone):
                                        if ($first_area_name === null) {
                                            $first_area_name = $row_zone['area_name'];
                                        }
                                ?>
                                    <option value="<?= $row_zone['area_name'] ?>"><?= $row_zone['area_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px" id="row_content">
                        <?php
                        $select_registered = "SELECT * FROM equipment_reg_glp WHERE location = '$first_area_name' AND enterprise_owner = $switch_user_id AND deleted != 1";
                        $result = mysqli_query($pmp_connection, $select_registered);
                        
                        if ($result) {
                            foreach ($result as $row):
                                $equipmentId = $row['equip_id'];
                                $chartContainerId = 'chartContainer_' . $equipmentId; // Unique ID for each chart container
                        ?>
                        <div class="col-md-4">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                                    <div class="col-md-12">
                                                        <!-- BEGIN REGIONAL STATS PORTLET-->
                                                        <div class="portlet light ">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="icon-share font-dark hide"></i>
                                                                    <span class="caption-subject font-dark bold uppercase"><?= $row['equipment'] ?></span>
                                                                </div>
                                                                <div class="actions">
                                                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;"><i class="icon-cloud-upload"></i></a>
                                                                    <a class="btn btn-circle btn-icon-only btn-default" onclick="get_report(<?php echo $equipmentId; ?>)" class="icon-calendar"></i></a>
                                                                    <a class="btn btn-circle btn-icon-only btn-default" href="#" target="_blank"><i class="fa fa-arrows-v"></i></a>
                                                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">
                                                                <div id="<?= $chartContainerId ?>" style="height: 370px; width: 100%;"></div>
                                                            </div>
                                                        </div>
                                                        <!-- END REGIONAL STATS PORTLET-->
                                                    </div>
                                            
                                                    <script>
                                                        var dataPoints<?= $equipmentId ?> = [];
                                            
                                                        <?php
                                                        // Fetch data from new_emp_records
                                                       $records_query = "SELECT parameter_name, n.id, n.parameter_id, n.result AS result FROM new_emp_records n INNER JOIN ( SELECT parameter_id, MAX(id) AS max_id FROM new_emp_records WHERE equip_id = $equipmentId GROUP BY parameter_id ) max_ids ON n.parameter_id = max_ids.parameter_id AND n.id = max_ids.max_id INNER JOIN new_emp_parameters ON new_emp_parameters.id = n.parameter_id; ";
                                            
                                                        $records_result = mysqli_query($emp_connection, $records_query);
                                                        foreach ($records_result as $record) {
                                                            $parameter_name = $record['parameter_name'];
                                                            $result = $record['result'];
                                                            if (!$result) {
                                                                $result = 0;
                                                            }
                                                            // Append data to the dataPoints array
                                                        ?>
                                                            dataPoints<?= $equipmentId ?>.push({ label: "<?= $parameter_name ?>", y: <?= $result ?> });
                                                        <?php
                                                        }
                                                        ?>
                                            
                                                        var chart<?= $equipmentId ?> = new CanvasJS.Chart("<?= $chartContainerId ?>", {
                                                            animationEnabled: true,
                                                            exportEnabled: true,
                                                            theme: "light1",
                                                            title: {
                                                                text: "Latest Inspection Results"
                                                            },
                                                            axisY: {
                                                                includeZero: true
                                                            },
                                                            data: [{
                                                                type: "column",
                                                                indexLabelFontColor: "#5A5757",
                                                                indexLabelPlacement: "outside",
                                                                dataPoints: dataPoints<?= $equipmentId ?>
                                                            }]
                                                        });
                                            
                                                        chart<?= $equipmentId ?>.render();
                                                    </script>
                                            
                                        </di>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            endforeach;
                        }
                        ?>
                    </div>

        <?php include_once ('footer.php'); ?>

<!-- Modal -->
<div class="modal fade" id="modal_report" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Table Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="reporting_table">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

            <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/moment.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
            <script src="assets//global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="//www.google.com/jsapi" type="text/javascript"></script>
            <script src="assets//pages/scripts/charts-google.min.js" type="text/javascript"></script>
            <script src="assets//pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
            <script src="assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
            <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

<script>
    function get_report(id){

        $.ajax({
           url: 'controller.php',
           type: 'POST',
           data:{
               action: "get_report",
               equipment_id: id
           },
           success: function(response){
               $('#reporting_table').html(response);
                // Show the Bootstrap modal
                $('#modal_report').modal('show');
           }
        });
    }
    $(document).ready(function(){
        $('#filter_zone').on('change', function() {
            var area_name = $(this).val();
            $.ajax({
                url: 'controller.php', // Path to your PHP script
                type: 'POST',
                data: { 
                    action: "get_zones_glp",
                    area_name: area_name 
                },
                success: function(response) {
                    console.log(response);
                    $('#row_content').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log("AJAX error: " + error);
                    console.log("Status: " + status);
                }
            });
        }); 
    });
    
    window.onload = function () {
     
    var totalVisitors = <?php echo $totalVisitors ?>;
    var visitorsData = {
    	"New vs Returning Visitors": [{
    		click: visitorsChartDrilldownHandler,
    		cursor: "pointer",
    		explodeOnClick: false,
    		innerRadius: "75%",
    		legendMarkerType: "square",
    		name: "New vs Returning Visitors",
    		radius: "100%",
    		showInLegend: true,
    		startAngle: 90,
    		type: "doughnut",
    		dataPoints: <?php echo json_encode($newVsReturningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
    	}],
    };
     
    var newVSReturningVisitorsOptions = {
    	animationEnabled: true,
    	theme: "light2",
    	title: {
    		text: "Today's Completion"
    	},
    	legend: {
    		fontFamily: "calibri",
    		fontSize: 14,
    		itemTextFormatter: function (e) {
    			return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";  
    		}
    	},
    	data: []
    };
     
    var visitorsDrilldownedChartOptions = {
    	animationEnabled: true,
    	theme: "light2",
    	axisX: {
    		labelFontColor: "#717171",
    		lineColor: "#a2a2a2",
    		tickColor: "#a2a2a2"
    	},
    	axisY: {
    		gridThickness: 0,
    		includeZero: false,
    		labelFontColor: "#717171",
    		lineColor: "#a2a2a2",
    		tickColor: "#a2a2a2",
    		lineThickness: 1
    	},
    	data: []
    };
     
    var chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
    chart.options.data = visitorsData["New vs Returning Visitors"];
    chart.render();
     
    function visitorsChartDrilldownHandler(e) {
    	chart = new CanvasJS.Chart("chartContainer", visitorsDrilldownedChartOptions);
    	chart.options.data = visitorsData[e.dataPoint.name];
    	chart.options.title = { text: e.dataPoint.name }
    	chart.render();
    	$("#backButton").toggleClass("invisible");
    }
     
    $("#backButton").click(function() { 
    	$(this).toggleClass("invisible");
    	chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
    	chart.options.data = visitorsData["New vs Returning Visitors"];
    	chart.render();
    });
     
    }
    
    var dataPoints = [
        { label: "TPC", y: -10 },
        { label: "E.coli", y: 35},
        { label: "Lysteria", y: 50 },
        { label: "Salmonella", y: 45 },
        { label: "Enterobacteriaceae", y: 45 },
        { label: "Aerobic Plate Count", y: 90 },
        { label: "ATP", y: 0 }
        // Add more data points with labels and values
    ];

    var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Latest Inspection Results"
        },
        axisY: {
            includeZero: true
        },
        data: [
            {
                type: "column",
                indexLabelFontColor: "#5A5757",
                indexLabelPlacement: "outside",
                dataPoints: dataPoints
            }
            // Add more data series with labels and data points as needed
        ]
    });

    chart1.render();
    
    var chart3 = new CanvasJS.Chart("chartContainer3", {
    	animationEnabled: true,
    	title: {
    		text: "Total Plate Count"
    	},
    	axisX: {
    		title: "Date",
    		valueFormatString: "DD MMM" // Format the date
    	},
    // 	axisY: {
    // 		title: "Response Time (in ms)"
    // 	},
    	legend: {
    		cursor: "pointer",
    		itemclick: toggleDataSeries
    	},
    	data: [
    		{
    			type: "scatter",
    			toolTipContent: "<span style='color:#4F81BC'><b>{name}</b></span><br/><b> Date:</b> {label}<br/>{y} TPC",
    			name: "Pass",
    			markerType: "square",
    			showInLegend: true,
    			dataPoints: [
    			    { label: "28 Sep", y: 100 },
    			    { label: "29 Sep", y: 80 },
    			    { label: "30 Sep", y: 70 },
    			    { label: "31 Sep", y: 60 },
    				{ label: "01 Oct", y: 100 },
    				{ label: "02 Oct", y: 90 },
    				// Add more data points with labels and values
    			]
    		},
    		{
    			type: "scatter",
    			name: "Fail",
    			markerType: "triangle",
    			showInLegend: true,
    			toolTipContent: "<span style='color:#C0504E'><b>{name}</b></span><br/><b> Date:</b> {label}<br/> {y} ms",
    			dataPoints: [
    			    { label: "29 Sep", y: 0},
    			    { label: "30 Sep", y: 30 },
    			    { label: "31 Sep", y: 0 },
    				{ label: "01 Oct", y: 0 },
    				{ label: "02 Oct", y: 40 },
    				// Add more data points with labels and values
    			]
    		}
    	]
    });
    
    chart3.render();
    
    function toggleDataSeries(e) {
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	} else {
    		e.dataSeries.visible = true;
    	}
    	chart3.render();
    }
</script>
    </body>
</html>