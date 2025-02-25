<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
					<div class="pd-20 d-flex">
                        <div class="col-md-4">
                            <label>Select Date </label>
                            <input type="hidden" id="start" name="start" value=""id="">
                            <select name="start" class="form-control" id="select_date">
                                <option cutoff_date="" value=""> Please Select Date</option>
                                <?php foreach($date_cutoff as $row): ?>
                                <option cutoff_date="<?= $row['paiddate'] ?>" value="<?= $row['paiddate'] ?>"> <?= $row['paiddate'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%">Start Process</button></div>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Id</th>
									<th class="table-plus datatable-nosort">Name</th>
									<th>Position</th>
									<th>Pay Rate</th>
									<th>Company Email</th>
									<th>Employee Level</th>
									<th>Payment Date</th>
									<th>Paid Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="tr_content">

							</tbody>
						</table>
						<div class="btn_submit" style="margin-top:25px;">
							<a href="#" class="btn btn-primary" onclick="export_pay()" type="button">Export Pays</a>
							<a href="#" class="btn btn-primary" onclick="for_approval()" type="button">For Approval</a>
						</div>
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
												    <div class="col-md-4">
                                                        <label>Start Date</label>
                                                        <input type="date" class="form-control" id="" name="start_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														<label>End Date</label>
														<input type="date" class="form-control" id="" name="paid_date"  placeholder="Enter Amount">
													</div>
													<div class="col-md-4">
														
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
$(document).ready(function(){
    $('[id*="select_date"]').change(function(){
        var start_dates = $("#select_date :selected").val();
        var cutoff_date = $("#select_date :selected").attr("cutoff_date");
        $('#start').val(cutoff_date);
        $.get("<?php echo site_url(); ?>Pages/get_payment_history", 
        {
            start_date: start_dates,
            cutoff_date: cutoff_date,
        },
          function(data){
            // Display the returned data in browser
             $('#tr_content').html(data);
            //  console.log('done : ' + data);  
        });
    });
});

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
function for_approval(){
let text = "Submit for approval ?";
  if (confirm(text) == true) {  

 			var start = document.getElementById('start').value
		
// 			
 			var location = "<?php echo site_url("Pages/update_flag_status/"); ?>"+start;
 			 window.location.href = location;
// 			//alert(location)
// 			//window.location.href = "<?php echo site_url('Pages/exportPays'); ?>"

	}
}
</script>
