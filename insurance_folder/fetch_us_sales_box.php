<?php
require '../database.php';

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

if(isset($_POST['key'])){
    $response = "";
    $i = 1;
    if ($_POST['key'] == 'ids') {
        $i++;
       $response .= '
         <tr id="row_tblus'; $response .= $i;  $response .= '">
           <td><input class="form-control no-border" name="us_item[]" placeholder="Item"></td>
          <td><input type="number" class="form-control no-border" name="us_estimated_gross[]" placeholder="$0.00"></td>
          <td><input type="number" class="form-control no-border" name="us_projected_gross[]" placeholder="$0.00"></td>
            <td><button type="button" name="remove" id="'; $response .= $i;  $response .= '" class="btn btn-danger float-right btn_remove_us_row"><i class="fa fa-close"></i></button></td>
        </tr>
       ';
    }
    else if ($_POST['key'] == 'fetch_us_data') {
        $sales_query = mysqli_query($conn, "select * from tblEnterpise_sales where sales_enterprise_id = $user_id");
        if(mysqli_fetch_row($sales_query)){
            foreach($sales_query as $row_sales){
                
                $estimated_start_date ='NULL';
                if($row_sales['estimated_start_date'] != 'NULL' and $row_sales['estimated_start_date'] != ''){$estimated_start_date = date('Y-m-d', strtotime($row_sales['estimated_start_date']));}
                $estimated_to_date = 'NULL';
                if($row_sales['estimated_to_date'] != 'NULL' and $row_sales['estimated_to_date'] != ''){$estimated_to_date = date('Y-m-d', strtotime($row_sales['estimated_to_date']));}
                $projected_start_date = '';
                if($row_sales['projected_start_date'] != 'NULL' and $row_sales['projected_start_date'] != ''){$projected_start_date = date('Y-m-d', strtotime($row_sales['projected_start_date']));}
                $projected_to_date = 'NULL';
                if($row_sales['projected_to_date']!= 'NULL' and $row_sales['projected_to_date'] != ''){ $projected_to_date = date('Y-m-d', strtotime($row_sales['projected_to_date']));}
               $estimated_foreign_start_date = 'NULL';
                if($row_sales['estimated_foreign_start_date']!= 'NULL' and $row_sales['estimated_foreign_start_date'] != ''){$estimated_foreign_start_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_start_date']));}
                $estimated_foreign_to_date = 'NULL';
                if($row_sales['estimated_foreign_to_date'] != 'NULL' and $row_sales['estimated_foreign_to_date'] != ''){$estimated_foreign_to_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_to_date']));}
                $projected_foreign_start_date = 'NULL';
                if($row_sales['projected_foreign_start_date'] != 'NULL' and $row_sales['projected_foreign_start_date'] != ''){$projected_foreign_start_date = date('Y-m-d', strtotime($row_sales['projected_foreign_start_date']));}
                $projected_foreign_to_date = 'NULL';
                if($row_sales['projected_foreign_to_date'] != 'NULL' and $row_sales['projected_foreign_to_date'] != ''){$projected_foreign_to_date = date('Y-m-d', strtotime($row_sales['projected_foreign_to_date']));}
                
               
               $response .= '
                 
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>
                                <input type="hidden" name="enter_id" value="'; $response .= $row_sales['sales_enterprise_id']; $response .= '">
                                Total US Gross Sales Item
                                </th>
                              <th width="350px">
                                  Estimated <input style="font-size:12px;" type="date" name="estimated_start_date" class=" no-border" value="'.$estimated_start_date.'"> 
                                  to <input style="font-size:12px;" type="date" name="estimated_to_date"  class="no-border" value="'.$estimated_to_date.'"></th>
                                  
                                    <th width="350px">Projected <input style="font-size:12px;" name="projected_start_date" type="date" class=" no-border" value="'.$projected_start_date.'"> 
                                    to <input style="font-size:12px;" type="date" name="projected_to_date" class=" no-border" value="'.$projected_to_date.'">
                                </th>
                              <th></th>
                          </tr>
                    </thead>
                      <tbody id="data_sales">
                      ';
                            $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_us_gross where us_enterprise_id = $user_id");
                            foreach($us_gross as $row_gross){
                                $response .= '
                                <tr id="us_row'.$row_gross['us_gross_id'].'">
                                    <td>'.$row_gross['us_item'].'</td>
                                      <td>$'.$row_gross['us_estimated_gross'].'</td>
                                      <td>$'.$row_gross['us_projected_gross'].'</td>
                                      <td>
                                        <div class="btn-group btn-group-circle">
                                            <a  href="#modal_update_us_sales" data-toggle="modal" type="button" id="update_us_sales" data-id="'.$row_gross['us_gross_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                    	                    <a href="#modal_delete_us_sales" data-toggle="modal" type="button" id="delete_us_sales" data-id="'.$row_gross['us_gross_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                        </div>
                                      </td>
                                </tr>';
                            }
                          $response .= '
                      </tbody>
                      <tbody id="dynamic_field_us">
                          <tr>
                              <td><input class="form-control no-border" name="us_item[]" placeholder="Item" value=""></td>
                              <td><input type="number" class="form-control no-border" name="us_estimated_gross[]" placeholder="$0.00"></td>
                              <td><input type="number" class="form-control no-border" name="us_projected_gross[]" placeholder="$0.00"></td>
                              <td><button type="button" name="add_us_row" id="add_us_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                          </tr>
                      </tbody>
                      <tbody>
                          <tr>
                              <th>Total Foreign Gross Sales</th>
                              <th width="350px">Estimated <input style="font-size:12px;" type="date" class=" no-border" name="estimated_foreign_start_date" value="'; $response .= $estimated_foreign_start_date; $response .= '"> 
                              to <input style="font-size:12px;" type="date" class=" no-border" name="estimated_foreign_to_date" value="'; $response .= $estimated_foreign_to_date; $response .= '"></th>
                            <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border" name="projected_foreign_start_date" value="'; $response .= $projected_foreign_start_date; $response .= '"> 
                            to <input style="font-size:12px;" type="date" class=" no-border" name="projected_foreign_to_date" value="'; $response .= $projected_foreign_to_date; $response .= '"></th>
                              <th></th>
                          </tr>
                      </tbody>
                        <tbody id="data_sales">
                            ';
                            $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_foreign_gross where foreign_enterprise_id = $user_id");
                            foreach($us_gross as $row_gross){
                                $response .= '
                                <tr id="foreign_row'.$row_gross['foreign_gross_id'].'">
                                    <td>'.$row_gross['foreign_item'].'</td>
                                      <td>$'.$row_gross['foreign_estimated_gross'].'</td>
                                      <td>$'.$row_gross['foreign_projected_gross'].'</td>
                                      <td>
                                        <div class="btn-group btn-group-circle">
                                            <a  href="#modal_update_foreign_sales" data-toggle="modal" type="button" id="update_foreign_sales" data-id="'.$row_gross['foreign_gross_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                    	                    <a href="#modal_delete_foreign_sales" data-toggle="modal" type="button" id="delete_foreign_sales" data-id="'.$row_gross['foreign_gross_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                        </div>
                                      </td>
                                </tr>';
                            }
                          $response .= '
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
                          </tr>
                      </thead>
                      <tbody>
                      ';
                        $sbc_query = mysqli_query($conn, "select * from tblEnterpise_sales_sbc where sbc_enterprise_id = $user_id");
                        foreach($sbc_query as $row_sbc){
                            $response .= '
                            <tr id="sbc_row'.$row_sbc['sbc_id'].'">
                                <td>'.$row_sbc['sbc_country_name'].'</td>
                                  <td>$'.$row_sbc['sbc_gross_1'].'</td>
                                  <td>$'.$row_sbc['sbc_gross_2'].'</td>
                                  <td>
                                    <div class="btn-group btn-group-circle">
                                        <a  href="#modal_update_sbc_sales" data-toggle="modal" type="button" id="update_sbc_sales" data-id="'.$row_sbc['sbc_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                	                    <a href="#modal_delete_sbc_sales" data-toggle="modal" type="button" id="delete_sbc_sales" data-id="'.$row_sbc['sbc_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                    </div>
                                  </td>
                            </tr>';
                        }
                      $response .= '
                      </tbody>
                      <tbody id="dynamic_sbc">
                          <tr>
                              <td><input class="form-control no-border" name="sbc_country_name[]" placeholder="Country Name"></td>
                            <td><input class="form-control no-border" name="sbc_gross_1[]" placeholder="$0.00"></td>
                            <td><input class="form-control no-border" name="sbc_gross_2[]" placeholder="$0.00"></td>
                              <td><button type="button" name="add_sbc_row" id="add_sbc_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                          </tr>
                      </tbody>
                  </table>
               ';
            }
        }
        else{
            $response .= '
            
            
           <table class="table table-bordered">
              <thead id="data_tblheader">
              <tr>
                  <th>
                      <input type="hidden" name="enter_id">
                      Total US Gross Sales Item
                  </th>
                  <th width="350px">
                      Estimated <input style="font-size:12px;" type="date" class=" no-border" name="estimated_start_date"> 
                      to <input style="font-size:12px;" type="date" class=" no-border"  name="estimated_to_date"></th>
                    <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border" name="projected_start_date"> 
                    to <input style="font-size:12px;" type="date" class=" no-border" name="projected_to_date"></th>
                  <th></th>
              </tr>
            </thead>
              <tbody id="data_sales">
                ';
                $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_us_gross where us_enterprise_id = $user_id");
                foreach($us_gross as $row_gross){
                    $response .= '
                    <tr id="us_row'.$row_gross['us_gross_id'].'">
                        <td>'.$row_gross['us_item'].'</td>
                          <td>$'.$row_gross['us_estimated_gross'].'</td>
                          <td>$'.$row_gross['us_projected_gross'].'</td>
                          <td>
                            <div class="btn-group btn-group-circle">
                                <a  href="#modal_update_us_sales" data-toggle="modal" type="button" id="update_us_sales" data-id="'.$row_gross['us_gross_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
        	                    <a href="#modal_delete_us_sales" data-toggle="modal" type="button" id="delete_us_sales" data-id="'.$row_gross['us_gross_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                            </div>
                          </td>
                    </tr>';
                }
              $response .= '
              </tbody>
              <tbody id="dynamic_field_us">
                  <tr>
                      <td><input class="form-control no-border" name="us_item[]" placeholder="Item" ></td>
                      <td><input type="number" class="form-control no-border" name="us_estimated_gross[]" placeholder="$0.00"></td>
                      <td><input type="number" class="form-control no-border" name="us_projected_gross[]" placeholder="$0.00"></td>
                      <td><button type="button" name="add_us_row" id="add_us_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                  </tr>
              </tbody>
              <tbody>
                  <tr>
                      <th>Total Foreign Gross Sales</th>
                      <th width="350px">Estimated <input style="font-size:12px;" type="date" class=" no-border" name="estimated_foreign_start_date"> 
                      to <input style="font-size:12px;" type="date" class=" no-border" name="estimated_foreign_to_date"></th>
                    <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border" name="projected_foreign_start_date"> 
                    to <input style="font-size:12px;" type="date" class=" no-border" name="projected_foreign_to_date"></th>
                      <th></th>
                  </tr>
              </tbody>
                <tbody id="data_sales">
                     ';
                            $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_foreign_gross where foreign_enterprise_id = $user_id");
                            foreach($us_gross as $row_gross){
                                $response .= '
                                <tr id="foreign_row'.$row_gross['foreign_gross_id'].'">
                                    <td>'.$row_gross['foreign_item'].'</td>
                                      <td>$'.$row_gross['foreign_estimated_gross'].'</td>
                                      <td>$'.$row_gross['foreign_projected_gross'].'</td>
                                      <td>
                                        <div class="btn-group btn-group-circle">
                                            <a  href="#modal_update_foreign_sales" data-toggle="modal" type="button" id="update_foreign_sales" data-id="'.$row_gross['foreign_gross_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                    	                    <a href="#modal_delete_foreign_sales" data-toggle="modal" type="button" id="delete_foreign_sales" data-id="'.$row_gross['foreign_gross_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                        </div>
                                      </td>
                                </tr>';
                            }
                          $response .= '
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
              <tbody>
              ';
                $sbc_query = mysqli_query($conn, "select * from tblEnterpise_sales_sbc where sbc_enterprise_id = $user_id");
                foreach($sbc_query as $row_sbc){
                    $response .= '
                    <tr id="sbc_row'.$row_sbc['sbc_id'].'">
                        <td>'.$row_sbc['sbc_country_name'].'</td>
                          <td>$'.$row_sbc['sbc_gross_1'].'</td>
                          <td>$'.$row_sbc['sbc_gross_2'].'</td>
                          <td>
                            <div class="btn-group btn-group-circle">
                                <a  href="#modal_update_sbc_sales" data-toggle="modal" type="button" id="update_sbc_sales" data-id="'.$row_sbc['sbc_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
        	                    <a href="#modal_delete_sbc_sales" data-toggle="modal" type="button" id="delete_sbc_sales" data-id="'.$row_sbc['sbc_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                            </div>
                          </td>
                    </tr>';
                }
              $response .= '
              </tbody>
              <tbody id="dynamic_sbc">
                  <tr>
                      <td><input class="form-control no-border" name="sbc_country_name[]" placeholder="Country Name"></td>
                        <td><input class="form-control no-border" name="sbc_gross_1[]" placeholder="$0.00"></td>
                        <td><input class="form-control no-border" name="sbc_gross_2[]" placeholder="$0.00"></td>
                      <td><button type="button" name="add_sbc_row" id="add_sbc_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                  </tr>
              </tbody>
          </table>
            ';
        }
    }
   exit($response);
}
?>
