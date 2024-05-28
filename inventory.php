<?php 
   $title = "Inventory System";
   $site = "inventory";
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
   <div class=row>
      <div class="col-lg-12">
         <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#warehouse_tab">Warehouse</a></li>
            <li><a data-toggle="tab" href="#purchases_tab">Purchase</a></li>
         </ul>

         <div class="tab-content">
            <?php include_once("view_inventory_warehouse.php"); ?>
            <?php include_once("view_inventory_purchases.php"); ?>   
         </div> 
      </div>
   </div>
</div>
<?php include_once("modals_inventory.php"); ?>            
<?php include_once('footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jSignature/2.1.3/jSignature.min.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script>
   var current_date = `<?php echo date("Y-m-d"); ?>`
</script>
<script src="inventory.js" type="text/javascript"></script>
</body>
</html>