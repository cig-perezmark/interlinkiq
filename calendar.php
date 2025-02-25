<?php 
    $title = "Calendar";
    $site = "MyPro";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    $base_url = "https://interlinkiq.com/";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
    .parentTbls{
      padding: 0px 10px;
    }
    .childTbls td {
        border:solid grey 1px;
      padding: 0px 10px;
    }
    .child-1{
        background-color:#3D8361;
        color:#fff;
        border:solid grey 1px;
        padding: 0px 10px;
    }
    .font-14{
        font-size:14px;
    }
    .paddId{
        padding: 0px 10px;
    }
    #loading
    {
     text-align:center; 
     background: url('loader.gif') no-repeat center; 
     height: 150px;
    }
   .fc-event .fc-time{
        display:none !important;
        color:transparent;
    }
    b{
        /*color:black;*/
    }
    
    .fc button {
        -moz-box-sizing: border-box !important;
        -webkit-box-sizing: border-box !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        height: 2.1em !important;
        padding: 0 .6em !important;
        font-size: 1em !important;
        white-space: nowrap !important;
        cursor: pointer !important;
    }
    .fc-button-primary {
        background-color: #f5f5f5 !important;
        background-image: -moz-linear-gradient(top, #fff, #e6e6e6) !important;
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fff), to(#e6e6e6)) !important;
        background-image: -webkit-linear-gradient(top, #fff, #e6e6e6) !important;
        background-image: -o-linear-gradient(top, #fff, #e6e6e6) !important;
        background-image: linear-gradient(to bottom, #fff, #e6e6e6) !important;
        background-repeat: repeat-x !important;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf !important;
        border-color: rgba(0, 0, 0, .1) rgba(0, 0, 0, .1) rgba(0, 0, 0, .25) !important;
        color: #333 !important;
        text-shadow: 0 1px 1px rgba(255, 255, 255, .75) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.2),0 1px 2px rgba(0,0,0,.05) !important;
    }
    .fc-button-primary {
        border: 1px solid;
    }
    .fc button .fc-icon {
        position: relative;
        top: -.05em;
        margin: 0 .2em;
        vertical-align: middle;
    }
    .fc-icon {
        display: inline-block;
        width: 1em;
        height: 1em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
        overflow: hidden;
        font-family: "Courier New", Courier, monospace;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .fc-button-active, .fc-button-down {
        background-color: #ccc !important;
        background-image: none !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, .15), 0 1px 2px rgba(0, 0, 0, .05) !important;
    }
    .fc-button-active, .fc-button-disabled, .fc-button-down, .fc-button-hover {
        color: #333 !important;
        background-color: #e6e6e6 !important;
    }
    
    .fc-list-table .fc-event, .fc-event:hover, .ui-widget .fc-event {
        color: #333; 
    }
    .fc-list-table .fc-event {
        border-radius: unset; 
        border: unset; 
        background-color: unset; 
    }
    .fc-list-table .fc-event > td:last-child {
        width: 100%;
    }
    .fc-list-table .fc table {
        table-layout: unset !important;
    }
    
    .fc table {
        width: 100%;
        table-layout: auto;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Calendar</span>
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#addNew_payroll_periods">Add Event</a>
                                    </div>
                                    <ul class="nav nav-tabs">
                                         <li class="active">
                                            <a href="#tab_Calendar" data-toggle="tab"> Calendar </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_Calendar">
                                             <div class="row">
                                                <div class="col-md-12">
                                                    <div id="calendar_data"> </div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Create Project MODAL AREA-->
                         <!--Certification MODAL AREA-->
                       
                        <?php include "mypro_function/modals.php"; ?>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="//cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            // for My Task 
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar_data')
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    // plugins: [ dayGridPlugin, interactionPlugin ],
                    themeSystem: 'bootstrap5',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next,today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listYear' // user can switch between the two
                    },
                    buttonText: {
                      'today': 'Today',
                      'dayGridMonth': 'Month',
                      'timeGridWeek': 'Week',
                      'timeGridDay': 'Day',
                      'listYear': 'Agenda'
                    },
                    events:'crm/fetch_calendar.php',
                    eventClick: function(event) {
                        if (event.event.url) {
                          event.jsEvent.preventDefault();
                          window.open(event.event.url, "_blank");
                        }
                    }
                })
                calendar.render()
            })
            // $(document).ready(function(){
            //     // calendar
            //     var calendar = $('#calendar_data').fullCalendar({
            //         header:{
            //             left:'prev,next today',
            //             center:'title',
            //             right:'month,agendaWeek,agendaDay,listDay,listWeek,listMonth,listYear'
            //         },
            //         // editable:true,
            //         disableDragging: true,
            //         events:'crm/fetch_calendar.php',
            //         eventClick:  function(event) {
            //             var id = event.id;
            //             url = 'customer_details.php?view_id='+id+'#contact_tasks';
            //             // location.href = url;
            //             window.open(url, '_blank');
            //         },
            //     });
            //     //filter
            //     function filter_data() {
            //         var stat = get_filter('status');
            //          //alert("MyPro.php?status="+stat+" #tblAssignTask");
            //         $("#tblAssignTask").load("MyPro.php?status="+stat+" #tblAssignTask");
            //     }
                
            //     function filter_data_all() {
            //         $("#tblAssignTask").load("MyPro.php #tblAssignTask");
            //     }
                
            //     function get_filter(class_name) {
            //         var filter = [];
            //         $('.'+class_name+':checked').each(function(){
            //             filter.push($(this).val());
            //         });
            //         return filter;
            //     }
            
            //     $('.common_selector').click(function(){
            //         filter_data();
            //     });
            //     // view all
            //     $('.common_selector_all').click(function(){
            //         filter_data_all();
            //     });
            // });
            
            // Edit on calendar modal
            $(".calendarModal").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_calendar',true);
            
                var l = Ladda.create(document.querySelector('#btnSubmit_calendar'));
                l.start();
            
                $.ajax({
                    url: "mypro_function/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Updated Sucessfully!";
                            $('#get_calendar_data').empty();
                            $('#get_calendar_data').append(response);
                            selectMulti();
                            //  $('#calendarModal').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add event modal
            $(".addNew_payroll_periods").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnAdd_payroll_periods',true);
            
                var l = Ladda.create(document.querySelector('#btnAdd_payroll_periods'));
                l.start();
            
                $.ajax({
                    url: "mypro_function/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Added Sucessfully!";
                            location.reload();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add event modal
            $(".addNew").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnCreate_Project',true);
            
                var l = Ladda.create(document.querySelector('#btnCreate_Project'));
                l.start();
            
                $.ajax({
                    url: "mypro_function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Added Sucessfully!";
                            $('#project_data').append(response);
                            $('#addNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
        </script>
    </body>
</html>
