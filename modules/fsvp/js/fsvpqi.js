jQuery(function() {
    const tableFSVPQI = Init.dataTable($('#tableFSVPQI'));
    Init.multiSelect($('#fsvpqiSelect'));
    populateFSVPQISelect();
});

function populateFSVPQISelect() {
    $.ajax({
        url: Init.baseUrl + "getFSVPQIs",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({result}) {
            if(result) {
                const options = [{
                    label: 'Select FSVPQI',
                    title: 'Select FSVPQI',
                    vaue: '',
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

                $('#fsvpqiSelect').multiselect('dataprovider', options)
            }
        },
        error: function() {
            bootstrapGrowl('Error FSVPQI employee(s)!');
        },
    });
}