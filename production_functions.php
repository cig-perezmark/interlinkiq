<?php
	error_reporting(E_ALL);
   include_once 'database_iiq.php';

   // AVAILABILITY 
   define("IN_STOCK","In Stock");
   define("NOT_AVAILABLE","Not Available");
   // ORDER STATUS
   define("PRODUCTION","Production");
   define("FOR_SHIPPING","For Shipping");
   define("IN_TRANSIT","In Transit");
   define("DELIVERED","Delivered");
   define("INGREDIENTS_ORDERED","Ingredients Ordered");
   define("CANCELLED","Cancelled");

   $tbl_products = "temp_products";
   $tbl_sales_order = "temp_sales_order";
   $tbl_sales_order_products = "temp_sales_order_products";
   $tbl_sales_order_products_raw_materials = "temp_sales_order_products_raw_materials";
   $tbl_sales_order_products_processes = "temp_sales_order_products_processes";
   
   if(isset($_POST['get_sales_orders'])){
   
      $order_status = $_POST['order_status'];
      $where;
      if($order_status == DELIVERED){
         $where = "order_status='".DELIVERED."'";
      }else{
         $where = "order_status !='".DELIVERED."'";
      }
      $sql = "SELECT * FROM $tbl_sales_order WHERE $where";
      // echo json_encode($sql);
      // exit();
      $query = $conn->query($sql);
      echo json_encode([
         'data' => $query->fetch_all(MYSQLI_ASSOC)
      ]);
   
   }else if(isset($_POST['get_product_selection'])){

      $sql = "SELECT * FROM $tbl_products";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($result);   
   
   }else if(isset($_POST['add_so'])){

      // so details
      $sales_order       = clean_data($_POST['sales_order']);
      $customer_name     = clean_data($_POST['customer_name']);
      $created_date      = clean_data($_POST['created_date']);
      $delivery_deadline = clean_data($_POST['delivery_deadline']);
      $remarks           = clean_data($_POST['remarks']);
      $currency          = clean_data($_POST['currency']);
      $total_amount      = clean_data($_POST['total_amount']);
      $stocks            = clean_data($_POST['stocks']);
      $approved_by_sig   = clean_data($_POST['approved_by_sig']);
      $approved_by_name  = clean_data($_POST['approved_by_name']);
      $approved_by_position = clean_data($_POST['approved_by_position']);
      // so table items
      $items_form = json_decode($_POST['items_form']);

      if(with_duplicate("SELECT * FROM $tbl_sales_order WHERE sales_order=$sales_order")){
         echo json_encode(error("Duplicate Sales Order Number"));
         exit();
      }

      // SALES ORDER
      $sql  = "INSERT INTO $tbl_sales_order(";
      $sql .= "sales_order,created_date,customer_name,total_amount,currency,delivery_deadline,stocks,order_status,order_status_date,remarks,approved_by_sig,approved_by_name,approved_by_position,date_approved";
      $sql .= ") VALUES("; 
      $sql .= "$sales_order,$created_date,$customer_name,$total_amount,$currency,$delivery_deadline,$stocks,'".PRODUCTION."',CURRENT_TIMESTAMP,$remarks,$approved_by_sig,$approved_by_name,$approved_by_position,CURRENT_TIMESTAMP";
      $sql .= ")";
      
      if($conn->query($sql) === TRUE){

         $sales_order_id = $conn->insert_id;
         foreach($items_form as $row_item){
      
            $cols = "sales_order_id,"; $vals=$sales_order_id.",";
            $product_quantity = 0;
            foreach($row_item as $col_item){
               $cols .= $col_item->name.",";
               $vals .= clean_data($col_item->value).","; //"'".$conn->real_escape_string($col_item->value)."',";
               if($col_item->name=="quantity"){
                  $product_quantity = intval($col_item->value);
               }
            }
            $cols = substr($cols,0, -1);
            $vals = substr($vals,0, -1);
            // PRODUCTS ENUMERATED IN THE SALES ORDER 
            $sql = "INSERT INTO $tbl_sales_order_products($cols) VALUES($vals)";
            if($conn->query($sql) === TRUE){

               $sales_order_products_id = $conn->insert_id;
               // $rcol = ""; $rval = "";
               $product_ids = "";
               foreach($row_item as $col_item){
                  if($col_item->name == "product_id"){
                     // $product_ids .= $col_item->value.",";
                     // $sql = "INSERT INTO $tbl_sales_order_products_raw_materials(sales_oder_product_id, raw_material_name,supplier_name,quantity,uom) SELECT $product_id,product";
                     $product_id = $col_item->value;
                     $sql = "SELECT ingredients,processes FROM $tbl_products WHERE id=$product_id";
                     $query = $conn->query($sql);
                     $product_rows = $query->fetch_all(MYSQLI_ASSOC);
                     
                     foreach($product_rows as $single_product){

                        // insert ingredients to sales_order_products_raw_materials table
                        $ingredients = json_decode($single_product['ingredients']);
                        foreach($ingredients as $ingredient){

                           $raw_material_name = clean_data($ingredient->raw_materials);
                           $supplier_name     = clean_data($ingredient->supplier_name);
                           $quantity          = $product_quantity*$ingredient->quantity;
                           $uom               = clean_data($ingredient->uom);
                           $price_per_unit    = $ingredient->price_per_unit;

                           $insert_sql = "INSERT INTO $tbl_sales_order_products_raw_materials(sales_order_products_id,raw_material_name,supplier_name,quantity,uom,price_per_unit) VALUES($sales_order_products_id,$raw_material_name,$supplier_name,$quantity,$uom,$price_per_unit)";
                           if($conn->query($insert_sql) === FALSE){
                              echo json_encode(error($insert_sql));
                              exit();
                           }
                        }

                        // insert process to sals_order_products_process table
                        $processes = json_decode($single_product['processes']);
                        foreach($processes as $process){

                           $item_order   = $process->item_order;
                           $process_step = clean_data($process->process_step);
                           $description  = clean_data($process->description);
                           $e_forms      = clean_data($process->e_forms);

                           $insert_sql = "INSERT INTO $tbl_sales_order_products_processes(sales_order_products_id,item_order,process_step,description,e_forms) VALUES($sales_order_products_id,$item_order,$process_step,$description,$e_forms)";
                           if($conn->query($insert_sql) === FALSE){
                              echo json_encode(error($insert_sql));
                              exit();
                           }

                        }
                        
                        // $ingredient        = json_decode($row_ingredient['ingredients'])[0];
                        // $raw_material_name = clean_data($ingredient->raw_materials);
                        // $supplier_name     = clean_data($ingredient->supplier_name);
                        // $quantity          = $ingredient->quantity;
                        // $uom               = clean_data($ingredient->uom);
                        // $price_per_unit    = $ingredient->price_per_unit;
                        // $insert_sql = "INSERT INTO $tbl_sales_order_products_raw_materials(sales_order_products_id,raw_material_name,supplier_name,quantity,uom,price_per_unit) VALUES($sales_order_products_id,$raw_material_name,$supplier_name,$quantity,$uom,$price_per_unit)";
                        // if($conn->query($insert_sql) === FALSE){
                        //    echo json_encode(error($insert_sql));
                        //    exit();
                        // }
                     }
                     
                     // update sales_order_products table set material_stocks = number of raw materials
                     $total_ingredients = sizeof(json_decode($single_product['ingredients']));
                     $update_product_sql = "UPDATE $tbl_sales_order_products SET material_stocks=$total_ingredients WHERE id=$sales_order_products_id";
                     if($conn->query($update_product_sql) === FALSE){
                        echo json_encode(error($update_product_sql));
                        exit();
                     }

                     // update sales_order_products table set production_status=first process_step
                     $update_product_sql = "UPDATE $tbl_sales_order_products SET production_status=1 WHERE id=$sales_order_products_id";
                     if($conn->query($update_product_sql) === FALSE){
                        echo json_encode(error($update_product_sql));
                        exit();
                     }
                  }
               }
               // $product_ids = substr($product_ids,0, -1);
               // $sql = "SELECT ingredients FROM $tbl_products WHERE id IN ($product_ids)";
               // $query = $conn->query($sql);
               // $ingredients = $query->fetch_all(MYSQLI_ASSOC);
               // foreach($ingredients as $row_ingredient){
                  
               //    $ingredient        = json_decode($row_ingredient['ingredients'])[0];
               //    $raw_material_name = clean_data($ingredient->raw_materials);
               //    $supplier_name     = clean_data($ingredient->supplier_name);
               //    $quantity          = $ingredient->quantity;
               //    $uom               = clean_data($ingredient->uom);
               //    $price_per_unit    = $ingredient->price_per_unit;
               //    $insert_sql = "INSERT INTO $tbl_sales_order_products_raw_materials(sales_order_products_id,raw_material_name,supplier_name,quantity,uom,price_per_unit) VALUES($sales_order_products_id,$raw_material_name,$supplier_name,$quantity,$uom,$price_per_unit)";
               //    if($conn->query($insert_sql) === FALSE){
               //       echo json_encode(error($insert_sql));
               //       exit();
               //    }
               // }
            }
         }
         echo json_encode(success("Successfully Added Sales Order"));
      }else{
         echo json_encode(error($sql));
      }
   }else if(isset($_POST['get_so_details'])){

      // so details
      $id = $_POST['id'];
      
      $sql = "SELECT * FROM $tbl_sales_order_products WHERE sales_order_id=$id";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($result);   

   }else if(isset($_POST['get_sales_order_products'])){
      
      $date_delivered = isset($_POST['date_delivered']);

      $sql = "SELECT a.id AS id,b.created_date AS order_date, sales_order, customer_name, a.name AS product_name, CONCAT(IFNULL(a.quantity,''),' ',IFNULL(a.uom,'')) AS quantity, b.delivery_deadline AS delivery_deadline, (CASE WHEN (date_materials_received IS NOT NULL) THEN 'Received' ELSE CONCAT('Pending=',material_stocks) END) AS material_stocks, production_status,materials_received_by_sig,materials_received_by_img,materials_received_by_name,materials_received_by_position,date_materials_received,process_completed_by_sig,process_completed_by_img,process_completed_by_name,process_completed_by_position,date_process_completed,(CASE WHEN date_process_completed IS NOT NULL THEN 'Completed' ELSE CONCAT((CASE c.status WHEN 1 THEN 'Not Yet Started' WHEN 2 THEN 'On-Going' WHEN 3 THEN 'Completed' ELSE '' END),' -- Step ',item_order,'. ',process_step) END) AS process_step ";
      $sql .= "FROM $tbl_sales_order_products a LEFT JOIN $tbl_sales_order b ON a.sales_order_id=b.id ";
      $sql .= "LEFT JOIN $tbl_sales_order_products_processes c ON a.production_status=c.id ";
      $sql .= "WHERE date_delivered IS ";
      if($date_delivered == true){
         $sql .= "NOT ";
      }
      $sql .= "NULL";
      $query = $conn->query($sql);
      // echo $sql; exit();
      echo json_encode([
         'data' => $query->fetch_all(MYSQLI_ASSOC)
      ]);
   }else if(isset($_POST['get_product_details'])){

      // so details
      $id = $_POST['id'];
      
      $sql = "SELECT * FROM $tbl_sales_order_products_raw_materials WHERE sales_order_products_id=$id";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($result);   

   }else if(isset($_POST['get_product_processes'])){

      // so details
      $id = $_POST['id'];
      
      $sql = "SELECT * FROM $tbl_sales_order_products_processes WHERE sales_order_products_id=$id";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($result);   

   }else if(isset($_POST['update_product_raw_material_stocks'])){

      $id                = clean_data($_POST['id']);
      $batch_lot_code    = clean_data($_POST['batch_lot_code']);
      $expiration_date   = clean_data($_POST['expiration_date']);
      $quantity_received = clean_data($_POST['quantity_received']);
      $status            = clean_data($_POST['status']);

      $sql = "UPDATE $tbl_sales_order_products_raw_materials SET batch_lot_code=$batch_lot_code, expiration_date=$expiration_date, quantity_received=$quantity_received, status=$status, status_date=CURRENT_TIMESTAMP WHERE id=$id";
      if($conn->query($sql) === TRUE){

         $sql = "UPDATE $tbl_sales_order_products a LEFT JOIN $tbl_sales_order_products_raw_materials b ON a.id=b.sales_order_products_id
         SET material_stocks=IF(material_stocks=1,0,material_stocks-1) WHERE b.id=$id";

         if($conn->query($sql) === TRUE){
            echo json_encode(success("Successfully updated status"));
            exit();
         }
      }
      echo json_encode(error($sql));
   }else if(isset($_POST['received_all_materials_by_product_id'])){

      $id   = clean_data($_POST['id']);
      $remarks_for_products   = clean_data($_POST['remarks_for_products']);
      $materials_received_by_sig   = clean_data($_POST['materials_received_by_sig']);
      $materials_received_by_name  = clean_data($_POST['materials_received_by_name']);
      $materials_received_by_position = clean_data($_POST['materials_received_by_position']);

      $sql = "UPDATE $tbl_sales_order_products SET materials_received_by_sig=$materials_received_by_sig, materials_received_by_name=$materials_received_by_name, materials_received_by_position=$materials_received_by_position, remarks_for_products=$remarks_for_products, date_materials_received=CURRENT_TIMESTAMP WHERE id=$id";
      if($conn->query($sql) === TRUE){
         echo json_encode(success("Successfully updated product"));
         exit();
      }
      echo json_encode(error($sql));

   }else if(isset($_POST['update_product_raw_material_steps'])){

      $id     = clean_data($_POST['id']);
      $status = clean_data($_POST['status']);

      $sql = "UPDATE $tbl_sales_order_products_processes SET status=$status, status_date=CURRENT_TIMESTAMP WHERE id=$id";
      if($conn->query($sql) === TRUE){

         $sql = "UPDATE $tbl_sales_order_products a LEFT JOIN $tbl_sales_order_products_processes b ON a.id=b.sales_order_products_id
         SET production_status=$id WHERE b.id=$id";

         if($conn->query($sql) === TRUE){
            echo json_encode(success("Successfully updated status"));
            exit();
         }
      }
      echo json_encode(error($sql));
   }else if(isset($_POST['complete_all_processes_by_product_id'])){

      $id   = clean_data($_POST['id']);
      $remarks_for_processes   = clean_data($_POST['remarks_for_processes']);
      $process_completed_by_sig   = clean_data($_POST['process_completed_by_sig']);
      $process_completed_by_name  = clean_data($_POST['process_completed_by_name']);
      $process_completed_by_position = clean_data($_POST['process_completed_by_position']);

      $sql = "UPDATE $tbl_sales_order_products SET process_completed_by_sig=$process_completed_by_sig, process_completed_by_name=$process_completed_by_name, process_completed_by_position=$process_completed_by_position, remarks_for_processes=$remarks_for_processes, date_process_completed=CURRENT_TIMESTAMP WHERE id=$id";
      if($conn->query($sql) === TRUE){
         echo json_encode(success("Successfully updated product"));
         exit();
      }
      echo json_encode(error($sql));

   }

   function success($message){
      $result = [];
      $result['type'] = 'success';
      $result['message'] = $message;
      return $result;
   }

   function error($message){
      $result = [];
      $result['type'] = 'error';
      $result['message'] = $message;
      return $result;
   }

   function with_duplicate($sql){

      global $conn;
      $query = $conn->query($sql);
      return $query->num_rows>0;
   }

   function clean_data($data){
      global $conn;
      return "'".$conn->real_escape_string($data)."'";
   }
?>