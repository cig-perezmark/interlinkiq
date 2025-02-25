<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Insurance Information";
    $site = "insurance_info";
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
    .float-right{
        float:right;
    }
    .float-left{
        float:left;
    }
    .float-center{
        float:center;
    }
    .minus-top{
        /*margin-top:-3rem;*/
    }
</style>

<!--START MAIN ROW-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet light portlet-fit">
            <div class="portlet-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <br>
                          <select class="form-control select2-allow-clear" id="single-append-radio" onchange="search_filter(this.value)">
                              <option value="0">--Select--</option>
                              <?php
                                $query = mysqli_query($conn, "select *  from tbl_insur_select order by select_name ASC");
                                foreach($query as $row){?>
                                    <option value="<?=  $row['select_id']; ?>" <?php if($row['select_id']==1){echo 'selected';}else{echo '';} ?>><?=  $row['select_name']; ?></option>
                               <?php }
                              ?>
                              
                          </select>
                      </div>
                  </div>
                  <div class="col-md-12" style="max-height:90vh;overflow-y:scroll;">
                      <div class="contact_data"></div>
                      <div id="active_data" >
                          <?php
                            $query = mysqli_query($conn,"select *from tblEnterpiseDetails where users_entities = '$switch_user_id' limit 1");
                            foreach($query as $row){
                            ?>
                                    <h3>Applicant Information</h3>
                                    <br>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="50px"><label class="form-control no-border">Name Insured:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control no-border" value="<?= $row['businessname']; ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50px"><label class="form-control no-border">Address:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <input class="form-control no-border" value="<?= $row['Bldg']; ?> <?= $row['city']; ?>, <?= $row['States']; ?> <?= $row['ZipCode']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                                <?php 
                                                                $cid = $row['country'];
                                                                $resultcountry = mysqli_query($conn, "select * from countries where id = $cid");
                                                                 while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                 { ?>
                                                                    <input class="form-control no-border" value="<?php echo utf8_encode($rowcountry['name']); ?>">
                                                                <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50px"><label class="form-control no-border">Phone:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control no-border" value="<?= $row['businesstelephone']; ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="180px"><label class="form-control no-border">Contact Person:</label></td>
                                                <td> 
                                                    <?php 
                                                       
                                                        $queries = "SELECT * FROM tblEnterpiseDetails_Contact where user_cookies = '$switch_user_id' limit 1";
                                                        $resultQuery = mysqli_query($conn, $queries);
                                                        while($rowq = mysqli_fetch_array($resultQuery)){ ?>
                                                                <div class="form-group">
                                                                    <div class="col-md-4">
                                                                        <input class="form-control no-border" value="<?php echo $rowq['contactpersonname']; ?> <?php echo $rowq['contactpersonlastname']; ?>">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="col-md-5">
                                                                            <label class="form-control no-border">Cell No.: </label>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <input class="form-control no-border" value="<?php echo $rowq['contactpersoncellno']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="col-md-3">
                                                                            <label class="form-control no-border">Phone:  </label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input class="form-control no-border" value="<?php echo $rowq['contactpersonphone']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                    <?php } ?>
                                                 </td>
                                            </tr>
                                            <tr>
                                                <td width="50px"><label class="form-control no-border">Website:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control no-border" value="<?= $row['businesswebsite']; ?>"> 
                                                            <!--<a href="https://" target="_blank"><i class="fa fa-eye"></i></a>-->
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="180px"><label class="form-control no-border">Date Established:</label></td>
                                               <td>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control no-border" value="<?= $row['YearEstablished']; ?>">
                                                        </div>
                                                    </div>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="40%">Prior experience in this business under any other name:</td>
                                                <td>
                                                    <label>
                                                        <input class="no-border"type="radio" name="checkradio">
                                                        Yes
                                                    </label>
                                                    &nbsp;
                                                    <label>
                                                        <input class="no-border"type="radio" name="checkradio">
                                                        No
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%">If so (Yes), please provide the name of the entity:</td>
                                                <td>
                                                    <input class="form-control no-border" value="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--<div clas="form-group">-->
                                    <!--    <div>-->
                                    <!--        <input type="submit" class="btn blue btn-primary float-right" value="Save">-->
                                    <!--    </div>-->
                                    <!--</div>-->
                            <?php }
                          ?>
                          <h3>Officer(s)</h3>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th>Title</th>
                                      <th>Ownership %</th>
                                      <th>Work Comp Class Code</th>
                                      <th>Include or Exclude for Work Comp Coverage</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody id="dynamic_field_officer">
                                  <tr>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                      <td><button type="button" name="add_officer_row" id="add_officer_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <h3>Sales</h3>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Total US Gross Sales Item</th>
                                      <th>Estimated __/__/ to __/__/</th>
                                      <th>Projected __/__/ to __/__/</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody id="dynamic_field_us">
                                  <tr>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border" placeholder="$"></td>
                                      <td><input class="form-control no-border" placeholder="$"></td>
                                      <td><button type="button" name="add_us_row" id="add_us_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                  </tr>
                              </tbody>
                          
                              <tbody id="dynamic_field_foreign">
                                  <tr>
                                      <th>Total Foreign Gross Sales</th>
                                      <th>Estimated __/__/ to __/__/</th>
                                      <th>Projected __/__/ to __/__/</th>
                                      <th></th>
                                  </tr>
                                  <tr>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border" placeholder="$"></td>
                                      <td><input class="form-control no-border" placeholder="$"></td>
                                      <td><button type="button" name="add_foreign_row" id="add_foreign_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <table class="table table-bordered minus-top">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th><center>Split By Country</center></th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                      <td><input class="form-control no-border"></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <h3>Annual Revenue</h3>
                        <p>(Total Annual Revenue Last 2 years):</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><label class="form-control no-border B">Year</label> </th>
                                    <th><label class="form-control no-border B">Total</label> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = mysqli_query($conn, "select * from tbl_insur_ar");
                                    foreach($query as $row){?>
                                        <tr>
                                            <td><input class="form-control no-border" value="<?=$row['ar_year']; ?>"></td>
                                            <td><input class="form-control no-border" value="<?= number_format($row['ar_total'],2); ?>"></td>
                                        </tr>
                                   <?php }
                                ?>
                            </tbody>
                        </table>
                      </div>
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
//multiple table customer
$(document).on('click', '#add_customer_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_customer_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_customer').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_customer_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblcustomer'+button_id+'').remove();
    });
   
});


