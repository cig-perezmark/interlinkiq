<?php
include 'database.php';

if(isset($_POST["id"])){

    $title = $_POST['title'];
    $start = $_POST['start'];
    $id = $_POST['id'];
    $edit=mysqli_query($sanition_connection,"UPDATE parts_maintainance SET  equipment_parts_PK_id='$equipment_parts_PK_id', next_maintainance='$start' WHERE parts_id ='$id'");
}
?>