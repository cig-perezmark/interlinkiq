<?php 
    $title = "";
    $site = "crisis_annual_review";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
</style>


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-body">
                                   
                                    <div class="row">
    				          	 			<div class="col-md-12" style="border:transparent;">
    				          	 			    <br>
    				          	 			    <button class="btn btn-primary noprint" style="float: right;margin-right:10px;" onclick="window.print();">Print</button>
    				          	 			    <br>
                                                <center >
                                                    <h4><b>CRISIS MANAGEMENT PLAN</b></h4>
                                                    <h4>Annual Review</h4>
                                                </center>
                                            </div>
                                            <center>
				          	 					<h5 style="padding: 2px;border: solid #ccc 1px;">The crisis management plan shall be reviewed, tested, and verified annually.</h5>
				          	 				</center>
				          	 				<center>
				          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-10px;">Crisis Management Infrastructure</h4>
				          	 				</center>
				          	 				<table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
					                              <tbody>
			                              		  <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '3'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
					                              </tbody>
					                          </table>
					                          <center>
				          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Information Handling</h4>
				          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
						                              <tbody>
						                          <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '6'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
						                              </tbody>
						                          </table>
						                           <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Crisis Communication</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
					                              <tbody>
					                                 <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '2'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
					                              </tbody>
					                          </table>
					                           <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Liaison</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
					                              <tbody>
					                                 <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '7'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
					                              </tbody>
					                          </table>
					                          <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Return to Normal Operations</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>
				                                  <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '9'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          </table>
				                              	<center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Training and Exercises</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>
				                                  <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '11'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          	</table>
				                              <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Evaluating and Updating the Crisis Management Plan</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>
				                                   <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '5'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          	</table>
				                              <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Map</h4>
					          	 				</center>
				                               <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>	
				                              	<?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '8'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          </table>
				                              <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Contact Lists</h4>
					          	 				</center>
				                           <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>	
				                              	<?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '1'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          </table>
				                          		<center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Special Plans (e.g., Contingency Plans, Evacuation Plans)</h4>
					          	 				</center>
				                          <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>	
				                              	<?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '10'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          </table>
				                         		 <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Critical Operations - To minimize damage from the emergency, the following personnel will be responsible for shutting down the listed operations.</h4>
					          	 				</center>
				                          <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>		
				                              	<?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT DISTINCT management_plan_area_category,management_plan_area_filled,management_plan_area_answer FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' and management_plan_area_category = '4'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area_filled']; ?>
    				                              		</td>
    				                              		<td width="50%">
    				                              			<?php echo $row['management_plan_area_answer']; ?>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
				                              </tbody>
				                          </table>
				                          <tbody>
				                            	    <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' LIMIT 1";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
				                          <h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Notes:<textarea class="form-control" name="Plan_Notes" readonly><?php echo $row['Plan_Notes']; ?></textarea> </h4>
				                          <center><h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-10px;">Action Items:<textarea class="form-control" name="Plan_Action_Items" readonly><?php echo $row['Plan_Action_Items']; ?></textarea> </h4></center>
				                          	<?php } ?>
                                        
                                    </div>
                                    <div class="row">

				                            <table class="table" style="border: transparent;">
				                            	<tbody>
				                            	    <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $view = $_GET['view'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_filled_form where Plan_code = '$view' LIMIT 1";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ 
                                                    $vdate= date_create($row['Verified_Date']);
                                                    $adate= date_create($row['Approved_Date']);
                                                    ?>
				                            		<tr>
				                            			<td>Verified by:</td>
				                            			<td width="30%" >
				                            				<?php echo $row['Verified_by']; ?>
				                            			</td>
				                            			<td>Approved by:</td>
				                            			<td width="30%" >
				                            				<?php echo $row['Approved_by']; ?>
				                            			</td>
				                            		</tr>
				                            		<tr>
				                            			<td>Date:</td>
				                            			<td width="30%" >
				                            				 <?php echo date_format($vdate,"Y/m/d"); ?>
				                            			</td>
				                            			<td>Date:</td>
				                            			<td width="30%" >
				                            				<?php echo date_format($adate,"Y/m/d"); ?>
				                            			</td>
				                            		</tr>
				                            		<?php } ?>
				                            	</tbody>
				                            </table>
				                          </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
 <!-- MODAL AREA-->
                    <div class="modal fade" id="modalNew"  tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">CRISIS MANAGEMENT PLAN</h4>
                                        </div>
                                    <div class="modal-body">
                                        <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                            <div class="mb-3 row">
                                              <label for="management_plan_category" class="col-md-3 form-label">Category</label>
                                              <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" id="addPrimaryNameField" name="addPrimaryNameField"> -->
                                               
                                                <select class="form-control" name="management_plan_category" id="management_plan_category" required>
                                                  <option value="">Select</option>
                                                  <option value="1">Contact Lists</option>
                                                  <option value="2">Critical Communication</option>
                                                  <option value="3">Crisis Management Infrastructure</option>
                                                  <option value="4">Critical Operations</option>
                                                  <option value="5">Evaluating and Updating the Crisis Management Plan</option>
                                                  <option value="6">Information Handling</option>
                                                  <option value="7">Liaison</option>
                                                  <option value="8">Map</option>
                                                  <option value="9">Return to Normal Operations</option>
                                                  <option value="10">Special Plans</option>
                                                  <option value="11">Training and Exercises</option>
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Management Plan</label>
                                              <div class="col-md-9">
                                                <input class="form-control" name="management_plan_area" id="management_plan_area">
                                              </div>
                                            </div>
                                            <br>
                                           
                                    </div>
                                    <div class="modal-footer">
                                             <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                              <button type="submit" class="btn btn-success" name="btnSave_management_plan_category">Save</button>
                                          </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        
                        
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <style type="text/css" media="print">
          header, header *{
        display: none; !important;
        }
        footer, footer *{
            display: none; !important;
        }
        .noprint, .noprint *{
            display: none; !important;
        }
        title, title *{
        	 display: none; !important;
        }
        .actions, .actions *{
            display: none; !important;
        }
        .caption, .caption *{
            display: none; !important;
        }
        .icon-users, .icon-users *{
            display: none; !important;
        }
    
     </style>
    </body>
</html>