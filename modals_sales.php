<div class="modal fade" id="add_so_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>Sales Order<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <div class="row">
                     <?= create_el(2, "Sales Order #", '<input type="text" class="form-control" name="sales_order" required>'); ?>
                     <?= create_el(4, "Customer Name", '<input type="text" class="form-control" name="customer_name" required>'); ?>
                     <?= create_el(2, "Currency", '<input type="text" class="form-control" name="currency" required>'); ?>
                     <?= create_el(2, "Created Date", '<input type="date" class="form-control" name="created_date" required readonly>'); ?>
                     <?= create_el(2, "Delivery Deadline", '<input type="date" class="form-control" name="delivery_deadline" required>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(8, "Remarks", '<textarea class=form-control name=remarks></textarea>'); ?>
                     <?= create_el(2, "Stocks", '<input type="text" class="form-control" name="stocks" readonly>'); ?>
                     <?= create_el(2, "Total Amount", '<input type="text" class="form-control" name="total_amount" readonly>'); ?>
                  </div>
               </form>
                  <div class="row">
                     <?= create_el(4, "Select Product", '<select class=form-control id=product_select></select>'); ?>
                  </div>
                  <div class="row">
                     <div class=col-lg-12>
                        <div class="form-group">
                           <label>Items</label>
                           <table class="products_table table table-bordered xtable-striped table-condensed">
                              <thead>
                                 <tr>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">UoM</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Material Stocks</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                              </thead>
                              <tbody></tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-lg-offset-4 col-lg-4">
                        <div id=create_so_sig_container class=text-center></div>  
                     </div>
                  </div>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(); ?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="view_so_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>Sales Order<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <div class="row">
                     <?= create_el(2, "Sales Order #", '<input type="text" class="form-control" name="sales_order" disabled>'); ?>
                     <?= create_el(4, "Customer Name", '<input type="text" class="form-control" name="customer_name" disabled>'); ?>
                     <?= create_el(2, "Currency", '<input type="text" class="form-control" name="currency" disabled>'); ?>
                     <?= create_el(2, "Created Date", '<input type="date" class="form-control" name="created_date" disabled>'); ?>
                     <?= create_el(2, "Delivery Deadline", '<input type="date" class="form-control" name="delivery_deadline" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(8, "Remarks", '<textarea class=form-control name=remarks disabled></textarea>'); ?>
                     <?= create_el(2, "Stocks", '<input type="text" class="form-control" name="stocks" disabled>'); ?>
                     <?= create_el(2, "Total Amount", '<input type="text" class="form-control" name="total_amount" disabled>'); ?>
                  </div>
               </form>
               <div class="row">
                  <div class=col-lg-12>
                     <div class="form-group">
                        <label>Items</label>
                        <table class="table table-bordered xtable-striped table-condensed">
                           <thead>
                              <tr>
                                 <th class=text-center>Product Name</th>
                                 <th class=text-center>Description</th>
                                 <th class=text-center>Quantity</th>
                                 <th class=text-center>UoM</th>
                                 <th class=text-center>Unit Price</th>
                                 <th class=text-center>Total Price</th>
                                 <th class=text-center>Material Stocks</th>
                                 <th class=text-center>Production Status</th>
                                 <th class=text-center>Action</th>
                              </tr>
                           </thead>
                           <tbody></tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-lg-offset-4 col-lg-4">
                     <div id=view_so_sig_container class=text-center></div>  
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(false); ?>
         </div>
      </div>
   </div>
</div>

<?php

   function create_el($col_num, $label, $input){
      $el = '<div class=col-lg-'.$col_num.'>';
      $el .= '<div class="form-group">';
      $el .= '<label>'.$label.'</label>';
      $el .= $input;
      $el .= '</div>';
      $el .= '</div>';
      return $el;
   }

   function submit_cancel($with_submit = true){

      $div = "<span class=loading></span>";
      if($with_submit == true){
         $div = '<button type="button" class="btn btn-primary submit">Save</button>';
      }
      $div .= '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
      return $div;
   }
?>
