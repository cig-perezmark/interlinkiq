<?php 
include "../database.php";

// user identifier
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

// officer function
if( isset($_POST['btnAdd_officer'])){
    
    $cookie = $_COOKIE['ID'];
    $officer_name = implode(' | ', $_POST["officer_name"]);
    $officer_name = explode(' | ', $officer_name);
    if(!empty($officer_name))
    {
        $i = 0;
       foreach($officer_name as $val)
        {
            $officer_title = $_POST["officer_title"][$i];
            $ownership = $_POST["ownership"][$i];
            $class_code = $_POST["class_code"][$i];
            $comp_coverage = $_POST["comp_coverage"][$i];
            
            $sql = "INSERT INTO tblEnterpise_officer(officer_name,officer_title,ownership,class_code,comp_coverage,officer_added_update_by,enterprise_id) 
            VALUES('".mysqli_real_escape_string($conn, $val)."','$officer_title','$ownership','$class_code','$comp_coverage','$cookie','$user_id')";
            if(mysqli_query($conn, $sql)){
                $last_id = mysqli_insert_id($conn);
                $queryr = "SELECT * FROM tblEnterpise_officer where officer_id = $last_id";
                $resultr = mysqli_query($conn, $queryr);
                while($row = mysqli_fetch_array($resultr))
                     { ?>
                   <tr id="row_tblofficer<?= $row['officer_id']; ?>">
                        <td><?= $row['officer_name']; ?></td>
                        <td><?= $row['officer_title']; ?></td>
                        <td><?= $row['ownership']; ?></td>
                        <td><?= $row['class_code']; ?></td>
                        <td><?= $row['comp_coverage']; ?></td>
                        <td>
                            <div class="btn-group btn-group-circle">
	                            <a  href="#modal_update_officer" data-toggle="modal" type="button" id="update_officer" data-id="<?= $row['officer_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
        	                    <a href="#modal_delete_officer" data-toggle="modal" type="button" id="delete_officer" data-id="<?= $row['officer_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                            </div>
                        </td>
                    </tr>
                  <?php }
            }
            $i++;
        }
    }
 
	mysqli_close($conn);
}


