<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4">Payroll Summary</h4>
					    </div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					<form action="<?php echo site_url("Pages/payroll_summary/"); ?>" method="POST">
					<div class="pb-20">
						<div class="container">
						    <div class="row">
    						    <div class="col-md-6">
    						        <label>From</label>
    						        <input type="date" class="form-control" name="from">
    						    </div>
    						    <div class="col-md-6">
    						        <label>To</label>
    						        <input type="date" class="form-control" name="to">
    						    </div>
						    </div>
						    <div class="row mt-5">
						        <div class="col-md-12" style="display:flex;justify-content:flex-end">
						            <button class="btn btn-primary">See Summary</button>
						        </div>
						    </div>
						</div>
					</div>
				</div>
				</form>
				</div>
			</div>

<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
