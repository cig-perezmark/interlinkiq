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
    let editDetailsTRIndex = null;
    let tempId = 1;

    let supplierTable = Init.dataTable('#tableSupplierList', {
        columnDefs: [
            {
                className: "dt-right",
            },
            {
                className: "text-center",
                targets: [3,4] 
            },
        ]
    });
    const supplierSelect = Init.multiSelect($('.supplierdd'), {
        onChange: function(option) {
            supplierDdOnchange($(option).val() || null);
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
    $('.signature__.display').prop('src', '#').css('display', 'none'); // reset signature display

    $('#tableSupplierList').on('click', '[data-openevalform]', function() {
        const data = suppliersData[this.dataset.eval];

        if(!data) {
            bootstrapGrowl('Unable to fetch data.', 'error');
            return;
        }

        evalFormAlert.isShowing() && evalFormAlert.hide();
        resetEvaluationForm();
        importerSelect.reset();

        editDetailsTRIndex = this.closest('tr');
        $('#evaluationForm [name="eval"]').val(data.id);

        $('#effsname').val(data.supplier_name || '');
        $('#effsaddress').val(data.supplier_address || '');
        $('#reefimporter').val(data.importer_name || '');
        $('#efImporterAddress').val(data.importer_address || '');
        $('#evaluationForm input[name="supplier"]').val(data.supplier_id || '');
        $('#evaluationForm input[name="importer"]').val(data.importer_id || '');
        $('#modalEvaluationForm').modal('show');
    });
    
    $('#tableSupplierList').on('click', '[data-openreevalform]', function() {
        const data = suppliersData[this.dataset.eval];

        if(!data) {
            bootstrapGrowl('Unable to fetch data.', 'error');
            return;
        }
        
        switchEvalModalFn('reeval');
        $('#viewPreviousEvalBtn').attr('data-evalid', data.evaluation.id || '')
        $('#evaluationForm [name="eval"]').val(data.id);
        prevEvalId = this.dataset.record || '';
        editDetailsTRIndex = this.closest('tr');

        $('#effsname').val(data.supplier_name || '');
        $('#effsaddress').val(data.supplier_address || '');
        $('#reefimporter').val(data.importer_name || '');
        $('#efImporterAddress').val(data.importer_address || '');
        $('#evaluationForm input[name="supplier"]').val(data.supplier_id || '');
        $('#evaluationForm input[name="importer"]').val(data.importer_id || '');
        
        $('#modalEvaluationForm').modal('show');
    });
    
    $('#viewPreviousEvalBtn').on('click', function() {
        fetchEvaluationData(this.dataset.evalid || '', () => {
            $('#modalEvaluationForm').modal('hide');
        }, prevEvalId);
    })
    $('[data-eval-list-id]').on('click', function() {
        // fetchEvaluationData(this.dataset.eval || '', () => {
        //     $('#modalEvaluationRecap').modal('hide');
        // }, this.dataset.evalListId);
        
        let id = this.dataset.eval;
        let recordId = this.dataset.evalListId;
        
        $.ajax({
            url: baseUrl + "viewEvaluationData=" + id + (recordId ? ('&r=' + recordId) : ''),
            type: "GET",
            contentType: false,
            processData: false,
            success: function({data}) {
                // cachedEvalFormData = data;
                // callback && callback();
                viewEvaluationDetails(data);
                $('#modalEvaluationRecap').modal('hide');
            },
            error: function({responseJSON}) {
                bootstrapGrowl(responseJSON?.error || 'Error fetching data!', 'danger');
            },
        });
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

    $('#tableSupplierList').on('click', '[data-edit-foreign-supplier]', function() {
        const supplierId = this.dataset.editForeignSupplier;
        
        supplierSelect.reset();
        $('#materialListSelection').html('');
        $('#materialListHelpBlock').text('Please select a supplier first.');
        $('#newSupplierForm [name=fsvp_supplier_id]').val('');
        $('#newSupplierForm [name=supplier]').val(supplierId);
        $('#fsName').val(this.dataset.fsname || '');
        
        // simulate multiselect dropdown selectopn
        supplierDdOnchange(supplierId);
        $(`.supplierdd`).multiselect('select', [supplierId]);
        editDetailsTRIndex = this.closest('tr');
        $('#modalNewSupplier').modal('show');
    });

    $('#tableSupplierList').on('click', '[data-update-foreign-supplier]', function() {
        const fsvpSupplierId = this.dataset.updateForeignSupplier;
        const data = suppliersData[fsvpSupplierId];
        
        const hasSupplierAgreementFiles = data.supplier_agreement.length > 0;
        const hasComplianceStatementFiles = data.compliance_statement.length > 0;   
        
        supplierSelect.reset();
        $('#materialListSelection').html('');
        $('#materialListHelpBlock').text('Please select a supplier first.');
        $('#newSupplierForm [name=fsvp_supplier_id]').val(data.id);

        $('#newSupplierForm [name=supplier]').val(data.supplier_id);
        $('#fsName').val(data.name || '');

        // uncheck options by default
        $('#modalNewSupplier .supplierlist-check :where(input[name="supplier_agreement"], input[name="compliance_statement"])').prop('checked', false);

        // enable files 
        if(hasSupplierAgreementFiles) {
            const container = $('#modalNewSupplier .supplierlist-check input[name="supplier_agreement"]').closest('.supplierlist-check').find('.filesArrayDisplay');
            $('#modalNewSupplier .supplierlist-check input[name="supplier_agreement"][value="1"]').prop('checked', true);            
            createUploadedFilesRowInSupplierModal(container, data.supplier_agreement, 'supplier_agreement');
        } else {
            $('#modalNewSupplier .supplierlist-check input[name="supplier_agreement"][value="0"]').prop('checked', true);
        }

        if(hasComplianceStatementFiles) {
            const container = $('#modalNewSupplier .supplierlist-check input[name="compliance_statement"]').closest('.supplierlist-check').find('.filesArrayDisplay');
            $('#modalNewSupplier .supplierlist-check input[name="compliance_statement"][value="1"]').prop('checked', true);
            createUploadedFilesRowInSupplierModal(container, data.compliance_statement, 'compliance_statement')
        } else {
            $('#modalNewSupplier .supplierlist-check input[name="compliance_statement"][value="0"]').prop('checked', true);
        }
        
        // simulate multiselect dropdown selectopn
        supplierDdOnchange(data.supplier_id, data.id);
        $(`.supplierdd`).multiselect('select', [data.supplier_id]);
        editDetailsTRIndex = this.closest('tr');
        $('#modalNewSupplier').modal('show');
    });

    $('#modalEvaluationDetails').on('click', '[data-file]', function() {
        const data = cachedEvalFormData?.files[this.dataset.file];
        console.log(data);

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
        Init.idFancyBoxType(data.src, modal.find('#evalFileIframeAnchor'));

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
            $('.signature__.display').prop('src', '#').css('display', 'none'); // reset signature display
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
        
        console.log(form)
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
                initSuppliers();
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

        // signatures
        data.append('preparer_sign', $('#preparer_signature').eSign("getData"));
        data.append('reviewer_sign', $('#reviewer_signature').eSign("getData"));
        data.append('approver_sign', $('#approver_signature').eSign("getData"));

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
                    suppliersData[form.eval.value] && (suppliersData[form.eval.value].evaluation = data);
                    renderDTRow(suppliersData[form.eval.value], 'data').draw();
                }

                $('#modalEvaluationForm').modal('hide');
                resetEvaluationForm();
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
        $('.signature__').eSign('destroy');
    });

    $('#modalEvaluationForm').on('show.bs.modal', () => {
        $('.signature__').eSign();
    });

    $('#toggleEvaluationBtn').click(function() {
        $('#viewEvaluationsCheck').click();
    });

    $('#viewEvaluationsCheck').on('change', function() {
        const btnLabel = $('#toggleEvaluationBtn span[data-label]');
        if(this.checked) {
            btnLabel.text("View Suppliers List");
            // viewing supplier evaluation data
            initEvaluations();
        } else {
            btnLabel.text("View Evaluations Data");
            initSuppliers();
        }
    });

    // reset supplier modal
    $('#modalNewSupplier').on('hidden.bs.modal', function() {
        $('#modalNewSupplier input[type=checkbox').prop('checked', false); // uncheck doocument uploads
        $('#modalNewSupplier .filesArrayDisplay .fileRow').remove(); // reset uploaded rows

        // reset file storage
        newSupplierFiles = {
            supplier_agreement: {},
            compliance_statement: {},
        }
    });

    function createUploadedFilesRowInSupplierModal(container, files, nameAttr) {
        // reset rows
        container.find('.fileRow').remove();
        
        files.forEach(file => {
            const fileId = 'forUpdate-' + file.id; 
            const item = document.createElement('div');
            item.classList.add('fileArrayItem', 'fileRow');
            item.innerHTML = `
                <span class="fileArrayName">
                    <a href="#">${file.filename}</a> 
                    <button type="button" data-id="${fileId}" data-name="${nameAttr}" class="btn btn-xs btn-default removeFileButton"><i class="fa fa-close"></i></button>
                </span>
                <input class="form-control fileArrayDates" type="date" data-name="date" data-fileinfoid="${fileId}" required value="${file.document_date}">
                <input class="form-control fileArrayDates" type="date" data-name="exp" data-fileinfoid="${fileId}" required value="${file.expiration_date}">
                <input class="form-control fileArrayDates" type="text" data-name="note" data-fileinfoid="${fileId}" placeholder="Add note" value="${file.note}">
            `;

            container.append(item)
            newSupplierFiles[nameAttr][fileId] = file.id;
        })
    }

    function refreshSupplierDT(headers, centerColumns) {
        // destroy datatable
        $('#fstToolbar').append($('#toggleEvaluationBtn').attr('class', 'dt-button buttons-collection').hide());
        $('#tableSupplierList').empty();
        supplierTable.dt.destroy();
        suppliersData = [];

        // setting new headers
        $('#tableSupplierList thead').html(headers);

        // re initialize
        supplierTable = Init.dataTable('#tableSupplierList', {
            columnDefs: [
                {
                    className: "dt-right",
                },
                {
                    className: "text-center",
                    targets: centerColumns 
                },
                {
                    orderable: false,
                    targets: [-1],
                },
                {
                    searchable: false,
                    targets: [-1],
                },
            ]
        });
        $('.dataTables_wrapper .dt-buttons').append($('#toggleEvaluationBtn').attr('class', 'dt-button buttons-collection').show())
    }
    
    function initSuppliers() {     
        refreshSupplierDT(`
            <tr>
                <th>Supplier Name</th>
                <th>Address</th>
                <th>Food Imported</th>
                <th style="max-width: 80px">Supplier Agreement</th>
                <th style="max-width: 80px;">FSVP Compliance Statement</th>
                <th>Action</th>
            </tr>
        `, [3,4,-1]);

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

    function initEvaluations() {
        refreshSupplierDT(`
            <tr>
                <th>Supplier Name</th>
                <th>Importer</th>
                <th>Status</th>
                <th>Last Evaluation</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        `, [2,3,4,-1]);

        $.ajax({
            url: baseUrl + "evaluationsByUser",
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
        if(!d.id) {
            // create a temporary id when null
            tempId++;
        }
        const temporaryRecordId = 'temp_id_' + tempId;
        // save to local storage
        suppliersData[d.id || temporaryRecordId] = d;

        const no = `<span style="font-weight:600;">No</span>`;
        const na = '<i class="text-muted">(N/A)</i>';
        let evalBtn = '';
        let rowData = [];

        if($('#viewEvaluationsCheck').prop('checked') == true) {
            let status = '';
            // displaying evaluations data
            switch(d.evaluation?.status) {
                case 'current': 
                    evalBtn = `
                        <div class="d-flex center">
                            <div class="btn-group btn-group-circle btn-group-sm btn-group-solid">
                                <button type="button" class="btn btn-outline btn-sm blue" data-view-eval="${d.id}" title="View data">View</button>
                                <button type="button" class="btn btn-outline btn-sm green" data-toggle="modal" href="#modalEvaluationRecap" onclick="btnEvalRecap(${d.id})">List</button>
                                <a href="${(Init.URL || 'fsvp') + '?pdf=evaluation_form&r=' + d.rhash}" target="_blank" class="btn btn-sm dark" title="PDF Document">PDF</a>
                            </div>
                        </div>
                    `;
                    status = `<span class="badge badge-success">current</span>`;
                    break;
                case 'expired': 
                    evalBtn = `
                        <div class="d-flex center">
                            <div class="btn-group btn-group-circle btn-group-sm btn-group-solid">
                                <button type="button" class="btn red btn-sm btn-circle btn-outline" title="Re-evaluate" data-reeval="true" data-openreevalform data-eval="${d.id}" data-record="${d.evaluation.record_id}">Eval.</button>
                                <a href="${(Init.URL || 'fsvp') + '?pdf=evaluation_form&r=' + d.rhash}" target="_blank" class="btn dark btn-circle btn-sm" title="PDF Document">PDF</a>
                            </div>
                        </div>
                    `;
                    status = `<span class="badge badge-danger">expired</span>`;
                    break;
                default: 
                    evalBtn = `
                        <div class="d-flex center">
                            <button type="button" class="btn green btn-sm btn-circle" title="Evaluation form" data-openevalform="${temporaryRecordId}" data-eval="${d.id}">
                                <i class="fa fa-search icon-margin-right"></i> Evaluate
                            </button>
                        </div>
                    `;
                    status = na;
                    break;
            }
            
            rowData = [
                d.supplier_name,
                d.importer_name,
                status,
                d.evaluation?.evaluation_date || na,
                d.evaluation?.evaluation_due_date || na,
                evalBtn,
            ];
        } else {
            const sa = !d.supplier_agreement || !d.supplier_agreement.length ? no : `<a href="javascript:void(0)" data-opensafile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View</a>`;
            const cs = !d.compliance_statement || !d.compliance_statement.length ?  no : `<a href="javascript:void(0)" data-opencsfile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View </a>`;

            // data is an fsvp supplier
            if(d.id) {
                evalBtn = `
                    <div class="d-flex center">
                        <div class="btn-group btn-group-circle btn-group-sm btn-group-solid">
                            <button type="button" class="btn green btn-sm btn-circle btn-outline" data-update-foreign-supplier="${d.id}">Edit</button>
                            <a href="${(Init.URL || 'fsvp') + '?pdf=report&r=' + d.rhash}" target="_blank" class="btn dark btn-sm btn-circle" data-update-foreign-supplierx="${d.id}" title="Generate Report">
                                <i class="fa fa-download icon-margin-right"></i>
                                PDF
                            </a>
                        </div>
                    </div>
                `;
            } else {
                evalBtn = `
                    <div class="d-flex center">
                        <button type="button" class="btn green btn-sm btn-circle" data-edit-foreign-supplier="${d.supplier_id}" data-fsname="${d.name}">Edit</button>
                    </div>
                `;
            }
        
            // displaying suppliers list
            rowData = [
                d.name,
                d.address,
                d.id ? d.food_imported.map((x) => x.name).join(', ') : na,
                d.id ? sa : na,
                d.id ? cs : na,
                evalBtn,
            ];
        }
        
        if(method == 'data') {
            supplierTable.dt.row(editDetailsTRIndex).data(rowData);
            editDetailsTRIndex = null;
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
                bootstrapGrowl(responseJSON?.error || 'Error fetching data!', 'danger');
            },
        });
    }

    function supplierDdOnchange(supplierId, existingFSVPSupplierId = null) {
        const mList = $('#materialListSelection');
        mList.html('');
        mList.append(`<div class="stat-loading"> <img src="assets/global/img/loading.gif" alt="loading"> </div>`);
        $('#materialListHelpBlock').addClass('d-none');

        $.ajax({
            url: baseUrl + "raw=true&getProductsByForeignSupplier=" + supplierId + (existingFSVPSupplierId ? ("&fsvpSupplier=" + existingFSVPSupplierId) : ""),
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
                        const isChecked = m.selected == 'true' ? 'checked' : '';
                        const isLocked = m.locked == 'true' ? 'disabled' : '';
                        const lockedCheckbox = m.locked == 'true' ? `<input type="checkbox" value="${m.id}" name="food_imported[]" checked style="display:none;">` : '';
                        const lockedTitle = m.locked == 'true' ? 'title="This product has been used by importer(s). You cannot unselect this."' : '';

                        mList.append(`
                            <label class="mt-checkbox mt-checkbox-outline" ${m.locked == 'true' ? 'style="cursor: not-allowed;"' : ''} ${lockedTitle}> ${m.name}
                                <p title="${m.description}" class="small text-muted" style="padding: 0; margin:0;">${(m.description.length > 32 ? substr + '...' : m.description) || ''}</p>
                                <input type="checkbox" value="${m.id}" name="food_imported[]" ${isChecked + ' ' + isLocked}>
                                ${lockedCheckbox}
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

        editDetailsTRIndex = null;
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
        Init.idFancyBoxType(fileInfo.src, $('.view-anchor'));
    } catch(err) {
        console.error(err)
        bootstrapGrowl('Error reading data.', 'error')
    }
}

function repopulateImporterSelect(supplierId) {
    $.ajax({
        url: Init.baseUrl + "fetchImporterBySupplier=" + (supplierId || 0) ,
        type: "GET",
        contentType: false,
        processData: false,
        success: function({result}) {
            if(result) {
                const options = [{
                    label: result.length ? 'Select an importer' : 'No data available.',
                    title: result.length ? 'Select an importer' : 'No data available.',
                    value: '',
                    selected: true,
                    disabled: true,
                }];

                Object.values(result).forEach((d) => {
                    options.push({
                        label: d.name,
                        title: d.namme,
                        value: d.id,
                        attributes: {
                            address: d.address
                        }
                    });
                });    

                $('#importerSelect').multiselect('dataprovider', options);
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching data.');
        },
    });
}
function btnEvalRecap(id) {
	$.ajax({
		type: "GET",
        url: Init.baseUrl + "btnEvalRecap=" + (id || 0) ,
		dataType: "html",
		success: function(data){
		    $('#modalEvaluationRecap .modal-body').html(data);
		}
	});
}

// opening the evaluation form
function openEvaluationForm(data) {
    if(!data) {
        bootstrapGrowl('Error reading data.', 'error');
        return;
    }

    $('#effsaddress').val(data.supplier_address || '')
    $('#effsname').val(data.supplier_name || '')
    $('#evaluationForm input[name="supplier"]').val(data.supplier_id || '');

    $('#effsname').val(data.evaluation.supplier_name || '');
    $('#effsaddress').val(data.evaluation.supplier_address || '');
    $('#reefimporter').val(data.evaluation.importer_name || '');
    $('#efImporterAddress').val(data.evaluation.importer_address || '');

    // set importer dropdown items to importers under the selected supplier
    repopulateImporterSelect(data.supplier_id);
    
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

// Generating Evaluation Details Content
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

    modal.find('[data-ed=approved_by]').text(data.approved_by || '(None)');
    modal.find('[data-ed=approve_date]').text(data.approve_date || '(None)');
    modal.find('[data-ed=reviewed_by]').text(data.reviewed_by || '(None)');
    modal.find('[data-ed=review_date]').text(data.review_date || '(None)');
    modal.find('[data-ed=prepared_by]').text(data.prepared_by || '(None)');
    modal.find('[data-ed=prepare_date]').text(data.prepare_date || '(None)');
    modal.find('[data-ed=comments]').text(data.comments || '(None)');
    
    if(data.prepared_by_sign) {
        $('#preparer_signature_display').prop('src', data.prepared_by_sign).css('display', 'inline-block');
    }
    
    if(data.reviewed_by_sign) {
        $('#reviewer_signature_display').prop('src', data.reviewed_by_sign).css('display', 'inline-block');
    }

    if(data.approved_by_sign) {
        $('#approver_signature_display').prop('src', data.approved_by_sign).css('display', 'inline-block');
    }
    
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
    modal.find('[data-ed=osca]').html(data.other_significant_ca == 1 ? viewFileBtn('other_sca') : no);
    console.log(data)
    modal.find('[data-ed=suppliers_ca]').html(data.suppliers_corrective_actions == 1 ? viewFileBtn('supplier_corrective_actions') : no);

    modal.find('[data-ed=info_related]').html(data.info_related || none);
    modal.find('[data-ed=rejection_date]').html(data.rejection_date || none);
    modal.find('[data-ed=approval_date]').html(data.approval_date || none);
    modal.find('[data-ed=assessment]').html(data.assessment || none);

    // update view ppdf button
    $('#pdfEvaluationForm').attr('href', (Init.URL || 'fsvp') + '?pdf=evaluation_form&r=' + data.rhash);

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
function btnOpenReEval(){
    const data = suppliersData[this.dataset.eval];

    if(!data) {
        bootstrapGrowl('Unable to fetch data.', 'error');
        return;
    }
    
    switchEvalModalFn('reeval');
    $('#viewPreviousEvalBtn').attr('data-evalid', data.evaluation.id || '')
    $('#evaluationForm [name="eval"]').val(data.id);
    prevEvalId = this.dataset.record || '';
    editDetailsTRIndex = this.closest('tr');

    $('#effsname').val(data.supplier_name || '');
    $('#effsaddress').val(data.supplier_address || '');
    $('#reefimporter').val(data.importer_name || '');
    $('#efImporterAddress').val(data.importer_address || '');
    $('#evaluationForm input[name="supplier"]').val(data.supplier_id || '');
    $('#evaluationForm input[name="importer"]').val(data.importer_id || '');
    
    $('#modalEvaluationForm').modal('show');
}
function evallist(id, recordId) {
    
    // let id = this.dataset.eval;
    // let recordId = this.dataset.evalListId;
    
    $.ajax({
        url: baseUrl + "viewEvaluationData=" + id + (recordId ? ('&r=' + recordId) : ''),
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            // cachedEvalFormData = data;
            // callback && callback();
            viewEvaluationDetails(data);
            // $('#modalEvaluationRecap').modal('hide');
        },
        error: function({responseJSON}) {
            bootstrapGrowl(responseJSON?.error || 'Error fetching data!', 'danger');
        },
    });
}