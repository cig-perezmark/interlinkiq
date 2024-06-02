<?php 
require '../database.php';
if( isset($_POST['pdf_notstarted_id']) ) {
    
	$ID = $_POST['pdf_notstarted_id'];

    $project = $conn->query("SELECT * FROM tbl_MyProject_Services where MyPro_id = '$ID'");
      if(mysqli_num_rows($project) > 0) {
        while($row = $project->fetch_assoc()) {?>
           <div class="row">
                <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Ticket#:</b> </label>
                       <?= $row['MyPro_id']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Project Name:</b> </label>
                       <?= $row['Project_Name']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Description:</b> </label>
                       <?= $row['Project_Description']; ?>
                   </div>
               </div>
           </div>
           <table class="table table-bordered " style="table-layout: fixed;width:100%;">
                <thead class="bg-info">
                    <tr>
                        <th style="width:45px !important;">#</th>
                        <th style="width:150px !important;">Assign to</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th style="width:140px !important;">Desired Due Date</th>
                    </tr>
                </thead>
                 <tbody>
                     <?php
                        $in__counter = 1; 
                        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 0 and Parent_MyPro_PK = $ID order by CAI_Action_due_date ASC";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result))
                         { ?>
        
                                <tr>
                                    <td><?= $in__counter++; ?></td>
                                    <td>
                                        <?php
                                            $emp_id =$row['CAI_Assign_to'];
                                            $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                            $result_emp = mysqli_query($conn, $query_emp);
                                            while($row_emp = mysqli_fetch_array($result_emp))
                                             {
                                                 echo $row_emp['first_name'];
                                             }
                                        ?>
                                        </td>
                                    <td><?= $row['CAI_filename']; ?></td>
                                    <td><?= $row['CAI_description']; ?></td>
                                    <td><?php if(!empty($row['CAI_Action_date'])){ echo date('Y-m-d',strtotime($row['CAI_Action_date']));} ?></td>
                                </tr>
                        <?php }
                     ?>
                </tbody>
             </table>
        <?php }
    }
}

if( isset($_POST['pdf_inprogress_id']) ) {
    
	$ID = $_POST['pdf_inprogress_id'];

    $project = $conn->query("SELECT * FROM tbl_MyProject_Services where MyPro_id = '$ID'");
      if(mysqli_num_rows($project) > 0) {
        while($row = $project->fetch_assoc()) {?>
           <div class="row">
                <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Ticket#:</b> </label>
                       <?= $row['MyPro_id']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Project Name:</b> </label>
                       <?= $row['Project_Name']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Description:</b> </label>
                       <?= $row['Project_Description']; ?>
                   </div>
               </div>
           </div>
           <table class="table table-bordered " style="table-layout: fixed;width:100%;">
                <thead class="bg-info">
                    <tr>
                        <th style="width:45px !important;">#</th>
                        <th style="width:150px !important;">Assign to</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th style="width:140px !important;">Due Date</th>
                    </tr>
                </thead>
                 <tbody>
                     <?php
                        $in__counter = 1; 
                        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 1 and Parent_MyPro_PK = $ID order by CAI_Action_due_date ASC";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result))
                         { ?>
        
                                <tr>
                                    <td><?= $in__counter++; ?></td>
                                    <td>
                                        <?php
                                            $emp_id =$row['CAI_Assign_to'];
                                            $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                            $result_emp = mysqli_query($conn, $query_emp);
                                            while($row_emp = mysqli_fetch_array($result_emp))
                                             {
                                                 echo $row_emp['first_name'];
                                             }
                                        ?>
                                        </td>
                                    <td><?= $row['CAI_filename']; ?></td>
                                    <td><?= $row['CAI_description']; ?></td>
                                    <td><?php if(!empty($row['CAI_Action_due_date'])){ echo date('Y-m-d',strtotime($row['CAI_Action_due_date']));} ?></td>
                                </tr>
                        <?php }
                     ?>
                </tbody>
             </table>
        <?php }
    }
}

if( isset($_POST['pdf_completed_id']) ) {
    
	$ID = $_POST['pdf_completed_id'];

    $project = $conn->query("SELECT * FROM tbl_MyProject_Services where MyPro_id = '$ID'");
      if(mysqli_num_rows($project) > 0) {
        while($row = $project->fetch_assoc()) {?>
           <div class="row">
                <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Ticket#:</b> </label>
                       <?= $row['MyPro_id']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Project Name:</b> </label>
                       <?= $row['Project_Name']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label><b>Description:</b> </label>
                       <?= $row['Project_Description']; ?>
                   </div>
               </div>
           </div>
           <table class="table table-bordered " style="table-layout: fixed;width:100%;">
                <thead class="bg-info">
                    <tr>
                        <th style="width:45px !important;">#</th>
                        <th style="width:150px !important;">Assign to</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th style="width:140px !important;">Date Completed</th>
                    </tr>
                </thead>
                 <tbody>
                     <?php
                        $comp__counter = 1; 
                        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 2 and Parent_MyPro_PK = $ID order by Date_Completed DESC";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result))
                         { ?>
        
                                <tr>
                                    <td><?= $comp__counter++; ?></td>
                                    <td>
                                        <?php
                                            $emp_id =$row['CAI_Assign_to'];
                                            $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                            $result_emp = mysqli_query($conn, $query_emp);
                                            while($row_emp = mysqli_fetch_array($result_emp))
                                             {
                                                 echo $row_emp['first_name'];
                                             }
                                        ?>
                                        </td>
                                    <td><?= $row['CAI_filename']; ?></td>
                                    <td><?= $row['CAI_description']; ?></td>
                                    <td><?php if(!empty($row['Date_Completed'])){ echo date('Y-m-d',strtotime($row['Date_Completed']));} ?></td>
                                </tr>
                        <?php }
                     ?>
                </tbody>
             </table>
        <?php }
    }
}
?>
