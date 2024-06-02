<?php 
    $title = "PRP";
    $site = "prp";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                    <div class="theme-panel">
                        <div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
                            <i class="icon-settings"></i>
                        </div>
                        <div class="toggler-close">
                            <i class="icon-close"></i>
                        </div>
                        <div class="theme-options">
                            <div class="theme-option theme-colors clearfix">
                                <span> THEME COLOR </span>
                                <ul>
                                    <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                                    <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                                    <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                                    <li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark"> </li>
                                    <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                                </ul>
                            </div>
                            <div class="theme-option">
                                <span> Theme Style </span>
                                <select class="layout-style-option form-control input-small">
                                    <option value="square" selected="selected">Square corners</option>
                                    <option value="rounded">Rounded corners</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Layout </span>
                                <select class="layout-option form-control input-small">
                                    <option value="fluid" selected="selected">Fluid</option>
                                    <option value="boxed">Boxed</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Header </span>
                                <select class="page-header-option form-control input-small">
                                    <option value="fixed" selected="selected">Fixed</option>
                                    <option value="default">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Top Dropdown</span>
                                <select class="page-header-top-dropdown-style-option form-control input-small">
                                    <option value="light" selected="selected">Light</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Mode</span>
                                <select class="sidebar-option form-control input-small">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Style</span>
                                <select class="sidebar-style-option form-control input-small">
                                    <option value="default" selected="selected">Default</option>
                                    <option value="compact">Compact</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Menu </span>
                                <select class="sidebar-menu-option form-control input-small">
                                    <option value="accordion" selected="selected">Accordion</option>
                                    <option value="hover">Hover</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Position </span>
                                <select class="sidebar-pos-option form-control input-small">
                                    <option value="left" selected="selected">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Footer </span>
                                <select class="page-footer-option form-control input-small">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- END THEME PANEL -->
                    <div class=container-fluid>
                        <div class=row>
                            <div class="col-12">
                                <h4 class="text-left"><strong><?php echo $title; ?></strong></h4>
                            </div>
                        </div>
                        <div class=row>
                            <div class="col-12">
                                <form class="form-inline pull-right">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input name="start_date" type="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input name="end_date" type="date" class="form-control">
                                    </div>
                                    <input type=button id=generate_report_btn class="btn btn-primary btn-sm" onclick="btnGenerate(this)" value="Generate Report">
                                </form>
                            </div>
                        </div>
                        <div class=row>
                            <div class="col-12">
                                <table id=main class="mt-1 table table-bordered table-sm table-condensed"></table> 
                            </div>
                        </div>
                        <div class=row>
                            <div class="col-12">
                                <table id=legend class="table table-borderless">
                                 <thead>
                                    <tr>
                                       <th colspan=2 class=text-left>Legend:</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td style="width:35px;height:35px;background-color:#16a085";></td>
                                       <td class=ps-3>Performed - All is well</td>
                                    </tr>
                                    <tr>
                                       <td style="width:35px;height:35px;background-color:#e59866";></td>
                                       <td class=ps-3>Encountered Issue</td>
                                    </tr>
                                 </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        <script type="text/javascript">
            function btnGenerate(e) {
                var start_date = $(e).parent().find('input[name="start_date"]').val();
                var end_date = $(e).parent().find('input[name="end_date"]').val();
                
                $.ajax({
                    type: "GET",
                    url: "prp/forms",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    dataType: "html",
                    success: function(response){
                        // alert(response);
                        var header = build_header(start_date, end_date);
                        var body   = build_body(response, start_date, end_date);
                        $("#main").html(header+body);
                    }
                    // error: function (response) {
                    //     // Swal.hideLoading();
                    // },
                    // beforeSend: function () {
                    //     // show_loader();
                    // }
                });
            }

            function get_dates(startDate, endDate) {

                startDate = new Date(startDate);
                endDate = new Date(endDate);

                const currentDate = new Date(startDate.getTime());
                const dates = [];
                while (currentDate <= endDate) {
                    var date = new Date(currentDate).toLocaleString('en-us',{month:'short', day:'numeric'});
                    dates.push(date);
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                return dates;
            }
            
            function build_header(start_date, end_date){
                var dates = get_dates(start_date, end_date);
                var header = `<thead style="background-color:#faf8dc;">
                    <tr>
                        <th rowspan=2 max-width=350 class="text-center">PRP</th>`;
                dates.forEach((elem)=>{
                    header += `<th colspan=3 class="text-center">${elem}</th>`;
                });
                header += `</tr><tr>`;
                dates.forEach((elem)=>{
                    header += "<th width=30 class=text-center>Per</th>";
                    header += "<th width=30 class=text-center>Rev</th>";
                    header += "<th width=30 class=text-center>Dev</th>";
                });
                header += `</tr></thead>`;
                return header;
            }

            function build_body(response, start_date, end_date){
                // console.log(response)
                response = JSON.parse(response);
                
                var body = "<tbody>";
                    if (start_date && end_date) {
                        response.forEach((elem)=>{
                            body += `<tr>`;
                            body += `<td style='background-color: #fff;'>${elem.name}</td>`;
                            elem.data.forEach((el)=>{
                                body += `<td style='background-color: ${el.performed};'></td>`;
                                body += `<td style='background-color: ${el.reviewed};' form-link='${el.r_form == null ? "" : el.r_form}'></td>`;
                                body += `<td class=text-center style='background-color: ${el.deviation};' form-link='${el.d_form == null ? "" : el.d_form}'>${el.total_errors == null || el.total_errors == "0" ? "" : el.total_errors}</td>`;
                            })
                            body += `</tr>`;
                        });
                    }
                body += "</tbody>";
                return body;
            }
        </script>
    </body>
</html>