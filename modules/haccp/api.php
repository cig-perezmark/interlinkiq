<?php 

include_once __DIR__ . '/../../alt-setup/setup.php';
include_once __DIR__ . '/HaccpModel.php';
include_once __DIR__ . '/api_functions.php';

$pageUrl .= "/$site";

/**
 * =======================
 * PRODUCTS
 * =======================
 */

if(isset($_POST['search-product']) && !empty($_POST['search-product'])) {
    $allProducts = [];
    $search = mysqli_real_escape_string($conn, $_POST['search-product']);
    $result = $conn->query("SELECT 
        p.ID AS id,
        p.image,
        p.code,
        p.name,
        p.description,
        c.name AS category
        FROM tbl_products AS p
        LEFT JOIN tbl_products_category AS c ON p.category = c.ID
        WHERE p.user_id=$user_id AND (p.code like '%$search%' OR p.name like '%$search%') AND p.deleted=0 AND NOT JSON_CONTAINS(CAST('{$_POST['products']}' AS JSON), CAST(p.ID AS CHAR))");
    $totalResult = $result->num_rows;
    if($totalResult > 0) {
        while($row = $result->fetch_assoc()) {
            $img = explode(',',$row['image'])[0];
            $img = empty($img) ? null : '//interlinkiq.com/uploads/products/' . $img;
            $row['image'] = !empty($img) ? $img : "https://via.placeholder.com/120x90/EFEFEF/AAAAAA.png?text=No+Image";
            $allProducts[] = $row;
        }
    }

    return send_response([
        'results' => $allProducts,
        'count' => $totalResult,
    ]);
}

/**
 * =======================
 * HACCP TEAM
 * =======================
 */

// adding haccp team
if(isset($_GET['add-haccp-team-roster'])) {
    try {
        $conn->begin_transaction();
        
        // borrow haccp param builder function
        $p = Haccp::paramBuilder([
            'user_id' => $user_id,
            'portal_user' => $portal_user,
            'primary_title' => $_POST['primary_title'] ?? null,
            'primary_member' => $_POST['primary_member'] ?? null,
            'alternate_title' => $_POST['alternate_title'] ?? null,
            'alternate_member' => $_POST['alternate_member'] ?? null,
        ]);

        $columns = $p['columns'];
        $values = $p['values'];
        $params = $p['params'];
        
        $conn->execute("INSERT INTO tbl_haccp_team_roster($columns) VALUE($params)", $values);
        $conn->commit();
        
        $teamRoster = fetchHaccpTeamRoster($conn, $user_id);
        return send_response([
            'message' => 'Successfully added.',
            'data' => $teamRoster
        ]);
    } catch(Exception $e) {
        $conn->rollback();
        send_response(['error' => $e->getMessage()], 500);
    }
}

// updating haccp team
if(isset($_GET['update-haccp-team-roster'])) {
    try {
        $conn->begin_transaction();
        $roster = $_GET['update-haccp-team-roster'];
        
        // borrow haccp param builder function
        $p = Haccp::paramBuilder([
            'portal_user' => $portal_user,
            'primary_title' => $_POST['primary_title'] ?? null,
            'primary_member' => $_POST['primary_member'] ?? null,
            'alternate_title' => $_POST['alternate_title'] ?? null,
            'alternate_member' => $_POST['alternate_member'] ?? null,
        ]);

        $columns = $p['columns'];
        $values = $p['values'];
        $params = $p['params'];
        $paramset = $p['params_set'];
        
        $conn->execute("UPDATE tbl_haccp_team_roster SET $paramset WHERE id = ?", [...$values, $roster]);
        $conn->commit();
        
        $teamRoster = fetchHaccpTeamRoster($conn, $user_id);
        return send_response([
            'message' => 'Successfully updated.',
            'data' => $teamRoster
        ]);
    } catch(Exception $e) {
        $conn->rollback();
        send_response(['error' => $e->getMessage()], 500);
    }
}

// deleting haccp team roster
if(isset($_GET['remove-haccp-team-roster'])) {
    try {
        $conn->begin_transaction();
        $roster = $_GET['remove-haccp-team-roster'];
        
        $conn->execute("UPDATE tbl_haccp_team_roster SET deleted_at = ? WHERE id = ?", $currentTimestamp, $roster);
        $conn->commit();
        
        $teamRoster = fetchHaccpTeamRoster($conn, $user_id);
        return send_response([
            'message' => 'Successfully removed!',
            'data' => $teamRoster
        ]);
    } catch(Exception $e) {
        $conn->rollback();
        send_response(['error' => $e->getMessage()], 500);
    }
}

// fetching haccp team roster 
if(isset($_GET['haccp-team-roster'])) {
    $teamRoster = fetchHaccpTeamRoster($conn, $user_id);
    return send_response(['data' => $teamRoster]);
}

/**
 * =======================
 * ORGANIZATIONAL CHART
 * =======================  
 */

if(isset($_GET['update-organization-chart'])) {
    try {
        $newChart = $_POST['image'] ?? null;
        $existingRecord = $conn->execute('SELECT * FROM tbl_haccp_org_charts WHERE user_id = ?', $user_id)->fetchAssoc();

        if(count($existingRecord)) {
            $conn->execute("UPDATE tbl_haccp_org_charts SET image = ?, portal_user=? WHERE user_id = ?", $newChart, $portal_user, $user_id);
        } else {
            $conn->execute("INSERT INTO tbl_haccp_org_charts(user_id, portal_user, image) VALUE(?,?,?)", $user_id, $portal_user, $newChart);
        }

        return send_response([
            'message' => 'Successfully saved!',
        ]);
    } catch(Exception $e) {
        send_response(['error' => $e->getMessage()], 500);
    }
}

if(isset($_GET['remove-organization-chart'])) {
    try {
        $conn->execute("DELETE FROM tbl_haccp_org_charts WHERE user_id = ?", $user_id);

        return send_response([
            'message' => 'Organizational chart has been deleted .',
        ]);
    } catch(Exception $e) {
        send_response(['error' => $e->getMessage()], 500);
    }
}

/**
 * =======================
 * TASK API
 * =======================  
 */

if(isset($_GET['add-task'])) {
    $haccp = new Haccp($_POST['haccp_id']);

    if($data = $haccp->addTask($_POST, $portal_user)) {
        return send_response([
            'message' => 'Task has been added.',
            'data' => $data,
        ]);
    }

    return send_response(['message' => 'Something went wrong.' ], 500);
}

if(isset($_GET['all-tasks'])) {
    $haccp = new Haccp($_GET['all-tasks']);
    
    return send_response([
        'data' => $haccp->getAllTasks(),
    ]);
}

if(isset($_GET['complete-task'])) {
    if(Haccp::updateTaskStatus($_GET['complete-task'], 'completed')) {
        return send_response([ 'message' => 'Marked as completed.' ]); 
    }
    return send_response([ 'message' => 'Something went wrong.' ], 500); 
}

/**
 * =======================
 * SIGNATURES
 * =======================  
 */

if(isset($_GET['signatures'])) {
    $haccp = new Haccp(($_POST['id']));
    $data = json_decode($_POST['signsData'] ?? '[]', true);

    if($haccp->updateSigns($data, $portal_user)) {
        return send_response([
            'message' => 'Signatures has been updated.'
        ]);
    }
    
    return send_response([
        'error' => 'Something went wrong.'
    ], 500);
}

if(isset($_GET['post-signatures'])) {
    $haccp = new Haccp($_GET['post-signatures']);
    return send_response([
        'data' => $haccp->getPostDocSigns(),
    ]);
}

if(isset($_GET['update-client-signatures'])) {
    $haccp = new Haccp($_GET['update-client-signatures']);
    
    if($haccp->updatePostSigns($_POST)) {
        return send_response([
            'message' => 'Updated successfully!',
        ]);
    }
}

/**
 * =======================
 * HACCP PLAN DATA
 * =======================  
 */

// creating new haccp plan
if(isset($_GET['create'])) {
    $haccp = new Haccp();

    $data = $_POST;
    $data['owner'] = $user_id;

    $user = new IIQ_User($conn, $portal_user);

    $developer = $user->first_name . ' ' . $user->last_name;
    $employer = $user->employer('ID') ?? null;
    
    $data['developer'] = isset($employer) && $employer == CIG_USER_ID ? 'Arnel Ryan' : $developer;
    $data['developer_sign'] = isset($employer) && $employer == CIG_USER_ID ? ARNEL_RYAN_SIGN_PNG : null;
    
    $haccp->create($data);
    $haccp->createLog('Initialized HACCP Plan as draft', Haccp::$step[1], $portal_user);

    return send_response([
        'message' => 'Successfully saved as draft.',
        'haccp' => md5($haccp->id),
    ]);
}

if(isset($_GET['update'])) {
    $haccp = new Haccp($_POST['id']);

    if($result = $haccp->update($_POST, $portal_user, $currentUser)) {
        return send_response([
            'message' => $result
        ]);
    }
    
    return send_response([
        'message' => 'Something went wrong.'
    ], 500);
}

if(isset($_GET['logs'])) {
    $haccp = new Haccp($_GET['logs']);
    return send_response([
        'data' => $haccp->getLogs($portal_user, $_GET['v'] ?? null),
        'versions' => array_map(function($v) {
                $v['id'] = hash('md5', $v['id']);
                
                if(isset($_GET['v'])) {
                    if($v['id'] == $_GET['v']) {
                        $v['active'] = true;
                    }
                }
                
                return $v;
            }, $haccp->getVersions()),
    ]);
}

if(isset($_GET['update-diagram-image'])) {
    $haccp = new Haccp($_GET['update-diagram-image']);
    
    if($haccp->updateDiagramImage($_POST['image'])) {
        return send_response('Diagram image has been updated.');
    } else {
        return send_response('Error.', 500);
    }
}

$conn->close();
// end
