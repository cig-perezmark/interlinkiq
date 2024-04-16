<?php   
 include('../database.php'); 
  $query = "SELECT * tbl_user";
  $result = mysqli_query($conn, $query);
    if( isset($_GET['modalViewApp']) ) : ?>
    		
    	<?php
    	$id = $_GET['modalViewApp']; 
    		$selectData = mysqli_query( $conn,"SELECT *,tbl_library.ID  as lib FROM tbl_library left join tbl_user on tbl_library.user_id = tbl_user.ID where tbl_library.ID = $id ORDER BY name ASC" );
            while($row = mysqli_fetch_array($selectData)){ ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input class="form-control" type="hidden" name="parent_id" id="parent_id" value="<?php echo $row['lib']; ?>" required />
                        </div>
                    </div>
                </div>
                    <br>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">  
                            <label>Dashboard</label>
                        </div>
                        <div class="col-md-12">
                             <input class="form-control" type="text" name="" id="" value="<?php echo $row['name']; ?>" readonly>
                        </div>
                    </div>
                </div>
                    <br>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-2">  
                            <label>From</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="contactpersonname" id="contactpersonname" value="<?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2">  
                            <label>To</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="" id="" value="Quincy Quality" readonly>
                                <!--<select class="form-control">-->
                                <!--    <option>---Select---</option>-->
                                <!--</select>-->
                        </div>
                    </div>
                </div>
    <?php } ?> 
<?php endif; ?>  
                
