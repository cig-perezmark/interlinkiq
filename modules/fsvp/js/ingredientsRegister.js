$(function () {
    const ingredientsTable = Init.dataTable($('#tableIngredients'), {
        columnDefs: [
            {
                orderable: false,
                targets: [-1],
            },
            {
                searchable: false,
                targets: [-1],
            },
            {
                className: "dt-right",
            },{
                className: 'text-center',
                targets: [3, 5]
            },{
                visible: false,
                targets: [2, 5]
            }
        ],
        pageLength: -1
    });
    const regFormAlert = Init.createAlert($('#IngProdRegForm .modal-body'));
    const importerSelect = Init.multiSelect($('#importerSelect'));
    let ProductRegisterData = [];
    let ImportersSelectionData = []

    // init
    initMemberSearch();
    fetchInitialData(ProductRegisterData, ingredientsTable, ImportersSelectionData);

    $('#IngProdRegForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        let url = Init.baseUrl + 'ingredientProductRegister';

        if(form.product_id.value.trim() == '') {
            regFormAlert.isShowing() && regFormAlert.hide();
            regFormAlert.setContent('<strong>Error!</strong> Please select a product first!').show();
            return;
        } 

        const data = new FormData(form);

        var l = Ladda.create(this.querySelector('[type=submit]'));
        l.start();

        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {

                $('#modalIngProdReg').modal('hide');

                // reset the form
                $(form.product_id).val('').trigger('change');
                form.reset();
                fetchInitialData(ProductRegisterData, ingredientsTable, ImportersSelectionData);

                regFormAlert.isShowing() && regFormAlert.hide();
                bootstrapGrowl(message || 'Successfully saved!');
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error!', 'danger');
            },
            complete: function() {
                l.stop();
            }
        });
    });

    $('#tableIngredients').on('click', '[data-editipr]', function() {
        const id = this.dataset.editipr;
        const data = ProductRegisterData[id];

        $('#modalIngProdReg .form-group:has(#productSelect2)').hide();
        $('#modalIngProdReg [name=product_id]').val(data.id);
        $('#modalIngProdReg [name=ipr_id]').val(data.ipr_id);
        $('#iprProductName').val(data.product_name);
        $('#iprDescription').val(data.product_name);
        $('#iprBrandName').val(data.brand_name || '');
        $('#iprIngredientsList').val(data.ingredients_list || '');
        $('#iprIntendedUse').val(data.intended_use || '');
        $('#importerSelect').multiselect('select', [data.importer_id])
        $('#iprTitle').text('Edit Details');

        $('#modalIngProdReg').modal('show');
    });

    $('#modalIngProdReg').on('hidden.bs.modal', function() {
        $('#modalIngProdReg .form-group:has(#productSelect2)').show();
        $('#modalIngProdReg .form-control').val('');
        $('#modalIngProdReg [name=product_id]').val('');
        $('#modalIngProdReg [name=ipr_id]').val('');
        $('#importerSelect').multiselect('select', '')
        $('#iprTitle').text('Add Product');
        importerSelect.reset();
    });
});

function fetchInitialData(dataset, table, importersData) {
    $.ajax({
        url: Init.baseUrl + "ingredientProductsRegisterData",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({results, importers}) {
            if(results) {
                table.dt.clear();
                results.forEach((d) => renderDTRow(dataset, d, table));
                table.dt.draw();
            }

            if(importers) {
                populateImporterDropdown(importers, importersData);
            }

            if(!results.length) {
                bootstrapGrowl('No items to display.')
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!', 'error');
        },
    });
}

function populateImporterDropdown(dataset, importersData) {
    if(Array.isArray(dataset)) {
        const options = [{
            label: dataset.length ? 'Select an importer' : 'No data available.',
            title: dataset.length ? 'Select an importer' : 'No data available.',
            value: '',
            selected: true,
            disabled: true,
        }];
        
        dataset.forEach(d => {
            importersData[d.id] = d;

            options.push({
                label: d.name,
                title: d.name,
                value: d.id,
            });
        });

        options.length && $('#importerSelect').multiselect('dataprovider', options);
    }
}

function renderDTRow(dataset, rowData, table, action = 'create') {
    const na = '<i class="text-muted">(N/A)</i>';
    dataset[rowData.id] = rowData;

    let actionBtn = '';

    if(rowData.rhash) {
        actionBtn = `
            <div class="d-flex center">
                <div class="btn-group btn-group-circle btn-group-sm btn-group-solid">
                    <a href="#" class="btn blue btn-circle btn-sm btn-outline" data-editipr="${rowData.id}">Edit</a>
                    <a href="${(Init.URL || 'fsvp') + '?pdf=ipr&r=' + rowData.rhash}" class="btn dark btn-circle btn-sm" target="_blank" title="PDF Document">PDF</a>
                </div>
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
        rowData.product_name ? `<strong>${rowData.product_name}</strong>` : na,
        rowData.description || na,
        rowData.ingredients_list || na,
        rowData.brand_name || na,
        rowData.intended_use || na,
        actionBtn,
    ]);
    return table.dt;
}

function initMemberSearch() {
    const searchEmpDropdown = $("#productSelect2");
    function formatProduct(data) {
        if (data.loading) return data.name;

        return `<div class="select2-result-repository clearfix">
            <div class="select2-result-repository__meta" style="margin-left: 0;"> 
                <div class="select2-result-repository__title">${data.material_name}</div>
                <div class="select2-result-repository__description">Description: ${data.description}</div>
                <div class="select2-result-repository__description">Foreign Supplier: ${data.supplier_name}</div>
            </div>
        </div>`;
    }

    function formatProductSelection(data) {
        $('#iprDescription').val(data.description);
        $('#iprProductName').val(data.material_name);
        $('#IngProdRegForm [name="ipr_id"]').val(data.id);
        return data.material_name || data.text;
    }

    const ajaxObj = {
        url: Init.baseUrl,
        dataType: "json",
        method: "POST",
        delay: 250,
        data: function (params) {
            return {
                "search-foreignMaterials": params.term,
                page: params.page,
            };
        },
        processResults: function (data, page) {
            return {
                results: data.results,
            };
        },
        cache: true,
    };

    searchEmpDropdown.select2({
        width: "100%",
        ajax: ajaxObj,
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatProduct,
        templateSelection: formatProductSelection,
    });
}