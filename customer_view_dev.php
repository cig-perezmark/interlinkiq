
<?php 
error_reporting(0);
    $title = "Contacts Relationship Management";
    
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Contacts Relationship Management';
    $site = "Customer Relationship Management";
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
                    <div class="row">
                        <div class="col-md-12">
                            <?php  ?>
                        
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-tabdrop tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Contacts Relationship Management</span>
                                                     
                                                </div>
                                                 <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#details" data-toggle="tab">Details</a>
                                                    </li> 
                                                    <li>
                                                        <a href="#about" data-toggle="tab">About</a>
                                                    </li>
                                                    <li>
                                                        <a href="#products" data-toggle="tab">Products and Services</a>
                                                    </li>
                                                     <li>
                                                        <a href="#contacts" data-toggle="tab">Contacts</a>
                                                    </li>
                                                     <li>
                                                        <a href="#tasks" data-toggle="tab">Tasks</a>
                                                    </li>
                                                     <li>
                                                        <a href="#email" data-toggle="tab">Email</a>
                                                    </li>
                                                     <li>
                                                        <a href="#notes" data-toggle="tab">Notes</a>
                                                    </li>
                                                     <li>
                                                        <a href="#references" data-toggle="tab">References</a>
                                                    </li>
                                                     <?php if($current_userEmployerID == 34): ?>
                                                    <li>
                                                        <a href="#campaign" data-toggle="tab">Campaign</a>
                                                    </li>
                                                    <li>
                                                        <a href="#fse" data-toggle="tab">FSE</a>
                                                    </li>
                                                    <li>
                                                        <a href="#MyPro" data-toggle="tab">MyPro</a>
                                                    </li>
                                                    <?php endif; ?>
                                                    <?php if($_COOKIE['ID'] == 108): ?>
                                                    <li>
                                                        <a href="#quotation" data-toggle="tab">Quotation</a>
                                                    </li>
                                                    <?php endif; ?>
                                                    
                                                </ul>
                                                
                                            </div>
                                              
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <?php   
                                                    // for display country
                                                    $querycountry = "SELECT * FROM countries order by name ASC";
                                                    $resultcountry = mysqli_query($conn, $querycountry);
                                                                        
                                                    // for display details
                                                    $i=1;
                                                    $a=1;
                                                    $b=1;
                                                    $c=1;
                                                    $d=1;
                                                    $e=1;
                                                    $z=1;
                                                    $users = $_COOKIE['ID'];
                                                    $getids = $_GET['view_id'];
                                                    $query = "SELECT * FROM tbl_Customer_Relationship  left join tbl_Customer_Relationship_Task on crm_ids = crm_id where crm_id = '$getids' ";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                         ?>
                                                    <!--start-->
                                                   <div class="tab-pane active" id="details">
                                                       <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                         <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Account Rep.<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="hidden" class="form-control" name="ids" value="<?php  echo $row['crm_id']; ?>" required> 
                                                                    <input type="" class="form-control" name="account_rep" value="<?php echo $row['account_rep']; ?>" > 
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Source/Tag<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="" class="form-control" name="Account_Source" value="<?php echo $row['Account_Source']; ?>" > 
                                                                </div>
                                                             </div> 
                                                       </div>
                                                       <br>
                                                       <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Account Name<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="" class="form-control" name="account_name" value="<?php echo $row['account_name']; ?>" > 
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Parent Account<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>    
                                                                    <input type="" class="form-control" name="parent_account" value="<?php echo $row['parent_account']; ?>" > 
                                                                </div>
                                                             </div> 
                                                       </div>
                                                       <br> 
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Address:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <input type="" class="form-control" name="account_address" value="<?php echo $row['account_address']; ?>" >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"><strong>Country:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                    <select class="form-control" name="account_country" >
                                                                        <option value="0">---Select---</option>
                                                                        
                                                                        <?php 
                                                                         while($rowcountry = mysqli_fetch_array($resultcountry))
                                                                         { ?>
                                                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if($rowcountry['id'] == $row['account_country']){ echo 'selected';}else{echo '';} ?>><?php echo utf8_encode($rowcountry['name']); ?></option>
                                                                        <?php } ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br> 
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Email</strong></label>
                                                                    <input type="" class="form-control" name="account_email" value="<?php echo $row['account_email']; ?>" >
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Phone</strong></label>
                                                                    <input type="" class="form-control" name="account_phone" value="<?php echo $row['account_phone']; ?>" >
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Fax</strong></label>
                                                                    <input type="" class="form-control" name="account_fax" value="<?php echo $row['account_fax']; ?>" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Website</strong>&nbsp;<i style="font-size:12px;"><a href="<?php echo $row['account_website']; ?>" target="_blank">Go to Website</a></i></label>
                                                                    <input type="" class="form-control" name="account_website" value="<?php echo $row['account_website']; ?>" >
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Facebook</strong></label>
                                                                    <input type="" class="form-control" name="account_facebook" value="<?php echo $row['account_facebook']; ?>" >
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Twitter</strong></label>
                                                                    <input type="" class="form-control" name="account_twitter" value="<?php echo $row['account_twitter']; ?>" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                         <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>LinkedIn</strong></label>
                                                                    <input type="" class="form-control" name="account_linkedin" value="<?php echo $row['account_linkedin']; ?>" >
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label"><strong>Interlink</strong></label>
                                                                    <input type="" class="form-control" name="account_interlink" value="<?php echo $row['account_interlink']; ?>" >
                                                                </div>
                                                                <?php if($current_userEmployerID == 34): ?>
                                                                <div class="col-md-2">
                                                                    <div class="form-control-plaintext form-check-inline">
                                                                        <label class="control-label">Status</label>
                                                                        <br>
                                                                        <input type="radio" class="form-check-input" name="account_status" id="status_active" value="Active" <?php  if($row['account_status']=='Active'){echo 'checked';}else{echo '';} ?>>
                                                                        <label class="control-label" >Active</label>
                                                                       &nbsp;
                                                                        <input type="radio" class="form-check-input" name="account_status" id="status_inactive" value="In-Active" <?php  if($row['account_status']=='In-Active'){echo 'checked';}else{echo '';} ?>>
                                                                        <label class="control-label">In-Active</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-control-plaintext form-check-inline">
                                                                        <label class="control-label">Directory</label>
                                                                        <br>
                                                                        <input type="radio" class="form-check-input" name="Account_Directory" id="Account_Directory" value="1" <?php  if($row['Account_Directory']=='1'){echo 'checked';}else{echo '';} ?>>
                                                                        <label class="control-label">Show</label>
                                                                        &nbsp;
                                                                        <input type="radio" class="form-check-input" name="Account_Directory" id="Account_Directory" value="0" <?php  if($row['Account_Directory']=='0'){echo 'checked';}else{echo '';} ?>>
                                                                        <label class="control-label">Hide</label>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <input type="submit" class="btn btn-primary" name="update_details_account" value="Save Changes" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <!--end--> 
                                                    <!--Start-->
                                                    <div class="tab-pane" id="about">
                                                        <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                     <div class="col-md-12">
                                                                        <label class="control-label"><strong>About</strong></label>
                                                                        <input type="hidden" class="form-control" name="ids" value="<?php echo $row['crm_id']; ?>" required> 
                                                                        <textarea class="form-control" name="account_about" rows="20"><?php echo $row['account_about']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <hr>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="submit" class="btn btn-primary" name="update_about" value="Save Changes" >
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--end-->
                                                      <!--Start-->
                                                         <div class="tab-pane" id="products">
                                                             <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Products:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                        <input type="hidden" class="form-control" name="ids" value="<?php echo $row['crm_id']; ?>" required> 
                                                                        <textarea class="form-control" name="account_product" rows="5"><?php echo $row['account_product']; ?></textarea>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Services:<i style="color:orange;" title="This input box is required!!!">*</i></strong></label>
                                                                        <textarea class="form-control" name="account_service" rows="5"><?php echo $row['account_service']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                            <label class="control-label">Industry</label>
                                                                            <select class="form-control" id="account_industry" name="account_industry">
                                                                                <option value="none" <?php if($row['account_industry']=='none'){echo 'selected';}else{echo '';} ?>>Select Industry</option>
                                                                                <option value="510k" <?php if($row['account_industry']=='510k'){echo 'selected';}else{echo '';} ?>>510k</option>
                                                                                <option value="Accounting" <?php if($row['account_industry']=='Accounting'){echo 'selected';}else{echo '';} ?>>Accounting</option>
                                                                                <option value="Acidified Foods" <?php if($row['account_industry']=='Acidified Foods'){echo 'selected';}else{echo '';} ?>>Acidified Foods</option>
                                                                                <option value="Agricultural" <?php if($row['account_industry']=='Agricultural'){echo 'selected';}else{echo '';} ?>> Agricultural</option>
                                                                                <option value="Animal Feed" <?php if($row['account_industry']=='Animal Feed'){echo 'selected';}else{echo '';} ?>>Animal Feed</option>
                                                                                <option value="Aquaculture" <?php if($row['account_industry']=='Aquaculture'){echo 'selected';}else{echo '';} ?>>Aquaculture</option>
                                                                                <option value="Baked Products" <?php if($row['account_industry']=='Baked Products'){echo 'selected';}else{echo '';} ?>> Baked Products</option>
                                                                                <option value="Beef" <?php if($row['account_industry']=='Beef'){echo 'selected';}else{echo '';} ?>>Beef</option>
                                                                                <option value="Beverage" <?php if($row['account_industry']=='Beverage'){echo 'selected';}else{echo '';} ?>>Beverage</option>
                                                                                <option value="Candies" <?php if($row['account_industry']=='Candies'){echo 'selected';}else{echo '';} ?>>Candies</option>
                                                                                <option value="Cannabis" <?php if($row['account_industry']=='Cannabis'){echo 'selected';}else{echo '';} ?>>Cannabis</option>
                                                                                <option value="Catering" <?php if($row['account_industry']=='Catering'){echo 'selected';}else{echo '';} ?>>Catering</option>
                                                                                <option value="Cereals" <?php if($row['account_industry']=='Cereals'){echo 'selected';}else{echo '';} ?>>Cereals</option>
                                                                                <option value="Chemicals" <?php if($row['account_industry']=='Chemicals'){echo 'selected';}else{echo '';} ?>>Chemicals</option>
                                                                                <option value="Chocolate" <?php if($row['account_industry']=='Chocolate'){echo 'selected';}else{echo '';} ?>>Chocolate</option>
                                                                                <option value="Coffee"  <?php if($row['account_industry']=='Coffee'){echo 'selected';}else{echo '';} ?>>Coffee</option>
                                                                                <option value="Confectionery" <?php if($row['account_industry']=='Confectionery'){echo 'selected';}else{echo '';} ?>>Confectionery</option>
                                                                                <option value="CPG/FMCG" <?php if($row['account_industry']=='CPG/FMCG'){echo 'selected';}else{echo '';} ?>>CPG/FMCG</option>
                                                                                <option value="Chicken Products" <?php if($row['account_industry']=='Chicken Products'){echo 'selected';}else{echo '';} ?>>Chicken Products</option>
                                                                                <option value="Cosmetics" <?php if($row['account_industry']=='Cosmetics'){echo 'selected';}else{echo '';} ?>>Cosmetics</option>
                                                                                <option value="Dairy" <?php if($row['account_industry']=='Dairy'){echo 'selected';}else{echo '';} ?>>Dairy</option>
                                                                                <option value="Deli" <?php if($row['account_industry']=='Deli'){echo 'selected';}else{echo '';} ?>>Deli</option>
                                                                                <option value="Dietary Supplement" <?php if($row['account_industry']=='Dietary Supplement'){echo 'selected';}else{echo '';} ?>>Dietary Supplement</option>
                                                                                <option value="Dips" <?php if($row['account_industry']=='Dips'){echo 'selected';}else{echo '';} ?>>Dips</option>
                                                                                <option value="Distribution" <?php if($row['account_industry']=='Distribution'){echo 'selected';}else{echo '';} ?>>Distribution</option>
                                                                                <option value="Equipment" <?php if($row['account_industry']=='Equipment'){echo 'selected';}else{echo '';} ?>>Equipment</option>
                                                                                <option value="Fats" <?php if($row['account_industry']=='Fats'){echo 'selected';}else{echo '';} ?>>Fats</option>
                                                                                <option value="Finance" <?php if($row['account_industry']=='Finance'){echo 'selected';}else{echo '';} ?>>Finance</option>
                                                                                <option value="Fishery" <?php if($row['account_industry']=='Fishery'){echo 'selected';}else{echo '';} ?>>Fishery</option>
                                                                                <option value="Flavoring" <?php if($row['account_industry']=='Flavoring'){echo 'selected';}else{echo '';} ?>>Flavoring</option>
                                                                                <option value="Food" <?php if($row['account_industry']=='Food'){echo 'selected';}else{echo '';} ?>>Food</option>
                                                                                <option value="Functional Foods" <?php if($row['account_industry']=='Functional Foods'){echo 'selected';}else{echo '';} ?>>Functional Foods</option>
                                                                                <option value="Fruits" <?php if($row['account_industry']=='Fruits'){echo 'selected';}else{echo '';} ?>>Fruits</option>
                                                                                <option value="Grains" <?php if($row['account_industry']=='Grains'){echo 'selected';}else{echo '';} ?>>Grains</option>
                                                                                <option value="Gravies" <?php if($row['account_industry']=='Gravies'){echo 'selected';}else{echo '';} ?>>Gravies</option>
                                                                                <option value="Heat to Eat" <?php if($row['account_industry']=='Heat to Eat'){echo 'selected';}else{echo '';} ?>>Heat to Eat</option>
                                                                                <option value="Herbal / Herbs" <?php if($row['account_industry']=='Herbal / Herbs'){echo 'selected';}else{echo '';} ?>>Herbal / Herbs</option>
                                                                                <option value="Honey" <?php if($row['account_industry']=='Honey'){echo 'selected';}else{echo '';} ?>>Honey</option>
                                                                                <option value="Ingredients" <?php if($row['account_industry']=='Ingredients'){echo 'selected';}else{echo '';} ?>>Ingredients</option>
                                                                                <option value="Juice" <?php if($row['account_industry']=='Juice'){echo 'selected';}else{echo '';} ?>>Juice</option>
                                                                                <option value="Kitchen" <?php if($row['account_industry']=='Kitchen'){echo 'selected';}else{echo '';} ?>>Kitchen</option>
                                                                                <option value="Lamb" <?php if($row['account_industry']=='Lamb'){echo 'selected';}else{echo '';} ?>>Lamb</option>
                                                                                <option value="Legal" <?php if($row['account_industry']=='Legal'){echo 'selected';}else{echo '';} ?>>Legal</option>
                                                                                <option value="Manufacturing" <?php if($row['account_industry']=='Manufacturing'){echo 'selected';}else{echo '';} ?>>Manufacturing</option>
                                                                                <option value="Medical Device" <?php if($row['account_industry']=='Medical Device'){echo 'selected';}else{echo '';} ?>>Medical Device</option>
                                                                                <option value="Medical Food" <?php if($row['account_industry']=='Medical Food'){echo 'selected';}else{echo '';} ?>>Medical Food</option>
                                                                                <option value="Nutraceuticals" <?php if($row['account_industry']=='Nutraceuticals'){echo 'selected';}else{echo '';} ?>>Nutraceuticals</option>
                                                                                <option value="Nuts" <?php if($row['account_industry']=='Nuts'){echo 'selected';}else{echo '';} ?>>Nuts</option>
                                                                                <option value="Oils" <?php if($row['account_industry']=='Oils'){echo 'selected';}else{echo '';} ?>>Oils</option>
                                                                                <option value="Organic" <?php if($row['account_industry']=='Organic'){echo 'selected';}else{echo '';} ?>>Organic</option>
                                                                                <option value="Packaging" <?php if($row['account_industry']=='Packaging'){echo 'selected';}else{echo '';} ?>>Packaging</option>
                                                                                <option value="Pharmaceutical" <?php if($row['account_industry']=='Pharmaceutical'){echo 'selected';}else{echo '';} ?>>Pharmaceutical</option>
                                                                                <option value="Pasta" <?php if($row['account_industry']=='Pasta'){echo 'selected';}else{echo '';} ?>>Pasta</option>
                                                                                <option value="Pet Food" <?php if($row['account_industry']=='Pet Food'){echo 'selected';}else{echo '';} ?>>Pet Food</option>
                                                                                <option value="Produce" <?php if($row['account_industry']=='Produce'){echo 'selected';}else{echo '';} ?>>Produce</option>
                                                                                <option value="PMTA" <?php if($row['account_industry']=='PMTA'){echo 'selected';}else{echo '';} ?>>PMTA</option>
                                                                                <option value="Poultry" <?php if($row['account_industry']=='Poultry'){echo 'selected';}else{echo '';} ?>>Poultry</option>
                                                                                <option value="Proteins" <?php if($row['account_industry']=='Proteins'){echo 'selected';}else{echo '';} ?>>Proteins</option>
                                                                                <option value="Raw Materials" <?php if($row['account_industry']=='Raw Materials'){echo 'selected';}else{echo '';} ?>>Raw Materials</option>
                                                                                <option value="Ready-to-Cook" <?php if($row['account_industry']=='Ready-to-Cook'){echo 'selected';}else{echo '';} ?>>Ready-to-Cook</option>
                                                                                <option value="Ready-to-Eat" <?php if($row['account_industry']=='Ready-to-Eat'){echo 'selected';}else{echo '';} ?>>Ready-to-Eat</option>
                                                                                <option value="Reduce Oxygen" <?php if($row['account_industry']=='Reduce Oxygen'){echo 'selected';}else{echo '';} ?>>Reduce Oxygen</option>
                                                                                <option value="Restaurant" <?php if($row['account_industry']=='Restaurant'){echo 'selected';}else{echo '';} ?>>Restaurant</option>
                                                                                <option value="Sauces" <?php if($row['account_industry']=='Sauces'){echo 'selected';}else{echo '';} ?>>Sauces</option>
                                                                                <option value="Sausage" <?php if($row['account_industry']=='Sausage'){echo 'selected';}else{echo '';} ?>>Sausage</option>
                                                                                <option value="Seafood" <?php if($row['account_industry']=='Seafood'){echo 'selected';}else{echo '';} ?>>Seafood</option>
                                                                                <option value="Seeds" <?php if($row['account_industry']=='Seeds'){echo 'selected';}else{echo '';} ?>>Seeds</option>
                                                                                <option value="Soups" <?php if($row['account_industry']=='Soups'){echo 'selected';}else{echo '';} ?>>Soups</option>
                                                                                <option value="Spices" <?php if($row['account_industry']=='Spices'){echo 'selected';}else{echo '';} ?>>Spices</option>
                                                                                <option value="Sushi" <?php if($row['account_industry']=='Sushi'){echo 'selected';}else{echo '';} ?>>Sushi</option>
                                                                                <option value="Systems" <?php if($row['account_industry']=='Systems'){echo 'selected';}else{echo '';} ?>>Systems</option>
                                                                                <option value="Tobacco" <?php if($row['account_industry']=='Tobacco'){echo 'selected';}else{echo '';} ?>>Tobacco</option>
                                                                                <option value="Transportation" <?php if($row['account_industry']=='Transportation'){echo 'selected';}else{echo '';} ?>>Transportation</option>
                                                                                <option value="Utensils" <?php if($row['account_industry']=='Utensils'){echo 'selected';}else{echo '';} ?>>Utensils</option>
                                                                                <option value="Vacuum Packaging" <?php if($row['account_industry']=='Vacuum Packaging'){echo 'selected';}else{echo '';} ?>>Vacuum Packaging</option>
                                                                                <option value="Veal" <?php if($row['account_industry']=='Veal'){echo 'selected';}else{echo '';} ?>>Veal</option>
                                                                                <option value="Vegetables" <?php if($row['account_industry']=='Vegetables'){echo 'selected';}else{echo '';} ?>>Vegetables</option>
                                                                                <option value="Others" <?php if($row['account_industry']=='Others'){echo 'selected';}else{echo '';} ?>>Others</option>
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Category</strong></label>
                                                                           <select class="form-control" id="account_category" name="account_category">
                                                                                <option value="none" <?php if($row['account_category']=='none'){echo 'selected';}else{echo '';} ?>>Select Category</option>
                                                                                <option value="Prospect" <?php if($row['account_category']=='Prospect'){echo 'selected';}else{echo '';} ?>>Prospect</option>
                                                                                <option value="Contact" <?php if($row['account_category']=='Contact'){echo 'selected';}else{echo '';} ?>>Contact</option>
                                                                                <option value="Presentation" <?php if($row['account_category']=='Presentation'){echo 'selected';}else{echo '';} ?>>Presentation</option>
                                                                                <option value="Follow Up" <?php if($row['account_category']=='Follow Up'){echo 'selected';}else{echo '';} ?>>Follow Up</option>
                                                                                <option value="Close the lead" <?php if($row['account_category']=='Close the lead'){echo 'selected';}else{echo '';} ?>>Close the lead</option>
                                                                                <option value="Customer" <?php if($row['account_category']=='Customer'){echo 'selected';}else{echo '';} ?>>Customer</option>
                                                                            </select>
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <label class="control-label"><strong>Certification/s</strong></label>
                                                                        <input type="" class="form-control" name="account_certification" value="<?php echo $row['account_certification']; ?>" >
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <hr>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-md-4">
                                                                            <input type="submit" class="btn btn-primary" name="update_details_contact" value="Save Changes" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                         <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="contacts">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#modal_MoreContacts" class="btn btn-primary"> Add Contacts</a>
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Name</th>
                                                                                <th>Title</th>
                                                                                <th>Report to</th>
                                                                                <th>Address</th>
                                                                                <th>Email</th>
                                                                                <th>Phone</th>
                                                                                <th>Fax</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                <td><?php echo $row['contact_name']; ?></td>
                                                                                <td><?php echo $row['contact_title']; ?></td>
                                                                                <td><?php echo $row['contact_report']; ?></td>
                                                                                <td><?php echo $row['contact_address']; ?></td>
                                                                                <td><?php echo $row['contact_email']; ?></td>
                                                                                <td><?php echo $row['contact_phone']; ?></td>
                                                                                <td><?php echo $row['contact_fax']; ?></td>
                                                                                <td>
                                                                                    <a class="btn blue btn-outline btnViewContact " data-toggle="modal" href="#modalGetContact" data-id="<?php echo $row["crm_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids_c = $_GET['view_id'];
                                                                            $query_c = "SELECT * FROM tbl_Customer_Relationship_More_Contacts where C_crm_ids = $crm_ids_c order by C_ids DESC";
                                                                            $result_c = mysqli_query($conn, $query_c);
                                                                                                        
                                                                            while($row_c = mysqli_fetch_array($result_c))
                                                                            {?>
                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                <td><?php echo $row_c['First_Name']; ?> <?php echo $row_c['Last_Name']; ?></td>
                                                                                <td><?php echo $row_c['C_Title']; ?></td>
                                                                                <td><?php echo $row_c['Report_to']; ?></td>
                                                                                <td><?php echo $row_c['C_Address']; ?></td>
                                                                                <td><?php echo $row_c['C_Email']; ?></td>
                                                                                <td><?php echo $row_c['C_Phone']; ?></td>
                                                                                <td><?php echo $row_c['C_Fax']; ?></td>
                                                                                <td>
                                                                                    <!--<a class="btn blue btn-outline btnViewContact " data-toggle="modal" href="#modalGetContact" data-id="<?php //echo $row["crm_id"]; ?>" style="float:right;margin-right:20px;">-->
                                                                                    <!--        VIEW-->
                                                                                    <!--</a>-->
                                                                                </td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="tasks">
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    
                                                                    <a data-toggle="modal" href="#modalNewTask" class="btn btn-primary">Add Task</a>
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>From</th>
                                                                                <th>Current Task</th>
                                                                                <th>Assigned to</th>
                                                                                <th>Description</th>
                                                                                <th>Email</th>
                                                                                <th>Date Scheduled</th>
                                                                                <th>Deadline</th>
                                                                                <th>Status</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids = $_GET['view_id'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Task left join tbl_hr_employee on ID = Assigned_to where crm_ids = $crm_ids and Task_Status != 3 order by crmt_id DESC";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowt = mysqli_fetch_array($result))
                                                                            {
                                                                            $dateadded = date_create($rowt['Task_added']);
                                                                            $deadline = date_create($rowt['Deadline']);
                                                                            $default_added = date_create($rowt['default_added']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo date_format($default_added,"Y/m/d"); ?></td>
                                                                                <td><?php 
                                                                                        $uploader = $rowt['user_cookies'];
                                                                                        $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                        $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                        while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                            echo $rowGEt['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowGEt['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $rowt['assign_task']; ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $assigned = $rowt['Assigned_to']; 
                                                                                        $users = $_COOKIE['ID'];
                                                                                        $queryassigned = "SELECT * FROM tbl_user where email = '$assigned'";
                                                                                        $resultassigned = mysqli_query($conn, $queryassigned);
                                                                                                                    
                                                                                        while($rowassigned = mysqli_fetch_array($resultassigned))
                                                                                        {
                                                                                            echo $rowassigned['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowassigned['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                 <td><?php echo $rowt['Task_Description']; ?></td>
                                                                                <td><?php echo $rowt['Assigned_to']; ?></td>
                                                                                <td><?php echo date_format($dateadded,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($deadline,"Y/m/d"); ?></td> 
                                                                                <td><?php 
                                                                                    if($rowt['Task_Status'] == 1){
                                                                                        echo "<b style='color:red;'>Pending</b>";
                                                                                    }else if($rowt['Task_Status'] == 2){
                                                                                        echo "<b style='color:orange;'>In-progress</b>";
                                                                                    }else{
                                                                                        echo "<b style='color:green;'>Done</b>";
                                                                                    } 
                                                                                ?></td>
                                                                                <td>
                                                                                    <a class="btn blue btn-outline btnStatus" data-toggle="modal" href="#modalGetStatus" data-id="<?php echo $rowt["crmt_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Completed Task</th>
                                                                                <th>Assigned to</th>
                                                                                <th>Date Added</th>
                                                                                <th>Date Completed</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                             <?php
                                                                             $i=1;
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids = $_GET['view_id'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Task left join tbl_hr_employee on ID = Assigned_to where crm_ids = $crm_ids and Task_Status = 3 order by crmt_id DESC";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowt = mysqli_fetch_array($result))
                                                                            {
                                                                            $dateadded = date_create($rowt['Task_added']);
                                                                            $deadline = date_create($rowt['Deadline']);
                                                                            $default_completed = date_create($rowt['Date_Updated']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $i++; ?></td>
                                                                                 <td><?php echo $rowt['assign_task']; ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $assigned = $rowt['Assigned_to']; 
                                                                                        $users = $_COOKIE['ID'];
                                                                                        $queryassigned = "SELECT * FROM tbl_user where email = '$assigned'";
                                                                                        $resultassigned = mysqli_query($conn, $queryassigned);
                                                                                                                    
                                                                                        while($rowassigned = mysqli_fetch_array($resultassigned))
                                                                                        {
                                                                                            echo $rowassigned['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowassigned['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo date_format($dateadded,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($default_completed,"Y/m/d"); ?></td>
                                                                                <td><?php 
                                                                                    if($rowt['Task_Status'] == 1){
                                                                                        echo "<b style='color:red;'>Pending</b>";
                                                                                    }else if($rowt['Task_Status'] == 2){
                                                                                        echo "<b style='color:orange;'>In-progress</b>";
                                                                                    }else{
                                                                                        echo "<b style='color:green;'>Done</b>";
                                                                                    } 
                                                                                ?></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="email">
                                                        <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#composeMail" class="btn btn-primary"> Compose</a>
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>From</th>
                                                                                <th>Recipient</th>
                                                                                <th>Subject</th>
                                                                                <th>Message</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids = $_GET['view_id'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Mailing where crm_ids = $crm_ids order by mail_id DESC";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowm = mysqli_fetch_array($result))
                                                                            {
                                                                            $date_mail = date_create($rowm['mail_date']); ?>
                                                                            <tr>
                                                                                <td><?php echo date_format($date_mail,"Y/m/d"); ?></td>
                                                                                <td><?php 
                                                                                        $uploader = $rowm['user_cookies'];
                                                                                        $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                        $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                        while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                            echo $rowGEt['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowGEt['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $rowm['Recipients']; ?></td>
                                                                                <td><?php echo $rowm['Subject']; ?></td>
                                                                                <td><?php echo $rowm['Message_body']; ?></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="notes">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#addNotes" class="btn btn-primary"> add Notes</a>
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Added by</th>
                                                                                <th>Title</th>
                                                                                <th>Notes</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids = $_GET['view_id'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_Notes where  crm_ids = $crm_ids order by notes_id DESC";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rown = mysqli_fetch_array($result))
                                                                            {
                                                                            $note_added = date_create($rown['notes_date']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo date('Y-m-d h:i:s', strtotime($rown['notes_stamp'])); ?></td>
                                                                                <td><?php 
                                                                                        $uploader = $rown['user_cookies'];
                                                                                        $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                        $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                        while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                            echo $rowGEt['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowGEt['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $rown['Title']; ?></td>
                                                                                <td><?php echo $rown['Notes']; ?></td>
                                                                                <td>
                                                                                    <a class="btn blue btn-outline btnNotes" data-toggle="modal" href="#modalGetNotes" data-id="<?php echo $rown["notes_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->  
                                                    <!--Start-->
                                                        <div class="tab-pane" id="references">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#addReference" class="btn btn-primary"> add References</a>
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Added by</th>
                                                                                <th>Title</th>
                                                                                <th>Description</th>
                                                                                <th>Date Added</th>
                                                                                <th>Date End</th>
                                                                                <th>Documents</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $users = $_COOKIE['ID'];
                                                                            $crm_ids = $_GET['view_id'];
                                                                            $query = "SELECT * FROM tbl_Customer_Relationship_References where crm_ids = $crm_ids order by reference_id DESC";
                                                                            $result = mysqli_query($conn, $query);
                                                                                                        
                                                                            while($rowf = mysqli_fetch_array($result))
                                                                            {
                                                                            $dateadded = date_create($rowf['Date_Added']);
                                                                            $dateend = date_create($rowf['Date_End']);
                                                                            $ref_added = date_create($rowf['default_reference_added']);
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo date_format($ref_added,"Y/m/d h:i:s"); ?></td>
                                                                                <td><?php 
                                                                                        $uploader = $rowf['user_cookies'];
                                                                                        $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                        $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                        while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                            echo $rowGEt['first_name'];
                                                                                            echo ' ';
                                                                                            echo $rowGEt['last_name'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $rowf['Title']; ?></td>
                                                                                <td><?php echo $rowf['Description']; ?></td>
                                                                                <td><?php echo date_format($dateadded,"Y/m/d"); ?></td>
                                                                                <td><?php echo date_format($dateend,"Y/m/d"); ?></td>
                                                                                <td><a href="Customer_Relationship_files_Folder/<?php echo $rowf['Documents']; ?>"><?php echo $rowf['Documents']; ?></a></td>
                                                                                <td>
                                                                                    <a class="btn blue btn-outline btnReference" data-toggle="modal" href="#modalGetReference" data-id="<?php echo $rowf["reference_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                            VIEW
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                             <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <!--end-->
                                                      <!--Start-->
                                                        <div class="tab-pane" id="campaign">
                                                            <div class="row">
                                                                <div class="tabbable tabbable-tabdrop">
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active">
                                                                            <a href="#tabCampaign_1" data-toggle="tab">Campaign</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tabGreetings_1" data-toggle="tab">Greetings</a>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="tab-content margin-top-20">
                                                                        <div class="tab-pane active" id="tabCampaign_1">
                                                                            <div class="col-md-12">
                                                                                <div class="table-scrollable">
                                                                                <div style="hieght:800px !important;">
                                                                                <a data-toggle="modal" href="#composeCampaign" class="btn btn-primary">Add Campaign</a>
                                                                                <table class="table table-bordered table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Date</th>
                                                                                            <th>Uploaded by</th>
                                                                                            <th>Campaign Name</th>
                                                                                            <th>Recipient</th>
                                                                                            <th>Subject</th>
                                                                                            <th>Message</th>
                                                                                            <th>Frequency</th>
                                                                                            <th>Auto Email</th>
                                                                                            <th></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        $users = $_COOKIE['ID'];
                                                                                        $crm_ids = $_GET['view_id'];
                                                                                        $query = "SELECT * FROM tbl_Customer_Relationship_Campaign where crm_ids = $crm_ids and Campaign_Status = 2 order by Campaign_Id DESC";
                                                                                        $result = mysqli_query($conn, $query);
                                                                                                                    
                                                                                        while($rowcc = mysqli_fetch_array($result))
                                                                                        {
                                                                                        $def_added = date_create($rowcc['Campaign_added']);
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td><?php echo date_format($def_added,"Y/m/d"); ?></td>
                                                                                            <td><?php 
                                                                                                    $uploader = $rowcc['userID'];
                                                                                                    $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                                    $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                                    while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                                        echo $rowGEt['first_name'];
                                                                                                        echo ' ';
                                                                                                        echo $rowGEt['last_name'];
                                                                                                    }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?php echo $rowcc['Campaign_Name']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_Recipients']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_Subject']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_body']; ?></td>
                                                                                            <td>
                                                                                                <?php  
                                                                                                    if($rowcc['Frequency'] == 1){ echo 'Once Per Day'; }
                                                                                                    else if($rowcc['Frequency'] == 2){ echo 'Once Per Week'; }
                                                                                                    else if($rowcc['Frequency'] == 3){ echo 'On the 1st and 15th of the Month'; }
                                                                                                    else if($rowcc['Frequency'] == 4){ echo 'Once Per Month'; }
                                                                                                    else if($rowcc['Frequency'] == 5){ echo 'Once Per Year'; }
                                                                                                    else if($rowcc['Frequency'] == 6){ echo 'Once Per Two Months (Every Other Month)'; }
                                                                                                    else if($rowcc['Frequency'] == 7){ echo 'Once Per Three Months (Quarterly)'; }
                                                                                                    else if($rowcc['Frequency'] == 8){ echo 'Once Per Six Months (Bi-Annual)'; }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php 
                                                                                                if($rowcc['Auto_Send_Status'] == 0){
                                                                                                    echo 'Stopped';
                                                                                                }else{
                                                                                                    echo 'Activated';
                                                                                                }
                                                                                                     
                                                                                                ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <a class="btn blue btn-outline btnCampaign" data-toggle="modal" href="#modalGetCampaign" data-id="<?php echo $rowcc["Campaign_Id"]; ?>" style="float:right;margin-right:20px;">
                                                                                                        VIEW
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php } ?>
                                                                                    </tbody>
                                                                                </table>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="tab-pane" id="tabGreetings_1">
                                                                            <div class="col-md-12">
                                                                                <a data-toggle="modal" href="#composeGreetings" class="btn btn-primary">Add Greetings</a>
                                                                                <table class="table table-bordered table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Date</th>
                                                                                            <th>Uploaded by</th>
                                                                                            <th>Greetings Titles</th>
                                                                                            <th>Recipient</th>
                                                                                            <th>Subject</th>
                                                                                            <th>Message</th>
                                                                                            <th>Scheduled</th>
                                                                                            <th>Auto Email</th>
                                                                                            <th></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        $users = $_COOKIE['ID'];
                                                                                        $crm_ids = $_GET['view_id'];
                                                                                        $query = "SELECT * FROM tbl_Customer_Relationship_Campaign where crm_ids = $crm_ids and Campaign_Status = 1 order by Campaign_Id DESC";
                                                                                        $result = mysqli_query($conn, $query);
                                                                                                                    
                                                                                        while($rowcc = mysqli_fetch_array($result))
                                                                                        {
                                                                                        
                                                                                        $def_added = date_create($rowcc['Campaign_added']);
                                                                                        $schedule_date = date_create($rowcc['date_execute']);
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td><?php echo date_format($def_added,"Y/m/d"); ?></td>
                                                                                            <td><?php 
                                                                                                    $uploader = $rowcc['userID'];
                                                                                                    $queriesGEt = "SELECT * FROM tbl_user where ID = $uploader ";
                                                                                                    $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                                                                                    while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                                                                                        echo $rowGEt['first_name'];
                                                                                                        echo ' ';
                                                                                                        echo $rowGEt['last_name'];
                                                                                                    }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?php echo $rowcc['Campaign_Name']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_Recipients']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_Subject']; ?></td>
                                                                                            <td><?php echo $rowcc['Campaign_body']; ?></td>
                                                                                            <td><?php echo date_format($schedule_date,"Y/m/d"); ?></td>
                                                                                            <td>
                                                                                                <?php 
                                                                                                if($rowcc['Auto_Send_Status'] == 0){
                                                                                                    echo 'Stopped';
                                                                                                }else{
                                                                                                    echo 'Activated';
                                                                                                }
                                                                                                     
                                                                                                ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <a class="btn blue btn-outline btnGreeting" data-toggle="modal" href="#modalGetGreeting" data-id="<?php echo $rowcc["Campaign_Id"]; ?>" style="float:right;margin-right:20px;">
                                                                                                        VIEW
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php } ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <!--end--> 
                                                       <!--Start-->
                                                        <div class="tab-pane" id="quotation">
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
                                                        
                                                        </div>
                                                     <!--end-->  
                                                       <!--Start-->
                                                    <div class="tab-pane" id="fse">
                                                        <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <a data-toggle="modal" href="#addfse" class="btn btn-success"> Add New</a>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Title</th>
                                                                                <th>Description</th>
                                                                                <th>Supporting files</th>
                                                                                <th>Source Link</th>
                                                                                <th>Event Date</th>
                                                                                 <th>Uploaded by</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $fse = 1;
                                                                                $users = $_COOKIE['ID'];
                                                                                $crm_ids = $_GET['view_id'];
                                                                                $queryfse = "SELECT * FROM tbl_Customer_Relationship_FSE where crm_ids = $crm_ids order by FSE_id DESC";
                                                                                $resultfse = mysqli_query($conn, $queryfse);
                                                                                                            
                                                                                while($rowfse = mysqli_fetch_array($resultfse))
                                                                                {
                                                                                // $def_added = date_create($rowcc['Campaign_added']);
                                                                                // $schedule_date = date_create($rowcc['date_execute']);
                                                                                ?>
                                                                            <tr>
                                                                                <td><?php echo $fse++; ?></td>
                                                                                <td><?php echo $rowfse['FSE_Title']; ?></td>
                                                                                <td><?php echo $rowfse['FSE_Description']; ?></td>
                                                                                <td><a href="Customer_Relationship_files_Folder/<?php echo $rowfse['FSE_Documents']; ?>"><?php echo $rowfse['FSE_Documents']; ?></a></td>
                                                                                <td><a href="<?php echo $rowfse['FSE_Source_Link']; ?>" target="_blank"><?php echo $rowfse['FSE_Source_Link']; ?></a></td>
                                                                                <td><?php echo $rowfse['FSE_Event_Date']; ?></td>
                                                                                <td>
                                                                                <?php
                                                                                $users = $_COOKIE['ID'];
                                                                                $added = $rowfse['FSE_Addedby'];
                                                                                $queryu = "SELECT * FROM tbl_user where ID = $added";
                                                                                $resultu = mysqli_query($conn, $queryu);
                                                                                                            
                                                                                while($rowu = mysqli_fetch_array($resultu))
                                                                                {
                                                                                    echo $rowu['first_name'];
                                                                                    echo ' ';
                                                                                    echo $rowu['last_name'];
                                                                                }
                                                                                ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="submit" class="btn btn-primary" name="update_FSE" value="Save Changes" >
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                   <!--end-->
                                                   <div class="tab-pane" id="MyPro">
                                                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="#addNew"> Create Project</a></h3>
                                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
                                                        <thead>
                                                            <tr>
                                                                <th>Tickets#</th>
                                                                 <th>Project Name</th>
                                                                <th>Description</th>
                                                                <th>Request Date</th>
                                                                <th>Desired Due Date</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                     $i_user = $_COOKIE['ID'];
                                                                    $query = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where tbl_MyProject_Services.user_cookies = $i_user and Project_status != 2";
                                                                    $result = mysqli_query($conn, $query);
                                                                                                
                                                                    while($row = mysqli_fetch_array($result))
                                                                    {?>
                                                                    <tr>
                                                                        <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                                                        <td><?php echo $row['Project_Name']; ?></td>
                                                                        <td><?php echo $row['Project_Description']; ?></td>
                                                                        <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                                                        <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                                                        <td>
                                                                            <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                                                            <a href="MyPro_Action_Items.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                                                View
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php }?>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
           <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNewTask" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" action="customer_relationship_AddTask.php" enctype="multipart/form-data" class="modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Add New Task</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php
                                                    $getids = $_GET['view_id'];
                                                    $query = "SELECT * FROM tbl_Customer_Relationship  left join tbl_Customer_Relationship_Task on crm_ids = crm_id where crm_id = '$getids' ";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($rowa = mysqli_fetch_array($result))
                                                    {?>
                                                    <input type="hidden" name="account" value="<?php echo $rowa['account_name']; ?>">
                                                     <?php }  ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Task Name</label>
                                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                                        <?php
                                                           // for display country
                                                            // where user_id = $trap_user
                                                            $trap_user = $_COOKIE['ID'];
                                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                                            $resultuser = mysqli_query($conn, $queryuser);
                                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                                 { ?>
                                                        <input class="form-control" type="hidden" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                                        <?php } ?>
                                                        <input class="form-control" type="text" name="assign_task" id="assign_task" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <div class="form-group">
                                                        <label class="control-label">Description</label></label>
                                                            <textarea  class="form-control" name="Task_Description" ></textarea>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <div class="form-group">
                                                        <label class="control-label">Assign to</label>
                                                            <input type="email" class="form-control" name="Assigned_to" placeholder="Input Email" required>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Start Date</label>
                                                        <input class="form-control" type="date" name="Task_added" id="Task_added" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Deadline</label>
                                                        <input class="form-control" type="date" name="Deadline" id="Deadline" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <input type="submit" class="btn btn-success" name="btntask_submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                          <!--Mail box MODAL AREA-->
        <div class="modal fade" id="composeMail" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" style="width:100%;">
                <div class="modal-content">
                    <form action="customer_relationship_mailer.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Message</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>From</label>
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $trap_user = $_COOKIE['ID'];
                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                            $resultuser = mysqli_query($conn, $queryuser);
                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                 { ?>
                                        <input class="form-control" type="email" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6" >
                                        <label>To</label><i style="color:orange;font-size:12px;">&nbsp;( One email only!! )</i>
                                        <input class="form-control" type="email" name="Recipients" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Subject</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Subject" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Message</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Message_body" id="your_summernote" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnmail_submit" value="Send" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
         <!--Mail box MODAL AREA-->
        <div class="modal fade" id="composeCampaign" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" style="width:100%;">
                <div class="modal-content">
                    <form action="customer_relationship_campaign.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Campaign <i style="color:#fff;font-size:14px;">&nbsp; ( This area is under development!!! )</i></h4>
                        </div>
                        <div class="modal-body">
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Campaign Name</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Campaign_Name" >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>From</label>
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $trap_user = $_COOKIE['ID'];
                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                            $resultuser = mysqli_query($conn, $queryuser);
                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                 { ?>
                                        <input class="form-control" type="email" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6" >
                                        <label>To </label><i style="color:orange;font-size:12px;">&nbsp; ( One email only!! )</i>
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $to = $_GET['view_id'];
                                            $query_to = "SELECT * FROM tbl_Customer_Relationship where crm_id = $to";
                                            $result_to = mysqli_query($conn, $query_to);
                                            while($row_to = mysqli_fetch_array($result_to))
                                                 { ?>
                                                    <input class="form-control" type="email" name="Campaign_Recipients" value="<?php echo $row_to['account_email']; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Subject</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Campaign_Subject"  >
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Message</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Campaign_body" id="your_campaign" rows="4" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Frequency </label>
                                        <!--<input type="number" class="form-control" type="text" name="Frequency" placeholder="No. of Days">-->
                                        <select class="form-control" name="Frequency">
        									<option value="1">Once Per Day</option>
        									<option value="2" selected="">Once Per Week</option>
        									<option value="3">On the 1st and 15th of the Month</option>
        									<option value="4">Once Per Month</option>
        									<option value="6">Once Per Two Months (Every Other Month)</option>
        									<option value="7">Once Per Three Months (Quarterly)</option>
        									<option value="8">Once Per Six Months (Bi-Annual)</option>
        									<option value="5">Once Per Year</option>
        								</select>
                                    </div>
                                </div>
                            </div>
                           <br>
                            
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btncampaign_submit" value="Send" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Mail box MODAL AREA-->
        <div class="modal fade" id="composeGreetings" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" style="width:100%;">
                <div class="modal-content">
                    <form action="customer_relationship_campaign.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Greetings <i style="color:#fff;font-size:14px;">&nbsp; ( This area is under development!!! )</i></h4>
                        </div>
                        <div class="modal-body">
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Greetings Titles</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Campaign_Name" >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>From</label>
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $trap_user = $_COOKIE['ID'];
                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                            $resultuser = mysqli_query($conn, $queryuser);
                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                 { ?>
                                        <input class="form-control" type="email" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6" >
                                        <label>To </label><i style="color:orange;font-size:12px;">&nbsp; ( One email only!! )</i>
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $to = $_GET['view_id'];
                                            $query_to = "SELECT * FROM tbl_Customer_Relationship where crm_id = $to";
                                            $result_to = mysqli_query($conn, $query_to);
                                            while($row_to = mysqli_fetch_array($result_to))
                                                 { ?>
                                                    <input class="form-control" type="email" name="Campaign_Recipients" value="<?php echo $row_to['account_email']; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Subject</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Campaign_Subject"  >
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Message</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Campaign_body" id="your_greetings" rows="4" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                   
                                    <div class="col-md-6" >
                                        <label>Schedule</label>
                                        <input type="date" class="form-control" type="text" name="Target_Date">
                                    </div>
                                </div>
                            </div>
                           <br>
                            
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btncampaign_submit" value="Send" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
               <!--More Contacts box MODAL AREA-->
        <div class="modal fade" id="modal_MoreContacts" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_relationship_More_Contacts.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add More Contacts</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>First Name</label>
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <?php
                                           // for display country
                                            // where user_id = $trap_user
                                            $trap_user = $_COOKIE['ID'];
                                            $queryuser = "SELECT * FROM tbl_user where ID = '$trap_user' order by first_name ASC";
                                            $resultuser = mysqli_query($conn, $queryuser);
                                            while($rowuser = mysqli_fetch_array($resultuser))
                                                 { ?>
                                        <input class="form-control" type="hidden" name="from" value="<?php echo $rowuser['email']; ?>" readonly>
                                        <?php } ?>
                                        <input name="First_Name" class="form-control">
                                    </div>
                                    <div class="col-md-6" >
                                        <label>Last Name</label>
                                        <input class="form-control"  name="Last_Name" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="C_Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Report to </label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Report_to">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Address</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="C_Address">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="email" name="C_Email">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" name="C_Phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Fax</label>
                                            <input class="form-control" name="C_Fax">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Website</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" name="contact_website">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Facebook</label>
                                        <input class="form-control" name="contact_facebook">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Twitter</label>
                                        <input class="form-control" name="contact_twitter">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Linkedin</label>
                                        <input class="form-control" name="contact_linkedin">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Interlink</label>
                                        <input class="form-control" name="contact_interlink">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnAdd_ContactSubmit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_details_contact2" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
         <!--view modalGetStatus modal-->
         <div class="modal fade bs-modal-lg" id="modalGetStatus" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Status</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_details_contact_status" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <!--view Campaign modal-->
         <div class="modal fade bs-modal-lg" id="modalGetCampaign" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Campaign Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_campaign" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
         <!--view Greetingd modal-->
         <div class="modal fade bs-modal-lg" id="modalGetGreeting" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Greeting Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_greeting" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--view Notes modal-->
         <div class="modal fade bs-modal-lg" id="modalGetNotes" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Note Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_notes" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--view Reference modal-->
         <div class="modal fade bs-modal-lg" id="modalGetReference" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                     <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['view_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Reference Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_reference" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
           <!--Mail box MODAL AREA-->
        <div class="modal fade" id="addNotes" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Notes</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Types</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="Notes_Types" required />
                                            <option value="">---Select---</option>
                                            <?php
                                            $queryType = "SELECT * FROM tbl_Notes_Type order by Notes_type ASC";
                                            $resultType = mysqli_query($conn, $queryType);
                                            while($rowType = mysqli_fetch_array($resultType))
                                                 { ?>
                                                 <option value="<?php echo $rowType['NoteType_Id']; ?>"><?php echo $rowType['Notes_type']; ?></option>
                                                 <?php }?>
                                                 <option value="0">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Notes</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <textarea class="form-control" type="text" name="Notes" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnnotes_submit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- References MODAL AREA-->
        <div class="modal fade" id="addReference" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Reference</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <input class="form-control" type="text" name="Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <textarea class="form-control" type="text" name="Description" required /></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date Added</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="date" name="Date_Added" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date End</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="date" name="Date_End" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Documents</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="file" name="Documents" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnreference_submit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- References MODAL AREA-->
        <div class="modal fade" id="addfse" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="hidden" name="crm_ids" id="crm_ids" value="<?php echo $_GET['view_id']; ?>">
                                        <input class="form-control" type="text" name="FSE_Title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <textarea class="form-control" type="text" name="FSE_Description" required /></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Event Date</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input type="date" class="form-control" type="text" name="FSE_Event_Date" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Source Link</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="FSE_Source_Link" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Documents</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="file" name="FSE_Documents" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnrfse_submit" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Create Project-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Customer_Relationship_Folder/customer_relationship_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Project Name</label>
                                        <input type="hidden" class="form-control" type="text" name="view_id" value="<?php echo $_GET['view_id']; ?>">
                                        <input class="form-control" type="text" name="Project_Name" required />
                                    </div>
                                    <div class="col-md-6" >
                                    <label>Image/file <i style="color:#1746A2;font-size:12px;"> ( Sample/Supporting files )</i></label>
                                        <input class="form-control" type="file" name="Sample_Documents">
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Descriptions</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Project_Description" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Start Date</label>
                                        <input class="form-control" type="date" name="Start_Date" required />
                                    </div>
                                    <div class="col-md-6" >
                                        <label>Desired Deliver Date</label>
                                        <input class="form-control" type="date" name="Desired_Deliver_Date" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Collaborator</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="Collaborator[]" multiple required>
                                            <option value="">---Select---</option>
                                            <?php 
                                                
                                                $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = 34 and status = 1 order by first_name ASC";
                                                $resultCollab = mysqli_query($conn, $queryCollab);
                                                                            
                                                while($rowCollab = mysqli_fetch_array($resultCollab))
                                                { ?> 
                                                <option value="<?php echo $rowCollab['ID']; ?>"><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></option>
                                            <?php } ?>
                                             </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnCreate_Project" value="Create" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
                   
                        <!-- / END MODAL AREA -->
          
        <?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      <script>
        $(document).ready(function() {
            $("#your_summernote").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
        $(document).ready(function() {
            $("#your_campaign").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
        $(document).ready(function() {
            $("#your_greetings").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
        
        // View Contact
         $(".btnViewContact").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-contact.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetContact .modal-body").html(data);
                       
                    }
                });
            });
            // View Task Status
         $(".btnStatus").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-contact_status.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetStatus .modal-body").html(data);
                       
                    }
                });
            });
            
             // View Campaign
         $(".btnCampaign").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-campaign.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetCampaign .modal-body").html(data);
                       
                    }
                });
            });
            
             // View Greeting
         $(".btnGreeting").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-Greeting.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetGreeting .modal-body").html(data);
                       
                    }
                });
            });
            
            // View Greeting
         $(".btnNotes").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-notes.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetNotes .modal-body").html(data);
                       
                    }
                });
            });
            
             // View Greeting
         $(".btnReference").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Customer_Relationship_Folder/fetch-reference.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetReference .modal-body").html(data);
                       
                    }
                });
            });
        </script>
        
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
       <style>
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
        /*.uuploader::after{*/
        /*     width:100%;*/
        /*   content:'Update';*/
        /*  font-family:'arial';*/
        /*   font-weight:bold;*/
        /*    color:#fff;*/
        /*    display:block;*/
        /*    top:30px;-->*/
        /*   font-size:12px;*/
        /*   position:abosolute;*/
        /*    text-align:center;*/
        /*}*/
        .uuploader:hover{
         opacity:1;
        }
       </style>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
    </body>
</html>