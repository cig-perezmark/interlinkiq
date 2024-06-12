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

    // const productDropdown = Init.multiSelect($('#productSelect2'), {
    //     onChange: function(option) {
    //         // ...
    //     }
    // });

    // getMaterials();
    initMemberSearch();
});

// function getMaterials() {
//     $.ajax({
//         url: baseUrl + "foreignSuppliersMaterials",
//         type: "GET",
//         contentType: false,
//         processData: false,
//         success: function({data}) {
//             console.log(data)
//         },
//         error: function() {
//             bootstrapGrowl('Error!');
//         },
//     });
// }



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