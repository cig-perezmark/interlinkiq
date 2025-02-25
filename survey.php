<?php 
    $title = "Qualification Survey";
    $site = "survey";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Information';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include_once ('database_afia_forms.php'); 
    include_once ('database_forms.php'); 
    include_once ('header.php'); 
?>
<style>
    .col-md-12{
	    padding:15px ;
	}
</style>
	<div class="row">
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="col-md-12">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Qualification Survey</span>
                        <?php
                            if($current_client == 0) {
                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $type_id = $row["type"];
                                    $file_title = $row["file_title"];
                                    $video_url = $row["youtube_link"];
                                    
                                    $file_upload = $row["file_upload"];
                                    if (!empty($file_upload)) {
                        	            $fileExtension = fileExtension($file_upload);
                        				$src = $fileExtension['src'];
                        				$embed = $fileExtension['embed'];
                        				$type = $fileExtension['type'];
                        				$file_extension = $fileExtension['file_extension'];
                        	            $url = $base_url.'uploads/instruction/';
                        
                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                    }
                                    
                                    if ($type_id == 0) {
                                		echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><i class="fa '. $file_extension .'"></i> '.$file_title.'</a>';
                                	} else {
                                		echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><i class="fa fa-youtube"></i> '.$file_title.'</a>';
                                	}
                                }
                                
                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                    echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- List of apps in tbl_app_store table -->
                    <div class="portlet-body">
                        <!--Emjay starts here-->
                        <?php
                            $survey = 0;
                            if(isset($_GET['survey_id'])){
                                $survey = 1;
                                $survey_id = $_GET['survey_id'];
                                $sql = "SELECT * FROM tbl_survey WHERE id = $survey_id";
                                $result = mysqli_query($conn,$sql);
                                $row_assoc = mysqli_fetch_assoc($result);
                            }
                        ?>
                        <div class="portlet-title tabbable-line">
                            <ul class="nav nav-tabs">
                                <!--Emjay starts here-->
                                <li class="active">
                                    <a href="#forms" data-toggle="tab">Form</a>
                                </li>
                                <?php if($survey == 0): ?>
                                <li>
                                    <a href="#record" data-toggle="tab">Records</a>
                                </li>
                                <?php endif; ?>
                                <!--Emjay Codes ends here-->
                            </ul>               
                        </div>
                        <div class="tab-content">
                            <div id="forms" class="tab-pane active">
                                <?php if($survey == 0): ?>
                                <hr>
                                <em><span class="caption-subject font-italic" style="margin-top:3em">This form must be fully completed. Please state "N/A" if not applicable.</span></em>
                                <?php endif; ?>
                                <form action="controller.php" method="POST">
                                    <hr>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Total Payroll of Employees:</label><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Full time:</label>
                                                <input type="text" class="form-control" name="full_time" value="<?= $var = ($survey == 1) ? $row_assoc['full_time'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Part Time:</label>
                                                <input type="text" name="part_time" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['part_time'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Temps/Leased (not on your payroll):</label>
                                                <input type="text" name="temps" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['temps'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>States with Payroll: (CA, UT, NV, WA, TX, etc.):</label>
                                                <input type="text" name="states_with_pay" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['states_with_pay'] :  "" ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Most Recent Trailing 12 month Turnover /Revenue:</label>
                                                <input type="text" name="q1" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q1'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Are you doing the manufacturing yourself or are you using a third party copacker / contract manufacturer?:</label>
                                                <input type="text" name="q2" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q2'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Projected Next 12 Month Turnover / Revenue:</label>
                                                <input type="text" name="q3" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q3'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Basic Description of Products / Services:</label>
                                                <input type="text" name="q4" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q4'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">% Revenue from Co-Manufacturing / Processing For Others?:</label>
                                                <input type="text" name="q5" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q5'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">% Revenue from Manufacturing Your Own Products?:</label>
                                                <input type="text" name="q6" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q6'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold"># of Autos / Power Units Owned or Leased By Your Company:</label>
                                                <input type="text" name="q7" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q7'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold"># of Trailers Owned or Leased By Your Company:</label>
                                                <input type="text" name="q8" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q8'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Annual Value of Goods Imported Directly By Your Company:</label>
                                                <input type="text" name="q9" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q9'] :  "" ?>" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold"># of buildings Owned or Leased By Your Company:</label>
                                                <input type="text" name="q10" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q10'] :  "" ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="caption-subject font-dark bold">Have you Experienced any Insurance Claims in the Past 5 Years (over $250k):</label>
                                                <input type="text" name="q11" class="form-control" value="<?= $var = ($survey == 1) ? $row_assoc['q11'] :  "" ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($survey == 0): ?>
                                    <div class="form-actions right" style="margin-top:15px">
                                        <button type="button" class="btn default">Cancel</button>
                                        <button type="submit" name="submit_survey" class="btn green">Submit</button>
                                    </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <div id="record" class="tab-pane">
                                <table class="table table-bordered" style="margin-top:15px">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Date Submitted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $owner_id = $_COOKIE['user_company_id'];
                                            $sql = "SELECT * FROM tbl_survey WHERE owner_id = $owner_id";
                                            $result = mysqli_query($conn,$sql);
                                            foreach($result as $row):
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        $new_date = strtotime($row['date_submitted']);
                                                        echo $date = date('F d, Y',$new_date);
                                                    ?>
                                                </td>
                                                <td><a href="survey.php?survey_id=<?= $row['id'] ?>" target="_blank" class="btn btn-primary">View</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Emjay code ends here-->
                    </div>
                </div>
                
            </div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->
	

	<?php include('footer.php'); ?>


	<style>
    .mt_element_card .mt_card_item {
        border: 1px solid;
        border-color: #e7ecf1;
        position: relative;
        margin-bottom: 30px;
    }
    .mt_element_card .mt_card_item .mt_card_avatar {
        margin-bottom: 15px;
    }
    .mt_element_card.mt_card_round .mt_card_item {
        padding: 50px 50px 10px 50px;
    }
    .mt_element_card.mt_card_round .mt_card_item .mt_card_avatar {
        border-radius: 50% !important;
        -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
    }
    .mt_element_card .mt_card_item .mt_card_content {
        text-align: center;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_desc {
        font-size: 14px;
        margin: 0 0 10px 0;
       
    }
    .mt_element_overlay .mt_overlay_1 {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }
    .mt_element_overlay .mt_overlay_1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
        opacity: 0.5;
    }
    
.card{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.card::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #283593;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.card::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3949ab;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for free cards*/
.cardFree{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
  
}

.cardFree::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #3CCF4E;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.cardFree::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 9rem;
  background: #3CCF4E;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for gallery view*/

.container-gallery {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: #003865;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: #A6D1E6;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #003865;
  padding: 2px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 14px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
 font-weight:600;
 color:#003865;
  background-color: #F1F1F1;
  border-bottom:solid #003865 4px;
}

/* Style the tab content */
.tabcontent{
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.tabcontent2{
  display: block;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
    
	</style>
    </body>
</html>
