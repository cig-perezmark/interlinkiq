<?php 
include "../database.php";

if(isset($_GET["modalView"])) {
    $get_id = $_GET["modalView"];
    $query = mysqli_query($conn,"select * from tblQuotation where quote_id = '$get_id'");
    foreach($query as $row){?>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Service Name</label>
                    <input type="hidden" class="form-control" name="ids" id="req_id" value="<?= $get_id; ?>">
                    <input class="form-control" name="quote_name" value="<?= $row['quote_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Estimated Hour</label>
                    <input type="number" class="form-control" name="estimated_hrs" value="<?= $row['estimated_hrs']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Estimated Cost</label>
                    <input type="number" class="form-control" name="estimated_cost" value="<?= $row['estimated_cost']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Supporting Files <a href="quotation_files/<?= $row['file_attch']; ?>" target="_blank"><i class="fa fa-eye"></i> View</a></label>
                    <input type="file" class="form-control" name="file_attch" value="<?= $row['file_attch']; ?>">
                    <input type="hidden" name="exist_file" value="<?= $row['file_attch']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Services Category</label>
                    <select  class="form-control" name="quote_category">
                    <option value="0">--Select--</option>
                    <?php
                        $sql_category = mysqli_query($conn,"select * from tblQuotation_cat");
                        foreach($sql_category as $row_cat){?>   
                            <option  value="<?= $row_cat['category_id']; ?>"<?php if($row['quote_category'] == $row_cat['category_id']){ echo 'selected'; }else{ echo''; } ?>><?= $row_cat['Category_Name']; ?></option>
                       <?php }
                    ?>
                    </select>
                </div>
            </div>
        <?php
     } 
}

if(isset($_POST['update_requirement'])){
    $id = $_POST['ids'];
    $quote_name = mysqli_real_escape_string($conn,$_POST['quote_name']);
    $estimated_hrs = mysqli_real_escape_string($conn,$_POST['estimated_hrs']);
    $estimated_cost = mysqli_real_escape_string($conn,$_POST['estimated_cost']);
    $quote_category = mysqli_real_escape_string($conn,$_POST['quote_category']);
    
    $file = $_FILES['file_attch']['name'];
    if(!empty($file))
    {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['file_attch']['name']));
        $rand = rand(10,1000000);
        $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['file_attch']['tmp_name'],'../quotation_files/'.$to_File_Documents);
    }
    else
    {
        $to_File_Documents =  $_POST['exist_file'];
    }
    
    $sql = "UPDATE tblQuotation SET quote_name='".$quote_name."',estimated_hrs='".$estimated_hrs."',estimated_cost ='".$estimated_cost."',file_attch = '".$to_File_Documents."',quote_category='".$quote_category."' WHERE quote_id=$id";
    if (mysqli_query($conn, $sql)) {
        $id = $_POST['ids'];
        $query_append = mysqli_query($conn,"select * from tblQuotation where quote_id = '$id'");
        foreach($query_append as $row_append){?>
            <div class="form-group" id="requirements_<?= $row_append['quote_id'];?>">
                <div class="col-md-12">
                    <label class="text_<?= $row_append['quote_id'];?>">
                        <input type="checkbox" class="value_data" id="checked_data" onclick="get_data(this)" value="<?= $row_append['quote_id'];?>">
                        <?= $row_append['quote_name'];?>
                    </label>
                </div>
                <div class="col-md-10">
                    <a class="btn dark btn-xs btn-outline">Estimated: <?= $row_append['estimated_hrs'];?> hrs</a>
                    <a href="quotation_files/<?= $row_append['file_attch']; ?>" class="btn dark btn-xs btn-outline" title="<?= $row_append['file_attch']; ?>" target="_blank">
                        <?php 
                            $ext = pathinfo($row_append['file_attch'], PATHINFO_EXTENSION);
                            if(!empty($ext)){echo strtoupper($ext);}else{echo 'No File';}
                        ?>
                    </a>
                    <a class="btn dark btn-xs btn-outline">Estimated Cost: $<?= number_format((float)$row_append['estimated_cost'], 2, '.', '');?></a>
                </div>
                <div class="col-md-2">
                    <a class="btn green btn-xs btn-outline btnView_requirement" data-toggle="modal" href="#modalGet_requirement" data-id="<?php echo $row_append["quote_id"]; ?>"><i class="icon-pencil"></i></a>
                </div>
            </div>
    <?php } }
}

