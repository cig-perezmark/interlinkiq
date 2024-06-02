<?php 
    include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
		$ID = $_GET['modalViewApp'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_PrivatePatrol WHERE ID = $ID" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);

            echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>First Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="first_name" value="'. $row['first_name'] .'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Last Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="last_name" value="'. $row['last_name'] .'"  required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Title</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="title" value="'. $row['title'] .'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Cell No.</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="cell" value="'. $row['cell'] .'"  />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Phone</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="phone" value="'. $row['phone'] .'" >
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>FAX</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="fax" value="'. $row['fax'] .'" >
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Email Address</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="email" value="'. $row['email'] .'"  required/>
                    </div>
                </div>
            </div>';

        }
        mysqli_close($conn);
	}
?>