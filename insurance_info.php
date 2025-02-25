<?php 
    $title = "Risk And Liabilities";
    $site = "insurance_info";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Organization';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title  tabbable-tabdrop tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Organization</span>
                            </div>
                             <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#ai_tab" data-toggle="tab">Risk And Liabilities</a>
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
                                    <a href="#tpf_tab" data-toggle="tab">Total No. of Plants and Facilities</a>
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
                          
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!--start-->
                               <div class="tab-pane active" id="ai_tab">
                                   <?php
                                        $query = mysqli_query($conn,"select *from tblEnterpiseDetails where users_entities = '$switch_user_id' limit 1");
                                        foreach($query as $row){
                                        ?>
                                                <h3>Organization</h3>
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
                                </div>
                                <div class="tab-pane" id="o_tab">
                                    <h3>Officer(s)</h3>
                                    <br>
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
                                </div>
                                <div class="tab-pane" id="s_tab">
                                    <h3>Sales</h3>
                                    <br>
                                      <table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>Total US Gross Sales Item</th>
                                                  <th width="350px">Estimated <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
                                                <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
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
                                                  <th width="350px">Estimated <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
                                                <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
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
                                </div>
                                <div class="tab-pane" id="ar_tab">
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
                                <div class="tab-pane" id="p_tab">
                                    <h3>Payroll</h3>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>State</th>
                                                <th>Code</th>
                                                <th>Classification</th>
                                                <th width="350px">Estimated <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
                                                <th width="350px">Projected <input style="font-size:12px;" type="date" class=" no-border"> to <input style="font-size:12px;" type="date" class=" no-border"></th>
                                                <th>Full Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                                <th>Part Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_field_payroll">
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><button type="button" name="add_payroll_row" id="add_payroll_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><label class="form-control ">Annual WC Premiums</label></td>
                                                <td><input class="form-control "></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="ne_tab">
                                    <h3>No. of Employees</h3>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Total</th>
                                                <th>USA/Canada</th>
                                                <th>European Union</th>
                                                <th>Rest of World</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="co_tab">
                                    <h3>Coverage Options</h3>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><label class="form-control no-border B">Options</label> </th>
                                                <th><label class="form-control no-border B">Limit Options</label> </th>
                                                <th><label class="form-control no-border B">Retention Options</label> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td>Accidental Contamination</td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td>Malicious Product Tempering</td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td>Combined Single Aggregate</td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div clas="form-group">
                                        <div>
                                            <input type="submit" class="btn blue btn-primary float-right" value="Save">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="do_tab">
                                    <h3>Description of Operations</h3>
                                    <p>Enterprise Process</p>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Bottler
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Brand Owner
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Broker
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Buyer
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Co-Manufacturer
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Co-Packer
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Cultivation
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Distributor
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Distribution
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Importer
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                IT Services
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Manufacturing
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Packing
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Packaging
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Professional Services
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Retailer
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Reseller
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Supplier of Ingredients
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Seller
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Wholesaler
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <input type="checkbox" name="">
                                                Others
                                            </label>
                                        </div>
                                    </div>
                                    <br><hr>
                                    <div clas="form-group">
                                        <div>
                                            <input type="submit" class="btn blue btn-primary float-right" value="Save">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="dp_tab">
                                    <h3>Description of Products</h3>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label>Does the enterprise offer products?</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label><input type="radio" placeholder="" name="product"> Yes</label>&nbsp;
                                            <label><input type="radio" placeholder="" name="product"> No</label>
                                        </div>
                                    </div>
                                    
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Products <i style="font-size:12px;color:orange;">(If yes)</i></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_dp">
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><button type="button" name="add_dp_row" id="add_dp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tpf_tab">
                                    <h3>No. of Plants and Facilities</h3>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>USA/Canada</th>
                                                <th>European Union</th>
                                                <th>Rest of World</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                                <td><input class="form-control no-border" placeholder=""></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="pbp_tab">
                                    <h3>Product By Plant</h3>
                                    <br>
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
                                        <tbody id="dynamic_pbp">
                                            <tr>
