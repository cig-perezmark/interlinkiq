<style>
    @media print {
        .form-control {
            border:none !important;
        }
        .dataTables_filter{
            display:none;
        }
        .dataTables_length{
            display:none;
        }
        
        .pagination{
            display:none;
        }
        .dataTables_info{
            display:none;
        }
        .label_title{
            font-size:20px;
        }
        .company_logo{
            display:flex !important;
        }
        @page {
                size: landscape;
            }
    }
</style>

<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						<div class="col-md-12 company_logo" style="display:none">
						    <div style="display:grid;padding-top:10px;padding-bottom:20px">
						        <div  id="company_logo" style="display:flex;justify-content:space-between;align-items:center">
						            <div style="display:flex;align-items:center">
						                <img src="https://interlinkiq.com/companyDetailsFolder/394227%20-%20cig.png"> <label style="font-size:24px;font-weight:500">Consultare Inc. Group</label>
						            </div>
						            <div>
						                <label style="font-size:24px;font-weight:800;text-align:center;display:flex;justify-content:center;margin-left:85px">Payroll Summary Report</label>
						            </div>
						            <div style="display:flex;justify-content:flex-end">
						                <?php
                                        $currentDate = date('Y-m-d');
                                        echo '<label style="font-size:24px;font-weight:600;text-align:center;display:flex;justify-content:center;margin-left:200px">Current Date: '.$currentDate.'</label>'
                                        ?>
						            </div>
						        </div>
						    </div>
						</div>
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4 d-print-none">Payroll Summary Report - <button id="printBtn" class="btn btn-primary d-print-none">Print a Report</button></h4>
					    </div>
						<div class="col-md-4 d-print-none">
						    <label class="label_title">From</label>
                            <input type="date" id="date_from" class="form-control">
                        </div>
                        <div class="col-md-4 d-print-none">
                            <label class="label_title">To</label>
                            <input type="date" id="date_to" class="form-control">
                        </div>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover">
							<thead>
								<tr style="text-align:center">
								    <th class="d-print-none datatable-nosort">ID</th>
									<th class="datatable-nosort">Month</th>
									<th class="datatable-nosort">Total Employees</th>
									<th class="datatable-nosort">Basic Pay</th>
									<th class="datatable-nosort">Incentives</th>
									<th>Comission</th>
									<th>Referal</th>
									<th>Other Fees</th>
									<th>Ajudstment (+)</th>
									<th>Gross Pay</th>
									<th>Ajudstment (-)</th>
									<th>Deductions</th>
									<th>Processing Fee</th>
									<th>Net Pay</th>
								</tr>
							</thead>
							<tbody id="tbody_content">
							    <?php
							        $result = $this->User_model->query("SELECT * FROM start_cutoff ORDER BY pay_period ASC");
							        $total_amount = 0;
							        $total_incentives = 0;
							        $total_referal = 0;
							        $total_adjusment = 0;
							        $total_gross = 0;
							        $total_net = 0;
							        $amount = 0;
							        $incentives = 0;
							        $total_comission = 0;
							        $referal = 0;
							        $total_deduction = 0;
							        $adjust = 0;
							        $other_fee = 0;
							        $adjustment_sum = 0;
    							    $adjustment_deduct = 0;
    							    $new_adjustment_sum = 0;
							        $new_adjustment_deduc = 0;
							        foreach($result as $result_row):
							        $month = date("M jS, Y", strtotime($result_row['pay_period']));
							        $from = $result_row['start_date'];
							        $to = $result_row['cutoff_date'];
							        $query_result = $this->User_model->query("SELECT payeeid,SUM(adjustment) as adjustment  FROM pay WHERE  paidstatus IN ('process', 'paid') AND paiddate >= '$from' AND paiddate <= '$to' GROUP BY payeeid ");
							        $adjustment_positive = $this->User_model->query("SELECT payeeid, SUM(adjustment) as adjustment FROM pay WHERE paidstatus IN ('process', 'paid') AND paiddate >= '$from' AND paiddate <= '$to' AND adjustment > 0 GROUP BY payeeid");

                                    $totalAdjustment = 0;
                                    if($adjustment_positive){
                                        foreach ($adjustment_positive as $row) {
                                            $totalAdjustment += $row['adjustment'];
                                        }
                                    }
                                    $adjustment_negative = $this->User_model->query("SELECT payeeid, SUM(adjustment) as adjustment FROM pay WHERE paidstatus IN ('process', 'paid') AND paiddate >= '$from' AND paiddate <= '$to' AND adjustment < 0 GROUP BY payeeid");

                                    $totalAdjustment_neative = 0;
                                    if($adjustment_negative){
                                        foreach ($adjustment_negative as $row) {
                                            $totalAdjustment_neative += $row['adjustment'];
                                        }
                                    }
							        if($query_result):
    							        foreach($query_result as $query_rows):
    							            if($query_rows['adjustment'] < 0 ){
    							            $adjustment_deduct = $query_rows['adjustment'];
    							            $new_adjustment_deduc += $query_rows['adjustment'];
        							        }
        							        else{
        							            $new_adjustment_sum += $query_rows['adjustment'];
        							            $adjustment_sum = $query_rows['adjustment'];
        							        }
    							        endforeach;
							        endif;
							        $employee_count = $this->User_model->query("SELECT COUNT(*) as total_count FROM pay WHERE start_date BETWEEN '$from' AND '$to' AND paidstatus IN ('process', 'paid')");
							        $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE date_paid >= '$from' AND date_paid <= '$to' GROUP BY date_paid");
							        $results = $this->User_model->query("SELECT paidstatus,paiddate,payeeid,SUM(other_fees) as other_fees,SUM(transfer_fee) as transfer_fee,SUM(adjustment) as adjustment , SUM(comission) as comission , SUM(pay_rate) as amount ,  SUM(incentives) as incentives,SUM(comission) as comission,SUM(royaltee) as royaltee FROM pay WHERE  paidstatus IN ('process', 'paid') AND paiddate >= '$from' AND paiddate <= '$to' GROUP BY paiddate ");
							        if($results):
							        foreach($results as $row):
							            $dedus = 0;
						                if($deduction){
						                    $total_deduction += $deduction[0]['user_deduction'];
						                    $dedus = $deduction[0]['user_deduction'];;
						                }
							            $total_amount +=  $row['amount'];
							            $total_comission += $row['comission'];
							            $total_incentives += $row['incentives'];
							            $total_referal += $row['royaltee'];
							            $total_adjusment += $row['adjustment'];
							            $total_gross += number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'], 2, '.', '');
							            $total_net += $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'] - $dedus;
							            $other_fee += $row['other_fees'];
							            $totalAmount = (float) $row['amount'] + $row['incentives'] + $row['comission'] + $totalAdjustment + $row['royaltee'] + $row['other_fees'];
							            
							    ?>
                                <tr>
                                  <td class="d-print-none"></td>
                                  <td><?= $month ?></td>
                                  <td><?= $employee_count[0]['total_count'] ?></td>
                                  <td><?= "$" ?><?= $row['amount'] ?></td>
                                  <td><?= "$" ?><?= $row['incentives'] ?></td>
                                  <td><?= "$" ?><?=  number_format((float) $row['comission'], 2, '.', '') ?></td>
                                  <td><?= "$" ?><?= $row['royaltee'] ?></td>
                                  <td><?= "$" ?> <?=  number_format((float)  $row['other_fees'], 2, '.', '') ?></td>
                                  <td><?= "$" ?><?=  number_format((float)$totalAdjustment, 2, '.', '') ?></td>
                                  <td><?= "$" ?><?= number_format((float) $totalAmount, 2, '.', '')  ?> </td>
                                  <td>
                                        <?php
    						                if ($totalAdjustment_neative < 0) {
                                                $formattedValue1 = '$ (' . number_format(abs($totalAdjustment_neative), 2, '.', '') . ')'; // Remove negative sign, add dollar sign, and enclose in parentheses
                                            } else {
                                                $formattedValue1 = '$' . number_format($totalAdjustment_neative, 2, '.', ''); // Add dollar sign for positive value
                                            }
                                            echo $formattedValue1;
                                            $totalAdjustment_neative = -$totalAdjustment_neative;
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
                                  <td><?= "$" ?><?= number_format((float) $row['transfer_fee'], 2, '.', '')  ?></td>
                                  <td><?= "$" ?><?= number_format((float) $totalAmount - $deduction[0]['user_deduction'] - $totalAdjustment_neative -  $row['transfer_fee'] , 2, '.', '') ?> </td>
                                </tr>
                                <?php
                                    endforeach;
                                    endif;
                                    endforeach;
                                ?>
                            </tbody>
						</table>
					</div>
				</div>
				<div style="display:flex;justify-content:center">
				    <label>T1331 Pine Trail, Tomball TX 77375</label>
				</div>
				</div>
			</div>

<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>

<style>
    @media print {
    @page {
    size: auto; /* You can specify paper size if needed */
    margin: 0mm; /* Set margins to zero to remove headers and footers */
}
}
</style>
<script>
    $(document).ready(function(){
        // $('#date_from, [id*="date_to"]').change(function(){   // detect changes in both dropdowns
        //     var date_from  = $('#date_from').val();
        //     // var from = $("#from :selected").val();
        //      var date_to = $('#date_to').val();
        //     // // $('#start').val(cutoff_date);
        //     $.get("<?php echo site_url(); ?>Pages/get_monthly_summary", 
        //     {
        //       date_from:date_from,
        //       date_to: date_to
        //     },
        //     function(data){
        //       // Display the returned data in browser
        //       $('#tbody_content').html(data);
        //       console.log('done : ' + data);  
        //     });
        // }); 
        // Event handler for print button click
        $('#printBtn').click(function() {
            window.print();
        });
    });
</script>
