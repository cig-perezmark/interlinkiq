jQuery(function() {
    const datatableAW = Init.dataTable($('#tableActivitiesWorksheet'));
    const supplierSelect = Init.multiSelect($('#awForeignSupplierSelect'));
    const fsvpqiSelect = Init.multiSelect($('#awFSVPQISelect'));
    const importerSelect = Init.multiSelect($('#awImporterSelect'), {
        onChange: function(option) {
            const id = $(option).val();

            console.log(id)
        }
    });

    let ActivitiesWorksheetData = [];

    // init
    fetchInitialData(ActivitiesWorksheetData, datatableAW);

    $('#newActivityWorksheetForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const data = new FormData(form);
        let url = Init.baseUrl + 'newActivityWorksheet';


        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {

                // $('#modalIngProdReg').modal('hide');

                // // reset the form
                // $(form.product_id).val('').trigger('change');
                // form.reset();
                // fetchInitialData(ProductRegisterData, ingredientsTable, ImportersSelectionData);

                // regFormAlert.isShowing() && regFormAlert.hide();
                // bootstrapGrowl(message || 'Successfully saved!');
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error!', 'danger');
            },
            complete: function() {
                // l.stop();
            }
        });
    })
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
                <div class="btn-group btn-group-circle btn-group-sm btn-group-solid hide">
                    <a href="#" class="btn blue btn-circle btn-sm btn-outline" data-editipr="${rowData.id}">Edit</a>
                    </div>
                    <a href="${(Init.URL || 'fsvp') + '?pdf=activities-worksheet&r=' + rowData.rhash}" class="btn dark btn-circle btn-sm" target="_blank" title="PDF Document">PDF</a>
            </div>
        `;
    } else {
        actionBtn = `
            <div class="d-flex center">
                <a href="#" class="btn dark btn-circle btn-sm btn-outline" data-editipr="${rowData.id}">Edit details</a>
            </div>
        `;
    }
    
    table.dt.row.add([
        rowData.importer_name || na,
        rowData.supplier_name || na,
        rowData.qi_name || na,
        rowData.products || na,
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