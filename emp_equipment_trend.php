
<?php 
    $title = "Environmental Monitoring Program";
    $site = "emp_equipment_trend";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include "database.php";
    include_once ('header.php'); 
    
    
    $totalVisitors = 5;
     
    $newVsReturningVisitorsDataPoints = array(
    	array("y"=> 4, "name"=> "Completed Inspection", "color"=> "#0fd180"),
    	array("y"=> 1, "name"=> "To Be Inspected", "color"=> "#546BC1")
    );
    ini_set('display_errors', 1);
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
                        <span class="caption-subject font-dark bold uppercase">Environmental Monitoring Program - DOOR EXHAUST FAN</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <label>Filter</label><br>
                                        <label class="control-label">Date Ranges</label>
                                        <div id="reportrange" class="btn default">
                                            <i class="fa fa-calendar"></i> &nbsp;
                                            <span> </span>
                                            <b class="fa fa-angle-down"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top:15px">
                                        <select class="form-control" style="text-align:center">
                                            <option> -- All --</option>
                                            <option>Total Plate Count</option>
                                            <option>E.coli</option>
                                            <option>Lysteria</option>
                                            <option>Salmonella</option>
                                        </select>
                                    </div>
                                </div>
                                <!--<div class="col-md-8">-->
                                <!--    <div class="col-md-12">-->
                                <!--        <div id="chartContainer" style="height: 370px; width: 100%;"></div>-->
                                <!--    </div>-->
                                <!--    <div class="col-md-12" style="margin-top:25px">-->
                                <!--        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>-->
                                <!--    </div>-->
                                <!--    <div class="col-md-12" style="margin-top:25px">-->
                                <!--        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-md-8" id="result_chart">
                                    <?php
                                    $sql = "SELECT *
                                            FROM new_emp_records
                                            INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_records.parameter_id
                                            WHERE new_emp_records.equip_id = {$_GET['equip_id']} ";
                                            
                                    $result = mysqli_query($emp_connection, $sql);
                                    $dataPoints1 = array();
                                    while ($row = mysqli_fetch_assoc($result)):
                                        $sampled_date = $row['sampled_date'];
                                        $results = $row['result'];
                                        if (!$result) {
                                            $result = 0;
                                        }
                                        $parameter_id = $row['parameter_id'];
                                        $formatted_date = 'new Date(' . date('Y', strtotime($sampled_date)) . ',' . (date('m', strtotime($sampled_date)) - 1) . ',' . date('d', strtotime($sampled_date)) . ')';
                                        $dataPoints1[] = '{x:' . $formatted_date . ',y:' . $results . '}';
                                    ?>
                                        <div class="col-md-12 portlet light" style="margin-top:35px">
                                            <div class="portlet-title tabbable-line" id="chartContainer<?= $parameter_id ?>" style="height: 370px; width: 100%;"></div>
                                        </div>
                                        
                                        <script>
                                        
                                            var chart<?= $parameter_id ?> = new CanvasJS.Chart("chartContainer<?= $parameter_id ?>", {
                                            	animationEnabled: true,
                                            	title:{
                                            		text: "<?= $row['parameter_name'] ?>"
                                            	},
                                            	axisX: {
                                            		valueFormatString: "DD MMM,YY"
                                            	},
                                            	axisY: {
                                            		title: "Count",
                                            	},
                                            	legend:{
                                            		cursor: "pointer",
                                            		fontSize: 16,
                                            		itemclick: toggleDataSeries
                                            	},
                                            	toolTip:{
                                            		shared: true
                                            	},
                                            	data: [{
                                            		name: "Pass Result",
                                            		type: "spline",
                                            		yValueFormatString: "#0.##",
                                            		showInLegend: true,
                                            		indexLabel: "<?= $row['parameter_name'] ?>",
                                            		dataPoints: [<?php echo implode(',', $dataPoints1); ?>]
                                            	},
                                            	{
                                            		name: "Fail Result",
                                            		type: "spline",
                                            		yValueFormatString: "#0.##",
                                            		showInLegend: true,
                                            		indexLabel: "<?= $row['parameter_name'] ?>",
                                            		dataPoints: [
                                            			{ x: new Date(2023,11,01), y: 2 },
                                            			{ x: new Date(2023,11,02), y: 3 },
                                            			{ x: new Date(2023,11,03), y: 1 },
                                            		]
                                            	}]
                                            });
                                            chart<?= $parameter_id ?>.render();
                                            
                                            function toggleDataSeries(e){
                                            	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                            		e.dataSeries.visible = false;
                                            	}
                                            	else{
                                            		e.dataSeries.visible = true;
                                            	}
                                            	chart<?= $parameter_id ?>.render();
                                            }
                                        </script>
                                    <?php endwhile; ?>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->
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
    $(document).ready(function () {

        $('.ranges ul li').click(function() {
            // Get the text content of the clicked li element
            var clickedText = $(this).text();
            var equip_id = <?= $_GET['equip_id'] ?>;
            // Define variables for date calculations
            var currentDate = new Date();
            var startDate;
            
            // Handle different cases based on the clicked text
            switch (clickedText) {
                case 'Today':
                    startDate = currentDate;
                    break;
                case 'Yesterday':
                    currentDate.setDate(currentDate.getDate() - 1);
                    startDate = currentDate;
                    break;
                case 'Last 7 Days':
                    currentDate.setDate(currentDate.getDate() - 6);
                    startDate = currentDate;
                    break;
                case 'Last 30 Days':
                    currentDate.setDate(currentDate.getDate() - 29);
                    startDate = currentDate;
                    break;
                case 'This Month':
                    startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                    break;
                case 'Last Month':
                    startDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                    break;
                // Add more cases for other ranges if needed
                
                default:
                    // Handle other cases or do nothing
                    break;
            }
            // Get the date components
            var year = startDate.getFullYear();
            var month = ('0' + (startDate.getMonth() + 1)).slice(-2); // Months are zero-based
            var day = ('0' + startDate.getDate()).slice(-2);
            
            // Format the date as "YYYY-MM-DD"
            var formattedStartDate = year + '-' + month + '-' + day;
            
            
            $.ajax({
                url: 'controller.php', // Path to your PHP script
                type: 'POST',
                data: { 
                    action: "get_graphs",
                    startDate: formattedStartDate,
                    equip_id:equip_id
                },
                success: function(response) {
                    console.log(response);
                    $('#result_chart').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log("AJAX error: " + error);
                    console.log("Status: " + status);
                }
            });
        });
    
    });
    
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