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


// New Purchase
if( isset($_POST['btnAdd_purchase']) ) {
  
    $cookie = $_COOKIE['ID'];
    $manufacturer = mysqli_real_escape_string($conn,$_POST['manufacturer']);
    $order_no = mysqli_real_escape_string($conn,$_POST['order_no']);
    $expected_arrival = mysqli_real_escape_string($conn,$_POST['expected_arrival']);
    $created_date = mysqli_real_escape_string($conn,$_POST['created_date']);
    
    $name = implode(' | ', $_POST["name"]);
    $name = explode(' | ', $name);
   
    $i = 0;
   foreach($name as $val)
    {
        $stocks = mysqli_real_escape_string($conn,$_POST["stocks"][$i]);
        
        $sql = "INSERT INTO tbl_inventory_management_materials(name,manufacturer,order_no,expected_arrival,created_date,status,user_id) 
        VALUES('".mysqli_real_escape_string($conn, $val)."','$manufacturer','$order_no','$expected_arrival','$created_date',1,'$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
            
            $sql_purchase = "INSERT INTO tbl_inventory_purchase(purchase_stocks,item_pk) 
            VALUES('$stocks','$last_id')";
            if(mysqli_query($conn, $sql_purchase)){
                $query = mysqli_query($conn, "select * from tbl_inventory_management_materials where id = $last_id");
                if(mysqli_fetch_row($query)){
                foreach($query as $row){?>
                     <tr id="row_supplier_<?= $row['id']; ?>">
    	                <td>
		                     <?php 
    	                        $mtrl = $row['name']; 
    	                        $material_qry = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
    	                        foreach($material_qry as $row_raw){?>
    	                            <span>
										<strong> <?= $row_raw['material_name']; ?> </strong>
										<p class="font-grey-mint" style="margin: 0; font-size: .95em;"> <?= $row_raw['description']; ?> </p>
									</span>
    	                       <?php }
    	                    ?>
		                    
		                </td>
		                <td>
		                    <?php 
    	                        $sppr = $row['manufacturer']; 
    	                        $suppr = mysqli_query($conn, "select * from tbl_supplier where id = '$sppr'");
    	                        foreach($suppr as $row_sup){?>
    	                            <?= $row_sup['name']; ?>
    	                       <?php }
    	                    ?>
		                </td>
		                <td>
		                    <?php 
    	                        $mtrl1 = $row['name']; 
    	                        $material_qry1 = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl1'");
    	                        foreach($material_qry1 as $row_raw1){?>
    	                            <?= $row_raw1['material_id']; ?>
    	                       <?php }
                            ?>          
                        </td>
		                <td><?= $row['stocks']; ?></td>
                        <td>
                            <?php
                                $item_pk= $row['id']; 
                                $qry_stocks = mysqli_query($conn, "select sum(purchase_stocks) as count from tbl_inventory_purchase where item_pk = $item_pk");
                                if(mysqli_num_rows($qry_stocks) > 0){
                                    foreach($qry_stocks as $row_stock){
                                        echo $row_stock['count'];
                                    }
                                }
                            ?>
                        </td>
		                <td>
		                     <div class="form-group">
		                         <div class="col-md-12">
			                         <select id="single-append-radio" class="bs-select form-control get_delivery" data-show-subtext="true" onchange="get_delivery_data(this.value)">
                                        <option data-icon="fa-square text-default" value="0">Not Recieved</option>
                                        <option data-icon="fa-square text-warning" value="<?= $row['id']; ?>"> Receive some</option>
                                        <option data-icon="fa-square text-success" value="rec_<?= $row['id']; ?>" <?php ?>>Receive all</option>
                                    </select>
			                     </div>
		                     </div>
		                </td>
		                <td>
		                    <?php 
		                        if($row['status'] == 1){ echo 'Active';} 
		                     ?>
		                </td>
		                <td width="150px">
                            <div class="btn-group btn-group-circle">
                                <a  href="#modal_update_inventory" data-toggle="modal" type="button" id="update_inventory" data-id="<?= $row['id']; ?>" class="btn btn-outline dark btn-sm">View</a>
        	                    <a href="#modal_delete_inventory" data-toggle="modal" type="button" id="delete_inventory" data-id="<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                            </div>
                        </td>
    	            </tr>
                <?php } 
                }
            }
         }
        $i++;
    }
}

