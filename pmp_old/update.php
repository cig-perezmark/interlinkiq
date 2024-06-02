<?php
 include 'connection/config.php';

if(isset($_POST["id"])){

    $title = $_POST['title'];
    $start = $_POST['start'];
    $id = $_POST['id'];
    $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':title' => $_POST['title'],
            ':start' => $_POST['start'],
            ':end' => $_POST['end'],
            ':id' => $_POST['id']
        )
    );
    $edit=mysqli_query($conn,"UPDATE parts_maintainance SET  equipment_parts_PK_id='$equipment_parts_PK_id', next_maintainance='$start' WHERE parts_id ='$id'");
  
    // echo $start;
}

?>