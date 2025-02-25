<style>
.col-form-label {
    color: #000;
}
span.deleted::after {
    content: '';
    display: inline-block;
    width: .25rem;
    height: 1rem    ;
    background-color: red;
}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.css" />
<script src="<?= base_url() ?>css/src/plugins/sweetalert2/sweetalert2.all.js"></script>
<link href="<?= base_url() ?>css/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>css/fancybox/jquery.fancybox.min.js"></script>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <div class="clearfix">
            <?php if(!isset($dataset)): ?>
            <div class="pd-20 card-box">
                <h4 class="h4 text-blue mb-4">Summary Report </h4>
                <div class="py-4">
                    <form action="<?= base_url() ?>expenses/summary" method="GET">
                        <div class="form-group mb-4 row">
                            <label class="col-md-3 col-form-label">Choose date range</label>
                            <div class="col-md-7">
                                <div class="d-flex align-items-center">
                                    <input type="date" class="form-control" name="from" <?= $earliest ? 'min="'.$earliest.'" max="'.$latest.'"' : 'disabled' ?>>
                                    <span class="mx-4">-</span>
                                    <input type="date" class="form-control" name="to" <?= $earliest ? 'min="'.$earliest.'" max="'.$latest.'"' : 'disabled' ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    Generate summary
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($dataset)): ?>
            <div class="card-box mb-30">
                <div class="pd-20 d-flex align-items-center justify-content-between">
                    <h4 class="text-blue h4">Summary Report for
                        <?= ($dataset['startDate'] ?? $earliest) . ' to ' . ($dataset['endDate'] ?? $latest) ?>
                    </h4>
                    <a href="<?= base_url('expenses/summary') ?>" class="btn btn-link">Back</a>
                </div>
                <form id="filterForm" class="py-4x container-fluid">
                    <div class="form-group mb-4 row">
                        <label class="col-md-3 col-form-label">Filter by payee account(s)</label>
                        <div class="col-md-4 mt-md-0">
                            <select class="selectpicker form-control" id="payeeSelect" data-size="5" multiple data-actions-box="true" data-selected-text-format="count">
                                <?php foreach($dataset['payees'] as $k => $p) echo '<option value="'.($p['value'] . '@' . $k).'">'.$p['value'].'</option>'; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-4 row ">
                        <label class="col-md-3 col-form-label">Filter by category</label>
                        <div class="col-md-4 mt-md-0">
                            <select class="selectpicker form-control" id="categorySelect" data-size="5" multiple data-actions-box="true" data-selected-text-format="count">
                                <?php foreach($dataset['categories'] as $k => $p) echo '<option value="'.($p['value'] . '@' . $k).'">'.$p['value'].'</option>'; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-4 row ">
                        <label class="col-md-3 col-form-label">Filter by mode of payment</label>
                        <div class="col-md-4 mt-md-0">
                            <select class="selectpicker form-control" id="mopSelect" data-size="5" multiple data-actions-box="true" data-selected-text-format="count">
                                <?php foreach($dataset['mops'] as $k => $p) echo '<option value="'.($p['value'] . '@' . $k).'">'.$p['value'].'</option>'; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-4 row ">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-auto mt-md-0">
                            <button type="submit" class="btn btn-primary">Refresh</button>
                        </div>
                    </div>
                </form>
                <div class="pb-20">
                    <div class="mb-3 d-flex align-items-center justify-content-end">
                        <span>Download as:</span>
                        <div id="customCon"></div>
                    </div>
                    <div class="table-responsive">
                        <table id="recordsTable" class="table table-sm stripex hover nowrap ">
                            <thead>
                                <tr>
                                    <th class="hide" aria-label="payee id">Hidden</th>
                                    <th class="hide" aria-label="category id">Hidden</th>
                                    <th class="hide" aria-label="mop id">Hidden</th>
                                    <th>Date</th>
                                    <th>Payee</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Mode of Payment</th>
                                    <th class="datatable-nosort">Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataset['records'] as $record): ?>
                                <tr>
                                    <td style="text-wrap: wrap;"><?= isset($dataset['payees'][$record->billing_entity]) ? $dataset['payees'][$record->billing_entity]['value'] . '@'. $record->billing_entity : '' ?></td>
                                    <td style="text-wrap: wrap;"><?= isset($dataset['categories'][$record->category]) ? $dataset['categories'][$record->category]['value'] . '@'. $record->category : '' ?></td>
                                    <td style="text-wrap: wrap;"><?= isset($dataset['mops'][$record->mop]) ? $dataset['mops'][$record->mop]['value'] . '@'. $record->mop : '' ?></td>
                                    <td style="text-wrap: wrap;"><?= $record->date_of_payment ?></td>
                                    <td style="text-wrap: wrap;" <?= $dataset['payees'][$record->billing_entity]['deleted'] ? 'title="This payee account has been removed."' : '' ?>>
                                        <?= $dataset['payees'][$record->billing_entity]['deleted'] ? '<span class="deleted"></span>' : '' ?>
                                        <?= $dataset['payees'][$record->billing_entity]['value'] ?? $record->billing_entity ?>
                                    </td>
                                    <td style="text-wrap: wrap;"><?= $record->description ?></td>
                                    <td style="text-wrap: wrap;"><?= '$'.number_format($record->amount, 2) ?></td>
                                    <td style="text-wrap: wrap;" <?= $dataset['categories'][$record->category]['deleted'] ? 'title="This category has been removed."' : '' ?>>
                                        <?= $dataset['categories'][$record->category]['deleted'] ? '<span class="deleted"></span>' : '' ?>
                                        <?= $dataset['categories'][$record->category]['value'] ?? $record->category ?>
                                    </td>
                                    <td style="text-wrap: wrap;" <?= $dataset['mops'][$record->mop]['deleted'] ? 'title="This mode of payment has been removed."' : '' ?>>
                                        <?= $dataset['mops'][$record->mop]['deleted'] ? '<span class="deleted"></span>' : '' ?>
                                        <?= $dataset['mops'][$record->mop]['value'] ?? $record->mop ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="dw dw-more"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <?php 
                                                    if($record->documents) {
                                                        $uploadPath = 'uploads/opex_docs/';
                                                        $docs = json_decode($record->documents);
                                                        foreach($docs as $k => $d) {
                                                            if($k > 0) {
                                                                echo '<a  href="'.(base_url() . $uploadPath . $d). '" data-fancybox="docs'.$record->id.'" class="collapse dropdown-item docs" rel="docs"></a>';
                                                            } else {
                                                                echo '<a  href="'.(base_url() . $uploadPath . $d). '" data-fancybox="docs'.$record->id.'" class="dropdown-item docs" rel="docs"><i class="icon-copy dw dw-view"></i> View attachment(s)</a>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a class="dropdown-item" href="<?= base_url() . 'expenses/form/update/' . $record->id ?>" target="_blank"><i class="dw dw-edit2"></i> Update</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteRecord(<?= $record->id ?>)"><i class="dw dw-delete-3"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6">Total amount: </th>
                                    <th colspan="4">$<?= number_format($total_amount ?? '0', 2, '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    let recordsTable = $('#recordsTable'),
        filterForm = $('#filterForm'),
        El = {
            payeeSelect: $('#payeeSelect'),
            categorySelect: $('#categorySelect'),
            mopSelect: $('#mopSelect'),
        },
        dtTable = recordsTable.DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }, {
                targets: 'hide',
                visible: false
            }],
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            "language": {
                "info": "_START_-_END_ of _TOTAL_ entries",
                searchPlaceholder: "Search",
                paginate: {
                    next: '<i class="ion-chevron-right"></i>',
                    previous: '<i class="ion-chevron-left"></i>'
                }
            },
            "order": [[3, 'asc']],
            "columns": [
                { "width": "0%" },
                { "width": "0%" },
                { "width": "0%" },
                { "width": "10%" },
                { "width": "20%" },
                { "width": "30%" },
                { "width": "10%" },
                { "width": "16%" },
                { "width": "14%" },
                { "width": "0%" },
            ],
            dom: 'lBfrtip',
            buttons: [{
                extend: 'csv',
                className: 'btn btn-sm btn-secondary',
                text: 'CSV',
                title: 'CIG Expenses',
                filename: 'CIG Expenses',
                attr: {
                    'data-bs-toggle': "tooltip",
                    'data-bs-placement': "top",
                    'title': "Convert to CSV  file"
                },
                exportOptions: {
                    columns: ':visible:not(.hide, :last-child)'
                }
            }, {
                extend: 'pdf',
                className: 'btn btn-sm btn-secondary',
                text: 'PDF',
                title: 'CIG Expenses',
                filename: 'CIG Expenses',
                attr: {
                    'data-bs-toggle': "tooltip",
                    'data-bs-placement': "top",
                    'title': "Download as PDF"
                },
                exportOptions: {
                    columns: ':visible:not(.hide, :last-child)'
                }
            }, ],
        }),
        Fn = {
            getSelectedValues(el) {
                var selectElement = el.get(0);
                var selectedValues = [];
                for (var i = 0; i < selectElement.options.length; i++) {
                    var option = selectElement.options[i];
                    if (option.selected) {
                        selectedValues.push(option.value);
                    }
                }
                return selectedValues;
            }
        };

    dtTable.buttons().containers().appendTo('#customCon');

    filterForm.on('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const payees = Fn.getSelectedValues(El.payeeSelect).join('|');
        const categories = Fn.getSelectedValues(El.categorySelect).join('|');
        const mop = Fn.getSelectedValues(El.mopSelect).join('|');

        // dtTable.column(0).search(valuesToSearch.join('|'), true, false).draw();
        dtTable.search('').draw(); // reset search
        dtTable.columns([0, 1, 2]).every(function(colIdx) {
            var valuesToSearch;
            
            switch(colIdx) {
                case 0: valuesToSearch = payees; break;
                case 1: valuesToSearch = categories; break;
                case 2: valuesToSearch = mop; break;
                default: valuesToSearch = payees; break;
            }
            this.search(valuesToSearch, true, false);
        });

        dtTable.draw()
    });
});

function deleteRecord(id) {
    swal({
        title: 'Delete this record?',
        text: "Are you sure you want to delete this recoord?",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes',
        confirmButtonClass: 'btn btn-success margin-5',
        cancelButtonClass: 'btn btn-secondary margin-5',
        buttonsStyling: false
    }).then(function(r) {
        if(r.value == true) {
            const formData = new FormData();
            formData.append('id', id);
            axios.post('expenses/api/delete-record', formData).then((r) => {
                swal(r.data.message || 'Record has been deleted!', '', 'success').then(() => {
                    location.reload();
                })
            }).catch(err => {
                swal({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    type: 'error',
                    confirmButtonClass: 'btn btn-success',
                });
            })
        }
    });
}
</script>
