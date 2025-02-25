<?php
include_once 'database.php';

/**
 * BASE QUERY
 * INSERT INTO `tbl_inventory_management_stocks` (`id`, `user_id`, `sku_number`, `product_code`, `product_name`, `description`, `quantity`, `unit_type`, `cost_per_unit`, `expanded_quantity`, `cost_per_item`, `selling_price`, `category`, `image`, `supplier_id`, `supplier_name`, `status`, `inserted_at`, `updated_at`) VALUES ('0', '0', '0', '0', '0', '0', '0', '[\"Wholesale\",\"Per Item\"]', '0', '0', '0', '0', '0', '0', '0', '0', '[\"Removed\",\"In stock\",\"Out of stock\",\"Discontinued\"]', current_timestamp(), NULL);
 */

// default user_id 
// $user_id = 1;
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

if($_SERVER['REQUEST_METHOD'] != 'POST' && (isset($_GET['method']) && $_GET['method'] != 'fetchProductsByUser'))
  die("404 | Page not found");

$method = isset($_POST['method']) ? $_POST['method'] : false;

if(isset($_GET['method']) && $_GET['method'] == 'fetchProductsByUser')
  $method = 'fetchProductsByUser';

if($method && function_exists($method)) 
  call_user_func($method);

// add new product
function addNewProduct() {
  global $conn, $user_id;

  $filename = "";
  $fileRequirementsData = array();
  
  if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] != 0) {
    $filename = uniqid() . time() . "_{$_POST['sku_number']}" . '.' . pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
  }

  $emptyIndices = isset($_FILES['fileRequirementFile']) 
                    ? FileRequirementsEmptyIndices($_FILES['fileRequirementFile'], $_POST['fileRequirementName'])
                    : [];
  
  // preparing filenames to save to database
  if(isset($_FILES['fileRequirementFile']) && isset($_POST['fileRequirementName'])) {
    foreach($_POST['fileRequirementName'] as $key => $value) {
      if(in_array($key, $emptyIndices))
        continue;

      $fileRequirementsData[] = array(
        $value,
        $_FILES['fileRequirementFile']['size'][$key] > 0 
          ? time() . uniqid() . "." . pathinfo($_FILES['fileRequirementFile']['name'][$key], PATHINFO_EXTENSION)
          : ""
      );
    }
  }

  $values = array(
    $user_id,
    $_POST['sku_number'],
    $_POST['material_name'],
    mysqli_real_escape_string($conn, $_POST['description']),
    $_POST['category'],
    $_POST['manufacturer'],
    $_POST['country'],
    $_POST['packaging_material'],
    $_POST['unit_measure'],
    $_POST['preparation'],
    1,
    $filename,
    json_encode($fileRequirementsData)
  );

  $stmt = $conn->prepare("INSERT INTO `tbl_inventory_management_materials`
    (`user_id`, `stockkeeping_unit`, `name`, `description`, `category`, `manufacturer`, `country_of_origin`, `packaging_material`, `unit_of_measure`, `preparation`, `status`, `image`, `files_requirements`)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param('issssssssssss', ...$values);

  if($stmt->execute()) {
    if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] != 0) {
      move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/material_img/$filename");
    }

    $frdCounter = 0;
    // moving files
    if(isset($_FILES['fileRequirementFile']) && isset($_POST['fileRequirementName'])) {
      foreach($_POST['fileRequirementName'] as $key => $value) {
        if(in_array($key, $emptyIndices))
          continue;
        move_uploaded_file($_FILES['fileRequirementFile']['tmp_name'][$key], "uploads/file_requirements/{$fileRequirementsData[$frdCounter++][1]}");
      }
    }
    
    echo json_encode([ 
      'success' => true, 
      'insert_id' => $conn->insert_id,
      'message' => 'Saved successfully!'
    ]);
  }
  else {
    echo json_encode([ 'error' => true, 'message' => 'Error saving data' ]);
  }

  $stmt->close();
  $conn->close();
}

function FileRequirementsEmptyIndices($fileArr, $fileNameArr) {
  $emptyIndices = array();

  foreach($fileArr['size'] as $ind => $fsize) {
    if($fsize == 0 && $fileNameArr[$ind] == "") {
      $emptyIndices[] = $ind;
    }
  }

  return $emptyIndices;
}

