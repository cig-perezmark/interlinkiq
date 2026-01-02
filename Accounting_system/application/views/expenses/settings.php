<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.css" />

<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <div class="clearfix">
            <h4 class="h4 text-blue mb-4">Expense Form - Settings</h4>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
				<i class="icon-copy dw dw-warning-1 h4 m-0 text-danger"></i>
				<span class="mx-2">
    				<strong>Caution:</strong>  Deleting items in the settings will impact all expense records directly associated with them. Please proceed with caution.
				</span>
				
			</div>
            <div class="pd-20 card-box mb-4" style="display: none;">
                <p class="pb-4">Choose the next action after submitting the <span class="weight-600">Expense Form</span> with:</p>
                <div class="row form-group mb-4">
                    <label class="col-md-2 col-form-label">
                        <span class="weight-600">Other payee info</span> <br>
                        <small class="form-text text-muted" data-description-target="other_payee_info"></small>
                    </label>
                    <div class="col-md-auto">
                        <select name="other_payee_info" id="" class="custom-select custom-select-sm settingsSelect">
                            <option value="always_ask" selected>Always ask</option>
                            <option value="save_automatically">Save automatically</option>
                            <option value="do_nothing">Do nothing</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 col-form-label">
                        <span class="weight-600">Other/new category</span> <br>
                        <small class="form-text text-muted" data-description-target="other_category"></small>
                    </label>
                    <div class="col-md-auto">
                        <select name="other_category" id="" class="custom-select custom-select-sm settingsSelect">
                            <option value="always_ask" selected>Always ask</option>
                            <option value="save_automatically">Save automatically</option>
                            <option value="do_nothing">Do nothing</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            <div class="pd-20 card-box">
                <div class="tab">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#payeeTab" role="tab" aria-selected="true">Payees / Billing entities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#categoryTab" role="tab" aria-selected="false">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#mopTab" role="tab" aria-selected="false">Modes of payment</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="payeeTab" role="tabpanel">
                            <div class="pd-20">
                                <div class="mb-4">
                                    <button type="button" class="btn btn-primary" id="addPBtn">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-copy dw dw-add mr-2"></i>
                                            <span>Add new payee</span>
                                        </div>
                                    </button>
                                </div>
                                <table class=" table stripe hover nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 55%;">Name</th>
                                            <th style="width: 20%;">Date Added</th>
                                            <th style="width: 15%;" class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="categoryTab" role="tabpanel">
                            <div class="pd-20">
                                <div class="mb-4">
                                    <button type="button" class="btn btn-primary" id="addCBtn">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-copy dw dw-add mr-2"></i>
                                            <span>Add new category</span>
                                        </div>
                                    </button>
                                </div>
                                <table class=" table stripe hover nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 55%;">Category Name</th>
                                            <th style="width: 20%;">Date Added</th>
                                            <th style="width: 15%;" class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mopTab" role="tabpanel">
                            <div class="pd-20">
                                <div class="mb-4">
                                    <button type="button" class="btn btn-primary" id="addMOPBtn">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-copy dw dw-add mr-2"></i>
                                            <span>Add new </span>
                                        </div>
                                    </button>
                                </div>
                                <table class=" table stripe hover nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 55%;">Description</th>
                                            <th style="width: 20%;">Date Added</th>
                                            <th style="width: 15%;" class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modals -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="updateForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="tableType" name="table">
                <div class="form-group mb-4 row">
                    <label for="umId" class="col-md-3 col-form-label">ID</label>
                    <div class="col-md-9">
                        <input type="text" id="umId" class="form-control bg-white border-0" readonly name="id">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label for="umTitle" class="col-md-3 col-form-label">Title / Description</label>
                    <div class="col-md-9">
                        <textarea name="title" id="umTitle" class="form-control" style="resize: none; height: 4rem;" placeholder="Enter title or description..."></textarea>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label for="lastUpdate" class="col-md-3 col-form-label">Last update</label>
                    <div class="col-md-9">
                        <input type="text" id="lastUpdate" class="form-control bg-white border-0" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

<!-- modals -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="addForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="addMTableType" name="table">
                <div class="form-group mb-4 row">
                    <label for="amTitle" class="col-md-3 col-form-label">Title / Description</label>
                    <div class="col-md-9">
                        <textarea name="title" required id="amTitle" class="form-control" style="resize: none; height: 4rem;" placeholder="Enter title or description..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.all.js"></script>
