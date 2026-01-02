<?php
	require '../database.php';
//search
if(isset($_POST['search'])){
	    $search = $_POST['search'];
 	    $query = "SELECT * FROM tbl_Project_Services where services_name LIKE '{$search}%' OR services_category LIKE '{$search}%'";

 		$result = mysqli_query($conn, $query);
 		if(mysqli_num_rows($result) > 0){
 		    while($row = mysqli_fetch_assoc($result)) {
 		    ?>
 		        
 		        <tr>
 		            <td></td>
 		            <td><?php echo $row['services_name']; ?></td>
 					<td><?php echo $row['services_category']; ?></td>
 					<td></td>
 				</tr>
				
	        <?php	}
 		}
 		else{
 		    echo '<h6>No data found</h6>';
 		}
         
}
//fetch display main
if (isset($_POST['key'])) {
	$response = "";
	if ($_POST['key'] == 'getServices') {
	    $count_row = 1;
		$sql = "SELECT * FROM tbl_Project_Services order by ps_id DESC";
		$result = mysqli_query($conn, $sql);
		while($data = mysqli_fetch_assoc($result)) {
			$response .= '
				<tr>
				    <td style="width:10px !important;">'.$count_row++.'</td>
				    <td >'.$data['services_name'].'</td>
					<td>'.$data['services_category'].'</td>
					<td>
					    <a style="font-weight:800;color:#fff;" href="#modalGet" data-toggle="modal" class="btn red btn-xs" onclick="btnUpdate('.$data['ps_id'].')">Edit</a>
					</td>
				</tr>
			';
		}
	}

	exit($response);
}


	// modal update Action Item
	if( isset($_GET['modal_update']) ) {
		$ID = $_GET['modal_update'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	        $query = "SELECT * FROM tbl_Project_Services where ps_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
             { 
                echo'
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Service</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="services_name" value="'.$row['services_name'].'">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Category</label>
                        </div>
                        <div class="col-md-12">
                            <select class="form-control" name="services_category">';
                                $cat_ = $row['services_category'];
                                $query1 = "SELECT * FROM tbl_Project_Category order by category_name ASC";
                                $result1 = mysqli_query($conn, $query1);
                                while($row1 = mysqli_fetch_array($result1))
                                 { 
                                     echo'<option value="'.$row1['category_name'].'" '; echo $row1['category_name'] == $row['services_category'] ? 'selected' : ''; echo '>'.$row1['category_name'].'</option>';
                                 }
                            echo '
                            </select>
                        </div>
                    </div>
                ';
             
             }
             
        }
        
	if( isset($_POST['btnSave_update']) ) {
        //$user_id = $_COOKIE['ID'];
            
	    $ID = $_POST['ID'];
		$services_name = mysqli_real_escape_string($conn,$_POST['services_name']);
		$services_category = mysqli_real_escape_string($conn,$_POST['services_category']);
		echo $sql = "UPDATE tbl_Project_Services  SET services_name = '$services_name',services_category = '$services_category' where ps_id = $ID";
 		if (mysqli_query($conn, $sql)) {
		
 		}
 		echo json_encode($conn);
	}
	
?>
