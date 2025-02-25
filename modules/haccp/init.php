<?php 

require_once __DIR__ . '/HaccpModel.php';

$arnel_title = 'FSC, PCQI, FSVPQI';
$pageUrl .= "/$site";

if(!isset($switch_user_id)) {
    $switch_user_id = $user_id ?? 0;
}

$facilities = $conn->execute("SELECT facility_id, facility_category FROM tblFacilityDetails where users_entities = ?", $switch_user_id)->fetchAll(); 
$organizationalChart  = $conn->execute("SELECT image FROM tbl_haccp_org_charts WHERE user_id = ?", $switch_user_id)->fetchAssoc()['image'] ?? null;
$employees = $conn->execute("SELECT ID,CONCAT(first_name, ' ', last_name) AS name,department_id,job_description_id FROM tbl_hr_employee WHERE user_id=$switch_user_id AND status <> 0")->fetchAll();
$cigEmployees = [];
$teamSigns = [];

$emps = mysqli_query( $conn,"SELECT * from tbl_hr_employee WHERE user_id = 34 AND suspended = 0 AND status = 1 ORDER BY first_name" ); 
if ( mysqli_num_rows($emps) > 0 ) { 
    while($rowEmployee = mysqli_fetch_array($emps)) { 
        $cigEmployees[] = array(
            'ID' => $rowEmployee['ID'],
            'name' => $rowEmployee['first_name'] . ' ' . $rowEmployee['last_name'],
        );
    } 
}

$hashedHACCPId = $_GET['edit'] ?? $_GET['pdf'] ?? null;
$customVersion = $_GET['version'] ?? null;
$haccpResource = null;
$haccps = [];
$haccp = null;
$haccpDiagramImage = null;
$session = 'allowed'; // allow access to haccp document by default

if(isset($hashedHACCPId)) {
    // edit haccp
    $haccp = new Haccp();
    $haccp->setId($hashedHACCPId, true);
    
    // custom version is set
    // only in pdf page
    if(isset($_GET['pdf']) && !empty($customVersion)) {
        $haccp->setVersion($customVersion, true);
    }
    
    $haccpResource = $haccp->getResource(true);

    $diagram = $haccpResource['diagram'];
    $planBuiderResource = $haccpResource;
    $haccpDiagramImage = $haccp->getDiagramImage();
    $teamSigns = $haccp->getSigns();

    $stat = $haccpResource['status'];

    // restrict user access with these statuses
    if($stat == 'For Review' || $stat == 'For Approval') {
        $session = null;
        if(isset($_GET['session'])) {
            // check if the session is in the url
            $s = $haccp->getAction($_GET['session']);
            if($s['recipient_id'] == $currentUser->employee('ID')) {
                $session = $_GET['session'];
            }
        } else {
            // no session in the url
            // check if the user is allowed to open the document
            // (check the recipient id of the last/open action)
            if($openSession = $haccp->getAction()) {
                if($openSession['recipient_id'] == $currentUser->employee('ID')) {
                    $session = hash('md5', $openSession['id']);
                }
            }
        }
    }

    unset($planBuiderResource['diagram']);
} else {
    // dashboard
    $haccps = Haccp::all($switch_user_id);
}

$resource = function ($key) use($haccpResource) {
    if(isset($haccpResource)) {
        return $haccpResource[$key] ?? '';
    }
    return '';
}

?>