//multiple table officer
$(document).on('click', '#add_officer_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_officer_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_officer').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_officer_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblofficer'+button_id+'').remove();
    });
   
});

//multiple table US
$(document).on('click', '#add_us_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_us_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_us').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_us_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblus'+button_id+'').remove();
    });
   
});


//multiple table foreign
$(document).on('click', '#add_foreign_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_foreign_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_foreign').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_foreign_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblforeign'+button_id+'').remove();
    });
   
});

//search dropdown
function search_filter(search_field){
   var search_val = $('#single-append-radio').val();
    
    // Applicant Information table
    if(search_val == 1){
            $.ajax({
            url:'insurance_folder/applicant_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 4){
            $.ajax({
            url:'insurance_folder/annual_revenue_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 7){
            $.ajax({
            url:'insurance_folder/coverage_option.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 8){
            $.ajax({
            url:'insurance_folder/desc_of_operation_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 15){
            $.ajax({
            url:'insurance_folder/branded_product_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 16){
            $.ajax({
            url:'insurance_folder/co_manufacturing_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }
    else if(search_val == 19){
            $.ajax({
            url:'insurance_folder/customers_form.php',
            method: 'POST',
            data: {search_val:search_val},
            success:function(data){
                $("#active_data").empty();
                $(".contact_data").empty();
                $(".contact_data").html(data);
            }
        });
    }else{ alert('data not found');}
 }
 
</script>
<style>
.600{
    font-weight:600;
}
.B{
    font-weight:bold;
}
.no-border{
        border:none;
    }
    .bottom-border{
        border:none;
        border-bottom:solid #ccc 1px;
    }

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
