<?php
	require '../database.php';
	// Get status only
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

$columns = array('ID', 'first_name', 'last_name', 'account', 'task_date');

$query = "SELECT *,ifnull(sum(minute), 0) as total_mim FROM tbl_service_logs left join tbl_user  on ID = user_id WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'task_date BETWEEN "'.$_POST["start_date_filter"].'" AND "'.$_POST["end_date_filter"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (ID LIKE "%'.$_POST["search"]["value"].'%" 
  OR first_name LIKE "%'.$_POST["search"]["value"].'%" 
  OR last_name LIKE "%'.$_POST["search"]["value"].'%" 
  OR account LIKE "%'.$_POST["search"]["value"].'%") 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'group by user_id ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'group by user_id ORDER BY task_date DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
    $users = $row['employee_id'];
    $hr_emp = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$users'");
    foreach($hr_emp as $emp_row){
        
        $time = $row['total_mim'];
        $hours = floor($time / 60);
        $minutes = ($time % 60);
         
        $sub_array = array();
        $sub_array[] = $row["ID"];
        $sub_array[] = $row["first_name"].' '.$row["last_name"];
        $sub_array[] = $hours.' hour/s $ '.$minutes.' minute/s';
        $data[] = $sub_array;
    }
}

// function get_all_data($conn)
// {
//  $query = "SELECT * FROM tbl_service_logs left join tbl_user  on ID = user_id";
//  $result = mysqli_query($conn, $query);
//  return mysqli_num_rows($result);
// }

$output = array(
 "draw"    => intval($_POST["draw"]),
//  "recordsTotal"  =>  get_all_data($conn),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>