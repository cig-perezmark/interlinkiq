<?php
include "../database.php";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['save_blog'])){
    $users = $_COOKIE['ID'];
        $blogs_title = mysqli_real_escape_string($conn,$_POST['blogs_title']);
         $desc_view = mysqli_real_escape_string($conn,$_POST['description_view']);
        $desc = mysqli_real_escape_string($conn,$_POST['description']);
        
        $sql = "INSERT INTO tbl_blogs_pages (blogs_title,description_view,descriptions,user_entities) VALUES ('$blogs_title','$desc_view','$desc','$users')";
        if ($conn->query($sql) === TRUE) {
              echo '<script> window.location.href = "../blog_pages";</script>';
        }else{
             echo "Error: " . $sql . "<br>" . $conn->error;
        }
}

if(isset($_POST['edit_blog'])){
        $ids = $_POST['ids'];
        $blogs_title = mysqli_real_escape_string($conn,$_POST['blogs_title']);
         $desc_view = mysqli_real_escape_string($conn,$_POST['description_view']);
        $desc = $_POST['description'];
        
        $sql = "Update tbl_blogs_pages set blogs_title='$blogs_title',description_view='$desc_view',descriptions='$desc' where  blogs_id = '$ids' ";
        if ($conn->query($sql) === TRUE) {
              echo '<script> window.location.href = "../blog_pages";</script>';
        }else{
             echo "Error: " . $sql . "<br>" . $conn->error;
        }
}
if(isset($_GET['publishid'])){
   echo $ids = $_GET['publishid'];
        $publish = 1;
        $sql = "Update tbl_blogs_pages set status_publish = '$publish' where  blogs_id = '$ids' ";
            if ($conn->query($sql) === TRUE) {
                  echo '<script> window.location.href = "../blog_pages";</script>';
            }else{
                 echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    if(isset($_GET['stop'])){
   echo $ids = $_GET['stop'];
        $publish = 0;
        $sql = "Update tbl_blogs_pages set status_publish = '$publish' where  blogs_id = '$ids' ";
            if ($conn->query($sql) === TRUE) {
                  echo '<script> window.location.href = "../blog_pages";</script>';
            }else{
                 echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
$conn->close();
?>
