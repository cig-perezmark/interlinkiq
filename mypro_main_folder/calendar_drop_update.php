<?php
 include '../database.php';

if(isset($_POST["id"])){

    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $id = $_POST['id'];
    // $statement = $connect->prepare($query);
    // $statement->execute(
    //     array(
    //         ':title' => $_POST['title'],
    //         ':start' => $_POST['start'],
    //         ':end' => $_POST['end'],
    //         ':id' => $_POST['id']
    //     )
    // );
    $edit=mysqli_query($conn,"UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_Action_date='$start', CAI_Action_due_date='$end' WHERE CAI_id ='$id'");
  
    // echo $start;
}

?>