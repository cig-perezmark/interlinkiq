$(function() {
    let importersData = [];
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
            },{
                className: 'text-center',
                targets: [3, 5]
            }
        ]
    });

    // init
    const fsvpqiSelect = Init.multiSelect($('#fsvpqiSelect'), {
        onChange: function(option) {
            $('#id_fsvpqiEmail').val(option.get(0).title || 'None');
        }
    });
    const supplierSelect = Init.multiSelect($('#supplierSelectDropdown'), {
        onChange: function(option, checked) {
            const address = option.get(0).dataset.address || '';
            $('#if_SupplierAddress').val(address);

            // render products importer
            // const foreignSupplierId = option.attr('value');

            const pList = $('#productsListSelection');
            pList.html('');
            pList.append(`<div class="stat-loading"> <img src="assets/global/img/loading.gif" alt="loading"> </div>`);
            $('#productsHelpBlock').addClass('d-none');

            $.ajax({
                url: baseUrl + "getProductsByForeignSupplier=" + $(option).val(),
                type: "GET",
                contentType: false,
                processData: false,
                success: function({materials}) {
                    if (materials && Array.isArray(materials)) {
                        if (!materials.length) {
                            $('#productsHelpBlock').text('No products found.');
                            return;
                        } else {
                            $('#productsHelpBlock').text('Tick on the checkbox to select the product.');
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
    const importerSelect = Init.multiSelect($('#importerdd'), {
        onChange: function(option, checked, select) {
            
            const address = option.get(0).dataset.address || '';
            $('#if_ImporterAddress').val(address);
        }
    });
    const CBPFormAlert = Init.createAlert($('#modalCBPFiling .modal-body'));

    populateFSVPQISelect();
    fetchImporterListTable(importersData, importerListTable);
    // events
    $('#newImporterForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.target;

        if(form.importerdd.value == '') {
            alert.isShowing() && alert.hide();
            alert.setContent(`<strong>Error!</strong> Importer field is required.`).show();
            return;
        }

        if($(form).find('[name="importer_products[]"]').length && !$(form).find('[name="importer_products[]"]:checked').length) {
            alert.isShowing() && alert.hide();
            alert.setContent(`<strong>Error!</strong> Please select product(s) to proceed.`).show();
            return;
        }
        
        var l = Ladda.create(form.querySelector('[type=submit]'));
        l.start();
        const data = new FormData(form);

        $.ajax({
            url: baseUrl + "newImporter",
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                if(data) {
                    renderDTRow(importersData, data, importerListTable).draw();
                }

                // reset form
                importerSelect.reset();
                supplierSelect.reset();
                fsvpqiSelect.reset();
                form.reset();
                
                $('#productsListSelection').html('');
                $('#productsHelpBlock').text('Select importer first.');
                
                $('#modalNewImporter').modal('hide');
                bootstrapGrowl(message || 'Saved!');
            },
            error: function({responseText}) {
                bootstrapGrowl(responseText || 'Error!', 'danger');
            },
            complete: function() {
                l.stop();
            }
        });
    });

    $('#tableImporterList').on('click', '[data-opencbpfilingform]', function() {
        $('#CBPFilingForm [name=importer]').val(this.dataset.opencbpfilingform || '');
        $('#modalCBPFiling').modal('show');
    });

    // viewing cbp data
    $('#tableImporterList').on('click', '[data-viewcbpform]', function() {
        const data = importersData[this.dataset.viewcbpform]; 
        if(!data) {
            bootstrapGrowl('Record not found.', 'error');
            return;
        }

        $('#modalViewCBP [data-viewcbp=importer]').text(data.importer.name);
        $('#modalViewCBP [data-viewcbp=date]').text(data.cbp.date);
        $('#modalViewCBP [data-viewcbp=address]').text(data.importer.address);
        $('#modalViewCBP [data-viewcbp=foods_info]').text(data.cbp.foods_info);
        $('#modalViewCBP [data-viewcbp=supplier_info]').text(data.cbp.supplier_info);
        $('#modalViewCBP [data-viewcbp=determining_importer]').text(data.cbp.determining_importer);
        $('#modalViewCBP [data-viewcbp=designated_importer]').text(data.cbp.designated_importer);
        $('#modalViewCBP [data-viewcbp=cbp_entry_filer]').text(data.cbp.cbp_entry_filer);
        
        $('#modalViewCBP').modal('show')
    });

    // cbp modal hide event
    $('#modalCBPFiling').on('hidden.bs.modal', function() {
        $('#CBPFilingForm [name=importer]').val('');
    });
    

    // submitting CBP forms
    $('#CBPFilingForm').submit(function(e) {
        e.preventDefault();

        const form = e.target;
        let url = baseUrl + 'newCBPRecord';

        if(form.importer.value == '') {
            CBPFormAlert.setContent('<strong>Error!</strong> Importer not found.').show();
            return;
        }

        const data = new FormData(form);

        var l = Ladda.create(this.querySelector('[type=submit]'));
        l.start();

        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                // update data
                importersData[form.importer.value].cbp = data;
                const updatedData = importersData[form.importer.value];

                renderDTRow(importersData, updatedData, importerListTable, 'modify');
                $('#modalCBPFiling').modal('hide');
                form.reset();
                CBPFormAlert.isShowing() && CBPFormAlert.hide();
                bootstrapGrowl(message || 'Saved!');
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error!', 'danger');
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
                            title: d.email,
                            value: d.id,
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

function fetchImporterListTable(importersData, table) {
    $.ajax({
        url: baseUrl + "fetchImportersForTable",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            if(data) {
                table.dt.clear().draw();
                data.forEach((d) => renderDTRow(importersData, d, table));
                table.dt.draw();
                // fancyBoxes();      
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!');
        },
    });
}

function renderDTRow(importersData, d, table, method = 'add') {
    // save to local storage
    importersData[d.id] = d;
    const importerName = `<span data-importerid="${d.id}">${d.importer.name || '(unnamed)'}</span>`;
    let CBPButtons = '';

    if(d.cbp) {
        CBPButtons = `
            <div class="d-flex center">
                <a href="${(Init.URL || 'fsvp') + '?pdf=cbp&r=' + d.cbp.ihash}" class="btn btn-link btn-sm" target="_blank" data-viewcbpformx="${d.id}">View</a>|
                <button type="button" class="btn btn-link btn-sm" data-opencbpfilingform="${d.id}">Update</button>
            </div>
        `;
    } else {
        CBPButtons = `<button type="button" class="btn green-soft btn-circle btn-sm" data-opencbpfilingform="${d.id}">Open Form</button>`;
    }
    
    const rowData = [
        importerName,
        d.duns_no,
        d.fda_registration,
        `<a href="#" title="View details">${d.fsvpqi.name}</a>`,
        d.evaluation_date,
        CBPButtons,
        `
            <div class="d-flex center">
                <a href="${(Init.URL || 'fsvp') + '?pdf=importer_information&r=' + d.rhash}" class="btn green btn-circle btn-sm" target="_blank">View</a>
            </div>
        `,
    ];

    if(method == 'modify') {
        const index = $(`#tableImporterList tr:has([data-importerid=${d.id}])`).index();
        table.dt.row(index).data(rowData);
    } else if(method == 'add') {
        table.dt.row.add(rowData);
    }
    return table.dt;
}