<script>
jQuery(document).ready(function() {
    let El = {
            /* table type indicator for updaate modal */
            updateMTableType: $('#tableType'),
            updateMDataId: $('#umId'),
            updateMNameInput: $('#umTitle'),
            updateForm: $('#updateForm'),
            updateModal: $('#updateModal'),
            payeesTable: $('#payeeTab table'),
            categoriesTable: $('#categoryTab table'),
            mopTable: $('#mopTab table'),
            lastUpdateDisplay: $('#lastUpdate'),
            addModal: $('#addModal'),
            addForm: $('#addForm'),
            addModalLabel: $('#addModalLabel'),
            addMTableType: $('#addMTableType'),
            btn_addCategory: $('#addCBtn'),
            btn_addMOP: $('#addMOPBtn'),
            btn_addPayee: $('#addPBtn'),
        },
        updateBtnDom = (table) => {
            return `<div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#" data-table="${table}" update-btn><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-table="${table}" delete-btn><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>`;
        },
        dt = {
            payees: null,
            categories: null,
            mop: null,
        },
        rowToUpdate = null,
        /* table data */
        Data = {
            payees: {},
            categories: {},
            mop: {},
        },
        Fn = {
            openUpdateModal: function(table, id) {
                const data = Data[table][id] || {};
                El.updateMTableType.val(table);
                El.updateMDataId.val(id);
                El.lastUpdateDisplay.val(data.updated_at || data.created_at || 'none');
                El.updateMNameInput.val(data.name || data.category_name || '');
                El.updateModal.modal('show');
            },
            openAddModal: function(table) {
                El.addModalLabel.text('Add new mode of payment');
                El.addMTableType.val(table);
            },
            initTables: function() {
                const dtOptions = {
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
                            rowToUpdate = row;
                            Fn.openUpdateModal(this.getAttribute('data-table'), data[0])
                        });

                        // delete
                        $('[delete-btn]', row).on('click', function() {
                            Fn.deleteRecord(this.getAttribute('data-table'), data[0], row);
                        });
                    }
                };

                dt.payees = El.payeesTable.DataTable(dtOptions);
                dt.mop = El.mopTable.DataTable(dtOptions);
                dt.categories = El.categoriesTable.DataTable(dtOptions);

                Object.entries(Data).forEach(([t, d]) => {
                    const rows = [];

                    Object.values(d).forEach(v => {
                        rows.push([
                            v.id,
                            v.name || v.category_name,
                            v.created_at || v.updated_at || '',
                            updateBtnDom(t),
                        ]);
                    });
                    dt[t].rows.add(rows).draw();
                });
            },
            init: function() {
                axios.get('expenses/api/get-settings').then(r => {
                    const data = r.data;
                    if (data.payees) {
                        data.payees.forEach((d) => {
                            Data.payees[d.id] = d;
                        });
                    }

                    if (data.categories) {
                        data.categories.forEach((d) => {
                            Data.categories[d.id] = d;
                        });
                    }

                    if (data.paymentMethods) {
                        data.paymentMethods.forEach((d) => {
                            Data.mop[d.id] = d;
                        });
                    }

                    Fn.initTables();
                });
            },
            deleteRecord: function(table, id, row) {
                swal({
                    title: 'Confirm delete',
                    text: "Are you sure you want to delete this data?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    buttonsStyling: false
                }).then(function(confirm) {
                    if (confirm.value === true) {

                        const formData = new FormData();
                        formData.append('id', id);
                        formData.append('table', table);
                        axios.post('expenses/api/delete-settings', formData).then((r) => {
                            dt[table].row(row).remove().draw();
                            delete Data[table][id];

                            swal(
                                r.data.message || 'Deleted!',
                                '',
                                'success'
                            )
                        }).catch(err => {
                            console.error(err);
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
        },
        Events = {
            updateModal: {
                'hidden.bs.modal': function() {
                    El.updateMDataId.val('');
                    El.lastUpdateDisplay.val('');
                    El.updateMTableType.val('');
                },
                'shown.bs.modal': function() {
                    El.updateMNameInput.focus();
                },
            },
            updateForm: {
                submit: function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);

                    axios.post('expenses/api/update-settings', formData).then(r => {
                        const table = form.table.value;
                        let data = Data[table][form.id.value];

                        if (data.name) {
                            Data[table][form.id.value].name = form.title.value;
                        } else if (data.category_name) {
                            Data[table][form.id.value].category_name = form.title.value;
                        }

                        data = Data[table][form.id.value];
                        dt[table].row(rowToUpdate).data(
                            [
                                data.id,
                                data.name || data.category_name,
                                data.created_at || data.updated_at || '',
                                updateBtnDom(table),
                            ]
                        ).draw();

                        swal({
                            title: 'Success',
                            text: r.data.message || 'Record has been saved!',
                            type: 'success',
                            confirmButtonClass: 'btn btn-success',
                        });
                    }).catch(err => {
                        console.error(err);
                        swal({
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            type: 'error',
                            confirmButtonClass: 'btn btn-success',
                        });
                    }).finally(() => {
                        El.updateModal.modal('hide');
                    });
                }
            },
            btn_addCategory: {
                click: function() {
                    El.addModalLabel.text('Add new category');
                    El.addMTableType.val('categories');
                    El.addModal.modal('show');
                }
            },
            btn_addMOP: {
                click: function() {
                    El.addModalLabel.text('Add new mode of payment');
                    El.addMTableType.val('mop');
                    El.addModal.modal('show');
                }
            },
            btn_addPayee: {
                click: function() {
                    El.addModalLabel.text('Add new payee');
                    El.addMTableType.val('payees');
                    El.addModal.modal('show');
                }
            },
            addModal: {
                'hidden.bs.modal': function() {
                    El.addModalLabel.text('');
                    El.addMTableType.val('');
                    $('#amTitle').val('');
                },
                'shown.bs.modal': function() {
                    $('#amTitle').focus();
                },
            },
            addForm: {
                submit: function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);

                    axios.post('expenses/api/add-settings', formData).then(r => {
                        const data = r.data.new_data;
                        const table = form.table.value;

                        Data[table][data.id] = data;
                        dt[table].rows.add([
                            [
                                data.id,
                                data.name || data.category_name,
                                data.created_at || data.updated_at || '',
                                updateBtnDom(table),
                            ]
                        ]).draw();

                        swal({
                            title: 'Success',
                            text: r.data.message || 'Record has been saved!',
                            type: 'success',
                            confirmButtonClass: 'btn btn-success',
                        });
                    }).catch(err => {
                        console.error(err);
                        swal({
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            type: 'error',
                            confirmButtonClass: 'btn btn-success',
                        });
                    }).finally(() => {
                        El.addModal.modal('hide');
                    });
                },
            },
        };

    // bind events
    Object.keys(Events).forEach((el) => {
        Object.entries(Events[el]).forEach(([ev, fn]) => {
            El[el].on(ev, (e) => fn(e));
        });
    });

    Fn.init();
});
</script>
