<?php 
    $title = "Food Safety Culture Analysis Trend Analysis";
    $site = "fscs-trend-analysis";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .fscs_ta_reporttype_filter {
        display: inline-block;
        padding-left : 10px;
        margin-left : 10px;
        border-left: 1px solid #2A344A;
    }
    .fscs_ta_summaryTbl {
        width : 90%;
        margin : auto;
    }
    .fscs_ta_printable_title>h3{
        margin: 5px 0px;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase">Food Safety Culture Survery Trend Analysis</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-sm-12 form-inline text-right">
                            <div class="form-group form-inline">
                                <label class="bold">Report Type : </label>
                                <select class="form-control fscs_ta_reporttype select2  ">
                                    <option value="" selected disabled></option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="annually">Annually</option>
                                </select>
                            </div>
                            <div class="fscs_ta_reporttype_filter fscs_ta_reporttype_filter_monthly hidden">
                                <div class="form-group form-inline">
                                    <label>Month : </label>
                                    <select class="form-control fscs_ta_reporttype_filter_monthly_month">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label>Year : </label>
                                    <input type="number" class="form-control fscs_ta_reporttype_filter_monthly_year" style="width:100px;" value="<?php echo date('Y'); ?>" >
                                </div>
                                <button class="btn btn-primary fscs_ta_reporttype_filter_monthly_generateBtn" style="margin-left:10px;"><i class="fa fa-file-text-o"></i> Generate Report</button>
                                <button class="btn btn-danger fscs_ta_reporttype_filter_monthly_printBtn" style="margin-left:10px;"><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="fscs_ta_reporttype_filter fscs_ta_reporttype_filter_quarterly hidden">
                                <div class="form-group form-inline">
                                    <label>Quarter : </label>
                                    <select class="form-control fscs_ta_reporttype_filter_quarterly_quarter">
                                        <option value="1,2,3">1st Quarter (Jan-Mar)</option>
                                        <option value="4,5,6">2nd Quarter (Apr-Jun)</option>
                                        <option value="7,8,9">3rd Quarter (Jul-Sep)</option>
                                        <option value="10,11,12">4th Quarter (Oct-Dec)</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label>Year : </label>
                                    <input type="number" class="form-control fscs_ta_reporttype_filter_quarterly_year" style="width:100px;" value="<?php echo date('Y'); ?>">
                                </div>
                                <button class="btn btn-primary fscs_ta_reporttype_filter_quarterly_generateBtn"  style="margin-left:10px;"><i class="fa fa-file-o"></i> Generate Report</button>
                                <button class="btn btn-danger fscs_ta_reporttype_filter_monthly_printBtn" style="margin-left:10px;"><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="fscs_ta_reporttype_filter fscs_ta_reporttype_filter_annually hidden">
                                <div class="form-group form-inline">
                                    <label>Year : </label>
                                    <input type="number" class="form-control fscs_ta_reporttype_filter_annually_year" style="width:100px;" value="<?php echo date('Y'); ?>">
                                </div>
                                <button class="btn btn-primary fscs_ta_reporttype_filter_annually_generateBtn" style="margin-left:10px;"><i class="fa fa-file-o"></i> Generate Report</button>
                                <button class="btn btn-danger fscs_ta_reporttype_filter_monthly_printBtn" style="margin-left:10px;"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div> 
                    <hr>
                    <div class="tab-content" id="fscs_ta_printable">
                        <div class="fscs_ta_printable_title text-center">
                            <img src="companyDetailsFolder/logo-sample.png" height="70px"></img>
                            <h3 class="text-center bold">FOOD SAFETY CULTURE SURVEY TREND ANALYSIS</h3>
                            <p class="text-center bold">FOR THE <span class="fscs_ta_title_type" style="min-width:50px;display: inline-block;"></span> OF <span class="fscs_ta_title_val" style="min-width:50px; border-bottom:1px solid #000; display: inline-block;"></span></p>
                        </div>
                        <div id="echarts_bar" style="height:500px;"></div>
                        <div class="fscs_ta_printable_table">
                            <table class="table table-bordered fscs_ta_summaryTbl">
                                <thead>
                                    <tr>
                                        <th class="text-center">Survey No.</th>
                                        <th>Survey</th>
                                        <th class="text-center">Strongly<br>Agree</th>
                                        <th class="text-center">Agree</th>
                                        <th class="text-center">Disagree</th>
                                        <th class="text-center">Strongly<br>Disagree</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    	<!--[if lt IE 9]>
		<script src="../assets/global/plugins/respond.min.js"></script>
		<script src="../assets/global/plugins/excanvas.min.js"></script> 
		<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
		<![endif]-->
		<!-- BEGIN CORE PLUGINS -->
		<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

		<script src='https://htmlguyllc.github.io/jAlert/dist/jAlert.min.js'></script>
		<script src='admin_2/jTimeout.js'></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/jquery.mockjax.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
		
		<script src="assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
		
		<script src="assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>

		<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

		<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>

		<script src="//www.codehim.com/demo/checkall-select-all-checkboxes-in-table-column/js/checkAll.min.js"></script>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
        <!-- ================================================================================================= -->                                            
        <!-- Echart Plugins Here -->
        <script src="assets/global/plugins/echarts/echarts.js" type="text/javascript"></script>
        <script src="assets/global/plugins/html2pdf/html2pdf.bundle.min.js" type="text/javascript"></script>
        <!-- ================================================================================================= -->   

		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
		<script src="assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
		<script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
		<script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->

        <?php // include_once ('footer.php'); ?>

        <script type="text/javascript">
            var fscs_chart;

            $(document).ready(function(){
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};
                $('.select2').select2();
                

                $('.fscs_ta_reporttype').change(function(){
                    $('.fscs_ta_reporttype_filter').addClass('hidden');
                    if ( $(this).val()=="monthly" ){
                        $('.fscs_ta_reporttype_filter_monthly').removeClass('hidden');
                    }else if($(this).val()=="quarterly"){
                        $('.fscs_ta_reporttype_filter_quarterly').removeClass('hidden');
                    }else if($(this).val()=="annually"){
                        $('.fscs_ta_reporttype_filter_annually').removeClass('hidden');
                    }
                });
                
                // Monthly
                $('.fscs_ta_reporttype_filter_monthly_generateBtn').click(function(){
                    var m       = $('.fscs_ta_reporttype_filter_monthly_month').val();
                    var m_val   = $('.fscs_ta_reporttype_filter_monthly_month').find(':selected').text();
                    var y       = $('.fscs_ta_reporttype_filter_monthly_year').val();

                    $('.fscs_ta_title_type').html("MONTH");
                    $('.fscs_ta_title_val').html(m_val);
                    load_fscs_ta_data(m,y);
                });

                // Quarterly
                $('.fscs_ta_reporttype_filter_quarterly_generateBtn').click(function(){
                    var m     = $('.fscs_ta_reporttype_filter_quarterly_quarter').val();
                    var m_val = $('.fscs_ta_reporttype_filter_quarterly_quarter').find(':selected').text();
                    var y = $('.fscs_ta_reporttype_filter_quarterly_year').val();
                    
                    $('.fscs_ta_title_type').html("QUARTER");
                    $('.fscs_ta_title_val').html(m_val);
                    load_fscs_ta_data(m,y);
                });

                // Yearly
                $('.fscs_ta_reporttype_filter_annually_generateBtn').click(function(){
                    var m = "1,2,3,4,5,6,7,8,9,10,11,12";
                    var y = $('.fscs_ta_reporttype_filter_annually_year').val();

                    $('.fscs_ta_title_type').html("YEAR");
                    $('.fscs_ta_title_val').html(y);
                    load_fscs_ta_data(m,y);
                });
                
                $('.fscs_ta_reporttype_filter_monthly_printBtn').click(function(){
                    var divtitle = $('.fscs_ta_printable_title').html();
                    var divtable = $('.fscs_ta_printable_table').html();
                    setTimeout(function(){
                        var a = window.open('', '', 'height=600, width=700'); 
                        a.document.write('<html>'); 
                        a.document.write('<style>.text-center{ text-align:center; } .bold{ font-weight:bold; } .table{width:"100%", border:1px solid #000; border-collapse: collapse; margin-top:15px; } th, td{border:1px solid #000; padding:3px; font-size: 12px; } .fscs_ta_printable_title>img{height:40px;} h3{margin:0px 5px; font-size:16px;} p{margin:0px 5px;} </style>'); 
                        a.document.write('<body>'); 
                        a.document.write('<div style="text-align:center">'+divtitle+'</div>'); 
                        a.document.write('<div style="text-align:center; margin-top:15px; "><img src="'+fscs_chart.getDataURL()+'" width="80%" style="margin:auto;"></img></div>'); 
                        a.document.write(divtable); 
                        a.document.write('</body></html>'); 
                        a.document.close(); 
                        setTimeout(function(){
                            a.print();
                        },500);
                    }, 500);
                    
                });

                // Echart
                require.config({
                    paths: {
                        echarts: 'assets/global/plugins/echarts/'
                    }
                });

                require(
                    [
                        'echarts',
                        'echarts/chart/bar',
                        'echarts/chart/chord',
                        'echarts/chart/eventRiver',
                        'echarts/chart/force',
                        'echarts/chart/funnel',
                        'echarts/chart/gauge',
                        'echarts/chart/heatmap',
                        'echarts/chart/k',
                        'echarts/chart/line',
                        'echarts/chart/map',
                        'echarts/chart/pie',
                        'echarts/chart/radar',
                        'echarts/chart/scatter',
                        'echarts/chart/tree',
                        'echarts/chart/treemap',
                        'echarts/chart/venn',
                        'echarts/chart/wordCloud'
                    ],
                    function(ec) {
                        //--- BAR ---
                        fscs_chart = ec.init(document.getElementById('echarts_bar'));
                        load_fscs_ta_data(0,0);
                    }
                );
            });

            // get FSCS Data Summary
            function load_fscs_ta_data(m,y){
                $.ajax({
                    type: "GET",
                    url: "fscs_function.php",
                    data : { 
                        fscs_action : 'getFSCSData',
                        m : m,
                        y : y
                    },
                    success: function(result){
                        var result= JSON.parse(result);
                        console.log(result)
                        var data  = result.data;
                        if ( data!=null && data.length!=0 ){
                            var html = "";
                            var fscs_chart_category = [];
                            var fscs_chart_A = []; // Strongly Agree
                            var fscs_chart_B = []; // Agree
                            var fscs_chart_C = []; // Disagree
                            var fscs_chart_D = []; // Strongly Disagree
                            var fscs_chart_data = [];

                            for(var i=0; i<data.length; i++){
                                html += '<tr>';
                                html +=     '<td class="text-center">'+(i+1)+'</td>';
                                html +=     '<td>'+data[i]['question']+'</td>';
                                html +=     '<td class="text-center">'+data[i]['A']+'</td>';
                                html +=     '<td class="text-center">'+data[i]['B']+'</td>';
                                html +=     '<td class="text-center">'+data[i]['C']+'</td>';
                                html +=     '<td class="text-center">'+data[i]['D']+'</td>';
                                html += '</tr>';

                                fscs_chart_category.push(i+1);
                                fscs_chart_A.push(data[i]['A']);
                                fscs_chart_B.push(data[i]['B']);
                                fscs_chart_C.push(data[i]['C']);
                                fscs_chart_D.push(data[i]['D']);
                            }
                            fscs_chart_data = [{
                                    name: 'Strongly Agree',
                                    type: 'bar',
                                    data: fscs_chart_A,
                                    itemStyle: {
                                        normal: {
                                            color: '#04364A'
                                        }
                                    }
                                },
                                {
                                    name: 'Agree',
                                    type: 'bar',
                                    data: fscs_chart_B,
                                    itemStyle: {
                                        normal: {
                                            color: '#176B87'
                                        }
                                    }
                                },
                                {
                                    name: 'Disagree',
                                    type: 'bar',
                                    data: fscs_chart_C,
                                    itemStyle: {
                                        normal: {
                                            color: '#64CCC5'
                                        }
                                    }
                                },
                                {
                                    name: 'Strongly Disagree',
                                    type: 'bar',
                                    data: fscs_chart_D,
                                    itemStyle: {
                                        normal: {
                                            color: '#DAFFFB'
                                        }
                                    }
                                }];

                            $('.fscs_ta_summaryTbl>tbody').html(html);

                            fscs_chart.setOption({
                                tooltip: {
                                    trigger: 'axis'
                                },
                                legend: {
                                    data: ['Strongly Agree','Agree','Disagree','Strongly Disagree']
                                },
                                toolbox: {
                                    show: true,
                                    feature: {
                                        mark: {
                                            show: true
                                        },
                                        dataView: {
                                            show: true,
                                            readOnly: false
                                        },
                                        magicType: {
                                            show: true,
                                            type: ['line', 'bar']
                                        },
                                        restore: {
                                            show: true
                                        },
                                        saveAsImage: {
                                            show: true
                                        }
                                    }
                                },
                                calculable: true,
                                xAxis: [{
                                    type: 'category',
                                    data: fscs_chart_category
                                }],
                                yAxis: [{
                                    type: 'value',
                                    splitArea: {
                                        show: true
                                    }
                                }],
                                series: fscs_chart_data
                            });
                        }
                    },error: function(err){
                        console.log(err);
                    }
                });
            }
            
        </script>