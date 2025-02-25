<style>
.col-form-label {
    color: #000;
}
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.css" />
<link href="<?= base_url() ?>css/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>css/fancybox/jquery.fancybox.min.js"></script>
<input type="hidden" id="baseUrl" value="<?= base_url() ?>">
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <div class="card-box mb-30">
            <div class="pd-20" style="background-color:#4682b4;border-radius:10px;position:relative">
                <h4 class="h4" style="color:#ffff">Expense Form <?= isset($editRecord) ? ' - Edit Record' : '' ?></h4>
            </div>
        </div>
        <div class="clearfix">
            <form class="pd-20 card-box" id="expenseForm">
                <?php 
                    function recordExists($record, $value) {
                        foreach($record as $r) {
                            if($r['id'] == $value) {
                                return true;
                            }
                        }
                        return false;
                    }
                    if(isset($editRecord)): 
                ?>
                <input type="hidden" name="editRecordId" value="<?= $editRecord['id'] ?>">
                <input type="hidden" id="editPayeeId" value="<?= $editRecord['billing_entity'] ?>" <?= isset($isDeletedPayee) ? 'data-deleted="1"' : '' ?> <?= !recordExists($payees, $editRecord['billing_entity']) ? 'data-tempdata="true"' : '' ?>>
                <input type="hidden" id="editCategoryId" value="<?= $editRecord['category'] ?>" <?= isset($isDeletedCategory) ? 'data-deleted="1"' : '' ?> <?= !recordExists($categories, $editRecord['category']) ? 'data-tempdata="true"' : '' ?>>
                <input type="hidden" id="editMOPId" value="<?= $editRecord['mop'] ?>" <?= isset($isDeletedMOP) ? 'data-deleted="1"' : '' ?> <?= !recordExists($paymentMethods, $editRecord['mop']) ? 'data-tempdata="true"' : '' ?>>
                <?php endif; ?>
                <div class="row">
                    <div class="col-auto ml-auto">
                        <a href="<?= base_url('expenses/settings') ?>" class="btn pb-2 btn-link p-0 text-black-50 d-flex align-items-center text-decoration-none">
                            <i class="icon-copy dw dw-settings mr-2"></i> Settings
                        </a>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label for="payee" class="col-md-2 col-form-label">Payee</label>
                    <div class="col-md-4">
                        <select name="payee" data-error-to="#payeeError" id="payee" class="custom-select2 form-control" style="width: 100%;">
                            <option value='' disabled selected>Select payee</option>
                            <option value="others">Others...</option>
                            <?php foreach($payees as $p) echo '<option value="'.$p['id'].'">'.$p['name'].'</option>'; ?>
                        </select>
                        <?php if(isset($isDeletedPayee)): ?> 
                        <small class="text-muted form-text">Payee assigned has been removed.</small>
                        <?php endif; ?>
                        <small data-error-message id="payeeError" style="display: none;" class="form-text text-danger font-weight-bold">Please select a payee!</small>
                    </div>
                    <div class="col-md-4 mt-4 mt-md-0">
                        <input type="text" class="form-control" data-for="#saveNewPayeeCheck" name="new_payee" placeholder="Other payee info (if applicable)">
                        <div class="form-text text-dark" id="saveNewPayeeCheck" style="display: none;">
                            <label class="small d-flex align-items-center m-0">
                                <input type="checkbox" name="save_new_payee" value="1" class="mr-2">
                                Save new payee info
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label for="categorySelect" class="col-md-2 col-form-label">Category</label>
                    <div class="col-md-4">
                        <select name="category" data-error-to="#catError" id="categorySelect" class="custom-select2 form-control" style="width: 100%;">
                            <option value="" disabled selected>Select category</option>
                            <?php foreach($categories as $cat) echo '<option value="'.$cat['id'].'">'.$cat['category_name'].'</option>'; ?>
                            <option value="others">Others...</option>
                        </select>
                        <?php if(isset($isDeletedCategory)): ?> 
                        <small class="text-muted form-text">Category assigned has been removed.</small>
                        <?php endif; ?>
                        <small data-error-message id="catError" style="display: none;" class="form-text text-danger font-weight-bold">Please select a category!</small>
                    </div>
                    <div class="col-md-4 mt-4 mt-md-0">
                        <input type="text" class="form-control" data-for="#saveNewCatCheck" name="new_category" placeholder="Other/new category (if applicable)">
                        <div class="form-text text-dark" id="saveNewCatCheck" style="display: none;">
                            <label class="small d-flex align-items-center m-0">
                                <input type="checkbox" name="save_new_category" value="1" class="mr-2">
                                Add as new category
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="col-md-2 col-form-label" for="amount">Amount</label>
                    <div class="col-md-4">
                        <input type="number" id="amount" name="amount" min="0" class="form-control" placeholder="Enter amount ($)" required value="<?= (isset($editRecord) ? $editRecord['amount'] : '') ?>">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="col-md-2 col-form-label" for="paymentDate">Date of payment</label>
                    <div class="col-md-4">
                        <input type="date" id="paymentDate" class="form-control" name="date" required value="<?= (isset($editRecord) ? $editRecord['date_of_payment'] : '') ?>">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="col-md-2 col-form-label" for="paymentModeSelect">Mode of payment</label>
                    <div class="col-md-4">
                        <select name="mop" data-error-to="#mopError" id="paymentModeSelect" class="custom-select2 form-control">
                            <option value="" disabled selected>Select mode of payment</option>
                            <?php foreach($paymentMethods as $pm) echo '<option value="'.$pm['id'].'">'.$pm['name'].'</option>'; ?>
                            <option value="others">Others...</option>
                        </select>
                        <?php if(isset($isDeletedMOP)): ?> 
                        <small class="text-muted form-text">Mode of payment selected has been removed from the list.</small>
                        <?php endif; ?>
                        <small data-error-message id="mopError" style="display: none;" class="form-text text-danger font-weight-bold">Please select the mode of payment!</small>
                    </div>
                    <div class="col-md-4 mt-4 mt-md-0" id="otherPaymentModeBox" style="display: none;">
                        <input type="text" class="form-control" name="new_mop" data-for="#saveNewMOPCheck" placeholder="Specify (if applicable)">
                        <div class="form-text text-dark" style="display:none;" id="saveNewMOPCheck">
                            <label class="small d-flex align-items-center m-0">
                                <input type="checkbox" name="save_new_mop" value="1" class="mr-2">
                                Save as new option
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="col-md-2 col-form-label" for="description">Description</label>
                    <div class="col-md-4">
                        <textarea name="description" id="description" class="form-control" style="height: 5rem;" placeholder="Enter description"><?= (isset($editRecord) ? $editRecord['description'] : '') ?></textarea>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="col-md-2 col-form-label" for="invoice">Document (optional)</label>
                    <div class="col-md-4">
                        <input type="file" class="form-control form-control-file" id="invoice" multiple name="documents[]" accept=".pdf, .jpeg, .jpg, .png">
                        <?php if(!isset($editRecord)): ?>
                        <small class="text-muted form-text">Upload receipts, invoices, or any other supporting document(s) for this expense.</small>
                        <?php else: ?>
                        <small class="text-muted form-text">**New upload(s) will replace the old documents(s).</small>
                        <?php 
                            if($editRecord['documents']) {
                                $uploadPath = 'uploads/opex_docs/';
                                $docs = json_decode($editRecord['documents']);
                                foreach($docs as $k => $d) {
                                    echo '<a href="'.(base_url() . $uploadPath . $d). '" style="border:none !important;'.( $k > 0 ? 'display:none;' : '').'" data-fancybox="docs" class="btn btn-link p-0" rel="docs" >View old document(s) here.</a>';
                                }
                            }
                            endif; 
                        ?>
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 pt-3">
                        <?php if(!isset($editRecord)): ?>
                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        <div class="mt-2">Running total amount of expenses: <strong id="runningTotalDisplay">$0.00</strong></div>
                        <?php else: ?>
                        <button type="submit" class="btn btn-block btn-success" id="saveChangesBtn" disabled>Save changes</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <div class="card-box mb-30" style="margin-top:50px; <?= isset($editRecord) ? 'display: none;' : '' ?>">
                <div class="pd-20">
                    <h4 class="text-blue h4">Tracker</h4>
                </div>
                <div class="pb-20">
                    <div class="mb-3 d-flex align-items-center justify-content-end">
                        <span>Download as:</span>
                        <div id="customCon"></div>
                    </div>
                    <table id="data-table-form" class="table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Method of Payment</th>
                                <th>Payee</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.all.js"></script>
