<?php 
    $title = "Crisis Testing Verification";
    $site = "crisis_testing_verification";
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
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users font-dark noprint"></i>
                                        <span class="caption-subject font-dark bold uppercase">Crisis Testing And Verification</span>
                                    </div>
                                    <?php if($_COOKIE['ID'] == 185): ?>
                                    <div class="actions noprint">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" > Add New</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="portlet-body">
                                    <div class="portlet-title tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#plan" data-toggle="tab">Crisis Testing and Verification</a>
                                            </li>
                                            <li>
                                                <a href="#view" data-toggle="tab">View</a>
                                            </li>
                                        </ul>               
                                    </div>
                                    <div class="tab-content">
                					<div id="plan" class="tab-pane active">
                                    <div class="row">
                                       <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
    				          	 			<div class="col-md-12" style="border:transparent;">
    				          	 			    <br>
                                                <center >
                                                    <h4><b>CRISIS MANAGEMENT PLAN</b></h4>
                                                    <h4>Testing and Verification</h4>
                                                </center>
                                            </div>
                                            <center>
				          	 					<h5 style="padding:2px;border: solid #ccc 1px;">The crisis management plan shall be reviewed, tested, and verified annually. - Ref. 2.6.4.2<br><br>
				          	 					TAFTER • Organizational changes, the introduction of new processes or technologies, change of responsibilities, etc.
				          	 					• experiences gained during emergencies, actual crisis situations (also by others!) • New evolving threats • Exercises • 
				          	 					Your CM plan (as well as underlying emergency or contingency plans) should be evaluated and adjusted.</h5>
				          	 				</center>
				          	 				<center>
				          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-10px;">Crisis Incident</h4>
				          	 				</center>
				          	 				<table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
					                              <tbody>
			                              		  <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '3'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
    				                              		</td>
    				                              	</tr>
					                              	<?php } ?>
					                              </tbody>
					                          </table>
					                          <center>
				          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Crisis Management Infrastructure</h4>
				          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
						                              <tbody>
						                          <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '6'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>	
						                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '2'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
					                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '7'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>			
					                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '9'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>			
        			                              	<tr>
        				                              		<td>
        				                              		    <?php echo $row['management_plan_area']; ?>
        				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
        				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
        				                              		</td>
        				                              		<td width="50%">
        				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '11'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>			
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
    				                              		</td>
    				                              	</tr>
				                              	<?php } ?>
				                              </tbody>
				                          	</table>
				                              <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">After Action Report</h4>
					          	 				</center>
				                              <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>
				                                   <?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '5'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '8'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '1'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '10'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
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
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '4'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
    				                              		</td>
    				                              	</tr>
				                              	<?php } ?>
				                              </tbody>
				                          </table>
				                           <center>
					          	 					<h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">
					          	 					    Critical Operations - To minimize damage from the emergency, the following personnel will be responsible for shutting down the listed operations.
					          	 					  </h4>
					          	 				</center>
				                          <table class="table table-bordered" style="border: solid #ccc 1px;margin-top:-10px;">
				                              <tbody>		
				                              	<?php
                                                    $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $queries = "SELECT * FROM tbl_crisis_incidents_management_plan_form where management_plan_category = '4'";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ ?>		
    				                              	<tr>
    				                              		<td>
    				                              		    <?php echo $row['management_plan_area']; ?>
    				                              		    <input type="hidden" name="management_plan_area_filled[]" value="<?php echo htmlentities($row['management_plan_area'] ?? ''); ?>">
    				                              		    <input type="hidden" name="management_plan_area_category[]" value="<?php echo htmlentities($row['management_plan_category'] ?? ''); ?>">
    				                              		</td>
    				                              		<td width="50%">
    				                              			<textarea class="form-control" name="management_plan_area_answer[]" required></textarea>
    				                              		</td>
    				                              	</tr>
				                              	<?php } ?>
				                              </tbody>
				                          </table>
				                          <h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-20px;">Notes:<textarea class="form-control" name="Plan_Notes" ></textarea> </h4>
				                          <center><h4 style="padding: 5px;border: solid #ccc 1px;margin-top:-10px;">Action Items:<textarea class="form-control" name="Plan_Action_Items" required></textarea> </h4></center>
                                        
                                    </div>
                                    <div class="row">

				                            <table class="table" style="border: transparent;">
				                            	<tbody>
				                            		<tr>
				                            			<td>Verified by:</td>
				                            			<td width="30%" >
				                            				<input type="" name="Verified_by" style="border: transparent;border-bottom: solid #ccc 2px;width:100%;" required>
				                            			</td>
				                            			<td>Approved by:</td>
				                            			<td width="30%" >
				                            				<input type="" name="Approved_by" style="border: transparent;border-bottom: solid #ccc 2px;width:100%;" required>
				                            			</td>
				                            		</tr>
				                            		<tr>
				                            			<td>Date:</td>
				                            			<td width="30%" >
				                            				<input type="date" name="Verified_Date" style="border: transparent;border-bottom: solid #ccc 2px;width:100%;" required>
				                            			</td>
				                            			<td>Date:</td>
				                            			<td width="30%" >
				                            				<input type="date" name="Approved_Date" style="border: transparent;border-bottom: solid #ccc 2px;width:100%;" required>
				                            			</td>
				                            		</tr>
				                            	</tbody>
				                            </table>
				                          </div>
				                          
				                          <?php echo $FreeAccess == false ? '<button type="submit" class="btn btn-success" name="save_FilledForm">Save</button>':''; ?>
                                          </form>
                                        </div>
                                        <div id="view" class="tab-pane">
                                            <h3>CRISIS MANAGEMENT PLAN LIST</h3>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Topics</th>
                                                        <th>Verified by</th>
                                                        <th>Date</th>
                                                        <th>Approved by</th>
                                                        <th>Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                    $usersQuery = $_COOKIE['ID'];
                                                    $queries = "SELECT DISTINCT Plan_code,management_plan_filled,Verified_Date,Approved_Date,Approved_by,Verified_by FROM tbl_crisis_incidents_management_plan_filled_form where user_cookies = $usersQuery";
                                                    $resultQuery = mysqli_query($conn, $queries);
                                                     
                                                    while($row = mysqli_fetch_array($resultQuery)){ 
                                                    $vdate= date_create($row['Verified_Date']);
                                                    $adate= date_create($row['Approved_Date']);
                                                    ?>	
                                                        <tr>
                                                            <td>
                                                                <?php echo $i++; ?>
                                                            </td>
                                                            <td>CRISIS MANAGEMENT PLAN</td>
                                                             <td><?php echo htmlentities($row['Verified_by'] ?? ''); ?></td>
                                                            <td>
                                                                <?php echo date_format($vdate,"Y/m/d"); ?>
                                                            </td>
                                                            <td><?php echo htmlentities($row['Approved_by'] ?? ''); ?></td>
                                                            <td>
                                                                <?php echo date_format($adate,"Y/m/d"); ?>
                                                            </td>
                                                            <td><a href="crisis_annual_review_print.php?view=<?php echo htmlentities($row['Plan_code'] ?? ''); ?>" class="btn blue btn-outline">View</a></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </tbody>
                                            </table>
                                        </div>
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
                                                  <option value="2">Crisis Communication</option>
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
        <script type="text/javascript">
          
        </script>
    </body>
</html>
