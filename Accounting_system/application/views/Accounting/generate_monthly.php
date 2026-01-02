<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4">Monthly Summary</h4>
					    </div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th>Basic Pay</th>
									<th>Incentives</th>
									<th>Comission</th>
									<th>Referal</th>
									<th>Ajudstment</th>
									<th>Deductions</th>
									<th>Gross Pay</th>
									<th>Net Pay</th>
								</tr>
							</thead>
							    <?php
							        $from = $_POST['from'];
							        $to = $_POST['to'];
							        $amount = 0;
							        $incentives = 0;
							        $total_comission = 0;
							        $referal = 0;
							        $total_deduction = 0;
							        $adjust = 0;
							        $result = $this->User_model->query("SELECT payeeid,SUM(adjustment) as adjustment , SUM(comission) as comission , SUM(pay_rate) as amount ,  SUM(incentives) as incentives,SUM(comission) as comission,SUM(royaltee) as royaltee FROM pay WHERE paiddate >= '$from' AND paiddate <= '$to' GROUP BY payeeid ");  
							        foreach($result as $row):
							        $amount += $row['amount'];
							        $incentives += $row['incentives'];
							        $total_comission += $row['comission'];
							        $referal += $row['royaltee'];
							        $comission = $row['comission'];
							        $payeeid = $row['payeeid'];
							        $adjust += $row['adjustment'];
							        $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE payeeid = $payeeid AND date_paid >= '$from' AND date_paid <= '$to' GROUP BY payeeid");
							        $payee_name = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = $payeeid");  
							        
							        $dedu = 0;
					                if($deduction){
					                    $total_deduction += $deduction[0]['user_deduction'];
					                    $dedu = $deduction[0]['user_deduction'];;
					                }
							    ?>
							    <?php endforeach; ?>
							    <?php 
							        $total = $amount + $incentives +  $total_comission + $referal + $comission;
							        $total_net = $amount + $incentives +  $total_comission + $referal  - $total_deduction;
							        $total_result =  number_format((float)$total, 2, '.', '')
							    ?>
							<tbody>
                                <tr>
                                  <td><?= "$" ?><?= $amount ?></td>
                                  <td><?= "$" ?><?= $incentives ?></td>
                                  <td><?= "$" ?><?=  number_format((float)$total_comission, 2, '.', '') ?></td>
                                  <td><?= "$" ?><?= $referal ?></td>
                                  <td><?= number_format((float)$adjust, 2, '.', '') ?></td>
                                  <td><?= "$" ?><?= $total_deduction ?></td>
                                  <td><?= "$" ?><?= $total_result ?></td>
                                  <td><?= "$" ?><?=  number_format((float)$total_net, 2, '.', '') ?></td>
                                </tr>
                            </tbody>
						</table>
					</div>
				</div>
				</div>
			</div>

<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>
