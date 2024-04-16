<?php 
include('database.php');

if($_GET['action']=='user_verification'){
  
    $query = "SELECT * FROM tbl_user";
    $result = mysqli_query($conn, $query);
     while($row = mysqli_fetch_array($result)){
         $done = false;
         if($row['ID'] == $_GET['id'] && $row['first_name'] == $_GET['name'] ){
            //  $done = true;
            //  break;
           if($row['ID'] == 19){
            $fname = $row['first_name'];
             header('location: http://www.prpblaster.com/qc/forms/InterlinkIQ/list/'. $fname.'');
           }
           else{
               $fname = $row['first_name'];
                 header('location: http://www.prpblaster.com/qc/forms/InterlinkIQ/demo_list/'. $fname.'');
           }
         }
     }
                                                                                
   
}else{
    echo "Access Denied!!";
}

?>