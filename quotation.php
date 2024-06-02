<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Quotation";
    $site = "quotation";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
    .no-border{
        border:none;
    }
    .bottom-border{
        border:none;
        border-bottom:solid #ccc 1px;
    }
    .requirements_box{
        overflow:scroll;
        height:68vh;
    }
    .requirements_box input{
        margin-top: 2rem !important;
    }
    .header_box{
        margin-left:1rem;
    }
    .float-right{
        float:right;
    }
    .minusMtop{
        margin-top:-2rem !important;
    }
    textarea {
    width: 100%;
    resize: none;
    }
    .textarea {
      border: none;
      font-family: inherit;
      font-size: inherit;
      padding: 1px 6px;
    }
    .width-machine {
      /*   Sort of a magic number to add extra space for number spinner */
      padding: 0 1rem;
    }
    .frame-wrapper {
  /*position: fixed;*/
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
}

.frame {
  position: absolute;
  width: 100%;
  height: 100%;
}
    .textarea {
      display: block;
      width: 100%;
      overflow: hidden;
      resize: both;
      min-height: 40px;
      line-height: 20px;
    }
    
    .textarea[contenteditable]:empty::before {
      content: "";
      border:none;
      color: gray;
    }
@media screen {
  #pdf_generate {
      /*display: none;*/
      
  }
  .front-page{
      display:none;
  }
}

