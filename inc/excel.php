<?php
    include_once ('../database_iiq.php'); 
    include_once ('../database_payroll.php'); 
    
    
    echo '<table border=1>
        <thead>
            <tr>
                <th colspan="3">Basic Information</th>
                <th colspan="7">Address</th>
                <th colspan="3">Bank Details</th>
            </tr>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                
                <th>House/Apartment Number(Optional)</th>
                <th>Street</th>
                <th>Barangay</th>
                <th>City</th>
                <th>Province</th>
                <th>Region(Optional)</th>
                <th>Postal Code</th>
                
                <th>Bank Name</th>
                <th>Bank Account</th>
                <th>Account Number</th>
            </tr>
        </thead>
        <tbody>';
            
            $result = mysqli_query( $conn,"
                SELECT
                e.ID AS e_ID,
                u.ID AS u_ID,
                u.first_name AS u_first_name,
                u.last_name AS u_last_name,
                u.email AS u_email,
                o.address AS o_address
                FROM tbl_hr_employee AS e
                
                LEFT JOIN (
                	SELECT
                    *
                    FROM tbl_user
                ) AS u
                ON e.ID = u.employee_ID
                
                LEFT JOIN (
                    SELECT
                    *
                    FROM others_employee_details
                ) AS o
                ON e.ID = o.employee_id
                
                WHERE e.user_id = 34
                AND e.suspended = 0
                AND e.status = 1
                AND u.first_name != ''
                
                ORDER BY e.first_name
            " );
            if ( mysqli_num_rows($result) > 0 ) {
                while($row = mysqli_fetch_array($result)) {
                    echo '<tr>
                        <td>'.htmlentities($row["u_first_name"] ?? '').'</td>
                        <td>'.htmlentities($row["u_last_name"] ?? '').'</td>
                        <td>'.htmlentities($row["u_email"] ?? '').'</td>';
                        
                        
                        // $employee_details = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = '$current_userEmployeeID'" );
                        // $row_employee= mysqli_fetch_array($employee_details);
                        // $personal_email = '';
                        // $company_email = '';
                        // $employee_address = '';
                        // $contact_no = '';
                        // $emergency_name = '';
                        // $emergency_address = '';
                        // $emergency_contact_no = '';
                        // $emergency_email = '';
                        // $emergency_relation = '';
                        // if($row_employee){
                        //     $personal_email = htmlentities($row_employee['personal_email'] ?? '');
                        //     $company_email = htmlentities($row_employee['company_email'] ?? '');
                        //     $contact_no = htmlentities($row_employee['contact_no'] ?? '');
                        //     $emergency_name  = htmlentities($row_employee['emergency_name'] ?? '');
                        //     $emergency_address = htmlentities($row_employee['emergency_address'] ?? '');
                        //     $emergency_contact_no = htmlentities($row_employee['emergency_contact_no'] ?? '');
                        //     $emergency_email = htmlentities($row_employee['emergency_email'] ?? '');
                        //     $emergency_relation = htmlentities($row_employee['emergency_relation'] ?? '');
                        //     $employee_address = htmlentities($row_employee['address'] ?? '');
                        // }
                        
                        
                        $address = '';
                        $postal_code = '';
                        $region = '';
                        $province = '';
                        $city = '';
                        $barangay = '';
                        $street = '';
                        $apartment ='';
                        if(!empty($row['o_address'])){
                            $address = htmlentities($row['o_address'] ?? '');
                            $addresses = $address;
                            $user_addres  = htmlentities($row['o_address'] ?? '');
                            // Split the address into parts based on the comma delimiter
                            $values = explode('|', $user_addres);
                            
                            // Assign variables based on the extracted parts
                            $apartment = $values[0];
                            $street = $values[1];
                            $barangay = $values[2];
                            $city = $values[3];
                            $province = $values[4];
                            $region = $values[5];
                            $postal_code = $values[6];
                        }
                        
                        echo '<td>'.$apartment.'</td>';
                        echo '<td>'.$street.'</td>';
                        echo '<td>'.$barangay.'</td>';
                        echo '<td>'.$city.'</td>';
                        echo '<td>'.$province.'</td>';
                        echo '<td>'.$region.'</td>';
                        echo '<td>'.$postal_code.'</td>';
                        
                        
                        
                        $current_userEmployeeID = $row["e_ID"];
                        $employee_details = mysqli_query($payroll_connection,"SELECT accountname, accountno, bankno FROM payee WHERE payeeid = '$current_userEmployeeID' " );
                        $employee_details_row = mysqli_fetch_array($employee_details); 
                        $accountname = '';
                        $accountno = '';
                        if($employee_details_row){
                            $accountname = $employee_details_row['accountname'];
                            $accountno = $employee_details_row['accountno'];
                        }
                        
                        $bankno = '';
                        if (!empty($employee_details_row['bankno'])) {
                            $bankno = $employee_details_row['bankno'];
                        }
                        
                        // $bank_name = mysqli_query($payroll_connection,"" );
                        // $bank_named = '';
                        // foreach($bank_name as $rows) {
                        //     $bank_id =  $rows['bankno'];
                        //     $bank_named = htmlentities($rows['bankname'] ?? '');
                            
                        //     echo '<option value="'.$rows['bankno'].'" '; echo ($bank_id === $bankno) ? 'selected' : ''; echo '>'.$bank_named.'</option>';
                        // }
                        
                        $bank_name = '';
                        $selectBank = mysqli_query( $payroll_connection,"SELECT bankno, bankname FROM bankname WHERE bankno = '".$bankno."'" );
                        if ( mysqli_num_rows($selectBank) > 0 ) {
                            $rowBank = mysqli_fetch_array($selectBank);
                            $bank_name = htmlentities($rowBank['bankname'] ?? '');
                        }
                        
                        echo '<td>'.$bank_name.'</td>';
                        echo '<td>'.$accountname.'</td>';
                        echo '<td>'.$accountno.'</td>';
                        
                        
                    echo '</tr>';
                }
            }
            
            
            
            
        echo '</tbody>
    </table>';

?>