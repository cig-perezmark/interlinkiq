<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Consultare - List of Employees</h4>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Name</th>
									<th>Position</th>
									<th>Pay Rate</th>
									<th>Amount</th>
									<th>Company Email</th>
									<th>Employee Level</th>
									<th>Payment Date</th>
									<th>Paid Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
						    <?php
						        $paid_date = $this->uri->segment(3);
						        $fetch_pay_table = $this->User_model->query("SELECT * FROM pay INNER JOIN employee_details ON pay.payeeid = employee_details.payeeid WHERE paiddate = '$paid_date'");
						        foreach($fetch_pay_table as $row):
						        $payeeid = $row['payeeid'];
						            $employee = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee INNER JOIN others_employee_details ON others_employee_details.employee_id = tbl_hr_employee.ID  WHERE tbl_hr_employee.ID = '$payeeid' AND tbl_hr_employee.status = 1");
						            foreach($employee as $employee_row):
						    ?>
								<tr>
									<td class="table-plus"><?= $employee_row['first_name'] ?><?= " " ?><?=$employee_row['last_name']  ?></td>
									<td>TBD</td>
									<td><?= $row['pay_rate'] ?></td>
									<td><?= $employee_row['amount'] ?></td>
									<td><?= $employee_row['email'] ?></td>
									<td><?= $employee_row['employee_lvl'] ?></td>
									<td><?= $row['paiddate'] ?></td>
									<td>
									    <?php
									    if($row['paidstatus'] == "paid"){
                                            echo "<td><span class='badge badge-success'>Paid</span></td>";
                                        }
									    elseif($row['paidstatus'] == "forpay"){
                                            echo "<td><span class='badge'style='background-color:purple;color:#ffff'>forpay</span></td>";
                                        }
                                        elseif($row['paidstatus'] == "onhold"){
                                            echo "<td><span class='badge badge-danger'>onhold</span></td>";
                                        }
                                        elseif($row['paidstatus'] == "process"){
                                            echo "<td><span class='badge badge-primary'>process</span></td>";
                                        }
                                        elseif($row['paidstatus'] == "unpaid")
                                        {
                                            echo "<td><span class='badge badge-warning'>Unpaid</span></td>";
                                        }
                                        elseif($row['paidstatus'] == "approved")
                                        {
                                            echo "<td><span class='badge badge-warning' style='background-color:yellow;'>Reviewed</span></td>";
                                        }
									    ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" other_fees="<?= $row['other_fees'] ?>" transfer_fee="<?= $row['transfer_fee']?>" comission="<?= $row['comission'] ?>"  incentives="<?= $row['incentives'] ?>" royaltee="<?= $row['royaltee'] ?>" full_name="<?= $employee_row['first_name'].' '.$employee_row['last_name'] ?>" source_id="<?= $row['sourceid']?>" notes="<?= $row['pay_notes'] ?>" adjustment="<?= $row['adjustment'] ?>"   paidstatus="<?=$row['paidstatus']?>"  refno="<?=$row['refno']?>" amount="<?=$row['amount']?>" paiddate="<?= $row['paiddate'] ?>" payid="<?= $row['payid'] ?>" id="view_pay_details"><i class="dw dw-edit2"></i> Edit</a>
												<!---<button data-toggle="modal" data-target="#bd-example-modal-lg" class="dropdown-item" id="pay" pay_amount="<?= $row->pay_rate ?>" payee_id="<?= $row->payeeid?>"  href="#"><i class="dw dw-edit2"></i> Pay</button>--->
												<button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item" id="" value="<?php echo $row['payeeid']; ?>" href="#"><i class="dw dw-edit3"></i> Unpaid</button>
												<!---<a class="dropdown-item" href="<?php echo site_url('Pages/delete_record/');?><?= $row['payid']?>"><i class="dw dw-delete-3"></i> Delete</a>--->
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/forpay"?>"><i class="icon-copy ion-android-navigate"  style="color:green"></i>Forpay</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/onhold"?>"><i class="icon-copy ion-ios-locked-outline" style="color:red"></i> Onhold</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/process"?>"><i class="icon-copy ion-load-c" style="color:blue"></i> Process</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/approved"?>"><i class="icon-copy ion-load-c" style="color:blue"></i> Approved</a>
											</div>
										</div>
									</td>
								</tr>
								<?php endforeach;endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
			
			
						
			<!--- Modal start --->



			<div class="modal fade bs-example-modal-lg" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Payment info - <span id="full_name"></span> </h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/update_table/0/'.$this->uri->segment('3').'/updatepay'); ?>">  
										<div class="modal-body">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<label>Paid date</label>
														<input type="hidden" name="payid" id="pay_id">
														<input type="date" class="form-control" id="paiddate" name="paiddate"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label>Amount</label>
														<input type="text" class="form-control" id="amount" name="amount"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label>Paid status <span style="color:red">*</span></label>
														<select clas="form-control"  id="dropdown_data" name="paidstatus" style="width:100%;border-color:#d4d4d4;padding:10px">
														    <option value="process">Processed</option>
															<option value="unpaid">Unpaid</option>	
															<option value="paid">Paid</option>
															<option value="forpay">For Pay</option>	
															<option value="onhold">On Hold</option>
															<option value="cancel">Cancel</option>	
															<option value="approved">Approved</option>
														</select>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-md-4">
														<label>Reference Number <span style="color:red">*</span></label>
														<input type="text" class="form-control" id="refno" name="refno"  placeholder="Enter Amount" required>
													</div>
													<div class="col-md-4">
														<label for="">Payment Source <span style="color:red">*</span> </label>
    													<select clas="form-control" id="source_dropdown" name="sourceid" style="width:100%;border-color:#d4d4d4;padding:10px">
    														<?php foreach($pay_source as $row): ?>
    														<option value="<?= $row['sourceid'] ?>"><?= $row['sourcename'] ?></option>	
    														<?php endforeach; ?>
    													</select>
													</div>
													<div class="col-md-4">
                                                        <label>Adjustment</label>
														<input type="text" class="form-control" id="adjustment" name="adjustment"  placeholder="Enter Amount">
													</div>
												</div>
												
												<div class="row mt-3">
													<div class="col-md-4 form-group">
														<label>Royaltee</label>
														<input type="text" class="form-control prc" id="royaltee" name="royaltee">
													</div>
													<div class="col-md-4 form-group">
														<label for="">Comission</label>
    													<input type="text" class="form-control prc" id="comission" name="comission">
													</div>
													<div class="col-md-4 form-group">
                                                        <label>Incentives</label>
														<input type="text" class="form-control prc" id="incenteives" name="incenteives">
													</div>
												</div>
												
													<div class="row mt-3">
													<div class="col-md-4">
														<label>Notes</label>
														<textarea class="form-control" id="notes" name="notes" style="height:70px"></textarea>
													</div>
													<div class="col-md-4">
													    <label>Process Fee<span style="color:red">*</span> </label>
														<input type="text" class="form-control" id="processing_fee" name="processing_fee"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
                                                        <label>Other Fee</label>
														<input type="text" class="form-control" id="other_fees" name="other_fees"  placeholder="Enter Amount">
													</div>
												</div>
											
											

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" id="save" name="save" value="Update"/>
										</div>
										</form> 
									</div>
								</div>
							</div>
							
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="container" style="padding:20px" id="employee_details_info">
                                    
                                </div>
                            </div>
                          </div>
                        </div>
