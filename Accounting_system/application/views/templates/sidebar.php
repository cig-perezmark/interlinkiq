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
							<li><a href="<?php echo site_url('Pages/HR_Dashboard'); ?>">List of Employees</a></li>
							<li><a href="<?php echo site_url('Pages/employee_deactivated'); ?>">List of Employees Deactivated</a></li>
							<li><a href="<?php echo site_url('Pages/pto_request'); ?>">Request PTO's</a></li>
							<li><a href="<?php echo site_url('Pages/Attendance'); ?>">Attendance</a></li>
						</ul>
					</li>			
	
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-analytics-21"></span><span class="mtext"></i> Payment</span>
						</a>
						<ul class="submenu">
							<li><a href="<?php echo site_url('Pages/HR_pay_source'); ?>">Payment Source</a></li>
							<li><a href="<?php echo site_url('Pages/employee_payrate'); ?>">Pay Rate</a></li>

						</ul>
					</li>
			</ul>
			</div>
		</div>
	</div>
