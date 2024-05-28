$(document).ready(function() {
    $('.addNew').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=insertProject';
        $.ajax({
            type: 'POST',
              url: 'ForNewFunctions/modules/process_clone.php',
            data: formData,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
function updateCookies() {
  var assignToHistory = $("#Assign_to_history").val();
  var viewId = $("input[name='viewid']").val();
  var action = "passToOtherusers";
  $("#collaborator").modal("hide");
  swal({
    title: 'Are you sure?',
    text: 'This action will pass the project to another user.',
    icon: 'warning',
    buttons: ['Cancel', 'Confirm'],
    dangerMode: true,
  }).then(function(confirmUpdate) {
    if (confirmUpdate) {
      $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
        method: "POST",
        data: {
          assign_to_history: assignToHistory,
          view_id: viewId,
          action: action
        },
        success: function(response) {
          swal('Success!', 'The project has been passed to another user.', 'success').then(function() {
            window.location.assign("https://www.interlinkiq.com/test_MyPro.php#tab_Dashboard");
          });
        },
        error: function(xhr, status, error) {
          console.log("Error updating cookies: " + error);
          swal('Error!', 'An error occurred while passing the project.', 'error');
        }
      });
    }
  });
}
function ListOfCommentSubtask(id) {
    var action = "dataModalCommentsSubtask";
    $.ajax({
        url: 'ForNewFunctions/modules/process.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            $('#listOfChatsSubtask').html(response);
        }
    });
}
function ListOfSubTaskChild(id) {
    var action = "loadingSubTaskChild";
    $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            $('#task_list_child').html(response);
        },
        error: function() {
            alert('An error occurred');
        }
    });
}
function ListOfComment(id) {
    var action = "dataModalComments";
    $.ajax({
           url: 'ForNewFunctions/modules/process_clone.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            $('#listOfChats').html(response);
        }
    });
}

