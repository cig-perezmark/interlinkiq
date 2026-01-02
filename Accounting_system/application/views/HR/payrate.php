<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">List of Payment Rates</h4>
						<?php if(isset($_SESSION['alert_message'])): ?>
						<div class="alert_message" style="width:70%;height:50px;background-color: rgba(50, 200, 0, 0.8);margin-left:2%;text-align:center;padding:20px;z-index:1;">
							<span style="padding:20px"><?= $_SESSION['alert_message'] ?></span>
							<?php  //unset success
					                    unset($_SESSION['alert_message']); ?>
						</div>
						<?php endif; ?>

					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Status Name</th>
									<th>30 Day</th>
                                    <th>60 Day</th>
                                    <th>90 Day</th>
                                    <th>120 Day</th>
                                    <th>150 Day</th>
                                    <th>6 Months</th>
                                    <th>12 Months</th>
                                    <th>0-250 Hour</th>
                                    <th>250 Hour</th>
                                    <th>Crossover</th>
                                    <th>Monthly</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($records as $row): ?>
								<tr>
									<td class="table-plus"><?= $row->statusname ?></td>
									<td><?= $row->Day30?></td>
                                    <td><?= $row->Day60?></td>
                                    <td><?= $row->Day90?></td>
                                    <td><?= $row->Day120?></td>
                                    <td><?= $row->Day150?></td>
                                    <td><?= $row->Month6?></td>
                                    <td><?= $row->Month12?></td>
                                    <td><?= $row->Hour0250?></td>
                                    <td><?= $row->Hour0250?></td>
                                    <td><?= $row->CrossOver?></td>
                                    <td><?= $row->Monthly?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
												<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
