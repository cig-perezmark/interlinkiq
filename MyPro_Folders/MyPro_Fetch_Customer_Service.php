<?php
include '../database.php';
$rows = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services order by MyPro_id ASC");
?>
<table class="table table-bordered table-hover" id="sample_4">
  <tr>
    <th>Task ID</th>
    <th>Project Name</th>
    <th>Description</th>
    <th>Skills And Experience</th>
    <th>Type</th>
    <th>Budget</th>
     <th>Duration</th>
    <th>Desired Date</th>
    <th>Files/Images</th>
    <th></th>
  </tr>
  <?php foreach($rows as $row) : ?>
    <tr>
      <td><?php echo 'TICKET#: '.$row["MyPro_id"]; ?></td>
      <td><?php echo $row["Project_Name"]; ?></td>
      <td><?php echo $row["Project_Description"]; ?></td>
      <td><?php echo $row["Skills_And_Experience"]; ?></td>
      <td>
            <?php
            if($row['Project_Type']==1){
                echo 'One-Time Project'; 
            }else if($row['Project_Type']==2){
                echo 'Part Time'; 
            }else{
                echo 'Full Time';
            }
            ?>
        </td>
      <td><?php echo $row["MyPro_Budget"]; ?></td>
      <td><?php echo $row['Project_Duration'].' day/s'; ?></td>
      <td><?php echo $row["Desired_Deliver_Date"]; ?></td>
      <td><a href="../MyPro_Folder_Files/<?php echo $row["Sample_Documents"]; ?>"><?php echo $row["Sample_Documents"]; ?></a></td>
      <td>
            <a class="btn blue btn-outline btnViewMyPro" data-toggle="modal" href="#modalGetMyPro" onclick="getPro(1)" style="float:right;margin-right:20px;">
                    VIEW
            </a>
        </td>
    </tr>
  <?php endforeach; ?>
</table>
<!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetMyPro" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_Project" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
         <script type="text/javascript">
           
        //   $(".btnViewMyPro").click(function() {
        //         var id = $(this).data("id");
        //         $.ajax({    
        //             type: "GET",
        //             url: "fetch-Assign.php?modalView="+id,
        //             dataType: "html",
        //             success: function(data){
        //                 $("#modalGetMyPro .modal-body").html(data);
                       
        //             }
        //         });
        //     });
            function getPro(id){
                alert(id);
                //  $.ajax({    
                //     type: "GET",
                //     url: "fetch-Assign.php?modalView="+id,
                //     dataType: "html",
                //     success: function(data){
                //         $("#modalGetMyPro .modal-body").html(data);
                       
                //     }
                // });
            }
        </script>
