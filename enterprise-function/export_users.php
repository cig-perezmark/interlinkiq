<?php  
	//export.php  
	include "../database.php";
	$output = '';

	// for Excel file
	if(isset($_POST["exportExcel"])) {
		$query = "SELECT * FROM tbl_user";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0) {
			$output .= '<table class="table table-bordered">  
				<tr>
					<th>first Name</th>  
					<th>last Name</th>  
					<th>Email</th>
					<th>Date Registered</th>
				</tr>';
				while($row = mysqli_fetch_array($result)) {
					$output .= '<tr>  
						<td>'.$row["first_name"].'</td>  
						<td>'.$row["last_name"].'</td>  
						<td>'.$row["email"].'</td>
						<td>'.$row["date_registered"].'</td> 
					</tr>';
				}
			$output .= '</table>';
			header('Content-Type: application/xls ');
			header('Content-Disposition: attachment; filename=DEMO - Registered Users.xls');
			echo $output;
		}
	}


	if(isset($_POST["exportExcelEnterprise"])) {
        $query = "SELECT * from tblEnterpiseDetails left join countries on id = country where businessname !='' order by enterp_id desc";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0) {
			$output .= '<table class="table table-bordered">  
				<tr>
                    <th>Legal Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th></th>
                    <th>City</th>
                    <th>States</th>
                    <th>Zip Code</th>
                    <th>Enterprise Process</th>
				</tr>';
				while($row = mysqli_fetch_array($result)) {
					$output .= '<tr>
                        <td>'.$row['businessname'].'</td>
                        <td>'.$row['businessemailAddress'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['Bldg'].'</td>
                        <td>'.$row['city'].'</td>
                        <td>'.$row['States'].'</td>
                        <td>'.$row['ZipCode'].'</td> 
                        <td>';
                        	$array_busi = explode(", ", $row["BusinessPROCESS"]); 
                    	    if(in_array('1', $array_busi)){ $output .= 'Manufacturing'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('2', $array_busi)){ $output .= 'Distribution'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('3', $array_busi)){ $output .= 'Co-Packer'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('4', $array_busi)){ $output .= 'Co-Manufacturer'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('5', $array_busi)){ $output .= 'Retailer'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('6', $array_busi)){ $output .= 'Reseller'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('7', $array_busi)){ $output .= 'Buyer'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('8', $array_busi)){ $output .= 'Seller'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('9', $array_busi)){ $output .= 'Broker'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('10', $array_busi)){ $output .= 'Packaging'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('11', $array_busi)){ $output .= 'Professional Services'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('12', $array_busi)){ $output .= 'IT Services'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('13', $array_busi)){ $output .= 'Brand Owner'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('14', $array_busi)){ $output .= 'Cultivation'; $output .= ", ";} else{ $output .= "";}
                    	    if(in_array('15', $array_busi)){ $output .= 'Others'; $output .= ", ";} else{ $output .= "";}
                        $output .= '</td>
					</tr>';
				}
			$output .= '</table>';
			header('Content-Type: application/xls ');
			header('Content-Disposition: attachment; filename=Enterprise Records.xls');
			echo $output;
		}
	}
?>
