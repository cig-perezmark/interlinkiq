<?php 
include "../database.php";
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

if(isset($_POST["search_val"])) {
    $get_id = $_POST["search_val"];
    if(!empty($_POST["search_val"])) {
        $get_id = $_POST["search_val"];
        $query = mysqli_query($conn,"select * from tbl_supplier where ID = '$get_id'");
        foreach($query as $row){?>
            <div class="form-group">
                  <div class="col-md-8">
                      <div class="table-scrollable" style="height:29vh;background-color:#EEEEEE;overflow:scroll;">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Items/Material</th>
                                      <th>SKU</th>
                                  </tr>
                              </thead>
                              <tbody>
                                    <?php
                                        $material = $row["material"];
                                        $material_arr = explode(", ", $material);
                                        $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material" );
                                        if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                            while($rowMaterial = mysqli_fetch_array($selectMaterial)){
                                            if(in_array($rowMaterial['ID'], $material_arr)){
                                            ?>
                                                <tr>
                                                    <td width="10px">
                                                        <input type="checkbox" class="value_data" id="checked_data" onclick="get_data(this)" value="<?= $rowMaterial['ID'];?>">
                                                    </td>
                                                    <td><?= $rowMaterial['material_name']; ?></td>
                                                    <td><?= $rowMaterial['material_id']; ?></td>
                                                </tr>
                                        <?php } } }
                                    ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="row">
                          <div class="col-md-12">
                              <label>Order #</label>
                              <input class="form-control" name="order_no">
                          </div>
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-12">
                              <label>Expected Arrival</label>
                              <input class="form-control" type="date" name="expected_date">
                          </div>
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-12">
                              <label>Created Date</label>
                              <input class="form-control" type="date" name="created_date">
                          </div>
                      </div>
                  </div>
            </div> 
            <?php
         } 
    }
}
?>
