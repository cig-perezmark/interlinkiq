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
});