
<?php
error_reporting(0);
//action.php
if(isset($_POST["action"]))
{
 $conn = mysqli_connect("localhost", "brandons_interlinkiq", "L1873@2019new", "brandons_interlinkiq");
 if($_POST["action"] == "fetch")
 {
  $query = "SELECT * FROM tbl_appstore ORDER BY app_id DESC";
  $result = mysqli_query($conn, $query);
  
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" >
       <div class="card" data-label="$'.$row["pricing"].'">
           <div class="mt-card-item" style="background-color:#EEEEEE; padding: 15px;">
               <div class="mt-card-avatar mt-overlay-1 mt-scroll-down">
                   <img src="admin_2/app-store-img/'.$row["images_name"].'" style="height:200px;">
                   <div class="mt-overlay">
                       <ul class="mt-info">
                           <li>
                               <a class="btn default btn-outline" href="javascript:;">
                                           GET
                               </a>
                                   </li>
                                   <li>
                                       <a class="btn default btn-outline" data-toggle="modal" href="#modalView">
                                           <i class="icon-magnifier"></i>
                                       </a>
                           </li>
                       </ul>
                   </div>
                   
               </div>
               <div class="mt-card-content">
                   <h3 class="mt-card-name" style="color:#1F4690;font-weight:800;">'.$row["application_name"].'</h3>
                   <p class="mt-card-desc font-grey-mint" style=" height:100px;">'.$row["descriptions"].'</p>
               </div>
           </div>
       </div>
       </div>
  
    
   ';
  }
  echo $output;
 }

 if($_POST["action"] == "insert")
 {
    
    $application_name = $_POST["application_name"];
    $descriptions = $_POST["descriptions"];
    $pricing = $_POST["pricing"];
    $app_url = $_POST["app_url"];
    $developer = $_POST["developer"];
     $apptype = $_POST["apptype"];
    $file = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"]; 
    
     $file1 = $_FILES["image1"]["name"];
    $tempname1 = $_FILES["image1"]["tmp_name"]; 
     $file2 = $_FILES["image2"]["name"];
    $tempname2 = $_FILES["image2"]["tmp_name"]; 
     $file3 = $_FILES["image3"]["name"];
    $tempname3 = $_FILES["image3"]["tmp_name"]; 
     $file4 = $_FILES["image4"]["name"];
    $tempname4 = $_FILES["image4"]["tmp_name"]; 
     $file5 = $_FILES["image5"]["name"];
    $tempname5 = $_FILES["image5"]["tmp_name"]; 
     $file6 = $_FILES["image6"]["name"];
    $tempname6 = $_FILES["image6"]["tmp_name"]; 

    $folder = "../app-store-img/".$file;   
    move_uploaded_file($tempname, $folder);
    
    $folder1 = "../app-store-img/".$file1;   
    move_uploaded_file($tempname1, $folder1);
    
    $folder2 = "../app-store-img/".$file2;   
    move_uploaded_file($tempname2, $folder2);
    
    $folder3 = "../app-store-img/".$file3;   
    move_uploaded_file($tempname3, $folder3);
    
    $folder4 = "../app-store-img/".$file4;   
    move_uploaded_file($tempname4, $folder4);
    
    $folder5 = "../app-store-img/".$file5;   
    move_uploaded_file($tempname5, $folder5);
    
    $folder6 = "../app-store-img/".$file6;   
    move_uploaded_file($tempname6, $folder6);
//   $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
 $query = "INSERT INTO tbl_appstore(application_name,descriptions,pricing,app_url,developer,images_name,images_name1,images_name2,images_name3,images_name4,images_name5,images_name6,appType) VALUES ('$application_name','$descriptions','$pricing','$app_url','$developer','$file','$file1','$file2','$file3','$file4','$file5','$file6','$apptype')";
if(mysqli_query($conn, $query))
 {
  echo 'Added Successfully';
    }
 }
 if($_POST["action"] == "update")
 {
  $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
  $query = "UPDATE tbl_appstore SET images_name = '$file' WHERE app_id = '".$_POST["app_id"]."'";
  if(mysqli_query($conn, $query))
  {
   echo ' Updated Successfully';
  }
 }
 if($_POST["action"] == "delete")
 {
  $query = "DELETE FROM tbl_appstore WHERE app_id = '".$_POST["app_id"]."'";
  if(mysqli_query($conn, $query))
  {
   echo 'Deleted Successfully';
  }
 }
}
?>