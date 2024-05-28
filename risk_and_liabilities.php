<?php 
    $title = "Risk & Liabilities";
    $site = "insurance_info";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Organization';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>

@media screen {
  #data_print {
      visibility:hidden;
  }
  
}

@media print {
  body * {
    visibility:hidden;
  }
  html, body {
        height: 99%;    
    }
  #data_print, #data_print * {
    visibility:visible;
    
  }
  #data_print{
    font-size:12px !important;
    margin-top:-7rem !important;
    }
    .profile-content{
      visibility:hidden;
      display:none !important;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title  tabbable-tabdrop tabbable-line">
                            <div class="col-md-3">
                                <div class="caption caption-md" id="org_title">
                                    <span class="caption-subject font-blue-madison bold uppercase" >Risk & Liabilities</span>
                                    <button type="button" name="print_btn" id="print_btn" class="btn green btn-xs  float-right"><b><i class="fa fa-print"></i> Print</b></button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#ai_tab" data-toggle="tab" >Organization</a>
                                    </li>
                                    <li>
                                        <a href="#o_tab" data-toggle="tab">Officer(s)</a>
                                    </li>
                                    <li>
                                        <a href="#s_tab" data-toggle="tab">Sales</a>
                                    </li>
                                    <li>
                                        <a href="#ar_tab" data-toggle="tab">Annual Revenue</a>
                                    </li>
                                    <li>
                                        <a href="#p_tab" data-toggle="tab">Payroll</a>
                                    </li>
                                    <li>
                                        <a href="#ne_tab" data-toggle="tab">No. of Employees</a>
                                    </li>
                                    <li>
                                        <a href="#co_tab" data-toggle="tab">Coverage Options</a>
                                    </li>
                                     <li>
                                        <a href="#do_tab" data-toggle="tab">Description of Operations</a>
                                    </li>
                                     <li>
                                        <a href="#dp_tab" data-toggle="tab">Description of Products</a>
                                    </li>
                                    <li>
                                        <a href="#tpf_tab" data-toggle="tab">No. of Plants and Facilities</a>
                                    </li>
                                    
                                    <li>
                                        <a href="#pbp_tab" data-toggle="tab">Product By Plant</a>
                                    </li>
                                    <li>
                                        <a href="#psc_tab" data-toggle="tab">Product Specific Coverage</a>
                                    </li>
                                    <li>
                                        <a href="#i_tab" data-toggle="tab">Import(s)</a>
                                    </li>
                                    <li>
                                        <a href="#bp_tab" data-toggle="tab">Branded Products</a>
                                    </li>
                                    <li>
                                        <a href="#cm_tab" data-toggle="tab">Co-Manufacturing</a>
                                    </li>
                                    <li>
                                        <a href="#np_tab" data-toggle="tab">New Products</a>
                                    </li>
                                    
                                    <li>
                                        <a href="#d_tab" data-toggle="tab">Distribution</a>
                                    </li>
                                    <li>
                                        <a href="#c_tab" data-toggle="tab">Customers</a>
                                    </li>
                                    <li>
                                        <a href="#sl_tab" data-toggle="tab">Shelf Life</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                          
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!--start-->
                               <div class="tab-pane active" id="ai_tab">
                                    <!--applicant form here!!-->
                                </div>
                                <div class="tab-pane" id="o_tab">
                                    <!--officer form here!!-->
                                    <form method="post" class="form-horizontal modalForm modal_new_officer">
                                            <div class="form-group">
                                                <div class="col-md-8"><h3>Officer(s)</h3></div>
                                                <div class="col-md-4">
                                                    
                                                </div>
                                            </div>
                                              <div class="table-scrollable">
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
                                                      <tbody id="data_officer">
                                                      </tbody>
                                                      <tbody id="dynamic_field_officer">
                                                          <tr>
                                                              <td><input class="form-control no-border" name="officer_name[]"></td>
                                                              <td><input class="form-control no-border" name="officer_title[]"></td>
                                                              <td><input class="form-control no-border" name="ownership[]"></td>
                                                              <td><input class="form-control no-border" name="class_code[]"></td>
                                                              <td><input class="form-control no-border" name="comp_coverage[]"></td>
                                                              <td><button type="button" name="add_officer_row" id="add_officer_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </div>
                                        <br>
                                        <div class="col-md-12">
                                            <input class="btn green float-right" type="submit" name="btnAdd_officer" id="btnAdd_officer" value="Save" >
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="s_tab">
                                    <form method="post" class="form-horizontal modalForm modal_new_sales">
                                    <h3>Sales</h3>
                                    <br>
                                    <div class="table-scrollable no-border">
                                      <div id="data_sales"></div>
                                    </div>
                                      <div class="col-md-12">
                                            <input class="btn green float-right" type="submit" name="btnAdd_sales" id="btnAdd_sales" value="Save" >
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="ar_tab">
                                    <form method="post" class="form-horizontal modalForm modal_new_annual_revenue">
                                    <h3>Annual Revenue</h3>
                                    <p>(Total Annual Revenue Last 2 years):</p>
                                    <div class="table-scrollable">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><label class="form-control no-border B">Year</label> </th>
                                                    <th><label class="form-control no-border B">Total</label> </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data_annual">
                                            </tbody>
                                            <tbody id="dynamic_field_annual">
                                                <tr>
                                                    <td><input class="form-control no-border" name="ar_year[]"></td>
                                                    <td><input class="form-control no-border" name="ar_total[]"></td>
                                                    <td><button type="button" name="add_ar_row" id="add_ar_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        <input class="btn green float-right" type="submit" name="btnAdd_annual" id="btnAdd_annual" value="Save" >
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="p_tab">
                                    <form method="post" class="form-horizontal modalForm form_new_payroll">
                                    <h3>Payroll</h3>
                                    <br>
                                    <div id="payroll_form">
                                        
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="ne_tab">
                                    <h3>No. of Employees</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_new_no_employees">
                                        <div class="table-scrollable">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>USA/Canada</th>
                                                    <th>European Union</th>
                                                    <th>Rest of World</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data_no_employee">
                                                
                                            </tbody>
                                            <tbody id="dynamic_field_no_emp">
                                                <tr>
                                                    <td><input class="form-control no-border" name="emp_total[]" placeholder=""></td>
                                                    <td><input class="form-control no-border" name="emp_usa_canada[]" placeholder=""></td>
                                                    <td><input class="form-control no-border" name="emp_european_union[]" placeholder=""></td>
                                                    <td><input class="form-control no-border" name="emp_rest_of_world[]" placeholder=""></td>
                                                    <td><button type="button" name="add_no_emp_row" id="add_no_emp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        <input class="btn green float-right" type="submit" name="btnAdd_no_emp" id="btnAdd_no_emp" value="Save" >
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="co_tab">
                                    <h3>Coverage Options</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_new_coverage">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><label class="form-control no-border B">Options</label> </th>
                                                        <th><label class="form-control no-border B">Limit Options</label> </th>
                                                        <th><label class="form-control no-border B">Retention Options</label> </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_coverage"></tbody>
                                                <tbody id="dynamic_field_coverage">
                                                    <tr>
                                                        <td><input class="form-control no-border" name="options[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="limits[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="retention[]" placeholder=""></td>
                                                        <td><button type="button" name="add_coverage_row" id="add_coverage_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                                    <div clas="form-group">
                                        <div>
                                            <input class="btn green float-right" type="submit" name="btnAdd_coverage" id="btnAdd_coverage" value="Save" >
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="do_tab">
                                    <h3>Description of Operations</h3>
                                    <p>Enterprise Process</p>
                                    <form method="post" class="form-horizontal modalForm form_business_process">
                                    <div id="business_process">
                                        
                                    </div>
                                    <br><hr>
                                    <div clas="form-group">
                                        <div>
                                            <input class="btn green float-right" type="submit" name="btnAdd_business_process" id="btnAdd_business_process" value="Save" >
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="dp_tab">
                                    <h3>Description of Products</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_desc_of_product">
                                    <div id="data_desc_of_product">
                                        
                                    </div>
                                    <div clas="form-group">
                                        <div>
                                            <input class="btn green float-right" type="submit" name="btnAdd_desc_product" id="btnAdd_desc_product" value="Save" >
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tpf_tab">
                                    <h3>No. of Plants and Facilities</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_plant_and_facility">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>USA/Canada</th>
                                                    <th>European Union</th>
                                                    <th>Rest of World</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data_plant_and_facility"></tbody>
                                            <tbody id="dynamic_plant_facility">
                                                <tr>
                                                    <td><input class="form-control no-border" name="usa_canada[]" placeholder="" ></td>
                                                    <td><input class="form-control no-border" name="eu_union[]" placeholder="" ></td>
                                                    <td><input class="form-control no-border" name="rest_of_world[]" placeholder=""></td>
                                                    <td><button type="button" name="add_plant_facility_row" id="add_plant_facility_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                    <div clas="form-group">
                                        <div>
                                            <input class="btn green float-right" type="submit" name="btnAdd_plant_facility" id="btnAdd_plant_facility" value="Save" >
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="pbp_tab">
                                    <h3>Product By Plant</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_product_by_plant">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Plant</th>
                                                        <th>Daily Output <i>(specify units,pounds,bottles, cases,etc.)</i></th>
                                                        <th>Daily Revenue</th>
                                                        <th>No. of Production Lines</th>
                                                        <th>No. of Shifts</th>
                                                        <th>Percentage of Total Capacity</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_product_by_plant"></tbody>
                                                <tbody id="dynamic_pbp">
                                                    <tr>
                                                        <td><input class="form-control no-border" name="plant_name[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="daily_output[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="daily_revenue[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="no_production_lines[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="no_of_shifts[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="ptc_of_total_capacity[]" placeholder=""></td>
                                                        <td><button type="button" name="add_pbp_row" id="add_pbp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_by_plant" id="btnAdd_by_plant" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="psc_tab">
                                    <h3>Product Specific Coverage</h3>
                                    <br>
                                    <p>(Please complete the following information for the top 3 products or if coverage is product specific,please list products to which insurance is to apply):</p>
                                    <form method="post" class="form-horizontal modalForm form_product_specific_coverage">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product (Name/Type)</th>
                                                        <th>Total Sales</th>
                                                        <th>Average Batch Size in $</th>
                                                        <th>Largest Batch Size in $</th>
                                                        <th>Daily Output in $</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_specific_coverage"></tbody>
                                                <tbody id="dynamic_psc">
                                                    <tr>
                                                        <td><input class="form-control no-border" name="product_name[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="total_sales[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="average_batch[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="largest_batch[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="daily_output[]" placeholder=""></td>
                                                        <td><button type="button" name="add_psc_row" id="add_psc_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <labe>Max Value at 1 Location</labe>
                                                <input class="form-control bottom-border" name="max_value">
                                            </div>
                                        </div>
                                        <div clas="form-group">
                                            <div  class="col-md-12">
                                                <input class="btn green float-right" type="submit" name="btnAdd_specific_coverage" id="btnAdd_specific_coverage" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="i_tab">
                                    <h3>Import(s)</h3>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label>Do you import raw or finished products?</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label><input type="radio" placeholder="" name="import"> Yes</label>&nbsp;
                                            <label><input type="radio" placeholder="" name="import"> No</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <hr>
                                            <p>If yes, please list a schedule of products/countries of origin:</p>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Products</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_import">
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><button type="button" name="add_import_row" id="add_import_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!--Branded Products-->
                                <div class="tab-pane" id="bp_tab">
                                    <h3>Branded Products</h3>
                                    <br>
                                    <p>(Please provide percentage of branded, non-branded, and/or own label):</p>
                                    <br>
                                     <form method="post" class="form-horizontal modalForm form_branded_product">
                                        <table class="table table-bordered">
                                            <tbody id="branded_product_data"> 
                                            <?php
                                                $query_bp = mysqli_query($conn, "select * from tblEnterpise_brand_pro where owner_id = '$switch_user_id'");
                                                if (mysqli_num_rows($query_bp) > 0 ) {
                                                    foreach($query_bp as $row_bp){ ?>
                                                    <tr id="row_branded_<?= $row_bp['brand_id']; ?>">
                                                        <td width="200px"><?= $row_bp['title_brand']; ?></td>
                                                        <td><?= $row_bp['percentage']; ?>%</td>
                                                        <td width="100px">
                                                            <div class="btn-group btn-group">
                                                                <a  href="#modal_update_branded" data-toggle="modal" type="button" id="update_branded" data-id="<?= $row_bp['brand_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                        	                    <!--<a href="#modal_delete_branded" data-toggle="modal" type="button" id="delete_branded" data-id="<?= $row_bp['brand_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>-->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                                else{?>
                                                    <tr>
                                                        <td width="200px"><input type="hidden" name="title_brand[]" value="Your Brands">Your Brands</td>
                                                        <td><input class="form-control no-border" name="percentage[]" value="" placeholder="%"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="title_brand[]" value="Non-Branded">Non-Branded</td>
                                                        <td>
                                                            <input class="form-control no-border" name="percentage[]" value="" placeholder="%">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="title_brand[]" value="3 rd Party’s Brand(s)">3 rd Party’s Brand(s)</td>
                                                        <td><input class="form-control no-border" name="percentage[]" value="" placeholder="%"></td>
                                                    </tr>
                                                            
                                                <?}
                                            ?>
                                            </tbody>
                                        </table>
                                        
                                        <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_branded_product" id="btnAdd_branded_product" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="tab-pane" id="cm_tab">
                                    <h3>Co-Manufacturing</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_comanufacturing">
                                    <table class="table table-bordered">
                                        <tbody id="comanufacturing_data">
                                            <?php
                                                $query_cm = mysqli_query($conn, "select * from tblEnterpise_co_manufacturing where cm_owner_id = '$switch_user_id'");
                                                if (mysqli_num_rows($query_cm) > 0 ) {
                                                    foreach($query_cm as $row_cm){ ?>
                                                    <tr id="row_co_manu_<?= $row_cm['cm_id']; ?>">
                                                        <td><?= $row_cm['party_product']; ?></td>
                                                        <td><?= $row_cm['ptc_product']; ?>%</td>
                                                        <td width="100px">
                                                            <div class="btn-group btn-group">
                                                                <a  href="#modal_update_co_manu" data-toggle="modal" type="button" id="update_co_manu" data-id="<?= $row_cm['cm_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                                else{?>
                                                    <tr>
                                                        <td><input type="hidden" name="party_product[]" value="Percentage of products manufactured by 3 rd Party’s">Percentage of products manufactured by 3 rd Party’s</td>
                                                        <td><input class="form-control no-border" name="ptc_product[]" value="" placeholder="%"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="party_product[]" value="What percentage of your products are component part/ingredients of other products">
                                                            What percentage of your products are component part/ingredients of other products
                                                        </td>
                                                        <td>
                                                           <input class="form-control no-border" name="ptc_product[]" value="" placeholder="%">
                                                        </td>
                                                    </tr>
                                                            
                                                <?}
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                    <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_co_manu" id="btnAdd_co_manu" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="tab-pane" id="np_tab">
                                    <h3>New Products < 12 Months</h3>
                                    <br>
                                    <p>(Please indicate any new products that have commenced production or have entered the public stream of commerce within the last 12 months)</p>
                                    <form method="post" class="form-horizontal modalForm form_new_product">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Products</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="new_products_data">
                                            <?php
                                                $query_np = mysqli_query($conn, "select * from tblEnterpise_new_product where np_owner_id = '$switch_user_id' and is_deleted = 0");
                                                if (mysqli_num_rows($query_np) > 0 ) {
                                                    foreach($query_np as $row_np){ ?>
                                                    <tr id="row_newprod_<?= $row_np['np_id']; ?>">
                                                        <td><?= $row_np['product_name']; ?></td>
                                                        <td width="200px">
                                                            <div class="btn-group btn-group-circle">
                                                                <a  href="#modal_update_new_prod" data-toggle="modal" type="button" id="update_new_prod" data-id="<?= $row_np['np_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                <a href="#modal_delete_new_prod" data-toggle="modal" type="button" id="delete_new_prod" data-id="<?= $row_np['np_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                            ?>
                                            
                                        </tbody>
                                        <tbody id="dynamic_newproduct">
                                            <tr>
                                                <td><input class="form-control no-border" name="product_name[]" placeholder=""></td>
                                                <td><button type="button" name="add_newproduct_row" id="add_newproduct_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_new_product" id="btnAdd_new_product" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                
                                <div class="tab-pane" id="d_tab">
                                    <h3>Distribution</h3>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_distribution">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Geography</th>
                                                    <th>Manufacture (as % of total sales)</th>
                                                    <th>Sales (as % of total sales)</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="distribution_data"> 
                                            <?php
                                                $query_dist = mysqli_query($conn, "select * from tblEnterpise_distribution where owner_id = '$switch_user_id'");
                                                if (mysqli_num_rows($query_dist) > 0 ) {
                                                    foreach($query_dist as $row_dist){ ?>
                                                    <tr id="row_distribution_<?= $row_dist['dist_id']; ?>">
                                                        <td width="200px"><?= $row_dist['geography']; ?></td>
                                                        <td><?= $row_dist['manufacture']; ?>%</td>
                                                        <td><?= $row_dist['sales']; ?>%</td>
                                                        <td width="100px">
                                                            <div class="btn-group btn-group">
                                                                <a  href="#modal_update_distribution" data-toggle="modal" type="button" id="update_distribution" data-id="<?= $row_dist['dist_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                                else{?>
                                                    
                                                    <tr>
                                                        <td><input type="hidden" name="geography[]" value="United States">United States</td>
                                                        <td><input class="form-control no-border" name="manufacture[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="sales[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="geography[]" value="Canada">Canada</td>
                                                        <td><input class="form-control no-border" name="manufacture[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="sales[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="geography[]" value="UK">UK</td>
                                                        <td><input class="form-control no-border" name="manufacture[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="sales[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="geography[]" value="Europe">Europe</td>
                                                        <td><input class="form-control no-border" name="manufacture[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="sales[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="geography[]" value="Rest of the World">Rest of the World</td>
                                                        <td><input class="form-control no-border" name="manufacture[]" placeholder=""></td>
                                                        <td><input class="form-control no-border" name="sales[]" placeholder=""></td>
                                                    </tr>
                                                            
                                                <?}
                                            ?>
                                            </tbody>
                                        </table>
                                        
                                        <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_distribution" id="btnAdd_distribution" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="c_tab">
                                    <h3>Customers</h3>
                                    <br>
                                    <p>(Please List Your Companies 3 Largest Customers):</p>
                                    <br>
                                    <form method="post" class="form-horizontal modalForm form_customer">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><label class="form-control no-border B">Customer</label> </th>
                                                <th><label class="form-control no-border B">Percentage of Sales</label> </th>
                                                <th><label class="form-control no-border B">Products Manufactured</label> </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="new_customer_data">
                                            <?php
                                                $query_c = mysqli_query($conn, "select * from tblEnterpise_customer where ownedby = '$switch_user_id' and is_deleted = 0");
                                                if (mysqli_num_rows($query_c) > 0 ) {
                                                    foreach($query_c as $row_c){ ?>
                                                    <tr id="row_customer_<?= $row_c['customer_id']; ?>">
                                                        <td><?= $row_c['customer_name']; ?></td>
                                                        <td><?= $row_c['percentage_sales']; ?></td>
                                                        <td><?= $row_c['product_manu']; ?></td>
                                                        <td width="200px">
                                                            <div class="btn-group btn-group-circle">
                                                                <a  href="#modal_update_customer" data-toggle="modal" type="button" id="update_customer" data-id="<?= $row_c['customer_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                                <a href="#modal_delete_customer" data-toggle="modal" type="button" id="delete_customer" data-id="<?= $row_c['customer_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                            ?>
                                        </tbody>
                                        <tbody id="dynamic_field_customer">
                                            <tr>
                                                <td><input class="form-control no-border" name="customer_name[]" placeholder=""></td>
                                                <td><input class="form-control no-border" name="percentage_sales[]" placeholder=""></td>
                                                <td><input class="form-control no-border" name="product_manu[]" placeholder=""></td>
                                                <td><button type="button" name="add_customer_row" id="add_customer_row" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_customer" id="btnAdd_customer" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="sl_tab">
                                    <h3>Shelf Life</h3>
                                    <br>
                                    <p>(What is the average shelf life of your products (as a percentage of total sales):</p>
                                    <form method="post" class="form-horizontal modalForm form_shelflife">
                                        <table class="table table-bordered">
                                            <tbody id="shelflife_data"> 
                                            <?php
                                                $query_shelf = mysqli_query($conn, "select * from tblEnterpise_shelflife where owner_id = '$switch_user_id'");
                                                if (mysqli_num_rows($query_shelf) > 0 ) {
                                                    foreach($query_shelf as $row_shelf){ ?>
                                                    <tr id="row_shelflife_<?= $row_shelf['shelf_id']; ?>">
                                                        <td width="200px"><?= $row_shelf['frequency']; ?></td>
                                                        <td><?= $row_shelf['percentage']; ?>%</td>
                                                        <td width="100px">
                                                            <div class="btn-group btn-group">
                                                                <a  href="#modal_update_shelf" data-toggle="modal" type="button" id="update_shelf" data-id="<?= $row_shelf['shelf_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                }
                                                else{?>
                                                   <tr>
                                                        <td><input type="hidden" name="frequency[]" value="Less than a week">Less than a week</td>
                                                        <td><input class="form-control no-border" name="percentage[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="frequency[]" value="One month to six months">One month to six months</td>
                                                        <td><input class="form-control no-border" name="percentage[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="frequency[]" value="One week to a month">One week to a month</td>
                                                        <td><input class="form-control no-border" name="percentage[]" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="frequency[]" value="More than six months">More than six months</td>
                                                        <td><input class="form-control no-border" name="percentage[]" placeholder=""></td>
                                                    </tr>
                                                            
                                                <?}
                                            ?>
                                            </tbody>
                                        </table>
                                        
                                        <div clas="form-group">
                                            <div>
                                                <input class="btn green float-right" type="submit" name="btnAdd_shelflife" id="btnAdd_shelflife" value="Save" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                
                                <!--end--> 
                            </div>
                        </div>
                       
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<div id="data_print"></div>
<?php include "insurance_folder/insurance_modal.php"; ?>
<?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="insurance_folder/custom_script.js" type="text/javascript"></script>
<script>

//delete officer
$(document).on('click', '#delete_officer', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_officer_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_officer .modal-body").html(data);
        }
    });
});
$(".modal_delete_officer").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    var Status_row = $("#Status").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_officer',true);

    var l = Ladda.create(document.querySelector('#btndelete_officer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_tblofficer'+row_id).empty();
                 $('#modal_delete_officer').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//update officer
$(document).on('click', '#update_officer', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_officer_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_officer .modal-body").html(data);
        }
    });
});
$(".modal_update_officer").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_officer',true);

    var l = Ladda.create(document.querySelector('#btnSave_officer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_tblofficer'+row_id).empty();
                 $('#row_tblofficer'+row_id).append(response);
                 $('#modal_update_officer').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
// modal_new_officer
$(".modal_new_officer").on('submit',(function(e) {
    e.preventDefault();
    //  var row_tbl = $("#Status_tbl").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_officer',true);

    var l = Ladda.create(document.querySelector('#btnAdd_officer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Added!";
                $('#data_officer').append(response);
                // document.getElementsByClassName('no-border').val = '';
                $('.modal_new_officer')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// modal_new_sales
$(".modal_new_sales").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_sales',true);

    var l = Ladda.create(document.querySelector('#btnAdd_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_sales').empty();
                $('#data_sales').append(response);
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


//update us sales
$(document).on('click', '#update_us_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_us_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_us_sales .modal-body").html(data);
        }
    });
});
$(".modal_update_us_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_us_sales',true);

    var l = Ladda.create(document.querySelector('#btnSave_us_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#us_row'+row_id).empty();
                 $('#us_row'+row_id).append(response);
                 $('#modal_update_us_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete us
$(document).on('click', '#delete_us_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_us_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_us_sales .modal-body").html(data);
        }
    });
});
$(".modal_delete_us_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    var Status_row = $("#Status").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_us_sales',true);

    var l = Ladda.create(document.querySelector('#btndelete_us_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#us_row'+row_id).empty();
                 $('#modal_delete_us_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//update foreign sales
$(document).on('click', '#update_foreign_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_foreign_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_foreign_sales .modal-body").html(data);
        }
    });
});
$(".modal_update_foreign_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_foreign_sales',true);

    var l = Ladda.create(document.querySelector('#btnSave_foreign_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#foreign_row'+row_id).empty();
                 $('#foreign_row'+row_id).append(response);
                 $('#modal_update_foreign_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete foreign sales
$(document).on('click', '#delete_foreign_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_foreign_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_foreign_sales .modal-body").html(data);
        }
    });
});
$(".modal_delete_foreign_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_foreign_sales',true);

    var l = Ladda.create(document.querySelector('#btndelete_foreign_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#foreign_row'+row_id).empty();
                 $('#modal_delete_foreign_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


//update spit by country
$(document).on('click', '#update_sbc_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_sbc_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_sbc_sales .modal-body").html(data);
        }
    });
});
$(".modal_update_sbc_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_sbc_sales',true);

    var l = Ladda.create(document.querySelector('#btnSave_sbc_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#sbc_row'+row_id).empty();
                 $('#sbc_row'+row_id).append(response);
                 $('#modal_update_sbc_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete foreign sales
$(document).on('click', '#delete_sbc_sales', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_sbc_sales_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_sbc_sales .modal-body").html(data);
        }
    });
});
$(".modal_delete_sbc_sales").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_sbc_sales',true);

    var l = Ladda.create(document.querySelector('#btndelete_sbc_sales'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#sbc_row'+row_id).empty();
                 $('#modal_delete_sbc_sales').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// modal_new annual revenue
$(".modal_new_annual_revenue").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_annual',true);

    var l = Ladda.create(document.querySelector('#btnAdd_annual'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_annual').append(response);
                $('.modal_new_annual_revenue')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//update  annual revenue
$(document).on('click', '#update_annual', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_annual_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_annual .modal-body").html(data);
        }
    });
});
$(".modal_update_annual").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_annual',true);

    var l = Ladda.create(document.querySelector('#btnSave_annual'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_ar_'+row_id).empty();
                 $('#row_ar_'+row_id).append(response);
                 $('#modal_update_annual').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete annual revenue
$(document).on('click', '#delete_annual', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_annual_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_annual .modal-body").html(data);
        }
    });
});
$(".modal_delete_annual").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_annual',true);

    var l = Ladda.create(document.querySelector('#btndelete_annual'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_ar_'+row_id).empty();
                 $('#modal_delete_annual').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// form new payroll
$(".form_new_payroll").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_payroll',true);

    var l = Ladda.create(document.querySelector('#btnAdd_payroll'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#payroll_form').empty();
                $('#payroll_form').append(response);
                $('.form_new_payroll')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//update payroll
$(document).on('click', '#update_payroll', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_payroll_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_payroll .modal-body").html(data);
        }
    });
});
$(".modal_update_payroll").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_payroll',true);

    var l = Ladda.create(document.querySelector('#btnSave_payroll'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#payroll_row'+row_id).empty();
                 $('#payroll_row'+row_id).append(response);
                 $('#modal_update_payroll').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete payroll
$(document).on('click', '#delete_payroll', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_payroll_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_payroll .modal-body").html(data);
        }
    });
});
$(".modal_delete_payroll").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_payroll',true);

    var l = Ladda.create(document.querySelector('#btndelete_payroll'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#payroll_row'+row_id).empty();
                 $('#modal_delete_payroll').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// form_new_no_employees
$(".form_new_no_employees").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_no_emp',true);

    var l = Ladda.create(document.querySelector('#btnAdd_no_emp'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_no_employee').append(response);
                $('.form_new_no_employees')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


//update no employee
$(document).on('click', '#update_emp', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_emp_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_no_emp .modal-body").html(data);
        }
    });
});
$(".modal_update_no_emp").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_emp',true);

    var l = Ladda.create(document.querySelector('#btnSave_emp'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_no_emp'+row_id).empty();
                 $('#row_no_emp'+row_id).append(response);
                 $('#modal_update_no_emp').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete no employee
$(document).on('click', '#delete_emp', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_emp_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_no_emp .modal-body").html(data);
        }
    });
});
$(".modal_delete_no_emp").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_emp',true);

    var l = Ladda.create(document.querySelector('#btndelete_emp'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_no_emp'+row_id).empty();
                 $('#modal_delete_no_emp').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// form_new_coverage
$(".form_new_coverage").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_coverage',true);

    var l = Ladda.create(document.querySelector('#btnAdd_coverage'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_coverage').append(response);
                $('.form_new_coverage')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update coverage
$(document).on('click', '#update_coverage', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_coverage_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_coverage .modal-body").html(data);
        }
    });
});
$(".modal_update_coverage").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_coverage',true);

    var l = Ladda.create(document.querySelector('#btnSave_coverage'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_coverage'+row_id).empty();
                 $('#row_coverage'+row_id).append(response);
                 $('#modal_update_coverage').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete coverage
$(document).on('click', '#delete_coverage', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_coverage_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_coverage .modal-body").html(data);
        }
    });
});
$(".modal_delete_coverage").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_coverage',true);

    var l = Ladda.create(document.querySelector('#btndelete_coverage'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_coverage'+row_id).empty();
                 $('#modal_delete_coverage').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// business process
$(".form_business_process").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_business_process',true);

    var l = Ladda.create(document.querySelector('#btnAdd_business_process'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                 $('#business_process').empty();
                $('#business_process').append(response);
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//form_desc_of_product
$(".form_desc_of_product").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_desc_product',true);

    var l = Ladda.create(document.querySelector('#btnAdd_desc_product'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                 $('#data_desc_of_product').empty();
                $('#data_desc_of_product').append(response);
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
// form_plant_and_facility
$(".form_plant_and_facility").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_plant_facility',true);

    var l = Ladda.create(document.querySelector('#btnAdd_plant_facility'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_plant_and_facility').append(response);
                $('.form_plant_and_facility')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update plant_facility
$(document).on('click', '#update_plant_facility', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_plant_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_plant_facility .modal-body").html(data);
        }
    });
});
$(".modal_update_plant_facility").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_plant_facility',true);

    var l = Ladda.create(document.querySelector('#btnSave_plant_facility'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_plant_facility'+row_id).empty();
                 $('#row_plant_facility'+row_id).append(response);
                 $('#modal_update_plant_facility').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete plant_facility
$(document).on('click', '#delete_plant_facility', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_plant_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_plant_facility .modal-body").html(data);
        }
    });
});
$(".modal_delete_plant_facility").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_plant_facility',true);

    var l = Ladda.create(document.querySelector('#btndelete_plant_facility'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_plant_facility'+row_id).empty();
                 $('#modal_delete_plant_facility').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// form_product_by_plant
$(".form_product_by_plant").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_by_plant',true);

    var l = Ladda.create(document.querySelector('#btnAdd_by_plant'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_product_by_plant').append(response);
                $('.form_product_by_plant')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update_by_plant
$(document).on('click', '#update_by_plant', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_by_plant_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_by_plant .modal-body").html(data);
        }
    });
});
$(".modal_update_by_plant").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_by_plant',true);

    var l = Ladda.create(document.querySelector('#btnSave_by_plant'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_by_plant'+row_id).empty();
                 $('#row_by_plant'+row_id).append(response);
                 $('#modal_update_by_plant').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete product by plant
$(document).on('click', '#delete_by_plant', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_by_plant_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_by_plant .modal-body").html(data);
        }
    });
});
$(".modal_delete_by_plant").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_by_plant',true);

    var l = Ladda.create(document.querySelector('#btndelete_by_plant'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_by_plant'+row_id).empty();
                 $('#modal_delete_by_plant').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// form_product_specific_coverage
$(".form_product_specific_coverage").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_specific_coverage',true);

    var l = Ladda.create(document.querySelector('#btnAdd_specific_coverage'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#data_specific_coverage').append(response);
                $('.form_product_specific_coverage')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// branded product
$(".form_branded_product").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_branded_product',true);

    var l = Ladda.create(document.querySelector('#btnAdd_branded_product'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#branded_product_data').empty();
                $('#branded_product_data').append(response);
                // $('.form_branded_product')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update branded product
$(document).on('click', '#update_branded', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_branded_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_branded .modal-body").html(data);
        }
    });
});
$(".modal_update_branded").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_branded',true);

    var l = Ladda.create(document.querySelector('#btnSave_branded'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_branded_'+row_id).empty();
                 $('#row_branded_'+row_id).append(response);
                 $('#modal_update_branded').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// shelf life
$(".form_shelflife").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_shelflife',true);

    var l = Ladda.create(document.querySelector('#btnAdd_shelflife'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#shelflife_data').empty();
                $('#shelflife_data').append(response);
                // $('.form_branded_product')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update shelf life
$(document).on('click', '#update_shelf', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_shelf_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_shelf .modal-body").html(data);
        }
    });
});
$(".modal_update_shelf").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_shelf',true);

    var l = Ladda.create(document.querySelector('#btnSave_shelf'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_shelflife_'+row_id).empty();
                 $('#row_shelflife_'+row_id).append(response);
                 $('#modal_update_shelf').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// Distribution
$(".form_distribution").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_distribution',true);

    var l = Ladda.create(document.querySelector('#btnAdd_distribution'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#distribution_data').empty();
                $('#distribution_data').append(response);
                // $('.form_branded_product')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update Distribution
$(document).on('click', '#update_distribution', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_distributionf_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_distribution .modal-body").html(data);
        }
    });
});
$(".modal_update_distribution").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_distribution',true);

    var l = Ladda.create(document.querySelector('#btnSave_distribution'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_distribution_'+row_id).empty();
                 $('#row_distribution_'+row_id).append(response);
                 $('#modal_update_distribution').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// Co Manufacturing
$(".form_comanufacturing").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_co_manu',true);

    var l = Ladda.create(document.querySelector('#btnAdd_co_manu'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#comanufacturing_data').empty();
                $('#comanufacturing_data').append(response);
                // $('.form_branded_product')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update Co Manufacturing
$(document).on('click', '#update_co_manu', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_comanu_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_co_manu .modal-body").html(data);
        }
    });
});
$(".modal_update_co_manu").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_comanu',true);

    var l = Ladda.create(document.querySelector('#btnSave_comanu'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_co_manu_'+row_id).empty();
                 $('#row_co_manu_'+row_id).append(response);
                 $('#modal_update_co_manu').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// new product
$(".form_new_product").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_new_product',true);

    var l = Ladda.create(document.querySelector('#btnAdd_new_product'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                $('#new_products_data').empty();
                $('#new_products_data').append(response);
                $('.form_new_product')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// form_customer
$(".form_customer").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_customer',true);

    var l = Ladda.create(document.querySelector('#btnAdd_customer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Successfully Added!";
                // $('#new_customer_data').empty();
                $('#new_customer_data').append(response);
                $('.form_customer')[0].reset();
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//update modal_update_customer
$(document).on('click', '#update_customer', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_customer_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_customer .modal-body").html(data);
        }
    });
});
$(".modal_update_customer").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_customer',true);

    var l = Ladda.create(document.querySelector('#btnSave_customer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_customer_'+row_id).empty();
                 $('#row_customer_'+row_id).append(response);
                 $('#modal_update_customer').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete customer
$(document).on('click', '#delete_customer', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_customer_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_customer .modal-body").html(data);
        }
    });
});
$(".modal_delete_customer").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_customer',true);

    var l = Ladda.create(document.querySelector('#btndelete_customer'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_customer_'+row_id).empty();
                 $('#modal_delete_customer').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));



//update new product
$(document).on('click', '#update_new_prod', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?get_newprod_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_update_new_prod .modal-body").html(data);
        }
    });
});
$(".modal_update_new_prod").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_newprod',true);

    var l = Ladda.create(document.querySelector('#btnSave_newprod'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Save!";
                $('#row_newprod_'+row_id).empty();
                 $('#row_newprod_'+row_id).append(response);
                 $('#modal_update_new_prod').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//delete new product
$(document).on('click', '#delete_new_prod', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "insurance_folder/function.php?delete_newprod_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_new_prod .modal-body").html(data);
        }
    });
});
$(".modal_delete_new_prod").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btndelete_newprod',true);

    var l = Ladda.create(document.querySelector('#btndelete_newprod'));
    l.start();

    $.ajax({
        url: "insurance_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Deleted!!!";
                $('#row_newprod_'+row_id).empty();
                 $('#modal_delete_new_prod').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//all  fetch form script below
$(document).ready(function(){
    //fetch data
   getData('get_applicant_form');
   getData_officer('fetch_officer');
   getData_us_sales('fetch_us_data');
   getData_annual('get_data_annual');
   getData_payroll('get_payroll_form');
   getData_employee('get_no_employee');
   getData_coverage('get_coverage');
   getData_business_process('get_business_process');
   getData_desc_of_product('get_desc_of_product');
   getData_plant_facility('get_plant_facility');
   getData_by_plant('get_by_plant');
   getData_specific_coverage('get_specific_coverage');
});

function getData(key) {
    $.ajax({
       url:'insurance_folder/applicant_form.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_applicant_form'){
               $('#ai_tab').append(response);
           }
       }
    });
}
function getData_officer(key) {
    $.ajax({
       url:'insurance_folder/fetch_officer_box.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_officer_form'){
               $('#o_tab').append(response);
           }
           else if (key == 'fetch_officer'){
               $('#data_officer').append(response);
           }
       }
    });
}
function getData_us_sales(key) {
    $.ajax({
       url:'insurance_folder/fetch_us_sales_box.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'fetch_us_data'){
               $('#data_sales').append(response);
           }
       }
    });
}
function getData_annual(key) {
    $.ajax({
       url:'insurance_folder/annual_revenue_form.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_data_annual'){
               $('#data_annual').append(response);
           }
       }
    });
}
function getData_payroll(key) {
    $.ajax({
       url:'insurance_folder/fetch_payroll_box.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_payroll_form'){
               $('#payroll_form').append(response);
           }
       }
    });
}

