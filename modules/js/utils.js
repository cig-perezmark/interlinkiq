function initMultiSelect(el, options = {}) {
    $(el).multiselect({
        widthSynchronizationMode: 'ifPopupIsSmaller',
        buttonTextAlignment: 'left',
        buttonWidth: '100%',
        maxHeight: 200,
        enableResetButton: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        includeSelectAllOption: true,
        nonSelectedText: 'None selected',
        ...options
    });

    $('.multiselect-container .multiselect-filter', $(el).parent()).css({
        'position': 'sticky', 'top': '0px', 'z-index': 1,
    });
}

function initDataTable(el, options = {}) {
    const obj = {
        dt: $(el).DataTable({
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending",
                },
                emptyTable: "No data available",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "No records found",
                infoFiltered: "(filtered from _MAX_ total records)",
                lengthMenu: "Show _MENU_",
                search: "Search:",
                zeroRecords: "No matching records found",
                paginate: {
                    previous: "Prev",
                    next: "Next",
                    last: "Last",
                    first: "First",
                },
            },
            bStateSave: false,
            lengthMenu: [
                [5, 15, 20, -1],
                [5, 15, 20, "All"],
            ],
            pageLength: 15,
            pagingType: "bootstrap_full_number",
            columnDefs: [{
                    orderable: false,
                    targets: [-1],
                },
                {
                    searchable: false,
                    targets: [-1],
                },
                {
                    className: "dt-right",
                },
            ],
            ...options,
            // dom: 'lBfrtip',
            // buttons: [{
            //     extend: 'excel',
            //     className: 'btn btn-secondary',
            //     text: 'Excel',
            //     title: 'COA Records',
            //     filename: 'COA_Records',
            //     attr: {
            //         'data-bs-toggle': "tooltip",
            //         'data-bs-placement': "top",
            //         'title': "Convert to Excel  file"
            //     },
            //     exportOptions: {
            //         columns: ':visible:not(:last-child)'
            //     }
            // }, {
            //     extend: 'pdf',
            //     className: 'btn btn-secondary',
            //     text: 'PDF',
            //     title: 'COA Records',
            //     filename: 'COA_Records',
            //     attr: {
            //         'data-bs-toggle': "tooltip",
            //         'data-bs-placement': "top",
            //         'title': "Download as PDF"
            //     },
            //     exportOptions: {
            //         columns: ':visible:not(:last-child)'
            //     }
            // }, ],
        }),
    }

    return obj;
}