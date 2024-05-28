<?php 
include "database.php";
include "inc/landing_header.php"; 

?>
 <div style="background-color:#242F9B;height:80px;width:100%;"></div>
<div class="container">
   
    <br><br><br><br>
    <div class="row">
        <div class="col-md-12">
               
                <table id="table">
                   <thead style="background-color:#035397;color:#fff;">
                       <tr>
                          <td>#</td>
                          <td>Title</td>
                          <!--<td>Description</td>-->
                          <td></td>
                       </tr>
                   </thead>
                   <tbody>
            <?php   
            
            $i = 1;
            $users = $_COOKIE['ID'];
            $query = "SELECT * FROM tbl_blogs_pages where status_publish = 1 order by blogs_title ASC";
            $result = mysqli_query($conn, $query);
                                        
            while($row = mysqli_fetch_array($result))
            {?>
               
                       <tr>
                           <td><?php echo $i++;?></td>
                           <!--<td><?php //echo $row['blogs_title']; ?></td>-->
                           <td style=""><p class="smalls"><?php echo $row['description_view']; ?></p></td>
                           <td><a href="blog_posts.php?id=<?php echo $row['blogs_id']; ?>">View</a></td>
                       </tr>
            <?php } ?>
                   </tbody>
               </table>
               <br>
               <br>
               <br>
        </div>
       </div>
</div>
<?php include "inc/footer.php"; ?>
<style>
#table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#table td, #table th {
  border: 1px solid #ddd;
  padding: 10px;
}

#table tr:nth-child(even){background-color: #E8F9FD;}

#table tr:hover {background-color: #2155CD;color:#fff;}

#table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>