if(isset($_POST['btnAdd_requirement'])){
    $userID = $_COOKIE['ID'];
    $quote_name = mysqli_real_escape_string($conn,$_POST['quote_name']);
    $estimated_hrs = mysqli_real_escape_string($conn,$_POST['estimated_hrs']);
    $estimated_cost = mysqli_real_escape_string($conn,$_POST['estimated_cost']);
    $quote_category = mysqli_real_escape_string($conn,$_POST['quote_category']);
    $hourly_rate = mysqli_real_escape_string($conn,$_POST['hourly_rate']);
    $time_of_delivery = mysqli_real_escape_string($conn,$_POST['time_of_delivery']);
    
    $to_File_Documents = '';
    $file = $_FILES['file_attch']['name'];
    if(!empty($file))
    {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['file_attch']['name']));
        $rand = rand(10,1000000);
        $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['file_attch']['tmp_name'],'../quotation_files/'.$to_File_Documents);
    }
    $sql = "INSERT INTO tblQuotation (quote_name,estimated_hrs,estimated_cost,quote_category,hourly_rate,user_cookie,time_of_delivery,file_attch) 
            VALUES ('$quote_name','$estimated_hrs','$estimated_cost','$quote_category','$hourly_rate','$userID','$time_of_delivery','$to_File_Documents')";
            if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
            $query_append = mysqli_query($conn,"select * from tblQuotation where quote_id = '$last_id'");
            foreach($query_append as $row_append){?>
                <div class="form-group" id="requirements_<?= $row_append['quote_id'];?>">
                    <div class="col-md-12">
                        <label class="text_<?= $row_append['quote_id'];?>">
                            <input type="checkbox" class="value_data" id="checked_data" onclick="get_data(this)" value="<?= $row_append['quote_id'];?>">
                            <?= $row_append['quote_name'];?>
                        </label>
                    </div>
                    <div class="col-md-10">
                        <a class="btn dark btn-xs btn-outline">Estimated: <?= $row_append['estimated_hrs'];?> hrs</a>
                        <a href="quotation_files/<?= $row_append['file_attch']; ?>" class="btn dark btn-xs btn-outline" title="<?= $row_append['file_attch']; ?>" target="_blank">
                            <?php 
                                $ext = pathinfo($row_append['file_attch'], PATHINFO_EXTENSION);
                                if(!empty($ext)){echo strtoupper($ext);}else{echo 'No File';}
                            ?>
                        </a>
                        <a class="btn dark btn-xs btn-outline">Estimated Cost: $<?= number_format((float)$row_append['estimated_cost'], 2, '.', '');?></a>
                    </div>
                    <div class="col-md-2">
                        <a class="btn green btn-xs btn-outline btnView_requirement" data-toggle="modal" href="#modalGet_requirement" data-id="<?php echo $row_append["quote_id"]; ?>"><i class="icon-pencil"></i></a>
                    </div>
                </div>
       <?php } }
}