// add new category
function addNewCategory() {
  global $conn, $user_id;

  $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

  $values = array(
    $user_id,
    $category_name,
  );

  $existing = $conn->query("SELECT * FROM tbl_inventory_management_categories WHERE category_name = '$category_name' AND user_id = $user_id");
  if(mysqli_num_rows($existing) > 0) {
    echo json_encode([ 
      'error' => 0,
      'message' => 'Category name already exists!'
    ]);

    $conn->close();
    return;
  }

  $stmt = $conn->prepare("INSERT INTO `tbl_inventory_management_categories`
    (user_id,category_name) VALUES(?,?)");
  $stmt->bind_param('is', ...$values);

  if($stmt->execute()) {
    echo json_encode([ 
      'success' => true, 
      'message' => $category_name . " has been added as new category",
      'insert_id' => $conn->insert_id 
    ]);
  }
  else {
    echo json_encode([ 'error' => true, 'message' => 'Error saving data' ]);
  }

  $stmt->close();
  $conn->close();
}

// fetch single category
function fetchCategoryById() {
  global $conn;

  $id = mysqli_real_escape_string($conn, $_POST['id']);

  $result = $conn->query("SELECT * FROM tbl_inventory_management_categories WHERE id = $id");

  if(mysqli_num_rows($result) > 0) {
    echo json_encode($result->fetch_assoc());
  }
  else {
    echo json_encode([]);
  }

  $conn->close();
}

// update single category
function updateCategoryById() {
  global $conn;

  $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
  $id = mysqli_real_escape_string($conn, $_POST['id']);

  $values = array(
    $category_name,
    $id
  );

  $stmt = $conn->prepare("UPDATE `tbl_inventory_management_categories`
    SET category_name=? WHERE id = ?");
  $stmt->bind_param('si', ...$values);

  if($stmt->execute()) {
    echo json_encode([ 
      'success' => true, 
      'message' => "Category has been updated successfully!"
    ]);
  }
  else {
    echo json_encode([ 'error' => true, 'message' => 'Error saving data' ]);
  }

  $stmt->close();
  $conn->close();
}

// remove category
function removeCategoryById() {
  global $conn;

  $id = mysqli_real_escape_string($conn, $_POST['id']);

  if($conn->query("UPDATE tbl_inventory_management_categories SET status = 0 WHERE id = $id")) {
    echo json_encode([
      "success" => true,
      "message" => "Category removed successfully!"
    ]);
  }
  else {
    echo json_encode([
      "success" => false,
      "message" => "Unable to complete task"
    ]);
  }

  $conn->close();
}

// fetch single product
function fetchProductById() {
  global $conn, $user_id;

  $id = mysqli_real_escape_string($conn, $_POST['id']);

  $product = $conn->query("SELECT * FROM tbl_inventory_management_stocks 
    WHERE id = $id AND user_id = $user_id AND (status <> '0' OR status is NULL);");

  if(mysqli_num_rows($product) > 0) {
    echo json_encode([
      "success" => true,
      "product" => $product->fetch_assoc()
    ]);
  } else {
    echo json_encode([
      "success" => false,
      "message" => "Product not found!"
    ]);
  }

  $conn->close();
}

// remove product
function removeProductById() {
  global $conn;

  $id = mysqli_real_escape_string($conn, $_POST['id']);

  if($conn->query("UPDATE tbl_inventory_management_materials SET status = '0' WHERE id = $id")) {
    echo json_encode([
      "success" => true,
      "message" => "Product has been removed successfully!"
    ]);
  } else {
    echo json_encode([
      "success" => false,
      "message" => "Unable to complete request"
    ]);
  }

  $conn->close();
}

// update product
function updateProduct() {
  global $conn;

  $values = array(
    $_POST['sku_number'],
    $_POST['material_name'],
    mysqli_real_escape_string($conn, $_POST['description']),
    $_POST['category'],
    $_POST['manufacturer'],
    $_POST['country'],
    $_POST['packaging_material'],
    $_POST['unit_measure'],
    $_POST['preparation'],
    $_POST['id']
  );

  $stmt = $conn->prepare("UPDATE `tbl_inventory_management_materials` SET `stockkeeping_unit`=?, `name`=?, `description`=?, `category`=?, `manufacturer`=?, `country_of_origin`=?, `packaging_material`=?, `unit_of_measure`=?, `preparation`=?
      WHERE id = ?");
  $stmt->bind_param('sssisssssi', ...$values);

  if($stmt->execute()) {
    // if new image is uploaded
    if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] != 0) {
      $filename = uniqid() . time() . "_{$_POST['sku_number']}" . '.' . pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
      
      $existing_image = $conn->query("SELECT image FROM tbl_inventory_management_materials WHERE id = {$_POST['id']}");
      
      if($conn->query("UPDATE `tbl_inventory_management_materials` SET image = '$filename' WHERE id = {$_POST['id']}")) {

        // to delete the last image file from the folder
        if(mysqli_num_rows($existing_image) > 0)
          unlink("uploads/material_img/" . $existing_image->fetch_assoc()['image']);

        // save uploaded file
        move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/material_img/$filename");
      }
    }
    
    echo json_encode([ 
      'success' => true,
      'message' => 'updated successfully!'  
    ]);
  }
  else {
    echo json_encode([ 'error' => true, 'message' => 'Error saving data' ]);
  }

  $stmt->close();
  $conn->close();
}

// fetch products of user
function fetchProductsByUser() {
  global $conn, $user_id;
  
  $results = $conn->query("SELECT * FROM `tbl_inventory_management_items` WHERE user_id = $user_id AND status <> 0");
    
  $data = array();
  
  if(mysqli_num_rows($results) > 0) {
    while($row = $results->fetch_assoc()) {
      $data[] = $row;
    }
  }

  echo json_encode($data);

  $conn->close();
}

// purchasing stocks
function addNewPurchase() {
  global $conn, $user_id;

  $values = array(
    $_POST['product_id'],
    $user_id,
    $_POST['purchase_date'],
    $_POST['package_quantity'],
    $_POST['qty_per_packet'],
    $_POST['cost_per_pack'],
    $_POST['total_cost'],
    $_POST['delivery_methods'],
    $_POST['mfg_date'],
    $_POST['expiry_date'],
  );

  $stmt = $conn->prepare("INSERT INTO `tbl_inventory_management_purchases` (`material_id`, `user_id`, `order_date`, `package_quantity`, `qty_per_packet`, `cost_per_pack`, `total_cost`, `delivery_methods`, `mfg_date`, `expiry_date`)
    VALUES (?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("iisiiddsss", ...$values);

  $response = array(
    'success' => false,
    'message' => 'Unable to perform this action'  
  );

  if($stmt->execute()) {
    $currentQuantity = $conn->query("SELECT stocks FROM `tbl_inventory_management_materials` WHERE id = {$_POST['product_id']}")->fetch_assoc()['stocks'];
    $currentQuantity += ($_POST['package_quantity'] * $_POST['qty_per_packet']); // add quantity (by piece)

    if($conn->query("UPDATE tbl_inventory_management_materials SET stocks = $currentQuantity WHERE id = {$_POST['product_id']}")) {
      $response = array(
        'success' => true, 
        'message' => 'Transaction completed!'  
      );
    }
  }

  echo json_encode($response);

  $stmt->close();
  $conn->close();
}

function getSuppliersByProductId() {
  global $conn;

  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

  $results = $conn->query("SELECT supplier,COUNT(*) as frequency FROM tbl_inventory_management_purchases WHERE product_id = $product_id GROUP BY supplier ORDER BY purchase_date DESC;");

  $data = array();

  if(mysqli_num_rows($results) > 0) {
    while($row = $results->fetch_assoc()) {
      $data[] =  $row;
    }
  }

  echo json_encode($data);

  $conn->close();
}

function fetchProductsFullInfo() {
  global $conn, $user_id;
  
  $results = $conn->query("SELECT * FROM `tbl_inventory_management_materials` WHERE user_id = $user_id AND status <> 0");
    
  $data = array();
  
  if(mysqli_num_rows($results) > 0) {
    while($row = $results->fetch_assoc()) {
      $product_id = $row['id'];

      // setup purchases
      // $pData = $conn->query("SELECT SUM(quantity) as total_quantity, SUM(pack_size * quantity) as total_expanded 
      //   FROM tbl_inventory_management_purchases WHERE product_id = $product_id GROUP BY product_id");

      // if(mysqli_num_rows($pData) > 0) {
      //   $pData = $pData->fetch_assoc();
        
      //   $row['total_quantity'] = $pData['total_quantity'];
      //   $row['total_expanded'] = $pData['total_expanded'];
      // }

      // $cprice = $conn->query("SELECT price_per_piece as current_price FROM tbl_inventory_management_sales 
      //   WHERE product_id = $product_id ORDER BY inserted_at DESC LIMIT 1");

      // if(mysqli_num_rows($cprice) > 0) {
      //   $row['current_price'] = $cprice->fetch_assoc()['current_price'];
      // }
      
      // $tCost = $conn->query("SELECT SUM(quantity * cost_per_pack) as total_cost FROM tbl_inventory_management_purchases 
      //   WHERE product_id = $product_id GROUP BY product_id");
      
      // if(mysqli_num_rows($tCost) > 0) {
      //   $row['total_cost'] = $tCost->fetch_assoc()['total_cost'];
      // }
      
      // $row['estimated_value'] = (isset($row['current_price']) ? $row['current_price'] : 0) * $row['stocks_on_hand'];

      // // get sales
      // $tSalesQ = $conn->query("SELECT SUM(quantity) as total_sales_quantity FROM tbl_inventory_management_sales 
      //   WHERE product_id = $product_id GROUP BY product_id");
      
      // if(mysqli_num_rows($tSalesQ) > 0) {
      //   $row['total_sales_quantity'] = $tSalesQ->fetch_assoc()['total_sales_quantity'];
      // }

      // $tSales = $conn->query("SELECT SUM(sale_price) as total_sales FROM tbl_inventory_management_sales 
      //   WHERE product_id = $product_id GROUP BY product_id");
      
      // if(mysqli_num_rows($tSales) > 0) {
      //   $row['total_sales'] = $tSales->fetch_assoc()['total_sales'];
      // }

      $data[] = $row;
    }
  }

  echo json_encode($data);

  $conn->close();
}
