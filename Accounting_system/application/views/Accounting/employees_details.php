<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
			<?php
			    $employee_id = $this->uri->segment('3');
			    $account_number = '';
			    $paye_rate = ' ';
			    $freelance_pay_rate = 0;
			    $account_name = '';
			    $bankno = '';
			    $employee_details_message= '<span class="badge badge-danger" style="margin-bottom:20px">No accounting employee details found !</span>';
			    $payee = $this->User_model->select_where('*', 'payee', array('payeeid' => $this->uri->segment('3')));
			    $payee_details = $this->User_model->select_where('*', 'employee_details', array('payeeid' => $this->uri->segment('3')));
			    if($payee_details){
			        $paye_rate = $payee_details[0]['pay_rate'];
			        $freelance_pay_rate = $payee_details[0]['freelance_pay_rate'];
			        $employee_details_message= '';
			    }
			    if($payee){
			        $account_number = $payee[0]['accountno'];
			        $account_name = $payee[0]['accountname'];
			        $bankno = $payee[0]['bankno'];
			    }
			    
			    $employee_user = $this->Interlink_model->query("SELECT * FROM tbl_user WHERE employee_id = '$employee_id'"); 
			    
			    $department_checker = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$employee_id'"); 
			    $department_id = $department_checker[0]['job_description_id'];
			    $employee_type = $department_checker[0]['type_id'];
			    
			    $employee_department = $this->Interlink_model->query("SELECT * FROM tbl_hr_job_description WHERE ID = '$department_id'"); 
			    $department_message = '<span class="badge badge-danger" style="margin-bottom:20px">No department found !</span>';
			    if($employee_department){
			        $department_message = '';
			    }

			    $personal_information = $this->Interlink_model->query("SELECT * FROM others_employee_details WHERE employee_id = '$employee_id'"); 
			    $personal_information_message = '<span class="badge badge-danger" style="margin-bottom:20px">No personal information record !</span>';
			    if($personal_information){
			        $personal_information_message = '';
			    }
			    
			?>
    
    <div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
						<div class="pd-20 card-box">
							<h5 class="h4 text-blue mb-20"><?= $employee_user[0]['first_name'].' '.$employee_user[0]['last_name'] ?></h5><?= $department_message ?><?= $employee_details_message ?><?= $personal_information_message ?>
    
							<div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active text-blue" data-toggle="tab" href="#home" role="tab" aria-selected="true">Employee Details</a>
									</li>
									<li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Deductions</a>
									<!--</li>-->
									<!--        <li class="nav-item">-->
									<!--	<a class="nav-link text-blue" data-toggle="tab" href="#records" role="tab" aria-selected="false">Employee Records</a>-->
									<!--</li>-->
								
								
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade show active" id="home" role="tabpanel">
										<div class="pd-20">
                                     
										<div class="row">
                                          <div class="col-md-12">
                                              <label style="font-weight:600">Pay</label>
                                          </div>
                                      </div>
									  <form autocomplete="off" method="post" action="<?php echo site_url('Pages/update_employee/'); ?><?= $this->uri->segment('3'); ?> "> 
									  <?php
									    $interlink_data_employee = $this->Interlink_model->query("SELECT * FROM others_employee_details WHERE employee_id = '$employee_id' ");
									  ?>
									  <div class="row mt-4">
									 		<div class="col-md-4 d-inline">
									 		    <input type="text" style="display:none" name="employee_type" value="<?= $employee_type ?>">
									 		<?php if($employee_type != 4): ?>
                                                    <input type="hidden" name="exist_pay" value="<?= $paye_rate ?>">
    												<label>Pay Rate <span style="color:red">*</span> - 
    												<input type="text" class="form-control"  value="<?= $paye_rate ?>" name="pay_rate" id="">
											<?php else: ?>
												    <input type="hidden" name="exist_freelance_pay" value="<?= $freelance_pay_rate ?>">
    												<label>Hourly Rate <span style="color:red">*</span> - 
    												<input type="text" class="form-control"  value="<?= $freelance_pay_rate ?>" name="hourly_rate" id="">
											<?php endif; ?>
											</div>  
											<div class="col-md-4">
											    <label> Contact Number </label>
												<input type="text" class="form-control"  value="<?= $interlink_data_employee[0]['contact_no'] ?>" name="" id="">
											</div>
											<div class="col-md-4">
											    <label> Address </label>
												<input type="text" class="form-control"  value="<?= $interlink_data_employee[0]['address'] ?>" name="" id="">
											</div>
                                        </div>
                                      <div class="row mt-2">
                                              <div class="col-md-12"><hr></div>
                                      </div>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <label style="font-weight:600">Bank Details</label>
                                          </div>
                                      </div>
                                        <div class="row mt-4">
                                            <input type="hidden" value="<?= $bankno ?>" name="" id="source_id">
                                            <div class="col-md-4">
                                                <label>Bank Name</label>
                                                <select id="source_dropdown" clas="form-control" name="bankno" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                 <option value="0" >Please Select</option>
													<?php
														foreach($bank_details as $row):
													?>
													<option value="<?=$row->bankno?>"><?= $row->bankname ?></option>
													<?php
														endforeach;
													?>
												</select>
                                            </div>
                                            <div class="col-md-4">
                                                
                                                <label>Account Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter account name" value="<?= $account_name ?>" name="accountname" id="">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Account Number:</label>
                                                <input type="text" class="form-control" placeholder="Enter account number" value="<?=$account_number ?>" name="accountno" id="">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <label>Remarks</label>
                                                <textarea name="" id="" class="form-control" style="height:70px"></textarea>
                                            </div>
                                            <div class="col-md-4">
														
											</div>
                                            <div class="col-md-4"></div>
                                        </div>
                                      

                                      <div class="row mt-5">
                                          <div class="col-md-4">
                                              <input type="submit" class="btn btn-primary" name="save" value="Update"/>
                                          </div>
									</form>
                                          <div class="col-md-4"></div>
                                          <div class="col-md-4"></div>
                                      </div>
										</div>
									</div>
									</form>
									     <div class="tab-pane fade" id="records" role="tabpanel">
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
                                                                                
                                </tbody>
                            </table>                                                                              
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                            </div>
                    </div>                                           
				</div>	



									<div class="tab-pane fade" id="profile" role="tabpanel">
										<div class="pd-20">
										<div class="pd-20 d-flex">
                            <h4 class="text-blue h4">List of Deductions</h4>
                           
                            <button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%">Add Deduction</button>
                        </div>
                        <div class="pb-20">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="table-plus datatable-nosort">Deduction Type</th>
                                        <th>Total Deduction</th>
                                        <th>By Monthly Deductiont</th>
                                        <th>Notes</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                      
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $deductions = $this->User_model->select_where('*', 'deductions', array('payeeid' => $this->uri->segment('3'),'status' => 0));
                                        if($deductions):
                                        foreach($deductions as $row):
                                    ?>
                                    <tr>
                                        <td style=""><?= $row['id'] ?></td>
                                        <td class="table-plus"><?= $row['deduction_type'] ?></td>
                                        <td><?= "$"?><?= $row['deduction_amount'] ?></td>
                                        <td><?= $row['deduction_per_pay'] ?></td>
                                        <td><?= $row['notes'] ?></td>
                                        <td><?= $row['start_date'] ?></td>
                                        <td><?= $row['end_date'] ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" deduction_per_pay="<?= $row['deduction_per_pay'] ?>" frequency="<?= $row['frequency'] ?>" start_date="<?= $row['start_date'] ?>" end_date="<?= $row['end_date'] ?>" notes="<?= $row['notes'] ?>" total_deduct="<?= $row['deduction_amount'] ?>" deduct_id="<?= $row['id'] ?>" deduct_type="<?= $row['deduction_type']?>" id="get_deduction" href="#"><i class="dw dw-eye"></i> Edit</a>
                                                    <a class="dropdown-item" record_id="<?= $row['id']?>" id="delete_record" href="#"><i style="color:red" class="icon-copy fi-trash"></i> Delete</a>   
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach;endif; ?>
                                </tbody>
                            </table>
                        </div>
                        				<div class="card-box mb-30" style="margin-top:150px">
						
                        <div class="pd-20 d-flex">
                            <h4 class="text-blue h4">Deduction Payment History</h4>
                        </div>
                        <div class="pb-20">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="table-plus datatable-nosort">Deduction Type</th>
                                        <th>Reference No.</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr>
                                        <td style=""></td>
                                        <td class="table-plus"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                                                    <button data-toggle="modal" data-target="#bd-example-modal-lg" class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Pay</button>
                                                    <button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item"  href="#"><i class="dw dw-edit3"></i> Unpaid</button>
                                          
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                  
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    </div>

	


										</div>
									</div>
								
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
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_deduction/'); ?><?=$employee_id ?> "> 
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Type of Deduction</label>
														<select clas="form-control" name="deduction_type" style="width:100%;border-color:#d4d4d4;padding:10px">
                                                             <option value="SSS" >SSS</option>
            												 <option value="philhealth" >philhealth</option>
            												 <option value="HDMF" >HDMF</option>
            												 <option value="CA" >CA</option>
            											    </select>
													<!---	<input type="text" class="form-control" id="" name="deduction_type"  placeholder="Enter type of deduction">-->
													</div>
													<div class="col-md-6">
														<label>Deduction Amount</label>
														<input type="number" class="form-control" name="deduction_amount" placeholder="Enter Amount">
													</div>
												</div>


												<div class="row mt-4">
													<div class="col-md-6">
														<label>Start Date</label>
														<input type="date" class="form-control" id="" name="start_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-6">
														<label>End Date</label>
														<input type="date" class="form-control" name="end_date" placeholder="Enter Reference">
													</div>
												</div>

                                                <div class="row mt-4">
													<div class="col-md-6">
														<label>Number of deductions</label>
														<input type="number" class="form-control" id="" name="frequency"  placeholder="Enter Amount">
													</div>
													<div class="col-md-6">
                                                        <label>Deduction Per Pay</label>
                                                        <input type="number" class="form-control" id="" name="deduction_per_pay"  placeholder="Enter Amount">
                                                    </div>
												</div>

                                                <div class="row mt-4">
													<div class="col-md-6">
														<label>Note</label>
														<textarea name="notes" id="" class="form-control" style="height:60px"></textarea>
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



    <div class="modal fade bs-example-modal-lg" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Payment info</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/update_table/0/'.$this->uri->segment('4').'/update_deduct'); ?>">  
										<div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Type of Deduction</label>
                                                        <input type="hidden" name="id" id="id">
                                                        <input type="hidden" name="auth_ref" value="<?= $this->uri->segment('3') ?>">
                                                        <input type="text" class="form-control" id="deduct_type" name="deduction_type"  placeholder="Enter type of deduction">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Deduction Amount</label>
                                                        <input type="number" class="form-control" id="total_deduct" name="deduction_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>


                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <label>Start Date</label>
                                                        <input type="date" class="form-control" id="start_date" name="start_date"  placeholder="Enter Amount">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>End Date</label>
                                                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter Reference">
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <label>Number of deductions</label>
                                                        <input type="number" class="form-control" id="frequency" name="frequency"  placeholder="Enter Amount">
                                                    </div>
                                                     <div class="col-md-6">
                                                        <label>Deduction Per Pay</label>
                                                        <input type="number" class="form-control" id="" name="deduction_per_pay"  placeholder="Enter Amount">
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <label>Note</label>
                                                        <textarea name="notes" id="notes" class="form-control" style="height:60px"></textarea>
                                                    </div>                                                                                                  
                                                </div>
                                            </div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="save" value="Update"/>
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
														<input type="text" class="form-control" id="" name="record_name"  placeholder="Enter record name">
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
        var source_id = $('#source_id').val();
        $('[id*="delete_record"]').click(function(){
            var id = $(this).attr('record_id');
            //alert(id)

        if (confirm('Are you sure you want to delete this record ?')) {
            var location = "<?php echo site_url("Pages/delete_records/deductions/id/"); ?>"+id;
            window.location.href = location;
        } else {
            alert('Why did you press cancel? You should have confirmed');
        }

        });
        $("#source_dropdown option[value="+source_id+"]").attr('selected','selected');
    });
</script>
