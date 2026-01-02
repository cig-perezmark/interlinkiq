<div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.html">
				<img src="../vendors/images/logo.png" alt="" class="dark-logo">
				<img src="../vendors/images/logo.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
				    <?php if($this->session->userdata('username') == 'Employee'): ?>
				    <li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
						<ul class="submenu">
                            <?php if( $this->session->userdata('fullname') == "Pena, Christine Joy" ):?>
                                <li><a href="<?php echo site_url('Pages/get_for_approve_pay'); ?>">VA Payroll</a></li>
                                <li><a href="<?php echo site_url('Pages/for_approve_request'); ?>">For Approval</a></li>
                                <?php elseif($this->session->userdata('fullname') == "Dahino, Cristina"): ?>
                                <li><a href="<?php echo site_url('Pages/approve_pay'); ?>">VA Payroll</a></li>
                            <?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>
				    <?php if($this->session->userdata('username') == 'Accounting'): ?>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
						<!-- <ul class="submenu">
							<li><a href="<?php echo site_url('Pages/Accounting_dashboard'); ?>">Payment History</a></li>
						</ul> -->
						<ul class="submenu">
							<li><a href="<?php echo site_url('Pages/Accounting_PTO'); ?>">List of PTO</a></li>
						</ul>
					</li>			
	
					<li class="dropdown" style="display:none">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-analytics-21"></span><span class="mtext"></i> Payment</span>
						</a>
						<ul class="submenu">
							<!---<li><a href="<?php echo site_url('Pages/employee_payrate'); ?>">Deductions</a></li>--->
							<li><a href="<?php echo site_url('Pages/get_employeebudget'); ?>">Employee Budget History</a></li>
							<li><a href="<?php echo site_url('Pages/monthly_budget_summary'); ?>">Monthly-Yearly Budget</a></li>
							<li><a href="<?php echo site_url('Pages/payment_history'); ?>">Payment History</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-analytics-21"></span><span class="mtext"></i> Payment Process</span>
						</a>
						<ul class="submenu">
							<li><a href="<?php echo site_url('Pages/process_payment/Consultare'); ?>">Consultare</a></li>
							<li><a href="<?php echo site_url('#'); ?>">InterlinkIQ</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-user1"></span><span class="mtext"></i> Employee</span>
						</a>
						<ul class="submenu">
							<li><a href="<?php echo site_url('Pages/Accounting_employee'); ?>">Employee List</a></li>
							<li><a  href="#" data-toggle="modal" data-target="#generate_employee_logs_modal">Generate Service Logs</a></li>
						</ul>
					</li>
					<?php endif; ?>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-user1"></span><span class="mtext"></i>Invoice</span>
						</a>
						<ul class="submenu">
							<li><a href="#" data-toggle="modal" data-target="#generate_logs_modal">Service Logs</a></li>
                            <li><a href="<?php echo site_url('Pages/accounting_invoice'); ?>">Accounts</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-user1"></span><span class="mtext"></i>Payroll</span>
						</a>
						<ul class="submenu">
                            <li><a href="<?php echo site_url('Pages/generate_summary'); ?>">Payroll Summary</a></li>
                            <!--<li><a href="<?php echo site_url('Pages/monthly_summary'); ?>">Monthly Summary</a></li>-->
                            <li><a href="<?php echo site_url('Pages/monthly_invoice'); ?>">Payroll Summary Report</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-user1"></span><span class="mtext"></i>Payslip</span>
						</a>
						<ul class="submenu">
                            <li><a href="<?php echo site_url('Pages/Accounting_employee_payslip'); ?>">Active Employee</a></li>
                            <li><a href="<?php echo site_url('Pages/Accounting_employee_payslip_inactive'); ?>">In-active Employee</a></li>
						</ul>
					</li>
					
					 <!-- almario -->

                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-user1"></span><span class="mtext"></i>Expenses</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo site_url('expenses/form'); ?>">Expense Form</a></li>
                            <li><a href="<?php echo site_url('expenses/summary'); ?>">Summary Report</a></li>
                        </ul>
                    </li>
			</ul>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
    <div class="modal fade" id="generate_logs_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Generate Logs</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label>From</label>
                        <input id="from" type="date" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>To</label>
                        <input id="to" type="date" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <select id="account" class="form-control">
                        // <?php $rows = $this->Interlink_model->query("SELECT DISTINCT account FROM tbl_service_logs");
                        //     foreach($rows as $row){
                        //         echo '
                        //             <option value="'.$row['account'].'" >'.$row['account'].'</option> 
                        //         ';
                        //     }
                        // ?>
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="generate_logs()" class="btn btn-primary">Generate</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="generate_employee_logs_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Generate Logs</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label>From</label>
                        <input id="from1" type="date" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>To</label>
                        <input id="to1" type="date" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <select id="employee_id" class="form-control">
                            <?php
                                $rows = $this->Interlink_model->query("SELECT tbl_user.ID AS logs_id, tbl_user.*, tbl_hr_employee.*
                                FROM tbl_user
                                INNER JOIN tbl_hr_employee ON tbl_hr_employee.ID = tbl_user.employee_id
                                WHERE tbl_user.is_active = 1
                                  AND tbl_hr_employee.user_id = 34
                                  AND tbl_hr_employee.status = 1;
                                ");
                                foreach($rows as $row):
                            ?>
                                <option value="<?= $row['logs_id'] ?>"><?= $row['first_name'] .' '. $row['last_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="generate_employee_logs()" class="btn btn-primary">Generate</button>
          </div>
        </div>
      </div>
    </div>
    
<script>
$(document).ready(function(){
    $('#to').change(function(){
        var from = $('#from').val();
        var to = $('#to').val();
        $.get("<?php echo site_url(); ?>Pages/get_active_accounts", 
        {
            from: from,
            to: to
        },
          function(data){
            // Display the returned data in browser
            $('#account').html(data);
            //console.log('done : ' + data);  
        });
    }); 
});

    function generate_logs() {
                let text = "Do you want to generate logs ?";
                if (confirm(text) == true) {  
                    var account = document.getElementById('account').value
                    var encodedAccountName = encodeURIComponent(account).replace(/[()]/g, function(c) {
          return '%' + c.charCodeAt(0).toString(16);
        });
                    var from = document.getElementById('from').value
                    var to = document.getElementById('to').value
                    var location = "<?php echo site_url("Pages/generate_logs/"); ?>"+encodedAccountName+'/'+from+'/'+to;
                    window.location.href = location;
                }
    }
    function generate_employee_logs() {
                let text = "Do you want to generate logs ?";
                if (confirm(text) == true) {  
                    var employee_id = document.getElementById('employee_id').value
                    var from = document.getElementById('from1').value
                    var to = document.getElementById('to1').value
                    var location = "<?php echo site_url("Pages/generate_employee_logs/"); ?>"+employee_id+'/'+from+'/'+to;
                    window.location.href = location;
                }
    }
</script>