@media print {
  body * {
    visibility:hidden;
    margin-top:0 !important;
  }
  .requirements_box{
       display:none;
    }
  /*@page { size: A4 portrait; }*/
  .front-page .front-page *{
      visibility:visible;
  }
  
  #pdf_generate, #pdf_generate * {
    visibility:visible;
    font-size:12px;
  }
  #pdf_generate {
    /*height: 100vh;*/
    /*width: 100vw;*/
    /*display: flex;*/
    /*align-items: center;*/
    /*justify-content: center;*/
  }
  .minusMtop{
       margin-top:-2rem !important;
    }
    .textarea {
      border:none !important;
      font-family: inherit;
      font-size: inherit;
      padding: 1px 6px;
    }
    .width-machine {
      /*   Sort of a magic number to add extra space for number spinner */
      padding: 0 1rem;
    }
    
    .textarea {
      display: block;
      width: 100%;
      overflow: hidden;
      resize: both;
      min-height: 40px;
      line-height: 20px;
    }
    
    .textarea[contenteditable]:empty::before {
      content: "";
      color: gray;
    }
    
  .front-page{
    margin-top:-20rem !important;
    height:98vh;
    margin-left:0px !important;
    margin-right:0px !important;
    text-align: center;
    border: 1px solid transparent;
  }
  .front-page .cig{
      margin-top:-30rem !important;
      float:left !important;
  }
  .front-page .iiq{
      margin-top:-30rem !important;
      float:right !important;
  }
  .front-page .title-cig{
      padding-top:165px!important;
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .front-page .title-iiq{
      padding-bottom:45px !important;
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .front-page .info-data{
      font-size:28px;
      padding-bottom:-75rem  !important;
      font-family:Helvetica;
  }
  .intro{font-size:28px;font-family:Helvetica;}
  .cIiq{
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .ddate{font-size:28px;font-family:Helvetica;}
  .pby{font-size:28px;font-family:Helvetica;}
      input[type="text"] {
        width: 100%;
    }
  table{padding:0px;}
}
</style>

<!--START MAIN ROW-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet light portlet-fit">
            <br>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Requirements&nbsp;
                                <a class="btn blue btn-xs btn-info btnView_requirement" data-toggle="modal" href="#add_requirement" ><i class="fa fa-plus"></i> Add Requirement</a>
                            </span>
                        </div>
                        <br>
                        <div class="header_box">
                            <div class="form-group">
                                <select id="single-append-radio" class="form-control select2-allow-clear" onchange="search_filter(this.value)" placeholder="Company Name">
                                    <option></option>
                                    <?php
                                       
                                        $queryType = "SELECT * FROM tbl_Customer_Relationship where account_name !='' order by account_name ASC";
                                        $resultType = mysqli_query($conn, $queryType);
                                    while($rowType = mysqli_fetch_array($resultType))
                                         { 
                                           echo '<option value="'.$rowType['crm_id'].'" >'.$rowType['account_name'].'</option>'; 
                                       } 
                                     ?>
                                </select>
                            </div>
                        
                             <div class="portlet-title tabbable-tabdrop tabbable-line">
                                 <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#services_tab" data-toggle="tab">Services</a>
                                    </li> 
                                    <li>
                                        <a href="#Paymenttab" data-toggle="tab">Payment</a>
                                    </li> 
                                    <li>
                                        <a href="#termstab" data-toggle="tab">Terms</a>
                                    </li> 
                                     <li>
                                        <a href="#category" data-toggle="tab">Category</a>
                                    </li>
                                    <li>
                                        <a href="#rec" data-toggle="tab">Records</a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        <div class="requirements_box">    
                         <div class="tab-content">
                             <div class="tab-pane" id="category">
                                 <div class="form-group">
                                     <br>
                                     <div class="col-md-12">
                                         <a class="btn blue btn-xs btn-info add_category" data-toggle="modal" href="#add_category" ><i class="fa fa-plus"></i> Add Category</a>
                                     </div>
                                     <hr>
                                 </div>
                                 <?php
                                    $query_cat = mysqli_query($conn,"select * from tblQuotation_cat order by Category_Name ASC");
                                    foreach($query_cat as $row_cat){?>
                                    
                                    <div class="form-group" id="category_top"></div>
                                    <div class="form-group" id="category_<?= $row_cat['category_id'];?>">
                                        <div class="col-md-10">
                                            <label class="cat_<?= $row_cat['category_id'];?>">
                                                <?= $row_cat['Category_Name'];?>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn green btn-xs btn-outline btnView_category" data-toggle="modal" href="#modalGet_category" data-id="<?php echo $row_cat["category_id"]; ?>">
                                                <i class="icon-pencil"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="tab-pane" id="Paymenttab">
                                    <div class="form-group">
                                         <br>
                                         <div class="col-md-12">
                                             <a class="btn blue btn-xs btn-info add_payment" data-toggle="modal" href="#add_payment" ><i class="fa fa-plus"></i> Add Payment</a>
                                         </div>
                                     </div>
                                     <div class="form-group" id="payment_top"></div>
                                     <?php
                                        $query_subs = mysqli_query($conn,"select * from tblQuotation_sublinks order by links_price ASC");
                                        foreach($query_subs as $row_subs){?>
                                        <div class="form-group" id="payment_<?= $row_subs['links_id'];?>">
                                            <br>
                                                <div class="col-md-12">
                                                    <label class="payment_label<?= $row_subs['links_id'];?>">
                                                        <input type="checkbox" id="checked_payment" onclick="get_payment(this)" value="<?= $row_subs['links_id'];?>">
                                                        Price: $<?= $row_subs['links_price'];?>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <a href="<?= $row_subs['links'];?>" target="_blank"><p><?= $row_subs['links'];?></p></a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn green btn-xs btn-outline btnView_payment" data-toggle="modal" href="#modalGet_payment" data-id="<?php echo $row_subs["links_id"]; ?>">
                                                        <i class="icon-pencil"></i>
                                                    </a>
                                                </div>
                                        </div>
                                    <?php }?>
                            </div>
                            <div class="tab-pane" id="termstab">
                                    <div class="form-group">
                                         <br>
                                         <div class="col-md-12">
                                             <a class="btn blue btn-xs btn-info add_tos" data-toggle="modal" href="#add_tos" ><i class="fa fa-plus"></i> Add Terms of Service</a>
                                         </div>
                                         <hr>
                                     </div>
                                     
                                    <div class="form-group" id="tos_top"></div>
                                     <?php
                                        $query_tos = mysqli_query($conn,"select * from tblQuotation_TOS order by tos_name ASC");
                                        foreach($query_tos as $row_tos){?>
                                        <div class="form-group" id="tos_<?= $row_tos['tos_id'];?>">
                                            <div class="col-md-12">
                                                <label class="terms_label<?= $row_tos['tos_id'];?>" >
                                                    <input type="checkbox" id="checked_terms" onclick="get_terms(this)" value="<?= $row_tos['tos_id'];?>">
                                                    <b><?= $row_tos['tos_name'];?></b>
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <p>
                                                    <?= htmlspecialchars($row_tos['tos_description']);?>
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn green btn-xs btn-outline btnView_tos" data-toggle="modal" href="#modalGet_tos" data-id="<?php echo $row_tos["tos_id"]; ?>">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php }?>
                            </div>
                        
                            <div class="tab-pane" id="rec">
                                <div id="qrecords"></div>
                                <?php
                                $quotation = mysqli_query($conn, "select * from tblQuotation_records order by date_create_q desc ");
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
                                            <a class="btn green btn-xs btn-outline btnView_records" data-toggle="modal" href="#modalGet_records" data-id="<?php echo $row["record_id"]; ?>">
                                                <i class="icon-pencil"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php }
                                ?>
                            </div>
                             <div class="tab-pane active" id="services_tab">
                                    <!--start-->
                                    <div class="form-group" id="services_top">
                                        
                                    </div>
                                    <?php
                                        $query = mysqli_query($conn,"select * from tblQuotation order by quote_name ASC");
                                        foreach($query as $row){?>
                                            
                                            <div class="form-group" id="requirements_<?= $row['quote_id'];?>">
                                                <div class="col-md-12">
                                                    <label class="text_<?= $row['quote_id'];?>">
                                                        <input type="checkbox" class="value_data" id="checked_data" onclick="get_data(this)" value="<?= $row['quote_id'];?>">
                                                        <?= $row['quote_name'];?>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <a class="btn dark btn-xs btn-outline">Estimated: <?= $row['estimated_hrs'];?> hrs</a>
                                                    <a href="quotation_files/<?= $row['file_attch']; ?>" class="btn dark btn-xs btn-outline" title="<?= $row['file_attch']; ?>" target="_blank">
                                                        <?php 
                                                            $ext = pathinfo($row['file_attch'], PATHINFO_EXTENSION);
                                                            if(!empty($ext)){echo strtoupper($ext);}else{echo 'No File';}
                                                        ?>
                                                    </a>
                                                    <a class="btn dark btn-xs btn-outline">Estimated Cost: $<?= number_format((float)$row['estimated_cost'], 2, '.', '');?></a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn green btn-xs btn-outline btnView_requirement" data-toggle="modal" href="#modalGet_requirement" data-id="<?php echo $row["quote_id"]; ?>"><i class="icon-pencil"></i></a>
                                                </div>
                                            </div>
                                       <?php }
                                    ?>
                                    <!--end-->
                                </div>
                                <div class="tab-pane" id="ro">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                    <form method="post" class="form-horizontal modalForm form_quotaion">
                        <div class="form-group">
                            <div class="col-md-5">
                                    <input class="form-control" name="record_name" placeholder="Quotation Name"> 
                            </div>
                            <div class="col-md-5">
                                    <?php
                                        $user_id = $_COOKIE['ID'];
                                        $presentedby_query = mysqli_query($conn, "select * from tbl_user where ID = $user_id");
                                        foreach($presentedby_query as $row_pres){?>
                                            <input class="form-control" name="presentedby" value="<?= $row_pres['first_name']; ?> <?= $row_pres['last_name']; ?>" placeholder="Presented by">
                                       <?php }
                                    ?>
                            </div>
                             <div class="col-md-2">
                                    <input type="submit" name="btnSave_quotaion" id="btnSave_quotaion" value="SAVE" class="btn blue btn-sm float-right"> 
                                    <a class="btn red btn-sm float-right" type="button" id="pdf_report">PDF</a>
                            </div>
                        </div>
                        <!--quotation-->
                        <div id="pdf_generate" >
                            <div class="front-page" >
                                <img class="cig" src="quotation_files/logo/cig.png" width="115px">
                                <img class="iiq" src="quotation_files/logo/iiqv2.png" width="115px">
                                <br>
                                <br>
                                <br>
                                <br>
                                <h3 class="title-cig">Consultare Inc. Group</h3>
                                <h3 class="title-iiq">InterlinkIQ Inc.</h3>
                                <br>
                                <br>
                                <h4 class="intro">Proudly presents the following services to:</h4>
                                <br>
                                <h1 class="cIiq">Company Name IIQ</h1>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h4 class="ddate">Date: <?= date('Y-m-d'); ?></h4>
                                <br>
                                <h4 class="pby">Presented By: XXXXX IIQ</h4>
                                <br>
                                <br>
                                <div class="info-data" style="font-family:Helvetica;">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><h4>202-982-3002</h4></td>
                                            <td><h4>enterprise@interlinkiq.com</h4></td>
                                            <td><h4>www.InterlinkIQ.com</h4></td>
                                        </tr>
                                    </table>
                                    <h4>1331 Pine Trail Tomball TX 77375</h4>
                                </div>
                            </div>
                            <div class="contact_data" >
                                <table class="table table-bordered">
                                    <tbody >
                                        <tr>
                                            <td width="50px">Company:</td>
                                            <td><input class="form-control no-border" placeholder="" name="company_name"></td>
                                            <td width="180px">Date:</td>
                                            <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="date_create_q"></td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Contact:</td>
                                            <td><input class="form-control no-border" placeholder="" name="contact_no"></td>
                                            <td width="180px">Target Completion Date:</td>
                                            <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="target_date"></td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Address</td>
                                            <td><input class="form-control no-border" placeholder="" name="address_q"></td>
                                            <td width="180px">Project No.:</td>
                                            <td><input class="form-control no-border" placeholder="" name="project_no"></td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Phone:</td>
                                            <td><input class="form-control no-border" placeholder="" name="phone_no"></td>
                                            <td width="180px">Location:</td>
                                            <td><input class="form-control no-border" placeholder="" name="location_no"></td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Email:</td>
                                            <td><input class="form-control no-border" placeholder="" name="email_q"></td>
                                            <td width="180px">Start Date:</td>
                                            <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="start_date"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                            <textarea class="form-control no-border" name="statement"></textarea>
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
                                        <!--<th>Estimated(hours)</th>-->
                                        <!--<th>File</th>-->
                                        <th>Service Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="data_table"></tbody>
                                <!--<tbody class="data_terms_table"></tbody>-->
                                <!-- <tbody class="data_payment_table"></tbody>-->
                            </table>
                            
                            <!--terms of services-->
                            <table class="table table-bordered minusMtop">
                                <thead>
                                    <tr >
                                        <td style="border:none;"></td>
                                    </tr>
                                </thead>
                                <tbody class="data_terms_table"></tbody>
                                <tbody class="data_payment_table"></tbody>
                            </table>
                            
                            <!--payment subscription-->
                            <!--<table class="table table-bordered minusMtop">-->
                            <!--    <thead>-->
                            <!--        <tr>-->
                            <!--            <td></td>-->
                            <!--        </tr>-->
                            <!--    </thead>-->
                            <!--    <tbody class="data_payment_table"></tbody>-->
                            <!--</table>-->
                            <div >
                                <!--id="data_file"-->
                                <?php if($_COOKIE['ID']==38): ?>
                                    <!--<iframe width="100%" src="terms_of_services/pdfviewer.php" id="wyngiframe" scrolling="no" frameborder="0"></iframe>-->
                                       
                                    <!--<div class="frame-wrapper">-->
                                    <!--  <iframe class="frame" src="terms_of_services/pdfviewer.php" frameborder="0"></iframe>-->
                                    <!--</div> -->
                                
                                <?php endif;?>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END BORDERED TABLE PORTLET-->
    </div>
   <!-- MODAL AREA -->
   <?php include "quotation_folder/quote_modals.php";  ?>
    <!-- / END MODAL AREA -->
</div>
<!-- END MAIN ROW -->
<?php include_once ('footer.php'); ?>
 <script src="assets/global/plugins/datatables/datatable_custom.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>

<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

<script src="assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
 
<script>

// View requirement
 $(".btnView_requirement").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "quotation_folder/functions.php?modalView="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_requirement .modal-body").html(data);
            selectMulti();
        }
    });
});
$(".modalGet_requirement").on('submit',(function(e) {
    e.preventDefault();
    var req_id = $("#req_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('update_requirement',true);

    var l = Ladda.create(document.querySelector('#update_requirement'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#requirements_'+req_id).empty();
                $('#requirements_'+req_id).html(response);
                $('#modalGet_requirement').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// add new requirement
$(".add_requirement").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_requirement',true);

    var l = Ladda.create(document.querySelector('#btnAdd_requirement'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#services_top').append(response);
                $('#add_requirement').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));


// save new quotaion
$(".form_quotaion").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_quotaion',true);

    var l = Ladda.create(document.querySelector('#btnSave_quotaion'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#qrecords').append(response);
                // $('#add_requirement').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
// View category
 $(".btnView_category").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "quotation_folder/functions.php?modalcategory="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_category .modal-body").html(data);
            selectMulti();
        }
    });
});
$(".modalGet_category").on('submit',(function(e) {
    e.preventDefault();
    var cat_id = $("#cat_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('update_category',true);

    var l = Ladda.create(document.querySelector('#update_category'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#category_'+cat_id).empty();
                $('#category_'+cat_id).html(response);
                $('#modalGet_category').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// View payment
 $(".btnView_payment").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "quotation_folder/functions.php?modalpay="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_payment .modal-body").html(data);
            selectMulti();
        }
    });
});
$(".modalGet_payment").on('submit',(function(e) {
    e.preventDefault();
    var pay_id = $("#pay_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('update_payment',true);

    var l = Ladda.create(document.querySelector('#update_payment'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#payment_'+pay_id).empty();
                $('#payment_'+pay_id).html(response);
                $('#modalGet_payment').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
// View tos
 $(".btnView_tos").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "quotation_folder/functions.php?modaltos="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_tos .modal-body").html(data);
            selectMulti();
        }
    });
});
$(".modalGet_tos").on('submit',(function(e) {
    e.preventDefault();
    var tos_id = $("#tos_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('update_tos',true);

    var l = Ladda.create(document.querySelector('#update_tos'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#tos_'+tos_id).empty();
                $('#tos_'+tos_id).html(response);
                $('#modalGet_tos').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// View records
 $(".btnView_records").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "quotation_folder/functions.php?modalrecords="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_records .modal-body").html(data);
            selectMulti();
        }
    });
});
$(".modalGet_records").on('submit',(function(e) {
    e.preventDefault();
    var tos_id = $("#tos_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('update_records',true);

    var l = Ladda.create(document.querySelector('#update_records'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#tos_'+tos_id).empty();
                $('#tos_'+tos_id).html(response);
                $('#modalGet_records').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
// add new category
$(".add_category").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_category',true);

    var l = Ladda.create(document.querySelector('#btnAdd_category'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#category_top').append(response);
                $('#add_category').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// add new payment
$(".add_payment").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_payment',true);

    var l = Ladda.create(document.querySelector('#btnAdd_payment'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#payment_top').append(response);
                $('#add_payment').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// add new tos
$(".add_tos").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_tos',true);

    var l = Ladda.create(document.querySelector('#btnAdd_tos'));
    l.start();

    $.ajax({
        url: "quotation_folder/functions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                $('#tos_top').append(response);
                $('#add_tos').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
//search 
function search_filter(search_field){
   var search_val = $('#single-append-radio').val();
    $("pdf_report").html(search_val);
    $.ajax({
        url:'quotation_folder/fetch_contacts.php',
        method: 'POST',
        data: {search_val:search_val,search_field:search_field},
        success:function(data){
            // alert(data);
            $(".contact_data").empty();
            $(".contact_data").html(data);
        }
    });
 }

function get_data(val){
    if(val.checked == true){
         $.ajax({  
            url:"quotation_folder/fetch_requirements.php",  
            method:"POST",  
            data:{ val:val.value},  
            success:function(data){
                $(".text_"+val.value).css({"color":"green","text-decoration": "line-through"});
                $('.data_table').append(data);  
            }  
       }); 
    }
    else{
        $(".text_"+val.value).css({"color":"","text-decoration": "none"});
       $('.data_'+val.value).remove();
    }
    
    //
     $.ajax({  
        url:"quotation_folder/view_file.php",  
        method:"POST",  
        data:{ val:val.value},  
        success:function(data){
            // alert(data);
            $('#data_file').append(data);  
        }  
   });
} 

// get_payment
function get_payment(val){
    if(val.checked == true){
         $.ajax({  
            url:"quotation_folder/fetch_payment.php",  
            method:"POST",  
            data:{ val:val.value},  
            success:function(data){
                $(".payment_label"+val.value).css({"color":"green","text-decoration": "line-through"});
                $('.data_payment_table').append(data);  
            }  
       }); 
    }
    else{
        $(".payment_label"+val.value).css({"color":"","text-decoration": "none"});
       $('.data_pay'+val.value).remove();
    }
} 

// get_payment
function get_terms(val){
    if(val.checked == true){
         $.ajax({  
            url:"quotation_folder/fetch_ToS.php",  
            method:"POST",  
            data:{ val:val.value},  
            success:function(data){
                $(".terms_label"+val.value).css({"color":"green","text-decoration": "line-through"});
                $('.data_terms_table').append(data);  
            }  
       }); 
    }
    else{
        $(".terms_label"+val.value).css({"color":"","text-decoration": "none"});
       $('.data_tblterms'+val.value).remove();
    }
}

// if checked
$('.value_data').click(function(){
   var checkboxes_value = []; 
    var inputval =$(".value_data").val();
   $('.value_data').each(function(){ 
        if(this.checked) {              
             checkboxes_value.push($(this).val());                                                                               
        }
   });                              
   checkboxes_value = checkboxes_value.toString(); 
});

//pdt report
$(document).on('click', '#pdf_report', function(){
    //var post_id = $(this).attr('data-id');
    $("#pdf_generate").html();
    window.print();
}); 




let widthMachine = document.querySelector(".width-machine");

// Dealing with Textarea Height
function calcHeight(value) {
  let numberOfLineBreaks = (value.match(/\n/g) || []).length;
  // min-height + lines x line-height + padding + border
  let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
  return newHeight;
}

let textarea = document.querySelector(".resize-ta");
textarea.addEventListener("keyup", () => {
  textarea.style.height = calcHeight(textarea.value) + "px";
});


</script>
<style>


/*end meeting minutes*/
            /*Loader*/
.loader {
  display: inline-block;
  width: 30px;
  height: 30px;
  position: relative;
  border: 4px solid #Fff;
  top: 50%;
  animation: loader 2s infinite ease;
}

.loader-inner {
  vertical-align: top;
  display: inline-block;
  width: 100%;
  background-color: #fff;
  animation: loader-inner 2s infinite ease-in;
}

@keyframes loader {
  0% {
    transform: rotate(0deg);
  }
  
  25% {
    transform: rotate(180deg);
  }
  
  50% {
    transform: rotate(180deg);
  }
  
  75% {
    transform: rotate(360deg);
  }
  
  100% {
    transform: rotate(360deg);
  }
}

@keyframes loader-inner {
  0% {
    height: 0%;
  }
  
  25% {
    height: 0%;
  }
  
  50% {
    height: 100%;
  }
  
  75% {
    height: 100%;
  }
  
  100% {
    height: 0%;
  }
}
        </style>
    </body>
</html>