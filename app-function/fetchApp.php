<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_appstore WHERE app_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['app_id'] .'" />
    		<div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"><strong>Price:</strong></label>
                </div>
                <div class="col-md-10">
                    <label class="control-label">'. $row['pricing'] .'</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"><strong>App Name:</strong></label>
                </div>
                <div class="col-md-10">
                    <label class="control-label">'. $row['application_name'] .'</label>
                </div>
            </div>
            <div class="form-group">
                 <div class="col-md-2">
                    <label class="control-label"><strong>Description:</strong></label>
                 </div
                 <div class="col-md-10">
                    <label class="control-label">'. $row['descriptions'] .'</label>
                 </div
            </div>
            <div class="container-gallery">

              <!-- Full-width images with number text -->
              <div class="mySlides active">
                <div class="numbertext">1 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name1"].'" style="width:100%;"></center>
              </div>
            
              <div class="mySlides">
                <div class="numbertext">2 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name2"].'" style="width:100%;"></center>
              </div>
            
              <div class="mySlides">
                <div class="numbertext">3 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name3"].'" style="width:100%;"></center>
              </div>
            
              <div class="mySlides">
                <div class="numbertext">4 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name4"].'" style="width:100%;"></center>
              </div>
            
              <div class="mySlides">
                <div class="numbertext">5 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name5"].'" style="width:100%;"></center>
              </div>
            
              <div class="mySlides">
                <div class="numbertext">6 / 6</div>
                  <center><img src="app-store-img/'.$row["images_name6"].'" style="width:100%;"></center>
              </div>
            
              <!-- Next and previous buttons -->
              <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1)">&#10095;</a>
            
              <!-- Image text -->
              <div class="caption-container">
                <p id="caption"></p>
              </div>
            
              <!-- Thumbnail images -->
              <div class="row">
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name1"].'" style="width:100%" onclick="currentSlide(1)" alt="'. $row['images_name1'] .'">
                </div>
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name2"].'" style="width:100%" onclick="currentSlide(2)" alt="'. $row['images_name2'] .'">
                </div>
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name3"].'" style="width:100%" onclick="currentSlide(3)" alt="'. $row['images_name3'] .'">
                </div>
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name4"].'" style="width:100%" onclick="currentSlide(4)" alt="'. $row['images_name4'] .'">
                </div>
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name5"].'" style="width:100%" onclick="currentSlide(5)" alt="'. $row['images_name5'] .'">
                </div>
                <div class="column">
                  <img class="demo cursor" src="app-store-img/'.$row["images_name6"].'" style="width:100%" onclick="currentSlide(6)" alt="'. $row['images_name6'] .'">
                </div>
              </div>
            </div>
            
            
            ';
    
            mysqli_close($conn);
    	}

?>
