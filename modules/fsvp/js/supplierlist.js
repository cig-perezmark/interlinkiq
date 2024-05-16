jQuery(function() {
    let newSupplierFiles = {
        supplier_agreement: {},
        compliance_statement: {},
    }

    let newSupplierFileCounter = 0;
    let newSupplierErrorDisplay = null;
    let supplierTable = null;
    let suppliersData = {};

    supplierTable = Init.dataTable('#tableSupplierList', {
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
                className: "text-center",
                targets: [4,5] 
            },
            {
                visible: false,
                targets: [2] 
            },
        ]
    });

    initSuppliers();
    
    Init.multiSelect($('.supplierdd'), {
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

    $('#tableSupplierList').on('click', '[data-openevalform]', function() {
        openEvaluationForm(suppliersData[this.dataset.openevalform]);
    });

    $('#tableSupplierList').on('click', '[data-opensafile]', function() {
        viewFile(suppliersData, this.dataset.opensafile, 'supplier_agreement');
    });

    $('#tableSupplierList').on('click', '[data-opencsfile]', function() {
        viewFile(suppliersData, this.dataset.opencsfile, 'compliance_statement');
    });

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

                $(form.supplier).val('').trigger('change');
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
    })

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

    function renderDTRow(d) {
        // save to local storage
        suppliersData[d.id] = d;
        const no = `<span style="font-weight:600;">No</span>`;
        const sa = !d.supplier_agreement || !d.supplier_agreement.length ? no : `<a href="javascript:void(0)" data-opensafile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View</a>`;
        const cs = !d.compliance_statement || !d.compliance_statement.length ?  no : `<a href="javascript:void(0)" data-opencsfile="${d.id}" class="btn-link"> <i class="icon-margin-right fa fa-file-text-o"></i> View </a>`;
        
        supplierTable.dt.row.add([
            d.name,
            d.food_imported.map((x) => x.name).join(', '),
            d.address,
            '',
            sa,
            cs,
            `
                <div class="d-flex center">
                    <button title="Evaluation form" type="button" class="btn green-soft btn-circle btn-sm" data-openevalform="${d.id}"> <i class="icon-margin-rightx fa fa-edit"></i> Form</button>
                    <span>|</span>
                    <button type="button" class="btn-link">Open</button>
                </div>
            `,
        ]);
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
    
    $('#modalEvaluationForm').modal('show');
}