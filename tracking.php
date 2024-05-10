<?php 
    $title = "Tracking Dashboard";
    $site = "tracking";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
    .modalNew img {
        width: 100%;
        filter: grayscale(1);
    }
    .modalNew h1 {
        margin: auto;
        text-align: center;
    }
    .modalNew .cover,
    .modalView .cover {
        display: flex;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px 30px;
    }
    .modalView img {
        width: 100%;
    }
    .modalView h3 {
        margin: auto;
        font-weight: bold;
        font-size: clamp(18px, 1.5vw, 22px);
        text-align: center;
    }
    .legend-holder{
        width:100%;
        height:40px;
    }
    .legend{
        width:33.33%;
        height:100%;
        border:solid white 1px;
        float:left;
        text-align: center;
        vertical-align: middle;
        line-height: 40px; 
        color:black !important;
        font-weight:bold;
        
    }
    .green{
        background-color:#34a853;
    }
    .orange{
        background-color:#fbbc04;
    }
    .red{
        background-color:#ea4335;
    }
    .frequency{
        display:inline-block;
        color:#335b86;
        text-transform: capitalize;
    }
    #main-box{
        padding:20px;
        box-sizing:border-box;
        width:100%;
    }
    .card{

        display:inline-block;
        height:220px;
        float:left;
        margin-top:20px;
    }
    .searchbarholder{
        margin:0 auto;
        width:500px;
    }
    
    .tableCenter {
        text-align: center;
        vertical-align: middle !important;
    }
    table#main {
        width: calc(100% - 100px);
    }
    /* Far right headers top border (it's outside the table) */
    /*table:after { 
        content: '';
        display: block;
        position: absolute;
        border-top: solid 1px #000;
        width: 101px;
        right: -101px;
        top: 0;
    }*/

    /* 
     - Apply header background/font colour 
     - Set base z-index for IE 9 - 10
    */
    table#main th:before {
        background: #FFF2CC;
        z-index: 1;
    }

    /* min-width and max-width together act like a width */
    table#main thead tr:nth-child(1) th:first-child,
    table#main thead tr:last-child th {
        height: 100px;
    }
    table#main thead tr:first-child th:nth-child(n+2) {
        position: relative;
        height: 32px;
        border: none;
        border-top: 1px solid;
    }
    table#main thead tr:first-child th:nth-child(n+2) span {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 100px;
        right: -100px;
        display: block;
        border: 1px solid;
        padding: 5px;
        background: #FFF2CC;
    }
    table#main thead tr:last-child th {
        border: none;
        min-width: 40px;
        max-width: 40px;
        position: relative;
    }

    /* Pseudo element borders */
    table#main thead tr:last-child th:before {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        right: -50px;
        height: 100px;
        width: 100%;
        border: solid 1px #000;
        transform: skew(-45deg);
        border-right: none;
    }
    table#main thead tr:last-child th:last-child:before {
        border-right: 1px solid;
    }

    /* Apply the right border only to the last pseudo element */
    table#main thead th:last-child:before {
        border-right: solid 1px #000;
    }

    /* Apply the top border only to the first rows cells */
    table#main tbody tr:first-child td {
        border-top: solid 1px #000;
    }

    /* 
     - Rotate and position headings
     - Padding centers the text vertically and does the job of height
     - z-index ensures that the text appears over the background color in IE 9 - 10
    */
    table#main thead tr:last-child th span {
        transform: rotate(-45deg);
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        left: 50%;
        right: 50%;
        bottom: 29px;
        height: 0;
        padding: 0.75em 0 1.85em;
        width: 100px;
        z-index: 2;
    }


    /* Create first two th styles */
    table#main th:nth-child(1)  {
        border: solid 1px #000;
        border-bottom: none;
        border-right: none;
        border-bottom: 1px solid #000 !important;
    }
    table#main th:nth-child(1):before  {
        display: none;  
    }

    table#main td {
        border: solid 1px #000;
    }

    table#main tfoot { 
        border: solid 1px #000;
    }
    .box-container {
      display:flex;
      flex-wrap: wrap;
      flex-direction: row;
    }
    .box {
      background-color:#fff; 
      border-radius:2px !important;
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      transition: all 0.3s cubic-bezier(.25,.8,.25,1); 
    }
    .box:hover {
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
    .action{
    }
    .title {
      font-weight:600;
      margin-bottom: 13rem;
    }
    a:link { text-decoration: none; }


    a:visited { text-decoration: none; }
    
    
    a:hover { text-decoration: none; color: rgb(72, 103, 126) !important; }
    
</style>
                    <br/>
                    <div style="text-align:right;">
                        <?php if ($user_id == 3 OR $user_id == 163 OR $user_id == 1 OR $user_id == 777)   { ?>
                        
                        <button type="button" class="btn btn-primary" href="#modalView" data-toggle="modal" class="modalNew">
                           Add New Tracking &nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                        </button>
                                                
                      <?php } ?>
                    </div><br/>
                    
                    <div class="row" id="main-box">
                        
                        <div class="searchbarholder">
                          <input type="search" onkeyup="myFunction()" class="form-control" id="datatable-search-input" placeholder="Enter Key Word">
                        </div> <br/><br/>
                        
                        <?php
                            $selectData = mysqli_query( $conn,"SELECT * FROM tbl_tracking WHERE deleted = 0 ORDER BY name ASC" );
                            if ( mysqli_num_rows($selectData) > 0 ) {
                                while($rowData = mysqli_fetch_array($selectData)) {
                                    $data_ID = $rowData['ID'];
                                    $data_name = $rowData['name'];

                                    $data_file = $rowData['file'];
                                    $fileExtension = fileExtension($data_file);
                                    $src = $fileExtension['src'];
                                    $embed = $fileExtension['embed'];
                                    $type = $fileExtension['type'];
                                    $file_extension = $fileExtension['file_extension'];
                                    $url = $base_url.'uploads/tracking/';

                                    echo '<div class="col-md-2 margin-bottom-15" id="div_'.$data_ID.'">';
                                
                                        if ($current_userID == 163) {
                                            echo '<a href="javascript:;" class="btn btn-danger" onclick="btnDelete('.$data_ID.')" style="position: absolute; z-index: 2;"><i class="fa fa-trash"></i></a>';
                                        }
                                
                                        
                                        echo '<a data-src="'.$src.$url.rawurlencode($data_file).$embed.'" data-fancybox data-type="'.$type.'" class="modalView">
                                            <img src="uploads/bgBlue.png" class="img-thumbnail" />
                                            <div class="cover"><h3 class="font-white">'.$data_name.'</h3>
                                            </div>
                                        </a>
                                    </div>';
                                }
                            }
                            echo'
                                <div class="col-md-2 margin-bottom-15">
                                    <a href="https://interlinkiq.com/PRP_Tracking.php" class="modalView">
                                        <img src="uploads/bgBlue.png" class="img-thumbnail">
                                        <div class="cover">
                                            <h3 class="font-white">Tracking</h3>
                                        </div>
                                    </a>
                                </div>
                            ';
                            if ($current_userID == 163) {
                                echo '<div class="col-md-2 margin-bottom-15">
                                    <a href="#modalView" data-toggle="modal" class="modalNew">
                                        <img src="uploads/bgBlue.png" class="img-thumbnail" />
                                        <div class="cover">
                                            <h1 class="font-white"><i class="icon-plus"></i></h1>
                                        </div>
                                    </a>
                                </div>';
                            }
                        ?>
                        
                        
                        <!--<div class="box-container">-->
                        <?php 
                            $selectDataTracking = mysqli_query( $conn,"SELECT * FROM tbl_tracking WHERE deleted = 0 AND status = 1 ORDER BY name ASC" );
                            if ( mysqli_num_rows($selectDataTracking) > 0 ) {
                                while($rowData = mysqli_fetch_array($selectDataTracking)) {
                                    $data_name = $rowData['name'];
                                    $data_ID = $rowData['ID'];
                                    $data_link = $rowData['module_link'];
                                    
                                    $data_file = $rowData['file'];
                                    $fileExtension = fileExtension($data_file);
                                    $src = $fileExtension['src'];
                                    $embed = $fileExtension['embed'];
                                    $type = $fileExtension['type'];
                                    $file_extension = $fileExtension['file_extension'];
                                    $url = $base_url.'uploads/tracking/';
                                    
                                    if ($current_userID == 481) {
                          ?>
                                        <div class="col-md-2">
                                    <div class="mt-widget-1 box">
                                        <div class="mt-head">
                                            <div class="mt-head-icon" style="margin-top: 2rem;">
                                                <span style="font-size:22px; border-radius: 50%!important; background-color: #eef1f5; margin:auto 0; padding: 5px;"><i class="icon-bar-chart" style="padding: 5px;"></i></span> 
                                            </div>
                                        </div>
                                        <div class="mt-body" style="margin-top: 2rem">
                                            <a href="<?=$data_link?>" target="_blank" class="text-dark" style="color: #000; align-text:left!important; font-weight:600;">
                                                <h5 class="mt-username" style="font-size: 14px!important; text-align:left"><?=$data_name?></h5>
                                            </a>
                                            <div class="mt-stats" style="margin-top: 5rem">
                                                <div class="btn-group btn-group-justified">
                                                    <a href="<?=$data_link?>" target="_blank" class="btn font-blue">
                                                        <i class="icon-eye"></i> View</a>
                                                     <?php if ($current_userID == 456 OR $current_userID == 163 OR $current_userID == 3) { ?> 
                                                    <a href="javascript:;" onclick="btnDelete('.$data_ID.')" class="btn font-red">
                                                        <i class="icon-trash"></i> Delete </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                        <!--<a style="font-weight:600; text" href="<?=$data_link?>" target="_blank">-->
                                        <!--  <div class="box">-->
                                        <!--    <div class="body">-->
                                        <!--    <h5 class="title"><?=$data_name?></h5>-->
                                        <!--      <div class="action">-->
                                        <!--        <a href="<?=$data_link?>" target="_blank" class="modalView btn btn-primary">View</a>-->
                                        <!--        <?php if ($current_userID == 456 OR $current_userID == 163 OR $current_userID == 3) {?>-->
                                        <!--        <a href="javascript:;" class="btn btn-danger" onclick="btnDelete('.$data_ID.')" style="position: absolute; z-index: 2;"><i class="fa fa-trash"></i></a>-->
                                        <!--        <?php }?>-->
                                        <!--      </div>-->
                                        <!--    </div>-->
                                        <!--  </div>-->
                                        <!--</a>  -->
                        <?php 
                                    }
                                }
                            }
                            
                            if ($current_userID == 1 OR $switch_user_id == 402) {
                                echo '<div class="card" style="width: 18rem;border:solid black 1px !important;background-color:#053262;padding:10px;border-radius:10px;color:white;margin-left:30px;">
                                    <div class="legend-holder">
                                        <div class="legend green">47</div>
                                        <div class="legend orange">62</div>
                                        <div class="legend red">61</div>
                                    </div>
                                
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Slaughter PRP-Tracking</strong></h5>
                                        <h6 class="card-text"></h6>
                                        <a href="#modalTracking" data-toggle="modal" class="modalView btn btn-primary" onclick="btnView(1)">View</a>&nbsp;
                                        <span class="frequency">Daily</span><br><br>
                                    </div>
                                </div>';
                            }
                        ?>
                        
                        <!--</div>-->
                    </div>




                    <!--<div class="row" id="dataRow">-->

                    <!--</div>-->
                    
                    <!--Add new Tracking Process -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form>
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Process Name / Title</label>
                                        <input type="text" class="form-control" id="process-name" aria-describedby="emailHelp" placeholder="Enter Process title">
                                        <small id="emailHelp" class="form-text text-muted">Enter the correct process name you want to track.</small>
                                      </div>
                                       <div class="form-group">
                                        <label for="exampleInputEmail1">Process Description</label>
                                        <input type="text" class="form-control" id="process-description" aria-describedby="emailHelp" placeholder="Enter Process description">
                                        <small id="emailHelp" class="form-text text-muted">Enter brief description about the process</small>
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Frequency</label>
                                        <select class="form-control" id="frequency" aria-describedby="emailHelp">
                                            <option>Daily</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                            <option>Yearly</option>
                                        </select>
                                        <small id="emailHelp" class="form-text text-muted">Frequency of the process to be performed/checked</small>
                                      </div>
                                      <input name="active_interprise" id="active_interprise" type="hidden" value="<?php echo $switch_user_id; ?>">
                                      <input type="hidden" name="active_user" id="active_user" value="<?php echo $user_id; ?>">
                                      
                                </form>
                                     </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"  id="submit-process">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                     <!--End Add new Tracking Process -->
                    

                    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalView">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Tracking</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Tracking Name</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="name" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Select File</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="file" name="file" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Tracking" id="btnSave_Tracking" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalTracking" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalTracking">
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script>
            function widget_date() {
                $('.daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto"
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function myFunction() {
                var input = document.getElementById("datatable-search-input");
                var filter = input.value.toLowerCase();
                var nodes = document.getElementsByClassName('card');
                
                for (i = 0; i < nodes.length; i++) {
                    if (nodes[i].innerText.toLowerCase().includes(filter)) {
                      nodes[i].style.display = "block";
                    } else {
                      nodes[i].style.display = "none";
                    }
                }
            }
            $(".modalView").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Tracking',true);

                var l = Ladda.create(document.querySelector('#btnSave_Tracking'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('#dataRow').prepend(obj.data);
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Tracking="+id,
                        dataType: "html",
                        success: function(response){
                            $('#div_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            $( "#submit-process" ).click(function() {
                   msg = "New Process Added!";
                   var process_name = $('#process-name').val();
                   var process_description = $('#process-description').val();
                   var frequency = $('#frequency').val();
                   var active_interprise = $('#active_interprise').val();
                   var active_user = $('#active_user').val();
                   
                   bootstrapGrowl(msg);
                   
                 $( "#main-box" ).prepend( '<div  class="card" style="width: 18rem;border:solid black 1px !important;background-color:#053262;padding:10px;border-radius:10px;color:white;margin-left:30px;"><div class="legend-holder"><div class="legend green">0</div><div class="legend orange">0</div><div class="legend red">0</div></div><div class="card-body"><h4 class="card-title"><strong>'+ process_name +'</strong></h4><h6 class="card-text">'+ process_description +'</h6><a href="#" class="btn btn-primary">View</a>&nbsp;<span class="frequency">'+ frequency+ '</span></div></div>' );
            });
            
            function btnView(frequency) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalTracking="+frequency,
                    dataType: "html",
                    success: function(data){
                        $("#modalTracking .modal-body").html(data);
                        widget_date();
                    }
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
                        <th rowspan=2 class="tableCenter bold text-center">PRP</th>`;
                        dates.forEach((elem)=>{
                            header += `<th colspan=3 class="text-center"><span>${elem}</span></th>`;
                        });
                        header += `</tr><tr>`;
                        dates.forEach((elem)=>{
                            header += "<th class=text-center><span>Per</span></th>";
                            header += "<th class=text-center><span>Rev</span></th>";
                            header += "<th class=text-center><span>Dev</span></th>";
                        });
                    header += `</tr></thead>`;
                return header;
            }
            function build_body(response, start_date, end_date){
                // console.log(response)
                response = JSON.parse(response);
                
                var body = "<tbody>";
                    if (start_date && end_date) {
                        for(var i=0; i < response.length; i++) {
                            var elem = response[i];
                        // }
                        // response.forEach((elem)=>{
                            body += `<tr>`;
                            body += `<td style='background-color: #fff;'>${elem.name}</td>`;
                            // console.log(elem);
                            for(var j=0; j < elem.data.length; j++) {
                                var el = elem.data[j];
                            // }
                            // elem.data.forEach((el)=>{
                                body += `<td style='background-color: ${el.performed};'></td>`;
                                body += `<td style='background-color: ${el.reviewed};' onclick='btnFormURL(this)' form-link='${el.r_form == null ? "" : el.r_form}'></td>`;
                                body += `<td class=text-center style='background-color: ${el.deviation};' onclick='btnFormURL(this)' form-link='${el.d_form == null ? "" : el.d_form}'>${el.total_errors == null || el.total_errors == "0" ? "" : el.total_errors}</td>`;
                            }
                            body += `</tr>`;
                        };
                    }
                body += "</tbody>";
                return body;
            }
            function btnGenerate(e) {
                var daterange = $(e).parent().parent().find('input[name="daterange"]').val();
                var dates = daterange.split(' - ');
                var start_date = dates[0];
                var end_date = dates[1];
                
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
            function btnFormURL(e) {
                var link = $(e).attr('form-link');
                if(link){
                    var contents = {
                        title: "Open Form",
                        text: "Would you like to open form?",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    };

                    swal(contents, function(result){
                        if(result){
                            window.open(link);
                        }
                    });
                }
            }
        </script>
    </body>
</html>