function ListOfSubTask(id) {
    var action = "loadingSubTask";
    $.ajax({
          url: 'ForNewFunctions/modules/process.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            $('#task_list').html(response);
        }
    });
}
function ListOfTaskDocument(id) {
    var action = "loadingTaskDocument";
    $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            $('#taskDocument').html(response);
        }
    });
}
function loadSubtaskdocumentlist(id){
    var action = "loadingSubtaskdocumentlist";
       $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
        type: 'POST',
        data: {
            id: id,
            action: action
        },
        success: function(response) {
            console.log(response);
            $('#SubtaskDocument').html(response);
        }
    });
}
function fill(Value) {
    $('#search_input').val(Value);
    $('#search_results').hide();
}
$(document).on('click', '#getChildSubTaskFormModal', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "addingChildSubTask";

        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                console.log(response);
                $('#childForm').html(response);
                $('#modalGetHistoryb').modal('show');
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
$(document).ready(function() {
    $("#search_input").keyup(function() {
        var searchQuery = $('#search_input').val();
        var view_id = $("#projectId").val();
        if (searchQuery === "") {
            $("#search_results").html("").hide();
        } else {
            $.ajax({
                  url: 'ForNewFunctions/modules/process_clone.php',
                type: 'POST',
                data: { searchQuery: searchQuery, view_id: view_id, action: 'searchingData' },
                dataType: 'html',
                success: function(html) {
                    console.log(html);
                    $("#search_results").html(html).show();
                }
            });
        }
    });
    $(document).on('submit', '#ViewHistoryForEdits', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        var view = $(this).data('view');

        $.ajax({
             url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: formData + "&action=SaveEditHistory",
            dataType: 'json',
            success: function(response) {
                    console.log(response.message);
                    $("#ViewHistoryForEdits").modal("hide");
                       getData(view);
                       getData1(view);
                       getData2(view);
            },
            error: function() {
                console.log('An error occurred');
            }
        });
    });
 
$(document).on('click', '#DeleteHistory', function(e) {
       var id = $(this).data('id');
       var action = "HistoryDeleted";
       Swal.fire({
       title: 'Delete Task?',
       html: '<textarea type="text" id="deletionReason" class="swal2-input" placeholder="Enter reason for deletion"></textarea>',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Delete',
       cancelButtonText: 'Cancel'
       }).then((result) => {
       if (result.isConfirmed) {
       var reason = $('#deletionReason').val();
            $.ajax({
                url: 'ForNewFunctions/modules/process_clone.php',
                method: 'POST',
                data:{history_id : id,action: action,reason: reason},
                success: function(response) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The history has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while deleting the history.',
                        icon: 'error'
                    });
                    console.log(error);
                }
            });
        }
    });
});
    $(document).on('click', '#input-picker', function() {
        var subTaskId = $(this).data('id');
        var $inputPicker = $(this);

        var action = "gettingCalendar";
        $.ajax({
               url: 'ForNewFunctions/modules/process_clone.php',
            method: "POST",
            data: {
                subTaskId: subTaskId,
                action: action
            },
            success: function(response) {
                var data = JSON.parse(response);
                var startDate = data.startDate;
                var dueDate = data.dueDate;
                var picker = new easepick.create({
                    element: $inputPicker[0],
                    css: [
                        "https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css",
                        "https://easepick.com/css/customize_sample.css",
                    ],
                    zIndex: 10000,
                    autoApply: false,
                    overflowX: true,
                    plugins: [
                        "RangePlugin"
                    ],
                    setup: function(picker) {
                        picker.on('select', function(e) {
                            let startDate = picker.getStartDate();
                            let endDate = picker.getEndDate();
                            let formattedStartDate = new Date(startDate).toISOString().split('.')[0].replace('T', ' ');
                            let formattedEndDate = new Date(endDate).toISOString().split('.')[0].replace('T', ' ');
                            var action = "changeSubtaskDate";
                            $.ajax({
                                url: 'modules/process_clone.php',
                                method: "POST",
                                data: {
                                    subTaskId: subTaskId,
                                    StartDate: formattedStartDate,
                                    EndDate: formattedEndDate,
                                    action: action
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        });
                    }
                });

                picker.setDateRange(startDate, dueDate);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
           $(document).on('click', '#deleteCollaborator', function(e) {
          e.preventDefault();
          $("#collaborator").modal("hide");
        
          var viewId = $(this).data('view');
          var collabId = $(this).data('id');
          var action = "deleteCollaborator";
        
          swal({
            title: 'Are you sure?',
            text: 'Once deleted, this collaborator will be removed.',
            icon: 'warning',
            buttons: ['Cancel', 'Delete'],
            dangerMode: true,
          }).then(function(confirmDelete) {
            if (confirmDelete) {
              $.ajax({
                url: 'ForNewFunctions/modules/process_clone.php',
                type: 'POST',
                data: { viewId: viewId, collabId: collabId, action: action },
                success: function(response) {
                  if (response === 'success') {
                    swal('Deleted!', 'The collaborator has been deleted.', 'success').then(function() {
                      location.reload();
                    });
                    $('#' + collabId).closest('.col-md-3').remove();
                  } else {
                    swal('Error!', 'Failed to delete the collaborator.', 'error');
                  }
                },
                error: function(xhr, status, error) {
                  // Handle the error here
                  console.log(error);
                  swal('Error!', 'An error occurred while deleting the collaborator.', 'error');
                }
              });
            }
          });
        });
          $(document).on('click', '#changeStatusHistory', function(e) {
            e.preventDefault();
            var HistoryId = $(this).data('id');
            var action = "ChangingHistoryStatus";
            console.log(HistoryId);
            // Show a confirmation alert
            Swal.fire({
                title: 'Select Status',
                input: 'select',
                inputOptions: {
                    0: 'Not started',
                    1: 'In Progress',
                    2: 'Completed'
                },
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Change',
                inputValidator: (value) => {
                    if (value === '') {
                        return 'You must select a status';
                    }
                }
            }).then((result) => {
                if (!result.dismiss && result.value !== '') {
                    // User confirmed and selected a status
                    var selectedStatus = result.value;
        
                    $.ajax({
                        url: 'ForNewFunctions/modules/process_clone.php',
                        type: 'POST',
                        data: { HistoryId: HistoryId, action: action, status: selectedStatus },
                        success: function(response) {
                            // Show success notification
                            console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'History status changed successfully.',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Reload Page'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Reload the page
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    $(document).on('click', '#subTask', function(e) {
        e.preventDefault();
        var taskId = $(this).data('id');
        var action = "getSubTaskData";

        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: { taskId: taskId, action: action },
            success: function(response) {
                $('#SubTaskViewData').html(response);
                ListOfCommentSubtask(taskId);
                ListOfSubTaskChild(taskId);
                loadSubtaskdocumentlist(taskId);
                $('#subTask_ids').val(taskId);
                
                   flatpickr('#example10', {
                    dateFormat: 'Y-m-d', 
                    onChange: function(selectedDates, dateStr, instance) {
                        var newDate = dateStr;
                        var actionHistory = "changeSubtaskDate";
                        $('#calendarHistoryDate').val(newDate);
                        var viewId = $('#example10').data('id');
                        
                        Swal.fire({
                            title: 'Update Due Date',
                            text: 'Do you want to update the due date to ' + newDate + '?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                                $.ajax({
                                    url: 'ForNewFunctions/modules/process_clone.php',
                                    type: 'POST',
                                    data: { view_id: viewId, new_date: newDate, action: actionHistory },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Changes have been made. Do you want to refresh the page to take effect the changes?',
                                            icon: 'success',
                                            showCancelButton: true,
                                            confirmButtonText: 'Refresh',
                                            cancelButtonText: 'Cancel'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            } else {
                                            }
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            } else {
                            }
                        });
                    }
                });
            },
            error: function(error) {
                console.log(error);
            }
        });

        var tabPane = $('.tab-pane');
        if (!tabPane.hasClass('page-quick-sidebar-content-item-shown')) {
            tabPane.addClass('page-quick-sidebar-content-item-shown');
        }
    });
    $(document).on('click', '#ViewHistoryForEdit', function(e) {
        e.preventDefault();
        var history_id = $(this).data('id');
        var action = "ViewHistoryForEdit";

        $.ajax({
              url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: history_id,
                action: action
            },
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    var jsonData = response[0];
                    console.log(jsonData);
                    var history_id = jsonData.History_id;
                    var filename = jsonData.filename;
                    var description = jsonData.description;
                    var files = jsonData.files;
                    var Estimated_Time = jsonData.Estimated_Time;
                    var Action_taken = jsonData.Action_taken;
                    var Action_date = jsonData.Action_date;
                    var h_accounts = jsonData.h_accounts;
                    var Assign_to_history = jsonData.Assign_to_history;
                    var formattedActionDate = Action_date.substr(0, 10);
                    $("#History_id").val(history_id);
                    $("#Action_date").val(formattedActionDate);
                    $("#filename").val(filename);
                    $("#description").val(description);
                    $("#file").val(files);
                    $("#Estimated_Time").val(Estimated_Time);
                    $("#Action_taken").val(Action_taken);
                    $("#h_accounts").val(h_accounts);
                    $("#Assign_to_history").val(Assign_to_history);
                } else {
                    console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.log('An error occurred:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
            }

        });
    });
    $(document).on('click', '#PrintToPdf', function(e) {
        e.preventDefault();
        var viewId = $(this).data('id');
        var downloadLink = document.createElement('a');
        downloadLink.href = 'ForNewFunctions/modules/myProGeneratepdf.php?viewId=' + viewId;
        downloadLink.target = '_blank';
        downloadLink.download = 'generated_pdf.pdf';
        downloadLink.click();
    });
    $(document).on('click', '#editViewSubTask', function(e) {
        e.preventDefault();
        var task_parent_id = $(this).data('id');
        // var subTask_id = $("#subTaskIdselected").val();
        // var subTask_id = $(this).data('subid');
        var action = "ViewSubTaskForEdit";
        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                parent_id: task_parent_id,
                action: action
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.length > 0) {
                    var jsonData = response[0];
                    console.log(jsonData);
                    var CAI_id = jsonData.CAI_id;
                    var History_id = jsonData.Services_History_PK;
                    var parent_MyPro_PK = jsonData.Parent_MyPro_PK;
                    var CAI_filename = jsonData.CAI_filename;
                    var CAI_description = jsonData.CAI_description;
                    var CAI_files = jsonData.CAI_files;
                    var CIA_progress = jsonData.CIA_progress;
                    var CAI_Estimated_Time = jsonData.CAI_Estimated_Time;
                    var CAI_Action_taken = jsonData.CAI_Action_taken;
                    var CAI_Action_due_date = jsonData.CAI_Action_due_date;
                    var CAI_Accounts = jsonData.CAI_Accounts;
                    var CAI_Assign_to = jsonData.CAI_Assign_to;
                    var formattedActionDate = CAI_Action_due_date.substr(0, 10);
                    $("#History_id").val(History_id);
                    $("#CAI_id").val(CAI_id);
                    $("#parent_MyPro_PK").val(parent_MyPro_PK);
                    $("#CAI_Action_due_date").val(formattedActionDate);
                    $("#CAI_filename").val(CAI_filename);
                    $("#CAI_description").val(CAI_description);
                    $("#CAI_files").val(CAI_files);
                    $("#CIA_progress").val(CIA_progress);
                    $("#CAI_Estimated_Time").val(CAI_Estimated_Time);
                    $("#CAI_Action_taken").val(CAI_Action_taken);
                    $("#CAI_Accounts").val(CAI_Accounts);
                    $("#CAI_Assign_to").val(CAI_Assign_to);
                } else {
                    console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.log('An error occurred:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
            }

        });
    });
     $(document).on('click', '#cloaserightpanel', function(e) {
          $('#todo_task').empty();
     });
    $(document).on('click', '#cardData', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "dataModal";
        var panelActiveClass = 'panel-right--open';
        $.ajax({
             url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                $('#todo_task').html(response);
                ListOfComment(id);
                ListOfSubTask(id);
                ListOfTaskDocument(id);
                $('#Task_ids').val(id);
                
                flatpickr('#example9', {
                    dateFormat: 'Y-m-d', 
                    onChange: function(selectedDates, dateStr, instance) {
                        var newDate = dateStr;
                        var actionHistory = "changeHistoryDate";
                        $('#calendarHistoryDate').val(newDate);
                        var viewId = $('#example9').data('id');
                        
                        Swal.fire({
                            title: 'Update Due Date',
                            text: 'Do you want to update the due date to ' + newDate + '?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                                $.ajax({
                                    url: 'ForNewFunctions/modules/process_clone.php',
                                    type: 'POST',
                                    data: { view_id: viewId, new_date: newDate, action: actionHistory },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Changes have been made. Do you want to refresh the page to take effect the changes?',
                                            icon: 'success',
                                            showCancelButton: true,
                                            confirmButtonText: 'Refresh',
                                            cancelButtonText: 'Cancel'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            } else {
                                            }
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            } else {
                            }
                        });
                    }
                });

            },
            error: function(xhr, status, error) {
                console.log('An error occurred:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
    });
    $(document).on('click', '#getChildFormModal', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "addingChild";

        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                $('#childForm').html(response);
                $('#modalGetHistoryb').modal('show');
                
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
      $(document).on('click', '#changeSubTaskAssignee', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "GetThisJsonEncodeForAssigneeHistory";
        var action2 = "InsertTheNewSubAssignee";
        var assigneeHistoryData;
        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                action: action
            },
            success: function(response) {
                assigneeHistoryData = JSON.parse(response);
    
                var options = {};
                for (var i = 0; i < assigneeHistoryData.length; i++) {
                    var option = assigneeHistoryData[i];
                    options[option.value] = option.label;
                }
                Swal.fire({
                    title: 'Select New Assignee',
                    input: 'select',
                    inputOptions: options, 
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    inputPlaceholder: 'Select New Assignee',
                    inputValidator: function(value) {
                        return new Promise(function(resolve, reject) {
                            if (value !== '') {
                                resolve();
                            } else {
                                reject('Please select an option');
                            }
                        });
                    }
                }).then(function(result) {
                    if (!result.dismiss && result.value !== '') {
                        var selectedValue = result.value;
                        $.ajax({
                            url: 'ForNewFunctions/modules/process_clone.php',
                            type: 'POST',
                            data: {
                                id: id,
                                action: action2,
                                selectedValue: selectedValue
                            },
                            success: function(response) {
                               console.log(response);
                            },
                            error: function() {
                                alert('An error occurred');
                            }
                        });
                    }
                });
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
    $(document).on('click', '#changeHistoryAssignee', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "GetThisJsonEncodeForAssigneeHistory";
        var action2 = "InsertTheNewAssignee";
        var assigneeHistoryData;
        $.ajax({
            url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                action: action
            },
            success: function(response) {
                assigneeHistoryData = JSON.parse(response);
    
                var options = {};
                for (var i = 0; i < assigneeHistoryData.length; i++) {
                    var option = assigneeHistoryData[i];
                    options[option.value] = option.label;
                }
                Swal.fire({
                    title: 'Select New Assignee',
                    input: 'select',
                    inputOptions: options, 
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    inputPlaceholder: 'Select New Assignee',
                    inputValidator: function(value) {
                        return new Promise(function(resolve, reject) {
                            if (value !== '') {
                                resolve();
                            } else {
                                reject('Please select an option');
                            }
                        });
                    }
                }).then(function(result) {
                    if (!result.dismiss && result.value !== '') {
                        var selectedValue = result.value;
                        $.ajax({
                            url: 'ForNewFunctions/modules/process_clone.php',
                            type: 'POST',
                            data: {
                                id: id,
                                action: action2,
                                selectedValue: selectedValue
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function() {
                                alert('An error occurred');
                            }
                        });
                    }
                });
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
    $(document).on('click', '#getModalDocumentForm', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "addingDocumentform";

        $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                $('#childDocumentForm').html(response);
                $('#modalDocumentForm').modal('show');
                // $("#contact-slider").slideReveal("hide");
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
        $(document).on('click', '#childgetModalDocumentForm', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var action = "addingSubDocumentform";
        $.ajax({
        url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                $('#childDocumentForm').html(response);
                $('#modalDocumentForm').modal('show');
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
    // subtask edit
    $(document).on('submit', '#ViewSubTaskForEdits', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        var history_id = $("#History_id").val();
        formData.append('action', 'SubmitEditedSubTask');
        $.ajax({
              url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    console.log(response.message);
                    ListOfSubTask(history_id);
                    $('#ViewSubTaskForEdit').modal('hide');
                } else {
                    console.log(response.message);
                    $('#ViewSubTaskForEdit').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                console.log('An error occurred:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
    });
    $(".modalGetHistoryb").on('submit', (function(e) {
        e.preventDefault();
        var parent_id = $("#parent_id").val();
        formObj = $(this);
        if (!formObj.validate().form()) return false;
        var formData = new FormData(this);
        formData.append('action', 'addingChildSubmit');
        $.ajax({
              url: 'ForNewFunctions/modules/process_clone.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                $('#modalGetHistoryb').modal('hide');
                ListOfSubTask(parent_id);
                
            },
            error: function() {
                msg = "An error occurred during the AJAX request.";
            }
        });
    }));
    
    $(".modalDocumentForm").on('submit', (function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var parent_val = $("#parent_id").val();
        formData.append('action', 'addingDocument');
        $.ajax({
               url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                    $('#modalDocumentForm').modal('hide');
                    ListOfTaskDocument(parent_val);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }));
    $(".modalDocumentForm").on('submit', (function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var parent_val = $("#parent_id").val();
        formData.append('action', 'addingSubDocument');
        $.ajax({
               url: 'ForNewFunctions/modules/process_clone.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                    $('#modalDocumentForm').modal('hide');
                    loadSubtaskdocumentlist(parent_val);
                
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }));
    // $(document).on('submit', '#commentForm', function(e) {
    //     e.preventDefault();
    //     var formData = {
    //         Task_ids: $('input[name=Task_ids]').val(),
    //         user_id: $('input[name=user_id]').val(),
    //         comment: $('input[name=commentinput]').val(),
    //         action: 'AddComment'
    //     };
    //     console.log(formData);
    //     $.ajax({
    //         type: 'POST',
    //           url: 'ForNewFunctions/modules/process_clone.php',
    //         data: formData,
    //         success: function(response) {
    //             console.log(response);
    //             $('input[name=commentinput]').val('');
    //             var id = $('input[name=Task_ids]').val();
    //             ListOfComment(id);
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(error);
    //         }
    //     });
    // });
    // $(document).on('submit', '#commentFormSub', function(e) {
    //     e.preventDefault();
    //     var formData = {
    //         Task_ids: $('input[name=subTask_ids]').val(),
    //         user_id: $('input[name=subtaskuser_id]').val(),
    //         comment: $('input[name=subTaskcommentinput]').val(),
    //         action: 'AddCommentSubtask'
    //     };
    //     console.log(formData);
    //     $.ajax({
    //         type: 'POST',
    //           url: 'ForNewFunctions/modules/process_clone.php',
    //         data: formData,
    //         success: function(response) {
    //             console.log(response);
    //             $('input[name=subTaskcommentinput]').val('');
    //             var id = $('input[name=subTask_ids]').val();
    //             ListOfCommentSubtask(id);
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(error);
    //         }
    //     });
    // });
    $(document).on('click', '#DeleteSelected', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var view = $(this).data('view');
        var action = "deleteSelectedSubTask";
        Swal.fire({
            title: 'Delete Selected Subtask',
            text: 'Are you sure you want to delete this subtask?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            html: `
                <textarea id="reason" class="swal2-input" placeholder="Enter reason for deletion"></textarea>
            `
        }).then((result) => {
            if (result.isConfirmed) {
                var reason = $('#reason').val();
    
                $.ajax({
                    url: 'ForNewFunctions/modules/process_clone.php',
                    method: "POST",
                    data: {
                        subTaskId: id,
                        action: action,
                        reason: reason
                    },
                    success: function(response) {
                        console.log(response);
                        ListOfSubTaskChild(view);
                        ListOfSubTask(view);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    });
     $(document).on('submit', '#addCollaborator', function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=AddCollaborator';
        
        // Hide the modal
        $('#collaborator').modal('hide');
    
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to update the collaborators?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, update it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: 'ForNewFunctions/modules/process_clone.php',
              type: 'POST',
              data: formData,
              success: function(response) {
                console.log(response);
                Swal.fire({
                  title: 'Success',
                  text: 'Collaborators updated successfully!',
                  icon: 'success',
                  showCancelButton: true,
                  confirmButtonText: 'Reload Page',
                  cancelButtonText: 'No, thanks',
                  reverseButtons: true
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              },
              error: function(xhr, status, error) {
                console.log(error);
                Swal.fire({
                  title: 'Error',
                  text: 'Error updating collaborators!',
                  icon: 'error',
                  confirmButtonText: 'Ok'
                });
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'Collaborators update was cancelled!',
              icon: 'error',
              confirmButtonText: 'Ok'
            });
          }
        });
      });
    $("#actionItem").on('submit', function(e) {
        e.preventDefault();
        var formObj = $(this);
        var parent_data = $("#project_id").val();
        if (!formObj.validate().form()) {
            return false;
        }
        var formData = new FormData(this);
        formData.append('action', 'InsertChildProjectAndHistory');
        $.ajax({
             url: 'ForNewFunctions/modules/process_clone.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response);
                $('#modalAddActionItem').modal('hide');
                getData(parent_data);
                getData1(parent_data);
                getData2(parent_data);
            }
        });
    });

});