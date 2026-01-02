jQuery(function() {
    const datatableAW = Init.dataTable($('#tableActivitiesWorksheet'));
    const supplierSelect = Init.multiSelect($('#awForeignSupplierSelect'), {
        onChange: SSOnChange
    });
    const fsvpqiSelect = Init.multiSelect($('#awFSVPQISelect'));
    const importerSelect = Init.multiSelect($('#awImporterSelect'), {
        onChange: ISOnChange
    });

    let ActivitiesWorksheetData = {};
    let onViewAWId = null;

    // init
    fetchInitialData(ActivitiesWorksheetData, datatableAW);

    $('#tableActivitiesWorksheet').on('click', '[data-awid]', function() {
        const id = this.dataset.awid ?? 0;

        onViewAWId = id;
        showEditModal(id)
    })

    $('#newActivityWorksheetForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const data = new FormData(form);
        let url = Init.baseUrl + 'newActivityWorksheet';

        if(onViewAWId) {
            data.append('editawid', onViewAWId);
        }

        // signatures
        data.append('preparer_sign', $('#preparer_signature').eSign("getData"));
        data.append('reviewer_sign', $('#reviewer_signature').eSign("getData"));
        data.append('approver_sign', $('#approver_signature').eSign("getData"));
        
        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                fetchInitialData(ActivitiesWorksheetData, datatableAW);

                form.reset();
                importerSelect.reset();
                supplierSelect.reset();
                fsvpqiSelect.reset();
                
                $('#modalActWorksheet').modal('hide');
                bootstrapGrowl((onViewAWId ? (message || 'Successfully saved!') : 'Changes saved.'));
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error!', 'danger');
            },
            complete: function() {
                // l.stop();
            }
        });
    });

    $('#modalActWorksheet').on('hidden.bs.modal', function() {
        resetAWForm();
    });
    
    $('.signature__').eSign();

    function SSOnChange(option) {
        const address = $('#awForeignSupplierSelect option:selected').attr('data-address') || '';
        $('#awForeignSupplierAddress').val(address);

        const supplierId = $(option).val();
        const importerId = $('#awImporterSelect').val() || '';

        populateFoodProducts(supplierId, importerId);
    }

    function ISOnChange(option) {
        const id = $(option).val();
        const address = $('#awImporterSelect option:selected').attr('data-address') || '';
        $('#awImporterAddress').val(address);

        supplierSelect.reset();
        fsvpqiSelect.reset();
        $('#awForeignSupplierAddress').val('');
        $('#awProductsImported').val('');
    }

    function showEditModal(id) {
        $.ajax({
            url: Init.baseUrl + "getActivitiesWorksheet=" + (id ?? 0),
            type: "GET",
            contentType: false,
            processData: false,
            success: function({data}) {

                setTimeout(() => {
                    $('#awFSVPQISelect').multiselect('select', [data.fsvpqi_id]);
                }, 500)
                
                $('#modalActWorksheet [name=importer_id]').multiselect('select', [data.importer_id]);
                ISOnChange($('#modalActWorksheet [name=importer_id]'));

                $('#modalActWorksheet [name=supplier_id]').multiselect('select', [data.supplier_id]);
                SSOnChange($('#modalActWorksheet [name=supplier_id]'));

                $('#modalActWorksheet [name=verification_date]').val(data.verification_date);
                $('#modalActWorksheet [name=supplier_evaluation_date]').val(data.supplier_evaluation_date);
                $('#modalActWorksheet [name=approval_date]').val(data.approval_date);

                $('#modalActWorksheet [name=fdfsc]').val(data.fdfsc);
                $('#modalActWorksheet [name=pdipm]').val(data.pdipm);
                $('#modalActWorksheet [name=fshc]').val(data.fshc);

                $('#modalActWorksheet [name=dfsc]').val(data.dfsc);
                $('#modalActWorksheet [name=vaf]').val(data.vaf);
                $('#modalActWorksheet [name=justification_vaf]').val(data.justification_vaf);

                $('#modalActWorksheet [name=verification_records]').val(data.verification_records);
                $('#modalActWorksheet [name=assessment_results]').val(data.assessment_results);
                $('#modalActWorksheet [name=corrective_actions]').val(data.corrective_actions);
                $('#modalActWorksheet [name=reevaluation_date]').val(data.reevaluation_date);
                $('#modalActWorksheet [name=comments]').val(data.comments);
                
                $('#modalActWorksheet [name=prepared_by]').val(data.prepared_by);
                $('#modalActWorksheet [name=prepare_date]').val(data.prepare_date);
                $('#modalActWorksheet [name=reviewed_by]').val(data.reviewed_by);
                $('#modalActWorksheet [name=review_date]').val(data.review_date);
                $('#modalActWorksheet [name=approved_by]').val(data.approved_by);
                $('#modalActWorksheet [name=approve_date]').val(data.approve_date);
                
                
                $('#preparer_signature').eSign("set", data.prepared_by_sign);
                $('#reviewer_signature').eSign("set", data.reviewed_by_sign);
                $('#approver_signature').eSign("set", data.approved_by_sign);

                $('#modalActWorksheet').modal('show');
            },
            error: function() {
                bootstrapGrowl('Error fetching record!', 'error');
            },
        });
    }

    function resetAWForm() {
        $('#modalActWorksheet form .form-control').val('');
        supplierSelect.reset();
        fsvpqiSelect.reset();
        importerSelect.reset();
        
        // signatures
        $('#preparer_signature').eSign("destroy");
        $('#reviewer_signature').eSign("destroy");
        $('#approver_signature').eSign("destroy");
        
    
        onViewAWId = null;
    }
});

