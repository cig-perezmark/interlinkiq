<?php
    $from = $_POST['from'];
    $to = $_POST['to'];
?>
	<div class="main-container">
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        	<!-- Simple Datatable start -->
        	<div class="card-box mb-30" style="overflow-x:auto">
				<div class="pd-20 d-flex">
				    <div class="col-md-6">
				        <h4 class="text-blue h4">Payroll Summary - <?= $from .'/'. $to ?></h4>
				    </div>
					<div class="col-md-6"></div>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap" id="pay_summary">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">Full Name</th>
								<th>Basic Pay</th>
								<th>Hourly</th>
								<th>Incentives</th>
								<th>Comission</th>
								<th>Referal</th>
								<th>Other Fees</th>
								<th>Ajudstment (+)</th>
								<th>Gross Pay</th>
								<th>Ajudstment (-)</th>
								<th>Deductions</th>
								<th>Processing Fee</th>
								<th>Net Pay</th>
								<th style="display:none">Net Pay</th>
							</tr>
						</thead>
						<tbody>
						    <?php
						        $pay_rate = 0;
						        $transfer_fee = 0;
						        $incentives = 0;
						        $total_comission = 0;
						        $referal = 0;
						        $total_deduction = 0;
						        $adjust = 0;
						        $other_fee = 0;
						        $new_adjustment_sum = 0;
						        $new_adjustment_deduc = 0;
						        $result = $this->User_model->query("SELECT payeeid,SUM(pay_rate) as pay_rate,SUM(hourly_rate) as hourly_rate,SUM(transfer_fee) as transfer_fee,SUM(other_fees) as other_fees, SUM(adjustment) as adjustment , SUM(comission) as comission , SUM(pay_rate) as amount ,  SUM(incentives) as incentives,SUM(comission) as comission,SUM(royaltee) as royaltee FROM pay WHERE  paidstatus IN ('process', 'paid') AND paiddate >= '$from' AND paiddate <= '$to' GROUP BY payeeid ");  
						        foreach($result as $row):
						        $pay_rate += $row['pay_rate'];
						        $hourt_rate += $row['hourly_rate'];
						        $transfer_fee += $row['transfer_fee'];
						        $incentives += $row['incentives'];
						        $total_comission += $row['comission'];
						        $referal += $row['royaltee'];
						        $adjust += $row['adjustment'];
						        $comission = $row['comission'];
						        $payeeid = $row['payeeid'];
						        $adjustment = $row['adjustment'];
						        $other_fee += $row['other_fees'];
						        $adjustment_sum = 0;
						        $adjustment_deduct = 0;
						        if($row['adjustment'] < 0 ){
						            $adjustment_deduct = $row['adjustment'];
						            $new_adjustment_deduc += $row['adjustment'];
						        }
						        else{
						            $new_adjustment_sum += $row['adjustment'];
						            $adjustment_sum = $row['adjustment'];
						        }
						        
						        $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE payeeid = $payeeid AND date_paid >= '$from' AND date_paid <= '$to' GROUP BY payeeid");
						        $payee_name = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = $payeeid");  
						        $gross_final_pay = $row['amount'] + $row['incentives'] + $comission + $row['royaltee'] + $adjustment_sum + $row['other_fees'];
						    ?>
						    <tr>
						        
						        <td>
						            <?php
						                if($payee_name){
						                    echo $payee_name[0]['last_name'] .' '. $payee_name[0]['first_name'];
						                }
						            ?>
						        </td>
						        <td><?= "$" ?><?= $row['pay_rate'] ?></td>
						        <td><?= "$" ?><?= $row['hourly_rate'] ?></td>
						        <td><?= "$" ?><?= $row['incentives'] ?></td>
						        <td><?= "$" ?><?= number_format((float)$comission, 2, '.', '') ?></td>
						        <td><?= "$" ?><?= number_format((float)$row['royaltee'], 2, '.', '') ?></td>
						        <td><?= "$" ?><?= number_format((float)$row['other_fees'], 2, '.', '') ?></td>
						        <td><?= number_format((float)$adjustment_sum, 2, '.', '') ?></td>
						        <td><?= number_format((float) $gross_final_pay, 2, '.', '')  ?> </td>
						        <td>
						            <?php
						                if ($adjustment_deduct < 0) {
                                            $formattedValue = '$ (' . number_format(abs($adjustment_deduct), 2, '.', '') . ')'; // Remove negative sign, add dollar sign, and enclose in parentheses
                                        } else {
                                            $formattedValue = '$' . number_format($adjustment_deduct, 2, '.', ''); // Add dollar sign for positive value
                                        }
                                        echo $formattedValue;
						            ?>
						     </td>
						        <td>
						            <?php
						                $dedu = 0;
						                if($deduction){
						                    $total_deduction += $deduction[0]['user_deduction'];
						                    echo "$";echo $deduction[0]['user_deduction'];
						                    $dedu = $deduction[0]['user_deduction'];;
						                }
						            ?>
						        
						        </td>
						        <td><?= number_format((float)$row['transfer_fee'], 2, '.', '') ?></td>
						        <td><?=  number_format((float) $gross_final_pay - $dedu + $adjustment_deduct - $row['transfer_fee'], 2, '.', '') ?> </td>
						    </tr>
						    <?php endforeach; ?>
						    <?php 
						        $sum_adjust = 0;
						        $deduct_adjust = 0;
						        if($adjust < 0 ){
						            $deduct_adjust = $adjust;
						        }
						        
						        else{
						            $sum_adjust = $adjust;
						        }
						        $total = $pay_rate + $incentives +  $total_comission + $referal + $comission + $other_fee + $new_adjustment_sum;
						        $total_net = $total  - $total_deduction + $other_fee + $deduct_adjust;
						        $total_result =  number_format((float)$total, 2, '.', '');
						    ?>
						</tbody>
						<tfoot>
                            <tr>
                              <td></td>
                              <td><?= "$" ?><?= $pay_rate ?></td>
                              <td><?= "$".''.$hourt_rate ?></td>
                              <td><?= "$" ?><?= $incentives ?></td>
                              <td><?= "$" ?><?=  number_format((float)$total_comission, 2, '.', '') ?></td>
                              <td><?= "$" ?><?= $referal ?></td>
                              <td><?= "$" ?><?= number_format((float)$other_fee, 2, '.', '')   ?></td>
                              <td><?= "$" ?><?=  number_format((float)$new_adjustment_sum, 2, '.', '') ?></td>
                              <td><?= "$" ?><?= $total_result ?></td>
                              <td>
                                    <?php
						                if ($new_adjustment_deduc < 0) {
                                            $formattedValue1 = '$ (' . number_format(abs($new_adjustment_deduc), 2, '.', '') . ')'; // Remove negative sign, add dollar sign, and enclose in parentheses
                                        } else {
                                            $formattedValue1 = '$' . number_format($new_adjustment_deduc, 2, '.', ''); // Add dollar sign for positive value
                                        }
                                        echo $formattedValue1;
						            ?>
                              </td>
                              <td><?= "$" ?><?= $total_deduction ?></td>
                              <td><?= "$".''.number_format((float)$transfer_fee, 2, '.', '') ?></td>
                              <?php
                                // Convert the necessary variables to float if they are strings
                                $total_net = floatval($total_net);
                                $transfer_fee = floatval($transfer_fee);
                                $formattedValue1 = floatval($formattedValue1);
                                
                                $total = floatval($total);
                                $total_deduction = floatval($total_deduction);
                                $new_adjustment_deduc = floatval($new_adjustment_deduc);
                                $transfer_fee = floatval($transfer_fee);
                                
                                // Convert $new_adjustment_deduc to its negative value
                                $new_adjustment_deduc = -$new_adjustment_deduc;
                                
                                // Perform the subtraction with parentheses to enforce order of operations
                                $totalAmount_net = $total - $total_deduction - $new_adjustment_deduc - $transfer_fee;// Perform the subtraction
                                $totalAmount_net = $total - $total_deduction - ($new_adjustment_deduc) -$transfer_fee ;
                                ?>
                              <td><?= "$" ?><?=  number_format((float) $totalAmount_net, 2, '.', '') ?></td>
                            </tr>
                        </tfoot>
					</table>
				</div>
			</div>
        </div>
	</div>
</div>
<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        
        var tbody = $('tbody');

        var rows = tbody.find('tr').get();
        rows.sort(function(a, b) {
            var keyA = $(a).find('td:first').text().toUpperCase();
            var keyB = $(b).find('td:first').text().toUpperCase();

            return keyA.localeCompare(keyB);
        });

        $.each(rows, function(index, row) {
            tbody.append(row);
        });
    });
</script>
