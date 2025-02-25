<div class="modal fade" id="add_product_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Product Details</h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <div class="row">
                  <div class="col-lg-12">
                     <ul class="nav nav-tabs">
                        <li><a data-toggle="tab" href="#production_product_modal_tab1">Basic Details</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab2">Product Description</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab3">Allergens</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab4">Dimensions</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab5">Storage & Distribution</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab6">Manufacturing Details</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab7">Exercises</a></li>
                        <li><a data-toggle="tab" href="#production_product_modal_tab8">Documents</a></li>
                     </ul>
                     <div class="tab-content">
                        <div id="production_product_modal_tab1" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Basic Details</strong></h4>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <label>Main Product View</label><br>
                                 <div class="bg-info text-center main-image"><img src="#" alt="main" /></div>
                                 <input type=file class="form-control image-file" name=img_main>
                              </div>
                              <div class="col-lg-6">
                                 <div class="row">
                                    <div class="col-lg-4">
                                       <label>Top View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="top view" /></div>
                                       <input type=file class="form-control image-file" name=img_top>
                                    </div>
                                    <div class="col-lg-4">
                                       <label>Front View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="front view" /></div>
                                       <input type=file class="form-control image-file" name=img_front>
                                    </div>
                                    <div class="col-lg-4">
                                       <label>Left View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="left view" /></div>
                                       <input type=file class="form-control image-file" name=img_left>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="row">
                                    <div class="col-lg-4">
                                       <label>Bottom View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="bottom view" />
                                       </div>
                                       <input type=file class="form-control image-file" name=img_bottom>
                                    </div>
                                    <div class="col-lg-4">
                                       <label>Back View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="back view" /></div>
                                       <input type=file class="form-control image-file" name=img_back>
                                    </div>
                                    <div class="col-lg-4">
                                       <label>Right View</label><br>
                                       <div class="bg-info text-center sub-image"><img src="#" alt="right view" /></div>
                                       <input type=file class="form-control image-file" name=img_right>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row">
                              <?= create_el(12, "Labeling Instructions", '<textarea class="form-control" name=labelling_instructions></textarea>'); ?>
                           </div>
                           <div class="row">
                              <?= create_el(3, "Product Code", '<input type=text class=form-control name=product_code>'); ?>
                              <?= create_el(9, "Product Name", '<input type=text class=form-control name=product_name>'); ?>
                           </div>
                           <div class="row">
                              <?= create_el(3, "Vendor Code", '<div id=vendor_code_container></div>'); ?>
                              <?= create_el(3, "Vendor Name", '<div id=vendor_name_container></div>'); ?>
                              <?= create_el(3, "Product Category", '<div id=product_category_container></div>'); ?>
                              <?= create_el(3, "Specify (if other)", '<input type=text class=form-control name=other_category>'); ?>
                           </div>
                           <div class="row">
                              <?= create_el(12, "Description", '<textarea class="form-control" name=product_description></textarea>'); ?>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="row" style="margin-top:0;margin-bottom:0;">
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb1_all_natural>All Natural</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb2_kosher>Kosher</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb3_organic>Organic</label></div>'); ?>
                                 </div>
                                 <div class="row">
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb4_fair_trade>Fair Trade</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb5_low_fat>Low Fat</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb6_sugar_free>Sugar Free</label></div>'); ?>
                                 </div>
                                 <div class="row">
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb7_halal>Halal</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb8_non_gmo>Non-GMO</label></div>'); ?>
                                    <?= create_el(4, "", '<div class="checkbox packaging_cb"><label><input type="checkbox" name=cb9_vegan>Vegan</label></div>'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Ingredients</strong></h4>
                              </div>
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Packaging Details</strong></h4>
                              </div>
                           </div>
                           <div class="row">
                              <?= create_el(6, "", '<select class=form-control id=select_raw_materials></select>'); ?>
                              <?= create_el(6, "", '<select class=form-control id=select_packagings></select>'); ?>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <table id=add_product_ingredients_table
                                    class="table table-bordered table-hover table-condensed">
                                    <thead>
                                       <tr>
                                          <th>Ingredient</th>
                                          <th>Supplier</th>
                                          <th class=last_col>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                              <div class="col-lg-6">
                                 <table id=add_product_packagings_table
                                    class="table table-bordered table-hover table-condensed">
                                    <thead>
                                       <tr>
                                          <th>Packaging</th>
                                          <th>Supplier</th>
                                          <th class=last_col>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row mt12 mb12">
                              <div class="col-lg-4">
                                 <div id=product_prepared_sig_container class=text-center></div>
                              </div>
                              <div class="col-lg-4">
                                 <div id=product_reviewed_sig_container class=text-center></div>
                              </div>
                              <div class="col-lg-4">
                                 <div id=product_verified_sig_container class=text-center></div>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab2" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Product Description</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab3" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Allergens</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab4" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Dimensions</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab5" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Storage & Distribution</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab6" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Manufacturing Details</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab7" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Exercises</h4>
                              </div>
                           </div>
                        </div>
                        <div id="production_product_modal_tab8" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title>Documents</h4>
                              </div>
                           </div>
                        </div>
                     </div>
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

<div class="modal fade" id="formulation_modal" role="dialog" tabindex="-1">
   <div class="modal-dialog modal-full">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <div class=container-fluid>
               <div class="row">
                  <div class="col-lg-12">
                     <ul class="nav nav-tabs">
                        <li><a data-toggle="tab" href="#production_formulation_modal_tab1">Information</a></li>
                        <li><a data-toggle="tab" href="#production_formulation_modal_tab2">Process</a></li>
                     </ul>

                     <div class="tab-content">
                        <div id="production_formulation_modal_tab1" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Information</strong></h4>
                              </div>
                           </div>
                           <div class="row">
                              <?= create_el(6, "Description", '<input type=text class=form-control name=product_description disabled>'); ?>
                              <?= create_el(3, "Category", '<input type=text class=form-control name=product_category disabled>'); ?>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Ingredients</strong></h4>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12">
                                 <table class="formulation_ingredients_table table table-bordered table-condensed">
                                    <thead>
                                       <tr>
                                          <th>Ingredient</th>
                                          <th>Supplier</th>
                                          <th>Unit Price</th>
                                          <th>Unit of Measure</th>
                                          <th>Quantity</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <h4 class=formulation_title><strong>Packaging</strong></h4>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12">
                                 <table class="formulation_packagings_table table table-bordered table-condensed">
                                    <thead>
                                       <tr>
                                          <th>Packaging</th>
                                          <th>Supplier</th>
                                          <th>Unit Price</th>
                                          <th>Unit of Measure</th>
                                          <th>Quantity</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row mt12 mb12">
                              <div class="col-lg-4">
                                 <div id=info_prepared_sig_container class=text-center></div>
                              </div>
                              <div class="col-lg-4">
                                 <div id=info_reviewed_sig_container class=text-center></div>
                              </div>
                              <div class="col-lg-4">
                                 <div id=info_verified_sig_container class=text-center></div>
                              </div>
                           </div>
                        </div>
                        <div id="production_formulation_modal_tab2" class="tab-pane fade">
                           <div class="row">
                              <div class="col-lg-12" id=process_container>
                                 <h4 class=formulation_title><strong>Process</strong></h4>
                                 <div class="panel panel-default">
                                    <div class="panel-body">
                                       <form class=form-inline>
                                          <div class=form-group>
                                             <input type=text class=form-control style="width:100%" name=process_step
                                                placeholder="Process Step">
                                          </div>
                                          <div class=form-group>
                                             <input type=text class=form-control style="width:100%" name=description
                                                placeholder="Description">
                                          </div>
                                          <input type=button class="btn btn-primary btn-md" id=add_process_btn
                                             value="Add Process">
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="panel-group ml12 mr12" id="process_accordion" role="tablist"
                                       aria-multiselectable="true">
                                    </div>
                                 </div>
                              </div>
                              <div class="row mt12 mb12">
                                 <div class="col-lg-4">
                                    <div id=process_prepared_sig_container class=text-center></div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div id=process_reviewed_sig_container class=text-center></div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div id=process_verified_sig_container class=text-center></div>
                                 </div>
                              </div>
                           </div>
                        </div>
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

   <?php
   function create_el($col_num, $label, $input)
   {
      $el = '<div class=col-lg-' . $col_num . '>';
      $el .= '<div class="form-group">';
      if ($label != "")
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

      $div = "<span class=loading style='margin-right:20px;'></span>";
      $div .= '<button type="button" class="btn btn-primary submit">Save</button>';
      if ($with_cancel == true) {
         $div .= '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
      }
      return $div;
   }
   ?>
