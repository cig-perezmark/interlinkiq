<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
<!-- Simple Datatable start -->
<div class="card-box mb-30">
                    
                <div class="pd-20 d-flex">
                    <h4>PTO List (Remaining Leave: <label>
                        <?php if(!empty($leave)):
                           echo "$leave"; 
                        else:
                            {
                                echo "0";
                            }
                     endif;?>
                    </label> )</h4>
                    <?php if($leave != 0): ?>
                        <button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg2" style="position:absolute;right:4%">Request PTO</button>
                    <?php endif; ?>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Leave ID</th>
                                <th class="table-plus datatable-nosort">Leave Count</th>
                                <th>Type of leave</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($pay_list): ?>
                            <?php foreach($pay_list as $row): ?>
                            <tr>
                                <td style="" id="payeeid"><?=$row->id?></td>
                                <td class="table-plus" id="fullname"><?=$row->leave_count ?></td>
                                <td><?= $row->leave_type ?></td>
                                <td><?= $row->start_date ?></td>
                                <td><?=$row->end_date?></td>
                                <td><?=$row->notes?></td>
                                <td><?php
										if($row->approve_status == '2')
										{
											echo "<span class='badge badge-success'>Approved</span>";
										}
                                        elseif($row->approve_status == "1")
                                        {
                                            echo "<span class='badge badge-primary'>For Approval</span>";
                                        }
                                        elseif($row->approve_status == "0")
                                        {
                                            echo "<span class='badge badge-secondary'>Pending</span>";
                                        }
                                        elseif($row->approve_status == "3")
                                        {
                                            echo "<span class='badge badge-danger'>For Cancel</span>";
                                        }
                                        elseif($row->approve_status == "4")
                                        {
                                            echo "<span class='badge badge-danger'>Canceled</span>";
                                        }
                                        else
                                        {
                                            echo "<span class='badge badge-danger'>Disapproved</span>"; 
                                        }

									
									?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a id="update_leave" class="dropdown-item" end_date="<?=$row->end_date?>" start_date="<?= $row->start_date ?>" leave_type="<?= $row->leave_type ?>" leave_id="<?=$row->id?>" leave_count="<?=$row->leave_count ?>" notes="<?=$row->notes ?>" data-toggle="modal" data-target="#bd-example-modal-lg10" href="#">Update</a> 
                                            <a class="dropdown-item" href="<?php echo site_url('Pages/Pay_details/');?>">Request Cancel</a>
                               
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; endif;  ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
            </div>
        </div>



        
		<!--- Modal start --->



        <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Add Leave</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_leave_details/'); ?><?="3302655412"?><?= "/"?><?=$_SESSION['id'] ?>">  
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Type of leave</label>
														<!--<input type="text" class="form-control" id="" name="leave_type"  placeholder="Enter type of leave">-->
														<select class="form-control" name="leave_type">
														    <option value="Sick Leave">Sick Leave</option>
														    <option  value="Vacation Leave">Vacation Leave</option>
														    <option  value="Bereavement Leave">Bereavement Leave</option>
														    <option  value="Paternity Leave">Paternity Leave</option>
														    <option  value="Emergency Leave">Emergency Leave</option>
														    <option  value="Leave of Absence">Leave of Absence</option>
														    <option  value="Half Day">Half Day</option>
														    <option  value="Maternity Leave">Maternity Leave</option>
														    <option  value="PTO">PTO</option>
														    <option  value="Out of Town">Out of Town</option>
														</select>
													</div>
													<div class="col-md-6">
														<label>Leave Count</label>
														<input type="text" class="form-control" name="leave_count" placeholder="Enter Amount">
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
													<div class="col-md-6" style="display:none">
													    <label>File attachment</label>
														<input type="file" name="pto_attachment" class="form-control">
													</div>
													
												</div>

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="save_request" value="Save Data"/>
										</div>
										</form> 
									</div>
								</div>
							</div>

                            <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg10" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
								<div class="modal-dialog modal-lg modal-dialog-centered" >
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Update Leave</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<form autocomplete="off" method="post" action="<?php echo site_url('Pages/insert_leave_details/'); ?><?="3302655412"?><?= "/"?><?=$_SESSION['id'] ?>">  
										<div class="modal-body">
											<div class="container">

                                            <div class="row">
													<div class="col-md-6">
														<label>Type of leave</label>
                                                        <input type="hidden" name="leave_ids" id="leave_id">
														<input type="text" class="form-control" id="leave_type" name="leave_type"  placeholder="Enter type of leave">
													</div>
													<div class="col-md-6">
														<label>Leave Count</label>
														<input type="text" class="form-control" id="leave_count" name="leave_count" placeholder="Enter Amount">
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
														<label>Notes <span style="color:red">*</span></label>
														<textarea class="form-control" id="notes" name="notes" style="height:70px"></textarea>
													</div> 
													<div class="col-md-6">
														<label>Status <span style="color:red">*</span></label>
														<select name="approve_status" class="form-control">
														    <option value="0">For Approval</option>
														    <option value="3">For Cancel</option>
														</select>
													</div> 
												</div>
											

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" name="update_pto" value="Update"/>
										</div>
										</form> 
									</div>
								</div>
							</div>


							<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
<!--- Modal end --->
