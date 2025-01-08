<?php 
    $title = "Payslip";
    $site = "payslip";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('database_payroll.php'); 
    include_once ('header.php'); 
    //error_reporting(0);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                </div>
                <div class="portlet-body">
                    <!--BEGIN SEARCH BAR        --
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                    
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <td>Pay Id</td>
                                        <td>Net Pay</td>
                                        <td>Payment Date</td>
                                        <td>Reference No</td>
                                        <td>Pay Source</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $payroll = mysqli_query($payroll_connection,"SELECT * FROM pay WHERE payeeid = $current_userEmployeeID AND (paidstatus = 'process' OR paidstatus = 'paid')  ORDER BY paiddate DESC" );
                                        foreach($payroll as $rows):
                                            $paiddate = $rows['paiddate'];
                                            $endDate = $rows['paiddate'];
                                            $employee = mysqli_query($conn,"SELECT * FROM tbl_hr_employee INNER JOIN tbl_hr_department ON tbl_hr_department.ID = tbl_hr_employee.department_id  WHERE tbl_hr_employee.ID = $current_userEmployeeID " );
                                            $employees = mysqli_fetch_array($employee);
                                            $position = mysqli_query($conn,"SELECT * FROM tbl_hr_employee INNER JOIN tbl_hr_job_description ON tbl_hr_job_description.ID = tbl_hr_employee.job_description_id  WHERE tbl_hr_employee.ID = $current_userEmployeeID " );
                                            $positions = mysqli_fetch_array($position);
                                            $payroll = mysqli_query($payroll_connection,"SELECT * FROM pay WHERE payeeid = $current_userEmployeeID and paiddate = '$paiddate' AND paidstatus IN ('process', 'paid') " );
                                            $row= mysqli_fetch_array($payroll);
                                            $payid = $row['payid'];
                                            $deductions = mysqli_query($payroll_connection,"SELECT SUM(user_deduction) as total FROM user_deductions WHERE payeeid = $current_userEmployeeID and date_paid = '$paiddate'" );
                                            $total_deductions= mysqli_fetch_array($deductions);
                                            
                                            $payroll_employee_details = mysqli_query($payroll_connection,"SELECT * FROM payee INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid INNER JOIN bankname ON payee.bankno = bankname.bankno WHERE payee.payeeid = $current_userEmployeeID" );
                                            $row_employee= mysqli_fetch_array($payroll_employee_details);
                                            $adjustment_deduction = 0;
                                            if($row['adjustment'] >= 0){
                                                $adjustment_deduction = $row['adjustment'];
                                            }
                                            $bi_pay = $row_employee['pay_rate'] / 2;
                                            $total_gross_pay = $row['pay_rate'] + $row['royaltee'] + $row['comission'] + $row['incentives'] + $adjustment_deduction + $row['other_fees'] +  $row['bunos'];
                                            $process_fee = $row['transfer_fee'];
                                            
                                            $total_adjustment = 0;
                                            $adjustment = mysqli_query($payroll_connection,"SELECT paidstatus,paiddate,adjustment,payeeid FROM pay WHERE payeeid = $current_userEmployeeID AND paiddate = '$endDate' AND paidstatus IN ('process', 'paid') " );
                                            foreach($adjustment as $row){
                                                if($row['adjustment'] < 0){
                                                    $total_adjustment += $row['adjustment'];
                                                }
                                            }
                                            $total_adjustment;
                                            
                                            $net_pay = $total_gross_pay - abs($total_adjustment) - $total_deductions['total'] - $process_fee;
                                    ?>
                                        <tr>
                                            <td><?= $rows['payid'] ?></td>
                                            <td><?= "$" ?><?= $net_pay ?></td>
                                            <td><?= $rows['paiddate'] ?></td>
                                            <td><?= $rows['refno'] ?></td>
                                            <td>Wise</td>
                                            <td><a href="https://interlinkiq.com/payslip_details.php?paiddate=<?= $rows['paiddate'] ?>" target="_blank" class="btn green btn-outline">View Pay</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!--Emjay code ends here-->
                    </div>
                </div>
            
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->

	<?php include('footer.php'); ?>

	<style>
    .mt_element_card .mt_card_item {
        border: 1px solid;
        border-color: #e7ecf1;
        position: relative;
        margin-bottom: 30px;
    }
    .mt_element_card .mt_card_item .mt_card_avatar {
        margin-bottom: 15px;
    }
    .mt_element_card.mt_card_round .mt_card_item {
        padding: 50px 50px 10px 50px;
    }
    .mt_element_card.mt_card_round .mt_card_item .mt_card_avatar {
        border-radius: 50% !important;
        -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
    }
    .mt_element_card .mt_card_item .mt_card_content {
        text-align: center;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_desc {
        font-size: 14px;
        margin: 0 0 10px 0;
       
    }
    .mt_element_overlay .mt_overlay_1 {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }
    .mt_element_overlay .mt_overlay_1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
        opacity: 0.5;
    }
    
.card{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.card::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #283593;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.card::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3949ab;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for free cards*/
.cardFree{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
  
}

.cardFree::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #3CCF4E;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.cardFree::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 9rem;
  background: #3CCF4E;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for gallery view*/

.container-gallery {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: #003865;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: #A6D1E6;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #003865;
  padding: 2px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 14px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
 font-weight:600;
 color:#003865;
  background-color: #F1F1F1;
  border-bottom:solid #003865 4px;
}

/* Style the tab content */
.tabcontent{
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.tabcontent2{
  display: block;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
    
	</style>
    </body>
</html>