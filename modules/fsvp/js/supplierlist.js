let newSupplierFiles = {
    supplier_agreement: {},
    compliance_statement: {},
}
let newSupplierFileCounter = 0;
let newSupplierErrorDisplay = null;
let supplierTable = null;

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
            <input class="form-control fileArrayDates" type="date" required>
            <input class="form-control fileArrayDates" type="date" required>
            <input class="form-control fileArrayDates" type="text" placeholder="Add note">
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
    })
})

// submit new supplier
$('#newSupplierForm').submit(function(e) {
    e.preventDefault();
    
    const form = e.target;

    if(!form.supplier.value) {
        return showError('Please select a supplier.');
    }

    if(!$(form).find('[name="food_imported[]"]:checked').length) {
        return showError('Please select food imported to proceed.');
    }

    if(form.supplier_agreement.value == '1' && !Object.values(newSupplierFiles.supplier_agreement).length) {
        return showError('Please upload supplier agreement document(s).');
    }

    if(form.compliance_statement.value == '1' && !Object.values(newSupplierFiles.compliance_statement).length) {
        return showError('Please upload supplier agreement document(s).');
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
    Object.values(newSupplierFiles.compliance_statement).forEach(f => {
        formData.append('compliance_statement_file', f)
    });

    Object.values(newSupplierFiles.supplier_agreement).forEach(f => {
        formData.append('supplier_agreement_file[]', f)
    });

    var l = Ladda.create(btn);
    l.start();

    $.ajax({
        url: baseUrl + "newSupplierToList",
        type: "POST",
        contentType: false,
        processData: false,
        data: formData,
        success: function(response) {
            console.log(response)
        },
        error: function() {
            bootstrapGrowl('Error!');
        },
        complete: function() {
            l.stop();
        }
    });
});

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
        }, 5000)
    })
}

initMultiSelect($('.supplierdd'), {
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
            success: function({
                materials
            }) {
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
                    })
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
})

$(document).ready(function() {
    supplierTable = initDataTable('#tableSupplierList')
});