function getData_employee(key) {
    $.ajax({
       url:'insurance_folder/fetch_no_employee.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_no_employee'){
               $('#data_no_employee').append(response);
           }
       }
    });
}
function getData_coverage(key) {
    $.ajax({
       url:'insurance_folder/coverage_option.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_coverage'){
               $('#data_coverage').append(response);
           }
       }
    });
}
function getData_business_process(key) {
    $.ajax({
       url:'insurance_folder/desc_of_operation_form.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_business_process'){
               $('#business_process').append(response);
           }
       }
    });
}
function getData_desc_of_product(key) {
    $.ajax({
       url:'insurance_folder/fetch_desc_of_product.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_desc_of_product'){
               $('#data_desc_of_product').append(response);
           }
       }
    });
}
function getData_plant_facility(key) {
    $.ajax({
       url:'insurance_folder/plants_and_facilities.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_plant_facility'){
               $('#data_plant_and_facility').append(response);
           }
       }
    });
}
function getData_by_plant(key) {
    $.ajax({
       url:'insurance_folder/fetch_pbp_box.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_by_plant'){
               $('#data_product_by_plant').append(response);
           }
       }
    });
}
function getData_specific_coverage(key) {
    $.ajax({
       url:'insurance_folder/fetch_psc_box.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_specific_coverage'){
               $('#data_specific_coverage').append(response);
           }
       }
    });
}
//print_btn
$(document).on('click', '#print_btn', function(){
    var key = 'print';
    $.ajax({
        type: "POST",
        url: "insurance_folder/print.php",
        dataType: "html",
        data: {
          key: key
      }, success: function(data){
            $("#data_print").html(data);
            window.print();
        }
    });
});
</script>     
<style>
#ai_tab{min-height:70vh;}
#o_tab{min-height:70vh;}
#s_tab{min-height:70vh;}
#ar_tab{min-height:70vh;}
#p_tab{min-height:70vh;}
#ne_tab{min-height:70vh;}
#co_tab{min-height:70vh;}
#do_tab{min-height:70vh;}
#dp_tab{min-height:70vh;}
#tpf_tab{min-height:70vh;}
#pbp_tab{min-height:70vh;}
#psc_tab{min-height:70vh;}
#mvl_tab{min-height:70vh;}
#i_tab{min-height:70vh;}
#bp_tab{min-height:70vh;}
#cm_tab{min-height:70vh;}
#np_tab{min-height:70vh;}
#d_tab{min-height:70vh;}
#c_tab{min-height:70vh;}
#sl_tab{min-height:70vh;}
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
.600{
font-weight:600;
}
.B{
    font-weight:bold;
}
h3{
    font-weight:600;
    margin-left:2.5rem;
     /*border: 1px solid black;*/
}
.no-border{
        border:none;
}
.bottom-border{
    border:none;
    border-bottom:solid #ccc 1px;
}
.brandAv{
   height:300px;
   width:300px;
   position:relative;
   border-radius:50%;
   border:solid 3px #fff;
   background-color:#F6FBF4;
   background-size:100% 100%;
   margin:5px auto;
   overflow:hidden;
}
.uuploader{
   position:absolute;
   bottom:0;
   outline:none;
   color:transparent;
   width:100%;
   box-sizing:border-box;
   padding:15px 140px;
   cursor:pointer;
     transition: 0.5s;
 background:rgba(0,0,0,0.5);
 opacity:0;
}
.uuploader::-webkit-file-upload-button{
visibility:hidden;
}
.uuploader::before{
	content:'\f030';
	font-family:fontAwesome;
	font-size:20px;
    color:#fff;
    display:inline-block;
    text-align:center;
    float:center;
    -webkit-user-select:none;
    }
    .uuploader:hover{
     opacity:1;
    }
#org_title{
    margin-top:1rem;   
}   

</style>
    </body>
</html>