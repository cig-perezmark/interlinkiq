<?php 
    $title = "Specialist/Consultant";
    $site = "specialist";

    include_once ('head.php'); 
?>
<style type="text/css">
    /*.secSpecialist .list-inline {*/
    /*	display: block;*/
    /*    white-space: nowrap;*/
    /*    overflow: hidden;*/
    /*    text-overflow: ellipsis;*/
    /*}*/
</style>


					<div class="section-header pb-3"><h2>Our Specialist</h2></div>
					<div class="row px-3 pb-5">
				        <div class="mx-auto">
				            <div class="input-group">
				                <input class="form-control border-end-0 border rounded-pill bg-white" type="search" placeholder="search" id="txtSearch2">
				                <span class="input-group-append">
				                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button" style="margin-left: -40px;">
				                        <i class="fa fa-search"></i>
				                    </button>
				                </span>
				            </div>
				        </div>
				    </div>
					<div class="row gy-4">

						<?php
							$selectJob = mysqli_query( $conn,"SELECT * FROM tbl_user_job WHERE is_active = 1 ORDER BY rand()" );
                            if ( mysqli_num_rows($selectJob) > 0 ) {
                            	while($rowJob = mysqli_fetch_array($selectJob)) {
        	                        $count_educ = 0;
        	                        $count_skill = 0;
                            		$job_user_id = $rowJob['user_id'];

                            		if (employerID($job_user_id) == 34) {
                                        $education = $rowJob['education'];
	                                    if (!empty($education)) {
	                                        $output_educ = json_decode($education,true);
		                                    if (count($output_educ) > 0) {
                                                foreach ($output_educ as $key => $value) {
                                                    if (!empty($value['educ_degree'])) {
                                                    	$count_educ++;
                                                    }
                                                }
                                            }
	                                    }

	                                    $skill = $rowJob['skill'];
	                                    if (!empty($skill)) {
	                                        $output_skill = json_decode($skill,true);
		                                    if (count($output_skill) > 0) {
                                                foreach ($output_skill as $key => $value) {
                                                    if (!empty($value['skill_name'])) {
                                                    	$count_skill++;
                                                    }
                                                }
                                            }
	                                    }
    
	                                    if ($count_skill > 0 OR $count_educ > 0) {
                                    		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE is_active = 1 AND ID = $job_user_id" );
        		                            if ( mysqli_num_rows($selectUser) > 0 ) {
        		                            	while($rowUser = mysqli_fetch_array($selectUser)) {
        		                            		$user_fullname = $rowUser['first_name'] .' '. $rowUser['last_name'];
        
        		                            		$selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_user_info WHERE user_id = $job_user_id" );
        				                            if ( mysqli_num_rows($selectInfo) > 0 ) {
        				                            	$rowInfo = mysqli_fetch_array($selectInfo);
        		                            			$info_avatar = $rowInfo['avatar'];
        				                            }
        
        		                            		echo '<div class="col-lg-4x col-md-12 secSpecialist">
        												<div class="service-item position-relative">
        													<div class="icon d-none">';
        														$arr = array("fa-mountain-city","fa-computer","fa-helmet-safety");
        														$arr_key = array_rand($arr);
        														echo '<i class="fa-solid '.$arr[$arr_key].'"></i>
        													</div>
        													<div class="d-flex justify-content-between">
        														<h3>'.$user_fullname.'</h3>
        														<img class="d-none" style="height:200px;margin-top:-12rem; border: 10px solid #fff ; border-radius: 50%; background-color: #EFEFEF;" src="'.$base_url.'uploads/avatar/'.$info_avatar.'" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/230x230/EFEFEF/AAAAAA.png?text=no+image\';" />
        													</div>';
        
        													if ($count_skill > 0) {
                                                                echo '<h6>Specialties:</h6>
                                                                <ul class="list-inline">';
        	                                                        foreach ($output_skill as $key => $value) {
        	                                                            if (!empty($value['skill_name'])) {
        	                                                                echo '<li class="list-inline-item border border-1 border-secondary px-2 py-1 mb-2"><i class="bi bi-check-circle"></i> <span>'.$value['skill_name'].'</span></li>';
        	                                                            }
        	                                                        }
                                                                echo '</ul>';
                                                            }
        
        													if ($count_educ > 0) {
                                                                echo '<h6>Training Title:</h6>
                                                                <ul class="list-inline">';
        	                                                        foreach ($output_educ as $key => $value) {
        	                                                        	if (!empty($value['educ_degree'])) {
        	                                                        		echo '<li class="list-inline-item border border-1 border-secondary px-2 py-1 mb-2"><i class="bi bi-check-circle"></i> <span>'.$value['educ_degree'].'</span></li>';
        	                                                        	}
        	                                                        }
                                                                echo '</ul>';
                                                            }
        
        													if(!empty($current_userID)) {
        														echo '<a href="#" data-bs-toggle="modal" data-bs-target="#sendMessage" class="d-none btn btn-primary" onClick="sendMessage('.$job_user_id.')">Send Message <i class="bi bi-arrow-right"></i></a>';
        														echo '<a href="#" data-bs-toggle="modal" data-bs-target="#sendMessage2" class="btn btn-primary" onClick="sendChat('.$job_user_id.', '.$current_userID.')">Send Chat <i class="bi bi-arrow-right"></i></a>';
        														echo '<a href="#" data-bs-toggle="modal" data-bs-target="#sendMessage2" class="d-none btn btn-primary">Send Chat <i class="bi bi-arrow-right"></i></a>';
        													} else {
        														echo '<a href="login" class="readmore stretched-link">Contact <i class="bi bi-arrow-right"></i></a>';
        													}
        
        												echo '</div>
        											</div>';
        
        		                            	}
        		                            }
	                                    }
                            		}
                            	}
                            }
						?>

					</div>
					<input class="d-none" type="button" onClick="document.getElementById('middle').scrollIntoView();" />

		<?php include_once ('foot.php'); ?>

	</body>
</html>