<script>
jQuery(document).ready(function() {
    let El = {
            /* Elements */
            totalDisplay: $('#runningTotalDisplay'),
            categorySelect: $('#categorySelect'),
            categoryInput: $('[name="new_category"]'),
            payeeSelect: $('#payee'),
            payeeInput: $('[name=new_payee]'),
            mopSelect: $('#paymentModeSelect'),
            mopInput: $('[name=new_mop]'),
            mopInputBox: $('#otherPaymentModeBox'),
            expenseForm: $('#expenseForm'),
            autoSaveModal: $('#autosaveModal'),
            table: $('#data-table-form'),
            saveNP: $('input[type=checkbox][name="save_new_payee"]'),
            saveNMOP: $('input[type=checkbox][name="save_new_mop"]'),
            saveNC: $('input[type=checkbox][name="save_new_category"]'),
        },
        runningTotal = 0,
        /* base url */
        baseUrl = $('#baseUrl').val(),
        /* datatable */
        dtTable = null,
        /**
         * registered events
         * heirarchy:
         * Events
         *   => event name
         *     => element variable (from El object)
         *       => function/callback     
         */
        Events = {
            change: {
                payeeSelect: function(e) {
                    /* control payee selection */
                    e.target.value !== '' && e.target.removeError();

                    if (e.target.value === 'others') {
                        setTimeout(() => El.payeeInput.focus(), 100);
                        El.payeeInput.attr('required', true);
                    } else {
                        El.payeeInput.val('').removeAttr('required').trigger('input');
                    }
                },
                categorySelect: function(e) {
                    /* control category selection */
                    if (e.target.value === 'others') {
                        setTimeout(() => El.categoryInput.focus(), 100);
                        El.categoryInput.attr('required', true);
                    } else {
                        El.categoryInput.val('').removeAttr('required').trigger('input');
                    }
                    e.target.value !== '' && e.target.removeError();
                },
                mopSelect: function(e) {
                    /* control mode of payment selection */
                    if (e.target.value === 'others') {
                        El.mopInputBox.fadeIn('linear', function() {
                            El.mopInput.focus().attr('required', true)
                        });
                    } else {
                        El.mopInputBox.fadeOut('linear', function() {
                            El.mopInput.val('').removeAttr('required').trigger('input');;
                        });
                    }
                    e.target.value !== '' && e.target.removeError();
                }
            },
            input: {
                payeeInput: function(e) {
                    /* trigger updates for new payee input */
                    if (e.target.value == '') {
                        $(e.target.getAttribute('data-for')).fadeOut();
                        $(e.target.getAttribute('data-for')).find('input[type=checkbox]').prop('checked', false);
                    } else {
                        El.payeeSelect.val('others').trigger('change');
                        $(El.payeeSelect.attr('data-error-to')).fadeOut();
                        $(e.target.getAttribute('data-for')).fadeIn();
                    }
                },
                categoryInput: function(e) {
                    /* trigger updates for other category input */
                    if (e.target.value == '') {
                        $(e.target.getAttribute('data-for')).fadeOut();
                        $(e.target.getAttribute('data-for')).find('input[type=checkbox]').prop('checked', false);
                    } else {
                        El.categorySelect.val('others').trigger('change');
                        $(El.categorySelect.attr('data-error-to')).fadeOut();
                        $(e.target.getAttribute('data-for')).fadeIn();
                    }
                },
                mopInput: function(e) {
                    /* trigger updates for other mop input */
                    if (e.target.value == '') {
                        $(e.target.getAttribute('data-for')).fadeOut();
                        $(e.target.getAttribute('data-for')).find('input[type=checkbox]').prop('checked', false);
                    } else {
                        El.mopSelect.val('others').trigger('change');
                        $(El.mopSelect.attr('data-error-to')).fadeOut();
                        $(e.target.getAttribute('data-for')).fadeIn();
                    }
                }
            },
            submit: {
                expenseForm: function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const isUpdateAction = form.editRecordId?.value || false;
                    const formData = new FormData(form);
                    const dropdowns = {
                        nc: El.saveNC.prop('checked'),
                        np: El.saveNP.prop('checked'),
                        nmop: El.saveNMOP.prop('checked')
                    }
                    let isError = false;

                    if (form.payee.value == '') {
                        form.payee.triggerError();
                        isError = true;
                    }

                    if (form.category.value == '') {
                        form.category.triggerError();
                        isError = true;
                    }

                    if (form.mop.value == '') {
                        form.mop.triggerError();
                        isError = true;
                    }

                    if (isError) return;
                    
                    if(isUpdateAction) {
                        // updating record
                        swal({
                            title: 'Save this update?',
                            text: "Please confirm your changes before saving it.",
                            type: 'warning',
                            showCancelButton: true,
                            cancelButtonText: 'No',
                            confirmButtonText: 'Yes, proceed!',
                            confirmButtonClass: 'btn btn-success margin-5',
                            cancelButtonClass: 'btn btn-secondary margin-5',
                            buttonsStyling: false
                        }).then(function(r) {
                            if(r.value == true) {
                               save();
                            }
                        });
                    } else {
                        // for adding new record
                        save();
                    }
                    
                    // one save function
                    function save() {
                        axios.post('expenses/api/add-expense', formData).then(r => {
                            const data = r.data.new_data || {};
                            
                            if(!isUpdateAction) {
                                // display data
                                Fn.populateNewDataToTable(data);
        
                                runningTotal += Number(form.amount.value || 0);
                                Fn.updateTotalDisplay(runningTotal);
                            }
    
                            swal({
                                title: 'Success',
                                text: r.data.message || 'Record has been saved!',
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                            }).then(() => {
                                if(!isUpdateAction) {
                                    // reset form
                                    El.payeeSelect.val('').trigger('change');
                                    El.categorySelect.val('').trigger('change');
                                    El.mopSelect.val('').trigger('change');
                                    form.reset();
                                } else if(data.documents?.length || isUpdateAction) {
                                    // if update action has files uploaded,
                                    // reload the page because I felt too lazy to update the DOM again
                                    // it's okay :)
                                    location.reload();
                                }
                               
                                // update dropdowns
                                dropdowns.np && Fn.addNewPayeeDropdown({
                                    name: data.billing_entity,
                                    id: data.billing_entity_id
                                });
    
                                dropdowns.nmop && Fn.addNewMOPDropdown({
                                    name: data.mop,
                                    id: data.mop_id,
                                });
    
                                dropdowns.nc && Fn.addNewCategoryDropdown({
                                    name: data.category,
                                    id: data.category_id,
                                });
                            });
                        }).catch(err => {
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        });
                    }
                }
            }
        },
        Fn = {
            updateTotalDisplay(newTotal) {
                El.totalDisplay.text('$' + newTotal.toFixed(2));
            },
            populateNewDataToTable: function(data) {
                if (dtTable === null) return;

                dtTable.rows.add([
                    [
                        data.date_of_payment,
                        data.mop,
                        data.billing_entity,
                        data.description,
                        data.category,
                        '$' + Number(data.amount).toFixed(2),
                        `<div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item collapse" href="#" update-btn data-id="${data.id}"><i class="dw dw-edit2"></i> Edit</a>
                                <a class="dropdown-item" href="#" delete-btn data-id="${data.id}" data-amount="${data.amount}"><i class="dw dw-delete-3"></i> Delete</a>
                            </div>
                        </div>`
                    ]
                ]).draw();
            },
            initTable: function() {
                dtTable = El.table.DataTable({
                    scrollCollapse: true,
                    autoWidth: false,
                    responsive: true,
                    columnDefs: [{
                        targets: "datatable-nosort",
                        orderable: false,
                    }],
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    "language": {
                        "info": "_START_-_END_ of _TOTAL_ entries",
                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<i class="ion-chevron-right"></i>',
                            previous: '<i class="ion-chevron-left"></i>'
                        }
                    },
                    rowCallback: function(row, data) {
                        // edit
                        $('[update-btn]', row).on('click', function() {
                            // rowToUpdate = row;
                            // Fn.openUpdateModal(data[0])
                        });

                        // delete
                        $('[delete-btn]', row).on('click', function() {
                            // Fn.deleteRecord(this.getAttribute('data-table'), data[0], row);
                            const id = this.dataset.id
                            const amount = Number(this.dataset.amount || 0);
                            Fn.deleteRecord(id, row, amount);
                        });
                    },
                    dom: 'lBfrtip',
                    buttons: [{
                        extend: 'csv',
                        className: 'btn btn-sm btn-secondary',
                        text: 'CSV',
                        attr: {
                            'data-bs-toggle': "tooltip",
                            'data-bs-placement': "top",
                            'title': "Convert to CSV  file"
                        },
                        exportOptions: {
                            columns: ':visible:not(:eq(6))'
                        }
                    }, {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-secondary',
                        text: 'PDF',
                        attr: {
                            'data-bs-toggle': "tooltip",
                            'data-bs-placement': "top",
                            'title': "Download as PDF"
                        },
                        exportOptions: {
                            columns: ':visible:not(:eq(6))'
                        }
                    }, ],
                });

                dtTable.buttons().containers().appendTo('#customCon');
            },
            addNewPayeeDropdown: function(data) {
                El.payeeSelect
                    .append(new Option(data.name, data.id, false, false))
                    .trigger('change');
            },
            addNewCategoryDropdown: function(data) {
                El.categorySelect.find('option[value=others]').remove().trigger('change');
                El.categorySelect
                    .append(new Option(data.name, data.id, false, false))
                    .append(new Option('Others...', 'others', false, false))
                    .trigger('change');
            },
            addNewMOPDropdown: function(data) {
                El.mopSelect.find('option[value=others]').remove().trigger('change');
                El.mopSelect
                    .append(new Option(data.name, data.id, false, false))
                    .append(new Option('Others...', 'others', false, false))
                    .trigger('change');
            },
            deleteRecord: function(id, row, amountToDeduct) {
                swal({
                    title: 'Confirm delete',
                    text: "Are you sure you want to delete this record?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-secondary margin-5',
                    buttonsStyling: false
                }).then(function(confirm) {
                    if (confirm.value === true) {
                        const formData = new FormData();
                        formData.append('id', id);
                        axios.post('expenses/api/delete-record', formData).then((r) => {
                            runningTotal -= amountToDeduct;
                            Fn.updateTotalDisplay(runningTotal);
                            dtTable.row(row).remove().draw();
                            swal(r.data.message || 'Deleted!', '', 'success')
                        }).catch(err => {
                            swal({
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                type: 'error',
                                confirmButtonClass: 'btn btn-success',
                            });
                        })
                    }
                })
            }
        };

    HTMLSelectElement.prototype.triggerError = function() {
        const errorId = this.getAttribute('data-error-to');
        const errorEl = document.querySelector(errorId) || null;
        if (errorEl) {
            $(errorEl).fadeIn();
        }
    }

    HTMLSelectElement.prototype.removeError = function() {
        const errorId = this.getAttribute('data-error-to');
        const errorEl = document.querySelector(errorId) || null;
        if (errorEl) {
            $(errorEl).fadeOut();
        }
    }

    // bind events
    Object.keys(Events).forEach((eventName) => {
        Object.entries(Events[eventName]).forEach(([e, fn]) => {
            El[e].on(eventName, (e) => fn(e));
        });
    });

    $('[data-error-message]').css('display', 'none');
    Fn.initTable();
    
    // init editing (intended for update functionality)
    let editMOPId = $('#editMOPId').get(0);
    let editCategoryId = $('#editCategoryId').get(0);
    let editPayeeId = $('#editPayeeId').get(0);
    
    // triggering "others" choices 
    if(editPayeeId && !editPayeeId.dataset.deleted) {
        if(editPayeeId.dataset.tempdata) {
            El.payeeInput.val(editPayeeId.value).trigger('input');
        } else {
            El.payeeSelect.find(`option[value=${editPayeeId.value}]`) && El.payeeSelect.val(editPayeeId.value).trigger('change');
        }
    }
    
    if(editCategoryId && !editCategoryId.dataset.deleted) {
        if(editCategoryId.dataset.tempdata) {
            El.categoryInput.val(editCategoryId.value).trigger('input');
        } else {
            El.categorySelect.find(`option[value=${editCategoryId.value}]`) && El.categorySelect.val(editCategoryId.value).trigger('change');
        }
    }
    
    if(editMOPId && !editMOPId.dataset.deleted) {
        if(editMOPId.dataset.tempdata) {
            El.mopSelect.val('others').trigger('change');
            El.mopInput.val(editMOPId.value).trigger('input');
        } else {
            El.mopSelect.find(`option[value=${editMOPId.value}]`) && El.mopSelect.val(editMOPId.value).trigger('change');
        }
    }
    
    // enabling the save button
    $('#saveChangesBtn').prop('disabled', false);
});
</script>
