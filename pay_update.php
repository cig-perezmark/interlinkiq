<?php 
$title = "pay_update";
    $site = "pay_update";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include_once ('database_payroll.php'); 
    include_once ('header.php'); 
    
echo "test";

$payroll_employee = mysqli_query($payroll_connection,"SELECT * FROM payee INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid" );
foreach($payroll_employee as $employee_row){
    echo $bi_pay = $employee_row['pay_rate'] / 2; echo "/";
    echo $payee_id = $employee_row['payeeid']; echo '<br>';
    $update_sql = mysqli_query($payroll_connection,"UPDATE pay SET pay_rate = '$bi_pay' WHERE payeeid = '$payee_id' AND paiddate = '2024-06-07'" );
}


// $pays = mysqli_query($payroll_connection,"SELECT * FROM pay" );
// foreach($pays as $row){
    
//     // $update_sql = mysqli_query($payroll_connection,"UPDATE pay SET pay_rate = '$bi_pay' WHERE payeeid = '$payee_id'" );
// }


?>