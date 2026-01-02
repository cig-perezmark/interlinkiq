<?php 
require '../database.php';
if( isset($_POST['post_id']) ) {
    
	$ID = $_POST['post_id'];

    $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes where id = $ID");
      if(mysqli_num_rows($meetings) > 0) {
        echo '<br><br><br><br><div class="col-md-12"><h3 style="margin-left:23rem;"> MINUTES OF THE MEETING</h3></div><br>';
        while($row = $meetings->fetch_assoc()) {
           echo '
           <div class="col-md-12">';
                echo '<b>DATE:</b> '.$row['meeting_date'].'<br><br>';
                echo '<b>START TIME:</b> '.date('h:i:s a', strtotime($row['duration_start'])).' /CST<br><br>';
                echo '<b>END TIME:</b> '.date('h:i:s a', strtotime($row['duration_end'])).' /CST<br><br>';
                echo '<b>PRESIDER:</b> ';
                        $array_data_pres = explode(", ", $row["presider"]);
                        $queryPres = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                        $resultPres = mysqli_query($conn, $queryPres);
                        while($rowPres = mysqli_fetch_array($resultPres))
                        { 
                           
                            if(in_array($rowPres['ID'],$array_data_pres)){
                                echo $rowPres['first_name'].' '.$rowPres['last_name'].'<br><br>';
                            }
                        }
                echo '<b>NOTE TAKER:</b> ';
                        $array_data_taker = explode(", ", $row["note_taker"]);
                        $queryTaker = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                        $resultTaker = mysqli_query($conn, $queryTaker);
                        while($rowTaker = mysqli_fetch_array($resultTaker))
                        { 
                           
                            if(in_array($rowTaker['ID'],$array_data_taker)){
                                echo $rowTaker['first_name'].' '.$rowTaker['last_name'].'<br><br>';
                            }
                        }
                        
                
                echo '<b>AGENDA:</b>';
                    if (!empty($row['agendas'])) {
                        echo '<ul style="margin-bottom: 0;">';
                        
                            $agendas = $row["agendas"];
                            $agendas_arr = explode(", ", $agendas);
                            foreach ($agendas_arr as $value) {
                                $selectAgenda = mysqli_query( $conn,"SELECT name FROM tbl_meeting_minutes_agenda WHERE ID = $value" );
                                if ( mysqli_num_rows($selectAgenda) > 0 ) {
                                    $rowAgenda = mysqli_fetch_array($selectAgenda);
                                    
                                    echo '<li>'.$rowAgenda['name'].'</li>';
                                }
                            }
                        echo '</ul>';
                    }
                    if (!empty($row['agenda'])) {
                        echo '<ul>
                            <li>'.htmlentities($row["agenda"] ?? '').'</li>
                        </ul>';
                    }
                
                echo '<b>ATTENDEES:</b><br>';
                        
                        $array_data = explode(", ", $row["attendees"]);
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                        { 
                           
                            if(in_array($rowAssignto['ID'],$array_data)){
                                echo $rowAssignto['first_name'].' '.$rowAssignto['last_name'].', ';
                            }
                        }
                        
                if (!empty($row['guest'])) {
                    echo '<br><br><b>GUEST:</b><br>'.$row['guest'];
                }
                    
            echo '
            </div>';
            echo '<div class="col-md-12" style="width:100%;">'.$row['discussion_notes'].'</div>';
        }
    }
}
?>
