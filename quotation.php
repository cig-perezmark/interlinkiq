<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Quotation";
    $site = "quotation";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
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
    .no-border{
        border:none;
    }
    .bottom-border{
        border:none;
        border-bottom:solid #ccc 1px;
    }
    .requirements_box{
        overflow:scroll;
        height:68vh;
    }
    .requirements_box input{
        margin-top: 2rem !important;
    }
    .header_box{
        margin-left:1rem;
    }
    .float-right{
        float:right;
    }
    .minusMtop{
        margin-top:-2rem !important;
    }
    textarea {
    width: 100%;
    resize: none;
    }
    .textarea {
      border: none;
      font-family: inherit;
      font-size: inherit;
      padding: 1px 6px;
    }
    .width-machine {
      /*   Sort of a magic number to add extra space for number spinner */
      padding: 0 1rem;
    }
    .frame-wrapper {
  /*position: fixed;*/
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
}

.frame {
  position: absolute;
  width: 100%;
  height: 100%;
}
    .textarea {
      display: block;
      width: 100%;
      overflow: hidden;
      resize: both;
      min-height: 40px;
      line-height: 20px;
    }
    
    .textarea[contenteditable]:empty::before {
      content: "";
      border:none;
      color: gray;
    }
@media screen {
  #pdf_generate {
      /*display: none;*/
      
  }
  .front-page{
      display:none;
  }
}

@media print {
  body * {
    visibility:hidden;
    margin-top:0 !important;
  }
  .requirements_box{
       display:none;
    }
  /*@page { size: A4 portrait; }*/
  .front-page .front-page *{
      visibility:visible;
  }
  
  #pdf_generate, #pdf_generate * {
    visibility:visible;
    font-size:12px;
  }
  #pdf_generate {
    /*height: 100vh;*/
    /*width: 100vw;*/
    /*display: flex;*/
    /*align-items: center;*/
    /*justify-content: center;*/
  }
  .minusMtop{
       margin-top:-2rem !important;
    }
    .textarea {
      border:none !important;
      font-family: inherit;
      font-size: inherit;
      padding: 1px 6px;
    }
    .width-machine {
      /*   Sort of a magic number to add extra space for number spinner */
      padding: 0 1rem;
    }
    
    .textarea {
      display: block;
      width: 100%;
      overflow: hidden;
      resize: both;
      min-height: 40px;
      line-height: 20px;
    }
    
    .textarea[contenteditable]:empty::before {
      content: "";
      color: gray;
    }
    
  .front-page{
    margin-top:-20rem !important;
    height:98vh;
    margin-left:0px !important;
    margin-right:0px !important;
    text-align: center;
    border: 1px solid transparent;
  }
  .front-page .cig{
      margin-top:-30rem !important;
      float:left !important;
  }
  .front-page .iiq{
      margin-top:-30rem !important;
      float:right !important;
  }
  .front-page .title-cig{
      padding-top:165px!important;
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .front-page .title-iiq{
      padding-bottom:45px !important;
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .front-page .info-data{
      font-size:28px;
      padding-bottom:-75rem  !important;
      font-family:Helvetica;
  }
  .intro{font-size:28px;font-family:Helvetica;}
  .cIiq{
      font-family:Helvetica;
      font-size:44px !important;
      font-weight:600;
  }
  .ddate{font-size:28px;font-family:Helvetica;}
  .pby{font-size:28px;font-family:Helvetica;}
      input[type="text"] {
        width: 100%;
    }
  table{padding:0px;}
}
</style>

<!--START MAIN ROW-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet light portlet-fit">
            <br>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Requirements&nbsp;
                                <a class="btn blue btn-xs btn-info btnView_requirement" data-toggle="modal" href="#add_requirement" ><i class="fa fa-plus"></i> Add Requirement</a>
                            </span>
                        </div>
                        <br>
                        <div class="header_box">
                            <div class="form-group">
                                <select id="single-append-radio" class="form-control select2-allow-clear" onchange="search_filter(this.value)" placeholder="Company Name">
                                    <option></option>
                                    <?php
                                       
                                        $queryType = "SELECT * FROM tbl_Customer_Relationship where account_name !='' order by account_name ASC";
                                        $resultType = mysqli_query($conn, $queryType);
                                    while($rowType = mysqli_fetch_array($resultType))
                                         { 
                                           echo '<option value="'.$rowType['crm_id'].'" >'.$rowType['account_name'].'</option>'; 
                                       } 
                                     ?>
                                </select>
                            </div>
                        
                             <div class="portlet-title tabbable-tabdrop tabbable-line">
                                 <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#services_tab" data-toggle="tab">Services</a>
                                    </li> 
                                    <li>
                                        <a href="#Paymenttab" data-toggle="tab">Payment</a>
                                    </li> 
                                    <li>
                                        <a href="#termstab" data-toggle="tab">Terms</a>
                                    </li> 
                                     <li>
                                        <a href="#category" data-toggle="tab">Category</a>
                                    </li>
                                    <li>
                                        <a href="#rec" data-toggle="tab">Records</a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        <div class="requirements_box">    
                         <div class="tab-content">
                             <div class="tab-pane" id="category">
                                 <div class="form-group">
                                     <br>
                                     <div class="col-md-12">
                                         <a class="btn blue btn-xs btn-info add_category" data-toggle="modal" href="#add_category" ><i class="fa fa-plus"></i> Add Category</a>
