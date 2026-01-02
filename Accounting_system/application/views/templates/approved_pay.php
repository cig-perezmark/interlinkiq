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
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
						<ul class="submenu">
                            <li><a href="<?php echo site_url('Pages/approve_pay'); ?>">VA Payroll</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-user1"></span><span class="mtext"></i>Invoice</span>
						</a>
						<ul class="submenu">
							<li><a href="#" data-toggle="modal" data-target="#generate_logs_modal">Service Logs</a></li>
                            <li><a href="<?php echo site_url('Pages/accounting_invoice'); ?>">Accounts</a></li>
                            <li><a href="<?php echo site_url('Pages/generate_summary'); ?>">Payroll Summary</a></li>
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
