$(document).ready(function() {
    $('.mt-multiselect').multiselect({
        widthSynchronizationMode: 'ifPopupIsSmaller',
        buttonTextAlignment: 'left',
        buttonWidth: '100%',
        maxHeight: 200,
        enableResetButton: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        includeSelectAllOption: true
    });
    $('.multiselect-container .multiselect-filter', $('.mt-multiselect').parent()).css({
        'position': 'sticky', 'top': '0px', 'z-index': 1,
    })
});

$(".modalProject").on('submit',(function(e) {
    e.preventDefault();

    var update = $('#modalProject [name="project_id"]').val();

    var formData = new FormData(this);
    formData.append('btnSave_USER_Project',true);

    $.ajax({
        url: "admin_2/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                var obj = jQuery.parseJSON(response);

                var result = "";

                if (!update) {
                    result += '<tr id="tr_'+obj.ID+'">';
                }

                result += '<td class="mt-element-ribbon">';

                if (obj.priority == 1) {
                    result += '<div class="ribbon ribbon-right ribbon-vertical-right ribbon-shadow ribbon-border-dash-vert ribbon-color-success uppercase">';
                    result += '<div class="ribbon-sub ribbon-bookmark"></div>';
                    result += '<i class="fa fa-star"></i>';
                    result += '</div>';
                }
                
                result += '<b>'+obj.project+'</b></br>';
                result += '<span><b>Assigned To: </b><i>'+obj.assigned_to_id+'</i></span></br>';
                result += '<span><b>Due Date: </b><i>'+obj.due_date+'</i></span></br>';
                result += '<span><b>Remarks: </b><i>';

                if (obj.status == 0) {
                    result += '<span class="label label-sm label-warning">Pending</span>';
                } else if (obj.status == 1) {
                    result += '<span class="label label-sm label-success">Completed</span>';
                } else if (obj.status == 2) {
                    result += '<span class="label label-sm label-danger">Canceled</span>';
                }

                result += '</i></span>';
                result += '</td>';

                result += '<td class="text-center">';
                result += '<div class="btn-group btn-group-circle">';
                result += '<button type="button" class="btn btn-outline dark btn-sm btnEditProject" ';
                result += 'data-id="'+obj.ID+'"';
                result += 'data-project="'+obj.project+'"';
                result += 'data-assigned="'+obj.assigned_to_id+'"';
                result += 'data-date="'+obj.due_date+'"';
                result += 'data-priority="'+obj.priority+'"';
                result += '>Edit</button>';
                result += '<button type="button" class="btn btn-outline red btn-sm btnDeleteProject" data-id="'+obj.ID+'">Delete</button>';
                result += '</div>';
                result += '</td>';

                if (!update) {
                    result += '</tr>';
                    $('#tableProject tbody').append(result);
                } else {
                    $('#tableProject tbody #tr_'+obj.ID).html(result);
                }

                $('.modalProject').trigger("reset");
                $('#modalProject [name="project_id"]').val("");
                $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', true);
                $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', false);

                $('#profileSidebarProject').html(obj.profileProject);
            } else {
                msg = "Error!"
            }

            $.bootstrapGrowl(msg,{
                ele:"body",
                type:"success",
                offset:{
                    from:"top",
                    amount:100
                },
                align:"right",
                width:250,
                delay:5000,
                allow_dismiss:1,
                stackup_spacing:10
            })
        }        
    });
}));
$(".btnEditProject").click(function() {
    var id = $(this).data("id");
    var project = $(this).data("project");
    var date = $(this).data("date");
    var priority = $(this).data("priority");

    var assigned = $(this).data("assigned");
    var assigned = assigned.split(', ');

    $('#modalProject [name="project_id"]').val(id);
    $('#modalProject [name="project"]').val(project);
    $('#modalProject [name="due_date"]').val(date);

    $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', true);
    $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', false);
    $('#modalProject [name="assigned_to_id[]"]').multiselect('select', assigned);
    $('#modalProject [name="assigned_to_id[]"]').multiselect('refresh');

    if (priority == 1) {
        $('#modalProject .bootstrap-switch-container [name="priority"]').attr( 'checked', true );
        $('#modalProject .bootstrap-switch-container [name="priority"]').bootstrapSwitch('state', true);
    } else {
        $('#modalProject .bootstrap-switch-container [name="priority"]').attr( 'checked', false );
        $('#modalProject .bootstrap-switch-container [name="priority"]').bootstrapSwitch('state', false);
    }
});
$(".btnDeleteProject").click(function() {
    var id = $(this).data("id");

    swal({
        title: "Are you sure?",
        text: "Your project will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            type: "GET",
            url: "admin_2/function.php?modalProject_Delete="+id,             
            dataType: "html",
            success: function(response){
                var obj = jQuery.parseJSON(response);
                $('#tableProject tbody #tr_'+id).remove();
                $('#profileSidebarProject').html(obj.profileProject);
            }
        });
        swal("Removed!", "Your project has been deleted.", "success");
    });
});
$("#btnReset_USER_Project").click(function() {
    btnReset("project");
});


