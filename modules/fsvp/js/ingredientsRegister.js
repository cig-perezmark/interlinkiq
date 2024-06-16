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
            }
        ]
    });
    const regFormAlert = Init.createAlert($('#IngProdRegForm .modal-body'));
    let ProductRegisterData = [];

    // init
    initMemberSearch();
    fetchProductRegisterData(ProductRegisterData, ingredientsTable);

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

        // var l = Ladda.create(this.querySelector('[type=submit]'));
        // l.start();

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

                regFormAlert.isShowing() && regFormAlert.hide();
                bootstrapGrowl(message || 'Successfully saved!');
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error!', 'danger');
            },
            complete: function() {
                // l.stop();
            }
        });
    });
});

function fetchProductRegisterData(dataset, table) {
    $.ajax({
        url: Init.baseUrl + "ingredientProductsRegisterData",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({results}) {
            if(results) {
                table.dt.clear();
                results.forEach((d) => renderDTRow(dataset, d, table));
                table.dt.draw();
            }

            if(!data.length) {
                bootstrapGrowl('No items to display.')
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!', 'error');
        },
    });
}

function renderDTRow(dataset, rowData, table, action = 'create') {
    dataset[rowData.id] = rowData;
    // console.log
    
    table.dt.row.add([
        rowData.importer_name,
        rowData.product_name,
        rowData.description,
        rowData.ingredients_list,
        rowData.brand_name,
        rowData.intended_use,
        `
            <div class="d-flex center">
                <a href="${(Init.URL || 'fsvp') + '?pdf=ipr&r=' + rowData.rhash}" class="btn green btn-circle btn-sm btn-outline" target="_blank">View</a>
            </div>
        `,
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
                <div class="select2-result-repository__description">${data.description}</div>
            </div>
        </div>`;
    }

    function formatProductSelection(data) {
        // form.find('[data-name]').val(data.name);
        // form.find('[data-title]').val(data.position);
        // form.find('[data-email]').val(data.email);
        // form.find('[data-phone]').val(data.phone);
        // form.find('[data-avatar]').attr('src', data.avatar);
        $('#iprImporter').val(data.supplier_name);
        $('#iprImporterId').val(data.supplier_id);
        $('#iprDescription').val(data.description);
        $('#iprProductName').val(data.material_name);
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