//update annual revenue
if( isset($_GET['get_material_id']) ) {
	$ID = $_GET['get_material_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_inventory_management_materials where id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <div class="form-group">
                    <div class="col-md-12" style="margin-top:-2.5rem;">
                        <p class="form-control bg-grey"> <b> Product Information</b></p>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>SKU: </b> </label>
                        <?php 
	                        $mtrl = $row['name']; 
	                        $material_qry_sku = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
	                        foreach($material_qry_sku as $row_sku){?>
	                         <i><?= $row_sku['material_id']; ?></i>
	                       <?php }
	                    ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label"><b>Item/Material</b> </label><br>
                        <?php 
	                        $mtrl = $row['name']; 
	                        $material_qry = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
	                        foreach($material_qry as $row_raw){?>
	                         <i><?= $row_raw['material_name']; ?></i>
	                       <?php }
	                    ?>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><b>Country of Origin</b></label><br>
                        <?php 
	                        $ccountry = $row['manufacturer']; 
	                        $suppr_country = mysqli_query($conn, "select * from tbl_supplier where id = '$ccountry'");
	                        foreach($suppr_country as $row_sup_cc){
	                            
	                                $array_data = explode(", ", $row_sup_cc["address"]);
	                                $selectCountry = mysqli_query( $conn,"SELECT * FROM countries" );
		                            while($rowCountry = mysqli_fetch_array($selectCountry)) {
		                                 if(in_array($rowCountry['iso2'], $array_data)){
                                            echo $rowCountry["name"]; 
                                        }
		                            }
	                        }
	                    ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Description</b> </label><br>
                        <?php 
	                        $mtrl = $row['name']; 
	                        $material_qry_dsc = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
	                        foreach($material_qry_dsc as $row_raw){?>
	                            <i><?= $row_raw['description']; ?></i>
	                       <?php }
	                    ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <p class="form-control bg-grey"> <b>Inventory Information</b></p>
                    </div>
                </div>
                <div class="form-group">
                    
                    <div class="col-md-6">
                        <label class="control-label"><b>Unit of Measure: </b></label>
	                     <?php 
	                        $mtrl = $row['name']; 
	                        $material_uom = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
	                        foreach($material_uom as $row_uom){?>
	                             <i><?= $row_uom['material_uom']; ?></i>
	                       <?php }
	                    ?>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><b>Product Status: </b></label>
                        <?php  if($row['status'] == 1){ echo 'Active';} ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label text-primary"><i class="fa fa-truck"></i> Expected: </label>
                        
                        <?php
                            $item_pk= $row['id']; 
                            $qry_stocks = mysqli_query($conn, "select sum(purchase_stocks) as count from tbl_inventory_purchase where item_pk = $item_pk");
                            if(mysqli_num_rows($qry_stocks) > 0){
                                foreach($qry_stocks as $row_stock){
                                    echo '( '.$row_stock['count'].' )';
                                }
                            }
                        ?>
	                       <a class="btn-xs bg-warning" title="Amount of stock that is expected to arrive in the stock.">!</a>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label text-primary"><i class="icon-basket-loaded"></i> Stocks on Hand: </label>
                        ( <?= $row['stocks']; ?> ) 
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <p class="form-control bg-grey"> <b>Manufacturer / Supplier</b></p>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Supplier: </b> </label>
                       <?php 
	                        $sppr = $row['manufacturer']; 
	                        $suppr = mysqli_query($conn, "select * from tbl_supplier where id = '$sppr'");
	                        foreach($suppr as $row_sup){?>
	                            <i><?= $row_sup['name']; ?></i>
	                       <?php }
	                    ?>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_material']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $ar_year = mysqli_real_escape_string($conn,$_POST['ar_year']);
    $ar_total = mysqli_real_escape_string($conn,$_POST['ar_total']);
   
	$sql = "UPDATE tbl_inventory_management_materials set ar_year='$ar_year',ar_total='$ar_total',ar_addedby='$cookie' where id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tbl_inventory_management_materials where id = $IDs";
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
if( isset($_GET['delete_material_id']) ) {
	$ID = $_GET['delete_material_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_inventory_management_materials where id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <?php 
	                        $mtrl1 = $row['name']; 
	                        $material_qry1 = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl1'");
	                        foreach($material_qry1 as $row_raw1){?>
	                            <strong>SKU: <?= $row_raw1['material_id']; ?> </strong>
	                       <?php }
                        ?>          
                    </div>
                    <div class="col-md-12">
                        <?php 
	                        $mtrl = $row['name']; 
	                        $material_qry = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
	                        foreach($material_qry as $row_raw){?>
	                            <span>
									<strong>Items: <?= $row_raw['material_name']; ?> </strong>
									<p class="font-grey-mint" style="margin: 0; font-size: .95em;">Description: <?= $row_raw['description']; ?> </p>
								</span>
	                       <?php }
	                    ?>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_material']) ) {
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tbl_inventory_management_materials set is_deleted= 1  where id = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

if( isset($_POST['btnReceive_material']) ) {
	
    $user_cookie = $_COOKIE['ID'];
    $today = date('Y-m-d');
	$ID = $_POST['item_pk'];
    $exptected = $_POST['exptected'];
// 	$filename = mysqli_real_escape_string($conn,$_POST['filename']);
	$stocks = mysqli_query($conn, "select sum(stocks) as counts,id from tbl_inventory_management_materials where id = $ID");
	foreach($stocks as $row_stocks){
	    $total = $row_stocks['counts'] + $exptected;
	}
	
	$purchase_stocks = mysqli_query($conn, "select sum(purchase_stocks) as counts,item_pk from tbl_inventory_purchase where item_pk = $ID");
	foreach($purchase_stocks as $row_purchase){
	    $deduction = $row_purchase['counts'] - $exptected;
	}
	
	$sql = "UPDATE tbl_inventory_management_materials set stocks = '$total'  where id = $ID";
    if(mysqli_query($conn, $sql)){
        
        $sql_purchase = "UPDATE tbl_inventory_purchase set purchase_stocks = '$deduction'  where item_pk = $ID";
        if(mysqli_query($conn, $sql_purchase)){
            echo $ID;
            $invty = mysqli_query($conn, "select * from tbl_inventory_management_materials where id = $ID");
            foreach($invty as $row){?>
                    <td>
                         <?php 
                            $mtrl = $row['name']; 
                            $material_qry = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
                            foreach($material_qry as $row_raw){?>
                                <span>
    								<strong> <?= $row_raw['material_name']; ?> </strong>
    								<p class="font-grey-mint" style="margin: 0; font-size: .95em;"> <?= $row_raw['description']; ?> </p>
    							</span>
                           <?php }
                        ?>
                        
                    </td>
                    <td>
                        <?php 
                            $sppr = $row['manufacturer']; 
                            $suppr = mysqli_query($conn, "select * from tbl_supplier where id = '$sppr'");
                            foreach($suppr as $row_sup){?>
                                <?= $row_sup['name']; ?>
                           <?php }
                        ?>
                    </td>
                    <td>
                        <?php 
                            $mtrl1 = $row['name']; 
                            $material_qry1 = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl1'");
                            foreach($material_qry1 as $row_raw1){?>
                                <?= $row_raw1['material_id']; ?>
                           <?php }
                        ?>          
                    </td>
                    <td><?= $row['stocks']; ?></td>
                    <td>
                        <?php
                            $item_pk= $row['id']; 
                            $qry_stocks = mysqli_query($conn, "select sum(purchase_stocks) as count from tbl_inventory_purchase where item_pk = $item_pk");
                            if(mysqli_num_rows($qry_stocks) > 0){
                                foreach($qry_stocks as $row_stock){
                                    echo $row_stock['count'];
                                }
                            }
                        ?>
                    </td>
                    <td>
                         <div class="form-group">
                             <div class="col-md-12">
    	                         <select id="single-append-radio" class="bs-select form-control get_delivery" data-show-subtext="true" onchange="get_delivery_data(this.value)">
                                    <option data-icon="fa-square text-default" value="0">Not Recieved</option>
                                    <option data-icon="fa-square text-warning" value="<?= $row['id']; ?>"> Receive some</option>
                                    <option data-icon="fa-square text-success" value="rec_<?= $row['id']; ?>">Receive all</option>
                                </select>
    	                     </div>
                         </div>
                    </td>
                    <td>
                        <?php 
                            if($row['status'] == 1){ echo 'Active';} 
                         ?>
                    </td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_inventory" data-toggle="modal" type="button" id="update_inventory" data-id="<?= $row['id']; ?>" class="btn btn-outline dark btn-sm">View</a>
    	                    <a href="#modal_delete_inventory" data-toggle="modal" type="button" id="delete_inventory" data-id="<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                <?php }
        }
    }

}

?>
