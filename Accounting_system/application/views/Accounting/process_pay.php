<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4">Consultare - Pay Period</h4>
					    </div>
						<div class="col-md-4"></div>
						<div class="col-md-4"><button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%">Start Process</button></div>
					</div>
					<div class="pb-20">
						<table class="table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Start Date</th>
									<th  class="datatable-nosort">End Date</th>
									<th  class="datatable-nosort">Pay Period</th>
									<th  class="datatable-nosort">Pay Period Status</th>
									<th  class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							    <?php
							        $get_date = $this->User_model->query("SELECT * FROM start_cutoff ORDER BY id DESC");
							        if($get_date):
							        foreach($get_date as $row):
							    ?>
								<tr>
									<td><?= $row['start_date'] ?></td>
									<td><?= $row['cutoff_date'] ?></td>
									<td><?= $row['pay_period'] ?></td>
									<td>
									    <?php if($row['flag'] == 0): ?>
									        <span class="badge badge-warning">For Draft</span>
									    <?php elseif($row['flag'] == 1): ?>
									        <span class="badge badge-warning" style="background-color:yellow">For Review</span>
									    <?php elseif($row['flag'] == 2): ?>
									        <span class="badge badge-primary">Reviewed</span>
									   <?php elseif($row['flag'] == 3): ?>
									        <span class="badge badge-success">Paid</span>
									    <?php endif; ?>
									 </td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/process_pays/')?><?=$row['cutoff_date'] ?>"><i class="dw dw-eye"></i> View/set</a>
						                        <a class="dropdown-item"  onclick="done(<?= $row['id'] ?>)"  ><i class="dw dw-check"></i> Done</a>
										</div>
									</td>
								</tr>
								<?php endforeach;endif; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>

<!--- Modal start --->
	<div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:90% !important">
    	<div class="modal-dialog modal-lg modal-dialog-centered" >
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="myLargeModalLabel">Process Date</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			</div>
    			<form autocomplete="off" method="post" action="<?php echo site_url('Pages/process_new'); ?>">  
    			<div class="modal-body">
    				<div class="container">
    					<div class="row">
    					    <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" class="form-control" id="" name="start_date"  placeholder="Enter Amount">
    						</div>
    						<div class="col-md-6">
    							<label>End Date</label>
    							<input type="date" class="form-control" id="" name="paid_date"  placeholder="Enter Amount">
    						</div>
    					</div>
    				    <div class="row mt-3">
    						<div class="col-md-6">
    							<label>Pay Period</label>
    							<input type="date" class="form-control" id="" name="pay_period"  placeholder="Enter Amount">
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

function done(id){
    let text = "Update this record ?";
    if (confirm(text) == true) {  
     	var location = "<?php echo site_url("Pages/update_pay_period/2/"); ?>"+id;
        window.location.href = location;
    }
}

</script>
