<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="card-box mb-30">
                    <div class="pd-20" style="background-color:#4682b4;border-radius:10px;">
                        <h4 class="h4" style="color:#ffff"><?= $fullname ?></h4> 
                        <?php if(isset($_SESSION['alert_message'])): ?>
						<div class="alert_message" style="width:70%;height:50px;background-color: rgba(50, 200, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;margin-left:50px">
							<span style="padding:18px"><?= $_SESSION['alert_message'] ?></span>
							<?php  //unset success
					                    unset($_SESSION['alert_message']); ?>
						</div>
						<?php endif; ?>
                    </div>
                    <div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
						<div class="pd-20 card-box">
							<div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active text-blue" data-toggle="tab" href="#home" role="tab" aria-selected="true">Employee Information</a>
									</li>
									<li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Employee Details</a>
									</li>
								<!---	<li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#contact" role="tab" aria-selected="false">Deductions</a>
									</li> --->
                                    <li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#user_acc" role="tab" aria-selected="false">User Account</a>
									</li>
                                    <li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#user_records" role="tab" aria-selected="false">Employee records</a>
									</li>
								</ul>
								<div class="tab-content">

                            
									<div class="tab-pane fade show active" id="home" role="tabpanel">
										<div class="pd-20">
                                        <form autocomplete="off" method="post" action="<?php echo site_url('Pages/update_employee_hr/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?> "> 
                                           <div class="row">
                                     
                                                <div class="col-md-4">
                                                        <label>Name:</label>
                                                        <input type="text" class="form-control" value="<?= $fullname?>" name="fullname" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Address:</label>
                                                        <input type="text" class="form-control" value="<?= $Address?>" name="address" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Phone:</label>
                                                        <input type="text" class="form-control" value="<?= $phone?>" name="phone" >
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <label>Personal Email:</label>
                                                        <input type="text" class="form-control" value="<?= $email?>" name="email" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Company Email:</label>
                                                        <input type="text" class="form-control" value="<?= $company_email?>" name="company_email" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Status:</label>
														<select clas="form-control" name="statusid" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                        <option value="<?= $statusid ?>"><?= $status1 ?></option>
														<?php
															foreach($status as $row):
														?>
														<option value="<?= $row->statusid ?>"><?= $row->statusname ?></option>
														<?php
															endforeach;
														?>
														</select>
                                                    </div>                                                  
                                                </div>
                                                <input type="hidden" id="employee_lvl_value" value="<?= $users['employee_lvl'] ?>">
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <label>Employee Level:</label>
														<select clas="form-control" id="employee_lvl_dropdown" name="employee_lvl" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                            <option value="L1">L1</option>;
                                                            <option value="L2">L2</option>;
                                                            <option value="L3">L3</option>;
                                                            <option value="L4">L4</option>;
                                                            <option value="L5">L5</option>;
                                                            <option value="L6">L6</option>;
														</select>
                                                    </div>                                                  
                                                </div>
                                                
                                                  <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <label>Account Status:</label>
                                                        <?php if($active_status == 1): ?>
                                                        <label style="color:red" for="">Deactivated</label>
                                                        <?php endif; ?>
                                                        <?php if($active_status == 0): ?>
                                                        <label style="color:blue" for="">Active</label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                    </div>                                                  
                                                </div>

                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <input type="submit" class="btn btn-primary" name="update_employee_information" value="Update"/>
                                                          <?php if($active_status == 1): ?>
                                                            <a href="<?php echo site_url('Pages/update/payee/0'); ?><?= "/"?><?=$employee_id ?> " class="btn btn-primary">Activate</a>
                                                        <?php endif; ?>
                                                        <?php if($active_status == 0): ?>
                                                            <a href="<?php echo site_url('Pages/update/payee/1'); ?><?= "/"?><?=$employee_id ?> " class="btn btn-danger">Deactivate</a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                                </form>
                                            </div>
                                            
									</div>
                                    
									<div class="tab-pane fade" id="profile" role="tabpanel">
										<div>
										
                                        <form autocomplete="off" method="post" action="<?php echo site_url('Pages/update_employee_hr/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?> "> 
                                            <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <label>Date Hired:</label>
                                                        <input type="text" class="form-control date-picker" value="<?= $datehired?>" name="datehired" placeholder="Choose Date and time">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Effectivity Date: <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control date-picker" name="effectivity_date" value="<?= $effectivity_date ?>" placeholder="Choose Date and time">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Position:</label>
                                                        <input type="text" value="<?= $position?>" name="position" class="form-control">
                                                    </div>
                                            </div>
                                            <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <label>Department:</label>
                                                            <input type="text" value="<?= $department?>" name="department" class="form-control">
                                                        </div>
                                                          <div class="col-md-4">
                                                            <label>Secondary Department:</label>
                                                            <select clas="form-control" name="secondary_department" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                                <option value="<?= $secondary_department?>"><?= $secondary_department?></option>
                                                                <option value="QMS">QMS</option>
                                                                <option value="HR">HR</option>
                                                                <option value="IT">IT</option>
                                                                <option value="ETRR">ETRR</option>
                                                                <option value="Regulator">Regulator</option>
                                                                <option value="Sales">Sales</option>
														    </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Emergency Contact Number:</label>
                                                            <input type="number" value="<?= $emergency_contact_number?>" name="emergency_contact_number" class="form-control">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                        <label>Remarks</label>
                                                        <textarea name="" class="form-control"  style="height:70px"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                 <input style="margin-top:33px" type="submit" class="btn btn-primary" name="update_employee_details" value="Update"/>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4"></div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>
                                            </div>
                                            </form>
                                            <div class="row">
                                                <div class="col-md-4">
                                                <form autocomplete="off" method="post" action="<?php echo site_url('Pages/upadte_add_leave/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?>">  
                                                    <label for="">Total No. Of Leave:</label>
                                                    <input type="text" name="total_leave" class="form-control" name="" >
                                                </div>
                                                <div class="col-md-4">
                                                    <input style="margin-top:33px" type="submit" class="btn btn-primary" name="save" value="Add"/>
                                                </div>
                                                <div class="col-md-4"></div>
                                               
                                            </div>
                                            <div class="row mt-5">
                                                <?php if($total_leave): ?>
                                            <?php foreach($sum as $row): ?>
                                                <div class="col-md-6">
                                                    <label> Total leave taken: <span><?= $row->total_amount ?></span></label>
                                                </div>
                                                <?php endforeach; ?>
                                                <div class="col-md-6">
                                                <?php foreach($total_leave as $row): ?>
                                                    <input style="display:none" type="text" name="current_leave" value="<?= $row->total_leave ?>">
                                                    <label> Remaining Leave : <span><?= $row->total_leave ?></span></label>
                                                </div>
                                                </form>
                                                <?php endforeach; endif; ?>
                                            </div>
                                          
                                           	<!-- Simple Datatable start -->
				<div class="card-box mb-30" style="margin-top:50px">
					<div class="pd-20">
                   
						<h4 class="text-blue h4">Leave History</h4>
                        <!---<button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg2" style="display:flex;right:4%">Add Leave</button>--->
                        <?php if($leaves): ?>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Type of leave</th>
									<th>No. of leave</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Status</th>
								
								</tr>
							</thead>

							<tbody>
                               
                                    <?php foreach($leaves as $row): ?>
								<tr>
									<td class="table-plus"><?= $row['leave_type'] ?></td>
									<td><?= $row['leave_count'] ?></td>
									<td><?= $row['start_date'] ?></td>
									<td><?= $row['end_date'] ?></td>
                                    <td>
                                        <?php
										if($row['approve_status'] == '2')
										{
											echo "<span class='badge badge-success'>Approved</span>";
										}
                                        elseif($row['approve_status'] == "1")
                                        {
                                            echo "<span class='badge badge-primary'>For Approval</span>";
                                        }
                                        elseif($row['approve_status'] == "0")
                                        {
                                            echo "<span class='badge badge-secondary'>Pending</span>";
                                        }
                                        elseif($row['approve_status'] == "3")
                                        {
                                            echo "<span class='badge badge-danger'>For Cancel</span>";
                                        }
                                        elseif($row['approve_status'] == "4")
                                        {
                                            echo "<span class='badge badge-danger'>Canceled</span>";
                                        }
                                        else
                                        {
                                            echo "<span class='badge badge-danger'>Deny</span>"; 
                                        }

									
									    ?>
									</td>
								</tr>
                                <?php endforeach; ?>
                                <?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
										</div>
									</div>

                                    <div class="tab-pane fade" id="user_acc" role="tabpanel">
										<div class="pd-20">
                                        
                                        <form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_leave/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?> ">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight:600">User Details</label>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <label>Username:</label>
                                                        <input type="text" class="form-control" name="username" value="<?= $username?>" placeholder="Please enter username">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Password:</label>
                                                        <input type="password" value="<?= $password?>" name="password" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                          <label>User type:</label>
                                                 
                                                          <select clas="form-control" name="user_type_id" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                                <?php
                                                                    if($user_type == 1):
                                                                        {
                                                                            echo " <option>HR</option>";
                                                                        }
                                                                    elseif($user_type == 2):
                                                                        {
                                                                            echo " <option>Accounting</option>";
                                                                        }
                                                                    elseif($user_type == 3):
                                                                        {
                                                                            echo " <option>Accounting</option>";
                                                                        }
                                                                    elseif($user_type == 4):
                                                                        {
                                                                            echo " <option>Supervisor/Team Lead</option>";
                                                                        }
                                                                    else:
                                                                        {
                                                                            echo " <option>Select User Type</option>";
                                                                        }
                                                                
                                                                ?>
                                                                <?php endif;?>
                                                                <option value="1">HR</option>
                                                                <option value="2">Accounting</option>
                                                                <option value="3">Employee</option>
                                                                <option value="4">Manager</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <input type="submit" class="btn btn-primary" name="save_employee_user" value="Save"/>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                    </form>
                                            </div>
                                            
									</div>


                                    <div class="tab-pane fade" id="user_records" role="tabpanel">
										<div class="pd-20">
                                        

                                                <div class="row">
                                                    <div class="col-md-12" style="height:80px">
                                                        <button class="btn btn-info" data-toggle="modal" data-target="#bd-example-modal-lg4" style="display:flex;align-items:center;justify-content:center">Add Record</button>
                                                    </div>
                                                </div>

                                                    <table class="data-table table stripe hover nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Record Id</th>
                                                                <th class="table-plus datatable-nosort">Record name</th>
                                                                <th class="table-plus datatable-nosort">Record file</th>
                                                                <th class="datatable-nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if($employee_records_files): foreach($employee_records_files as $row): ?>                                                           
                                                            <tr>
                                                                <td style="" id="payeeid"><?= $row->id?></td>
                                                                <td class="table-plus"><?= $row->record_name?></td>  
                                                                <td class="table-plus"><a href="<?php echo site_url('Pages/download/');?><?= $row->record_file_name?>"><?= $row->record_file_name?></a></td>  
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                            <i class="dw dw-more"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                          <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> edit</a>                                                            
                                                                        </div>
                                                                    </div>
                                                                </td> 
                                                            </tr>
                                                            <?php endforeach;endif; ?>                                                   
                                                        </tbody>
                                                    </table>
                                                                                
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <input type="submit" class="btn btn-primary" name="save_employee_user" value="Save"/>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                            
									</div>

									
                </div>

            </div>
 </div>



			<!--- Modal start --->



			<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Add Deduction</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_deduction/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?> "> 
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Type of Deduction</label>
														<input type="text" class="form-control"  name="deduction_type"  placeholder="Enter type of deduction">
													</div>
													<div class="col-md-6">
														<label>Deduction Amount</label>
														<input type="number" class="form-control" name="deduction_amount" placeholder="Enter Amount">
													</div>
												</div>


												<div class="row mt-4">
													<div class="col-md-6">
														<label>Start Date</label>
														<input type="date" class="form-control"  name="start_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-6">
														<label>End Date</label>
														<input type="date" class="form-control" name="end_date" placeholder="Enter Reference">
													</div>
												</div>

                                                <div class="row mt-4">
													<div class="col-md-6">
														<label>Note</label>
														<textarea name="notes"  class="form-control" style="height:60px"></textarea>
													</div>
													
												</div>
											

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="save" value="Save Data"/>
										</div>
										</form> 
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->

        

		<!--- Modal start --->



        <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Add Leave</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_leave_details/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?>">  
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Type of leave</label>
														<input type="text" class="form-control"  name="leave_type"  placeholder="Enter type of leave">
													</div>
													<div class="col-md-6">
														<label>Leave Count</label>
														<input type="number" class="form-control" name="leave_count" placeholder="Enter Amount">
													</div>
												</div>


												<div class="row mt-4">
													<div class="col-md-6">
														<label>Start Date</label>
														<input type="date" class="form-control"  name="start_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-6">
														<label>End Date</label>
														<input type="date" class="form-control" name="end_date" placeholder="Enter Reference">
													</div>
												</div>

                                                <div class="row mt-4">
													<div class="col-md-6">
														
													</div>
													
												</div>
											

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="save" value="Save Data"/>
										</div>
										</form> 
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->

	<!--- Modal start --->



    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Add Record/File</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo site_url('Pages/update_employee_hr/'); ?><?=$employee_auth ?><?= "/"?><?=$employee_id ?> ">  
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Record Name:</label>
														<input type="text" class="form-control"  name="record_name"  placeholder="Enter record name">
													</div>
													<div class="col-md-6">
														<label>Record File:</label>
														<input type="file" class="form-control" name="record_file_name">
													</div>
												</div>											
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="save_records" value="Save Data"/>
										</div>
										</form> 
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->


<script>
    $(document).ready(function(){
        var employee_lvl_value = $("#employee_lvl_value").val();
        $("#employee_lvl_dropdown option[value="+employee_lvl_value+"]").attr('selected','selected');
    });
</script>
