<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">List of Employees Deactivated</h4>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
							
								<tr>
									<th class="table-plus datatable-nosort">Name</th>
									<th>Department</th>
									<th>Position</th>
									<th>Company Email</th>
									
									<th>Date Hired</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								if($records): foreach($records as $row):
							?>
								<tr>
									<td class="table-plus"><?= $row->fullname ?></td>
									<td><?= $row->department ?> </td>
									<td><?= $row->position ?></td>
									<td><?= $row->company_email ?></td>
									
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
									endforeach; endif;
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
															<option>IT</option>
														</select>
													</div>
												</div>
												<div class="row mt-4">
													<div class="col-md-4">
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
											<!---	<div class="row">
													<div class="col-md-4">
														<label>Effectivity Date</label>
														<input type="text" class="form-control date-picker" name="effectivity_date" placeholder="Choose Date and time">
													</div>
													<div class="col-md-4">
														<label>Payrate</label>
														<input type="text" class="form-control" name="pay_rate" placeholder="Enter Pay">
													</div>
													<div class="col-md-4">
													<label>Other Position</label>
														<select clas="form-control" name="other_position" style="width:100%;border-color:#d4d4d4;padding:10px">
															<option></option>
															<option>Supervisor</option>
															<option>Team Leader</option>
														</select> 
													</div>
												</div>
												
												<div class="row mt-5">
													<div class="col-md-12">
														<hr>
													</div>
												</div>
												<div class="row">
														<div class="col-md-12">
															<label style="font-weight:600">Bank Details</label>
														</div>
												</div>
												<div class="row mt-3">
													<div class="col-md-4">
														<label for="">Bank Name</label>
														<select clas="form-control" name="bankno" style="width:100%;border-color:#d4d4d4;padding:10px">
														<?php foreach($bank_name as $row): ?>
														<option value="<?= $row->bankno ?>"><?= $row->bankname ?></option>	
														<?php endforeach; ?>
														</select>
													</div>

													<div class="col-md-4">
														<label>Account Name</label>
														<input type="text" class="form-control" name="accountname" placeholder="Enter Account Name">
													</div>
													<div class="col-md-4">
														<label>Account Number</label>
														<input type="text" class="form-control" name="accountno" placeholder="Enter Account Number">
													</div>
												</div>
												<div class="row mt-2">
													<div class="col-md-4">
														<label>Remarks</label>
														<textarea class="form-control" name="notes" id="" style="height:50px"></textarea>
													</div>
													<div class="col-md-4"></div>
													<div class="col-md-4"></div>
												</div>--->
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