// save quotatioh
if(isset($_POST['btnSave_quotaion'])){
    $userID = $_COOKIE['ID'];
    $record_name = mysqli_real_escape_string($conn,$_POST['record_name']);
    $presentedby = mysqli_real_escape_string($conn,$_POST['presentedby']);
    $rrequirement_id = '';
    $ttos_id = '';
    $ppayment_ids = '';
    
    $company_name = mysqli_real_escape_string($conn,$_POST['company_name']);
    $contact_no = mysqli_real_escape_string($conn,$_POST['contact_no']);
    $address_q = mysqli_real_escape_string($conn,$_POST['address_q']);
    $phone_no = mysqli_real_escape_string($conn,$_POST['phone_no']);
    $email_q = mysqli_real_escape_string($conn,$_POST['email_q']);
    $statement = mysqli_real_escape_string($conn,$_POST['statement']);
    $date_create_q = mysqli_real_escape_string($conn,$_POST['date_create_q']);
    $target_date = mysqli_real_escape_string($conn,$_POST['target_date']);
    $project_no = mysqli_real_escape_string($conn,$_POST['project_no']);
    $location_no = mysqli_real_escape_string($conn,$_POST['location_no']);
    $start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
    
    if(!empty($_POST["requirement_id"]))
    {
        foreach($_POST["requirement_id"] as $requirement_id)
        {
            $rrequirement_id .= $requirement_id.', ';
        }
         
    }
    if(!empty($_POST["tos_id"]))
    {
        foreach($_POST["tos_id"] as $tos_id)
        {
            $ttos_id .= $tos_id.', ';
        }
         
    }
    if(!empty($_POST["payment_ids"]))
    {
        foreach($_POST["payment_ids"] as $payment_ids)
        {
            $ppayment_ids .= $payment_ids.', ';
        }
         
    }
    $ppayment_ids = substr($ppayment_ids, 0, -2);
    $rrequirement_id = substr($rrequirement_id, 0, -2);
    $ttos_id = substr($ttos_id, 0, -2);
    $sql = "INSERT INTO tblQuotation_records (record_name,presentedby,record_addedby,requirement_id,tos_id,payment_ids,company_name,contact_no,address_q,phone_no,email_q,statement,date_create_q,target_date,project_no,location_no,start_date) 
            VALUES ('$record_name','$presentedby','$userID','$rrequirement_id','$ttos_id','$ppayment_ids','$company_name','$contact_no','$address_q','$phone_no','$email_q','$statement','$date_create_q','$target_date','$project_no','$location_no','$start_date')";
            if(mysqli_query($conn, $sql)){
             $last_id = mysqli_insert_id($conn);
             $quotation = mysqli_query($conn, "select * from tblQuotation_records where record_id = $last_id");
             foreach($quotation as $row){?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Presented By: <?= $row['presentedby']; ?></label>
                    </div>
                    <div class="col-md-5">
                        <label class="text-info"><?= $row['record_name']; ?></label>
                    </div>
                    <div class="col-md-4">
                        <label class="text-info"><?= date('Y-m-d', strtotime($row['date_create_q'])); ?></label>
                    </div>
                    <div class="col-md-3">
                        <a class="btn green btn-xs btn-outline btnView_category" data-toggle="modal" href="#" data-id="<?php echo $row["record_id"]; ?>">
                            <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
            <?php
         }
       } 
}
// view  category
if(isset($_GET["modalcategory"])) {
    $get_id = $_GET["modalcategory"];
    $query = mysqli_query($conn,"select * from tblQuotation_cat where category_id = '$get_id'");
    foreach($query as $row){?>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Category Name</label>
                    <input type="hidden" class="form-control" name="id" id="cat_id" value="<?= $get_id; ?>">
                    <input class="form-control" name="Category_Name" value="<?= $row['Category_Name']; ?>">
                </div>
            </div>
        <?php
     } 
}

if(isset($_POST['update_category'])){
    $id = $_POST['id'];
    $Category_Name = mysqli_real_escape_string($conn,$_POST['Category_Name']);
    
    $sql = "UPDATE tblQuotation_cat SET Category_Name='".$Category_Name."' WHERE category_id=$id";
    if (mysqli_query($conn, $sql)) {
        $id = $_POST['id'];
        $query_append = mysqli_query($conn,"select * from tblQuotation_cat where category_id = '$id'");
        foreach($query_append as $row_append){?>
        <div class="form-group" id="category_<?= $row_append['category_id'];?>">
            <div class="col-md-10">
                <label class="cat_<?= $row_append['category_id'];?>">
                    <?= $row_append['Category_Name'];?>
                </label>
            </div>
            <div class="col-md-2">
                <a class="btn green btn-xs btn-outline btnView_category" data-toggle="modal" href="#modalGet_category" data-id="<?php echo $row_append["category_id"]; ?>">
                    <i class="icon-pencil"></i>
                </a>
            </div>
        </div>
    <?php } }
}

