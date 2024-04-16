<?php 
    $title = "PRP Tracking";
    $site = "PRP Tracking";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    $base_url = "https://interlinkiq.com/";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
   
    
//     function fileExtension($file) {
//         $extension = pathinfo($file, PATHINFO_EXTENSION);
//         $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
//         $embed = '&embedded=true';
//         $type = 'iframe';
//     	if ($extension == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
// 		else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
// 		else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
// 		else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
// 		else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
// 		else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
// 		else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

// 		$output['src'] = $src;
// 	    $output['embed'] = $embed;
// 	    $output['type'] = $type;
// 	    $output['file_extension'] = $file_extension;
// 	    return $output;
//     }
?>
<style>
    .parentTbls{
      padding: 0px 10px;
    }
    .childTbls td {
        border:solid grey 1px;
      padding: 0px 10px;
    }
    .child-1{
        background-color:#3D8361;
        color:#fff;
        border:solid grey 1px;
        padding: 0px 10px;
    }
    .font-14{
        font-size:14px;
    }
    .paddId{
        padding: 0px 10px;
    }
    #loading
    {
     text-align:center; 
     background: url('loader.gif') no-repeat center; 
     height: 150px;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">PRP Tracking</span>
                                    </div>
                                    
                                    
                                    </div>
                                </div>
                                
                                <div class="container">
                                        	<table>
                                        		<thead>
                                        			<tr>
                                        				<th><div >PRP</div></th>
                                        				<th><div class="innerDiv">Performed</div></th>
                                        				<th><div class="innerDiv">Reviewed</div></th>
                                        				<th><div class="innerDiv">Deviation/NC</div></th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        		    <tr>
                                        				<td>Foreing Material Program Checklist</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                
                                        			</tr>
                                        		    <tr>
                                        				<td>Pre-Ops / Inspection-Retail</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        			
                                        			</tr>
                                        		    <tr>
                                        				<td>Pre-Ops / Inspection-Grinding</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        			
                                        			</tr>
                                        		    <tr>
                                        				<td>Pre-Ops / Inspection-Boning</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        		    <tr>
                                        				<td>Pre-Ops / Inspection-Packaging</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        		    <tr>
                                        				<td>Pre-Ops / Inspection-Kill Floor</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        		    <tr>
                                        				<td>Acetic Acid Mix Log</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        			
                                        			</tr>
                                        		    <tr>
                                        				<td>Lactic Acid Testing log</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        		
                                        			</tr>
                                        		    <tr>
                                        				<td>Thermometer Calibration</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Admin</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Baking/Cooking</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        			</tr>
                                        			<tr>
                                        				<td>Cooling/Chiling</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Facility</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Food Service</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>GMP</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Growing</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Harvesting</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Harvesting</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Harvesting</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Harvesting</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Internal Audit</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Maintenance</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Mixing/Blending</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        			
                                        			</tr>
                                        			<tr>
                                        				<td>Pre-Ops</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Production</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>PRP's</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Purchasing</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>QA/QC</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Receiving</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Retail</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Safety</td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        				<td></td>
                                        			
                                        			</tr>
                                        			<tr>
                                        				<td>Sanitation</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        		
                                        			</tr>
                                        			<tr>
                                        				<td>Testing</td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td class="completed-remark"><i class="fa fa-check-square-o checkmark" aria-hidden="true"></i></td>
                                        				<td></td>
                                        	
                                        			</tr>
                                        			<tr>
                                        				<td>Warehouse</td>
                                        				<td></td>
                                        				<td></td>
                                        				<td class="nc-remark"><i class="fa fa-exclamation-circle checkmark" aria-hidden="true"></i></td>
                                        	
                                        			</tr>
                                        			
                                        		</tbody>
                                        	</table>
                                        </div>
                                
                            </div>
                        </div>
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php');
        
        // jQuery.noConflict();
        ?>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
        <script src='//fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
        <script src='//fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
        <script src="//fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
        <script src='//fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
        <!--<script src="assets/apps/scripts/calendar.min.js" type="text/javascript"></script>-->
                
        <script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script type="text/javascript">
           
        </script>
    </body>
</html>

<style>
    html,
body {
	height: 100%;
}

.container {
	margin: 0;
	font-family: sans-serif;
	font-weight: 100;
	width:100%;
}


table {
	width: 80%;
	border-collapse: collapse;
	overflow: hidden;
	box-shadow: 0 0 20px rgba(0,0,0,0.1);
	margin:0 auto;
	margin-top:100px;
	margin-bottom:100px;
	
}

th,
td {
	padding: 15px;
	border:solid lightgray 1px;
}

th {
	text-align: left;
	border: solid lightgray 1px;
	height:200px;
}

thead {
	th {
		background-color: #55608f;
	}
}

tbody {
	tr {
		&:hover {
			background-color: rgba(255,255,255,0.3);
		}
	}
	td {
		position: relative;
		&:hover {
			&:before {
				content: "";
				position: absolute;
				left: 0;
				right: 0;
				top: -9999px;
				bottom: -9999px;
				background-color: rgba(255,255,255,0.2);
				z-index: -1;
			}
		}
	}
}

th>div {
  white-space:nowrap;
  margin: -1em -2em -1em 6em;/* tune this to your needs, you might also see & update  transform-origin */
  padding: 0;
  -webkit-writing-mode: vertical-lr;
  /* old Win safari */
  writing-mode: vertical-lr;
  writing-mode: tb-lr;
  transform: scale(-1, -1) rotate(45deg);
}
.checkmark{
    font-size:30px;
    color:white;
}
.completed-remark{
    background-color:#7FFF00;
    text-align:center;
}
.nc-remark{
    background-color:#FF7F50;
    text-align:center;
}

th:before {
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  transform: skew(-45deg);
  transform-origin: bottom left;
}
th {
  padding: 0;
  position: relative
}
</style>