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

.mt-radio {
    margin-bottom: 0;
}

hr {
    margin: 0.5rem 0 !important;
}

.filesArrayDisplay {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px 0;
}

.fileArrayItem {
    display: flex;
    align-items: center;
    /* justify-content: space-between; */
    gap: 1rem;
}

.removeFileButton {
    border: none !important;
    /* padding: 0; */
}

.mls-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    margin-top: 1rem;
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
<script src="modules/js/utils.js"></script>
<script>
var baseUrl = 'fsvp?api&';
</script>
<!-- <script src="modules/fsvp/js/functions.js"></script> -->

<script>
// fetchSuppliers();
$('#tableSupplierList').DataTable();
</script>

<script>
initMultiSelect($('.supplierdd'), {
    onChange: function(option, checked, select) {
        // alert('Changed option ' + $(option).val() + '.');

        $.ajax({
            url: baseUrl + "getProductsBySupplier=" + $(option).val(),
            type: "GET",
            contentType: false,
            processData: false,
            success: function({
                materials
            }) {
                if (materials && Array.isArray(materials)) {
                    const mList = $('#materialListSelection');
                    mList.html('');

                    if (!materials.length) {
                        $('#materialListHelpBlock').text('No materials found.');
                        return;
                    } else {
                        $('#materialListHelpBlock').text('Tick on the checkboxes to select.');
                    }

                    materials.forEach((m) => {
                        const substr = m.description.substring(0, 32);

                        mList.append(`
                            <label class="mt-checkbox mt-checkbox-outline "> ${m.name}
                                <p title="${m.description}" class="small text-muted" style="padding: 0; margin:0;">${(m.description.length > 32 ? substr + '...' : m.description) || ''}</p>
                                <input type="checkbox" value="${m.id}" name="food_imported[]"">
                                <span></span>
                            </label>
                        `);
                    })
                }
            },
            error: function() {
                bootstrapGrowl('Error!');
            },
            complete: function() {
                // l.stop();
            }
        });
    }
})
</script>