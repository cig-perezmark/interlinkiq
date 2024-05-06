jQuery(function() {
    const newMemberForm = $('#newMemberForm');
    const fsvpTeamTable = Init.dataTable($('#tableFSVPTeamRoster'), {paging: false});
    const actionColumnDT = fsvpTeamTable.dt.column(6);
    let newMemberModalErrorTimeout = null;
    let changeData = {};
    
    fetchTeamRoster(fsvpTeamTable.dt);
    initMemberSearch(newMemberForm);
    actionColumnDT.visible(false)

    $('.esign').eSign();
    
    // modal hide event hook 
    $('#modalAddMember').on('hidden.bs.modal', function() {
        newMemberForm.find('[name=employee]').val('').trigger('change');
        newMemberForm.find('[data-name]').val('');
        newMemberForm.find('[data-title]').val('');
        newMemberForm.find('[data-email]').val('');
        newMemberForm.find('[data-phone]').val('');
        newMemberForm.find('[data-avatar]').attr('src', 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image');
    });

    // add new employee
    newMemberForm.on('submit', function(e) {
        e.preventDefault();
        const employee = e.target.employee.value;

        if(!employee) {
            if(newMemberModalErrorTimeout) {
                clearTimeout(newMemberModalErrorTimeout);
            }
            
            $('#modalNewMemberErrorMessage').text('Please select an employee to proceed!');
            $('#modalNewMemberError').fadeIn('linear', () => {
                newMemberModalErrorTimeout = setTimeout(() => {
                    $('#modalNewMemberError').fadeOut();
                    newMemberModalErrorTimeout = null;
                }, 5000)
            });

            return;
        }

        const formData = new FormData(e.target);
        $.ajax({
            url: Init.baseUrl + "newFSVPTeamMember",
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function({id, message}) {
                if(id) {
                    renderDTRow(fsvpTeamTable.dt, {
                        name: newMemberForm.find('[data-name]').val(),
                        position: newMemberForm.find('[data-title]').val(),
                        phone: newMemberForm.find('[data-phone]').val(),
                        email: newMemberForm.find('[data-email]').val(),
                        id,
                        type: e.target.member_type.value
                    }).draw()
                }

                $('#modalAddMember').modal('hide');
                bootstrapGrowl(message || 'Saved!');
            },
            error: function() {
                bootstrapGrowl('Error!');
            },
            complete: function() {
                // l.stop();
            }
        });
    });

    // toggle update to table
    $('#updateRosterToggle').change(function() {
        const procBtn = (btn = this) => {
            const label = $(btn).closest('label');
            $('#tableFSVPTeamRoster')[btn.checked ? 'removeClass' : 'addClass']('for-display');
            $('#addMemberBtn')[btn.checked ? 'addClass' : 'removeClass']('hide');
            label.removeClass('blue blue-dark').addClass(btn.checked ? 'blue' : 'blue-dark');
            label.find('span.btnLabel').text(btn.checked ? 'Save changes' : 'Update roster')
            label.find('i').removeClass('fa-refresh fa-check').addClass(btn.checked ? 'fa-check' : 'fa-refresh')
            actionColumnDT.visible(btn.checked);
            $('#cancelUpdateBtn')[btn.checked ? 'removeClass' : 'addClass']('hide');
        }
        
        var btn = this;
        if (!this.checked && Object.entries(changeData).length) {
            // var l = Ladda.create(this.closest('label'));
            // l.start();

            const data = new FormData();
            data.append('updates', JSON.stringify(changeData));

            $.ajax({
                url: Init.baseUrl + "updateFSVPTeamRoster",
                type: "POST",
                contentType: false,
                processData: false,
                data,
                success: function({message}) {
                    if(message) {
                        bootstrapGrowl(message || 'Updated successfully!');
                    }
                    changeData = {}; // reset
                    procBtn();
                },
                error: function(err) {
                    console.error(err)
                    bootstrapGrowl('Unable to complete action.');
                },
                complete: function() {
                    // l.stop();
                    // setTimeout(() => {
                    //     procBtn(btn);
                    // }, 2000)
                }
            });
            
            return;
        }

        procBtn(this);
    });

    // cancel updates
    $('#cancelUpdateBtn').click(function() {
        $('#updateRosterToggle').prop('checked', false).trigger('change');
        fetchTeamRoster(fsvpTeamTable.dt);
    });

    // remove event
    $('#tableFSVPTeamRoster').on('click', 'button[data-removebtn]', function(e) {
        const id = this.dataset.removebtn;
        const name = this.dataset.name;
        const tr =  $(this).parents('tr');

        if(!id) return;

        swal(
            {
                title: `Remove "${name}" from the team roster?`,
                type: "warning",
                allowOutsideClick: false,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonClass: "btn red",
                cancelButtonClass: "btn default",
                closeOnConfirm: true,
                closeOnCancel: true,
                confirmButtonText: "Confirm action",
                cancelButtonText: "Cancel",
            },
            function (isConfirm) {
                if (isConfirm) {
                   fsvpTeamTable.dt.row(tr).remove().draw();
                   changeData[id] = {remove: true}; 
                }
            }
        );
    });

    // switching member types
    $('#tableFSVPTeamRoster').on('change', '.fsvp-trmt input[type=radio]', function(e) {
        const id = this.dataset.id || null;
        if(this.checked && id) {
            changeData[id] = {type: this.value};
        }
    });
});

function fetchTeamRoster(dt) {
    $.ajax({
        url: Init.baseUrl + "getFSVPRoster",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            if(data) {
                dt.clear();
                data.forEach((d) => renderDTRow(dt, d));
                dt.draw();
                // fancyBoxes();      
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!');
        },
    });
}

function renderDTRow(dt, d) {
    dt.row.add([
        d.name,
        d.position,
        d.phone,
        d.email,
        `   <div class="fsvp-trmt">
                <input type="radio" name="fsvptrmt-${d.id}" value="primary" ${d.type == 'primary' ? 'checked' : ''} data-id="${d.id}" />
                <i class="fa fa-check-square font-blue" style="margin-top:4px;"></i>
            </div>
        `,
        `   <div class="fsvp-trmt">
                <input type="radio" name="fsvptrmt-${d.id}" value="alternate" ${d.type == 'alternate' ? 'checked' : ''} data-id="${d.id}" />
                <i class="fa fa-check-square font-blue" style="margin-top:4px;"></i>
            </div>
        `,
        `   <div class="d-flex center">
                <button type="button" class="btn-link font-red" data-removebtn="${d.id}" data-name="${d.name}">
                    <i class="fa fa-trash-o icon-margin-right font-red"></i>
                    Remove
                </button>
            </div>
        `,
    ]);
    return dt;
}

function initMemberSearch(form) {
    const searchEmpDropdown = $("#employeeSearchDd");
    function formatProduct(data) {
        if (data.loading) return data.name;

        return `<div class="select2-result-repository clearfix">
            <div class="select2-result-repository__avatar" style="width: 40px;">
                <img src="${data.avatar}" alt="Avatar" />
            </div>
            <div class="select2-result-repository__meta" style="margin-left: 0;"> 
                <div class="select2-result-repository__title">${data.name}</div>
                <div class="select2-result-repository__description">${data.position}</div>
            </div>
        </div>`;
    }

    function formatProductSelection(data) {
        form.find('[data-name]').val(data.name);
        form.find('[data-title]').val(data.position);
        form.find('[data-email]').val(data.email);
        form.find('[data-phone]').val(data.phone);
        form.find('[data-avatar]').attr('src', data.avatar);
        return data.name || data.text;
    }

    const ajaxObj = {
        url: Init.baseUrl,
        dataType: "json",
        method: "POST",
        delay: 250,
        data: function (params) {
            return {
                "search-employee": params.term, // search term
                // products: JSON.stringify(planBuilder.products) || "[]",
                page: params.page,
            };
        },
        processResults: function (data, page) {
            return {
                results: data.results,
            };
        },
        cache: true,
    };

    searchEmpDropdown.select2({
        width: "100%",
        ajax: ajaxObj,
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatProduct,
        templateSelection: formatProductSelection,
    });
}