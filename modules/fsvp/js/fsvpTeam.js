$(document).ready(function() {
    initMemberSearch();
});

function initMemberSearch() {
    const searchEmpDropdown = $("#employeeSearchDd");
    function formatProduct(data) {
        if (data.loading) return data.name;

        return `<div class="select2-result-repository clearfix">
            <div class="select2-result-repository__avatar">
                <img src="${data.avatar}" alt="Avatar" />
            </div>
            <div class="select2-result-repository__meta"> 
                <div class="select2-result-repository__title">${data.name}</div>
                <div class="select2-result-repository__description">Job ID${data.job_description_id}</div>
            </div>
        </div>`;
    }

    function formatProductSelection(data) {
        // __selectedProductData = data; // set the selected material id to the hidden input
        // if (data.name) {
        //     $(".addProductBtn").removeAttr("disabled");
        // } else {
        //     $(".addProductBtn").prop("disabled", true);
        // }
        console.log(data)
        return data.name || data.text;
    }

    const ajaxObj = {
        url: baseUrl,
        dataType: "json",
        method: "POST",
        delay: 250,
        data: function (params) {
            return {
                "search-employee": params.term, // search term
                // products: JSON.stringify(planBuilder.products) || "[]",
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