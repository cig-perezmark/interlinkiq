<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Employee Budget History </h4>
				
						<!---<button class="btn btn-primary" onclick="reset_pay()" style="position:absolute;right:4%">Start Process</button>--->
						<!---<button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%">Start Process</button> --->
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
								
									<th class="table-plus datatable-nosort">Name</th>
                                    <th>Amount</th>
									<th>Position</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($employee_budget as $row):
							?>
								<tr>
									
									<td class="table-plus" id="fullname"><?= $row->fullname ?></td>
                                    <td style="" id="payeeid"><?php echo $row->total_amount ?></td>
									<td><?= $row->position ?></td>
								
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/Pay_details/');?>"><i class="dw dw-eye"></i> View</a>
											</div>
										</div>
									</td>
								</tr>
								<?php
									endforeach;
								?>

							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
