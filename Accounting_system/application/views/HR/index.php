<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">List of Employees</h4>
						<?php if(isset($_SESSION['alert_message'])): ?>
						<div class="alert_message" style="width:70%;height:50px;background-color: rgba(50, 200, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;">
							<span style="padding:18px"><?= $_SESSION['alert_message'] ?></span>
							<?php  //unset success
					                    unset($_SESSION['alert_message']); ?>
						</div>
						<?php endif; ?>
						<!-- delete message -->
						<?php if(isset($_SESSION['alert_message1'])): ?>
						<div class="alert_message" style="width:70%;height:50px;background-color: rgba(100, 0, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;">
							<span style="padding:18px;color:#ffff"><?= $_SESSION['alert_message1'] ?></span>
							<?php  //unset success
					                    unset($_SESSION['alert_message1']); ?>
						</div>
						<?php endif; ?>
						
						<button class="btn btn-info" data-toggle="modal" data-target="#bd-example-modal-lg" style="position:absolute;right:4%">Add Employee</button>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
							
								<tr>
									<th class="table-plus datatable-nosort">Name</th>
									<th>Department</th>
									<th>Position</th>
									<th>Company Email</th>
									<th>Employee Level</th>
									<th>Date Hired</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($records as $row):
							?>
								<tr>
									<td class="table-plus"><?= $row->fullname ?></td>
									<td><?= $row->department ?> </td>
									<td><?= $row->position ?></td>
									<td><?= $row->company_email ?></td>
									<td><?= $row->employee_lvl ?></td>
									<td><?= $row->datehired ?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/employee_details/');?><?= $row->authentication ?><?="/"?><?= $row->payeeid ?>"><i class="dw dw-eye"></i> View</a>
												<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/delete_record/');?><?= $row->payeeid?>"><i class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								<?php
									endforeach;
								?>

							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>

            <!--- Modal start --->



            	<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Add Employee Details</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/savedata'); ?>">  
										<div class="modal-body">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<label>Name</label>
														<input type="text" class="form-control" name="name" placeholder="Enter Full Name">
													</div>
													<div class="col-md-4">
														<label>Address</label>
														<input type="text" class="form-control" name="address" placeholder="Enter Address">
													</div>
													<div class="col-md-4">
														<label>Phone:</label>
														<input type="text" class="form-control" name="phone" placeholder="Enter Phone">
													</div>
												</div>
												<div class="row mt-4">
													<div class="col-md-4">
														<label>Personal Email:</label>
														<input type="text" class="form-control" name="email" placeholder="Enter Personal Email">
													</div>
													<div class="col-md-4">
														<label>Company Email</label>
														<input type="text" class="form-control" name="company_email" placeholder="Enter Company Email">
													</div>
													<div class="col-md-4">
														<label>Status:</label>
														<select clas="form-control" name="statusid" style="width:100%;border-color:#d4d4d4;padding:10px">
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
												<div class="row mt-4">
													<div class="col-md-4">
														<label>Employee Position</label>
														<input type="text" class="form-control" name="position" placeholder="Enter Position">
													</div>
													<div class="col-md-4">
														<label>Date Hired</label>
														<input type="text" class="form-control date-picker" name="datehired" placeholder="Choose Date and time">
													</div>
													<div class="col-md-4">
														<label>Department:</label>
														<select clas="form-control" name="department" style="width:100%;border-color:#d4d4d4;padding:10px">
															<option>QMS</option>
															<option>HR</option>
															<option>IT</option>
															<option>ETRR</option>
															<option>Regulatory</option>
															<option>Sales</option>
														</select>
													</div>
												</div>
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
													<div class="col-md-4">
													</div>
													<div class="col-md-4">
														<label for="">Second Department</label>
														<select clas="form-control" name="secondary_department" style="width:100%;border-color:#d4d4d4;padding:10px">
															<option value="">None</option>
															<option value="QMS">QMS</option>
                                                            <option value="HR">HR</option>
                                                            <option value="IT">IT</option>
                                                            <option value="ETRR">ETRR</option>
                                                            <option value="Regulator">Regulator</option>
                                                            <option value="Sales">Sales</option>
														</select>
													</div>
												</div>
												<div class="row mt-5">
													<div class="col-md-12">
														<hr>
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
