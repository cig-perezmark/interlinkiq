<?php 
error_reporting(0);
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Task Tracker";
    $site = "Task_Tracker";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Task Tracker</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_Assigned" data-toggle="tab"> Assigned Task </a>
                                        </li>
                                        <!--<li>-->
                                        <!--    <a href="#tab_Drafted" data-toggle="tab"> Drafted Task </a>-->
                                        <!--</li>-->
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_Assigned">
                                               
                                                <table class="table table-bordered table-hover" id="sample_4">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th style="" class="text-center">Assign to</th>
                                                            <th style="width:65%;" class="text-center">Task</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php
                                                            $i_user=1;
                                                            $query = "SELECT *  FROM tbl_user left join tbl_hr_employee on employee_id = tbl_hr_employee.ID
                                                            left join tbl_hr_department on department_id = tbl_hr_department.ID where tbl_hr_employee.status = 1 and tbl_hr_employee.user_id= 34 order by tbl_user.first_name ASC";
                                                            $result = mysqli_query($conn, $query);
                                                                                        
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                                <?php echo $i_user++; ?>
                                                            </td>
                                                            <td>
                                                           
                                                                <button class="accordion-task">
                                                                    <?php echo $row['first_name'];  ?> <?php echo $row['last_name'];  ?>&nbsp;<i style="font-size:12px;color:#1C3879;">(<?php echo $row['title'];  ?>)</i>
                                                                </button>
                                                                <div class="panel-task">
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          <br>
                                                                          <p>Email: <?php echo $row['email'];  ?></p>
                                                                      </div>
                                                                  </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="accordion-task">
                                                                    <!--Pending Count-->
                                                                    <?php
                                                                        $t=1;
                                                                        $getMail = $row['email'];
                                                                        $queryPending = "SELECT count(*) as countPending  FROM tbl_Customer_Relationship_Task  where Task_Status = 1 and Assigned_to = '$getMail'";
                                                                        $resultPending = mysqli_query($conn, $queryPending);
                                                                                                    
                                                                        while($rowPending = mysqli_fetch_array($resultPending)):?>
                                                                        <i class="pending">Not Started (<?php echo $rowPending['countPending']; ?>)</i>
                                                                    <?php endwhile; ?>
                                                                    <!--Inprogress Count-->
                                                                    <?php
                                                                        $t=1;
                                                                        $getMail = $row['email'];
                                                                        $queryInprogress = "SELECT count(*) as countInprogress  FROM tbl_Customer_Relationship_Task  where Task_Status = 2 and Assigned_to = '$getMail'";
                                                                        $resultInprogress = mysqli_query($conn, $queryInprogress);
                                                                                                    
                                                                        while($rowInprogress = mysqli_fetch_array($resultInprogress)):?>
                                                                         &nbsp;<i class="inprogress">Inprogress (<?php echo $rowInprogress['countInprogress']; ?>)</i>
                                                                    <?php endwhile; ?>&nbsp;
                                                                    <!--Done Count-->
                                                                    <?php
                                                                        $t=1;
                                                                        $getMail = $row['email'];
                                                                        $queryDone = "SELECT count(*) as countDone  FROM tbl_Customer_Relationship_Task  where Task_Status = 3 and Assigned_to = '$getMail'";
                                                                        $resultDone = mysqli_query($conn, $queryDone);
                                                                                                    
                                                                        while($rowDone = mysqli_fetch_array($resultDone)):?>
                                                                    <i class="done">Completed (<?php echo $rowDone['countDone']; ?>)</i>
                                                                    <?php endwhile; ?>
                                                                </button>
                                                                <div class="panel-task">
                                                                    
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                            <h5>Dashboard</h5><i class="pending">Under Development!!</i>
                                                                      <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No.</th>
                                                                                    <th>Task</th>
                                                                                    <th>From</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                      </div>
                                                                    </div>
                                                                    <div class="row">
                                                                      <div class="col-md-12">
                                                                            <h5>Email Marketing</h5>
                                                                      <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Today</th>
                                                                                    <th>Weekly</th>
                                                                                    <th>Monthly</th>
                                                                                    <th>Total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?php
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d');
                                                                                            
                                                                                            $queryMarketing = "SELECT * FROM tbl_Customer_Relationship where mutiple_added = 0";
                                                                                            $resultMarketing = mysqli_query($conn, $queryMarketing);
                                                                                            
                                                                                            $count = 1;
                                                                                            $total = 0;
                                                                                            $total2 = 0;
                                                                                            $final = 0;
                                                                                            while($rowMarketing = mysqli_fetch_array($resultMarketing)){
                                                                                               
                                                                                                $date = date_create($rowMarketing['crm_date_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowMarketing['userID'];
                                                                                                // $date_function = false;
                                                                                                if($today == $date_get && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                                
                                                                                            }
                                                                                             // Start Campaign count
                                                                                            $queryCampaign = "SELECT * FROM tbl_Customer_Relationship_Campaign where userID = $getIDs and Campaign_Status = 2";
                                                                                            $resultCampaign = mysqli_query($conn, $queryCampaign);
                                                                                            while($rowCampaign = mysqli_fetch_array($resultCampaign)){
                                                                                                $date = date_create($rowCampaign['Campaign_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowCampaign['userID'];
                                                                                                // $date_function = false;
                                                                                                if($today == $date_get && $getIDs == $userID){
                                                                                                   $total2 = $count++;
                                                                                                   
                                                                                                }
                                                                                            }
                                                                                             // End Campaign count
                                                                                            for ($i = 0; $i < $total2; $i++) {}
                                                                                            for ($x = 0; $x < $total; $x++) {} $t = $x + $i; echo "($t) email sent!";
                                                                                            ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d');
                                                                                            
                                                                                            $queryMarketing = "SELECT * FROM tbl_Customer_Relationship where mutiple_added = 0";
                                                                                            $resultMarketing = mysqli_query($conn, $queryMarketing);
                                                                                            
                                                                                            $count = 1;
                                                                                            $total = 0;
                                                                                            $total2 = 0;
                                                                                            $final = 0;
                                                                                            while($rowMarketing = mysqli_fetch_array($resultMarketing)){
                                                                                                $date = date_create($rowMarketing['crm_date_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowMarketing['userID'];
                                                                                                $startTimeStamp = strtotime($date_get);
                                                                                                $endTimeStamp = strtotime($today);
                                                                                                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                                $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                                // and you might want to convert to integer
                                                                                                 $numberDays = intval($numberDays);
                                                                                                if($numberDays < 7 && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            // Start Campaign count
                                                                                            $queryCampaign = "SELECT * FROM tbl_Customer_Relationship_Campaign where userID = $getIDs and Campaign_Status = 2";
                                                                                            $resultCampaign = mysqli_query($conn, $queryCampaign);
                                                                                            while($rowCampaign = mysqli_fetch_array($resultCampaign)){
                                                                                                $date = date_create($rowCampaign['Campaign_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowCampaign['userID'];
                                                                                                // $date_function = false;
                                                                                                if($numberDays < 7 && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                            }
                                                                                             // End Campaign count
                                                                                            for ($i = 0; $i < $total2; $i++) {}
                                                                                            for ($x = 0; $x < $total; $x++) {} $t = $x + $i; echo "($t) email sent!";
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d');
                                                                                            
                                                                                            $queryMarketing = "SELECT * FROM tbl_Customer_Relationship where mutiple_added = 0";
                                                                                            $resultMarketing = mysqli_query($conn, $queryMarketing);
                                                                                            
                                                                                            $count = 1;
                                                                                            $total = 0;
                                                                                            $total2 = 0;
                                                                                            $final = 0;
                                                                                            while($rowMarketing = mysqli_fetch_array($resultMarketing)){
                                                                                                $date = date_create($rowMarketing['crm_date_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowMarketing['userID'];
                                                                                                $startTimeStamp = strtotime($date_get);
                                                                                                $endTimeStamp = strtotime($today);
                                                                                                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                                $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                                // and you might want to convert to integer
                                                                                                 $numberDays = intval($numberDays);
                                                                                                if($numberDays < 30 && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            // Start Campaign count
                                                                                            $queryCampaign = "SELECT * FROM tbl_Customer_Relationship_Campaign where userID = $getIDs and Campaign_Status = 2";
                                                                                            $resultCampaign = mysqli_query($conn, $queryCampaign);
                                                                                            while($rowCampaign = mysqli_fetch_array($resultCampaign)){
                                                                                                $date = date_create($rowCampaign['Campaign_added']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowCampaign['userID'];
                                                                                                // $date_function = false;
                                                                                                if($numberDays < 30 && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                            }
                                                                                             // End Campaign count
                                                                                            for ($i = 0; $i < $total2; $i++) {}
                                                                                            for ($x = 0; $x < $total; $x++) {} $t = $x + $i; echo "($t) email sent!";
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d'); 
                                                                                            $queryMarketing = "SELECT count(*) as count  FROM tbl_Customer_Relationship where userID = $getIDs and mutiple_added = 0";
                                                                                            $resultMarketing = mysqli_query($conn, $queryMarketing);
                                                                                                                        
                                                                                            while($rowMarketing = mysqli_fetch_array($resultMarketing)){
                                                                                            ?>
                                                                                            
                                                                                            <?php 
                                                                                            
                                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                                $today = $date_default_tx->format('Y/m/d'); 
                                                                                                $queryCampaign = "SELECT count(*) as count2  FROM tbl_Customer_Relationship_Campaign where userID = $getIDs and Campaign_Status = 2";
                                                                                                $resultCampaign = mysqli_query($conn, $queryCampaign);                      
                                                                                                while($rowCampaign = mysqli_fetch_array($resultCampaign)){
                                                                                                    $c2 = $rowCampaign['count2']; 
                                                                                                }
                                                                                            ?>
                                                                                            <b>(<?php $c1 = $rowMarketing['count']; $ft = $c2 + $c1; echo $ft; ?>) email sent!</b>
                                                                                            <?php } ?>
                                                                                            
                                                                                            
                                                                                            
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                      </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h5>Call Summary</h5>
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Today</th>
                                                                                        <th>Weekly</th>
                                                                                        <th>Monthly</th>
                                                                                        <th>Total</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d');
                                                                                            
                                                                                            $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                            $resultSummary = mysqli_query($conn, $querySummary);
                                                                                            
                                                                                            $count = 1;
                                                                                            $total = 0;
                                                                                            $total2 = 0;
                                                                                            $final = 0;
                                                                                            while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                               
                                                                                               
                                                                                               
                                                                                                $date = date_create($rowSummary['notes_date']);
                                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                                $userID = $rowSummary['user_cookies'];
                                                                                                // $date_function = false;
                                                                                                if($today == $date_get && $getIDs == $userID){
                                                                                                   $total = $count++;
                                                                                                   
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            for ($x = 0; $x < $total; $x++) {} echo "($x) record/s.";
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                                $getMail = $row['email'];
                                                                                                $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                                $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                            
                                                                                                while($rowuser = mysqli_fetch_array($resultuser))
                                                                                                {
                                                                                                    $getIDs = $rowuser['ID'];
                                                                                                }
                                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                                $today = $date_default_tx->format('Y/m/d');
                                                                                                
                                                                                                $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                                $resultSummary = mysqli_query($conn, $querySummary);
                                                                                                
                                                                                                $count = 1;
                                                                                                $total = 0;
                                                                                                $total2 = 0;
                                                                                                $final = 0;
                                                                                                while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                                   
                                                                                                   
                                                                                                   
                                                                                                    $date = date_create($rowSummary['notes_date']);
                                                                                                    $date_get = date_format($date,"Y/m/d");
                                                                                                    $userID = $rowSummary['user_cookies'];
                                                                                                    $startTimeStamp = strtotime($date_get);
                                                                                                    $endTimeStamp = strtotime($today);
                                                                                                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                                    // and you might want to convert to integer
                                                                                                     $numberDays = intval($numberDays);
                                                                                                    if($numberDays < 7 && $getIDs == $userID){
                                                                                                       $total = $count++;
                                                                                                       
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                                                
                                                                                                for ($x = 0; $x < $total; $x++) {} echo "($x) record/s.";
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                                $getMail = $row['email'];
                                                                                                $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                                $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                            
                                                                                                while($rowuser = mysqli_fetch_array($resultuser))
                                                                                                {
                                                                                                    $getIDs = $rowuser['ID'];
                                                                                                }
                                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                                $today = $date_default_tx->format('Y/m/d');
                                                                                                
                                                                                                $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                                $resultSummary = mysqli_query($conn, $querySummary);
                                                                                                
                                                                                                $count = 1;
                                                                                                $total = 0;
                                                                                                $total2 = 0;
                                                                                                $final = 0;
                                                                                                while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                                   
                                                                                                   
                                                                                                   
                                                                                                    $date = date_create($rowSummary['notes_date']);
                                                                                                    $date_get = date_format($date,"Y/m/d");
                                                                                                    $userID = $rowSummary['user_cookies'];
                                                                                                    $startTimeStamp = strtotime($date_get);
                                                                                                    $endTimeStamp = strtotime($today);
                                                                                                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                                    // and you might want to convert to integer
                                                                                                     $numberDays = intval($numberDays);
                                                                                                    if($numberDays < 30 && $getIDs == $userID){
                                                                                                       $total = $count++;
                                                                                                       
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                                                
                                                                                                for ($x = 0; $x < $total; $x++) {} echo "($x) record/s.";
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $getMail = $row['email'];
                                                                                            $queryuser = "SELECT *  FROM tbl_user where email ='$getMail'";
                                                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                                                                                        
                                                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                                            {
                                                                                                $getIDs = $rowuser['ID'];
                                                                                            }
                                                                                            
                                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                            $today = $date_default_tx->format('Y/m/d'); 
                                                                                            $querySummary = "SELECT count(*) as count  FROM tbl_Customer_Relationship_Notes where user_cookies = $getIDs and Title = 'Call Summary'";
                                                                                            $resultSummary = mysqli_query($conn, $querySummary);
                                                                                                                        
                                                                                            while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                            ?>
                                                                                            
                                                                                            
                                                                                            <b>(<?php echo $rowSummary['count']; ?>) record/s.</b>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          <h5>Contact Relationship Management</h5>
                                                                      <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No.</th>
                                                                                    <th>Task</th>
                                                                                    <th>Description</th>
                                                                                    <th>From</th>
                                                                                    <th>Deadline</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <!--Pending-->
                                                                            <?php
                                                                                $t=1;
                                                                                $getMail = $row['email'];
                                                                                $queryt = "SELECT *  FROM tbl_Customer_Relationship_Task  where Task_Status = 1 and Assigned_to = '$getMail'";
                                                                                $resultt = mysqli_query($conn, $queryt);
                                                                                                            
                                                                                while($rowt = mysqli_fetch_array($resultt)):?>
                                                                                <tr style="color:#B73E3E;">
                                                                                    <td><?php echo $t++; ?></td>
                                                                                    <td><?php echo $rowt['assign_task']; ?></td>
                                                                                    <td><?php echo $rowt['Task_Description']; ?></td>
                                                                                    <td>
                                                                                        <?php
                                                                                            $from_task = $rowt['user_cookies'];
                                                                                            $queryf = "SELECT *  FROM tbl_user where ID = $from_task ";
                                                                                            $resultf = mysqli_query($conn, $queryf);                          
                                                                                            while($rowf = mysqli_fetch_array($resultf))
                                                                                            {?>
                                                                                            <?php echo $rowf['first_name']; ?>&nbsp;<?php echo $rowf['last_name']; ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td><?php echo $rowt['Deadline']; ?></td>
                                                                                </tr>
                                                                                <?php endwhile; ?>
                                                                                <!--Inprogress-->
                                                                                <?php
                                                                                $t=1;
                                                                                $getMail = $row['email'];
                                                                                $queryt = "SELECT *  FROM tbl_Customer_Relationship_Task  where Task_Status = 2 and Assigned_to = '$getMail'";
                                                                                $resultt = mysqli_query($conn, $queryt);
                                                                                                            
                                                                                while($rowt = mysqli_fetch_array($resultt)):?>
                                                                                <tr style="color:#E38B29;">
                                                                                    <td><?php echo $t++; ?></td>
                                                                                    <td><?php echo $rowt['assign_task']; ?></td>
                                                                                    <td><?php echo $rowt['Task_Description']; ?></td>
                                                                                    <td>
                                                                                        <?php
                                                                                            $from_task = $rowt['user_cookies'];
                                                                                            $queryf = "SELECT *  FROM tbl_user where ID = $from_task ";
                                                                                            $resultf = mysqli_query($conn, $queryf);                          
                                                                                            while($rowf = mysqli_fetch_array($resultf))
                                                                                            {?>
                                                                                            <?php echo $rowf['first_name']; ?>&nbsp;<?php echo $rowf['last_name']; ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td><?php echo $rowt['Deadline']; ?></td>
                                                                                </tr>
                                                                                <?php endwhile; ?>
                                                                                <!--Done-->
                                                                                <?php
                                                                                $t=1;
                                                                                $getMail = $row['email'];
                                                                                $queryt = "SELECT *  FROM tbl_Customer_Relationship_Task  where Task_Status = 3 and Assigned_to = '$getMail'";
                                                                                $resultt = mysqli_query($conn, $queryt);
                                                                                                            
                                                                                while($rowt = mysqli_fetch_array($resultt)):?>
                                                                                <tr style="color:#42855B;">
                                                                                    <td><?php echo $t++; ?></td>
                                                                                    <td><?php echo $rowt['assign_task']; ?></td>
                                                                                    <td><?php echo $rowt['Task_Description']; ?></td>
                                                                                    <td>
                                                                                        <?php
                                                                                            $from_task = $rowt['user_cookies'];
                                                                                            $queryf = "SELECT *  FROM tbl_user where ID = $from_task ";
                                                                                            $resultf = mysqli_query($conn, $queryf);                          
                                                                                            while($rowf = mysqli_fetch_array($resultf))
                                                                                            {?>
                                                                                            <?php echo $rowf['first_name']; ?>&nbsp;<?php echo $rowf['last_name']; ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td><?php echo $rowt['Deadline']; ?></td>
                                                                                </tr>
                                                                                <?php endwhile; ?>
                                                                            </tbody>
                                                                        </table>
                                                                      </div>
                                                                  </div>
                                                                </div>   
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    
                                                </table>
                                        </div>
                                        <div class="tab-pane" id="tab_Drafted">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataServicesComplete">
                                                    <thead>
                                                        <tr>
                                                            <th>ID#</th>
                                                            <th>Category</th>
                                                            <th>Service</th>
                                                            <th>Contact Info</th>
                                                            <th class="text-center" style="width: 135px;">Desire Due Date</th>
                                                            <th class="text-center" style="width: 135px;">Completed</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="btnUpdate_Service" id="btnUpdate_Service" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script type="text/javascript">
          var acc = document.getElementsByClassName("accordion-task");
            var i;
            
            for (i = 0; i < acc.length; i++) {
              acc[i].addEventListener("click", function() {
                this.classList.toggle("active-task");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                  panel.style.display = "none";
                } else {
                  panel.style.display = "block";
                }
              });
            }
        </script>
        <style>
        .accordion-task {
          background-color: #eee;
          color: #444;
          cursor: pointer;
          padding: 15px;
          width: 100%;
          border: none;
          text-align: left;
          outline: none;
          font-size: 15px;
          transition: 0.4s;
        }
        
        .active-task, .accordion-task:hover {
          background-color: #ccc; 
        }
        
        .panel-task {
          padding: 0 15px;
          display: none;
          background-color: white;
          overflow: hidden;
        }
        .pending{
            font-size:12px;
            font-weight:600;
            margin:2px;
            padding:0 5px;
            background-color:#874C62;
            color:#fff;
        }
        .inprogress{
            font-size:12px;
            font-weight:600;
            margin:2px;
            padding:0 5px;
            background-color:#C98474;
            color:#fff;
        }
        .done{
            font-size:12px;
            font-weight:600;
            margin:2px;
            padding:0 5px;
            background-color:#1C6758;
            color:#fff;
        }
        </style>
    </body>
</html>