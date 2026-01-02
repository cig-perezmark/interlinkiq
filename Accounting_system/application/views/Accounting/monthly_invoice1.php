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
            justify-content:center !important;
            align-items:center !important;
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
						        <label style="font-size:24px;font-weight:500;text-align:center">Payroll Summary Report</label>
						        <div style="display:flex;justify-content:center;align-items:center">
						            <img src="https://interlinkiq.com/companyDetailsFolder/394227%20-%20cig.png"> <label style="font-size:24px;font-weight:500">Consultare Inc. Group</label>
						        </div>
						    </div>
						</div>
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4 d-print-none">Payroll Summary Report - <button id="printBtn" class="btn btn-primary d-print-none">Print a Report</button></h4>
					    </div>
						<div class="col-md-4">
						    <label class="label_title">From</label>
                            <input type="date" id="date_from" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="label_title">To</label>
                            <input type="date" id="date_to" class="form-control">
                        </div>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr style="text-align:center">
									<th>Month</th>
									<th>Total Employees</th>
									<th>Basic Pay</th>
									<th>Incentives</th>
									<th>Comission</th>
									<th>Referal</th>
									<th>Gross Pay</th>
									<th>Ajudstment</th>
									<th>Deductions</th>
									<th>Net Pay</th>
								</tr>
							</thead>
							<tbody id="tbody_content">
							    <?php
							        $result = $this->User_model->query("SELECT * FROM start_cutoff ORDER BY id DESC");
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
							        foreach($result as $result_row):
							        $month = date("M jS, Y", strtotime($result_row['pay_period']));
							        $from = $result_row['start_date'];
							        $to = $result_row['cutoff_date'];
							        $employee_count = $this->User_model->query("SELECT COUNT(*) as total_count FROM pay WHERE start_date BETWEEN '$from' AND '$to' AND paidstatus IN ('process', 'paid')");
							        $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE date_paid >= '$from' AND date_paid <= '$to' GROUP BY date_paid");
							        $results = $this->User_model->query("SELECT paiddate,payeeid,SUM(adjustment) as adjustment , SUM(comission) as comission , SUM(pay_rate) as amount ,  SUM(incentives) as incentives,SUM(comission) as comission,SUM(royaltee) as royaltee FROM pay WHERE paiddate >= '$from' AND paiddate <= '$to' GROUP BY paiddate ");
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
							    ?>
                                <tr>
                                  <td><?= $month ?></td>
                                  <td><?= $employee_count[0]['total_count'] ?></td>
                                  <td><?= "$" ?><?= $row['amount'] ?></td>
                                  <td><?= "$" ?><?= $row['incentives'] ?></td>
                                  <td><?= "$" ?><?=  number_format((float) $row['comission'], 2, '.', '') ?></td>
                                  <td><?= "$" ?><?= $row['royaltee'] ?></td>
                                  <td><?= "$" ?><?= number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'], 2, '.', '')  ?> </td>
                                  <td><?= "$" ?><?=  number_format((float) $row['adjustment'], 2, '.', '') ?></td>
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
                                  <td><?= "$" ?><?= number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'] - $dedu , 2, '.', '') ?> </td>
                                </tr>
                                <?php
                                    endforeach;
                                    endforeach;
                                ?>
                            </tbody>
						</table>
					</div>
				</div>
				</div>
			</div>

<script type="text/javascript" rel="stylesheet"> $('document').ready(function(){ $(".alert_message").fadeIn(1000).fadeOut(5000); }); </script>


<script>
    $(document).ready(function(){
        $('#date_from, [id*="date_to"]').change(function(){   // detect changes in both dropdowns
            var date_from  = $('#date_from').val();
            // var from = $("#from :selected").val();
             var date_to = $('#date_to').val();
            // // $('#start').val(cutoff_date);
            $.get("<?php echo site_url(); ?>Pages/get_monthly_summary", 
            {
              date_from:date_from,
              date_to: date_to
            },
            function(data){
              // Display the returned data in browser
              $('#tbody_content').html(data);
              console.log('done : ' + data);  
            });
        }); 
        // Event handler for print button click
        $('#printBtn').click(function() {
            window.print();
        });
    });
</script>
