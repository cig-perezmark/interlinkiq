<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Total Hours Per Account</h4>
					</div>
					<div style="display:flex;justify-content:flex-end;margin-right:20px;margin-bottom:15px">
					    <a href="#" data-toggle="modal" data-target="#upload_invoice_modal">Upload Invoice</a>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
								
									<th class="table-plus datatable-nosort">Months</th>
                                    <th>Total Hours</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							    <?php if($get_month_invoice): foreach($get_month_invoice as $row):
							        $month = $row->month;
							        $monthNum = (int) $month;
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('F');  
							    ?>
							    <tr>
							        <td>December</td>
							        <td>150 Hours</td>
							        <td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/Pay_details');?>"><i class="dw dw-eye"></i> View</a>
											</div>
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


			

		


    <!-- Modal -->
    <div class="modal fade" id="upload_invoice_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Invoice</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method='POST' action="<?php echo site_url('Pages/importFile'); ?>" enctype="multipart/form-data">
             <input type='file' name='file' >
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type='submit'  class="btn btn-primary" value='Upload' name='upload'>
          </div>
            </form>
        </div>
      </div>
    </div>
