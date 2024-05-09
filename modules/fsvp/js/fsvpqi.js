jQuery(function() {
    const alert = Init.createAlert($('#fsvpqiRegForm .modal-body'));
    const tableFSVPQI = Init.dataTable($('#tableFSVPQI'), {
        columnDefs:  [
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
                targets: [1]
            }
        ]
    });
    
    Init.multiSelect($('#fsvpqiSelect'));
    populateFSVPQISelect();

    $('#fsvpqiRegForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;

        if(form.fsvpqi.value == '') {
            if(alert.isShowing()) {
                alert.hide();
            }

            alert.setContent(`<strong>Error!</strong> An FSVPQI is required.`).show();
        }
    });

    $('.frfUplDoc').on('change', '.mt-checkbox input[type=checkbox]', function() {
        const parent = $(this).closest('.frfUplDoc');
        parent.find('input.form-control:not([data-note])').prop('required', this.checked);
    });
});

function populateFSVPQISelect() {
    $.ajax({
        url: Init.baseUrl + "getFSVPQIs",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({result}) {
            if(result) {
                let options = [{
                    label: 'No data available.',
                    title: 'No data available.',
                    value: '',
                    selected: true,
                    disabled: true,
                }];
                
                if(result.length) {
                    options = [{
                        label: 'Select FSVPQI',
                        title: 'Select FSVPQI',
                        value: '',
                        selected: true,
                        disabled: true,
                    }];

                    Object.values(result).forEach((d) => {
                        options.push({
                            label: d.name,
                            title: d.name,
                            value: d.id
                        });
                    });
                }

                $('#fsvpqiSelectHelpBlock').html(!result.length ? `Please assign FSVPQI(s) in the <a href="/employee" target="_blank">Employee Roster</a> module.` : '');
                $('#fsvpqiSelect').multiselect('dataprovider', options);
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching data.');
        },
    });
}