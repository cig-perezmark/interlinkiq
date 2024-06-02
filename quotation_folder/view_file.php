<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
 $query = mysqli_query($conn,"select * from tblQuotation where quote_id = '$get_id'");
    foreach($query as $row){
        echo $files = $row['file_attch'];
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename"'.$files.'"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($files);
    } 
    }
?>
