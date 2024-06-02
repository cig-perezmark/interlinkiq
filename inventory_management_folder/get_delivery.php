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
if( isset($_POST['get_field']) ) {
    
    $all = $_POST['receive_all'];
    $remove_str = substr($all, 4);
    if($all == 'rec_'.$remove_str ){$item_pk =$remove_str; }else{ $item_pk = $_POST['get_field'];}
    
   
    $invty = mysqli_query($conn, "select * from tbl_inventory_management_materials where id = $item_pk");
    foreach($invty as $row){
    ?>

    <div class="form-group">
        <div class="col-md-12">
            <p class="form-control bg-grey"> <b> Material Information</b></p>
        </div>
        <div class="col-md-12">
             <label class="control-label"><b>SKU: </b> </label>
            <input type="hidden" value="<?= $item_pk; ?>" name="item_pk" id="project_id">
            
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
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-5">
            <label class="control-label text-primary"><i class="icon-basket-loaded"></i> Stocks on Hand: </label>
            
            <?= $row['stocks'];  ?>
        </div>
        <div class="col-md-3">
            <label class="control-label text-primary"><i class="fa fa-truck"></i>Expected: </label>
        </div>
        <div class="col-md-2">
            <?php
                $item_pk= $row['id']; 
                $qry_stocks = mysqli_query($conn, "select sum(purchase_stocks) as count from tbl_inventory_purchase where item_pk = $item_pk");
                if(mysqli_num_rows($qry_stocks) > 0){
                    foreach($qry_stocks as $row_stock){
                        if($all == 'rec_'.$remove_str ){?>
                            <label class="form-control" style="border:none !important;">( <?= $row_stock['count']; ?> )</label>
                            <input type="hidden" name="exptected" class="form-control" value="<?= $row_stock['count'] ; ?>"> 
                       <?php }else{?> 
                            <input type="number" name="exptected" class="form-control" value="<?= $row_stock['count'] ; ?>"> 
                        <?php }
                    }
                }
            ?>
        </div>
        <div class="col-md-2" >
             <?php 
                $mtrl = $row['name']; 
                $material_uom = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
                foreach($material_uom as $row_uom){?>
                     <label class="form-control" style="border:none !important;"><?= $row_uom['material_uom']; ?></label>
               <?php }
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <p class="form-control bg-grey"> <b> Supplier</b></p>
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
    
    <? } 
}
?>