<?php
error_reporting(0);
//action.php
if(isset($_POST["action"]))
{
 $conn = mysqli_connect("localhost", "brandons_interlinkiq", "L1873@2019new", "brandons_interlinkiq");

 if($_POST["action"] == "insert")
 {
    if( isset($_GET['btnClone']) ) {
		$id = $_GET['btnClone'];
		$req_user_id = $_POST['getID'];

		// PARENT CLONING
		$sql = "INSERT INTO tbl_library (user_id, parent_id, child_id, type, name, program, description, assigned_to_id, due_date, last_modified)
		SELECT $req_user_id, '0', '', type, name, program, description, assigned_to_id, due_date, last_modified
		FROM tbl_library
		WHERE ID = $id";

		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);

			cloneComment($req_user_id, $id, $last_id);
			cloneFile($req_user_id, $id, $last_id);

			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID=$id");
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_child_id = $rowData['child_id'];

				// CHILD
				if (!empty($data_child_id)) {

					cloneChild($req_user_id, $id, $last_id);
					echo "done";
				}
			}
		}

        mysqli_close($conn);
	}
 }
}
?>