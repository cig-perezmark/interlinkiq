<?php 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "E-forms Catalog";
    $site = "form-catalog";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('../../header.php'); 
    
?>
<style type="text/css">
    /*Loader*/
    .loader {
      display: inline-block;
      width: 30px;
      height: 30px;
      position: relative;
      border: 4px solid #Fff;
      top: 50%;
      animation: loader 2s infinite ease;
    }
    
    .loader-inner {
      vertical-align: top;
      display: inline-block;
      width: 100%;
      background-color: #fff;
      animation: loader-inner 2s infinite ease-in;
    }
    
    @keyframes loader {
      0% {
        transform: rotate(0deg);
      }
      
      25% {
        transform: rotate(180deg);
      }
      
      50% {
        transform: rotate(180deg);
      }
      
      75% {
        transform: rotate(360deg);
      }
      
      100% {
        transform: rotate(360deg);
      }
    }
    
    @keyframes loader-inner {
      0% {
        height: 0%;
      }
      
      25% {
        height: 0%;
      }
      
      50% {
        height: 100%;
      }
      
      75% {
        height: 100%;
      }
      
      100% {
        height: 0%;
      }
    }
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
    /* Define spinning animation */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Apply spinning animation to glyphicon-refresh class */
    .glyphicon-spin {
        display: inline-block;
        -webkit-animation: spin 1s infinite linear;
        animation: spin 1s infinite linear;
    }
    .d-none {
        display:none!important;
    }
    .margin-5 {
        margin-top: 5em;
    }
    .modal-xxl {
        width: 1700px;
    }
    .list-group-item {
        border:none;
    }
    .border {
        border: 1px solid #e7ecf1;
        margin-top:3.28;
    }
    .filter-flex {
        display:flex;
        flex-direction: column;
    }
    .filter--title {
        margin-top: 2rem;
    }
    table th{
        text-transform: uppercase;
        /*text-align: center;*/
    }
    .d-flex {
        display: flex;
    }
    .justify-content-end{
        justify-content: end;
    }
    .mt-2{
        margin-top: 2rem;
    }
    .nav-tabs {
        border-bottom: 1px solid transparent;
    }
    #actionBtn {
        position: fixed;
        right: 0;
        bottom: 0;
        padding: 0 100px 25px 0;
        z-index: 4;
    }
    
    .col1{
        padding: 1rem 0;
    }
    .col2 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }
    .d-flex {
        display: flex;
    }
    .justify-content-center {
        justify-content: center;
    }
    .justify-content-between {
        justify-content: space-between;
    }
    .dt-buttons {
        margin: 2rem 0;
    }
    .page-container-bg-solid .tabbable-line>.tab-content {
        border-top: 1px solid transparent;
    }
    .tabbable-line>.tab-content {
        padding: 0;
    }
    /* .widget-thumb .widget-thumb-wrap {
        overflow: unset;
    }
    .table-scrollable {
        overflow: unset;
        z-index: 2;
    } */
    .swal2-container {
        z-index: 9999;
    }

    .table-scrollable {
        overflow-y: auto;
    }
</style>
    <div class="row">
        <div class="col-md-12">
           <h1>TEST 123</h1>
        </div>
    </div>

    <?php include_once ('../../footer.php'); ?>
    </body>
</html>