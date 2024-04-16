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
    $edit=mysqli_query($conn,"UPDATE tbl_project_management SET start_date='$start', completion_date='$end' WHERE project_pk ='$id'");
  
    // echo $start;
}

?>