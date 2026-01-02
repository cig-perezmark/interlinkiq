<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Payment Source </h4>
						

						<!---<button class="btn btn-primary" onclick="reset_pay()" style="position:absolute;right:4%">Start Process</button>--->
						<button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%" >Add Source</button>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Source ID</th>
									<th class="table-plus datatable-nosort">Source Name</th>
									<th>Source Notes</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
                                <?php foreach($records as $row): ?>
								<tr>
									<td style="" id="payeeid"><?= $row->sourceid ?></td>
									<td class="table-plus" id="fullname"><?= $row->sourcename ?></td>
									<td id="e_pay_rate"><?= $row->notes_source ?></td>
									
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/Pay_details/');?>"><i class="dw dw-eye"></i> View/Pay</a>
												<!---<button data-toggle="modal" data-target="#bd-example-modal-lg" class="dropdown-item" id="pay" pay_amount="<?= $row->pay_rate ?>" payee_id="<?= $row->payeeid?>"  href="#"><i class="dw dw-edit2"></i> Pay</button>--->
												<button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item" id="" href="#"><i class="dw dw-edit3"></i> Unpaid</button>
												<!---<a class="dropdown-item" href="<?php echo site_url('Pages/delete_record/');?><?= $row->payeeid?>"><i class="dw dw-delete-3"></i> Delete</a>--->
											</div>
										</div>
									</td>
								</tr>
                                <?php endforeach; ?>

							</tbody>
						</table>
					</div>
				</div>
                </div>
			</div>

				<!-- Simple Datatable End -->
