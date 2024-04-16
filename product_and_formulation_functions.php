<?php
error_reporting(E_ALL);
include_once 'database_iiq.php';
define("IMAGE_PATH", "images/");

define("SESSION_NAME", clean_data("Alex Polo"));
define("SESSION_POSITION", clean_data("Encoder"));

$tbl_products = "temp_products";
$tbl_raw_materials = "temp_raw_materials";
$tbl_suppliers = "temp_suppliers";

if (isset($_POST['get_raw_materials_and_packagings'])) {

   $sql = "SELECT a.id AS id,raw_materials,supplier_name,price_per_unit,uom,material_type FROM $tbl_raw_materials a LEFT JOIN $tbl_suppliers b ON a.supplier_id=b.id";

   $query = $conn->query($sql);
   $result = $query->fetch_all(MYSQLI_ASSOC);
   echo json_encode($result);
} else if (isset($_POST['get_products'])) {

   $sql = "SELECT * FROM $tbl_products WHERE deleted IS NULL";

   $query = $conn->query($sql);
   echo json_encode([
      'data' => $query->fetch_all(MYSQLI_ASSOC)
   ]);
} else if (isset($_POST['add_product'])) {

   unset($_POST['add_product']);
   $cols = "";
   $vals = "";
   // PROCESSING OF IMAGES
   $images = ["img_main", "img_top", "img_front", "img_left", "img_bottom", "img_back", "img_right"];
   foreach ($images as $image) {

      $cols .= $image . ",";
      if (isset($_FILES[$image])) {
         $file = $_FILES[$image]['name'];
         $path = pathinfo($file);
         $filename = date("YmdHis") . $path['filename']; //  this is to prevent duplication
         $ext = $path['extension'];
         $temp_name = $_FILES[$image]['tmp_name'];
         $path_filename_ext = IMAGE_PATH . $filename . "." . $ext;
         if (!file_exists($path_filename_ext))
            move_uploaded_file($temp_name, $path_filename_ext);
         $vals .= "'" . $filename . "." . $ext . "',";
      } else {
         $vals .= "NULL,";
      }
   }

   foreach ($_POST as $key => $value) {
      if (!in_array($key, $images)) {
         $cols .= $key . ",";
         $vals .= clean_data($value) . ","; //"'".$conn->real_escape_string($col_item->value)."',";
      }
   }

   if (isset($_POST['product_prepared_by_sig'])) {
      $cols .= "product_prepared_by_name,product_prepared_by_position,date_product_prepared";
      $vals .= SESSION_NAME . "," . SESSION_POSITION . ",CURRENT_TIMESTAMP";
   }


   // $cols = substr($cols, 0, -1);
   // $vals = substr($vals, 0, -1);
   $sql = "INSERT INTO $tbl_products($cols) VALUES($vals)";
   if ($conn->query($sql) === TRUE) {
      echo json_encode(success("Successfully Added Product"));
   } else {
      echo json_encode(error($sql));
   }
} else if (isset($_POST['update_product'])) {

   unset($_POST['update_product']);
   $set_items = "";
   $id = $_POST['id'];
   unset($_POST['id']);
   // $cols = ""; $vals="";
   // PROCESSING OF IMAGES
   $images = ["img_main", "img_top", "img_front", "img_left", "img_bottom", "img_back", "img_right"];
   foreach ($images as $image) {

      // $cols .= $image.",";
      if (isset($_FILES[$image])) {
         $file = $_FILES[$image]['name'];
         $path = pathinfo($file);
         $filename = date("YmdHis") . $path['filename']; //  this is to prevent duplication
         $ext = $path['extension'];
         $temp_name = $_FILES[$image]['tmp_name'];
         $path_filename_ext = IMAGE_PATH . $filename . "." . $ext;
         if (!file_exists($path_filename_ext))
            move_uploaded_file($temp_name, $path_filename_ext);
         // $vals  .= "'".$filename.".".$ext."',";
         $set_items .= $image . "='" . $filename . "." . $ext . "',";
      } else {
         $set_items .= $image . "=NULL,";
         // $vals  .= "NULL,";
      }
   }

   foreach ($_POST as $key => $value) {
      if (!in_array($key, $images)) {

         $set_items .= $key . "=" . clean_data($value) . ",";
         // $cols .= $key.",";
         // $vals .= clean_data($value).","; //"'".$conn->real_escape_string($col_item->value)."',";
      }
   }

   if (isset($_POST['product_reviewed_by_sig'])) {
      $set_items .= "product_reviewed_by_name=" . SESSION_NAME . ",";
      $set_items .= "product_reviewed_by_position=" . SESSION_POSITION . ",";
      $set_items .= "date_product_reviewed=CURRENT_TIMESTAMP,";
   }


   if (isset($_POST['product_verified_by_sig'])) {
      $set_items .= "product_verified_by_name=" . SESSION_NAME . ",";
      $set_items .= "product_verified_by_position=" . SESSION_POSITION . ",";
      $set_items .= "date_product_verified=CURRENT_TIMESTAMP,";
   }

   // $cols = substr($cols,0, -1);
   // $vals = substr($vals,0, -1);
   $set_items = substr($set_items, 0, -1);
   $sql = "UPDATE $tbl_products SET $set_items WHERE id=$id";
   if ($conn->query($sql) === TRUE) {
      echo json_encode(success("Successfully Updated Product"));
   } else {
      echo json_encode(error($sql));
   }
} else if (isset($_POST['delete_product'])) {

   $id = $_POST['id'];
   $sql = "UPDATE $tbl_products SET deleted=1 WHERE id=$id";
   if ($conn->query($sql) === TRUE) {
      echo json_encode(success("Successfully Deleted Product"));
   } else {
      echo json_encode(error("Error in Deleting Product"));
   }
} else if (isset($_POST['update_information'])) {

   $id = $_POST['id'];
   $ingredients = clean_data($_POST['ingredients']);
   $packagings = clean_data($_POST['packagings']);

   $sql = "UPDATE $tbl_products SET ingredients=$ingredients,packagings=$packagings,";
   if (isset($_POST['info_prepared_by_sig'])) {
      $sql .= "info_prepared_by_sig=" . clean_data($_POST['info_prepared_by_sig']) . ",";
      $sql .= "info_prepared_by_name=" . SESSION_NAME . ",";
      $sql .= "info_prepared_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_info_prepared=CURRENT_TIMESTAMP";
   } else if (isset($_POST['info_reviewed_by_sig'])) {
      $sql .= "info_reviewed_by_sig=" . clean_data($_POST['info_reviewed_by_sig']) . ",";
      $sql .= "info_reviewed_by_name=" . SESSION_NAME . ",";
      $sql .= "info_reviewed_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_info_reviewed=CURRENT_TIMESTAMP";
   } else if (isset($_POST['info_verified_by_sig'])) {
      $sql .= "info_verified_by_sig=" . clean_data($_POST['info_verified_by_sig']) . ",";
      $sql .= "info_verified_by_name=" . SESSION_NAME . ",";
      $sql .= "info_verified_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_info_verified=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_prepared_by_sig'])) {
      $sql .= "process_prepared_by_sig=" . clean_data($_POST['process_prepared_by_sig']) . ",";
      $sql .= "process_prepared_by_name=" . SESSION_NAME . ",";
      $sql .= "process_prepared_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_prepared=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_reviewed_by_sig'])) {
      $sql .= "process_reviewed_by_sig=" . clean_data($_POST['info_reviewed_by_sig']) . ",";
      $sql .= "process_reviewed_by_name=" . SESSION_NAME . ",";
      $sql .= "process_reviewed_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_reviewed=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_verified_by_sig'])) {
      $sql .= "process_verified_by_sig=" . clean_data($_POST['info_verified_by_sig']) . ",";
      $sql .= "process_verified_by_name=" . SESSION_NAME . ",";
      $sql .= "process_verified_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_verified=CURRENT_TIMESTAMP";
   } else {
      $sql = substr($sql, 0, -1);
   }
   $sql .= " WHERE id=$id";

   // $sql = "UPDATE $tbl_products SET ingredients=$ingredients,packagings=$packagings WHERE id=$id";
   if ($conn->query($sql) === TRUE) {
      echo json_encode(success("Successfully Updated Information"));
   } else {
      echo json_encode(error("Error in Updating Information"));
   }
} else if (isset($_POST['update_process'])) {

   $id = $_POST['id'];
   $processes = clean_data($_POST['processes']);

   $sql = "UPDATE $tbl_products SET processes=$processes,";
   if (isset($_POST['process_prepared_by_sig'])) {
      $sql .= "process_prepared_by_sig=" . clean_data($_POST['process_prepared_by_sig']) . ",";
      $sql .= "process_prepared_by_name=" . SESSION_NAME . ",";
      $sql .= "process_prepared_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_prepared=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_reviewed_by_sig'])) {
      $sql .= "process_reviewed_by_sig=" . clean_data($_POST['process_reviewed_by_sig']) . ",";
      $sql .= "process_reviewed_by_name=" . SESSION_NAME . ",";
      $sql .= "process_reviewed_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_reviewed=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_verified_by_sig'])) {
      $sql .= "process_verified_by_sig=" . clean_data($_POST['process_verified_by_sig']) . ",";
      $sql .= "process_verified_by_name=" . SESSION_NAME . ",";
      $sql .= "process_verified_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_verified=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_prepared_by_sig'])) {
      $sql .= "process_prepared_by_sig=" . clean_data($_POST['process_prepared_by_sig']) . ",";
      $sql .= "process_prepared_by_name=" . SESSION_NAME . ",";
      $sql .= "process_prepared_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_prepared=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_reviewed_by_sig'])) {
      $sql .= "process_reviewed_by_sig=" . clean_data($_POST['process_reviewed_by_sig']) . ",";
      $sql .= "process_reviewed_by_name=" . SESSION_NAME . ",";
      $sql .= "process_reviewed_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_reviewed=CURRENT_TIMESTAMP";
   } else if (isset($_POST['process_verified_by_sig'])) {
      $sql .= "process_verified_by_sig=" . clean_data($_POST['process_verified_by_sig']) . ",";
      $sql .= "process_verified_by_name=" . SESSION_NAME . ",";
      $sql .= "process_verified_by_position=" . SESSION_POSITION . ",";
      $sql .= "date_process_verified=CURRENT_TIMESTAMP";
   } else {
      $sql = substr($sql, 0, -1);
   }
   $sql .= " WHERE id=$id";

   if ($conn->query($sql) === TRUE) {
      echo json_encode(success("Successfully Updated Processes"));
   } else {
      echo json_encode(error("Error in Updating Processes"));
   }
} else if (isset($_POST['get_product_info'])) {

   $id = $_POST['id'];

   $sql = "SELECT * FROM $tbl_products WHERE id=$id";
   $query = $conn->query($sql);
   echo json_encode($query->fetch_all(MYSQLI_ASSOC)[0]);
}

function success($message)
{
   $result = [];
   $result['type'] = 'success';
   $result['message'] = $message;
   return $result;
}
function error($message)
{
   $result = [];
   $result['type'] = 'error';
   $result['message'] = $message;
   return $result;
}
function with_duplicate($sql)
{

   global $conn;
   $query = $conn->query($sql);
   return $query->num_rows > 0;
}
function clean_data($data)
{
   global $conn;
   if ($data == "" || $data == null) {
      return 'NULL';
   }
   return "'" . $conn->real_escape_string($data) . "'";
}
