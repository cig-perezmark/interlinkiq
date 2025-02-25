<?php
include_once ('../../database_iiq.php');

// default user_id 
// $user_id = 1;

function employerID($ID) {
	global $conn;

	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID=$current_userEmployeeID" );
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

  // new query
//   $materials = $conn->query("SELECT ID as id,material_name,material_ppu,description,material_id FROM tbl_supplier_material WHERE user_id = $user_id AND 
//     (
//       ID like '%$q%' OR
//       material_id like '%$q%' OR
//       material_name like '%$q%' OR
//       description like '%$q%'
//     )
//   ");
  $materials = $conn->query("SELECT
    	m.ID AS id,
    	m.material_name AS material_name,
    	m.material_id AS material_id,
    	m.material_ppu AS material_ppu,
    	m.description AS description,
		s.name AS s_name,
		CASE
            WHEN s.status = 1 THEN 'Approved'
            WHEN s.status = 2 THEN 'Non-Approved'
            WHEN s.status = 3 THEN 'Emergency Use Only'
            WHEN s.status = 4 THEN 'Do Not Use'
            ELSE 'Pending'
        END AS s_status
    
    	FROM tbl_supplier_material AS m
    
    	INNER JOIN (
    		SELECT
    		name,
    		status,
            material,
    	    page,
            is_deleted
    	    FROM tbl_supplier
    	    WHERE page = 1 
    		AND is_deleted = 0
    	) AS s
    	ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
    
    	WHERE m.user_id = $user_id
    	AND (
            m.ID like '%$q%' OR
            m.material_id like '%$q%' OR
            m.material_name like '%$q%' OR
            m.description like '%$q%' OR
            s.name like '%$q%'
        )");

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

  $st = $conn->prepare("INSERT INTO tbl_formulation_formulas (user_id, portal_user, name,formula_code,version_number,status,status_date,serving_size,ingredients,instructions)
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
    $materials = $conn->query("SELECT ID,material_name,material_id,material_count,material_ppu,material_uom FROM tbl_supplier_material WHERE ID in ($materialIds)");

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
  global $conn, $portal_user;

  $values = array(
    $portal_user,
    $_POST['formula_name'],
    $_POST['formula_code'],
    $_POST['version_number'],
    $_POST['status'],
    $_POST['status_date'],
    $_POST['serving_size'],
    $_POST['ingredients'],
    $_POST['instructions'],
    $_POST['notes'],
    $_POST['formula_id'],
  );

  $st = $conn->prepare("UPDATE tbl_formulation_formulas SET portal_user=?,name=?,formula_code=?,version_number=?,status=?,status_date=?,serving_size=?,ingredients=?,instructions=?,notes=? WHERE id = ?");
  $st->bind_param('isssssdsssi', ...$values);

  if($st->execute()) {
    res(['success' => true]);
  } else {
    res(['success' => false], 422);
  }

  $conn->close();
}

function deleteFormula() {
  global $conn;

  if($conn->query("UPDATE tbl_formulation_formulas SET status=0 WHERE id = {$_POST['id']}")) {
    res(['success' => true]);
  } else {
    res(['success' => false], 422);
  }

  $conn->close();
}

function viewFormula() {
  global $conn;

  $st = ["Removed","Approved","R&D","Sample Use Only","Do Not Use"];
  $formula = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE id={$_POST['id']}");

  if($formula->num_rows) {
    $formula = $formula->fetch_assoc();
    
    echo '<h4>Basic Information</h4>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th style="width: 15%">Formula Name</th>
            <td style="width: 45%">'.$formula['name'].'</td>
            <th style="width: 15%">Code</th>
            <td>'.$formula['formula_code'].'</td>
          </tr>
          <tr>
            <th>Serving Size</th>
            <td data-batch>'.$formula['serving_size'].'</td>
            <th>Version No.</th>
            <td>'.$formula['version_number'].'</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>'.$st[$formula['status']].'</td>
            <th>Date</th>
            <td>'.$formula['status_date'].'</td>
          </tr>
        </tbody>
      </table>
      <h4>Ingredients</h4>
      <table class="table table-bordered table-center">
        <thead>
          <tr>
            <th rowspan="2">Ingredient</th>
            <th rowspan="2">Amount/serving </th>
            <th rowspan="2">Price</th>
            <th rowspan="2">Formulation</th>
            <th colspan="3">Cost Per Serving</th>
          </tr>
          <tr>
            <th>lb</th>
            <th>oz</th>
            <th>kg</th>
          </tr>
        </thead>
        <tbody>';
        $ing = json_decode($formula['ingredients'], TRUE);
        $totalGrams = 0;
        $totalPrice = 0;
        foreach($ing as $ind => $i) {
          $srv = is_string($i['serving']) ? [
            'amount' => $i['serving'],
            'grams' => 1,
            'unit' => 'g'
          ] : $i['serving'];
          $ingName = $conn->query("SELECT material_name,material_ppu,material_count FROM tbl_supplier_material WHERE ID={$i['id']}")->fetch_assoc();
          $ing[$ind]['serving'] = $srv;
          $ing[$ind]['data'] = $ingName;
          $totalGrams += doubleval($srv['amount']) * doubleval($srv['grams']);
        }
        foreach($ing as $i) {
          $g = doubleval($i['serving']['amount']) * doubleval($i['serving']['grams']);
          $price = number_format(($g * doubleval($i['data']['material_ppu'] ?? 1)) / doubleval($i['data']['material_count'] ?? 1), 2);
          $totalPrice += $price;
          echo '<tr>
            <td>'.$i['data']['material_name'].'</td>
            <td><span data-batch>'.$i['serving']['amount']. '</span> ' .$i['serving']['unit'].'</td>
            <td data-batch>'.$price.'</td>
            <td>'.(number_format(($g / $totalGrams) * 100, 2)).'%</td>
            <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'lb').'</td>
            <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'oz').'</td>
            <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'kg').'</td>
          </tr>';
        }
        echo '</tbody>
      </table>
      <h5>Total Amount/serving, g: <strong data-batch>'.($totalGrams).'</strong></h5>
      <h5>Total Price: <strong data-batch>'.($totalPrice).'</strong></h5>
      <a href="pdf_formulation?id='.$_POST['id'].'" class="btn btn-success" target="_blank">Print</a>
      <h4 style="margin-top:3rem;">Notes</h4>
      <div style="padding: 1rem;">'.(isset($formula['notes']) || empty($formula['notes']) ? $formula['notes'] : "<i class='text-muted'>Not added.</i>").'</div>
      <h4 style="margin-top:3rem;">Instructions</h4>';
      $ins = json_decode($formula['instructions'], true);
      foreach($ins as  $i) {
        echo '<div style="padding: 1rem;"><h5 style="font-weight: 600;">'.$i['title'].'</h5><ol>';
        foreach($i['instructions'] as $ii) {
          echo '<li>'.$ii.'</li>';
        }
        echo '</ol></div>';
      }

    $conn->close();
  }

}

function convert($g, $unit) {
  return match($unit) {
    'lb' => number_format((0.00220462 * floatval($g)), 2),
    'oz' => number_format((0.035274 * floatval($g)), 2),
    'kg' => number_format((0.001 * floatval($g)), 2),
  };
}