$(".modalTask").on('submit',(function(e) {
    e.preventDefault();

    var update = $('#modalTask [name="task_id"]').val();

    var formData = new FormData(this);
    formData.append('btnSave_USER_Task',true);

    $.ajax({
        url: "admin_2/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                var obj = jQuery.parseJSON(response);

                var result = "";

                if (!update) {
                    result += '<tr id="tr_'+obj.ID+'">';
                }

                result += '<td class="mt-element-ribbon">';

                if (obj.priority == 1) {
                    result += '<div class="ribbon ribbon-right ribbon-vertical-right ribbon-shadow ribbon-border-dash-vert ribbon-color-success uppercase">';
                    result += '<div class="ribbon-sub ribbon-bookmark"></div>';
                    result += '<i class="fa fa-star"></i>';
                    result += '</div>';
                }
                
                result += '<b>'+obj.task+'</b></br>';
                result += '<span><b>Assigned To: </b><i>'+obj.assigned_to_id+'</i></span></br>';
                result += '<span><b>Due Date: </b><i>'+obj.due_date+'</i></span></br>';
                result += '<span><b>Remarks: </b><i>';

                if (obj.status == 0) {
                    result += '<span class="label label-sm label-warning">Pending</span>';
                } else if (obj.status == 1) {
                    result += '<span class="label label-sm label-success">Completed</span>';
                } else if (obj.status == 2) {
                    result += '<span class="label label-sm label-danger">Canceled</span>';
                }

                result += '</i></span>';
                result += '</td>';

                result += '<td class="text-center">';
                result += '<div class="btn-group btn-group-circle">';
                result += '<button type="button" class="btn btn-outline dark btn-sm btnEditTask" ';
                result += 'data-id="'+obj.ID+'"';
                result += 'data-task="'+obj.task+'"';
                result += 'data-assigned="'+obj.assigned_to_id+'"';
                result += 'data-date="'+obj.due_date+'"';
                result += 'data-priority="'+obj.priority+'"';
                result += '>Edit</button>';
                result += '<button type="button" class="btn btn-outline red btn-sm btnDeleteTask" data-id="'+obj.ID+'">Delete</button>';
                result += '</div>';
                result += '</td>';

                if (!update) {
                    result += '</tr>';
                    $('#tableTask tbody').append(result);
                } else {
                    $('#tableTask tbody #tr_'+obj.ID).html(result);
                }

                $('.modalTask').trigger("reset");
                $('#modalTask [name="task_id"]').val("");
                $('#modalTask [name="assigned_to_id[]"]').multiselect('deselectAll', true);
                $('#modalTask [name="assigned_to_id[]"]').multiselect('deselectAll', false);

                $('#profileSidebarTask').html(obj.profileTask);
            } else {
                msg = "Error!"
            }

            $.bootstrapGrowl(msg,{
                ele:"body",
                type:"success",
                offset:{
                    from:"top",
                    amount:100
                },
                align:"right",
                width:250,
                delay:5000,
                allow_dismiss:1,
                stackup_spacing:10
            })
        }        
    });
}));
$(".btnEditTask").click(function() {
    var id = $(this).data("id");
    var task = $(this).data("task");
    var assigned = $(this).data("assigned");
    var date = $(this).data("date");
    var priority = $(this).data("priority");

    $('#modalTask [name="task_id"]').val(id);
    $('#modalTask [name="task"]').val(task);
    $('#modalTask [name="due_date"]').val(date);

    $('#modalTask [name="assigned_to_id"').multiselect('select', [assigned]);
    $('#modalTask [name="assigned_to_id"').multiselect('refresh');

    if (priority == 1) {
        $('#modalTask .bootstrap-switch-container [name="priority"]').attr( 'checked', true );
        $('#modalTask .bootstrap-switch-container [name="priority"]').bootstrapSwitch('state', true);
    } else {
        $('#modalTask .bootstrap-switch-container [name="priority"]').attr( 'checked', false );
        $('#modalTask .bootstrap-switch-container [name="priority"]').bootstrapSwitch('state', false);
    }
});
$(".btnDeleteTask").click(function() {
    var id = $(this).data("id");

    swal({
        title: "Are you sure?",
        text: "Your task will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            type: "GET",
            url: "admin_2/function.php?modalTask_Delete="+id,             
            dataType: "html",
            success: function(response){
                var obj = jQuery.parseJSON(response);
                $('#tableTask tbody #tr_'+id).remove();
                $('#profileSidebarTask').html(obj.profileTask);
            }
        });
        swal("Removed!", "Your task has been deleted.", "success");
    });
});
$("#btnReset_USER_Task").click(function() {
    btnReset("task");
});

