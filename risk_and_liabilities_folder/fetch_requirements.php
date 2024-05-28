<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
 $query = mysqli_query($conn,"select * from tbl_supplier_material where ID = '$get_id'");
    foreach($query as $row){?>
      <tr class="data_<?= $row['ID']; ?>">
            <td>
              <input class="form-control" value="<?= $row['material_name']; ?>" name="requirement_id[]">
            </td>
            <td width="50px">
              <input class="form-control qty_Cal"  value="1" name="qty[]" type="number" onchange="Calc(this);">
            </td>
            <td width="50px">
                <label class="form-control"> Kg</label>
            </td>
            <td width="120px">
                <input class="form-control cost_data"  value="<?= $row['cost_kg']; ?>" name="cost_data[]" type="number" onchange="Calc(this);" readonly>
            </td>
            <td width="100px">
                <input class="form-control"  value="<?= $row['cost_kg']; ?>" name="amt" readonly>
            </td>
      </tr>
   <?php } 
    }
?>
