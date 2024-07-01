jQuery(document).ready(function () {
    // initSelect2AddProducts();
    // initHaccpTeamRosterTable();

    events();
    submits();
    tcTable.prototype.ccp_determination();

    // summary table
    $("#haccp-overview_table").DataTable({
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
            },
        ],
        order: [[0, "asc"]],
        drawCallback: function (settings) {
            const dt = this;
            const manualSearchTrigger = function () {
                dt.api().search(this.innerText).draw();
            };

            $("#haccp-overview_table").find("td a[data-filter]").off("click").on("click", manualSearchTrigger);
        },
    });
});
