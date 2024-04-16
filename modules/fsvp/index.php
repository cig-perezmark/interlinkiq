<?php
    include_once __DIR__ . '/../../header.php';


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
</style>

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

<script>
$('#tableSupplierList').DataTable();
</script>