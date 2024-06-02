
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
        $contact_view_id = $_GET['view_id'];

        include_once ('header.php'); 
        $stmt = $conn->prepare('SELECT id, name FROM countries ORDER BY name ASC');
        if ($stmt === false) {
            echo 'Error preparing Statement: ' . $conn->error;
            exit;
        }
        $stmt->execute();
        $stmt->bind_result($id, $name);
        $countries = [];
        while ($stmt->fetch()) {
            $countries[] = ['id' => $id, 'name' => $name];
        }
        $stmt->close();

        $details = $conn->prepare('SELECT c.id, c.name, r.account_website, r.account_about, r.account_product, r.account_service, r.account_industry, r.account_category, r.account_certification FROM tbl_customer_relationship r JOIN countries c ON r.account_country = c.id WHERE crm_id = ?');
        if ($details === false) {
            echo 'Error preparing Statement: ' . $conn->error;
            exit;
        }
        $details->bind_param('i', $contact_view_id);
        $details->execute();
        $details->bind_result($country_id, $country, $website, $about, $product, $services, $industry, $category, $certification);
        $details->fetch();
        $details->close();
    ?>
        <style>
            html {
                scroll-behavior: smooth;
            }
            .content {
                height: 1800px;
                background-color: lightgray;
                margin: 20px 0;
            }
            .nav-tabs {
                display: flex;
                justify-content: end;
                margin-bottom: 3rem; 
                border: 1px solid transparent !important;
            }
            .nav-tabs li {
                background: #fff;
                 box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            .page-container-bg-solid .tabbable-line>.tab-content {
                border-top: 1px solid transparent;
            }
            .d-flex-end {
                display: flex;
                justify-content: end;
            }
            .mt-4 {
                margin-top: 2rem;
            }
            .mt-6 {
                margin-top: 5rem;
            }
            .d-none {
                display: none;
            }
            .dt-buttons {
                margin: 0  0 2rem 0;
            }
            .sticky-nav {
                position: -webkit-sticky; /* For Safari */
                position: sticky;
                top: 60px;
                z-index: 999; 
                border-bottom: 1px solid #ccc;
                width: 100%;
                padding-top: 10px;
                border: 1px solid transparent;
            }
            body {
                padding-top: 70px;
            }
            #old-document-container {
                padding: 10px 0;
            }

            #old-document-container a{
                text-decoration: none;
            }

        </style>
        <div class="row">
            <div class="col-md-12">
                <div class="sticky-nav">
                    <ul class="nav nav-tabs fixed-nav" id="universal_id" data-id="<?=$contact_view_id?>">
                        <li><a href="#contact_details">Details</a></li> 
                        <li><a href="#contact_contacts">Contacts</a></li>
                        <li><a href="#contact_tasks">Tasks</a></li>
                        <li><a href="#contact_notes">Notes</a></li>
                        <li><a href="#contact_reference">References</a></li>
                        <li><a href="#contact_email">Email</a></li>
                        <li><a href="#contact_campaign">Campaign</a></li>
                        <li><a href="#contact_about">About</a></li>
                        <li><a href="#contact_product">Products & Services</a></li>
                        <?php if($current_userEmployerID == 34): ?>
                            <li><a href="#contact_fse">FSE</a></li>
                            <li><a href="#contact_mypro">MyPro</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12 contact_details" id="contact_details">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Contact's Details</h4>
                                </div>
                                <div class="widget-thumb-wrap">
                                        <form class="modalForm modalSave" id="accountDetailsForm">
                                            <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Account Rep.</strong></label>
                                                    <input type="text" class="form-control" name="account_rep">
                                                    <input type="hidden" class="form-control" name="id">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Source/Tag</strong></label>
                                                    <input type="text" class="form-control" name="Account_Source"> 
                                                </div>
                                                </div> 
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Account Name</strong></label>
                                                    <input type="text" class="form-control" name="account_name"> 
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Parent Account</strong></label>    
                                                    <input type="text" class="form-control" name="parent_account"> 
                                                </div>
                                                </div> 
                                        </div>
                                        <br> 
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Address</strong></label>
                                                    <input type="text" class="form-control" name="account_address">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label"><strong>Country</strong></label>
                                                    <select class="form-control mt-multiselect" name="account_country">
                                                            <option value="<?=$country_id?>"><?=$country?></option>
                                                        <?php if(!empty($countries)): foreach($countries as $country): ?>
                                                            <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                                        <?php endforeach; endif?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br> 
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Email</strong></label>
                                                    <input type="text" class="form-control" name="account_email">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Phone</strong></label>
                                                    <input type="text" class="form-control" name="account_phone">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Fax</strong></label>
                                                    <input type="text" class="form-control" name="account_fax">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Website</strong>&nbsp;<i style="font-size:12px;"><a href="<?=$website?>" target="_blank">Go to Website</a></i></label>
                                                    <input type="text" class="form-control" name="account_website">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Facebook</strong></label>
                                                    <input type="text" class="form-control" name="account_facebook">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Twitter</strong></label>
                                                    <input type="text" class="form-control" name="account_twitter">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>LinkedIn</strong></label>
                                                    <input type="text" class="form-control" name="account_linkedin">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"><strong>Interlink</strong></label>
                                                    <input type="text" class="form-control" name="account_interlink">
                                                </div>
                                                
                                                <div class="col-md-2" id="status-container">
                                                </div>
                                                <div class="col-md-2" id="directory-container">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 mt-4 d-flex-end">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_contacts" id="contact_contacts">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Contacts</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#contactModal" >Add New Contact</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover" id="contactsTable">
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_tasks" id="contact_tasks">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Task</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalTaskForm" >Add New Task</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#pending-task" data-toggle="tab"> Pending </a>
                                    </li>
                                    <li>
                                        <a href="#completed-task" data-toggle="tab"> Completed </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pending-task">
                                        <div class="widget-thumb-wrap">
                                            <table class="table table-bordered table-hover table-striped dataTable no-footer" id="pendingTaskTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th>Task</th>
                                                        <th>Originator</th>
                                                        <th>Assigned to</th>
                                                        <th>Status</th>
                                                        <th>Due</th>
                                                        <th width="%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="completed-task">
                                        <div class="widget-thumb-wrap">
                                            <table class="table table-bordered table-hover table-striped dataTable no-footer" id="completedTaskTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th>Task</th>
                                                        <th>Originator</th>
                                                        <th>Assigned to</th>
                                                        <th>Status</th>
                                                        <th>Due</th>
                                                        <th width="%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_notes" id="contact_notes">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Notes</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalAddNotes" >Add New Notes</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover" id="notesTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Added by</th>
                                                <th>Notes</th>
                                                <th width="%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_reference" id="contact_reference">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">References</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#addReference" >Add New Reference</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
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
                                                <th width="%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_email" id="contact_email">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Emails</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalTaskForm" >Add New Email</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover" id="emailsTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>From</th>
                                                <th>Recipient</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_campaign" id="contact_campaign">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Campaigns</h4>
                                    <div class="actions d-none">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#addReference" >Add New Campaign</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <table class="table table-bordered table-hover" id="campaignsTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Campained by</th>
                                                <th>Campaign name</th>
                                                <th>Recipient</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Frequency</th>
                                                <th>Status</th>
                                                <th width="%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_about" id="contact_about">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">About Contact</h4>
                                </div>
                                <div class="widget-thumb-wrap">
                                    <form id="updateAbout">
                                        <div class="row">
                                            <div class="form-group">
                                                    <div class="col-md-12">
                                                    <label class="control-label"><strong>About</strong></label>
                                                    <input type="hidden" name="contact_id" value="<?= $contact_view_id?>">
                                                    <textarea class="form-control" name="account_about" rows="20"><?= $about?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-4 d-flex-end">
                                                <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-out" id="aboutBtn"><span class="ladda-label">Save Changes</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_product" id="contact_product">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">Contact's Products and Services</h4>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pending-task">
                                        <div class="widget-thumb-wrap">
                                            <form id="updateProduct">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <label class="control-label"><strong>Industry</strong></label>
                                                            <input type="hidden" name="contact_id" value="<?= $contact_view_id?>">
                                                            <select class="form-control mt-multiselect btn btn-default" id="account_industry" name="account_industry">
                                                                <option value="<?= $industry?>"><?= $industry?></option>
                                                                <option value="510k">510k</option>
                                                                <option value="Accounting">Accounting</option>
                                                                <option value="Acidified Foods">Acidified Foods</option>
                                                                <option value="Agricultural">Agricultural</option>
                                                                <option value="Animal Feed">Animal Feed</option>
                                                                <option value="Aquaculture">Aquaculture</option>
                                                                <option value="Baked Products">Baked Products</option>
                                                                <option value="Beef">Beef</option>
                                                                <option value="Beverage">Beverage</option>
                                                                <option value="Candies">Candies</option>
                                                                <option value="Cannabis">Cannabis</option>
                                                                <option value="Catering">Catering</option>
                                                                <option value="Cereals">Cereals</option>
                                                                <option value="Chemicals">Chemicals</option>
                                                                <option value="Chocolate">Chocolate</option>
                                                                <option value="Coffee">Coffee</option>
                                                                <option value="Confectionery">Confectionery</option>
                                                                <option value="CPG/FMCG">CPG/FMCG</option>
                                                                <option value="Chicken Products">Chicken Products</option>
                                                                <option value="Cosmetics">Cosmetics</option>
                                                                <option value="Dairy">Dairy</option>
                                                                <option value="Deli">Deli</option>
                                                                <option value="Dietary Supplement">Dietary Supplement</option>
                                                                <option value="Dips">Dips</option>
                                                                <option value="Distribution">Distribution</option>
                                                                <option value="Equipment">Equipment</option>
                                                                <option value="Fats">Fats</option>
                                                                <option value="Finance">Finance</option>
                                                                <option value="Fishery">Fishery</option>
                                                                <option value="Flavoring">Flavoring</option>
                                                                <option value="Food">Food</option>
                                                                <option value="Functional Foods">Functional Foods</option>
                                                                <option value="Fruits">Fruits</option>
                                                                <option value="Grains">Grains</option>
                                                                <option value="Gravies">Gravies</option>
                                                                <option value="Heat to Eat">Heat to Eat</option>
                                                                <option value="Herbal / Herbs">Herbal / Herbs</option>
                                                                <option value="Honey">Honey</option>
                                                                <option value="Ingredients">Ingredients</option>
                                                                <option value="Juice">Juice</option>
                                                                <option value="Kitchen">Kitchen</option>
                                                                <option value="Lamb">Lamb</option>
                                                                <option value="Legal">Legal</option>
                                                                <option value="Manufacturing">Manufacturing</option>
                                                                <option value="Medical Device">Medical Device</option>
                                                                <option value="Medical Food">Medical Food</option>
                                                                <option value="Nutraceuticals">Nutraceuticals</option>
                                                                <option value="Nuts">Nuts</option>
                                                                <option value="Oils">Oils</option>
                                                                <option value="Organic">Organic</option>
                                                                <option value="Packaging">Packaging</option>
                                                                <option value="Pharmaceutical">Pharmaceutical</option>
                                                                <option value="Pasta">Pasta</option>
                                                                <option value="Pet Food">Pet Food</option>
                                                                <option value="Produce">Produce</option>
                                                                <option value="PMTA">PMTA</option>
                                                                <option value="Poultry">Poultry</option>
                                                                <option value="Proteins">Proteins</option>
                                                                <option value="Raw Materials">Raw Materials</option>
                                                                <option value="Ready-to-Cook">Ready-to-Cook</option>
                                                                <option value="Ready-to-Eat">Ready-to-Eat</option>
                                                                <option value="Reduce Oxygen">Reduce Oxygen</option>
                                                                <option value="Restaurant">Restaurant</option>
                                                                <option value="Sauces">Sauces</option>
                                                                <option value="Sausage">Sausage</option>
                                                                <option value="Seafood">Seafood</option>
                                                                <option value="Seeds">Seeds</option>
                                                                <option value="Soups">Soups</option>
                                                                <option value="Spices">Spices</option>
                                                                <option value="Sushi">Sushi</option>
                                                                <option value="Systems">Systems</option>
                                                                <option value="Tobacco">Tobacco</option>
                                                                <option value="Transportation">Transportation</option>
                                                                <option value="Utensils">Utensils</option>
                                                                <option value="Vacuum Packaging">Vacuum Packaging</option>
                                                                <option value="Veal">Veal</option>
                                                                <option value="Vegetables">Vegetables</option>
                                                                <option value="Others">Others</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label"><strong>Category</strong></label>
                                                            <select class="form-control mt-multiselect btn btn-default" id="account_category" name="account_category">
                                                                <option value="<?= $category?>"><?= $category?></option>
                                                                <option value="Prospect">Prospect</option>
                                                                <option value="Contact">Contact</option>
                                                                <option value="Presentation">Presentation</option>
                                                                <option value="Follow Up">Follow Up</option>
                                                                <option value="Close the lead">Close the lead</option>
                                                                <option value="Customer">Customer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <label class="control-label"><strong>Products</strong></label>
                                                            <textarea class="form-control" name="account_product" rows="5"><?= $product?></textarea>                    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label"><strong>Services</strong></label>
                                                            <textarea class="form-control" name="account_service" rows="5"><?= $services?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label"><strong>Certification/s</strong></label>
                                                            <input type="text" class="form-control" name="account_certification" value="<?= $certification?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-12 mt-4 d-flex-end">
                                                            <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-out" id="productBtn"><span class="ladda-label">Save Changes</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_fse" id="contact_fse">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">FSE</h4>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#fseModal" >Add New FSE</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pending-task">
                                        <div class="widget-thumb-wrap">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 contact_project" id="contact_mypro">
                            <div class="widget-thumb widget-bg-color-white margin-bottom-20 tabbable-line">
                                <div class="d-flex justify-content-between">
                                    <h4 class="widget-thumb-heading text-uppercase">My Pro</h4>
                                    <div class="actions d-none">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#projectModal" >Add New Project</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pending-task">
                                        <div class="widget-thumb-wrap">
                                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="projectsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Tickets#</th>
                                                        <th>Project Name</th>
                                                        <th>Description</th>
                                                        <th>Request Date</th>
                                                        <th>Desired Due Date</th>
                                                        <th width="%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fseModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="fseForm" enctype="multipart/form-data">
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
                                        <input class="form-control" type="text" name="contact_id" value="<?=$contact_view_id?>">
                                        <input class="form-control" type="text" name="title" required />
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
                                        <textarea class="form-control" type="text" name="description" required /></textarea>
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
                                        <input type="date" class="form-control" type="text" name="date" required>
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
                                        <input class="form-control" type="text" name="source" required>
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
                                        <input class="form-control" type="file" name="file" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Create Project-->
        <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="projectForm" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Project Name</label>
                                        <input class="form-control" type="text" name="contact_id" value="<?=$contact_view_id?>">
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
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="contactForm">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add More Contacts</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>First Name</label>
                                        <input type="hidden" id="contact-id" value="<?=$contact_view_id?>" name="contactid">
                                        <input name="first" class="form-control">
                                    </div>
                                    <div class="col-md-6" >
                                        <label>Last Name</label>
                                        <input class="form-control"  name="last" required />
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
                                        <input class="form-control" type="text" name="title" required />
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
                                        <input class="form-control" type="text" name="report">
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
                                        <input class="form-control" type="text" name="address">
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
                                        <input class="form-control" type="email" name="email">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Fax</label>
                                            <input class="form-control" name="fax">
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
                                        <input class="form-control" name="website">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Facebook</label>
                                        <input class="form-control" name="facebook">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Twitter</label>
                                        <input class="form-control" name="twitter">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Linkedin</label>
                                        <input class="form-control" name="linkedin">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Interlink</label>
                                        <input class="form-control" name="interlink">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateContactModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateContact">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Edit Contacts</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6" >
                                        <label>First Name</label>
                                        <input type="text" name="contactid" id="contact_info_id" class="form-control">
                                        <input name="first" class="form-control" id="contact_info_first">
                                    </div>
                                    <div class="col-md-6" >
                                        <label>Last Name</label>
                                        <input class="form-control" name="last" id="contact_info_last" required />
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
                                        <input class="form-control" type="text" name="title" id="contact_info_title" required />
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
                                        <input class="form-control" type="text" name="report" id="contact_info_report">
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
                                        <input class="form-control" type="text" name="address" id="contact_info_address">
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
                                        <input class="form-control" type="email" name="email" id="contact_info_email">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" name="phone" id="contact_info_phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Fax</label>
                                            <input class="form-control" name="fax" id="contact_info_fax">
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
                                        <input class="form-control" name="website" id="contact_info_website">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Facebook</label>
                                        <input class="form-control" name="facebook" id="contact_info_facebook">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Twitter</label>
                                        <input class="form-control" name="twitter" id="contact_info_twitter">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                        <label>Linkedin</label>
                                        <input class="form-control" name="linkedin" id="contact_info_linkedin">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Interlink</label>
                                        <input class="form-control" name="interlink" id="contact_info_interlink">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTaskForm" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="taskForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Task</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <input type="hidden" value="<?=$contact_view_id?>" name="contact">
                                        <input class="form-control" type="text" name="task" id="assign_task" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Description</label></label>
                                            <textarea  class="form-control" name="description" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Assign to</label>
                                        <select class="form-control mt-multiselect btn btn-default get-person-activity" name="assignee" type="text" required style="width: 100%">
                                            <option>Select Person</option>
                                            <?php
                                                $user_id = $switch_user_id ?? 34 ;
                                                $query = mysqli_prepare($conn, "SELECT CONCAT(first_name, ' ', last_name) as name, email FROM tbl_hr_employee WHERE user_id = ? ORDER BY first_name ASC");
                                                mysqli_stmt_bind_param($query, 'i', $user_id);
                                                mysqli_stmt_execute($query);
                                                if(!$query){
                                                    die('Error: '. mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($query, $name, $email);
                                                while(mysqli_stmt_fetch($query)) {
                                                    echo '<option value="'.$email.'">'.$name.'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label>
                                        <input class="form-control" type="date" name="startdate" id="Task_added" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deadline</label>
                                        <input class="form-control" type="date" name="duedate" id="Deadline" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <input type="submit" class="btn btn-success" id="taskFormBtn" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalEditTaskForm" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateTaskForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Edit Task</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <input class="form-control" type="text" name="task_name" id="task-name" required>
                                        <input class="form-control" type="hidden" name="old_assigned" id="old-assigned" required>
                                        <input class="form-control" type="hidden" name="taskid" id="taskid" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Task Name</label>
                                        <select class="form-control" name="status" id="task-status">
                                            <option value="1">Pending</option>
                                            <option value="2">In Progress</option>
                                            <option value="3">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Description</label></label>
                                            <textarea  class="form-control" name="description" rows="5" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label">Assign to
                                            <span class="text-success">Current Assigned: </span> <span class="text-blue" id="assigned-to"> </span>
                                        </label>
                                        <select class="form-control" name="assign_to" type="text" required style="width: 100%">
                                            <option>Select Person</option>
                                            <?php
                                                $user_id = $switch_user_id ?? 34 ;
                                                $query = mysqli_prepare($conn, "SELECT first_name, last_name, email FROM tbl_hr_employee WHERE user_id = ? AND status = 1 ORDER BY first_name ASC");
                                                mysqli_stmt_bind_param($query, 'i', $user_id);
                                                mysqli_stmt_execute($query);
                                                if(!$query){
                                                    die('Error: '. mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($query, $first_name, $last_name, $email);
                                                while(mysqli_stmt_fetch($query)) {
                                                    echo '<option value="'.$email.'">'.$first_name.' '.$last_name.'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date <span id="startdate1"></span> </label>
                                        <input class="form-control" type="date" name="startdate" id="startdate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deadline</label>
                                        <input class="form-control" type="date" name="duedate" id="duedate" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<input type="submit" class="btn btn-info">Save Changes</button>      -->
                             <input type="submit" name="update_task" class="btn btn-info" value="Save Changes">
                         </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAddNotes" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="noteForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Notes</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Notes</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" id="contact-id" value="<?=$contact_view_id?>" name="contactid">
                                        <textarea class="form-control" type="text" name="notes" col="5" rows="8" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" id="noteFormBtn" value="Save" class="btn btn-info ladda-button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateNotesModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateNotesForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Add New Notes</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Notes</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" id="notes-id" name="noteid">
                                        <textarea class="form-control" type="text" id="notes" name="notes" col="5" rows="8" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" id="noteFormBtn" value="Save" class="btn btn-info ladda-button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addReference" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="referenceForm" enctype="multipart/form-data">
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
                                        <input type="hidden" id="contact-id" value="<?=$contact_view_id?>" name="contactid">
                                        <input class="form-control" type="text" name="title" required />
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
                                        <textarea class="form-control" type="text" name="description" required /></textarea>
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
                                        <input class="form-control" type="date" name="added" required />
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
                                        <input class="form-control" type="date" name="ended" required />
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
                                        <input class="form-control" type="file" id="referenceFile" name="reference" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" class="btn btn-info">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateReference" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateReferenceForm" enctype="multipart/form-data">
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
                                        <input type="hidden" id="reference-id" name="reference_id">
                                        <input type="hidden" id="reference-old-file" name="old_file">
                                        <input class="form-control" id="reference-title" type="text" name="title" required />
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
                                        <textarea class="form-control" id="reference-description" type="text" name="description" required /></textarea>
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
                                        <input class="form-control" id="reference-added" type="date" name="added" required />
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
                                        <input class="form-control" id="reference-ended" type="date" name="ended" required />
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
                                        <div id="old-document-container">
                                            
                                        </div>
                                        <input class="form-control" type="file" id="updateReferenceFile" name="reference" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <button type="submit" class="btn btn-info">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="getCampaignMessage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content" style="border-radius: 6px!important;">
                    <div class="modal-body">
                        <div id="campaignMessageBody">
                            <div id="site_activities_loading_campaign">
                                <span id="spinner-text-campaign" style="display:18px" class="">Fetching data </span>
                                <img src="assets/global/img/loading.gif" alt="loading" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="getEmailMessage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content" style="border-radius: 6px!important;">
                    <div class="modal-body">
                        <div id="emailMessageBody">
                            <div id="site_activities_loading_email">
                                <span id="spinner-text-email" style="display:18px" class="">Fetching data </span>
                                <img src="assets/global/img/loading.gif" alt="loading" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="addCampaignModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content">
                     <form id="campaignForm">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Campaign Details</h4>
                        </div>
                        <div class="modal-body">
                            <input class="form-control" type="hidden" name="campaignid"/>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Campaign Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" name="campaign">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Recipient</label>
                                        <input class="form-control" name="recipient">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Subject</label>
                                        <input class="form-control" name="subject">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Body</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control campaign_body" name="body"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Auto Email</label>
                                        <select class="form-control mt-multiselect" name="status" style="width:100%">
                                            <option value="1">Activate</option>
                                            <option value="0">Suspend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="campaignDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content">
                     <form id="updateCampaignForm">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Campaign Details</h4>
                        </div>
                        <div class="modal-body">
                            <input class="form-control" type="hidden" name="campaignid" id="campaign-id"/>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Campaign Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" name="campaign" id="campaign-name">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Recipient</label>
                                        <input class="form-control" name="recipient" id="campaign-recipient">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Subject</label>
                                        <input class="form-control" name="subject" id="campaign-subject">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Body</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="body" id="campaign-message"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Auto Email</label>
                                        <select class="form-control mt-multiselect" id="campaign-status" name="status" style="width:100%">
                                            <option value="1">Activate</option>
                                            <option value="0">Suspend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once ('footer.php'); ?>
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script src="crm/customer_details.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $(".campaign_body").summernote({
                    placeholder: '',
                    height: 400
                });
            });

            var universalId = $('#universal_id').data('id');
                                  
            function initializeDataTable(selector) {
                if ($.fn.DataTable.isDataTable(selector)) {
                    $(selector).DataTable().destroy();
                }
                return $(selector).dataTable({
                    language: {
                        aria: {
                            sortAscending: ": activate to sort column ascending",
                            sortDescending: ": activate to sort column descending"
                        },
                        emptyTable: "No data available in table",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries found",
                        infoFiltered: "(filtered1 from _MAX_ total entries)",
                        lengthMenu: "_MENU_ entries",
                        search: "Search:",
                        zeroRecords: "No matching records found"
                    },
                    buttons: [
                        { extend: 'print', className: 'btn default' },
                        { extend: 'pdf', className: 'btn red' },
                        { extend: 'csv', className: 'btn green' }
                    ],
                    order: [
                        [0, 'DESC']
                    ],
                    lengthMenu: [
                        [5, 10, 15, 20],
                        [5, 10, 15, 20]
                    ],
                    pageLength: 5,
                    searching: true,
                    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                });
            }

            function formatDate(date) {
                var parts = date.split('/');
                var year = parts[0];
                var day = parts[1];
                var month = parts[2];
                return year + '/' + day + '/' + month;
            }

            function generateStatusHtml(response) {
                const statuses = [
                    { value: "Active", label: "Active" },
                    { value: "In-Active", label: "In-Active" },
                    { value: "Manual", label: "Manual" },
                    { value: "0", label: "Archive" }
                ];

                let selectedValue = response.flag == 0 ? "0" : response.account_status;

                let html = '<label class="control-label"><strong>Status</strong></label><br>';
                statuses.forEach((status, index) => {
                    html += `<input type="radio" class="form-check-input" name="account_status" value="${status.value}" ${status.value === selectedValue ? 'checked' : ''}>`;
                    html += `<label class="control-label"> &nbsp${status.label}</label> &nbsp;&nbsp;&nbsp;`;

                    if ((index + 1) % 2 === 0) {
                        html += '<br>';
                    }
                });
                return html;
            }

            function generateDirectoryHtml(selectedValue) {
                const directories = [
                    { value: "1", label: "Show" },
                    { value: "0", label: "Hide" }
                ];

                let html = '<label class="control-label"><strong>Directory</strong></label><br>';
                directories.forEach(directory => {
                    html += `<input type="radio" class="form-check-input" name="Account_Directory" value="${directory.value}" ${directory.value === selectedValue ? 'checked' : ''}>`;
                    html += `<label class="control-label">&nbsp ${directory.label}</label> &nbsp;&nbsp;&nbsp;`;
                });
                return html;
            }

            function get_notes() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_notes: true
                    },
                    success: function(response) {
                        var notes = JSON.parse(response);
                        var notesTable = $('#notesTable');

                        if (!notesTable.hasClass('dataTable')) {
                            initializeDataTable('#notesTable');
                        } else {
                            notesTable.DataTable().clear().draw(); // Clear existing data
                        }

                        notes.forEach(function(note) {
                            notesTable.DataTable().row.add([
                                note.date,
                                note.name,
                                note.note,
                                `<a data-toggle="modal" data-target="#updateNotesModal" class="btn btn-primary edit-notes-btn btn-sm" data-id="${note.id}">View</a>
                                <a class="btn btn-danger delete-btn btn-sm d-none" data-id="${note.id}">Delete</a>`
                            ]);
                        });

                        notesTable.DataTable().draw();
                    }
                });
            }

            function get_contact_emails () {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_contact_emails: true
                    },
                    success: function(response) {
                        var emails = JSON.parse(response);
                        var emailsTable = $('#emailsTable');

                        if (!emailsTable.hasClass('dataTable')) {
                            initializeDataTable('#emailsTable');
                        } else {
                            emailsTable.DataTable().clear().draw(); // Clear existing data
                        }

                        emails.forEach(function(email) {
                            emailsTable.DataTable().row.add([
                                email.date,
                                `<a data-toggle="modal" data-target="#getEmailMessage" class="viewEmailMessage" data-id="${email.mailid}">View Message</a>`,
                                email.subject,
                                email.name,
                                email.recipient
                            ]);
                        });

                        emailsTable.DataTable().draw();
                    }
                });
            }

            function get_contact_campaigns () {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_contact_campaigns: true
                    },
                    success: function(response) {
                        var campaigns = JSON.parse(response);
                        var campaignsTable = $('#campaignsTable');

                        if (!campaignsTable.hasClass('dataTable')) {
                            initializeDataTable('#campaignsTable');
                        } else {
                            campaignsTable.DataTable().clear().draw();
                        }
                        campaigns.forEach(function(campaign) {
                            let status = campaign.status == 1 ? "Suspended" : "Active";
                            var email_frequency = parseInt(campaign.frequency);
                            var frequency = '';

                            switch(email_frequency) {
                                case 1:
                                    frequency = 'Once Per Day';
                                    break;
                                case 2:
                                    frequency = 'Once Per Week';
                                    break;
                                case 3:
                                    frequency = 'On the 1st and 15th of the Month';
                                    break;
                                case 4:
                                    frequency = 'Once Per Month';
                                    break;
                                case 5:
                                    frequency = 'Once Per Year';
                                    break;
                                case 6:
                                    frequency = 'Once Per Two Months (Every Other Month)';
                                    break;
                                case 7:
                                    frequency = 'Once Per Three Months (Quarterly)';
                                    break;
                                case 8:
                                    frequency = 'Once Per Six Months (Bi-Annual)';
                                    break;
                                default:
                                    frequency = 'Unknown Frequency';
                            }
                            campaignsTable.DataTable().row.add([
                                campaign.date,
                                campaign.name,
                                campaign.campaign,
                                campaign.recipient,
                                campaign.subject,
                                `<a data-toggle="modal" data-target="#getCampaignMessage" class="viewCampaignMessage" data-id="${campaign.id}">View Message</a>`,
                                frequency,
                                status,
                                `<a data-toggle="modal" data-target="#campaignDetailsModal" class="btn btn-primary edit-campaign-btn btn-sm" data-id="${campaign.id}">View</a>`
                            ]);
                        });

                        campaignsTable.DataTable().draw();
                    }
                });
            }

            function get_references() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_contact_references: true
                    },
                    success: function(response) {
                        var references = JSON.parse(response);
                        var referenceTable = $('#referencesTable');
                        
                        // Initialize DataTable if not already initialized
                        if (!referenceTable.hasClass('dataTable')) {
                            initializeDataTable('#referencesTable');
                        } else {
                            referenceTable.DataTable().clear().draw(); // Clear existing data
                        }

                        references.forEach(function(reference) {
                            referenceTable.DataTable().row.add([
                                reference.inserted,
                                reference.name,
                                reference.title,
                                reference.description,
                                reference.added,
                                reference.end,
                                `<a href="Customer_Relationship_files_Folder/${reference.documents}" target="_blank" data-id="${reference.documents}">View Document</a>`,
                                `<a data-toggle="modal" data-target="#updateReference" class="btn btn-primary edit-reference-btn btn-sm" data-id="${reference.id}">View</a>
                                <a class="btn btn-danger delete-btn btn-sm d-none" data-id="${reference.id}">Delete</a>`
                            ]);
                        });

                        referenceTable.DataTable().draw(); // Draw the updated table
                    }
                });
            }
            
            function get_fse() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_contact_fse: true
                    },
                    success: function(response) {
                        var fses = JSON.parse(response);
                        var fseTable = $('#fsesTable');
                        
                        if (!fseTable.hasClass('dataTable')) {
                            initializeDataTable('#fsesTable');
                        } else {
                            fseTable.DataTable().clear().draw();
                        }

                        fses.forEach(function(fse) {
                            fseTable.DataTable().row.add([
                                fse.id,
                                fse.title,
                                fse.description,
                                `<a href="Customer_Relationship_files_Folder/${fse.document}" target="_blank" data-id="${fse.document}">View</a>`,
                                `<a href="${fse.link}" target="_blank" data-id="${fse.link}">Visit Link</a>`,
                                fse.event,
                                fse.name
                            ]);
                        });

                        fseTable.DataTable().draw();
                    }
                });
            }

            function get_projects() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        get_projects: true
                    },
                    success: function(response) {
                        var projects = JSON.parse(response);
                        var projectTable = $('#projectsTable');
                        
                        if (!projectTable.hasClass('dataTable')) {
                            initializeDataTable('#projectsTable');
                        } else {
                            projectTable.DataTable().clear().draw();
                        }

                        projects.forEach(function(project) {
                            projectTable.DataTable().row.add([
                                project.id,
                                project.project,
                                project.description,
                                project.start,
                                project.due,
                                `<a href="interlink/mypro_task.php?view_id=${project.id}" target="_blank" class="btn btn-sm btn-primary" data-id="${project.document}">View</a>`,
                            ]);
                        });

                        projectTable.DataTable().draw();
                    }
                });
            }

            function get_contacts() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_contacts: true
                    },
                    success: function(response) {
                        var contacts = JSON.parse(response);
                        var contactsTable = $('#contactsTable');
                        
                        // Initialize DataTable if not already initialized
                        if (!contactsTable.hasClass('dataTable')) {
                            initializeDataTable('#contactsTable');
                        } else {
                            contactsTable.DataTable().clear().draw(); // Clear existing data
                        }

                        contacts.forEach(function(contact) {
                            contactsTable.DataTable().row.add([
                                contact.id,
                                contact.name,
                                contact.title,
                                contact.reporting_to,
                                contact.address,
                                contact.email,
                                contact.phone,
                                contact.fax,
                                `<a data-toggle="modal" data-target="#updateContactModal" class="btn btn-primary edit-contact-btn btn-sm" data-id="${contact.id}">View</a>
                                <a class="btn btn-danger d-none delete-btn" data-id="${contact.id}">Delete</a>`
                            ]);
                        });

                        contactsTable.DataTable().draw(); // Draw the updated table
                    }
                });
            }

            function get_tasks() {
                $.post({
                    url: 'crm/customer_details.php',
                    data: {
                        id: universalId,
                        get_tasks: true
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var pendings = data.pendings;
                        var completed = data.completed;

                        // Initialize or clear existing DataTables for pending and completed tasks
                        var pendingTable = initializeDataTable('#pendingTaskTable').DataTable();
                        var completedTable = initializeDataTable('#completedTaskTable').DataTable();
                        
                        // Clear existing data
                        pendingTable.clear();
                        completedTable.clear();

                        // Add new pending tasks
                        pendings.forEach(function(pending) {
                            let status = pending.status == 1 ? "Pending" : "In-Progress";
                            var pendingRow = [
                                pending.taskid,
                                pending.task_name,
                                pending.originator,
                                pending.assigned,
                                status,
                                pending.due_date,
                                `<a data-toggle="modal" data-target="#modalEditTaskForm" class="btn btn-primary edit-btn btn-sm" data-id="${pending.taskid}">View</a>
                                <a class="btn btn-danger delete-btn btn-sm d-none" data-id="${pending.taskid}">Delete</a>`
                            ];
                            pendingTable.row.add(pendingRow);
                        });

                        // Add new completed tasks
                        completed.forEach(function(complete) {
                            var completeRow = [
                                complete.taskid,
                                complete.task_name,
                                complete.originator,
                                complete.assigned,
                                "Completed",
                                complete.due_date,
                                `<a data-toggle="modal" data-target="#modalEditContactForm" class="btn btn-primary edit-btn btn-sm" data-id="${complete.taskid}">View</a>
                                <a class="btn btn-danger delete-btn btn-sm d-none" data-id="${complete.taskid}">Delete</a>`
                            ];
                            completedTable.row.add(completeRow);
                        });

                        // Draw the updated tables
                        pendingTable.draw();
                        completedTable.draw();
                    }
                });
            }

            $(document).on('click', '.viewCampaignMessage', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    url: 'crm/customer_details.php',
                    type: 'POST',
                    data: {
                        id: id,
                        get_campaign_message: true
                    },
                    success: function(response) {
                        $('#site_activities_loading_campaign, #spinner-text-campaign').addClass('d-none');
                        $('#campaignMessageBody').html(response); // Append the response to the modal body
                    }
                });
            });

            $(document).on('click', '.viewEmailMessage', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    url: 'crm/customer_details',
                    type: 'POST',
                    data: {
                        id: id,
                        get_email_message: true
                    },
                    success: function(response) {
                        console.log(response);
                        $('#site_activities_loading_email, #spinner-text-email').addClass('d-none');
                        $('#emailMessageBody').html(response);
                    }
                });
            });

            function get_contact_details() {
                $.ajax({
                    url: 'crm/customer_details.php',
                    type: 'POST',
                    data: { id:universalId, get_contact_details: true },
                    success: function(response) {
                        var response = JSON.parse(response)
                        $('input[name="id"]').val(response.crm_id);
                        $('input[name="account_rep"]').val(response.account_rep);
                        $('input[name="Account_Source"]').val(response.Account_Source);
                        $('input[name="account_name"]').val(response.account_name);
                        $('input[name="parent_account"]').val(response.parent_account);
                        $('input[name="account_address"]').val(response.account_address);
                        $('input[name="account_email"]').val(response.account_email);
                        $('input[name="account_phone"]').val(response.account_phone);
                        $('input[name="account_fax"]').val(response.account_fax);
                        $('input[name="account_country"]').val(response.account_country).prop('checked', true);
                        $('input[name="account_website"]').val(response.account_website);
                        $('input[name="account_facebook"]').val(response.account_facebook);
                        $('input[name="account_twitter"]').val(response.account_twitter);
                        $('input[name="account_linkedin"]').val(response.account_linkedin);
                        $('input[name="account_interlink"]').val(response.account_interlink);
                        $('input[name="account_status"][value="' + response.status + '"]').prop('checked', true);
                        $('input[name="Account_Directory"][value="' + response.directory + '"]').prop('checked', true);
                        $('#status-container').html(generateStatusHtml(response));
                        $('#directory-container').html(generateDirectoryHtml(response.directory));
                    }
                })
            }
        
            document.addEventListener('DOMContentLoaded', function() {
                let observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1
                };

                let targets = {
                    'contact_details': get_contact_details,
                    'contact_contacts': get_contacts,
                    'contact_tasks': get_tasks,
                    'contact_notes': get_notes,
                    'contact_reference': get_references,
                    'contact_email': get_contact_emails,
                    'contact_campaign': get_contact_campaigns,
                    'contact_fse': get_fse,
                    'contact_project': get_projects,
                    
                };

                let observer = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            let targetClass = entry.target.classList[1];
                            if (targets[targetClass]) {
                                targets[targetClass]();
                                observer.unobserve(entry.target);
                            }
                        }
                    });
                }, observerOptions);
                let lazyLoadElements = document.querySelectorAll('.col-md-12');
                lazyLoadElements.forEach(element => {
                    observer.observe(element);
                });
            });
        </script>
    </body>
</html>