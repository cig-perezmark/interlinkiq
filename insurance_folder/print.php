<?php
require '../database.php';

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

if(isset($_POST['key'])){
    if ($_POST['key'] == 'print') {
        //applicant form
        $query_af = mysqli_query($conn,"select *from tblEnterpiseDetails where users_entities = '$user_id' limit 1");
        foreach($query_af as $row){
        ?>
                <center><h3><b>Risk & Liabilities</b></h3></center>
                <br>
                <h5><b>Organization</b></h5>
                <br>
                <table class="table table-bordered">
                    <tr>
                        <td width="130px">Name Insured:</td>
                        <td><?= $row['businessname']; ?></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><?= $row['Bldg']; ?>, <?= $row['city']; ?>, <?= $row['States']; ?> <?= $row['ZipCode']; ?> , 
                            <?php 
                            $country = $row['country'];
                            $resultcountry = mysqli_query($conn, "select * from countries where id = '$country'");
                             while($rowcountry = mysqli_fetch_array($resultcountry))
                             { 
                                    echo utf8_encode($rowcountry['name']);
                             } 
                             ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?= $row['businesstelephone']; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?= $row['businesstelephone']; ?></td>
                    </tr>
                    <tr>
                        <td>Website:</td>
                        <td><?= $row['businesswebsite']; ?></td>
                    </tr>
                    <tr>
                        <td>Date Established:</td>
                        <td><?= $row['YearEstablished']; ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <td width="250px">Prior experience in this business under any other name:</td>
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
                        <td>If so (Yes), please provide the name of the entity:</td>
                        <td>
                            <input class="form-control bottom-border" id="actions" value="" placeholder="Specify" >
                        </td>
                    </tr>
                </table>
                <h5><b>Officer(s)</b></h5>
                <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Title</th>
                          <th>Ownership %</th>
                          <th>Work Comp Class Code</th>
                          <th>Include or Exclude for Work Comp Coverage</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                  </tbody>
                </table>
                <br>
        <?php }
        
        
        //sale
        $query = mysqli_query($conn, "select * from tblEnterpise_sales where sales_enterprise_id = $user_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_sales){
            $estimated_start_date ='';
            if($row_sales['estimated_start_date'] != 'NULL' and $row_sales['estimated_start_date'] != ''){$estimated_start_date = date('Y-m-d', strtotime($row_sales['estimated_start_date']));}
            $estimated_to_date = '';
            if($row_sales['estimated_to_date'] != 'NULL' and $row_sales['estimated_to_date'] != ''){$estimated_to_date = date('Y-m-d', strtotime($row_sales['estimated_to_date']));}
            $projected_start_date = '';
            if($row_sales['projected_start_date'] != 'NULL' and $row_sales['projected_start_date'] != ''){$projected_start_date = date('Y-m-d', strtotime($row_sales['projected_start_date']));}
            $projected_to_date = '';
            if($row_sales['projected_to_date']!= 'NULL' and $row_sales['projected_to_date'] != ''){ $projected_to_date = date('Y-m-d', strtotime($row_sales['projected_to_date']));}
           $estimated_foreign_start_date = '';
            if($row_sales['estimated_foreign_start_date']!= 'NULL' and $row_sales['estimated_foreign_start_date'] != ''){$estimated_foreign_start_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_start_date']));}
            $estimated_foreign_to_date = '';
            if($row_sales['estimated_foreign_to_date'] != 'NULL' and $row_sales['estimated_foreign_to_date'] != ''){$estimated_foreign_to_date = date('Y-m-d', strtotime($row_sales['estimated_foreign_to_date']));}
            $projected_foreign_start_date = '';
            if($row_sales['projected_foreign_start_date'] != 'NULL' and $row_sales['projected_foreign_start_date'] != ''){$projected_foreign_start_date = date('Y-m-d', strtotime($row_sales['projected_foreign_start_date']));}
            $projected_foreign_to_date = '';
            if($row_sales['projected_foreign_to_date'] != 'NULL' and $row_sales['projected_foreign_to_date'] != ''){$projected_foreign_to_date = date('Y-m-d', strtotime($row_sales['projected_foreign_to_date']));}
           
           ?>
                <!--for US-->
              <table class="table table-bordered">
                  <thead>
                      <tr>
                            <!--Top-->
                            <td width="200px" style="border-bottom:none !important;">
                                
                            </td>
                            <td style="border-bottom:none !important;">
                                <center>Estimated</center> 
                            </td> 
                            <td style="border-bottom:none !important;">
                                <center>Projected</center> 
                            </td>
                      </tr>
                      <tr>
                            <!--bottom-->
                            <td style="border-top:none !important;">
                                Total US Gross Sales Item
                            </td>
                            <td style="border-top:none !important;">
                                From: <i><u><?php if(!empty($estimated_start_date)){ echo $estimated_start_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                                To: <i><u></u></i><?php if(!empty($estimated_to_date)){ echo $estimated_to_date;}else{ echo 'YYYY-MM-DD'; } ?>
                            </td> 
                            <td style="border-top:none !important;">
                                From: <i><u><?php if(!empty($projected_start_date)){ echo $projected_start_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                                To: <i><u><?php if(!empty($projected_to_date)){ echo $projected_to_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                            </td>
                      </tr>
                </thead>
                  <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                      <?php 
                        $us_gross = mysqli_query($conn, "select * from tblEnterpise_sales_us_gross where us_enterprise_id = $user_id");
                        foreach($us_gross as $row_gross){?>
                            <tr id="us_row<?= $row_gross['us_gross_id']; ?>">
                                <td><?= $row_gross['us_item']; ?></td>
                                  <td>$<?= $row_gross['us_estimated_gross']; ?></td>
                                  <td>$<?= $row_gross['us_projected_gross']; ?></td>
                            </tr>
                       <?php }
                      ?>
                  </tbody>
              </table>
              
              <!--for foreign-->
              <table class="table table-bordered">
                  <thead>
                      <tr>
                            <!--Top-->
                            <td width="200px" style="border-bottom:none !important;">
                                
                            </td>
                            <td style="border-bottom:none !important;">
                                <center>Estimated</center> 
                            </td> 
                            <td style="border-bottom:none !important;">
                                <center>Projected</center> 
                            </td>
                      </tr>
                      <tr>
                            <!--bottom-->
                            <td style="border-top:none !important;">
                                Total Foreign Gross Sales
                            </td>
                            <td style="border-top:none !important;">
                                From: <i><u><?php if(!empty($estimated_foreign_start_date)){ echo $estimated_foreign_start_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                                To: <i><u></u></i><?php if(!empty($estimated_foreign_to_date)){ echo $estimated_foreign_to_date;}else{ echo 'YYYY-MM-DD'; } ?>
                            </td> 
                            <td style="border-top:none !important;">
                                From: <i><u><?php if(!empty($projected_foreign_start_date)){ echo $projected_foreign_start_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                                To: <i><u><?php if(!empty($projected_foreign_to_date)){ echo $projected_foreign_to_date;}else{ echo 'YYYY-MM-DD'; } ?></u></i>
                            </td>
                      </tr>
                </thead>
                    <tbody id="data_sales">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                         <?php 
                        $foreign_gross = mysqli_query($conn, "select * from tblEnterpise_sales_foreign_gross where foreign_enterprise_id = $user_id");
                        foreach($foreign_gross as $row_gross){?>
                            <tr id="foreign_row<?= $row_gross['foreign_gross_id']; ?>">
                                <td><?= $row_gross['foreign_item']; ?></td>
                              <td>$<?= $row_gross['foreign_estimated_gross']; ?></td>
                              <td>$<?= $row_gross['foreign_projected_gross']; ?></td>
                            </tr>
                       <?php }
                      ?>
                    </tbody>
              </table>
              <table class="table table-bordered minus-top">
                  <thead>
                      <tr>
                          <th style="border-right:none !important;"></th>
                          <th style="border-right:none !important;border-left:none !important;"><center>Split By Country</center></th>
                          <th style="border-left:none !important;"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                  <?php
                      $sbc_query = mysqli_query($conn, "select * from tblEnterpise_sales_sbc where sbc_enterprise_id = $user_id");
                    foreach($sbc_query as $row_sbc){?>
                        <tr>
                            <td><?=$row_sbc['sbc_country_name']; ?></td>
                            <td>$<?= $row_sbc['sbc_gross_1']; ?></td>
                            <td>$<?= $row_sbc['sbc_gross_2']; ?></td>
                        </tr>
                    <?php }
                  ?>
                  </tbody>
                </table>
                <br>
                <h5><b>Annual Revenue</b></h5>
                <p>(Total Annual Revenue Last 2 years):</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Payroll</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><center>Estimated</center></td>
                            <td><center>Projected</center></td>
                            <td><center><i style="font-size:10px;color:orange;">(No. of)</i></center></td>
                            <td><center><i style="font-size:10px;color:orange;">(No. of)</i></center></td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>Code</td>
                            <td>Classification</td>
                            <td> 
                                From: <i><u>YYYY-MM-DD</u></i>
                                <br>
                                To: <i><u>YYYY-MM-DD</u></i>
                            </td>
                            <td>
                                From: <i><u>YYYY-MM-DD</u></i><br>
                                To: <i><u>YYYY-MM-DD</u></i> 
                            </td>
                            <td>Full Time </td>
                            <td>Part Time </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    </tbody>
                </table>
                
                <h5><b>No. of Employees</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total</th>
                            <th>USA/Canada</th>
                            <th>European Union</th>
                            <th>Rest of World</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Coverage Options</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Options</th>
                            <th>Limit Options</th>
                            <th>Retention Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Accidental Contamination</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Malicious Product Tempering</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Combined Single Aggregate</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <br>
                <h5><b>Description of Operations</b></h5>
                <p>Enterprise Process</p>
                <table class="table">
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox">
                                Bottler
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Brand Owner
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Broker
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Buyer
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox">
                                Co-Manufacturer
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                               Co-Packer
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Cultivation
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Distributor
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox">
                                Distribution
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                               Importer
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                IT Services
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Manufacturing
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox">
                                Packing
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                               Packaging
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Professional Services
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Retailer
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox">
                                Reseller
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Supplier of Ingredients
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                               Seller
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="checkbox">
                                Wholesaler
                            </label>
                        </td>
                    </tr>
                </table>
                
                <br>
                <h5><b>Description of Products</b></h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Does the enterprise offer products?</td>
                            <td>
                                <label><input type="radio"> Yes</label>&nbsp;
                                <label><input type="radio"> No</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        Products <i style="font-size:12px;color:orange;">(If yes)</i>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" rows="3" name="ProductDesc"></textarea>
                    </div>
                </div>
                
                <br>
                <h5><b>No. of Plants and Facilities</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>USA/Canada</th>
                            <th>European Union</th>
                            <th>Rest of World</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Product By Plant</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Plant</th>
                            <th>Daily Output <i>(specify units,pounds,bottles, cases,etc.)</i></th>
                            <th>Daily Revenue</th>
                            <th>No. of Production Lines</th>
                            <th>No. of Shifts</th>
                            <th>Percentage of Total Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <br>
                <h5><b>Product Specific Coverage</b></h5>
                <p>(Please complete the following information for the top 3 products or if coverage is product specific,please list products to which insurance is to apply):</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product (Name/Type)</th>
                            <th>Total Sales</th>
                            <th>Average Batch Size in $</th>
                            <th>Largest Batch Size in $</th>
                            <th>Daily Output in $</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <labe>Max Value at 1 Location</labe>
                        <input class="form-control bottom-border" name="max_value">
                    </div>
                </div>
                
                <br>
                <br>
                <h5><b>Import(s)</b></h5>
                <div class="row">
                    <div class="col-md-12">
                        <label>Do you import raw or finished products?</label>&nbsp;&nbsp;&nbsp;
                        <label><input type="radio" placeholder="" name="import"> Yes</label>&nbsp;
                        <label><input type="radio" placeholder="" name="import"> No</label>
                    </div>
                    <div class="col-md-12">
                        <p>If yes, please list a schedule of products/countries of origin:</p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Products</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Branded Products</b></h5>
                <p>(Please provide percentage of branded, non-branded, and/or own label):</p>
                <table class="table table-bordered">
                    <tbody>
                        <tr >
                            <td width="150px">Your Brands</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Non-Branded</td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>3 rd Party’s Brand(s)</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Co-Manufacturing</b></h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="200px">Percentage of products manufactured by 3 rd Party’s</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>What percentage of your products are component part/ingredients of other products:</td>
                            <td>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>New Products < 12 Months</b></h5>
                <p>(Please indicate any new products that have commenced production or have entered the public stream of commerce within the last 12 months)</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Products</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Distribution</b></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Geography</th>
                            <th>Manufacture (as % of total sales)</th>
                            <th>Sales (as % of total sales)</th>
                        </tr>
                    </thead>
                    <tbody id="">
                        <tr>
                            <td>United States</td>
                            <td><input class="form-control no-border" placeholder=""></td>
                            <td><input class="form-control no-border" placeholder=""></td>
                        </tr>
                        <tr>
                            <td>Canada</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>UK</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Europe</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rest of the World</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Customers</b></h5>
                <p>(Please List Your Companies 3 Largest Customers):</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><label class="form-control no-border B">Customer</label> </th>
                            <th><label class="form-control no-border B">Percentage of Sales</label> </th>
                            <th><label class="form-control no-border B">Products Manufactured</label> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5><b>Shelf Life</b></h5>
                <p>(What is the average shelf life of your products (as a percentage of total sales):</p>
                <table class="table table-bordered">
                    <tbody id="">
                        <tr>
                            <td width="180px">Less than a week</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One month to six months</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One week to a month</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>More than six months</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
       <?php }
    }
    }
}
?>
