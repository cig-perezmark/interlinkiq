jQuery(function() {
    let fsvpqiData = [];
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
                className: "text-center",
                targets: [2,3,4,5,6,7]
            },
            {
                visible: false,
                targets: [1]
            }
        ]
    });
    
    const fsvpqiSelect = Init.multiSelect($('#fsvpqiSelect'));
    populateFSVPQISelect(alert);
    fetchFSVPQIData(fsvpqiData, tableFSVPQI);

    $('#fsvpqiRegForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;

        if(form.fsvpqi.value == '') {
            if(alert.isShowing()) {
                alert.hide();
            }

            alert.setContent(`<strong>Error!</strong> FSVPQI field is required.`).show();
            return;
        }

        const data = new FormData(form); 
        var l = Ladda.create(this.querySelector('[type=submit]'));
        l.start();

        $.ajax({
            url: Init.baseUrl + "newFSVPQI",
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                renderDTRow(fsvpqiData, data, tableFSVPQI);
                tableFSVPQI.dt.draw();

                fsvpqiSelect.reset();
                form.reset();
                $('#modalFSVPQIReg').modal('hide');

                bootstrapGrowl(message || 'Saved successfully.');
                populateFSVPQISelect(alert);
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.info || responseJSON.message || 'Error saving data.');
            },
            complete: function() {
                l.stop();
            }
        });
    });

    $('.frfUplDoc').on('change', '.mt-checkbox input[type=checkbox]', function() {
        const parent = $(this).closest('.frfUplDoc');
        parent.find('input.form-control:not([data-note])').prop('required', this.checked);
    });
});

function populateFSVPQISelect(alert) {
    $.ajax({
        url: Init.baseUrl + "getFSVPQIsForRegistration",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({result, message}) {
            if(result) {
                let options = [{
                    label: message || 'No data available.',
                    title: message || 'No data available.',
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
                    alert.hide();
                } else {
                    alert.setContent(`<strong>Note:</strong> An FSVPQI employee is required.`).show();
                }
                
                alert.setTimeout(result.length ? 3000 : 10000);
                $('#modalFSVPQIReg [type=submit]').prop('disabled', !result.length);
                $('#fsvpqiSelectHelpBlock').html(!result.length ? `Assign FSVPQI(s) in the <a href="/employee" target="_blank">Employee Roster</a> module.` : '');
                $('#fsvpqiSelect').multiselect('dataprovider', options);
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching data.');
        },
    });
}

function renderDTRow(set, d, table) {
    set[d.id] = d;
    table.dt.row.add([
        d.name || '',
        d.ces || '',
        fileCellHtml(d.certifications['pcqi-certificate'], d.id),
        fileCellHtml(d.certifications['food-quality-auditing'], d.id),
        fileCellHtml(d.certifications['haccp-training'], d.id),
        fileCellHtml(d.certifications['food-safety-training-certificate'], d.id),
        fileCellHtml(d.certifications['gfsi-certificate'], d.id),
        fileCellHtml(d.certifications['fsvpqi-certificate'], d.id),
        // `
        //     <div class="d-flex center">
        //         <button type="button" class="btn-link">Open</button>
        //     </div>
        // `,
    ]);
    return table.dt;
}

function fetchFSVPQIData(dataSet, table) {
    $.ajax({
        url: Init.baseUrl + "fetchFSVPQI",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            if(data && Array.isArray(data)) {
                data.forEach((d) => renderDTRow(dataSet, d, table));
                table.dt.draw();
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching data.');
        },
    });
}

function fileCellHtml(fileData, id) {
    let fancyBoxAttr = '';
    if(fileData) {
        const src = fileData.src ?? fileData.filename;
        fancyBoxAttr = `data-fancybox data-src="${src}"`;
        if(!src.search('fancybox_type=no_iframe')) {
            fancyBoxAttr += `  data-type="iframe"`;
        }
    }
    
    return !fileData 
        ? `<span class="fa fa-close text-danger"></span>` 
        : `<a href="javascript:void(0)" ${fancyBoxAttr} class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View</a>`;
}