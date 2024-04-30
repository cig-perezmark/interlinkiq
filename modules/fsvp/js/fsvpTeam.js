const newMemberForm = $('#newMemberForm');
let newMemberModalErrorTimeout = null;
let fsvpTeamTable = null;

$(document).ready(function() {
    initMemberSearch();
    fsvpTeamTable = initDataTable($('#tableFSVPTeamRoster'))
    fetchTeamRoster();
});

// modal hide event hook 
$('#modalAddMember').on('hidden.bs.modal', function() {
    newMemberForm.find('[name=employee]').val('').trigger('change');
    newMemberForm.find('[data-name]').val('');
    newMemberForm.find('[data-title]').val('');
    newMemberForm.find('[data-email]').val('');
    newMemberForm.find('[data-phone]').val('');
    newMemberForm.find('[data-avatar]').attr('src', 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image');
});

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
        url: baseUrl + "newFSVPTeamMember",
        type: "POST",
        contentType: false,
        processData: false,
        data: formData,
        success: function({id, message}) {
            if(id) {
                renderDTRow({
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
            l.stop();
        }
    });
})

function initMemberSearch() {
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
        newMemberForm.find('[data-name]').val(data.name);
        newMemberForm.find('[data-title]').val(data.position);
        newMemberForm.find('[data-email]').val(data.email);
        newMemberForm.find('[data-phone]').val(data.phone);
        newMemberForm.find('[data-avatar]').attr('src', data.avatar);
        return data.name || data.text;
    }

    const ajaxObj = {
        url: baseUrl,
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

function renderDTRow(d) {
    fsvpTeamTable.dt.row.add([
        d.name,
        d.position,
        d.phone,
        d.email,
        `   <div class="fsvp-trmt">
                <input type="radio" name="fsvptrmt-${d.id}" value="primary" ${d.type == 'primary' ? 'checked' : ''} />
                <i class="fa fa-check-square font-blue" style="margin-top:4px;"></i>
            </div>
        `,
        `   <div class="fsvp-trmt">
                <input type="radio" name="fsvptrmt-${d.id}" value="alternate" ${d.type == 'alternate' ? 'checked' : ''} />
                <i class="fa fa-check-square font-blue" style="margin-top:4px;"></i>
            </div>
        `,
        `
            <div class="d-flex center">
                <button type="button" class="btn-link">Remove</button>
            </div>
        `,
    ]);
    return fsvpTeamTable.dt;
}

function fetchTeamRoster() {
    $.ajax({
        url: baseUrl + "getFSVPRoster",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            if(data) {
                fsvpTeamTable.dt.clear().draw();
                data.forEach((d) => renderDTRow(d));
                fsvpTeamTable.dt.draw();
                // fancyBoxes();      
            }
        },
        error: function() {
            bootstrapGrowl('Error fetching records!');
        },
    });
}