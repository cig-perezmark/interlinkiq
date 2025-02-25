<?php 

    $query = mysqli_query($conn,"select *from tblEnterpiseDetails where users_entities = '$switch_user_id'");
    foreach($query as $row){
    $array_busi = explode(", ", $row["BusinessPROCESS"]); 
    ?>
            
            <h3 class="block">Organization Details</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Name Insured:</label>
                    <input class="form-control" value="" placeholder="Company Name">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Country:</label>
                    <select class="form-control" name="country">
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
            <div class="form-group">
                <div class="col-md-3">
                    <label>Street address: </label>
                     <input class="form-control" value="<?= $row['Bldg']; ?>" placeholder="Bldg">
                </div>
                <div class="col-md-3">
                    <label>City</label>
                     <input class="form-control" value="<?= $row['city']; ?>" placeholder="City">
                </div>
                <div class="col-md-3">
                    <label>States</label>
                    <input class="form-control" value="<?= $row['States']; ?>" placeholder="States">
                </div>
                <div class="col-md-3">
                    <label>ZIP Code</label>
                     <input class="form-control " value="<?= $row['ZipCode']; ?>" placeholder="ZipCode">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Phone: </label>
                     <input class="form-control" value="<?= $row['businesstelephone']; ?>" placeholder="Phone">
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                     <input type="email" class="form-control" value="<?= $row['businesstelephone']; ?>" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Website: </label>
                    <input class="form-control" value="<?= $row['businesswebsite']; ?>" placeholder="Website"> 
                </div>
                <div class="col-md-6">
                    <label>Date Established:</label>
                    <input class="form-control" value="<?= $row['YearEstablished']; ?>" placeholder="Year Established">
                </div>
            </div>
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
            <div class="form-group">
                <div class="col-md-5">
                    <label class="form-control no-border">If so (Yes), please provide the name of the entity:</label>
                </div>
                <div class="col-md-7">
                    <input class="form-control bottom-border" id="actions" value="" placeholder="Specify" >
                </div>
            </div>
            
            <hr>
            <br>
            <h3 class="block">Officer(s)</h3>
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
                          <td><input class="form-control" name="officer_name[]"></td>
                          <td><input class="form-control" name="officer_title[]"></td>
                          <td><input class="form-control" name="ownership[]"></td>
                          <td><input class="form-control" name="class_code[]"></td>
                          <td><input class="form-control" name="comp_coverage[]"></td>
                          <td><button type="button" name="add_officer_row" id="add_officer_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          
        <hr>
        <br>
        <h3 class="block">No. of Employees</h3>
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
        
        <hr>
        <br>
        <h3 class="block">Description of Operations</h3>
        <p>Enterprise Process</p>
         <div class="form-group">
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="16" <?php if(in_array('16', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Bottler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="13" <?php if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Brand Owner
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="9" <?php if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Broker
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="7" <?php if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Buyer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="4" <?php if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Manufacturer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="3"  <?php if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Packer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="14" <?php if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Cultivation
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="17" <?php if(in_array('17', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distributor
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distribution
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="18" <?php if(in_array('18', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Importer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="12" <?php if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        IT Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Manufacturing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="19" <?php if(in_array('19', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="10" <?php if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packaging
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="11" <?php if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Professional Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="5" <?php if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Retailer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="6" <?php if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Reseller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="20" <?php if(in_array('20', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Supplier of Ingredients
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="8" <?php if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Seller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="21" <?php if(in_array('21', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Wholesaler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="15" <?php if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Others
                    </label>
                </div>
            </div>

            <hr>
            <br>
            <h3 class="block">Description of Operations</h3>
            <div class="form-group">
                <div class="col-md-4">
                    <label>Does the enterprise offer products?</label>
                </div>
                <div class="col-md-2">
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="Yes" <?php if($row['enterpriseProducts']=='Yes'){echo 'checked';}else{echo '';} ?>> Yes</label>&nbsp;
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="No" <?php if($row['enterpriseProducts']=='No'){echo 'checked';}else{echo '';} ?>> No</label>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Products <i style="font-size:12px;color:orange;">(If yes)</i></th>
                        <!--<th></th>-->
                    </tr>
                </thead>
                <tbody id="dynamic_dp">
                    <tr>
                        <td><textarea class="form-control no-border" rows="3" name="ProductDesc"><?php echo $row['ProductDesc']; ?></textarea></td>
                        <!--<td>-->
                        <!--    <button type="button" name="add_dp_row" id="add_dp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>-->
                        <!--</td>-->
                    </tr>
                </tbody>
            </table>
            
            <hr>
            <br>
            <h3 class="block">No. of Plants and Facilities</h3>
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
    <?php } 
?>