// view  tos
if(isset($_GET["modaltos"])) {
    $get_id = $_GET["modaltos"];
    $query = mysqli_query($conn,"select * from tblQuotation_TOS where tos_id = '$get_id'");
    foreach($query as $row){?>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Terms</label>
                    <input type="hidden" class="form-control" name="id" id="tos_id" value="<?= $get_id; ?>">
                    <input class="form-control" name="tos_name" value="<?= $row['tos_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Desciption</label>
                    <textarea class="form-control" name="tos_description" rows="5"><?= $row['tos_description']; ?></textarea>
                </div>
            </div>
        <?php
     } 
}

if(isset($_POST['update_tos'])){
    $id = $_POST['id'];
    $tos_name = mysqli_real_escape_string($conn,$_POST['tos_name']);
    $tos_description = mysqli_real_escape_string($conn,$_POST['tos_description']);
    
    $sql = "UPDATE tblQuotation_TOS SET tos_name='".$tos_name."',tos_description='".$tos_description."' WHERE tos_id=$id";
    if (mysqli_query($conn, $sql)) {
        $id = $_POST['id'];
        $query_append = mysqli_query($conn,"select * from tblQuotation_TOS where tos_id = '$id'");
        foreach($query_append as $row_append){?>
        <div class="form-group" id="tos_<?= $row_append['tos_id'];?>">
            <div class="col-md-12">
                <label class="cat_<?= $row_append['tos_id'];?>">
                    <b><?= $row_append['tos_name'];?></b>
                </label>
            </div>
            <div class="col-md-10">
                <p>
                    <?= htmlspecialchars($row_append['tos_description']);?>
                </p>
            </div>
            <div class="col-md-2">
                <a class="btn green btn-xs btn-outline btnView_tos" data-toggle="modal" href="#modalGet_tos" data-id="<?php echo $row_append["tos_id"]; ?>">
                    <i class="icon-pencil"></i>
                </a>
            </div>
        </div>
    <?php } }
}

// add new category
if(isset($_POST['btnAdd_category'])){
    $id = $_COOKIE['ID'];
    $Category_Name = mysqli_real_escape_string($conn,$_POST['Category_Name']);
    
    $sql = "INSERT INTO tblQuotation_cat (Category_Name,catuser_cookie) 
            VALUES ('$Category_Name','$id')";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        $query_append = mysqli_query($conn,"select * from tblQuotation_cat where category_id = '$last_id'");
        foreach($query_append as $row_append){?>
        <div class="form-group" id="category_<?= $row_append['category_id'];?>">
            <div class="col-md-10">
                <label class="cat_<?= $row_append['category_id'];?>">
                    <?= $row_append['Category_Name'];?>
                </label>
            </div>
            <div class="col-md-2">
                <a class="btn green btn-xs btn-outline btnView_category" data-toggle="modal" href="#modalGet_category" data-id="<?php echo $row_append["category_id"]; ?>">
                    <i class="icon-pencil"></i>
                </a>
            </div>
        </div>
    <?php } }
}


// add new tos
if(isset($_POST['btnAdd_tos'])){
    $id = $_COOKIE['ID'];
    $tos_name = mysqli_real_escape_string($conn,$_POST['tos_name']);
    $tos_description = mysqli_real_escape_string($conn,$_POST['tos_description']);
    
    $sql = "INSERT INTO tblQuotation_TOS (tos_name,tos_description,tos_addedby) 
            VALUES ('$tos_name','$tos_description','$id')";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        $query_append = mysqli_query($conn,"select * from tblQuotation_TOS where tos_id = '$last_id'");
        foreach($query_append as $row_append){?>
        <div class="form-group" id="tos_<?= $row_append['tos_id'];?>">
            <div class="col-md-12">
                <label class="cat_<?= $row_append['tos_id'];?>">
                    <b><?= $row_append['tos_name'];?></b>
                </label>
            </div>
            <div class="col-md-10">
                <p>
                    <?= htmlspecialchars($row_append['tos_description']);?>
                </p>
            </div>
            <div class="col-md-2">
                <a class="btn green btn-xs btn-outline btnView_tos" data-toggle="modal" href="#modalGet_tos" data-id="<?php echo $row_append["tos_id"]; ?>">
                    <i class="icon-pencil"></i>
                </a>
            </div>
        </div>
    <?php } }
}

