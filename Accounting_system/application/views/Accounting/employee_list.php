<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Employee List </h4>
						<?php if(isset($_SESSION['alert_message'])): ?>
						<div class="alert_message" style="width:50%;height:50px;background-color: rgba(50, 200, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;">
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

						<!---<button class="btn btn-primary" onclick="reset_pay()" style="position:absolute;right:4%">Start Process</button>--->
						
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Id</th>
									<th class="table-plus datatable-nosort">Name</th>
									<th>Position</th>
									<th>Pay Rate</th>
									<th>Bank Name</th>
									<!---<th>Payment Status</th> --->
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							    if($pay_status):
								foreach($pay_status as $row):
							?>
								<tr>
									<td style="" id="payeeid"><?php echo $row->payeeid ?></td>
									<td class="table-plus" id="fullname"><?= $row->fullname ?></td>
									<td><?= $row->position ?></td>
									<td id="e_pay_rate">
                                        <?php
												if($row->pay_rate == 0 )
												{
													echo "<span class='badge badge-info'>Pay not set Pay</span>";
												}
												else
												{
													echo $row->pay_rate;
												}
											?>
                                    </td>
									<td><?php
										
											if($row->bankno == 0 )
												{
													echo "<span class='badge badge-info'>No records</span>";
												}
												else
												{
													echo $row->bankname;
												}

									?></td>
								
									
							
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/Accounting_employee_list_details/');?><?= $row->authentication ?><?="/"?><?= $row->payeeid ?>"><i class="dw dw-eye"></i> View/set</a>
						
										</div>
									</td>
								</tr>
								<?php
									endforeach;
									endif;
								?>

							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>


			

			<!--- Modal start --->



		<!---	<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<?php print_r($pays) ?>
											<h4 class="modal-title" id="myLargeModalLabel"></h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/process_pay'); ?>">  
									
										<div class="modal-body">
											<div class="container">
											<div class="row">
											<input type="text" class="form-control" id="e_id" name="payeeid"  placeholder="Enter Full Name">
													<div class="col-md-4">
														<label>Pay</label>
														<input type="text" class="form-control" id="e_pay" name="amount" placeholder="Enter Amount" readonly>
													</div>
													<div class="col-md-4">
														<label>Deduction/s</label>
														<input type="text" class="form-control" name="refno" placeholder="">
													</div>
													<div class="col-md-4">
														<label for="">Bank Name</label>
														<select clas="form-control" name="sourceid" style="width:100%;border-color:#d4d4d4;padding:10px">
														<?php foreach($pay_source as $row): ?>
														<option value="<?= $row->sourceid ?>"><?= $row->sourcename ?></option>	
														<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="row mt-4">
													<div class="col-md-4">
														<label>Pay</label>
														<input type="text" class="form-control" id="" name="amount"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label>Reference No.</label>
														<input type="text" class="form-control" name="refno" placeholder="Enter Reference">
													</div>
													<div class="col-md-4">
														<label for="">Bank Name</label>
														<select clas="form-control" name="sourceid" style="width:100%;border-color:#d4d4d4;padding:10px">
														<?php foreach($pay_source as $row): ?>
														<option value="<?= $row->sourceid ?>"><?= $row->sourcename ?></option>	
														<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="row mt-4">
													<div class="col-md-4">
														<label>Paid Date</label>
														<input type="date" class="form-control"  name="paiddate" placeholder="Choose Date and time">
													</div>
													<div class="col-md-4">
													
													</div>
													<div class="col-md-4"></div>
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
<!--- Modal end ---> -->



			<!--- Modal start --->



			<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Process Date</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/reset_date'); ?>">  
										<div class="modal-body">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<label>Start Date</label>
														<input type="date" class="form-control" id="" name="start_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label>Cutoff Date</label>
														<input type="date" class="form-control" name="cutoff_date" placeholder="Enter Reference">
													</div>
													<div class="col-md-4">
														
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
											<h4 class="modal-title" id="myLargeModalLabel">Employee Name - Unpdaid</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/reset_date'); ?>">  
										<div class="modal-body">
											<div class="container">
												<div class="row">
													<div class="col-md-5">
														<label>Notes</label>
														<textarea name="" class="form-control" id="" style="height:50px"></textarea>
													</div>
													<div class="col-md-4">
														
													</div>
													<div class="col-md-3">
														
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


<script>
function reset_pay() {
  let text = "Do you want to Start processing ?";
  if (confirm(text) == true) {
    

	window.location.href = "<?php echo site_url('Pages/reset_pay'); ?>"

  } else {
    text = "You canceled!";
  }
  
}
</script>
