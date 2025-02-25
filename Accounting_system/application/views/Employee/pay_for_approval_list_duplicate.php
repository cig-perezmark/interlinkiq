<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
					<?php
    					$paid_date = $this->uri->segment(3);
						$fetch_pay_table = $this->User_model->query("SELECT * FROM pay INNER JOIN employee_details ON pay.payeeid = employee_details.payeeid  INNER JOIN start_cutoff ON start_cutoff.start_date = pay.start_date WHERE paiddate = '$paid_date'");
					?>
					<div class="pd-20 d-flex" style="justify-content:space-between">
						<h4 class="text-blue h4">Consultare - List of Employees</h4>
						<span class="text-blue h6">Payroll Period - <?= $fetch_pay_table[0]['pay_period'] ?></span>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Name</th>
									<th>Employment Status</th>
									<th>Department</th>
									<th>Bi-Monthly</th>
									<th>Net Pay</th>
									<th>Payment Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
						    <?php
						        foreach($fetch_pay_table as $row):
						        $payeeid = $row['payeeid'];
						            $employee = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee INNER JOIN others_employee_details ON others_employee_details.employee_id = tbl_hr_employee.ID INNER JOIN tbl_hr_department ON tbl_hr_department.ID = tbl_hr_employee.department_id  WHERE tbl_hr_employee.ID = '$payeeid' AND tbl_hr_employee.status = 1");
						            if($employee):
						            foreach($employee as $employee_row):
						    ?>
								<tr>
									<td><a href="#" id="view_employee" employee_id="<?= $row['payeeid'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg"><?=$employee_row['last_name']  ?><?= ", " ?><?= $employee_row['first_name'] ?></a></td>
									<td>
									    <?php
									        if($employee_row['type_id'] == 1){
									            echo "Fulltime";
									        }
									        if($employee_row['type_id'] == 2){
									            echo "Partime";
									        }
									        if($employee_row['type_id'] == 3){
									            echo "OJT";
									        }
									        if($employee_row['type_id'] == 4){
									            echo "Freelance";
									        }
									        if($employee_row['type_id'] == 5){
									            echo "OJT-Crossover";
									        }
									        if($employee_row['type_id'] == 6){
									            echo "Trainee";
									        }
									        if($employee_row['type_id'] == 7){
									            echo "Employment";
									        }
									    ?>
									</td>
									<td><?= $employee_row['title'] ?></td>
									<td><?= "$"; ?><?=  $row['pay_rate'] / 2 ?></td>
									<td><?= "$"; ?><?= $row['amount'] ?></td>
									<td id="status<?= $row['payeeid'] ?>">
									    <?php
									    if($row['paidstatus'] == "paid"){
                                            echo "<span class='badge badge-success'>Paid</span>";
                                        }
									    elseif($row['paidstatus'] == "forpay"){
                                            echo "<span class='badge' style='background-color:purple;color:#ffff'>forpay</span>";
                                        }
                                        elseif($row['paidstatus'] == "onhold"){
                                            echo "<span class='badge badge-danger'>onhold</span>";
                                        }
                                        elseif($row['paidstatus'] == "process"){
                                            echo " <span class='badge badge-primary'>process</span>";
                                        }
                                        elseif($row['paidstatus'] == "unpaid")
                                        {
                                            echo "<span class='badge badge-warning'>Unpaid</span>";
                                        }
                                        elseif($row['paidstatus'] == "approved")
                                        {
                                            echo "<span class='badge badge-warning' style='background-color:yellow;'>Reviewed</span>";
                                        }
									    ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" payid="<?= $row['payid'] ?>" data-toggle="modal" data-target="#show_modal"  id="view_pay_details"><i class="dw dw-edit2"></i> Edit</a>
												<button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item" id="" value="<?php echo $row['payeeid']; ?>" href="#"><i class="dw dw-edit3"></i> Unpaid</button>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/forpay"?>"><i class="icon-copy ion-android-navigate"  style="color:green"></i>Forpay</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/onhold"?>"><i class="icon-copy ion-ios-locked-outline" style="color:red"></i> Onhold</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/process"?>"><i class="icon-copy ion-load-c" style="color:blue"></i> Process</a>
												<a class="dropdown-item" href="<?php echo site_url('Pages/Update_pay/');?><?= $row['payid'] ?><?= "/approved"?>"><i class="icon-copy ion-load-c" style="color:blue"></i> Approved</a>
											</div>
										</div>
									</td>
								</tr>
								<?php endforeach;endif;endforeach; ?>
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
										<form id="myForm" autocomplete="off" method="post" action="<?php echo site_url('Pages/update_table/0/'.$this->uri->segment('3').'/updatepay'); ?>">  
										<div class="modal-body" id="modal_body">
											

											
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

			
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>			
<script>
$(document).ready(function(){
    $('#myForm').submit(function(event) {
      event.preventDefault(); // prevent the form from submitting
      var paidstatus = $('#dropdown_data').val();
      var payeeid = $('#payeeid').val();
      var formData = $(this).serialize(); // serialize the form data
      $.post('<?php echo site_url('Pages/update_table/0/'.$this->uri->segment('3').'/updatepay'); ?>', formData, function(response) {
        // handle the response from the server
        console.log(payeeid);
        if(paidstatus == "paid"){
            $('.data-table #status'+payeeid).html("<span class='badge badge-success'>Paid</span>");
        }
	    else if(paidstatus == "forpay"){
            $('.data-table #status'+payeeid).html("<span class='badge badge-success'>forpay</span>");
        }
        else if(paidstatus == "onhold"){
            $('.data-table #status'+payeeid).html("<span class='badge badge-danger'>onhold</span>");
        }
        else if(paidstatus == "process"){
            $('.data-table #status'+payeeid).html("<span class='badge badge-primary'>process</span>");
        }
        else if(paidstatus == "unpaid")
        {
            $('.data-table #status'+payeeid).html("<span class='badge badge-warning'>Unpaid</span>");
        }
        else if(paidstatus== "approved")
        {
            $('.data-table #status'+payeeid).html("<span class='badge badge-warning' style='background-color:yellow;'>Reviewed</span>");
        }
        $('#show_modal').modal('hide');
        ////$('.data-table #status'+payeeid).text(paidstatus);
      });
    });
    $('.data-table').on('click', '[id*="view_pay_details"]', function() {
        var payid = $(this).attr('payid'); //get the attribute value
        $.get("<?php echo site_url(); ?>Pages/get_employee_pay", 
        {
            payid: payid
        },
          function(data){
            // Display the returned data in browser
             $('#modal_body').html(data);
             
        });
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