<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->

			
			
<script>
    $(document).ready(function(){
    
    $('[id*="view_pay_details"]').click(function(){
        var id = $(this).attr('payid'); //get the attribute value
        var paiddate = $(this).attr('paiddate'); //get the attribute value
        var amount = $(this).attr('amount'); //get the attribute value
        var paidstatus = $(this).attr('paidstatus'); //get the attribute value
        var refno = $(this).attr('refno'); //get the attribute value
        var sourcename = $(this).attr('sourcename'); //get the attribute value
        var source_id = $(this).attr('source_id');
        var adjustment = $(this).attr('adjustment');
        var notes = $(this).attr('notes');
        var full_name = $(this).attr('full_name');
        var comission = $(this).attr('comission');
        var incentives = $(this).attr('incentives');
        var royaltee = $(this).attr('royaltee');
        var transfer_fee = $(this).attr('transfer_fee');
        var other_fees = $(this).attr('other_fees');
      //alert(id);
         $('#pay_id').val(id);
         $('#paiddate').val(paiddate);
         $('#amount').val(amount);
         $('#paidstatus').val(paidstatus);
         $('#refno').val(refno);
         $('#adjustment').val(adjustment);
         $('#sourcename').val(sourcename);
         $('#notes').val(notes);
         $('#full_name').html(full_name);
         $('#incentives').val(incentives);
         $('#royaltee').val(royaltee);
         $('#comission').val(comission);
         $('#processing_fee').val(transfer_fee);
         $('#other_fees').val(other_fees);
          $("#source_dropdown option[value="+source_id+"]").attr('selected','selected');
        $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
     
    });
    
});

function for_approval(){
let text = "Update this record ?";
  if (confirm(text) == true) {  

 			var start = document.getElementById('start').value
 			var location = "<?php echo site_url("Pages/update_flag_status2/"); ?>"+start;
            window.location.href = location;
	}
}

function export_pay() {
  let text = "Do you want to export pays ?";
  if (confirm(text) == true) {  

 			var start = document.getElementById('start').value
			
// 			
 			var location = "<?php echo site_url("Pages/exportPays_history/"); ?>"+start;
 			 window.location.href = location;
// 			//alert(location)
// 			//window.location.href = "<?php echo site_url('Pages/exportPays'); ?>"

	}
}

$('[id*="view_employee"]').click(function(){
    
    var employee_id =  ($(this).attr('employee_id'));
    $.get("<?php echo site_url(); ?>Pages/get_employee", 
        {
          employee_id: employee_id
        },
          function(data){
            // Display the returned data in browser
            $('#employee_details_info').html(data);
            //console.log('done : ' + data);  
    });
        
});
</script>