function btnReset(type) {
    if(type === "project") {
        $('.modalProject').trigger("reset");
        $('#modalProject [name="project_id"]').val("");
        $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', true);
        $('#modalProject [name="assigned_to_id[]"]').multiselect('deselectAll', false);
        $('#modalProject [name="assigned_to_id[]"]').multiselect('refresh');
    } else if(type === "task") {
        $('.modalTask').trigger("reset");
        $('#modalTask [name="task_id"]').val("");
        $('#modalTask [name="assigned_to_id"]').multiselect('deselectAll', true);
        $('#modalTask [name="assigned_to_id"]').multiselect('deselectAll', false);
        $('#modalTask [name="assigned_to_id"]').multiselect('refresh');
    }
}


$(".modalUpload").on('submit',(function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('btnSave_USER_Upload',true);

    $.ajax({
        url: "admin_2/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                var obj = jQuery.parseJSON(response);
                var result = '<tr id="tr_'+obj.ID+'">';
                result += '<td>';

                if ( obj.description ) {
                    result += '<span>'+obj.description+'</span></br>';
                }
                
                result += '<a href="admin_2/uploads/'+obj.files+'" target="_blank">'+obj.files+'</a>';
                result += '</td>';
                result += '<td class="text-center"><a class="btn red-thunderbird btn-sm uppercase btnRemoveUpload" data-id="'+obj.ID+'"><i class="fa fa-times"></i> Remove</a></td>';
                result += '</tr>';

                $('#tableUpload tbody').append(result);
                $('#profileSidebarUpload').html(obj.profileUpload);
            } else {
                msg = "Error!"
            }

            $.bootstrapGrowl(msg,{
                ele:"body",
                type:"success",
                offset:{
                    from:"top",
                    amount:100
                },
                align:"right",
                width:250,
                delay:5000,
                allow_dismiss:1,
                stackup_spacing:10
            })

        }        
    });
}));
$(".btnRemoveUpload").click(function() {
    var id = $(this).data("id");

    swal({
        title: "Are you sure?",
        text: "Your file will be removed!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, remove it!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            type: "GET",
            url: "admin_2/function.php?modalUpload_Remove="+id,             
            dataType: "html",
            success: function(response){
                var obj = jQuery.parseJSON(response);
                $('#tableUpload tbody #tr_'+id).remove();
                $('#profileSidebarUpload').html(obj.profileUpload);
            }
        });
        swal("Removed!", "Your file has been removed.", "success");
    });
});

$(".mt-sweetalert").click(function() {
    swal({
        title: "Are you sure?",
        text: "Your file will be removed!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, remove it!",
        closeOnConfirm: false
    },
    function(){
        swal("Removed!", "Your file has been removed.", "success");
    });
});