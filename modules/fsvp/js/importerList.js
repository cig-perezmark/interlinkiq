$(function() {
    const alert = Init.createAlert($('#newImporterForm .modal-body'));
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

    // init
    Init.multiSelect($('#fsvpqiSelect'));
    Init.multiSelect($('#supplierSelectDropdown'));
    Init.multiSelect($('#importerdd'), {
        onChange: function(option, checked, select) {
            const pList = $('#productsListSelection');
            pList.html('');
            pList.append(`<div class="stat-loading"> <img src="assets/global/img/loading.gif" alt="loading"> </div>`);
            $('#productsHelpBlock').addClass('d-none');

            $.ajax({
                url: baseUrl + "getProductsBySupplier=" + $(option).val(),
                type: "GET",
                contentType: false,
                processData: false,
                success: function({materials}) {
                    if (materials && Array.isArray(materials)) {
                        if (!materials.length) {
                            $('#productsHelpBlock').text('No materials found.');
                            return;
                        } else {
                            $('#productsHelpBlock').text('Tick on the checkboxes to select.');
                        }

                        materials.forEach((m) => {
                            const substr = m.description.substring(0, 32);

                            pList.append(`
                                <label class="mt-checkbox mt-checkbox-outline "> ${m.name}
                                    <p title="${m.description}" class="small text-muted" style="padding: 0; margin:0;">${(m.description.length > 32 ? substr + '...' : m.description) || ''}</p>
                                    <input type="checkbox" value="${m.id}" name="importer_products[]"">
                                    <span></span>
                                </label>
                            `);
                        });
                    }
                },
                error: function() {
                    bootstrapGrowl('Error!');
                },
                complete: function() {
                    pList.find('.stat-loading').remove();
                    $('#productsHelpBlock').removeClass('d-none');
                }
            });
        }
    });
    populateFSVPQISelect();

    // events
    $('#newImporterForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;

        if(form.importerdd.value == '') {
            if(alert.isShowing()) {
                alert.hide();
            }

            alert.setContent(`<strong>Error!</strong> Importer field is required.`).show();
            return;
        }
        
        // var l = Ladda.create(form.querySelector('[type=submit]'));
        // l.start();
        const data = new FormData(form);

        $.ajax({
            url: baseUrl + "newImporter",
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                // if(data) {
                //     renderDTRow(data).draw();
                // }

                // $(form.supplier).val('').trigger('change');
                // $('#modalNewSupplier').modal('hide');
                // bootstrapGrowl(message || 'Saved!');
            },
            error: function() {
                bootstrapGrowl('Error!', 'danger');
            },
            complete: function() {
                l.stop();
            }
        });
    });
});

function populateFSVPQISelect() {
    $.ajax({
        url: Init.baseUrl + "myFSVPQIInRecords",
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
                }
                
                // alert.setTimeout(result.length ? 3000 : 10000);
                // $('#modalFSVPQIReg [type=submit]').prop('disabled', !result.length);
                // $('#fsvpqiSelectHelpBlock').html(!result.length ? `Assign FSVPQI(s) in the <a href="/employee" target="_blank">Employee Roster</a> module.` : '');
                $('#fsvpqiSelect').multiselect('dataprovider', options);
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching data.');
        },
    });
}