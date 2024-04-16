<?php 
require '../database.php';
	// Get status only
if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
}
function employerID($ID) {
	global $conn;

	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
        if ( mysqli_num_rows($selectEmployer) > 0 ) {
            $rowEmployer = mysqli_fetch_array($selectEmployer);
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}


//update pricing
if( isset($_GET['get_id']) ) {
	$ID = $_GET['get_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblPricing where pricing_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Category</label>
                        <input class="form-control" name="Category" value="<?= $row['Category']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" name="Description" ><?= $row['Description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Monthly Subscription</label>
                        <input class="form-control" type="number" name="MonthlySubscription" value="<?= $row['MonthlySubscription']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_pricing']) ) {
  
    $user_id = $user_id;
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $Category = mysqli_real_escape_string($conn,$_POST['Category']);
    $Description = mysqli_real_escape_string($conn,$_POST['Description']);
    $MonthlySubscription = mysqli_real_escape_string($conn,$_POST['MonthlySubscription']);
   
	$sql = "UPDATE tblPricing set Category='$Category',Description='$Description',MonthlySubscription='$MonthlySubscription' where pricing_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblPricing where pricing_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                    <td><?php echo $row['Category']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td>$<?php echo $row['MonthlySubscription']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                           
                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td> 
          <?php }
          
          
    }
}

//delete pricing
if( isset($_GET['delete_id']) ) {
	$ID = $_GET['delete_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblPricing where pricing_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Category: </b></label>
                        <i><?= $row['Category']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Description: </b></label>
                        <i><?= $row['Description']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Monthly Subscription: </b></label>
                        <i class="bg-danger">$<?= $row['MonthlySubscription']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_pricing']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblPricing  where pricing_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}
?>