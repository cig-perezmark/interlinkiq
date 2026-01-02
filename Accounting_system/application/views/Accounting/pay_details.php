<?php
    $user_id = $this->uri->segment('3');
    $end_date = $this->uri->segment('5');
    $start_date = $this->uri->segment('6');
    $employee_user = $this->Interlink_model->query("SELECT * FROM tbl_user WHERE employee_id = '$user_id'"); 
    $user_cookie = $employee_user[0]['ID'];
    $absent_count = $this->Interlink_model->query("SELECT COUNT(*) as total_absent FROM tbl_service_logs WHERE user_id = '$user_cookie' AND task_date between '$start_date' AND '$end_date' AND `minute` = -5");
    $royaltee = '';
    $comission = '';
    $incentives = '';
    $other_fees = '';
    $adjustment = '';
    $get_pay = $this->User_model->query("SELECT * FROM pay WHERE payeeid = '$user_id' AND paiddate = '$end_date'");
    if($get_pay){
        if($get_pay[0]['paidstatus'] == "process"){
            
        }
    }
    $department_checker = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$employee_id'"); 
    $department_id = $department_checker[0]['job_description_id'];
    $employee_type = $department_checker[0]['type_id'];
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="card-box mb-30">
                        <div class="pd-20" style="background-color:#4682b4;border-radius:10px;position:relative">
                        <h4 class="h4" style="color:#ffff"><?= $employee_user[0]['first_name'].' '.$employee_user[0]['last_name'] ?></h4>
						<!--<button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg3" style="position:absolute;right:5px;top:10px">Night Diff</button>-->
						<!--<button class="btn btn-primary"  data-toggle="modal" data-target="#modal-absent"  style="position:absolute;right:150px;top:10px">Absences</button>-->
						<?php if(isset($_SESSION['alert_message'])): ?>
						<div class="alert_message" style="width:70%;height:50px;background-color: rgba(50, 200, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;">
							<span style="padding:18px"><?= $_SESSION['alert_message'] ?></span>
							<?php  //unset success
					                    unset($_SESSION['alert_message']); ?>
						</div>
						<?php endif; ?>
                    </div>
                    <div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
						<div class="pd-20 card-box">
							
						<form autocomplete="off" method="post" action="<?php echo site_url('Pages/process_pay/'); ?><?=$employee_id ?>">  
                            <div class="row">
								 <input type="hidden" name="counter[]">
								<input style="display:none" type="text" value="<?= $deduction_id ?>" name="deduction_id" id=""> 
								<input  type="hidden" value="<?= $this->uri->segment(4)?>" name="payid" id="">  
								<input style="display:none" name="payeeid" type="text" value="<?=$employee_id ?>" name="pay_rate" id="">
								<?php if($employee_type != 4): ?>
                                    <div class="col-md-4 form-group">
                                        <label>Pay Rate</label>
                                        <input type="hidden" id="base_pay" value="<?= $employee_rate ?>" name="" id="">
                                        <input type="hidden" class="form-control prc" id="hour_total" value="0">
                                        <input type="hidden" value="0" class="form-control"  id="hourly_rate" >
    									<?php 
    										$total_pay = $employee_rate/2;
                                        echo '<input type="text" value='.$total_pay.' class="form-control prc" name="payrate_comment_name" id="" oninput="togglepayrateTextarea()" >';
    									?>
    									<div id="payrateTextarea" class="textarea-container mt-3" style="display:none">
                                            <label>Pay Rate Comment</label>
                                            <textarea class="form-control" style="height:70px" name="payrate_comment" placeholder="Pay rate Additional Information"><?= isset($get_pay[0]['payrate_comment']) ? $get_pay[0]['payrate_comment'] : '' ?></textarea>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-4 form-group">
                                        <label>Hourly Rate</label>
                                        <input type="hidden" id="freelance_pay_rate" value="<?= $freelance_pay_rate ?>" name="" id="">
    									<?php 
    									$total_pay = 0;
                                        echo '<input type="text" value='.$freelance_pay_rate.' class="form-control" name="hourly_rate" id="hourly_rate" >';
    									?>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Total Hours</label>
                                        <input type="text" class="form-control prc" id="hour_total" value="<?= isset($get_pay[0]['total_hours']) ? $get_pay[0]['total_hours'] : 0 ?>" name="total_hours" oninput="toggleHourlyTextarea()"  >
                                        <div id="hourlyTextarea" class="textarea-container" style="display: none;">
                                            <label>Hourly Comment</label>
                                            <textarea class="form-control" name="hourly_comment" placeholder="Hourly Additional Information"><?= isset($get_pay[0]['hourly_comment']) ? $get_pay[0]['hourly_comment'] : '' ?></textarea>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="col-md-4 form-group">
									<label>Total Deduction/s</label>
										<?php
											
										$total_sum = 0;
										if($employee_deduction):
										foreach($employee_deduction as $row):
											$i=1;
											
										 echo '<input type="hidden" value='.$row['id'].' class="form-control drc" name="deduction_id[]" readonly>';
										 $total_deduction = $row['deduction_per_pay'];
										 $total_sum += (int)$row['deduction_per_pay'];
										 echo '<input type="hidden" value='.$total_deduction.' class="form-control drc" name="deduction_amounts[]" readonly>';
										 $i++; endforeach; endif;
											echo '    <input type="number" value='.$total_sum.' class="form-control drc" name="deduction_amount" id="deduct"> ';
											if($total_sum != 0){
											    echo '<label>Deduction Comment</label><textarea class="form-control" name="deduction_comment" style="height:70px;margin-top:15px"></textarea>';
											}
										?>

								</div>
                            </div>

						    <div class="row mt-2">
								<div class="col-md-4 form-group">
                                    <label>Referal Fee</label>
                                    <input type="text" value="<?= isset($get_pay[0]['royaltee']) ? $get_pay[0]['royaltee'] : '' ?>" class="form-control prc" name="royaltee" placeholder="Enter Royalty" oninput="toggleRoyaltyTextarea()">
                                    <div id="royalteeTextarea" class="textarea-container" style="display: none;">
                                        <label>Referal Comment</label>
                                        <textarea class="form-control" name="royaltee_comment" placeholder="Royalty Fee Additional Information"><?= isset($get_pay[0]['royaltee_comment']) ? $get_pay[0]['royaltee_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 form-group">
                                    <label>Commission</label>
                                    <input type="text" class="form-control prc" value="<?= isset($get_pay[0]['comission']) ? $get_pay[0]['comission'] : '' ?>" name="comission" placeholder="Enter Commission" oninput="toggleCommissionTextarea()">
                                    <div id="commissionTextarea" class="textarea-container" style="display: none;">
                                        <label>Commission Comment</label>
                                        <textarea class="form-control" name="comission_comment" placeholder="Commission Additional Information"><?= isset($get_pay[0]['comission_comment']) ? $get_pay[0]['comission_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 form-group">
                                    <label>Incentives</label>
                                    <input type="text" class="form-control prc" value="<?= isset($get_pay[0]['incentives']) ? $get_pay[0]['incentives'] : '' ?>" name="incentives" placeholder="Enter Incentives" oninput="toggleIncentivesTextarea()">
                                    <div id="incentivesTextarea" class="textarea-container" style="display: none;">
                                        <label>Incentives Comment</label>
                                        <textarea class="form-control" name="incentives_comment" placeholder="Incentives Additional Information"><?= isset($get_pay[0]['incentives_comment']) ? $get_pay[0]['incentives_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
								<div class="col-md-4 form-group">
                                    <label>Bonus Fee</label>
                                    <input type="text" value="<?= isset($get_pay[0]['bunos']) ? $get_pay[0]['bunos'] : '' ?>" class="form-control prc" name="bunos" placeholder="Enter Bunos" oninput="toggleBunosTextarea()">
                                    <div id="bunosTextarea" class="textarea-container" style="display: none;">
                                        <label>Bonus Comment</label>
                                        <textarea class="form-control" name="bunos_comment" placeholder="Bunos Fee Additional Information"><?= isset($get_pay[0]['bunos_comment']) ? $get_pay[0]['bunos_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 form-group">
                                    <label>Marketing Fee</label>
                                    <input type="text" class="form-control prc" value="<?= isset($get_pay[0]['marketing_fee']) ? $get_pay[0]['marketing_fee'] : '' ?>" name="marketing_fee" placeholder="Enter Marketing" oninput="toggleMarketingTextarea()">
                                    <div id="marketingTextarea" class="textarea-container" style="display: none;">
                                        <label>Marketing Comment</label>
                                        <textarea class="form-control" name="marketing_fee_comment" placeholder="Marketing Additional Information"><?= isset($get_pay[0]['marketing_fee_comment']) ? $get_pay[0]['marketing_fee_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 form-group">
                                    <label>Cash Advance</label>
                                    <input type="text" class="form-control prc" value="<?= isset($get_pay[0]['cash_advance']) ? $get_pay[0]['cash_advance'] : '' ?>" name="cash_advance" placeholder="Enter Cash Advance" oninput="toggleCashAdvanceTextarea()">
                                    <div id="cash_advanceTextarea" class="textarea-container" style="display: none;">
                                        <label>Cash Advance Comment</label>
                                        <textarea class="form-control" name="cash_advance_comment" placeholder="Cash Advance Additional Information"><?= isset($get_pay[0]['cash_advance_comment']) ? $get_pay[0]['cash_advance_comment'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
								<div class="col-md-4 form-group">
										<label>Other Fees</label>
										<input type="text" class="form-control prc" value="<?= isset($get_pay[0]['other_fees']) ? $get_pay[0]['other_fees'] : '' ?>" name="other_fees" placeholder="Enter Other fees" oninput="toggleOthersTextarea()">
										<div id="otherTextarea" class="textarea-container" style="display: none;">
                                            <label>Other Fees Comment</label>
                                            <textarea class="form-control" name="other_fees_comment" placeholder="Other Additional Information"><?= isset($get_pay[0]['other_fees_comment']) ? $get_pay[0]['other_fees_comment'] : '' ?></textarea>
                                        </div>
								</div>
								<div class="col-md-4  form-group">
                                    <label for="">Absent Deduction</label>
                                    <?php 
                                        $base_pay = $employee_rate/22;
                                        $number_of_abcenses = $absent_count[0]['total_absent'];
                                        $absent_deduction = $base_pay * $number_of_abcenses;
                                    ?>
									<input type="text" name="absent_deduction" class="form-control" value="<?= $absent_deduction ?>" id="absent_deductions" >
                                </div>
                                <div class="col-md-4  form-group">
									<label for="">Ajustment</label>
									<input type="text" name="adjustment" class="form-control prc" value="<?= isset($get_pay[0]['adjustment']) ? $get_pay[0]['adjustment'] : 0 ?>" id="absent_deduction_total" oninput="toggleAdjustmentTextarea()" >
									<div id="adjustmentTextarea" class="textarea-container" style="display: none;">
                                        <label>Adjustment Comment</label>
                                        <textarea class="form-control" name="adjustment_comment" placeholder="Adjusment Information"><?= isset($get_pay[0]['adjustment_comment']) ? $get_pay[0]['adjustment_comment'] : '' ?></textarea>
                                    </div>
								</div>
                            </div>

    						<div class="row mt-2">
								<div class="col-md-4 form-group">
										<label>Reference Number</label>
										<input type="text" class="form-control" value="<?= $get_pay[0]['refno'] ?>" name="refno" placeholder="Enter Reference">
								</div>
                                <div class="col-md-4">
										<label>Paid Date</label>
										<input type="date" name="paiddate" class="form-control" value="<?= $this->uri->segment(5)?>" placeholder="Enter Royalty">
                                </div>
                                <div class="col-md-4 ">
												<label for="">Payment Source</label>
												<select clas="form-control" name="sourceid" style="width:100%;border-color:#d4d4d4;padding:10px">
													<?php foreach($pay_source as $row): ?>
													<option value="<?= $row->sourceid ?>"><?= $row->sourcename ?></option>	
													<?php endforeach; ?>
												</select>
								</div>
                            </div>	
							<div class="row mt-2">
                                <div class="col-md-4  form-group">
									<label for="">Notes</label>
									<textarea readonly name="notes" id="" class="form-control" style="height:70px"><?= isset($get_pay[0]['pay_notes']) ? $get_pay[0]['pay_notes'] : '' ?></textarea>
								</div>
                            </div>

							<div class="row mt-2">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4 mt-4">
									<!---<input type="number" id="result" class="form-control" placeholder="Enter Comission">-->
									
									<?php if($get_pay[0]['paidstatus'] == "process"): ?>
									    <label>Total paid:</label>
									    <output style="font-weight:700"><?= $get_pay[0]['amount'] ?></output>
									<?php else: ?>
									    <label>Total to be paid:</label>
									    <output style="font-weight:700" id="result"><?= $get_pay[0]['amount'] ?></output>
									<?php endif; ?>
								</div>
                                <div class="col-md-4">
									
								</div>
                            </div>
							<div class="row mt-2">
                                <div class="col-md-4">
                                    <input style="display:none" name="amount" value="<?= $total_pay ?>" type="text" id="total_result">
                                </div>
                                <div class="col-md-4">
                                    <?php 
                                        if($get_pay[0]['paidstatus'] != "process"):
                                    ?>
									<input type="submit" style="color:#ffff" class="form-control btn btn-primary" name="save" value="Update"/>
									<?php else: ?>
									    <label>Sorry it's already been processed cannot be updated, Thanks !</label>
									<?php endif; ?>
								</div>
                                <div class="col-md-4">
									
								</div>
                            </div>

							</form>
                        </div>

						<script>
							    var deductions = $("#deduct").val();
                                // var absent_deduction = $("#absent_deduction_total").val();
                                var hourly_rate = $('#hourly_rate').val();
                                var absent_deductions = $("#absent_deductions").val();
    							$('.form-group').on('input','.prc',function(){
    							    var free_lance_total = hourly_rate * hour_total;
    								var totalSum = 0;
    								var final_total = 0;
    								$('.form-group .prc').each(function(){
    								    var hour_total = $('#hour_total').val();
    									var inputVal = $(this).val();
    									freelance_total = hourly_rate * hour_total;
    									if($.isNumeric(inputVal))
    									{
    										totalSum += parseFloat(inputVal);
    								// 		console.log(totalSum);
    										
    									}
    									final_total = totalSum - deductions - absent_deductions + freelance_total - hour_total;

    								});
    								
    									$('#total_result').val(final_total.toFixed(2));
    									$('#result').text(final_total.toFixed(2));
    							});
						</script>

							
				<div class="card-box mb-30" style="margin-top:50px">
					<div class="pd-20">
						<h4 class="text-blue h4">Payment History</h4>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Paid Date</th>
									<th>Amount</th>
									<th>Reference No.</th>
									<th>Paid Status</th>
                                    <th>Pay Source</th>
                                    <th>Submitted By</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>

							<?php 
										if ($pay_history) {
									foreach($pay_history as $row):
									if($row->paidstatus == "process"):
									?>
									
									<tr>
									<td class="table-plus"><?= $row->paiddate ?></td>
									<td><?= $row->amount ?></td>
									<td><?= $row->refno ?></td>
									<td>
										<?php 
											if($row->paidstatus == "paid")
											{
												echo "<span class='badge badge-success'>Paid</span>";
											}
											elseif($row->paidstatus == "cancel")
											{
												echo "<span class='badge badge-danger'>Canceled</span>";
											}
											elseif($row->paidstatus == "forpay")
											{
												echo "<span class='badge badge-success'>forpay</span>";
											}
											elseif($row->paidstatus == "unpaid")
											{
												echo "<span class='badge badge-warning'>Unpaid</span>";
											}
											elseif($row->paidstatus == "approved")
											{
												echo "<span class='badge badge-primary'>Approved</span>";
											}
											elseif($row->paidstatus == "process")
											{
												echo "<span class='badge badge-primary'>Approved</span>";
											}
											else
											{
												echo "<span class='badge badge-warning'>Unpaid</span>";
											}
										?>
									</td>
                                    <td><?= $row->sourcename ?></td>
                                    <td><?= $row->submited_by ?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" source_id="<?= $row->sourceid?>" notes="<?= $row->pay_notes ?>" adjustment="<?= $row->adjustment ?>" sourcename="<?=$row->sourcename?>"  paidstatus="<?=$row->paidstatus?>"  refno="<?=$row->refno?>" amount="<?=$row->amount?>" paiddate="<?= $row->paiddate ?>" payid="<?= $row->payid ?>" id="edit_pay"><i class="dw dw-edit2"></i> Edit</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/delete_records/pay/payid/');?><?= $row->payid?>"><i class="icon-copy ion-android-close"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
									<?php endif; endforeach; } else { ?>
										no record
									<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->

					<!-- Simple Datatable start -->
						<div class="card-box mb-30 mt-5">
						
                        <div class="pd-20 d-flex">
                            <h4 class="text-blue h4">Deductions History</h4>
 
                        </div>
                        <div class="pb-20">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="table-plus datatable-nosort">Deduction Type</th>
                                        <th>Deduction Amount</th>
										<th>Date Paid</th>
										<th>Reference Number</th>
                                        <!---<th>Payment Status</th> --->
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

									<?php 
										if ($deduction_history) {
										foreach($deduction_history as $row): ?>
											 <tr>
                                        <td style=""><?= $row->id ?></td>
                                        <td class="table-plus"><?= $row->deduction_type ?></td>
                                        <td><?= $row->user_deduction ?></td>
										<td><?= $row->date_paid ?></td>
										<td><?= $row->reference_no?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                                                    <button data-toggle="modal" data-target="#bd-example-modal-lg" class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Pay</button>
                                                    <button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item"  href="#"><i class="dw dw-edit3"></i> Unpaid</button>
                                                    <!---<a class="dropdown-item" href="<?php echo site_url('Pages/delete_record/');?><?= $row->payeeid?>"><i class="dw dw-delete-3"></i> Delete</a>--->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
										<?php endforeach; } else { ?>
										no record
									<?php } ?>
							
                                </tbody>
                            </table>
                        </div>
                    </div>


					
                    <!-- Simple Datatable End -->

				      
                                           	<!-- Simple Datatable start -->
											   <div class="card-box mb-30" style="margin-top:50px">
					<div class="pd-20">
                   
						<h4 class="text-blue h4">Leave History</h4>
                  
                        <?php if($leave): ?>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Type of leave</th>
									<th>No. of leave</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>

							<tbody>
                               
                                    <?php foreach($leave as $row): ?>
								<tr>
									<td class="table-plus"><?= $row->leave_type ?></td>
									<td><?= $row->leave_count ?></td>
									<td><?= $row->start_date ?></td>
									<td><?= $row->end_date ?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
											</div>
										</div>
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
									<!---<div class="tab-pane fade" id="contact" role="tabpanel">
										<div class="pd-20">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
										</div>
									</div> -->
								</div>
							</div>
						</div>
					</div>
                </div>

            </div>
 </div>
 
 
			<!--- Modal start --->



			<div class="modal fade bs-example-modal-lg" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Payment info</h4>
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
														<label>Paid status</label>
														<select clas="form-control"  id="dropdown_data" name="paidstatus" style="width:100%;border-color:#d4d4d4;padding:10px">
															<option value="unpaid">Unpaid</option>	
															<option value="paid">Paid</option>
															<option value="forpay">Forpay</option>	
															<option value="onhold">Onhold</option>
															<option value="cancel">Cancel</option>	
															<option value="process">Process</option>	
														</select>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-md-4">
														<label>Reference Number</label>
														<input type="text" class="form-control" id="refno" name="refno"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label for="">Payment Source</label>
    													<select clas="form-control" id="source_dropdown" name="sourceid" style="width:100%;border-color:#d4d4d4;padding:10px">
    														<?php foreach($pay_source as $row): ?>
    														<option value="<?= $row->sourceid ?>"><?= $row->sourcename ?></option>	
    														<?php endforeach; ?>
    													</select>
													</div>
													<div class="col-md-4">
                                                        <label>Adjustment</label>
														<input type="text" class="form-control" id="adjustment" name="adjustment"  placeholder="Enter Amount">
													</div>
												</div>
												
													<div class="row mt-3">
													<div class="col-md-4">
														<label>Notes</label>
														<textarea class="form-control" id="notes" name="notes" style="height:70px"></textarea>
													</div>
													<div class="col-md-4">
													</div>
													<div class="col-md-4">

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



	<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Night Differentials</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<table id="night_diff" class="data-table table stripe hover nowrap">
													<div class="row d-flex">
														<div class="col-md-4">
														<label for="">Hourly Rate</label>
															<input type="text" class="form-control" name=""  id="hours_amount">
															</div>
														<div class="col-md-6">
															<label for="">Total to paid</label>
															<input type="text" class="form-control" name="night_diff_pay"  id="total_night_diff">
														</div>
														<div class="col-md-2">
															<label for="">See total</label>
															<input type="button" class="btn btn-primary" id="check" name="save" value="Total"/>
														</div>
													</div>
												<thead>
													<tr>
														<th class="table-plus datatable-nosort">Case Basis</th>
														<th class="table-plus datatable-nosort">Total of Hours</th>
														<th>Total Pay</th>
													</tr>
												</thead>
												<tbody>
												    <tr>
														<td>Ordinary day Night Shift <input name="payeeid" type="hidden" value="<?=$employee_id ?>" name="payeeid" id=""></td>
														<td class="table-plus"><input type="number" class="form-control total_hours" name="ordinary_day" id="total_hours"></td>
														<td><input type="text" value="0" name="" class="form-control total_nd_sum prc" id="total_nd" readonly></td>
													</tr>
													<tr>
														<td>Rest day Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours1" name="rest_day" id="total_hours1" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd1" readonly></td>												
													</tr>
													<tr>
														<td>Special Holdiay Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours2" name="special_day" id="total_hours2" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd2" readonly></td>												
													</tr>
													<tr>
														<td>Special Holdiay at the same time Rest day Nigh Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours3" name="special_rest_day" id="total_hours3" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd3" readonly></td>												
													</tr>
													<tr>
														<td>Regular Holiday Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours4" name="regular_day" id="total_hours4" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd4" readonly></td>												
													</tr>
													<tr>
														<td>Regular Holiday and at the same time Rest day Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours5" name="regular_rest_day" id="total_hours5" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd5" readonly></td>												
													</tr>
													<tr>
														<td>Double Holiday Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours6" name="double_day" id="total_hours6" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd6" readonly></td>												
													</tr>
													<tr>
														<td>Double Holiday and at the same time Rest day Night Shift</td>
														<td class="table-plus"><input type="number" class="form-control total_hours7" name="double_rest_day" id="total_hours7" ></td>
														<td><input type="text" value="0" name=""  class="form-control total_nd_sum prc" id="total_nd7" readonly></td>												
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" id="save" name="save" value="Save Data"/>
										</div>
										</form>
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->

<!--- Modal start --->
	<div class="modal fade bs-example-modal-lg" id="modal-absent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
	    						<form autocomplete="off" method="post" action="<?php echo site_url('Pages/savedata'); ?>"> 
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
										    <input type="hidden" name="payeeid" value="<?= $this->uri->segment(3) ?>">
											<h4 class="modal-title" id="myLargeModalLabel">Total Absence</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											
							<div class="row mt-4">
								<div class="col-md-4 form-group">
										<label>Total Absences</label>
										<input type="number" id="number_of_absent" class="form-control" name="royaltee" placeholder="Enter number of absences">
								</div>

                                <div class="col-md-4 form-group">
                                    <label>Absences Deduction</label>
									<input type="number" id="absent_deduction" class="form-control drc"  name="absent_deduction" readonly>
                                </div>
                            </div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" id="save_absent" name="save_absent" value="Save Data"/>
										</div>
										</form>
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->

<script>
	$('input[id="save"]').attr('disabled','disabled');

	$('#total_hours').on('input', function(){

		var sum = $("#total_hours").val();
		var hours_amount = $("#hours_amount").val();
		var first_num = parseFloat(hours_amount);
		var  total  = first_num*.10*sum;
		var nd_total_amount = total.toFixed(2);

		$('#total_nd').val(nd_total_amount);
	})

	$('#total_hours1').on('input', function(){
	
	var sum = $("#total_hours1").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*1.3*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd1').val(nd_total_amount1);
	})

	$('#total_hours2').on('input', function(){
	
	var sum = $("#total_hours2").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*1.3*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd2').val(nd_total_amount1);
	})

	$('#total_hours3').on('input', function(){
	
	var sum = $("#total_hours3").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*1.5*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd3').val(nd_total_amount1);
	})

	$('#total_hours4').on('input', function(){
	
	var sum = $("#total_hours4").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*2*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd4').val(nd_total_amount1);
	})


	$('#total_hours5').on('input', function(){
	
	var sum = $("#total_hours5").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*2.6*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd5').val(nd_total_amount1);
	})

	
	$('#total_hours6').on('input', function(){
	
	var sum = $("#total_hours6").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*3.3*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd6').val(nd_total_amount1);
	})

	$('#total_hours7').on('input', function(){
	
	var sum = $("#total_hours7").val();
	var hours_amount = $("#hours_amount").val();

	var  total  = hours_amount*3.9*.10*sum;
	var nd_total_amount1 = total.toFixed(2);

	$('#total_nd7').val(nd_total_amount1);
	})

	$("#check").click(function(){
		var sum = $("#total_nd").val();
		var num = parseFloat(sum)
		var sum1 = $("#total_nd1").val();
		var num1 = parseFloat(sum1)
		var sum2 = $("#total_nd2").val();
		var num2 = parseFloat(sum2)
		var sum3 = $("#total_nd3").val();
		var num3 = parseFloat(sum3)
		var sum4 = $("#total_nd4").val();
		var num4 = parseFloat(sum4)
		var sum5 = $("#total_nd5").val();
		var num5 = parseFloat(sum5)
		var sum6 = $("#total_nd6").val();
		var num6 = parseFloat(sum6)
		var sum7 = $("#total_nd7").val();
		var num7 = parseFloat(sum7)

		var total_sum = num+num1+num2+num3+num4+num5+num6+num7;
		$('#total_night_diff').val(total_sum.toFixed(2));
		$('input[id="save"]').removeAttr('disabled');
   
	});
	
	$('#number_of_absent').on('input', function(){
	
	var base_pay = $("#base_pay").val();
	var number_of_absent = $("#number_of_absent").val();

	var  total  = base_pay/15*number_of_absent;
	var total_absent_deduction = total.toFixed(2);

	$('#absent_deduction').val(total_absent_deduction);
	})
	

    // Toggle functions for each input
    function toggleRoyaltyTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='royaltee']`).value);
        const textareaContainer = document.getElementById('royalteeTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    // Toggle functions for each input
    function togglepayrateTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='payrate_comment_name']`).value);
        const textareaContainer = document.getElementById('payrateTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    // Toggle functions for each input
    function toggleHourlyTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='hourly_rate']`).value);
        const textareaContainer = document.getElementById('hourlyTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }

    function toggleCommissionTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='comission']`).value);
        const textareaContainer = document.getElementById('commissionTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }

    function toggleIncentivesTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='incentives']`).value);
        const textareaContainer = document.getElementById('incentivesTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    function toggleOthersTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='other_fees']`).value);
        const textareaContainer = document.getElementById('otherTextarea');

        if (!isNaN(inputValue) && inputValue > 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    function toggleAdjustmentTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='adjustment']`).value);
        const textareaContainer = document.getElementById('adjustmentTextarea');

        if (!isNaN(inputValue) && inputValue != 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    
    function toggleBunosTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='bunos']`).value);
        const textareaContainer = document.getElementById('bunosTextarea');

        if (!isNaN(inputValue) && inputValue != 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    function toggleMarketingTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='marketing_fee']`).value);
        const textareaContainer = document.getElementById('marketingTextarea');

        if (!isNaN(inputValue) && inputValue != 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    function toggleCashAdvanceTextarea() {
        const inputValue = parseFloat(document.querySelector(`input[name='cash_advance']`).value);
        const textareaContainer = document.getElementById('cash_advanceTextarea');

        if (!isNaN(inputValue) && inputValue != 0) {
            textareaContainer.style.display = 'block';
        } else {
            textareaContainer.style.display = 'none';
        }
    }
    // Invoke toggle functions on page load if the initial value is greater than 0
    window.onload = function() {
        toggleRoyaltyTextarea();
        toggleCommissionTextarea();
        toggleIncentivesTextarea();
        toggleBunosTextarea();
        toggleMarketingTextarea();
        toggleCashAdvanceTextarea();

    }

</script>
