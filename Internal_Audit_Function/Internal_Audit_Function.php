<?php
include "../database.php";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['save_IA'])){
    $users = $_COOKIE['ID'];
    $IA_Category = mysqli_real_escape_string($conn,$_POST['IA_Category']);
    $IA_Areas = mysqli_real_escape_string($conn,$_POST['IA_Areas']);
    $IA_Description = $_POST['IA_Description'];
    $IA_Account = $_POST['IA_Account'];
    
    $sql = "INSERT INTO tbl_Internal_Audit (IA_Category,IA_Account,IA_Areas,IA_Description,Addby_id) VALUES ('$IA_Category','$IA_Account','$IA_Areas','$IA_Description','$users')";
    if ($conn->query($sql) === TRUE) {
          echo '<script> window.location.href = "../Internal_Audit";</script>';
    }else{
         echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Add multiple
    if(isset($_POST['btn_Multi_IT'])) {
        $userID = $_COOKIE['ID'];
        $from = $_POST['from'];
        $fileTypes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
        );

        // Validate whether selected file is a CSV file
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileTypes)) {
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== false) {
              // Get row data
            $IA_Category = mysqli_real_escape_string($conn,$getData[0]);
            $IA_Areas = mysqli_real_escape_string($conn,$getData[1]);
            $IA_Description = mysqli_real_escape_string($conn,$getData[2]);
            $IA_Account = mysqli_real_escape_string($conn,$getData[3]);
            
            
             $sql = "INSERT INTO tbl_Internal_Audit (IA_Category,IA_Account,IA_Areas,IA_Description,Addby_id) VALUES ('$IA_Category','$IA_Account','$IA_Areas','$IA_Description','$userID')";
            if ($conn->query($sql) === TRUE) {
                  echo '<script> window.location.href = "../Internal_Audit";</script>';
            }else{
                 echo "Error: " . $sql . "<br>" . $conn->error;
            }
            }
            // Close opened CSV file
            fclose($csvFile);
        }
        else {
          echo "Please select valid file";
        }
    }
// if(isset($_POST['edit_blog'])){
//         $ids = $_POST['ids'];
//         $blogs_title = mysqli_real_escape_string($conn,$_POST['blogs_title']);
//          $desc_view = mysqli_real_escape_string($conn,$_POST['description_view']);
//         $desc = $_POST['description'];
        
//         $sql = "Update tbl_blogs_pages set blogs_title='$blogs_title',description_view='$desc_view',descriptions='$desc' where  blogs_id = '$ids' ";
//         if ($conn->query($sql) === TRUE) {
//               echo '<script> window.location.href = "../blog_pages";</script>';
//         }else{
//              echo "Error: " . $sql . "<br>" . $conn->error;
//         }
// }
// if(isset($_GET['publishid'])){
//   echo $ids = $_GET['publishid'];
//         $publish = 1;
//         $sql = "Update tbl_blogs_pages set status_publish = '$publish' where  blogs_id = '$ids' ";
//             if ($conn->query($sql) === TRUE) {
//                   echo '<script> window.location.href = "../blog_pages";</script>';
//             }else{
//                  echo "Error: " . $sql . "<br>" . $conn->error;
//             }
//     }
//     if(isset($_GET['stop'])){
//   echo $ids = $_GET['stop'];
//         $publish = 0;
//         $sql = "Update tbl_blogs_pages set status_publish = '$publish' where  blogs_id = '$ids' ";
//             if ($conn->query($sql) === TRUE) {
//                   echo '<script> window.location.href = "../blog_pages";</script>';
//             }else{
//                  echo "Error: " . $sql . "<br>" . $conn->error;
//             }
//     }
$conn->close();
?>
