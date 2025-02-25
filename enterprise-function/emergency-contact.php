<?php
error_reporting(0);
include('../database.php');
//action.php
if(isset($_POST["action"]))
{
//  $conn = mysqli_connect("localhost", "brandons_interlinkiq", "L1873@2019new", "brandons_interlinkiq");

 if($_POST["action"] == "insert")
 {
    $getStatus = 1;
    $app_id = $_POST["ID"];
    $userID = $_POST["userID"];
    $companydetails = $_POST["companydetails"];
    $query = "INSERT INTO tblEnterpiseDetails_Emergency(users_entities,apps_entities,companyDetails,getStatus) VALUES ('$userID','$app_id','$companydetails','$getStatus')";
    if(mysqli_query($conn, $query))
     {
      echo 'Added Successfully';
    }
 }
}
?>
