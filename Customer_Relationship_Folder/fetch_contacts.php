<?php
require '../database.php';
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

$output = '';
if(isset($_POST["query"]))
{
     $search = mysqli_real_escape_string($conn, $_POST["query"]);
     $query = "
      SELECT * FROM tbl_Customer_Relationship 
      WHERE  account_name LIKE '%".$search."%'
      OR account_email LIKE '%".$search."%' 
      OR account_phone LIKE '%".$search."%' 
      OR account_address LIKE '%".$search."%' 
      OR Account_Source LIKE '%".$search."%'
      OR account_rep LIKE '%".$search."%'
      OR account_certification LIKE '%".$search."%'
      OR account_category LIKE '%".$search."%'
     ";
}
else
{
     $query = "
      SELECT * FROM tbl_Customer_Relationship where account_name != '' ORDER BY account_name
     ";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
     $output .= '
      <div class="table-responsive">
       <table class="table table-bordered" style="table-layout: fixed;width:100%;">
        <tr>
        <th>Account Rep</th>
        <th>Date</th>
         <th>Customer Name</th>
         <th width="250px">Email</th>
         <th>Phone</th>
         <th>Address</th>
         <th>Certification</th>
         <th>Source</th>
         <th>Status</th>
         <th width="90px"></th>
        </tr>
     ';
 while($row = mysqli_fetch_array($result))
 {
     $userID = $row["userID"];
     if(employerID($userID) == $user_id) {
        $default_added = date_create($row['crm_date_added']);
        $output .= '
        <tr>
            <td>'.$row["account_rep"].'</td>
            <td>'.date_format($default_added,"Y/m/d h:i:s a").'</td>
            <td>'.$row["account_name"].'</td>
            <td width="250px">'.$row["account_email"].'</td>
            <td>'.$row["account_phone"].'</td>
            <td>'.$row["account_address"].'</td>
            <td>'.$row["account_certification"].'</td>
            <td>'.$row["Account_Source"].'</td>
            <td>'.$row["account_category"].'</td>
            <td width="90px">
			 <a href="customer_relationship_View.php?view_id='.$row['crm_id'].'" class="btn blue btn-outline" >
                                                    View
                </a>
            </td>
        </tr>
        ';
    }
     
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}
	
?>