// add new payment
if(isset($_POST['btnAdd_payment'])){
    $id = $_COOKIE['ID'];
    $links_price = mysqli_real_escape_string($conn,$_POST['links_price']);
    $links = mysqli_real_escape_string($conn,$_POST['links']);
    
    $sql = "INSERT INTO tblQuotation_sublinks (links_price,links,links_addedby) 
            VALUES ('$links_price','$links','$id')";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        $query_append = mysqli_query($conn,"select * from tblQuotation_sublinks where links_id = '$last_id'");
        foreach($query_append as $row_append){?>
         <div class="form-group" id="payment_<?= $row_append['links_id'];?>">
            <br>
                <div class="col-md-12">
                    <label>
                        <input type="checkbox">
                        Price: $<?= $row_append['links_price'];?>
                    </label>
                </div>
                <div class="col-md-10">
                    <a href="<?= $row_append['links'];?>" target="_blank"><p><?= $row_append['links'];?></p></a>
                </div>
                <div class="col-md-2">
                    <a class="btn green btn-xs btn-outline btnView_payment" data-toggle="modal" href="#modalGet_payment" data-id="<?php echo $row_append["links_id"]; ?>">
                        <i class="icon-pencil"></i>
                    </a>
                </div>
        </div>
    <?php } }
}

// view  payment
if(isset($_GET["modalpay"])) {
    $get_id = $_GET["modalpay"];
    $query = mysqli_query($conn,"select * from tblQuotation_sublinks where links_id = '$get_id'");
    foreach($query as $row){?>
            <div class="form-group">
                <div class="col-md-12">
                     <div class="form-group">
                    <div class="col-md-12">
                        <label>Price</label>
                        <input class="form-control" type="hidden" name="id" id="pay_id" value="<?=$row['links_id']; ?>">
                        <input class="form-control" type="number" name="links_price" value="<?=$row['links_price']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Subscription Links</label>
                        <input class="form-control" type="url" name="links" value="<?=$row['links']; ?>">
                    </div>
                </div>
                </div>
            </div>
        <?php
     } 
}

if(isset($_POST['update_payment'])){
    $id = $_POST['id'];
    $links_price = mysqli_real_escape_string($conn,$_POST['links_price']);
    $links = mysqli_real_escape_string($conn,$_POST['links']);
    
    $sql = "UPDATE tblQuotation_sublinks SET links_price='".$links_price."',links='".$links."' WHERE links_id=$id";
    if (mysqli_query($conn, $sql)) {
        $id = $_POST['id'];
        $query_append = mysqli_query($conn,"select * from tblQuotation_sublinks where links_id = '$id'");
        foreach($query_append as $row_append){?>
        <div class="form-group" id="payment_<?= $row_append['links_id'];?>">
            <br>
                <div class="col-md-12">
                    <label>
                        <input type="checkbox">
                        Price: $<?= $row_append['links_price'];?>
                    </label>
                </div>
                <div class="col-md-10">
                    <a href="<?= $row_append['links'];?>" target="_blank"><p><?= $row_append['links'];?></p></a>
                </div>
                <div class="col-md-2">
                    <a class="btn green btn-xs btn-outline btnView_payment" data-toggle="modal" href="#modalGet_payment" data-id="<?php echo $row_append["links_id"]; ?>">
                        <i class="icon-pencil"></i>
                    </a>
                </div>
        </div>
    <?php } }
}