//update pricing
if( isset($_GET['get_officer_id']) ) {
	$ID = $_GET['get_officer_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_officer where officer_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Name</label>
                        <input class="form-control" name="officer_name" value="<?= $row['officer_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Title</label>
                        <textarea class="form-control" name="officer_title" ><?= $row['officer_title']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Ownership</label>
                        <input class="form-control" name="ownership" value="<?= $row['ownership']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Work Comp Class Code</label>
                        <input class="form-control" name="class_code" value="<?= $row['class_code']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Include or Exclude for Work Comp Coverage</label>
                        <input class="form-control" name="comp_coverage" value="<?= $row['comp_coverage']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_officer']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $officer_name = mysqli_real_escape_string($conn,$_POST['officer_name']);
    $officer_title = mysqli_real_escape_string($conn,$_POST['officer_title']);
    $ownership = mysqli_real_escape_string($conn,$_POST['ownership']);
    $class_code = mysqli_real_escape_string($conn,$_POST['class_code']);
    $comp_coverage = mysqli_real_escape_string($conn,$_POST['comp_coverage']);
   
	$sql = "UPDATE tblEnterpise_officer set officer_name='$officer_name',officer_title='$officer_title',ownership='$ownership',class_code='$class_code',comp_coverage='$comp_coverage',officer_added_update_by='$cookie' where officer_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_officer where officer_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row['officer_name']; ?></td>
                <td><?= $row['officer_title']; ?></td>
                <td><?= $row['ownership']; ?></td>
                <td><?= $row['class_code']; ?></td>
                <td><?= $row['comp_coverage']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_officer" data-toggle="modal" type="button" id="update_officer" data-id="<?= $row['officer_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_officer" data-toggle="modal" type="button" id="delete_officer" data-id="<?= $row['officer_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete pricing
if( isset($_GET['delete_officer_id']) ) {
	$ID = $_GET['delete_officer_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_officer where officer_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Name: </b></label>
                        <i><?= $row['officer_name']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Title: </b></label>
                        <i><?= $row['officer_title']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>ownership: </b></label>
                        <i><?= $row['ownership']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Work Comp Class Code: </b></label>
                        <i><?= $row['class_code']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Include or Exclude for Work Comp Coverage: </b></label>
                        <i><?= $row['comp_coverage']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_officer']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_officer  where officer_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// save sale date header function
if( isset($_POST['btnAdd_sales'])){
    
    // for us sales
    $cookie = $_COOKIE['ID'];
    $enter_id = $_POST["enter_id"];
    
    $estimated_start_date = 'NULL';
    if(!empty($_POST["estimated_start_date"])){
        $estimated_start_date = $_POST["estimated_start_date"];
    }
    
    $estimated_to_date = 'NULL';
    if(!empty($_POST["estimated_to_date"])){
        $estimated_to_date = $_POST["estimated_to_date"];
    }
    $projected_start_date = 'NULL';
    if(!empty($_POST["projected_start_date"])){
        $projected_start_date = $_POST["projected_start_date"];
    }
    $projected_to_date = 'NULL';
    if(!empty($_POST["projected_to_date"])){
        $projected_to_date = $_POST["projected_to_date"];
    }
    $estimated_foreign_start_date = 'NULL';
    if(!empty($_POST["estimated_foreign_start_date"])){
        $estimated_foreign_start_date = $_POST["estimated_foreign_start_date"];
    }
    $estimated_foreign_to_date = 'NULL';
    if(!empty($_POST["estimated_foreign_to_date"])){
        $estimated_foreign_to_date = $_POST["estimated_foreign_to_date"];
    }
    $projected_foreign_start_date = 'NULL';
    if(!empty($_POST["projected_foreign_start_date"])){
        $projected_foreign_start_date = $_POST["projected_foreign_start_date"];
    }
    $projected_foreign_to_date = 'NULL';
    if(!empty($_POST["projected_foreign_to_date"])){
        $projected_foreign_to_date = $_POST["projected_foreign_to_date"];
    }
    
    // for tbl us gross header
    if(!empty($enter_id)){
        	$sql = "UPDATE tblEnterpise_sales set estimated_start_date='$estimated_start_date',estimated_to_date='$estimated_to_date',projected_start_date='$projected_start_date',projected_to_date='$projected_to_date',estimated_foreign_start_date='$estimated_foreign_start_date',estimated_foreign_to_date='$estimated_foreign_to_date',projected_foreign_start_date='$projected_foreign_start_date',projected_foreign_to_date='$projected_foreign_to_date',sales_added_by='$cookie' where sales_enterprise_id = $user_id";
            if(mysqli_query($conn, $sql)){
                $user_id;
            }
    }
    else{
        $sql = "INSERT INTO tblEnterpise_sales(estimated_start_date,estimated_to_date,projected_start_date,projected_to_date,estimated_foreign_start_date,estimated_foreign_to_date,projected_foreign_start_date,projected_foreign_to_date,sales_enterprise_id,sales_added_by) 
        VALUES($estimated_start_date,$estimated_to_date,$projected_start_date,$projected_to_date,$estimated_foreign_start_date,$estimated_foreign_to_date,$projected_foreign_start_date,$projected_foreign_to_date,'$user_id','$cookie')";
        if(mysqli_query($conn, $sql)){
           $last_id = mysqli_insert_id($conn);
        }
    }
    
    // for us gross table
    $us_item = implode(' | ', $_POST["us_item"]);
    $us_item = explode(' | ', $us_item);
    foreach($us_item as $con){$con;}
    $con;
    if(!empty($con))
    {
        $i = 0;
       foreach($us_item as $val)
        {
            $us_estimated_gross = $_POST["us_estimated_gross"][$i];
            $us_projected_gross = $_POST["us_projected_gross"][$i];
            
            $sql_us_gross = "INSERT INTO tblEnterpise_sales_us_gross(us_item,us_estimated_gross,us_projected_gross,us_addedby,us_enterprise_id) 
            VALUES('".mysqli_real_escape_string($conn, $val)."','$us_estimated_gross','$us_projected_gross','$cookie','$user_id')";
            if(mysqli_query($conn, $sql_us_gross)){
                $last_id = mysqli_insert_id($conn);
             }
            $i++;
        }
    }
    
    // for foreign gross table
    $foreign_item = implode(' | ', $_POST["foreign_item"]);
    $foreign_item = explode(' | ', $foreign_item);
    foreach($foreign_item as $ccon){ $ccon;}
    $ccon;
    if(!empty($ccon))
    {
        $z = 0;
       foreach($foreign_item as $val)
        {
            $foreign_estimated_gross = $_POST["foreign_estimated_gross"][$z];
            $foreign_projected_gross = $_POST["foreign_projected_gross"][$z];
            
            $sql_us_gross = "INSERT INTO tblEnterpise_sales_foreign_gross(foreign_item,foreign_estimated_gross,foreign_projected_gross,foreign_addedby,foreign_enterprise_id) 
            VALUES('".mysqli_real_escape_string($conn, $val)."','$foreign_estimated_gross','$foreign_projected_gross','$cookie','$user_id')";
            if(mysqli_query($conn, $sql_us_gross)){
                $last_id = mysqli_insert_id($conn);
             }
            $z++;
        }
    }
    
    // for split by country table
    $sbc_country_name = implode(' | ', $_POST["sbc_country_name"]);
    $sbc_country_name = explode(' | ', $sbc_country_name);
    foreach($sbc_country_name as $sbc){ $sbc;}
    $sbc;
    if(!empty($sbc))
    {
        $z = 0;
       foreach($sbc_country_name as $val)
        {
            $sbc_gross_1 = $_POST["sbc_gross_1"][$z];
            $sbc_gross_2 = $_POST["sbc_gross_2"][$z];
            
            $sql_us_gross = "INSERT INTO tblEnterpise_sales_sbc(sbc_country_name,sbc_gross_1,sbc_gross_2,sbc_addedby,sbc_enterprise_id) 
            VALUES('".mysqli_real_escape_string($conn, $val)."','$sbc_gross_1','$sbc_gross_2','$cookie','$user_id')";
            if(mysqli_query($conn, $sql_us_gross)){
                $last_id = mysqli_insert_id($conn);
             }
            $z++;
        }
    }
    
    $query = mysqli_query($conn, "select * from tblEnterpise_sales where sales_enterprise_id = $user_id");
    if(mysqli_fetch_row($query)){
        foreach($query as $row_sales){
            $estimated_start_date ='';
            if($row_sales['estimated_start_date'] != 'NULL' and $row_sales['estimated_start_date'] != ''){$estimated_start_date = date('Y-m-d', strtotime($row_sales['estimated_start_date']));}
            $estimated_to_date = '';
            if($row_sales['estimated_to_date'] != 'NULL' and $row_sales['estimated_to_date'] != ''){$estimated_to_date = date('Y-m-d', strtotime($row_sales['estimated_to_date']));}
            $projected_start_date = '';
            if($row_sales['projected_start_date'] != 'NULL' and $row_sales['projected_start_date'] != ''){$projected_start_date = date('Y-m-d', strtotime($row_sales['projected_start_date']));}
            $projected_to_date = '';
            if($row_sales['projected_to_date']!= 'NULL' and $row_sales['projected_to_date'] != ''){ $projected_to_date = date('Y-m-d', strtotime($row_sales['projected_to_date']));}
           $estimated_foreign_start_date = '';
            if($row_sales['estimated_foreign_start_date']!= 'NULL' and $row_sales['estimated_foreign_start_date'] != ''){$estimated_foreign_start_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_start_date']));}
            $estimated_foreign_to_date = '';
            if($row_sales['estimated_foreign_to_date'] != 'NULL' and $row_sales['estimated_foreign_to_date'] != ''){$estimated_foreign_to_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_to_date']));}
            $projected_foreign_start_date = '';
            if($row_sales['projected_foreign_start_date'] != 'NULL' and $row_sales['projected_foreign_start_date'] != ''){$projected_foreign_start_date = date('Y-m-d', strtotime($row_sales['projected_foreign_start_date']));}
            $projected_foreign_to_date = '';
            if($row_sales['projected_foreign_to_date'] != 'NULL' and $row_sales['projected_foreign_to_date'] != ''){$projected_foreign_to_date = date('Y-m-d', strtotime($row_sales['projected_foreign_to_date']));}
           
           ?>
             
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>
                            <input type="hidden" name="enter_id" value="<?= $row_sales['sales_enterprise_id']; ?>">
                            Total US Gross Sales Item
                            </th>
                          <th width="350px">
                              Estimated <input style="font-size:12px;" type="date" name="estimated_start_date" class=" no-border" value="<?= $estimated_start_date; ?>"> 
                              to <input style="font-size:12px;" type="date" name="estimated_to_date"  class="no-border" value="<?= $estimated_to_date; ?>"></th>
                              
                                <th width="350px">Projected <input style="font-size:12px;" name="projected_start_date" type="date" class=" no-border" value="<?= $projected_start_date; ?>"> 
                                to <input style="font-size:12px;" type="date" name="projected_to_date" class=" no-border" value="<?= $projected_to_date; ?>">
                            </th>
                          <th></th>
                      </tr>
                </thead>
                  <tbody id="data_sales">
                      <?php 
                        $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_us_gross where us_enterprise_id = $user_id");
                        foreach($us_gross as $row_gross){?>
                            <tr id="us_row<?= $row_gross['us_gross_id']; ?>">
                                <td><?= $row_gross['us_item']; ?></td>
                                  <td>$<?= $row_gross['us_estimated_gross']; ?></td>
                                  <td>$<?= $row_gross['us_projected_gross']; ?></td>
                                  <td>
                                    <div class="btn-group btn-group-circle">
                                        <a  href="#modal_update_us_sales" data-toggle="modal" type="button" id="update_us_sales" data-id="<?= $row_gross['us_gross_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                	                    <a href="#modal_delete_us_sales" data-toggle="modal" type="button" id="delete_us_sales" data-id="<?= $row_gross['us_gross_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                    </div>
                                  </td>
                            </tr>
                       <?php }
                      ?>
                  </tbody>
                  <tbody id="dynamic_field_us">
                      <tr>
                          <td><input class="form-control no-border" name="us_item[]" placeholder="Item"></td>
                          <td><input type="number" class="form-control no-border" name="us_estimated_gross[]" placeholder="$0.00"></td>
                          <td><input type="number" class="form-control no-border" name="us_projected_gross[]" placeholder="$0.00"></td>
                          <td><button type="button" name="add_us_row" id="add_us_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <th>Total Foreign Gross Sales</th>
                          <th width="350px">
                              Estimated <input style="font-size:12px;" type="date" name="estimated_foreign_start_date" class=" no-border" value="<?= $estimated_foreign_start_date; ?>"> 
                              to <input style="font-size:12px;" type="date" name="estimated_foreign_to_date"  class="no-border" value="<?= $estimated_foreign_to_date; ?>"></th>
                              
                                <th width="350px">Projected <input style="font-size:12px;" name="projected_foreign_start_date" type="date" class=" no-border" value="<?= $projected_foreign_start_date; ?>"> 
                                to <input style="font-size:12px;" type="date" name="projected_foreign_to_date" class=" no-border" value="<?= $projected_foreign_to_date; ?>">
                            </th>
                          <th></th>
                      </tr>
                  </tbody>
                    <tbody id="data_sales">
                         <?php 
                        $foreign_gross = mysqli_query($conn, "select * from tblEnterpise_sales_foreign_gross where foreign_enterprise_id = $user_id");
                        foreach($foreign_gross as $row_gross){?>
                            <tr id="foreign_row<?= $row_gross['foreign_gross_id']; ?>">
                                <td><?= $row_gross['foreign_item']; ?></td>
                                  <td>$<?= $row_gross['foreign_estimated_gross']; ?></td>
                                  <td>$<?= $row_gross['foreign_projected_gross']; ?></td>
                                  <td>
                                    <div class="btn-group btn-group-circle">
                                        <a  href="#modal_update_foreign_sales" data-toggle="modal" type="button" id="update_foreign_sales" data-id="<?= $row_gross['foreign_gross_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                	                    <a href="#modal_delete_foreign_sales" data-toggle="modal" type="button" id="delete_foreign_sales" data-id="<?= $row_gross['foreign_gross_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                    </div>
                                  </td>
                            </tr>
                       <?php }
                      ?>
                    </tbody>
                  <tbody id="dynamic_field_foreign">
                      <tr>
                          <td><input class="form-control no-border" name="foreign_item[]" placeholder="Item"></td>
                          <td><input class="form-control no-border"  name="foreign_estimated_gross[]" placeholder="$0.00"></td>
                          <td><input class="form-control no-border" placeholder="$0.00" name="foreign_projected_gross[]"></td>
                          <td><button type="button" name="add_foreign_row" id="add_foreign_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                      </tr>
                  </tbody>
              </table>
              <table class="table table-bordered minus-top">
                  <thead>
                      <tr>
                          <th></th>
                          <th><center>Split By Country</center></th>
                          <th></th>
                          <th></th>
                      </tr>
                  </thead>
                  <?php
                      $sbc_query = mysqli_query($conn, "select * from tblEnterpise_sales_sbc where sbc_enterprise_id = $user_id");
                            foreach($sbc_query as $row_sbc){?>
                                <tr id="sbc_row<?= $row_sbc['sbc_id']; ?>">
                                    <td><?=$row_sbc['sbc_country_name']; ?></td>
                                      <td>$<?= $row_sbc['sbc_gross_1']; ?></td>
                                      <td>$<?= $row_sbc['sbc_gross_2']; ?></td>
                                      <td>
                                        <div class="btn-group btn-group-circle">
                                            <a  href="#modal_update_sbc_sales" data-toggle="modal" type="button" id="update_sbc_sales" data-id="<?= $row_sbc['sbc_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                    	                    <a href="#modal_delete_sbc_sales" data-toggle="modal" type="button" id="delete_sbc_sales" data-id="<?= $row_sbc['sbc_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                        </div>
                                      </td>
                                </tr>
                            <?php }
                  ?>
                  <tbody>
                      <tr>
                          <td><input class="form-control no-border" name="sbc_country_name[]" placeholder="Country Name"></td>
                            <td><input class="form-control no-border" name="sbc_gross_1[]" placeholder="$0.00"></td>
                            <td><input class="form-control no-border" name="sbc_gross_2[]" placeholder="$0.00"></td>
                            <td>
                               <button type="button" name="add_sbc_row" id="add_sbc_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                            </td>
                      </tr>
                  </tbody>
              </table>
       <?php }
    }
	mysqli_close($conn);
}


//update us sales
if( isset($_GET['get_us_sales_id']) ) {
	$ID = $_GET['get_us_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_us_gross where us_gross_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Item</label>
                        <input class="form-control" name="us_item" value="<?= $row['us_item']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Estimated Gross</label>
                        <textarea class="form-control" name="us_estimated_gross" ><?= $row['us_estimated_gross']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Projected Gross</label>
                        <input class="form-control" name="us_projected_gross" value="<?= $row['us_projected_gross']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_us_sales']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $us_item = mysqli_real_escape_string($conn,$_POST['us_item']);
    $us_estimated_gross = mysqli_real_escape_string($conn,$_POST['us_estimated_gross']);
    $us_projected_gross = mysqli_real_escape_string($conn,$_POST['us_projected_gross']);
   
	$sql = "UPDATE tblEnterpise_sales_us_gross set us_item='$us_item',us_estimated_gross='$us_estimated_gross',us_projected_gross='$us_projected_gross' where us_gross_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_sales_us_gross where us_gross_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row['us_item']; ?></td>
                <td>$<?= $row['us_estimated_gross']; ?></td>
                <td>$<?= $row['us_projected_gross']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_us_sales" data-toggle="modal" type="button" id="update_us_sales" data-id="<?= $row['us_gross_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_us_sales" data-toggle="modal" type="button" id="delete_us_sales" data-id="<?= $row['us_gross_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete us sales
if( isset($_GET['delete_us_sales_id']) ) {
	$ID = $_GET['delete_us_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_us_gross where us_gross_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Item: </b></label>
                        <i><?= $row['us_item']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Estimated Gross: </b></label>
                        <i$><?= $row['us_estimated_gross']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Projected Gross: </b></label>
                        <i>$<?= $row['us_projected_gross']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_us_sales']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_sales_us_gross  where us_gross_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

//update foreign sales
if( isset($_GET['get_foreign_sales_id']) ) {
	$ID = $_GET['get_foreign_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_foreign_gross where foreign_gross_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Item</label>
                        <input class="form-control" name="foreign_item" value="<?= $row['foreign_item']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Estimated Gross</label>
                        <textarea class="form-control" name="foreign_estimated_gross" ><?= $row['foreign_estimated_gross']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Projected Gross</label>
                        <input class="form-control" name="foreign_projected_gross" value="<?= $row['foreign_projected_gross']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_foreign_sales']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $foreign_item = mysqli_real_escape_string($conn,$_POST['foreign_item']);
    $foreign_estimated_gross = mysqli_real_escape_string($conn,$_POST['foreign_estimated_gross']);
    $foreign_projected_gross = mysqli_real_escape_string($conn,$_POST['foreign_projected_gross']);
   
	$sql = "UPDATE tblEnterpise_sales_foreign_gross set foreign_item='$foreign_item',foreign_estimated_gross='$foreign_estimated_gross',foreign_projected_gross='$foreign_projected_gross' where foreign_gross_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_sales_foreign_gross where foreign_gross_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row['foreign_item']; ?></td>
                <td>$<?= $row['foreign_estimated_gross']; ?></td>
                <td>$<?= $row['foreign_projected_gross']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_foreign_sales" data-toggle="modal" type="button" id="update_foreign_sales" data-id="<?= $row['foreign_gross_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_foreign_sales" data-toggle="modal" type="button" id="delete_foreign_sales" data-id="<?= $row['foreign_gross_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete foreign sales
if( isset($_GET['delete_foreign_sales_id']) ) {
	$ID = $_GET['delete_foreign_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_foreign_gross where foreign_gross_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Item: </b></label>
                        <i><?= $row['foreign_item']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Estimated Gross: </b></label>
                        <i$><?= $row['foreign_estimated_gross']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Projected Gross: </b></label>
                        <i>$<?= $row['foreign_projected_gross']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_foreign_sales']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_sales_foreign_gross  where foreign_gross_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

//update sbc sales
if( isset($_GET['get_sbc_sales_id']) ) {
	$ID = $_GET['get_sbc_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_sbc where sbc_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Item</label>
                        <input class="form-control" name="sbc_country_name" value="<?= $row['sbc_country_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Estimated Gross</label>
                        <textarea class="form-control" name="sbc_gross_1" ><?= $row['sbc_gross_1']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Projected Gross</label>
                        <input class="form-control" name="sbc_gross_2" value="<?= $row['sbc_gross_2']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_sbc_sales']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $sbc_country_name = mysqli_real_escape_string($conn,$_POST['sbc_country_name']);
    $sbc_gross_1 = mysqli_real_escape_string($conn,$_POST['sbc_gross_1']);
    $sbc_gross_2 = mysqli_real_escape_string($conn,$_POST['sbc_gross_2']);
   
	$sql = "UPDATE tblEnterpise_sales_sbc set sbc_country_name='$sbc_country_name',sbc_gross_1='$sbc_gross_1',sbc_gross_2='$sbc_gross_2' where sbc_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_sales_sbc where sbc_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row['sbc_country_name']; ?></td>
                <td>$<?= $row['sbc_gross_1']; ?></td>
                <td>$<?= $row['sbc_gross_2']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_sbc_sales" data-toggle="modal" type="button" id="update_sbc_sales" data-id="<?= $row['sbc_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_sbc_sales" data-toggle="modal" type="button" id="delete_sbc_sales" data-id="<?= $row['sbc_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete sbc sales
if( isset($_GET['delete_sbc_sales_id']) ) {
	$ID = $_GET['delete_sbc_sales_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_sales_sbc where sbc_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Country Name: </b></label>
                        <i><?= $row['sbc_country_name']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Estimated Gross: </b></label>
                        <i$><?= $row['sbc_gross_1']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Projected Gross: </b></label>
                        <i>$<?= $row['sbc_gross_2']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_sbc_sales']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_sales_sbc  where sbc_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_annual
if( isset($_POST['btnAdd_annual']) ) {
  
    $cookie = $_COOKIE['ID'];
    $ar_year = implode(' | ', $_POST["ar_year"]);
    $ar_year = explode(' | ', $ar_year);
   
    $i = 0;
   foreach($ar_year as $val)
    {
        $ar_total= $_POST["ar_total"][$i];
        
        $sql = "INSERT INTO tblEnterpise_AR(ar_year,ar_total,ar_addedby,ar_user_entities) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$ar_total','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_AR where ar_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_ar_<?=$row['ar_id']; ?>">
                    <td><?=$row['ar_year']; ?></td>
                    <td>$<?= $row['ar_total']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_annual" data-toggle="modal" type="button" id="update_annual" data-id="<?= $row['ar_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_annual" data-toggle="modal" type="button" id="delete_annual" data-id="<?= $row['ar_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

//update annual revenue
if( isset($_GET['get_annual_id']) ) {
	$ID = $_GET['get_annual_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_AR where ar_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Year</label>
                        <input class="form-control" name="ar_year" value="<?= $row['ar_year']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Total</label>
                        <input class="form-control" name="ar_total" value="<?= $row['ar_total']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_annual']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $ar_year = mysqli_real_escape_string($conn,$_POST['ar_year']);
    $ar_total = mysqli_real_escape_string($conn,$_POST['ar_total']);
   
	$sql = "UPDATE tblEnterpise_AR set ar_year='$ar_year',ar_total='$ar_total',ar_addedby='$cookie' where ar_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_AR where ar_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['ar_year']; ?></td>
                <td>$<?= $row['ar_total']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_annual" data-toggle="modal" type="button" id="update_annual" data-id="<?= $row['ar_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_annual" data-toggle="modal" type="button" id="delete_annual" data-id="<?= $row['ar_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete annual revenue
if( isset($_GET['delete_annual_id']) ) {
	$ID = $_GET['delete_annual_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_AR where ar_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Year: </b></label>
                        <i><?= $row['ar_year']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Total: </b></label>
                        <i>$<?= $row['ar_total']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_annual']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_AR  where ar_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_payroll
if( isset($_POST['btnAdd_payroll']) ) {
  
    $cookie = $_COOKIE['ID'];
    $payroll_state = implode(' | ', $_POST["payroll_state"]);
    $payroll_state = explode(' | ', $payroll_state);
   
    if(!empty($payroll_state))
    {
        $i = 0;
       foreach($payroll_state as $val)
        {
            $payroll_code = mysqli_real_escape_string($conn, $_POST["payroll_code"][$i]);
            $payroll_classification = mysqli_real_escape_string($conn, $_POST["payroll_classification"][$i]);
            $payroll_estimated = mysqli_real_escape_string($conn, $_POST["payroll_estimated"][$i]);
            $payroll_projected = mysqli_real_escape_string($conn, $_POST["payroll_projected"][$i]);
            $payroll_full_time = mysqli_real_escape_string($conn, $_POST["payroll_full_time"][$i]);
            $payroll_part_time = mysqli_real_escape_string($conn, $_POST["payroll_part_time"][$i]);
            
            $sql = "INSERT INTO tblEnterpise_payroll(payroll_state,payroll_code,payroll_classification,payroll_estimated,payroll_projected,payroll_full_time,payroll_part_time,payroll_addedby,payroll_enterprise_entities) 
            VALUES('".mysqli_real_escape_string($conn, $val)."','$payroll_code','$payroll_classification','$payroll_estimated','$payroll_projected','$payroll_full_time','$payroll_part_time','$cookie','$user_id')";
            if(mysqli_query($conn, $sql)){
                $last_id = mysqli_insert_id($conn);
                
            }
            $i++;
        }
    }
    
    
    $payroll_estimated_from = mysqli_real_escape_string($conn,$_POST['payroll_estimated_from']);
    $payroll_estimated_to = mysqli_real_escape_string($conn,$_POST['payroll_estimated_to']);
    $payroll_projected_from = mysqli_real_escape_string($conn,$_POST['payroll_projected_from']);
    $payroll_projected_to = mysqli_real_escape_string($conn,$_POST['payroll_projected_to']);
     $annual_premium = mysqli_real_escape_string($conn,$_POST['annual_premium']);
    
    $query = mysqli_query($conn, "select * from tblEnterpise_payroll_header where payroll_h_enterprise_id = '$user_id'");
    if(mysqli_fetch_row($query)){
        foreach($query as $row_payroll){
            $sql = "UPDATE tblEnterpise_payroll_header set payroll_estimated_from='$payroll_estimated_from',payroll_estimated_to='$payroll_estimated_to',payroll_projected_from='$payroll_projected_from',payroll_projected_to='$payroll_projected_to',annual_premium='$annual_premium',payroll_h_addedby='$cookie' where payroll_h_enterprise_id = $user_id";
            if(mysqli_query($conn, $sql)){ 
                 $cookie = $_COOKIE['ID'];
            }
        }
    }else{
        $sql = "INSERT INTO tblEnterpise_payroll_header(payroll_estimated_from,payroll_estimated_to,payroll_projected_from,payroll_projected_to,annual_premium,payroll_h_addedby,payroll_h_enterprise_id) 
            VALUES('$payroll_estimated_from','$payroll_estimated_to','$payroll_projected_from','$payroll_projected_to','$annual_premium','$cookie','$user_id')";
            if(mysqli_query($conn, $sql)){
                $last_id = mysqli_insert_id($conn);
                
            }
    }
    
    
    ?>
     <div class="table-scrollable">
        <table class="table table-bordered">
            <thead>
                <?php 
                        $query = mysqli_query($conn, "select * from tblEnterpise_payroll_header where payroll_h_enterprise_id = '$user_id'");
                        if(mysqli_fetch_row($query)){
                        foreach($query as $row_payroll){?>
                            <tr>
                                <th>State</th>
                                <th>Code</th>
                                <th>Classification</th>
                                <th width="350px">Estimated <input style="font-size:12px;" type="date" name="payroll_estimated_from" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_estimated_from'])); ?>"> 
                                To <input style="font-size:12px;" type="date" name="payroll_estimated_to" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_estimated_to'])); ?>"></th>
                                <th width="350px">Projected <input style="font-size:12px;" type="date" name="payroll_projected_from" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_projected_from'])); ?>"> 
                                To <input style="font-size:12px;" type="date" name="payroll_projected_to" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_projected_to'])); ?>"></th>
                                <th>Full Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th>Part Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th></th>
                            </tr>
                        <?php }
                        }else {?> 
                            <tr>
                                <th>State</th>
                                <th>Code</th>
                                <th>Classification</th>
                                <th width="350px">Estimated <input style="font-size:12px;" type="date" name="payroll_estimated_from" class=" no-border" required> 
                                To <input style="font-size:12px;" type="date" name="payroll_estimated_to" class=" no-border" required></th>
                                <th width="350px">Projected <input style="font-size:12px;" type="date" name="payroll_projected_from" class=" no-border" required> 
                                To <input style="font-size:12px;" type="date" name="payroll_projected_to" class=" no-border" required></th>
                                <th>Full Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th>Part Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th></th>
                            </tr>
                        <?php }
                    ?>
            </thead>
            <tbody id="data_payroll">
                <?php 
                    $data_query = mysqli_query($conn, "select * from tblEnterpise_payroll where payroll_enterprise_entities = '$user_id'");
                    foreach($data_query as $row_payroll){?>
                        <tr id="payroll_row<?= $row_payroll['payroll_id']; ?>">
                            <td><?= $row_payroll['payroll_state']; ?></td>
                            <td><?= $row_payroll['payroll_code']; ?></td>
                            <td><?= $row_payroll['payroll_classification']; ?></td>
                            <td><?= $row_payroll['payroll_estimated']; ?></td>
                            <td><?= $row_payroll['payroll_projected']; ?></td>
                            <td><?= $row_payroll['payroll_full_time']; ?></td>
                            <td><?= $row_payroll['payroll_part_time']; ?></td>
                            <td width="200px">
                                <div class="btn-group btn-group-circle">
                                    <a  href="#modal_update_payroll" data-toggle="modal" type="button" id="update_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
            	                    <a href="#modal_delete_payroll" data-toggle="modal" type="button" id="delete_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php }
                ?>
            </tbody>
            <tbody id="dynamic_field_payroll">
                <tr>
                    <td><input class="form-control no-border" name="payroll_state[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_code[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_classification[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_estimated[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_projected[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_full_time[]" placeholder=""></td>
                    <td><input class="form-control no-border" name="payroll_part_time[]" placeholder=""></td>
                    <td><button type="button" name="add_payroll_row" id="add_payroll_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br><br>
    <div class="form-group">
        <div class="col-md-6">
            <div class="col-md-4">
                <label class="form-control no-border">Annual WC Premiums: </label>
            </div>
            <div class="col-md-8">
                <?php 
                        $query_premium = mysqli_query($conn, "select * from tblEnterpise_payroll_header where payroll_h_enterprise_id = '$user_id'");
                        if(mysqli_fetch_row($query_premium)){
                        foreach($query_premium as $row){?>
                            <input class="form-control bottom-border" placeholder="$" name="annual_premium" value="<?= $row['annual_premium']; ?>">
                        <?php }
                        }else {?> 
                            <input class="form-control bottom-border" placeholder="$" name="annual_premium">
                        <?php }
                    ?>
            </div>
        </div>
        <div class="col-md-6">
            <input class="btn green float-right" type="submit" name="btnAdd_payroll" id="btnAdd_payroll" value="Save" >
        </div>
    </div>
    <?php
    
}

//update payroll
if( isset($_GET['get_payroll_id']) ) {
	$ID = $_GET['get_payroll_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_payroll where payroll_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">State</label>
                        <input class="form-control" name="payroll_state" value="<?= $row['payroll_state']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Code</label>
                        <input class="form-control" name="payroll_code" value="<?= $row['payroll_code']; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Classification</label>
                        <input class="form-control" name="payroll_classification" value="<?= $row['payroll_classification']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label">Estimated</label>
                        <input class="form-control" name="payroll_estimated" value="<?= $row['payroll_estimated']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Projected</label>
                        <input class="form-control" name="payroll_projected" value="<?= $row['payroll_projected']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label">Full Time</label>
                        <input class="form-control" name="payroll_full_time" value="<?= $row['payroll_full_time']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Part Time</label>
                        <input class="form-control" name="payroll_part_time" value="<?= $row['payroll_part_time']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_payroll']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $payroll_state = mysqli_real_escape_string($conn,$_POST['payroll_state']);
    $payroll_code = mysqli_real_escape_string($conn,$_POST['payroll_code']);
    
    $payroll_classification = mysqli_real_escape_string($conn,$_POST['payroll_classification']);
    $payroll_estimated = mysqli_real_escape_string($conn,$_POST['payroll_estimated']);
    $payroll_projected = mysqli_real_escape_string($conn,$_POST['payroll_projected']);
    $payroll_full_time = mysqli_real_escape_string($conn,$_POST['payroll_full_time']);
    $payroll_part_time = mysqli_real_escape_string($conn,$_POST['payroll_part_time']);
    
   
	$sql = "UPDATE tblEnterpise_payroll set payroll_state='$payroll_state',payroll_code='$payroll_code',payroll_classification='$payroll_classification',payroll_estimated='$payroll_estimated',payroll_projected='$payroll_projected',payroll_full_time='$payroll_full_time',payroll_part_time='$payroll_part_time',payroll_addedby='$cookie' where payroll_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_payroll where payroll_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row_payroll = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row_payroll['payroll_state']; ?></td>
                <td><?= $row_payroll['payroll_code']; ?></td>
                <td><?= $row_payroll['payroll_classification']; ?></td>
                <td><?= $row_payroll['payroll_estimated']; ?></td>
                <td><?= $row_payroll['payroll_projected']; ?></td>
                <td><?= $row_payroll['payroll_full_time']; ?></td>
                <td><?= $row_payroll['payroll_part_time']; ?></td>
                <td width="200px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_payroll" data-toggle="modal" type="button" id="update_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_payroll" data-toggle="modal" type="button" id="delete_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete payroll
if( isset($_GET['delete_payroll_id']) ) {
	$ID = $_GET['delete_payroll_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_payroll where payroll_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>State: </b></label>
                        <i><?= $row['payroll_state']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Code: </b></label>
                        <i><?= $row['payroll_code']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Classification: </b></label>
                        <i><?= $row['payroll_classification']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Estimated: </b></label>
                        <i><?= $row['payroll_estimated']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Projected: </b></label>
                        <i><?= $row['payroll_projected']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Full Time: </b></label>
                        <i><?= $row['payroll_full_time']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Part Time: </b></label>
                        <i><?= $row['payroll_part_time']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_payroll']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_payroll  where payroll_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_annual
if( isset($_POST['btnAdd_no_emp']) ) {
  
    $cookie = $_COOKIE['ID'];
    $emp_total = implode(' | ', $_POST["emp_total"]);
    $emp_total = explode(' | ', $emp_total);
   
    $i = 0;
   foreach($emp_total as $val)
    {
        $emp_usa_canada = mysqli_real_escape_string($conn,$_POST["emp_usa_canada"][$i]);
        $emp_european_union = mysqli_real_escape_string($conn,$_POST["emp_european_union"][$i]);
        $emp_rest_of_world = mysqli_real_escape_string($conn,$_POST["emp_rest_of_world"][$i]);
        
        $sql = "INSERT INTO tblEnterpise_no_employee(emp_total,emp_usa_canada,emp_european_union,emp_rest_of_world,emp_addedby,emp_enterprise_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$emp_usa_canada','$emp_european_union','$emp_rest_of_world','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_no_employee where no_emp_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_no_emp<?=$row['no_emp_id']; ?>">
                    <td><?=$row['emp_total']; ?></td>
                    <td><?= $row['emp_usa_canada']; ?></td>
                    <td><?= $row['emp_european_union']; ?></td>
                    <td><?= $row['emp_rest_of_world']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_no_emp" data-toggle="modal" type="button" id="update_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_no_emp" data-toggle="modal" type="button" id="delete_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

//update no employee
if( isset($_GET['get_emp_id']) ) {
	$ID = $_GET['get_emp_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_no_employee where no_emp_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Total</label>
                        <input class="form-control" name="emp_total" value="<?= $row['emp_total']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">USA/Canada</label>
                        <input class="form-control" name="emp_usa_canada" value="<?= $row['emp_usa_canada']; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">European Union</label>
                        <input class="form-control" name="emp_european_union" value="<?= $row['emp_european_union']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Rest of World</label>
                        <input class="form-control" name="emp_rest_of_world" value="<?= $row['emp_rest_of_world']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_emp']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $emp_total = mysqli_real_escape_string($conn,$_POST['emp_total']);
    $emp_usa_canada = mysqli_real_escape_string($conn,$_POST['emp_usa_canada']);
    
    $payroll_classification = mysqli_real_escape_string($conn,$_POST['payroll_classification']);
    $emp_european_union = mysqli_real_escape_string($conn,$_POST['emp_european_union']);
    $emp_rest_of_world = mysqli_real_escape_string($conn,$_POST['emp_rest_of_world']);
    
   
	$sql = "UPDATE tblEnterpise_no_employee set emp_total='$emp_total',emp_usa_canada='$emp_usa_canada',emp_european_union='$emp_european_union',emp_rest_of_world='$emp_rest_of_world',emp_addedby='$cookie' where no_emp_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_no_employee where no_emp_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['emp_total']; ?></td>
                <td><?= $row['emp_usa_canada']; ?></td>
                <td><?= $row['emp_european_union']; ?></td>
                <td><?= $row['emp_rest_of_world']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_no_emp" data-toggle="modal" type="button" id="update_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_no_emp" data-toggle="modal" type="button" id="delete_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete no employee
if( isset($_GET['delete_emp_id']) ) {
	$ID = $_GET['delete_emp_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_no_employee where no_emp_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Total: </b></label>
                        <i><?= $row['emp_total']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>USA/Canada: </b></label>
                        <i><?= $row['emp_usa_canada']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>European Union: </b></label>
                        <i><?= $row['emp_european_union']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Rest of World: </b></label>
                        <i><?= $row['emp_rest_of_world']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_emp']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_no_employee  where no_emp_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_coverage
if( isset($_POST['btnAdd_coverage']) ) {
  
    $cookie = $_COOKIE['ID'];
    $options = implode(' | ', $_POST["options"]);
    $options = explode(' | ', $options);
   
    $i = 0;
   foreach($options as $val)
    {
        $limits = mysqli_real_escape_string($conn,$_POST["limits"][$i]);
        $retention = mysqli_real_escape_string($conn,$_POST["retention"][$i]);
        $emp_rest_of_world = mysqli_real_escape_string($conn,$_POST["emp_rest_of_world"][$i]);
        
        $sql = "INSERT INTO tblEnterpise_coverage(options,limits,retention,coverage_addedby,coverage_enterprise_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$limits','$retention','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_coverage where coverage_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_coverage<?=$row['coverage_id']; ?>">
                    <td><?=$row['options']; ?></td>
                    <td><?= $row['limits']; ?></td>
                    <td><?= $row['retention']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_coverage" data-toggle="modal" type="button" id="update_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_coverage" data-toggle="modal" type="button" id="delete_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

//update no employee
if( isset($_GET['get_coverage_id']) ) {
	$ID = $_GET['get_coverage_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_coverage where coverage_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Options</label>
                        <input class="form-control" name="options" value="<?= $row['options']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Limit</label>
                        <input class="form-control" name="limits" value="<?= $row['limits']; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Retention</label>
                        <input class="form-control" name="retention" value="<?= $row['retention']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_coverage']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $options = mysqli_real_escape_string($conn,$_POST['options']);
    $limits = mysqli_real_escape_string($conn,$_POST['limits']);
    $retention = mysqli_real_escape_string($conn,$_POST['retention']);
    
   
	$sql = "UPDATE tblEnterpise_coverage set options='$options',limits='$limits',retention='$retention',coverage_addedby='$cookie' where coverage_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_coverage where coverage_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['options']; ?></td>
                <td><?= $row['limits']; ?></td>
                <td><?= $row['retention']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_coverage" data-toggle="modal" type="button" id="update_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_coverage" data-toggle="modal" type="button" id="delete_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete no employee
if( isset($_GET['delete_coverage_id']) ) {
	$ID = $_GET['delete_coverage_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_coverage where coverage_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Options: </b></label>
                        <i><?= $row['options']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Limit: </b></label>
                        <i><?= $row['limits']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Retention: </b></label>
                        <i><?= $row['retention']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_coverage']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_coverage  where coverage_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

if( isset($_POST['btnAdd_business_process']) ) {
   $bPROCESS = '';
    
     if(!empty($_POST["BusinessPROCESS"]))
     {
        foreach($_POST["BusinessPROCESS"] as $businessPROCESS)
        {
            $bPROCESS .= $businessPROCESS . ', ';
        }
            
    }
    $bPROCESS = substr($bPROCESS, 0, -2);
    mysqli_query($conn,"update tblEnterpiseDetails set BusinessPROCESS ='$bPROCESS' where users_entities='$user_id'");  
    $query = mysqli_query($conn, "select * from tblEnterpiseDetails where users_entities = $user_id");
    foreach($query as $row){
    $array_busi = explode(", ", $row["BusinessPROCESS"]); 
    ?>
            <div class="form-group">
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="16" <?php if(in_array('16', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Bottler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="13" <?php if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Brand Owner
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="9" <?php if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Broker
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="7" <?php if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Buyer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="4" <?php if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Manufacturer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="3"  <?php if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Packer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="14" <?php if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Cultivation
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="17" <?php if(in_array('17', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distributor
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distribution
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="18" <?php if(in_array('18', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Importer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="12" <?php if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        IT Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Manufacturing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="19" <?php if(in_array('19', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="10" <?php if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packaging
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="11" <?php if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Professional Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="5" <?php if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Retailer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="6" <?php if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Reseller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="20" <?php if(in_array('20', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Supplier of Ingredients
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="8" <?php if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Seller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="21" <?php if(in_array('21', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Wholesaler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="15" <?php if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Others
                    </label>
                </div>
            </div>
    <?php }
    
}

if( isset($_POST['btnAdd_desc_product']) ) {
    
    $enterpriseProducts = mysqli_real_escape_string($conn,$_POST['enterpriseProducts']);
    $ProductDesc = mysqli_real_escape_string($conn,$_POST['ProductDesc']);
    mysqli_query($conn,"update tblEnterpiseDetails set enterpriseProducts ='$enterpriseProducts',ProductDesc ='$ProductDesc' where users_entities='$user_id'"); 
    $query_product = mysqli_query($conn, "select * from tblEnterpiseDetails WHERE users_entities = $user_id"); 
        foreach($query_product as $row){?>
            <div class="form-group">
                <div class="col-md-4">
                    <label>Does the enterprise offer products?</label>
                </div>
                <div class="col-md-2">
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="Yes" <?php if($row['enterpriseProducts']=='Yes'){echo 'checked';}else{echo '';} ?>> Yes</label>&nbsp;
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="No" <?php if($row['enterpriseProducts']=='No'){echo 'checked';}else{echo '';} ?>> No</label>
                </div>
            </div>
            
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Products <i style="font-size:12px;color:orange;">(If yes)</i></th>
                        <!--<th></th>-->
                    </tr>
                </thead>
                <tbody id="dynamic_dp">
                    <tr>
                        <td><textarea class="form-control no-border" rows="10" name="ProductDesc"><?php echo $row['ProductDesc']; ?></textarea></td>
                        <!--<td>-->
                        <!--    <button type="button" name="add_dp_row" id="add_dp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>-->
                        <!--</td>-->
                    </tr>
                </tbody>
            </table>
        <?php }
}

// btnAdd_plant and facility
if( isset($_POST['btnAdd_plant_facility']) ) {
  
    $cookie = $_COOKIE['ID'];
    $usa_canada = implode(' | ', $_POST["usa_canada"]);
    $usa_canada = explode(' | ', $usa_canada);
   
    $i = 0;
   foreach($usa_canada as $val)
    {
        $eu_union = mysqli_real_escape_string($conn,$_POST["eu_union"][$i]);
        $rest_of_world = mysqli_real_escape_string($conn,$_POST["rest_of_world"][$i]);
        
        $sql = "INSERT INTO tblEnterpiseDetails_no_plant_and_facility(usa_canada,eu_union,rest_of_world,plant_addedby,plant_enterprise_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$eu_union','$rest_of_world','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpiseDetails_no_plant_and_facility where plant_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_plant_facility<?=$row['plant_id']; ?>">
                    <td><?=$row['usa_canada']; ?></td>
                    <td><?= $row['eu_union']; ?></td>
                    <td><?= $row['rest_of_world']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_plant_facility" data-toggle="modal" type="button" id="update_plant_facility" data-id="<?= $row['plant_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_plant_facility" data-toggle="modal" type="button" id="delete_plant_facility" data-id="<?= $row['plant_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

//update plant and facility
if( isset($_GET['get_plant_id']) ) {
	$ID = $_GET['get_plant_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpiseDetails_no_plant_and_facility where plant_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">USA/Canada</label>
                        <input class="form-control" name="usa_canada" value="<?= $row['usa_canada']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">European Union</label>
                        <input class="form-control" name="eu_union" value="<?= $row['eu_union']; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Rest of World</label>
                        <input class="form-control" name="rest_of_world" value="<?= $row['rest_of_world']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_plant_facility']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $usa_canada = mysqli_real_escape_string($conn,$_POST['usa_canada']);
    $eu_union= mysqli_real_escape_string($conn,$_POST['eu_union']);
    $rest_of_world = mysqli_real_escape_string($conn,$_POST['rest_of_world']);
    
   
	$sql = "UPDATE tblEnterpiseDetails_no_plant_and_facility set usa_canada='$usa_canada',eu_union='$eu_union',rest_of_world='$rest_of_world',plant_addedby='$cookie' where plant_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpiseDetails_no_plant_and_facility where plant_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['usa_canada']; ?></td>
                <td><?= $row['eu_union']; ?></td>
                <td><?= $row['rest_of_world']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_plant_facility" data-toggle="modal" type="button" id="update_plant_facility" data-id="<?= $row['plant_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_plant_facility" data-toggle="modal" type="button" id="delete_plant_facility" data-id="<?= $row['plant_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete no employee
if( isset($_GET['delete_plant_id']) ) {
	$ID = $_GET['delete_plant_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpiseDetails_no_plant_and_facility where plant_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>USA/Canada: </b></label>
                        <i><?= $row['usa_canada']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>European Union: </b></label>
                        <i><?= $row['eu_union']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Rest of World: </b></label>
                        <i><?= $row['rest_of_world']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_plant_facility']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpiseDetails_no_plant_and_facility  where plant_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_by_plant
if( isset($_POST['btnAdd_by_plant']) ) {
  
    $cookie = $_COOKIE['ID'];
    $plant_name = implode(' | ', $_POST["plant_name"]);
    $plant_name = explode(' | ', $plant_name);
   
    $i = 0;
   foreach($plant_name as $val)
    {
        $daily_output = mysqli_real_escape_string($conn,$_POST["daily_output"][$i]);
        $daily_revenue = mysqli_real_escape_string($conn,$_POST["daily_revenue"][$i]);
        $no_production_lines = mysqli_real_escape_string($conn,$_POST["no_production_lines"][$i]);
        $no_of_shifts = mysqli_real_escape_string($conn,$_POST["no_of_shifts"][$i]);
        $ptc_of_total_capacity = mysqli_real_escape_string($conn,$_POST["ptc_of_total_capacity"][$i]);
        
        $sql = "INSERT INTO tblEnterpiseDetails_product_by_plant(plant_name,daily_output,daily_revenue,no_production_lines,no_of_shifts,ptc_of_total_capacity,by_plant_addedby,by_plant_enterprise_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$daily_output','$daily_revenue','$no_production_lines','$no_of_shifts','$ptc_of_total_capacity','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpiseDetails_product_by_plant where by_plant_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_by_plant<?=$row['by_plant_id']; ?>">
                    <td><?=$row['plant_name']; ?></td>
                    <td><?= $row['daily_output']; ?></td>
                    <td><?= $row['daily_revenue']; ?></td>
                    <td><?=$row['no_production_lines']; ?></td>
                    <td><?= $row['no_of_shifts']; ?></td>
                    <td><?= $row['ptc_of_total_capacity']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_by_plant" data-toggle="modal" type="button" id="update_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_by_plant" data-toggle="modal" type="button" id="delete_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

//update product by plant
if( isset($_GET['get_by_plant_id']) ) {
	$ID = $_GET['get_by_plant_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpiseDetails_product_by_plant where by_plant_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Plant</label>
                        <input class="form-control" name="plant_name" value="<?= $row['plant_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Daily Output (specify units,pounds,bottles, cases,etc.)</label>
                        <input class="form-control" name="daily_output" value="<?= $row['daily_output']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Daily Revenue</label>
                        <input class="form-control" name="daily_revenue" value="<?= $row['daily_revenue']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">No. of Production Lines</label>
                        <input class="form-control" name="no_production_lines" value="<?= $row['no_production_lines']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">No. of Shifts</label>
                        <input class="form-control" name="no_of_shifts" value="<?= $row['no_of_shifts']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Percentage of Total Capacity</label>
                        <input class="form-control" name="ptc_of_total_capacity" value="<?= $row['ptc_of_total_capacity']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_by_plant']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $plant_name = mysqli_real_escape_string($conn,$_POST['plant_name']);
    $daily_output= mysqli_real_escape_string($conn,$_POST['daily_output']);
    $daily_revenue = mysqli_real_escape_string($conn,$_POST['daily_revenue']);
    $no_production_lines = mysqli_real_escape_string($conn,$_POST['no_production_lines']);
    $no_of_shifts = mysqli_real_escape_string($conn,$_POST['no_of_shifts']);
    $ptc_of_total_capacity = mysqli_real_escape_string($conn,$_POST['ptc_of_total_capacity']);
    
   
	$sql = "UPDATE tblEnterpiseDetails_product_by_plant set plant_name='$plant_name',daily_output='$daily_output',daily_revenue='$daily_revenue',no_production_lines='$no_production_lines',no_of_shifts='$no_of_shifts',ptc_of_total_capacity='$ptc_of_total_capacity',by_plant_addedby='$cookie' where by_plant_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpiseDetails_product_by_plant where by_plant_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['plant_name']; ?></td>
                <td><?= $row['daily_output']; ?></td>
                <td><?= $row['daily_revenue']; ?></td>
                <td><?=$row['no_production_lines']; ?></td>
                <td><?= $row['no_of_shifts']; ?></td>
                <td><?= $row['ptc_of_total_capacity']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_by_plant" data-toggle="modal" type="button" id="update_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_by_plant" data-toggle="modal" type="button" id="delete_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete product by plant
if( isset($_GET['delete_by_plant_id']) ) {
	$ID = $_GET['delete_by_plant_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpiseDetails_product_by_plant where by_plant_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Plant: </b></label>
                        <i><?= $row['plant_name']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Daily Output: </b></label>
                        <i><?= $row['daily_output']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Daily Revenue: </b></label>
                        <i><?= $row['daily_revenue']; ?></i>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="control-label"><b>No. of Production Lines: </b></label>
                        <i><?= $row['no_production_lines']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>No. of Shifts: </b></label>
                        <i><?= $row['no_of_shifts']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Percentage of Total Capacity: </b></label>
                        <i><?= $row['ptc_of_total_capacity']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_by_plant']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpiseDetails_product_by_plant  where by_plant_id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnAdd_specific_coverage
if( isset($_POST['btnAdd_specific_coverage']) ) {
  
    $cookie = $_COOKIE['ID'];
    $product_name = implode(' | ', $_POST["product_name"]);
    $product_name = explode(' | ', $product_name);
   
    $i = 0;
   foreach($product_name as $val)
    {
        $total_sales = mysqli_real_escape_string($conn,$_POST["total_sales"][$i]);
        $average_batch = mysqli_real_escape_string($conn,$_POST["average_batch"][$i]);
        $largest_batch = mysqli_real_escape_string($conn,$_POST["largest_batch"][$i]);
        $daily_output = mysqli_real_escape_string($conn,$_POST["daily_output"][$i]);
        
        $sql = "INSERT INTO tblEnterpiseDetails_product_specific_coverage(product_name,total_sales,average_batch,largest_batch,daily_output,specific_coverage_addedby,specific_coverage_enterprise_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$total_sales','$average_batch','$largest_batch','$daily_output','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpiseDetails_product_specific_coverage where specific_coverage_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_by_plant<?=$row['specific_coverage_id']; ?>">
                    <td><?=$row['product_name']; ?></td>
                    <td><?= $row['total_sales']; ?></td>
                    <td><?= $row['average_batch']; ?></td>
                    <td><?=$row['largest_batch']; ?></td>
                    <td><?= $row['daily_output']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_by_plant" data-toggle="modal" type="button" id="update_by_plant" data-id="<?= $row['specific_coverage_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_by_plant" data-toggle="modal" type="button" id="delete_by_plant" data-id="<?= $row['specific_coverage_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}

// Branded Products
if( isset($_POST['btnAdd_branded_product']) ) {
  
    $cookie = $_COOKIE['ID'];
    $title_brand = implode(' | ', $_POST["title_brand"]);
    $title_brand = explode(' | ', $title_brand);
    
    $i = 0;
   foreach($title_brand as $val)
    {
        $percentage = mysqli_real_escape_string($conn,$_POST["percentage"][$i]);
        if(empty($percentage)){ $percentage = 0; }
        $sql = "INSERT INTO tblEnterpise_brand_pro(title_brand,percentage,addedby,owner_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$percentage','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_brand_pro where brand_id  = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_branded_<?= $row['brand_id']; ?>">
                   <td width="200px"><?= $row['title_brand']; ?></td>
                    <td><?= $row['percentage']; ?>%</td>
                    <td width="100px">
                        <div class="btn-group btn-group">
                            <a  href="#modal_update_branded" data-toggle="modal" type="button" id="update_branded" data-id="<?= $row['brand_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <!--<a href="#modal_delete_branded" data-toggle="modal" type="button" id="delete_branded" data-id="<?= $row['brand_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>-->
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update Branded Products
if( isset($_GET['get_branded_id']) ) {
	$ID = $_GET['get_branded_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_brand_pro where brand_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $row['title_brand']; ?></label>
                        <input type="hidden" name="title_brand" value="<?= $row['title_brand']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Percentage</label>
                        <input class="form-control" name="percentage" value="<?= $row['percentage']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_branded']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $title_brand = mysqli_real_escape_string($conn,$_POST['title_brand']);
    $percentage= mysqli_real_escape_string($conn,$_POST['percentage']);
    
   
	$sql = "UPDATE tblEnterpise_brand_pro set title_brand='$title_brand',percentage='$percentage' where brand_id  = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_brand_pro where brand_id  = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
               <td width="200px"><?= $row['title_brand']; ?></td>
                <td><?= $row['percentage']; ?>%</td>
                <td width="100px">
                    <div class="btn-group btn-group">
                        <a  href="#modal_update_branded" data-toggle="modal" type="button" id="update_branded" data-id="<?= $row['brand_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <!--<a href="#modal_delete_branded" data-toggle="modal" type="button" id="delete_branded" data-id="<?= $row['brand_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>-->
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete Branded Products
if( isset($_GET['delete_branded_id']) ) {
	$ID = $_GET['delete_branded_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_brand_pro where brand_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b><?= $row['title_brand']; ?></b></label>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Percentage: </b></label>
                        <i><?= $row['percentage']; ?>%</i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_branded']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblEnterpise_brand_pro  where brand_id  = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// Co Manufacturing
if( isset($_POST['btnAdd_co_manu']) ) {
  
    $cookie = $_COOKIE['ID'];
    $party_product = implode(' | ', $_POST["party_product"]);
    $party_product = explode(' | ', $party_product);
    
    $i = 0;
   foreach($party_product as $val)
    {
        $percentage = mysqli_real_escape_string($conn,$_POST["ptc_product"][$i]);
        if(empty($percentage)){ $percentage = 0; }
        $sql = "INSERT INTO tblEnterpise_co_manufacturing(party_product,ptc_product,cm_addedby,cm_owner_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$percentage','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_co_manufacturing where cm_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_co_manu_<?= $row['cm_id']; ?>">
                    <td><?= $row['party_product']; ?></td>
                    <td><?= $row['ptc_product']; ?>%</td>
                    <td width="100px">
                        <div class="btn-group btn-group">
                            <a  href="#modal_update_co_manu" data-toggle="modal" type="button" id="update_co_manu" data-id="<?= $row['cm_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update Co Manufacturing
if( isset($_GET['get_comanu_id']) ) {
	$ID = $_GET['get_comanu_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_co_manufacturing where cm_id   = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $row['party_product']; ?></label>
                        <input type="hidden" name="party_product" value="<?= $row['party_product']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Percentage</label>
                        <input class="form-control" name="ptc_product" value="<?= $row['ptc_product']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_comanu']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $party_product = mysqli_real_escape_string($conn,$_POST['party_product']);
    $ptc_product = mysqli_real_escape_string($conn,$_POST['ptc_product']);
    
   
	$sql = "UPDATE tblEnterpise_co_manufacturing set party_product='$party_product',ptc_product='$ptc_product' where cm_id   = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_co_manufacturing where cm_id   = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
               <td><?= $row['party_product']; ?></td>
                <td><?= $row['ptc_product']; ?>%</td>
                <td width="100px">
                    <div class="btn-group btn-group">
                        <a  href="#modal_update_co_manu" data-toggle="modal" type="button" id="update_co_manu" data-id="<?= $row['cm_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

// New Products
if( isset($_POST['btnAdd_new_product']) ) {
  
    $cookie = $_COOKIE['ID'];
    $product_name = implode(' | ', $_POST["product_name"]);
    $product_name = explode(' | ', $product_name);
    
    $i = 0;
   foreach($product_name as $val)
    {
        // $percentage = mysqli_real_escape_string($conn,$_POST["percentage"][$i]);
        // if(empty($percentage)){ $percentage = 0; }
        $sql = "INSERT INTO tblEnterpise_new_product(product_name,np_addedby,np_owner_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_new_product where np_id  = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_newprod_<?= $row['np_id']; ?>">
                    <td><?= $row['product_name']; ?></td>
                    <td width="200px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_new_prod" data-toggle="modal" type="button" id="update_new_prod" data-id="<?= $row['np_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                            <a href="#modal_delete_new_prod" data-toggle="modal" type="button" id="delete_new_prod" data-id="<?= $row['np_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update New Products
if( isset($_GET['get_newprod_id']) ) {
	$ID = $_GET['get_newprod_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_new_product where np_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Product Name</label>
                        <input class="form-control" name="product_name" value="<?= $row['product_name']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_newprod']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
    
   
	$sql = "UPDATE tblEnterpise_new_product set product_name='$product_name' where np_id  = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_new_product where np_id  = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                    <td><?= $row['product_name']; ?></td>
                    <td width="200px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_new_prod" data-toggle="modal" type="button" id="update_new_prod" data-id="<?= $row_np['np_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                            <a href="#modal_delete_new_prod" data-toggle="modal" type="button" id="delete_new_prod" data-id="<?= $row_bp['np_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
          <?php }
          
          
    }
}

//delete New Products
if( isset($_GET['delete_newprod_id']) ) {
	$ID = $_GET['delete_newprod_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_new_product where np_id   = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Product Name: </b></label>
                        <i><?= $row['product_name']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_newprod']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tblEnterpise_new_product set is_deleted= 1 where np_id   = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// New customer
if( isset($_POST['btnAdd_customer']) ) {
  
    $cookie = $_COOKIE['ID'];
    $customer_name = implode(' | ', $_POST["customer_name"]);
    $customer_name = explode(' | ', $customer_name);
    
    $i = 0;
   foreach($customer_name as $val)
    {
        $percentage_sales = mysqli_real_escape_string($conn,$_POST["percentage_sales"][$i]);
        if(empty($percentage_sales)){ $percentage_sales = 0; }
        $product_manu = mysqli_real_escape_string($conn,$_POST["product_manu"][$i]);
        
        $sql = "INSERT INTO tblEnterpise_customer(customer_name,percentage_sales,product_manu,addedby,ownedby) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$percentage_sales','$product_manu','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_customer where customer_id  = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_customer_<?= $row['customer_id']; ?>">
                    <td><?= $row['customer_name']; ?></td>
                    <td><?= $row['percentage_sales']; ?></td>
                    <td><?= $row['product_manu']; ?></td>
                    <td width="200px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_customer" data-toggle="modal" type="button" id="update_customer" data-id="<?= $row['customer_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                            <a href="#modal_delete_customer" data-toggle="modal" type="button" id="delete_customer" data-id="<?= $row['customer_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update customer
if( isset($_GET['get_customer_id']) ) {
	$ID = $_GET['get_customer_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_customer where customer_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Customer</label>
                        <input class="form-control" name="customer_name" value="<?= $row['customer_name']; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Percentage of Sales</label>
                        <input type="munber" class="form-control" name="percentage_sales" value="<?= $row['percentage_sales']; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Products Manufactured</label>
                        <input class="form-control" name="product_manu" value="<?= $row['product_manu']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_customer']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $customer_name = mysqli_real_escape_string($conn,$_POST['customer_name']);
    $percentage_sales = mysqli_real_escape_string($conn,$_POST['percentage_sales']);
    $product_manu = mysqli_real_escape_string($conn,$_POST['product_manu']);
   
	$sql = "UPDATE tblEnterpise_customer set customer_name='$customer_name',percentage_sales= '$percentage_sales',product_manu='$product_manu' where customer_id  = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_customer where customer_id  = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?= $row['customer_name']; ?></td>
                <td><?= $row['percentage_sales']; ?></td>
                <td><?= $row['product_manu']; ?></td>
                <td width="200px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_customer" data-toggle="modal" type="button" id="update_customer" data-id="<?= $row['customer_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                        <a href="#modal_delete_customer" data-toggle="modal" type="button" id="delete_customer" data-id="<?= $row['customer_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete customer
if( isset($_GET['delete_customer_id']) ) {
	$ID = $_GET['delete_customer_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_customer where customer_id   = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>customer_name: </b></label>
                        <i><?= $row['customer_name']; ?></i>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Percentage of Sales: </b></label>
                        <i><?= $row['percentage_sales']; ?></i>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Products Manufactured: </b></label>
                        <i><?= $row['product_manu']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_customer']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tblEnterpise_customer set is_deleted= 1 where customer_id   = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// shelf life
if( isset($_POST['btnAdd_shelflife']) ) {
  
    $cookie = $_COOKIE['ID'];
    $frequency = implode(' | ', $_POST["frequency"]);
    $frequency = explode(' | ', $frequency);
    
    $i = 0;
   foreach($frequency as $val)
    {
        $percentage = mysqli_real_escape_string($conn,$_POST["percentage"][$i]);
        if(empty($percentage)){ $percentage = 0; }
        $sql = "INSERT INTO tblEnterpise_shelflife(frequency,percentage,addedby,owner_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$percentage','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_shelflife where shelf_id  = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_shelflife_<?= $row['shelf_id']; ?>">
                    <td width="200px"><?= $row['frequency']; ?></td>
                    <td><?= $row['percentage']; ?>%</td>
                    <td width="100px">
                        <div class="btn-group btn-group">
                            <a  href="#modal_update_shelf" data-toggle="modal" type="button" id="update_shelf" data-id="<?= $row['shelf_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update shelf life
if( isset($_GET['get_shelf_id']) ) {
	$ID = $_GET['get_shelf_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_shelflife where shelf_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $row['frequency']; ?></label>
                        <input type="hidden" name="title_brand" value="<?= $row['title_brand']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Percentage</label>
                        <input class="form-control" name="percentage" value="<?= $row['percentage']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_shelf']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $percentage= mysqli_real_escape_string($conn,$_POST['percentage']);
    
   
	$sql = "UPDATE tblEnterpise_shelflife set percentage='$percentage' where shelf_id  = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_shelflife where shelf_id  = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
               <td width="200px"><?= $row['frequency']; ?></td>
                <td><?= $row['percentage']; ?>%</td>
                <td width="100px">
                    <div class="btn-group btn-group">
                        <a  href="#modal_update_shelf" data-toggle="modal" type="button" id="update_shelf" data-id="<?= $row['shelf_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

// Distribution
if( isset($_POST['btnAdd_distribution']) ) {
  
    $cookie = $_COOKIE['ID'];
    $geography = implode(' | ', $_POST["geography"]);
    $geography = explode(' | ', $geography);
    
    $i = 0;
   foreach($geography as $val)
    {
        $manufacture = mysqli_real_escape_string($conn,$_POST["manufacture"][$i]);
        if(empty($manufacture)){ $manufacture = 0; }
        $sales = mysqli_real_escape_string($conn,$_POST["sales"][$i]);
        if(empty($sales)){ $sales = 0; }
        $sql = "INSERT INTO tblEnterpise_distribution(geography,manufacture,sales,addedby,owner_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$manufacture','$sales','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblEnterpise_distribution where dist_id  = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_distribution_<?= $row['dist_id']; ?>">
                    <td width="200px"><?= $row['geography']; ?></td>
                    <td><?= $row['manufacture']; ?>%</td>
                    <td><?= $row['sales']; ?>%</td>
                    <td width="100px">
                        <div class="btn-group btn-group">
                            <a  href="#modal_update_distribution" data-toggle="modal" type="button" id="update_distribution" data-id="<?= $row['dist_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
        $i++;
    }
}
//update Distribution
if( isset($_GET['get_distributionf_id']) ) {
	$ID = $_GET['get_distributionf_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblEnterpise_distribution where dist_id  = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Geography: </b><?= $row['geography']; ?></label>
                        <input type="hidden" name="geography" value="<?= $row['geography']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Manufacture (as % of total sales)</label>
                        <input class="form-control" name="manufacture" value="<?= $row['manufacture']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Sales (as % of total sales)</label>
                        <input class="form-control" name="sales" value="<?= $row['sales']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_distribution']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $geography = mysqli_real_escape_string($conn,$_POST['geography']);
    $manufacture = mysqli_real_escape_string($conn,$_POST['manufacture']);
    $sales = mysqli_real_escape_string($conn,$_POST['sales']);
   
	$sql = "UPDATE tblEnterpise_distribution set geography='$geography',manufacture='$manufacture',sales='$sales' where dist_id  = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblEnterpise_distribution where dist_id  = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
               <td width="200px"><?= $row['geography']; ?></td>
                <td><?= $row['manufacture']; ?>%</td>
                <td><?= $row['sales']; ?>%</td>
                <td width="100px">
                    <div class="btn-group btn-group">
                        <a  href="#modal_update_distribution" data-toggle="modal" type="button" id="update_distribution" data-id="<?= $row['dist_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                    </div>
                </td>
          <?php }
          
          
    }
}
?>