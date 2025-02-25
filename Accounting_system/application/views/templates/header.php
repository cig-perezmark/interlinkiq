<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>HR + Accounting System</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/vendors/styles/style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="<?php echo base_url(); ?>css/js/ajax.js"></script>
    <script>
		$(document).ready(function() {
		setInterval(function(){
			fade();
			},100);
		function fade(){
			$(".alert_message").fadeOut(50);
			}
		});
    </script>


	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
	<style>
        .col-form-label {
            color: #000;
        }
        
        .form-control,
        .form-group *:not([role=presentation]) {
            border-color: #555 !important;
            font-size: 16px;
        }
    </style>
</head>
<?php 
ini_set('display_errors', 0);


if (!$this->session->has_userdata('user_type_id')){
  redirect('Login/user_login');
} 

?>
<body>
	 

	<?php if(isset($_SESSION['alert_message3'])): ?>

		<div class="pre-loader">
		<div class="pre-loader-box">
        <div class="loader-logo"><img src="<?php echo site_url(); ?>css/vendors/images/Logo.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div> 

							<?php  //unset success
					                    unset($_SESSION['alert_message3']); ?>
						
	<?php endif; ?>

	<div class="header d-print-none">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			
		</div>
		<div class="header-right">
			<div class="user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
						<i class="icon-copy dw dw-notification"></i>
						<?php
						    if($this->session->userdata('fullname') == 'Accounting Department'){
			                   $count = $this->Interlink_model->query("SELECT COUNT(*) AS record_count FROM others_notification WHERE is_read = 0");
			                }
			                if($this->session->userdata('fullname') == 'Dahino, Cristina'){
			                   $count = $this->Interlink_model->query("SELECT COUNT(*) AS record_count FROM others_notification WHERE user_1 = 0");
			                }
			                if($this->session->userdata('fullname') == 'Pena, Christine Joy'){
			                   $count = $this->Interlink_model->query("SELECT COUNT(*) AS record_count FROM others_notification WHERE user_2 = 0");
			                }
                            $recordCount = $count[0]['record_count'];
                            if ($recordCount >= 1):
						?>
						<span class="badge notification-active"></span>
						<?php endif; ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
							<ul id="notification-list">
							    <?php
							        $notification = $this->Interlink_model->query("SELECT n.* FROM others_notification AS n INNER JOIN ( SELECT employee_id, MAX(id) AS max_id FROM others_notification WHERE notification_message != ''  GROUP BY employee_id ) AS max_ids ON n.id = max_ids.max_id ORDER BY n.id DESC LIMIT 10;");
							        if($notification):
							        foreach($notification as $row):
							                $employee_id = $row['employee_id'];
							                if($this->session->userdata('fullname') == 'Accounting Department'){
							                   $is_read = $row['is_read']; 
							                }
							                if($this->session->userdata('fullname') == 'Dahino, Cristina'){
							                   $is_read = $row['user_1']; 
							                }
							                if($this->session->userdata('fullname') == 'Pena, Christine Joy'){
							                   $is_read = $row['user_2']; 
							                }
							                $notification_message = $row['notification_message'];
							                $updated_date = $row['updated_date']; 
							                $data = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$employee_id' AND status = 1 ");
							    ?>
								<li>
									<a href="<?php echo site_url('Pages/bank_comparison/'.$employee_id); ?>">
										<img src="vendors/images/img.jpg" alt="">
										<?php if($is_read == 0): ?>
										    <h3><?= $data[0]['first_name'] ?> <?= " " ?><?= $data[0]['last_name'] ?></h3>
										   <?php else: ?>
										   <span><?= $data[0]['first_name'] ?> <?= " " ?><?= $data[0]['last_name'] ?></span>
										<?php endif; ?>
										<p>Hi Accounting, <?= $data[0]['first_name'] ?> <?= " " ?><?= $data[0]['last_name'] ?> updated his/her <?= $notification_message ?> <br> <span style="font-size:9px">On <?= $updated_date ?></span></p>
									</a>
								</li>
								<?php
								     endforeach; endif;
								?>
							</ul>
						</div>
						<div style="display:flex;justify-content:center">
						    <a href="<?php echo site_url('Pages/notification/')?>">View all</a>
						</div>
					</div>
				</div>
			</div>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-name"><?= $this->session->userdata('fullname') ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
					    <?php if($this->session->userdata('user_type_id') == 2 OR $this->session->userdata('user_type_id') == 1 ): ?>
						    <a class="dropdown-item" href="<?php echo site_url('Pages/Employee_dashboard'); ?>"><i class="dw dw-user1"></i> Profile</a>
						<?php endif; ?>
						<a class="dropdown-item" href="<?php echo site_url('Login/logout'); ?>"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
			<div class="github-link">
				<a href="https://github.com/dropways/deskapp" target="_blank"><img src="vendors/images/github.svg" alt=""></a>
			</div>
			
		</div>
	</div>

<script>
$(document).ready(function() {
    var page = 1; // Initialize the page number
    var isLoading = false; // To prevent multiple AJAX requests

    // Function to load more notifications
    function loadMoreNotifications() {
        if (isLoading) {
            return;
        }

        isLoading = true;

        // Send an AJAX request to fetch more notifications
        $.ajax({
            url: '<?php echo site_url(); ?>Pages/load_notification', // Replace with your actual backend endpoint
            method: 'POST',
            data: { page: page },
            success: function(response) {
                // Append the new notifications to the list
                $('#notification-list').append(response);
                page++; // Increment the page number
                isLoading = false;
            }
        });
    }

    // Detect when the user scrolls to the bottom of the container
    $('.customscroll').scroll(function() {
        var container = $(this);
        alert('test');
        // if (container[0].scrollHeight - container.scrollTop() === container.outerHeight()) {
        //     loadMoreNotifications();
        // }
    });
});
</script>
