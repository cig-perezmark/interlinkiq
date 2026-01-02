<?php
	error_reporting(E_ALL);
   include_once 'database_iiq.php';
   
   // TABLE NAMES
   $tbl_inventory_comments             = "temp_inventory_comments";
   $tbl_inventory_materials_inventory  = "temp_inventory_materials_inventory";
   $tbl_inventory_warehouse_receiving  = "temp_inventory_warehouse_receiving";
   $tbl_inventory_purchase_orders      = "temp_inventory_purchase_orders";
   $tbl_inventory_purchase_order_items = "temp_inventory_purchase_order_items";
   $tbl_inventory_stock_transfers      = "temp_inventory_stock_transfers";
   $tbl_inventory_stock_card           = "temp_inventory_stock_card";
   $tbl_inventory_stock_transfers_sources      = "temp_inventory_stock_transfers_sources";
   $tbl_inventory_warehouse_receiving_checklist = "temp_inventory_warehouse_receiving_checklist";
   
   // FOR INTEGRATION
   $tbl_inventory_locations = "temp_inventory_locations";
   $col_location_id         = "id";
   $col_location_location   = "location";

   $tbl_raw_materials              = "temp_raw_materials"; // SUPPLIER
   $col_raw_material_id            = "id";
   $col_raw_material_supplier_id   = "supplier_id";
   $col_raw_material_raw_materials = "raw_materials";
   $col_raw_material_sku           = "sku";
   $col_raw_material_category      = "category";
   $col_raw_material_price_per_unit = "price_per_unit";
   $col_raw_material_uom           = "uom";

   $tbl_suppliers = "temp_suppliers";     // RAW MATERIALS
   $col_suppliers_id = "id";
   $col_supplier_name = "supplier_name";

   // SEE FUNCTIONS BELOW THE CONDITIONALS

	if(isset($_POST['get_purchase_data'])){

      $status = $_POST['status'];
      $where = "AND a.status='$status'";
      if($status == "all"){
         $where = "";
      }
      $sql  = "SELECT a.*,a.id AS po_id,facility_category as location,name as supplier_name,1 AS comment_type FROM $tbl_inventory_purchase_orders a LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id LEFT JOIN tbl_supplier c ON a.supplier_id=c.ID WHERE deleted='0' $where ORDER BY date_added DESC";
       
      if($status=="received"){
         $sql = "SELECT a.*, b.*,facility_category as location,name as supplier_name,1 AS comment_type FROM $tbl_inventory_purchase_orders a LEFT JOIN $tbl_inventory_warehouse_receiving b ON a.id=b.po_id LEFT JOIN tblFacilityDetails c ON a.location_id=c.facility_id LEFT JOIN tbl_supplier d ON a.supplier_id=d.ID WHERE deleted='0' AND a.status='$status' ORDER BY date_added DESC";
      }

      $query = $conn->query($sql);
      echo json_encode([
         'data' => $query->fetch_all(MYSQLI_ASSOC)
      ]);
      
   }else if(isset($_POST['get_suppliers_locations'])){

      $results = [];
      $results['suppliers'] = get_suppliers();
      $user = "SELECT employee_id FROM tbl_user WHERE ID = {$_COOKIE['ID']}";
        $result = $conn->query($user);
        
        if ($result) {
            $row = $result->fetch_assoc();
            $employeeid = $row['employee_id'];
        
            $employee = "SELECT user_id FROM tbl_hr_employee WHERE ID = {$employeeid}";
            $result2 = $conn->query($employee);
        
            if ($result2) {
                $row2 = $result2->fetch_assoc();
                $entity_id = $row2['user_id'];
            }
        }
        
        if (!empty($_COOKIE['switchAccount'])) {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = $_COOKIE['switchAccount'];
    	}
    	else {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = employerID($portal_user);
    	}
        
      $results['locations'] = get_locations($user_id);
      echo json_encode($results);
   
   }else if(isset($_POST['get_items_from_supplier'])){

        $supplier_id = $_POST['supplier_id'];
        $supplier_material = "SELECT material, category FROM tbl_supplier WHERE ID = $supplier_id AND page = 1 AND status = 1 AND is_deleted = 0";
        $result = $conn->query($supplier_material);
        if ($result) {
            $row = $result->fetch_assoc();
            $material = $row['material'];
            $category_id = $row['category'];
        } else {
            echo "Error: " . $conn->error;
        }
        $category_query = "SELECT name FROM tbl_supplier_category WHERE ID = $category_id";
        $category_result = $conn->query($category_query);
        if ($category_result) {
            $category_row = $category_result->fetch_assoc();
            $name = $category_row['name'];
        } else {
            echo "Error: " . $conn->error;
        }
        
        $data =  get_raw_mats($material);
        $materials = json_decode($data, true);
      
        $response =  array(
            'materials' => $materials,
            'name'  =>  $name,
            'category_id'   => $category_id
        );
          
        echo json_encode($response);
        exit();
        
   }else if(isset($_POST['add_po'])){
    
      $po_form    = json_decode($_POST['po_form']);
      $items_form = json_decode($_POST['items_form']);

      $po_form_cols = "";
      $po_form_vals = "";
      $purchase_order = "";
      foreach($po_form as $po_item){

         $po_form_cols .= $po_item->name.",";
         $po_form_vals .= "'".$conn->real_escape_string($po_item->value)."',";

         if($po_item->name == "po"){
            $purchase_order = $conn->real_escape_string($po_item->value);
         }
      }

      $po_form_cols .= "logo";
      $po_form_vals .= "'".get_user_logo()."'";

      if(with_duplicate("SELECT * FROM $tbl_inventory_purchase_orders WHERE po='$purchase_order' AND deleted='0'")){
         echo json_encode(error("Duplicate Purchase Order Number."));
         exit();
      }

      $sql = "INSERT INTO $tbl_inventory_purchase_orders($po_form_cols) VALUES($po_form_vals)";
      
      if($conn->query($sql) === TRUE){

         $last_id = $conn->insert_id;
         foreach($items_form as $row_item){
      
            $cols = "po_id,"; $vals=$last_id.",";
            foreach($row_item as $col_item){
               $cols .= $col_item->name.",";
               $vals .= "'".$conn->real_escape_string($col_item->value)."',";
            }
            $cols = substr($cols,0, -1);
            $vals = substr($vals,0, -1);
            $sql = "INSERT INTO $tbl_inventory_purchase_order_items($cols) VALUES($vals)";
            $conn->query($sql);
         }

         // insert into warehouse receiving
         $sql = "INSERT INTO $tbl_inventory_warehouse_receiving(po_id) VALUES($last_id)";
         if($conn->query($sql) === TRUE){
            $warehouse_receiving_id = $conn->insert_id;
            // insert default cheklist items (warehouse receiving)
            $checklist_items = ['Approved Supplier/Vendor','BOL/Quantity Ordered','Certificate of Guarantee (COG)','Certificate of Analysis (COA)','Safety Data Sheets (SDS)','Kosher Ingredient Logo','Halal Ingredient Logo','Organic Ingredient Logo','Gluten Free Ingredient Logo','Certificate of Origin (COO)'];
            $item_type = 1;

            foreach($checklist_items as $item){
               $sql = "INSERT INTO $tbl_inventory_warehouse_receiving_checklist(warehouse_receiving_id,item_type,description) VALUES($warehouse_receiving_id,$item_type,'$item')";
               $conn->query($sql);
            }

            $checklist_items = ['Trailer Internal & External Damaged','Signs of Pest Activity/Vermin','Checmical Spill/Stains or smell','Signs of Odors Chemical or Spoiled','Shipment Mixed Toxic Material','Ingredients Sealed or Intact','Ingredients Record Damaged','Ingredients Quantity Received','Ingredients Proper Identification','MFG Expiry/Lot Number/Retest Date'];
            $item_type = 2;

            foreach($checklist_items as $item){
               $sql = "INSERT INTO $tbl_inventory_warehouse_receiving_checklist(warehouse_receiving_id,item_type,description) VALUES($warehouse_receiving_id,$item_type,'$item')";
               $conn->query($sql);
            }
         }
         echo json_encode(success("Successfully Added Purchase Order"));
      }else{
         echo json_encode(error($sql));
      }
   
   }else if(isset($_POST['get_po_items_details'])){

      $po_id = $_POST['po_id'];

      $sql = "SELECT * FROM $tbl_inventory_purchase_order_items WHERE po_id=$po_id";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($result);

   }else if(isset($_POST['get_warehouse_receiving_data'])){

      $sql = "SELECT * FROM (";
      $sql .= "SELECT 
                a.id AS id, 
                created_date AS order_date, 
                a.po_id AS po_id, 
                po, 
                name AS supplier_name, 
                facility_category as location, 
                expected_arrival, 
                a.remarks AS remarks, 
                b.status AS status, 
                date_received, 
                arrival_time, 
                invoice, 
                trailer_no, 
                trailer_plate, 
                trailer_seal, 
                po_received_by_sig, 
                po_received_by_name, 
                po_received_by_position, 
                date_po_received, 
                po_verified_by_sig, 
                po_verified_by_name, 
                po_verified_by_position, 
                date_po_verified, 
                supplier_inspected_by_sig, 
                supplier_inspected_by_name, 
                supplier_inspected_by_position, 
                date_supplier_inspected, 
                supplier_verified_by_sig, 
                supplier_verified_by_name, 
                supplier_verified_by_position, 
                date_supplier_verified,
                (CASE WHEN supplier_inspected_by_name IS NULL 
                    THEN 'For Inspection' WHEN (supplier_inspected_by_name IS NOT NULL AND supplier_verified_by_name IS NULL) 
                    THEN 'Inspected' WHEN supplier_verified_by_name IS NOT NULL 
                    THEN 'Completed' ELSE 'No Status' END) AS checklist_status, total_comments, 1 AS record_type, b.date_added AS date_added 
                    FROM $tbl_inventory_warehouse_receiving a 
                    LEFT JOIN $tbl_inventory_purchase_orders b ON a.po_id=b.id 
                    LEFT JOIN tbl_supplier c ON b.supplier_id=c.ID 
                    LEFT JOIN tblFacilityDetails d ON b.location_id=d.facility_id 
                    WHERE deleted='0' and b.status IN ('for_delivery','received')";
      $sql .= " UNION ";
      $sql .= "SELECT a.id, 
                transfer_date AS order_date, 
                null, stock_no AS po, 
                null, facility_category, 
                null, notes AS remarks, 
                status, null,  null,  null,  null,  null,  null,  null,  null,  null,  null,  null,  null,  null,  null, null,  null,  null,  null,  null, 
                received_by_sig,  
                received_by_name,  
                received_by_position,  
                date_received,  
                null, 
                2 AS record_type, 
                a.date_added AS date_added 
                FROM $tbl_inventory_stock_transfers a 
                LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id 
                WHERE a.deleted='0' and a.status 
                IN ('for_delivery','received')";
      $sql .= ") a ORDER BY date_added";

      $query = $conn->query($sql);
      $result = [];
      if($query->num_rows > 0){
         $result = $query->fetch_all(MYSQLI_ASSOC);
      }
      echo json_encode([
         'data' => $result
      ]);

   }else if(isset($_POST['get_warehouse_receiving_checklist_details_by_warehouse_id'])){

      $id = $_POST['id'];
      $sql = "SELECT id, item_type, description, value, IFNULL(corrective_action,'') AS corrective_action FROM $tbl_inventory_warehouse_receiving_checklist WHERE warehouse_receiving_id=$id ORDER BY id ASC";
      $query = $conn->query($sql);
      echo json_encode($query->fetch_all(MYSQLI_ASSOC)); 

   }else if(isset($_POST['get_po_order_items'])){
      $po_id = $_POST['po_id'];
      $sql = "SELECT * FROM $tbl_inventory_purchase_order_items WHERE po_id=$po_id";
      $query = $conn->query($sql);
      echo json_encode($query->fetch_all(MYSQLI_ASSOC)); 

   }else if(isset($_POST['add_entry'])){

      // $formdata               = $_POST['formdata'];
      $warehouse_receiving_id = $_POST['warehouse_receiving_id'];
      $item_type              = $_POST['item_type'];
      $description            = $_POST['description'];

      $sql = "INSERT INTO $tbl_inventory_warehouse_receiving_checklist(warehouse_receiving_id,item_type,description) VALUES($warehouse_receiving_id,$item_type,'$description')";
      if($conn->query($sql) === TRUE){
         $last_id = $conn->insert_id;
         echo json_encode(success($last_id));
         exit();
      }
      echo json_encode(error($sql));

   }else if(isset($_POST['update_po'])){
   
      // $po_form = json_decode($_POST['po_form']);
      $id      = $_POST['id'];
      $expected_arrival = $_POST['expected_arrival'];
      $remarks = $_POST['remarks'];

      $where = "expected_arrival='$expected_arrival',";
      if(trim($remarks)!=""){
         $where .= "remarks='".$conn->real_escape_string($remarks)."'";
      }

      $sql = "UPDATE $tbl_inventory_purchase_orders SET $where WHERE id=$id";
      if($conn->query($sql) === TRUE){
         echo json_encode(success("Successfully Updated Purchase Order"));
         exit();
      }
      echo json_encode(error("Error Updating Purchase Order"));
   
   }else if(isset($_POST['update_status'])){

      $id = $_POST['id'];
      $status = $_POST['status'];
      $prefix = $_POST['prefix'];
      $signature_value = $_POST['signature_value'];
      $name_value = $_POST['name_value'];
      $position_value = $_POST['position_value'];

      $sig_column = $prefix."_sig";
      $name_column = $prefix."_name";
      $position_column = $prefix."_position";
      $date = "date_".substr($prefix, 0, -3);;

      $sql = "UPDATE $tbl_inventory_purchase_orders SET status='$status', $sig_column='$signature_value', $name_column='$name_value', $position_column='$position_value', $date=CURRENT_TIMESTAMP WHERE id=$id";
      if($conn->query($sql) == false){
         echo json_encode(error("Error updating PO"));
         exit();
      }
      
      if($status == "for_delivery"){

        //  $sql = "INSERT INTO $tbl_inventory_materials_inventory(po_id,raw_material_id, category_id, incoming,price_per_unit,total_amount,location_id) SELECT po_id,raw_material_id,a.quantity,price_per_unit,a.total_price,location_id, category_id $tbl_inventory_purchase_order_items a LEFT JOIN $tbl_inventory_purchase_orders b ON a.po_id=b.id WHERE po_id=$id ON DUPLICATE KEY UPDATE incoming=IFNULL(incoming,0)+a.quantity";
        //  $sql = "INSERT INTO $tbl_inventory_materials_inventory(
        //          po_id,
        //          raw_material_id,
        //          category,
        //          incoming,
        //          price_per_unit,
        //          total_amount,
        //          location_id) 
        //      SELECT po_id,raw_material_id,a.quantity,price_per_unit,a.total_price,location_id $tbl_inventory_purchase_order_items a 
        //      LEFT JOIN $tbl_inventory_purchase_orders b 
        //      ON a.po_id=b.id 
        //      WHERE po_id=$id 
        //      ON DUPLICATE KEY UPDATE incoming=IFNULL(incoming,0)+a.quantity";
             
         $sql = "INSERT INTO temp_inventory_materials_inventory (
                    po_id,
                    raw_material_id, 
                    incoming,
                    price_per_unit,
                    total_amount,
                    location_id,
                    category_id
                ) 
                SELECT a.po_id,
                       a.raw_material_id,
                       a.quantity,
                       a.price_per_unit,
                       a.total_price,
                       b.location_id ,
                       b.category_id
                FROM temp_inventory_purchase_order_items a 
                LEFT JOIN temp_inventory_purchase_orders b 
                ON a.po_id = b.id 
                WHERE a.po_id = $id
                ON DUPLICATE KEY UPDATE incoming = IFNULL(incoming, 0) + VALUES(incoming)
                ";
         if($conn->query($sql) == false){
            echo json_encode(error("Error updating Materials Inventory"));
            exit();
         }
      }      
      echo json_encode(success("Successfully Set Status of PO"));
   
   }else if(isset($_POST['get_po_print_details'])){
   
      $results = [];
      $id = $_POST['id'];
      $sql = "SELECT a.*, DATE_FORMAT(date_drafted, '%M %e, %Y') AS date_prepared, DATE_FORMAT(date_approved, '%M %e, %Y') AS date_approved, po_received_by_sig, po_received_by_name, po_received_by_position, DATE_FORMAT(date_po_received, '%M %e, %Y') AS date_received,(CASE a.status WHEN 'received' THEN 3 WHEN 'for_delivery' THEN 2 WHEN 'for_approval' THEN 1 ELSE 0 END) AS sig_num, c.facility_category AS location,name AS supplier_name FROM temp_inventory_purchase_orders a LEFT JOIN temp_inventory_warehouse_receiving b ON a.id=b.po_id LEFT JOIN tblFacilityDetails c ON a.location_id=c.facility_id LEFT JOIN tbl_supplier d ON a.supplier_id=d.ID WHERE a.id=$id";
      $query = $conn->query($sql);
      $results['po_data'] = $query->fetch_object();

      $sql = "SELECT * FROM $tbl_inventory_purchase_order_items WHERE po_id=$id";
      $query = $conn->query($sql);
      $results['po_items_data'] = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($results);

   
   }else if(isset($_POST['delete_po'])){

      $id = $_POST['id'];
      $sql = "UPDATE $tbl_inventory_purchase_orders SET deleted='1' WHERE id=$id";
      if($conn->query($sql) === TRUE){
         echo json_encode(success("Successfully Deleted PO"));
         exit();
      }
      echo json_encode(error("Error Deleting PO"));

   }else if(isset($_POST['whouse_po_save'])){

      $form_items  = json_decode($_POST['form_items']);
      $table_items = json_decode($_POST['table_items']);

      $sql = "UPDATE $tbl_inventory_warehouse_receiving SET ";
      $id = ""; $po_id = "";
      foreach($form_items as $item){
         if($item->name == "id"){
            $id = $item->value;
            continue;
         }else if($item->name == "po_id"){
            $po_id = $item->value;
            continue;
         } 
         $form_cols = $item->name;// corrdate problem
         $form_vals = "'".$conn->real_escape_string($item->value)."',";
         $sql .= $form_cols."=".$form_vals;
      }
      $sql .= "date_po_received=CURRENT_TIMESTAMP";
      $sql .= " WHERE id=$id";
      if($conn->query($sql) === FAlSE){
         echo json_encode(error("Error1 Saving PO Form Details"));
         exit();
      }
      
      foreach($table_items as $item){

         if(!isset($item->value)){
            continue;
         }

         $id    = $item->name;
         $value = $item->value;
         $sql = "UPDATE $tbl_inventory_purchase_order_items SET quantity_received=$value WHERE id=$id";
         if($conn->query($sql) === FALSE){
            echo json_encode(error("Error2 Saving PO Form details"));
            exit();
         }
      }

      $sql = "UPDATE $tbl_inventory_purchase_orders SET status='received' WHERE id=$po_id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error3 Saving PO Form details"));
         exit();
      }

      $sql = "UPDATE $tbl_inventory_materials_inventory a INNER JOIN $tbl_inventory_purchase_order_items b ON a.raw_material_id=b.raw_material_id AND a.po_id=b.po_id SET incoming=IFNULL(incoming,0)-IFNULL(b.quantity,0), a.quantity=IFNULL(a.quantity,0)+IFNULL(quantity_received,0), total_amount=((IFNULL(a.quantity,0)+IFNULL(quantity_received,0))*b.price_per_unit) WHERE b.po_id=$po_id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error4 Saving PO Form details"));
         exit();
      }

      // add to stock card
      $sql = "INSERT INTO $tbl_inventory_stock_card(raw_material_id,location_id,value,action) SELECT raw_material_id,location_id,quantity_received,3 FROM $tbl_inventory_purchase_order_items a LEFT JOIN $tbl_inventory_purchase_orders b ON a.po_id=b.id WHERE po_id=$po_id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error5 Saving PO Form details"));
         exit();
      }

      echo json_encode(success("Successfully Updated Form Details"));
      exit();

   }else if(isset($_POST['whouse_supplier_save'])){

      $formdata  = json_decode($_POST['formdata']);
      $checklist = json_decode($_POST['checklist']);
      $supplier_inspected = json_decode($_POST['supplier_inspected']);
      $supplier_verified = json_decode($_POST['supplier_verified']);

      $sql = "UPDATE $tbl_inventory_warehouse_receiving SET ";
      $id = "";
      foreach($formdata as $item){
         if($item->name == "id"){
            $id = $item->value;
            continue;
         }  // skip id attr
         $form_cols = $item->name;// corrdate problem
         $form_vals = "'".$conn->real_escape_string($item->value)."',";
         $sql .= $form_cols."=".$form_vals;
      }
      if($supplier_inspected == true){
         $sql .= "date_supplier_inspected=CURRENT_TIMESTAMP,";
      }
      if($supplier_verified == true){
         $sql .= "date_supplier_verified=CURDATE(),";      
      }
      $sql = substr($sql, 0, -1);
      $sql .= " WHERE id=$id";
      if($conn->query($sql) === FAlSE){
         echo json_encode(error("Error1 Saving Supplier Form Details"));
         exit();
      }
      
      foreach($checklist as $item){
         $id                = $item->id;
         $value             = $item->value;
         $corrective_action = "'".$conn->real_escape_string($item->corrective_action)."'";
         $sql = "UPDATE $tbl_inventory_warehouse_receiving_checklist SET value=$value,corrective_action=$corrective_action WHERE id=$id";
         if($conn->query($sql) === FALSE){
            echo json_encode(error("Error2 Saving Supplier Form Details"));
            exit();
         }
      }
      echo json_encode(success("Successfully Updated Supplier Form Details"));
      exit();

   }else if(isset($_POST['get_materials_inventory'])){

    //   $sql = "SELECT a.*,c.material_id,c.material_name,c.material_uom,facility_category as location,(IFNULL(a.quantity,0)+IFNULL(a.str_in,0)-IFNULL(a.str_out,0)) AS variance FROM $tbl_inventory_materials_inventory a LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id LEFT JOIN tbl_supplier_material c ON a.raw_material_id=c.ID WHERE deleted='0'";
      $sql = "SELECT a.*,c.material_id,d.name AS category, c.material_name AS material_name,c.material_uom,facility_category as location,(IFNULL(a.quantity,0)+IFNULL(a.str_in,0)-IFNULL(a.str_out,0)) AS variance FROM temp_inventory_materials_inventory a LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id LEFT JOIN tbl_supplier_material c ON a.raw_material_id=c.ID LEFT JOIN tbl_supplier_category d ON a.category_id=d.ID WHERE a.deleted='0'";

      $query = $conn->query($sql);
      $result = [];
      if($query->num_rows > 0){
         $result = $query->fetch_all(MYSQLI_ASSOC);
      }
      echo json_encode([
         'data' => $result
      ]);
      
   }else if(isset($_POST['update_inventory_cell'])){
      
      $id = $_POST['id'];
      $column = $_POST['column'];
      $value = $_POST['value'];

      $sql = "UPDATE $tbl_inventory_materials_inventory SET $column='$value' WHERE id=$id";
      if($conn->query($sql) === TRUE){
         echo json_encode(success("Successfully Updated Value"));
         exit();
      }
      echo json_encode(error("Error Updating Value"));

   }else if(isset($_POST['get_whouse_print_details'])){

      $result = [];
      $id = $_POST['id'];
      $sql = "SELECT a.supplier_inspected_by_sig,a.supplier_inspected_by_name,a.supplier_inspected_by_position,DATE_FORMAT(date_supplier_inspected, '%M %e, %Y') AS date_supplier_inspected,a.supplier_verified_by_sig,a.supplier_verified_by_name,a.supplier_verified_by_position,DATE_FORMAT(date_supplier_verified, '%M %e, %Y') AS date_supplier_verified,a.date_received,a.arrival_time,a.invoice,a.trailer_no,a.trailer_plate,a.trailer_seal,b.po,c.name as supplier_name,b.logo FROM temp_inventory_warehouse_receiving a LEFT JOIN temp_inventory_purchase_orders b ON a.po_id=b.id LEFT JOIN tbl_supplier c ON b.supplier_id=c.id WHERE a.id=$id";
      $query = $conn->query($sql);
      $result['main'] = $query->fetch_object();

      $sql = "SELECT a.id AS id,description,value,corrective_action FROM $tbl_inventory_warehouse_receiving_checklist a LEFT JOIN $tbl_inventory_warehouse_receiving b ON a.warehouse_receiving_id=b.id WHERE po_id=$id";

      $query = $conn->query($sql." AND item_type='1' ORDER BY a.id ASC");
      $result['table1'] = $query->fetch_all(MYSQLI_ASSOC);
      $query = $conn->query($sql." AND item_type='2' ORDER BY a.id ASC");
      $result['table2'] = $query->fetch_all(MYSQLI_ASSOC);

      echo json_encode($result);
      exit();
   }else if(isset($_POST['view_comments'])){

      $results = [];
      $po_id = $_POST['po_id'];
      $data_type = $_POST['data_type'];

      $sql = "SELECT id,comment, datetime, commenter FROM $tbl_inventory_comments WHERE po_id=$po_id AND comment_type='$data_type' AND parent_id IS NULL ORDER BY datetime ASC";
      $query = $conn->query($sql);
      $results['parents'] = $query->fetch_all(MYSQLI_ASSOC);

      $sql = "SELECT parent_id,comment, datetime, commenter FROM $tbl_inventory_comments WHERE po_id=$po_id AND comment_type='$data_type' AND parent_id IS NOT NULL ORDER BY datetime ASC";
      $query = $conn->query($sql);
      $results['replies'] = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($results);

   }else if(isset($_POST['add_comment'])){

      $comment   = $conn->real_escape_string($_POST['comment']);
      $po_id     = $_POST['po_id'];
      $parent_id = $_POST['parent_id'];
      $comment_type = $_POST['comment_type'];
      $commenter = get_commenter_name();
      $datetime  = date("Y-m-d H:i:s");

      $cols = "comment_type,po_id,comment,datetime,commenter";
      $values = "'$comment_type',$po_id,'$comment','$datetime','$commenter'";
      if($parent_id){
         $cols .= ",parent_id";
         $values .= ",$parent_id";
      }
      
      $sql = "INSERT INTO $tbl_inventory_comments($cols) VALUES($values)";
      if($conn->query($sql) === TRUE){
         
         $insert_id = $conn->insert_id;

         $table = $tbl_inventory_purchase_orders;
         if($comment_type=="str"){
            $table = $tbl_inventory_stock_transfers;
         }
         $sql = "UPDATE $table SET total_comments=total_comments+1 WHERE id=$po_id";
         if($conn->query($sql) === FALSE){
            echo json_encode('error');
            exit();
         }

         $result = [];
         $result['id'] = $insert_id;
         $result['commenter'] = $commenter;
         $result['datetime'] = $datetime;
         $result['comment'] = $comment;
         echo json_encode($result);
         exit();
      }
      echo json_encode('error');
   }else if(isset($_POST['get_stock_transfers'])){

      $transfer_type = $_POST['transfer_type'];
      $sql = "SELECT a.*,a.id AS po_id,material_name AS item_name,material_uom as uom,facility_category as location,2 AS comment_type FROM $tbl_inventory_stock_transfers a LEFT JOIN tbl_supplier_material b ON a.raw_material_id=b.ID LEFT JOIN tblFacilityDetails c ON a.location_id=c.facility_id WHERE transfer_type='$transfer_type'";
      
      $query = $conn->query($sql);
      echo json_encode([
         'data' => $query->fetch_all(MYSQLI_ASSOC)
      ]);

   }else if(isset($_POST['get_available_items'])){

      $location_id = $_POST['location_id'];
      $sql = "SELECT b.id AS id,raw_materials AS value FROM $tbl_inventory_materials_inventory a LEFT JOIN tbl_supplier_material b ON a.raw_material_id=b.id WHERE location_id != $location_id GROUP BY raw_material_id";
      echo get_rows($sql);

   }else if(isset($_POST['get_current_stock'])){

      $raw_material_id = $_POST['raw_material_id'];
      $location_id = $_POST['location_id'];
      $sql = "SELECT SUM(quantity) AS current_stock, uom FROM $tbl_inventory_materials_inventory a LEFT JOIN tbl_supplier_material b ON a.raw_material_id=b.id WHERE raw_material_id=$raw_material_id AND location_id != $location_id GROUP BY raw_material_id";
      $query = $conn->query($sql);

      $results = [];
      $results['item'] = $query->fetch_object();

      $sql = "SELECT a.id,location, quantity FROM $tbl_inventory_materials_inventory a LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id WHERE raw_material_id=$raw_material_id AND location_id != $location_id";
      $query = $conn->query($sql);
      $results['sources'] = $query->fetch_all(MYSQLI_ASSOC);
      
      echo json_encode($results);

   }else if(isset($_POST['add_stock_transfer'])){

      $formdata = json_decode($_POST['formdata']);
      $itemlist = json_decode($_POST['itemlist']);

      $cols = ""; $vals = ""; $raw_material_id = ""; $location_id = ""; $str_in_quantity = 0; 
      foreach($formdata as $item){
         if($item->name=="raw_material_id"){
            $raw_material_id = $item->value;
         }else if($item->name=="location_id"){
            $location_id = $item->value;
         }else if($item->name=="quantity"){
            $str_in_quantity = $item->value;
         }
         $cols .= $item->name.",";
         $vals .= "'".$conn->real_escape_string($item->value)."',";
      }
      $cols .= "transfer_type,status";
      $vals .= "'str_out','for_delivery'";

      $sql = "INSERT INTO $tbl_inventory_stock_transfers($cols) VALUES($vals)";
      if($conn->query($sql) === TRUE){

         $last_id = $conn->insert_id;

         foreach($itemlist as $item){

            $stock_transfer_id      = $last_id;
            $materials_inventory_id = $item->materials_inventory_id;
            $current_quantity       = $item->current_quantity;
            $quantity               = $item->quantity;

            $sql = "INSERT INTO $tbl_inventory_stock_transfers_sources(stock_transfer_id,materials_inventory_id,current_Stock,quantity) VALUES($stock_transfer_id,$materials_inventory_id,$current_quantity,$quantity)";

            if($conn->query($sql) === FALSE){
               echo json_encode(error("Error1 Adding Stock Transfer"));
               exit();
            }

            $sql = "UPDATE $tbl_inventory_materials_inventory SET quantity=(quantity-$quantity),str_out=(IFNULL(str_out,0)+$quantity) WHERE id=$materials_inventory_id";
            if($conn->query($sql) === FALSE){
               echo json_encode(error("Error2 Adding Stock Transfer"));
               exit();
            }
         }

         $sql = "UPDATE $tbl_inventory_materials_inventory SET str_in=(IFNULL(str_in,0)+$str_in_quantity),incoming=(IFNULL(incoming,0)+$str_in_quantity) WHERE raw_material_id=$raw_material_id AND location_id=$location_id";
         if($conn->query($sql) === FALSE){
            echo json_encode(error("Error3 Adding Stock Transfer"));
            exit();
         }

         echo json_encode(success("Successfully Added Stock Transfer"));
         exit();
      }
      echo json_encode(error("Error4 Adding Stock Transfer"));
      exit();

   }else if(isset($_POST['get_stock_transfer_details'])){

      $id = $_POST['id'];
      $sql = "SELECT a.*,location,raw_materials,uom FROM $tbl_inventory_stock_transfers a LEFT JOIN tblFacilityDetails b ON a.location_id=b.facility_id LEFT JOIN tbl_supplier_material c ON a.raw_material_id=c.id WHERE a.id=$id";
      $query = $conn->query($sql);

      $results = [];
      $results['details'] = $query->fetch_object();
      echo json_encode($results);

   }else if(isset($_POST['receive_stock_transfer'])){

      $form_items  = json_decode($_POST['form_items']);

      // UPDATE stock transfer set received by and date received
      $sql = "UPDATE $tbl_inventory_stock_transfers SET ";
      $id = "";
      foreach($form_items as $item){
         if($item->name == "id"){
            $id = $item->value;
            continue;
         }
         $form_cols = $item->name;
         $form_vals = "'".$conn->real_escape_string($item->value)."',";
         $sql .= $form_cols."=".$form_vals;
      }
      $sql .= "status='received', date_received=CURRENT_TIMESTAMP";
      $sql .= " WHERE id=$id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error1 Error Receiving Stock Transfer"));
         exit();
      }

      // UPDATE stock transfer out of materials inventory table
      $sql = "UPDATE $tbl_inventory_materials_inventory a LEFT JOIN $tbl_inventory_stock_transfers_sources b ON a.id=b.materials_inventory_id SET str_out=(IFNULL(str_out,0)-b.quantity) WHERE stock_transfer_id=$id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error2 Error Receiving Stock Transfer"));
         exit();
      }

      // add to stock card
      $sql = "INSERT INTO $tbl_inventory_stock_card(raw_material_id,location_id,value,action) SELECT raw_material_id,location_id,a.quantity,1 FROM $tbl_inventory_stock_transfers_sources a LEFT JOIN $tbl_inventory_materials_inventory b ON a.materials_inventory_id=b.id WHERE stock_transfer_id=$id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error4 Saving PO Form details"));
         exit();
      }

      // UPDATE stock transfer in of materials inventory table
      $sql = "UPDATE $tbl_inventory_materials_inventory a LEFT JOIN $tbl_inventory_stock_transfers b ON a.raw_material_id=b.raw_material_id AND a.location_id=b.location_id SET incoming=(IFNULL(incoming,0)-b.quantity),str_in=(IFNULL(str_in,0)-b.quantity),a.quantity=(IFNULL(a.quantity,0)+b.quantity) WHERE b.id=$id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error3 Error Receiving Stock Transfer"));
         exit();
      }

      // add to stock card
      $sql = "INSERT INTO $tbl_inventory_stock_card(raw_material_id,location_id,value,action) SELECT raw_material_id,location_id,quantity,2 FROM $tbl_inventory_stock_transfers WHERE id=$id";
      if($conn->query($sql) === FALSE){
         echo json_encode(error("Error4 Saving PO Form details"));
         exit();
      }

      echo json_encode(success("Successfully Received Stock Transfer"));
      exit();
   }else if(isset($_POST['get_stock_card_details'])){

      $raw_material_id = $_POST['raw_material_id'];
      $location_id = $_POST['location_id'];
      $start_date  = $_POST['location_id'];
      $end_date    = $_POST['location_id'];

      $sql = "SELECT *,(transfer_in+deliveries-transfer_out) AS quantity FROM (SELECT DATE_FORMAT(date,'%b-%d') AS date, SUM(IF(ACTION=1,VALUE,0)) AS transfer_out, SUM(IF(ACTION=2,VALUE,0)) AS transfer_in, SUM(IF(ACTION=3,VALUE,0)) AS deliveries FROM $tbl_inventory_stock_card
      WHERE raw_material_id=$raw_material_id AND location_id=$location_id) a";
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      echo json_encode([
         'data' => $result
      ]);
   } else if(isset($_POST['get_login_details_name'])) {
      $user_logged = get_loggedin_user();
       echo json_encode(array('user_logged' => $user_logged));
       exit();
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
      $count = $query->num_rows;

      if($count>0){
         return true;
      }
      return false;
   }

   // FOR INTEGRATION
   use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	function php_mailer($to, $user, $subject, $body) {
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		try {
		    $mail->isSMTP();
		    $mail->Host       = 'mail.prpblaster.com';
		    $mail->CharSet 	  = 'UTF-8';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'fsms@prpblaster.com';
		    $mail->Password   = 'Brandon@2020';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom('fsms@prpblaster.com', 'Interlink IQ');
		    $mail->addAddress($to, $user);

		    $mail->isHTML(true);
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		    $msg = 'Message has been sent';
		} catch (Exception $e) {
		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		return $msg;
	}

   function get_user_logo(){

      return "https://interlinkiq.com/companyDetailsFolder/133548%20-%20Fat%20and%20Weird%20Cookies%20-%20FINAL.png";
   }

   function get_locations($user_id){
      
      global $tbl_inventory_locations,$col_location_id,$col_location_location;
      $sql = "SELECT facility_id AS ID, facility_category AS value FROM tblFacilityDetails WHERE users_entities = $user_id";
      return get_rows($sql);
   }

   function get_suppliers(){

      global $tbl_suppliers,$col_suppliers_id,$col_supplier_name;
      
      if (!empty($_COOKIE['switchAccount'])) {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = $_COOKIE['switchAccount'];
    	} else {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = employerID($portal_user);
	    }
      $sql = "SELECT ID,material,name AS value FROM tbl_supplier WHERE user_id = $user_id AND page = 1 AND status = 1 AND is_deleted = 0 AND material !='' ORDER BY name ASC";
      return get_rows($sql);
   }

   function get_raw_mats($material){
      global $tbl_raw_materials;
      $sql = "SELECT * FROM tbl_supplier_material WHERE ID IN($material) ORDER BY material_name ASC";
      return get_rows($sql);
   }

   function get_commenter_name(){
      return $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
   }
   
   function get_loggedin_user(){
      return $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
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

   function get_rows($sql){
      
      global $conn;
      $query = $conn->query($sql);
      $result = $query->fetch_all(MYSQLI_ASSOC);
      return json_encode($result);
   }
?>