function refreshDropdownsByImporter(importerId) {
    // dynamically update fsvpqi and supplier dropdown items by importer selection
}

function fetchInitialData(dataset, table) {
    showLoadingToolbar();

    $.ajax({
        url: Init.baseUrl + "activitiesWorksheetsInitialData",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({results}) {
            if(results) {
                table.dt.clear();
                results.forEach((d) => renderDTRow(dataset, d, table));
                table.dt.draw();
            }

            if(!results.length) {
                bootstrapGrowl('No items to display.')
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!', 'error');
        },
        complete: function() {
            showLoadingToolbar(false);
        }
    });
}

function renderDTRow(dataset, rowData, table, mode = 'add') {
    const na = '<i class="text-muted">(N/A)</i>';
    dataset[rowData.id] = rowData;

    let actionBtn = '';

    if(rowData.rhash) {
        actionBtn = `
            <div class="d-flex center">
                <div class="btn-group btn-group-circle btn-group-sm btn-group-solid hidex">
                    <a href="javascript:void(0)" class="btn blue btn-circle btn-sm btn-outline" data-awid="${rowData.id}">Edit</a>
                    <a href="${(Init.URL || 'fsvp') + '?pdf=activities-worksheet&r=' + rowData.rhash}" class="btn dark btn-circle btn-sm" target="_blank" title="PDF Document">PDF</a>
                </div>
            </div>
        `;
    } else {
        actionBtn = `
            <div class="d-flex center">
                <a href="#" class="btn dark btn-circle btn-sm btn-outline" data-awid="${rowData.id}">Edit details</a>
            </div>
        `;
    }
    
    table.dt.row.add([
        rowData.importer_name || na,
        rowData.supplier_name || na,
        rowData.products || na,
        rowData.qi_name || na,
        rowData.approval_date || na,
        rowData.evaluation_date || na,
        actionBtn,
    ]);
    return table.dt;
}

function showLoadingToolbar(mode = true) {
    $('.tab-toolbar #newAWBtn')[mode ? 'hide' : 'show']();
    $('.tab-toolbar .stat-loading')[!mode ? 'hide' : 'show']();
}

function populateFoodProducts(supplierId, importerId) {
    const foodImportedSelect = $('#awProductsImported');
    foodImportedSelect.val('');
    
    const data = new FormData();
    data.append('supplier', supplierId);
    data.append('importer', importerId);

    $.ajax({
        url: Init.baseUrl + "fetchProductsBySupplierAndImporter",
        type: "POST",
        contentType: false,
        processData: false,
        data,
        success: function({results}) {
            if(results) {
                foodImportedSelect.val(results);
            } else {
                foodImportedSelect.val('Unable to find imported products. Kindly check if the selected importer is currently linked to the foreign supplier.');
            }
        },
        error: function() {
            foodImportedSelect.val('');
            bootstrapGrowl('Error fetching records!', 'error');
        },
    });
}
