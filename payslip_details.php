<?php 
    $title = "Payment Record";
    $site = "payslip";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include_once ('database_afia_forms.php'); 
    include_once ('database_payroll.php'); 
    include_once ('header.php'); 
    error_reporting(0);
?>

	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">User Payment Record
                        <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                            (<a data-toggle="modal" data-target="#modal_video">Add Video</a>)
                        <?php endif; ?>
                        </span>- <button class="btn btn-primary" id="print" onclick="printPage()" >Print</button>
                            <?php
                                $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND user_id = '$switch_user_id' OR page = '$site' AND user_id = '163' OR page = '$site' AND user_id = '$current_userEmployerID' " ; 
                                $result = mysqli_query ($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)){?>   
                                    <!--<a data-toggle="modal" data-target="#view_video" class="view_videos"  file_name="<?= $row['youtube_link'] ?>"><?= $row['file_title'] ?></a>-->
                                    <a class="view_videos" data-src="<?= $row['youtube_link'] ?>" data-fancybox><i class="fa fa-youtube"></i><?= $row['file_title'] ?></a>
                                    <?= "/" ?>
                            <?php } ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--BEGIN SEARCH BAR        -->
                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <!--Emjay starts here-->
                            <li>
                               
                            </li>
                            <!--Emjay Codes ends here-->
                        </ul>               
                    </div>
                    <?php
                    
                        $paiddate = $_GET['paiddate'];
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
                    ?>
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                        <div id="forms" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead>
                                        <tr style="text-align:center">
                                            <td rowspan="2" colspan="2" width="200">
                                                <img src="https://interlinkiq.com/companyDetailsFolder/394227%20-%20cig.png" alt="Interlinkiq Logo" height="100">
                                                <label style="font-weight:800">CONSULTARE INC. GROUP</label>
                                            </td>
                                            <td>
                                                <label>PAYSLIP</label><br>
                                                <span>Reference #: <?= $row['refno']?></span>
                                            </td>
                                            <td rowspan="2" colspan="3"   width="200">
                                                <h5>Paid Time Off: 
                                                <?php
                                                 $cookie =  $_COOKIE['ID'];
                                                $start_date = $row['start_date'];
                                                $end_date = $row['paiddate'];
                                                    $total_sql = mysqli_query($conn,"SELECT COUNT(task_id) as total FROM `tbl_service_logs` WHERE task_date BETWEEN '$start_date' AND '$end_date' AND user_id = '$cookie' AND minute < 0" );
                                                    $total= mysqli_fetch_array($total_sql);
                                                ?>
                                               <?= $total['total'] ?> </h5><br id="remove">
                                                <hr><br id="remove">
                                                <h5>Remaining PTO :
                                                <?php
                                                    $leave_remaining = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = $current_userEmployeeID " );
                                                    $employees_leave_remaining = mysqli_fetch_array($leave_remaining);
                                                ?>
                                                <?= $employees_leave_remaining['total_leave'] ?> </h5>
                                            </td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td>
                                                <?php 
                                                $date = strtotime($paiddate);
                                                echo strftime('%B %d, %Y', $date);
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                Name: &nbsp;&nbsp; <?php echo $current_userFName .' '. $current_userLName; ?> <br> <br>
                                                Employee ID : &nbsp;&nbsp; <?= $current_userEmployeeID ?> <br><br>
                                                Position : &nbsp;&nbsp; <?= $positions['title'] ?> <br><br>
                                                Department : &nbsp;&nbsp; <?= $employees['title'] ?>
                                            </td>
                                            <td>
                                               
                                            </td>
                                            <td colspan="3">
                                                Bank Name: &nbsp;&nbsp; <?= $row_employee['bankname'] ?> <br> <br>
                                                Bank Account No. : &nbsp;&nbsp;<?php $first_four_chars = substr($row_employee['accountno'], 0, 4); echo $first_four_chars; ?><br> <br>
                                                Email Address : &nbsp;&nbsp; <?=  $rowUser['email'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:center">
                                                Description
                                            </td>
                                            <td style="text-align:center">
                                               Earnings
                                            </td>
                                            <td colspan="2" style="text-align:center">
                                                Description
                                            </td>
                                            <td colspan="" style="text-align:center">
                                                 Deductions
                                            </td>
                                        </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td colspan="2" >
                                                Basic Pay
                                            </td>
                                            <td style="text-align:center" id="basic_pay">
                                               <?= "$" ?><?= $row['pay_rate']?>
                                            </td>
                                            <td colspan="2">
                                                Leave Without Pay
                                            </td>
                                            <td colspan="" style="text-align:center" id="absent_deduction">
                                                <?= "$(" ?><?= $row['absent_deduction'] ?> <?= ")" ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Comission
                                            </td>
                                            <td style="text-align:center" id="comission">
                                               <?= "$" ?><?= $row['comission'] ?>
                                            </td>
                                            <td colspan="2" >
                                                Cash Advance
                                            </td>
                                            <td colspan="" style="text-align:center" id="cash_advance">
                                                <?php
                                                    if($total_deductions['total']):
                                                ?>
                                                    <?= "$(" ?><?= $total_deductions['total'] ?> <?= ")" ?>
                                                <?php endif ?>
                                                <input type="hidden" id="cash_advance_minus" value="<?= $total_deductions['total'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Incentive
                                            </td>
                                            <td style="text-align:center" id="incentive">
                                               <?= "$" ?><?= $row['incentives'] ?>
                                            </td>
                                            <td colspan="2">
                                                Process Fee
                                            </td>
                                            <td style="text-align:center">
                                                <?= "$(" ?><?= $row['transfer_fee'] ?><?= ")" ?>
                                                <input type="hidden" id="transfer_fee_minus" value="<?= $row['transfer_fee'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Referral Fee
                                            </td>
                                            <td style="text-align:center" id="referal">
                                               <?= "$" ?><?= $row['royaltee'] ?>
                                            </td>
                                            <td colspan="2">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Adjustment
                                            </td>
                                            <td style="text-align:center" id="adjustment">
                                                <?php if($row['adjustment'] >= 0): ?>
                                                    <?= "$" ?><?= $row['adjustment'] ?>
                                                <?php endif; ?>
                                            </td>
                                            <td colspan="2">
                                            </td>
                                            <td id="adjustment_deduct" style="text-align:center">
                                                <?php
            						                if ($row['adjustment'] < 0) {
                                                        $formattedValue1 = '$ (' . number_format(abs($row['adjustment']), 2, '.', '') . ')'; // Remove negative sign, add dollar sign, and enclose in parentheses
                                                    } else {
                                                        $formattedValue1 = '$' . number_format($row['adjustment'], 2, '.', ''); // Add dollar sign for positive value
                                                    }
                                                    echo $formattedValue1;
            						            ?>
            						            <input type="hidden" id="adjustment_minus" value="<?= $row['adjustment'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Other Fees
                                            </td>
                                            <td style="text-align:center" id="adjustment">
                                                <?= "$" ?><?= $row['other_fees'] ?>
                                            </td>
                                            <td colspan="2">
                                            </td>
                                            <td >
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Bonus
                                            </td>
                                            <td style="text-align:center" id="adjustment">
                                                <?= "$" ?><?= $row['bunos'] ?>
                                            </td>
                                            <td colspan="2">
                                            </td>
                                            <td >
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                Total Earnings
                                            </td>
                                            <td style="text-align:center">
                                               <?= "$" ?><?=  $total_gross_pay ?>
                                            </td>
                                            <td colspan="2" style="text-align:center" >
                                                Total Deduction
                                            </td>
                                            <td id="total_deduction"></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2" rowspan="3" >
                                                Gross Pay to Date :  &nbsp;&nbsp; <?= "$" ?><?= $total_gross_pay ?> <br><br>
                                                Year to Date Gross Pay : 
                                                <?php
                                                    $endDate = $_GET['paiddate'];
                                                    $year_amount = 0;
                                                    $year_incentives = 0;
                                                    $year_comission = 0;
                                                    $year_referal = 0;
                                                    $year_gross_sql = mysqli_query($payroll_connection,"SELECT * FROM pay WHERE payeeid = $current_userEmployeeID AND YEAR(paiddate) = YEAR(CURDATE()) AND paiddate <= '$endDate' AND paidstatus IN ('process', 'paid') " );
                                                    foreach($year_gross_sql as $year_gross_rows){
                                                        $year_amount += $year_gross_rows['pay_rate'];
                                                        $year_incentives += $year_gross_rows['incentives'];
                                                        $year_comission += $year_gross_rows['comission'];
                                                        $year_referal += $year_gross_rows['royaltee'];
                                                        $year_other_fees += $year_gross_rows['other_fees'];
                                                        $year_bunos_fees += $year_gross_rows['bunos'];
                                                        
                                                    }
                                                    echo "$"; echo $year_amount+$year_incentives+$year_comission+$year_referal+$year_other_fees+$year_bunos_fees;echo'<br>';
                                                ?>
                                                <br>
                                                <?= "Notes:" ?><?php
                                                        $comments = array();  // Initialize an array to store non-empty comments
                                                        if (!empty($row['royaltee_comment'])) {
                                                            $comments[] = $row['royaltee_comment'];
                                                        }
                                                        
                                                        if (!empty($row['comission_comment'])) {
                                                            $comments[] = $row['comission_comment'];
                                                        }
                                                        
                                                        if (!empty($row['incentives_comment'])) {
                                                            $comments[] = $row['incentives_comment'];
                                                        }
                                                        if (!empty($row['other_fees_comment'])) {
                                                            $comments[] = $row['other_fees_comment'];
                                                        }
                                                        if (!empty($row['pay_notes'])) {
                                                            $comments[] = $row['pay_notes'];
                                                        }
                                                        if (!empty($row['adjustment_comment'])) {
                                                            $comments[] = $row['adjustment_comment'];
                                                        }
                                                        if (!empty($row['deduction_comment'])) {
                                                            $comments[] = $row['deduction_comment'];
                                                        }
                                                        if (!empty($row['bunos_comment'])) {
                                                            $comments[] = $row['bunos_comment'];
                                                        }
                                                        if (!empty($row['marketing_fee_comment'])) {
                                                            $comments[] = $row['marketing_fee_comment'];
                                                        }
                                                        if (!empty($row['cash_advance_comment'])) {
                                                            $comments[] = $row['cash_advance_comment'];
                                                        }
                                                        if (!empty($row['hourly_comment'])) {
                                                            $comments[] = $row['hourly_comment'];
                                                        }
                                                        if (!empty($row['payrate_comment'])) {
                                                            $comments[] = $row['payrate_comment'];
                                                        }
                                                        // Echo the comments separated by commas
                                                        echo implode(', ', $comments);
                                                ?>
                                            </td>
                                            <td style="text-align:center" rowspan="3">
                                                
                                            </td>
                                            <td colspan="3" >
                                                <?php
                                                    $total_adjustment = 0;
                                                    $adjustment = mysqli_query($payroll_connection,"SELECT paidstatus,paiddate,adjustment,payeeid FROM pay WHERE payeeid = $current_userEmployeeID AND paiddate = '$endDate' AND paidstatus IN ('process', 'paid') " );
                                                    foreach($adjustment as $row){
                                                        if($row['adjustment'] < 0){
                                                            $total_adjustment += $row['adjustment'];
                                                        }
                                                    }
                                                    $total_adjustment;
                                                    
                                                    $total_deduction = 0;
                                                    foreach($adjustment as $row){
                                                        if($row['adjustment'] >= 0){
                                                            $total_deduction += $row['adjustment'];
                                                        }
                                                    }
                                                    $total_deduction;
                                                    $user_deduction = 0;
                                                    $user_deductions = mysqli_query($payroll_connection,"SELECT date_paid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE payeeid = $current_userEmployeeID AND paiddate = '$endDate'" );
                                                    foreach($user_deductions as $row){
                                                        if($row['adjustment'] >= 0){
                                                            $user_deduction += $row['adjustment'];
                                                        }
                                                    }
                                                    
                                                    $earnings = mysqli_query($payroll_connection,"SELECT paidstatus,paiddate, SUM(amount) as amount, SUM(royaltee) as royaltee, SUM(comission) as comission, SUM(incentives) as incentives FROM pay WHERE payeeid = $current_userEmployeeID AND paiddate = '$endDate' AND paidstatus IN ('process', 'paid')" );
                                                    $earnings_rows = mysqli_fetch_array($earnings);
                                                    $earnings_amount = $earnings_rows['amount'];
                                                    $earnings_royaltee = $earnings_rows['royaltee'];
                                                    $earnings_comission = $earnings_rows['comission'];
                                                    $earnings_incentives = $earnings_rows['incentives'];
                                                    $total_earnings = $earnings_amount + $earnings_royaltee + $earnings_comission + $earnings_incentives;
                                                    
                                                ?>
                                                
                                                <span style="background-color:yellow">
                                                    Net Pay to Date :  &nbsp;&nbsp; <?php
                                                       echo "$"; echo    $net_pay =  $total_gross_pay - abs($total_adjustment) - $total_deductions['total'] - $process_fee;
                                                    ?>
                                                </span><br><br>
                                                Year to Date Net Pay :  &nbsp;&nbsp; 
                                                <?php 
                                                    $amount = 0;
                                                    $adjustment_total = 0;
                                                    $ca_total = 0;
                                                    $comission = 0;
                                                    $incentives = 0;
                                                    $royaltee= 0;
                                                    $gross_sql = mysqli_query($payroll_connection,"SELECT * FROM pay WHERE payeeid = $current_userEmployeeID AND YEAR(paiddate) = YEAR(CURDATE()) AND paiddate <= '$endDate' AND paidstatus IN ('process', 'paid') " );
                                                    foreach($gross_sql as $row){
                                                        $paiddate = $row['paiddate'];
                                                        $ca_sql = mysqli_query($payroll_connection,"SELECT * FROM user_deductions WHERE  payeeid = $current_userEmployeeID AND date_paid = '$paiddate' " );
                                                        foreach($ca_sql as $ca_rows){
                                                            $ca_total += abs($ca_rows['user_deduction']);
                                                        }
                                                        if($row['adjustment'] < 0){
                                                            $adjustment_total += abs($row['adjustment']);
                                                        }
                                                        $amount += $row['pay_rate'];
                                                        $comission += $row['comission'];
                                                        $incentives += $row['incentives'];
                                                        $royaltee += $row['royaltee'];
                                                        $process_fee += $row['transfer_fee'];
                                                        $other_fees += $row['other_fees'];
                                                    }
                                                    $total_amount = $amount + $comission + $incentives + $royaltee + $other_fees;
                                                    echo "$"; echo $total_amount - $adjustment_total - $ca_total - $process_fee; echo'<br>';
                                                ?>
                                                <br id="remove">
                                                <?php
                                                    $ca_deduc = mysqli_query($payroll_connection,"SELECT SUM(user_deduction) as total FROM user_deductions WHERE payeeid = $current_userEmployeeID and date_paid <= '$paiddate'" );
                                                    $ca_deduc_total= mysqli_fetch_array($ca_deduc);
                                                ?>
                                                CA Deduction to Date :  &nbsp;&nbsp;<?= "$" ?><?= $ca_deduc_total['total'] ?>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if($row['paidstatus'] == "paid"): ?>
                            <div id="received" style="text-align:center">
                                <span>Received</span>
                            </div>
                        <?php else: ?>
                            <button class="btn btn-primary" id="received" style="margin-left:50%">Received</button>
                        <?php endif; ?>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->

	<?php include('footer.php'); ?>
<script>
 
$(document).ready(function(){
    var basic_pay = parseInt($('#basic_pay').text()) || 0;
    var incentive = parseInt($('#incentive').text()) || 0;
    var comission = parseInt($('#comission').text()) || 0;
    var royaltee = parseInt($('#royaltee').text()) || 0;
    var referal = parseInt($('#referal').text()) || 0;
    var adjustment = parseInt($('#adjustment').text()) || 0;
    var adjustment_minus = $("#adjustment_minus").val();
    var cash_advance_minus = $("#cash_advance_minus").val();
    var transfer_fee_minus = $("#transfer_fee_minus").val();
    var total = basic_pay + incentive + comission + referal + adjustment + royaltee;
    $('#total_earnings').text(total);
    console.log(basic_pay);
    console.log(incentive);
    console.log(comission);
    console.log(referal);
    console.log(adjustment);
    console.log(total);
    var absent_deduction = parseInt($('#absent_deduction').text()) || 0;
    var cash_advance = parseInt($('#cash_advance').text()) || 0;
    var adjustment_deduct = parseInt($('#adjustment_deduct').text()) || 0 ;
    console.log(cash_advance);
    var total_ded = absent_deduction + Math.abs(cash_advance_minus) + Math.abs(adjustment_minus)+ Math.abs(transfer_fee_minus) ;
    var total_ded_net = absent_deduction + Math.abs(cash_advance_minus) + Math.abs(adjustment_minus) ;
    $('#total_deduction').text('$ (' +total_ded+')');
    var net_to_date = total - total_ded_net;
    $('#net_to_date').text(net_to_date);
    $('#deduction_to_date').text(total_ded_net);
    
    var currentDate = new Date(); // get current date
    var currentMonth = currentDate.getMonth() + 1; // get current month as a number (0-11) and add 1 to it
    console.log(currentMonth); // output the result
    
 $('[id*="update_pto"]').click(function(){
        var user_id = $(this).attr('user_id');
        var leave_count = $(this).attr('leave_count');
        var start_date = $(this).attr('task_date');
        var leave_ids = $(this).attr('leave_ids');
        var end_date = $(this).attr('end_date');
        var notes = $(this).attr('notes');
        $('#leave_id').val(leave_ids);
        $('#leave_count').val(leave_count);
        $('#start_date').val(start_date);
        $('#end_date').val(end_date);
        $('#notes').val(notes);
 });
 
 $('[id*="pto_cancel"]').click(function(){
        var id_leave = $(this).attr('id_leave');
        var user_notes = $(this).attr('user_notes');
        $('#id_leave').val(id_leave);
        $('#user_notes').val(user_notes);
 });
 
 $('#received').click(function(){
   
    var payid = <?= $payid ?>;
    $.ajax({
      url:"app-function/controller.php",
          method:"POST",
          data:{
              action:"update_pay",
              payid:payid
          },
          success:function(data)
          {
            //window.location.reload();
            console.log(data); 
            location.reload();
          } 
    });
 });
 
 
// for gallery
}); 
let slideIndex = 1;
showSlides(slideIndex);

function printPage() {
  window.print();
}
// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

function apps(evt, appName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(appName).style.display = "block";
  evt.currentTarget.className += " active";
}

function btnClone(id) {
    $.ajax({
        type: "GET",
        url: "function.php?btnClone="+id,
        dataType: "html",
        success: function(data){
            // $("#modalReport .modal-body").html(data);
        }
    });
}
</script>

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

table {
    width: 100%;
    border-collapse: collapse;
}
td, th {
    border: 1px solid #000;
    padding: 0.5em;
    text-align: left;
    vertical-align: top;
    width: auto;
}

@media print{
    #print{
        display:none;
    }
    .bot-icon{
        display:none;
    }
    .noprint{
        display:none;
    }
    table {
        width: 50%;
    }
    .portlet-title{
        display:none;
    }
    .page-title{
        display:none;
    }
    #received{
        display:none;
    }
    #remove{
        display:none;
    }
}
@page {
    size: A4 portrait;
    margin: 0;
}
	</style>
    </body>
</html>