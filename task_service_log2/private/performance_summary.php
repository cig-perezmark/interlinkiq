<?php

if(!isset($_COOKIE['ID'])) {
    die("Invalid action.");
}

include "connection.php";

$summ = array();
$currentDate = date('Y-m-d');
$currentWeek = date('Y-m-d', strtotime("sunday -1 week"));

$summ['current_date'] = $currentDate;

// overall time spent
$data = $con->query("SELECT SUM(minute) as total FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND not_approved = 0");
$total = $data->fetch_assoc()['total'];
$hours = $total / 60;
$minutes = $total % 60;
if($hours >= 1) {
    $summ['overall_time'] = number_format(floor($hours))." <h4 class='font-grey-cascade d-inline-block'>".pluralize("hr", floor($hours)).
                            (($minutes > 0) ? " & </h4> ".$minutes." <h4 class='font-grey-cascade d-inline-block'>".pluralize("min", $minutes)."</h4>" : "</h4>");
}
else if($minutes > 0) {
    $summ['overall_time'] = $minutes." <h4 class='font-grey-cascade d-inline-block'>".pluralize("min", $minutes)."</h4>";
}
else {
    $summ['overall_time'] = 0;
}

// total completed tasks
$data = $con->query("SELECT COUNT(*) AS tasks FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND not_approved = 0");
$tasks = $data->fetch_assoc()['tasks'];
$summ['total_completed_tasks'] = number_format($tasks);


// SELECT task_date,SUM(minute) as total_minutes FROM `tbl_service_logs` WHERE user_id = 1 GROUP BY task_date HAVING total_minutes >= 480;
// total days worked
$data = $con->query("SELECT COUNT(DISTINCT task_date) AS days FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND not_approved = 0");
$days = $data->fetch_assoc()['days'];
$summ['total_days_worked'] = number_format($days);

// daily time
$data = $con->query("SELECT SUM(minute) as time FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND task_date = '$currentDate' AND not_approved = 0");
$time = $data->fetch_assoc()['time'];
$hours = $time / 60;
$minutes = $time % 60;
if($hours >= 1) {
    $summ['daily_time'] = number_format(floor($hours))." <h5 class='d-inline-block'>".pluralize("hr", $hours).
                            (($minutes > 0) ? " & </h5> ".$minutes." <h5 class='d-inline-block'>".pluralize("min", $minutes)."</h5>" : "</h5>");
}
else if($minutes > 0) {
    $summ['daily_time'] = $minutes." <h5 class='d-inline-block'>".pluralize("min", $minutes)."</h5>";
}
else {
    $summ['daily_time'] = 0;
}

// daily taskks 
$data = $con->query("SELECT COUNT(*) as tasks FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND task_date = '$currentDate' AND not_approved = 0");
$tasks = $data->fetch_assoc()['tasks'];
$summ['daily_tasks'] = $tasks." <h5 class='d-inline-block'>total</h5>";

// weekly time
$data = $con->query("SELECT SUM(minute) as time FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND task_date >= '$currentWeek'");
$time = $data->fetch_assoc()['time'];
$hours = $time / 60;
$minutes = $time % 60;
if($hours >= 1) {
    $summ['weekly_time'] = number_format(floor($hours))." <h5 class='d-inline-block'>".pluralize("hr", $hours).
                            (($minutes > 0) ? " & </h5> ".$minutes." <h5 class='d-inline-block'>".pluralize("min", $minutes)."</h5>" : "</h5>");
}
else if($minutes > 0) {
    $summ['weekly_time'] = $minutes." <h5 class='d-inline-block'>".pluralize("min", $minutes)."</h5>";
}
else {
    $summ['weekly_time'] = 0;
}

// weekly taskks 
$data = $con->query("SELECT COUNT(*) as tasks FROM `tbl_service_logs` WHERE user_id = {$_COOKIE['ID']} AND task_date >= '$currentWeek' AND not_approved = 0");
$tasks = $data->fetch_assoc()['tasks'];
$summ['weekly_tasks'] = $tasks." <h5 class='d-inline-block'>total</h5>";

// calculations for averages
// I choose to start from the earliest date so I can basically get the last day of its week
// then I can regroup them in to weeks
$data = $con->query("SELECT SUM(minute) AS sum,`task_date` as date FROM `tbl_service_logs`
                        WHERE user_id = {$_COOKIE['ID']} GROUP BY task_date
                        ORDER BY task_date ASC"); 
$total_rows = mysqli_num_rows($data);
if($total_rows > 0) {
    $total_hrs = 0; // sum hours
    $total_hrs_w = 0; $end_of_week = 0; $week_count = 1;
    while($row = $data->fetch_assoc()) {
        $date_ts = strtotime($row['date']); // timestamp of date
        
        // computing the overall total of the minutes (avg hrs/day)
        $total_hrs += $row['sum'];
        
        // if the date is not part of the current week, will calculate the averages
        if($date_ts < date(strtotime("Sunday -1 week"))) {
            $total_hrs_w += $row['sum']; // sum up minutes 
            if($date_ts >= $end_of_week) {
                // this is to count how many weeks are there based on the dates
                $end_of_week = date(strtotime('Next Sunday', strtotime($row['date']))); // get the end of the week of the date
                $week_count++; // add a week 
            }
        }
    }
    
    // for average hours/day
    $hrs = $total_hrs / $total_rows; // mistakenly named the total minutes variable here (hrs), but still has a point tho
    $avg_hrs = $hrs / 60; // get the hours from the total minutes
    $xtra_mins = $hrs % 60;
    if($avg_hrs >= 1) {
        $summ['avg_hours_day'] = floor($avg_hrs)." <h5 class='d-inline-block lowercase'>".pluralize("hr", floor($avg_hrs)).
                                (($xtra_mins > 0) ? " & </h5> ".$xtra_mins." <h5 class='d-inline-block lowercase'>".pluralize("min", $xtra_mins)."</h5>" : "</h5>");
    }
    else if($xtra_mins > 0) {
        $summ['avg_hours_day'] = $xtra_mins." <h5 class='d-inline-block lowercase'> ".pluralize("min", $xtra_mins)."</h5>";
    }

    // for average hours/week
    // the current week is considered and counted as one
    // but if there is a record that is from the past weeks
    // will compute their average except the current 
    if($week_count > 1) {
        $hrs = $total_hrs_w / ($week_count - 1);
        $avg_hrs = $hrs / 60;
        $xtra_mins = $hrs % 60;
        if($avg_hrs >= 1) {
            $summ['avg_hours_week'] = floor($avg_hrs)." <h5 class='d-inline-block lowercase'>".pluralize("hr", floor($avg_hrs)).
                                    (($xtra_mins > 0) ? " & </h5> ".$xtra_mins." <h5 class='d-inline-block lowercase'>".pluralize("min", $xtra_mins)."</h5>" : "</h5>");
        }
        else if($xtra_mins > 0) {
            $summ['avg_hours_week'] = $xtra_mins." <h5 class='d-inline-block lowercase'> ".pluralize("min", $xtra_mins)."</h5>";
        }
    }
}
else {
    $summ['avg_hours_day'] = 0;
    $summ['avg_hours_week'] = 0;
}

// finally
echo json_encode($summ);

// simple function to plurarlize minute and hour (only)
function pluralize($str, $quantity) {
    return ($str . (floor($quantity) > 1 ? "s" : ""));
}