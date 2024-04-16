<?php 
    $title = "Product and Formulation";
    $site = "product_formulation";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
   .has-error {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
   }

   .mt12 {
      margin-top: 12px;
   }

   .ml12 {
      margin-left: 12px;
   }

   .mb12 {
      margin-bottom: 12px;
   }

   .mr12 {
      margin-right: 12px;
   }

   .sig_bg {
      border: 1px solid #888282;
   }

   .swal-container {
      z-index: 2000;
   }

   .main-image,
   .main-image img {
      width: 100%;
      height: 400px;
   }

   .sub-image,
   .sub-image img {
      width: 100%;
      height: 150px;
   }

   .image-file {
      margin-top: 10px;
   }

   .packaging_cb {
      margin-left: 24px;
   }

   .formulation_title {
      margin: 12px 0 12px 0;
   }

   textarea {
      resize: vertical;
   }
</style>

<div class=container-fluid>
   <div class=row>
      <div class="col-lg-12">
         <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#product_tab">Product</a></li>
            <li><a data-toggle="tab" href="#formulation_tab">Formulation</a></li>
         </ul>

         <div class="tab-content">
            <?php include_once ("view_product.php"); ?>
            <?php include_once ("view_formulation.php"); ?>
         </div>
      </div>
   </div>
</div>
<?php include_once ("modals_product_and_formulation.php"); ?>
<?php include_once ('footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jSignature/2.1.3/jSignature.min.js"></script>
<script>
   const SESSION_NAME = `<?php echo "Alex Polo"; ?>`;
   const SESSION_POSITION = `<?php echo "Encoder"; ?>`;
   const CURRENT_DATE = `<?php echo date("Y-m-d"); ?>`;
</script>
<script src="product_and_formulation.js" type="text/javascript"></script>
</body>

</html>