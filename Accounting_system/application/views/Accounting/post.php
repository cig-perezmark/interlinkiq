<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Payment History </h4>
					

						<!---<button class="btn btn-primary" onclick="reset_pay()" style="position:absolute;right:4%">Start Process</button>--->
						<a class="btn btn-primary" style="position:absolute;right:4%" href="<?php echo site_url('Pages/export/');?><?= $monthly_budget_info?>">Export</a>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Id</th>
									<th class="table-plus datatable-nosort">Name</th>
                                    <th>Amount Paid</th>
                                    <th>Date Paid</th>
                                     <th>Source</th>
									<!---<th>Payment Status</th> --->
				
								</tr>
							</thead>
							<tbody>
                            <?php foreach($monthly_budget_details as $row): ?>
								<tr>
									<td style="" id="payeeid"><?= $row->payid ?></td>
									<td class="table-plus" id="fullname"><?= $row->fullname ?></td>
                                    <td style="" id="payeeid"><?= $row->amount ?></td>
                                    <td style="" id="payeeid"><?= $row->paiddate ?></td>
                                    <td style="" id="payeeid"><?= $row->sourcename ?></td>
								
								</tr>
                                <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
