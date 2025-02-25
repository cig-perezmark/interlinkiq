<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-3No Amount">
	<!-- Simple Datatable start -->
	<div class="card-box mb-3No Amount">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Pay Details - <span><?=$paiddate ?> </span></h4>
				    </div>
				    
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Status:</label>
                                <input type="text" class="form-control" value="<?= (!empty($pays_details['paidstatus'])) ? $pays_details['paidstatus'] : 'No Status'; ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Total Amount Paid</label>
                                <input type="text" value="<?= (!empty($pays_details['amount'])) ? $pays_details['amount'] : 'No Amount';?>" name="" id="" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label>Incentives</label>
                                <input type="text" value="<?= (!empty($pays_details['incentives'])) ? $pays_details['incentives'] : 'No Amount';?>" name="" id="" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Commission</label>
                                <input type="text" value="<?= (!empty($pays_details['comission'])) ? $pays_details['comission'] : 'No Amount'; ?>" name="" id="" class="form-control" readonly>
                            </div>
                            
                            <div class="col-md-4">
                                <label>Royaltee</label>
                                <input type="text" value="<?= (!empty($pays_details['royaltee'])) ? $pays_details['royaltee'] : 'No Amount'; ?>" name="" id="" class="form-control" readonly>
                            </div>
                            
                         </div>
                         <div class="row mt-5">
                            <div class="col-md-4">
                                <label>CA Deduction</label>
                                <input type="text" value="<?= (!empty($pay_deduction['user_deduction'])) ? $pay_deduction['user_deduction'] : 'No Amount'; ?>" name="" id="" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Absent Deduction</label>
                                <input type="text" value="<?= (!empty($pays_details['absent_deduction'])) ? $pays_details['absent_deduction'] : 'No Amount' ?>" name="" id="" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Adjustment</label>
                                <input type="text" value="<?= (!empty($pays_details['adjustment'] )) ? $pays_details['adjustment'] : 'No Amount'; ?>" name="" id="" class="form-control" readonly>
                            </div>
                         </div>

                         <div class="row mt-5">
                             <div class="col-md-4">
                                 <label>Other Fees</label>
                                 <input type="text" value="<?= (!empty($pays_details['other_fees'])) ? $pays_details['other_fees'] : 'No Amount'; ?>" name="" id="" class="form-control" readonly>
                             </div>
                         </div>
                         
                         <div class="row mt-5 mb-3">
                            <div class="col-md-4">
                                <label>Reference Number</label>
                                <input type="text" value="<?=(!empty($pays_details['refno'])) ? $pays_details['refno'] : 'No Amount';?>" name="" id="" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Pay Source</label>
                                <input type="text" value="<?= $this->uri->segment(3) ?>" name="" id="" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                 <label>Pay Notes</label>
                                <textarea class="form-control" style="height:70px"><?= (!empty($pays_details['pay_notes'])) ? $pays_details['pay_notes'] : 'Not Set'; ?></textarea>
                             </div>
                         </div>
                    </div>
                    </div>
				<!-- Simple Datatable End -->
       
				</div>
			</div>
