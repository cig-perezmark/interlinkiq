<?php 
include "../database.php";

// user identifier
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

//crm data
if(isset($_POST["key"])) {
    if($_POST["key"] == 'get_applicant_form'){
    $query = mysqli_query($conn,"select *from tblEnterpiseDetails where users_entities = '$user_id' limit 1");
    foreach($query as $row){
    ?>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="form-control no-border">Name Insured:</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control bottom-border" value="" placeholder="">
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="form-control no-border">Address:</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control bottom-border" value="<?= $row['Bldg']; ?>" placeholder="Bldg">
                </div>
                <div class="col-md-2">
                    <input class="form-control bottom-border" value="<?= $row['city']; ?>" placeholder="City">
                </div>
                <div class="col-md-2">
                    <input class="form-control bottom-border" value="<?= $row['States']; ?>" placeholder="States">
                </div>
                <div class="col-md-2">
                    <input class="form-control bottom-border" value="<?= $row['ZipCode']; ?>" placeholder="ZipCode">
                </div>
                <div class="col-md-2">
                    <select class="form-control bottom-border" name="country">
                        <option value="0">---Country---</option>
                        
                        <?php 
                        $resultcountry = mysqli_query($conn, "select * from countries order by name ASC");
                         while($rowcountry = mysqli_fetch_array($resultcountry))
                         { ?>
                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['country']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                        <?php } ?>
                        
                    </select>
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="form-control no-border">Phone:</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control bottom-border" value="<?= $row['businesstelephone']; ?>" placeholder="Phone">
                </div>
                <div class="col-md-2">
                    <label class="form-control no-border">Email:</label>
                </div>
                <div class="col-md-4">
                    <input type="email" class="form-control bottom-border" value="<?= $row['businesstelephone']; ?>" placeholder="Email">
                </div>
            </div>
            <br><br>
            <?php 
                           
                $queries = "SELECT * FROM tblEnterpiseDetails_Contact where user_cookies = $user_id limit 1";
                $resultQuery = mysqli_query($conn, $queries);
                while($rowq = mysqli_fetch_array($resultQuery)){ ?>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="form-control no-border">Contact Person:</label>
                        </div>
                        <div class="col-md-2">
                             <input class="form-control bottom-border" value="<?php echo $rowq['contactpersonname']; ?>" placeholder="First Name">
                        </div>
                        <div class="col-md-2">
                             <input class="form-control bottom-border" value="<?php echo $rowq['contactpersonlastname']; ?>" placeholder="Last Name">
                        </div>
                        <div class="col-md-2">
                            <label class="form-control no-border">Email:</label>
                        </div>
                        <div class="col-md-4">
                             <input type="email" class="form-control bottom-border" value="<?php echo $rowq['contactpersonemailAddress']; ?>"  placeholder="Contact Email">
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="form-control no-border">Cell No.: </label>
                        </div>
                        <div class="col-md-4">
                             <input class="form-control bottom-border" value="<?php echo $rowq['contactpersoncellno']; ?>" placeholder="Cell No.">
                        </div>
                        <div class="col-md-2">
                            <label class="form-control no-border">Phone:  </label>
                        </div>
                        <div class="col-md-4">
                             <input class="form-control bottom-border" value="<?php echo $rowq['contactpersonphone']; ?>" placeholder="Phone">
                        </div>
                    </div>
                    
            <br>
            <br>
            <?php } ?>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="form-control no-border">Website:</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control bottom-border" value="<?= $row['businesswebsite']; ?>" placeholder="Website"> 
                </div>
                <div class="col-md-2">
                    <label class="form-control no-border">Date Established:</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control bottom-border" value="<?= $row['YearEstablished']; ?>" placeholder="Year Established">
                </div>
            </div>
            <br>
            <br>
            <hr>
            <div class="form-group">
                <div class="col-md-5">
                    <label class="form-control no-border">Prior experience in this business under any other name:</label>
                </div>
                <div class="col-md-7">
                    <label>
                        <input class="no-border"type="radio" name="checkradio">
                        Yes
                    </label>
                    &nbsp;
                    <label>
                        <input class="no-border"type="radio" name="checkradio">
                        No
                    </label>
                </div>
            </div>
            <br>
            <br>
            <div class="form-group">
                <div class="col-md-5">
                    <label class="form-control no-border">If so (Yes), please provide the name of the entity:</label>
                </div>
                <div class="col-md-7">
                    <input class="form-control bottom-border" id="actions" value="" placeholder="Specify" >
                </div>
            </div>
            <br>
            <br>
            <br>
            <div clas="form-group">
                <div>
                    <input type="submit" class="btn blue btn-primary float-right" value="Save">
                </div>
            </div>
    <?php } }
}
?>
