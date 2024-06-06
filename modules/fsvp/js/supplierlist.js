jQuery(function() {
    let newSupplierFiles = {
        supplier_agreement: {},
        compliance_statement: {},
    }

    let newSupplierFileCounter = 0;
    let newSupplierErrorDisplay = null;
    let suppliersData = {};
    let cachedEvalFormData = null;
    let prevEvalId = null;

    const supplierTable = Init.dataTable('#tableSupplierList', {
        columnDefs: [
            // {
            //     orderable: false,
            //     targets: [-1],
            // },
            // {
            //     searchable: false,
            //     targets: [-1],
            // },
            {
                className: "dt-right",
            },
            {
                className: "text-center",
                targets: [3,4,5] 
            },
            {
                visible: false,
                targets: [2] 
            },
        ]
    });
    const supplierSelect = Init.multiSelect($('.supplierdd'), {
        onChange: function(option, checked, select) {
            const mList = $('#materialListSelection');
            mList.html('');
            mList.append(`<div class="stat-loading"> <img src="assets/global/img/loading.gif" alt="loading"> </div>`);
            $('#materialListHelpBlock').addClass('d-none');

            $.ajax({
                url: baseUrl + "getProductsBySupplier=" + $(option).val(),
                type: "GET",
                contentType: false,
                processData: false,
                success: function({materials}) {
                    if (materials && Array.isArray(materials)) {
                        if (!materials.length) {
                            $('#materialListHelpBlock').text('No materials found.');
                            return;
                        } else {
                            $('#materialListHelpBlock').text('Tick on the checkboxes to select.');
                        }

                        materials.forEach((m) => {
                            const substr = m.description.substring(0, 32);

                            mList.append(`
                                <label class="mt-checkbox mt-checkbox-outline "> ${m.name}
                                    <p title="${m.description}" class="small text-muted" style="padding: 0; margin:0;">${(m.description.length > 32 ? substr + '...' : m.description) || ''}</p>
                                    <input type="checkbox" value="${m.id}" name="food_imported[]"">
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
                    mList.find('.stat-loading').remove();
                    $('#materialListHelpBlock').removeClass('d-none');
                }
            });
        }
    });
    const importerSelect = Init.multiSelect($('#importerSelect'), {
        onChange: function(option, checked, select) {
            const address = $('#importerSelect option:selected').attr('data-address') || '';
            $('#efImporterAddress').val(address);
        }
    });
    const evalFormAlert = Init.createAlert($('#evaluationForm .modal-body'));
    $('.esign').eSign();

    $('#tableSupplierList').on('click', '[data-openevalform]', function() {
        evalFormAlert.isShowing() && evalFormAlert.hide();
        resetEvaluationForm();
        importerSelect.reset();
        openEvaluationForm(suppliersData[this.dataset.eval]);
    });
    
    $('#tableSupplierList').on('click', '[data-openreevalform]', function() {
        const data = suppliersData[this.dataset.eval];

        if(!data) {
            bootstrapGrowl('Unable to fetch data.', 'error');
            return;
        }
        
        switchEvalModalFn('reeval');
        $('#viewPreviousEvalBtn').attr('data-evalid', data.evaluation.id || '')
        prevEvalId = this.dataset.record || '';

        $('#effsname').val(data.evaluation.supplier_name || '');
        $('#effsaddress').val(data.evaluation.supplier_address || '');
        $('#reefimporter').val(data.evaluation.importer_name || '');
        $('#efImporterAddress').val(data.evaluation.importer_address || '');
        $('#evaluationForm input[name="supplier"]').val(data.id || '');
        
        $('#modalEvaluationForm').modal('show');
    });
    
    $('#viewPreviousEvalBtn').on('click', function() {
        fetchEvaluationData(this.dataset.evalid || '', () => {
            $('#modalEvaluationForm').modal('hide');
        }, prevEvalId);
    })

    $('#tableSupplierList').on('click', '[data-opensafile]', function() {
        viewFile(suppliersData, this.dataset.opensafile, 'supplier_agreement');
    });

    $('#tableSupplierList').on('click', '[data-opencsfile]', function() {
        viewFile(suppliersData, this.dataset.opencsfile, 'compliance_statement');
    });

    $('#tableSupplierList').on('click', '[data-view-eval]', function() {
        fetchEvaluationData(this.dataset.viewEval);
    });

    $('#modalEvaluationDetails').on('click', '[data-file]', function() {
        const data = cachedEvalFormData?.files[this.dataset.file];

        if(!data) {
            bootstrapGrowl('Unable to preview file', 'error');
            return;
        }

        const modal = $('#modalEvaluationDetails');
        modal.find('#evalFilename').text(convertStringToTitleCase(this.dataset.file));
        modal.find('[data-evalfile=filename]').text(data.filename);
        modal.find('[data-evalfile=document_date]').text(data.document_date);
        modal.find('[data-evalfile=due_date]').text(data.expiration_date);
        modal.find('#evalFileIframe').prop('src', data.src);
        modal.find('#evalFileIframeAnchor').attr('data-src', data.src);

        if(this.dataset.file == 'suppliers_corrective_actions') {
            modal.find('.evalFileCommentRow').show();
            modal.find('[data-evalfile=note]').text(data.note);
        } else {
            modal.find('.evalFileCommentRow').hide();
        }

        $('#evalFilePreviewPanel').fadeIn();
    });

    $('#modalEvaluationDetails').on('click', '#evalFilePreviewClose', function() {
        $('#evalFilePreviewPanel').fadeOut('linear', function() {
            const modal = $('#modalEvaluationDetails');
            modal.find('[data-evalfile]').text('');
            modal.find('#evalFilename').text('');
            modal.find('#evalFileIframe').prop('src', 'about:blank');
            modal.find('#evalFileIframeAnchor').attr('data-src', '');
            modal.find('.evalFileCommentRow').hide();
            document.getElementById('edStatus').outerHTML = '<span id="edStatus"></span>';
        });
    });

    $('#modalEvaluationDetails').on('hide.bs.modal', function() {
        // close file previews during modal hide
        $('#evalFilePreviewClose').click();
    })

    $('.asFileUpload').change(function() {
        const files = this.files;
        const arrDisplay = $(this).closest('.supplierlist-check').find('.filesArrayDisplay');

        for(let i=0; i<files.length || 0; i++) {
            const file= files[i];
            const item = document.createElement('div');
            const fileId = ++newSupplierFileCounter;

            item.classList.add('fileArrayItem', 'fileRow');
            item.innerHTML = `
                <span class="fileArrayName">
                    <a href="#" target="_blank"></a> 
                    <button type="button" data-id="${fileId}" data-name="${this.dataset.name}" class="btn btn-xs btn-default removeFileButton"><i class="fa fa-close"></i></button>
                </span>
                <input class="form-control fileArrayDates" type="date" data-name="date" data-fileinfoid="${fileId}" required>
                <input class="form-control fileArrayDates" type="date" data-name="exp" data-fileinfoid="${fileId}" required>
                <input class="form-control fileArrayDates" type="text" data-name="note" data-fileinfoid="${fileId}" placeholder="Add note">
            `;

            const anchor = item.querySelector('a');
            anchor.innerText = file.name;

            fetch(URL.createObjectURL(file)).then(r => r.blob()).then(d => {
                d = URL.createObjectURL(d);
                anchor.setAttribute('href', d);
            })

            if(this.dataset.name == 'compliance_statement') {
                arrDisplay.find('.fileRow').remove();
                newSupplierFiles[this.dataset.name] = {};
            }

            arrDisplay.append(item)
            newSupplierFiles[this.dataset.name][fileId] = file;
        }

        this.value = '';
    });

    $('.filesArrayDisplay').on('click', '.removeFileButton', function() {
        const name = this.dataset.name;
        const id = this.dataset.id;

        $(this).closest('.fileArrayItem').fadeOut('linear', function() {
            delete newSupplierFiles[name][id];
            $(this).remove();
        });
    });

    // submit new supplier
    $('#newSupplierForm').submit(function(e) {
        e.preventDefault();
        
        const form = e.target;

        if(!form.supplier.value) {
            return showError('Please select a supplier.');
        }

        if($(form).find('[name="food_imported[]"]').length && !$(form).find('[name="food_imported[]"]:checked').length) {
            return showError('Please select food imported to proceed.');
        }

        if(form.supplier_agreement.value == '1' && !Object.values(newSupplierFiles.supplier_agreement).length) {
            return showError('Please upload supplier agreement document(s).');
        }

        if(form.compliance_statement.value == '1' && !Object.values(newSupplierFiles.compliance_statement).length) {
            return showError('Please upload a compliance statement document.');
        }
        
        // remove error if valid
        if(newSupplierErrorDisplay) {
            $('#modalNewSupplierError').fadeOut();
            clearTimeout(newSupplierErrorDisplay);
            newSupplierErrorDisplay = null;
        }

        // submit to api
        const formData = new FormData(form);
        const btn = form.querySelector('[type=submit]');

        // prepare files
        Object.entries(newSupplierFiles.compliance_statement).forEach(([id, f]) => {
            formData.append('csf_date', $(`input[data-name="date"][data-fileinfoid="${id}"]`).val());
            formData.append('csf_exp', $(`input[data-name="exp"][data-fileinfoid="${id}"]`).val());
            formData.append('csf_note', $(`input[data-name="note"][data-fileinfoid="${id}"]`).val());
            formData.append('compliance_statement_file', f);
        });

        Object.entries(newSupplierFiles.supplier_agreement).forEach(([id, f]) => {
            formData.append('saf_date[]', $(`input[data-name="date"][data-fileinfoid="${id}"]`).val());
            formData.append('saf_exp[]', $(`input[data-name="exp"][data-fileinfoid="${id}"]`).val());
            formData.append('saf_note[]', $(`input[data-name="note"][data-fileinfoid="${id}"]`).val());
            formData.append('supplier_agreement_file[]', f);
        });

        var l = Ladda.create(btn);
        l.start();

        $.ajax({
            url: baseUrl + "newSupplierToList",
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function({data, message}) {
                if(data) {
                    renderDTRow(data).draw();
                }

                supplierSelect.reset();
                form.reset();
                $('#materialListSelection').html('');
                $('#materialListHelpBlock').text('Please select a supplier first.');

                $('#modalNewSupplier').modal('hide');
                bootstrapGrowl(message || 'Saved!');
            },
            error: function() {
                bootstrapGrowl('Error!', 'danger');
            },
            complete: function() {
                l.stop();
            }
        });
    });

    // viewing individual files while modal popped out
    $('#viewFileList').on('click', '.viewFileAnchor', function() {
        try {
            if(this.closest('.mt-list-item').classList.contains('done')) {
                // disable click repeat on the item itself
                return;
            }
            
            // cancelling the form
            $('#vfCancelBtn').click();
            
            const fileData= suppliersData[this.dataset.id][this.dataset.type][this.dataset.index];
            $('#viewFileList .done').removeClass('done');
            this.closest('.mt-list-item').classList.add('done');
            showFileInfo(fileData);
        } catch(err) {
            console.error(err)
        }
    });

    // file modal buttons
    $('#vfUpdateBtn').click(function() {
        $('#viewFileInfoForm').toggleClass('is-update');
    });

    $('#vfCancelBtn').click(function() {
        $('#viewFileInfoForm').removeClass('is-update');
    });

    $('#vfRemoveBtn').click(function() {
        swal(
            {
                title: `Do you really wish to remove this file?`,
                type: "warning",
                allowOutsideClick: false,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonClass: "btn red",
                cancelButtonClass: "btn default",
                closeOnConfirm: true,
                closeOnCancel: true,
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel",
            },
            function (isConfirm) {
                if (isConfirm) {
          
                    console.log('file removed')
                }
            }
        );
    });
    // end of file modal buttons

    // resetting modal display
    $('#modalViewFiles').on('hidden.bs.modal', function() {
        const fileInfoForm = document.querySelector('#viewFileInfoForm');

        // input fields
        fileInfoForm.note.value = '';
        fileInfoForm.document_date.value = '';
        fileInfoForm.expiration_date.value = '';

        // info display
        $(fileInfoForm).find('span[data-view-info=filename]').text('');

        $('.file-viewer').attr('src', 'about:blank');
        $('.view-anchor').attr('data-src', 'about:blank');
    });

    // evaluation form radio buttons
    $('.ynDocsUpl input[type=radio]').on('change', function() {
        const container = this.closest('.ynDocsUpl');
        const isDisabled = this.checked && this.value == 0;
        
        if(isDisabled) {
            const file = $(container).find('input[type=file]').get(0);

            if(file.files.length > 0) {
                swal(
                    {
                        title: `You will lose the uploaded file...`,
                        type: "warning",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonClass: "btn blue",
                        cancelButtonClass: "btn default",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        confirmButtonText: "It's OK",
                        cancelButtonText: "Cancel",
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $(container).find('.form-control').val('').prop('disabled', true).prop('required', false);
                        } else {
                            // cancelled, recheck yes option
                            $(container).find('input[type=radio][value=1]').prop('checked', true);
                        }
                    }
                );
            } else {
                $(container).find('.form-control').val('').prop('disabled', true).prop('required', false);
            }
        } else {
            $(container).find('.form-control').prop('disabled', false).prop('required', true);
        }
        
    });

    $('#evaluationForm').submit(function(e) {
        e.preventDefault();

        const form = e.target;
        let url = baseUrl;

        if(prevEvalId === null && form.importer.value == '') {
            evalFormAlert.isShowing() && evalFormAlert.hide();
            evalFormAlert.setContent('<strong>Error!</strong> Importer is required.').show();
            return;
        }

        const data = new FormData(form);

        var l = Ladda.create(this.querySelector('[type=submit]'));
        l.start();

        if(prevEvalId !== null) {
            data.append('prev_record_id', prevEvalId);
            url += "supplierReEvaluation";
        } else {
            url += "newSupplierEvaluation";
        }

        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({data, message}) {
                if(data) {
                    suppliersData[form.supplier.value] && (suppliersData[form.supplier.value].evaluation = data);
                    renderDTRow(suppliersData[form.supplier.value], 'data').draw();
                }

                $('#modalEvaluationForm').modal('hide');
                resetEvaluationForm();
                importerSelect.reset();
                evalFormAlert.isShowing() && evalFormAlert.hide();

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

    $('#modalEvaluationForm').on('hidden.bs.modal', () => {
        prevEvalId = null;
        switchEvalModalFn();
    });
    
    function initSuppliers() {
        $.ajax({
            url: baseUrl + "suppliersByUser",
            type: "GET",
            contentType: false,
            processData: false,
            success: function({data}) {
                if(data) {
                    supplierTable.dt.clear().draw();
                    data.forEach((d) => renderDTRow(d));
                    supplierTable.dt.draw();
                    // fancyBoxes();      
                }
            },
            error: function() {
                bootstrapGrowl('Error fetching records!');
            },
        });
    }

    function renderDTRow(d, method = 'add') {
        // save to local storage
        suppliersData[d.id] = d;
        const no = `<span style="font-weight:600;">No</span>`;
        const sa = !d.supplier_agreement || !d.supplier_agreement.length ? no : `<a href="javascript:void(0)" data-opensafile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View</a>`;
        const cs = !d.compliance_statement || !d.compliance_statement.length ?  no : `<a href="javascript:void(0)" data-opencsfile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View </a>`;
        let evalBtn = '';

        console.log(suppliersData[d.id]);

        switch(d.evaluation?.status) {
            case 'current': 
                evalBtn = `<a href="javascript:void(0)" class="font-dark semibold" data-view-eval="${d.evaluation.id}" title="Click to view evaluation details"> 
                                ${d.evaluation.evaluation_date}
                                <i class="fa fa-check-circle font-green-jungle" style="margin-left:.75rem"></i>
                            </a>`;
                break;
            case 'expired': 
                evalBtn = `<button type="button" class="btn red btn-sm btn-circle" title="Re-evaluate" data-reeval="true" data-openreevalform data-eval="${d.id}" data-record="${d.evaluation.record_id}">
                                Re-evaluate
                            </button>`;
                break;
            default: 
                evalBtn = `<button type="button" class="btn green btn-sm btn-circle" title="Evaluation form" data-openevalform data-eval="${d.id}">
                                <i class="fa fa-search icon-margin-right"></i> Evaluate
                            </button>`;
                break;
        }
        const rowData = [
            d.name,
            d.food_imported.map((x) => x.name).join(', '),
            d.address,
            evalBtn,
            sa,
            cs,
            // `
            //     <div class="d-flex center">
            //         <div class="btn-group btn-group-circle btn-group-sm btn-group-solid hide">
            //             <button type="button" class="btn dark btn-outline btn-circle btn-smx" title="View data">View</button>
            //         </div>
            //         <button type="button" class="btn dark btn-outline btn-circle btn-sm" title="View data">View</button>
            //     </div>
            // `,
        ];
        
        if(method == 'data') {
            const index = $(`#tableSupplierList tr:has([data-eval=${d.id}])`).index();
            supplierTable.dt.row(index).data(rowData);
        } else if(method == 'add') {
            supplierTable.dt.row.add(rowData);
        }

        return supplierTable.dt;
    }
    
    function showError(message = "Unable to proceed submit action.") {
        const errorEl = $('#modalNewSupplierError');

        if(newSupplierErrorDisplay) {
            clearTimeout(newSupplierErrorDisplay);
            newSupplierErrorDisplay = null;
        }

        if(!message) {
            errorEl.fadeOut();
            return
        }
        
        const messageEl = $('#modalNewSupplierMessage');
        messageEl.text(message);
        errorEl.fadeIn('linear', function() {
            newSupplierErrorDisplay = setTimeout(() => {
                errorEl.fadeOut();
                newSupplierErrorDisplay = null;
            }, 5000);
        });
    }

    function fetchEvaluationData(id, callback = null, recordId = null) {
        if(!id) {
            bootstrapGrowl('Missing data.', 'error');
            return;
        } else if(cachedEvalFormData && cachedEvalFormData.id == id) {
            // reuse data
            viewEvaluationDetails(cachedEvalFormData);
            return;
        }

        $.ajax({
            url: baseUrl + "viewEvaluationData=" + id + (recordId ? ('&r=' + recordId) : ''),
            type: "GET",
            contentType: false,
            processData: false,
            success: function({data}) {
                cachedEvalFormData = data;
                callback && callback();
                viewEvaluationDetails(data);
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON.error || 'Error fetching data!', 'danger');
            },
        });
    }

    // init
    resetEvaluationForm();
    initSuppliers();
    switchEvalModalFn();
});

// truncrate string into desired maximum length
function trunc(str, length = 12) {
    const newStr = str.slice(0, length);
    return newStr + (str.length > length ? '...' : '');
}

// viewing files
function viewFile(data, id, fileType) {
    const fileData= data[id][fileType]

    if(!fileData) {
        bootstrapGrowl('File(s) not found.')
        return;
    }
    
    let label = 'Unknown';
    switch(fileType) {
        case 'supplier_agreement': label = 'Supplier Agreement'; break;
        case 'compliance_statement': label = 'Compliance Statement'; break;
    }

    $('#viewFileTitle').text(label)

    const fileListContainer = $('#viewFileList');
    fileListContainer.html('')
    fileData.forEach((f, i) => {
        fileListContainer.append(`
            <li class="mt-list-item">
                <div class="list-item-content" style="padding: 0;">
                    <h5 style="margin: 0;">
                        <a class="viewFileAnchor" href="javascript:void(0)" data-type="${fileType}" data-id="${id}" data-index="${i}">${f.filename}</a>
                    </h5>
                </div>
            </li>
        `);
    })

    $('#viewFileList .mt-list-item:first-child .viewFileAnchor').click();
    $('#modalViewFiles').modal('show')
}

// showing individual file info
function showFileInfo(fileInfo) {
    try {
        const fileInfoForm = document.querySelector('#viewFileInfoForm');

        // input fields
        fileInfoForm.note.value = fileInfo.note;
        fileInfoForm.document_date.value = fileInfo.document_date;
        fileInfoForm.expiration_date.value = fileInfo.expiration_date;

        // info display
        $(fileInfoForm).find('[data-view-info=filename]').text(fileInfo.filename);
        $(fileInfoForm).find('[data-view-info=document_date]').text(fileInfo.document_date);
        $(fileInfoForm).find('[data-view-info=expiration_date]').text(fileInfo.expiration_date);
        $(fileInfoForm).find('[data-view-info=note]').text(fileInfo.note);
        $(fileInfoForm).find('[data-view-info=upload_date]').text(fileInfo.upload_date);

        $('.file-viewer').attr('src', fileInfo.src);
        $('.view-anchor').attr('data-src', fileInfo.src);
    } catch(err) {
        console.error(err)
        bootstrapGrowl('Error reading data.', 'error')
    }
}

// opening the evaluation form
function openEvaluationForm(data) {
    if(!data) {
        bootstrapGrowl('Error reading data.', 'error');
        return;
    }

    $('#effsaddress').val(data.address || '')
    $('#effsname').val(data.name || '')
    $('#evaluationForm input[name="supplier"]').val(data.id || '');
    
    $('#modalEvaluationForm').modal('show');
}

// basically triggering reset
function resetEvaluationForm() {
    const form = $('#evaluationForm');
    // initially reset all fields
    form.get(0).reset();
    // to disable upload fields, simmulate "no" option
    $('.ynDocsUpl input[type=radio][value=0]').prop('checked', true).trigger('change');
    // to reset the radio buttons
    form.get(0).reset();
}

function viewEvaluationDetails(data) {
    const modal = $('#modalEvaluationDetails');
    const viewFileBtn = (file) => {
        return `<a href="javascript:void(0)" data-file="${file}" title="View details"><i class="fa fa-file-text-o icon-margin-right"></i>View</a>`;
    }
    const no = `<strong>No</strong>`;
    const none = `<i class="text-muted small">(None)</i>`;
    const statusBadge = document.getElementById('edStatus');

    switch(data.status) {
        case 'current': statusBadge.outerHTML = `<span class="label label-success" id="edStatus"> current </span>`; break;
        case 'expired': statusBadge.outerHTML = `<span class="label label-danger" id="edStatus"> expired </span>`; break;
        default: statusBadge.outerHTML = `<span id="edStatus"></span>`; break;
    }

    modal.find('[data-ed=importer]').text(data.importer_name);
    modal.find('[data-ed=date]').text(data.evaluation_date);
    modal.find('[data-ed=supplier]').text(data.supplier_name);
    modal.find('[data-ed=supplier_address]').text(data.supplier_address);
    modal.find('[data-ed=food_products_description]').html(data.description || none);
    modal.find('[data-ed=spp]').html(data.sppp || none);

    let fpStr = ``;
    if(data.food_imported && Array.isArray(data.food_imported)) {
        fpStr = `<ul style="margin:0;">`;
        data.food_imported.forEach(d => {
            fpStr += `<li class="liFP" title="${d.description}">${d.name}</li>`;
        })
        fpStr += `</ul>`;
    }
    modal.find('[data-ed=food_products]').html(fpStr);
    

    modal.find('[data-ed=import_alerts]').html(data.import_alerts == 1 ? viewFileBtn('import_alerts') : no);
    modal.find('[data-ed=recalls]').html(data.recalls == 1 ? viewFileBtn('recalls') : no);
    modal.find('[data-ed=warning_letters]').html(data.warning_letters == 1 ? viewFileBtn('warning_letters') : no);
    modal.find('[data-ed=osca]').html(data.other_significant_ca == 1 ? viewFileBtn('other_significant_ca') : no);
    modal.find('[data-ed=suppliers_ca]').html(data.suppliers_corrective_actions == 1 ? viewFileBtn('suppliers_corrective_actions') : no);

    modal.find('[data-ed=info_related]').html(data.info_related || none);
    modal.find('[data-ed=rejection_date]').html(data.rejection_date || none);
    modal.find('[data-ed=approval_date]').html(data.approval_date || none);
    modal.find('[data-ed=assessment]').html(data.assessment || none);

    modal.modal('show');
}

function convertStringToTitleCase(str) {
    return str.replace(/(_|\b)(\w)/g, function(m, pre, char) {
        return (pre === '_' ? ' ' : pre) + char.toUpperCase();
    });
}

function switchEvalModalFn(mode = 'eval') {
    $(`#modalEvaluationForm [data-efm]:not([data-efm=${mode}])`).hide();
    $(`#modalEvaluationForm [data-efm=${mode}]`).show();
}