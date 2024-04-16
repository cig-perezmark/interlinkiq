<?php 
    $title = "Environmental Monitoring Program";
    $site = "emp_main_development";
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
        FROM new_emp_equipment_frequency";
    
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
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Environmental Monitoring Program -  </span><a class="btn btn-primary" href="emp_bgl_zones" target="_blank">View Areas</a>
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
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-6" style="border-color: 1px solid black">
                                        <!-- BEGIN PORTLET -->
                                        <div class="portlet light  tasks-widget">
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <i class="icon-bar-chart theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Today's Action Items -</span><a href="https://interlinkiq.com/emp_bgl_filter.php" target="_blank">  <span class="task-title"> Inspection Schedules</span></a>
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
                                                $select_settings = "SELECT * FROM new_emp_equipment_frequency WHERE new_emp_equipment_frequency.equipment_id = 121";
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
                                                    <div class="scroller" style="height: 282px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                        <!-- START TASK LIST -->
                                                        <ul class="task-list">
                                                            <?php
                                                                $frequency_sql = "SELECT * FROM new_emp_equipment_frequency WHERE owner_id = $switch_user_id";
                                                                $frequency_result = mysqli_query($emp_connection,$frequency_sql);
                                                                foreach($frequency_result as $row):
                                                                    $area_sql = "SELECT * FROM equipment_reg INNER JOIN area_list ON area_list.enterprise_owner = equipment_reg.enterprise_owner WHERE equipment_reg.equip_id = {$row['equipment_id']}";
                                                                    $area_result = mysqli_query($pmp_connection,$area_sql);
                                                                    $area_assoc = mysqli_fetch_assoc($area_result);
                                                                    $badge = '';
                                                                    if($row['status'] == 'Inspected'){
                                                                        $badge = 'checked';
                                                                    }
                                                            ?>
                                                            <li>
                                                                <div class="task-checkbox">
                                                                    <input type="checkbox" class="liChild" value="" <?= $badge ?>/> </div>
                                                                <div class="task-title">
                                                                   <a href="https://interlinkiq.com/emp_bgl_filter_details.php?equip_id=<?= $area_assoc['equip_id'] ?>" target="_blank"><span class="task-title-sp"><?= $area_assoc['equipment'] ?></span></a>
                                                                </div>
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
                                <div class="col-md-6">
                                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:75px">
                                <div class="col-md-4">
                                    <label>Area</label>
                                    <select id="filter_zone" class="form-control">
                                        <option>-- Please select --</option>
                                        <?php
                                            $sql_zone = "SELECT * FROM area_list WHERE enterprise_owner = $switch_user_id";
                                            $result_zone = mysqli_query($pmp_connection, $sql_zone);
                                            foreach ($result_zone as $row_zone):
                                        ?>
                                            <option value="<?= $row_zone['area_name'] ?>"><?= $row_zone['area_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top:75px" id="row_content">
                                
                            </div>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->
	
<!-- Modal -->
<div class="modal fade" id="resultsModal" tabindex="-1" role="dialog" aria-labelledby="resultsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resultsModalLabel">Results Calendar</h5> 
        <div class="col-md-6">
            <label>Filter</label><br>
            <label class="control-label">Date Ranges</label>
            <div id="reportrange" class="btn default">
                <i class="fa fa-calendar"></i> &nbsp;
                <span> </span>
                <b class="fa fa-angle-down"></b>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Calendar Table -->
        <table class="table table-bordered" id="resultsTable">
          <thead>
            <tr>
              <th></th> <!-- Empty corner cell -->
              <th>November 17, 2023</th>
              <th>November 18, 2023</th>
              <th>November 19, 2023</th>
              <th>November 20, 2023</th>
              <th>November 21, 2023</th>
              <th>November 22, 2023</th>
              <th>November 23, 2023</th>
              <!-- Add more date columns as needed -->
            </tr>
          </thead>
          <tbody id="calendarBody">
            <tr>
              <th>Total Plate Count</th>
              <td style="color:red">2</td>
              <td style="color:red">3</td>
              <td style="color:red">1</td>
              <td style="color:red">1</td>
              <td style="color:red">1</td>
              <td></td>
              <td></td>
              <!-- Add more result columns as needed -->
            </tr>
            <tr>
              <th>E.Coli</th>
              <td >5</td>
              <td style="color:green">5</td>
              <td style="color:green">7</td>
              <td style="color:green">7</td>
              <td style="color:green">7</td>
              <td></td>
              <td></td>
              <!-- Add more result columns as needed -->
            </tr>
            <tr>
              <th>Salmonella</th>
              <td style="color:green">5</td>
              <td style="color:green">7</td>
              <td style="color:red">3</td>
              <td style="color:red">3</td>
              <td style="color:red">3</td>
              <td></td>
              <td></td>
              <!-- Add more result columns as needed -->
            </tr>
            <!-- Add more rows as needed -->
          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- Use your existing jQuery library -->
	<?php include('footer.php'); ?>
	<!-- BEGIN CORE PLUGINS -->
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
            <!-- END THEME LAYOUT SCRIPTS -->

<script>
    $(document).ready(function(){
        $('#filter_zone').on('change', function() {
            var area_name = $(this).val();
            $.ajax({
                url: 'controller.php', // Path to your PHP script
                type: 'POST',
                data: { 
                    action: "get_zones_bgl",
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

	<style>
	.canvasjs-chart-credit{
	    display:none !important;
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