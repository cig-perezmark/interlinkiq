<?php 
    $title = "Sales";
    $site = "sales";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
   .mt12 {
      margin-top : 12px;
   }

   .sig_bg {
      border : 1px solid #888282;
   }

   .swal-container {
      z-index : 2000;
   }
</style>

<div class=container-fluid>
   <div id="sales_tab" class="tab-pane">      
      <ul class="nav nav-tabs">
         <li><a data-toggle="tab" href="#sales_open">Open</a></li>
         <li><a data-toggle="tab" href="#sales_done">Done</a></li>
      </ul>

      <div class="tab-content">
         <div id="sales_open" class="tab-pane fade">
            <div class="row">
               <div class="col-lg-6">
                  <h3 class=product_title>Sales Open</h3>
               </div>
               <div class="col-lg-6">
                  <input type=button class="btn btn-md btn-primary pull-right mt-2" value="Add Sales Order" id="add_so_btn">
               </div>
            </div>
            <div class="row mt12">
               <div class="col-12">
                  <div class="panel panel-default">
                     <div class="panel-body"><table class="main_table table table-bordered"></table></div>
                  </div> 
               </div>
            </div>
         </div>

         <div id="sales_done" class="tab-pane fade">
            <div class="row">
               <div class="col-lg-6">
                  <h3 class=product_title>Sales Done</h3>
               </div>
            </div>
            <div class="row mt12">
               <div class="col-12">
                  <div class="panel panel-default">
                     <div class="panel-body"><table class="main_table table table-bordered"></table></div>
                  </div> 
               </div>
            </div>
         </div>
      </div>     
   </div>
</div>
<?php include_once("modals_sales.php"); ?>            
<?php include_once('footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jSignature/2.1.3/jSignature.min.js"></script>
<script>
   var current_date = `<?php echo date("Y-m-d"); ?>`
</script>
<script src="sales.js" type="text/javascript"></script>
</body>
</html>
