$(function() {
    Init.multiSelect($('#importerdd'));
    const importerListTable = Init.dataTable($('#tableImporterList'), {
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
            {
                visible: false,
                targets: [2]
            }
        ]
    });
});
