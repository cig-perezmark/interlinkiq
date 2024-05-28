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
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
        <link href="assets/global/plugins/socicon/socicon.css" rel="stylesheet" type="text/css" />
        <style>
            .brandAv {
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
           .uuploader {
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
            .uuploader::before {
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
            .nav-tabs>li.active>a {
                background-color: transparent!important;
                border: transparent!important;
                border-bottom: 2px solid #555!important;
                cursor: default!important;
            }
            .nav-tabs {
                border-bottom: transparent;
            }
            .contact-highlights {
                display: flex;
                justify-content: space-between;
            }
            .contact-title {
                padding: 0.5rem;
            }
            .title-header-contact {
                display: flex;
                justify-content: start;
                padding: 0;
                font-size: 16px;
                font-weight: bold;
                margin: 0;
            }
            .custom-container {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
                margin: 0;
                padding: 0;
            }
            .custom-content {
                padding: 10px;
                background-color: #fbfcfd;
                flex-grow: 1;
                flex-shrink: 1;
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: center;
            }
            .text-ellipsis {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .rounded {
                border-radius: 0.25rem!important;
            }
            .portlet>.portlet-title {
                 border-bottom: transparent; 
            }
            .label-count {
                margin-top: 6px;
                margin-left: 2px;
                padding: 0 5px;
                font-size: 10px;
                border: 1px solid #32c5d2;
                color: #32c5d2;
                border-radius: 50%!important;
            }
            .d-flex-g {
                display:flex;
                gap: 1rem;
            }
            .container-row-reverse {
                display: flex;
                flex-direction: column-reverse;
            }
        </style>
        
        <!------------------------>
        <!--    MODAL BUTTONS   -->
        <!------------------------>
        <div class="row">
            <div class="col-md-12">
                <div class="actions" style="display: flex; justify-content: end; margin-bottom: 3rem">
                    <div class="clearfix">
                        <div class="btn-group btn-group-solid">
                            <button type="button" class="btn green" data-toggle="modal" href="#modal_MoreContacts">Add Contact</button>
                            <button type="button" class="btn default tooltips" data-original-title="Add Task" data-toggle="modal" href="#modalNewTask"><i class="icon-list"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Compose Email" data-toggle="modal" href="#composeMail"><i class="icon-envelope"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Add Notes" data-toggle="modal" href="#addNotes"><i class="icon-notebook"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Add Reference" data-toggle="modal" href="#addReference"><i class="icon-grid"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Compose Campaign" data-toggle="modal" href="#composeCampaign"><i class="icon-flag"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Compose Greetings" data-toggle="modal" href="#composeGreetings"><i class="icon-present"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Add FSE" data-toggle="modal" href="#addfse"><i class="icon-settings"></i></button>
                            <button type="button" class="btn default tooltips" data-original-title="Edit Contact" data-toggle="modal" href="#update-contact"><i class="icon-note"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------->
        <!--    MODAL BUTTONS END  -->
        <!--------------------------->
        
        <?php // MAIN QUERY
            $querycountry = "SELECT * FROM countries order by name ASC";
            $resultcountry = mysqli_query($conn, $querycountry);
            list($i, $a, $b, $c, $d, $e, $z) = array_fill(0, 7, 1);
            $users = $_COOKIE['ID'];
            $getids = $_GET['view_id'];
            $query = "SELECT * FROM tbl_Customer_Relationship left join tbl_Customer_Relationship_Task on crm_ids = crm_id where crm_id = '$getids' ";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result)) { ?>
                
        <div class="container-row-reverse">
        
        <!-------------------------------->
        <!--    CARD DETAILS SECTION    -->
        <!-------------------------------->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content" style="margin-bottom:20rem">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light">
                                    <div class="portlet-title" style="margin-top: 1.3rem; margin-bottom: 0!important">
                                        <div class="caption">
                                            <i class="icon-briefcase font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Contact's informations</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="custom-container">
                                            <div class="custom-content"><span><span class="font-blue uppercase">Account : </span><span class="bold" style="padding: 0 1rem; color:#888"> <?php echo $row['account_name']; ?></span></span></div>
                                            <div class="custom-content"><span><span class="font-blue uppercase">Category : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_category']; ?></span></span></div>
                                            <div class="custom-content"><span><span class="font-blue uppercase">Industry : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_industry'] ?></span></span></div>
                                            <div class="custom-content"><span><span class="font-blue uppercase">Contact no. : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_phone']; ?></span></span></div>
                                        </div>
                                        <!-------------------------------->
                                        <!--     OTHER INFORMATIONS     -->
                                        <!-------------------------------->
                                        <div id="openToggle" class="contact-title" style="display: flex; justify-content: center; margin-top: 2rem">
                                            <p><a id="seeMoreLink" data-toggle="collapse" href="#collapseContent" aria-expanded="false" aria-controls="collapseContent" style="text-decoration: none;"><i class="bi bi-arrow-down-circle-fill text-primary"></i>&nbsp; See more</a></p>
                                        </div>
                                        <div class="collapse" id="collapseContent" style="margin-top: 1rem;">
                                            <div class="custom-container">
                                                <div class="custom-content"><span><span class="font-blue uppercase">Status : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_status']; ?></span></span></div>
                                                <div class="custom-content"><span><span class="font-blue uppercase">Email : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_email']; ?></span></span></div>
                                                <div class="custom-content"><span><span class="font-blue uppercase">Address : </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_address']; ?></span></span></div>
                                                <div class="custom-content"><span><span class="font-blue uppercase">Date Added : </span><span style="padding: 0 1rem; color:#888">
                                                    <?php 
                                                        $default_added = date_create($row['crm_date_added']);
                                                        echo date_format($default_added,"F d, Y");
                                                    ?>
                                                    </span></span>
                                                </div>
                                                <div class="custom-content"><span><span class="font-blue uppercase">Account rep: </span><span style="padding: 0 1rem; color:#888"> <?php echo $row['account_rep']; ?></span></span></div>
                                            </div>
                                            <div id="closeToggle" class="custom-contente" style="display: flex; justify-content: center; margin-top: 4rem">
                                                <p><a id="minimizeLink" data-toggle="collapse" href="#collapseContent" aria-expanded="false" aria-controls="collapseContent" style="text-decoration: none;"><i class="bi bi-arrow-up-circle-fill text-primary"></i>&nbsp; Minimize</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 hidden">
                                <div class="portlet light">
                                     <div class="portlet-title" style="margin-top: 1.3rem; margin-bottom: 0!important">
                                        <div class="caption">
                                            <i class="icon-earphones-alt font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Products &amp; Services</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="contact-highlights">
                                            <h3 class="title-header-contact" style="margin: 2rem 0">Products</h3>
                                            <div class="custom-container">
                                                <?php
                                                    if(empty($row['account_product'])){ echo '<i style="display: flex; justify-content: start; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>No products have been inputted yet.</i>';}else{
                                                    $products = explode(', ', $row['account_product']);
                                                    foreach($products ?? [] as $product) { ?>
                                                        <div class="custom-content rounded text-ellipsis align-item-center">
                                                            <span class="text-center"><?=$product?></span>
                                                        </div>
                                                <?php } }?>
                                            </div>
                                            <h3 class="title-header-contact" style="margin: 2rem 0">Services</h3>
                                            <div class="custom-container">
                                                <?php
                                                    if(empty($row['account_service'])){ echo '<i style="display: flex; justify-content: start; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>No services have been inputted yet.</i>';}else{
                                                    $services = explode(', ', $row['account_service']);
                                                    foreach($services ?? [] as $service) { ?>
                                                        <div class="custom-content rounded text-ellipsis align-item-center">
                                                            <span class="text-center"><?=$service?></span>
                                                        </div>
                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-4 hidden">
                                <div class="portlet light">
                                     <div class="portlet-title" style="margin-top: 1.3rem; margin-bottom: 0!important">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Others</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="contact-highlights socicons">
                                            <div class="contact-title d-flex-g"><a href="javascript:;" data-original-title="Website" class="social-icon picasa tooltips"> </a><span style="margin: 0 0.5rem;"><?php echo $soc = (!empty($row['account_website'])) ? '<a href="'.$row['account_website'].'" target="_blank">'.$row['account_website'].'</a>' : '<i style="display: flex; justify-content: start; padding: 5px 10px; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>Not Specified</i>'; ?></span></div>
                                            <div class="contact-title d-flex-g"><a href="javascript:;" data-original-title="Twitter" class="social-icon twitter tooltips"> </a><span style="margin: 0 0.5rem;"><?php echo $soc2 = (!empty($row['account_twitter'])) ? '<a href="'.$row['account_twitter'].'" target="_blank">'.$row['account_twitter'].'</a>' : '<i style="display: flex; justify-content: start; padding: 5px 10px; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>Not Specified</i>';?></span></div>
                                            <div class="contact-title d-flex-g"><a href="javascript:;" data-original-title="Facebook" class="social-icon facebook tooltips"> </a><span style="margin: 0 0.5rem;"><?php echo $soc3 = (!empty($row['account_facebook'])) ? '<a href="'.$row['account_facebook'].'" target="_blank">'.$row['account_facebook'].'</a>' : '<i style="display: flex; justify-content: start; padding: 5px 10px; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>Not Specified</i>';?></span></div>
                                            <div class="contact-title d-flex-g"><a href="javascript:;" data-original-title="Linkedin" class="social-icon linkedin tooltips"> </a><span style="margin: 0 0.5rem;"><?php echo $soc4 = (!empty($row['account_linkedin'])) ? '<a href="'.$row['account_linkedin'].'" target="_blank">'.$row['account_linkedin'].'</a>' : '<i style="display: flex; justify-content: start; padding: 5px 10px; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>Not Specified</i>';?></span></div>
                                            <div class="contact-title d-flex-g"><a href="javascript:;" data-original-title="InterlinkIQ" class="social-icon rss tooltips"> </a><span style="margin: 0 0.5rem;"><?php echo $soc5 = (!empty($row['account_interlink'])) ? '<a href="'.$row['account_interlink'].'" target="_blank">'.$row['account_interlink'].'</a>' : '<i style="display: flex; justify-content: start; padding: 5px 10px; width: 100%;" class="font-blue"><i style="margin-top:2px; padding: 0 6px;" class="icon-info"></i>Not Specified</i>';?></span></div>
                                        </div>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
        <!----------------------------------->
        <!--    CARD DETAILS SECTION END   -->
        <!----------------------------------->
        
        <!------------------------------->
        <!--    TAB SECTION DETAILS    -->
        <!------------------------------->
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 2rem">
                                <ul class="nav nav-tabs"  style="margin-bottom:3.3rem">
                                     <li class="active">
                                        <a href="#contacts" data-toggle="tab">Contacts
                                            <span class="label-count" id="contacsCountRes">0</span>
                                        </a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="#about" data-toggle="tab">About</a>-->
                                    <!--</li>-->
                                    <li>
                                        <a href="#products" data-toggle="tab">Products and Services</a>
                                    </li>
                                     <li>
                                        <a href="#tasks" data-toggle="tab">Tasks
                                            <span class="label-count" id="tasksCountRes">0</span>
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#email" data-toggle="tab">Email
                                            <span class="label-count" id="emailCountRes">0</span>
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#notes" data-toggle="tab">Notes
                                            <span class="label-count" id="notesCountRes">0</span>
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#references" data-toggle="tab">References
                                            <span class="label-count" id="referencesCountRes">0</span>
                                        </a>
                                    </li>
                                     <?php if($current_userEmployerID == 34): ?>
                                    <li>
                                        <a href="#campaign" data-toggle="tab">Campaign
                                            <span class="label-count" id="campaignCountRes">0 </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#fse" data-toggle="tab">FSE
                                            <span class="label-count" id="fseCountRes">0</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#MyPro" data-toggle="tab">MyPro
                                            <span class="label-count" id="myproCountRes">0</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="portlet light">
                                    <div class="portlet-body" style="margin-top: 3.5rem;">
                                        <div class="tab-content" style="margin-top:3rem">
                                            <!--Start-->
                                            <div class="tab-pane active" id="contacts">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover" id="contactsTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Name</th>
                                                                    <th>Title</th>
                                                                    <th>Report To</th>
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
                                                                        <a class="btn btn-sm green btnViewContact" data-toggle="modal" href="#modalGetContact" data-id="<?php echo $row["crm_id"]; ?>" style="float:right;margin-right:20px;">View</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    $users = $_COOKIE['ID'];
                                                                    $crm_ids_c = $_GET['view_id'];
                                                                    $query_c = "SELECT * FROM tbl_Customer_Relationship_More_Contacts where C_crm_ids = $crm_ids_c order by C_ids DESC";
                                                                    $result_c = mysqli_query($conn, $query_c);
                                                                    $contact = 1;                            
                                                                    while($row_c = mysqli_fetch_array($result_c)) { $contact++; ?>
                                                                    <tr>
                                                                        <td><?php echo $i++; ?></td>
                                                                        <td><?php echo $row_c['First_Name']; ?> <?php echo $row_c['Last_Name']; ?></td>
                                                                        <td><?php echo $row_c['C_Title']; ?></td>
                                                                        <td><?php echo $row_c['Report_to']; ?></td>
                                                                        <td><?php echo $row_c['C_Address']; ?></td>
                                                                        <td><?php echo $row_c['C_Email']; ?></td>
                                                                        <td><?php echo $row_c['C_Phone']; ?></td>
                                                                        <td><?php echo $row_c['C_Fax']; ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <input type="hidden" value="<?=$contact?>" id="contactCount">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end-->  
                                             
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
                                                                <select class="form-control mt-multiselect btn btn-default" id="account_industry" name="account_industry">
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
                                                                <label class="control-label"><strong>Status</strong></label>
                                                               <select class="form-control mt-multiselect btn btn-default" id="account_category" name="account_category">
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
                                                            <div class="col-md-12">
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
                                            
                                            <!--Start-->
                                            <div class="tab-pane" id="tasks">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover" id="tasksTable">
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
                                                                $task = 0;                            
                                                                while($rowt = mysqli_fetch_array($result)) {
                                                                    $task++;
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
                                                                
                                                                <input type="hidden" value="<?=$task?>" id="tasksCount">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" style="margin-top: 8rem;">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover" id="tasks2Table">
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
                                                                $task2 = 0;                            
                                                                while($rowt = mysqli_fetch_array($result))
                                                                {
                                                                    $task2++;
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
                                                                <input type="hidden" value="<?=$task2?>" id="tasks2Count">
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
                                                        <table class="table table-bordered table-hover" id="emailsTable">
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
                                                                $email = 0;                            
                                                                while($rowm = mysqli_fetch_array($result)) {
                                                                    $email++;
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
                                                                <input type="hidden" value="<?=$email?>" id="emailCount">
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
                                                        <table class="table table-bordered table-hover" id="notesTable">
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
                                                                $notes = 0;                            
                                                                while($rown = mysqli_fetch_array($result)) {
                                                                    $notes++;
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
                                                                <input type="hidden" value="<?=$notes?>" id="notesCount">
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
                                                        <table class="table table-bordered table-hover" id="referencesTable">
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
                                                                $reference = 0;                            
                                                                while($rowf = mysqli_fetch_array($result))
                                                                {
                                                                    $reference++;
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
                                                                 <input type="hidden" value="<?=$reference?>" id="referenceCount">
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
                                                                    <table class="table table-bordered table-hover" id="campaignsTable">
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
                                                                            $campaign = 0;                            
                                                                            while($rowcc = mysqli_fetch_array($result)) {
                                                                                $campaign++;
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
                                                                            <input type="hidden" value="<?=$campaign?>" id="campaignCount">
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="tabGreetings_1">
                                                                <div class="col-md-12">
                                                                    <table class="table table-bordered table-hover" id="greetingsTable">
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
                                            <div class="tab-pane" id="fse">
                                                <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered table-hover" id="fsesTable">
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
                                                                        $fse = 0;
                                                                        $users = $_COOKIE['ID'];
                                                                        $crm_ids = $_GET['view_id'];
                                                                        $queryfse = "SELECT * FROM tbl_Customer_Relationship_FSE where crm_ids = $crm_ids order by FSE_id DESC";
                                                                        $resultfse = mysqli_query($conn, $queryfse);
                                                                                                    
                                                                        while($rowfse = mysqli_fetch_array($resultfse)) { 
                                                                            $fse++;
                                                                        // $def_added = date_create($rowcc['Campaign_added']);
                                                                        // $schedule_date = date_create($rowcc['date_execute']);
                                                                        ?>
                                                                    <tr data-id="<?=$fse?>">
                                                                        <td><?php echo $fse; ?></td>
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
                                                                    <input type="hidden" value="<?=$fse?>" id="fseCount">
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
                                           
                                           <!--Start-->
                                           <div class="tab-pane" id="MyPro">
                                                <!--<h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="#addNew"> Create Project</a></h3>-->
                                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="myproTable">
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
                                                            $mypro = 0;                            
                                                            while($row = mysqli_fetch_array($result)) { 
                                                                $mypro++;
                                                            ?>
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
                                                        <input type="hidden" value="<?=$mypro?>" id="myproCount">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!----------------------------------->
        <!--    TAB SECTION DETAILS END    -->
        <!----------------------------------->
        </div>
        <?php } // END MAIN QUERY ?>
        
        
        <!--------------------->
        <!--    MODAL AREA   -->
        <!--------------------->
        
        <div class="modal fade" id="update-contact" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="Customer_Relationship_Folder/customer_relationship_function.php" enctype="multipart/form-data" class="modalForm modalSave">
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
                            <input type="submit" class="btn btn-success" name="update_details_account" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
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
        
        <!------------------------->
        <!--    END MODAL AREA   -->
        <!------------------------->
          
        <?php include_once ('footer.php'); ?>
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function() {
                
                var contacsCountRes = $('#contactCount').val()
                $('#contacsCountRes').html(contacsCountRes)
                
                var tasksCountRes = parseInt($('#tasksCount').val(), 10) || 0;
                var tasksCountRes2 = parseInt($('#tasks2Count').val(), 10) || 0;
                var totalTasks = tasksCountRes + tasksCountRes2;
                
                $('#tasksCountRes').html(totalTasks);
                
                var emailCountRes = $('#emailCount').val()
                $('#emailCountRes').html(emailCountRes)
                
                var notesCountRes = $('#notesCount').val()
                $('#notesCountRes').html(notesCountRes)
                
                var referencesCountRes = $('#referenceCount').val()
                $('#referencesCountRes').html(referencesCountRes)
                
                var campaignCountRes = $('#campaignCount').val()
                $('#campaignCountRes').html(campaignCountRes)
                
                var fseCount = $('#fseCount').val()
                $('#fseCountRes').html(fseCount)
                
                var myproCountRes = $('#myproCount').val()
                $('#myproCountRes').html(myproCountRes)
                
            })
        </script>
        
        <!------------------------->
        <!--     TABLE SCRIPT    -->
        <!------------------------->
        <script>
            var TableDatatablesRowreorder = function () {
                var initTable = function (tableId) {
                    var table = $('#' + tableId);
        
                    var oTable = table.DataTable({
        
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green ' }
                        ],
        
                        "order": [
                            [1, 'desc']
                        ],
        
                        "lengthMenu": [
                            [5, 10, 15, 20, -1],
                            [5, 10, 15, 20, "All"]
                        ],
                        
                        "pageLength": 10,
        
                        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    });
                }
        
                return {
                    init: function (tableId) {
                        if (!jQuery().DataTable) {
                            return;
                        }
        
                        initTable(tableId);
                    }
                };
            }();
        
            jQuery(document).ready(function() {
                TableDatatablesRowreorder.init('contactsTable');
                TableDatatablesRowreorder.init('tasksTable');
                TableDatatablesRowreorder.init('tasks2Table');
                TableDatatablesRowreorder.init('emailsTable');
                TableDatatablesRowreorder.init('notesTable');
                TableDatatablesRowreorder.init('referencesTable');
                TableDatatablesRowreorder.init('campaignsTable');
                TableDatatablesRowreorder.init('greetingsTable');
                TableDatatablesRowreorder.init('fsesTable');
                TableDatatablesRowreorder.init('myproTable');
            });
        </script>

        <script>
            $(document).ready(function () {
                $('#closeToggle').hide();
        
                $('#seeMoreLink').on('click', function () {
                    $('#collapseContent').collapse('show');
                    $('#openToggle').hide();
                    $('#closeToggle').show();
                });
        
                $('#minimizeLink').on('click', function () {
                    setTimeout(function () {
                        $('#collapseContent').collapse('hide');
                        $('#openToggle').show();
                        $('#closeToggle').hide();
                    }, 200);
                });
            });
        </script>
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
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
    </body>
</html>