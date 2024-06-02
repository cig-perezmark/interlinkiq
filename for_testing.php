<?php

include "database.php";

 

    $total_minute =0;
    $total = 0;
    $overall = 0;
    $ot_query = mysqli_query($conn, "select * from tbl_service_logs where user_id = '38' and week(task_date) = week(now()) AND not_approved = 0 order by task_date desc");
    foreach($ot_query as $ot_row){
            $taskid = $ot_row['task_id'];
            $ddescription = $ot_row['description'];
            $ccomment = $ot_row['comment'];
            $mminute = $ot_row['minute'];
            $tasktdate = $ot_row['task_date'];
            $total_minute += $ot_row['minute'];
    }
    $task_date = date('Y-m-d', strtotime($tasktdate));
    $ttoday = date('Y-m-d');
    echo $overall = $total_minute;
    echo '<br>';
     if($overall < 438 && empty($get_row['reasons']) && $task_date != $ttoday){
         echo 'good';
         echo '<br>';
         echo $task_date;
         echo '<br>';
         echo $ddescription;
         echo '<br>';
         echo $ccomment;
         echo '<br>';
         echo $mminute;
         echo '<br>';
         echo $taskid;
        exit;
     }

?>