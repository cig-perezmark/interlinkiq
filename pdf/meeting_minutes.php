<?php

    require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');

    $mpdf = new \Mpdf\Mpdf();
    // $base_url = "https://interlinkiq.com/";
    $base_url = "../";
    $html = "";

    $ID = $_GET['i'];
    $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes where id = $ID");
    if(mysqli_num_rows($meetings) > 0) {
        WHILE ($row = $meetings->fetch_assoc()) {
            $user_ids = $row['user_ids'];
            $html .= '<html>
                <head>
                    <title>Meeting Minutes</title>
                </head>
                <body>
                    <b>DATE:</b> '.$row['meeting_date'].'<br>
                    <b>START TIME:</b> '.date('h:i:s a', strtotime($row['duration_start'])).' /CST<br>
                    <b>END TIME:</b> '.date('h:i:s a', strtotime($row['duration_end'])).' /CST<br>
                    <b>PRESIDER:</b>';
                        $array_data_pres = explode(", ", $row["presider"]);
                        $queryPres = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                        $resultPres = mysqli_query($conn, $queryPres);
                        while ($rowPres = mysqli_fetch_array($resultPres)) {
                            if(in_array($rowPres['ID'],$array_data_pres)){
                                $html .= $rowPres['first_name'].' '.$rowPres['last_name'];
                            }
                        }

                    $html .= '<br><br><b>NOTE TAKER:</b> ';
                        $array_data_taker = explode(", ", $row["note_taker"]);
                        $queryTaker = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                        $resultTaker = mysqli_query($conn, $queryTaker);
                        while  ($rowTaker = mysqli_fetch_array($resultTaker)) {
                            if(in_array($rowTaker['ID'],$array_data_taker)){
                                $html .= $rowTaker['first_name'].' '.$rowTaker['last_name'];
                            }
                        }

                    $html .= '<br><br><b>AGENDA:</b>';
                        if (!empty($row['agendas'])) {
                            $html .= '<ul style="margin-bottom: 0;">';
                                $agendas = $row["agendas"];
                                $agendas_arr = explode(", ", $agendas);
                                foreach ($agendas_arr as $value) {
                                    $selectAgenda = mysqli_query( $conn,"SELECT name FROM tbl_meeting_minutes_agenda WHERE ID = $value" );
                                    if ( mysqli_num_rows($selectAgenda) > 0 ) {
                                        $rowAgenda = mysqli_fetch_array($selectAgenda);
                                        
                                        $html .= '<li>'.$rowAgenda['name'].'</li>';
                                    }
                                }
                            $html .= '</ul>';
                        }
                        if (!empty($row['agenda'])) {
                            $html .= '<ul>
                                <li>'.htmlentities($row["agenda"] ?? '').'</li>
                            </ul>';
                        }
                    
                    $html .= '<b>ATTENDEES:</b><br>';
                        $array_data = explode(", ", $row["attendees"]);
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                        while($rowAssignto = mysqli_fetch_array($resultAssignto)) {
                            if(in_array($rowAssignto['ID'],$array_data)){
                                $html .= $rowAssignto['first_name'].' '.$rowAssignto['last_name'].', ';
                            }
                        }
                        if (!empty($row['guest'])) {
                            $html .= '<br><br><b>GUEST:</b><br>'.$row['guest'];
                        }

                        $html .= '<br><br>'.$row['discussion_notes'];

                $html .= '</body>
            </html>';
        }  
    }

    $title = 'Meeting Minutes - '.date('mdy');
    $mpdf->SetDisplayMode('fullpage');
    
    if ($user_ids == 1486) {
        $logo = '394227 - cig.png';
        $selectData = mysqli_query( $conn,"SELECT BrandLogos FROM tblEnterpiseDetails WHERE users_entities = $user_ids" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $rowData = mysqli_fetch_array($selectData);
            $logo = $rowData['BrandLogos'];
        }
            
        // $header = '<table cellpadding="7" cellspacing="0" width="100%" border="1" style="text-align: center;">
        //     <tr>
        //         <td rowspan="2"><img src="../companyDetailsFolder/'.$logo.'" height="100px" alt="logo"></td>
        //         <td><b>Meeting Minutes</b></td>
        //         <td>
        //             Issued Date<br>
        //             <b>03/16/2023</b>
        //         </td>
        //         <td>
        //             Page<br>
        //             <b>{PAGENO} of {nb}</b>
        //         </td>
        //     </tr>
        //     <tr>
        //         <td>
        //             Code<br>
        //             <b>SOP-01-0000111</b>
        //         </td>
        //         <td>
        //             Supersedes Date<br>
        //             <b>03/16/2023</b>
        //         </td>
        //         <td>
        //             Version No.<br>
        //             <b>1</b>
        //         </td>
        //     </tr>
        // </table>';
            
        $header = '<table cellpadding="7" cellspacing="0" width="100%" border="1" style="text-align: center;">
            <tr>
                <td><img src="../companyDetailsFolder/'.$logo.'" height="100px" alt="logo"></td>
            </tr>
        </table>';
        
        $mpdf->SetHeader($header, 'O');
        $mpdf->AddPageByArray([
            'margin-top' => '50px'
        ]);
    }
    
    $mpdf->WriteHTML($html);
    $mpdf->Output($title.'.pdf', 'I');

?>