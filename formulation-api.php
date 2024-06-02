<?php
    include_once "database.php";
    
    // default user_id 
    // $user_id = 1;


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
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    }
    else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    }
    
    // only accepts post data
    if($_SERVER['REQUEST_METHOD'] != 'POST')
      die("404 | Page not found");
    
    $method = isset($_POST['method']) ? call_user_func($_POST['method']) : false;
    
    function res($arr, $status = null) {
      echo json_encode($arr);
    
      if($status != null)
        http_response_code($status);
    }
    
    function getAllMaterials() {
        global $conn, $user_id;
    
        $q = $_POST['q'];
        $materials = $conn->query("SELECT ID as id,material_name,material_ppu,description,material_id FROM tbl_supplier_material WHERE user_id = $user_id AND 
        (
          ID like '%$q%' OR
          material_id like '%$q%' OR
          material_name like '%$q%' OR
          description like '%$q%'
        )
      ");
    //   $materials = $conn->query("SELECT * FROM tbl_inventory_management_materials WHERE user_id = $user_id AND 
    //     (
    //       id like '%$q%' OR
    //       stockkeeping_unit like '%$q%' OR
    //       name like '%$q%' OR
    //       manufacturer like '%$q%'
    //     )
    //   ");
    
      $data = array(
        'items' => [],
        'total_count' => mysqli_num_rows($materials)
      );
      
      if(mysqli_num_rows($materials) > 0) {
        while($row = $materials->fetch_assoc()) {
          $data['items'][] = $row;
        }
      }
    
      res($data);
    
      $conn->close();
    }
    
    function getMaterialById() {
      global $conn;
    
      $material = $conn->query("SELECT * FROM tbl_supplier_material WHERE ID = {$_POST['id']}");
      
      res($material->fetch_assoc());
      $conn->close();
    }
    
    function addNewFormula() {
      global $conn, $user_id, $portal_user;
    
      $values = array(
        $user_id,
        $portal_user,
        $_POST['formula_name'],
        $_POST['formula_code'],
        $_POST['version_number'],
        $_POST['status'],
        $_POST['status_date'],
        $_POST['serving_size'],
        $_POST['ingredients'],
        $_POST['instructions'],
      );
    
      $st = $conn->prepare("INSERT INTO tbl_formulation_formulas (user_id,portal_user,name,formula_code,version_number,status,status_date,serving_size,ingredients,instructions)
        VALUES(?,?,?,?,?,?,?,?,?,?)");
      $st->bind_param('iisssssdss', ...$values);
    
      if($st->execute()) {
        res(['success' => true]);
      } else {
        res(['success' => false], 422);
      }
    
      $conn->close();
    }
    
    function getFormulaById() {
      global $conn;
    
      $formula = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE id = {$_POST['id']}")->fetch_assoc();
    
      $formula['ingredients'] = json_decode($formula['ingredients'] ?? "[]", true);
      $formula['instructions'] = json_decode($formula['instructions'] ?? "[]", true);
    
      $materialIds = array();
      foreach($formula['ingredients'] as $i => $ing) {
        $materialIds[] = $ing['id'];
      }
        if(count($materialIds) > 0) {
          $materialIds = implode(',', $materialIds);
          $materials = $conn->query("SELECT ID,material_name,material_id FROM tbl_supplier_material WHERE ID in ($materialIds)");
        
          if(mysqli_num_rows($materials) > 0) {
            while($row = $materials->fetch_assoc()) {
              foreach($formula['ingredients'] as $i => $ing) {
                if($ing['id'] == $row['ID']) {
                  $formula['ingredients'][$i]['material'] = $row; 
                  break;
                }
              }
            }
          }
        }
      res($formula);
      $conn->close();
    }
    
    function updateFormula() {
      global $conn;
    
      $values = array(
        $_POST['formula_name'],
        $_POST['formula_code'],
        $_POST['version_number'],
        $_POST['status'],
        $_POST['status_date'],
        $_POST['serving_size'],
        $_POST['ingredients'],
        $_POST['instructions'],
        $_POST['formula_id'],
      );
    
      $st = $conn->prepare("UPDATE tbl_formulation_formulas SET name=?,formula_code=?,version_number=?,status=?,status_date=?,serving_size=?,ingredients=?,instructions=? WHERE id = ?");
      $st->bind_param('sssssdssi', ...$values);
    
      if($st->execute()) {
        res(['success' => true]);
      } else {
        res(['success' => false], 422);
      }
    
      $conn->close();
    }
    
    function deleteFormula() {
      global $conn, $user_id;
    
      if($conn->query("UPDATE tbl_formulation_formulas SET status=0 WHERE id = {$_POST['id']} AND user_id = $user_id")) {
        res(['success' => true]);
      } else {
        res(['success' => false], 422);
      }
    
      $conn->close();
}