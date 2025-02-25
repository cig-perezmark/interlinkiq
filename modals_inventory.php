<!-- purchases -->
<div class="modal fade" id="add_po_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <div class="row">
                     <?= create_el(6, "Supplier", "<select class=form-control name=supplier_id></select>"); ?>
                     <?= create_el(3, "Expected Arrival", '<input type="date" class="form-control" name="expected_arrival">'); ?>
                     <?= create_el(3, "Created Date", '<input type="date" class="form-control" name="created_date" readonly>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(6, "Purchase Order", '<input type="text" class="form-control" name="po" placeholder="Purchase Order">'); ?>
                     <?= create_el(3, "Location", "<select class=form-control name=location_id></select>"); ?>
                     <?= create_el(3, "Currency", '<input type="text" class="form-control" name="currency" placeholder="Currency">'); ?>
                  </div>
               </form>
               <div class="row">
                  <?= create_po_items_table(); ?>
               </div>
               <div class="row">
                  <?= create_el(12, "Remarks", "<textarea class=form-control id=remarks height=75></textarea>"); ?>
               </div>
               <div class="row">
                  <div class="col-lg-4 col-lg-offset-8">
                     <table class="table">
                        <tbody>
                           <tr>
                              <td><strong>Subtotal (Tax excluded)</strong></td>
                              <td><span id=sub_total></span></td>
                              <td><span class=display_currency></span></td>
                           </tr>
                           <tr>
                              <td><strong>Plus Tax</strong></td>
                              <td><span id=tax></span></td>
                              <td><span class=display_currency></span></td>
                           </tr>
                           <tr>
                              <td><strong>Shipping</strong></td>
                              <td><input type="text" class="form-control" id="shipping"></td>
                              <td><span class=display_currency></span></td>
                           </tr>
                           <tr>
                              <td><strong>Total</strong></td>
                              <td><span id=total_price></span></td>
                              <td><span class=display_currency></span></td>
                           </tr>
                        </tbody>
                     </table>
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

<div class="modal fade" id="edit_po_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">

            <div class=container-fluid>
               <form>
                  <input type=text class=hidden name="id">
                  <div class="row">
                     <?= create_el(6, "Supplier", '<input type=text class=form-control name="supplier_name" disabled>'); ?>
                     <?= create_el(3, "Expected Arrival", '<input type="date" class="form-control" name="expected_arrival">'); ?>
                     <?= create_el(3, "Created Date", '<input type="date" class="form-control" name="created_date" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(6, "Purchase Order", '<input type="text" class="form-control" name="po" placeholder="Purchase Order" disabled>'); ?>
                     <?= create_el(3, "Location", '<input type=text class=form-control name="location" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= get_po_items_table(); ?>
                  </div>
                  <div class="row">
                     <?= create_el(12, "Remarks", '<textarea class=form-control name=remarks height=75 disabled></textarea>'); ?>
                  </div>
                  <div class="row">
                     <div class="col-lg-4 col-lg-offset-8">
                        <table class="table">
                           <tbody>
                              <tr>
                                 <td><strong>Subtotal (Tax excluded)</strong></td>
                                 <td><span name=sub_total></span></td>
                                 <td><span class=display_currency></span></td>
                              </tr>
                              <tr>
                                 <td><strong>Plus Tax</strong></td>
                                 <td><span name=tax></span></td>
                                 <td><span class=display_currency></span></td>
                              </tr>
                              <tr>
                                 <td><strong>Shipping</strong></td>
                                 <td><span name=shipping></span></td>
                                 <td><span class=display_currency></span></td>
                              </tr>
                              <tr>
                                 <td><strong>Total</strong></td>
                                 <td><span name=total_price></span></td>
                                 <td><span class=display_currency></span></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(); ?>
         </div>
      </div>

   </div>
</div>

<div class="modal fade" id="view_warehouse_receiving_po_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <input type=text class=hidden name=id disabled>
            <input type=text class=hidden name=po_id disabled>
            <h4 class="modal-title"><strong>Purchase Order</strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <div class="row">
                     <div class="row">
                        <?= create_el(6, "Supplier", '<input type=text class=form-control name="supplier_name" disabled>'); ?>
                        <?= create_el(3, "Expected Arrival", '<input type="date" class="form-control" name="expected_arrival">'); ?>
                        <?= create_el(3, "Purchase Date", '<input type="date" class="form-control" name="created_date" disabled>'); ?>
                     </div>
                     <div class="row">
                        <?= create_el(6, "PO No./Order No.", '<input type="text" class="form-control" name="po" disabled>'); ?>
                        <?= create_el(3, "Location", '<input type="text" class="form-control" name="location" disabled>'); ?>
                     </div>
                  </div>
                  <div class="row">
                     <div class=col-lg-12>
                        <div class="form-group">
                           <table id=warehouse_receiving_items class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th class=text-center>SKU/Item #</th>
                                    <th class=text-center>Item Name</th>
                                    <th class=text-center>Category</th>
                                    <th class=text-center>Quantity</th>
                                    <th class=text-center>UoM</th>
                                    <!-- <th class=text-center>Lot No./Batch No.</th> -->
                                    <th class=text-center>Mfg Date</th>
                                    <th class=text-center width="10%">Quantity Received</th>
                                    <th class=text-center width="10%">Supplier Lot Code</th>
                                    <th class=text-center width="10%">Internal Lot Code</th>
                                 </tr>
                              </thead>
                              <tbody></tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <strong>Remarks/Comments</strong>
                        <textarea class=form-control name=remarks height=80></textarea>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-lg-offset-4 col-lg-4">
                        <div id=whouse_received_container class=text-center></div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(); ?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="view_warehouse_supplier_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <input type=text class=hidden name=id disabled>
            <h4 class="modal-title"><strong>Incoming Material Receiving Checklist<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <h5><strong>Delivery Details</strong></h5><br>
               <div class="row">
                  <?= create_el(4, "Date Received", '<input type="date" class="form-control" name="date_received">'); ?>
                  <?= create_el(4, "Arrival Time", '<input type="time" class="form-control" name="arrival_time">'); ?>
                  <?= create_el(4, "PO# or Order#", '<input type="text" class="form-control" name="po" disabled>'); ?>
               </div>
               <div class="row">
                  <?= create_el(8, "Supplier Name", '<input type="text" class="form-control" name="supplier_name" disabled>'); ?>
                  <?= create_el(4, "Invoice", '<input type="text" class="form-control" name="invoice">'); ?>
               </div>
               <div class="row">
                  <?= create_el(4, "Trailer #", '<input type="text" class="form-control" name="trailer_no">'); ?>
                  <?= create_el(4, "Trailer Plate #", '<input type="text" class="form-control" name="trailer_plate">'); ?>
                  <?= create_el(4, "Trailer Seal #", '<input type="text" class="form-control" name="trailer_seal">'); ?>
               </div>
               <h5><strong>Verify Packaging List</strong></h5><br>
               <table class="table table-condensed table-bordered" id=warehouse_receiving_table1>
                  <thead>
                     <tr>
                        <th width=40% colspan=2>List</th>
                        <th width=30% colspan=3 class=text-center>Compliance</th>
                        <th width=30%>Corrective Action</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                     <tr>
                        <td colspan=2>
                           <input type=text class=hidden name=warehouse_receiving_id>
                           <input type=text class=hidden name=data_type value=1>
                           <input type=text class=form-control name=add_entry>
                        </td>
                        <td colspan=2><button type=button class="btn btn-sm btn-primary add_item_btn">Add</button></td>
                     </tr>
                  </tfoot>
               </table>
               <h5><strong>Vehicle or Transportation Inspection</strong></h5><br>
               <table class="table table-condensed table-bordered" id=warehouse_receiving_table2>
                  <thead>
                     <tr>
                        <th width=40% colspan=2>List</th>
                        <th width=30% colspan=3 class=text-center>Compliance</th>
                        <th width=30%>Corrective Action</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                     <tr>
                        <td colspan=2>
                           <input type=text class=hidden name=warehouse_receiving_id>
                           <input type=text class=hidden name=data_type value=2>
                           <input type=text class=form-control name=add_entry>
                        </td>
                        <td colspan=2><button type=button class="btn btn-sm btn-primary add_item_btn">Add</button></td>
                     </tr>
                  </tfoot>
               </table>
               <div class=row>
                  <div class=col-lg-6>
                     <div id=inspected2_container class=text-center></div>
                  </div>
                  <div class=col-lg-6>
                     <div id=verified2_container class=text-center></div>
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

<div class="modal fade" id="signature_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-lg-12">
                  <input type=text class=hidden name=id>
                  <input type=text class=hidden name=status>
                  <input type=text class=hidden name=prefix>
                  <div class=contents></div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(); ?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="comments_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog xmodal-lg" style="height:90%;max-height: calc(100% - 120px);">
      <div class="modal-content" style="height:90%;max-height: calc(100% - 120px);">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body" style="height:100%;max-height: calc(100% - 120px);overflow-y: scroll;">
            <div class="row">
               <div class="col-lg-12" id=comments_area>
                  <div class="portlet-body">
                     <div class="timeline"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <div class="row">
               <div class="col-lg-8">
                  <input type=text class="form-control hidden" name=po_id>
                  <input type=text class="form-control hidden" name=parent_id>
                  <input type=text class="form-control hidden" name=comment_type>
                  <input type=text class="form-control form-control-sm" id=input_comment>
               </div>
               <div class="col-lg-4">
                  <input type=button class="submit btn btn-sm btn-primary" style="width:100%;" value="Add Notes">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="add_stock_transfer_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>Stock Transfer Form<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <div class="row">
                     <?= create_el(4, "Stock Transfer #", '<input type="text" class="form-control" name="stock_no" required>'); ?>
                     <?= create_el(4, "Lot/Batch #", '<input type="text" class="form-control" name="lot_batch_no" required>'); ?>
                     <?= create_el(4, "Destination", '<select class="form-control" name="location_id" required></select>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(4, "Item Name", '<select class="form-control" name="raw_material_id" required></select>'); ?>
                     <?= create_el(4, "Current Stock", '<input type="text" class="form-control" name="current_stock" readonly required>'); ?>
                     <?= create_el(2, "UoM", '<input type="text" class="form-control" name="uom" disabled required>'); ?>
                     <?= create_el(2, "Quantity", '<input type="number" class="form-control" name="quantity" required readonly>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(8, "Transfer For", '<input type="text" class="form-control" name="transfer_for">'); ?>
                     <?= create_el(4, "Transferred Date", '<input type="date" class="form-control" name="transfer_date" readonly required>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(12, "Source", "<table id=stock_transfer_sources class='table table-sm table-bordered'><thead><tr><th class=text-center>Location</th><th class=text-center>Current Stock</th><th class=text-center>Quantity</th></tr></thead><tbody></tbody></table>") ?>
                  </div>
                  <div class="row">
                     <?= create_el(12, "Remarks", '<textarea class=form-control name=notes></textarea>'); ?>
                  </div>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <?= submit_cancel(); ?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="view_stock_transfer_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>Stock Transfer Form<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <form>
                  <input type=text class=hidden name=id>
                  <div class="row">
                     <?= create_el(4, "Stock Transfer #", '<input type="text" class="form-control" name="stock_no" disabled>'); ?>
                     <?= create_el(4, "Lot/Batch #", '<input type="text" class="form-control" name="lot_batch_no" disabled>'); ?>
                     <?= create_el(4, "Destination", '<input type="text" class="form-control" name="location" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(8, "Item Name", '<input type="text" class="form-control" name="raw_materials" disabled>'); ?>
                     <?= create_el(2, "UoM", '<input type="text" class="form-control" name="uom" disabled>'); ?>
                     <?= create_el(2, "Quantity", '<input type="text" class="form-control" name="quantity" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(8, "Transfer For", '<input type="text" class="form-control" name="transfer_for" disabled>'); ?>
                     <?= create_el(4, "Transferred Date", '<input type="date" class="form-control" name="transfer_date" disabled>'); ?>
                  </div>
                  <div class="row">
                     <?= create_el(12, "Remarks", '<textarea class=form-control name=notes disabled></textarea>'); ?>
                  </div>
               </form>
               <div class="row mt-2">
                  <div class="col-lg-offset-3 col-lg-6">
                     <div id=sig_container class=text-center></div>
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

<div class="modal fade" id="view_stock_card" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center"><strong>Materials Inventory - Stock Card<strong></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>

               <div class="row">
                  <?= create_el(6, "Material Name", '<input type="text" class="form-control" name="material_name" disabled>'); ?>
                  <?= create_el(6, "Location", '<input type="text" class="form-control" name="location" disabled>'); ?>
               </div>
               <div class="row">
                  <form class="form-inline">
                     <div class="form-group">
                        <label style="margin-left:16px;">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                           style="margin-left:8px;">
                     </div>
                     <div class="form-group">
                        <label style="margin-left:16px;">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" style="margin-left:8px;">
                     </div>
                     <button style="margin-left:16px;" type="button" class="filter btn btn-default">Filter</button>
                  </form>
               </div>
               <div class="row">
                  <?= create_el(12, "", "<table id='stock_card_table' class='table table-sm table-bordered'></table>") ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
function create_el($col_num, $label, $input)
{
   $el = '<div class=col-lg-' . $col_num . '>';
   $el .= '<div class="form-group">';
   $el .= '<label>' . $label . '</label>';
   $el .= $input;
   $el .= '</div>';
   $el .= '</div>';
   return $el;
}
function create_po_items_table()
{
   return <<<ENTRY
                  <div class=col-lg-12>
                  <div class="form-group">
                     <label>Items</label>
                     <table class="item_table table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th></th>
                              <th>SKU</th>
                              <th width="10%">Item</th>
                              <th>Category</th>
                              <th>Quantity</th>
                              <th width="5%">UoM</th>
                              <th colspan=2>Price Per Unit</th>
                              <th colspan=2>Total Price</th>
                              <th>Tax (in Percent)</th>
                           </tr>
                        </thead>
                        <tbody></tbody>
                     </table>
                  </div>
               </div>
      ENTRY;
}
function get_po_items_table()
{
   return <<<ENTRY
      <div class=col-lg-12>
         <div class="form-group">
            <label>Items</label>
            <table class="item_table table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>SKU</th>
                     <th width="20%">Item</th>
                     <th>Category</th>
                     <th>Quantity</th>
                     <th>UoM</th>
                     <th colspan=2>Price Per Unit</th>
                     <th colspan=2>Total Price</th>
                     <th>Tax (in Percent)</th>
                  </tr>
               </thead>
               <tbody></tbody>
            </table>
         </div>
      </div>
      ENTRY;
}
function submit_cancel($with_cancel = true)
{

   $div = '<button type="button" class="btn btn-primary submit">Save</button>';
   if ($with_cancel == true) {
      $div .= '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
   }
   return $div;
}
?>
