<?php
// Set variables for SQL queries
$months = 04;
$year = 2023;

// Set initial values for other variables used in table
$amount = 0;
$incentives = 0;
$total_comission = 0;
$referal = 0;
$total_deduction = 0;
$adjust = 0;

// Query database for user deductions and payroll data
$deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE MONTH(date_paid) = $months AND YEAR(date_paid) = $year GROUP BY date_paid");

$results = $this->User_model->query("SELECT start_cutoff.cutoff_date, start_cutoff.pay_period, pay.paiddate, pay.payeeid, SUM(pay.adjustment) as adjustment, SUM(pay.comission) as comission, SUM(pay.pay_rate) as amount, SUM(pay.incentives) as incentives, SUM(pay.comission) as comission, SUM(pay.royaltee) as royaltee 
                                    FROM pay 
                                    INNER JOIN start_cutoff ON start_cutoff.cutoff_date = pay.paiddate  
                                    WHERE MONTH(pay.paiddate) = $months AND YEAR(pay.paiddate) = 2023 
                                    GROUP BY pay.paiddate");

// Start outputting HTML
echo '<!DOCTYPE html>
        <html>
        <head>
        	<meta charset="UTF-8">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        	<title>Payroll Summary</title>
        	<style>
        		table {
        			border-collapse: collapse;
        			width: 100%;
        			max-width: 600px;
        			margin: 20px auto;
        			font-family: Arial, sans-serif;
        			font-size: 14px;
        			color: #333;
        			border: 1px solid #999;
        		}
        		th, td {
        			border: 1px solid #999;
        			padding: 10px;
        			text-align: left;
        		}
        		th {
        			background-color: #ccc;
        			font-weight: bold;
        		}
        		tr:nth-child(even) {
        			background-color: #f2f2f2;
        		}
        		.total {
        			font-weight: bold;
        			background-color: #f5f5f5;
        		}
        		.gross-pay {
        			font-size: 20px;
        			font-weight: bold;
        			margin-top: 30px;
        		}
        		.net-pay {
        			font-size: 18px;
        			font-weight: bold;
        			margin-top: 10px;
        		}
        	</style>
        </head>
        <body>
        	<h2>Payroll Summary</h2>
        	<table>
        		<thead>
        			<tr>
        				<th>Pay Period</th>
        				<th>Basic Pay</th>
        				<th>Incentives</th>
        				<th>Referral</th>
        				<th>Commission</th>
        				<th>Adjustment</th>
        				<th>Deduction</th>
        				<th>Gross Pay</th>
        				<th>Net Pay</th>
        			</tr>
        		</thead>
        		<tbody>';

// Loop through payroll results and output table rows
foreach($results as $row) {
    echo '<tr>
            <td>' . date("F j, Y",strtotime($row['pay_period']) ) . ' - ' . date("F j, Y",strtotime($row['cutoff_date']) ) . '</td>
<td>$' . number_format($row['amount'], 2) . '</td>
<td>$' . number_format($row['incentives'], 2) . '</td>
<td>$' . number_format($row['royaltee'], 2) . '</td>
<td>$' . number_format($row['comission'], 2) . '</td>
<td>$' . number_format($row['adjustment'], 2) . '</td>';// Query database for user deductions for the current pay period
$payeeid = $row['payeeid'];
$deductions = array_filter($deduction, function($val) use ($payeeid) { return $val['payeeid'] == $payeeid; });

// If user has deductions, loop through them and add to total deduction
if(!empty($deductions)) {
    foreach($deductions as $deduct) {
        $total_deduction += $deduct['user_deduction'];
    }
}

// Calculate gross pay, net pay, and add to total commission
$gross_pay = $row['amount'] + $row['incentives'] + $row['royaltee'] + $row['comission'] + $row['adjustment'] - $total_deduction;
$net_pay = $gross_pay - $row['comission'];
$total_comission += $row['comission'];

// Output remaining table rows
echo '<td>$' . number_format($total_deduction, 2) . '</td>
        <td>$' . number_format($gross_pay, 2) . '</td>
        <td>$' . number_format($net_pay, 2) . '</td>
      </tr>';

// Reset deduction and adjustment totals for next row
$total_deduction = 0;
$adjust = 0;
}

// Output total commission and net pay at the bottom of the table
echo '<tr class="total">
<td>Total</td>
<td></td>
<td></td>
<td></td>
<td>$' . number_format($total_comission, 2) . '</td>
<td></td>
<td>$' . number_format($total_deduction, 2) . '</td>
<td></td>
<td>$' . number_format($total_comission, 2) . '</td>
</tr>
</tbody>

  </table>';
// Output total gross pay and net pay at the bottom of the page
echo '<div class="gross-pay">Total Gross Pay: $' . number_format($gross_pay, 2) . '</div>';
echo '<div class="net-pay">Total Net Pay: $' . number_format($net_pay, 2) . '</div>';

echo '</body>
</html>';
?>
