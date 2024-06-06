<?php
    include_once __DIR__ . '/../../header.php';
    include_once __DIR__ .'/utils.php';
?>
<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
<link href="assets/apps/css/todo-2.min.css" rel="stylesheet" type="text/css" />
<style>
textarea {
    resize: vertical !important;
    max-height: 14rem;
}

.table-align-top th {
    vertical-align: top !important;
}

.fsvp-table * {
    font-size: .97em !important;
}

.fsvp-tabs li {
    position: relative;
}

.fsvp-tabs li .badge {
    position: absolute;
    display: inline-block;
    min-width: auto !important;
    width: 8px;
    height: 8px;
    padding: 0;
    inset: 5px 5px auto auto;
}

.checkFileUpload {
    display: flex;
    width: 100%;
    gap: 2rem;
}

.checkFileUpload .input-group {
    flex: 1 0 auto;
}

.checkFileUpload input.form-control {
    height: inherit;
}

.mt-radio:not(.not-this) {
    margin-bottom: 0;
}

hr {
    margin: 0.5rem 0 !important;
}

.filesArrayDisplay {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    gap: 15px;
    padding: 10px 0;
}

.fileArrayItem {
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.fileArrayName {
    flex-grow: 1;
    display: inline-flex;
    gap: .5rem;
}

.fileArrayName a {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 220px;
}

.removeFileButton {
    border: none !important;
}

.mls-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    margin-top: 1rem;
}

.icon-margin-right {
    margin-right: .5rem;
}

.d-flex.center {
    align-items: center;
    justify-content: center;
}

label:has(.help-icon-group) {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.help-icon-group {
    display: inline-block;
}

.tooltip:has(.form-hint) {
    opacity: 1;
}

.tooltip-inner:has(.form-hint) {
    padding: 0 !important;
}

.form-hint {
    padding: .75rem;
    background-color: #fafafa;
    color: #000;
    text-align: left;
    border: 1px solid grey;
}

.form-hint mark {
    display: block;
    margin: .5rem;
    padding: .45rem;
}
</style>
<link rel="stylesheet" href="modules/Init.style.css">

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-folder font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">
                        FSVP Module
                    </span>
                </div>
                <ul class="nav nav-tabs fsvp-tabs">
                    <li <?= isset($_GET['supplier_list']) || !count($_GET) ? 'class="active"' : '' ?>><a href="?supplier_list">Supplier List</a></li>
                    <li <?= isset($_GET['ingredient_product_register']) ? 'class="active"' : '' ?>><a href="?ingredient_product_register">Ingredient Product Register</a></li>
                    <li <?= isset($_GET['fsvpqi_register']) ? 'class="active"' : '' ?>><a href="?fsvpqi_register">FSVPQI Register</a></li>
                    <li <?= isset($_GET['fsvp_team']) ? 'class="active"' : '' ?>>
                        <span class="badge badge-danger"> </span>
                        <a href="?fsvp_team">FSVP Team</a>
                    </li>
                    <li <?= isset($_GET['importer_list']) ? 'class="active"' : '' ?>><a href="?importer_list">Importer List</a></li>
                </ul>
            </div>
            <div class="portlet-body">
                <?php 
                if(isset($_GET['supplier_list']) || !count($_GET)) {
                    include_once __DIR__ . '/pages/supplierList.php';
                } else if(isset($_GET['ingredient_product_register'])) {
                    include_once __DIR__ . '/pages/ingredientProductRegister.php';
                } else if(isset($_GET['fsvpqi_register'])) {
                    include_once __DIR__ . '/pages/fsvpqiRegister.php';
                } else if(isset($_GET['fsvp_team'])) {
                    include_once __DIR__ . '/pages/fsvpTeam.php';
                } else if(isset($_GET['importer_list'])) {
                    include_once __DIR__ . '/pages/importerList.php';
                }
            ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../footer.php'; ?>
<script src="modules/js/init.js"></script>
<script src="assets/jSignature/jSignature.min.js"></script>
<script src="assets/esign.js"></script>
<script>
var baseUrl = 'fsvp?api&';
Init.baseUrl = 'fsvp?api&';
</script>
<script>
</script>