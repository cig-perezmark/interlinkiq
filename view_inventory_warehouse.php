<div id="warehouse_tab" class="tab-pane fade">
   <ul class="nav nav-tabs">
      <li><a data-toggle="tab" href="#receiving">Receiving</a></li>
      <li><a data-toggle="tab" href="#inventory">Inventory</a></li>
   </ul>

   <div class="tab-content">
      <div id="receiving" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-12">
               <h3 class=receiving_title>Receiving</h3>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered" style="width:100%;"></table></div>
               </div> 
            </div>
         </div>
      </div>
   
      <div id="inventory" class="tab-pane fade">
         <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#materials_inventory">Materials inventory</a></li>
            <li><a data-toggle="tab" href="#stock_transfer_out">Stock Transfer Out</a></li>
            <li><a data-toggle="tab" href="#stock_transfer_in">Stock Transfer In</a></li>
         </ul>

         <div class=tab-content>
            <div id="materials_inventory" class="tab-pane fade">
               <div class="row">
                  <div class="col-lg-12">
                     <h3 class=materials_inventory_title>Materials Inventory</h3>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="panel panel-default">
                        <div class="panel-body"><table class="main_table table table-bordered" style="width:100%;"></table></div>
                     </div> 
                  </div>
               </div>
            </div>
            <div id="stock_transfer_out" class="tab-pane fade">
               <div class="row">
                  <div class="col-lg-6">
                     <h3 class=stock_transfer_out_title>Stock Transfer Out</h3>
                  </div>
                  <div class="col-lg-6">
                     <input type=button class="btn btn-md btn-primary pull-right mt-2" value="Add Stock Transfer" data-toggle="modal" data-target="#add_stock_transfer_modal">
                  </div>
               </div>
               <div class="row mt12">
                  <div class="col-12">
                     <div class="panel panel-default">
                        <div class="panel-body"><table class="main_table table table-bordered" style="width:100%;"></table></div>
                     </div> 
                  </div>
               </div>
            </div>
            <div id="stock_transfer_in" class="tab-pane fade">
               <div class="row">
                  <div class="col-lg-12">
                     <h3 class=stock_transfer_out_title>Stock Transfer In</h3>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="panel panel-default">
                        <div class="panel-body"><table class="main_table table table-bordered" style="width:100%;"></table></div>
                     </div> 
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> 
</div>