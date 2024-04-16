<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
 $query = mysqli_query($conn,"select * from tbl_supplier_material where ID = '$get_id'");
    foreach($query as $row){?>
      <tr class="data_<?= $row['ID']; ?>">
            <td>
                <input type="hidden" value="<?= $row['ID']; ?>" name="name[]">
              <input class="form-control" value="<?= $row['material_name']; ?>">
            </td>
            <td width="50px">
              <input class="form-control qty_Cal"  value="1" name="stocks[]" type="number" onchange="Calc(this);">
            </td>
            <td width="50px">
                <label class="form-control"> <?= $row['material_uom']; ?></label>
            </td>
            <td width="120px">
                <input class="form-control cost_data"  value="<?= $row['material_ppu']; ?>" name="" type="number" onchange="Calc(this);" readonly>
            </td>
            <td width="100px">
                <input class="form-control"  value="<?= $row['material_ppu']; ?>" name="amt" readonly>
            </td>
      </tr>
   <?php } 
    }
?>