// view  records
if(isset($_GET["modalrecords"])) {
    $get_id = $_GET["modalrecords"];
    $query = mysqli_query($conn,"select * from tblQuotation_records where record_id = '$get_id'");
    foreach($query as $row){?>
           <table class="table table-bordered">
                <tbody >
                    <tr>
                        <td width="50px">Company:</td>
                        <td><input class="form-control no-border" value="<?= $row['company_name']; ?>" name="company_name"></td>
                        <td width="180px">Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime($row['date_create_q'])); ?>" name="date_create_q"></td>
                    </tr>
                    <tr>
                        <td width="50px">Contact:</td>
                        <td><input class="form-control no-border" value="<?= $row['contact_no']; ?>" name="contact_no"></td>
                        <td width="180px">Target Completion Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime($row['target_date'])); ?>" name="target_date"></td>
                    </tr>
                    <tr>
                        <td width="50px">Address</td>
                        <td><input class="form-control no-border" value="<?= $row['address_q']; ?>" name="address_q"></td>
                        <td width="180px">Project No.:</td>
                        <td><input class="form-control no-border" value="<?= $row['project_no']; ?>" name="project_no"></td>
                    </tr>
                    <tr>
                        <td width="50px">Phone:</td>
                        <td><input class="form-control no-border" value="<?= $row['phone_no']; ?>" name="phone_no"></td>
                        <td width="180px">Location:</td>
                        <td><input class="form-control no-border" value="<?= $row['location_no']; ?>" name="location_no"></td>
                    </tr>
                    <tr>
                        <td width="50px">Email:</td>
                        <td><input class="form-control no-border" value="<?= $row['email_q']; ?>" name="email_q"></td>
                        <td width="180px">Start Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime($row['start_date'])); ?>" name="start_date"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style=" table-layout: fixed;width: 100%;">
                <thead>
                    <tr>
                        <td>Need Statement</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <!--<p><span class="textarea"  role="textbox" contenteditable></span></p>-->
                            <textarea class="form-control no-border" name="statement"><?= $row['statement']; ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;">Service Scope Statement: The Scope of this engagement is to provide</th>
                    </tr>
                </thead>
            </table>
            <!--for services offer-->
            <table class="table table-bordered minusMtop">
                <thead>
                    <tr>
                        <th>Services</th>
                        <th>Service Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $array_req = explode(", ", $row["requirement_id"]);
                         $query = mysqli_query($conn,"select * from tblQuotation");
                        foreach($query as $row_req){
                        if(in_array($row_req['quote_id'],$array_req)){?>
                          <tr class="data_<?= $row_req['quote_id']; ?>">
                              <td>
                                  <?= $row_req['quote_name']; ?>
                                </td>
                              <td>$<?= number_format((float)$row_req['estimated_cost'], 2, '.', '');?></td>
                          </tr>
                       <?php } }
                    ?>
                </tbody>
            </table>
            <!--terms of services-->
            <table class="table table-bordered minusMtop">
                <thead>
                    <tr >
                        <td style="border:none;"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $array_tos = explode(", ", $row["tos_id"]);
                         $query_tos = mysqli_query($conn,"select * from tblQuotation_TOS");
                        foreach($query_tos as $row_tos){
                        if(in_array($row_tos['tos_id'],$array_tos)){?>
                          <tr class="data_tblterms<?= $row_tos['tos_id']; ?>">
                              <td>
                                  <input type="hidden" value="<?= $row_tos['tos_id']; ?>" name="tos_id[]">
                                  <?= $row_tos['tos_name']; ?>
                                </td>
                              <td><?= htmlspecialchars($row_tos['tos_description']);?></td>
                          </tr>
                       <?php } }
                    ?>
                </tbody>
                <tbody>
                    <?php
                        $array_pay = explode(", ", $row["payment_ids"]);
                         $query_pay = mysqli_query($conn,"select * from tblQuotation_sublinks");
                        foreach($query_pay as $row_pay){
                        if(in_array($row_pay['links_id'],$array_pay)){?>
                          <tr class="data_pay<?= $row['links_id']; ?>">
                              <td>
                                  <input type="hidden" value="<?= $row_pay['links_id']; ?>" name="payment_ids[]">
                                  <?= $row_pay['links_price']; ?>
                                </td>
                              <td><?= htmlspecialchars($row_pay['links']);?></td>
                          </tr>
                       <?php } }
                    ?>
                </tbody>
            </table>
        <?php
     } 
}
?>
