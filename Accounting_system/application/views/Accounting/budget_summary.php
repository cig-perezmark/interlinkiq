<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
						<h4 class="text-blue h4">Budget Summary</h4>
					
						<!---<button class="btn btn-primary" onclick="reset_pay()" style="position:absolute;right:4%">Start Process</button>--->

					</div>
					<div class="pb-20">
						<table class=" table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Month</th>
									<th>Amount</th>
									<!---<th>Payment Status</th> --->
									<th class="datatable-nosort">Action</th> 
								</tr>
							</thead>
							<tbody>
                         
                            <?php foreach($monthly_budget as $row): $month = $row->month;

                                
                                    $monthNum = (int) $month;
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('F');   
                                    if(!empty($monthNum) OR $monthNum !=0)
                                    {

                                    
                                   // echo $monthName;
                                     echo " <tr>";
                                    echo "<td class='table-plus'>$monthName</td>";
                                    echo "<td>$ $row->total_amount</td>";
                                    ?>
								    <td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="<?php echo site_url('Pages/post/');?><?= $row->month?>"><i class="dw dw-eye"></i> View</a>
												<!---<button data-toggle="modal" data-target="#bd-example-modal-lg" class="dropdown-item" id="pay" pay_amount="<?= $row->pay_rate ?>" payee_id="<?= $row->payeeid?>"  href="#"><i class="dw dw-edit2"></i> Pay</button>--->
												<!---<a class="dropdown-item" href="<?php echo site_url('Pages/delete_record/');?><?= $row->payeeid?>"><i class="dw dw-delete-3"></i> Delete</a>--->
											</div>
										</div>
									</td> 
                                
                                   
								</tr>
                            <?php } endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
